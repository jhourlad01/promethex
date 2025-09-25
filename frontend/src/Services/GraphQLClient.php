<?php

namespace App\Services;

use App\Services\DataTransformer;
use Framework\Config;

class GraphQLClient
{
    private $apiUrl;
    
    public function __construct($apiUrl = null)
    {
        $this->apiUrl = $apiUrl ?? Config::get('api.url', 'http://localhost:4001');
    }
    
    /**
     * Execute a GraphQL query or mutation
     */
    public function query(string $query, array $variables = []): array
    {
        $data = [
            'query' => $query,
            'variables' => $variables
        ];
        
        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
                'ignore_errors' => true  // Don't treat HTTP errors as PHP errors
            ]
        ];
        
        $context = stream_context_create($options);
        $result = file_get_contents($this->apiUrl, false, $context);
        
        if ($result === false) {
            // Get more detailed error information
            $error = error_get_last();
            $errorMessage = 'Failed to connect to GraphQL API';
            if ($error && strpos($error['message'], 'HTTP request failed') !== false) {
                $errorMessage .= '. HTTP Error: ' . $error['message'];
            }
            throw new \Exception($errorMessage);
        }
        
        // Check for HTTP errors in the response headers
        $httpCode = $this->getHttpResponseCode($http_response_header ?? []);
        if ($httpCode >= 400) {
            throw new \Exception("GraphQL API returned HTTP {$httpCode}: " . $result);
        }
        
        $response = json_decode($result, true);
        
        if (isset($response['errors'])) {
            $error = $response['errors'][0];
            $errorMessage = 'GraphQL Error: ' . $error['message'];
            
            // Add more details if available
            if (isset($error['locations'])) {
                $location = $error['locations'][0];
                $errorMessage .= " (Line: {$location['line']}, Column: {$location['column']})";
            }
            
            if (isset($error['path'])) {
                $errorMessage .= " Path: " . implode('.', $error['path']);
            }
            
            throw new \Exception($errorMessage);
        }
        
        return $response['data'] ?? [];
    }
    
    /**
     * Extract HTTP response code from response headers
     */
    private function getHttpResponseCode(array $headers): int
    {
        foreach ($headers as $header) {
            if (preg_match('/HTTP\/\d\.\d\s+(\d+)/', $header, $matches)) {
                return (int) $matches[1];
            }
        }
        return 200; // Default to 200 if no status code found
    }
    
    /**
     * Get all categories
     */
    public function getCategories()
    {
        $query = '
            query {
                categories {
                    id
                    name
                    slug
                    description
                    image_url
                    product_count
                }
            }
        ';
        
        $result = $this->query($query);
        $categories = $result['categories'] ?? [];
        return DataTransformer::transformCategories($categories);
    }
    
    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 6)
    {
        $query = '
            query GetFeaturedProducts($limit: Int) {
                products(featured: true, limit: $limit) {
                    id
                    name
                    slug
                    description
                    price
                    sale_price
                    primary_image
                    images
                    category {
                        name
                        slug
                    }
                    average_rating
                    total_reviews
                }
            }
        ';
        
        $result = $this->query($query, ['limit' => $limit]);
        $products = $result['products'] ?? [];
        return DataTransformer::transformProducts($products);
    }
    
    /**
     * Get products by category
     */
    public function getProductsByCategory(string $categorySlug, int $limit = 50)
    {
        $query = '
            query GetProductsByCategory($slug: String!, $limit: Int) {
                category(slug: $slug) {
                    id
                    name
                    slug
                    products {
                        id
                        name
                        slug
                        description
                        price
                        sale_price
                        primary_image
                        images
                        average_rating
                        total_reviews
                    }
                }
            }
        ';
        
        $result = $this->query($query, ['slug' => $categorySlug, 'limit' => $limit]);
        $products = $result['category']['products'] ?? [];
        return DataTransformer::transformProducts($products);
    }
    
    /**
     * Get single product by slug
     */
    public function getProduct(string $slug)
    {
        $query = '
            query GetProduct($slug: String!) {
                product(slug: $slug) {
                    id
                    name
                    slug
                    description
                    short_description
                    price
                    sale_price
                    sku
                    stock_quantity
                    manage_stock
                    featured
                    status
                    in_stock
                    primary_image
                    images
                    attributes
                    weight
                    length
                    width
                    height
                    meta_title
                    meta_description
                    category {
                        id
                        name
                        slug
                    }
                    reviews {
                        id
                        rating
                        title
                        comment
                        is_verified_purchase
                        helpful_votes
                        helpful_count
                        user {
                            name
                        }
                        created_at
                    }
                    average_rating
                    total_reviews
                }
            }
        ';
        
        $result = $this->query($query, ['slug' => $slug]);
        $product = $result['product'] ?? null;
        
        if ($product) {
            return DataTransformer::transformProduct($product);
        }
        
        return null;
    }
    
    /**
     * Get product reviews
     */
    public function getProductReviews(string $productId, int $limit = 50)
    {
        $query = '
            query GetProductReviews($productId: ID!, $limit: Int) {
                reviews(product_id: $productId, limit: $limit) {
                    id
                    rating
                    title
                    comment
                    is_verified_purchase
                    helpful_votes
                    helpful_count
                    user {
                        name
                    }
                    created_at
                }
            }
        ';
        
        $result = $this->query($query, ['productId' => $productId, 'limit' => $limit]);
        $reviews = $result['reviews'] ?? [];
        return DataTransformer::transformReviews($reviews);
    }
    
    /**
     * Create a review
     */
    public function createReview(array $reviewData): array
    {
        $query = '
            mutation CreateReview(
                $productId: ID!
                $userId: ID!
                $rating: Int!
                $title: String
                $comment: String
                $isVerifiedPurchase: Boolean
            ) {
                createReview(
                    product_id: $productId
                    user_id: $userId
                    rating: $rating
                    title: $title
                    comment: $comment
                    is_verified_purchase: $isVerifiedPurchase
                ) {
                    id
                    rating
                    title
                    comment
                }
            }
        ';
        
        $result = $this->query($query, $reviewData);
        return $result['createReview'] ?? [];
    }
    
    /**
     * Mark review as helpful
     */
    public function markReviewHelpful(string $reviewId): array
    {
        $query = '
            mutation MarkReviewHelpful($id: ID!) {
                markReviewHelpful(id: $id) {
                    id
                    helpful_votes
                    helpful_count
                }
            }
        ';
        
        $result = $this->query($query, ['id' => $reviewId]);
        return $result['markReviewHelpful'] ?? [];
    }
    
    /**
     * Login user
     */
    public function login(string $email, string $password, bool $remember = false): string
    {
        $query = '
            mutation Login($email: String!, $password: String!, $remember: Boolean) {
                login(email: $email, password: $password, remember: $remember)
            }
        ';
        
        $result = $this->query($query, [
            'email' => $email,
            'password' => $password,
            'remember' => $remember
        ]);
        
        return $result['login'] ?? '';
    }
    
    /**
     * Logout user
     */
    public function logout(): bool
    {
        $query = '
            mutation {
                logout
            }
        ';
        
        $result = $this->query($query);
        return $result['logout'] ?? false;
    }
}
