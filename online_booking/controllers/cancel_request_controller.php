<?php
session_start();
error_reporting(0);
include '../config/database.php';
$db = new DB();

// if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['request'])) {
//     if ($_GET['request'] == 'loadPaymentData') {

//         $appoinmentID = $_GET['appoinmentID'];
        
//         $res_apdata = $db->Search("select d.title,d.dname,d.docfee,c.cname,c.cfee,p.pname,a.date,a.time,a.apoin_no,a.refno from appointment a left join doctor d on d.docid = a.doctor_docid left join centers c on c.cid = a.center_cid left join patient p on p.pid = a.patient_pid where a.apoin_id='".$appoinmentID."'");

//         if ($result_apdata = mysqli_fetch_assoc($res_apdata)) {

//                 $total = $result_apdata["cfee"] + $result_apdata["docfee"] + 150;

//                 $datetime = $result_apdata['date'] . " " . $result_apdata['time'];
//                 $timestamp = strtotime($datetime);
//                 $formatted_date = date("F j, Y", $timestamp);
//                 $formatted_time = date("D h:i a", $timestamp);

//                 echo "<tr>";
//                     echo "<td>Reference No</td>";
//                     echo "<td>: " . $result_apdata["refno"] . "</td>";
//                 echo "</tr>";

//                 echo "<tr>";
//                     echo "<td>Appoinment No</td>";
//                     echo "<td>: " . str_pad($result_apdata["apoin_no"], 2, "0", STR_PAD_LEFT) . "</td>";
//                 echo "</tr>";

//                 echo "<tr>";
//                     echo "<td>Patient Name</td>";
//                     echo "<td>: " . decryptData($result_apdata["pname"]) . "</td>";
//                 echo "</tr>";

//                 echo "<tr>";
//                     echo "<td>Hospital Name</td>";
//                     echo "<td>: " . $result_apdata["cname"] . "</td>";
//                 echo "</tr>";

//                 echo "<tr>";
//                     echo "<td>Doctor Name</td>";
//                     echo "<td>: ".$result_apdata["title"]."." . $result_apdata["dname"] . "</td>";
//                 echo "</tr>";

//                 echo "<tr>";
//                     echo "<td>Appoinment Data & Time</td>";
//                     echo "<td>: ".$formatted_date." - " . $formatted_time . "</td>";
//                 echo "</tr>";

//                 echo "<tr>";
//                     echo "<td>Hospital Fee</td>";
//                     echo "<td align='right'>".number_format($result_apdata["cfee"],2)."</td>";
//                 echo "</tr>";

//                 echo "<tr>";
//                     echo "<td>Doctor Fee</td>";
//                     echo "<td align='right'>".number_format($result_apdata["docfee"],2)."</td>";
//                 echo "</tr>";

//                 echo "<tr>";
//                     echo "<td>Booking Fee</td>";
//                     echo "<td align='right'>".number_format(150,2)."</td>";
//                 echo "</tr>";

//                 echo "<tr>";
//                     echo "<td style='font-weight:bold;'>Total Amount</td>";
//                     echo "<td style='font-weight:bold;' align='right'>".number_format($total,2)."</td>";
//                 echo "</tr>";
//         }
//     }
// }


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request'])) {
    if ($_POST['request'] == 'cancelBooking') {

        $refNo = $_POST["refno"];
        $contactNo = $_POST["contno"];
        $reason = $_POST["reason"];

        $res_checkcancel = $db->Search("select bcrid from booking_cancel_req where refno='".$refNo."' and contact='".$contactNo."'");
        if ($result_checkcancel = mysqli_fetch_assoc($res_checkcancel)) {
            echo "2";
        }else{
            $savecancelReq = $db->SUD("insert into booking_cancel_req(refno, contact, status, date, reason, req_user) values ('" . $refNo . "','".$contactNo."','0','".date("Y-m-d")."','".$reason."','".$_SESSION["userID"]."')");

            if ($savecancelReq == "1") {
                echo "1";
            }else{
                echo "0";
            } 
        }         
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