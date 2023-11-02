<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modernize Free</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
    <?php
    include_once("functions.php");
    $userid = getuserid();
    
    if (isset($_POST['save'])) {
        $name = $_POST['name'];
        $city = $_POST['city'];
        $add = $_POST['add'];
        $pcode = $_POST['pcode'];
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            setdata($conn, $userid, 'name', $name);
            setdata($conn, $userid, 'city', $city);
            setdata($conn, $userid, 'pin code', $add);
            setdata($conn, $userid, 'address', $pcode);
            header("location:dashboard.php");
        }
    }
    $nameval = getdata($conn, $userid, 'name');
    $cityval = getdata($conn, $userid, 'city');
    $addval = getdata($conn, $userid, 'pin code');
    $pcodeval = getdata($conn, $userid, 'address');
    include_once("menu.php");
    // print_r($dynamicVariables);
    ?>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div id="msg"></div>
                                <form action="" method="post" name="form" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Enter Your Name</label>
                                        <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name" value="<?php echo $nameval; ?>">
                                        <p id="uname"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="city" class="form-label">Enter Your City</label>
                                        <input type="text" class="form-control" id="city" aria-describedby="emailHelp" name="city" value="<?php echo $cityval; ?>">
                                        <p id="ucity"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="add" class="form-label">Enter Your Address</label>
                                        <input type="textarea" class="form-control" id="add" aria-describedby="emailHelp" name="add" value="<?php echo $addval; ?>">
                                        <p id="uadd"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pcode" class="form-label">Enter Your Pin Code</label>
                                        <input type="text" class="form-control" id="pcode" aria-describedby="emailHelp" name="pcode" value="<?php echo $pcodeval ?>">
                                        <p id="upcode"></p>
                                    </div>
                                    <div class="mb-4">
                                        <label for="image" class="form-label">Select Your Profile Picture</label>
                                        <input type="file" class="form-control" id="image" name="img" value="hello.png">
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
</body>

</html>