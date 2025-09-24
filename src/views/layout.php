<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Promethex E-Commerce' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
                
                :root {
                    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                    --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
                    --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
                    --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
                    --shadow-lg: 0 8px 24px rgba(0,0,0,0.15);
                    --shadow-xl: 0 16px 48px rgba(0,0,0,0.2);
                }
                
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    background-color: #ffffff;
                    line-height: 1.6;
                    color: #1a1a1a;
                    font-weight: 400;
                }
                
                /* Navigation */
                .navbar {
                    backdrop-filter: blur(20px);
                    background: rgba(255, 255, 255, 0.95) !important;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                    transition: all 0.3s ease;
                }
                
                .navbar.scrolled {
                    background: rgba(255, 255, 255, 0.98) !important;
                    box-shadow: var(--shadow-md);
                }
                
                .brand-gradient {
                    background: var(--primary-gradient);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    font-weight: 800;
                }
                
                .nav-link {
                    color: #4a5568 !important;
                    font-weight: 500;
                    transition: all 0.3s ease;
                    position: relative;
                }
                
                .nav-link:hover {
                    color: #667eea !important;
                    transform: translateY(-1px);
                }
                
                .nav-link::after {
                    content: '';
                    position: absolute;
                    bottom: -5px;
                    left: 50%;
                    width: 0;
                    height: 2px;
                    background: var(--primary-gradient);
                    transition: all 0.3s ease;
                    transform: translateX(-50%);
                }
                
                .nav-link:hover::after {
                    width: 20px;
                }
                
                /* Main Content */
                .main-content {
                    min-height: calc(100vh - 200px);
                }
                
                /* Hero Section */
                .hero-section {
                    background: var(--primary-gradient);
                    color: white;
                    padding: 6rem 0;
                    position: relative;
                    overflow: hidden;
                }
                
                .hero-section::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
                    opacity: 0.3;
                }
                
                .hero-stats .stat-item {
                    text-align: center;
                    padding: 1rem;
                    border-radius: 12px;
                    background: rgba(255, 255, 255, 0.1);
                    backdrop-filter: blur(10px);
                    transition: all 0.3s ease;
                }
                
                .hero-stats .stat-item:hover {
                    transform: translateY(-4px);
                    background: rgba(255, 255, 255, 0.15);
                }
                
                /* Category Cards */
                .category-card {
                    background: white;
                    border: 1px solid rgba(0, 0, 0, 0.05);
                    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                    cursor: pointer;
                    border-radius: 16px;
                    overflow: hidden;
                }
                
                .category-card:hover {
                    transform: translateY(-12px) scale(1.02);
                    box-shadow: var(--shadow-xl);
                    border-color: transparent;
                }
                
                /* Product Cards */
                .product-card {
                    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                    border-radius: 20px;
                    overflow: hidden;
                    background: white;
                    border: 1px solid rgba(0, 0, 0, 0.05);
                }
                
                .product-card:hover {
                    transform: translateY(-12px);
                    box-shadow: var(--shadow-xl);
                }
                
                .product-image {
                    border-radius: 20px 20px 0 0;
                    overflow: hidden;
                    position: relative;
                }
                
                .product-image img {
                    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
                }
                
                .product-card:hover .product-image img {
                    transform: scale(1.08);
                }
                
                .product-badge {
                    z-index: 2;
                }
                
                .product-rating i {
                    font-size: 0.9rem;
                }
                
                /* Buttons */
                .btn-primary {
                    background: var(--primary-gradient);
                    border: none;
                    font-weight: 600;
                    transition: all 0.3s ease;
                    border-radius: 50px;
                    padding: 12px 24px;
                }
                
                .btn-primary:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 12px 24px rgba(102, 126, 234, 0.4);
                }
                
                /* Footer */
                .modern-footer {
                    background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
                    color: #e2e8f0;
                    margin-top: 6rem;
                }
                
                .footer-brand .brand-gradient {
                    background: var(--primary-gradient);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }
                
                .footer-link {
                    color: #a0aec0;
                    text-decoration: none;
                    transition: all 0.3s ease;
                    font-weight: 400;
                }
                
                .footer-link:hover {
                    color: #667eea;
                    transform: translateX(4px);
                }
                
                .social-link {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 40px;
                    height: 40px;
                    background: rgba(255, 255, 255, 0.1);
                    border-radius: 50%;
                    color: #a0aec0;
                    text-decoration: none;
                    transition: all 0.3s ease;
                }
                
                .social-link:hover {
                    background: var(--primary-gradient);
                    color: white;
                    transform: translateY(-3px);
                }
                
                .text-white-50 {
                    color: rgba(255, 255, 255, 0.7) !important;
                }
                
                /* Responsive */
                @media (max-width: 768px) {
                    .hero-section {
                        padding: 4rem 0;
                    }
                    
                    .hero-stats {
                        flex-direction: column;
                        gap: 1rem;
                    }
                    
                    .product-card:hover {
                        transform: translateY(-6px);
                    }
                }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="/">
                <span class="brand-gradient">Promethex</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/contact">Contact</a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <a class="nav-link position-relative" href="/cart">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span class="position-absolute badge rounded-pill bg-primary" style="font-size: 0.7rem; padding: 0.25em 0.5em; top: -5px; right: -5px;">3</span>
                    </a>
                    <?php if (\Framework\Auth::check()): ?>
                        <div class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user fs-5"></i>
                                <span class="ms-1"><?= htmlspecialchars(\Framework\Auth::user()['name'] ?? 'User') ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/account"><i class="fas fa-user me-2"></i>My Account</a></li>
                                <li><a class="dropdown-item" href="/orders"><i class="fas fa-box me-2"></i>My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger" onclick="logout()">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="nav-link ms-3" href="/login">
                            <i class="fas fa-sign-in-alt fs-5"></i>
                            <span class="ms-1">Login</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        </nav>
        
    <!-- Main Content -->
    <main class="main-content">
            <?= $content ?>
    </main>
    
    <!-- Footer -->
    <footer class="modern-footer">
        <div class="container">
            <div class="row py-5">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand mb-3">
                        <span class="brand-gradient fs-3 fw-bold">Promethex</span>
                    </div>
                    <p class="text-muted mb-4">Your trusted destination for premium products and exceptional shopping experiences.</p>
                    <div class="social-links">
                        <a href="#" class="social-link me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Shop</h6>
                    <ul class="list-unstyled">
                        <li><a href="/products" class="footer-link">All Products</a></li>
                        <li><a href="/categories" class="footer-link">Categories</a></li>
                        <li><a href="/new-arrivals" class="footer-link">New Arrivals</a></li>
                        <li><a href="/best-sellers" class="footer-link">Best Sellers</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="/help" class="footer-link">Help Center</a></li>
                        <li><a href="/shipping" class="footer-link">Shipping Info</a></li>
                        <li><a href="/returns" class="footer-link">Returns</a></li>
                        <li><a href="/contact" class="footer-link">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Company</h6>
                    <ul class="list-unstyled">
                        <li><a href="/about" class="footer-link">About Us</a></li>
                        <li><a href="/careers" class="footer-link">Careers</a></li>
                        <li><a href="/press" class="footer-link">Press</a></li>
                        <li><a href="/partners" class="footer-link">Partners</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="/privacy" class="footer-link">Privacy Policy</a></li>
                        <li><a href="/terms" class="footer-link">Terms of Service</a></li>
                        <li><a href="/cookies" class="footer-link">Cookie Policy</a></li>
                        <li><a href="/security" class="footer-link">Security</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">&copy; <?= date('Y') ?> Promethex. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="payment-methods">
                        <span class="text-muted me-2">We accept:</span>
                        <i class="fab fa-cc-visa fs-4 me-2"></i>
                        <i class="fab fa-cc-mastercard fs-4 me-2"></i>
                        <i class="fab fa-cc-paypal fs-4 me-2"></i>
                        <i class="fab fa-cc-apple-pay fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            
            <script>
            async function logout() {
                try {
                    const response = await fetch('/api/auth/logout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        // Redirect to home page
                        window.location.href = '/';
                    } else {
                        console.error('Logout failed:', result.message);
                        // Still redirect on error
                        window.location.href = '/';
                    }
                } catch (error) {
                    console.error('Logout error:', error);
                    // Still redirect on error
                    window.location.href = '/';
                }
            }
            </script>
</body>
</html>
