<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: categoryPage.php');
}
include "connect.php";
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = sprintf("DELETE FROM category WHERE id = $id");
    $result = $conn->query($sql);
    if ($result) {
        $sql = "SELECT * FROM category";
        $arr_category = [];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr_category = $result->fetch_all(MYSQLI_ASSOC);
            $html = '';
            foreach ($arr_category as $categorys) {
                $html .= '<tr>';
                $html .= '<td>' . $categorys['id'] . '</td>';
                $html .= '<td>' . $categorys['category_name'] . '</td>';
                $html .= '<td class="d-flex justify-content-around">';
                $html .= '<a data-id="' . $categorys['id'] . '" href="#" class="btn btn-warning btn-updateCategory text-white">Update</a>';
                $html .= '<a name_category="'.$categorys['category_name'].'" id_category="' . $categorys['id'] . '" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
                $html .= '</td>';
                $html .= '</td>';
            }
            echo json_encode(['success' => 'true', 'html_table' => $html]);
        } else {
            $html = '';
            echo json_encode(array('empty' => 'true', 'message' => 'Category list empty!', 'html_table' => $html));
        }
    }else{
        if($conn->errno == 1451){
            echo json_encode(array('error' => 'true','message' => 'This Category cannot be removed because there are products of that brand'));
        }else {
            echo json_encode(array('error' => 'true', 'message' => 'Error: ' . $conn->error));
        }
    }
}
