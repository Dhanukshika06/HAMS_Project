<?php
session_start();
include '../models/db.php';
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
        if ($_GET['action'] == 'getAllAvailability') {

            $docID = $_GET['docID'];
            $centerID = $_GET['centerID'];
            $availabilityList = "";

            if ($docID != "" && $centerID != "") {
                $query = "select a.av_id, a.avai_time, a.avai_date, a.centers_cid, a.doctor_docid, a.available_status, b.dname,c.cname
                    FROM doc_availability a
                    LEFT JOIN doctor b ON a.doctor_docid = b.docid
                    LEFT JOIN centers c ON a.centers_cid = c.cid
                    where a.doctor_docid = '$docID' and a.centers_cid = '$centerID'
                    and a.avai_date >= '".date('Y-m-d')."'
                    GROUP BY a.av_id
                    ORDER BY a.avai_date ASC, a.avai_time ASC";
            } else {
                if ($docID == "") {
                    $docID = "%";
                }

                if ($centerID == "") {
                    $centerID = "%";
                }

                $query = "select a.av_id, a.avai_time, a.avai_date, a.centers_cid, a.doctor_docid, a.available_status, b.dname,c.cname
                    FROM doc_availability a
                    LEFT JOIN doctor b ON a.doctor_docid = b.docid
                    LEFT JOIN centers c ON a.centers_cid = c.cid
                    where a.doctor_docid like '$docID' and a.centers_cid like '$centerID'
                    and a.avai_date >= '".date('Y-m-d')."'
                    GROUP BY a.av_id
                    ORDER BY a.avai_date ASC, a.avai_time ASC";
            }      

            
            $getAllAvailability = $db->Search($query);

            while ($availability_results = mysqli_fetch_assoc($getAllAvailability)) {

                $getroomNo = $db->Search("select roomNo from doctor_has_centers where doctor_docid = '".$availability_results['doctor_docid']."' and centers_cid = '".$availability_results['centers_cid']."'");

                    if ($roomt_results = mysqli_fetch_assoc($getroomNo)) {
                        $roomNo = $roomt_results["roomNo"];
                    }
                    else
                    {
                        $roomNo = 0;
                    }




                if ($availability_results['available_status'] == 1) 
                {
                    $checkAppCountByDate = $db->Search("select count(apoin_id) as appcount from appointment where date = '".$availability_results['avai_date']."' and doctor_docid = '".$availability_results['doctor_docid']."' and center_cid = '".$availability_results['centers_cid']."'");

                    if ($availapcount_results = mysqli_fetch_assoc($checkAppCountByDate)) {
                        $appCount = $availapcount_results["appcount"];
                    }
                    else
                    {
                        $appCount = 0;
                    }

                    
                    if ($appCount > 0) {
                        $btn_avb = "<button class='btn btn-danger btn-sm' onclick='change_reshed_Availability(" . $availability_results['av_id'] . ")' >Not Available</button>";
                    }else{
                        $btn_avb = "<button class='btn btn-danger btn-sm' onclick='changeAvailability(" . $availability_results['av_id'] . ",\"B\")'>Not Available</button>";
                    }


                    $availabilityList .= "<tr>";
                    $availabilityList .= "<td style=\"font-size: large;\">" . $availability_results['dname'] . "</td>";
                    $availabilityList .= "<td style=\"font-size: large;\">" . $availability_results['cname'] . "</td>";
                    $availabilityList .= "<td style=\"font-size: large;\" align='center'>" . $roomNo . "</td>"; 
                    $availabilityList .= "<td style=\"font-size: large;\">" . $availability_results['avai_date'] . "</td>"; 
                    $availabilityList .= "<td style=\"font-size: large;\">" . $availability_results['avai_time'] . "</td>";                 
                    $availabilityList .= "<td style=\"font-size: large;\">Available</td>"; 
                    $availabilityList .= "<td style=\"font-size: large;\">
                <button class='btn btn-primary btn-sm' onclick='loadAvailability(" . $availability_results['av_id'] . ", 
                \"" . $availability_results['avai_date'] . "\", 
                \"" . $availability_results['avai_time'] . "\", 
                " . $availability_results['centers_cid'] . ",
                " . $availability_results['doctor_docid'] . ",
                " . $availability_results['available_status'] . ",
                \"" . $roomNo . "\")'>
                Edit</button>&nbsp;&nbsp;
                ".$btn_avb."

                    
                </td>";
                    $availabilityList .= "</tr>";
                } 
                else
                {
                    $availabilityList .= "<tr>";
                    $availabilityList .= "<td style=\"font-size: large;\">" . $availability_results['dname'] . "</td>";
                    $availabilityList .= "<td style=\"font-size: large;\">" . $availability_results['cname'] . "</td>";
                    $availabilityList .= "<td style=\"font-size: large;\" align='center'>" . $roomNo . "</td>"; 
                    $availabilityList .= "<td style=\"font-size: large;\">" . $availability_results['avai_date'] . "</td>"; 
                    $availabilityList .= "<td style=\"font-size: large;\">" . $availability_results['avai_time'] . "</td>";                 
                    $availabilityList .= "<td style=\"font-size: large;\">Not Available</td>"; 
                    $availabilityList .= "<td style=\"font-size: large;\">
                        <button class='btn btn-success btn-sm' onclick='changeAvailability(" . $availability_results['av_id'] . ",\"A\")'>Available</button>
                    </td>";
                        $availabilityList .= "</tr>";   
                }
                
            }

            echo $availabilityList;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'saveAvailability') {
        $doctorId = $_POST['doctor'];
        $centerId = $_POST['center'];
        $date = $_POST['date'];
        $timeFrom = $_POST['timeFrom'];
        $room_No = $_POST['room_No'];

        // Check if availability already exists
        $checkAvailability = $db->Search("SELECT * FROM doc_availability 
                                      WHERE doctor_docid = '$doctorId' 
                                        AND avai_date = '$date' 
                                        AND avai_time = '$timeFrom'
                                        AND centers_cid = '$centerId'");

        if (mysqli_fetch_assoc($checkAvailability)) {
            echo "2";  // Availability already exists
        } 
        else 
        {
            // Insert new availability record into doc_availability
            $av_id = $db->SUDwithKeys("INSERT INTO doc_availability 
                                     (avai_time, avai_date, centers_cid, doctor_docid, available_status) 
                                     VALUES ('$timeFrom', '$date', '$centerId', '$doctorId', '1')");

            $checkROOM = $db->Search("SELECT * FROM doctor_has_centers 
            WHERE doctor_docid = '$doctorId' 
            AND centers_cid = '$centerId' 
            AND roomNo = '$room_No'");

            if (mysqli_fetch_assoc($checkROOM)) {

                $updaRoom = $db->SUD("update doctor_has_centers set roomNo = '".$room_No."' where doctor_docid = '".$doctorId."' and centers_cid = '".$centerId."'");

                if ($updaRoom == "1") 
                {
                  echo "1";  
                } 
                else 
                {
                  echo "0";  
                }
            }else{
                $insertRoom = $db->SUD("INSERT INTO doctor_has_centers (doctor_docid, centers_cid, roomNo, doc_avid) VALUES ('$doctorId', '$centerId', '$room_No', '$av_id')");

                if ($insertRoom == "1") 
                {
                  echo "1";  
                } 
                else 
                {
                  echo "0";  
                }
            }                            
        }
    } else if ($_POST['action'] == 'updateAvailability') {

        $av_id = $_POST['availability_id'];
        $timeFrom = $_POST['timeFrom'];
        $date = $_POST['date'];
        $center = $_POST['center'];
        $doctor = $_POST['doctor'];
        $room_No = $_POST['room_No']; 

       
        $updateAvailability = $db->SUD("UPDATE doc_availability 
                                    SET avai_time = '$timeFrom', 
                                        avai_date = '$date', 
                                        centers_cid = '$center', 
                                        doctor_docid = '$doctor' 
                                    WHERE av_id = '$av_id'");

        if ($updateAvailability == "1") {

            $updateRoom = $db->SUD("UPDATE doctor_has_centers 
                                SET roomNo = '$room_No' 
                                WHERE doctor_docid = '$doctor' 
                                  AND centers_cid = '$center'");

            echo "1";
        } else {
            echo "0"; 
        }
    } else if ($_POST['action'] == 'deleteAvailability') {
        
        $av_id = $_POST['availability_id'];

      
        $updateStatus = $db->SUD("UPDATE doc_availability 
                              SET available_status = '0' 
                              WHERE av_id = '$av_id'");

        if ($updateStatus == "1") {
           
            $updateRoom = $db->SUD("UPDATE doctor_has_centers 
                                SET roomNo = NULL 
                                WHERE doctor_docid = (SELECT doctor_docid FROM doc_availability WHERE av_id = '$av_id') 
                                  AND centers_cid = (SELECT centers_cid FROM doc_availability WHERE av_id = '$av_id')");

            echo "1"; 
        } else {
            echo "0"; 
        }
    }else if ($_POST['action'] == 'changeAvailability') {

        $av_id = $_POST['availability_id'];
        $date = $_POST['req_date'];

        $checkavbDate = $db->Search("select centers_cid, doctor_docid from doc_availability where av_id = '".$av_id."'");

        if ($avb_results = mysqli_fetch_assoc($checkavbDate)) {
            $centerID = $avb_results["centers_cid"];
            $docID = $avb_results["doctor_docid"];
        }

        $checkavbDate2 = $db->Search("select av_id from doc_availability where centers_cid = '".$centerID."' and doctor_docid = '".$docID."' and avai_date='".$date."'");
        
        if ($avb_results2 = mysqli_fetch_assoc($checkavbDate2)) {
            $updateAppDate = $db->SUD("UPDATE appointment 
                                    SET date = '".$date."' 
                                    WHERE av_id = '$av_id'");

            $updateAVDate = $db->SUD("UPDATE doc_availability 
                                    SET available_status = '0' 
                                    WHERE av_id = '$av_id'");
        }

        if ($updateAppDate == "1") {
            echo "1";
        } else {
            echo "0"; 
        }
    }
    else if ($_POST['action'] == 'updatechange_Availability') {

        $av_id = $_POST['availability_id'];
        $param = $_POST['req_param'];

        if ($param == "A") {
            $updateAVDate = $db->SUD("UPDATE doc_availability 
                                    SET available_status = '1' 
                                    WHERE av_id = '$av_id'");
        }else{
            $updateAVDate = $db->SUD("UPDATE doc_availability 
                                    SET available_status = '0' 
                                    WHERE av_id = '$av_id'");
        }

        if ($updateAVDate == "1") {
            echo "1";
        } else {
            echo "0"; 
        }
    }
}