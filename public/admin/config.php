<?php
session_start();
$hostName = "localhost";
$userName = "root";
$password = "";
$dbName = "angelhigh";
$conn = mysqli_connect($hostName, $userName, $password, $dbName);
