<?php
session_start();
error_reporting(0);
include '../config/database.php';
$db = new DB();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>My Booking - Medicio Doctor Channeling</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="../assets/img/logo.png" rel="icon">
  <link href="../assets/img/logo.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">

</head>

<body class="starter-page-page">

  <?php include "../contains/sec_header.php"; ?>

  <main class="main">
    
    <div class="container mt-5">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-mb-12">
              <div class="row">
                <div class="col-md-3 form-group position-relative">
                  <label>Date To</label>
                  <input type="date" class="form-control pl-3" id="date_to">
                </div>
                <div class="col-md-3 form-group mt-3 mt-md-0 position-relative">
                  <label>Date From</label>
                  <input type="date" class="form-control pl-3" id="date_from">
                </div>
                <div class="col-md-1 form-group mt-3 mt-md-0">
                  <label style="color: white;">.</label>
                  <div class="text-center"><button type="submit" class="btn btn-dark" id="search_btn">Search</button></div>
                </div>
              </div> 
            </div>
          </div>
        </div>

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <div class="container" data-aos="fade-up">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <tbody id="mybooklistdata"></tbody>
          </table>
        </div>
      </div>

    </section><!-- /Starter Section Section -->

  </main>

  <?php include "../contains/sec_footer.php"; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script type="text/javascript">

    window.onload = function() {
      var date = new Date();
      document.getElementById('date_to').valueAsDate = date;
      document.getElementById('date_from').valueAsDate = date;
        getMyBookingChart();
    };


    function getMyBookingChart(){
        
      $.ajax({
          type: 'GET',
          url: "../controllers/mybooking_controller.php",
          data: {
              request: "getBookingList",
              date_to:$("#date_to").val(),
              date_from:$("#date_from").val()
          },
          success: function(response) {
            $("#mybooklistdata").html(response);    
          },
          error: function(xhr, status, error) {
              alert("Error: " + JSON.parse(response).error);
          }
      });
    }

    

    document.getElementById("search_btn").addEventListener("click", function() {
        getMyBookingChart();
    });
  </script>

</body>

</html>