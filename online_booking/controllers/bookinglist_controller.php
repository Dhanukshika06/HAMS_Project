<?php
session_start();
error_reporting(0);
include '../config/database.php';
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['request'])) {
    if ($_GET['request'] == 'getBookingList') {

        $doctorData = $_GET['doctor'];
        $centerData = $_GET['center'];
        

        // Fetch center details
        $res_centerDetails = $db->Search("SELECT cid, cname FROM centers WHERE cid = '" . $centerData . "'");

        if (mysqli_num_rows($res_centerDetails) > 0) {
            if ($result_centers = mysqli_fetch_assoc($res_centerDetails)) {
                echo "<tr>";
                echo "<td style='background-color: #86c48c; font-weight:bold;' colspan='3'>" . htmlspecialchars($result_centers['cname']) . "</td>";
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
                        echo "<td colspan='3'>
                                <img src='../assets/img/doctor.png' style='width:100px;'>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label style='color:red; font-weight:bold; font-size:20px;'>
                                    " . htmlspecialchars($result_doctors['title']) . ". " . htmlspecialchars($result_doctors['dname']) . " 
                                    <br><span style='color:blue; font-size:18px;'>(" . htmlspecialchars($result_doctors['speciality_name']) . ")</span>
                                </label>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No doctors found</td></tr>";
                }

                $res_bookDetails = $db->Search("
                    SELECT av_id, avai_time, avai_date, available_status 
                    FROM doc_availability  
                    WHERE centers_cid = '".$result_centers['cid']."' 
                    AND doctor_docid = '".$doctorData."'
                    AND avai_date >= '".date('Y-m-d')."' 
                    ORDER BY avai_date,avai_time ASC
                ");

                if (mysqli_num_rows($res_bookDetails) > 0) {
                    while ($result_bookdata = mysqli_fetch_assoc($res_bookDetails)) {
                        
                        $datetime = $result_bookdata['avai_date'] . " " . $result_bookdata['avai_time'];
                        $timestamp = strtotime($datetime);
                        $formatted_date = date("F j, Y", $timestamp);
                        $formatted_time = date("D h:i a", $timestamp);

                        if ($result_bookdata['available_status'] == "1") {
                            $btn_stat = "";
                            $btn_word = "Book";
                            $btn_clr = "btn-danger";
                        }else{
                            $btn_stat = "disabled";
                            $btn_word = "Cancelled";
                            $btn_clr = "btn-dark";
                        }
                        
                        $res_bookCount = $db->Search("SELECT d.patient_count,count(a.apoin_id) as appointment_count FROM doctor d left join appointment a on a.doctor_docid = d.docid WHERE a.center_cid = '".$result_centers['cid']."' AND d.docid = '".$doctorData."' AND a.date = '".$result_bookdata['avai_date']."'");

                        if ($result_bookCount = mysqli_fetch_assoc($res_bookCount)) {
                             $patient_limit = $result_bookCount["patient_count"];
                             $book_count = $result_bookCount["appointment_count"];
                        }else{
                             $patient_limit = 0;
                             $book_count = 0;
                        }

                        $btn_msg = "";

                        if ($patient_limit != 0 && $book_count != 0 && $patient_limit == $book_count) {
                            $btn_stat = "disabled";
                            $btn_word = "Book";
                            $btn_clr = "btn-danger";
                            $btn_msg = "Limit is over";
                        }

                        

                        echo "<tr>";
                        echo "<td><i class='fa fa-address-book fa-2x'></i>&nbsp;&nbsp;&nbsp;&nbsp;<label style='font-size:14px;'>" . $formatted_date . " <br><span style='color:red; font-weight:bold; font-size:20px;'>" . $formatted_time . "</span>
                                </label></td>";
                        echo "<td align='center'><sub>patient limit per day</sub>&nbsp;&nbsp;<span style='color:blue; font-weight:bold; font-size:20px;'>".$patient_limit." / ".$book_count."</span>&nbsp;&nbsp;<sub>current booking count</sub></td>";             
                        echo "<td align='center'><button class='btn ".$btn_clr."' onclick='placeBooking(".$result_bookdata["av_id"].",".$doctorData.",".$result_centers['cid'].")' ".$btn_stat."><i class='fa fa-bookmark'></i> ".$btn_word."</button><p>".$btn_msg."</p></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No sessions found</td></tr>";
                }
            }
        } else {
            echo "<tr><td colspan='3'>No centers found</td></tr>";
        }
    }
}

?>