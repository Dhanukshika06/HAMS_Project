<?php
session_start();
include '../models/db.php';

$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {

    if ($_GET['action'] == 'getAllCenters') {
        $centersList = "";

        $getAllCenters = $db->Search("SELECT * FROM centers ORDER BY cname ASC");

        while ($center_results = mysqli_fetch_assoc($getAllCenters)) {

            if ($center_results['c_status'] == 1) {
                $centersList .= "<tr>";
                $centersList .= "<td style=\"font-size: large;\">" . $center_results['cname'] . "</td>";
                $centersList .= "<td style=\"font-size: large;\">" . $center_results['c_contact'] . "</td>";
                $centersList .= "<td style=\"font-size: large;\">" . $center_results['cfee'] . "</td>";
                $centersList .= "<td style=\"font-size: large;\">
                <button class='btn btn-primary btn-md' onclick='loadCenter(" . $center_results['cid'] . ", \"" . $center_results['cname'] . "\", \"" . $center_results['c_contact'] . "\", \"" . $center_results['cfee'] . "\")'>Edit</button>
               <button class='btn btn-danger btn-md' onclick='deleteCenter(" . $center_results['cid'] . ")'>Delete</button>
            </td>";
                $centersList .= "</tr>";
            }
            
        }
        echo $centersList;
    }else if ($_GET['action'] == 'getAllSpeciality') {
        $specialityList = "";

        $getAllSpeciality = $db->Search("SELECT * FROM speciality ORDER BY speciality_name ASC");

        while ($speciality_results = mysqli_fetch_assoc($getAllSpeciality)) {
            $specialityList .= "<tr>";
            $specialityList .= "<td style=\"font-size: large;\">" . $speciality_results['speciality_name'] . "</td>";
            $specialityList .= "<td style=\"font-size: large;\">
                <button class='btn btn-primary btn-md' onclick='loadSpeciality(" . $speciality_results['idspeciality'] . ", \"" . $speciality_results['speciality_name'] . "\")'>Edit</button>
                <button class='btn btn-danger btn-md' onclick='deleteSpeciality(" . $speciality_results['idspeciality'] . ")'>Delete</button>
            </td>";
            $specialityList .= "</tr>";
        }

        echo $specialityList;
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] == 'saveCenter') {

        $getCenter = $db->Search("SELECT cid FROM centers WHERE LOWER(cname) = LOWER('" . $_POST['center_name'] . "')");

        if ($center_results = mysqli_fetch_assoc($getCenter)) {
            echo "2"; 
        } else {
            $saveCenter = $db->SUD("INSERT INTO centers (cname, c_contact, cfee, c_status) 
                                    VALUES ('" . $_POST['center_name'] . "', 
                                            '" . $_POST['center_contact'] . "', 
                                            '" . $_POST['center_fee'] . "', 
                                            '1')");

            if ($saveCenter == "1") {
                echo "1"; 
            } else {
                echo "0"; 
            }
        }
    } else if ($_POST['action'] == 'updateCenter') {

        $updateCenter = $db->SUD("UPDATE centers 
                              SET cname = '" . $_POST['center_name'] . "', 
                                  c_contact = '" . $_POST['center_contact'] . "', 
                                  cfee = '" . $_POST['center_fee'] . "' 
                              WHERE cid = '" . $_POST['center_id'] . "'");

        if ($updateCenter == "1") {
            echo "1";
        } else {
            echo "0";
        }
    } else if ($_POST['action'] == 'deleteCenter') {
        $deleteCenter = $db->SUD("DELETE FROM centers WHERE cid = '" . $_POST['center_id'] . "'");

        if ($deleteCenter == "1") {
            echo "1";
        } else {
            echo "0";
        }
    }
}
