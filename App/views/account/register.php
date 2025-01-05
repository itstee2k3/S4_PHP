<?php include 'app/views/shares/header.php'; ?>

<div class="">
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border shadow-lg my-5" style="overflow: hidden;">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image">
                            <img src="../public/user/img/login.jpeg" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-4">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome!</h1>
                                </div>
                                <form class="user" action="/s4_php/account/save" method="post">
                                        <!-- Hiển thị lỗi -->
                                        <?php if (isset($errors) && !empty($errors)): ?>
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    <?php foreach ($errors as $err): ?>
                                                        <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user border"
                                            id="username"
                                            placeholder="Username" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user border"
                                            id="fullname"
                                            placeholder="Fullname" name="fullname" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user border"
                                            name="password" id="password" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user border"
                                            name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
                                    </div>

                                    <button class="btn btn-primary btn-user btn-block border" type="submit">Register</button>

                                    <hr>
                                    <a href="#" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Login with Google
                                    </a>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="#">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<?php include 'app/views/shares/footer.php'; ?>
