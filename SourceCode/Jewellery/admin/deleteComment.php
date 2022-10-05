<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: comments.php');
}
include "connect.php";
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = sprintf("DELETE FROM comments WHERE id = $id");
    $result = $conn->query($sql);
    if ($result) {
        $sql = "SELECT comments.id, account.fullname, account.email, account.phone, comments.content, comments.created_at, comments.status  FROM account INNER JOIN comments on account.id = comments.account_id INNER JOIN product on comments.product_id = product.id";
        $arr_comment = [];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr_comment = $result->fetch_all(MYSQLI_ASSOC);
            $html = '';
            foreach ($arr_comment as $index => $comments) {
                $html .= '<tr>';
                $html .= '<td>' . ++$index . '</td>';
                $html .= '<td>' . $comments['fullname'] . '</td>';
                $html .= '<td>' . $comments['email'] . '</td>';
                $html .= '<td>' . $comments['phone'] . '</td>';
                $html .= '<td>' . $comments['content'] . '</td>';
                $html .= '<td>' . $comments['created_at'] . '</td>';
                $html .= '<td>' . $comments['status'] . '</td>';
                $html .= '<td class="d-flex justify-content-around">';
                $html .= '<a data-id="' . $comments['id'] . '" href="#" class="btn btn-warning btn-updateComment text-white">Update</a>';
                $html .= '<a id_comment="' . $comments['id'] . '" href="#" class="btn btn-danger btn-delete btn-delete">Delete</a>';
                $html .= '</td>';
                $html .= '</td>';
            }
            echo json_encode(['success' => 'true', 'html_table' => $html]);
        } else {
            $html = '';
            echo json_encode(array('empty' => 'true', 'message' => 'Comment list empty!', 'html_table' => $html));
        }
    } else {
        echo json_encode(array('error' => 'true', 'message' => 'Error: ' . $conn->error));
    }
}
