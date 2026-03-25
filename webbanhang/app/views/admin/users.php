<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Quản Lý Người Dùng</h4>
        <span class="badge bg-light text-dark border p-2">Tổng cộng: <?php echo count($users); ?></span>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted uppercase" style="font-size: 0.75rem;">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="py-3">Tên Đăng Nhập</th>
                        <th class="py-3">Họ Tên</th>
                        <th class="py-3">Vai Trò</th>
                        <th class="py-3">Trạng Thái</th>
                        <th class="py-3 text-end px-4">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td class="px-4 text-muted small">#<?php echo $user->id; ?></td>
                        <td><span class="fw-bold"><?php echo $user->username; ?></span></td>
                        <td><?php echo $user->fullname; ?></td>
                        <td>
                            <span class="badge rounded-pill <?php echo $user->role === 'admin' ? 'bg-danger' : 'bg-info'; ?> bg-opacity-10 <?php echo $user->role === 'admin' ? 'text-danger' : 'text-info'; ?> px-3">
                                <?php echo strtoupper($user->role); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($user->is_locked): ?>
                                <span class="badge bg-danger rounded-pill px-3">BỊ KHÓA</span>
                            <?php else: ?>
                                <span class="badge bg-success rounded-pill px-3">HOẠT ĐỘNG</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end px-4">
                            <?php if ($user->role !== 'admin'): ?>
                                <?php if ($user->is_locked): ?>
                                    <a href="/webbanhang/Admin/unlockUser/<?php echo $user->id; ?>" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold">
                                        <i class="bi bi-unlock-fill me-1"></i> Mở khóa
                                    </a>
                                <?php else: ?>
                                    <a href="/webbanhang/Admin/lockUser/<?php echo $user->id; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">
                                        <i class="bi bi-lock-fill me-1"></i> Khóa lại
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
