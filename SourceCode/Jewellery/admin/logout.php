<?php
session_start();
if(!isset($_SESSION['email'])) {
    header('location: loginAdmin.php');
} else {
    session_destroy();
    header('Location: loginAdmin.php');
}