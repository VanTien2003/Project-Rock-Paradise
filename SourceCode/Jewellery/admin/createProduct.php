<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
include "connect.php";
$product = array();

if (isset($_POST['create'])) {
    $name = htmlspecialchars($_POST['name']);
    $conn->real_escape_string($name);
    $description = htmlspecialchars($_POST['description']);
    $conn->real_escape_string($description);
    $price = htmlspecialchars($_POST['price']);
    $conn->real_escape_string($price);
    $category_id = (int)htmlspecialchars($_POST['category']);
    $conn->real_escape_string($category_id);
    $brand_id = (int)htmlspecialchars($_POST['brand']);
    $conn->real_escape_string($brand_id);
    $gemstone_id = (int)htmlspecialchars($_POST['gemstone']);
    $conn->real_escape_string($gemstone_id);

    if (empty($name)) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Name is required </div>']);
        return;
    }

    if(empty($description)){
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Description is required </div>']);
        return;
    }

    if (empty($price)) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Price is required </div>']);
        return;
    }

    if (empty($category_id)) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Category is required </div>']);
        return;
    }

    if (empty($brand_id)) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Brand is required </div>']);
        return;
    }

    if (empty($gemstone_id)) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Gemstone is required </div>']);
        return;
    }

    $sql = sprintf("SELECT * FROM product WHERE name = '%s'",$name);
    $result = $conn->query($sql);
        if($result->num_rows > 0) {
            echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Product Name is already exists </div>']);
            return;
        }

    if(!file_exists('uploads')) {
        mkdir('uploads',777);
    }

    if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0){
        $avatar = $_FILES['avatar']['name'];
        $avatar_tmp = $_FILES['avatar']['tmp_name'];
        // phan tach ten file ra va lay ra ten file va extension va chuyen thanh mang
        $fileExt = explode('.', $avatar);
        // lay ra extension
        $fileActualExt = strtolower((end($fileExt)));
        $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'gif', 'bmp', 'webp');

        if(in_array($fileActualExt, $allowed)) {
            $avatar = 'uploads/'. $avatar;
            move_uploaded_file($avatar_tmp, $avatar);
        }
    } else {
        $avatar = !empty($products['avatar']) ? $products['avatar'] : '../public/images/avatar/imageDefault.jpg';
    }

    try {
        $sql = sprintf("INSERT INTO product(id, avatar, name, description, price, category_id, brand_id, gemstone_id) VALUES(null, '%s', '%s', '%s',%f, %d, %d, %d)",$avatar, $name, $description, $price, $category_id, $brand_id, $gemstone_id);
        $result = $conn->query($sql);
        if ($result) {
            $sql = "SELECT product.id, product.avatar, product.name,product.description, product.price, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name";
            $arr_prd = [];
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $arr_prd = $result->fetch_all(MYSQLI_ASSOC);
                $html = '';
                foreach ($arr_prd as $prd) {
                    $product_avatar = !empty($prd['avatar']) ? $prd['avatar'] : '../public/images/avatar/imageDefault.jpg';
                    $html .= '<tr>';
                    $html .= '<td>' . $prd['id'] . '</td>';
                    $html .= "<td> <img src='{$product_avatar}' alt='product' height='50' width='100'></td>";
                    $html .= '<td>' . $prd['name'] . '</td>';
                    $html .= '<td>' . $prd['description'] . '</td>';
                    $html .= '<td>' . $prd['price'] . '</td>';
                    $html .= '<td>' . $prd['category_name'] . '</td>';
                    $html .= '<td>' . $prd['brand_name'] . '</td>';
                    $html .= '<td>' . $prd['gemstone_name'] . '</td>';
                    $html .= '<td class="d-flex justify-content-around">';
                    $html .= '<a data-id="' . $prd['id'] . '" href="#" class="btn btn-warning btn-updateProduct text-white">Update</a>';
                    $html .= '<a name_product="' . $prd['name'] . '" id_product="' . $prd['id'] . '" href="#" class="btn btn-danger btn-delete">Delete</a>';
                    $html .= '</td>';
                    $html .= '</td>';
                }
                echo json_encode(['success', $html]);
            } else {
                echo json_encode(array('error' => 'true', 'message' => 'Error: ' . $conn->error));
            }
        } else {
            echo json_encode('fail');
        }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}
