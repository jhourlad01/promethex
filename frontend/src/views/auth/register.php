<!-- Server validation errors at the top -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Please correct the following errors:</strong>
        <ul class="mb-0 mt-2">
            <?php foreach ($errors as $field => $message): ?>
                <li><?= htmlspecialchars($message) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form id="registerForm" method="POST" action="/register">
    <div class="mb-4">
        <label for="name" class="form-label fw-semibold text-dark">Full Name</label>
        <div class="input-group input-group-lg">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-user text-primary"></i>
            </span>
            <input 
                type="text" 
                class="form-control border-start-0" 
                id="name" 
                name="name" 
                placeholder="Enter your full name"
                value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                required
            >
        </div>
    </div>

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
                value="<?= htmlspecialchars($old['email'] ?? '') ?>"
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
                placeholder="Create a strong password"
                autocomplete="new-password"
                required
            >
        </div>
    </div>

    <div class="mb-4">
        <label for="password_confirm" class="form-label fw-semibold text-dark">Confirm Password</label>
        <div class="input-group input-group-lg">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-lock text-primary"></i>
            </span>
            <input 
                type="password" 
                class="form-control border-start-0" 
                id="password_confirm" 
                name="password_confirm" 
                placeholder="Confirm your password"
                autocomplete="new-password"
                required
            >
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-semibold mb-4" id="registerBtn">
        <i class="fas fa-user-plus me-2"></i>
        <span class="btn-text">Create Account</span>
    </button>
</form>

<div class="text-center">
    <p class="text-muted mb-2">
        Already have an account? 
        <a href="/login" class="text-primary fw-semibold text-decoration-none">
            Sign in here
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

<style>
/* Simple CSS to position Just-Validate errors below inputs */
.just-validate-error-label {
    display: block !important;
    margin-top: 0.25rem !important;
    color: #dc3545 !important;
    font-size: 0.875rem !important;
    width: 100% !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Just-Validate
    const validation = new JustValidate('#registerForm');

    // Add validation rules
    validation
        .addField('#name', [
            {
                rule: 'required',
                errorMessage: 'Please enter your full name'
            },
            {
                rule: 'minLength',
                value: 2,
                errorMessage: 'Name must be at least 2 characters'
            },
            {
                rule: 'maxLength',
                value: 50,
                errorMessage: 'Name must not exceed 50 characters'
            }
        ])
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
                errorMessage: 'Please enter a password'
            },
            {
                rule: 'minLength',
                value: 8,
                errorMessage: 'Password must be at least 8 characters'
            },
            {
                rule: 'customRegexp',
                value: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/,
                errorMessage: 'Password must contain at least one uppercase letter, one lowercase letter, and one number'
            }
        ])
        .addField('#password_confirm', [
            {
                rule: 'required',
                errorMessage: 'Please confirm your password'
            },
            {
                rule: 'function',
                validator: function() {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('password_confirm').value;
                    return password === confirmPassword;
                },
                errorMessage: 'Passwords do not match'
            }
        ])
        .onSuccess((event) => {
            // Clear all error messages
            document.querySelectorAll('.invalid-feedback').forEach(div => {
                div.textContent = '';
                div.style.display = 'none';
            });
            
            // Show loading state
            const registerBtn = document.getElementById('registerBtn');
            const btnText = registerBtn.querySelector('.btn-text');
            
            registerBtn.disabled = true;
            btnText.textContent = 'Creating Account...';
            
            // Add spinner
            const spinner = document.createElement('span');
            spinner.className = 'spinner-border spinner-border-sm me-2';
            spinner.setAttribute('role', 'status');
            spinner.setAttribute('aria-hidden', 'true');
            registerBtn.insertBefore(spinner, btnText);
            
            // Submit the form
            event.target.submit();
        });

    // Reset button state if there are validation errors (page reload)
    const registerBtn = document.getElementById('registerBtn');
    const btnText = registerBtn.querySelector('.btn-text');
    const spinner = registerBtn.querySelector('.spinner-border');
    
    if (spinner) {
        spinner.remove();
        registerBtn.disabled = false;
        btnText.textContent = 'Create Account';
    }
    
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