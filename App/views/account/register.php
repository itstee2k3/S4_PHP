<?php include 'app/views/shares/header.php'; ?>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form action="/s4_php/account/save" method="post">
                            <h2 class="fw-bold mb-4 text-uppercase">Register</h2>

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

                            <div class="form-outline form-white mb-4">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control form-control-lg" required />
                            </div>

                            <div class="form-outline form-white mb-4">
                                <label class="form-label" for="fullname">Full Name</label>
                                <input type="text" id="fullname" name="fullname" class="form-control form-control-lg" required />
                            </div>

                            <div class="form-outline form-white mb-4">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                            </div>

                            <div class="form-outline form-white mb-4">
                                <label class="form-label" for="confirmpassword">Confirm Password</label>
                                <input type="password" id="confirmpassword" name="confirmpassword" class="form-control form-control-lg" required />
                            </div>

                            <button type="submit" class="btn btn-outline-light btn-lg px-5">Register</button>

                            <p class="mt-3 mb-0">Already have an account? <a href="/s4_php/account/login" class="text-white-50 fw-bold">Login</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>
