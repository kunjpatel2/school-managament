<?php
include("menu.php");
?>
  <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #061b42; /* Dark Blue Background */
            color: #fff; /* White Text Color */
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form {
            background: rgba(255, 255, 255, 0.1); /* Semi-transparent white background */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 100%; /* Full width */
            max-width: 100%; /* Adjusted for full width */
            margin: 0; /* Removed margin */
        }
        label {
            display: block;
            margin: 10px 0;
            font-weight: 600;
        }
        input[type="text"],
        input[type="date"],
        input[type="time"] {
            width: 100%; /* Full width input fields */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            background: #007BFF;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
    <?php
    if ($usertype == 0) {
        ?> 
<h1 align="center" style="font-family: Times New Roman, Times, serif;">
    <b>Time Table Of Final Exam 2023</b>
</h1>
  <div class="container">
        <div class="form">
            <form method="post" action="" onsubmit="return validateform()">
                <label for="standard">Standard:</label>
                <input type="number" name="standard" id="std">
                <p id="standered"></p>
                <label for="subject">Subject:</label>
                <input type="text" name="subject" id="sub">
                <p id="subject"></p>
                <label for="date">Date:</label>
                <input type="date" name="date" id="date">
                <p id="datev"></p>
                <label for="start_time">Start Time:</label>
                <input type="time" name="start_time" id="stime"> 
                <p id="starttime"></p>
                <label for="end_time">End Time:</label>
                <input type="time" name="end_time" id="etime">
                <p id="endtime"></p>
                <input type="submit" value="Add Exam" name="exam">
            </form>
        </div>
    </div>
    <script> 
        function validateform() {
            var standered = $('#std').val();
            var subject = $('#sub').val();
            var date = $('#date').val();
            var starttime = $('#stime').val();
            var endtime = $('#etime').val();
            var valid = true;
            if (standered == '' || subject == '' || date == '' || starttime == '' || endtime == '') {
                if (standered == null || standered == "") {
                    $('#standered').html("<h6 style='color: red;'> ** Plese Enter Teachername ** </h6>");
                } else {
                    $('#standered').hide();
                }
                if (subject == null || subject == "") {
                    $('#subject').html("<h6 style='color: red;'> ** Plese Enter Mobile Number ** </h6>");
                } else {
                    $('#subject ').hide();
                }
                if (date == null || date == "") {
                    $('#datev').html("<h6 style='color: red;'> ** Plese Enter Email ** </h6>");
                } else {
                    $('#datev').hide();
                }
                if (starttime == null || starttime == "") {
                    $('#starttime').html("<h6 style='color: red;'> ** Plese Enter Password **</h6>");
                } else {
                    $('#starttime').hide();
                }
                if (endtime == null || endtime == "") {
                    $('#endtime').html("<h6 style='color: red;'> ** Plese Enter Subject Name **</h6>");
                    return false;
                } else {
                    $('#endtime').hide();
                }
            return false;
            }
        }
    </script>
    <?php
    if (isset($_POST['exam'])) {
        $standard = $_POST['standard'];
        $subject = $_POST['subject'];
        $inputdate = $_POST['date'];
        $input_start_time = $_POST['start_time'];
        $input_end_time = $_POST['end_time'];
        $date = date('Y-m-d', strtotime($inputdate));
        $starttime = date('H:i:s', strtotime($input_start_time));
        $endtime = date('H:i:s', strtotime($input_end_time));
        if($standard=='' && $subject=='' && $inputdate='' && $input_start_time='' && $input_end_time='' ){
            echo "plese enter detail";
        } else {
            // Insert data into the MySQL database
            $sql = "INSERT INTO `exam`( `standered`, `Subject`, `Date`, `Start Time`, `End Time`) 
            VALUES ($standard,'$subject','$date','$starttime','$endtime')";
            mysqli_query($conn, $sql);
        }
    }
    }
    ?>
        <div id="addteacher">
        <table border="10" width="100%" class="table-bordered table table-dark table-hover">
            <tr class="table-active">
                <td colspan="7" align="center">
                    <h1> Teacher List </h1>
                </td>
            </tr>
            <tr class="table-light">
                <th>Standered</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
            <?php
            $selectquery = "SELECT * FROM `exam` ";
            $result = mysqli_query($conn, $selectquery);
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['standered']; ?></td>
                    <td><?php echo $row['Subject'] ?></td>
                    <td><?php echo $row['Date'] ?></td>
                    <td><?php echo $row['Start Time'] ?></td>
                    <td><?php echo $row['End Time'] ?></td>
                    </td>
                </tr>
            <?php }
            ?>
        </table>
    </div>