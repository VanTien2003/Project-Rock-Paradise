<?php
session_start();
include "connect.php";

if(isset($_SESSION['user'])) {
    // echo "<script>location</script>";
} else {
    header('location:login.php');
}

if (isset($_POST['update'])) {
    $fullname = htmlspecialchars($_POST['fullname']);
    $conn->real_escape_string($fullname);
    $phone = htmlspecialchars($_POST['phone']);
    $conn->real_escape_string($phone);
    $address = htmlspecialchars($_POST['address']);
    $conn->real_escape_string($address);

    $sql = sprintf("UPDATE account set fullname = '%s', phone = '%s', address = '%s' WHERE role = 'user' AND email= '" . $_SESSION['user'] . "' ", $fullname, $phone, $address);
    $result = $conn->query($sql);
    if ($result) {
    } else {
        echo 'Error: ' . $conn->error;
    }
}

$sql = "SELECT * FROM account WHERE role = 'user' AND email='" . $_SESSION['user'] . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $user = $result->fetch_array();
} else {
    echo 'Error: ' . $conn->error;
}

$sql = "SELECT * FROM order_method";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $orderMethod = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo 'Error:' . $conn->error;
}

if (isset($_POST['orderMethod_id'])) {
    $orderMethod_id = $_POST['orderMethod_id'];
    $userId = $user['id'];
    $sql = sprintf("INSERT INTO product_order(account_id, orderMethod_id, order_date) VALUES(%d, %d , now())", $userId, $orderMethod_id);
    $result = $conn->query($sql);
    if ($result) {
        $sql = "SELECT id FROM product_order order by id DESC limit 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();
            $orderId = $order['id'];
            foreach (array_keys($_SESSION['cart']) as $productId) {
                $quantity = $_SESSION['cart'][$productId];
                $sql = "SELECT price FROM product WHERE id = $productId";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                    $price = $product['price'];
                    $sql = sprintf("INSERT INTO order_detail VALUES(null, %d, %d, %f, %d)", $orderId, $productId, $price, $quantity);
                    $result = $conn->query($sql);
                } else {
                    echo 'Error:' . $conn->error;
                }
            }
        } else {
            echo 'Error:' . $conn->error;
        }
    } else {
        echo 'Error: ' . $conn->error;
    }
    unset($_SESSION['cart']);
    echo "<script>alert('Your order has been placed successfully!'); location='home.php'</script>";

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Check Out Page</title>
    <link rel="shortcut icon" href="public/font/favicon.ico" type="image/x-icon" />
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" href="./public/css/header.css?v=1">
    <link rel="stylesheet" href="./public/css/footer.css?v=2" />
    <!-- Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include "header.php"; ?>
    <section>
        <div class="container my-5">
            <h1 class="section-title d-flex justify-content-center align-items-center text-success mb-4">YOUR ORDER INFORMATION</h1>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-6 pr-4">
                        <h2 class="cus-info text-primary my-3">Customer Information</h2>
                        <div class="form-group">
                            <label>Fullname: </label>
                            <input type="text" class="form-control mb-3 mt-1" name="fullname" value="<?= $user['fullname'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email: </label>
                            <input type="email" class="form-control mb-3 mt-1" name="email" value="<?= $user['email'] ?>" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Phone: </label>
                            <input type="tel" class="form-control mb-3 mt-1" name="phone" value="<?= $user['phone'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Address: </label>
                            <input type="text" class="form-control mb-4 mt-1" name="address" value="<?= $user['address'] ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Update" name="update" class="btn btn-success btn-lg w-100 text-white">
                        </div>
                    </div>
                    <div class="col-md-6 pl-4">
                        <h2 class="product-info text-primary mt-3 mb-4"> Product Details You Choose</h2>
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th>STT</th>
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (is_array($prd_cart) && count($prd_cart) > 0) {
                                    foreach ($prd_cart as $index => $value) {
                                    ?>
                                        <tr class="text-center">
                                            <td><?= ++$index; ?></td>
                                            <td><img src="admin/<?php if (!empty($value['avatar'])) : echo $value['avatar']; else : echo './public/images/avatar/imageDefault.jpg'; endif; ?>" alt="product" height="50" width="60"></td>
                                            <td><?= $value['name']; ?></td>
                                            <td>$<?= $value['price']; ?>.00</td>
                                            <td><?= $_SESSION['cart'][$value['id']] ?></td>
                                            <td>$<?= $value['price'] * $_SESSION['cart'][$value['id']] ?>.00</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr class="text-center">
                                        <th colspan="5" >Total Money</th>
                                        <th>$<?=$total?>.00</th>
                                    </tr>
                                <?php }?>
                            </tbody>      
                        </table>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6 mb-5 pr-4" style="padding-left:7rem;">
            <h2 class="text-primary mb-3">Order method</h2>
            <form action="" method="post">
                <?php foreach ($orderMethod as $orderMethod) { ?>
                    <div class="form-check mb-2">
                        <input type="radio" required name="orderMethod_id" value="<?= $orderMethod['id'] ?>" <?= $orderMethod['id'] != 1 ?: 'checked' ?> class="form-check-input"> <?= $orderMethod['orderName']?>
                    </div>
                <?php }; ?>
                <div class="form-group mt-4">
                    <input type="submit" value="Order" class="btn btn-warning text-white w-100 btn-lg" id="btn-order">
                </div>
            </form>
        </div>
    </section>
    <?php include "footer.php" ?>
</body>
<!-- JS -->

<script src="https://kit.fontawesome.com/d8162761f2.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="./public/js/main.js?v=2"></script>

</html>