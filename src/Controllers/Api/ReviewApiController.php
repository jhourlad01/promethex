<?php

namespace App\Controllers\Api;

use Framework\Request;
use App\Models\Review;
use App\Models\Product;
use Framework\Auth;

class ReviewApiController extends BaseApiController
{
    protected Request $request;
    protected array $params = [];

    public function __construct(Request $request, array $params = [])
    {
        $this->request = $request;
        $this->params = $params;
    }

    /**
     * Get request parameter
     */
    protected function getParam(string $key): ?string
    {
        return $this->params[$key] ?? null;
    }

    /**
     * Get reviews for a product
     */
    public function getProductReviews()
    {
        $productId = $this->getParam('productId');
        $sortBy = $this->request->getInput('sort', 'newest'); // newest, highest, lowest, most_helpful
        $rating = $this->request->getInput('rating'); // filter by rating
        $page = (int) $this->request->getInput('page', 1);
        $limit = (int) $this->request->getInput('limit', 10);

        if (!$productId) {
            return $this->error('Product ID is required', 400);
        }

        $product = Product::find($productId);
        if (!$product) {
            return $this->error('Product not found', 404);
        }

        $query = $product->approvedReviews()->with('user');

        // Apply rating filter
        if ($rating && in_array($rating, [1, 2, 3, 4, 5])) {
            $query->where('rating', $rating);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'highest':
                $query->highestRating();
                break;
            case 'lowest':
                $query->lowestRating();
                break;
            case 'most_helpful':
                $query->mostHelpful();
                break;
            case 'newest':
            default:
                $query->newest();
                break;
        }

        $reviews = $query->paginate($limit, ['*'], 'page', $page);

        return $this->success([
            'reviews' => $reviews->items(),
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
            ],
            'stats' => Review::getProductStats($productId)
        ]);
    }

    /**
     * Create a new review
     */
    public function createReview()
    {
        if (!Auth::check()) {
            return $this->unauthorized('You must be logged in to write a review');
        }

        $data = $this->request->getJson();
        if (!$data) {
            return $this->error('Invalid JSON data', 400);
        }

        // Validate required fields
        $validation = $this->validateRequired($data, ['product_id', 'rating']);
        if ($validation !== true) {
            return $validation;
        }

        $productId = (int) $data['product_id'];
        $rating = (int) $data['rating'];

        // Validate rating
        if ($rating < 1 || $rating > 5) {
            return $this->error('Rating must be between 1 and 5', 400);
        }

        $product = Product::find($productId);
        if (!$product) {
            return $this->error('Product not found', 404);
        }

        $user = Auth::user();
        
        // Check if user already reviewed this product
        if ($product->hasUserReviewed($user['id'])) {
            return $this->error('You have already reviewed this product', 400);
        }

        // Create review
        $review = Review::createReview([
            'product_id' => $productId,
            'user_id' => $user['id'],
            'rating' => $rating,
            'title' => $data['title'] ?? null,
            'comment' => $data['comment'] ?? null,
            'is_verified_purchase' => $data['is_verified_purchase'] ?? false,
            'is_approved' => true, // Auto-approve for now
            'is_featured' => false,
            'helpful_votes' => json_encode([]),
            'helpful_count' => 0,
        ]);

        return $this->success([
            'review' => $review->toApiArray(),
            'message' => 'Review submitted successfully'
        ], 201);
    }

    /**
     * Update user's review
     */
    public function updateReview()
    {
        if (!Auth::check()) {
            return $this->unauthorized('You must be logged in to update a review');
        }

        $reviewId = $this->getParam('reviewId');
        $data = $this->request->getJson();

        if (!$data) {
            return $this->error('Invalid JSON data', 400);
        }

        $review = Review::find($reviewId);
        if (!$review) {
            return $this->error('Review not found', 404);
        }

        $user = Auth::user();
        if ($review->user_id !== $user['id']) {
            return $this->forbidden('You can only update your own reviews');
        }

        // Validate rating if provided
        if (isset($data['rating'])) {
            $rating = (int) $data['rating'];
            if ($rating < 1 || $rating > 5) {
                return $this->error('Rating must be between 1 and 5', 400);
            }
            $review->rating = $rating;
        }

        // Update other fields
        if (isset($data['title'])) {
            $review->title = $data['title'];
        }
        if (isset($data['comment'])) {
            $review->comment = $data['comment'];
        }
        if (isset($data['is_verified_purchase'])) {
            $review->is_verified_purchase = (bool) $data['is_verified_purchase'];
        }

        $review->save();

        return $this->success([
            'review' => $review->toApiArray(),
            'message' => 'Review updated successfully'
        ]);
    }

    /**
     * Delete user's review
     */
    public function deleteReview()
    {
        if (!Auth::check()) {
            return $this->unauthorized('You must be logged in to delete a review');
        }

        $reviewId = $this->getParam('reviewId');
        $review = Review::find($reviewId);

        if (!$review) {
            return $this->error('Review not found', 404);
        }

        $user = Auth::user();
        if ($review->user_id !== $user['id']) {
            return $this->forbidden('You can only delete your own reviews');
        }

        $review->delete();

        return $this->success([
            'message' => 'Review deleted successfully'
        ]);
    }

    /**
     * Mark review as helpful
     */
    public function markHelpful()
    {
        if (!Auth::check()) {
            return $this->unauthorized('You must be logged in to mark reviews as helpful');
        }

        $reviewId = $this->getParam('reviewId');
        $review = Review::find($reviewId);

        if (!$review) {
            return $this->error('Review not found', 404);
        }

        $user = Auth::user();
        $userId = $user['id'];

        // Check if user already marked this review as helpful
        if ($review->isHelpfulByUser($userId)) {
            return $this->error('You have already marked this review as helpful', 400);
        }

        $review->addHelpfulVote($userId);

        return $this->success([
            'helpful_count' => $review->helpful_count,
            'message' => 'Review marked as helpful'
        ]);
    }

    /**
     * Remove helpful vote from review
     */
    public function removeHelpful()
    {
        if (!Auth::check()) {
            return $this->unauthorized('You must be logged in to remove helpful votes');
        }

        $reviewId = $this->getParam('reviewId');
        $review = Review::find($reviewId);

        if (!$review) {
            return $this->error('Review not found', 404);
        }

        $user = Auth::user();
        $userId = $user['id'];

        if (!$review->isHelpfulByUser($userId)) {
            return $this->error('You have not marked this review as helpful', 400);
        }

        $review->removeHelpfulVote($userId);

        return $this->success([
            'helpful_count' => $review->helpful_count,
            'message' => 'Helpful vote removed'
        ]);
    }

    /**
     * Get review statistics for a product
     */
    public function getProductReviewStats()
    {
        $productId = $this->getParam('productId');

        if (!$productId) {
            return $this->error('Product ID is required', 400);
        }

        $product = Product::find($productId);
        if (!$product) {
            return $this->error('Product not found', 404);
        }

        $stats = Review::getProductStats($productId);

        return $this->success($stats);
    }
}
