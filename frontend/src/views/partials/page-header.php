<?php
// Global page header component
$title = $title ?? 'Page Title';
$subtitle = $subtitle ?? '';
$badge = $badge ?? '';
?>
<div class="text-center mb-5">
    <?php if ($badge): ?>
        <span class="badge bg-primary mb-3"><?= htmlspecialchars($badge) ?></span>
    <?php endif; ?>
    <h1 class="display-4 fw-bold text-dark mb-3"><?= htmlspecialchars($title) ?></h1>
    <?php if ($subtitle): ?>
        <p class="lead text-muted"><?= htmlspecialchars($subtitle) ?></p>
    <?php endif; ?>
</div>
