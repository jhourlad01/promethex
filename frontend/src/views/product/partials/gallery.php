<?php
// Product page gallery
?>
<div class="product-gallery">
    <div class="main-image mb-3">
        <img src="<?= htmlspecialchars($product->primary_image) ?>" 
             alt="<?= htmlspecialchars($product->name) ?>" 
             class="img-fluid rounded shadow" 
             id="mainImage">
    </div>
    <?php if (!empty($product->images) && count($product->images) > 1): ?>
        <div class="thumbnail-images d-flex gap-2">
            <?php foreach ($product->images as $index => $image): ?>
                <img src="<?= htmlspecialchars($image) ?>" 
                     alt="<?= htmlspecialchars($product->name) ?> - Image <?= $index + 1 ?>" 
                     class="img-thumbnail" 
                     style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                     onclick="document.getElementById('mainImage').src = this.src">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
