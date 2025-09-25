<!-- Category Show Page -->
<div class="container py-4">
    <?= \Framework\View::partial('category', 'breadcrumbs', ['category' => $category]) ?>
    
    <?= \Framework\View::partial('category', 'header', ['category' => $category, 'products' => $products, 'priceRange' => $priceRange ?? null]) ?>
    
    <?= \Framework\View::partial('product', 'products-grid', ['products' => $products]) ?>
</div>