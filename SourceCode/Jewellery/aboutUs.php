<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us Page</title>
    <link rel="shortcut icon" href="public/font/favicon.ico" type="image/x-icon" /> 
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boostrap & JS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <!-- CSS -->
    <link rel="stylesheet" href="./public/css/aboutUs.css"/>
    <link rel="stylesheet" href="./public/css/header.css?v=1">
    <link rel="stylesheet" href="./public/css/footer.css?v=1"/>

  </head>
  <body> 
    <?php include "header.php" ?>
    <main >
      <div class="banner-page">
        <div class="container container-wrapper">
          <div class="title-page">
            <h2>About Us</h2>
          </div>
          <div class="bread-crumb">
            <a href="./home.php" title="Back to the frontpage">Home<i class="fa fa-angle-right" aria-hidden="true"></i></a>
            <strong>About Us</strong>
          </div>
        </div>
      </div>
      <div class="main-page">
        <div class="container container-wrapper"> 
              <div class="about-introduce">
                  <div class="row"> 
                    <div class="col-md-6 intro_detail d-flex align-items-center">
                  <div class="info-intro">
                      <h3 class="title_intro">Who we are</h3>
                      <p class="des_intro"> World's Largest Gem Store</p>
                      <p class="content_intro">Rock Paradise is the premier online retailer for all things crystals and gemstones. Our extensive collection includes unique stone varieties from all over the world, and we’re always on the hunt for the highest-quality products for our customers!</p>
                  </div>
              </div>
              <div class="col-md-6 intro_image ">
                  <img class="w-100" src=" https://cdn.shopify.com/s/files/1/0378/1876/1260/files/aboutus-img1.jpg?v=1586767483 ">
              </div>
              <div class="col-md-6 intro_image">
                  <img class="w-100" src=" https://cdn.shopify.com/s/files/1/0378/1876/1260/files/aboutus-img2.jpg?v=1586767482 ">
              </div>
              <div class="col-md-6 intro_detail d-flex align-items-center">
                  <div class="info-intro">
                      <h3 class="title_intro">Choice for all</h3>
                      <p class="des_intro">Our Promises</p>
                      <p class="content_intro">For over a decade we've been traveling the world, building partnerships and amassing one of the most amazing collection of stones out there. Over time we've learned about where they come from, how they work, and what's special about each and every one. We're here to help with whatever you need. We're committed to bringing you beauty you can see, a breathtaking selection and excellent customer service. </p>
                    </div>
              </div> 
                  </div>
              </div>	 
          </div>
      </div>		
      <div class="main-page bg-black">
        <div class="container container-wrapper">	
          <div class="text-center  text_top">
            <h3 class="title_heading">INSTAGRAM</h3>
          </div>
          <div class="js-instagram galary_inta">  
            <div class="content relative hover-images instagram__item">
              <img src="./public/images/product/10.jpg" class="img-responsive" alt="instagram">
              <div class="absolute content_text flex center">
                <a href="https://www.instagram.com/" class="delay03 inline-block" target="_blank" tabindex="-1"><i class="fa fa-instagram"></i></a>
              </div>
            </div> 
            <div class="content relative hover-images instagram__item">
              <img src="./public/images/product/11.jpg" class="img-responsive" alt="instagram">
              <div class="absolute content_text flex center">
                <a href="https://www.instagram.com/" class="delay03 inline-block" target="_blank" tabindex="-1"><i class="fa fa-instagram"></i></a>
              </div>
            </div>
            <div class="content relative hover-images instagram__item">
              <img src="./public/images/product/12.jpg" class="img-responsive" alt="instagram">
              <div class="absolute content_text flex center">
                <a href="https://www.instagram.com/" class="delay03 inline-block" target="_blank" tabindex="-1"><i class="fa fa-instagram"></i></a>
              </div>
            </div>
            <div class="content relative hover-images instagram__item">
              <img src="./public/images/product/13.jpg" class="img-responsive" alt="instagram">
              <div class="absolute content_text flex center">
                <a href="https://www.instagram.com/" class="delay03 inline-block" target="_blank" tabindex="-1"><i class="fa fa-instagram"></i></a>
              </div>
            </div>
            <div class="content relative hover-images instagram__item">
              <img src="./public/images/product/14.jpg" class="img-responsive" alt="instagram">
              <div class="absolute content_text flex center">
                  <a href="https://www.instagram.com/" class="delay03 inline-block" target="_blank" tabindex="-1"><i class="fa fa-instagram"></i></a>
              </div>
            </div>
            <div class="content relative hover-images instagram__item">
              <img src="./public/images/product/15.jpg" class="img-responsive" alt="instagram">
              <div class="absolute content_text flex center">
                  <a href="https://www.instagram.com/" class="delay03 inline-block" target="_blank" tabindex="-1"><i class="fa fa-instagram"></i></a>
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
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
  <script src="./public/js/main.js?v=1"></script>
  <script>
    (() => {
      $('.js-instagram').slick({
        arrows: true,
        dots: false,
        infinite: false,
        autoplay: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev fa fa-angle-left"></button>',
        nextArrow: '<button type="button" class="slick-next fa fa-angle-right"></button>',
        responsive: [
          {
            breakpoint: 1600,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 1199,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          }
        ]
      }); 
    })();
  </script>
</html>			