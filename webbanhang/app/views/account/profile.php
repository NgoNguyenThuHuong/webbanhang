<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar Profile -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
                <div class="card-body p-5 text-center bg-dark position-relative">
                    <div class="hero-glow" style="top: -50%; left: -50%; background: var(--accent-theme); filter: blur(100px); opacity: 0.1;"></div>
                    
                    <div class="position-relative d-inline-block mb-4">
                        <div class="rounded-circle p-1" style="background: linear-gradient(135deg, var(--accent-theme), #fff);">
                            <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center overflow-hidden" style="width: 140px; height: 140px; border: 4px solid #1e293b;">
                                <?php if (!empty($user->avatar_url)): ?>
                                    <img src="<?php echo $user->avatar_url; ?>" class="w-100 h-100 object-fit-cover">
                                <?php else: ?>
                                    <span class="display-3 fw-black text-white"><?php echo strtoupper(substr($user->fullname ?? 'U', 0, 1)); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <label class="position-absolute bottom-0 end-0 bg-emerald rounded-circle p-2 shadow-lg border border-4 border-dark" style="cursor: pointer;">
                            <i class="bi bi-camera-fill text-white fs-5"></i>
                        </label>
                    </div>

                    <h4 class="fw-black text-white mb-1"><?php echo htmlspecialchars($user->fullname); ?></h4>
                    <span class="badge bg-soft-emerald text-emerald px-3 py-2 rounded-pill fw-bold small text-uppercase" style="letter-spacing: 1px;">
                        Member Since <?php echo date('Y', strtotime($user->created_at ?? 'now')); ?>
                    </span>
                </div>
                <div class="card-footer bg-white border-0 p-4">
                    <div class="d-flex flex-column gap-2">
                        <a href="/webbanhang/Order/index" class="btn btn-light border-0 py-3 rounded-4 d-flex align-items-center gap-3 text-dark fw-bold transition-all">
                            <i class="bi bi-bag-check-fill text-muted fs-5"></i>
                            Đơn hàng của tôi
                        </a>
                        <a href="/webbanhang/Account/changePassword" class="btn btn-light border-0 py-3 rounded-4 d-flex align-items-center gap-3 text-dark fw-bold transition-all">
                            <i class="bi bi-shield-lock-fill text-muted fs-5"></i>
                            Bảo mật & Mật khẩu
                        </a>
                        <hr class="my-3 opacity-10">
                        <a href="/webbanhang/Account/logout" class="btn btn-soft-danger border-0 py-3 rounded-4 d-flex align-items-center gap-3 fw-bold text-danger">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                            Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Profile -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 p-md-5" style="border-radius: 24px;">
                <div class="d-flex align-items-center justify-content-between mb-5">
                    <div>
                        <h2 class="fw-black mb-1" style="letter-spacing: -1px;">Hồ Sơ Thành Viên</h2>
                        <p class="text-muted small">Cập nhật thông tin cá nhân của bạn để nhận được trải nghiệm tốt nhất</p>
                    </div>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-emerald border-0 rounded-4 p-3 mb-4 d-flex align-items-center gap-3">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <span class="fw-bold"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger border-0 rounded-4 p-3 mb-4 d-flex align-items-center gap-3">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <span class="fw-bold"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                    </div>
                <?php endif; ?>

                <form action="/webbanhang/Account/updateProfile" method="POST">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Họ và Tên</label>
                                <div class="input-modern-group">
                                    <i class="bi bi-person"></i>
                                    <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user->fullname ?? ''); ?>" placeholder="Nhập họ tên...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Email</label>
                                <div class="input-modern-group">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user->email ?? ''); ?>" placeholder="example@email.com">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Số điện thoại</label>
                                <div class="input-modern-group">
                                    <i class="bi bi-telephone"></i>
                                    <input type="tel" name="phone" class="form-control" value="<?php echo htmlspecialchars($user->phone ?? ''); ?>" placeholder="09xxx">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Tên đăng nhập</label>
                                <div class="input-modern-group">
                                    <i class="bi bi-fingerprint"></i>
                                    <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($user->username ?? ''); ?>" disabled readonly>
                                </div>
                                <div class="small text-muted mt-1 px-3">Tên đăng nhập không thể thay đổi</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-custom">
                                <label class="small fw-bold text-uppercase text-muted mb-2">Địa chỉ giao hàng mặc định</label>
                                <div class="input-modern-group">
                                    <i class="bi bi-geo-alt"></i>
                                    <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($user->address ?? ''); ?>" placeholder="Số nhà, Tên đường, Phường/Xã...">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn-luxury w-100 py-4 shadow-lg">
                                LƯU THÔNG TIN HỒ SƠ <i class="bi bi-shield-check ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .bg-emerald { background: #10b981; }
    .text-emerald { color: #10b981; }
    .alert-emerald { background: #f0fdf4; color: #166534; }
    .bg-soft-emerald { background: rgba(16, 185, 129, 0.1); }
    .btn-soft-danger { background: rgba(239, 68, 68, 0.05); }
    .btn-soft-danger:hover { background: rgba(239, 68, 68, 0.1); }
    
    .form-group-custom label {
        padding-left: 1rem;
    }
    
    .input-modern-group {
        position: relative;
    }
    
    .input-modern-group i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.2rem;
    }
    
    .input-modern-group .form-control {
        padding: 1.2rem 1.2rem 1.2rem 3.5rem;
        background: #f8fafc;
        border: 2px solid transparent;
        border-radius: 16px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .input-modern-group .form-control:focus {
        background: #fff;
        border-color: var(--accent-theme);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.1);
        transform: translateY(-2px);
    }
    
    .transition-all {
        transition: all 0.2s ease;
    }
    
    .btn-light:hover {
        background: #f1f5f9;
        transform: translateX(8px);
    }
    
    .cursor-not-allowed {
        cursor: not-allowed;
    }
</style>
