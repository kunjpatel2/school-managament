<?php
// include("functions.php");
include_once("functions.php");
if ($_SESSION['uname'] == '') {
    header("location:index.php");
}
//get usertype of user
$userid = getuserid();
$getquery = "SELECT usertype FROM `user` WHERE id=$userid";
$result = mysqli_query($conn, $getquery);
$row = mysqli_fetch_assoc($result);
$usertype = $row['usertype'];

// delet record from user
$nameval = '';
$email = '';
$password = '';
$sname = '';
$address = '';
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
        $deletrecordstudent = "DELETE FROM `student` WHERE student_id=$id";
        if (mysqli_query($conn, $deletrecordstudent)) {
            $_SESSION['message'] = [
                'msg_type' => 'success',
                'message' => 'Record deleted successfully.'
            ];
            header("location:student.php");
            exit;
        }
    } elseif ($action === 'edit') {
        $stud_id = $_REQUEST['id'];
        $nameval = getdata($conn, $stud_id, 'name');
        $address = getdata($conn, $stud_id, 'address');
    }
}
$count = 0;
$showErrorMessage = false;
?>
<?php
if (isset($_POST['submit'])) {
    $nameval = $_POST['tname'];
    $sname = $_POST['tname'];
    if (empty($stud_id)) {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
    }
    $address = $_POST['add'];
    // insert student as teacher 
    if (!isset($stud_id)) {
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
        // insert detail in user
        if (empty($stud_id)) {
            $query = "INSERT INTO `user`( `name`, `username`, `password`, `usertype`) VALUES ('$sname','$email','$password', 2)";
            mysqli_query($conn, $query);
            $last_id = mysqli_insert_id($conn);
            // insert detail in profile
            setdata($conn, $last_id, 'name', $sname);
            setdata($conn, $last_id, 'address', $address);
            // if user is teacher
            if ($usertype == 1) {
                $insertquery = "INSERT INTO `student`( `techer_id`,`student_id`) VALUES ($userid,$last_id)";
                mysqli_query($conn, $insertquery);
            }
            //if user is admin
            if ($usertype == 0) {
                if (isset($_REQUEST['method'])) {
                    $method = $_REQUEST['method'];
                    $teacherid = $_GET['id'];
                    $insertquery = "INSERT INTO `student`( `techer_id`,`student_id`) VALUES ($teacherid,$last_id)";
                    mysqli_query($conn, $insertquery);
                }
            }
            $_SESSION['message'] = [
                'msg_type' => 'success',
                'message' => 'Student Added successfully.'
            ];
            header("location:student.php");
            exit;
        } else {
            // update record 
            setdata($conn, $stud_id, 'name', $sname);
            setdata($conn, $stud_id, 'address', $address);
            $_SESSION['message'] = [
                'msg_type' => 'success',
                'message' => 'Record Updated successfully.'
            ];
            header("location:student.php");
        }
        //insert student id and teacher id in student table 
    } else {
        $showErrorMessage = '<h4 style="color: red;">** Student Has Alredy Been Exists</h4>';
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
        echo '<div class="alert alert-success" role="alert" align="center" id="message"><h4>' . $message . ' </h4> <button class="btn btn-success btn-lg" id="removebutton">
                <span class="glyphicon glyphicon-remove"></span> <img src="assets/images/logos/close.svg" alt="remove">
                </button></div>';
    }
    unset($_SESSION['message']);
}
?>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" style="background-color: black;">
    <h1 align="center">Welcome Student</h1>
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <!-- display messasge if student has exists or not  -->
                            <?php
                            if ($showErrorMessage) {
                                echo $showErrorMessage;
                            }
                            ?>
                            <form action="" method="post" onsubmit="return validateregister()" name="studentform" class="studentform">
                            <?php 
                                if ($usertype == 0) { ?>
                                    <div class="mb-3"><div id="msg"></div>
                                        <select name="teaches" id="selecttea" onchange="redirectStudent()" >
                                            <option disabled selected> Select A teacher </option>
                                            <?php
                                            $getteacher = "SELECT name,user.id FROM `user`,`teacher` WHERE user.id=teacher.teacher_id";
                                            $result = mysqli_query($conn, $getteacher);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <option value="<?php echo $row['id'];  ?>"><?php echo $row['name']; ?></option>
                                            <?php
                                                $getid = $row['id'];
                                            }
                                            ?>
                                        </select>
                                    </div>
                                     <script>
                                            $(document).ready(function() {
                                                $('.studentform').submit(function() {
                                                    var selectOption = $('#selecttea').val();
                                                    if (selectOption == '' || selectOption==null) {
                                                        alert('Please select an option.');
                                                        // return false;
                                                    }
                                                    return true;
                                                });
                                            });
                                            $(document).ready(function() {
                                                var initialSelectedValue = $('#selecttea').val();
                                                $('#selecttea').change(function() {
                                                    var selectedOption = $(this).val();
                                                    sessionStorage.setItem('teacherid', selectedOption);
                                                });
                                                if (initialSelectedValue) {
                                                    sessionStorage.setItem('teacherid', initialSelectedValue);
                                                }
                                            });
                                            $(document).ready(function() {
                                                var storedValue = sessionStorage.getItem('teacherid');
                                                if (storedValue) {
                                                    $('#selecttea').val(storedValue);
                                                    sessionStorage.removeItem('teacherid');
                                                }
                                            });
                                    </script>
                            <?php
                                } 
                            ?>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" aria-describedby="textHelp" name="id" value="<?php echo ($stud_id != '') ? $stud_id : '' ?>">
                                    <label for="exampleInputtext1" class="form-label"> Student Name</label>
                                    <input type="text" class="form-control" id="exampleInputtext1" aria-describedby="textHelp" name="tname" value="<?php echo ($nameval != '') ? $nameval : '' ?>">
                                    <p id="name"></p>
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
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?php echo ($email != '') ? $email : '' ?>">
                                        <p id="email"></p>
                                    </div>
                                    <div class="mb-4" id="pass">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" value="<?php echo ($password != '') ? $password : '' ?>">
                                        <p id="password"></p>
                                    </div>
                                <?php } ?>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="exampleInputsubname" name="add" value="<?php echo ($address != '') ? $address : '' ?>">
                                    <p id="address"></p>                        
                                    <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" value="Sign Up" name="submit">
                                </div>
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
                <h1> Student List </h1>
            </td>
        </tr>
        <tr class="table-light">
            <th>Name</th>
            <th>E-Mail</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        <?php
        if ($usertype == 1) {
            $selectquery = "SELECT DISTINCT u.name , u.username, p.value ,u.id FROM user u INNER JOIN student s ON u.id = s.student_id 
            INNER JOIN profile p ON p.user_id = s.student_id WHERE s.techer_id = $userid AND p.field = 'address'";
            $result = mysqli_query($conn, $selectquery);
        }
        if ($usertype == 0) {
            if (isset($_REQUEST['method'])) {
                $method = $_REQUEST['method'];
                $teacherid = $_GET['id'];
                $selectquery = "SELECT DISTINCT u.name , u.username, p.value ,u.id FROM user u INNER JOIN student s ON u.id = s.student_id 
                    INNER JOIN profile p ON p.user_id = s.student_id WHERE s.techer_id = $teacherid AND p.field = 'address'";
                $result = mysqli_query($conn, $selectquery);
            }
        }
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['username'] ?></td>
                <td><?php echo $row['value'] ?></td>
                <td><a onclick="return confirmation()" href="student.php?action=delete&id=<?php echo $row['id']; ?>">Delete</a> |
                    <a class="edit-link" href="student.php?action=edit&id=<?php echo $row['id']; ?>">Edit</a>
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
        var email = $('#exampleInputEmail1').val();
        var password = $('#exampleInputPassword1').val();
        var address = $('#exampleInputsubname').val();
        var valid = true;
        if (name == '' || email == '' || password == '' || address == '') {
            if (name == null || name == "") {
                $('#name').html("<h6 style='color: red;'> ** Plese Enter Student Name ** </h6>");
            } else {
                $('#name').hide();
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
            if (address == null || address == "") {
                $('#address').html("<h6 style='color: red;'> ** Plese Enter Address **</h6>");
                return false;
            } else {
                $('#address').hide();
            }
            return false;
        }
        return true;
    }

    $(document).ready(function() {
        $('#removebutton').click(function() {
            $('#message').hide();
        });
    });
    // get teacher id which user select
    function redirectStudent() {
        var selectElement = document.getElementById("selecttea");
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var teacherId = selectedOption.value;

        if (teacherId) {
            window.location.href = 'student.php?method=teacherid&id=' + teacherId;
        }
    }
</script>