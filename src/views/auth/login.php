<!-- Login Form -->
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

                    <form id="loginForm" method="POST">
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

                        <div class="mb-4">
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    id="remember" 
                                    name="remember"
                                >
                                <label class="form-check-label text-muted" for="remember">
                                    Remember me
                                </label>
                            </div>
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

                    <div class="text-center mt-3">
                        <a href="/forgot-password" class="text-muted small text-decoration-none">
                            Forgot your password?
                        </a>
                    </div>
                </div>
            </div>

            <!-- Demo Credentials -->
            <div class="card mt-4 border-0 bg-light">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-secondary mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Demo Credentials
                    </h6>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block">Admin User</small>
                            <code class="small">admin@promethex.com</code>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Password</small>
                            <code class="small">admin123</code>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block">Regular User</small>
                            <code class="small">john.doe@example.com</code>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Password</small>
                            <code class="small">password123</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const loginBtn = document.getElementById('loginBtn');
    const btnText = loginBtn.querySelector('.btn-text');
    const originalText = btnText.textContent;
    
    // Show loading state
    loginBtn.disabled = true;
    btnText.textContent = 'Signing In...';
    
    // Get form data
    const formData = new FormData(this);
    const data = {
        email: formData.get('email'),
        password: formData.get('password'),
        remember: formData.get('remember') === 'on'
    };
    
    try {
        const response = await fetch('/api/auth/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Show success message
            showAlert('success', 'Login successful! Redirecting...');
            
            // Redirect to home page
            setTimeout(() => {
                window.location.href = '/';
            }, 1000);
        } else {
            // Show error message
            showAlert('danger', result.message);
        }
    } catch (error) {
        showAlert('danger', 'An error occurred. Please try again.');
    } finally {
        // Reset button state
        loginBtn.disabled = false;
        btnText.textContent = originalText;
    }
});

function showAlert(type, message) {
    // Remove existing alerts
    const existingAlert = document.querySelector('.alert');
    if (existingAlert) {
        existingAlert.remove();
    }
    
    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert after the title
    const titleDiv = document.querySelector('.text-center.mb-4');
    titleDiv.insertAdjacentElement('afterend', alertDiv);
}
</script>
