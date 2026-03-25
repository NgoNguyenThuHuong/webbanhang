<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg p-4 p-md-5" style="border-radius: 32px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px);">
                <div class="text-center mb-5">
                    <div class="d-inline-flex p-4 rounded-circle bg-soft-emerald mb-4">
                        <i class="bi bi-patch-question-fill text-emerald display-4"></i>
                    </div>
                    <h2 class="fw-black mb-1" style="letter-spacing: -1px;">Khôi Phục Mật Khẩu</h2>
                    <p class="text-muted small">Nhập thông tin xác thực để đặt lại mật khẩu của bạn</p>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger border-0 rounded-4 p-3 mb-4 d-flex align-items-center gap-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span class="fw-bold"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                    </div>
                <?php endif; ?>

                <form action="/webbanhang/Account/verifyForgot" method="POST">
                    <div class="form-group-custom mb-4">
                        <label class="small fw-bold text-uppercase text-muted mb-2 px-3">Tên đăng nhập</label>
                        <div class="input-modern-group">
                            <i class="bi bi-person"></i>
                            <input type="text" name="username" class="form-control" required placeholder="Nhập username của bạn">
                        </div>
                    </div>

                    <div class="form-group-custom mb-5">
                        <label class="small fw-bold text-uppercase text-muted mb-2 px-3">Email liên kết</label>
                        <div class="input-modern-group">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" class="form-control" required placeholder="Nhập email đã đăng ký">
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        <button type="submit" class="btn-luxury w-100 py-4 shadow-lg border-0 text-white fw-bold">
                            TIẾP THEO <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                        <a href="/webbanhang/Account/login" class="btn btn-light border-0 py-3 rounded-4 fw-bold text-muted text-center transition-all">
                             Quay lại Đăng nhập
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
    }
    .btn-luxury {
        background: linear-gradient(135deg, #065f46, #10b981);
        border-radius: 20px;
        letter-spacing: 1px;
    }
</style>
