<?php
session_start();
include "connect.php";
$arr_prd = [];
$bestselling = [];
$price = [];
$productDetail = [];
$comments = [];
$sql = "SELECT product.id, product.avatar, product.name,product.description, product.price, product.category_id, product.brand_id, product.gemstone_id, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name";

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

//  Keyword Search
if (isset($_POST['keyword'])) {
  $sql .= " HAVING product.name like '%" . $_POST['keyword'] . "%'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $arr_prd = $result->fetch_all(MYSQLI_ASSOC);
  }
}

// Range Price
if (isset($_GET['rangePrice'])) {
  $rangePrice = $_GET['rangePrice'];
  $range = preg_split('[\s]', $rangePrice);
  $from = 0;
  $to = 0;
  if ($range[0] == 'over') {
    $from = $range[1];
  } else {
    $range1 = preg_split('[\-]', $range[0]);
    $from = $range1[0];
    $to = $range1[1];
  }
  $sql .= " HAVING product.price >= $from";
  if ($to != 0) {
    $sql .= " and product.price <= $to";
  }
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
} // else {
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
    if(array_key_exists($productId, $_SESSION['cart'])) {
      $_SESSION['cart'][$productId]++;
    }else {
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
  <link rel="stylesheet" href="./public/css/productPage.css?v=2" />
  <link rel="stylesheet" href="./public/css/header.css">
  <link rel="stylesheet" href="./public/css/footer.css?v=2" />

</head>

<body>
  <div class="home_black_version">
    <?php include "header.php" ?>
    <div class="banner-page mt-3 mb-5">
      <div class="container container-wrapper">
        <div class="title-page">
          <h2>Products</h2>
        </div>
        <div class="bread-crumb">
          <a href="./home.php" title="Back to the frontpage">Home<i class="fa fa-angle-right" aria-hidden="true"></i></a>
          <strong>Products</strong>
        </div>
      </div>
    </div>

    <!-- product section area starts  -->
    <section class="product_section p_section1 product_black_section bottom mt-5">
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
                              <img src="admin/<?= $product['avatar'] ?>" alt="product" style="padding: 0px 10px; height: 228px; width:100%;">
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

    <!-- product section area starts  -->
    <section class="product_section p_section1 product_black_section">
      <div class="container">
        <div class="row">
          <div class="product_tab_button">
            <ul class="nav" role="tablist">
              <li>
                <a href="#featured" class="active" data-toggle="tab" role="tab" aria-controls="featured" aria-selected="true">Product</a>
              </li>
            </ul>
          </div>
          <ul class="col-md-3 bg-secondary p-3 pt-5 text-white" style="width: 16rem;">
            <!-- Filter -->
            <h3 class="text-center mb-4 text-warning"><i class="fa fa-filter"></i> Filters</h3>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <ul class="sidebar mb-0 list-unstyled mt-4" id="accordionSidebar">
              <li class="nav-item collapsed">
                <a class="nav-link text-warning" href="#" data-toggle="collapse" data-target="#collapseOne">
                  <i class="fa-solid fa-dollar-sign"></i> <span>Price</span>
                </a>
                <div id="collapseOne" class="collapse">
                  <div class="bg-white py-2 rounded-lg m-auto" style="width:13rem; font-size: .9rem;">
                    <?php foreach ($price as $price) : ?>
                      <a href="?rangePrice=<?= $price['rangePrice'] ?>" class="dropdown-item text-info"><?= $price['rangePrice'] ?></a>
                    <?php endforeach; ?>
                  </div>
                </div>
              </li>

              <!-- Divider -->
              <hr class="sidebar-divider">

              <li class="nav-item collapsed">
                <a class="nav-link text-warning" href="#" data-toggle="collapse" data-target="#collapseTwo">
                  <i class="fa-solid fa-list"></i> <span>Category</span>
                </a>
                <div id="collapseTwo" class="collapse">
                  <div class="bg-white py-2 rounded-lg m-auto" style="width:13rem; font-size: .9rem;">
                    <?php foreach ($arr_category as $category) : ?>
                      <a href="?category_id=<?= $category['id'] ?>" class="dropdown-item text-info"><?= $category['category_name'] ?></a>
                    <?php endforeach; ?>
                  </div>
                </div>
              </li>

              <!-- Divider -->
              <hr class="sidebar-divider">

              <li class="nav-item collapsed">
                <a class="nav-link text-warning" href="#" data-toggle="collapse" data-target="#collapseThree">
                  <i class="fa-solid fa-copyright"></i> <span>Brand</span>
                </a>
                <div id="collapseThree" class="collapse">
                  <div class="bg-white py-2 rounded-lg m-auto" style="width:13rem; font-size: .9rem;">
                    <?php foreach ($arr_brand as $brand) : ?>
                      <a href="?brand_id=<?= $brand['id'] ?>" class="dropdown-item text-info"><?= $brand['brand_name'] ?></a>
                    <?php endforeach; ?>
                  </div>
                </div>
              </li>

              <!-- Divider -->
              <hr class="sidebar-divider">

              <li class="nav-item collapsed">
                <a class="nav-link text-warning" href="#" data-toggle="collapse" data-target="#collapseFour">
                  <i class="fa-solid fa-gem"></i> <span>Gemstone</span>
                </a>
                <div id="collapseFour" class="collapse">
                  <div class="bg-white py-2 rounded-lg m-auto" style="width:13rem; font-size: .9rem;">
                    <?php foreach ($arr_gemstone as $gemstone) : ?>
                      <a href="?gemstone_id=<?= $gemstone['id'] ?>" class="dropdown-item text-info"><?= $gemstone['gemstone_name'] ?></a>
                    <?php endforeach; ?>
                  </div>
                </div>
              </li>

              <!-- Divider -->
              <hr class="sidebar-divider">
            </ul>

          </ul>
          <div class="col-md-9 m-auto">
            <div class="product_area">
              <div class="tab-content">
                <div class="tab-pane fade show active" id="featured" role="tabpane1">
                  <div class="product_container">
                    <div class="row">
                      <?php if (count($arr_prd) == 0) : ?>
                        <section class="alert alert-danger w-100 mb-5">No Product</section>
                      <?php else : ?>
                        <?php foreach ($arr_prd as $product) : ?>
                          <div class="col-product col-12 col-sm-12 col-md-6 col-lg-4">
                            <div class="single_product">
                              <div class="product_thumb">
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
                          <div class="tab-pane fade show active" id="tab0" role="tabpanel">
                            <div class="modal_tab_img">
                              <a href="#"><img src="./admin/<?= $productDetail['avatar'] ?>" alt="avatarProduct" style="height: 333px; width: 333px;"></a>
                            </div>
                          </div>
                          <?php
                          foreach ($images as $index => $image) {
                          ?>
                            <div class="tab-pane fade" id="tab<?= ++$index ?>" role="tabpanel">
                              <div class="modal_tab_img">
                                <a href="#">
                                  <img src="./admin/<?= $image['image'] ?>" alt="imageProduct">
                                </a>
                              </div>
                            </div>
                          <?php
                          }
                          ?>
                        </div>
                        <div class="modal_tab_button">
                          <ul class="nav product_navactive owl-carousel owl-loaded owl-drag" role="tablist">
                            <div class="owl-stage-outer">
                              <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s;">
                                <?php
                                foreach ($images as $index => $image) {
                                ?>
                                  <div class="owl-item">
                                    <li>
                                      <a href="#tab<?= ++$index ?>" class="nav-link active" data-toggle="tab" role="tab" aria-controls="tab<?= ++$index ?>" aria-selected="false">
                                        <img src="./admin/<?= $image['image'] ?>" alt="imageProduct" style="height: 77px; width:77px">
                                      </a>
                                    </li>
                                  </div>
                                <?php
                                }
                                ?>

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
  <!-- Sweet Alert -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://kit.fontawesome.com/d8162761f2.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
  <script src="./public/js/main.js?v=5"></script>

</body>

</html>