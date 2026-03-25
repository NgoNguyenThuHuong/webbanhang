<?php include 'app/views/shares/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex align-items-center mb-4">
                <a href="/webbanhang/Category/" class="btn btn-outline-secondary btn-sm rounded-circle me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="fw-bold mb-0">Chỉnh sửa danh mục</h2>
            </div>

            <form method="POST" action="/webbanhang/Category/update">
                <input type="hidden" name="id" value="<?php echo $category->id; ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên danh mục</label>
                    <input type="text" name="name" class="form-control rounded-3" 
                           value="<?php echo htmlspecialchars($category->name); ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Mô tả danh mục</label>
                    <textarea name="description" class="form-control rounded-3" 
                              rows="4"><?php echo htmlspecialchars($category->description); ?></textarea>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-warning btn-lg rounded-pill shadow-sm text-white fw-bold">
                        <i class="bi bi-save me-2"></i>Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>