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
            $sql = sprintf("SELECT * FROM account WHERE email = '%s' AND password = '%s' AND role = 'admin'",$email, sha1($password));
            $result = $conn->query($sql);
            if($result->num_rows > 0 ) {
                $_SESSION['email'] = $email;
                header('location: listProduct.php');
            } else {
                $errors['login'] = 'Login Failed';
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
    <title>Login Admin Page</title>
    <link rel="shortcut icon" href="../public/font/favicon.ico" type="image/x-icon" />
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />

    <link rel="stylesheet" href="../public/css/loginAdmin.css">
</head>
<body>
    <section>
        <div class="container">
            <div id="wrapper" class="d-flex justify-content-center align-items-center">
                <form action="" method="post" id="form-login" class="rounded-lg">
                    <h2 class="form-heading text-center mb-5">Login Admin</h2>
                    <div class="form-group my-4">
                        <i class="far fa-user pt-2 pr-2"></i>
                        <input type="text" name="email" class="form-input pb-2 mt-1" placeholder="Email address" required>
                    </div>
                    <div class="form-group mb-4">
                        <i class="fas fa-key pt-2 pr-2"></i>
                        <input type="password" name="password" class="form-input pb-2 mt-1" placeholder="Password" required>
                        <div class="showpass">
                            <span class="far fa-eye pt-2"></span>
                        </div>
                    </div>
                    <?php 
                        foreach ($errors as $errors) {
                            echo '<div class="alert alert-danger" role="alert">'.$errors.'</div>';
                        }
                    ?>
                    <input type="submit" value="Login" class="btn-submit w-100 mt-3 rounded" name="login">
                </form>
            </div>
        </div>
    </section>
</body>
<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(e) {
        $('.showpass').on('click', function(e) {
            e.preventDefault();
            let self = $(this);
            let input = self.parents('.form-group').find('input');
            input.attr('type') == 'password' ? input.attr('type', 'text') : input.attr('type', 'password');
            self.find('span').toggleClass('fa-eye fa-eye-slash');
        });
    });
</script>
</html>