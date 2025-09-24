<!-- Breadcrumbs -->
<div class="container py-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
            <?php if ($product->category): ?>
            <li class="breadcrumb-item"><a href="/categories/<?= $product->category->slug ?>" class="text-decoration-none"><?= htmlspecialchars($product->category->name) ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product->name) ?></li>
        </ol>
    </nav>
</div>

<!-- Product Details -->
<div class="container py-5">
    <div class="row g-5">
        <!-- Product Images -->
        <div class="col-lg-6">
            <div class="product-gallery">
                <?php if (!empty($product->images)): ?>
                    <div class="main-image mb-3">
                        <img src="<?= htmlspecialchars($product->primary_image) ?>" 
                             class="img-fluid rounded-3 shadow-sm" 
                             alt="<?= htmlspecialchars($product->name) ?>"
                             id="mainProductImage">
                    </div>
                    
                    <?php if (count($product->images) > 1): ?>
                    <div class="thumbnail-images d-flex gap-2">
                        <?php foreach ($product->images as $index => $image): ?>
                        <div class="thumbnail <?= $index === 0 ? 'active' : '' ?>" 
                             onclick="changeMainImage('<?= htmlspecialchars($image) ?>', this)">
                            <img src="<?= htmlspecialchars($image) ?>" 
                                 class="img-thumbnail" 
                                 alt="<?= htmlspecialchars($product->name) ?> - Image <?= $index + 1 ?>"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="main-image mb-3">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=600&fit=crop" 
                             class="img-fluid rounded-3 shadow-sm" 
                             alt="<?= htmlspecialchars($product->name) ?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="product-info">
                <!-- Product Title -->
                <h1 class="display-6 fw-bold mb-3"><?= htmlspecialchars($product->name) ?></h1>
                
                <!-- Rating -->
                <div class="product-rating mb-3">
                    <div class="d-flex align-items-center">
                        <div class="stars me-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <span class="text-muted">(<?= rand(50, 500) ?> reviews)</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="price-section mb-4">
                    <?php if ($product->isOnSale()): ?>
                        <div class="d-flex align-items-center gap-3">
                            <span class="display-5 fw-bold text-primary">$<?= number_format($product->sale_price, 2) ?></span>
                            <span class="h4 text-muted text-decoration-line-through">$<?= number_format($product->price, 2) ?></span>
                            <span class="badge bg-danger fs-6">Save <?= $product->discount_percentage ?>%</span>
                        </div>
                    <?php else: ?>
                        <span class="display-5 fw-bold text-primary">$<?= number_format($product->price, 2) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Short Description -->
                <?php if ($product->short_description): ?>
                <div class="short-description mb-4">
                    <p class="lead text-muted"><?= htmlspecialchars($product->short_description) ?></p>
                </div>
                <?php endif; ?>

                <!-- Stock Status -->
                <div class="stock-status mb-4">
                    <?php if ($product->isOutOfStock()): ?>
                        <span class="badge bg-danger fs-6">Out of Stock</span>
                    <?php elseif ($product->isLowStock()): ?>
                        <span class="badge bg-warning text-dark fs-6">Only <?= $product->stock_quantity ?> left in stock</span>
                    <?php else: ?>
                        <span class="badge bg-success fs-6">In Stock</span>
                    <?php endif; ?>
                </div>

                <!-- Add to Cart -->
                <div class="add-to-cart mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                                <input type="number" class="form-control text-center" value="1" min="1" max="<?= $product->stock_quantity ?>" id="quantity">
                                <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <button class="btn btn-primary btn-lg w-100" <?= $product->isOutOfStock() ? 'disabled' : '' ?>>
                                <i class="fas fa-shopping-cart me-2"></i>
                                <?= $product->isOutOfStock() ? 'Out of Stock' : 'Add to Cart' ?>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Features -->
                <div class="product-features mb-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="feature-item d-flex align-items-center">
                                <i class="fas fa-shipping-fast text-primary me-2"></i>
                                <small>Free Shipping</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item d-flex align-items-center">
                                <i class="fas fa-undo text-primary me-2"></i>
                                <small>30-Day Returns</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item d-flex align-items-center">
                                <i class="fas fa-shield-alt text-primary me-2"></i>
                                <small>2-Year Warranty</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item d-flex align-items-center">
                                <i class="fas fa-headset text-primary me-2"></i>
                                <small>24/7 Support</small>
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
            <div class="product-tabs">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                            Description
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                            Specifications
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                            Reviews
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabsContent">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="product-description">
                            <?php if ($product->description): ?>
                                <p><?= nl2br(htmlspecialchars($product->description)) ?></p>
                            <?php else: ?>
                                <p class="text-muted">No detailed description available for this product.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Specifications Tab -->
                    <div class="tab-pane fade" id="specifications" role="tabpanel">
                        <div class="product-specifications">
                            <?php if (!empty($product->attributes)): ?>
                                <div class="row">
                                    <?php foreach ($product->attributes as $key => $value): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="spec-item">
                                            <strong><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $key))) ?>:</strong>
                                            <span class="text-muted ms-2"><?= htmlspecialchars($value) ?></span>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <?php if ($product->weight || $product->length || $product->width || $product->height): ?>
                                <hr class="my-4">
                                <h6 class="fw-bold mb-3">Physical Specifications</h6>
                                <div class="row">
                                    <?php if ($product->weight): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="spec-item">
                                            <strong>Weight:</strong>
                                            <span class="text-muted ms-2"><?= $product->formatted_weight ?></span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($product->formatted_dimensions): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="spec-item">
                                            <strong>Dimensions:</strong>
                                            <span class="text-muted ms-2"><?= $product->formatted_dimensions ?></span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-muted">No specifications available for this product.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="product-reviews">
                            <div class="text-center py-5">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Reviews Coming Soon</h5>
                                <p class="text-muted">Customer reviews will be available here.</p>
                            </div>
                        </div>
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
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="product-image position-relative overflow-hidden">
                            <img src="<?= htmlspecialchars($relatedProduct->primary_image) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($relatedProduct->name) ?>"
                                 style="height: 200px; object-fit: cover;">
                            <?php if ($relatedProduct->isOnSale()): ?>
                            <div class="product-badge position-absolute top-0 end-0 m-2">
                                <span class="badge bg-warning text-dark">Sale</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="card-title fw-bold mb-2"><?= htmlspecialchars($relatedProduct->name) ?></h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <?php if ($relatedProduct->isOnSale()): ?>
                                    <span class="fw-bold text-primary">$<?= number_format($relatedProduct->sale_price, 2) ?></span>
                                <?php else: ?>
                                    <span class="fw-bold text-primary">$<?= number_format($relatedProduct->price, 2) ?></span>
                                <?php endif; ?>
                                <a href="/product/<?= $relatedProduct->slug ?>" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                    </div>
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
</script>
