<?php include 'app/views/shares/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h2 class="fw-bold mb-4">Thêm sản phẩm mới</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/webbanhang/Product/save">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Giá bán (VNĐ)</label>
                        <input type="number" name="price" class="form-control rounded-3" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Danh mục</label>
                    <select name="category_id" class="form-select rounded-3">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>"><?php echo htmlspecialchars($category->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mô tả sản phẩm</label>
                    <textarea name="description" class="form-control rounded-3" rows="3"></textarea>
                </div>
                <div class="mb-4">
                    <!-- Image field removed as part of API refactor -->
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">Lưu sản phẩm</button>
                    <a href="/webbanhang/Product/" class="btn btn-light px-4 rounded-pill">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>