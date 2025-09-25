<?php

namespace App\Models;

use Framework\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'title',
        'comment',
        'is_verified_purchase',
        'is_approved',
        'is_featured',
        'helpful_votes',
        'helpful_count'
    ];

    protected $casts = [
        'product_id' => 'integer',
        'user_id' => 'integer',
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'helpful_votes' => 'array',
        'helpful_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product that owns the review.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted rating stars.
     */
    public function getStarsAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-warning"></i>';
            }
        }
        return $stars;
    }

    /**
     * Get formatted date.
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('M d, Y');
    }

    /**
     * Get time ago string.
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Check if review is helpful by user.
     */
    public function isHelpfulByUser(int $userId): bool
    {
        $votes = $this->helpful_votes ?? [];
        return in_array($userId, $votes);
    }

    /**
     * Add helpful vote.
     */
    public function addHelpfulVote(int $userId): bool
    {
        $votes = $this->helpful_votes ?? [];
        
        if (!in_array($userId, $votes)) {
            $votes[] = $userId;
            $this->helpful_votes = $votes;
            $this->helpful_count = count($votes);
            return $this->save();
        }
        
        return false;
    }

    /**
     * Remove helpful vote.
     */
    public function removeHelpfulVote(int $userId): bool
    {
        $votes = $this->helpful_votes ?? [];
        
        if (($key = array_search($userId, $votes)) !== false) {
            unset($votes[$key]);
            $votes = array_values($votes); // Re-index array
            $this->helpful_votes = $votes;
            $this->helpful_count = count($votes);
            return $this->save();
        }
        
        return false;
    }

    /**
     * Scope a query to only include approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope a query to only include featured reviews.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include verified purchase reviews.
     */
    public function scopeVerifiedPurchase($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    /**
     * Scope a query to filter by rating.
     */
    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope a query to order by most helpful.
     */
    public function scopeMostHelpful($query)
    {
        return $query->orderBy('helpful_count', 'desc')->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to order by newest.
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to order by highest rating.
     */
    public function scopeHighestRating($query)
    {
        return $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to order by lowest rating.
     */
    public function scopeLowestRating($query)
    {
        return $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Create a new review.
     */
    public static function createReview(array $data): self
    {
        return static::create($data);
    }

    /**
     * Get review statistics for a product.
     */
    public static function getProductStats(int $productId): array
    {
        $reviews = static::where('product_id', $productId)
            ->where('is_approved', true)
            ->get();

        if ($reviews->isEmpty()) {
            return [
                'total_reviews' => 0,
                'average_rating' => 0,
                'rating_distribution' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
                'verified_purchases' => 0
            ];
        }

        $totalReviews = $reviews->count();
        $averageRating = round($reviews->avg('rating'), 1);
        $verifiedPurchases = $reviews->where('is_verified_purchase', true)->count();

        $ratingDistribution = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        foreach ($reviews as $review) {
            $ratingDistribution[$review->rating]++;
        }

        return [
            'total_reviews' => $totalReviews,
            'average_rating' => $averageRating,
            'rating_distribution' => $ratingDistribution,
            'verified_purchases' => $verifiedPurchases
        ];
    }

    /**
     * Convert the model to an array for API responses.
     */
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name ?? 'Anonymous',
            'user_initials' => $this->user->initials ?? 'A',
            'rating' => $this->rating,
            'stars' => $this->stars,
            'title' => $this->title,
            'comment' => $this->comment,
            'is_verified_purchase' => $this->is_verified_purchase,
            'is_approved' => $this->is_approved,
            'is_featured' => $this->is_featured,
            'helpful_count' => $this->helpful_count,
            'formatted_date' => $this->formatted_date,
            'time_ago' => $this->time_ago,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
