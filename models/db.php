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


// class DB {
//     private static $Connection = null;
    
//     public function getConnection() {
//         if (!isset(DB::$Connection)) {
//             $dbhost = "localhost";
//             $dbuser = "root";
//             $dbpass = "root";
//             $dbname = "hams_dashboard";
//             DB::$Connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//             return DB::$Connection;
//         } else {
//             return DB::$Connection;
//         }

//         if (mysqli_connect_errno()) {
//             echo ("Database Connectin failed : " . mysqli_connect_error() . "( " . mysqli_connect_errno() . " )");
//         }
//     }

//     public function SUD($query)
//     {
//         $db = new DB();
//         mysqli_query($db->getConnection(), $query);
//         if (mysqli_errno($db->getConnection())) {
//             return mysqli_error($db->getConnection());
//         } else {
//             return "1";
//         }
//     }

//     public function SUDwithKeys($query)
//     {
//         $db = new DB();
//         mysqli_query($db->getConnection(), $query);
//         if (mysqli_errno($db->getConnection())) {
//             // return mysqli_error($DB->getConnection());
//             return "0";
//         } else {
//             return mysqli_insert_id($db->getConnection());
//         }
//     }

//     public function Search($query)
//     {
//         $db = new DB();
//         $res = mysqli_query($db->getConnection(), $query);
//         if (mysqli_errno($db->getConnection())) {
//             return mysqli_connect_error();
//         } else {
//             return $res;
//         }
//     }
   

//     public function closeConnection()
//     {
//         mysqli_close(DB::$Connection);
//     }
// }




?>