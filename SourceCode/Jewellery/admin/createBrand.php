<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
include "connect.php";
$errors = [];
if (isset($_POST['create'])) {
    $brand = htmlspecialchars($_POST['brand']);
    $conn->real_escape_string($brand);
    if (empty($brand)) {
        $errors['brand'] = 'Brand is required';
    }
    if (count($errors) == 0) {
        try {
            $sql = sprintf("INSERT INTO brand VALUES(null, '%s')", $brand);
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
                        $html .= '<a name_brand="' . $brands['brand_name'] . '" id_brand="' . $brands['id'] . '" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
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
            echo json_encode($e->getMessage());;
        }
    }
}
