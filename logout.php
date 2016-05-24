<?php
session_start();
unset($_SESSION['roleID']);
unset($_SESSION["username"]);
header("Location:http://localhost/GCaaS-3/index.php");
?>