<?php
session_start();
include "connect.php";
$arr_prd = [];
$bestselling = [];
$price = [];
$productDetail = [];
$comments = [];
$errors = [];
$sql = "SELECT product.id, product.avatar, product.name,product.description, product.price, product.sale, product.category_id, product.brand_id, product.gemstone_id, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name, product.sale HAVING product.sale";

// Category
if (isset($_GET['category_id'])) {
  $sql .= " HAVING product.category_id=" . $_GET['category_id'];
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $arr_prd = $result->fetch_all(MYSQLI_ASSOC);
  }
}

// Brand
if (isset($_GET['brand_id'])) {
  $sql .= " HAVING product.brand_id=" . $_GET['brand_id'];
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $arr_prd = $result->fetch_all(MYSQLI_ASSOC);
  }
}

// Gemstone
if (isset($_GET['gemstone_id'])) {
  $sql .= " HAVING product.gemstone_id=" . $_GET['gemstone_id'];
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $arr_prd = $result->fetch_all(MYSQLI_ASSOC);
  }
}

// Keyword Search
if (isset($_POST['keyword'])) {
  $sql .= " HAVING product.name like '%" . $_POST['keyword'] . "%'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $arr_prd = $result->fetch_all(MYSQLI_ASSOC);
  }
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $arr_prd = $result->fetch_all(MYSQLI_ASSOC);
}
// else {
//   echo 'Error: ' . $conn->error;
// }

// Bestselling
$sql = "SELECT product.id, product.avatar, product.name,product.description, product.price,product.sold, product.category_id, product.brand_id, product.gemstone_id, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name, product.sold HAVING product.sold ORDER BY product.sold DESC LIMIT 8";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $bestselling = $result->fetch_all(MYSQLI_ASSOC);
} //else {
//   echo 'Error: ' . $conn->error;
// }

// Price
$sql = "SELECT * FROM price";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $price = $result->fetch_all(MYSQLI_ASSOC);
} else {
  echo 'Error: ' . $conn->error;
}

// Cart
$prd_cart = [];
$total = 0;
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'add') {
    $productId = $_GET['productId'];
    $_SESSION['cart'][$productId] = 0;
    if (array_key_exists($productId, $_SESSION['cart'])) {
      $_SESSION['cart'][$productId]++;
    } else {
      $_SESSION['cart'][$productId] = 1;
    }
    header("Location:?");
  }
  if ($_GET['action'] == 'delete') {
    $productId = $_GET['productId'];
    unset($_SESSION['cart'][$productId]);
  }
}

// if (isset($_SESSION['cart'])) {
//   $listId = '0';
//   foreach (array_keys($_SESSION['cart']) as $key) {
//     $listId .= ',' . $key;
//   }
//   $sql = "SELECT product.id, product.avatar, product.name,product.description, product.price, product.category_id, product.brand_id, product.gemstone_id, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name HAVING product.id in($listId)";
//   $result = $conn->query($sql);
//   if ($result->num_rows > 0) {
//     $prd_cart = $result->fetch_all(MYSQLI_ASSOC);
//   }
// }

// Comments
if (isset($_POST['content'])) {
  $content = $_POST['content'];
  $product_id = $_GET['product_id'];
  if (isset($_SESSION['user'])) {
    $sql = "SELECT * FROM account WHERE email = '" . $_SESSION['user'] . "'";
    $result = $conn->query($sql);
    if ($result) {
      $account_id = $result->fetch_assoc();
      $account_id = $account_id['id'];
      $sql = sprintf("INSERT INTO comments(account_id, product_id, content) VALUES('%s', '%s', '%s')", $account_id, $product_id, $content);
      $result = $conn->query($sql);
      if ($result) {
        echo "<script>alert(`Your comment is submited! \nIt will showed soon.`)</script>";
      } else {
        echo "Error: " . $conn->error;
      }
    } else {
      echo "Error: " . $conn->error;
    }
  } else {
    $_SESSION['content'] = $content;
    echo "<script>alert('You must login to comment!'); location='login.php?product_id=$product_id'; </script>";
  }
}

