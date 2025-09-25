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
        :root {
            /* Bootstrap theming using CSS custom properties only */
            --bs-border-color: #6c757d;
            --bs-border-width: 1px;
            --bs-border-style: solid;
        }
    </style>
    
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-lg">
    <div class="container">
            <a class="navbar-brand fw-bold text-white" href="/">
                <span class="text-white">Promethex Store</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <!-- Navigation links removed - categories shown as badges on homepage -->
                </ul>
                <div class="navbar-nav">
                    <a class="nav-link position-relative" href="/cart">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <?php 
                        $cartCount = \App\Models\Cart::getTotalItems();
                        if ($cartCount > 0): 
                        ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-danger mt-2" id="cart-count"><?= $cartCount ?></span>
                        <?php endif; ?>
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
    <footer class="bg-dark text-light">
        <div class="container">
            <div class="row py-5">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand mb-3">
                        <span class="text-primary fs-3 fw-bold">Promethex Store</span>
                    </div>
                    <p class="text-light mb-4">Your trusted destination for premium products and exceptional shopping experiences.</p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="/help" class="text-light text-decoration-none">Help Center</a></li>
                        <li><a href="/shipping" class="text-light text-decoration-none">Shipping Info</a></li>
                        <li><a href="/returns" class="text-light text-decoration-none">Returns</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="/privacy" class="text-light text-decoration-none">Privacy Policy</a></li>
                        <li><a href="/terms" class="text-light text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-light mb-0">&copy; <?= date('Y') ?> Joe Estrella. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="payment-methods">
                        <span class="text-light me-2">We accept:</span>
                        <i class="fab fa-cc-visa fs-4 me-2"></i>
                        <i class="fab fa-cc-mastercard fs-4 me-2"></i>
                        <i class="fab fa-cc-paypal fs-4 me-2"></i>
                        <i class="fab fa-cc-apple-pay fs-4"></i>
                    </div>
                </div>
        </div>
    </div>
    </footer>
    
    <!-- jQuery (required for Parsley.js) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Parsley.js Validation Library -->
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.css">
    
    <script>
    // Configure Parsley validation
    window.Parsley.setLocale('en');
    window.Parsley.addValidator('rating', {
        requirementType: 'integer',
        validateNumber: function(value, requirement) {
            return value >= 1 && value <= 5;
        },
        messages: {
            en: 'Please select a rating between 1 and 5 stars'
        }
    });
    </script>
            
            <script>
            async function logout() {
                try {
                    const response = await fetch('/logout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    });
                    
                    // Always redirect to home page after logout
                    window.location.href = '/';
                } catch (error) {
                    console.error('Logout error:', error);
                    // Still redirect on error
                    window.location.href = '/';
                }
            }
            </script>
</body>
</html>
