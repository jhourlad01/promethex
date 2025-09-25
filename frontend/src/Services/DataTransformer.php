<?php

namespace App\Services;

/**
 * Transforms GraphQL API data arrays into object-like structures
 * that work with the existing frontend code
 */
class DataTransformer
{
    /**
     * Transform a category array into an object-like structure
     */
    public static function transformCategory(array $category): object
    {
        return new class($category) {
            private $data;
            
            public function __construct(array $data) {
                $this->data = $data;
            }
            
            public function __get($property) {
                return $this->data[$property] ?? null;
            }
            
            public function __isset($property) {
                return isset($this->data[$property]);
            }
            
            public function toArray() {
                return $this->data;
            }
        };
    }
    
    /**
     * Transform a product array into an object-like structure
     */
    public static function transformProduct(array $product): object
    {
        return new class($product) {
            private $data;
            
            public function __construct(array $data) {
                $this->data = $data;
            }
            
            public function __get($property) {
                $value = $this->data[$property] ?? null;
                
                // Transform nested objects
                if ($property === 'category' && is_array($value)) {
                    return DataTransformer::transformCategory($value);
                }
                
                if ($property === 'reviews' && is_array($value)) {
                    return DataTransformer::transformReviews($value);
                }
                
                return $value;
            }
            
            public function __isset($property) {
                return isset($this->data[$property]);
            }
            
            public function toArray() {
                return $this->data;
            }
            
            /**
             * Check if product is on sale
             */
            public function isOnSale(): bool
            {
                return isset($this->data['sale_price']) && 
                       $this->data['sale_price'] && 
                       $this->data['sale_price'] < $this->data['price'];
            }
            
            /**
             * Check if product is out of stock
             */
            public function isOutOfStock(): bool
            {
                return isset($this->data['stock_quantity']) && 
                       $this->data['stock_quantity'] <= 0;
            }
            
            /**
             * Check if product is low on stock
             */
            public function isLowStock(): bool
            {
                return isset($this->data['stock_quantity']) && 
                       $this->data['stock_quantity'] > 0 && 
                       $this->data['stock_quantity'] <= 10;
            }
            
            /**
             * Get formatted weight
             */
            public function getFormattedWeight(): string
            {
                if (!isset($this->data['weight']) || !$this->data['weight']) {
                    return '';
                }
                return number_format($this->data['weight'], 2) . ' lbs';
            }
            
            /**
             * Get formatted dimensions
             */
            public function getFormattedDimensions(): string
            {
                $dimensions = [];
                if (isset($this->data['length']) && $this->data['length']) {
                    $dimensions[] = number_format($this->data['length'], 2) . '"';
                }
                if (isset($this->data['width']) && $this->data['width']) {
                    $dimensions[] = number_format($this->data['width'], 2) . '"';
                }
                if (isset($this->data['height']) && $this->data['height']) {
                    $dimensions[] = number_format($this->data['height'], 2) . '"';
                }
                return implode(' × ', $dimensions);
            }
            
            /**
             * Get parsed attributes
             */
            public function getAttributes(): array
            {
                if (!isset($this->data['attributes']) || !$this->data['attributes']) {
                    return [];
                }
                
                // If attributes is a JSON string, decode it
                if (is_string($this->data['attributes'])) {
                    $decoded = json_decode($this->data['attributes'], true);
                    return is_array($decoded) ? $decoded : [];
                }
                
                // If it's already an array, return it
                return is_array($this->data['attributes']) ? $this->data['attributes'] : [];
            }
        };
    }
    
    /**
     * Transform a review array into an object-like structure
     */
    public static function transformReview(array $review): object
    {
        return new class($review) {
            private $data;
            
            public function __construct(array $data) {
                $this->data = $data;
            }
            
            public function __get($property) {
                $value = $this->data[$property] ?? null;
                
                // Transform nested user object
                if ($property === 'user' && is_array($value)) {
                    return DataTransformer::transformUser($value);
                }
                
                return $value;
            }
            
            public function __isset($property) {
                return isset($this->data[$property]);
            }
            
            public function toArray() {
                return $this->data;
            }
        };
    }
    
