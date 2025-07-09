<?php
include("config.php");
session_destroy();
echo "<script>window.location.href = '/site/admin/login.php'</script>";
