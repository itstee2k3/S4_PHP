<?php include 'app/views/shares/header.php'; ?>
    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Offer Start -->
    <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="../public/user/img/offer-1.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Spring Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                    <img src="../public/user/img/offer-2.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Winter Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Trandy Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php foreach ($products as $product): ?>

                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border mb-4"  style="overflow: hidden;">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent p-0">
                            <div class="d-flex justify-content-between position-absolute" style="z-index:5">
                                <?php 
                                    // Kiểm tra nếu sản phẩm đã có trong danh sách yêu thích
                                    $is_favorite = in_array($product->id, $favorite_product_ids); // $favorite_product_ids là mảng ID sản phẩm yêu thích
                                    if ($is_favorite):
                                ?>
                                    <!-- Nút bỏ yêu thích (màu đỏ) -->
                                    <a href="/s4_php/favorite/removeFromFavorites/<?php echo $product->id; ?>" 
                                    class="btn btn-danger btn-sm border" style="border: 1px solid #dc3545 !important;">
                                        <i class="fas fa-heart"></i> 
                                    </a>
                                <?php else: ?>
                                    <!-- Nút yêu thích (màu mặc định) -->
                                    <a href="/s4_php/favorite/addToFavorites/<?php echo $product->id; ?>" 
                                    class="btn btn-outline-danger btn-sm border" style="border: 1px solid #dc3545 !important;">
                                        <i class="fas fa-heart"></i> 
                                    </a>
                                <?php endif; ?>
                            </div>

                            <?php if ($product->image): ?>
                                <img src="/s4_php/public/images/<?php echo $product->image; ?>" 
                                    class="img-fluid w-100" 
                                    alt="product Image"
                                    style="height: 200px; width: 100%; object-fit: contain;">
                            <?php endif; ?>
                        </div>

                        <div class="card-body text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </h6>
                            <div class="d-flex justify-content-center">
                                <h6>
                                    $<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>
                                </h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light">
                            <a href="/s4_php/product/show/<?php echo $product->id; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="/s4_php/cart/addToCart/<?php echo $product->id; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Products End -->

<?php include 'app/views/shares/footer.php'; ?>
