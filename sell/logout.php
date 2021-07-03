<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';
unset($_SESSION['vuser']);
header('Location: login.php')
?>