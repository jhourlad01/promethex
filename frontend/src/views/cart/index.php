<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h2 mb-4">Shopping Cart</h1>
            
            <?php if ($cart['is_empty']): ?>
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h3 class="text-muted">Your cart is empty</h3>
                    <p class="text-muted mb-4">Add some products to get started!</p>
                    <a href="/" class="btn btn-primary">Continue Shopping</a>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead class="table-primary">
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col" class="text-end">Price</th>
                                                <th scope="col" class="text-center">Quantity</th>
                                                <th scope="col" class="text-end">Total</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cart['items'] as $item): ?>
                                                <tr data-product-id="<?= $item['product_id'] ?>">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?= htmlspecialchars($item['product']['primary_image']) ?>" 
                                                                 alt="<?= htmlspecialchars($item['product']['name']) ?>" 
                                                                 class="img-thumbnail me-3" 
                                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                                            <div>
                                                                <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($item['product']['name']) ?></h6>
                                                                <small class="text-muted">SKU: <?= htmlspecialchars($item['product']['sku'] ?? 'N/A') ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="fw-bold fs-6">$<?= number_format($item['price'], 2) ?></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group input-group-sm" style="width: 120px; margin: 0 auto;">
                                                            <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(<?= $item['product_id'] ?>, -1)">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" class="form-control text-center" 
                                                                   value="<?= $item['quantity'] ?>" 
                                                                   min="1" 
                                                                   onchange="updateQuantity(<?= $item['product_id'] ?>, this.value)">
                                                            <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(<?= $item['product_id'] ?>, 1)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="fw-bold fs-5 text-primary">$<?= number_format($item['total'], 2) ?></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-outline-danger btn-sm" onclick="removeItem(<?= $item['product_id'] ?>)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button class="btn btn-outline-secondary" onclick="clearCart()">
                                        <i class="fas fa-trash me-2"></i>Clear Cart
                                    </button>
                                    <a href="/" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Items (<?= $cart['total_items'] ?>):</span>
                                    <span>$<?= number_format($cart['total_amount'], 2) ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span class="text-success">Free</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong class="text-primary">$<?= number_format($cart['total_amount'], 2) ?></strong>
                                </div>
                                
                                <button class="btn btn-primary w-100 mb-2" onclick="proceedToCheckout()">
                                    <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                                </button>
                                
                                <small class="text-muted d-block text-center">
                                    <i class="fas fa-lock me-1"></i>Secure checkout
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Cart JavaScript functions
function changeQuantity(productId, change) {
    const input = document.querySelector(`tr[data-product-id="${productId}"] input[type="number"]`);
    const currentQuantity = parseInt(input.value);
    const newQuantity = currentQuantity + change;
    
    if (newQuantity < 1) {
        removeItem(productId);
        return;
    }
    
    updateQuantity(productId, newQuantity);
}

function updateQuantity(productId, newQuantity) {
    if (typeof newQuantity === 'string') {
        newQuantity = parseInt(newQuantity);
    }
    
    if (newQuantity < 1) {
        removeItem(productId);
        return;
    }
    
    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `product_id=${productId}&quantity=${newQuantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the input value
            const input = document.querySelector(`tr[data-product-id="${productId}"] input[type="number"]`);
            input.value = newQuantity;
            
            // Update the total price for this item
            const priceCell = document.querySelector(`tr[data-product-id="${productId}"] td:nth-child(4)`);
            const price = parseFloat(priceCell.querySelector('span').textContent.replace('$', ''));
            const newTotal = price * newQuantity;
            priceCell.querySelector('span').textContent = '$' + newTotal.toFixed(2);
            
            // Update cart summary
            updateCartSummary(data.cart_summary);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the cart');
    });
}

function removeItem(productId) {
    if (!confirm('Are you sure you want to remove this item from your cart?')) {
        return;
    }
    
    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `product_id=${productId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the row from the table
            const row = document.querySelector(`tr[data-product-id="${productId}"]`);
            row.remove();
            
            // Update cart summary
            updateCartSummary(data.cart_summary);
            
            // Check if cart is empty
            if (data.cart_summary.total_items === 0) {
                location.reload(); // Reload to show empty cart message
            }
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while removing the item');
    });
}

function clearCart() {
    if (!confirm('Are you sure you want to clear your entire cart?')) {
        return;
    }
    
    fetch('/cart/clear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to show empty cart
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while clearing the cart');
    });
}

function updateCartSummary(cartSummary) {
    // Update total items
    const totalItemsElement = document.querySelector('.card-body .d-flex.justify-content-between span:first-child');
    if (totalItemsElement) {
        totalItemsElement.textContent = `Items (${cartSummary.total_items}):`;
    }
    
    // Update total amount
    const totalAmountElements = document.querySelectorAll('.card-body .d-flex.justify-content-between span:last-child');
    totalAmountElements.forEach(element => {
        if (element.textContent.includes('$')) {
            element.textContent = '$' + cartSummary.total_amount.toFixed(2);
        }
    });
    
    // Update navbar cart count
    updateCartCount(cartSummary.total_items);
}

function updateCartCount(count) {
    const cartBadge = document.getElementById('cart-count');
    const cartLink = document.querySelector('a[href="/cart"]');
    
    if (count > 0) {
        if (cartBadge) {
            cartBadge.textContent = count;
        } else {
            // Create badge if it doesn't exist
            const badge = document.createElement('span');
            badge.id = 'cart-count';
            badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary';
            badge.textContent = count;
            cartLink.appendChild(badge);
        }
    } else {
        // Remove badge if count is 0
        if (cartBadge) {
            cartBadge.remove();
        }
    }
}
</script>
