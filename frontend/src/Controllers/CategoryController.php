<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Request;
use Framework\Response;
use App\Services\GraphQLClient;
use App\Services\DataTransformer;

class CategoryController extends Controller
{
    private $graphqlClient;
    
    public function __construct(Request $request, array $params = [])
    {
        parent::__construct($request, $params);
        $this->graphqlClient = new GraphQLClient();
    }
    
    /**
     * Show products in a specific category
     */
    public function show()
    {
        $slug = $this->getParam('slug');

        if (!$slug) {
            return $this->redirect('/');
        }

        // Get category and products from GraphQL API
        $query = '
            query GetCategoryWithProducts($slug: String!) {
                category(slug: $slug) {
                    id
                    name
                    slug
                    description
                    image_url
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
                        featured
                        created_at
                    }
                }
            }
        ';
        
        $result = $this->graphqlClient->query($query, ['slug' => $slug]);
        $category = $result['category'] ?? null;

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

        // Apply client-side filtering and sorting
        $products = $category['products'] ?? [];
        
        // Apply price filters
        if ($priceMin !== null && is_numeric($priceMin)) {
            $products = array_filter($products, function($product) use ($priceMin) {
                return $product['price'] >= $priceMin;
            });
        }
        if ($priceMax !== null && is_numeric($priceMax)) {
            $products = array_filter($products, function($product) use ($priceMax) {
                return $product['price'] <= $priceMax;
            });
        }

        // Apply sorting
        switch ($sortBy) {
            case 'price_low':
                usort($products, function($a, $b) {
                    return $a['price'] <=> $b['price'];
                });
                break;
            case 'price_high':
                usort($products, function($a, $b) {
                    return $b['price'] <=> $a['price'];
                });
                break;
            case 'name':
                usort($products, function($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
                break;
            case 'featured':
                usort($products, function($a, $b) {
                    if ($a['featured'] == $b['featured']) {
                        return strtotime($b['created_at']) - strtotime($a['created_at']);
                    }
                    return $b['featured'] - $a['featured'];
                });
                break;
            case 'newest':
            default:
                usort($products, function($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });
                break;
        }

        // Get breadcrumbs
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'Categories', 'url' => '/categories'],
            ['name' => $category['name'], 'url' => '/category/' . $category['slug']]
        ];

        // Calculate price range
        $prices = array_column($products, 'price');
        $priceRange = [
            'min_price' => !empty($prices) ? min($prices) : 0,
            'max_price' => !empty($prices) ? max($prices) : 0
        ];

        return $this->view('category/show', [
            'title' => $category['name'] . ' - Promethex',
            'category' => DataTransformer::transformCategory($category),
            'products' => DataTransformer::transformProducts($products),
            'breadcrumbs' => $breadcrumbs,
            'sortBy' => $sortBy,
            'priceMin' => $priceMin,
            'priceMax' => $priceMax,
            'priceRange' => DataTransformer::transformPriceRange($priceRange),
            'meta_description' => $category['description'] ?? '',
            'meta_title' => $category['name']
        ], 'layout');
    }

    /**
     * Show all categories (category index)
     */
    public function index()
    {
        $categories = $this->graphqlClient->getCategories();

        return $this->view('category/index', [
            'title' => 'All Categories - Promethex',
            'categories' => $categories,
            'meta_description' => 'Browse all product categories at Promethex',
            'meta_title' => 'All Categories'
        ], 'layout');
    }
}