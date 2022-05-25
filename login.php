<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login | Hoàng Kiên Mobile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description">
    <meta content="Coderthemes" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- App favicon -->
    <link rel="shortcut icon" href="./img/icon.png">

    <!-- App css -->
    <link href="./admin/assets\css\bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet">
    <link href="./admin/assets\css\icons.min.css" rel="stylesheet" type="text/css">
    <link href="./admin/assets\css\app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet">
</head>

<body style="background-image: linear-gradient(180deg, #c7d1ea, #a3b0d1)">
    <?php
    require_once './module/db.php';
    require_once './header.php';

    if (isset($_SESSION['user'])) {
        header('Location: trang-chu.php');
    }
    if (isset($_POST['submit'])) {
        $error = array();
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (strlen($username) <= 4) {
            $error['username'] = 'Tên đăng nhập phải trên 4 kí tự';
        } elseif (strlen($username) >= 16) {
            $error['username'] = 'Tên đăng nhập phải nhỏ hơn 16 kí tự';
        } else {
            $sql = "SELECT * FROM user WHERE username = '$username'";
            $query = $db->prepare($sql);
            $query->execute();
            if ($query->rowCount() == 0) {
                $error['username'] = 'Tên đăng nhập không tồn tại';
            }
        }
        if (count($error) == 0) {
            $sql = "SELECT * FROM user WHERE username = '$username' AND password = '" . md5($password) . "'";
            $query = $db->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $user = $query->fetch(PDO::FETCH_ASSOC);
                if ($user['chan_user'] == 1) {
                    $error['username'] = 'Tài khoản đã bị khoá';

                } else {
                    unset($user['mat_khau']);
                    $_SESSION['user'] = $user;

                    if ($user['phan_quyen'] == 1) {
                        $_SESSION['verified']['title'] = "Đăng nhập thành công";
                        $_SESSION['verified']['content'] = "Bạn sẽ được chuyển hướng đến Dashboard";
                        $_SESSION['verified']['link'] = "./admin/index.php";
                        header("Location: verified.php");

                    } else {
                        if (isset($_GET['idsp'])) {
                            $_SESSION['verified']['title'] = "Đăng nhập thành công";
                            $_SESSION['verified']['content'] = "Bạn sẽ được chuyển hướng đến trang sản phẩm";
                            $_SESSION['verified']['link'] = "./product-detail.php?id=".$_GET["idsp"];
                            header("Location: verified.php");
                            
                        }
                        else {
                            $_SESSION['verified']['title'] = "Đăng nhập thành công";
                            $_SESSION['verified']['content'] = "Bạn sẽ được chuyển hướng đến Trang chủ";
                            $_SESSION['verified']['link'] = "./trang-chu.php";
                            header("Location: verified.php");
                        }
                    }
                }
            } else {
                $error['password'] = 'Mật khẩu không chính xác';
            }
        }
    }
    ?>
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="text-center account-logo-box">
                            <div class="mt-2 mb-2">
                                <span class="title">Đăng nhập</span>
                            </div>
                        </div>
                        <div class="card-body">

                            <form action="" method="POST">

                                <div class="row log-img">
                                    <div class="col-sm-12 text-center">
                                        <p class="text-muted"><img src="./assets/img/user.png" width="80px"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" value="<?php echo (isset($username)) ? $username : '' ?>" type="text" name="username" placeholder="Tên đăng nhập" required>
                                    <span class="error"><?php echo (isset($error['username'])) ? $error['username'] : '' ?></span>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" value="<?php echo (isset($password)) ? $password : '' ?>" type="password" name="password" placeholder="Mật khẩu" required>
                                    <span class="error"><?php echo (isset($error['password'])) ? $error['password'] : '' ?></span>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12 text-right">
                                        <p class="text-muted">Bạn chưa có tài khoản? <a href="register.php" class="text-primary ml-1"><b>Đăng ký</b></a></p>
                                    </div>
                                </div>

                                <div class="form-group account-btn text-center mt-2">
                                    <div class="col-12">
                                        <button class="btn width-md btn-bordered btn-danger waves-effect waves-light" name="submit" type="submit">Đăng nhập</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <script>

                    </script>


                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="assets\js\vendor.min.js"></script>

    <!-- App js -->
    <script src="assets\js\app.min.js"></script>

</body>

</html>