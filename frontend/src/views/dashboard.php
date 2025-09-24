<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h1 class="card-title text-center mb-4">Dashboard</h1>
                    <p class="text-center text-muted mb-4">Welcome back, <?= htmlspecialchars($user['name'] ?? 'User') ?>!</p>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-shopping-cart fa-2x mb-3"></i>
                                    <h5>Orders</h5>
                                    <p class="mb-0">View your order history</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-user fa-2x mb-3"></i>
                                    <h5>Profile</h5>
                                    <p class="mb-0">Manage your account</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
