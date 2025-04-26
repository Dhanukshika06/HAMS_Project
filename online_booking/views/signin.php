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
  <title>Search Doctor - Medicio Doctor Channeling</title>
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

      <div class="container d-flex justify-content-center align-items-center" data-aos="fade-up">
          <div class="card shadow-lg p-4 rounded" style="width: 350px;">
              <div id="signin-form">
                  <h3 class="text-center mb-3">Sign In</h3>
                  <div>
                      <div class="mb-3">
                          <label for="signin-email" class="form-label">Email Address</label>
                          <input type="email" class="form-control" id="signin-email" placeholder="Enter your email">
                      </div>
                      <div class="mb-3">
                          <label for="signin-password" class="form-label">Password</label>
                          <input type="password" class="form-control" id="signin-password" placeholder="Enter your password">
                      </div>
                      <button type="submit" class="btn btn-primary w-100" id="signin_btn">Sign In</button>
                  </div>
                  <div class="text-center mt-3">
                      <a href="#" onclick="showForgotPassword()">Forgot password?</a> |
                      <a href="#" onclick="showSignup()">Sign Up</a>
                  </div>
              </div>

              <!-- Sign Up Form -->
              <div id="signup-form" style="display: none;">
                  <h3 class="text-center mb-3">Sign Up</h3>
                  <div>
                      <div class="mb-3">
                          <label for="signup-name" class="form-label">Name</label>
                          <input type="text" class="form-control" id="signup-name" placeholder="Enter your name">
                      </div>
                      <div class="mb-3">
                          <label for="signup-name" class="form-label">NIC Number</label>
                          <input type="text" class="form-control" id="signup-nic" placeholder="Enter your nic no">
                      </div>
                      <div class="mb-3">
                          <label for="signup-name" class="form-label">Mobile Number</label>
                          <input type="number" class="form-control" id="signup-mobile" placeholder="Enter your mobile no">
                      </div>
                      <div class="mb-3">
                          <label for="signup-email" class="form-label">Email address</label>
                          <input type="email" class="form-control" id="signup-email" placeholder="Enter your email">
                      </div>
                      <div class="mb-3">
                          <label for="signup-password" class="form-label">Password</label>
                          <input type="password" class="form-control" id="signup-password" placeholder="Create a password">
                      </div>
                      <button type="submit" class="btn btn-success w-100" id="signup_btn">Sign Up</button>
                  </div>
                  <div class="text-center mt-3">
                      <a href="#" onclick="showSignin()">Already have an account? Sign In</a>
                  </div>
              </div>

              <!-- Forgot Password Form -->
              <div id="forgot-password-form" style="display: none;">
                  <h3 class="text-center mb-3">Forgot Password</h3>
                  <div>
                      <div class="mb-3">
                          <label for="forgot-email" class="form-label">Email address</label>
                          <input type="email" class="form-control" id="forgot-email" placeholder="Enter your email">
                      </div>
                      <button type="submit" class="btn btn-warning w-100" id="send_reset_btn">Confirm Email</button>
                  </div>
                  <div class="text-center mt-3">
                      <a href="#" onclick="showSignin()">Back to Sign In</a>
                  </div>
              </div>

              <div id="reset-password-form" style="display: none;">
                  <h3 class="text-center mb-3">Password Reset</h3>
                  <div>
                      <div class="mb-3">
                          <label for="forgot-email" class="form-label">New Password</label>
                          <input type="password" class="form-control" id="pass-newpass" placeholder="Enter your new password">
                      </div>
                      <div class="mb-3">
                          <label for="forgot-email" class="form-label">Confirm Password</label>
                          <input type="password" class="form-control" id="pass-confpass" placeholder="Re-enter your password">
                      </div>
                      <button type="submit" class="btn btn-warning w-100" id="reset_pw_btn">Reset Password</button>
                      <input type="hidden" id="userID">
                  </div>
              </div>
          </div>
      </div>

    </section><!-- /Starter Section Section -->

  </main>

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

    function showSignup() {
        document.getElementById("signin-form").style.display = "none";
        document.getElementById("signup-form").style.display = "block";
        document.getElementById("forgot-password-form").style.display = "none";
        document.getElementById("reset-password-form").style.display = "none";
    }

    function showSignin() {
        document.getElementById("signin-form").style.display = "block";
        document.getElementById("signup-form").style.display = "none";
        document.getElementById("forgot-password-form").style.display = "none";
        document.getElementById("reset-password-form").style.display = "none";
    }

    function showForgotPassword() {
        document.getElementById("signin-form").style.display = "none";
        document.getElementById("signup-form").style.display = "none";
        document.getElementById("forgot-password-form").style.display = "block";
        document.getElementById("reset-password-form").style.display = "none";
    }

    function showResetPassword() {
        document.getElementById("signin-form").style.display = "none";
        document.getElementById("signup-form").style.display = "none";
        document.getElementById("forgot-password-form").style.display = "none";
        document.getElementById("reset-password-form").style.display = "block";
    }


    function signupData(){

      if($("#signup-name").val() == "" || $("#signup-nic").val() == "" || $("#signup-mobile").val() == "" || $("#signup-email").val() == "" || $("#signup-password").val() == "")
      {
         sweetalert2("warning","Please fill all records!");
      }
      else
      {
        $.ajax({
            type: 'POST',
            url: "../controllers/signin_controller.php",
            data: {
                request: "signup",
                name: $("#signup-name").val(),
                nic: $("#signup-nic").val(),
                mobile: $("#signup-mobile").val(),
                email: $("#signup-email").val(),
                password: $("#signup-password").val()
            },
            success: function(response) {
                if (response == "1") 
                {
                   sweetalert("success","Success", "Account created successfully!");
                   showSignin();
                   $("#signup-name").val("");
                   $("#signup-nic").val("");
                   $("#signup-mobile").val("");
                   $("#signup-email").val("");
                   $("#signup-password").val("");
                }
                else if (response == "2") 
                {
                   sweetalert("warning","Warning", "Account already exist in your nic number!");
                }
                else
                {
                   sweetalert("error","Error", "Error!");
                }   
            },
            error: function(xhr, status, error) {
                alert("Error: " + JSON.parse(response).error);
            }
        });
      }    
    }

    document.getElementById("signup_btn").addEventListener("click", function() {
        signupData();
    });


    function signinData(){

      if($("#signin-email").val() == "")
      {
         sweetalert2("warning","Please enter email!");
      }
      else if ($("#signin-password").val() == "") 
      {
         sweetalert2("warning","Please enter password!");
      } 
      else
      {
        $.ajax({
            type: 'GET',
            url: "../controllers/signin_controller.php",
            data: {
                request: "signIn",
                email: $("#signin-email").val(),
                password: $("#signin-password").val()
            },
            success: function(response) {
                if (response == "1") 
                {
                   window.location = "../index.php";
                }
                else
                {
                   sweetalert("error","Error", "Wrong email or password!");
                }   
            },
            error: function(xhr, status, error) {
                alert("Error: " + JSON.parse(response).error);
            }
        });
      }      
    }

    document.getElementById("signin_btn").addEventListener("click", function() {
        signinData();
    });


    function forgetData(){
      if($("#forgot-email").val() == "")
      {
         sweetalert2("warning","Please enter email!");
      } 
      else
      {
        $.ajax({
            type: 'GET',
            url: "../controllers/signin_controller.php",
            data: {
                request: "forget",
                email: $("#forgot-email").val()
            },
            success: function(response) {
                if (response == "no") 
                {
                   sweetalert("error","Error", "Email address not found in this system!");
                }
                else
                {
                  $("#userID").val(response);
                   showResetPassword();
                }   
            },
            error: function(xhr, status, error) {
                alert("Error: " + JSON.parse(response).error);
            }
        });
      } 
    }

    document.getElementById("send_reset_btn").addEventListener("click", function() {
        forgetData();
    });


    function resetPwData(){

      if($("#pass-newpass").val() == "")
      {
         sweetalert2("warning","Please enter new password!");
      }
      else if ($("#pass-confpass").val() == "") 
      {
         sweetalert2("warning","Please enter confirm password!");
      } 
      else
      {
        if ($("#pass-newpass").val() != $("#pass-confpass").val()) 
        {
           sweetalert2("warning","Password not match!");
        }
        else
        {
          $.ajax({
              type: 'POST',
              url: "../controllers/signin_controller.php",
              data: {
                  request: "reset",
                  userID: $("#userID").val(),
                  password: $("#pass-newpass").val()
              },
              success: function(response) {
                  if (response == "1") 
                  {
                     sweetalert("success","Success", "Password reset successfully!");
                     showSignin();
                  }
                  else
                  {
                     sweetalert("error","Error", "Password not reset!");
                  }   
              },
              error: function(xhr, status, error) {
                  alert("Error: " + JSON.parse(response).error);
              }
          });
        }  
      }      
    }

    document.getElementById("reset_pw_btn").addEventListener("click", function() {
        resetPwData();
    });

    // function getQueryParam(param) {
    //     var urlParams = new URLSearchParams(window.location.search);
    //     return urlParams.get(param) ? decodeURIComponent(urlParams.get(param)) : "";
    // }

    // window.onload = function() {
    //     getBookingChart();
    // };


    // function getBookingChart(){
        
    //   $.ajax({
    //       type: 'GET',
    //       url: "../controllers/bookinglist_controller.php",
    //       data: {
    //           request: "getBookingList",
    //           doctor: getQueryParam("doc"),
    //           center: getQueryParam("hos")
    //       },
    //       success: function(response) {
    //         $("#booklistdata").html(response);    
    //       },
    //       error: function(xhr, status, error) {
    //           alert("Error: " + JSON.parse(response).error);
    //       }
    //   });
    // }

    // function getBookingList(docID,centerID){
        
    //   var url = 'views/bookinglist.php?doc=' + encodeURIComponent(docID) + 
    //             "&hos=" + encodeURIComponent(centerID);

    //   window.location.href = url;
    // }

    // document.getElementById("search_btn").addEventListener("click", function() {
    //     getBookingChart();
    // });
  </script>

</body>

</html>