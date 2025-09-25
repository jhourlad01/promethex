<?php

namespace App\Models;

use Framework\Model;

class Cart extends Model
{
    protected $table = 'cart'; // This won't be used since we're using sessions
    
    private static $sessionKey = 'cart';
    
    /**
     * Get the current cart from session
     */
    public static function getCart(): array
    {
        return $_SESSION[self::$sessionKey] ?? [];
    }
    
    /**
     * Add item to cart
     */
    public static function addItem($product, int $quantity = 1): void
    {
        $cart = self::getCart();
        $productId = $product->id;
        
        if (isset($cart[$productId])) {
            // Update existing item quantity
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Convert object to array for session storage
            $cart[$productId] = [
                'product' => $product->toArray(), // Convert to array for session
                'quantity' => $quantity,
                'price' => $product->sale_price ?? $product->price,
                'added_at' => time()
            ];
        }
        
        $_SESSION[self::$sessionKey] = $cart;
    }
    
    /**
     * Update item quantity in cart
     */
    public static function updateItem(int $productId, int $quantity): bool
    {
        $cart = self::getCart();
        
        if (!isset($cart[$productId])) {
            return false;
        }
        
        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $quantity;
        }
        
        $_SESSION[self::$sessionKey] = $cart;
        return true;
    }
    
    /**
     * Remove item from cart
     */
    public static function removeItem(int $productId): bool
    {
        $cart = self::getCart();
        
        if (!isset($cart[$productId])) {
            return false;
        }
        
        unset($cart[$productId]);
        $_SESSION[self::$sessionKey] = $cart;
        return true;
    }
    
    /**
     * Clear entire cart
     */
    public static function clear(): void
    {
        unset($_SESSION[self::$sessionKey]);
    }
    
    /**
     * Get total number of items in cart
     */
    public static function getTotalItems(): int
    {
        $cart = self::getCart();
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['quantity'];
        }
        
        return $total;
    }
    
    /**
     * Get total amount of cart
     */
    public static function getTotalAmount(): float
    {
        $cart = self::getCart();
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }
    
    /**
     * Get cart items with calculated totals
     */
    public static function getItems(): array
    {
        $cart = self::getCart();
        $items = [];
        
        foreach ($cart as $productId => $item) {
            $items[] = [
                'product_id' => $productId,
                'product' => $item['product'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
                'added_at' => $item['added_at']
            ];
        }
        
        return $items;
    }
    
    /**
     * Check if cart is empty
     */
    public static function isEmpty(): bool
    {
        return empty(self::getCart());
    }
    
    /**
     * Check if product is in cart
     */
    public static function hasItem(int $productId): bool
    {
        $cart = self::getCart();
        return isset($cart[$productId]);
    }
    
    /**
     * Get quantity of specific product in cart
     */
    public static function getItemQuantity(int $productId): int
    {
        $cart = self::getCart();
        return $cart[$productId]['quantity'] ?? 0;
    }
    
    /**
     * Get cart summary
     */
    public static function getSummary(): array
    {
        return [
            'items' => self::getItems(),
            'total_items' => self::getTotalItems(),
            'total_amount' => self::getTotalAmount(),
            'is_empty' => self::isEmpty()
        ];
    }
}
