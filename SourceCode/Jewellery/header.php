<?php
include "connect.php";
// List category 
$arr_category = [];
$sql = "SELECT * FROM category";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $arr_category = $result->fetch_all(MYSQLI_ASSOC);
} else {
  echo 'Error: ' . $conn->error;
}

// List Brand 
$arr_brand = [];
$sql = "SELECT * FROM brand";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $arr_brand = $result->fetch_all(MYSQLI_ASSOC);
} else {
  echo 'Error: ' . $conn->error;
}

// List gemstone 
$arr_gemstone = [];
$sql = "SELECT * FROM gemstone";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $arr_gemstone = $result->fetch_all(MYSQLI_ASSOC);
} else {
  echo 'Error: ' . $conn->error;
}

// Cart
$prd_cart = [];
$quantity = 0;
$total = 0;

if (isset($_SESSION['cart'])) {
  $listId = '0';
  foreach (array_keys($_SESSION['cart']) as $key) {
    $listId .= ',' . $key;
  }
  $sql = "SELECT product.id, product.avatar, product.name,product.description, product.price, product.category_id, product.brand_id, product.gemstone_id, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name HAVING product.id in($listId)";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $prd_cart = $result->fetch_all(MYSQLI_ASSOC);
  }
}

// Account User
if (isset($_SESSION['user'])) {
  $sql = "SELECT * FROM account WHERE role = 'user' AND email = '" . $_SESSION['user'] . "' ";
  $result = $conn->query($sql);
  $user_login = [];
  if ($result->num_rows > 0) {
    $user_login = $result->fetch_all(MYSQLI_ASSOC);
  } else {
    echo "Error: " . $conn->error;
  }
} else {
  $user_login = [];
  // header('location: login.php');
}

