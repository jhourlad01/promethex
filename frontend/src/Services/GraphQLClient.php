<?php

namespace App\Services;

use App\Services\DataTransformer;
use Framework\Config;

class GraphQLClient
{
    private $apiUrl;
    
    public function __construct($apiUrl = null)
    {
        $this->apiUrl = $apiUrl ?? Config::get('api.url', 'http://localhost:4000');
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
    public function getFeaturedProducts(int $limit = 8)
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
                        id
                        name
                        slug
                    }
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
                    }
                }
            }
        ';
        
        $result = $this->query($query, ['slug' => $categorySlug, 'limit' => $limit]);
        $products = $result['category']['products'] ?? [];
        return DataTransformer::transformProducts($products);
    }
    
    /**
     * Get single product by ID
     */
    public function getProductById(int $id)
    {
        $query = '
            query GetProductById($id: ID!) {
                product(id: $id) {
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
                    images
                    primary_image
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
                    created_at
                    updated_at
                }
            }
        ';
        
        $result = $this->query($query, ['id' => $id]);
        $product = $result['product'] ?? null;
        
        if (!$product) {
            return null;
        }
        
        return DataTransformer::transformProduct($product);
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
                    images
                    primary_image
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
                    created_at
                    updated_at
                }
            }
        ';
        
        $result = $this->query($query, ['slug' => $slug]);
        $product = $result['product'] ?? null;
        
        if (!$product) {
            return null;
        }
        
        return DataTransformer::transformProduct($product);
    }
    
    /**
     * Get category by slug
     */
    public function getCategory(string $slug)
    {
        $query = '
            query GetCategory($slug: String!) {
                category(slug: $slug) {
                    id
                    name
                    slug
                    description
                    image_url
                    product_count
                    products {
                        id
                        name
                        slug
                        description
                        price
                        sale_price
                        primary_image
                        images
                    }
                }
            }
        ';
        
        $result = $this->query($query, ['slug' => $slug]);
        $category = $result['category'] ?? null;
        
        if (!$category) {
            return null;
        }
        
        return DataTransformer::transformCategory($category);
    }
    
    /**
     * Login user and get JWT token
     */
    public function login(string $email, string $password, bool $remember = false): ?string
    {
        $query = '
            mutation Login($email: String!, $password: String!, $remember: Boolean) {
                login(email: $email, password: $password, remember: $remember)
            }
        ';
        
        try {
            $result = $this->query($query, [
                'email' => $email,
                'password' => $password,
                'remember' => $remember
            ]);
            
            return $result['login'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
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
        
        try {
            $result = $this->query($query);
            return $result['logout'] ?? false;
        } catch (\Exception $e) {
            return false;
        }
    }
}