<?php
session_start();
include "connect.php";

$errors = [];


if (isset($_POST['confirm'])) {
    $OTP = htmlspecialchars($_POST['OTP']);
    $conn->real_escape_string($OTP);

    if (empty($OTP)) {
        $errors['OTP'] = 'OTP is required';
    }

    if (count($errors) == 0) {
        $sql = sprintf("SELECT * FROM account WHERE code = %d ", $OTP);
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            header('location: register.php?OTP=verified');
        } else {
            $errors['confirm'] = "Your verification code is not correct";
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
    <title>Send OTP</title>
    <link rel="shortcut icon" href="public/font/favicon.ico" type="image/x-icon" />
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- boostrap 4.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <section class="sendOTP mt-5">
        <div class="container">
            <form action="" method="post">
                <h2>Enter OTP</h2>
                <div class="error-wrap">
                    <?php
                    foreach ($errors as $errors) {
                        echo '<div class="alert alert-danger mt-3" role="alert">' . $errors . '</div>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <input type="number" name="OTP" min="0" class="form-control w-25 mt-3" placeholder="Enter your verification code..." required>
                </div>
                <input type="submit" value="Confirm" name="confirm" class="btn btn-success text-white">
            </form>
        </div>
    </section>
</body>

</html>