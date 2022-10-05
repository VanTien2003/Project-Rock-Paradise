<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
}
include "connect.php";
$errors = [];
if (isset($_POST['create'])) {
    $gemstone = htmlspecialchars($_POST['gemstone']);
    $conn->real_escape_string($gemstone);
    if (empty($gemstone)) {
        $errors['gemstone'] = 'Gemstone is required';
    }
    if (count($errors) == 0) {
        try {
            $sql = sprintf("INSERT INTO gemstone VALUES(null, '%s')", $gemstone);
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
                        $html .= '<a name_gemstone="' . $gemstones['gemstone_name'] . '" id_gemstone="' . $gemstones['id'] . '" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
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
