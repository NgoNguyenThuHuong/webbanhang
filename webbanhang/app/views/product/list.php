<!-- Luxury Hero Banner Section -->
<?php if (!isset($_GET['keyword']) && !isset($_GET['category_id'])): ?>
<div class="hero-banner d-flex align-items-center" style="background-image: 
    radial-gradient(at 0% 0%, rgba(var(--primary-theme-rgb), 0.15) 0, transparent 50%), 
    radial-gradient(at 100% 100%, rgba(var(--primary-dark-rgb), 0.3) 0, transparent 50%);">
    <!-- Decorative Glows -->
    <div class="hero-glow" style="top: -10%; left: -10%; background: var(--accent-theme);"></div>
    <div class="hero-glow" style="bottom: -10%; right: -10%; background: var(--primary-dark);"></div>
    
    <!-- Floating Icons for depth -->
    <i class="bi bi-watch floating-icon" style="top: 10%; right: 5%; transform: rotate(15deg);"></i>
    <i class="bi bi-clock-history floating-icon" style="bottom: 10%; left: 10%; font-size: 6rem; opacity: 0.02;"></i>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge border border-success text-success mb-3 px-3 py-2 rounded-pill fw-bold" style="background: rgba(16, 185, 129, 0.1);">
                    <i class="bi bi-stars me-2"></i> BỘ SƯU TẬP PREMUM 2026
                </span>
                <h1 class="hero-title">Kiến Tạo Đẳng Cấp Thượng Lưu</h1>
                <p class="hero-subtitle">
                    Định nghĩa lại phong cách cá nhân với những cỗ máy thời gian kiệt tác. Nâng niu từng giây phút với sự tinh xảo tuyệt đối từ IWATCH.
                </p>
                <div class="d-flex gap-3 align-items-center flex-wrap">
                    <a href="#store-section" class="btn-luxury">
                        Trải Nghiệm Ngay <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>
                    <div class="banner-stats d-none d-md-flex mt-0 border-0 pt-0 ms-lg-4">
                        <div class="stat-item">
                            <span class="stat-value">500+</span>
                            <span class="stat-label">Mẫu độc bản</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">24/7</span>
                            <span class="stat-label">Hỗ trợ tận tâm</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="cyber-watch-wrapper p-4">
                    <!-- Holographic Rings -->
                    <div class="holo-ring ring-1"></div>
                    <div class="holo-ring ring-2"></div>
                    <div class="holo-ring ring-3"></div>
                    
                    <!-- Floating Data Points -->
                    <div class="data-node node-1"><i class="bi bi-cpu"></i> <span>Swiss Movement</span></div>
                    <div class="data-node node-2"><i class="bi bi-shield-check"></i> <span>Sapphire Crystal</span></div>
                    
                    <div class="watch-display-container">
                        <div class="tech-icon-center">
                            <i class="bi bi-intersect core-icon"></i>
                            <i class="bi bi-gear-wide-connected gear-icon"></i>
                            <div class="glow-sphere"></div>
                        </div>
                        <div class="watch-shadow"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div id="store-section" class="row mb-5 py-2">
    <div class="col-12 text-center mb-5">
        <h2 class="fw-bold text-dark display-5 mb-3">
            <?php 
            if (isset($categoryName) && $categoryName) {
                echo htmlspecialchars($categoryName);
            } elseif (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                echo 'Kết quả cho: "' . htmlspecialchars($_GET['keyword']) . '"';
            } else {
                echo 'Sản Phẩm Của Chúng Tôi';
            }
            ?>
        </h2>
        <div class="mx-auto" style="width: 60px; height: 4px; background: #10b981; border-radius: 50px;"></div>
    </div>
</div>

<div class="row g-4">

<?php if (empty($products)): ?>
<div class="col-12 text-center py-5">
    <i class="bi bi-search text-muted" style="font-size: 4rem; opacity: 0.15;"></i>
    <h4 class="text-muted fw-bold mt-4">Không tìm thấy sản phẩm nào</h4>
    <a href="/webbanhang/Product/index" class="btn btn-sm mt-3 px-4 py-2 text-white" style="background:#065f46; border-radius:50px;">Quay lại cửa hàng</a>
</div>

