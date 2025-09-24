<?php

namespace App\Controllers;

use Framework\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Get all active categories
        $allCategories = Category::where('is_active', true)
            ->orderBy('sort_order')
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
            'allCategories' => $allCategories,
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
