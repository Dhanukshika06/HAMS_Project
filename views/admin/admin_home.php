<?php 
session_start();
include '../../models/db.php';
$db = new DB();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Melody Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../dist/vendors/iconfonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="../../dist/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../dist/vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../dist/css/style.css">
</head>

<body>
  <div class="container-scroller">
    <!-- Nav Bar start -->
    <?php include "../../contains_main/header_main.php"; ?>
    <!-- Nav Bar End -->
    <div class="container-fluid page-body-wrapper">

      <!-- _*******sidebar.html ************************************************-->
      <?php include "../../contains_main/sidebar_main.php"; ?>
      <!-- _*******sidebar End ************************************************-->
      <!--************************************ details***************************************** -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Dashboard
            </h3>
          </div>
          <!-- <div class="row grid-margin">
           
          </div> -->
          <div class="row">
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                                        <div class="statistics-item">
                                            <p>
                                            <i class="icon-sm fa fa-user mr-2" style="font-size: 3em;"></i>
                                            Appointments Count
                                            </p>
                                            <h2 style="color: #06c44f;" id="appCount">0</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                                        <div class="statistics-item">
                                            <p>
                                            <i class="icon-sm fa fa-user-md mr-2" style="font-size: 3em;"></i>
                                            Available Registered Doctors
                                            </p>
                                            <h2 style="color:rgb(78, 42, 224);" id="docCount">0</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                                        <div class="statistics-item">
                                            <p>
                                            <i class="icon-sm fa fa-home mr-2" style="font-size: 3em;"></i>
                                            Available Centers Count
                                            </p>
                                            <h2 style="color: #06c44f;" id="centerCount">0</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        </div>
        <!-- content-wrapper ends -->
        <!-- footer.html -->
        <?php include "../../contains_main/footer_main.php"; ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../../dist/vendors/js/vendor.bundle.base.js"></script>
  <script src="../../dist/vendors/js/vendor.bundle.addons.js"></script>
  <script src="../../dist/js/off-canvas.js"></script>
  <script src="../../dist/js/hoverable-collapse.js"></script>
  <script src="../../dist/js/misc.js"></script>
  <script src="../../dist/js/settings.js"></script>
  <script src="../../dist/js/todolist.js"></script>
  <script src="../../dist/js/dashboard.js"></script>
  <script>
    window.onload = getCounts;
    function getCounts() {
      $.ajax({
          type: 'GET',
          url: "../../controllers/admin_controller.php",
          data: {
              action: "getCounts"
          },
          success: function(response) {
              var data = response.split(",");
              $("#appCount").html(data[0]);
              $("#docCount").html(data[1]);
              $("#centerCount").html(data[2]);
          },
          error: function(xhr, status, error) {
              alert("Error: " + JSON.parse(response).error);
          }
      });
    }
  </script>
</body>


</html>