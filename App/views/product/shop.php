<?php include 'app/views/shares/header.php'; ?>
    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="price-all">
                            <label class="custom-control-label" for="price-all">All Price</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-1">
                            <label class="custom-control-label" for="price-1">$0 - $100</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-2">
                            <label class="custom-control-label" for="price-2">$100 - $200</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-3">
                            <label class="custom-control-label" for="price-3">$200 - $300</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-4">
                            <label class="custom-control-label" for="price-4">$300 - $400</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="price-5">
                            <label class="custom-control-label" for="price-5">$400 - $500</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div>
                <!-- Price End -->
                
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="">
                                <div class="input-group border" style="overflow: hidden;">
                                    <input type="text" class="form-control" placeholder="Search by name">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-transparent text-primary">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                            Sort by
                                        </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="#">Latest</a>
                                    <a class="dropdown-item" href="#">Popularity</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
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
                    <div class="col-12 pb-1">
                        <nav aria-label="Page navigation">
                          <ul class="pagination justify-content-center mb-3">
                            <li class="page-item disabled">
                              <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                              </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                              <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                              </a>
                            </li>
                          </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
<?php include 'app/views/shares/footer.php'; ?>
