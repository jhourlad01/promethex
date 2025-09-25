<!-- Hero Section -->
<div class="hero-section text-center py-5 mb-5">
    <div class="container">
        <h1 class="display-3 fw-bold mb-4 text-white">
            <?= $message ?? 'Welcome to Promethex' ?>
        </h1>
        <p class="lead text-white-50 mb-4">
            Discover premium products crafted for modern living
        </p>
        <div class="hero-stats d-flex justify-content-center gap-5 text-white">
            <div class="stat-item">
                <div class="h3 mb-1"><?= $totalProducts ?? '500+' ?></div>
                <small>Products</small>
            </div>
            <div class="stat-item">
                <div class="h3 mb-1">50K+</div>
                <small>Happy Customers</small>
            </div>
            <div class="stat-item">
                <div class="h3 mb-1">4.9</div>
                <small>Rating</small>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<?php if (!empty($allCategories) && $allCategories->count() > 0): ?>
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold mb-3">Shop by Category</h2>
        <p class="text-muted lead">Explore our wide range of product categories</p>
    </div>
    
    <div class="row g-3 justify-content-center">
        <?php foreach ($allCategories as $category): ?>
        <div class="col-auto">
            <a href="/category/<?= $category->slug ?>" class="text-decoration-none">
                <span class="badge bg-primary bg-gradient fs-6 px-4 py-3 rounded-pill category-badge">
                    <i class="fas fa-tag me-2"></i><?= htmlspecialchars($category->name) ?>
                </span>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<style>
.category-badge {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.category-badge:hover {
    background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    border-color: rgba(255, 255, 255, 0.2);
}

.category-badge i {
    transition: transform 0.3s ease;
}

.category-badge:hover i {
    transform: scale(1.1);
}
</style>

<!-- Products Section -->
<?php if (!empty($featuredProducts) && count($featuredProducts) > 0): ?>
<div class="container">
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold mb-3">Featured Products</h2>
        <p class="text-muted lead">Handpicked items for the modern lifestyle</p>
    </div>
    
    <div class="row g-4">
        <?php foreach ($featuredProducts as $product): ?>
        <div class="col-md-6 col-lg-4">
            <div class="product-card card h-100 border-0 shadow-sm">
                <div class="product-image position-relative overflow-hidden">
                    <?php 
                    $primaryImage = $product->primary_image;
                    $imageUrl = $primaryImage ?: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop';
                    ?>
                    <a href="/product/<?= $product->slug ?>">
                        <img src="<?= htmlspecialchars($imageUrl) ?>" class="card-img-top" alt="<?= htmlspecialchars($product->name) ?>">
                    </a>
                    <?php if ($product->isOnSale()): ?>
                    <div class="product-badge position-absolute top-0 end-0 m-3">
                        <span class="badge bg-warning text-dark">Sale</span>
                    </div>
                    <?php elseif ($product->featured): ?>
                    <div class="product-badge position-absolute top-0 end-0 m-3">
                        <span class="badge bg-success">Featured</span>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-body p-4">
                    <div class="product-rating mb-2">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <span class="ms-2 text-muted small">(<?= rand(20, 200) ?> reviews)</span>
                    </div>
                    <h5 class="card-title fw-bold mb-2">
                        <a href="/product/<?= $product->slug ?>" class="text-decoration-none text-dark">
                            <?= htmlspecialchars($product->name) ?>
                        </a>
                    </h5>
                    <p class="card-text text-muted mb-3"><?= htmlspecialchars($product->description) ?></p>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php if ($product->isOnSale()): ?>
                                <span class="h5 text-primary fw-bold mb-0">$<?= number_format($product->sale_price, 2) ?></span>
                                <small class="text-muted text-decoration-line-through d-block">$<?= number_format($product->price, 2) ?></small>
                            <?php else: ?>
                                <span class="h5 text-primary fw-bold mb-0">$<?= number_format($product->price, 2) ?></span>
                            <?php endif; ?>
                            <small class="text-muted d-block">Free shipping</small>
                        </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary px-4 py-2 rounded-pill flex-grow-1">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                    </button>
                                </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
<div class="container">
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold mb-3">Featured Products</h2>
        <p class="text-muted lead">No featured products available at the moment</p>
    </div>
</div>
<?php endif; ?>

<style>
.category-badge {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.category-badge:hover {
    background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    border-color: rgba(255, 255, 255, 0.2);
}

.category-badge i {
    transition: transform 0.3s ease;
}

.category-badge:hover i {
    transform: scale(1.1);
}
</style>
