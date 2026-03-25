<div class="row justify-content-center py-5">
    <div class="col-md-6">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark display-6 mb-2">Tham Gia Cùng IWatch</h2>
            <div class="mx-auto" style="width: 40px; height: 3px; background: var(--accent-mint); border-radius: 50px;"></div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4 p-lg-5">
            <div class="card-body p-0">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger rounded-4 mb-4 border-0 shadow-sm" style="background: #fef2f2; color: #991b1b;">
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $error): ?>
                                <li class="small fw-semibold"><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="/webbanhang/Account/saveRegister" method="POST">
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase text-muted tracking-wide mb-2">Họ và tên</label>
                            <input type="text" name="fullname" class="form-control bg-light border-0 py-3" placeholder="Nguyễn Văn A" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase text-muted tracking-wide mb-2">Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control bg-light border-0 py-3" placeholder="Tên dùng để đăng nhập" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted tracking-wide mb-2">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" name="password" id="reg-password" class="form-control bg-light border-0 py-3" placeholder="••••••••" required>
                                <button class="btn bg-light border-0 px-3 toggle-password" type="button" data-target="reg-password">
                                    <i class="bi bi-eye text-muted"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted tracking-wide mb-2">Xác nhận</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" id="confirm-password" class="form-control bg-light border-0 py-3" placeholder="••••••••" required>
                                <button class="btn bg-light border-0 px-3 toggle-password" type="button" data-target="confirm-password">
                                    <i class="bi bi-eye text-muted"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-premium btn-emerald w-100 py-3 mt-5 mb-4 shadow-sm">
                        KHỞI TẠO TÀI KHOẢN
                    </button>

                    <div class="text-center">
                        <p class="text-muted small fw-semibold mb-0">Đã có tài khoản? <a href="/webbanhang/Account/login" class="text-emerald text-decoration-none fw-bold">Đăng nhập ngay</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.tracking-wide { letter-spacing: 0.05em; }
input::placeholder { color: #cbd5e1 !important; opacity: 1; }
</style>

<script>
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
});
</script>
