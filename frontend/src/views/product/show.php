<?php
// Product Show Page
?>
<div class="container py-5">
    <?= \Framework\View::partial('product', 'breadcrumbs', ['product' => $product]) ?>
    
    <div class="row g-5">
        <!-- Product Images -->
        <div class="col-lg-6">
            <?= \Framework\View::partial('product', 'gallery', ['product' => $product]) ?>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="">
                <!-- Product Title -->
                <h1 class="display-6 fw-bold mb-3"><?= htmlspecialchars($product->name) ?></h1>

                <!-- Price -->
                <div class="mb-4">
                    <?php if ($product->isOnSale()): ?>
                        <div class="d-flex align-items-center gap-3">
                            <span class="display-5 fw-bold text-primary">$<?= number_format($product->sale_price, 2) ?></span>
                            <span class="text-muted text-decoration-line-through">$<?= number_format($product->price, 2) ?></span>
                            <span class="badge bg-danger fs-6">Save <?= $product->discount_percentage ?>%</span>
                        </div>
                    <?php else: ?>
                        <span class="display-5 fw-bold text-primary">$<?= number_format($product->price, 2) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Short Description -->
                <?php if ($product->short_description): ?>
                <div class="mb-4">
                    <p class="lead text-muted"><?= htmlspecialchars($product->short_description) ?></p>
                </div>
                <?php endif; ?>

                <!-- Stock Status -->
                <div class="mb-4">
                    <?php if ($product->isOutOfStock()): ?>
                        <span class="badge bg-danger fs-6">Out of Stock</span>
                    <?php elseif ($product->isLowStock()): ?>
                        <span class="badge bg-warning text-dark fs-6">Only <?= $product->stock_quantity ?> left in stock</span>
                    <?php else: ?>
                        <span class="badge bg-success fs-6">In Stock</span>
                    <?php endif; ?>
                </div>

                <!-- Product Features -->
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-shipping-fast text-primary me-2"></i>
                                <small>Free Shipping</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-undo text-primary me-2"></i>
                                <small>30-Day Returns</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-shield-alt text-primary me-2"></i>
                                <small>2-Year Warranty</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-headset text-primary me-2"></i>
                                <small>24/7 Support</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quantity and Add to Cart -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <label for="quantity" class="form-label fw-bold mb-0 me-3">Quantity:</label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button" id="decrease-qty">-</button>
                                        <input type="number" class="form-control text-center border" id="quantity" value="1" min="1" max="<?= $product->stock_quantity ?>" required data-parsley-type="integer" data-parsley-min="<?= 1 ?>" data-parsley-max="<?= $product->stock_quantity ?>" data-parsley-required-message="Please enter a quantity" data-parsley-type-message="Quantity must be a number" data-parsley-min-message="Quantity must be at least 1" data-parsley-max-message="Quantity cannot exceed <?= $product->stock_quantity ?>">
                                        <button class="btn btn-outline-secondary" type="button" id="increase-qty">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                <button class="btn btn-primary btn-lg px-4" id="add-to-cart-btn" 
                                        data-product-id="<?= $product->id ?>" 
                                        data-product-name="<?= htmlspecialchars($product->name) ?>"
                                        data-product-price="<?= $product->isOnSale() ? $product->sale_price : $product->price ?>">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                            <span class="">Description</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                            <span class="">Specifications</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    </li>
                </ul>
                
                <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabsContent">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <?= \Framework\View::partial('product', 'description', ['product' => $product]) ?>
                    </div>
                    
                    <!-- Specifications Tab -->
                    <div class="tab-pane fade" id="specifications" role="tabpanel">
                        <?= \Framework\View::partial('product', 'specifications', ['product' => $product]) ?>
                                    </div>
                                    
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if ($relatedProducts->count() > 0): ?>
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Related Products</h3>
            <div class="row g-4">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="/product/<?= htmlspecialchars($relatedProduct->slug) ?>" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm product-card">
                            <div class="position-relative">
                            <img src="<?= htmlspecialchars($relatedProduct->primary_image) ?>" 
                                 class="card-img-top" 
                                     alt="<?= htmlspecialchars($relatedProduct->name) ?>">
                            <?php if ($relatedProduct->isOnSale()): ?>
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">Sale</span>
                            <?php endif; ?>
                        </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($relatedProduct->name) ?></h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    <?= htmlspecialchars(substr($relatedProduct->description, 0, 100)) ?>...
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="h5 text-primary mb-0">$<?= number_format($relatedProduct->price, 2) ?></span>
                                <?php if ($relatedProduct->isOnSale()): ?>
                                            <small class="text-muted text-decoration-line-through d-block">$<?= number_format($relatedProduct->original_price, 2) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function changeMainImage(imageSrc, thumbnail) {
    document.getElementById('mainProductImage').src = imageSrc;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
    thumbnail.classList.add('active');
}

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const max = parseInt(quantityInput.getAttribute('max'));
    const current = parseInt(quantityInput.value);
    
    if (current < max) {
        quantityInput.value = current + 1;
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const current = parseInt(quantityInput.value);
    
    if (current > 1) {
        quantityInput.value = current - 1;
    }
}

// Quantity and Add to Cart JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('#productTabs button[data-bs-toggle="tab"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(event) {
            // Reset all badges to secondary
            document.querySelectorAll('#productTabs .badge').forEach(badge => {
                badge.classList.remove('bg-primary');
                badge.classList.add('bg-secondary');
            });
            
            // Set active tab badge to primary
            const activeBadge = event.target.querySelector('.badge');
            if (activeBadge) {
                activeBadge.classList.remove('bg-secondary');
                activeBadge.classList.add('bg-primary');
                    }
                });
            });
            
    // Quantity controls
    const decreaseBtn = document.getElementById('decrease-qty');
    const increaseBtn = document.getElementById('increase-qty');
    const quantityInput = document.getElementById('quantity');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    
    if (decreaseBtn) {
        decreaseBtn.addEventListener('click', decreaseQuantity);
    }
    
    if (increaseBtn) {
        increaseBtn.addEventListener('click', increaseQuantity);
    }
    
    // Add to cart functionality
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = this.dataset.productPrice;
            const quantity = quantityInput.value;
            
            // Add to cart logic here
            console.log('Adding to cart:', {
                productId: productId,
                productName: productName,
                productPrice: productPrice,
                quantity: quantity
            });
            
            // Show success message
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check me-2"></i>Added!';
            this.classList.remove('btn-primary');
            this.classList.add('btn-success');
            
            setTimeout(() => {
                this.innerHTML = originalText;
                this.classList.remove('btn-success');
                this.classList.add('btn-primary');
            }, 2000);
        });
    }
});
</script>