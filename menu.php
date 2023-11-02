<?php
include_once("functions.php");
if (!isset($_SESSION['uid']) &&  $_SESSION['uid'] == '') {
  header("location:index.php");
}
$userid = getuserid();
$getquery = "SELECT usertype FROM `user` WHERE id=$userid";
$result = mysqli_query($conn, $getquery);
$row = mysqli_fetch_assoc($result);
$usertype = $row['usertype'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    .circle-image {
      border-radius: 50%;
      width: 100px;
      height: 100px;
      object-fit: cover;
      margin: 5px;
    }
  </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" align="left">
    <!-- Sidebar Start -->
    <aside class="left-sidebar" style="background-color: black;">
      <!-- Sidebar scroll-->
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="dashboard.php" class="text-nowrap logo-img">
          <img src="assets/images/logos/dark-logo.svg" width="180" alt="" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
          <i class="ti ti-x fs-8"></i>
        </div>
      </div>
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">

        <ul id="sidebarnav">
          <li>
            <?php
            //get admin image 
            $query = "SELECT * FROM `profile` WHERE user_id=$userid AND field='profile_image'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $image = $row['value'];
            echo '<img src="' . $image . '" alt="Processed Image" class="circle-image">';
            //get admin name
            $query = "SELECT name FROM user WHERE id=$userid";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            echo '<h3 style="color: aliceblue;">Admin=</h3>' . $row['name']  ?>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="dashboard.php" aria-expanded="false">
              <span>
                <i class="ti ti-layout-dashboard"></i>
              </span>
              <span class="hide-menu" style="color: aliceblue;">Dashboard</span>
              <h3 style="color: aliceblue;">=></h3>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="update_profile.php?action=edit" aria-expanded="false">
              <span>
                <i class="ti ti-layout-dashboard"></i>
              </span>
              <span class="hide-menu" style="color: aliceblue;">Update Profile</span>
              <h3 style="color: aliceblue;">=></h3>
            </a>
          </li>
          <?php
          if ($usertype == 0) {
          ?>
            <li class="sidebar-item">
              <a class="sidebar-link" href="teacher.php" aria-expanded="false">
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
                  </svg> </span>
                <span class="hide-menu" style="color: aliceblue;">Teacher</span>
                <h3 style="color: aliceblue;">=></h3>
              </a>
            </li>
          <?php
          }
          if ($usertype == 1 || $usertype == 0) {
          ?>
            <li class="sidebar-item">
              <a class="sidebar-link" href="student.php" aria-expanded="false">
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backpack" viewBox="0 0 16 16">
                    <path d="M4.04 7.43a4 4 0 0 1 7.92 0 .5.5 0 1 1-.99.14 3 3 0 0 0-5.94 0 .5.5 0 1 1-.99-.14ZM4 9.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-4Zm1 .5v3h6v-3h-1v.5a.5.5 0 0 1-1 0V10H5Z" />
                    <path d="M6 2.341V2a2 2 0 1 1 4 0v.341c2.33.824 4 3.047 4 5.659v5.5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5V8a6.002 6.002 0 0 1 4-5.659ZM7 2v.083a6.04 6.04 0 0 1 2 0V2a1 1 0 0 0-2 0Zm1 1a5 5 0 0 0-5 5v5.5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5V8a5 5 0 0 0-5-5Z" />
                  </svg>
                </span>
                <span class="hide-menu" style="color: aliceblue;">Student</span>
                <h3 style="color: aliceblue;">=></h3>
              </a>
            </li>
          <?php } ?>
          <li class="sidebar-item">
            <a class="sidebar-link" href="event.php" aria-expanded="false">
              <i style='font-size:24px' class='fas'>&#xf79f;</i>
              <span class="hide-menu" style="color: aliceblue;">Event</span>
              <h3 style="color: aliceblue;">=></h3>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="exam.php" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
              <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
            </svg>
              <span class="hide-menu" style="color: aliceblue;">Exam Time Table</span>
              <h3 style="color: aliceblue;">=></h3>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <div class="body-wrapper">
      <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item d-block d-xl-none">
            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
              <i class="ti ti-bell-ringing"></i>
              <div class="notification bg-primary rounded-circle"></div>
            </a>
          </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
          <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            <li class="nav-item dropdown">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                <div class="message-body">
                  <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-user fs-6"></i>
                    <p class="mb-0 fs-3">My Profile</p>
                  </a>
                  <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-mail fs-6"></i>
                    <p class="mb-0 fs-3">My Account</p>
                  </a>
                  <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-list-check fs-6"></i>
                    <p class="mb-0 fs-3">My Task</p>
                  </a>
                  <a href="logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </nav>

</body>
</html>