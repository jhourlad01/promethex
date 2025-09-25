<?php
// Products grid component - expects $products variable
if (!empty($products)): ?>
<div class="row g-4">
    <?php foreach ($products as $product): ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="/product/<?= htmlspecialchars($product->slug) ?>" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm product-card">
                    <div class="position-relative">
                        <img src="<?= htmlspecialchars($product->primary_image) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($product->name) ?>">
                        <?php if ($product->isOnSale()): ?>
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">Sale</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                        <p class="card-text text-muted small flex-grow-1">
                            <?= htmlspecialchars(substr($product->description, 0, 100)) ?>...
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="h5 text-primary mb-0">$<?= number_format($product->price, 2) ?></span>
                                <?php if ($product->isOnSale()): ?>
                                    <small class="text-muted text-decoration-line-through d-block">$<?= number_format($product->original_price, 2) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>


<?php endif; ?>
