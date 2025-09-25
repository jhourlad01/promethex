<?php
// Category page header
?>
<div class="row mb-5">
    <div class="col-lg-8">
        <h1 class="display-5 fw-bold text-dark mb-3"><?= htmlspecialchars($category->name) ?></h1>
        <p class="lead text-muted mb-4"><?= htmlspecialchars($category->description) ?></p>
        <div class="d-flex align-items-center text-muted">
            <span class="me-3">
                <i class="fas fa-box me-1"></i>
                <?= count($products) ?> products
            </span>
            <?php if (isset($priceRange) && $priceRange->min_price && $priceRange->max_price): ?>
                <span>
                    <i class="fas fa-dollar-sign me-1"></i>
                    $<?= number_format($priceRange->min_price, 2) ?> - $<?= number_format($priceRange->max_price, 2) ?>
                </span>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-4 text-end">
        <?php if ($category->primary_image): ?>
            <img src="<?= htmlspecialchars($category->primary_image) ?>" 
                 alt="<?= htmlspecialchars($category->name) ?>" 
                 class="img-fluid rounded shadow" 
                 style="max-height: 200px;">
        <?php endif; ?>
    </div>
</div>
