<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Danh Sách Yêu Thích</h1>
    
    <?php if (!empty($favorites)): ?>
        <div class="row">
            <?php foreach ($favorites as $id => $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if ($item['image']): ?>
                            <img src="/s4_php/<?php echo $item['image']; ?>" alt="Product Image" class="card-img-top" style="max-height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="card-text">
                                <strong>Giá:</strong> <?php echo htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8'); ?> VND
                            </p>
                            <a href="/s4_php/Product/view/<?php echo $id; ?>" class="btn btn-primary">Xem Chi Tiết</a>
                            <a href="/s4_php/Product/removeFromFavorites/<?php echo $id; ?>" class="btn btn-danger">Xóa khỏi yêu thích</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            Bạn chưa có sản phẩm yêu thích nào.
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between mt-4">
        <a href="/s4_php/Product" class="btn btn-secondary">Tiếp tục mua sắm</a>
        <?php if (!empty($favorites)): ?>
            <a href="/s4_php/Product/checkout" class="btn btn-success">Thanh Toán</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
