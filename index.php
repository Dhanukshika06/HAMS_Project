<!DOCTYPE html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HAMS </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="dist/vendors/iconfonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="dist/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="dist/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="dist/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="dist/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="http://www.urbanui.com/" />
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="dist/images/logo.svg" alt="logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" id="uname" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-sm" id="pword" placeholder="Password">
                </div>
                <div class="mt-3">
                  <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" onclick="login()">SIGN IN</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
    <!-- container-scroller -->
    <script src="dist/vendors/js/vendor.bundle.base.js"></script>
    <script src="dist/vendors/js/vendor.bundle.addons.js"></script>
    <script src="dist/js/off-canvas.js"></script>
    <script src="dist/js/hoverable-collapse.js"></script>
    <script src="dist/js/misc.js"></script>
    <script src="dist/js/settings.js"></script>
    <script src="dist/js/todolist.js"></script>

    <script>
        function login() {
            var username = document.getElementById("uname").value;
            var password = document.getElementById("pword").value;
            
            if (username == "") {
                alert("Please enter username");
                return;
            }else if (password == "") {
                alert("Please enter password");
                return;
            }

            $.ajax({
                type: 'GET',
                url: "controllers/signin_controller.php",
                data: {
                    action: "signIn",
                    uname: username,
                    password: password
                },
                success: function(response) {
                    if (response == "011") {
                        window.location.href = "views/admin/admin_home.php";
                    } else if (response == "1") {
                        window.location.href = "views/doctor/doctor_home.php";
                    } else {
                        alert("Invalid username or password");
                    }
                }
            });
        }


        $(document).keypress(function(e) {
            if (e.which === 13) 
            {
              login();   
            }
        });
    </script>
    
</body>


</html>