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
<body class="bg-secondary">
    <!-- Auth Page Container -->
    <div class="min-vh-100 d-flex align-items-center">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-lg border-0 rounded-4">
                        <!-- Header Section -->
                        <div class="card-header bg-primary text-white text-center py-4 border-0 shadow-lg mb-2 border-bottom border-white border-3">
                            <div class="mb-3">
                                <?php if (isset($header_icon)): ?>
                                    <i class="<?= htmlspecialchars($header_icon) ?> fs-1 text-white"></i>
                                <?php else: ?>
                                    <i class="fas fa-store fs-1 text-white"></i>
                                <?php endif; ?>
                            </div>
                            <h2 class="fw-bold mb-2"><?= htmlspecialchars($header_title ?? 'Welcome') ?></h2>
                            <p class="mb-0 opacity-75"><?= htmlspecialchars($header_subtitle ?? 'Promethex E-Commerce') ?></p>
                        </div>
                        
                        <div class="card-body p-5">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>