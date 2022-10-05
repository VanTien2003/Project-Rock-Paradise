<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: listUser.php');
}
include "connect.php";
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = sprintf("DELETE FROM product WHERE id = $id");
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
            $html = '';
            echo json_encode(array('empty' => 'true', 'message' => 'Product list empty!', 'html_table' => $html));
        }
    }else {
        if($conn->errno == 1451){
            echo json_encode(array('error' => 'true','message' => 'This product cannot be deleted because it has already been ordered'));
        } else {
            echo json_encode(array('error' => 'true', 'message' => 'Error: ' . $conn->error));
        }
    }
}
