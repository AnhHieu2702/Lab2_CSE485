<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></head>
<body>

<form method="POST" action="<?= APP_ROOT ?>/tlunews/public/index.php?action=login">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-1">

                                <h2 class="fw-bold mb-2 text-uppercase">Đăng nhập</h2>
                                <p class="text-white-50 mb-5">Hãy nhập tài khoản và mật khẩu!</p>

                                <!-- Email input -->
                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input type="email" id="typeEmailX" name="username" class="form-control form-control-lg" required placeholder="Tên đăng nhập"/>
                                </div>

                                <!-- Password input -->
                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <input type="password" id="typePasswordX" name="password" class="form-control form-control-lg" required placeholder="Mật khẩu"/>
                                </div>

                                <!-- Submit button -->
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit">Đăng nhập</button>
                            </div>

                            <!-- Sign up link -->
                            <div>
                                <p class="mb-0">Bạn chưa có tài khoản? <a href="#!" class="text-white-50 fw-bold">Đăng ký</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<!-- Hiển thị thông báo lỗi nếu có -->
<?php if (isset($error)) { echo "<p style='color:red;' class='text-center'>$error</p>"; } ?>

</body>
</html>
