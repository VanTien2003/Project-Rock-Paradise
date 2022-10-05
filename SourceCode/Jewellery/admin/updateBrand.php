<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
include "connect.php";

if(isset($_POST['updateBrand'])) {
    $id = (int)htmlspecialchars($_POST['id']);
    $conn->real_escape_string($id);
    $brand = htmlspecialchars($_POST['brand']);
    $conn->real_escape_string($brand);
    if (empty($brand)) {
        $errors['brand'] = 'Brand is required';
    }
    $sql = sprintf("UPDATE brand SET brand_name = '%s' WHERE id = $id", $brand);
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
                $html .= '<a data-id="'.$brands['id'].'" href="#" class="btn btn-warning btn-updateBrand text-white">Update</a>';
                $html .= '<a name_brand="'.$brands['brand_name'].'" id_brand="'.$brands['id'].'" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
                $html .= '</td>';
                $html .= '</td>';
            }
            echo json_encode(['success' => 'true', 'html_table' => $html]);
        } else {
            echo json_encode(array('error' => 'true', 'message' => 'Error: ' . $conn->error));
        }
    } else {
        echo 'Update Fail';
    }
}
