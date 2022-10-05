<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: listAdmin.php');
}
include "connect.php";
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = sprintf("DELETE FROM account WHERE id = $id");
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
                $html .= '<a name_admin="'.$acc['fullname'].'" id_admin="' . $acc['id'] . '" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
                $html .= '</td>';
                $html .= '</td>';
            }
            echo json_encode(['success' => 'true', 'html_table' => $html]);
        } else {
            $html = '';
            echo json_encode(array('empty' => 'true', 'message' => 'Infomation admin list empty!', 'html_table' => $html));
        }
    }else {
        if($conn->errno == 1451){
            echo json_encode(array('error' => 'true','message' => 'Account admin cannot be deleted because it has already been ordered'));
        } else {
            echo json_encode(array('error' => 'true', 'message' => 'Error: ' . $conn->error));
        }
    }
}
