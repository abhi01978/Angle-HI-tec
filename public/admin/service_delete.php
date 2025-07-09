<?php
include 'config.php';
include("middleware.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM services WHERE Id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: /site/admin/service_list.php");
        
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}
