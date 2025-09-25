<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Request;
use Framework\Response;
use App\Services\GraphQLClient;
use App\Services\DataTransformer;

class ProductController extends Controller
{
    private $graphqlClient;
    
    public function __construct(Request $request, array $params = [])
    {
        parent::__construct($request, $params);
        $this->graphqlClient = new GraphQLClient();
    }
    
    public function show()
    {
        $slug = $this->getParam('slug');
        
        if (!$slug) {
            return $this->redirect('/');
        }

        // Get product from GraphQL API
        $product = $this->graphqlClient->getProduct($slug);

        if (!$product) {
            return $this->view('errors/404', [
                'title' => 'Product Not Found',
                'message' => 'The product you are looking for does not exist.'
            ], 'layout');
        }

        // Get related products (same category, excluding current product)
        $relatedProductsQuery = '
            query GetRelatedProducts($categoryId: ID!) {
                products(category_id: $categoryId, limit: 4) {
                    id
                    name
                    slug
                    price
                    sale_price
                    primary_image
                }
            }
        ';

        $relatedResult = $this->graphqlClient->query($relatedProductsQuery, [
            'categoryId' => $product->category->id
        ]);

        $relatedProducts = array_filter($relatedResult['products'] ?? [], function($p) use ($product) {
            return $p['id'] != $product->id;
        });

        // Limit to 4 related products
        $relatedProducts = array_slice($relatedProducts, 0, 4);


        return $this->view('product/show', [
            'title' => $product->name . ' - Promethex',
            'product' => $product,
            'relatedProducts' => DataTransformer::transformProducts($relatedProducts),
            'meta_description' => $product->description ?? '',
            'meta_title' => $product->name
        ], 'layout');
    }
    
}
