<?php
// Header Start
include('header-login.php');
// Header End
session_start();
// var_dump($_SESSION);
if(isset($_SESSION['uid']) &&  $_SESSION['uid']!=""){
    header("location:dashboard.php");
    // echo "hello";
}
?>
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
                <form action="" method="post" name="form" onsubmit="return validateform()">
                  <div class="mb-3">
                    <!-- <p id="user"></p>  -->
                    <label for="exampleInputEmail1" class="form-label" >Username</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="uname">
                    <p id="user"></p>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label" >Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="upass">
                    <p id="pass"></p> 
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <!-- <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remeber this Device
                      </label>
                    </div> -->
                    <a class="text-primary fw-bold" href="index.php">Forgot Password ?</a>
                  </div>
                  <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" name="submit" value="Sign In" id="submit">
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">New to Modernize?</p>
                    <a class="text-primary fw-bold ms-2" href="register.php">Create an account</a>                 
                  </div>
                </form>
                <!-- <a href="logout.php" id="logout"> Logout </a> -->
              </div> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>   
<?php 
// Footer Start 
include('footer-login.php');
// Footer End 
?>
<!-- validation -->
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){ 
});
function validateform(){ 
      var name=$('#exampleInputEmail1').val();  
      var password=$('#exampleInputPassword1').val(); 
      if( name=="" || password==""){
          if(password == null || password==""){
            $('#pass').html("<h6 style='color: red;'> ** Plese Enter Password **</h6>");   
          } else{
            $('#pass').hide();
          }
          if(name == null || name ==""){
            $('#user').html("<h6 style='color: red;'> ** Plese Enter Username ** </h6>");              
          }
          else{
            $('#user').hide();
          } 
          return false;
        }else{
          $('#pass').hide();
          $('#user').hide();
        }
      // Check Login Using Ajax
    var username=$("#exampleInputEmail1").val();
    var password=$("#exampleInputPassword1").val();
    $.ajax({
      type:"POST",
      url: "login_data.php",
      data:{
            username:username,
            password:password
          },
          // dataType: "json",
      success: function(response){
        console.log(response.success);
        var parsedResponse = JSON.parse(response);
        if(parsedResponse.success === 1) {        
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: false,
            timer: 4000
        })
        window.location.href="profile.php";
          } else {
            $('#msg').html("<h6 style='color: red;'> ** Wrong Detail**</h6>");
            $('#exampleInputEmail1').css('border-color', 'red');
            $('#exampleInputPassword1').css('border-color', 'red');
        }     
      }
    });
    return false;
}
</script>