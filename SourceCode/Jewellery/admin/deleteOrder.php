<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: listUser.php');
}
include "connect.php";
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = sprintf("DELETE FROM order_detail WHERE order_id = $id");
    $result = $conn->query($sql);
    if ($result) {
        $sql = sprintf("DELETE FROM product_order WHERE id = $id");
        $result = $conn->query($sql);
        if($result) {

        } else {
            echo json_encode(array('error' => 'true', 'message' => 'Error:  Delete product_order failed!' . $conn->error));
        }

        $sql = "SELECT order_detail.id, order_detail.order_id, order_detail.price,  order_detail.quantity, product.price, product_order.order_date, account.fullname, account.email, account.phone, account.address, product.avatar, product.name, product.description, product.price 
        FROM order_detail INNER JOIN product on order_detail.product_id = product.id INNER JOIN product_order on order_detail.order_id = product_order.id INNER JOIN account on product_order.account_id = account.id  GROUP BY order_detail.order_id";
        
        $order_detail = [];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $order_detail = $result->fetch_all(MYSQLI_ASSOC);
            $html = '';
            foreach ($order_detail as $index => $value) {
                $html .= '<tr>';
                $html .= '<td>' . (++$index). '</td>';
                $html .= '<td>' . $value['fullname'] . '</td>';
                $html .= '<td>' . $value['email'] . '</td>';
                $html .= '<td>' . $value['phone'] . '</td>';
                $html .= '<td>' . $value['address'] . '</td>';
                $html .= '<td>' . $value['order_date'] . '</td>';
                $html .= '<td class="d-flex justify-content-around">';
                $html .= '<a data-id="' . $value['order_id'] . '" href="#" class="btn btn-primary btn-orderDetail text-white">Detail</a>';
                $html .= '<a name_order="' . $value['fullname'] . '" id_order="' . $value['order_id'] . '" href="#" class="btn btn-danger btn-delete">Delete</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            echo json_encode(['success' => 'true', 'html_table' => $html]);
        } else {
            $html = '';
            echo json_encode(array('empty' => 'true', 'message' => 'Infomation order list empty!', 'html_table' => $html));
        }
    }else {
        echo json_encode(array('error' => 'true', 'message' => 'Error: Delete failed!' . $conn->error));
    }
}
