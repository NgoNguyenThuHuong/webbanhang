<div class="row justify-content-center py-5">
    <div class="col-md-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark display-6 mb-2">Đăng Nhập</h2>
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

                <form id="loginForm">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted tracking-wide mb-2">Tên đăng nhập</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-3"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="username" id="username" class="form-control bg-light border-0 py-3 ps-0" placeholder="Username của bạn" required>
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label class="form-label small fw-bold text-uppercase text-muted tracking-wide mb-2">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-3"><i class="bi bi-shield-lock text-muted"></i></span>
                            <input type="password" name="password" id="password-input" class="form-control bg-light border-0 py-3 ps-0" placeholder="••••••••" required>
                            <button class="btn bg-light border-0 px-3" type="button" id="togglePassword">
                                <i class="bi bi-eye text-muted"></i>
                            </button>
                        </div>
                        <div class="text-end mt-2">
                            <a href="/webbanhang/Account/forgotPassword" class="text-muted small text-decoration-none hover-emerald fw-semibold">Quên mật khẩu?</a>
                        </div>
                    </div>
                    
                    <div id="loginError" class="alert alert-danger d-none rounded-4 mb-3 border-0"></div>

                    <button type="submit" id="submitBtn" class="btn btn-premium btn-emerald w-100 py-3 mb-4 shadow-sm">
                        ĐĂNG NHẬP NGAY
                    </button>

                    <div class="text-center">
                        <p class="text-muted small fw-semibold mb-0">Bạn mới đến đây? <a href="/webbanhang/Account/register" class="text-emerald text-decoration-none fw-bold">Tạo tài khoản mới</a></p>
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
document.getElementById('togglePassword').addEventListener('click', function (e) {
    const password = document.getElementById('password-input');
    const icon = this.querySelector('i');
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
});

document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('submitBtn');
    const errDiv = document.getElementById('loginError');
    const username = document.getElementById('username').value;
    const password = document.getElementById('password-input').value;

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> ĐANG XỬ LÝ...';
    errDiv.classList.add('d-none');

    fetch('/webbanhang/Account/api_login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.token) {
            // Lưu token vào localStorage để dùng cho các yêu cầu API sau này
            localStorage.setItem('jwt_token', data.token);
            // Chuyển hướng về trang chủ sản phẩm
            window.location.href = '/webbanhang/Product';
        } else {
            errDiv.textContent = data.message || "Đăng nhập thất bại";
            errDiv.classList.remove('d-none');
            btn.disabled = false;
            btn.innerHTML = 'ĐĂNG NHẬP NGAY';
        }
    })
    .catch(err => {
        errDiv.textContent = "Có lỗi xảy ra kết nối máy chủ.";
        errDiv.classList.remove('d-none');
        btn.disabled = false;
        btn.innerHTML = 'ĐĂNG NHẬP NGAY';
    });
});
</script>
