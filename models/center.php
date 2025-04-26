<?php
include '../models/db.php'; // Ensure DB class is included

class Center
{
    private $db;

    public function __construct()
    {
        $this->db = new DB(); // Create an instance of DB
    }

    public function getAllCenters()
    {
        $center = [];
        $getAllCenters = $this->db->Search("SELECT * FROM centers ORDER BY cname ASC");

        //cid, cname, c_contact, cfee, c_status
        if (is_string($getAllCenters)) {
            return [];
        }

        while ($center_results = mysqli_fetch_assoc($getAllCenters)) {
            $center[] = [
                "cid" => $center_results["cid"],
                "cname" => $center_results["cname"],
                "c_contact" => $center_results["c_contact"],
                "cfee" => $center_results["cfee"]

            ];
        }

        return $center;
    }

    // public function getSpecialityByName($spec_name)
    // {
    //     $speciality = [];
    //     $getAllSpeciality = $this->db->Search("SELECT * FROM speciality where lower(speciality_name) = lower('" . $spec_name . "')");


    //     if (is_string($getAllSpeciality)) {
    //         return [];
    //     }

    //     while ($speciality_results = mysqli_fetch_assoc($getAllSpeciality)) {
    //         $speciality[] = [
    //             "spID" => $speciality_results["idspeciality"],
    //             "name" => $speciality_results["speciality_name"]
    //         ];
    //     }

    //     return $speciality;
    // }

    public function saveSpeciality($spec_name)
    {
        $getSpeciality = $this->db->Search("SELECT idspeciality FROM speciality where lower(speciality_name) = lower('" . $spec_name . "')");

        if ($speciality_results = mysqli_fetch_assoc($getSpeciality)) {
            return "2";
        } else {
            $saveSpeciality = $this->db->SUD("insert into speciality (speciality_name) values ('" . $spec_name . "')");

            if ($saveSpeciality == "1") {
                return "1";
            } else {
                return "0";
            }
        }
    }


    // public function updateSpecialityByID($spid, $spname)
    // {
    //     $updateSpeciality = $this->db->SUD("update speciality set speciality_name = '" . $spname . "' where idspeciality = '" . $spid . "'");

    //     if ($updateSpeciality == "1") {
    //         return "1";
    //     } else {
    //         return "0";
    //     }
    // }

    // public function deleteSpecialityByID($spid)
    // {
    //     $deleteSpeciality = $this->db->SUD("delete FROM speciality where idspeciality = '" . $spid . "'");

    //     if ($deleteSpeciality == "1") {
    //         return "1";
    //     } else {
    //         return "0";
    //     }
    // }
}
