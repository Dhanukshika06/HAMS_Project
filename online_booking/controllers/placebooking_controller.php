<?php
session_start();
error_reporting(0);
include '../config/database.php';
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['request'])) {
    if ($_GET['request'] == 'getBookingForm') {

        $doctorData = $_GET['doctor'];
        $centerData = $_GET['center'];
        $timeData = $_GET['time'];
        

        // Fetch center details
        $res_centerDetails = $db->Search("SELECT cid, cname FROM centers WHERE cid = '" . $centerData . "'");

        if (mysqli_num_rows($res_centerDetails) > 0) {
            if ($result_centers = mysqli_fetch_assoc($res_centerDetails)) {
                echo "<tr>";
                echo "<td style='background-color: #86c48c; font-weight:bold;' colspan='2'>" . htmlspecialchars($result_centers['cname']) . "</td>";
                echo "</tr>";

                $res_doctorDetails = $db->Search("
                    SELECT d.docid, d.title, d.dname, s.speciality_name, c.cname 
                    FROM doctor d 
                    LEFT JOIN speciality s ON d.spec_id = s.idspeciality 
                    LEFT JOIN doctor_has_centers dhc ON d.docid = dhc.doctor_docid 
                    JOIN centers c ON dhc.centers_cid = c.cid 
                    WHERE dhc.centers_cid LIKE '".$result_centers['cid']."' 
                    AND dhc.doctor_docid LIKE '".$doctorData."' 
                    ORDER BY d.dname ASC
                ");

                if (mysqli_num_rows($res_doctorDetails) > 0) {
                    if ($result_doctors = mysqli_fetch_assoc($res_doctorDetails)) {
                        echo "<tr>";
                        echo "<td colspan='2'>
                                <img src='../assets/img/doctor.png' style='width:100px;'>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label style='color:red; font-weight:bold; font-size:20px;'>
                                    " . htmlspecialchars($result_doctors['title']) . ". " . htmlspecialchars($result_doctors['dname']) . " 
                                    <br><span style='color:blue; font-size:18px;'>(" . htmlspecialchars($result_doctors['speciality_name']) . ")</span>
                                </label>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No doctors found</td></tr>";
                }

                $res_bookDetails = $db->Search("
                    SELECT av_id, avai_time, avai_date 
                    FROM doc_availability  
                    WHERE centers_cid = '".$result_centers['cid']."' 
                    AND doctor_docid = '".$doctorData."'
                    AND av_id = '".$timeData."' 
                    ORDER BY avai_date,avai_time ASC
                ");

                if (mysqli_num_rows($res_bookDetails) > 0) {
                    if ($result_bookdata = mysqli_fetch_assoc($res_bookDetails)) {
                        
                        $datetime = $result_bookdata['avai_date'] . " " . $result_bookdata['avai_time'];
                        $timestamp = strtotime($datetime);
                        $formatted_date = date("F j, Y", $timestamp);
                        $formatted_time = date("D h:i a", $timestamp);

                        $res_bookNo = $db->Search("SELECT max(apoin_no) as last_appoinmentNo FROM doctor d left join appointment a on a.doctor_docid = d.docid WHERE a.center_cid = '".$result_centers['cid']."' AND d.docid = '".$doctorData."' AND a.date = '".$result_bookdata['avai_date']."'");

                        if ($result_bookNo = mysqli_fetch_assoc($res_bookNo)) {
                             $book_No = $result_bookNo["last_appoinmentNo"] + 1;
                        }

                        echo "<tr>";
                        echo "<td><i class='fa fa-address-book fa-2x'></i>&nbsp;&nbsp;&nbsp;&nbsp;<label style='font-size:14px;'>" . $formatted_date . " <br><span style='color:red; font-weight:bold; font-size:20px;'>" . $formatted_time . "</span>
                                </label></td>";
                        echo "<td align='center'><span style='font-weight:bold; font-size:20px;'> Appoinment No -:</span> <span style='color:red; font-weight:bold; font-size:30px;'>" . str_pad($book_No, 2, "0", STR_PAD_LEFT) . "</span></td>";        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No sessions found</td></tr>";
                }
            }
        } else {
            echo "<tr><td colspan='2'>No centers found</td></tr>";
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request'])) {
    if ($_POST['request'] == 'submitBooking') {

        $name     = $_POST["name"];
        $contact  = $_POST["contact"];
        $nic      = $_POST["nic"];
        $email    = $_POST["email"];
        $address  = $_POST["address"];
        $doctor  = $_POST["doctor"];
        $center  = $_POST["center"];
        $dateID  = $_POST["time"];

        if ($_SESSION["userID"] == "") {
            $ulog = "0";
        }else{
            $ulog = $_SESSION["userID"];
        }

        $res_checkdate = $db->Search("SELECT avai_date,avai_time FROM doc_availability WHERE av_id = '" . $dateID . "'");
        if ($result_checkdate = mysqli_fetch_assoc($res_checkdate)) {
            $ap_date = $result_checkdate["avai_date"];
            $ap_time = $result_checkdate["avai_time"];
        }


        $res_checkPatient = $db->Search("SELECT pid FROM patient WHERE nic = '" . encryptData($nic) . "'");
        if ($result_patient = mysqli_fetch_assoc($res_checkPatient)) {

            $res_checkAppoinment = $db->Search("SELECT apoin_id FROM appointment WHERE patient_pid = '" . $result_patient["pid"] . "' and doctor_docid = '".$doctor."' and center_cid = '".$center."' and date = '".$ap_date."'");
            if ($result_appoinment = mysqli_fetch_assoc($res_checkAppoinment)) {
                echo "ap_already";
            }else{

                $res_checkAppoinmentbookNo = $db->Search("SELECT MAX(apoin_no) + 1 AS next_apoin_no, ADDTIME(MAX(time), '00:10:00') AS next_time FROM appointment WHERE doctor_docid = '".$doctor."' AND center_cid = '".$center."' AND date = '".$ap_date."'");
                if ($result_bookNo = mysqli_fetch_assoc($res_checkAppoinmentbookNo)) {
                    if ($result_bookNo["next_apoin_no"] == "") {
                        $book_No = 1;
                        $book_Time = $ap_time;
                    }else{
                        $book_No = $result_bookNo["next_apoin_no"];
                        $book_Time = $result_bookNo["next_time"];
                    }
                }

                $saveAppoinmentID = $db->SUDwithKeys("insert into appointment(date, time, apoin_no, patient_pid, doctor_docid, center_cid, user_log_uid, av_id, refno) values ('" . $ap_date . "','".$book_Time."','".$book_No."','".$result_patient["pid"]."','".$doctor."','".$center."','".$ulog."','".$dateID."','".mt_rand(1000, 99999)."-".$book_No."')");

                echo $saveAppoinmentID;
            }

        }else{


            $savePatientID = $db->SUDwithKeys("insert into patient(pname, contact, address, nic, email) values ('" . encryptData($name) . "','".encryptData($contact)."','".encryptData($address)."','".encryptData($nic)."','".encryptData($email)."')");

            $res_checkAppoinment = $db->Search("SELECT apoin_id FROM appointment WHERE patient_pid = '" . $savePatientID . "' and doctor_docid = '".$doctor."' and center_cid = '".$center."' and date = '".$ap_date."'");
            if ($result_appoinment = mysqli_fetch_assoc($res_checkAppoinment)) {
                echo "ap_already";
            }else{

                $res_checkAppoinmentbookNo = $db->Search("SELECT MAX(apoin_no) + 1 AS next_apoin_no, ADDTIME(MAX(time), '00:10:00') AS next_time FROM appointment WHERE doctor_docid = '".$doctor."' AND center_cid = '".$center."' AND date = '".$ap_date."'");
                if ($result_bookNo = mysqli_fetch_assoc($res_checkAppoinmentbookNo)) {
                    $book_No = $result_bookNo["next_apoin_no"];
                    $book_Time = $result_bookNo["next_time"];
                }else{
                    $book_No = 1;
                    $book_Time = $ap_time;
                }

                $saveAppoinmentID = $db->SUDwithKeys("insert into appointment(date, time, apoin_no, patient_pid, doctor_docid, center_cid, user_log_uid, av_id, refno) values ('" . $ap_date . "','".$book_Time."','".$book_No."','".$savePatientID."','".$doctor."','".$center."','".$ulog."','".$dateID."','".mt_rand(1000, 99999)."-".$book_No."')");

                echo $saveAppoinmentID;
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