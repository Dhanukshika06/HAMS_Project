<?php
session_start();
include '../models/db.php';
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {

    if ($_GET['action'] == 'getDoctorFeatures') {
        $doctorID = $_GET['doctorID'];
        $features = [];

        $getFeatures = $db->Search("SELECT fid FROM privilages WHERE uid = '".$doctorID."'");
        while ($row = mysqli_fetch_assoc($getFeatures)) {
            $features[] = $row['fid'];
        }

        echo json_encode(["features" => $features]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'savePrivileges') {

        $doctorID = $_POST['doctorID'];
        $features = $_POST['features'];

        $DeleteOldFeatures = $db->SUD("delete from privilages where uid = '" . $doctorID . "'");
    
        foreach ($features as $fid) {
            $SaveFeatures = $db->SUD("insert into privilages (uid, fid) values('" . $doctorID . "','" . $fid . "')");
        }
        
        echo "1";    
    } 
}

