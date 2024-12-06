<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Danh sách sản phẩm</h1>
    <a href="/s4_php/product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($product->image): ?>
                        <img src="/s4_php/public/images/<?php echo $product->image; ?>" 
                            class="card-img-top img-fluid" 
                            alt="product Image" 
                            style="height: 200px; width: 100%; object-fit: contain;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/s4_php/product/show/<?php echo $product->id; ?>" 
                            class="text-decoration-none text-dark">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h5>
                        <p class="card-text"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="fw-bold">Giá: <?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?> VND</p>
                        <p class="text-muted">Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="d-flex justify-content-between">
                            <a href="/s4_php/product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="/s4_php/product/delete/<?php echo $product->id; ?>" 
                            class="btn btn-danger btn-sm" 
                            onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                            <a href="/s4_php/cart/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-sm">Thêm vào giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>