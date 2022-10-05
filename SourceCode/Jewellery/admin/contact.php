<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
$errors = [];;
include "connect.php";
$sql = "SELECT * FROM contact ";
$result = $conn->query($sql);
$arr_contact = [];
if ($result->num_rows > 0) {
    $arr_contact = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>Contact</title>
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
                        <div class="list_brand border rounded-lg">
                            <div class="create-brand bg-info p-3 w-100 d-flex justify-content-between">
                                <h2 class="text-white">Contact</h2>
                                <!-- <a href="#" class="btn btn-success btn-addBrand py-2 text-white">Add Brand</a> -->
                            </div>
                            <div class="table_brand p-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (is_array($arr_contact)) {
                                            foreach ($arr_contact as $index => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo ++$index; ?></td>
                                                    <td><?php echo $value['name']; ?></td>
                                                    <td><?php echo $value['phone']; ?></td>
                                                    <td><?php echo $value['email']; ?></td>
                                                    <td><?php echo $value['subject']; ?></td>
                                                    <td><?php echo $value['message']; ?></td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
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