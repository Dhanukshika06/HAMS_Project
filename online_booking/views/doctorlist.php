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

    <!-- Page Title -->
    <div class="page-title">
      <!-- <div class="heading"> -->
        <div class="container mt-5">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-mb-12">
              <div class="row">
                <div class="col-md-3 form-group position-relative">
                  <!-- <i class="fa fa-user-md position-absolute icon"></i> -->
                  <input type="text" name="name" class="form-control pl-3" id="name" placeholder="Doctor - Max 20 Characters" list="doclist">
                  <datalist id="doclist">
                    <?php
                      $query = "select d.docid,d.title,d.dname,s.speciality_name from doctor d left join speciality s on d.spec_id = s.idspeciality order by d.dname ASC";
                      $res = $db->Search($query);
                      while ($result = mysqli_fetch_assoc($res)) {
                          ?>
                          <option value="<?php echo $result["docid"].":" .$result["title"].". ".$result["dname"]; ?>"> <?php echo $result["speciality_name"]; ?></option>
                    <?php } ?>
                  </datalist>
                </div>
                <div class="col-md-3 form-group mt-3 mt-md-0 position-relative">
                <!-- <i class="fa fa-hospital position-absolute icon"></i> -->
                  <input type="text" class="form-control pl-3" id="center" placeholder="Any Hospital" list="centerlist">
                  <datalist id="centerlist">
                    <?php
                      $query = "select cid,cname from centers order by cname ASC";
                      $res = $db->Search($query);
                      while ($result = mysqli_fetch_assoc($res)) {
                          ?>
                          <option value="<?php echo $result["cid"].":" .$result["cname"]; ?>"> <?php echo $result["cname"]; ?></option>
                    <?php } ?>  
                  </datalist>
                </div>
                <div class="col-md-3 form-group mt-3 mt-md-0 position-relative">
                  <!-- <i class="fa fa-user-md position-absolute icon"></i> -->
                  <input type="text" class="form-control pl-3" id="doc_cat" placeholder="Any Specialization" list="doc_specilist">
                  <datalist id="doc_specilist">
                   <?php
                      $query = "select idspeciality, speciality_name from speciality order by speciality_name ASC";
                      $res = $db->Search($query);
                      while ($result = mysqli_fetch_assoc($res)) {
                          ?>
                          <option value="<?php echo $result["idspeciality"].":" .$result["speciality_name"]; ?>"> <?php echo $result["speciality_name"]; ?></option>
                    <?php } ?>
                </div>
                <div class="col-md-2 form-group mt-3 mt-md-0">
                  <input type="date" name="date" class="form-control datepicker" id="date" placeholder="Appointment Date">
                </div>
                <div class="col-md-1 form-group mt-3 mt-md-0">
                  <div class="text-center"><button type="submit" class="btn btn-dark" id="search_btn">Search</button></div>
                </div>
              </div> 
            </div>
          </div>
        </div>
      <!-- </div> -->
      <!-- <nav class="breadcrumbs">
        <div class="container">
        </div>
      </nav> -->
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <div class="container" data-aos="fade-up">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody id="doclistdata"></tbody>
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

    function getQueryParam(param) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param) ? decodeURIComponent(urlParams.get(param)) : "";
    }

    window.onload = function() {
        document.getElementById("name").value = getQueryParam("doc");
        document.getElementById("center").value = getQueryParam("hos");
        document.getElementById("doc_cat").value = getQueryParam("spe");
        document.getElementById("date").value = getQueryParam("dt");
        getDoctorList();
    };


    function getDoctorList(){
        
      $.ajax({
          type: 'GET',
          url: "../controllers/doctorlist_controller.php",
          data: {
              request: "getDoctors",
              doctor: document.getElementById("name").value,
              center: document.getElementById("center").value,
              speciality: document.getElementById("doc_cat").value,
              selectdate: document.getElementById("date").value
          },
          success: function(response) {
            $("#doclistdata").html(response);    
          },
          error: function(xhr, status, error) {
              alert("Error: " + JSON.parse(response).error);
          }
      });
    }

    function getBookingList(docID,centerID){
        
      var url = '../views/bookinglist.php?doc=' + encodeURIComponent(docID) + 
                "&hos=" + encodeURIComponent(centerID);

      window.location.href = url;
    }

    document.getElementById("search_btn").addEventListener("click", function() {
        getDoctorList();
    });
  </script>

</body>

</html>