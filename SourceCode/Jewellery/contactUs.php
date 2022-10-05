<?php
session_start();
include "connect.php";
$errors = [];
if(isset($_POST['sendForm'])) {
    $name = htmlspecialchars($_POST['contactName']);
    $conn->real_escape_string($name);
    $phone = htmlspecialchars($_POST['contactPhone']);
    $conn->real_escape_string($phone);
    $email = htmlspecialchars($_POST['contactEmail']);
    $conn->real_escape_string($email);
    $subject = htmlspecialchars($_POST['contactSubject']);
    $conn->real_escape_string($subject);
    $message = htmlspecialchars($_POST['contactMessage']);
    $conn->real_escape_string($message);

    if(empty($name)) {
        $errors['name'] = "Name is required";
    }

    if(empty($phone)) {
        $errors['phone'] = "Phone is required";
    }

    if(empty($email)) {
        $errors['email'] = "Email is required";
    }

    if(empty($subject)) {
        $errors['subject'] = "Subject is required";
    }

    if(empty($message)) {
        $errors['message'] = "Message is required";
    }

    $pattern = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    preg_match($pattern, $email, $matches);
    if (!$matches) {
        $errors['email'] = 'Email must be email format';
    }

    if(count($errors) == 0) {
        $sql = sprintf("INSERT INTO contact(name, phone, email ,subject , message) values('%s','%s','%s','%s','%s')", $name, $phone, $email, $subject, $message);
        $result = $conn->query($sql);
        if ($result) {
            echo "<script> alert(`Send successfully! \nWe will contact you as soon as possible.`) ;location='contactUs.php'</script>";
        } else {
            die("Error: " . $conn->error);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us Page</title>
	<link rel="shortcut icon" href="public/font/favicon.ico" type="image/x-icon" /> 
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Boostrap & JS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <!-- CSS -->
    <link rel="stylesheet" href="./public/css/contactUs.css?v=1"/>
    <link rel="stylesheet" href="./public/css/header.css?v=1">
    <link rel="stylesheet" href="./public/css/footer.css?v=1"/>

</head>
<body> 
    <?php include "header.php"?>
	<main>
		<div class="banner-page">
			<div class="container container-wrapper">
				<div class="title-page">
					<h2>Contact Us</h2>
				</div>
				<div class="bread-crumb">
					<a href="./home.php" title="Back to the frontpage">Home<i class="fa fa-angle-right" aria-hidden="true"></i></a>
					<strong>Contact Us</strong>
				</div>
			</div>
		</div>
		<div class="main-page">
			<div class="container"> 
        		<div class="contact-form">
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="address-shop">
                                <h3 class="shop-name">
                                    Rock Paradise
                                </h3>
                                <p class="shop-address">285 Doi Can, Lieu Giai, Ba Dinh, Ha Noi<br>
                                    <a href="tel: 19002489">Hotline: 19002489</a>
                                </p>
                            </div>
                            <div class="info-shop">
                                <h3 class="title">
                                    Store Opening Hours
                                </h3>
                                <p class="content">Monday - Saturday 8:00Am - 7:00Pm <br> Sunday 10:00Am - 6:00Pm</p>
                            </div>
                            <div class="info-shop">
                                <h3 class="title">
                                    Specialist Hours
                                </h3>
                                <p class="content">Monday - Friday 9:00Am - 5:00Pm</p>
                            </div>
                            <div class="contact__maps mt-3">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.9232490033883!2d105.81679641473157!3d21.03575678599455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab0d127a01e7%3A0xab069cd4eaa76ff2!2zMjg1IMSQ4buZaSBD4bqlbiwgVsSpbmggUGjDuiwgQmEgxJDDrG5oLCBIw6AgTuG7mWkgMTAwMDAwLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1654098499312!5m2!1svi!2s" width="600" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="contact-form-page">
                                <form method="post" action="" id="contact_form">
                                    <div class="contact-form form-group">
                                        <div class="contact-name mb-3">
                                            <input class="form-control rounded" placeholder="Your name" type="text" id="contactFormName" name="contactName" value="<?= isset($name) ? $name : '' ?>" required>
                                        </div>
                                        <div class="contact-phone mb-3">
                                            <input type="text" pattern="[0-9]{10,11}" class="form-control" id="contactFormPhone" placeholder="Phone" name="contactPhone" value="<?= isset($phone) ? $phone : '' ?>" required>
                                        </div>
                                        <div class="contact-email mb-3">
                                            <input class="form-control rounded" placeholder="Email" type="email" id="contactFormEmail" name="contactEmail" value="<?= isset($email) ? $email : '' ?>" required>
                                        </div>
                                        <div class="contact-subject mb-3">
                                            <input class="dark border form-control rounded" placeholder="Subject" type="text" id="contactFormSubject" name="contactSubject" value="<?= isset($subject) ? $subject : '' ?>" required>
                                        </div>
                                        <div class="contact-message mb-3">
                                            <textarea class="form-control rounded" placeholder="Your message" cols="30" rows="10" id="contactFormMessage" name="contactMessage" value="<?= isset($message) ? $message : '' ?>" required></textarea>
                                        </div>
                                        <div class="contact-submit mb-3">
                                            <button type="submit" name="sendForm" class="btn btn-warning w-100 text-white p-3"> SEND TO US <i class="pl-1 fas fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>	 
    	    </div>
	    </div>	 		
	</main>  
    <?php include "footer.php" ?>
</body>

<!-- JS -->
<script src="https://kit.fontawesome.com/d8162761f2.js"></script>     
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="./public/js/main.js?v=1"></script>
</html>			