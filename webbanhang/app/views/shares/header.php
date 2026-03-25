<?php
// Khởi tạo dữ liệu cho Navbar phụ
require_once 'app/config/database.php';
require_once 'app/models/CategoryModel.php';

$db_nav = (new Database())->getConnection();
$categoryModel_nav = new CategoryModel($db_nav);
$nav_categories = $categoryModel_nav->getCategories();

$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IWATCH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                /* Admin Theme - Amber & Dark */
                --primary-theme: #d97706; /* Amber-600 */
                --primary-dark: #92400e;  /* Amber-800 */
                --accent-theme: #f59e0b;  /* Amber-500 */
                --bg-slate: #0f172a;      /* Slate-900 */
                --text-main: #f8fafc;
                --nav-bg: rgba(15, 23, 42, 0.9);
            <?php else: ?>
                /* Customer Theme - Emerald & Glass */
                --primary-theme: #065f46; /* Emerald-800 */
                --primary-dark: #064e3b;  /* Emerald-900 */
                --accent-theme: #10b981;  /* Emerald-500 */
                --bg-slate: #f8fafc;      /* Slate-50 */
                --text-main: #1e293b;
                --nav-bg: rgba(255, 255, 255, 0.8);
            <?php endif; ?>
            
            --primary-emerald: var(--primary-theme);
            --accent-mint: var(--accent-theme);
            --glass-white: var(--nav-bg);
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-slate);
            color: var(--text-main);
            transition: background-color 0.5s ease;
        }

        .main-content {
            flex: 1 0 auto;
            padding-top: 40px;
            padding-bottom: 80px;
        }

        /* Glassmorphism Header */
        .main-navbar {
            background: var(--glass-white);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            color: var(--primary-emerald) !important;
            letter-spacing: -0.5px;
        }

        .sub-navbar {
            background: #ffffff !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .nav-category {
            color: #475569 !important;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 10px 16px;
            border-radius: 50px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .nav-category:hover, .nav-category.active {
            color: var(--accent-mint) !important;
            background: rgba(16, 185, 129, 0.08);
        }

        .nav-category-container {
            display: flex;
            align-items: center;
            gap: 12px;
            overflow-x: auto;
            scrollbar-width: none;
            padding: 8px 0;
        }
        .nav-category-container::-webkit-scrollbar { display: none; }

        /* Search Bar */
        .search-container {
            position: relative;
            width: 300px;
        }
        .search-input {
            background: #f1f5f9;
            border: 1px solid transparent;
            padding: 0.6rem 1rem 0.6rem 2.8rem;
            border-radius: 50px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            width: 100%;
        }
        .search-input:focus {
            background: #fff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            border-color: var(--accent-mint);
            outline: none;
        }
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        /* Buttons */
        .btn-premium {
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.9rem;
        }
        .btn-emerald {
            background: var(--primary-emerald);
            color: #fff;
            border: none;
        }
        .btn-emerald:hover {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(6, 95, 70, 0.3);
            color: #fff;
        }

        .cart-badge {
            background: var(--accent-mint);
            color: #fff;
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
            border-radius: 50px;
        }

        .btn-my-orders {
            text-decoration: none;
            color: var(--primary-emerald);
            font-weight: 700;
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.1);
            transition: all 0.3s ease;
        }
        .btn-my-orders:hover {
            background: var(--primary-emerald);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(6, 95, 70, 0.1);
        }

        /* Product Cards */
        .product-card {
            border: none;
            border-radius: 20px;
            background: #fff;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .img-zoom {
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover .img-zoom {
            transform: scale(1.1);
        }

        /* Luxury Hero Banner */
        .hero-banner {
            background: #020617; /* Slate-950 */
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.15) 0, transparent 50%), 
                radial-gradient(at 50% 0%, rgba(6, 95, 70, 0.2) 0, transparent 50%), 
                radial-gradient(at 100% 0%, rgba(16, 185, 129, 0.15) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(6, 78, 59, 0.3) 0, transparent 50%),
                radial-gradient(at 0% 100%, rgba(4, 120, 87, 0.2) 0, transparent 50%);
            border-radius: 40px;
            padding: 6rem 3rem;
            margin-bottom: 4rem;
            position: relative;
            overflow: hidden;
            color: white;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.5), 
                        0 20px 50px -10px rgba(6, 95, 70, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255, 255, 255, 0.05),
                transparent
            );
            transition: all 0.6s;
            animation: shine-banner 8s infinite;
        }

        @keyframes shine-banner {
            0% { left: -100%; }
            20% { left: 100%; }
            100% { left: 100%; }
        }

        .hero-glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--accent-mint);
            filter: blur(150px);
            border-radius: 50%;
            opacity: 0.15;
            z-index: 1;
            pointer-events: none;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 900;
            letter-spacing: -2px;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            background: linear-gradient(135deg, #ffffff 30%, #a7f3d0 70%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .hero-subtitle {
            font-size: 1.35rem;
            color: #94a3b8; /* Slate-400 */
            max-width: 650px;
            margin-bottom: 3rem;
            line-height: 1.7;
            font-weight: 500;
        }

        .btn-luxury {
            position: relative;
            padding: 1.2rem 3rem;
            font-size: 1.1rem;
            background: white;
            color: #020617;
            border-radius: 100px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            display: inline-flex;
            align-items: center;
            gap: 12px;
            border: none;
            overflow: hidden;
            z-index: 1;
        }

        .btn-luxury::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #10b981, #065f46);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.4s;
        }

        .btn-luxury:hover {
            color: white;
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
        }

        .btn-luxury:hover::after {
            opacity: 1;
        }

        .floating-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.03);
            font-size: 8rem;
            z-index: 0;
            pointer-events: none;
            animation: float 10s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Stats in Banner */
        .banner-stats {
            display: flex;
            gap: 40px;
            margin-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg main-navbar sticky-top">
        <div class="container py-1">
            <a class="navbar-brand fw-bold fs-3" href="/webbanhang/Product/index">
                <i class="bi bi-intersect me-2" style="color: var(--primary-theme);"></i>IWATCH
            </a>

            <div class="d-flex align-items-center gap-4 ms-auto">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] !== 'admin'): ?>
                <a href="/webbanhang/Order/index" class="btn-my-orders d-none d-xl-flex align-items-center gap-2">
                    <i class="bi bi-box-seam"></i> <span>Đơn hàng của tôi</span>
                </a>
                <?php endif; ?>

                <div class="search-container d-none d-lg-block">
                    <form action="/webbanhang/Product/index" method="GET">
                        <i class="bi bi-search search-icon"></i>
                        <input class="search-input" type="search" name="keyword" placeholder="Bạn đang tìm gì?">
                    </form>
                </div>

                <a href="/webbanhang/Product/cart" class="text-dark text-decoration-none d-flex align-items-center gap-2">
                    <div class="position-relative">
                        <i class="bi bi-handbag fs-4"></i>
                        <span class="position-absolute top-0 start-100 translate-middle cart-badge">
                            <?php echo $cart_count; ?>
                        </span>
                    </div>
                </a>

                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Hiển thị tên user -->
                    <!-- Hiển thị tên user (Clickable to Profile) -->
                    <a href="/webbanhang/Account/profile" class="d-flex align-items-center gap-2 bg-light rounded-pill px-3 py-1 text-decoration-none transition-all hover-account" style="border: 1px solid #e2e8f0;">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['fullname']); ?>&background=<?php echo (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? 'b45309' : '047857'; ?>&color=fff"
                             class="rounded-circle" width="30" height="30">
                        <div class="lh-1">
                            <div class="small fw-bold text-dark" style="font-size:0.82rem;"><?php echo htmlspecialchars($_SESSION['fullname']); ?></div>
                            <div class="fw-bold text-uppercase" style="font-size:0.62rem; color:<?php echo (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? '#b45309' : '#10b981'; ?>;">
                                <?php echo (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? '👑 Admin' : '🛒 Khách hàng'; ?>
                            </div>
                        </div>
                    </a>

                    <!-- Nút Đăng xuất -->
                    <a href="/webbanhang/Account/logout" id="logout-btn"
                       class="btn fw-semibold d-flex align-items-center gap-2"
                       style="background:#fef2f2; color:#dc2626; border:1px solid #fecaca; border-radius:50px; padding:0.5rem 1.1rem; font-size:0.875rem;">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </a>

                    <script>
                    document.getElementById('logout-btn').addEventListener('click', function() {
                        localStorage.removeItem('jwt_token');
                    });
                    </script>

                <?php else: ?>
                    <div class="d-flex gap-2">
                        <a href="/webbanhang/Account/login" class="btn btn-premium btn-light text-dark fw-semibold">Đăng nhập</a>
                        <a href="/webbanhang/Account/register" class="btn btn-premium btn-emerald">Đăng ký</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <!-- MODERN ADMIN MANAGEMENT HEADER -->
    <div style="background: #020617; border-bottom: 4px solid var(--primary-theme); position: sticky; top: 0; z-index: 1030;">
        <div class="container d-flex align-items-center justify-content-between py-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-warning rounded-3 p-2 d-flex align-items-center justify-content-center shadow-lg">
                    <i class="bi bi-cpu-fill text-dark fs-4"></i>
                </div>
                <div>
                    <h6 class="text-white mb-0 fw-bold tracking-wider">HỆ THỐNG QUẢN TRỊ</h6>
                    <small class="text-warning fw-bold text-uppercase" style="font-size: 0.65rem; opacity: 0.8;">Premium Management Panel</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <a href="/webbanhang/Admin/index" class="admin-nav-btn active-panel">
                    <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                </a>
                <a href="/webbanhang/Product/add" class="admin-nav-btn">
                    <i class="bi bi-plus-lg"></i> <span>Sản phẩm mới</span>
                </a>
                <a href="/webbanhang/Order/manage" class="admin-nav-btn">
                    <i class="bi bi-receipt-cutoff"></i> <span>Đơn hàng</span>
                </a>
                <a href="/webbanhang/Admin/users" class="admin-nav-btn">
                    <i class="bi bi-people"></i> <span>Người dùng</span>
                </a>
                <a href="/webbanhang/Admin/coupons" class="admin-nav-btn">
                    <i class="bi bi-ticket-perforated"></i> <span>Khuyến mãi</span>
                </a>
                <div class="vr mx-2 bg-white opacity-25"></div>
                <a href="/webbanhang/Product/index" class="btn btn-outline-light rounded-pill btn-sm px-3 fw-bold border-opacity-25">
                    <i class="bi bi-eye-fill me-1"></i> Xem Shop
                </a>
            </div>
        </div>
    </div>

    <style>
        .admin-nav-btn {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .admin-nav-btn:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
            transform: translateY(-2px);
        }
        .active-panel {
            background: var(--primary-theme) !important;
            color: #fff !important;
            box-shadow: 0 10px 15px -3px rgba(217, 119, 6, 0.3);
        }
        .admin-nav-btn i { font-size: 1.1rem; }
        @media (max-width: 991px) { .admin-nav-btn span { display: none; } }
    </style>
    <?php endif; ?>

    <!-- Category sub-navbar -->
    <nav class="sub-navbar shadow-sm <?php echo (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? 'd-none' : ''; ?>">
        <div class="container">
            <div class="nav-category-container">
                <a href="/webbanhang/Product/index#store-section" class="nav-category">
                    <i class="bi bi-house-door-fill"></i> TẤT CẢ
                </a>
                <?php if (!empty($nav_categories)): ?>
                    <?php
                    $iconMap = [
                        'Điện thoại' => 'bi-phone',
                        'Laptop & Máy tính' => 'bi-laptop',
                        'Máy tính bảng' => 'bi-tablet',
                        'Thiết bị Âm thanh' => 'bi-headset',
                        'Đồng hồ & Sức khỏe' => 'bi-watch',
                        'Phụ kiện & Linh kiện' => 'bi-keyboard',
                        'Gaming & Giải trí' => 'bi-controller',
                        'Thiết thiết bị Âm thanh' => 'bi-headset',
                    ];
                    ?>
                    <?php foreach ($nav_categories as $cat): ?>
                        <?php $icon = $iconMap[$cat->name] ?? 'bi-tag'; ?>
                        <a href="/webbanhang/Product/index?category_id=<?php echo $cat->id; ?>#store-section"
                            class="nav-category">
                            <i class="bi <?php echo $icon; ?>"></i> <?php echo htmlspecialchars($cat->name); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container main-content">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>