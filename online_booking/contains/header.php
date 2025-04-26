<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="d-none d-md-flex align-items-center">
          <i class="bi bi-clock me-1"></i> <div id="datetime"></div>
        </div>
        <div class="d-flex align-items-center">
          <i class="bi bi-phone me-1"></i> Call us now 011 327 4554
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-end">
        <a href="index.html" class="logo d-flex align-items-center me-auto">
          <img src="assets/img/logo.png" alt="">
          <!-- Uncomment the line below if you also wish to use a text logo -->
          <!-- <h1 class="sitename">Medicio</h1>  -->
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#hero" class="active">Home</a></li>
            <li><a href="#about">About</a></li>
            <!-- <li><a href="#services">Services</a></li>
            <li><a href="#departments">Departments</a></li>
            <li><a href="#doctors">Doctors</a></li> -->
            
            <!-- <li><a href="#contact">Contact</a></li> -->
            <?php
                 if ($_SESSION["userID"] == "") {?>
                    <li><a href="views/signin.php">Sign In</a></li><?php
                 }else{

                    $res_checkUser = $db->Search("SELECT name FROM user WHERE uid = '" . $_SESSION["userID"] . "'");
                    if ($result_user = mysqli_fetch_assoc($res_checkUser)) {
                       $userName = decryptData($result_user["name"]);
                    }else{
                       $userName = "User";
                    }

                  ?>
                    <li class="dropdown"><a href="#"><span><?php echo $userName; ?></span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                      <ul>
                        <li><a href="views/mybooking.php">My Bookings</a></li>
                        <li><a href="views/cancel_request.php">Cancel Bookings</a></li>
                        <li><a href="controllers/signout_controller.php">Sign Out</a></li>
                      </ul>
                    </li><?php
                 }
             ?>
            
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="cta-btn" href="#appointment">Search Your Doctor</a>

      </div>

    </div>

  </header>

  <script>
      function updateTime() {
          let now = new Date();
          let options = { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' };
          let dateStr = now.toLocaleDateString('en-US', options);
          let timeStr = now.toLocaleTimeString('en-US', { hour24: true });

          document.getElementById('datetime').innerHTML = dateStr + " " + timeStr;
      }
      setInterval(updateTime, 1000); // Update every second
      window.onload = updateTime; // Update immediately on load
  </script>


  <?php

  function encryptData($data) {
      $encryptedData = base64_encode(strrev($data));
      return $encryptedData;
  }

  function decryptData($encryptedData) {
      $decryptedData = strrev(base64_decode($encryptedData));
      return $decryptedData;
  }

  ?>