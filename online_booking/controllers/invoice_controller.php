<?php

session_start();
error_reporting(0);
include '../config/database.php';
$db = new DB(); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_FILES['pdf'])) {
        die("No PDF file received!");
    }

    $res_apdata = $db->Search("select p.email from appointment a left join doctor d on d.docid = a.doctor_docid left join centers c on c.cid = a.center_cid left join patient p on p.pid = a.patient_pid left join doctor_has_centers dhc on dhc.doctor_docid = a.doctor_docid left join payments py on py.apid = a.apoin_id where a.apoin_id='".$_POST['apid']."' and py.status = '1'");

    if ($result_apdata = mysqli_fetch_assoc($res_apdata)) {
    	$patient_email = decryptData($result_apdata["email"]);
    }

    


    if ($_FILES['pdf']['error'] === 0) {
        $pdfFile = $_FILES['pdf']['tmp_name'];
        $pdfName = "invoice_" . time() . ".pdf";
        $savePath = "../invoices/" . $pdfName;

        // Create invoices folder if not exists
        if (!is_dir("../invoices/")) {
            mkdir("../invoices/", 0777, true);
        }

        // Move uploaded file
        if (move_uploaded_file($pdfFile, $savePath)) {
            if (sendEmailWithAttachment($savePath, $pdfName,$patient_email)) {
                echo "1"; // Success
            } else {
                echo "Email sending failed!";
            }
        } else {
            echo "Error saving PDF file.";
        }
    } else {
        echo "Error uploading PDF!";
    }
}

// Function to send email with PDF attachment
function sendEmailWithAttachment($pdfPath, $pdfName,$emailData)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Config
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sumudu123ishara@gmail.com';  // Change This
        $mail->Password = 'pbmq dcds vunz wplc';  // Change This
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Details
        $mail->setFrom('sumudu123ishara@gmail.com', 'Medico Online Channeling');
        $mail->addAddress($emailData);
        $mail->Subject = 'Invoice PDF Attached';
        $mail->Body = "Dear Sir/Madam, \n\nPlease find your invoice attached here.\n\nThank you!";
        $mail->addAttachment($pdfPath, $pdfName);

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['request'])) {
    if ($_GET['request'] == 'loadInvoiceData') {

       $res_apdata = $db->Search("select d.title,d.dname,d.docfee,c.cname,c.cfee,p.pname,p.contact,p.nic,p.email,a.date,a.time,a.apoin_no,a.refno,dhc.roomNo,py.date as paydate,py.amount from appointment a left join doctor d on d.docid = a.doctor_docid left join centers c on c.cid = a.center_cid left join patient p on p.pid = a.patient_pid left join doctor_has_centers dhc on dhc.doctor_docid = a.doctor_docid left join payments py on py.apid = a.apoin_id where a.apoin_id='".$_GET['appoinmentID']."' and py.status = '1'");

        if ($result_apdata = mysqli_fetch_assoc($res_apdata)) {

            $docname = $result_apdata["title"].".".$result_apdata["dname"];
            $doc_fee = $result_apdata["docfee"];
            $center_name = $result_apdata["cname"];
            $center_fee = $result_apdata["cfee"];
            $patient_name = decryptData($result_apdata["pname"]);
            $patient_contact = decryptData($result_apdata["contact"]);
            $patient_nic = decryptData($result_apdata["nic"]);
            $patient_email = decryptData($result_apdata["email"]);

            $datetime = $result_apdata['date'] . " " . $result_apdata['time'];
            $timestamp = strtotime($datetime);
            $appoinment_date = $result_apdata["date"];
            $appoinment_time = date("D h:i a", $timestamp);

            $appoinment_no = str_pad($result_apdata["apoin_no"], 2, "0", STR_PAD_LEFT);
            $refference_no = $result_apdata["refno"];
            $doctor_roomNo = $result_apdata["roomNo"];
            $payment_date = $result_apdata["paydate"];
            $payamount = $result_apdata["amount"];
        }


        echo "<br><br><center>     
        <img src='../assets/img/logo.png' width='15%'/>

        <h4>- Booking Invoice -</h4>
        <hr/></br>

        <table width='80%' style='border: 1px solid black; padding: 5px; border-collapse: collapse; font-family: 'Times New Roman', Times, serif;'>
            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Refference No</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: ". $refference_no ." </td>     
            </tr>
            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Appoinment Date</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: ".$appoinment_date."</td>     
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Appoinment Time</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: ".$appoinment_time."</td>
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Appoinment No</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: ".$appoinment_no."</td>    
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Hospital</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: ".$center_name."</td>    
            </tr>

            
            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Patient Name</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: ".$patient_name."</td>     
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Contact Number</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: ".$patient_contact."</td>   
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>NIC</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>:  ".$patient_nic."</td> 
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Email</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: ".$patient_email."</td> 
            </tr>

            
            


            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Room</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>:  ".$doctor_roomNo."</td> 
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Doctor Name</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: ".$docname."</td> 
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Payment Date</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: ".$payment_date."</td> 
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Source</td>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>: Online Web</td> 
            </tr>

            

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Doctor Charge</td>
                <td align='right' style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>". number_format($doc_fee,2)."</td>    
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Hospital Charge</td>
                <td align='right' style='border: 1px solid black; padding: 5px; border-collapse: collapse;'> ". number_format($center_fee,2)."</td>  
            </tr>

            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>Booking Charge</td>
                <td align='right' style='border: 1px solid black; padding: 5px; border-collapse: collapse;'> ".number_format(150,2)."</td> 
            </tr>

            
            <tr style='border: 1px solid black; padding: 5px; border-collapse: collapse;'>  
                <td style='border: 1px solid black; padding: 5px; border-collapse: collapse; font-weight: bold;'>Total Charge</td>
                <td align='right' style='border: 1px solid black; padding: 5px; border-collapse: collapse; font-weight: bold;'> ".number_format($payamount,2)."</td>    
            </tr>
        </table>
        <br/>
    </center> 
    <hr/>
    <center><p style='font-size:12px; margin-right: 30px;'><small>Thank You For Using Medicio Channeling System - Powered by MaGora</small></p></center>";
        
    }
}



function encryptData($data) {
    $encryptedData = base64_encode(strrev($data));
    return $encryptedData;
}

function decryptData($encryptedData) {
    $decryptedData = strrev(base64_decode($encryptedData));
    return $decryptedData;
}
?>