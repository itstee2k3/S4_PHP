<?php include 'app/views/shares/header.php'; ?>



<div class="container-fluid">
    <h1 class="text-center">List Favorite</h1>
    <?php if (!empty($favorites)): ?>
        <div class="row px-xl-5 pb-3">
            <?php foreach ($favorites as $product): ?>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border mb-4"  style="overflow: hidden;">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent p-0">
                            <div class="d-flex justify-content-between position-absolute" style="z-index:5">
                                <a href="/s4_php/favorite/removeFromFavorites/<?php echo $product['id']; ?>" 
                                    class="btn btn-danger btn-sm border" style="border: 1px solid #dc3545 !important;">
                                    <i class="fas fa-heart"></i> 
                                </a>
                            </div>

                            <?php if ($product['image']): ?>
                                <img src="/s4_php/public/images/<?php echo $product['image']; ?>" 
                                    class="img-fluid w-100" 
                                    alt="product Image"
                                    style="height: 200px; width: 100%; object-fit: contain;">
                            <?php endif; ?>
                        </div>
                        <div class="card-body text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">
                                <?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>
                            </h6>
                            <div class="d-flex justify-content-center">
                                <h6>
                                    $<?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?>
                                </h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light">
                            <a href="/s4_php/product/show/<?php echo $product['id']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="/s4_php/cart/addToCart/<?php echo $product['id']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                            <!-- <a href="/s4_php/favorite/removeFromFavorites/<?php echo $product['id']; ?>" class="btn btn-danger">Xoá</a> -->
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center">There are no products in your favorites list yet.</p>
    <?php endif; ?>
</div>

<!-- <script>
    function updateElapsedTime() {
        const elements = document.querySelectorAll('.time-elapsed');

        elements.forEach(function(element) {
            const createdAt = element.getAttribute('data-time'); // Lấy thời gian tạo sản phẩm từ data-time
            const timeElapsed = calculateTimeElapsed(createdAt);
            element.textContent = timeElapsed; // Cập nhật nội dung hiển thị
        });
    }

    function calculateTimeElapsed(createdAt) {
        const createdTime = new Date(createdAt); // Chuyển đổi thời gian từ chuỗi vào Date object
        const now = new Date(); // Thời gian hiện tại

        const diff = now - createdTime; // Tính khoảng thời gian giữa hiện tại và thời gian tạo

        const seconds = Math.floor(diff / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);

        if (days > 0) {
            const hoursRemaining = hours % 24;
            const minutesRemaining = minutes % 60;
            const secondsRemaining = seconds % 60;
            return `${days} ngày ${hoursRemaining} giờ ${minutesRemaining} phút ${secondsRemaining} giây trước`;
        } else if (hours > 0) {
            const minutesRemaining = minutes % 60;
            const secondsRemaining = seconds % 60;
            return `${hours} giờ ${minutesRemaining} phút ${secondsRemaining} giây trước`;
        } else if (minutes > 0) {
            const secondsRemaining = seconds % 60;
            return `${minutes} phút ${secondsRemaining} giây trước`;
        } else {
            return `${seconds} giây trước`;
        }
    }

    // Cập nhật thời gian mỗi giây
    setInterval(updateElapsedTime, 1000); // Gọi hàm mỗi giây (1000ms)
</script> -->


<?php include 'app/views/shares/footer.php'; ?>

