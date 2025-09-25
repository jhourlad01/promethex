<?php

namespace App\Controllers;

use Framework\{Controller, Request, Response};
use App\Models\Cart;
use App\Services\GraphQLClient;

class CartController extends Controller
{
    private $graphqlClient;
    
    public function __construct(Request $request, array $params = [])
    {
        parent::__construct($request, $params);
        $this->graphqlClient = new GraphQLClient();
    }
    
    /**
     * Show cart page
     */
    public function index(): Response
    {
        $cartSummary = Cart::getSummary();
        
        return $this->view('cart/index', [
            'title' => 'Shopping Cart - Promethex E-Commerce',
            'cart' => $cartSummary
        ]);
    }
    
    /**
     * Add item to cart (AJAX)
     */
    public function add(): Response
    {
        $productId = (int) $this->request->getInput('product_id');
        $quantity = (int) $this->request->getInput('quantity', 1);
        
        if (!$productId || $quantity <= 0) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Invalid product or quantity'
            ], 400);
        }
        
        try {
            // Get product details from API
            $product = $this->graphqlClient->getProductById($productId);
            
            if (!$product) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }
            
            // Add to cart
            Cart::addItem($product, $quantity);
            
            return $this->jsonResponse([
                'success' => true,
                'message' => 'Item added to cart',
                'cart_summary' => Cart::getSummary()
            ]);
            
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to add item to cart: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update item quantity (AJAX)
     */
    public function update(): Response
    {
        $productId = (int) $this->request->getInput('product_id');
        $quantity = (int) $this->request->getInput('quantity');
        
        if (!$productId) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Product ID is required'
            ], 400);
        }
        
        if ($quantity < 0) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Quantity cannot be negative'
            ], 400);
        }
        
        $success = Cart::updateItem($productId, $quantity);
        
        if (!$success) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
        }
        
        return $this->jsonResponse([
            'success' => true,
            'message' => 'Cart updated',
            'cart_summary' => Cart::getSummary()
        ]);
    }
    
    /**
     * Remove item from cart (AJAX)
     */
    public function remove(): Response
    {
        $productId = (int) $this->request->getInput('product_id');
        
        if (!$productId) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Product ID is required'
            ], 400);
        }
        
        $success = Cart::removeItem($productId);
        
        if (!$success) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
        }
        
        return $this->jsonResponse([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_summary' => Cart::getSummary()
        ]);
    }
    
    /**
     * Clear entire cart (AJAX)
     */
    public function clear(): Response
    {
        Cart::clear();
        
        return $this->jsonResponse([
            'success' => true,
            'message' => 'Cart cleared',
            'cart_summary' => Cart::getSummary()
        ]);
    }
    
    /**
     * Get cart summary (AJAX)
     */
    public function summary(): Response
    {
        return $this->jsonResponse([
            'success' => true,
            'cart_summary' => Cart::getSummary()
        ]);
    }
    
    /**
     * Helper method to return JSON response
     */
    private function jsonResponse(array $data, int $statusCode = 200): Response
    {
        return (new Response())
            ->json($data, $statusCode);
    }
}
