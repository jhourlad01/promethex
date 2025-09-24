<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Request;
use Framework\Response;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Show products in a specific category
     */
    public function show()
    {
        $slug = $this->getParam('slug');

        if (!$slug) {
            return $this->redirect('/');
        }

        // Find category by slug
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$category) {
            return $this->view('errors/404', [
                'title' => 'Category Not Found',
                'message' => 'The category you are looking for does not exist.'
            ], 'layout');
        }

        // Get sorting and filtering parameters
        $sortBy = $this->request->getInput('sort', 'newest');
        $priceMin = $this->request->getInput('price_min');
        $priceMax = $this->request->getInput('price_max');
        $page = (int) $this->request->getInput('page', 1);
        $perPage = 12;

        // Build product query - only products from this specific category
        $query = Product::where('status', 'active')
            ->where('in_stock', true)
            ->where('category_id', $category->id);

        // Apply price filters
        if ($priceMin !== null && is_numeric($priceMin)) {
            $query->where('price', '>=', $priceMin);
        }
        if ($priceMax !== null && is_numeric($priceMax)) {
            $query->where('price', '<=', $priceMax);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'featured':
                $query->orderBy('featured', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Get products (without pagination for now)
        $products = $query->get();

        // Get breadcrumbs
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'Categories', 'url' => '/categories'],
            ['name' => $category->name, 'url' => '/category/' . $category->slug]
        ];

        // Get price range for filters
        $priceRange = Product::where('status', 'active')
            ->where('in_stock', true)
            ->where('category_id', $category->id)
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        return $this->view('category/show', [
            'title' => $category->name . ' - Promethex',
            'category' => $category,
            'products' => $products,
            'breadcrumbs' => $breadcrumbs,
            'sortBy' => $sortBy,
            'priceMin' => $priceMin,
            'priceMax' => $priceMax,
            'priceRange' => $priceRange,
            'meta_description' => $category->meta_description ?? $category->description,
            'meta_title' => $category->meta_title ?? $category->name
        ], 'layout');
    }

    /**
     * Show all categories (category index)
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return $this->view('category/index', [
            'title' => 'All Categories - Promethex',
            'categories' => $categories,
            'meta_description' => 'Browse all product categories at Promethex',
            'meta_title' => 'All Categories'
        ], 'layout');
    }
}
