<?php

namespace App\Controllers;

use Framework\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured categories (root categories that are featured)
        $featuredCategories = Category::where('is_featured', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        // Get featured products
        $featuredProducts = Product::where('featured', true)
            ->where('status', 'active')
            ->where('in_stock', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get product counts for hero stats
        $totalProducts = Product::where('status', 'active')->count();
        $featuredProductCount = Product::where('featured', true)->where('status', 'active')->count();

        return $this->view('home', [
            'title' => 'Promethex - Premium E-Commerce',
            'message' => 'Welcome to Promethex',
            'featuredCategories' => $featuredCategories,
            'featuredProducts' => $featuredProducts,
            'totalProducts' => $totalProducts,
            'featuredProductCount' => $featuredProductCount,
            'features' => app()->getEnabledFeatures()
        ], 'layout');
    }

    public function dashboard()
    {
        return $this->view('dashboard', [
            'title' => 'Dashboard - Promethex E-Commerce'
        ], 'layout');
    }

    public function profile()
    {
        return $this->view('profile', [
            'title' => 'Profile - Promethex E-Commerce'
        ], 'layout');
    }

    public function account()
    {
        return $this->view('account', [
            'title' => 'Account - Promethex E-Commerce'
        ], 'layout');
    }
}
