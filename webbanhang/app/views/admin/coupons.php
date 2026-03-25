<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Hệ Thống Khuyến Mãi</h4>
        <button class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addCouponModal">
            <i class="bi bi-plus-lg me-1"></i> Tạo Mã Mới
        </button>
    </div>

    <div class="row g-4">
        <?php foreach($coupons as $c): ?>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 position-relative" style="background: linear-gradient(135deg, #ffffff, #f8fafc);">
                <div class="position-absolute top-0 end-0 p-3">
                    <span class="badge <?php echo $c->status === 'active' ? 'bg-success' : 'bg-secondary'; ?> rounded-pill px-3">
                        <?php echo strtoupper($c->status); ?>
                    </span>
                </div>
                <h3 class="fw-bold text-warning mb-1"><?php echo $c->discount_percent; ?>% OFF</h3>
                <div class="bg-light p-2 rounded-2 text-center border-dashed border-2 mb-3" style="border: 2px dashed #e2e8f0;">
                    <span class="fw-bold tracking-widest fs-5 text-dark"><?php echo $c->code; ?></span>
                </div>
                <div class="text-muted small mb-3">
                    <i class="bi bi-calendar-event me-1"></i> Hết hạn: <?php echo $c->expires_at ?: 'Không thời hạn'; ?>
                </div>
                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                    <small class="text-muted">ID: #<?php echo $c->id; ?></small>
                    <button class="btn btn-sm btn-outline-danger border-0">
                        <i class="bi bi-trash"></i> Xóa
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Add Coupon Modal (Simplified) -->
<div class="modal fade" id="addCouponModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="fw-bold">Tạo Mã Giảm Giá Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/webbanhang/Admin/addCoupon" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mã Code</label>
                        <input type="text" name="code" class="form-control bg-light border-0" placeholder="VD: SUMMER24" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Phần Trăm Giảm (%)</label>
                        <input type="number" name="discount" class="form-control bg-light border-0" min="1" max="100" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Ngày Hết Hạn</label>
                        <input type="date" name="expires_at" class="form-control bg-light border-0">
                    </div>
                    <button type="submit" class="btn btn-warning w-100 rounded-pill py-3 fw-bold">Xác Nhận Tạo</button>
                </form>
            </div>
        </div>
    </div>
</div>
