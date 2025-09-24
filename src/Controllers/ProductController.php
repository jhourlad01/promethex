<?php

namespace App\Controllers;

use Framework\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function show()
    {
        $slug = $this->getParam('slug');
        
        if (!$slug) {
            return $this->redirect('/');
        }

        // Find product by slug
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with('category')
            ->first();

        if (!$product) {
            return $this->view('errors/404', [
                'title' => 'Product Not Found',
                'message' => 'The product you are looking for does not exist.'
            ], 'layout');
        }

        // Get related products (same category, excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('in_stock', true)
            ->limit(4)
            ->get();

        return $this->view('product/show', [
            'title' => $product->name . ' - Promethex',
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'meta_description' => $product->meta_description ?? $product->short_description,
            'meta_title' => $product->meta_title ?? $product->name
        ], 'layout');
    }
}
