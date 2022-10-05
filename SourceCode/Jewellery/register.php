<?php
session_start();
include "connect.php";

$errors = [];
//  random OTP
function randomOTP($num = 6)
{
    $str = "0123456789";
    $str_len = strlen($str);
    $str_random = "";
    for ($i = 0; $i < $num; $i++) {
        $str_random .= $str[rand(0, $str_len - 1)];
    }
    return $str_random;
}

if (isset($_POST['register'])) {
    $fullname = htmlspecialchars($_POST['fullname']);
    $conn->real_escape_string($fullname);
    $email = htmlspecialchars($_POST['email']);
    $conn->real_escape_string($email);
    $phone = htmlspecialchars($_POST['phone']);
    $conn->real_escape_string($phone);
    $address = htmlspecialchars($_POST['address']);
    $conn->real_escape_string($address);
    $password = htmlspecialchars($_POST['password']);
    $conn->real_escape_string($password);
    $password_confirm = htmlspecialchars($_POST['password_confirm']);
    $conn->real_escape_string($password_confirm);

    if (empty($fullname)) {
        $errors['fullname'] = 'Fullname is required';
    }
    if (empty($phone)) {
        $errors['phone'] = 'Phone is required';
    }
    if (empty($address)) {
        $errors['address'] = 'address is required';
    }
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }
    if ($password != $password_confirm) {
        $errors['password_confirm'] = 'Password does not match';
    }

    $pattern = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    preg_match($pattern, $email, $matches);
    if (!$matches) {
        $errors['email'] = 'Email must be email format';
    }

    $sql = sprintf("SELECT * FROM account WHERE email = '%s'", $email);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $errors['email'] = "Email already exists!";
    }

    if (count($errors) == 0) {
        $codeOTP = randomOTP();
        require "PHPMailer-master/src/PHPMailer.php";
        require "PHPMailer-master/src/SMTP.php";
        require 'PHPMailer-master/src/Exception.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer(true); //true:enables exceptions
        try {
            $mail->SMTPDebug = 0; //0,1,2: chế độ debug
            $mail->isSMTP();
            $mail->CharSet  = "utf-8";
            $mail->Host = 'smtp.gmail.com';  //SMTP servers
            $mail->SMTPAuth = true; // Enable authentication
            $mail->Username = 'tien.pv.2054@aptechlearning.edu.vn'; // SMTP username
            $mail->Password = 'tien2003.';   // SMTP password
            $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
            $mail->Port = 465;  // port to connect to                
            $mail->setFrom('tien.pv.2054@aptechlearning.edu.vn', 'Tien');
            $mail->addAddress($email);
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = 'Send repassword';
            $noidungthu = "<h3>Dear you </h3>";
            $noidungthu .= "<p>Your verification code is : </p> <b>$codeOTP</b>";

            $mail->Body = $noidungthu;
            $mail->smtpConnect(array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )
            ));
            $mail->send();

            $password_hash = sha1($password);
            $sql = sprintf("INSERT INTO account(role, fullname, email, phone , address , password, code, status) values('user', '%s','%s','%s','%s','%s', %d, 'unverified')", $fullname, $email, $phone, $address, $password_hash,$codeOTP);
            $result = $conn->query($sql);
            if ($result) {
                echo "<script>alert(`We have sent you a verification code \nPlease check your email and enter the correct verification code to register for an account.`); location= 'sendOTP.php';</script>";
            } else {
                die('Error: ' . $conn->error);
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

if (isset($_GET['OTP'])) { 
    if($_GET['OTP'] == 'verified') {
        $sql = "UPDATE account SET code = 0, status = 'verified' ";
        $result = $conn->query($sql);
        if($result) {
            echo "<script> alert('Register account successfully!'); location='login.php'; </script>";
        } else {
            echo('Error: Update status failed!');
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
    <title>Register Page</title>
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
            max-width: 45rem;
        }

        .form-register a {
            color: #919191;
        }


        .form-register a:hover {
            color: #eb5809;
        }
    </style>
</head>

<body>
    <?php include "header.php" ?>
    <section class="my-5 m-auto pb-5" id="register_form">
        <div class="container">
            <div class="form-register">
                <form id="addNewUser" method="post">
                    <h2 class="text-center text-info mb-3"><i class="fa-regular fa-pen-to-square"></i> Register</h2>
                    <div class="input-form p-3">
                        <div class="form-group mb-3">
                            <label>Fullname </label>
                            <div class="input-group mt-1">
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= isset($fullname) ? $fullname : '' ?>" required>
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
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
                            <label>Phone Number </label>
                            <div class="input-group mt-1">
                                <input type="text" pattern="[0-9]{10,11}" class="form-control" id="phone" name="phone" value="<?= isset($phone) ? $phone : '' ?>" required>
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Address</label>
                            <div class="input-group mt-1">
                                <input type="text" class="form-control" id="address" name="address" value="<?= isset($address) ? $address : '' ?>" required>
                                <div class="input-group-text">
                                    <span class="fas fa-address-book"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Password </label>
                            <div class="input-group mt-1">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="input-group-text showpass">
                                    <span class="fas fa-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Confirm Password</label>
                            <div class="input-group mt-1">
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                                <div class="input-group-text showpass">
                                    <span class="fas fa-eye"></span>
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Register" name="register" class="btn btn-warning text-white w-100 btn-lg mt-4">
                        <div class="error-wrap">
                            <?php
                            foreach ($errors as $errors) {
                                echo '<div class="alert alert-danger mt-3" role="alert">' . $errors . '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </form>
                <div class="box-register mt-4 bg-light text-secondary text-center p-2">
                    <a href="login.php"> Back to Login <i class="ml-1 fa-solid fa-arrow-right"></i></a>
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
        $('#password_confirm').on('keyup', function(e) {
            if ($('#password').val() != $('#password_confirm').val()) {
                $('#password_confirm').addClass('is-invalid');
            } else {
                $('#password_confirm').removeClass('is-invalid');
            }
        });
    });
</script>

</html>