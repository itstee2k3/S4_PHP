
    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">

        <?php if ($product): ?>

            <div class="row px-xl-5">
                <div class="col-lg-5 pb-5">
                    <div class="carousel-inner border">
                        <img src="/s4_php/public/images/<?php echo $product->image; ?>" alt="<?php echo $product->name; ?>" style="height: 300px; width: 100%; object-fit: contain;">
                    </div>
                </div>

                <div class="col-lg-7 pb-5">
                    <h3 class="font-weight-semi-bold"><?php echo $product->name; ?></h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">(50 Reviews)</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">$<?php echo $product->price; ?></h3>
                    <p class="mb-4"><?php echo $product->description; ?></p>
                    
                    <form action="/s4_php/cart/addToCart/<?php echo $product->id; ?>" method="POST">
                        <div class="d-flex align-items-center mb-4 pt-2">
                            <div class="input-group quantity mr-3 border" style="width: 130px; overflow: hidden;">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary btn-minus" type="button">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" name="quantity" class="form-control bg-secondary text-center" value="1" id="quantity" min="1" readonly>
                                <div class="input-group-btn">
                                    <button class="btn btn-primary btn-plus" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary px-3 border">
                                <i class="fa fa-shopping-cart mr-1"></i> Add To Cart
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        <?php endif; ?>

        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                        <p>Dolore magna est eirmod sanctus dolor, amet diam et eirmod et ipsum. Amet dolore tempor consetetur sed lorem dolor sit lorem tempor. Gubergren amet amet labore sadipscing clita clita diam clita. Sea amet et sed ipsum lorem elitr et, amet et labore voluptua sit rebum. Ea erat sed et diam takimata sed justo. Magna takimata justo et amet magna et.</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Additional Information</h4>
                        <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                  </ul> 
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                  </ul> 
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">1 review for "Colorful Stylish Shirt"</h4>
                                <div class="media mb-4">
                                    <img src="../../public/user/img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                    <div class="text-primary">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <form>
                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Your Name *</label>
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Your Email *</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">

                    <?php foreach ($products as $product): ?>

                        <div class="card product-item border-0">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
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
                                            style="height: 300px; width: 100%; object-fit: contain;">
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
        </div>
    </div>
    <!-- Products End -->
