<?php
include("config.php");
function getuserid(){
    return $_SESSION['uid'];
}
function setdata($conn, $userid, $filedname='', $value='')
{
    if (isset($_GET['action']) && $_GET['action']=='edit') {
        $updateQuery = "UPDATE `profile` SET `value` = ? WHERE `user_id` = ? AND `field` = ?";
        $stmt = $conn->prepare($updateQuery);
        if ($stmt && $userid != '' && $filedname != '' && $value != '') {
            $stmt->bind_param("sis", $value, $userid, $filedname);
            $stmt->execute();
            $stmt->close();
        }  
    }else{
        $insertQuery = "INSERT INTO `profile` (`user_id`, `field`, `value`) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        if ($stmt && $filedname != '' && $value != '') {
            $stmt->bind_param("iss", $userid, $filedname, $value);
            $stmt->execute();
            $stmt->close();
        }
    }
}
function getdata($conn,$id,$filed){
    $getrecord = "SELECT * FROM profile WHERE user_id=$id AND field='$filed'";
    if($filed!=''){
    $res = mysqli_query($conn,$getrecord);
        $string = "";
    $row = mysqli_fetch_assoc($res);
    $string=[$row['field']]=$row['value'];
}
    return $string;
}
