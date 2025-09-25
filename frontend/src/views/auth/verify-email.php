<?php // frontend/src/views/auth/verify-email.php ?>

<div class="text-center">
    <p class="lead mb-4">
        <?= htmlspecialchars($message ?? 'Please check your email inbox at ') ?>
        <strong class="text-primary"><?= htmlspecialchars($email ?? 'your email address') ?></strong>
        to verify your account.
    </p>
    <p class="text-muted mb-0">
        Didn't receive the email? Check your spam folder or
        <a href="/resend-verification" class="text-primary fw-semibold text-decoration-none">resend it</a>.
    </p>
    <p class="text-muted mb-0 mt-4">
        <a href="/" class="text-secondary fw-medium text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i>Back to Home
        </a>
    </p>
</div>