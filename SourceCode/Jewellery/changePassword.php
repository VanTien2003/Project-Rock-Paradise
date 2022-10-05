<?php
session_start();
include "connect.php";

$errors = [];
if (isset($_POST['change'])) {
    $email = htmlspecialchars($_POST['email']);
    $conn->real_escape_string($email);
    $password_current = htmlspecialchars($_POST['password_current']);
    $conn->real_escape_string($password_current);
    $password_new = htmlspecialchars($_POST['password_new']);
    $conn->real_escape_string($password_new);

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }

    if (empty($password_current)) {
        $errors['password_current'] = 'Password current is required';
    }

    if (empty($password_new)) {
        $errors['password_new'] = 'Password new is required';
    }

    if (count($errors) == 0) {
        $current_password_hash = sha1($password_current);
        $new_password_hash = sha1($password_new);
        $sql = sprintf("SELECT * FROM account WHERE email = '%s' AND password = '%s'", $email, $current_password_hash);
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sql = sprintf("UPDATE account SET password = '%s' WHERE email = '%s'", $new_password_hash, $email);
            $result = $conn->query($sql);
            if ($result) {
                echo "<script> alert('Update password successfully') </script>";
            } else {
                $errors['password_new'] = "Update password failed";
            }
        } else {
            $errors['password_current'] = "Current password or Email is not correct";
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
    <title>Change Password</title>
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
        #register_form {
            max-width: 35rem;
        }
    </style>
</head>

<body>
    <?php include "header.php" ?>
    <section class="my-5 m-auto pb-5" id="register_form">
        <div class="container">
            <div class="form-register">
                <form id="addNewUser" method="post">
                    <h2 class="text-center text-info mb-3"><i class="fa-solid fa-arrows-rotate"></i><br> Change Your Password</h2>
                    <div class="input-form p-3">
                        <div class="form-group mb-3">
                            <label>Email </label>
                            <div class="input-group mt-1">
                                <input type="email" class="form-control" id="email" name="email" value="<?= isset($email) ? $email : '' ?>" required>
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Password old</label>
                            <div class="input-group mt-1">
                                <input type="password" class="form-control" id="password_current" name="password_current" required>
                                <div class="input-group-text showpass">
                                    <span class="fas fa-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Password new</label>
                            <div class="input-group mt-1">
                                <input type="password" class="form-control" id="password_new" name="password_new" required>
                                <div class="input-group-text showpass">
                                    <span class="fas fa-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="error-wrap">
                            <?php
                            foreach ($errors as $errors) {
                                echo '<div class="alert alert-danger mt-3" role="alert">' . $errors . '</div>';
                            }
                            ?>
                        </div>
                        <input type="submit" value="Change" name="change" class="btn btn-warning btn-lg text-white w-100  mt-3">
                    </div>
                </form>
                <div class="box-register mt-2 px-3">
                    <a href="login.php" class="btn btn-secondary text-white w-100 ">Cancel</a>
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