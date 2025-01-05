<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Your cart</h1>

    <?php if (!empty($cart)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"> <!-- Điều chỉnh để hiển thị hàng ngang -->
            <?php foreach ($cart as $id => $item): ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <div class="row g-0">
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                <?php if ($item['image']): ?>
                                    <img src="/s4_php/public/images/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" 
                                        class="img-fluid rounded-start" 
                                        alt="product Image">
                                <?php else: ?>
                                    <img src="/s4_php/public/images/default.png" 
                                        class="img-fluid rounded-start" 
                                        alt="Default Image">
                                <?php endif; ?>
                            </div>

                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                    <p class="card-text"><strong>Price:</strong> $<?php echo htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p class="card-text"><strong>Quantity:</strong> 
                                        <form action="/s4_php/cart/updateQuantity/<?php echo $item['product_id']; ?>" method="POST" class="d-inline">
                                            <input type="number" name="quantity" 
                                                value="<?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                min="1" 
                                                class="form-control d-inline w-50 border" 
                                                required>
                                            <button type="submit" class="btn btn-primary btn-sm border">Update</button>
                                        </form>
                                    </p>
                                    <div class="d-flex justify-content-between mt-3">
                                        <a href="/s4_php/cart/remove/<?php echo $item['product_id']; ?>" 
                                           class="btn btn-danger btn-sm border" 
                                           onclick="return confirm('Are you sure you want to remove this product from your cart?');">
                                           Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="/s4_php/product/shop" class="btn btn-secondary border">Continue shopping</a>
            <a href="/s4_php/cart/checkout" class="btn btn-success border">Check out</a>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            <strong>Your shopping cart is empty.</strong>Add products to cart to continue shopping.
        </div>
        <div class="text-center">
            <a href="/s4_php/product/shop" class="btn btn-primary border">Continue shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
