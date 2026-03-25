<div class="py-4">
    <!-- Header Admin Section -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-xl-6">
            <h2 class="fw-black mb-1" style="letter-spacing: -1px; color: var(--text-main);">Quản Lý Đơn Hàng</h2>
            <p class="text-muted mb-0">Hệ thống xử lý và theo dõi giao dịch toàn cầu</p>
        </div>
        <div class="col-12 col-xl-6">
            <div class="row g-3">
                <div class="col-sm-4">
                    <div class="card border-0 shadow-sm p-3 rounded-4 bg-white">
                        <div class="small text-muted fw-bold text-uppercase mb-1" style="font-size:0.65rem;">Tổng Doanh Thu</div>
                        <div class="h5 fw-black text-emerald mb-0"><?php echo number_format($stats['total_revenue'], 0, ',', '.'); ?>đ</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card border-0 shadow-sm p-3 rounded-4 bg-white">
                        <div class="small text-muted fw-bold text-uppercase mb-1" style="font-size:0.65rem;">Chờ Xử Lý</div>
                        <div class="h5 fw-black text-warning mb-0"><?php echo $stats['pending_count']; ?></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card border-0 shadow-sm p-3 rounded-4 bg-white border-start border-4 border-success">
                        <div class="small text-muted fw-bold text-uppercase mb-1" style="font-size:0.65rem;">Hoàn Thành</div>
                        <div class="h5 fw-black text-dark mb-0"><?php echo $stats['done_count']; ?> / <?php echo $stats['all_count']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($orders)): ?>
        <div class="text-center py-5 bg-white rounded-5 shadow-sm border border-dashed">
            <div class="mb-4">
                <i class="bi bi-inbox" style="font-size: 5rem; color: #e2e8f0;"></i>
            </div>
            <h4 class="fw-bold">Chưa có dữ liệu đơn hàng</h4>
            <p class="text-muted">Hệ thống sẽ hiển thị đơn hàng khi có khách hàng thực hiện thanh toán.</p>
        </div>
    <?php else: ?>
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-4 fw-bold text-muted small text-uppercase" width="50">#</th>
                        <th class="py-4 fw-bold text-muted small text-uppercase">Khách hàng / SĐT</th>
                        <th class="py-4 fw-bold text-muted small text-uppercase">Địa chỉ giao hàng</th>
                        <th class="py-4 fw-bold text-muted small text-uppercase" width="150">Tổng tiền</th>
                        <th class="py-4 fw-bold text-muted small text-uppercase" width="200">Trạng thái</th>
                        <th class="py-4 fw-bold text-muted small text-uppercase text-center" width="100">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr class="order-row-main">
                        <td class="ps-4">
                            <span class="fw-bold text-dark">#<?php echo $order->id; ?></span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-soft-emerald rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;">
                                    <i class="bi bi-person text-emerald"></i>
                                </div>
                                <div>
                                    <div class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($order->fullname); ?></div>
                                    <div class="small text-muted"><?php echo htmlspecialchars($order->phone); ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-muted small lh-sm" style="max-width: 250px;">
                                <?php echo htmlspecialchars($order->address); ?>
                            </div>
                        </td>
                        <td>
                            <div class="fw-black text-emerald fs-5"><?php echo number_format($order->total_price, 0, ',', '.'); ?>đ</div>
                        </td>
                        <td>
                            <form action="/webbanhang/Order/updateStatus/<?php echo $order->id; ?>" method="POST" class="d-flex align-items-center gap-2">
                                <select name="status" class="form-select form-select-sm rounded-pill border-0 shadow-sm status-select-custom" 
                                        data-current="<?php echo $order->status; ?>">
                                    <?php
                                    $options = [
                                        'pending'   => '🕐 Chờ xử lý',
                                        'confirmed' => '✅ Xác nhận',
                                        'shipping'  => '🚚 Đang giao',
                                        'done'      => '🎉 Hoàn thành',
                                        'cancelled' => '❌ Hủy đơn',
                                    ];
                                    foreach ($options as $val => $label) {
                                        $selected = ($order->status === $val) ? 'selected' : '';
                                        echo "<option value='$val' $selected>$label</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit" class="btn-update-status">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <button class="btn-expand-order" type="button" data-bs-toggle="collapse" data-bs-target="#order-details-<?php echo $order->id; ?>">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Expandable Details Row -->
                    <tr>
                        <td colspan="6" class="p-0 border-0">
                            <div class="collapse order-details-collapse bg-light" id="order-details-<?php echo $order->id; ?>">
                                <div class="p-4 border-top">
                                    <div class="row g-4">
                                        <div class="col-lg-8">
                                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 text-dark">
                                                <i class="bi bi-journals"></i> Danh sách sản phẩm trong đơn
                                            </h6>
                                            <div class="bg-white rounded-4 p-3 shadow-sm">
                                                <table class="table table-sm table-borderless align-middle mb-0">
                                                    <thead>
                                                        <tr class="small text-muted">
                                                            <th>Sản phẩm</th>
                                                            <th width="100">Giá</th>
                                                            <th width="50" class="text-center">SL</th>
                                                            <th width="120" class="text-end">Thành tiền</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($order->items as $item): ?>
                                                        <tr>
                                                            <td><span class="fw-semibold text-dark"><?php echo htmlspecialchars($item->product_name); ?></span></td>
                                                            <td><?php echo number_format($item->price, 0, ',', '.'); ?>đ</td>
                                                            <td class="text-center">×<?php echo $item->quantity; ?></td>
                                                            <td class="text-end fw-bold text-emerald">
                                                                <?php echo number_format($item->price * $item->quantity, 0, ',', '.'); ?>đ
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-info-circle"></i> Log & Ghi chú</h6>
                                            <div class="bg-soft-warning p-3 rounded-4 shadow-sm h-100">
                                                <div class="small fw-bold text-uppercase text-muted mb-1" style="font-size:0.6rem;">Ghi chú từ khách</div>
                                                <p class="small mb-2"><?php echo htmlspecialchars($order->note ?: 'Không có ghi chú'); ?></p>
                                                <hr class="opacity-10">
                                                <div class="small fw-bold text-uppercase text-muted mb-1" style="font-size:0.6rem;">Ngày đặt</div>
                                                <div class="small"><?php echo date('d/m/Y H:i:s', strtotime($order->created_at)); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .fw-black { font-weight: 900; }
    .text-emerald { color: #10b981; }
    .bg-soft-emerald { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.05); border: 1px dashed rgba(245, 158, 11, 0.2); }
    
    .status-select-custom {
        background: #f8fafc !important;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        padding-left: 1.2rem;
        border: 1px solid #e2e8f0 !important;
    }
    
    .btn-update-status {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #1e293b;
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    
    .btn-update-status:hover {
        background: var(--primary-theme);
        transform: rotate(90deg);
    }
    
    .btn-expand-order {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        border: none;
        color: #475569;
        transition: all 0.3s;
    }
    
    .btn-expand-order:not(.collapsed) {
        background: #1e293b;
        color: white;
        transform: rotate(180deg);
    }
    
    .order-row-main:hover {
        background: #f8fafc !important;
    }
    
    .order-details-collapse {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
