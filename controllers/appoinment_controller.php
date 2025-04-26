<?php
error_reporting(0);
session_start();
include '../models/db.php';

$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {

    if ($_GET['action'] == 'getAllAppoinment') {

        $datefrom = $_GET['datefrom'];
        $dateto = $_GET['dateto'];
        $doctor = $_GET['doctor'];
        $center = $_GET['center'];
        $status = $_GET['status'];

        $appList = "";


        $getAppoinmentData = $db->Search("select a.apoin_no,a.date,p.pname,p.contact,p.address,d.title,d.dname,c.cname from appointment a left join patient p on p.pid = a.patient_pid left join doctor d on d.docid = a.doctor_docid left join centers c on c.cid = a.center_cid where a.date between '".$datefrom."' and '".$dateto."' and a.doctor_docid like '".$doctor."' and a.center_cid like '".$center."' order by a.date,a.apoin_no asc");

        while ($app_results = mysqli_fetch_assoc($getAppoinmentData)) {
            $appList .= "<tr>";
            $appList .= "<td style=\"font-size: large;\" align='center'>" . $app_results['apoin_no'] . "</td>";
            $appList .= "<td style=\"font-size: large;\" align='center'>" . $app_results['date'] . "</td>";
            $appList .= "<td style=\"font-size: large;\">" . decryptData($app_results['pname']) . "</td>";
            $appList .= "<td style=\"font-size: large;\">" . decryptData($app_results['contact']) . "</td>";
            $appList .= "<td style=\"font-size: large;\">" . decryptData($app_results['address']) . "</td>";
            $appList .= "<td style=\"font-size: large;\">" . $app_results['title'].".". $app_results['dname'] . "</td>";
            $appList .= "<td style=\"font-size: large;\">" . $app_results['cname']."</td>";
            // $appList .= "<td style=\"font-size: large;\">
                
            // </td>";
            $appList .= "</tr>";

            // <button class='btn btn-primary btn-md' onclick='loadCenter(" . $app_results['apoin_no'] . ", \"" . $app_results['cname'] . "\", \"" . $center_results['c_contact'] . "\", \"" . $center_results['cfee'] . "\")'>Edit</button>
            //    <button class='btn btn-danger btn-md' onclick='deleteCenter(" . $app_results['apoin_no'] . ")'>Delete</button>
        }
        
        echo $appList;
        
        
    }else if ($_GET['action'] == 'getAllSpeciality') {
        
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] == 'saveSpeciality') {
        
        $getSpeciality = $db->Search("SELECT idspeciality FROM speciality where lower(speciality_name) = lower('" . $_POST['speciality_name'] . "')");

        if ($speciality_results = mysqli_fetch_assoc($getSpeciality)) {
            echo "2";
        } else {
            $saveSpeciality = $db->SUD("insert into speciality (speciality_name) values ('" . $_POST['speciality_name'] . "')");

            if ($saveSpeciality == "1") {
                echo "1";
            } else {
                echo "0";
            }
        }
    } else if ($_POST['action'] == 'updateSpeciality') {
        
        $updateSpeciality = $db->SUD("update speciality set speciality_name = '" . $_POST['speciality_name'] . "' where idspeciality = '" . $_POST['speciality_id'] . "'");

        if ($updateSpeciality == "1") {
            echo "1";
        } else {
            echo "0";
        }

    } else if ($_POST['action'] == 'deleteSpeciality') {
        $deleteSpeciality = $db->SUD("delete FROM speciality where idspeciality = '" . $_POST['speciality_id'] . "'");

        if ($deleteSpeciality == "1") {
            echo "1";
        } else {
            echo "0";
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

