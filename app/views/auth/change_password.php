<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<form method="POST" action="/tlunews/public/index.php?action=change">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-1">
                                <h2 class="fw-bold mb-2 text-uppercase">Đổi Mật Khẩu</h2>
                                <p class="text-white-50 mb-5">Hãy nhập mật khẩu cũ và mật khẩu mới!</p>

                                <!-- Mật khẩu cũ input -->
                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="current_password" name="current_password" class="form-control form-control-lg" required placeholder="Mật khẩu cũ"/>
                                </div>

                                <!-- Mật khẩu mới input -->
                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="new_password" name="new_password" class="form-control form-control-lg" required placeholder="Mật khẩu mới"/>
                                </div>

                                <!-- Xác nhận mật khẩu mới input -->
                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg" required placeholder="Xác nhận mật khẩu mới"/>
                                </div>

                                <!-- Submit button -->
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Đổi Mật Khẩu</button>
                            </div>

                            <!-- Sign up link (nếu có) -->
                            <div>
                                <p class="mb-0">Quay lại <a href="/tlunews/public/index.php?action=login" class="text-white-50 fw-bold">Trang Đăng Nhập</a></p>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
