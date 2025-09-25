<?= \Framework\View::partial('home', 'hero') ?>

<!-- Categories Section -->
<?php if (!empty($allCategories) && $allCategories->count() > 0): ?>
<div class="container py-5">
    <?= \Framework\View::partial('page-header', [
        'title' => 'Shop by Category',
        'subtitle' => 'Explore our wide range of product categories'
    ]) ?>
    
    <?= \Framework\View::partial('category', 'categories-badges', ['categories' => $allCategories]) ?>
</div>
<?php endif; ?>

<!-- Products Section -->
<?php if (!empty($featuredProducts) && count($featuredProducts) > 0): ?>
<div class="container">
    <?= \Framework\View::partial('page-header', [
        'title' => 'Featured Products',
        'subtitle' => 'Handpicked items for the modern lifestyle'
    ]) ?>
    
    <?= \Framework\View::partial('product', 'products-grid', ['products' => $featuredProducts]) ?>
</div>
<?php else: ?>
<div class="container">
    <?= \Framework\View::partial('page-header', [
        'title' => 'Featured Products',
        'subtitle' => 'No featured products available at the moment'
    ]) ?>
</div>
<?php endif; ?>

