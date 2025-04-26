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
  <title>Payments - Medicio Doctor Channeling</title>
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
        

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg p-4">
                        <h3 class="text-center mb-4">Booking Cancel Request</h3>
                        
                        <div class="tab-content">
                            
                            <div class="tab-pane fade show active" id="card">
                                <div>
                                    <div class="mb-3">
                                        <label class="form-label">Refference No</label>
                                        <input type="text" id="refNo" class="form-control" placeholder="Enter refference no" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Contact No</label>
                                        <input type="number" id="contactNo" class="form-control" placeholder="Enter contact no" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Reason</label>
                                        <input type="text" id="reason" class="form-control" placeholder="Enter reason" required>
                                    </div>

                                    <button class="btn btn-success w-100 mt-4" id="btn_sendReq">Send Request</button>
                                </div>
                            </div>
                        </div>
                    </div>
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

    function saveRequest(){
        
        if ($("#refNo").val() == "") {
          sweetalert2("warning","Please enter refference no!");
        }else if ($("#contactNo").val() == "") {
          sweetalert2("warning","Please enter contact no!");
        }else{
            $.ajax({
                type: 'POST',
                url: "../controllers/cancel_request_controller.php",
                data: {
                    request: "cancelBooking",
                    refno: $("#refNo").val(),
                    contno: $("#contactNo").val(),
                    reason: $("#reason").val()
                },
                success: function(response) {

                    if (response == "2") {
                        sweetalert("warning","Warning", "Already requested in this refference no!");
                    }
                    else if (response == "1") 
                    {
                       sweetalert("success","Success", "Booking cancel request sent successfully!");
                       $("#refNo").val("");
                       $("#contactNo").val("");
                       $("#reason").val("");
                    }
                    else
                    {
                        sweetalert("error","Error", "Error!");    
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error: " + JSON.parse(xhr.responseText).error);
                }
            });
        } 
    }

    document.getElementById("btn_sendReq").addEventListener("click", function() {
        saveRequest();
    });
  </script>

</body>

</html>
