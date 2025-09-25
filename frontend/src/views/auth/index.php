<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Promethex E-Commerce</title>
    
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
<body class="bg-light">
    <!-- Login Page -->
    <div class="min-vh-100 d-flex align-items-center">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-lg border-0 rounded-4">
                        <!-- Header Section -->
                        <div class="card-header bg-primary text-white text-center py-4 border-0 shadow-lg mb-2 border-bottom border-white border-3">
                            <div class="mb-3">
                                <i class="fas fa-store fs-1 text-white"></i>
                            </div>
                            <h2 class="fw-bold mb-2">Welcome Back</h2>
                            <p class="mb-0 opacity-75">Sign in to your Promethex account</p>
                        </div>
                        
                        <div class="card-body p-5">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <?= htmlspecialchars($error) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <form id="loginForm" method="POST" action="/login" data-parsley-validate>
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold text-dark">Email Address</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </span>
                                        <input 
                                            type="email" 
                                            class="form-control border-start-0" 
                                            id="email" 
                                            name="email" 
                                            placeholder="Enter your email"
                                            required
                                            data-parsley-type="email"
                                            data-parsley-required-message="Please enter your email address"
                                            data-parsley-type-message="Please enter a valid email address"
                                        >
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold text-dark">Password</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-primary"></i>
                                        </span>
                                        <input 
                                            type="password" 
                                            class="form-control border-start-0" 
                                            id="password" 
                                            name="password" 
                                            placeholder="Enter your password"
                                            required
                                            data-parsley-minlength="6"
                                            data-parsley-required-message="Please enter your password"
                                            data-parsley-minlength-message="Password must be at least 6 characters"
                                        >
                                    </div>
                                </div>

                                <div class="mb-4 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label fw-medium" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="/forgot-password" class="text-primary fw-medium text-decoration-none">
                                        Forgot Password?
                                    </a>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-semibold mb-4" id="loginBtn">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    <span class="btn-text">Sign In</span>
                                </button>
                            </form>

                            <div class="text-center">
                                <p class="text-muted mb-2">
                                    Don't have an account? 
                                    <a href="/register" class="text-primary fw-semibold text-decoration-none">
                                        Create one here
                                    </a>
                                </p>
                                <p class="text-muted mb-0 mt-4">
                                    <a href="/" class="text-secondary fw-medium text-decoration-none">
                                        <i class="fas fa-arrow-left me-1"></i>Back to Home
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Simple loading state for form submission
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const loginBtn = document.getElementById('loginBtn');
    const btnText = loginBtn.querySelector('.btn-text');
    
    // Show loading state
    loginBtn.disabled = true;
    btnText.textContent = 'Signing In...';
    
    // Add spinner
    const spinner = document.createElement('span');
    spinner.className = 'spinner-border spinner-border-sm me-2';
    spinner.setAttribute('role', 'status');
    spinner.setAttribute('aria-hidden', 'true');
    loginBtn.insertBefore(spinner, btnText);
});

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert && alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    });
});
</script>
