<?php 
    session_start();
    include "connect.php";
    
    $errors = [];
    if(isset($_POST['login'])) {
        $email = htmlspecialchars($_POST['email']);
        $conn->real_escape_string($email);
        $password = htmlspecialchars($_POST['password']);
        $conn->real_escape_string($password);
        if(empty($email)) {
            $errors['email'] = 'Email is required';
        }
        if(empty($password)) {
            $errors['password'] = 'Password is required';
        }
        $pattern = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        preg_match($pattern, $email, $matches);
        if(!$matches) {
            $errors['email'] = 'Email must be email format';
        }
        if(count($errors) == 0) {
            $sql = sprintf("SELECT * FROM account WHERE email = '%s' AND password = '%s' AND role = 'user'",$email, sha1($password));
            $result = $conn->query($sql);
            if($result->num_rows > 0 ) {
                $_SESSION['user'] = $email;
                $account = $result->fetch_assoc();
                if(isset($_GET['order'])) {
                    header('location: Checkout.php');
                } elseif($_GET['product_id']) {
                    $account_id = $account['id'];
                    $product_id = $_GET['product_id'];
                    $content = $_SESSION['content'];
                    $sql = sprintf("INSERT INTO comments(account_id, product_id, content) VALUES('%s', '%s', '%s')", $account_id, $product_id, $content);
                    $result = $conn->query($sql);
                    if($result) {
                        echo "<script>alert(`Your comment is submited! \nIt will showed soon.`); location='home.php';</script>";
                    }else {
                        echo "Error: " . $conn->error;
                    }
                }
                else {
                    header('location: home.php');
                }
            } else {
                $errors['login'] = 'Email or Password is not correct ';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="shortcut icon" href="public/font/favicon.ico" type="image/x-icon" />
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" href="./public/css/header.css">
    <link rel="stylesheet" href="./public/css/footer.css" />
    <style>
        #login_form {
            max-width: 32rem;
        }

        .form-login hr.sidebar-divider {
            border-top: 1px solid #000;
            
        }

        .form-login a {
            color: #919191;
        }


        .form-login a:hover {
            color: #eb5809;
        }
    </style>
</head>
<body>
<?php include "header.php"?>
    <section class="my-5 m-auto pb-5" id="login_form">
        <div class="container">         
            <div class="form-login">
                <form action="" method="post">
                    <div class="logo text-center">
                        <a href="">
                            <img src="./public/images/logo/logo7.jpg" alt="Logo" width="180" height="100">
                        </a>
                    </div>
                    <!-- Divider -->
                    <hr class="sidebar-divider mt-0 mb-4">

                    <h2 class="text-center text-success mb-4">Great to have you back!</h2>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <div class="input-group mt-1">
                            <input type="email" name="email" class="form-control" value="<?= isset($email) ? $email : '' ?>" required>
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Password</label>
                        <div class="input-group mt-1">
                            <input type="password" name="password" class="form-control" required>
                            <div class="input-group-text showpass">
                                <span class="fas fa-eye"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <a href="repassword.php" class="ForgotPassword">Forgot your password?</a>
                        <a href="changePassword.php" class="ForgotPassword">Change your password?</a>
                    </div>
                    <?php 
                        foreach ($errors as $errors) {
                            echo '<div class="alert alert-danger mt-2" role="alert" >'.$errors.'</div>';
                        }
                    ?>
                    <div class="form-group">
                        <input type="submit" value="Login" class="btn btn-info text-white w-100 btn-lg mt-4" name="login">
                    </div>                 
                </form>
                <div class="box-register mt-4 bg-light text-secondary text-center p-2">
                    <span class="mr-2">Don't have an account yet? </span>
                    <a href="register.php"> Register now <i class="ml-1 fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php" ?>
</body>
<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(e) {
        $('.showpass').on('click', function(e) {
            e.preventDefault();
            let self = $(this);
            let input = self.parents('.input-group').find('input');
            input.attr('type') == 'password' ? input.attr('type', 'text') : input.attr('type', 'password');
            self.find('span').toggleClass('fa-eye fa-eye-slash');
        });
    });
</script>
</html>