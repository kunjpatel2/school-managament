<?php
include("config.php");
if($_POST['username']!= "" && $_POST['password']!=""){
    $username=$_POST['username'];
    md5($password=$_POST['password']);
    $newpasss=md5($_POST['password']);
    $query=" SELECT * FROM `user` WHERE username=? AND password=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $newpasss);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row= $result->fetch_assoc()) {
        $_SESSION['uname']=$row['username'];
        $_SESSION['uid']=$row['id'];
       // $_SESSION['logged_in'] = true;
        $success= array('success'=>1);
    }
    else{
        $success= array('success'=>0);
    }
}else{
    $success= array('success'=>2);
}
echo $jsondata= json_encode($success);
exit;
?>
