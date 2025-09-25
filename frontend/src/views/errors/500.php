<?php
$title = $title ?? 'Error';
$message = $message ?? 'An error occurred';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="error-page">
                <h1 class="display-1 text-muted">500</h1>
                <h2 class="mb-4"><?= htmlspecialchars($title) ?></h2>
                <p class="lead text-muted mb-4"><?= htmlspecialchars($message) ?></p>
                <a href="/" class="btn btn-primary">Go Home</a>
            </div>
        </div>
    </div>
</div>
