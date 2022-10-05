<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
$errors = [];;
include "connect.php";
$sql = "SELECT comments.id, account.fullname, account.email, account.phone, comments.content, comments.created_at, comments.status  FROM account INNER JOIN comments on account.id = comments.account_id INNER JOIN product on comments.product_id = product.id";
$result = $conn->query($sql);
$arr_comments = [];
if ($result->num_rows > 0) {
    $arr_comments = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments List</title>
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
                        <div class="list_comment border rounded-lg">
                            <div class="create-comment bg-info p-3 w-100 d-flex justify-content-between">
                                <h2 class="text-white">Comments</h2>
                                <!-- <a href="#" class="btn btn-success btn-addBrand py-2 text-white">Add Brand</a> -->
                            </div>
                            <div class="table_comment p-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Fullname</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Content</th>
                                            <th>Create_at</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (is_array($arr_comments)) {
                                            foreach ($arr_comments as $index => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo ++$index; ?></td>
                                                    <td><?php echo $value['fullname']; ?></td>
                                                    <td><?php echo $value['email']; ?></td>
                                                    <td><?php echo $value['phone']; ?></td>
                                                    <td><?php echo $value['content']; ?></td>
                                                    <td><?php echo $value['created_at']; ?></td>
                                                    <td><?php echo $value['status']; ?></td>
                                                    <td class="d-flex justify-content-around">
                                                        <a data-id="<?php echo $value['id']; ?>" href="#" class="btn btn-warning btn-updateComment text-white">Update</a>
                                                        <button id_comment="<?php echo $value['id']; ?>" class="btn btn-danger btn-delete">Delete</button>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <form id="form_delete" action="deleteComment.php" method="get">
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

<!-- Modal Update Status -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateStatus" method="post" class="border rouned-lg">
                    <h2 class="text-white bg-info p-3 w-100">Update Status</h2>
                    <input type="hidden" name="id">
                    <div class="input-form p-3">
                        <div class="form-group mb-3">
                            <label>Status </label>
                            <input type="number" min="0" max="1" class="form-control mt-1" name="status" placeholder="Enter status" required>
                        </div>
                        <input type="hidden" name="create" value="1">
                        <input type="submit" value="Update" name="update_btn" class="btn btn-success text-white py-2 px-3">
                        <?php
                        foreach ($errors as $errors) {
                            echo '<div class="alert alert-danger mt-2" role="alert">' . $errors . '</div>';
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function handleUpdateClick() {
        $('.btn-updateComment').on('click', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            console.log(id);
            $('#updateModal').modal('show');
            $.ajax({
                url: 'getCommentById.php?id=' + id,
                type: 'get',
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#updateStatus').html(res);
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
            let id_comment = $(this).attr('id_comment');
            Swal.fire({
                title: `Are you sure you want to delete comment this ?`,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'deleteComment.php?id=' + id_comment,
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
                                    text: 'Delete Comment Successfully!',
                                    icon: 'success',
                                    confirmButtonText: "OK"
                                });
                                $('.table_comment table tbody').html(data.html_table);
                                handleUpdateClick();
                                handleDeleteClick();

                            }
                        }
                    });
                } else {
                    Swal.fire(
                        'Not Delete!',
                        'Comment has not been deleted yet.',
                        'error'
                    )
                }
            })
        });
    }

    $(document).ready(function() {
        handleUpdateClick();
        handleDeleteClick();

        $('#updateStatus').on('submit', function(e) {
            e.preventDefault();
            let form = e.target;
            let data = new FormData(form);
            data.append('updateStatus', 'true');
            $.ajax({
                url: 'updateComment.php',
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function(res) {
                    let data_return = JSON.parse(res);
                    if (typeof(data_return) == 'object' && data_return.success == 'true') {
                        swal.fire({
                            title: 'Success',
                            text: 'Update Status successfully!',
                            icon: 'success',
                            confirmButtonText: "OK"
                        });
                        $('#updateModal').modal('hide');
                        $('.table_comment table tbody').html(data_return.html_table);
                        handleUpdateClick();
                        handleDeleteClick();
                    }
                }
            });
        });
    });
</script>
</html>