<?php else: ?>
<?php foreach ($products as $product): ?>
<div class="col-sm-6 col-lg-4 col-xl-3">
    <div class="card h-100 border-0 shadow-sm product-card" style="border-radius:20px; overflow:hidden; background:#fff;">

        <!-- Ảnh sản phẩm -->
        <div class="position-relative overflow-hidden bg-light d-flex align-items-center justify-content-center" style="height:260px;">
            <?php if (!empty($product->image)): ?>
                <img src="<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                     class="w-100 h-100 img-zoom" alt="<?php echo htmlspecialchars($product->name); ?>"
                     style="object-fit:contain; padding:1.5rem; transition: transform 0.6s ease;"
                     onerror="this.src='https://via.placeholder.com/400x400?text=No+Image';">
            <?php else: ?>
                <i class="bi bi-box text-muted fs-1" style="opacity:0.2;"></i>
            <?php endif; ?>

            <!-- Badge danh mục -->
            <?php if (!empty($product->category_name)): ?>
            <div class="position-absolute top-0 start-0 m-3" style="background:rgba(255,255,255,0.9); border-radius:50px; padding:4px 14px; font-size:0.75rem; font-weight:700; color:#065f46; border:1px solid #d1fae5;">
                <?php echo htmlspecialchars($product->category_name); ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="card-body p-4 d-flex flex-column">
            <h5 class="fw-bold text-dark mb-1" style="font-size:1rem; min-height:2.5rem; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                    <?php echo htmlspecialchars($product->name); ?>
                </a>
            </h5>

            <p class="text-muted small mt-2 mb-3" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; min-height:2.4rem;">
                <?php echo htmlspecialchars($product->description ?? ''); ?>
            </p>

            <div class="mt-auto d-flex align-items-center justify-content-between pt-2 border-top">
                <span class="fw-bold fs-5" style="color:#065f46;">
                    <?php echo number_format($product->price, 0, ',', '.'); ?>đ
                </span>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <!-- Nút dành riêng cho Admin -->
                    <div class="d-flex gap-2">
                        <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>"
                           class="btn btn-sm btn-outline-warning rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px;" title="Chỉnh sửa">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>"
                           class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px;" title="Xóa"
                           onclick="return confirm('Bạn chắc muốn xóa sản phẩm này?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Nút dành cho Khách hàng -->
                    <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>"
                       class="btn btn-sm text-white d-flex align-items-center justify-content-center rounded-circle"
                       style="width:40px;height:40px;background:#065f46;border:none;transition:all 0.3s;" title="Thêm vào giỏ">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

</div>

<style>
.product-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; }
.product-card:hover .img-zoom { transform: scale(1.08) !important; }

/* Cyber-Luxury Banner Effects */
.cyber-watch-wrapper {
    position: relative;
    height: 450px;
    display: flex;
    align-items: center;
    justify-content: center;
    perspective: 1000px;
}

.watch-display-container {
    position: relative;
    z-index: 5;
    animation: float-3d 6s infinite ease-in-out;
    transform-style: preserve-3d;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tech-icon-center {
    font-size: 8rem;
    position: relative;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 250px;
    height: 250px;
}

.core-icon {
    color: #ffffff;
    text-shadow: 0 0 20px var(--accent-theme), 0 0 40px var(--accent-theme);
    position: relative;
    z-index: 12;
    animation: pulse-core 3s infinite ease-in-out;
}

.gear-icon {
    position: absolute;
    font-size: 12rem;
    color: var(--accent-theme);
    opacity: 0.15;
    animation: rotate-gear 20s infinite linear;
    z-index: 8;
}

.glow-sphere {
    position: absolute;
    width: 150px;
    height: 150px;
    background: var(--accent-theme);
    filter: blur(80px);
    border-radius: 50%;
    opacity: 0.4;
    z-index: 5;
    animation: pulse-glow 4s infinite ease-in-out;
}

@keyframes pulse-core {
    0%, 100% { transform: scale(1); opacity: 0.8; }
    50% { transform: scale(1.1); opacity: 1; }
}

@keyframes rotate-gear {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes pulse-glow {
    0%, 100% { transform: scale(1); opacity: 0.3; }
    50% { transform: scale(1.3); opacity: 0.5; }
}

.animate-glow-icon {
    animation: pulse-glow 3s infinite ease-in-out;
}

@keyframes pulse-glow {
    0%, 100% { filter: drop-shadow(0 0 30px rgba(16, 185, 129, 0.5)); opacity: 0.8; }
    50% { filter: drop-shadow(0 0 60px rgba(16, 185, 129, 0.8)); opacity: 1; }
}

.hero-watch-img {
    filter: drop-shadow(0 20px 50px rgba(0,0,0,0.5));
    max-height: 400px;
    z-index: 10;
    position: relative;
}

.watch-shadow {
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    width: 60%;
    height: 20px;
    background: radial-gradient(ellipse at center, rgba(0,0,0,0.4) 0%, transparent 70%);
    border-radius: 50%;
    filter: blur(5px);
    animation: shadow-scale 6s infinite ease-in-out;
}

.holo-ring {
    position: absolute;
    border: 1px solid var(--accent-theme);
    border-radius: 50%;
    opacity: 0.15;
    pointer-events: none;
}

.ring-1 { width: 300px; height: 300px; border-width: 2px; animation: rotate-holo 15s infinite linear; border-style: dashed; }
.ring-2 { width: 380px; height: 380px; border-width: 1px; animation: rotate-holo 20s infinite linear reverse; border-style: dotted; }
.ring-3 { width: 450px; height: 450px; border-color: rgba(255,255,255,0.1); border-style: dashed; animation: pulse-ring 4s infinite; }

.data-node {
    position: absolute;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    z-index: 15;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.node-1 { top: 20%; right: -5%; animation: float-node 5s infinite ease-in-out; }
.node-2 { bottom: 25%; left: -5%; animation: float-node 7s infinite ease-in-out reverse; }

@keyframes float-3d {
    0%, 100% { transform: translateY(0) rotateX(10deg) rotateY(-10deg); }
    50% { transform: translateY(-20px) rotateX(-5deg) rotateY(15deg); }
}

@keyframes shadow-scale {
    0%, 100% { transform: translateX(-50%) scale(1); opacity: 0.4; }
    50% { transform: translateX(-50%) scale(0.8); opacity: 0.2; }
}

@keyframes rotate-holo {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes pulse-ring {
    0%, 100% { transform: scale(1); opacity: 0.1; }
    50% { transform: scale(1.05); opacity: 0.2; }
}

@keyframes float-node {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
</style>
