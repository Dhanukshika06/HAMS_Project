<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    <img src="../../dist/images/faces/face5.png" alt="image" />
                </div>
                <div class="profile-name">
                    <p class="name">
                        Welcome

                        <?php
                            if ($_SESSION["user_ID"] == "011") {
                                echo "Super Admin";
                            }else{
                                $query = "select dname from doctor where docid = '" . $_SESSION["user_ID"] . "'";
                                $res = $db->Search($query);
                                if ($result = mysqli_fetch_assoc($res)) {
                                    echo $result["dname"];
                                } else {
                                    echo "Please Login!";
                                } 
                            } 
                        ?>
                    </p>
                    <p class="designation">
                        <?php
                            if ($_SESSION["user_ID"] == "011") {
                                echo "System Admin";
                            }else{
                                $query = "select dname from doctor where docid = '" . $_SESSION["user_ID"] . "'";
                                $res = $db->Search($query);
                                if ($result = mysqli_fetch_assoc($res)) {
                                    echo "Doctor";
                                } else {
                                    echo "";
                                } 
                            } 
                        ?>
                    </p>
                </div>
            </div>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" href="../../index.php">
                <i class="fa fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li> -->

        <?php
            $privs = array();
            $query = "select fid from privilages where uid = '" . $_SESSION["user_ID"] . "'";
            $res = $db->Search($query);
            while ($result = mysqli_fetch_assoc($res)) {
                array_push($privs, $result["fid"]);
            }
        ?>

        
        <?php
            if ($_SESSION["user_ID"] == "011") 
            {?>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#editors_admin" aria-expanded="false" aria-controls="editors_admin">
                        <i class="fas fa-user-md menu-icon"></i>
                        <span class="menu-title" style="color:#b324f0">Admin</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="editors_admin">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="../../views/admin/admin_home.php" style="color:#c90ac6">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="../../views/doctor/doctor_registration.php"style="color:#c90ac6">Doctor Registration</a></li>
                            <li class="nav-item"><a class="nav-link" href="../../views/doctor/doctor_availability.php"style="color:#c90ac6">Doctor Availability</a></li>
                            <li class="nav-item"><a class="nav-link" href="../../views/doctor/doctor_appintment_management.php"style="color:#c90ac6">Appointment Management</a></li>
                            <li class="nav-item"><a class="nav-link" href="../../views/doctor/doctor_speciality.php"style="color:#c90ac6">Manage Center & Speciality </a></li>
                            <!-- <li class="nav-item"><a class="nav-link" href="../../views/admin/privilages.php">Manage Privileges</a></li> -->
                        </ul>
                    </div>
                </li><?php
            }
            else
            {?>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#editors" aria-expanded="false" aria-controls="editors">
                        <i class="fas fa-user-md menu-icon"></i>
                        <span class="menu-title">Doctor</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="editors">
                        <ul class="nav flex-column sub-menu">
                            <!-- <li class="nav-item"><a class="nav-link" href="views/doctor/doctor_registration.php">Doctor Registration</a></li>
                            <li class="nav-item"><a class="nav-link" href="views/doctor/doctor_management.php">Doctor Management</a></li> -->
                            <li class="nav-item"><a class="nav-link" href="../../views/doctor/doctor_home.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="../../views/doctor/doctor_appintment_management.php">Appointment Management</a></li>
                            <li class="nav-item"><a class="nav-link" href="../../views/doctor/doctor_availability.php">Doctor Availability</a></li>
                        </ul>
                    </div>
                </li><?php 
            } 
        ?>




        

        

        <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#privilegeMenu" aria-expanded="false" aria-controls="privilegeMenu">
                <i class="fas fa-user-cog menu-icon"></i>
                <span class="menu-title">Privilege Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="privilegeMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="../../views/admin/privilages.php">Manage Privileges</a></li>
                </ul>
            </div>
        </li> -->
    </ul>
</nav>