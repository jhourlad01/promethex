<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Request;
use App\Services\GraphQLClient;

class HomeController extends Controller
{
    private $graphqlClient;
    
    public function __construct(Request $request, array $params = [])
    {
        parent::__construct($request, $params);
        $this->graphqlClient = new GraphQLClient();
    }
    
    public function index()
    {
        // Get all active categories from GraphQL API
        $allCategories = $this->graphqlClient->getCategories();

        // Get featured products from GraphQL API
        $featuredProducts = $this->graphqlClient->getFeaturedProducts(6);

        // Calculate stats from the data we already have
        $totalProducts = count($this->graphqlClient->query('query { products { id } }')['products'] ?? []);
        $featuredProductCount = count($featuredProducts);

        return $this->view('home/index', [
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
