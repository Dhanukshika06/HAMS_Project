<?php
session_start();
include '../models/db.php';
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] == 'getAllDoctors') {
        $doctorsList = "";

        $query = "SELECT d.*, s.speciality_name, centers.cname AS center_name 
          FROM doctor d 
          LEFT JOIN speciality s ON d.spec_id = s.idspeciality 
          LEFT JOIN centers ON d.cid = centers.cid 
          ORDER BY d.docid ASC";


        $getAllDoctors = $db->Search($query);

        while ($doctor_results = mysqli_fetch_assoc($getAllDoctors)) {
            if ($doctor_results['dstatus'] == 1) { 
                $doctorsList .= "<tr>";
                $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['docid'] . "</td>";
                $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['title'] . " " . $doctor_results['dname'] . "</td>";
                $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['speciality_name'] . "</td>";
                $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['dcontact'] . "</td>";
                $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['docfee'] . "</td>";
                $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['center_name'] . "</td>";
                $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['spec_note'] . "</td>";
                $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['patient_count'] . "</td>";
                $doctorsList .= "<td style=\"font-size: large;\">
              <button class='btn btn-primary btn-md' onclick='loadDoctor(" . $doctor_results['docid'] . ", \"" . $doctor_results['title'] . "\", \"" . $doctor_results['dname'] . "\", " . $doctor_results['spec_id'] . ", \"" . $doctor_results['dcontact'] . "\", \"" . $doctor_results['docfee'] . "\", \"" . $doctor_results['spec_note'] . "\", " . $doctor_results['cid'] . ", " . $doctor_results['patient_count'] . ")'>Edit</button>
                <button class='btn btn-danger btn-md' onclick='deleteDoctor(" . $doctor_results['docid'] . ")'>Delete</button>
            </td>";
                $doctorsList .= "</tr>";
            }
        }

        echo $doctorsList;
    }
    elseif ($_GET['action'] == 'searchDoctors') {
        $doctorsList = "";
    
        $query = "SELECT d.*, s.speciality_name, centers.cname AS center_name 
                  FROM doctor d 
                  LEFT JOIN speciality s ON d.spec_id = s.idspeciality 
                  LEFT JOIN centers ON d.cid = centers.cid 
                  WHERE d.dstatus = 1";
    
        $conditions = [];
    
        if (!empty($_GET['doctorId'])) {
            $conditions[] = "d.docid = " . intval($_GET['doctorId']);
        }
    
        if (!empty($_GET['specialityId'])) {
            $conditions[] = "d.spec_id = " . intval($_GET['specialityId']);
        }
    
        if (!empty($_GET['contact'])) {
            $contact = mysqli_real_escape_string($db->conn, $_GET['contact']);
            $conditions[] = "d.dcontact LIKE '%" . $contact . "%'";
        }
    
        if (!empty($conditions)) {
            $query .= " AND " . implode(" AND ", $conditions);
        }
    
        $query .= " ORDER BY d.dname ASC";
    
        $getAllDoctors = $db->Search($query);
    
        while ($doctor_results = mysqli_fetch_assoc($getAllDoctors)) {
            $doctorsList .= "<tr>";
            $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['docid'] . "</td>";
            $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['title'] . " " . $doctor_results['dname'] . "</td>";
            $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['speciality_name'] . "</td>";
            $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['dcontact'] . "</td>";
            $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['docfee'] . "</td>";
            $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['center_name'] . "</td>";
            $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['spec_note'] . "</td>";
            $doctorsList .= "<td style=\"font-size: large;\">" . $doctor_results['patient_count'] . "</td>";
            $doctorsList .= "<td style=\"font-size: large;\">
                <button class='btn btn-primary btn-md' onclick='loadDoctor(" . $doctor_results['docid'] . ", \"" . addslashes($doctor_results['title']) . "\", \"" . addslashes($doctor_results['dname']) . "\", " . $doctor_results['spec_id'] . ", \"" . $doctor_results['dcontact'] . "\", \"" . $doctor_results['docfee'] . "\", \"" . addslashes($doctor_results['spec_note']) . "\", " . $doctor_results['cid'] . ", " . $doctor_results['patient_count'] . ")'>Edit</button>
                <button class='btn btn-danger btn-md' onclick='deleteDoctor(" . $doctor_results['docid'] . ")'>Delete</button>
            </td>";
            $doctorsList .= "</tr>";
        }
    
        echo $doctorsList;
    }
    
}



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'saveDoctor') {
        $getDoctors = $db->Search("SELECT docid FROM doctor where lower(dname) = lower('" . $_POST['name'] . "')");

        if ($doctor_results = mysqli_fetch_assoc($getDoctors)) {
            echo "2";
        } else {
            
            $saveDoctor = $db->SUD("insert INTO doctor (dname, title, spec_id, dcontact, docfee, spec_note, dstatus, cid, patient_count, doc_user_name, password) 
                      VALUES ('" . $_POST['name'] . "', 
                              '" . $_POST['title'] . "', 
                              '" . $_POST['speciality'] . "', 
                              '" . $_POST['contact'] . "', 
                              '" . $_POST['fee'] . "', 
                              '" . $_POST['special_note'] . "', 
                              '1', 
                              '" . $_POST['center'] . "',
                              '" . $_POST['patient_count'] . "',
                              '" . $_POST['doc_user_name'] . "',
                              '" . $_POST['password'] . "')");

            if ($saveDoctor == "1") {
                echo "1";
            } else {
                echo "0";
            }
        }
    } else if ($_POST['action'] == 'updateDoctor') {

        $getDoctor = $db->Search("SELECT docid FROM doctor WHERE lower(dname) = lower('" . $_POST['name'] . "') AND docid != '" . $_POST['doctor_id'] . "'");

        if ($doctor_results = mysqli_fetch_assoc($getDoctor)) {
            echo "2";  
        } else {

            $updateDoctor = $db->SUD("UPDATE doctor 
                                  SET dname = '" . $_POST['name'] . "', 
                                      title = '" . $_POST['title'] . "', 
                                      spec_id = '" . $_POST['speciality'] . "', 
                                      dcontact = '" . $_POST['contact'] . "', 
                                      docfee = '" . $_POST['fee'] . "', 
                                      spec_note = '" . $_POST['special_note'] . "', 
                                      dstatus = '1', 
                                      cid = '" . $_POST['center'] . "' ,
                                        patient_count = '" . $_POST['patient_count'] . "'
                                  WHERE docid = '" . $_POST['doctor_id'] . "'");

            if ($updateDoctor == "1") {
                echo "1";  
            } else {
                echo "0";  
            }
        }
    } else if ($_POST['action'] == 'deleteDoctor') {
        $deleteDoctor = $db->SUD("DELETE FROM doctor WHERE docid = '" . $_POST['doctor_id'] . "'");
        if ($deleteDoctor == "1") {
            echo "1";  
        } else {
            echo "0";  
        }
    }
}

