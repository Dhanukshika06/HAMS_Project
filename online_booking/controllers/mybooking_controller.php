<?php
session_start();
error_reporting(0);
include '../config/database.php';
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['request'])) {
    if ($_GET['request'] == 'getBookingList') {

// and py.status = '1'
        // Fetch center details
        $res_bookDetails = $db->Search("select d.title,d.dname,d.docfee,c.cname,c.cfee,p.pname,p.contact,p.nic,p.email,a.date,a.time,a.apoin_no,a.refno,dhc.roomNo,py.date as paydate,py.amount from appointment a left join doctor d on d.docid = a.doctor_docid left join centers c on c.cid = a.center_cid left join patient p on p.pid = a.patient_pid left join doctor_has_centers dhc on dhc.doctor_docid = a.doctor_docid left join payments py on py.apid = a.apoin_id where a.date between '".$_GET['date_to']."' and '".$_GET['date_from']."' and a.user_log_uid = '".$_SESSION["userID"]."' ");

        if (mysqli_num_rows($res_bookDetails) > 0) {
            if ($result_book = mysqli_fetch_assoc($res_bookDetails)) {
                $datetime = $result_book['date'] . " " . $result_book['time'];
                $timestamp = strtotime($datetime);
                $formatted_date = date("F j, Y", $timestamp);
                $formatted_time = date("D h:i a", $timestamp);

                echo "<tr>";
                echo "<td colspan='3'>
                        Refference No : ".$result_book["refno"]."<br> Appoinment No : ".str_pad($result_book["apoin_no"], 2, "0", STR_PAD_LEFT)."<br> Date & Time : ".$formatted_date." - " . $formatted_time . "<br> Doctor Name : ".$result_book["title"]."." . $result_book["dname"] . "<br> Patient Name : ".decryptData($result_book["pname"])."<br> Hospital Name : ".$result_book["cname"]."
                      </td>";
                echo "</tr>";  
            }
        } else {
            echo "<tr><td colspan='3'>No bookings found</td></tr>";
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