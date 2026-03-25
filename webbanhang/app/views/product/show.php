<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/webbanhang/Product/index" class="text-decoration-none text-muted">Cửa hàng</a></li>
            <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">
                <?php echo htmlspecialchars($product->category_name ?? 'Sản phẩm'); ?>
            </li>
        </ol>
    </nav>

    <div class="row g-5 align-items-start">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden product-image-wrapper">
                <?php if (!empty($product->image)): ?>
                    <img src="/webbanhang/<?php echo $product->image; ?>" 
                         class="img-fluid w-100 object-fit-cover shadow-sm" 
                         style="min-height: 450px;" alt="Product Image">
                <?php else: ?>
                    <img src="https://via.placeholder.com/600x600?text=No+Image" 
                         class="img-fluid w-100 object-fit-cover" alt="No Image">
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6 ps-md-5">
            <div class="product-info-header mb-4">
                <h1 class="display-4 fw-bold text-dark mb-2"><?php echo htmlspecialchars($product->name); ?></h1>
                <div class="d-flex align-items-center gap-3">
                    <h2 class="text-danger fw-bold display-6 mb-0">
                        <?php echo number_format($product->price, 0, ',', '.'); ?> <small class="fs-6">VNĐ</small>
                    </h2>
                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill small fw-bold">
                        <i class="bi bi-check2-circle me-1"></i>Sẵn sàng giao
                    </span>
                </div>
            </div>

            <div class="product-description mb-5">
                <h5 class="fw-bold text-secondary border-bottom pb-2 mb-3">Thông tin chi tiết</h5>
                <p class="text-muted lh-lg fs-5">
                    <?php echo nl2br(htmlspecialchars($product->description)); ?>
                </p>
            </div>

            <div class="d-flex flex-wrap gap-3 align-items-center mt-auto">
                <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" 
                   class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-cart-plus-fill fs-4"></i> THÊM VÀO GIỎ HÀNG
                </a>
                
                <div class="d-flex gap-2">
                    <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" 
                       class="btn btn-outline-warning btn-action-round shadow-sm" title="Chỉnh sửa">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                       class="btn btn-outline-danger btn-action-round shadow-sm" 
                       onclick="return confirm('Xóa món này khỏi hệ thống?');" title="Xóa">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>

            <div class="mt-5 pt-4 border-top">
                <a href="/webbanhang/Product/index" class="text-decoration-none text-muted fw-bold">
                    <i class="bi bi-arrow-left me-2"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>