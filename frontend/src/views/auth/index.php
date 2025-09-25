<?php // frontend/src/views/auth/index.php ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form id="loginForm" method="POST" action="/login">
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

<!-- Just-Validate (modern, jQuery-free validation) -->
<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Just-Validate
    const validation = new JustValidate('#loginForm', {
        errorFieldCssClass: 'is-invalid',
        errorLabelCssClass: 'text-danger small mt-1',
        successFieldCssClass: 'is-valid',
        focusInvalidField: true,
        lockForm: true,
        errorLabelStyle: {
            color: '#dc3545',
            fontSize: '0.875rem',
            marginTop: '0.25rem',
            display: 'block'
        },
        errorLabelPosition: 'bottom'
    });

    // Add validation rules
    validation
        .addField('#email', [
            {
                rule: 'required',
                errorMessage: 'Please enter your email address'
            },
            {
                rule: 'email',
                errorMessage: 'Please enter a valid email address'
            }
        ])
        .addField('#password', [
            {
                rule: 'required',
                errorMessage: 'Please enter your password'
            },
            {
                rule: 'minLength',
                value: 6,
                errorMessage: 'Password must be at least 6 characters'
            }
        ])
        .onSuccess((event) => {
            // Show loading state
            const loginBtn = document.getElementById('loginBtn');
            const btnText = loginBtn.querySelector('.btn-text');
            
            loginBtn.disabled = true;
            btnText.textContent = 'Signing In...';
            
            // Add spinner
            const spinner = document.createElement('span');
            spinner.className = 'spinner-border spinner-border-sm me-2';
            spinner.setAttribute('role', 'status');
            spinner.setAttribute('aria-hidden', 'true');
            loginBtn.insertBefore(spinner, btnText);
            
            // Submit the form
            event.target.submit();
        });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert && alert.parentNode) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    });
});
</script>