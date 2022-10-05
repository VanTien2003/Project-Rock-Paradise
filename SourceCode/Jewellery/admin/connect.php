<?php 
    $conn = new mysqli("localhost", "root", "vertrigo", "TermProject1");
    if($conn->connect_error) {
        die("Connection Failed: ". $conn->connect_error);
    }
?>