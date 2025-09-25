<!-- Category Page -->
<div class="container py-4">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb): ?>
                <li class="breadcrumb-item">
                    <?php if (isset($breadcrumb['url'])): ?>
                        <a href="<?= $breadcrumb['url'] ?>"><?= htmlspecialchars($breadcrumb['name']) ?></a>
                    <?php else: ?>
                        <?= htmlspecialchars($breadcrumb['name']) ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="category-header text-center py-5 bg-light rounded-3">
                <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($category->name) ?></h1>
                <?php if ($category->description): ?>
                    <p class="lead text-muted mb-4"><?= htmlspecialchars($category->description) ?></p>
                <?php endif; ?>
                <div class="category-stats">
                    <span class="badge bg-primary fs-6"><?= count($products) ?> Products</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <?php if (count($products) > 0): ?>
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
        <div class="col-md-6 col-lg-4 col-xl-3">
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
                            <button class="btn btn-primary px-4 py-2 rounded-pill">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <!-- No Products Found -->
    <div class="row">
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Products Found</h4>
                <p class="text-muted">Try adjusting your filters or browse other categories.</p>
                <a href="/" class="btn btn-primary">Back to Home</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

.product-image img {
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.category-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.badge.bg-outline-primary {
    background-color: transparent !important;
    color: #0d6efd !important;
}

.badge.bg-outline-primary:hover {
    background-color: #0d6efd !important;
    color: white !important;
}
</style>
