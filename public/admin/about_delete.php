<?php
include 'config.php';
include("middleware.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM about WHERE Id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: /site/admin/about_list.php");
        
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}
