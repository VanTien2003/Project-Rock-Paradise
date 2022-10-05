<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: brandPage.php');
}
include "connect.php";
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = sprintf("DELETE FROM brand WHERE id = $id");
    $result = $conn->query($sql);
    if ($result) {
        $sql = "SELECT * FROM brand";
        $arr_brand = [];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr_brand = $result->fetch_all(MYSQLI_ASSOC);
            $html = '';
            foreach ($arr_brand as $brands) {
                $html .= '<tr>';
                $html .= '<td>' . $brands['id'] . '</td>';
                $html .= '<td>' . $brands['brand_name'] . '</td>';
                $html .= '<td class="d-flex justify-content-around">';
                $html .= '<a data-id="' . $brands['id'] . '" href="#" class="btn btn-warning btn-updateBrand text-white">Update</a>';
                $html .= '<a name_brand="'.$brands['brand_name'].'" id_brand="' . $brands['id'] . '" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
                $html .= '</td>';
                $html .= '</td>';
            }
            echo json_encode(['success' => 'true', 'html_table' => $html]);
        } else {
            $html = '';
            echo json_encode(array('empty' => 'true', 'message' => 'Brand list empty!', 'html_table' => $html));
        }
    }else{
        if($conn->errno == 1451){
            echo json_encode(array('error' => 'true','message' => 'This brand cannot be removed because there are products of that brand'));
        }else {
            echo json_encode(array('error' => 'true', 'message' => 'Error: ' . $conn->error));
        }
    }
}
