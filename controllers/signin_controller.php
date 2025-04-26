<?php
session_start();
include '../models/db.php';
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {

    if ($_GET['action'] == 'signIn') {

        if ($_GET['uname'] == "admin" && $_GET['password'] == "axadmin") {
            $_SESSION["user_ID"] = "011";
            echo "011";
        }else{
            $res_checkUser = $db->Search("SELECT docid FROM doctor WHERE doc_user_name = '" . $_GET['uname'] . "' and password = '". $_GET['password'] ."'");
            if ($result_user = mysqli_fetch_assoc($res_checkUser)) {
               $_SESSION["user_ID"] = $result_user["docid"];
               echo "1";
            }else{
               echo "0";
            }
        }
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


