<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
$errors = [];
include "connect.php";
$order_detail = [];
$totalMoney = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {

        $sql = "SELECT * FROM order_detail INNER JOIN product on order_detail.product_id = product.id INNER JOIN product_order on order_detail.order_id = product_order.id INNER JOIN account on product_order.account_id = account.id 
        INNER JOIN category on product.category_id = category.id INNER JOIN brand on product.brand_id = brand.id INNER JOIN gemstone on product.gemstone_id = gemstone.id INNER JOIN order_method on order_method.id = product_order.orderMethod_id WHERE order_detail.order_id = $id ";


        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $order_detail = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            echo json_encode('Error: ' . $conn->error);
        }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }

    try {
        $sql = "SELECT * FROM order_detail INNER JOIN product on order_detail.product_id = product.id INNER JOIN product_order on order_detail.order_id = product_order.id INNER JOIN account on product_order.account_id = account.id 
        INNER JOIN category on product.category_id = category.id INNER JOIN brand on product.brand_id = brand.id INNER JOIN gemstone on product.gemstone_id = gemstone.id INNER JOIN order_method on order_method.id = product_order.orderMethod_id WHERE order_detail.order_id = $id GROUP BY order_detail.order_id";
        // $sql = "SELECT order_detail.id, order_detail.order_id, order_detail.price,  order_detail.quantity, product.price, product_order.order_date, account.fullname, account.email, account.phone, account.address, product.avatar, product.name, product.description, product.price 
        // FROM order_detail INNER JOIN product on order_detail.product_id = product.id INNER JOIN product_order on order_detail.order_id = product_order.id INNER JOIN account on product_order.account_id = account.id INNER JOIN category on product.category_id = category.id
        // INNER JOIN brand on product.brand_id = brand.id INNER JOIN gemstone on product.gemstone_id = gemstone.id INNER JOIN order_method on order_method.id = product_order.orderMethod_id GROUP BY order_detail.order_id ";
        

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();
         } //else {
        //     echo json_encode('Error: ' . $conn->error);
        // }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>
    <link rel="shortcut icon" href="../public/font/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../public/css/admin.css?v=1">
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
<section class="flex-wrap d-flex ">
    <?php include "navbar.php" ?>
    <section>
        <div class="container-fluid">
            <div class="list_acc row">
                <div class="col-md-12" style="min-height: 40rem;">
                    <div class="list_order border rounded-lg">
                        <div class="create-order bg-info p-3 w-100 d-flex justify-content-between">
                            <h2 class="text-white">Order Detail</h2>
                        </div>
                        <div class="table_order p-3">
                            <table class="table table-bordered mb-5">
                                <tbody>
                                    <?php
                                    if (is_array($order)) {
                                        ?>
                                            <tr>
                                                <th>Fullname</th>
                                                <td><?php echo $order['fullname']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?php echo $order['email']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Phone Number</th>
                                                <td><?php echo $order['phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td><?php echo $order['address']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Order_method</th>
                                                <td><?php echo $order['orderName']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Order Date</th>
                                                <td><?php echo $order['order_date']; ?></td>
                                            </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                            <h2 class="text-center text-success">Total Money</h2>
                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Avatar</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Gemstone</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (is_array($order_detail)) {
                                        foreach ($order_detail as $index => $value) {
                                    ?>
                                            <tr>
                                                <td><?php echo ++$index; ?></td>
                                                <td><img src="<?php if (!empty($value['avatar'])) : echo $value['avatar']; else : echo '../public/images/avatar/imageDefault.jpg'; endif; ?>" alt="product" height="50" width="100"></td>
                                                <td><?php echo $value['name']; ?></td>
                                                <td><?php echo $value['category_name']; ?></td>
                                                <td><?php echo $value['brand_name']; ?></td>
                                                <td><?php echo $value['gemstone_name']; ?></td>
                                                <td>$<?php echo $value['price']; ?>.00</td>
                                                <td><?php echo $value['quantity']; ?></td>
                                                <td>$<?php echo $value['quantity'] * $value['price']; ?>.00</td>
                                            </tr>
                                    <?php
                                            $totalMoney += ($value['quantity'] * $value['price']);
                                        }
                                    }

                                    ?>
                                </tbody>
                                <tr>
                                    <th colspan="7" style="text-align: center;">Total Money</th>
                                    <th colspan="7" style="text-align: center;">$<?= $totalMoney ?>.00</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-white">
        <div class="container my-auto py-4">
            <div class="text-center my-auto text-black-50 small">
                <span>Copyright @Phung Van Tien 2022</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->
</section>
</body>

</html>