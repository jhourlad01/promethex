<!-- Hero Section -->
<div class="hero-section text-center py-5 mb-5">
    <div class="container">
        <h1 class="display-3 fw-bold mb-4 text-white">
            <?= $message ?? 'Welcome to Promethex' ?>
        </h1>
        <p class="lead text-white-50 mb-4">
            Discover premium products crafted for modern living
        </p>
        <div class="hero-stats d-flex justify-content-center gap-5 text-white">
            <div class="stat-item">
                <div class="h3 mb-1">500+</div>
                <small>Products</small>
            </div>
            <div class="stat-item">
                <div class="h3 mb-1">50K+</div>
                <small>Happy Customers</small>
            </div>
            <div class="stat-item">
                <div class="h3 mb-1">4.9</div>
                <small>Rating</small>
            </div>
        </div>
    </div>
</div>

<!-- Featured Categories -->
<div class="container mb-5">
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="category-card text-center p-4 rounded-3">
                <div class="category-icon mb-3">
                    <i class="fas fa-headphones fa-3x text-primary"></i>
                </div>
                <h5 class="fw-bold">Audio & Music</h5>
                <p class="text-muted small">Premium sound experience</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="category-card text-center p-4 rounded-3">
                <div class="category-icon mb-3">
                    <i class="fas fa-laptop fa-3x text-success"></i>
                </div>
                <h5 class="fw-bold">Tech & Gadgets</h5>
                <p class="text-muted small">Latest technology</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="category-card text-center p-4 rounded-3">
                <div class="category-icon mb-3">
                    <i class="fas fa-gamepad fa-3x text-warning"></i>
                </div>
                <h5 class="fw-bold">Gaming</h5>
                <p class="text-muted small">Professional gaming gear</p>
            </div>
        </div>
    </div>
</div>

<!-- Products Section -->
<div class="container">
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold mb-3">Featured Products</h2>
        <p class="text-muted lead">Handpicked items for the modern lifestyle</p>
    </div>
    
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="product-card card h-100 border-0 shadow-sm">
                <div class="product-image position-relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop" class="card-img-top" alt="Premium Headphones">
                    <div class="product-badge position-absolute top-0 end-0 m-3">
                        <span class="badge bg-success">Best Seller</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="product-rating mb-2">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <span class="ms-2 text-muted small">(128 reviews)</span>
                    </div>
                    <h5 class="card-title fw-bold mb-2">Premium Headphones</h5>
                    <p class="card-text text-muted mb-3">High-quality audio experience with active noise cancellation technology.</p>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="h4 text-primary fw-bold mb-0">$199.99</span>
                            <small class="text-muted d-block">Free shipping</small>
                        </div>
                        <button class="btn btn-primary px-4 py-2 rounded-pill">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="product-card card h-100 border-0 shadow-sm">
                <div class="product-image position-relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop" class="card-img-top" alt="Smart Watch">
                    <div class="product-badge position-absolute top-0 end-0 m-3">
                        <span class="badge bg-info">New</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="product-rating mb-2">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <span class="ms-2 text-muted small">(89 reviews)</span>
                    </div>
                    <h5 class="card-title fw-bold mb-2">Smart Watch</h5>
                    <p class="card-text text-muted mb-3">Track your fitness goals and stay connected with advanced health monitoring.</p>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="h4 text-primary fw-bold mb-0">$299.99</span>
                            <small class="text-muted d-block">Free shipping</small>
                        </div>
                        <button class="btn btn-primary px-4 py-2 rounded-pill">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="product-card card h-100 border-0 shadow-sm">
                <div class="product-image position-relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=300&fit=crop" class="card-img-top" alt="Wireless Speaker">
                    <div class="product-badge position-absolute top-0 end-0 m-3">
                        <span class="badge bg-warning text-dark">Sale</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="product-rating mb-2">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="far fa-star text-warning"></i>
                        <span class="ms-2 text-muted small">(67 reviews)</span>
                    </div>
                    <h5 class="card-title fw-bold mb-2">Wireless Speaker</h5>
                    <p class="card-text text-muted mb-3">Portable speaker with exceptional sound quality and long battery life.</p>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="h4 text-primary fw-bold mb-0">$149.99</span>
                            <small class="text-muted d-block">Free shipping</small>
                        </div>
                        <button class="btn btn-primary px-4 py-2 rounded-pill">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="product-card card h-100 border-0 shadow-sm">
                <div class="product-image position-relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&h=300&fit=crop" class="card-img-top" alt="Gaming Mouse">
                </div>
                <div class="card-body p-4">
                    <div class="product-rating mb-2">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <span class="ms-2 text-muted small">(156 reviews)</span>
                    </div>
                    <h5 class="card-title fw-bold mb-2">Gaming Mouse</h5>
                    <p class="card-text text-muted mb-3">Precision gaming mouse with customizable RGB lighting and ergonomic design.</p>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="h4 text-primary fw-bold mb-0">$79.99</span>
                            <small class="text-muted d-block">Free shipping</small>
                        </div>
                        <button class="btn btn-primary px-4 py-2 rounded-pill">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="product-card card h-100 border-0 shadow-sm">
                <div class="product-image position-relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1541140532154-b024d705b90a?w=400&h=300&fit=crop" class="card-img-top" alt="Mechanical Keyboard">
                    <div class="product-badge position-absolute top-0 end-0 m-3">
                        <span class="badge bg-danger">Hot</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="product-rating mb-2">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <span class="ms-2 text-muted small">(203 reviews)</span>
                    </div>
                    <h5 class="card-title fw-bold mb-2">Mechanical Keyboard</h5>
                    <p class="card-text text-muted mb-3">Professional mechanical keyboard with tactile switches for typing and gaming.</p>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="h4 text-primary fw-bold mb-0">$129.99</span>
                            <small class="text-muted d-block">Free shipping</small>
                        </div>
                        <button class="btn btn-primary px-4 py-2 rounded-pill">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="product-card card h-100 border-0 shadow-sm">
                <div class="product-image position-relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=300&fit=crop" class="card-img-top" alt="USB-C Hub">
                </div>
                <div class="card-body p-4">
                    <div class="product-rating mb-2">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="far fa-star text-warning"></i>
                        <span class="ms-2 text-muted small">(45 reviews)</span>
                    </div>
                    <h5 class="card-title fw-bold mb-2">USB-C Hub</h5>
                    <p class="card-text text-muted mb-3">Multi-port USB-C hub for laptops and tablets with fast data transfer.</p>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="h4 text-primary fw-bold mb-0">$49.99</span>
                            <small class="text-muted d-block">Free shipping</small>
                        </div>
                        <button class="btn btn-primary px-4 py-2 rounded-pill">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
