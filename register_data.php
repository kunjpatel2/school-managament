<?php
include("config.php");
// $sucess = array('success' => 0);
if($_POST['name']!= "" && $_POST['password']!="" && $_POST['email']!=""){ 
    $name=$_POST['name'];
    $email=$_POST['email'];
    md5($password=$_POST['password']);
    // $conformpassword = $_POST['conformpassword'];
    $newpasss = md5($password = $_POST['password']);
    // $newconformpass = md5($conformpassword = $_POST['conformpassword']);
    //chech username is exists or not

    if ($email && $name && $newpasss  != "") {
        $query = "SELECT COUNT(name) FROM `user` WHERE `username` = '$email'";
        $res = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($res);
        $count = $row[0];
        // print_r($count);
        if($count==0){
        $stmt = $conn->prepare("INSERT INTO `user`(`name`,`username`, `password`) VALUES (?,?,?)");
        $stmt->bind_param("sss", $name, $email, $newpasss);
        $stmt->execute();
        // $sucess = array('success'=>1);
        echo "success";
        }
    }
    // echo "abcd";
    // header("location:register.php");
}
// echo $jsondata = json_encode($sucess);
// print_r($sucess);
// exit;
?>
