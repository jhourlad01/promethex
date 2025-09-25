<!-- Login Page -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary mb-2">Welcome Back</h2>
                        <p class="text-muted">Sign in to your account</p>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form id="loginForm" method="POST" action="/login">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input 
                                    type="email" 
                                    class="form-control border-start-0" 
                                    id="email" 
                                    name="email" 
                                    placeholder="Enter your email"
                                    required
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input 
                                    type="password" 
                                    class="form-control border-start-0" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Enter your password"
                                    required
                                >
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold" id="loginBtn">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            <span class="btn-text">Sign In</span>
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">
                            Don't have an account? 
                            <a href="/register" class="text-primary fw-medium text-decoration-none">
                                Sign up here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
