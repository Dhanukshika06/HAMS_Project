<?php
session_start();
error_reporting(0);
include '../config/database.php';
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['request'])) {
    if ($_GET['request'] == 'signIn') {
        $res_checkUser = $db->Search("SELECT uid FROM user WHERE email = '" . encryptData($_GET["email"]) . "' and password = '". encryptData($_GET["password"]) ."'");
        if ($result_user = mysqli_fetch_assoc($res_checkUser)) {
           $_SESSION["userID"] = $result_user["uid"];
           echo "1";
        }else{
           echo "0";
        }
    }else if ($_POST['request'] == 'forget') {

        $res_checkUser = $db->Search("SELECT uid FROM user WHERE email = '" . encryptData($_GET["email"]) . "'");
        if ($result_user = mysqli_fetch_assoc($res_checkUser)) {
           echo $result_user["uid"];
        }else{
            echo "no";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request'])) {
    if ($_POST['request'] == 'signup') {
        $res_checkUser = $db->Search("SELECT uid FROM user WHERE nic = '" . encryptData($_POST["nic"]) . "'");
        if ($result_user = mysqli_fetch_assoc($res_checkUser)) {
           echo "2";
        }else{
            $saveUser = $db->SUD("insert into user(name, nic, mobile, password, email) values ('" . encryptData($_POST["name"]) . "','".encryptData($_POST["nic"])."','".encryptData($_POST["mobile"])."','".encryptData($_POST["password"])."','".encryptData($_POST["email"])."')");
        
            if ($saveUser == 1) 
            {
                echo "1";
            }
            else
            {
                echo "0";
            }
        }
    }else if ($_POST['request'] == 'reset') {
        $updateUser = $db->SUD("update user set password = '".encryptData($_POST["password"])."' where uid = '".$_POST["userID"]."'");
        if ($updateUser == 1) 
        {
            echo "1";
        }
        else
        {
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

?>