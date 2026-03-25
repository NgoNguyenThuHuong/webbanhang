<div class="row justify-content-center py-5">
    <div class="col-lg-8">
        <?php 
        // Kiểm tra xem đây là trang vừa đặt xong hay xem lại
        $is_new_order = !isset($_GET['revisit']); // Giả sử hoặc check session
        ?>
        
        <!-- Header Section -->
        <div class="text-center mb-5">
            <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle text-white mb-4 shadow-lg animate-pop"
                 style="width:80px;height:80px;background:linear-gradient(135deg,#10b981,#065f46);font-size:2rem;">
                <i class="bi bi-check2-all"></i>
            </div>
            <h1 class="fw-black mb-2" style="color: var(--primary-emerald);">
                <?php echo $is_new_order ? 'Đặt hàng thành công!' : 'Chi Tiết Đơn Hàng'; ?>
            </h1>
            <p class="text-muted fs-6">Mã định danh đơn hàng: <span class="fw-bold text-dark">#<?php echo $order->id; ?></span></p>
        </div>

        <div class="row g-4">
            <!-- Left: Info -->
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5 h-100 bg-white">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i class="bi bi-person-badge text-emerald"></i> Thông Tin Nhận Hàng
                    </h5>
                    
                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex gap-3">
                            <div class="text-muted"><i class="bi bi-person"></i></div>
                            <div>
                                <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Họ và tên</div>
                                <div class="fw-bold"><?php echo htmlspecialchars($order->fullname); ?></div>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="text-muted"><i class="bi bi-telephone"></i></div>
                            <div>
                                <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Số điện thoại</div>
                                <div class="fw-bold"><?php echo htmlspecialchars($order->phone); ?></div>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="text-muted"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Địa chỉ</div>
                                <div class="fw-bold"><?php echo htmlspecialchars($order->address); ?></div>
                            </div>
                        </div>
                    </div>

                    <?php if ($order->note): ?>
                        <div class="mt-4 p-3 rounded-3 bg-light border-start border-4 border-warning">
                            <div class="small fw-bold text-muted mb-1 text-uppercase" style="font-size: 0.65rem;">Ghi chú</div>
                            <div class="small italic text-dark"><?php echo htmlspecialchars($order->note); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right: Items Summary -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i class="bi bi-box-seam text-emerald"></i> Sản Phẩm Đã Mua
                    </h5>
                    
                    <div class="d-flex flex-column gap-3 mb-4 max-vh-40 overflow-auto">
                        <?php foreach ($items as $item): ?>
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                            <div style="max-width: 70%;">
                                <div class="fw-bold small text-truncate"><?php echo htmlspecialchars($item->product_name); ?></div>
                                <div class="text-muted small">SL: <?php echo $item->quantity; ?> × <?php echo number_format($item->price, 0, ',', '.'); ?>đ</div>
                            </div>
                            <div class="fw-bold text-emerald small"><?php echo number_format($item->price * $item->quantity, 0, ',', '.'); ?>đ</div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-auto">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Phí vận chuyển</span>
                            <span class="text-success fw-bold small">FREE</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-black fs-5">TỔNG CỘNG</span>
                            <span class="fw-black fs-4 text-emerald"><?php echo number_format($order->total_price, 0, ',', '.'); ?>đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="/webbanhang/Order/index" class="btn btn-emerald btn-premium px-5 py-3 shadow">
                <i class="bi bi-arrow-left me-2"></i> QUAY LẠI DANH SÁCH
            </a>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .text-emerald { color: var(--primary-emerald); }
    .animate-pop { animation: popIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    @keyframes popIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<style>
@keyframes popIn {
    0% { transform: scale(0.5); opacity: 0; }
    70% { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
}
</style>
