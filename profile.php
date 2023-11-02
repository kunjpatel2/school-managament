<?php
include("header-login.php.");
include_once("functions.php");
include("footer-login.php");
// set session 
$userid = getuserid();
if (!isset($_SESSION['uname']) && $_SESSION['uname'] == "") {
    header("location:index.php");
    exit;
}
if (isset($_FILES['img'])) {
    $target_dir = "assets/images/";
    $profilepic = $_FILES['img']['name'];
    $targetfile = $target_dir .  basename($profilepic);
    move_uploaded_file($_FILES['img']['tmp_name'], $targetfile);
    echo '<img src="' . $targetfile . '" alt="Processed Image">';    
}
    // get user data
    if (isset($_POST['save'])) {
        $name = $_POST['name'];
        $city = $_POST['city'];
        $pcode = $_POST['pcode'];
        $add = $_POST['add'];
        // using udf insert record
        setdata($conn, $userid,'name',$name);
        setdata($conn, $userid,'city',$city);
        setdata($conn, $userid,'pin code',$pcode);
        setdata($conn, $userid,'address',$add);
        setdata($conn, $userid,'profile_image',$targetfile);
        // setdata($conn, $userid, $name, $city, $add,$pcode);
        // set value coulmn 1 when porofiler save 
        $updatequery = "UPDATE profile SET value = 1 WHERE field = 'is_profile'";
        mysqli_query($conn, $updatequery);
        $updatequery2 = "UPDATE profile SET user_id = $userid WHERE value = 1";
        mysqli_query($conn, $updatequery2);
        // set flag 1 in user table when profile save 
        $profilecomplete = "UPDATE user SET profile_completed = 1 WHERE id = $userid";
        mysqli_query($conn, $profilecomplete);
    }
    // one time profile save redirect dashboard
$query = "SELECT * FROM user WHERE id=$userid";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $flag = $row['profile_completed'];
    $name = $row['name'];
}
if ($flag == 1) {
    header("location:dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="index.php" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="assets/images/logos/dark-logo.svg" width="180" alt="">
                                </a>
                                <p class="text-center">Your Social Campaigns</p>
                                <div id="msg"></div>
                                <form action="" method="post" name="form" onsubmit="return validateform()" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Enter Your Name</label>
                                        <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name" value="<?php echo $name ?>">
                                        <p id="uname"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="city" class="form-label">Enter Your City</label>
                                        <input type="text" class="form-control" id="city" aria-describedby="emailHelp" name="city">
                                        <p id="ucity"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pcode" class="form-label">Enter Your Pin Code</label>
                                        <input type="text" class="form-control" id="pcode" aria-describedby="emailHelp" name="pcode">
                                        <p id="upcode"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="add" class="form-label">Enter Your Address</label>
                                        <input type="textarea" class="form-control" id="add" aria-describedby="emailHelp" name="add">
                                        <p id="uadd"></p>
                                    </div>
                                    <div class="mb-4">
                                        <label for="image" class="form-label">Select Your Profile Picture</label>
                                        <input type="file" class="form-control" id="image" name="img" accept="image/*">
                                        <p id="fileUploadMessage" style="color: red; display: none;">** Please select a file **</p>
                                    </div>
                                    <div class="mb-4">
                                        <input type="submit" class="form-control" id="exampleInputPassword1" name="save">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  validation -->
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {});

        function validateform() {
            var fileInput = $('#image');
            var message = $('#fileUploadMessage');
            if (fileInput.get(0).files.length === 0) {
                message.show();
                return false;
                // e.preventDefault(); // Prevent the form submission
            } else {
                message.hide();
            }
            var name = $('#name').val();
            var city = $('#city').val();
            var pincode = $('#pcode').val();
            var address = $('#add').val();
            if (name == "" || city == "" || pincode == "" || address == "") {
                if (name == null || name == "") {
                    $('#uname').html("<h6 style='color: red;'> ** Plese Enter Your Name ** </h6>");
                    // return false;               
                } else {
                    $('#uname').hide();
                }
                if (city == null || city == "") {
                    $('#ucity').html("<h6 style='color: red;'> ** Plese Enter City **</h6>");
                    // return false;
                } else {
                    $('#ucity').hide();
                }
                if (pincode == null || pincode == "") {
                    $('#upcode').html("<h6 style='color: red;'> ** Plese Enter Pincode **</h6>");
                    // return false;
                } else {
                    $('#upcode').hide();
                }
                if (address == null || address == "") {
                    $('#uadd').html("<h6 style='color: red;'> ** Plese Enter Address **</h6>");
                    return false;
                } else {
                    $('#uadd').hide();
                }
                return false;
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your profile has been saved',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    </script>
    <!-- get data  -->
    <?php
    // get image
    if (isset($_FILES['img'])) {
        $target_dir = "assets/images/";
        $profilepic = $_FILES['img']['name'];
        $targetfile = $target_dir .  basename($profilepic);
        move_uploaded_file($_FILES['img']['tmp_name'], $targetfile);
        echo '<img src="' . $targetfile . '" alt="Processed Image">';
        
    }

    ?>
</body>
<script src="sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>

</html>