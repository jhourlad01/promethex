<!-- Categories Index Page -->
<div class="container py-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">All Categories</h1>
        <p class="lead text-muted">Browse our complete range of product categories</p>
    </div>

    <!-- Categories Grid -->
    <?php if (!empty($categories) && $categories->count() > 0): ?>
    <div class="row g-4">
        <?php foreach ($categories as $category): ?>
        <div class="col-md-6 col-lg-4">
            <div class="category-card card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-5">
                <div class="category-image mb-4">
                    <?php 
                    $categoryImage = $category->image_url ?: '/public/images/categories/' . $category->slug . '.jpg';
                    ?>
                    <img src="<?= htmlspecialchars($categoryImage) ?>" 
                         alt="<?= htmlspecialchars($category->name) ?>" 
                         class="img-fluid rounded-3" 
                         style="width: 200px; height: 150px; object-fit: cover;">
                </div>
                    <h4 class="fw-bold mb-3"><?= htmlspecialchars($category->name) ?></h4>
                    <?php if ($category->description): ?>
                        <p class="text-muted mb-4"><?= htmlspecialchars($category->description) ?></p>
                    <?php endif; ?>
                    <a href="/category/<?= $category->slug ?>" class="btn btn-primary btn-lg rounded-pill px-4">
                        <i class="fas fa-arrow-right me-2"></i>Browse Products
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <!-- No Categories Found -->
    <div class="row">
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Categories Available</h4>
                <p class="text-muted">Categories will be available soon.</p>
                <a href="/" class="btn btn-primary">Back to Home</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.category-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

.category-icon i {
    transition: transform 0.3s ease;
}

.category-card:hover .category-icon i {
    transform: scale(1.1);
}

.btn-primary {
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
}
</style>
