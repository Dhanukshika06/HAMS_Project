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
  <title>Appoinment Doctor - Medicio Doctor Channeling</title>
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
    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <div class="container" data-aos="fade-up">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody id="placebooklistdata"></tbody>
          </table>
        </div>

        <div class="card shadow-lg p-4 rounded">
              <div id="booking-form">
                  <h3 class="text-center mb-3">Booking Form</h3>
                  <div class="alert alert-warning text-center">
                      <b>COMPLETE WITHIN <span id="timer">10:00</span></b>
                  </div>

                  <div>
                      <div class="mb-3">
                          <label for="signin-email" class="form-label">Name</label>
                          <input type="text" class="form-control" id="booking-name" placeholder="Enter your name - required" required>
                      </div>
                      <div class="mb-3">
                          <label for="signin-password" class="form-label">Contact Number</label>
                          <input type="number" class="form-control" id="booking-contact" placeholder="Enter your contact no - required" required> 
                      </div>
                      <div class="mb-3">
                          <label for="signin-email" class="form-label">NIC Number</label>
                          <input type="text" class="form-control" id="booking-nic" placeholder="Enter your nic no - required" required>
                      </div>
                      <div class="mb-3">
                          <label for="signin-email" class="form-label">Email Address</label>
                          <input type="email" class="form-control" id="booking-email" placeholder="Enter your email - required" required>
                          <span><span style="color: red;">*</span> Please enter email address if you require to send PDF receipt to your email account</span>
                      </div>
                      <div class="mb-3">
                          <label for="signin-password" class="form-label">Address</label>
                          <input type="text" class="form-control" id="booking-address" placeholder="Enter your address - optional">
                      </div>

                      <button type="submit" id="continue_btn" class="btn btn-success w-100"><i class="fa fa-check-square"></i> Continue</button>
                  </div>
              </div>

              

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
  <script src="../assets/js/sweetalert2.js"></script>
  <script type="text/javascript">

    function sweetalert(type, title, message) {
      Swal.fire({
          icon: type,
          title: title,
          text: message,
      })
    }

    function sweetalert2(type, title) 
    {

      const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: type,
        title: title
      })
    }

    function getQueryParam(param) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param) ? decodeURIComponent(urlParams.get(param)) : "";
    }

    let timeLeft = 600; // 10 minutes
    let timerElement = document.getElementById("timer");

    function updateTimer() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        timerElement.innerText = `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
        if (timeLeft > 0) {
            timeLeft--;
        } else {
            sweetalert("warning","Warning", "Time is up! Redirecting to previous page!");
            var url = '../views/bookinglist.php?doc=' + encodeURIComponent(getQueryParam("doc")) + 
                "&hos=" + encodeURIComponent(getQueryParam("hos"));
            window.location.href = url;
        }
    }

    setInterval(updateTimer, 1000); // Run every second

    $(document).ready(function () {
        setInterval(function()
        {
          getBookingForm();  
        }, 3000); 
    });
    
    function getBookingForm() {
        $.ajax({
            type: 'GET',
            url: "../controllers/placebooking_controller.php",
            data: {
                request: "getBookingForm",
                doctor: getQueryParam("doc"),
                center: getQueryParam("hos"),
                time: getQueryParam("tid")
            },
            success: function(response) {
                $("#placebooklistdata").html(response);
            },
            error: function(xhr, status, error) {
                alert("Error: " + JSON.parse(xhr.responseText).error);
            }
        });  
    }


    function saveBookingForm() {

      if ($("#booking-name").val() == "" || $("#booking-contact").val() == "" || $("#booking-nic").val() == "" || $("#booking-email").val() == "") 
      {
           sweetalert2("warning","Please fill required fields!");
      }
      else
      {
        $.ajax({
            type: "POST",
            url: "../controllers/placebooking_controller.php",
            data: {
                request: "submitBooking",
                name: $("#booking-name").val(),
                contact: $("#booking-contact").val(),
                nic: $("#booking-nic").val(),
                email: $("#booking-email").val(),
                address: $("#booking-address").val(),
                doctor: getQueryParam("doc"),
                center: getQueryParam("hos"),
                time: getQueryParam("tid")
            },
            success: function(response) {

              // alert(response);

                if (response == "ap_already") {
                    sweetalert("warning","Warning", "This patient already booking this doctor!");
                }else{
                    sweetalert("success","Success", "Booking successful! Proceeding to the payments.");
                    var url = '../views/payment.php?apid=' + encodeURIComponent(response);
                    window.location.href = url;
                }
            },
            error: function(xhr, status, error) {
                alert("Error: " + JSON.parse(xhr.responseText).error);
            }
        });
      }   
  }

  document.getElementById("continue_btn").addEventListener("click", function() {
        saveBookingForm();
    });


  </script>

</body>

</html>