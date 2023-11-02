<?php
include("menu.php");
?>
<?php if ($usertype == 0) { ?>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="assets/images/logos/dark-logo.svg" width="180" alt="">
                            </a>
                            <form action="" method="post" onsubmit="return validateregister()">
                                <div class="mb-3">
                                    <label for="exampleInputtext1" class="form-label">Event Date</label>
                                    <input type="date" class="form-control" id="exampleInputtext1" aria-describedby="textHelp" name="startdate">
                                    <p id="date"></p>
                                </div>
                                <div class="enddate" style="display: none;">
                                    <label for="exampleInputtext1" class="form-label">Select Secound Date</label>
                                    <input type="date" class="form-control" id="exampleInputtext1" aria-describedby="textHelp" name="enddate">
                                    <p id="date"></p>
                                </div>
                                <div class="mb-3">
                                    <h5>If You Want Find Multiple Festival <br><strong style="color: blue;">-><u class="multiple">Click Here</u></strong></h5>
                                </div>
                                <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" value="Show Event" name="submit">
                        </div>  
                        </form>    
                        <?php
                        if (isset($_POST['submit'])) {
                            $date = $_POST['startdate'];
                            $date2 = $_POST['enddate'];
                            if (empty($date) && empty($date2)) {
                                echo '<h1 style="color:red">** Please select at least one date **</h1>';
                            } elseif (empty($date)) {
                                echo '<h1 style="color:red">** Please select First date date **</h1>';
                            } elseif (empty($date2)) {
                                // Display festival for the selected start date
                                $time = strtotime($date);
                                $eventdate = date('Y-m-d', $time);
                                $query = "SELECT * FROM `festival` WHERE date='$eventdate'";
                                $result = mysqli_query($conn, $query);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<h1>" . $row['festival'] . "</h1>" . "<br>";
                                    }
                                } else {
                                    echo "<h1> &#128533;!! Sorrry No festivals found!! </h1>";
                                }
                            } else {
                                // Both start and end dates are selected
                                $time = strtotime($date);
                                $eventdate = date('Y-m-d', $time);
                                $time = strtotime($date2);
                                $enddate = date('Y-m-d', $time);
                                $query = "SELECT * FROM `festival` WHERE date BETWEEN '$eventdate' AND '$enddate'";
                                $result = mysqli_query($conn, $query);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<h1>" . $row['festival'] . "</h1>" . "<br>";
                                    }
                                } else {
                                    echo "<h1>No festivals found</h1>";
                                }
                            }
                        }
                        ?>              
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     $(document).ready(function() {
        $('.multiple').click(function() {
            $('.enddate').show();
        });
    });
</script>
<?php } ?>
<table border="10" width="100%" class="table-bordered table table-dark table-hover">
            <tr class="table-active">
                <td colspan="7" align="center">
                    <h1> Festival List </h1>
                </td>
            </tr>
            <tr class="table-light">
                <th>Date</th>
                <th>Festival</th>
            </tr>
            <?php
            $query = "SELECT * FROM festival ";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['date'] ?></td>
                    <td><?php echo $row['festival'] ?></td>
                </tr>
            <?php }
            ?>
        </table>