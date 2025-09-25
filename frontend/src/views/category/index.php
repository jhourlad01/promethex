<!-- Categories Index Page -->
<div class="container py-5">
    <?= \Framework\View::partial('page-header', [
        'title' => 'All Categories',
        'subtitle' => 'Browse our complete range of product categories'
    ]) ?>

    <?= \Framework\View::partial('category', 'categories-badges', ['categories' => $categories]) ?>
</div>