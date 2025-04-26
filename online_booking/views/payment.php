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
                                <h3 class="text-center mb-4">Secure Payment</h3>

                                <ul class="nav nav-tabs mb-3" id="paymentTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="card-tab" data-bs-toggle="tab" data-bs-target="#card" type="button">💳 Card Details</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="qr-tab" type="button">📱 Payment Details</button>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <!-- Card Payment -->
                                    <div class="tab-pane fade show active" id="card">
                                        <div>
                                            <div class="mb-3">
                                                <label class="form-label">Card Number</label>
                                                <input type="number" id="cardNo" class="form-control" placeholder="**** **** **** ****" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Expiry Date</label>
                                                    <input type="text" id="expDate" class="form-control" placeholder="MM/YY" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">CVV</label>
                                                    <input type="password" id="cvvdata" class="form-control" placeholder="***" required>
                                                </div>
                                            </div>

                                            <button class="btn btn-success w-100 mt-4" id="confirmPayment">Confirm Payment</button>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="bank">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody id="invoicetbl"></tbody>
                                            </table>
                                        </div>
                                        <button class="btn btn-success w-100 mt-4" id="btn_payment_send" data-bs-target="#qr">Payment Send</button>
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
        window.onload = function() {
            loadPaymentData();
        };

        function sweetalert(type, title, message) {
            Swal.fire({
                icon: type,
                title: title,
                text: message,
            })
        }

        function sweetalert2(type, title) {

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

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("confirmPayment").addEventListener("click", function() {

                var cardNo = $("#cardNo").val().trim();
                var expDate = $("#expDate").val().trim();
                var cvv = $("#cvvdata").val().trim();

                if (cardNo === "") {
                    sweetalert2("warning", "Please enter card no!");
                } else if (cardNo.length !== 16 || !/^\d+$/.test(cardNo)) {
                    sweetalert2("warning", "Please enter a valid 16‑digit card no!");
                } else if (expDate === "") {
                    sweetalert2("warning", "Please enter expiry date!");
                } else if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expDate)) {
                    sweetalert2("warning", "Please enter a valid expiry date (MM/YY)!");
                } else if (cvv === "") {
                    sweetalert2("warning", "Please enter cvv no!");
                } else if (cvv.length !== 3 || !/^\d+$/.test(cvv)) {
                    sweetalert2("warning", "Please enter a valid 3‑digit cvv no!");
                } else {
                    
                    document.getElementById("bank").classList.add("show", "active");
                    var qrTab = new bootstrap.Tab(document.getElementById("qr-tab"));
                    qrTab.show();
                    document.getElementById("card-tab").classList.add("disabled");
                }
            });
        });

        function loadPaymentData() {

            // alert(getQueryParam("apid"));
            $.ajax({
                type: 'GET',
                url: "../controllers/payment_controller.php",
                data: {
                    request: "loadPaymentData",
                    appoinmentID: getQueryParam("apid")
                },
                success: function(response) {
                    $("#invoicetbl").html(response);
                },
                error: function(xhr, status, error) {
                    alert("Error: " + JSON.parse(xhr.responseText).error);
                }
            });
        }


        function savePayments() {
            $.ajax({
                type: 'POST',
                url: "../controllers/payment_controller.php",
                data: {
                    request: "savePayment",
                    appoinmentID: getQueryParam("apid")
                },
                success: function(response) {
                    if (response == "0") {
                        sweetalert("error", "Error", "Payment not completed");
                    } else {
                        sweetalert("success", "Success", "Payment successfully");
                        var url = '../views/invoice.php?apid=' + encodeURIComponent(getQueryParam("apid"));
                        window.location.href = url;
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error: " + JSON.parse(xhr.responseText).error);
                }
            });
        }

        document.getElementById("btn_payment_send").addEventListener("click", function() {
            savePayments();
        });
    </script>

</body>

</html>