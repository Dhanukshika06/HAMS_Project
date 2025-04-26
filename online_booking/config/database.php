<?php

class DB {
    private static $Connection = null;

    
    public static function getConnection() {
        if (!isset(self::$Connection)) {
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpass = "root";
            $dbname = "hams_dashboard";

            self::$Connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

          
            if (self::$Connection->connect_error) {
                die("Database Connection Failed: " . self::$Connection->connect_error);
            }
        }
        return self::$Connection;
    }

    
    public function SUD($query) {
        $db = self::getConnection();
        if ($db->query($query) === TRUE) {
            return "1"; 
        } else {
            return $db->error; 
        }
    }

   
    public function SUDwithKeys($query) {
        $db = self::getConnection();
        if ($db->query($query) === TRUE) {
            return $db->insert_id; 
        } else {
            return "0"; 
        }
    }

    
    public function Search($query) {
        $db = self::getConnection();
        $res = $db->query($query);
        if (!$res) {
            return $db->error; 
        } else {
            return $res; 
        }
    }

   
    public static function closeConnection() {
        if (isset(self::$Connection)) {
            self::$Connection->close();
            self::$Connection = null;
        }
    }
}

?>
