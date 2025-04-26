<?php
session_start();
error_reporting(0);
include '../config/database.php';
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['request'])) {
    if ($_GET['request'] == 'getDoctors') {

        $doctorData = isset($_GET['doctor']) && strpos($_GET['doctor'], ':') !== false ? explode(":", $_GET['doctor'])[0] : "%";
        $centerData = isset($_GET['center']) && strpos($_GET['center'], ':') !== false ? explode(":", $_GET['center'])[0] : "%";
        $specialityData = isset($_GET['speciality']) && strpos($_GET['speciality'], ':') !== false ? explode(":", $_GET['speciality'])[0] : "%";
        $dateData = isset($_GET['selectdate']) ? $_GET['selectdate'] : "%";

        // Fetch center details
        $res_centerDetails = $db->Search("SELECT cid, cname FROM centers WHERE cid LIKE '%" . $centerData . "%' AND c_status='1'");

        if (mysqli_num_rows($res_centerDetails) > 0) {
            while ($result_centers = mysqli_fetch_assoc($res_centerDetails)) {
                echo "<tr>";
                echo "<td style='background-color: #86c48c; font-weight:bold;' colspan='2'>" . htmlspecialchars($result_centers['cname']) . "</td>";
                echo "</tr>";

                if ($dateData != "") {
                    $join_part = "LEFT JOIN doc_availability da ON d.docid = da.doctor_docid";
                    $where_part = "AND da.avai_date ='".$dateData."' and da.available_status = '1'";
                }else{
                    $join_part = "";
                    $where_part = "";
                }

                $res_doctorDetails = $db->Search("
                    SELECT d.docid, d.title, d.dname, s.speciality_name, c.cname 
                    FROM doctor d 
                    LEFT JOIN speciality s ON d.spec_id = s.idspeciality 
                    LEFT JOIN doctor_has_centers dhc ON d.docid = dhc.doctor_docid
                    ".$join_part." 
                    JOIN centers c ON dhc.centers_cid = c.cid 
                    WHERE dhc.centers_cid LIKE '".$result_centers['cid']."' 
                    AND dhc.doctor_docid LIKE '".$doctorData."'
                    AND d.spec_id LIKE '".$specialityData."'
                    ".$where_part." 
                    ORDER BY d.dname ASC
                ");

                if (mysqli_num_rows($res_doctorDetails) > 0) {
                    while ($result_doctors = mysqli_fetch_assoc($res_doctorDetails)) {
                        echo "<tr>";
                        echo "<td><i class='fa fa-user fa-2x'></i>&nbsp;&nbsp;&nbsp;&nbsp;" . htmlspecialchars($result_doctors['title']) . ". " . htmlspecialchars($result_doctors['dname']) . " - [" .
                            htmlspecialchars($result_doctors['speciality_name']) . "]</td>";
                        echo "<td align='center'><button class='btn btn-danger' onclick='getBookingList(".$result_doctors["docid"].",".$result_centers['cid'].")'><i class='fa fa-stethoscope'></i> Channel</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No doctors found</td></tr>";
                }
            }
        } else {
            echo "<tr><td colspan='2'>No centers found</td></tr>";
        }
    }
}

?>