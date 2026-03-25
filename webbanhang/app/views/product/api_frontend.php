<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">API Quản lý Sản phẩm (jQuery AJAX)</h2>
                <button class="btn btn-primary rounded-pill px-4 shadow-sm" id="btn-add-product" data-bs-toggle="modal" data-bs-target="#productModal">
                    <i class="bi bi-plus-lg me-1"></i> Thêm mới
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" width="10%">ID</th>
                            <th scope="col" width="30%">Tên sản phẩm</th>
                            <th scope="col" width="20%">Giá</th>
                            <th scope="col" width="25%">Mô tả</th>
                            <th scope="col" width="15%" class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        <!-- Products will be loaded here via AJAX -->
                        <tr><td colspan="5" class="text-center text-muted py-4">Đang tải dữ liệu...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold fs-4" id="modalTitle">Thêm Sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <form id="productForm">
                    <input type="hidden" id="productId">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Tên sản phẩm</label>
                        <input type="text" class="form-control rounded-3 py-2" id="productName" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-secondary">Giá bán (VNĐ)</label>
                            <input type="number" class="form-control rounded-3 py-2" id="productPrice" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-secondary">Danh mục</label>
                            <select class="form-select rounded-3 py-2" id="productCategory" required>
                                <option value="">Đang tải...</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Mô tả</label>
                        <textarea class="form-control rounded-3 py-2" id="productDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary rounded-pill px-5 shadow-sm" id="btn-save">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast for Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
  <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastMessage">
        Thành công!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Utility to show notification toast
    function showToast(message, isError = false) {
        let toastEl = document.getElementById('liveToast');
        let toastMessage = document.getElementById('toastMessage');
        toastMessage.textContent = message;
        
        if (isError) {
            toastEl.classList.remove('bg-success');
            toastEl.classList.add('bg-danger');
        } else {
            toastEl.classList.remove('bg-danger');
            toastEl.classList.add('bg-success');
        }
        
        // bootstrap toast will be initialized properly as it is loaded by header.php
        if (typeof bootstrap !== 'undefined') {
            let toast = new bootstrap.Toast(toastEl);
            toast.show();
        } else {
            alert(message);
        }
    }

    // --- START BÀI 6: Gửi JWT trong Header ---
    $.ajaxSetup({
        beforeSend: function(xhr) {
            const token = localStorage.getItem('jwt_token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        }
    });
    // --- END BÀI 6 ---

    loadCategories();
    loadProducts();

    function loadCategories() {
        $.ajax({
            url: '/webbanhang/api/category',
            method: 'GET',
            success: function(res) {
                let options = '<option value="">-- Chọn danh mục --</option>';
                if (Array.isArray(res)) {
                    res.forEach(c => {
                        options += `<option value="${c.id}">${c.name}</option>`;
                    });
                }
                $('#productCategory').html(options);
            },
            error: function() {
                $('#productCategory').html('<option value="">Lỗi khi tải danh mục</option>');
            }
        });
    }

    function loadProducts() {
        $.ajax({
            url: '/webbanhang/api/product',
            method: 'GET',
            success: function(res) {
                let html = '';
                if(Array.isArray(res) && res.length > 0) {
                    res.forEach(p => {
                        let imgHtml = p.image ? `<img src="${p.image}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">` : `<i class="bi bi-box me-2 text-muted fs-4"></i>`;
                        html += `
                            <tr>
                                <td class="fw-bold text-secondary">#${p.id}</td>
                                <td><div class="d-flex align-items-center">${imgHtml}<span class="fw-semibold text-dark">${p.name}</span></div></td>
                                <td class="text-success fw-bold">${new Intl.NumberFormat('vi-VN').format(p.price)} đ</td>
                                <td><span class="text-muted small" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">${p.description || ''}</span></td>
                                <td class="text-end">
                                    <div class="btn-group border rounded-pill shadow-sm overflow-hidden">
                                        <button class="btn btn-sm btn-light btn-edit px-3 py-2" data-id="${p.id}" title="Sửa"><i class="bi bi-pencil-square text-warning"></i></button>
                                        <button class="btn btn-sm btn-light btn-delete px-3 py-2" data-id="${p.id}" title="Xóa"><i class="bi bi-trash text-danger"></i></button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = '<tr><td colspan="5" class="text-center text-muted py-5"><i class="bi bi-box-seam fs-1 d-block mb-3 opacity-25"></i>Chưa có sản phẩm nào.</td></tr>';
                }
                $('#product-list').html(html);
            },
            error: function() {
                $('#product-list').html('<tr><td colspan="5" class="text-center text-danger py-4">Có lỗi xảy ra khi tải danh sách sản phẩm.</td></tr>');
            }
        });
    }

    $('#btn-add-product').click(function() {
        $('#modalTitle').text('Thêm Sản phẩm');
        $('#productForm')[0].reset();
        $('#productId').val('');
    });

    $('#btn-save').click(function() {
        let form = $('#productForm')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        let id = $('#productId').val();
        let method = id ? 'PUT' : 'POST';
        let url = '/webbanhang/api/product' + (id ? '/' + id : '');
        
        let data = {
            name: $('#productName').val(),
            price: $('#productPrice').val(),
            category_id: $('#productCategory').val(),
            description: $('#productDescription').val()
        };

        // Disable button while processing
        let btn = $(this);
        let originalText = btn.text();
        btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Đang lưu...').prop('disabled', true);

        $.ajax({
            url: url,
            method: method,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(res) {
                $('#productModal').modal('hide');
                loadProducts();
                showToast(res.message || 'Lưu thành công!');
            },
            error: function(err) {
                let msg = 'Có lỗi xảy ra!';
                if(err.responseJSON && err.responseJSON.message) msg = err.responseJSON.message;
                showToast(msg, true);
            },
            complete: function() {
                btn.html(originalText).prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        
        // Indicate loading
        let btn = $(this);
        let origHtml = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm"></span>');
        
        $.ajax({
            url: '/webbanhang/api/product/' + id,
            method: 'GET',
            success: function(p) {
                $('#modalTitle').text('Chỉnh sửa Sản phẩm');
                $('#productId').val(p.id);
                $('#productName').val(p.name);
                $('#productPrice').val(p.price);
                $('#productCategory').val(p.category_id);
                $('#productDescription').val(p.description);
                $('#productModal').modal('show');
            },
            error: function() {
                showToast('Không thể lấy thông tin sản phẩm', true);
            },
            complete: function() {
                btn.html(origHtml);
            }
        });
    });

    $(document).on('click', '.btn-delete', function() {
        if(confirm('Bạn chắn chắn muốn xóa sản phẩm này chứ? Hành động này không thể hoàn tác.')) {
            let id = $(this).data('id');
            $.ajax({
                url: '/webbanhang/api/product/' + id,
                method: 'DELETE',
                success: function(res) {
                    loadProducts();
                    showToast(res.message || 'Đã xóa sản phẩm');
                },
                error: function(err) {
                    let msg = 'Xóa thất bại!';
                    if(err.responseJSON && err.responseJSON.message) msg = err.responseJSON.message;
                    showToast(msg, true);
                }
            });
        }
    });
});
</script>
