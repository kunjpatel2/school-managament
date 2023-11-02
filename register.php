<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
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
                <p class="text-center">Your Social Campaigns</p>
                <form action="" method="post" onsubmit="return validateregister()">
                  <div class="mb-3">
                    <label for="exampleInputtext1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleInputtext1" aria-describedby="textHelp" name="name">
                    <p id="name"></p>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">School Name</label>
                    <input type="text" class="form-control" id="exampleInputsname" name="sname">
                    <p id="schoolname"></p>
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                    <p id="email"></p>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                    <p id="password"></p>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Conform Password</label>
                    <input type="password" class="form-control" id="exampleInputconformPassword1" name="conformpassword">
                    <p id="conformpassword"></p>
                    <p id="conformpassword2"></p>
                  </div>
                  <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" value="Sign Up" name="submit">
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                    <a class="text-primary fw-bold ms-2" href="index.php">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {});
    function validateregister() {
      var name = $('#exampleInputtext1').val();
      var email = $('#exampleInputEmail1').val();
      var schoolname = $('#exampleInputsname').val();
      var password = $('#exampleInputPassword1').val();
      var conformpassword = $('#exampleInputconformPassword1').val();
      var valid = true;
      if (name == null || name == "") {
        $('#name').html("<h6 style='color: red;'> ** Plese Enter Username ** </h6>");
      } else {
        $('#name').hide();
      }
      if (email == null || email == "") {
        $('#email').html("<h6 style='color: red;'> ** Plese Enter Email ** </h6>");
      } else {
        $('#email').hide();
      }
      if (schoolname == null || schoolname == "") {
        $('#schoolname').html("<h6 style='color: red;'> ** Plese Enter School Name ** </h6>");
      } else {
        $('#schoolname').hide();
      }
      if (password == null || password == "") {
        $('#password').html("<h6 style='color: red;'> ** Plese Enter Password **</h6>");
      } else {
        $('#password').hide();
      }
      if (conformpassword == null || conformpassword == "") {
        $('#conformpassword').html("<h6 style='color: red;'> ** Plese Enter  Conform Password **</h6>");
        return false;
      } else {
        $('#conformpassword').hide();
      }
      if (conformpassword != password) {
        $('#conformpassword2').html("<h6 style='color: red;'> ** Does Not Match Conform Password And Password **</h6>");
        return false;
      } else {}
      var name = $('#exampleInputtext1').val();
      var email = $('#exampleInputEmail1').val();
      var password = $('#exampleInputPassword1').val();
      var conformpassword = $('#exampleInputconformPassword1').val();
      if (valid) {
        $.ajax({
          type: "POST",
          url: "register_data.php",
          data: {
            name: name,
            email: email,
            password: password
          },
          // dataType: "json",
          success: function(response) {
            console.log(response);
            // var parsedResponse = JSON.parse(response);
            if (response==="success") {
              window.location.href = "index.php";
            } else {
              alert("uncorrect");
            }
          }
        });
      }
      return false;
    }
  </script>
</body>

</html>