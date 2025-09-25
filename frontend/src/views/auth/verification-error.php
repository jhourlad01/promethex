<?php // frontend/src/views/auth/verification-error.php ?>

<div class="text-center">
    <p class="lead mb-4 text-danger">
        <?= htmlspecialchars($message ?? 'The email verification link is invalid or has expired.') ?>
    </p>
    <p class="text-muted mb-0">
        Please try registering again or contact support if the issue persists.
    </p>
    <p class="text-muted mb-0 mt-4">
        <a href="/register" class="btn btn-primary fw-medium text-decoration-none">
            <i class="fas fa-user-plus me-1"></i>Register Again
        </a>
        <a href="/" class="btn btn-secondary fw-medium text-decoration-none ms-2">
            <i class="fas fa-arrow-left me-1"></i>Back to Home
        </a>
    </p>
</div>