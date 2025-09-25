<?php
// Product Reviews Partial
?>
<div class="">
    <?php if ($reviewStats['total_reviews'] > 0): ?>
        <!-- Review Summary -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="text-center p-4 bg-light rounded">
                    <div class="display-4 fw-bold text-primary mb-2"><?= $reviewStats['average_rating'] ?></div>
                    <div class="d-flex align-items-center mb-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= $reviewStats['average_rating']): ?>
                                <i class="fas fa-star text-warning"></i>
                            <?php else: ?>
                                <i class="far fa-star text-warning"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <p class="text-muted mb-0"><?= $reviewStats['total_reviews'] ?> Reviews</p>
                </div>
            </div>
            <div class="col-md-8">
                <h6 class="fw-bold mb-3">Rating Distribution</h6>
                <?php for ($rating = 5; $rating >= 1; $rating--): ?>
                    <?php 
                    $count = $reviewStats['rating_distribution'][$rating - 1];
                    ?>
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-2" style="width: 60px;">
                            <small><?= $rating ?> star<?= $rating > 1 ? 's' : '' ?></small>
                        </div>
                        <div class="flex-grow-1 me-2">
                            <small class="text-muted"><?= $count ?> review<?= $count != 1 ? 's' : '' ?></small>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="">
            <h6 class="fw-bold mb-3">Recent Reviews</h6>
            <?php foreach ($recentReviews as $review): ?>
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <?= $review->user->initials ?>
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold"><?= htmlspecialchars($review->user->name) ?></div>
                                <div class="text-muted small"><?= $review->formatted_date ?></div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="d-flex align-items-center mb-1">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?= $i <= $review->rating ? 'text-warning' : 'text-muted' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <div class="fw-bold"><?= htmlspecialchars($review->title) ?></div>
                        </div>
                    </div>
                    <p class="mb-2"><?= htmlspecialchars($review->comment) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">No reviews yet. Be the first to review this product!</p>
    <?php endif; ?>

    <!-- Write a Review Section -->
    <div class="p-4 rounded shadow-sm mb-4 bg-light">
        <h5 class="fw-bold mb-3">Write a Review</h5>
        <form id="reviewForm" class="needs-validation" novalidate>
            <input type="hidden" id="reviewProductId" value="<?= $product->id ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="reviewRating" class="form-label">Rating *</label>
                    <div class="">
                        <div class="d-flex gap-1">
                           <i class="fas fa-star text-muted" data-rating="1"></i>
                           <i class="fas fa-star text-muted" data-rating="2"></i>
                           <i class="fas fa-star text-muted" data-rating="3"></i>
                           <i class="fas fa-star text-muted" data-rating="4"></i>
                           <i class="fas fa-star text-muted" data-rating="5"></i>
                        </div>
                        <input type="hidden" id="reviewRating" name="rating" required>
                        <div class="invalid-feedback">Please select a rating.</div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="reviewTitle" class="form-label">Review Title *</label>
                    <input type="text" class="form-control" id="reviewTitle" name="title" required>
                    <div class="invalid-feedback">Please provide a review title.</div>
                </div>
            </div>
            <div class="mb-3">
                <label for="reviewComment" class="form-label">Your Review *</label>
                <textarea class="form-control" id="reviewComment" name="comment" rows="4" required></textarea>
                <div class="invalid-feedback">Please provide your review.</div>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
</div>
