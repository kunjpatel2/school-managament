<?php
include("config.php");
$id = $_REQUEST['id'];
$query = "DELETE FROM `teacher` WHERE id=$id";
$res = mysqli_query($conn, $query);
header("location:dashboard.php");
?>