<?php include 'app/views/shares/header.php'; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h2 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>Giỏ hàng của bạn</h2>
            
            <?php if (empty($cart)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-basket display-1 text-muted opacity-25"></i>
                    <p class="mt-3 text-muted">Giỏ hàng đang trống.</p>
                    <a href="/webbanhang/Product/index" class="btn btn-primary rounded-pill px-4">Tiếp tục mua sắm</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total_price = 0; ?>
                            <?php foreach ($cart as $id => $item): ?>
                                <?php $subtotal = $item['price'] * $item['quantity']; ?>
                                <?php $total_price += $subtotal; ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="/webbanhang/<?php echo $item['image']; ?>" class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            <span class="fw-bold"><?php echo htmlspecialchars($item['name']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                                    <td>
                                        <form action="/webbanhang/Product/updateCart/<?php echo $id; ?>" method="POST" class="d-flex align-items-center" style="max-width: 120px;">
                                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" class="form-control form-control-sm rounded-3 text-center" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="fw-bold text-primary"><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</td>
                                    <td>
                                        <a href="/webbanhang/Product/removeFromCart/<?php echo $id; ?>" class="text-danger"><i class="bi bi-x-circle-fill"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
            <h4 class="fw-bold mb-4">Tóm tắt đơn hàng</h4>
            <div class="d-flex justify-content-between mb-2">
                <span>Tạm tính:</span>
                <span class="fw-bold"><?php echo number_format($total_price ?? 0, 0, ',', '.'); ?> đ</span>
            </div>
            <div class="d-flex justify-content-between mb-4">
                <span>Phí vận chuyển:</span>
                <span class="text-success fw-bold">Miễn phí</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-4">
                <span class="fs-5 fw-bold">Tổng cộng:</span>
                <span class="fs-4 fw-bold text-danger"><?php echo number_format($total_price ?? 0, 0, ',', '.'); ?> đ</span>
            </div>
            <?php if (!empty($cart)): ?>
            <a href="/webbanhang/Order/checkout" 
               class="btn btn-lg w-100 rounded-pill fw-bold shadow-sm text-white"
               style="background:linear-gradient(135deg,#065f46,#10b981);border:none;letter-spacing:0.03em;">
                TIẾN HÀNH ĐẶT HÀNG →
            </a>
            <?php else: ?>
            <button class="btn btn-lg w-100 rounded-pill fw-bold" disabled
                    style="background:#e2e8f0;color:#94a3b8;border:none;">
                TIẾN HÀNH ĐẶT HÀNG
            </button>
            <?php endif; ?>
            <a href="/webbanhang/Product/index" class="btn btn-link w-100 text-muted mt-2 text-decoration-none">Quay lại mua sắm</a>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>