?>
<header class="header_area header_black">
  <!-- header middle starts -->
  <div class="header_middel">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <div class="home_contact">
            <div class="contact_icone">
              <img src="public/images/icon/icon_phone.png" alt="">
            </div>
            <div class="contact_box">
              <p>
                HotLine:
                <a href="tel: 19002489">19002489</a>
              </p>
            </div>
            <div class="text-info d-none d-sm-block" style="font-size: 0.8rem;">
              <i class="fa-solid fa-users"></i> <span id="website-counter"></span>
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 col-4 p-0">
          <div class="logo">
            <a href="home.php"><img src="./public/images/logo/logo7.jpg" alt="Logo"></a>
          </div>
        </div>

        <div class="col-lg-5 col-md-7 col-6">
          <div class="middel_right">
            <div class="search_btn">
              <a href="#"><i class="ion-ios-search-strong"></i></a>
              <div class="dropdown_search">
                <form action="?request=search" method="post">
                  <input type="search" name="keyword" placeholder="Search Product ....">
                  <button type="submit"><i class="ion-ios-search-strong"></i></button>
                </form>
              </div>
            </div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown d-flex">
              <a class="nav-link" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <?php
                if (is_array($user_login)) {
                  foreach ($user_login as $key => $value) {
                ?>
                    <span class="ml-2 d-none d-lg-inline small text-secondary"><?php if (!empty($value['fullname'])) echo $value['fullname'] ?></span>
                <?php
                  }
                }
                ?>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu">
                <a class="dropdown-item" href="logout.php"> <i class="fas fa-right-from-bracket fa-sm mr-2 text-secondary"></i> Logout </a>
              </div>
            </li>
            <div class="wishlist_btn">
              <a href="login.php"><i class="ion-android-person"></i></a>
            </div>
            <div class="cart_link">
              <a href="#">
                <?php
                if (is_array($prd_cart)) {
                  foreach ($prd_cart as $key => $value) {
                ?>
                    <?php $quantity += $_SESSION['cart'][$value['id']] ?>
                <?php
                  }
                }
                ?>
                <i class="ion-android-cart"><span class="cart_quantity"><?= $quantity ?></span></i>
              </a>

              <!-- mini cart -->
              <div class="mini_cart">
                <div class="cart_close">
                  <div class="cart_text">
                    <h3>cart</h3>
                  </div>
                  <div class="mini_cart_close">
                    <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                  </div>
                </div>
                <?php
                if (is_array($prd_cart) && count($prd_cart) > 0) {
                ?>
                  <div class="list-cart" id="list_cart">
                    <?php
                    foreach ($prd_cart as $index => $value) {
                    ?>
                      <div class="cart_item my-2">
                        <div class="cart_img">
                          <img src="admin/<?php if (!empty($value['avatar'])) : echo $value['avatar'];
                                          else : echo './public/images/avatar/imageDefault.jpg';
                                          endif; ?>" alt="product" height="50" width="100">
                        </div>
                        <div class="cart_info">
                          <a href="#"><?= $value['name']; ?></a>
                          <span class="quantity">Qty:<?= $_SESSION['cart'][$value['id']] ?></span>
                          <span class="price_cart">$<?= $value['price']; ?>.00</span>
                          <?php $quantity += $_SESSION['cart'][$value['id']] ?>
                          <?php $total += $value['price'] * $_SESSION['cart'][$value['id']] ?>
                        </div>
                        <div class="cart_remove">
                          <a href="#" class="btn-delete" name_productCart="<?php echo $value['name'] ?>" id_productCart="<?php echo $value['id']; ?>"><i class="ion-android-close"></i></a>
                        </div>
                      </div>
                    <?php
                    }
                    ?>
                  </div>
                  <?php
                  ?>

                  <div class="cart_total mt-5">
                    <span>Subtotal : </span>
                    <span>$<?= $total ?>.00</span>
                  </div>
                  <div class="mini_cart_footer">
                    <div class="cart_button view_cart">
                      <a href="./cartPage.php">View Cart</a>
                    </div>
                    <div class="cart_button checkout">
                      <a href="./Checkout.php" class="active">Checkout</a>
                    </div>
                  </div>
                <?php
                } else {
                ?>
                  <section class="alert alert-danger my-5 text-center">Your Cart is currently empty</section>
                <?php
                }
                ?>
              </div>
              <!-- mini cart ends  -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- header middle ends -->

  <!-- header bottom starts -->

  <div class="header_bottom sticky-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12">
          <div class="main_menu_inner">
            <div class="logo_sticky">
              <a href="#"><img src="./public/images/logo/logo7.jpg" alt="logo"></a>
            </div>
            <div class="main_menu">
              <nav>
                <ul>
                  <li class="active">
                    <a href="./home.php">Home <i class="ion-chevron-down"></i></a>
                    <ul class="sub_menu">
                      <li><a href="#banner">Banner</a></li>
                      <li><a href="#onSale">On-Sale</a></li>
                      <li><a href="#collection">Collection</a></li>
                      <li><a href="#bestselling">Best Selling</a></li>
                      <li><a href="#instagram">Instagram</a></li>
                      <li><a href="#subcribe">Subscribe</a></li>
                    </ul>
                  </li>
                  <li>
                    <a href="./aboutUs.php">About Us</a>
                  </li>
                  <li>
                    <a href="productPage.php">Products</a>
                  </li>
                  <li>
                    <a href="#">
                      Category <i class="ion-chevron-down"></i>
                    </a>
                    <ul class="sub_menu pages">
                      <?php foreach ($arr_category as $category) : ?>
                        <li><a href="#"><?= $category['category_name'] ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </li>
                  <li>
                    <a href="#">Brand <i class="ion-chevron-down"></i></a>
                    <ul class="sub_menu pages">
                      <?php foreach ($arr_brand as $brand) : ?>
                        <li><a href="#"><?= $brand['brand_name'] ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </li>
                  <li>
                    <a href="#"> Gemstone <i class="ion-chevron-down"></i></a>
                    <ul class="sub_menu pages">
                      <?php foreach ($arr_gemstone as $gemstone) : ?>
                        <li><a href="#"><?= $gemstone['gemstone_name'] ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </li>
                  <li>
                    <a href="./contactUs.php">Contact Us</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- header bottom ends -->
</header>