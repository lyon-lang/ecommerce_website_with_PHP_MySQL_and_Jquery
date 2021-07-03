<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';
unset($_SESSION['cuser']);
header('Location: ../index.php')
?>