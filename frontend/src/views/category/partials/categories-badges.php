<?php
// Categories badges component - expects $categories variable
if (!empty($categories)): ?>
<div class="row g-3">
    <?php foreach ($categories as $category): ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 shadow-sm category-card">
                <a href="/category/<?= htmlspecialchars($category->slug) ?>" class="text-decoration-none text-dark">
                    <div class="position-relative">
                        <img src="/public/images/categories/<?= htmlspecialchars($category->slug) ?>.jpg" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($category->name) ?>">
                        <div class="card-img-overlay d-flex align-items-end">
                            <div class="bg-dark bg-opacity-75 rounded p-2 w-100">
                                <h5 class="card-title text-white mb-0"><?= htmlspecialchars($category->name) ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted small">
                            <?= htmlspecialchars(substr($category->description, 0, 80)) ?>...
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-box me-1"></i>
                                <?= $category->product_count ?? 0 ?> products
                            </small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>
