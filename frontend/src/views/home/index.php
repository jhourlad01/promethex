<?= \Framework\View::partial('home', 'hero') ?>

<?php if (isset($_GET['verified']) && $_GET['verified'] == '1'): ?>
<div class="container mt-4">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Email Verified!</strong> Your account has been activated successfully. Welcome to Promethex!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

<?php if (isset($_GET['registered']) && $_GET['registered'] == '1'): ?>
<div class="container mt-4">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Welcome to Promethex!</strong> Your account has been created successfully. You can now start shopping!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

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

