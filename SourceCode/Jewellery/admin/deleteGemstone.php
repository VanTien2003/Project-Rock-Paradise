<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: gemstonePage.php');
}
include "connect.php";
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = sprintf("DELETE FROM gemstone WHERE id = $id");
    $result = $conn->query($sql);
    if ($result) {
        $sql = "SELECT * FROM gemstone";
        $arr_gemstone = [];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr_gemstone = $result->fetch_all(MYSQLI_ASSOC);
            $html = '';
            foreach ($arr_gemstone as $gemstones) {
                $html .= '<tr>';
                $html .= '<td>' . $gemstones['id'] . '</td>';
                $html .= '<td>' . $gemstones['gemstone_name'] . '</td>';
                $html .= '<td class="d-flex justify-content-around">';
                $html .= '<a data-id="' . $gemstones['id'] . '" href="#" class="btn btn-warning btn-updateGemstone text-white">Update</a>';
                $html .= '<a name_gemstone="'.$gemstones['gemstone_name'].'" id_gemstone="' . $gemstones['id'] . '" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
                $html .= '</td>';
                $html .= '</td>';
            }
            echo json_encode(['success' => 'true', 'html_table' => $html]);
        } else {
            $html = '';
            echo json_encode(array('empty' => 'true', 'message' => 'Gemstone list empty!', 'html_table' => $html));
        }
    }else{
        if($conn->errno == 1451){
            echo json_encode(array('error' => 'true','message' => 'This Gemstone cannot be removed because there are products of that brand'));
        }else {
            echo json_encode(array('error' => 'true', 'message' => 'Error: ' . $conn->error));
        }
    }
}
