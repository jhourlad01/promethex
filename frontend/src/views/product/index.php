<!-- Product Page -->
<div class="container py-4">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
            <?php if ($product->category): ?>
            <li class="breadcrumb-item"><a href="/category/<?= $product->category->slug ?>" class="text-decoration-none"><?= htmlspecialchars($product->category->name) ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product->name) ?></li>
        </ol>
    </nav>

    <!-- Product Details will be added here -->
    <div class="row">
        <div class="col-12">
            <h1><?= htmlspecialchars($product->name) ?></h1>
            <p><?= htmlspecialchars($product->description) ?></p>
        </div>
    </div>
</div>
