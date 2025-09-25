<?php
// Product Description Partial
?>
<div class="">
    <?php if ($product->description): ?>
        <p><?= nl2br(htmlspecialchars($product->description)) ?></p>
    <?php else: ?>
        <p class="text-muted">No detailed description available for this product.</p>
    <?php endif; ?>
</div>
