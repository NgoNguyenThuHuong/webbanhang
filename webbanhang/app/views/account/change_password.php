<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg p-4 p-md-5" style="border-radius: 32px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px);">
                <div class="text-center mb-5">
                    <div class="d-inline-flex p-4 rounded-circle bg-soft-emerald mb-4">
                        <i class="bi bi-shield-lock-fill text-emerald display-4"></i>
                    </div>
                    <h2 class="fw-black mb-1" style="letter-spacing: -1px;">Bảo Mật Tài Khoản</h2>
                    <p class="text-muted small">Cập nhật mật khẩu mới để bảo vệ thông tin của bạn</p>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-emerald border-0 rounded-4 p-3 mb-4 d-flex align-items-center gap-3 animate__animated animate__fadeIn">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <span class="fw-bold"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger border-0 rounded-4 p-3 mb-4 d-flex align-items-center gap-3 animate__animated animate__shakeX">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <span class="fw-bold"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                    </div>
                <?php endif; ?>

                <form action="/webbanhang/Account/updatePassword" method="POST" class="needs-validation" novalidate>
                    <div class="form-group-custom mb-4">
                        <label class="small fw-bold text-uppercase text-muted mb-2 px-3">Mật khẩu hiện tại</label>
                        <div class="input-modern-group">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="current_password" class="form-control" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="form-group-custom mb-4">
                        <label class="small fw-bold text-uppercase text-muted mb-2 px-3">Mật khẩu mới</label>
                        <div class="input-modern-group">
                            <i class="bi bi-shield-plus"></i>
                            <input type="password" name="new_password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
                        </div>
                    </div>

                    <div class="form-group-custom mb-5">
                        <label class="small fw-bold text-uppercase text-muted mb-2 px-3">Xác nhận mật khẩu mới</label>
                        <div class="input-modern-group">
                            <i class="bi bi-shield-check"></i>
                            <input type="password" name="confirm_password" class="form-control" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        <button type="submit" class="btn-luxury w-100 py-4 shadow-lg border-0 text-white fw-bold">
                            CẬP NHẬT MẬT KHẨU <i class="bi bi-check-lg ms-2"></i>
                        </button>
                        <a href="/webbanhang/Account/profile" class="btn btn-light border-0 py-3 rounded-4 fw-bold text-muted transition-all">
                            <i class="bi bi-arrow-left me-2"></i> Quay lại Hồ sơ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .bg-soft-emerald { background: rgba(16, 185, 129, 0.1); }
    .text-emerald { color: #10b981; }
    .alert-emerald { background: #f0fdf4; color: #166534; }
    
    .input-modern-group { position: relative; }
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
        border-radius: 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .input-modern-group .form-control:focus {
        background: #fff;
        border-color: var(--accent-theme);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.1);
        transform: translateY(-2px);
    }
    
    .btn-luxury {
        background: linear-gradient(135deg, #065f46, #10b981);
        border-radius: 20px;
        letter-spacing: 1px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .btn-luxury:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    .transition-all { transition: all 0.2s ease; }
    .btn-light:hover { background: #f1f5f9; transform: translateX(-5px); }
</style>
