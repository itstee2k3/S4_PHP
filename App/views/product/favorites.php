<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Danh Sách Yêu Thích</h1>
    
    <?php if (!empty($favorites)): ?>
        <div class="row">
            <?php foreach ($favorites as $id => $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">                       
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>                            
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
