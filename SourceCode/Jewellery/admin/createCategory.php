<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
include "connect.php";
$errors = [];
if (isset($_POST['create'])) {
    $category = htmlspecialchars($_POST['category']);
    $conn->real_escape_string($category);
    if (empty($category)) {
        $errors['category'] = 'Category is required';
    }
    if (count($errors) == 0) {
        try {
            $sql = sprintf("INSERT INTO category VALUES(null, '%s')", $category);
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
                        $html .= '<a name_category="' . $categorys['category_name'] . '" id_category="' . $categorys['id'] . '" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
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
