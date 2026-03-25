<?php include 'app/views/shares/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex align-items-center mb-4">
                <a href="/webbanhang/Product/" class="btn btn-outline-secondary btn-sm rounded-circle me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="fw-bold mb-0">Chỉnh sửa sản phẩm</h2>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/webbanhang/Product/update">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control rounded-3" 
                               value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Giá bán (VNĐ)</label>
                        <input type="number" name="price" class="form-control rounded-3" step="0.01"
                               value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Danh mục</label>
                    <select name="category_id" class="form-select rounded-3" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mô tả chi tiết</label>
                    <textarea name="description" class="form-control rounded-3" rows="3" required><?php 
                        echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); 
                    ?></textarea>
                </div>

                <div class="mb-4">
                    <!-- Image field removed as part of API refactor -->
                </div>

                <div class="border-top pt-4">
                    <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                        <i class="bi bi-save me-2"></i>Lưu thay đổi
                    </button>
                    <a href="/webbanhang/Product/" class="btn btn-light px-4 rounded-pill ms-2">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>