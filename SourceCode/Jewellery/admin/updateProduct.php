<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
include "connect.php";
$product = [];
$sql = sprintf("SELECT product.id, product.avatar, product.name,product.description, product.price, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name");
$result = $conn->query($sql);
if($result) {
    $product = $result->fetch_assoc();
} else {
    echo 'Error: '. $conn->error;
}

if (isset($_POST['updateProduct'])) {
    $id = (int)htmlspecialchars($_POST['id']);
    $conn->real_escape_string($id);
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
    } 
    else {
        $avatar = !empty($products['avatar']) ? $products['avatar'] : '../public/images/avatar/imageDefault.jpg';
    }

    $sql = sprintf("UPDATE product SET avatar = '%s', name = '%s', description = '%s', price = %f, category_id = %d, brand_id = %d, gemstone_id = %d WHERE id = %d",$avatar, $name, $description, $price, $category_id, $brand_id, $gemstone_id, $id);
    $result = $conn->query($sql);
    if ($result) {
        $sql = "SELECT product.id, product.avatar, product.name,product.description, product.price, category.category_name, brand.brand_name, gemstone.gemstone_name FROM product inner join brand on product.brand_id = brand.id inner join category on product.category_id = category.id inner join gemstone on product.gemstone_id = gemstone.id GROUP BY product.id, product.name";
        $arr_product = [];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr_product = $result->fetch_all(MYSQLI_ASSOC);
            $html = '';
            foreach ($arr_product as $products) {
                $product_avatar = !empty($products['avatar']) ? $products['avatar'] : '../public/images/avatar/imageDefault.jpg';
                $html .= '<tr>';
                $html .= '<td>' . $products['id'] . '</td>';
                $html .= "<td> <img src='{$product_avatar}' alt='product' height='50' width='100'></td>";
                $html .= '<td>' . $products['name'] . '</td>';
                $html .= '<td>' . $products['description'] . '</td>';
                $html .= '<td>' . $products['price'] . '</td>';
                $html .= '<td>' . $products['category_name'] . '</td>';
                $html .= '<td>' . $products['brand_name'] . '</td>';
                $html .= '<td>' . $products['gemstone_name'] . '</td>';
                $html .= '<td class="d-flex justify-content-around">';
                $html .= '<a data-id="' . $products['id'] . '" href="#" class="btn btn-warning btn-updateProduct text-white">Update</a>';
                $html .= '<a name_product="' . $products['name'] . '" id_product="' . $products['id'] . '" href="#" class="btn btn-danger btn-delete">Delete</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            echo json_encode(['success' => 'true', 'html_table' => $html]);
        } else {
            echo json_encode(array('error' => 'true', 'message' => 'Error: ' . $conn->error));
        }
    } else {
        echo 'Update Fail';
    }
}
