<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Pay</h1>

    <form method="POST" action="/s4_php/cart/processCheckout">
        <div class="form-group mb-3">
            <label for="phone" class="form-label">Phone Number:</label>
            <input type="text" id="phone" name="phone" class="form-control border" placeholder="Nhập số điện thoại" required>
        </div>

        <div class="form-group mb-3">
            <label for="address" class="form-label">Address:</label>
            <textarea id="address" name="address" class="form-control border" rows="4" placeholder="Nhập địa chỉ giao hàng" required></textarea>
        </div>

        <div class="form-group mb-4">
            <h4 class="text-end">Tổng số tiền: <span class="text-primary">
                <?php echo isset($totalPrice) ? number_format($totalPrice, 0, ',', '.') . ' đ' : '0 đ'; ?>
                </span
            ></h4>
        </div>

        <div class="text-ce anter">
            <button type="submit" class="btn btn-primary px-4 border">Thanh Toán</button>
            <a href="/s4_php/cart/" class="btn btn-secondary px-4 ms-2 border">Quay lại Giỏ Hàng</a>
        </div>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>
