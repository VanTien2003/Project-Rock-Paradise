<?php
session_start();
include "connect.php";

// Cart 
$prd_cart = [];
$quantity = 0;
$total = 0;
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'add') {
        $productId = $_GET['productId'];
        if (array_key_exists($productId, $_SESSION['cart'])) {
            if(isset($_POST['number'])) {
                $_SESSION['cart'][$productId] += $_POST['number'];
            }else {
                $_SESSION['cart'][$productId]++;
            }
        } else {
            if(isset($_POST['number'])) {
                $_SESSION['cart'][$productId] = $_POST['number'];
              } else {
                $_SESSION['cart'][$productId] = 1;
              }
        }
        header("Location:?");
    }
    if($_GET['action'] == 'delete') {
        $productId = $_GET['productId'];
        unset($_SESSION['cart'][$productId]);
    }
    if($_GET['action'] == 'clearCart') {
        unset($_SESSION['cart']);
    }
    
    if($_GET['action'] == 'update') {
        foreach(array_keys($_SESSION['cart']) as $key) {
            $_SESSION['cart'][$key] = $_POST[$key];
        }
    }

    if($_GET['action'] == 'order') {
        if(isset($_SESSION['user'])) {
            header('location: Checkout.php');
        } else {
            header('location:login.php?order=1');
        }
    }
}

if (isset($_SESSION['cart'])) {
    $listId = '0';
    foreach (array_keys($_SESSION['cart']) as $key) {
        $listId .= ',' . $key;
    }
    $sql = "SELECT product.id, product.avatar, product.name,product.description, product.price, product.category_id, product.brand_id, product.gemstone_id, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name HAVING product.id in($listId)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $prd_cart = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart Page</title>
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
    <link rel="stylesheet" href="./public/css/cartPage.css?v=2">
</head>

<body class="p-0">
    <?php include "header.php"; ?>
    <section>
        <div class="banner-page">
            <div class="container container-wrapper">
                <div class="title-page">
                    <h2>Cart Page</h2>
                </div>
                <div class="bread-crumb">
                    <a href="./home.php" title="Back to the frontpage">Home<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    <strong>Cart Page</strong>
                </div>
            </div>
        </div>
        <div class="cart-page">
            <div class="container">
                <?php
                if (is_array($prd_cart) && count($prd_cart) > 0) {
                ?>
                    <form method="post" action="?action=update">
                        <div class="col-12 my-5">
                            <div class="clear_cart d-flex justify-content-between my-3">
                                <h1 style="line-height: 1;">Shopping Cart</h1>
                                <div class="event d-flex">
                                    <button class="btn btn-info text-white btn-clearCart mr-4">Clear Cart</button>
                                    <input type="submit" value="Update Cart" class="btn btn-warning text-white">
                                </div>
                            </div>
                            <table class="table table-bordered table-responsive mt-3">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>IMAGE</th>
                                        <th>NAME</th>
                                        <th>QUANTITY</th>
                                        <th>PRICE</th>
                                        <th>TOTAL</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($prd_cart as $index => $value) {
                                    ?>
                                        <tr>
                                            <td class="pl-3"><?= ++$index; ?></td>
                                            <td class="pl-3"><img src="admin/<?php if (!empty($value['avatar'])) : echo $value['avatar']; else : echo './public/images/avatar/imageDefault.jpg'; endif; ?>" alt="product" height="50" width="100"></td>
                                            <td class="pl-3"><?= $value['name']; ?></td>
                                            <td><input type="number" name="<?= $value['id'] ?>" value="<?= $_SESSION['cart'][$value['id']] ?>" class="form-control" min="1" max="99"></td>
                                            <td class="pl-3">$<?= $value['price']; ?>.00</td>
                                            <td class="pl-3">$<?= $value['price'] * $_SESSION['cart'][$value['id']] ?>.00</td>
                                            <td class="pl-3"><a href="#" name_productCart="<?php echo $value['name'] ?>" id_productCart="<?php echo $value['id']; ?>" class="btn btn-danger btn-delete">Delete</a></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="cart-total p-4 my-5">
                        <h2>CART TOTALS</h2>
                        <table class="total-checkout table table-responsive">
                            <tbody>
                                <tr>
                                    <th class="cart-label"><span>Sub Total</span></th>
                                    <th class="cart-amount"><span>$<?= $total ?>.00</span></th>
                                </tr>
                                <tr>
                                    <th class="cart-label"><span>Shipping Cost</span></th>
                                    <th class="cart-amount"><span>Free</span></th>
                                </tr>
                                <tr>
                                    <th class="cart-label"><span>Total</span></th>
                                    <th class="cart-amount"><span>$<?= $total?>.00</span></th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-checkout">
                            <a href="./home.php">
                                <button type="button" class="btn btn-primary text-white p-2">Continue Shopping <i class="fa fa-shopping-cart"></i></button>
                            </a>
                            <a href="?action=order">
                                <button type="button" class="btn btn-warning text-white p-2 ml-37">Checkout<i class="fa fa-check ml-1"></i></button>
                            </a>
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
        </div>
    </section>
    <?php include "footer.php" ?>
</body>
<!-- JS -->
<!-- Sweet Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/d8162761f2.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="./public/js/main.js?v=1"></script>

<script>
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        let id_productCart = $(this).attr('id_productCart');
        let name_productCart = $(this).attr('name_productCart');
        Swal.fire({
            title: `Are you sure you want to delete product ${name_productCart} ?`,
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `?action=delete&productId=${id_productCart}`;
            } else {
                Swal.fire(
                    'Not Delete!',
                    'Product has not been deleted yet.',
                    'error'
                )
            }
        })
    });
    $('.btn-clearCart').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: `Are you sure you want to Clear Cart ?`,
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "?action=clearCart";
            } else {
                Swal.fire(
                    'Not Delete!',
                    'Cart has not been cleared yet.',
                    'error'
                )
            }
        })
    });
</script>

</html>