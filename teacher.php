<?php
// include("functions.php");
include_once("functions.php");
if($_SESSION['uname']==''){
    header("location:index.php");
}
// delet record from user

$userid = getuserid();
$nameval = '';
$email = '';
$password = '';
$tname = '';
$subname = '';
$number = '';
if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
    $id = $_REQUEST['id'];
    if ($action === 'delete') {
        // Delete record from 'user' table
        $deletrecord = "DELETE FROM `user` WHERE id=$id";
        mysqli_query($conn, $deletrecord);

        // Delete record from 'profile' table
        $deletrecordprofile = "DELETE FROM profile WHERE user_id=$id";
        mysqli_query($conn, $deletrecordprofile);
        
        //Delete from teacher 'table'
        $deletrecordteacher = "DELETE FROM `teacher` WHERE teacher_id=$id";
        if(mysqli_query($conn, $deletrecordteacher)){
            $_SESSION['message'] = [
                'msg_type' => 'success',
                'message' => 'Record deleted successfully.'
            ];
            header("location:teacher.php");
            exit;
        }
    } elseif ($action === 'edit') {
        $tea_id = $_REQUEST['id'];
        $nameval = getdata($conn, $tea_id, 'name');
        $number = getdata($conn, $tea_id, 'phonenumber');
        $subname = getdata($conn, $tea_id, 'subject');
    }
}
$count = 0;
$showErrorMessage = false;
?>
<?php
if (isset($_POST['submit'])) {
    $nameval = $_POST['tname'];
    $tname = $_POST['tname'];
    $number = $_POST['no'];
    if (empty($tea_id)) {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
    }
    $subname = $_POST['sname'];
    // insert teacher as user 
    if (!isset($tea_id)) {
        $query = "SELECT COUNT(*) FROM `user` WHERE `username` = '$email'";
        $res = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($res);
        $count = $row[0];
        if ($count > 0) {
            $showErrorMessage = true;
        }
    }
    // insert and update record 
    if ($count == 0 && !$showErrorMessage) {
        // insert detail in profile
        if (empty($tea_id)) {
            $query = "INSERT INTO `user`( `name`, `username`, `password`, `usertype`) VALUES ('$tname','$email','$password', 1)";
            mysqli_query($conn, $query);
            $last_id = mysqli_insert_id($conn);
            setdata($conn, $last_id, 'name', $tname);
            setdata($conn, $last_id, 'phonenumber', $number);
            setdata($conn, $last_id, 'subject', $subname);
            $userndteacher = "INSERT INTO `teacher`(`user_id`, `teacher_id`) VALUES ($userid,$last_id)";   
            mysqli_query($conn, $userndteacher);
            $_SESSION['message'] = [
                'msg_type' => 'success',
                'message' => 'Teacher Added successfully.'
            ];
            header("location:teacher.php");
            exit;
            // echo '<script>alert(" Teacher Added successfulyy")</script>';
        } else {
            // update record 
            setdata($conn, $tea_id, 'name', $tname);
            setdata($conn, $tea_id, 'phonenumber', $number);
            setdata($conn, $tea_id, 'subject', $subname);
            $_SESSION['message'] = [
                'msg_type' => 'success',
                'message' => 'Record Updated successfully.'
            ];
            header("location:teacher.php"); 
            // echo '<script>alert(" Teacher record updated successfulyy")</script>';
        }
        //insert teacher id and user id in teacher table 
    } else {
        $showErrorMessage = '<h4 style="color: red;">** Teacher Has Alredy Been Exists</h4>';
    }   
}
include("menu.php");
?>
 
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />    
 
    <!-- display message after insert,update or delet  -->
    <?php
        if (isset($_SESSION['message'])) {
            $messageData = $_SESSION['message'];
            $msgType = $messageData['msg_type'];
            $message = $messageData['message'];            
            if ($msgType === 'success') {     
                echo '<div class="alert alert-success" role="alert" align="center" id="message"><h4>'. $message.' </h4> <button class="btn btn-success btn-lg" id="removebutton">
                <span class="glyphicon glyphicon-remove"></span> <img src="assets/images/logos/close.svg" alt="remove">
                </button></div>';
            }       
            unset($_SESSION['message']);
        }
    ?>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" style="background-color: black;">
        <h1 align="center">Welcome Teacher</h1>
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- display messasge if teacher has exists or not  -->
                                <?php 
                                    if($showErrorMessage){   
                                        echo $showErrorMessage;
                                    }
                                ?>
                                <form action="" method="post" onsubmit="return validateregister()">
                                    <div class="mb-3">
                                        <input type="hidden" class="form-control" aria-describedby="textHelp" name="id" value="<?php echo $tea_id; ?>">
                                        <label for="exampleInputtext1" class="form-label"> Teacher Name</label>
                                        <input type="text" class="form-control" id="exampleInputtext1" aria-describedby="textHelp" name="tname" value="<?php echo ($nameval != '') ? $nameval : '' ?>">
                                        <p id="name"></p>
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Mobile Number</label>
                                        <input type="text" class="form-control" id="exampleInputmono" name="no" value="<?php echo ($number !='')? $number:'' ?>">
                                        <p id="number"></p>
                                    </div>
                                    <?php
                                    $isedit = false;
                                    if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                                        $isedit = true;
                                    }
                                    ?>
                                    <?php if (!$isedit) { ?>
                                        <div class="mb-3" id="mail">
                                            <label for="exampleInputEmail1" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?php echo ($email !='')? $email:''?>">
                                            <p id="email"></p>
                                        </div>
                                        <div class="mb-4" id="pass">
                                            <label for="exampleInputPassword1" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" value="<?php echo ($password !='')? $password:''?>">
                                            <p id="password"></p>
                                        </div>   
                                    <?php } ?>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Subject Name</label>
                                        <input type="text" class="form-control" id="exampleInputsubname" name="sname" value="<?php echo ($subname !='')? $subname:'' ?>">
                                        <p id="subjectname"></p>
                                    </div>
                                    <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" value="Sign Up" name="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- get teacher list -->
    <div id="addteacher">
        <table border="10" width="100%" class="table-bordered table table-dark table-hover">
            <tr class="table-active">
                <td colspan="7" align="center">
                    <h1> Teacher List </h1>
                </td>
            </tr>
            <tr class="table-light">
                <th>Name</th>
                <th>E-Mail</th>
                <th>Subject Name</th>
                <th>Action</th>
            </tr>
            <?php
            $selectquery = "SELECT DISTINCT u.name , u.username, p.value ,u.id FROM user u INNER JOIN teacher t ON u.id = t.teacher_id 
            INNER JOIN profile p ON p.user_id = t.teacher_id WHERE t.user_id = $userid AND p.field = 'subject'";
            $result = mysqli_query($conn, $selectquery);
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['username'] ?></td>
                    <td><?php echo $row['value'] ?></td>
                    <td><a onclick="return confirmation()" href="teacher.php?action=delete&id=<?php echo $row['id']; ?>">Delete</a> |
                        <a class="edit-link" href="teacher.php?action=edit&id=<?php echo $row['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php }
            ?>
        </table>
    </div>
    <!-- validation  -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        function confirmation() {
            return confirm("Are you sure you want to delete the record?");
        }

        function validateregister() {
            var name = $('#exampleInputtext1').val();
            var number = $('#exampleInputmono').val();
            var email = $('#exampleInputEmail1').val();
            var password = $('#exampleInputPassword1').val();
            var subname = $('#exampleInputsubname').val();
            var valid = true;
            if (name == '' || number == '' || email == '' || password == '' || subname == '') {
                if (name == null || name == "") {
                    $('#name').html("<h6 style='color: red;'> ** Plese Enter Teachername ** </h6>");
                } else {
                    $('#name').hide();
                }
                if (number == null || number == "") {
                    $('#number').html("<h6 style='color: red;'> ** Plese Enter Mobile Number ** </h6>");
                } else {
                    $('#number ').hide();
                }
                if (email == null || email == "") {
                    $('#email').html("<h6 style='color: red;'> ** Plese Enter Email ** </h6>");
                } else {
                    $('#email').hide();
                }
                if (password == null || password == "") {
                    $('#password').html("<h6 style='color: red;'> ** Plese Enter Password **</h6>");
                } else {
                    $('#password').hide();
                }
                if (subname == null || subname == "") {
                    $('#subjectname').html("<h6 style='color: red;'> ** Plese Enter Subject Name **</h6>");
                    return false;
                } else {
                    $('#subjectname').hide();
                }
            return false;
            }
        }
        $(document).ready(function(){
            $('#removebutton').click(function(){
                $('#message').hide();
            });
        }); 
    </script>
    <script>
    $(document).ready(function(){
        $('#exam').change(function() {
        var selectedOption = $(this).find(':selected').attr('class');
        if (selectedOption === 'first') {
            $('.frtable').show();
        } else {
            $('.frtable').hide();
        }
        if (selectedOption === 'secound') {
            $('.frtable').show();
        } else {
            $('.frtable').hide();
        }
    });
    });
</script>