<?php include 'app/views/shares/header.php'; ?>

<div class="row mb-4 align-items-center">

<div class="col-md-6">
<h1 class="fw-bold">Quản lý Danh mục</h1>
</div>

<div class="col-md-6 text-end">
<a href="/webbanhang/Category/add" class="btn btn-success rounded-pill">
<i class="bi bi-plus-circle"></i> Thêm danh mục
</a>
</div>

</div>

<div class="card shadow-sm">

<table class="table table-hover">

<thead class="table-light">
<tr>
<th>ID</th>
<th>Tên danh mục</th>
<th>Mô tả</th>
<th>Thao tác</th>
</tr>
</thead>

<tbody>

<?php foreach ($categories as $category): ?>

<tr>

<td><?php echo $category->id; ?></td>

<td class="fw-bold text-success">
<?php echo htmlspecialchars($category->name); ?>
</td>

<td>
<?php echo htmlspecialchars($category->description); ?>
</td>

<td>

<a href="/webbanhang/Category/edit/<?php echo $category->id; ?>" class="btn btn-sm btn-warning">
<i class="bi bi-pencil"></i>
</a>

<a href="/webbanhang/Category/delete/<?php echo $category->id; ?>" 
class="btn btn-sm btn-danger"
onclick="return confirm('Xóa danh mục này?')">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<?php include 'app/views/shares/footer.php'; ?>