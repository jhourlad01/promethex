<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h1 class="card-title text-center mb-4">Profile</h1>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Name</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['name'] ?? '') ?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Email</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Role</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['role'] ?? '') ?>" readonly>
                    </div>
                    
                    <div class="text-center">
                        <a href="/dashboard" class="btn btn-primary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
