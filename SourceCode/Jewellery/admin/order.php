<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
$errors = [];;
include "connect.php";
$sql = "SELECT order_detail.id, order_detail.order_id, order_detail.price,  order_detail.quantity, product.price, product_order.order_date, account.fullname, account.email, account.phone, account.address, product.avatar, product.name, product.description, product.price 
FROM order_detail INNER JOIN product on order_detail.product_id = product.id INNER JOIN product_order on order_detail.order_id = product_order.id INNER JOIN account on product_order.account_id = account.id GROUP BY order_detail.order_id ";

$result = $conn->query($sql);
$order_detail = [];
if ($result->num_rows > 0) {
    $order_detail = $result->fetch_all(MYSQLI_ASSOC);
} //else {
//     echo 'Error: ' . $conn->error;
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link rel="shortcut icon" href="../public/font/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../public/css/admin.css?v=2">
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
                            <h2 class="text-white">Order</h2>
                        </div>
                        <div class="table_order p-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Addresss</th>
                                        <th>Order Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (is_array($order_detail)) {
                                        foreach ($order_detail as $index => $value) {
                                    ?>
                                            <tr>
                                                <td><?php echo ++$index; ?></td>
                                                <td><?php echo $value['fullname']; ?></td>
                                                <td><?php echo $value['email']; ?></td>
                                                <td><?php echo $value['phone']; ?></td>
                                                <td><?php echo $value['address']; ?></td>
                                                <td><?php echo $value['order_date']; ?></td>
                                                <td class="d-flex justify-content-around">
                                                    <a data-id="<?php echo $value['order_id']; ?>" href="#" class="btn btn-primary btn-orderDetail text-white">Detail</a>
                                                    <button name_order="<?php echo $value['fullname'] ?>" id_order="<?php echo $value['order_id']; ?>" class="btn btn-danger btn-delete">Delete</button>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <form id="form_delete" action="deleteOrder.php" method="get">
                                <input type="hidden" name="id">
                            </form>
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

<script>
    function handleUpdateClick() {
        $('.btn-orderDetail').on('click', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            console.log(id);
            window.location = "orderDetail.php?id=" + id;
        });
    }

    function handleDeleteClick() {
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            let id_order = $(this).attr('id_order');
            let name_order = $(this).attr('name_order');
            Swal.fire({
                title: `Are you sure you want to delete Infomation Order of ${name_order} ?`,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'deleteOrder.php?id=' + id_order,
                        type: 'GET',
                        contentType: false,
                        processData: false,
                        success: function(res) {
                            let data = JSON.parse(res);
                            if (data.error == 'true') {
                                swal.fire({
                                    title: 'An error has occurred',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: "OK"
                                });
                            }
                            if (data.empty == 'true') {
                                swal.fire({
                                    title: 'Warning',
                                    text: data.message,
                                    icon: 'warning',
                                    confirmButtonText: "OK"
                                });
                                $('.table_order table tbody').html(data.html_table);
                                handleUpdateClick();
                                handleDeleteClick();
                            }
                            if (data.success == 'true') {
                                swal.fire({
                                    title: 'Success',
                                    text: 'Delete Infomation Order Successfully!',
                                    icon: 'success',
                                    confirmButtonText: "OK"
                                });
                                $('.table_order table tbody').html(data.html_table);
                                handleUpdateClick();
                                handleDeleteClick();

                            }
                        }
                    });
                } else {
                    Swal.fire(
                        'Not Delete!',
                        'Infomation Order has not been deleted yet.',
                        'error'
                    )
                }
            })
        });
    }

    $(document).ready(function() {
        handleUpdateClick();
        handleDeleteClick();
    });
</script>

</html>