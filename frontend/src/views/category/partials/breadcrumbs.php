<?php
// Category page breadcrumbs
$breadcrumbs = [
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Categories', 'url' => '/categories'],
    ['title' => $category->name, 'url' => '']
];
?>
<?= \Framework\View::partial('breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
