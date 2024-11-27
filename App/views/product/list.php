<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Danh Sách Sản Phẩm</h1>
        <a href="/demo1/Product/add" class="btn btn-success">Thêm Sản Phẩm Mới</a>
    </div>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-truncate">
                            <a href="/demo1/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                                <?php echo htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h5>
                        <?php if ($product->image): ?>
                            <img src="/demo1/<?php echo $product->image; ?>" alt="Product Image" style="max-width: 50px;">
                        <?php endif; ?>
                        <p class="card-text text-muted small text-truncate">
                            <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        
                        <div class="d-flex justify-content-between">
                            <a href="/demo1/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="/demo1/Product/delete/<?php echo $product->id; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                Xóa
                            </a>
                            <a href="/demo1/Product/addToFavorites/<?php echo $product->id; ?>" class="btn btn-primary btn-sm">Thích</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>