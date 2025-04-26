<?php
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Colombo');
setlocale(LC_MONETARY, 'en_US');
include '../config/database.php';
$db = new DB();
?>

<html>
<head>
    <title>Invoice - Medicio Doctor Channeling</title>
    <!-- Favicons -->
    <link href="../assets/img/logo.png" rel="icon">
    <link href="../assets/img/logo.png" rel="apple-touch-icon">
    <link href="../assets/css/main.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/sweetalert2.js"></script>
    <style>
        .Report_Headerx{
            border-radius: 10px; 
            width: 250px;
            display: block;
            background-color: #cc0033;
            color: white;
            padding-left: 20px;
            padding-right: 20px; 
            padding-top: 5px;
            padding-bottom: 5px;     
            font-size: 18px; 
            font-family: "Times New Roman", Times, serif;
            font-weight: bolder;
        } 

        .borderbtm{
            border-bottom-color: #000; 
            border-bottom-style: solid; 
            border-bottom-width: 1px;
        }

        .borderbtmAsh{
            border-bottom-color: #999999; 
            border-bottom-style: solid; 
            border-bottom-width: 1px;
        }
    </style>

</head>
<body>

     <script type="text/javascript">
            window.onload = function() {
             generateInv();
            };

            function getQueryParam(param) {
                var urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param) ? decodeURIComponent(urlParams.get(param)) : "";
            }

            function sweetalert(type, title, message) {
              Swal.fire({
                  icon: type,
                  title: title,
                  text: message,
              })
            }


            function generateInv(){
                $.ajax({
                    type: 'GET',
                    url: "../controllers/invoice_controller.php",
                    data: {
                        request: "loadInvoiceData",
                        appoinmentID: getQueryParam("apid")
                    },
                    success: function(response) {
                        $("#invoice_data").html(response);
                        setTimeout(generatePDF, 2000);
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + JSON.parse(xhr.responseText).error);
                    }
                });  
            }


            function generatePDF() 
            {
                const element = document.querySelector("#invoice_data");

                const opt = {
                    margin: 8,
                    filename: "invoice.pdf",
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'letter', orientation: 'portrait' }
                };

                html2pdf().from(element).toPdf().get('pdf').then(function (pdf) {
                    pdf.save("invoice.pdf");

                    let pdfBlob = pdf.output('blob');
                    let formData = new FormData();
                    formData.append("pdf", pdfBlob, "invoice.pdf");
                    formData.append("apid", getQueryParam("apid"));

                    // Send to backend
                    fetch("../controllers/invoice_controller.php", {
                        method: "POST",
                        body: formData
                    })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() === "1") {
                                sweetalert("success","Success", "Invoice sent successfully via email");
                                var url = '../index.php';
                                window.location.href = url;
                            } else {
                                alert("Error sending email: " + data);
                            }
                        })
                        .catch(error => console.error("Error:", error));
                });
            }
        </script>
    <div id="invoice_data"></div>
</body>
</html>