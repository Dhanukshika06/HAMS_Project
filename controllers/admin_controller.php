<?php
session_start();
include '../models/db.php';

$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {

    if ($_GET['action'] == 'getCounts') {

        $getAppoinmentCount = $db->Search("SELECT count(apoin_id) as appoinment_count FROM appointment where date = '" . date('Y-m-d') . "'");

        if ($app_results = mysqli_fetch_assoc($getAppoinmentCount)) {
            $appCount = $app_results['appoinment_count'];            
        }

        $getDoctorsCount = $db->Search("SELECT count(docid) as doctor_count FROM doctor where dstatus = '1'");

        if ($doc_results = mysqli_fetch_assoc($getDoctorsCount)) {
            $docCount = $doc_results['doctor_count'];            
        }

        $getCentersCount = $db->Search("SELECT count(cid) as center_count FROM centers where c_status = '1'");

        if ($cen_results = mysqli_fetch_assoc($getCentersCount)) {
            $cenCount = $cen_results['center_count'];            
        }

        echo $appCount.",".$docCount.",".$cenCount;
        
    }else if ($_GET['action'] == 'getAllSpeciality') {
        
    }
}


