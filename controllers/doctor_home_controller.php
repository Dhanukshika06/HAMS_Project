<?php
session_start();
include '../models/db.php';

$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {

    if ($_GET['action'] == 'getCounts') {

        $getAppoinmentCount = $db->Search("SELECT count(apoin_id) as appoinment_count FROM appointment where date = '" . date('Y-m-d') . "' and doctor_docid = '".$_SESSION["user_ID"]."'");

        if ($app_results = mysqli_fetch_assoc($getAppoinmentCount)) {
            $appCount = $app_results['appoinment_count'];            
        }

        $getCentersCount = $db->Search("SELECT count(doctor_docid) as centers FROM doctor_has_centers where doctor_docid = '".$_SESSION["user_ID"]."'");

        if ($cen_results = mysqli_fetch_assoc($getCentersCount)) {
            $cenCount = $cen_results['centers'];            
        }

        echo $appCount.",".$cenCount;
        
    }
}


