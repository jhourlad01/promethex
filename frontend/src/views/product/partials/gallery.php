<?php
// Product page gallery
?>
<div class="product-gallery">
    <div class="mb-3">
        <img src="<?= htmlspecialchars($product->primary_image) ?>" 
             alt="<?= htmlspecialchars($product->name) ?>" 
             class="img-fluid rounded w-100" 
             id="mainImage">
    </div>
    <?php if (!empty($product->images) && count($product->images) > 1): ?>
        <div class="row g-2">
            <?php foreach ($product->images as $index => $image): ?>
                <div class="col-2">
                    <img src="<?= htmlspecialchars($image) ?>" 
                         alt="<?= htmlspecialchars($product->name) ?> - Image <?= $index + 1 ?>" 
                         class="img-fluid rounded border w-100" 
                         onclick="document.getElementById('mainImage').src = this.src">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
