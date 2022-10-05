<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}

include "connect.php";
$errors = [];
$arr_prd = [];
$sql = "SELECT product.id, product.avatar, product.name,product.description, product.price, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $arr_prd = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo 'Error: ' . $conn->error;
}

$sql = "SELECT * FROM category";
$result = $conn->query($sql);
$categorys = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categorys[] = $row;
    }
}

$sql = "SELECT * FROM brand";
$result = $conn->query($sql);
$brands = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $brands[] = $row;
    }
}

$sql = "SELECT * FROM gemstone";
$result = $conn->query($sql);
$gemstones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gemstones[] = $row;
    }
}

$sql = "SELECT * FROM account WHERE role = 'admin' ";
$result = $conn->query($sql);
$admin = [];
if ($result->num_rows > 0) {
    $admin = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error: " . $conn->error;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="shortcut icon" href="../public/font/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../public/css/admin.css?v=3">
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
        <?php include "navbar.php"?>
        <section>
            <div class="container-fluid">
                <div class="list_acc row">
                    <div class="col-md-12" style="min-height: 40rem;">
                        <div class="list_product border rounded-lg">
                            <div class="create-product bg-info p-3 w-100 d-flex justify-content-between">
                                <h2 class="text-white">Product List</h2>
                                <a href="#" class="btn btn-success btn-addProduct py-2 text-white">Add Product</a>
                            </div>
                            <div class="table_product p-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Avatar</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Price($)</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Gemstone</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (is_array($arr_prd)) {
                                            foreach ($arr_prd as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $value['id']; ?></td>
                                                    <td><img src="<?php if (!empty($value['avatar'])) : echo $value['avatar'];
                                                                    else : echo '../public/images/avatar/imageDefault.jpg';
                                                                    endif; ?>" alt="product" height="50" width="100"></td>
                                                    <td><?php echo $value['name']; ?></td>
                                                    <td><?php echo $value['description']; ?></td>
                                                    <td><?php echo $value['price']; ?>.00</td>
                                                    <td><?php echo $value['category_name']; ?></td>
                                                    <td><?php echo $value['brand_name']; ?></td>
                                                    <td><?php echo $value['gemstone_name']; ?></td>
                                                    <td class="">
                                                        <a data-id="<?php echo $value['id']; ?>" href="#" class="btn btn-warning btn-updateProduct text-white m-2">Update</a>
                                                        <button name_product="<?php echo $value['name'] ?>" id_product="<?php echo $value['id']; ?>" class="btn btn-danger btn-delete ml-2">Delete</button>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <form id="form_delete" action="deleteProduct.php" method="get">
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
        </div>
        </div>
    </section>
</body>
<!-- Modal Add New Product-->
<div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addNewProduct" method="post" class="border rouned-lg" enctype="multipart/form-data">
                    <h2 class="text-white bg-info p-3 w-100">Add Product</h2>
                    <div class="input-form p-3">
                        <div class="form-group mb-3">
                            <label>Name </label>
                            <input type="text" class="form-control mt-1" id="name" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Description </label>
                            <textarea name="description" class="form-control mt-1" id="description" rows="5" placeholder="Enter description" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label>Price($) </label>
                            <input type="number" class="form-control mt-1" id="price" name="price" placeholder="Enter price" min="0" step=".01" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Category</label>
                            <select name="category" id="category_id" class="form-control mt-1" required>
                                <option value="">-- Select Category --</option>
                                <?php
                                if (is_array($categorys) && count($categorys) > 0) {
                                    foreach ($categorys as $category) {
                                        echo "<option value='$category[id]'>$category[category_name] </option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Brand</label>
                            <select name="brand" id="brand_id" class="form-control mt-1" required>
                                <option value="">-- Select Brand --</option>
                                <?php
                                if (is_array($brands) && count($brands) > 0) {
                                    foreach ($brands as $brand) {
                                        echo "<option value='$brand[id]'>$brand[brand_name] </option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Gemstone</label>
                            <select name="gemstone" id="gemstone_id" class="form-control mt-1" required>
                                <option value="">-- Select Gemstone --</option>
                                <?php
                                if (is_array($gemstones) && count($gemstones) > 0) {
                                    foreach ($gemstones as $gemstone) {
                                        echo "<option value='$gemstone[id]'>$gemstone[gemstone_name] </option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Avatar </label><br>
                            <input type="file" class="mt-1" name="avatar"> <br>
                            <img class="mt-2" src="<?php if (!empty($product['avatar'])) : echo $product['avatar'];
                                                    else : echo '../public/images/avatar/imageDefault.jpg';
                                                    endif; ?>" alt="imageDefault" width="110" height="110">
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

<!-- Modal Update Product-->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateProduct" method="post" class="border rouned-lg" enctype="multipart/form-data">
                    <h2 class="text-white bg-info p-3 w-100">Update Product</h2>
                    <input type="hidden" name="id">
                    <div class="input-form p-3">
                        <div class="form-group mb-3">
                            <label>Name </label>
                            <input type="text" class="form-control mt-1" id="name" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Description </label>
                            <textarea name="description" class="form-control mt-1" id="description" rows="5" placeholder="Enter description" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label>Price($) </label>
                            <input type="number" class="form-control mt-1" id="price" name="price" placeholder="Enter price" min="0" step=".01" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Category</label>
                            <select name="category" id="category_id" class="form-control mt-1" required>
                                <?php
                                if (is_array($categorys) && count($categorys) > 0) {
                                    foreach ($categorys as $category) {
                                        echo "<option value='$category[id]'>$category[category_name] </option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Brand</label>
                            <select name="brand" id="brand_id" class="form-control mt-1" required>
                                <?php
                                if (is_array($brands) && count($brands) > 0) {
                                    foreach ($brands as $brand) {
                                        echo "<option value='$brand[id]'>$brand[brand_name] </option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Gemstone</label>
                            <select name="gemstone" id="gemstone_id" class="form-control mt-1" required>
                                <?php
                                if (is_array($gemstones) && count($gemstones) > 0) {
                                    foreach ($gemstones as $gemstone) {
                                        echo "<option value='$gemstone[id]'>$gemstone[gemstone_name] </option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Avatar </label><br>
                            <input type="file" class="mt-1" name="avatar"> <br>
                            <img class="mt-2" src="<?php if (!empty($product['avatar'])) : echo $product['avatar'];
                                                    else : echo '../public/images/avatar/imageDefault.jpg';
                                                    endif; ?>" alt="imageDefault" width="110" height="110">
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
        $('.btn-updateProduct').on('click', function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            $('#updateModal').modal('show');
            $.ajax({
                url: 'getProductById.php?id=' + id,
                type: 'get',
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#updateProduct').html(res);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    }

    function handleDeleteClick() {
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            let id_product = $(this).attr('id_product');
            let name_product = $(this).attr('name_product');
            Swal.fire({
                title: `Are you sure you want to delete product ${name_product} ?`,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'deleteProduct.php?id=' + id_product,
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
                                    text: 'Delete Product Successfully!',
                                    icon: 'success',
                                    confirmButtonText: "OK"
                                });
                                $('.table_product table tbody').html(data.html_table);
                                handleUpdateClick();
                                handleDeleteClick();

                            }
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                } else {
                    Swal.fire(
                        'Not Delete!',
                        'Product has not been deleted yet.',
                        'error'
                    )
                }
            })
        });
    }

    $(document).ready(function() {
        handleUpdateClick();
        handleDeleteClick();

        $('#addNewProduct').on('submit', function(e) {
            e.preventDefault();
            let form = e.target;
            let data = new FormData(form);
            data.append('addProduct', 'true');

            $.ajax({
                url: 'createProduct.php',
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

                        $('#addNewProduct')[0].reset();
                        $('.table_product table tbody').html(data[1]);
                        handleUpdateClick();
                        handleDeleteClick();
                    } else {
                        console.log(data);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $('#updateProduct').on('submit', function(e) {
            e.preventDefault();
            let form = e.target;
            let data = new FormData(form);
            data.append('updateProduct', 'true');
            $.ajax({
                url: 'updateProduct.php',
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
                            text: 'Update Product Successfully!',
                            icon: 'success',
                            confirmButtonText: "OK"
                        });
                        $('#updateModal').modal('hide');
                        $('.table_product table tbody').html(data_return.html_table);
                        handleUpdateClick();
                        handleDeleteClick();
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $('.btn-addProduct').on('click', function(e) {
            e.preventDefault();
            $('#addNewModal').modal('show');
        });
    });
</script>

</html>