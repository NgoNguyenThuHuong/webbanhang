<?php
// Layout cho trang lịch sử đơn hàng của khách
?>
<div class="py-4">
    <!-- Page Header Area -->
    <div class="row mb-5 align-items-end">
        <div class="col-md-6">
            <h2 class="fw-black mb-1" style="letter-spacing: -1px; color: var(--primary-emerald);">Lịch Sử Mua Sắm</h2>
            <p class="text-muted mb-0">Theo dõi và quản lý tất cả đơn hàng của bạn</p>
        </div>
        <div class="col-md-6 text-md-end pt-3 pt-md-0">
            <span class="badge bg-white text-emerald border px-3 py-2 rounded-pill shadow-sm">
                <i class="bi bi-bag-check-fill me-2"></i> <?php echo count($orders); ?> Đơn hàng
            </span>
        </div>
    </div>

    <?php if (empty($orders)): ?>
        <div class="text-center py-5 bg-white rounded-5 shadow-sm border border-dashed">
            <div class="mb-4">
                <i class="bi bi-cart-x" style="font-size: 5rem; color: #e2e8f0;"></i>
            </div>
            <h4 class="fw-bold">Bạn chưa có đơn đặt hàng nào</h4>
            <p class="text-muted mb-4">Hãy bắt đầu hành trình mua sắm của bạn ngay hôm nay!</p>
            <a href="/webbanhang/Product" class="btn btn-emerald btn-premium px-5 py-3">
                <i class="bi bi-shop me-2"></i> KHÁM PHÁ CỬA HÀNG
            </a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($orders as $order): ?>
                <?php
                $status_config = [
                    'pending'   => ['icon' => 'bi-clock-history', 'color' => '#f59e0b', 'bg' => '#fffbeb', 'text' => 'Chờ xử lý'],
                    'confirmed' => ['icon' => 'bi-check2-circle', 'color' => '#0ea5e9', 'bg' => '#f0f9ff', 'text' => 'Đã xác nhận'],
                    'shipping'  => ['icon' => 'bi-truck', 'color' => '#8b5cf6', 'bg' => '#f5f3ff', 'text' => 'Đang giao hàng'],
                    'done'      => ['icon' => 'bi-bag-check', 'color' => '#10b981', 'bg' => '#f0fdf4', 'text' => 'Hoàn thành'],
                    'cancelled' => ['icon' => 'bi-x-circle', 'color' => '#ef4444', 'bg' => '#fef2f2', 'text' => 'Đã hủy']
                ];
                $cfg = $status_config[$order->status] ?? $status_config['pending'];
                ?>
                <div class="col-12">
                    <div class="order-card-luxury position-relative overflow-hidden">
                        <div class="row g-0">
                            <!-- Side Decoration -->
                            <div class="col-auto d-none d-md-block" style="width: 8px; background: <?php echo $cfg['color']; ?>;"></div>
                            
                            <div class="col p-4 p-lg-5">
                                <div class="d-flex flex-wrap justify-content-between align-items-start gap-4 mb-4">
                                    <div>
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <span class="fw-black fs-4 text-dark">#<?php echo $order->id; ?></span>
                                            <span class="badge rounded-pill px-3 py-2 fw-bold d-flex align-items-center gap-2" 
                                                  style="background: <?php echo $cfg['bg']; ?>; color: <?php echo $cfg['color']; ?>; border: 1px solid <?php echo $cfg['color']; ?>33;">
                                                <i class="bi <?php echo $cfg['icon']; ?>"></i> <?php echo $cfg['text']; ?>
                                            </span>
                                        </div>
                                        <div class="text-muted small fw-medium">
                                            <i class="bi bi-calendar3 me-1"></i> Ngày đặt: <?php echo date('d/m/Y - H:i', strtotime($order->created_at)); ?>
                                        </div>
                                    </div>
                                    <div class="text-md-end">
                                        <div class="text-muted small text-uppercase fw-bold mb-1" style="letter-spacing: 1px;">Tổng thanh toán</div>
                                        <div class="fw-black fs-3" style="color: var(--primary-emerald);"><?php echo number_format($order->total_price, 0, ',', '.'); ?>đ</div>
                                    </div>
                                </div>

                                <div class="row align-items-center mt-auto border-top pt-4">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-stack">
                                                <div class="bg-light rounded-circle border d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                    <i class="bi bi-box-seam text-muted"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">Giao đến: <?php echo htmlspecialchars($order->fullname); ?></div>
                                                <div class="text-muted small text-truncate" style="max-width: 300px;">
                                                    <i class="bi bi-geo-alt me-1"></i> <?php echo htmlspecialchars($order->address); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end mt-3 mt-md-0">
                                        <a href="/webbanhang/Order/success/<?php echo $order->id; ?>" class="btn btn-emerald-outline rounded-pill px-4 py-2 fw-bold w-100 w-md-auto">
                                            XEM CHI TIẾT <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .fw-black { font-weight: 900; }
    
    .order-card-luxury {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 10px 30px -5px rgba(0,0,0,0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.03);
    }
    
    .order-card-luxury:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);
        border-color: var(--primary-emerald);
    }
    
    .btn-emerald-outline {
        background: transparent;
        color: var(--primary-emerald);
        border: 2px solid var(--primary-emerald);
        transition: all 0.3s;
    }
    
    .btn-emerald-outline:hover {
        background: var(--primary-emerald);
        color: #fff;
        transform: scale(1.05);
    }
    
    /* Animation cho list */
    .order-card-luxury {
        animation: slideUp 0.5s ease backwards;
    }
    
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>