// Subcribe
if (isset($_POST['subcribe'])) {
  $email = htmlspecialchars($_POST['email']);
  $conn->real_escape_string($email);

  if (empty($email)) {
    $errors['email'] = 'Email is required';
  }

  $pattern = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
  preg_match($pattern, $email, $matches);
  if (!$matches) {
    $errors['email'] = 'Email must be email format';
  }

  if (count($errors) == 0) {
    echo "<script> alert('We will send you an email about all the updates our lastest and special offer.'); </script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ashirwaad Jewelry</title>
  <link rel="shortcut icon" href="public/font/favicon.ico" type="image/x-icon" />
  <!-- font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- CSS only -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" href="./public/css/home.css?v=2" />
  <link rel="stylesheet" href="./public/css/header.css">
  <link rel="stylesheet" href="./public/css/footer.css?v=1" />

</head>

<body>
  <div class="home_black_version">
    <?php include "header.php" ?>
    <!-- slider section starts -->
    <div class="slider_area slider_black owl-carousel owl-loaded owl-drag">
      <div class="owl-stage-outer">
        <div class="owl-stage" style="transform: translate3d(-3038px, 0px, 0px); transition: all 0s ease 0s; width: 10635px;">
          <div class="owl-item cloned" style="width: 1519.2px;">
            <div class="single_slider" data-bgimg="public/images/slider/2.jpg" style="background-image: url(&quot;public/images/slider/2.jpg&quot;);">
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="slider_content">
                      <p>exclusive offer -40% off this week</p>
                      <h1>Earings and Pendant</h1>
                      <span>Complete bridal set with white pearls</span>
                      <p class="slider_price">
                        starting at <span>$30.00</span>
                      </p>
                      <a href="productPage.php" class="button">Shop Now</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="owl-item cloned" style="width: 1519.2px;">
            <div class="single_slider" data-bgimg="public/images/slider/3.jpg" style="background-image: url(&quot;public/images/slider/3.jpg&quot;);">
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="slider_content">
                      <p>exclusive offer -10% off this week</p>
                      <h1>Wedding Rings</h1>
                      <span>Ashirwaad Special wedding rings for couples.</span>
                      <p class="slider_price">
                        starting at <span>$20.00</span>
                      </p>
                      <a href="productPage.php" class="button">Shop Now</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="owl-item active" style="width: 1519.2px;">
            <div class="single_slider" data-bgimg="public/images/slider/1.png" style="background-image: url(&quot;public/images/slider/1.png&quot;);">
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="slider_content">
                      <p>exclusive offer -20% off this week</p>
                      <h1>Necklace</h1>
                      <span>22 Carat gold necklace for wedding</span>
                      <p class="slider_price">
                        starting at <span>$21.00</span>
                      </p>
                      <a href="productPage.php" class="button">Shop Now</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="owl-item" style="width: 1519.2px;">
            <div class="single_slider" data-bgimg="public/images/slider/2.jpg" style="background-image: url(&quot;public/images/slider/2.jpg&quot;);">
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="slider_content">
                      <p>exclusive offer -40% off this week</p>
                      <h1>Earings and Pendant</h1>
                      <span>Complete bridal set with white pearls</span>
                      <p class="slider_price">
                        starting at <span>$30.00</span>
                      </p>
                      <a href="productPage.php" class="button">Shop Now</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="owl-item" style="width: 1519.2px;">
            <div class="single_slider" data-bgimg="public/images/slider/3.jpg" style="background-image: url(&quot;public/images/slider/3.jpg&quot;);">
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="slider_content">
                      <p>exclusive offer -10% off this week</p>
                      <h1>Wedding Rings</h1>
                      <span>Ashirwaad Special wedding rings for couples.</span>
                      <p class="slider_price">
                        starting at <span>$20.00</span>
                      </p>
                      <a href="productPage.php" class="button">Shop Now</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="owl-item cloned" style="width: 1519.2px;">
            <div class="single_slider" data-bgimg="public/images/slider/1.png" style="background-image: url(&quot;public/images/slider/1.png&quot;);">
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="slider_content">
                      <p>exclusive offer -20% off this week</p>
                      <h1>Necklace</h1>
                      <span>22 Carat gold necklace for wedding</span>
                      <p class="slider_price">
                        starting at <span>$21.00</span>
                      </p>
                      <a href="productPage.php" class="button">Shop Now</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="owl-item cloned" style="width: 1519.2px;">
            <div class="single_slider" data-bgimg="public/images/slider/2.jpg" style="background-image: url(&quot;public/images/slider/2.jpg&quot;);">
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="slider_content">
                      <p>exclusive offer -40% off this week</p>
                      <h1>Earings and Pendant</h1>
                      <span>Complete bridal set with white pearls</span>
                      <p class="slider_price">
                        starting at <span>$30.00</span>
                      </p>
                      <a href="productPage.php" class="button">Shop Now</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button></div>
      <div class="owl-dots"><button role="button" class="owl-dot active"><span></span></button><button role="button" class="owl-dot"><span></span></button><button role="button" class="owl-dot"><span></span></button></div>
    </div>
    <!-- slider section ends -->
    <!-- banner section starts -->
    <section class="banner_section banner_black" id="banner">
      <div class="container">
        <div class="row">
          <div class="col-12 mb-3 col-lg-4 col-md-6 col-sm-12">
            <div class="single_banner">
              <div class="banner_thumb">
                <a href="#">
                  <img src="public/images/banner/bg-1.jpg" alt="banner1">
                </a>
                <div class="banner_content">
                  <p>New Design</p>
                  <h2>Small design Rings</h2>
                  <span>Sale 20% </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3 col-lg-4 col-md-6 col-sm-12">
            <div class="single_banner">
              <div class="banner_thumb">
                <a href="#">
                  <img src="public/images/banner/bg-2.jpg" alt="banner2">
                </a>
                <div class="banner_content">
                  <p>Bestselling Rings</p>
                  <h2>White gold rings</h2>
                  <span>Sale 10% </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3 col-lg-4 col-md-6 col-sm-12">
            <div class="single_banner">
              <div class="banner_thumb">
                <a href="#"><img src="public/images/banner/bg-3.jpg" alt="banner3"></a>
                <div class="banner_content">
                  <p>Featured Rings</p>
                  <h2>Platinium Rings</h2>
                  <span>Sale 30% </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- banner section ends -->
    <!-- product section area starts  -->
    <section class="product_section p_section1 product_black_section mt-5" id="onSale">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="product_area">
              <div class="product_tab_button">
                <ul class="nav" role="tablist">
                  <li>
                    <a href="#featured" class="active" data-toggle="tab" role="tab" aria-controls="featured" aria-selected="true">On-Sale</a>
                  </li>
                </ul>
              </div>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="featured" role="tabpane1">
                  <div class="product_container">
                    <div class="row">
                      <?php if (count($arr_prd) == 0) : ?>
                        <section class="alert alert-danger w-100 mb-5">No Product</section>
                      <?php else : ?>
                        <?php foreach ($arr_prd as $product) : ?>
                          <div class="col-product-sale col-12 col-lg-3 col-md-4 col-sm-6">
                            <div class="single_product">
                              <div class="product_thumb">
                                <!-- Sale -->
                                <figure class="label-sale text-center">
                                  <span><?= $product['sale'] ?></span>
                                </figure>
                                <a href="#" class="primary_img btn-productDetail" data-id="<?= $product['id'] ?>">
                                  <img src="admin/<?= $product['avatar'] ?>" alt="product" class="" style="height: 293px; width:292px;">
                                </a>
                                <div class="quick_button">
                                  <a data-id="<?= $product['id'] ?>" href="#" class="btn-productDetail" data-original-title="quick view">Quick View</a>
                                </div>
                              </div>
                              <div class="product_content">
                                <div class="tag_cate">
                                  <a href="#" data-id="<?= $product['id'] ?>" class="btn-productDetail"><?= $product['name']; ?></a>
                                </div>
                                <h3><a href="#"><?= $product['category_name']; ?></a></h3>
                                <div class="price_box">
                                  <span data-id="<?= $product['id'] ?>" class="btn-productDetail">$<?= $product['price']; ?>.00</span>
                                </div>
                                <div class="product_hover">
                                  <div class="product_ratings btn-productDetail" data-id="<?= $product['id'] ?>">
                                    <ul>
                                      <li>
                                        <a href="#"><i class="ion-ios-star-outline"></i></a>
                                      </li>
                                      <li>
                                        <a href="#"><i class="ion-ios-star-outline"></i></a>
                                      </li>
                                      <li>
                                        <a href="#"><i class="ion-ios-star-outline"></i></a>
                                      </li>
                                      <li>
                                        <a href="#"><i class="ion-ios-star-outline"></i></a>
                                      </li>
                                      <li>
                                        <a href="#"><i class="ion-ios-star-outline"></i></a>
                                      </li>
                                    </ul>
                                  </div>
                                  <div class="product_desc">
                                    <p><?= $product['description']; ?></p>
                                  </div>
                                  <div class="action_links">
                                    <ul>
                                      <li>
                                        <a href="#" data-placement="top" title="Add to Wishlist" data-toggle="tooltip"><span class="ion-heart"></span></a>
                                      </li>
                                      <li class="add_to_cart">
                                        <a href="?action=add&productId=<?= $product['id'] ?>" title="Add To Cart">Add To Cart</a>
                                      </li>
                                      <li>
                                        <a href="#" title="Compare">
                                          <i class="ion-ios-settings-strong"></i>
                                        </a>
                                      </li>
                                    </ul>

                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- product section area sends -->

    <!-- banner full width start -->
    <section class="banner_fullwidth black_fullwidth" id="collection">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-12 col-sm-12 col-md-6 col-lg-12">
            <div class="banner_text">
              <p>Sale Off 20% All Products</p>
              <h2>New Trending Collection</h2>
              <span>Best Design makes you more special.</span>
              <a href="#">Shop Now</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- banner full width end -->

    <!-- product section area starts  -->
    <section class="product_section p_section1 product_black_section bottom mt-5" id="bestselling">
      <div class="container ">
        <div class="row">
          <div class="col-12 mt-5">
            <div class="section_title">
              <h2>Bestselling Products</h2>
            </div>
          </div>
          <div class="col-12">
            <div class="product-area slider_best">
              <div class="product_container bottom">
                <div class="custom-row product_row1">
                  <?php if (count($bestselling) == 0) : ?>
                    <section class="alert alert-info">No Product</section>
                  <?php else : ?>
                    <?php foreach ($bestselling as $product) : ?>
                      <div class="custom-col-5">
                        <div class="single_product">
                          <div class="product_thumb">
                            <a href="#" class="primary_img btn-productDetail" data-id="<?= $product['id'] ?>">
                              <img src="admin/<?= $product['avatar'] ?>" alt="product" style="height: 228px; width:228px">
                            </a>
                            <!-- <a href="#" class="secondary_img">
                              <img src="admin/<?= $product['avatar'] ?>" alt="product" class="">
                            </a> -->
                            <div class="quick_button">
                              <a data-id="<?= $product['id'] ?>" href="#" class="btn-productDetail" data-original-title="quick view">Quick View</a>
                            </div>
                          </div>
                          <div class="product_content">
                            <div class="tag_cate" style="min-height: 3rem;">
                              <a href="#" data-id="<?= $product['id'] ?>" class="btn-productDetail"><?= $product['name']; ?></a>
                            </div>
                            <h3><a href="#"><?= $product['category_name']; ?></a></h3>
                            <div class="price_box">
                              <span data-id="<?= $product['id'] ?>" class="btn-productDetail">$<?= $product['price']; ?>.00</span>
                            </div>
                            <div class="product_hover">
                              <div class="product_ratings btn-productDetail" data-id="<?= $product['id'] ?>">
                                <ul>
                                  <li>
                                    <a href="#"><i class="ion-ios-star-outline"></i></a>
                                  </li>
                                  <li>
                                    <a href="#"><i class="ion-ios-star-outline"></i></a>
                                  </li>
                                  <li>
                                    <a href="#"><i class="ion-ios-star-outline"></i></a>
                                  </li>
                                  <li>
                                    <a href="#"><i class="ion-ios-star-outline"></i></a>
                                  </li>
                                  <li>
                                    <a href="#"><i class="ion-ios-star-outline"></i></a>
                                  </li>
                                </ul>
                              </div>
                              <div class="product_desc">
                                <p><?= $product['description']; ?></p>
                              </div>
                              <div class="action_links">
                                <ul>
                                  <li>
                                    <a href="#" data-placement="top" title="Add to Wishlist" data-toggle="tooltip"><span class="ion-heart"></span></a>
                                  </li>
                                  <li class="add_to_cart">
                                    <a href="?action=add&productId=<?= $product['id'] ?>" title="Add To Cart">Add To Cart</a>
                                  </li>
                                  <li>
                                    <a href="#" title="Compare">
                                      <i class="ion-ios-settings-strong"></i>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- product section area ends  -->

    <!-- instagram section starts -->
    <div class="instagram" id="instagram">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-2 col-md-4 col-sm-4 p-0">
            <div class="instagram__item set-bg" data-bgimg="public/images/instagram/insta-1.jpg" style="background-image: url(&quot;public/images/instagram/insta-1.jpg&quot;);">
              <div class="instagram__text">
                <i class="ion-social-instagram"></i>
                <a href="#"></a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-4 p-0">
            <div class="instagram__item set-bg" data-bgimg="public/images/instagram/insta-2.jpg" style="background-image: url(&quot;public/images/instagram/insta-2.jpg&quot;);">
              <div class="instagram__text">
                <i class="ion-social-instagram"></i>
                <a href="#"></a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-4 p-0">
            <div class="instagram__item set-bg" data-bgimg="public/images/instagram/insta-3.jpg" style="background-image: url(&quot;public/images/instagram/insta-3.jpg&quot;);">
              <div class="instagram__text">
                <i class="ion-social-instagram"></i>
                <a href="#"></a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-4 p-0">
            <div class="instagram__item set-bg" data-bgimg="public/images/instagram/insta-4.jpg" style="background-image: url(&quot;public/images/instagram/insta-4.jpg&quot;);">
              <div class="instagram__text">
                <i class="ion-social-instagram"></i>
                <a href="#"></a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-4 p-0">
            <div class="instagram__item set-bg" data-bgimg="public/images/instagram/insta-5.jpg" style="background-image: url(&quot;public/images/instagram/insta-5.jpg&quot;);">
              <div class="instagram__text">
                <i class="ion-social-instagram"></i>
                <a href="#"></a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-4 p-0">
            <div class="instagram__item set-bg" data-bgimg="public/images/instagram/insta-6.jpg" style="background-image: url(&quot;public/images/instagram/insta-6.jpg&quot;);">
              <div class="instagram__text">
                <i class="ion-social-instagram"></i>
                <a href="#"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- instagram section  ends-->

    <!-- subscribe section starts -->
    <div class="newsletter_area newsletter_black" id="subcribe">
      <div class="container">
        <div class="row mt-5">
          <div class="col-12">
            <div class="newsletter_content">
              <h2>Subscribe for Rock Paradise Magazines</h2>
              <p>
                Get E-mail of all the updates about our lastest and special
                offer.
              </p>
              <div class="subscibe_form">
                <form class="footer-newsletter" method="POST">
                  <input type="email"  name="email" placeholder="Email address ..." required>
                  <button type="submit" name="subcribe">Subscribe</button>
                  <div class="error-wrap">
                    <?php
                    foreach ($errors as $errors) {
                      echo '<div class="alert alert-danger mt-3" role="alert">' . $errors . '</div>';
                    }
                    ?>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- subscribe section ends -->
    <!-- banner area starts  -->
    <section class="banner_section banner_section_five">
      <div class="container-fluid p-0">
        <div class="row no-gutters">
          <div class="col-12 mb-3 col-lg-6 col-md-12 col-sm-12">
            <div class="port-box">
              <div class="text-overlay">
                <h1>New Arrivals 2022</h1>
                <p>Crown for wife</p>
              </div>
              <img src="public/images/banner/1.jpg" alt="">
            </div>
          </div>
          <div class="col-12 col-lg-6 col-md-12 col-sm-12">
            <div class="port-box">
              <div class="text-overlay">
                <h1>Featured Products 2022</h1>
                <p>Pendant for Valentine</p>
              </div>
              <img src="public/images/banner/2.jpg" alt="">
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- banner area ends -->
    <?php include "footer.php" ?>
    <div class="ticker text-warning bg-secondary mr-3 mb-3">
      <div id="Date" class="fw-bold"></div>
      <ul class="ultime mt-2">
        <li class="idtime ">VietNam </li>
        <li class="idtime fw-bold" id="hours"></li>
        <li class="idtime fw-bold" id="point">:</li>
        <li class="idtime fw-bold" id="min"></li>
        <li class="idtime fw-bold" id="point">:</li>
        <li class="idtime fw-bold" id="sec"></li>
      </ul>
    </div>
  </div>

  <!-- modal section starts -->
  <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <div class="modal_body">
          <section id="productDetail">
            <div class="container">
              <div class="row">
                <?php if (count($productDetail) == 0) : ?>
                  <section class="alert alert-danger w-100 mt-4">No Product</section>
                <?php else : ?>
                  <?php if (is_array($productDetail) && count($productDetail) > 0) : ?>
                    <div class="col-lg-5 col-md-5 col-sm-12">
                      <div class="modal_tab">
                        <div class="tab-content product-details-large">
                          <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                            <div class="modal_tab_img">
                              <a href="#"><img src="images/product/70.jpg" alt=""></a>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <div class="modal_tab_img">
                              <a href="#">
                                <img src="images/product/71.jpg" alt="">
                              </a>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab3" role="tabpanel">
                            <div class="modal_tab_img">
                              <a href="#">
                                <img src="images/product/72.jpg" alt="">
                              </a>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab4" role="tabpanel">
                            <div class="modal_tab_img">
                              <a href="#">
                                <img src="images/product/73.jpg" alt="">
                              </a>
                            </div>
                          </div>
                        </div>
                        <div class="modal_tab_button">
                          <ul class="nav product_navactive owl-carousel owl-loaded owl-drag" role="tablist">
                            <div class="owl-stage-outer">
                              <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s;">
                                <div class="owl-item">
                                  <li>
                                    <a href="#tab1" class="nav-link active" data-toggle="tab" role="tab" aria-controls="tab1" aria-selected="false">
                                      <img src="images/product/70.jpg" alt="">
                                    </a>
                                  </li>
                                </div>
                                <div class="owl-item">
                                  <li>
                                    <a href="#tab2" class="nav-link" data-toggle="tab" role="tab" aria-controls="tab2" aria-selected="false">
                                      <img src="images/product/71.jpg" alt="">
                                    </a>
                                  </li>
                                </div>
                                <div class="owl-item">
                                  <li>
                                    <a href="#tab3" class="nav-link button_three" data-toggle="tab" role="tab" aria-controls="tab3" aria-selected="false"><img src="images/product/72.jpg" alt=""></a>
                                  </li>
                                </div>
                                <div class="owl-item">
                                  <li>
                                    <a href="#tab4" class="nav-link" data-toggle="tab" role="tab" aria-controls="tab4" aria-selected="false">
                                      <img src="images/product/73.jpg" alt="">
                                    </a>
                                  </li>
                                </div>
                              </div>
                            </div>
                            <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><i class="ion-chevron-left arrow-left"></i></button><button type="button" role="presentation" class="owl-next"><i class="ion-chevron-right arrow-right"></i></button></div>
                            <div class="owl-dots disabled"></div>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                      <div class="modal_right">
                        <div class="modal_title mb-10">
                          <h2><?= $productDetail['name']; ?></h2>
                        </div>
                        <div class="modal_price mb-10">
                          <span>$<?= $productDetail['price']; ?></span>
                        </div>
                        <div class="see_all">
                          <a href="#">See All Products</a>
                        </div>
                        <div class="modal_add_to_cart mb-15">
                          <form method="post" action="?action=add&productId=<?= $productDetail['id'] ?>" id="addToCart">
                            <div class="form-group">
                              <input type="number" name="number" min="1" max="100" step="1" value="1" class="d-inline-flex border-secondary form-control">
                              <button type="submit">Add To Cart</button>
                            </div>
                          </form>
                        </div>
                        <div class="modal_description mb-15">
                          <p><?= $productDetail['description']; ?></p>
                        </div>
                        <div class="modal_social pl-4">
                          <h2>Share this Product</h2>
                          <ul>
                            <li>
                              <a href="#"><i class="ion-social-facebook"></i></a>
                            </li>
                            <li>
                              <a href="#"><i class="ion-social-twitter"></i></a>
                            </li>
                            <li>
                              <a href="#"><i class="ion-social-rss"></i></a>
                            </li>
                            <li>
                              <a href="#"><i class="ion-social-googleplus"></i></a>
                            </li>
                            <li>
                              <a href="#"><i class="ion-social-youtube"></i></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <!-- Comments -->
                    <hr>
                    <section class="mt-4">
                      <h3>Comments:</h3>
                      <?php
                      $sql = "SELECT * FROM account INNER JOIN comments on account.id = comments.account_id INNER JOIN product on comments.product_id = product.id WHERE comments.status = 1 AND comments.product_id = " . $productDetail['id'];
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $comments = $result->fetch_all(MYSQLI_ASSOC);
                        foreach ($comments as $comments) {
                      ?>
                          <div class="font-weight-bold pl-1"><?= $comments['fullname'] ?></div>
                          <div class="pl-4"><?= $comments['content'] ?></div>
                      <?php
                        }
                      } else {
                        echo "<section class='alert alert-danger text-center'>No comments!</section>";
                      }
                      ?>
                      <form action="?product_id=<?= $productDetail['id'] ?>" method="post" class="mt-3">
                        <div class="my-2">
                          <textarea name="content" class="w-100 form-control" rows="5" placeholder="Write comment here..."></textarea>
                        </div>
                        <div class="form-group">
                          <input type="submit" value="Submit" class="btn btn-success text-white">
                        </div>
                      </form>
                    </section>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  <!-- modal section ends -->

  <!-- JS -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://kit.fontawesome.com/d8162761f2.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
  <script src="./public/js/main.js?v=1"></script>
</body>

</html>