<?php
session_start();
include "connect.php";
$arr_prd = [];
$bestselling = [];
$price = [];
$productDetail = [];
$comments = [];
$images = [];
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
$sql = "SELECT product.id, product.avatar, product.name,product.description, product.price, product.category_id, product.brand_id, product.gemstone_id, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $bestselling = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo 'Error: ' . $conn->error;
}


// Price
$sql = "SELECT * FROM price";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $price = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo 'Error: ' . $conn->error;
}

// Product Detail

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];
    try {
        $sql = "SELECT product.id, product.avatar, product.name,product.description, product.price, product.category_id, product.brand_id, product.gemstone_id, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name HAVING product.id='$productId'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $productDetail = $result->fetch_assoc();
            $sql = sprintf("SELECT * FROM gallery INNER JOIN product ON gallery.product_id = product.id WHERE gallery.product_id = '$productId'");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $images = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                echo "Error: Select gallery!" . $conn->error;
            }
        }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}

if (is_array($productDetail) && isset($productId)) {
?>
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
                                    <div class="tab-pane fade" id="tab<?=++$index?>" role="tabpanel">
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
                                                        <a href="#tab<?=++$index?>" class="nav-link active" data-toggle="tab" role="tab" aria-controls="tab<?=++$index?>" aria-selected="false">
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
                                <span>$<?= $productDetail['price']; ?>.00</span>
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
                        $sql = "SELECT comments.id, account.fullname, account.email, account.phone, comments.content, comments.created_at, comments.status  FROM account INNER JOIN comments on account.id = comments.account_id INNER JOIN product on comments.product_id = product.id WHERE comments.status = 1 AND comments.product_id = " . $productDetail['id'];
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
<?php
}