    /**
     * Transform a user array into an object-like structure
     */
    public static function transformUser(array $user): object
    {
        return new class($user) {
            private $data;
            
            public function __construct(array $data) {
                $this->data = $data;
            }
            
            public function __get($property) {
                if ($property === 'initials') {
                    return $this->getInitials();
                }
                return $this->data[$property] ?? null;
            }
            
            public function __isset($property) {
                if ($property === 'initials') {
                    return true;
                }
                return isset($this->data[$property]);
            }
            
            public function toArray() {
                return $this->data;
            }
            
            private function getInitials(): string
            {
                $name = $this->data['name'] ?? '';
                $words = explode(' ', trim($name));
                $initials = '';
                foreach ($words as $word) {
                    if (!empty($word)) {
                        $initials .= strtoupper(substr($word, 0, 1));
                    }
                }
                return $initials ?: 'U';
            }
        };
    }
    
    /**
     * Transform an array of categories into a collection-like object
     */
    public static function transformCategories(array $categories): object
    {
        $transformed = array_map([self::class, 'transformCategory'], $categories);
        
        return new class($transformed) implements \IteratorAggregate, \Countable {
            private $items;
            
            public function __construct(array $items) {
                $this->items = $items;
            }
            
            public function count(): int {
                return count($this->items);
            }
            
            public function getIterator(): \ArrayIterator {
                return new \ArrayIterator($this->items);
            }
            
            public function toArray() {
                return $this->items;
            }
            
            public function first() {
                return $this->items[0] ?? null;
            }
            
            public function last() {
                return end($this->items) ?: null;
            }
            
            public function isEmpty(): bool {
                return empty($this->items);
            }
            
            public function isNotEmpty(): bool {
                return !empty($this->items);
            }
        };
    }
    
    /**
     * Transform an array of products into a collection-like object
     */
    public static function transformProducts(array $products): object
    {
        $transformed = array_map([self::class, 'transformProduct'], $products);
        
        return new class($transformed) implements \IteratorAggregate, \Countable {
            private $items;
            
            public function __construct(array $items) {
                $this->items = $items;
            }
            
            public function count(): int {
                return count($this->items);
            }
            
            public function getIterator(): \ArrayIterator {
                return new \ArrayIterator($this->items);
            }
            
            public function toArray() {
                return $this->items;
            }
            
            public function first() {
                return $this->items[0] ?? null;
            }
            
            public function last() {
                return end($this->items) ?: null;
            }
            
            public function isEmpty(): bool {
                return empty($this->items);
            }
            
            public function isNotEmpty(): bool {
                return !empty($this->items);
            }
            
            public function filter(callable $callback): self {
                $filtered = array_filter($this->items, $callback);
                return new self($filtered);
            }
            
            public function take(int $count): self {
                return new self(array_slice($this->items, 0, $count));
            }
        };
    }
    
    /**
     * Transform a price range array into an object-like structure
     */
    public static function transformPriceRange(array $priceRange): object
    {
        return new class($priceRange) {
            private $data;
            
            public function __construct(array $data) {
                $this->data = $data;
            }
            
            public function __get($property) {
                return $this->data[$property] ?? null;
            }
            
            public function __isset($property) {
                return isset($this->data[$property]);
            }
            
            public function toArray() {
                return $this->data;
            }
        };
    }
    
    /**
     * Transform an array of reviews into a collection-like object
     */
    public static function transformReviews(array $reviews): object
    {
        $transformed = array_map([self::class, 'transformReview'], $reviews);
        
        return new class($transformed) implements \IteratorAggregate, \Countable {
            private $items;
            
            public function __construct(array $items) {
                $this->items = $items;
            }
            
            public function count(): int {
                return count($this->items);
            }
            
            public function getIterator(): \ArrayIterator {
                return new \ArrayIterator($this->items);
            }
            
            public function toArray() {
                return $this->items;
            }
            
            public function first() {
                return $this->items[0] ?? null;
            }
            
            public function last() {
                return end($this->items) ?: null;
            }
            
            public function isEmpty(): bool {
                return empty($this->items);
            }
            
            public function isNotEmpty(): bool {
                return !empty($this->items);
            }
        };
    }
}
