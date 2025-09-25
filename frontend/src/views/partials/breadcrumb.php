<?php
// Global breadcrumb component
if (!empty($breadcrumbs)): ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
            <?php if ($index === count($breadcrumbs) - 1): ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= htmlspecialchars($breadcrumb['title']) ?>
                </li>
            <?php else: ?>
                <li class="breadcrumb-item">
                    <a href="<?= htmlspecialchars($breadcrumb['url']) ?>">
                        <?= htmlspecialchars($breadcrumb['title']) ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
<?php endif; ?>
