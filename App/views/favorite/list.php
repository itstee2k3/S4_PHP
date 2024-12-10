<?php include 'app/views/shares/header.php'; ?>


<div class="container mt-5">
    <h1 class="text-center">Danh Sách Yêu Thích</h1>
    <?php if (!empty($favorites)): ?>
        <div class="row">
            <?php foreach ($favorites as $product): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="/s4_php/public/images/<?php echo !empty($product['image']) ? $product['image'] : '/path/to/default/image.jpg'; ?>" class="card-img-top img-fluid" 
                            style="height: 200px; width: 100%; object-fit: contain;" alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</p>
                            <p class="card-text text-muted">Đã thêm: <?php echo $product['time_elapsed']; ?></p>
                            <!-- <p>Đã thêm: <span class="time-elapsed" data-time="<?php echo $product['created_at']; ?>"><?php echo $product['time_elapsed']; ?></span></p> -->

                            <a href="/s4_php/favorite/removeFromFavorites/<?php echo $product['id']; ?>" class="btn btn-danger">Xoá</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center">Chưa có sản phẩm nào trong danh sách yêu thích.</p>
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

