<div class="container-fluid py-4">
    <div class="row g-4 mb-5">
        <!-- Stats Cards -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3" style="background: linear-gradient(135deg, #0f172a, #1e293b); color: white;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4">
                        <i class="bi bi-cash-stack text-warning fs-3"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Doanh Thu (VNĐ)</small>
                        <h4 class="mb-0 fw-bold"><?php echo number_format($totalRevenue, 0, ',', '.'); ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4">
                        <i class="bi bi-cart-check text-primary fs-3"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Tổng Đơn Hàng</small>
                        <h4 class="mb-0 fw-bold text-dark"><?php echo $orderCount; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-danger bg-opacity-10 p-3 rounded-4">
                        <i class="bi bi-clock-history text-danger fs-3"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Đơn Chờ Xử Lý</small>
                        <h4 class="mb-0 fw-bold text-dark"><?php echo $pendingOrders; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-4">
                        <i class="bi bi-people text-success fs-3"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Tổng Khách Hàng</small>
                        <h4 class="mb-0 fw-bold text-dark"><?php echo $userCount; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Revenue Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-4">Biểu Đồ Doanh Thu Năm 2026</h5>
                <canvas id="revenueChart" height="300"></canvas>
            </div>
            
            <!-- Low Stock Alerts -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Cảnh Báo Tồn Kho Thấp</h5>
                    <span class="badge bg-danger rounded-pill">Sắp hết hàng</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead>
                            <tr class="text-muted small">
                                <th>SẢN PHẨM</th>
                                <th>SỐ LƯỢNG CÒN LẠI</th>
                                <th class="text-end">HÀNH ĐỘNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Giả lập lấy sản phẩm stock thấp (thực tế sẽ gọi từ model)
                            $lowStockProducts = $this->db->query("SELECT * FROM product WHERE stock_quantity < 10")->fetchAll(PDO::FETCH_OBJ);
                            ?>
                            <?php if (empty($lowStockProducts)): ?>
                                <tr><td colspan="3" class="text-muted italic">Tất cả sản phẩm đều đủ hàng.</td></tr>
                            <?php else: ?>
                                <?php foreach($lowStockProducts as $lp): ?>
                                <tr>
                                    <td><span class="fw-bold"><?php echo $lp->name; ?></span></td>
                                    <td><span class="badge bg-danger bg-opacity-10 text-danger px-3"><?php echo $lp->stock_quantity; ?> cái</span></td>
                                    <td class="text-end">
                                        <a href="/webbanhang/Product/edit/<?php echo $lp->id; ?>" class="btn btn-sm btn-light rounded-pill px-3 fw-bold">Nhập thêm</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Top Selling Products -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold mb-4">Sản Phẩm Bán Chạy</h5>
                <div class="list-group list-group-flush">
                    <?php if (empty($topProducts)): ?>
                        <p class="text-muted italic">Chưa có dữ liệu bán hàng.</p>
                    <?php else: ?>
                        <?php foreach($topProducts as $p): ?>
                        <div class="list-group-item border-0 px-0 mb-3 d-flex align-items-center gap-3">
                            <div class="bg-light rounded-3 p-2 text-dark fw-bold" style="min-width: 45px; text-align: center;">
                                <?php echo $p->total_sold; ?>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="fw-bold text-dark text-truncate" style="font-size: 0.9rem;"><?php echo $p->product_name; ?></div>
                                <small class="text-muted">Đã bán ra</small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const dataLabels = [];
const dataValues = [];

<?php 
$months = array_fill(1, 12, 0);
foreach($monthlyRevenue as $row) {
    $months[(int)$row->month] = (float)$row->revenue;
}
?>

const chartData = <?php echo json_encode(array_values($months)); ?>;
const labels = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'];

new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: chartData,
            borderColor: '#d97706',
            backgroundColor: 'rgba(217, 119, 6, 0.1)',
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#d97706',
            pointBorderWidth: 2,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { drawBorder: false, color: 'rgba(0,0,0,0.05)' }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});
</script>
