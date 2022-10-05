<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
include "connect.php";
if (isset($_POST['create'])) {
    $fullname = htmlspecialchars($_POST['fullname']);
    $conn->real_escape_string($fullname);
    $email = htmlspecialchars($_POST['email']);
    $conn->real_escape_string($email);
    $phone = htmlspecialchars($_POST['phone']);
    $conn->real_escape_string($phone);
    $address = htmlspecialchars($_POST['address']);
    $conn->real_escape_string($address);
    $password = htmlspecialchars($_POST['password']);
    $conn->real_escape_string($password);
    $password_confirm = htmlspecialchars($_POST['password_confirm']);
    $conn->real_escape_string($password_confirm);

    if (empty($fullname)) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Fullname is required </div>']);
        return;
    }

    if (empty($password)) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Password is required </div>']);
        return;
    }
    if ($password != $password_confirm) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Password does not match </div>']);
        return;
    }

    if (empty($email)) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Email is required </div>']);
        return;
    }

    if (empty($address)) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Address is required </div>']);
        return;
    }

    if (empty($phone)) {
        echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Phone is required </div>']);
        return;
    }
    
    try {
        $sql = sprintf("INSERT INTO account VALUES(null, '%s', '%s', '%s', '%s', '%s',null)", $fullname, $email, sha1($password), $phone, $address);
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
                    $html .= '<a data-id="' . $acc['id'] . '" href="#" class="btn btn-warning btn-updateAdmin text-white">Update</a>';
                    $html .= '<a name_admin="' . $acc['fullname'] . '" id_admin="' . $acc['id'] . '" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
                    $html .= '</td>';
                    $html .= '</td>';
                }
                echo json_encode(['success', $html]);
            } else {
                echo json_encode(array('error' => 'true', 'error_msg' => 'Error: ' . $conn->error));
            }
        } else {
            echo json_encode('fail');
        }
    } catch (Exception $e) {
        if (strpos($conn->error, 'email') != false) {
            echo json_encode(['error' => 'true', 'error_msg' => '<div class="alert alert-danger mt-2" role="alert"> Email already exists </div>']);
            return;
        } else {
            echo json_encode(array('error' => 'true', 'error_msg' => 'Error: ' . $conn->error));
        }
        echo json_encode($e->getMessage());;
    }
    
}
