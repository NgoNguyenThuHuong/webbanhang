<div class="row g-5 py-3">
    <!-- Form thông tin giao hàng -->
    <div class="col-lg-7">
        <div class="d-flex align-items-center gap-3 mb-4">
            <div style="width:4px;height:32px;background:#10b981;border-radius:50px;"></div>
            <h3 class="fw-bold m-0">Thông Tin Giao Hàng</h3>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="alert border-0 rounded-4 mb-4 p-4" style="background:#fef2f2; color:#991b1b;">
            <ul class="mb-0 ps-3">
                <?php foreach ($errors as $error): ?>
                    <li class="fw-semibold small"><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form action="/webbanhang/Order/placeOrder" method="POST">
            <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:20px;">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-uppercase text-muted mb-2" style="letter-spacing:0.05em;">Họ và tên người nhận *</label>
                        <input type="text" name="fullname" class="form-control bg-light border-0 py-3 rounded-3"
                               placeholder="Nguyễn Văn A"
                               value="<?php echo htmlspecialchars($_SESSION['fullname'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted mb-2" style="letter-spacing:0.05em;">Số điện thoại *</label>
                        <input type="tel" name="phone" class="form-control bg-light border-0 py-3 rounded-3"
                               placeholder="0901 234 567" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted mb-2" style="letter-spacing:0.05em;">Email</label>
                        <input type="email" name="email" class="form-control bg-light border-0 py-3 rounded-3"
                               placeholder="email@example.com">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-uppercase text-muted mb-2" style="letter-spacing:0.05em;">Địa chỉ giao hàng *</label>
                        <input type="text" name="address" class="form-control bg-light border-0 py-3 rounded-3"
                               placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-uppercase text-muted mb-2" style="letter-spacing:0.05em;">Ghi chú cho đơn hàng</label>
                        <textarea name="note" class="form-control bg-light border-0 rounded-3" rows="3"
                                  placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi giao..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:20px;">
                <h5 class="fw-bold mb-4">Phương thức thanh toán</h5>
                <div class="d-flex flex-column gap-3">
                    <label class="d-flex align-items-center gap-3 p-3 rounded-3 border border-2" style="cursor:pointer; border-color:#10b981 !important; background:#f0fdf4;">
                        <input type="radio" name="payment" value="cod" checked class="form-check-input m-0" style="width:20px;height:20px;accent-color:#065f46;">
                        <div>
                            <div class="fw-bold">💵 Thanh toán khi nhận hàng (COD)</div>
                            <div class="small text-muted">Trả tiền mặt khi shipper giao hàng đến tay bạn</div>
                        </div>
                    </label>
                    <label class="d-flex align-items-center gap-3 p-3 rounded-3 border" style="cursor:pointer;">
                        <input type="radio" name="payment" value="bank" class="form-check-input m-0" style="width:20px;height:20px;accent-color:#065f46;">
                        <div>
                            <div class="fw-bold">🏦 Chuyển khoản ngân hàng</div>
                            <div class="small text-muted">Chuyển khoản sau khi đặt hàng, đơn hàng sẽ được duyệt trong 30 phút</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Hidden fields for coupon code -->
            <input type="hidden" name="coupon_code" id="hidden_coupon_code">
            
            <button type="submit" class="btn w-100 py-4 fw-bold fs-5 text-white shadow" 
                    style="background:linear-gradient(135deg,#065f46,#10b981);border:none;border-radius:16px;letter-spacing:0.05em;transition:all 0.3s;"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 20px 40px rgba(6,95,70,0.3)';"
                    onmouseout="this.style.transform='none';this.style.boxShadow='';">
                ✅ XÁC NHẬN ĐẶT HÀNG
            </button>
        </form>
    </div>

    <!-- Tóm tắt đơn hàng -->
    <div class="col-lg-5">
        <div class="sticky-top" style="top:90px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width:4px;height:32px;background:#10b981;border-radius:50px;"></div>
                <h3 class="fw-bold m-0">Đơn Hàng</h3>
            </div>
            <div class="card border-0 shadow-sm p-4" style="border-radius:20px;">
                <div class="d-flex flex-column gap-3 mb-4">
                    <?php foreach ($cart as $id => $item): ?>
                    <div class="d-flex align-items-center gap-3">
                        <div class="position-relative">
                            <img src="<?php echo htmlspecialchars($item['image'] ?? ''); ?>"
                                 style="width:60px;height:60px;object-fit:contain;background:#f8fafc;border-radius:12px;padding:4px;"
                                 onerror="this.src='https://via.placeholder.com/60x60?text=SP';">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle text-white"
                                  style="background:#065f46;font-size:0.65rem;width:20px;height:20px;display:flex;align-items:center;justify-content:center;">
                                <?php echo $item['quantity']; ?>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold small" style="line-height:1.3;"><?php echo htmlspecialchars($item['name']); ?></div>
                        </div>
                        <div class="fw-bold small text-nowrap" style="color:#065f46;">
                            <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <hr class="my-3">
                
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-2">Mã giảm giá</label>
                    <div class="input-group">
                        <input type="text" name="coupon_code" id="coupon_code" class="form-control bg-light border-0 py-2" placeholder="Nhập mã giảm giá...">
                        <button class="btn btn-dark px-3 fw-bold" type="button" id="apply_coupon">Áp dụng</button>
                    </div>
                    <div id="coupon_message" class="small mt-2"></div>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tạm tính</span>
                    <span class="fw-semibold" id="subtotal"><?php echo number_format($total, 0, ',', '.'); ?>đ</span>
                </div>
                <div class="d-flex justify-content-between mb-2 d-none" id="discount_row">
                    <span class="text-muted">Giảm giá (<span id="discount_percent">0</span>%)</span>
                    <span class="fw-bold text-danger">-<span id="discount_amount">0</span>đ</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Phí vận chuyển</span>
                    <span class="fw-bold text-success">Miễn phí</span>
                </div>
                <hr class="my-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-5">Tổng cộng</span>
                    <span class="fw-bold fs-4" id="final_total" style="color:#065f46;"><?php echo number_format($total, 0, ',', '.'); ?>đ</span>
                </div>

                <div class="mt-4 p-3 rounded-3 d-flex align-items-center gap-3" style="background:#f0fdf4;border:1px dashed #10b981;">
                    <i class="bi bi-truck fs-4 text-success"></i>
                    <div class="small">
                        <div class="fw-bold text-success">Giao hàng miễn phí</div>
                        <div class="text-muted">Dự kiến giao trong 2-3 ngày làm việc</div>
                    </div>
                </div>
            </div>

            <a href="/webbanhang/Product/cart" class="btn w-100 mt-3 text-muted text-decoration-none" style="font-size:0.9rem;">
                ← Quay lại giỏ hàng
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('apply_coupon').addEventListener('click', function() {
    const code = document.getElementById('coupon_code').value.trim();
    const messageDiv = document.getElementById('coupon_message');
    const btn = this;
    
    if (code === '') {
        messageDiv.innerHTML = '<span class="text-danger small">Vui lòng nhập mã!</span>';
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    const formData = new FormData();
    formData.append('code', code);

    fetch('/webbanhang/Order/checkCoupon', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = 'Áp dụng';

        if (data.success) {
            messageDiv.innerHTML = '<span class="text-success small fw-bold"><i class="bi bi-check-circle-fill"></i> ' + data.message + '</span>';
            
            // Đồng bộ mã vào form chính
            document.getElementById('hidden_coupon_code').value = code;

            const subtotal = <?php echo $total; ?>;
            const discountPercent = data.discount;
            const discountAmount = Math.floor(subtotal * (discountPercent / 100));
            const finalTotal = subtotal - discountAmount;

            document.getElementById('discount_row').classList.remove('d-none');
            document.getElementById('discount_percent').innerText = discountPercent;
            document.getElementById('discount_amount').innerText = discountAmount.toLocaleString('vi-VN');
            document.getElementById('final_total').innerText = finalTotal.toLocaleString('vi-VN') + 'đ';
        } else {
            messageDiv.innerHTML = '<span class="text-danger small">' + data.message + '</span>';
            document.getElementById('discount_row').classList.add('d-none');
            document.getElementById('final_total').innerText = (<?php echo $total; ?>).toLocaleString('vi-VN') + 'đ';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.disabled = false;
        btn.innerHTML = 'Áp dụng';
        messageDiv.innerHTML = '<span class="text-danger small">Đã có lỗi xảy ra.</span>';
    });
});
</script>
