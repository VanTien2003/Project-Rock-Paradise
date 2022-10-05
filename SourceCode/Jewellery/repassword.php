<?php
session_start();
include "connect.php";

$errors = [];
//  Reset Password
function randomstring($num = 10)
{
    $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str_len = strlen($str);
    $str_random = "";
    for ($i = 0; $i < $num; $i++) {
        $str_random .= $str[rand(0, $str_len - 1)];
    }
    return $str_random;
}

if (isset($_POST['reset'])) {
    $email = htmlspecialchars($_POST['email']);
    $conn->real_escape_string($email);
    $phone = htmlspecialchars($_POST['phone']);
    $conn->real_escape_string($phone);

    if (empty($phone)) {
        $errors['phone'] = 'Phone is required';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }

    $pattern = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    preg_match($pattern, $email, $matches);
    if (!$matches) {
        $errors['email'] = 'Email must be email format';
    }

    if (count($errors) == 0) {
        $sql = sprintf("SELECT * from account where email = '%s'", $email);
        $result = $conn->query($sql);
        $account = $result->fetch_assoc();
        if ($result->num_rows > 0) {
            $password_new = randomstring();
            $sql = sprintf("UPDATE account SET password = '%s' WHERE email = '%s' AND phone = '%s' ", sha1($password_new), $email, $phone);
            $result = $conn->query($sql);
            if ($result) {
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
                    $noidungthu = "<h3>Dear ".$account['fullname']." </h3>";
                    $noidungthu .= "<p>We have receive a request to re-issue your password recently.</p>";
                    $noidungthu .= "<p>We have updated and sent you a new password </p>";
                    $noidungthu .= "<p>Your new password is : </p> <b>$password_new</b>";
                    
                    $mail->Body = $noidungthu;
                    $mail->smtpConnect(array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                            "allow_self_signed" => true
                        )
                    ));
                    $mail->send();
                    echo "<script>alert('Send mail successfully!'); location='login.php';</script>";
                } catch (Exception $e) {
                    echo 'Error: '. $e->getMessage();
                }
            } else {
                die("Error: " . $conn->error);
            }
        } else {
            $errors['email'] = "Email or Phone is not correct";
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
    <title>Forgot Password</title>
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
                    <h2 class="text-center text-primary mb-3"><i class="fa-solid fa-rotate-right"></i> <br> Reset Your Password</h2>
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
                            <label>Phone Number </label>
                            <div class="input-group mt-1">
                                <input type="text" pattern="[0-9]{10,11}" class="form-control" id="phone" name="phone" value="<?= isset($phone) ? $phone : '' ?>" required>
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
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
                        <input type="submit" value="Reset" name="reset" class="btn btn-success btn-lg text-white w-100  mt-3">
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

</html>