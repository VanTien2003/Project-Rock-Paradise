<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
$errors = [];;
include "connect.php";
$sql = "SELECT * FROM account WHERE role = 'user' ";
$result = $conn->query($sql);
$arr_acc = [];
if ($result->num_rows > 0) {
    $arr_acc = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo 'Error: ' . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Account</title>
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
                    <div class="list_user border rounded-lg">
                        <div class="create-user bg-info p-3 w-100 d-flex justify-content-between">
                            <h2 class="text-white">User Account</h2>
                            <a href="#" class="btn btn-success btn-createAcc py-2 text-white">Create Account</a>
                        </div>
                        <div class="table_user p-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (is_array($arr_acc)) {
                                        foreach ($arr_acc as $index => $value) {
                                    ?>
                                            <tr>
                                                <td><?php echo ++$index; ?></td>
                                                <td><?php echo $value['fullname']; ?></td>
                                                <td><?php echo $value['email']; ?></td>
                                                <td><?php echo $value['phone']; ?></td>
                                                <td><?php echo $value['address']; ?></td>
                                                <td class="d-flex justify-content-around">
                                                    <a data-id="<?php echo $value['id']; ?>" href="#" class="btn btn-warning btn-updateUser text-white">Update</a>
                                                    <button name_user="<?php echo $value['fullname'] ?>" id_user="<?php echo $value['id']; ?>" class="btn btn-danger btn-delete">Delete</button>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <form id="form_delete" action="deleteUser.php" method="get">
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
<!-- Modal Add New User-->
<div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addNewUser" method="post" class="border rouned-lg">
                    <h2 class="text-white bg-info p-3 w-100">Create Account</h2>
                    <div class="input-form p-3">
                        <div class="form-group mb-3">
                            <label>Account For </label>
                            <input type="text" class="form-control mt-1" id="role" name="role" placeholder="Enter role" value="user" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label>Fullname </label>
                            <input type="text" class="form-control mt-1" id="fullname" name="fullname" placeholder="Enter fullname" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email </label>
                            <input type="email" class="form-control mt-1" id="email" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Phone Number </label>
                            <input type="text" pattern="[0-9]{10,11}" class="form-control mt-1" id="phone" name="phone" placeholder="Enter phone " required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control mt-1" id="address" name="address" placeholder="Enter address" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Password </label>
                            <input type="password" class="form-control mt-1" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control mt-1" id="password_confirm" name="password_confirm" placeholder="Confirm password " required>
                        </div>
                        <input type="hidden" name="create" value="1">
                        <input type="submit" value="Create" name="create_btn" class="btn btn-success text-white py-2 px-3">
                        <div class="error-wrap">
                            <?php
                                foreach ($errors as $errors) {
                                    echo '<div class="alert alert-danger mt-2" role="alert">' . $errors . '</div>';
                                }
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update User-->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update User Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateUser" method="post" class="border rouned-lg">
                    <h2 class="text-white bg-info p-3 w-100">Update User Account</h2>
                    <input type="hidden" name="id">
                    <div class="input-form p-3">
                        <div class="form-group mb-3">
                            <label>Fullname </label>
                            <input type="text" class="form-control mt-1" name="fullname" placeholder="Enter fullname" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email </label>
                            <input type="email" class="form-control mt-1" name="email" placeholder="Enter email" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label>Phone Number </label>
                            <input type="text" pattern="[0-9]{10,11}" class="form-control mt-1" name="phone" placeholder="Enter phone " required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control mt-1" name="address" placeholder="Enter address" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Password </label>
                            <input type="password" class="form-control mt-1" name="password" placeholder="Enter password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control mt-1" name="password_confirm" placeholder="Confirm password " required>
                        </div>
                        <input type="hidden" name="create" value="1">
                        <input type="submit" value="Update" name="update_btn" class="btn btn-success text-white py-2 px-3">
                        <div class="error-wrap">
                            <?php
                                foreach ($errors as $errors) {
                                    echo '<div class="alert alert-danger mt-2" role="alert">' . $errors . '</div>';
                                }
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function handleUpdateClick() {
        $('.btn-updateUser').on('click', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            console.log(id);
            $('#updateModal').modal('show');
            $.ajax({
                url: 'getUserById.php?id=' + id,
                type: 'get',
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#updateUser').html(res);
                },
                error: function(err) {
                    console.log(err)
                }
            });
        });
    }

    function handleDeleteClick() {
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            let id_user = $(this).attr('id_user');
            let name_user = $(this).attr('name_user');
            Swal.fire({
                title: `Are you sure you want to delete student ${name_user} ?`,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'deleteUserAjax.php?id=' + id_user,
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
                                    text: 'Delete User Account Successfully!',
                                    icon: 'success',
                                    confirmButtonText: "OK"
                                });
                                $('.table_user table tbody').html(data.html_table);
                                handleUpdateClick();
                                handleDeleteClick();

                            }
                        }
                    });
                } else {
                    Swal.fire(
                        'Not Delete!',
                        'User Account has not been deleted yet.',
                        'error'
                    )
                }
            })
        });
    }

    $(document).ready(function() {
        handleUpdateClick();
        handleDeleteClick();

        $('#addNewUser').on('submit', function(e) {
            e.preventDefault();
            let form = e.target;
            if ($('#password').val() == $('#password_confirm').val()) {
                let data = new FormData(form);
                data.append('addUser', 'true');
                $.ajax({
                    url: 'createAccountAjax.php',
                    type: 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        let data = JSON.parse(res);
                        if (typeof(data) == 'object' && data.error == 'true') {
                            $('#addNewModal .error-wrap').html(data.error_msg);
                            handleUpdateClick();
                            handleDeleteClick();
                        } 

                        if (data[0] == 'success') {
                            $('#addNewModal').modal('hide');
                            $('#addNewUser')[0].reset();
                            $('.table_user table tbody').html(data[1]);
                            handleUpdateClick();
                            handleDeleteClick();
                        }
                    },
                    error: function(err){
                        console.log(err);
                    }
                });
            } else {
                swal.fire({
                    title: 'Warning',
                    text: 'Password not match!',
                    icon: 'warning',
                    confirmButtonText: "OK"
                });
            }
        });

        $('#updateUser').on('submit', function(e) {
            e.preventDefault();
            let form = e.target;
            let data = new FormData(form);
            data.append('updateUser', 'true');
            $.ajax({
                url: 'updateUserAjax.php',
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function(res) {
                    let data_return = JSON.parse(res);
                    if (typeof(data_return) == 'object' && data_return.error == 'true') {
                        $('#updateModal .error-wrap').html(data_return.error_msg);
                        handleUpdateClick();
                        handleDeleteClick();
                    }

                    if (typeof(data_return) == 'object' && data_return.success == 'true') {
                        swal.fire({
                            title: 'Success',
                            text: 'Update User Account Successfully!',
                            icon: 'success',
                            confirmButtonText: "OK"
                        });
                        $('#updateModal').modal('hide');
                        $('.table_user table tbody').html(data_return.html_table);
                        handleUpdateClick();
                        handleDeleteClick();
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
            if ($('#new_password').val() == $('#new_password_confirm').val()) {
                form.submit();
            } else {
                swal.fire({
                    title: 'Warning',
                    text: 'Password not match!',
                    icon: 'warning',
                    confirmButtonText: "OK"
                });
            }
        });

        $('.btn-createAcc').on('click', function(e) {
            e.preventDefault();
            $('#addNewModal').modal('show');
        });

        $('#password_confirm').on('keyup', function(e) {
            if ($('#password').val() != $('#password_confirm').val()) {
                $('#password_confirm').addClass('is-invalid');
            } else {
                $('#password_confirm').removeClass('is-invalid');
            }
        });
    });
</script>

</html>