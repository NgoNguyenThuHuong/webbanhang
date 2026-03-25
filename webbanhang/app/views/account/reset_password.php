<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg p-4 p-md-5" style="border-radius: 32px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px);">
                <div class="text-center mb-5">
                    <div class="d-inline-flex p-4 rounded-circle bg-soft-emerald mb-4">
                        <i class="bi bi-key-fill text-emerald display-4"></i>
                    </div>
                    <h2 class="fw-black mb-1" style="letter-spacing: -1px;">Đặt Lại Mật Khẩu</h2>
                    <p class="text-muted small">Cung cấp mật khẩu mới cho tài khoản của bạn</p>
                </div>

                <form action="/webbanhang/Account/resetPasswordConfirm" method="POST">
                    <div class="form-group-custom mb-4">
                        <label class="small fw-bold text-uppercase text-muted mb-2 px-3">Mật khẩu mới</label>
                        <div class="input-modern-group">
                            <i class="bi bi-shield-lock"></i>
                            <input type="password" name="new_password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
                        </div>
                    </div>

                    <div class="form-group-custom mb-5">
                        <label class="small fw-bold text-uppercase text-muted mb-2 px-3">Xác nhận mật khẩu</label>
                        <div class="input-modern-group">
                            <i class="bi bi-shield-check"></i>
                            <input type="password" name="confirm_password" class="form-control" required placeholder="Nhập lại mật khẩu mới">
                        </div>
                    </div>

                    <button type="submit" class="btn-luxury w-100 py-4 shadow-lg border-0 text-white fw-bold">
                        HOÀN TẤT ĐẶT LẠI <i class="bi bi-check-circle-fill ms-2"></i>
                    </button>
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
    .btn-luxury {
        background: linear-gradient(135deg, #065f46, #10b981);
        border-radius: 20px;
        letter-spacing: 1px;
    }
</style>
