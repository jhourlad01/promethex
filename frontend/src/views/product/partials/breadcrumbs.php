<?php
// Product page breadcrumbs
$breadcrumbs = [
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Categories', 'url' => '/categories'],
    ['title' => $product->category->name, 'url' => '/category/' . $product->category->slug],
    ['title' => $product->name, 'url' => '']
];
?>
<?= \Framework\View::partial('breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
