<?php
// Product Specifications Partial
?>
<div class="">
    <?php 
    $attributes = $product->getAttributes();
    if (!empty($attributes)): 
    ?>
        <div class="row">
            <?php foreach ($attributes as $key => $value): ?>
            <div class="col-md-6 mb-3">
                <div class="">
                    <strong><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $key))) ?>:</strong>
                    <span class="text-muted ms-2"><?= htmlspecialchars($value) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($product->weight || $product->getFormattedDimensions()): ?>
            <hr class="my-4">
            <h6 class="fw-bold mb-3">Physical Specifications</h6>
            <div class="row">
                <?php if ($product->weight): ?>
                <div class="col-md-6 mb-3">
                    <div class="">
                        <strong>Weight:</strong>
                        <span class="text-muted ms-2"><?= $product->getFormattedWeight() ?></span>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($product->getFormattedDimensions()): ?>
                <div class="col-md-6 mb-3">
                    <div class="">
                        <strong>Dimensions:</strong>
                        <span class="text-muted ms-2"><?= $product->getFormattedDimensions() ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-muted">No specifications available for this product.</p>
    <?php endif; ?>
    
    <!-- Basic Product Information -->
    <hr class="my-4">
    <h6 class="fw-bold mb-3">Product Information</h6>
    <div class="row">
        <?php if ($product->sku): ?>
        <div class="col-md-6 mb-3">
            <div class="">
                <strong>SKU:</strong>
                <span class="text-muted ms-2"><?= htmlspecialchars($product->sku) ?></span>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="col-md-6 mb-3">
            <div class="">
                <strong>Stock Quantity:</strong>
                <span class="text-muted ms-2"><?= $product->stock_quantity ?? 0 ?></span>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="">
                <strong>Status:</strong>
                <span class="text-muted ms-2"><?= ucfirst($product->status ?? 'active') ?></span>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="">
                <strong>In Stock:</strong>
                <span class="text-muted ms-2"><?= $product->in_stock ? 'Yes' : 'No' ?></span>
            </div>
        </div>
    </div>
</div>
