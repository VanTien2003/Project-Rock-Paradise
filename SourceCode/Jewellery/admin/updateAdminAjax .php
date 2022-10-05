<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
include "connect.php";

if(isset($_POST['updateAdmin'])) {
    $id = (int)htmlspecialchars($_POST['id']);
    $conn->real_escape_string($id);
    $fullname = htmlspecialchars($_POST['fullname']);
    $conn->real_escape_string($fullname);
    $email = htmlspecialchars($_POST['email']);
    $conn->real_escape_string($email);
    $phone = htmlspecialchars($_POST['phone']);
    $conn->real_escape_string($phone);
    $address = htmlspecialchars($_POST['address']);
    $conn->real_escape_string($address);
    $new_password = htmlspecialchars($_POST['new_password']);
    $conn->real_escape_string($new_password);
    $new_password_confirm = htmlspecialchars($_POST['new_password_confirm']);
    $conn->real_escape_string($new_password_confirm);
    if (empty($password)) {
        $errors['password'] = 'password is required';
    }
    if ($password != $password_confirm) {
        $errors['password_confirm'] = 'Password does not match';
    }
    if (empty($fullname)) {
        $errors['fullname'] = 'Fullname is required';
    }
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }
    if (empty($address)) {
        $errors['address'] = 'Address is required';
    }
    if (empty($phone)) {
        $errors['phone'] = 'Phone is required';
    }
    if (empty($new_password) && empty($new_password_confirm)) {
        $sql = sprintf("UPDATE account SET phone = '%s', address = '%s' WHERE id = %d ", $phone, $address, $id);
    } else {
        $sql = sprintf("UPDATE account SET phone = '%s', address = '%s', password = '%s' WHERE id = %d ", $phone, $address, sha1($new_password), $id);
    }
    $result = $conn->query($sql);
    if ($result) {
        $sql = "SELECT * FROM account WHERE role = 'admin' ";
        $arr_acc = [];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr_acc = $result->fetch_all(MYSQLI_ASSOC);
            $html = '';
            foreach ($arr_acc as $acc) {
                $html .= '<tr>';
                $html .= '<td>' . $acc['id'] . '</td>';
                $html .= '<td>' . $acc['role'] . '</td>';
                $html .= '<td>' . $acc['fullname'] . '</td>';
                $html .= '<td>' . $acc['email'] . '</td>';
                $html .= '<td>' . $acc['phone'] . '</td>';
                $html .= '<td>' . $acc['address'] . '</td>';
                $html .= '<td class="d-flex justify-content-around">';
                $html .= '<a data-id="'.$acc['id'].'" href="#" class="btn btn-warning btn-updateAdmin text-white">Update</a>';
                $html .= '<a name_admin="'.$acc['fullname'].'" id_admin="'.$acc['id'].'" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
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
