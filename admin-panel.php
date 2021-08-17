<?php include("./apis/api.php"); ?>
<?php 
    if(isset($_SESSION['admin-panel-login-auth'])){
        //
    }else{
        header('location: admin-login.php');
    }
?>
<?php 
    //Selecting Stops Data from Database
    $sql = "SELECT * from stops";
    $res = mysqli_query($con, $sql);
    $json_array = array();
    while($row = mysqli_fetch_assoc($res)){
        $json_array[] = 'Stop # '.$row['stop_number'].' Of Route # '.(int)$row['route_registered'];
        $json_array[] = (float)$row['lat'];
        $json_array[] = (float)$row['lng'];
        $json_array[] = './img/bus_icons/'.$row['icon'];
        $json_array[] = (int)$row['route_registered'];
    }
    $json = json_encode($json_array);
?>
<?php

    //Paging Configration
    $limit = 12;
    if (isset($_GET["page"])) {  
        $pn  = $_GET["page"];  
    }else {  
        $pn=1;  
    };  
    $start_from = ($pn-1) * $limit; 
?>

<?php 
    if(isset($_POST['logout'])){
        unset($_SESSION['admin-panel-login-auth']);
        header('location: admin-login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUohs9NPW_czz-fJUYObeLEmHhuUyUMmo&callback=initMap&libraries=&v=weekly" defer></script>
    <script src="https://kit.fontawesome.com/6d5ca9b667.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500;900&display=swap" rel="stylesheet">
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.3/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.3/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.3/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.3/firebase-firestore.js"></script>
    <link rel="stylesheet" href="./css/admin.css">
    <script src="./js/firebase.js"></script>
    <meta name="author" content="Muhammad Ahmer Tahir, iLoBBer">
    <link rel="shortcut icon" href="./img/bus_logo.png">
    <title>Bus Tracking - Admin Panel</title>
</head>
<style>
    .box-select {
        font-family: 'Poppins', sans-serif;
        font-weight: 100;
        background-color: #424146;
        color: #afafaf;
        padding: 8px 12px;
        width: 100%;
        border: none;
        font-size: 15px;
        appearance: button;
        outline: none;
        margin-bottom: 10px;
        border-radius: 50px;
    }
    .box-select-2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 100;
        background-color: #e6e6e6;
        box-shadow: 0px 5px 5px rgba(0,0,0,0.2);
        color: #4e5059;
        padding: 5px 12px;
        width: 20%;
        border: none;
        font-size: 15px;
        appearance: button;
        outline: none;
        margin-bottom: 10px;
        border-radius: 50px;
    }
    .maps{
        margin-bottom: 5px;
    }

    .point-up {
        background-color: #239248;
        color: white;
        padding: 5px 10px;
        font-weight: 500;
        border-radius: 6px;
        border: none;
    }
</style>
<body>
    <!-------->
    <form action="admin-panel.php" method="POST">
        <button type="submit" name="logout" id='logout'><i class="fas fa-door"></i>Logout</button>
    </form>

    <!-------->
    <div class="body">
        <div class="body-1">
            <img class="bus" src="./img/bus.png">
            <p>nfc iet bus tracking</p>
            <ul>
                <button class="tablink" onclick="openCity('s1', this, '#606a75')" id="defaultOpen"><i class="fas fa-users-cog"></i>Dashboard</button>
                <button class="tablink" onclick="openCity('s2', this, '#606a75')"><i class="fas fa-bus"></i>Bus-Stop Setting</button>
                <button class="tablink" onclick="openCity('s7', this, '#606a75')"><i class="fas fa-map"></i>Maps</button>
                <button class="tablink" onclick="openCity('s3', this, '#606a75')"><i class="fas fa-user"></i>Students List</button>
                <button class="tablink" onclick="openCity('s4', this, '#606a75')"><i class="fas fa-plane"></i>Driver Settings</button>
                <button class="tablink" onclick="openCity('s5', this, '#606a75')"><i class="fas fa-book"></i>Contacts</button>
                <button class="tablink" onclick="openCity('s6', this, '#606a75')"><i class="fas fa-exclamation-circle"></i>Issues Report</button>
                <button class="tablink" onclick="openCity('s8', this, '#606a75')"><i class="fas fa-envelope"></i>Emails</button>
            </ul>
            <ul>
                <h1 class="title-1">Admin</h1>
                <h1 class="title-2">Panel</h1>
            </ul>
        </div>

        <div class="body-2">

            <!----Dashboard Section----->
            <div id="s1" class="section tabcontent">
                <h1 class="title">Dashboard</h1>
                <div class="dash-box-grid">
                    <div class="dash-box">
                        <i class="fas fa-user"></i>
                        <h3>Users</h3>
                        <p><span><?php $sql = "SELECT * from students";
                                        $res = mysqli_query($con, $sql);
                                        echo (mysqli_num_rows($res));  ?></span> Students Registered</p>
                    </div>

                    <div class="dash-box">
                        <i class="fa fa-drivers-license"></i>
                        <h3>Drivers</h3>
                        <p><span><?php $sql = "SELECT * from drivers";
                                        $res = mysqli_query($con, $sql);
                                        echo (mysqli_num_rows($res));  ?></span> Drivers Registered</p>
                    </div>

                    <div class="dash-box">
                        <i class="fas fa-book"></i>
                        <h3>Contacts</h3>
                        <p><span><?php $sql = "SELECT * from contacts";
                                        $res = mysqli_query($con, $sql);
                                        echo (mysqli_num_rows($res));  ?></span> Users Contacted</p>
                    </div>

                    <div class="dash-box">
                        <i class="fas fa-exclamation-circle"></i>
                        <h3>Issues</h3>
                        <p><span><?php $sql = "SELECT * from reports";
                                        $res = mysqli_query($con, $sql);
                                        echo (mysqli_num_rows($res));  ?></span> Issues Reported</p>
                    </div>

                    <div class="dash-box">
                        <i class="fas fa-route"></i>
                        <h3>Routes</h3>
                        <p><span><?php $sql = "SELECT * from routes";
                                        $res = mysqli_query($con, $sql);
                                        echo (mysqli_num_rows($res));  ?></span> Routes Registered</p>
                    </div>

                    <div class="dash-box">
                        <i class="fas fa-hand-paper"></i>
                        <h3>Stops</h3>
                        <p><span><?php $sql = "SELECT * from stops";
                                        $res = mysqli_query($con, $sql);
                                        echo (mysqli_num_rows($res));  ?></span> Stops Registered</p>
                    </div>

                    <div class="dash-box">
                        <i class="fas fa-envelope"></i>
                        <h3>Emails</h3>
                        <p><span><?php $sql = "SELECT * from email";
                                        $res = mysqli_query($con, $sql);
                                        echo (mysqli_num_rows($res));  ?></span> Emails Has Sent</p>
                    </div>

                    <div class="dash-box">
                        <i class="fas fa-at"></i>
                        <h3>Admins</h3>
                        <p><span><?php $sql = "SELECT * from admin_register";
                                        $res = mysqli_query($con, $sql);
                                        echo (mysqli_num_rows($res));  ?></span> Admins Registered</p>
                    </div>

                    <div class="dash-box">
                        <h3>Code Generator</h3>
                        <form class="form" action="admin-panel.php" method="POST">
                            <?php if(isset($_POST['generate-code'])){
                                if($errors){
                                    include('./apis/errors.php');
                                    }
                                } 
                            ?>
                            <input type="text" name="code" placeholder="Enter Text To Encode.!" autocomplete="off" required>
                            <button type="submit" name="generate-code">Generate</button>
                            <?php 
                                if(isset($_POST['generate-code'])){
                                    if(isset($success)){
                                    echo $success;
                                    }
                                } 
                            ?>
                        </form>
                    </div>

                    <div class="dash-box">
                        <h3>Admin SignUp Code</h3>
                        <form class="form" action="admin-panel.php" method="POST">
                            <?php if(isset($_POST['admin-code'])){
                                if($errors){
                                    include('./apis/errors.php');
                                    }
                                } 
                            ?>
                            <input type="password" name="main_code" placeholder="Administrator Code" autocomplete="off" required>
                            <input type="password" name="g_code" placeholder="Generated Code"  autocomplete="off"required>
                            <button type="submit" name="admin-code">Upload Admin Code</button>
                            <?php 
                                if(isset($_POST['admin-code'])){
                                    if(isset($success)){
                                    echo $success;
                                    }
                                } 
                            ?>
                        </form>
                    </div>
                </div>
            </div>


            <!----Bus / Route Settings----->
            <div id="s2" class="section tabcontent">
                <h1 class="title">Route Settings</h1>
                <?php 
                    if(isset($_POST['delete-route'])){
                        if(isset($success)){
                            echo $success;
                        }else if($errors){
                            include('./apis/errors.php');
                        }
                    } 
                ?>
                <div class="flex-sec">
                    <div class="table">
                        <table>
                            <tr>
                                <th>Stop Number</th>
                                <th>Icon</th>
                                <th>Route Number</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Added_At</th>
                                <th>Delete</th>
                                <th>Update</th>
                            </tr>
                            <?php 
                                require "./apis/init.php";
                                $sql = "SELECT * from stops ORDER BY route_registered DESC LIMIT $start_from, $limit ";
                                $res = mysqli_query($con, $sql);
                                if(mysqli_num_rows($res) >= 1){
                                    while($row = mysqli_fetch_assoc($res)){
                                        $id = $row['id'];
                                        $number = $row['stop_number'];
                                        $route = $row['route_registered'];
                                        $lat = $row['lat'];
                                        $lng = $row['lng'];
                                        $img = './img/bus_icons/'.$row['icon'];
                                        $date= $row['created_at'];
                                        echo" 
                                        <tr>
                                            <td>Stop # $number</td>
                                            <td><img src=$img style='width: 18px;'></img></td>
                                            <td>Route # $route</td>
                                            <td>$lat</td>
                                            <td>$lng</td>
                                            <td>$date</td>
                                            <td><form action='admin-panel.php' method='POST'><input name='stop' value='$number' type='hidden' /><input name='route' value='$route' type='hidden' /><button class='delete' type='submit' name='delete-stop' value='$id'>Delete</button></form></td>
                                            <td><a class='point-up' href='update-data.php?point-update-id=$id'>Update</a></td>
                                        </tr>";
                                    }
                                }else{
                                    echo "<tr>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                        </tr>
                                    ";
                                }
                            ?>

                        </table>
                        <div class="paging">
                            <ul>
                                <?php   
                                    $sql = "SELECT COUNT(*) FROM stops";   
                                    $rs_result = mysqli_query($con, $sql);   
                                    $row = mysqli_fetch_row($rs_result);   
                                    $total_records = $row[0];   
                                    
                                    // Number of pages required. 
                                    $total_pages = ceil($total_records / $limit);   
                                    $pagLink = "";                         
                                    for ($i=1; $i<=$total_pages; $i++) { 
                                    if ($i==$pn) { 
                                        $pagLink .= "<a class='active' href='admin-panel.php?page=".$i."'>".$i."</a>"; 
                                    }             
                                    else  { 
                                        $pagLink .= "<a href='admin-panel.php?page=".$i."'>".$i."</a>";   
                                    } 
                                    };   
                                    echo $pagLink;   
                                ?> 
                            </ul>
                            
                        </div>
                    </div>

                    <div class="box-2" style='overflow: vertical; width: 22%;'>
                        <form action="admin-panel.php" method="POST" style='margin-bottom: 20px'>
                            <div class="details">
                                <i class="fas fa-envelope"></i>
                                <h2>Add Stop</h2>
                            </div>
                            <?php 
                                if(isset($_POST['add-stop'])){
                                    if(isset($errors)){
                                        include('./apis/errors.php');
                                    }
                                } 
                            ?>
                            <input type="number" name="number" min="1" placeholder="Stop Number" autocomplete="off" >
                            <input type="text" name="lat" id="lat" placeholder="Latitude" autocomplete="off">
                            <input type="text" name="lng" id="lng" placeholder="Longitude" autocomplete="off">
                            <select class='box-select' name='route'>
                            <?php 
                                $sql = "SELECT * from routes ORDER BY route_number";
                                $res = mysqli_query($con, $sql);
                                while($row = mysqli_fetch_assoc($res)){
                                    $route = $row['route_number'];
                                    echo "<option value=$route>Route # $route</option>";
                                }
                            ?>
                            </select>
                            <button type="submit" name="add-stop">Add Stop</button>
                            <?php 
                                if(isset($_POST['add-stop'])){
                                    if(isset($success)){
                                        echo $success;
                                    }
                                } 
                            ?>
                        </form>

                        <form action="admin-panel.php" method="POST" enctype="multipart/form-data">
                            <div class="details">
                                <h2 style="margin-bottom: 20px;">Add Route</h2>
                                <a href="routes.php" class="view-routes">View Routes</a>
                            </div>
                            <?php if(isset($_POST['add-route'])){
                                if($errors){
                                    include('./apis/errors.php');
                                    }
                                } 
                            ?>
                            <input type="number" name="route_number" min="1" placeholder="Route Number" autocomplete="off" >
                            <input type="number" name="tracker" min="1" placeholder="Tracker" autocomplete="off" >
                            <select name="driver" class='box-select'>
                                <?php 
                                    $sql = "SELECT * from drivers";
                                    $res = mysqli_query($con, $sql);
                                    while($row = mysqli_fetch_assoc($res)){
                                        $name = $row['name'];
                                        echo "<option value=$name>$name</option>";
                                    }
                                ?>
                            </select>
                            <input type="file" name="route_icon">
                            <button type="submit" name="add-route">Add Route</button>
                            
                            <?php 
                                if(isset($_POST['add-route'])){
                                    if(isset($success)){
                                        echo $success;
                                    }
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>


            <!----Google Maps Section----->
            <div id="s7" class="section tabcontent">
                <h1 class="title" style='margin-bottom: 5px;'>Google Maps</h1>
                <div id="map" class='maps'></div>
                <div class="form">
                    <select name="select" class='box-select-2' id="root" onchange="initMap()">
                    <option value="0">All Routes</option>
                    <?php 
                        $sql = "SELECT * from routes ORDER BY route_number";
                        $res = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_assoc($res)){
                            $route = $row['route_number'];
                            echo "<option value=$route>Route # $route</option>";
                        }
                    ?>
                    </select>
                </div>
            </div>


            <!----Students List Section----->
            <div id="s3" class="section tabcontent">
                <h1 class="title">Students List</h1>
                <div class="student-form">
                    <?php 
                        if(isset($_POST['add_student'])){
                            if($errors){
                                include('./apis/errors.php');
                            }
                        } 
                    ?>
                    <form action="admin-panel.php" method="POST">
                        <input type="email" name="email" placeholder="Enter Student's Email">
                        <input type="text" name="rollnumber" placeholder="Enter Roll Number (2K16BSCS201)">
                        <input type="password" name="password" placeholder="Enter Password">
                        <button type="submit" name="add_student">Submit</button>
                    </form>
                </div>
                <div class="table">
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Email</th>
                            <th>Roll Number</th>
                            <th>Created_At</th>
                            <th>Verify_Status</th>
                            <th>LastLogin</th>
                        </tr>

                        <?php 
                                require "./apis/init.php";
                                $sql = "SELECT * from students ORDER BY id DESC";
                                $res = mysqli_query($con, $sql);
                                if(mysqli_num_rows($res) >= 1){
                                    while($row = mysqli_fetch_assoc($res)){
                                        $id = $row['id'];
                                        $email = $row['email'];
                                        $last = $row['lastLogin'];
                                        $rollnumber = $row['rollnumber'];
                                        $date= $row['created_at'];
                                        $status= $row['status'];
                                        echo" 
                                        <tr>
                                            <td>$id</td>
                                            <td>$email</td>
                                            <td>$rollnumber</td>
                                            <td>$date</td>
                                            <td>$status</td>
                                            <td>$last</td>                             
                                        </tr>";
                                    }
                                }else{
                                    echo "<tr>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                        </tr>
                                    ";
                                }
                            ?>

                    </table>

                    <div class="paging">
                            <ul>
                                <?php   
                                    $sql = "SELECT COUNT(*) FROM students";   
                                    $rs_result = mysqli_query($con, $sql);   
                                    $row = mysqli_fetch_row($rs_result);   
                                    $total_records = $row[0];   
                                    
                                    // Number of pages required. 
                                    $total_pages = ceil($total_records / $limit);   
                                    $pagLink = "";                         
                                    for ($i=1; $i<=$total_pages; $i++) { 
                                    if ($i==$pn) { 
                                        $pagLink .= "<a class='active' href='admin-panel.php?page=".$i."'>".$i."</a>"; 
                                    }             
                                    else  { 
                                        $pagLink .= "<a href='admin-panel.php?page=".$i."'>".$i."</a>";   
                                    } 
                                    };   
                                    echo $pagLink;   
                                ?> 
                            </ul>
                        </div>
                </div>
            </div>


            <!---Drivers Settings-->
            <div id="s4" class="section tabcontent">
                <h1 class="title">Driver Settings</h1>
                <?php 
                    if(isset($_POST['delete-route'])){
                        if(isset($success)){
                            echo $success;
                        }else if($errors){
                            include('./apis/errors.php');
                        }
                    } 
                ?>
                <div class="flex-sec">
                    <div class="table">
                        <table>
                            <tr>
                                <th>id</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>PhoneNumber</th>
                                <th>Created_AT</th>
                                <th>Updated_AT</th>
                                <th>Delete</th>
                                <th>Update</th>
                            </tr>
                            <?php 
                                require "./apis/init.php";
                                $sql = "SELECT * from drivers ORDER BY id DESC LIMIT $start_from, $limit ";
                                $res = mysqli_query($con, $sql);
                                if(mysqli_num_rows($res) >= 1){
                                    while($row = mysqli_fetch_assoc($res)){
                                        $id = $row['id'];
                                        $img = './img/drivers/'.$row['image'];
                                        $name = $row['name'];
                                        $phone = $row['phone_number'];
                                        $date= $row['created_at'];
                                        $update= $row['updated_at'];
                                        echo" 
                                        <tr>
                                            <td>$id</td>
                                            <td><img src=$img style='width: 50px; height: 50px; border-radius: 50px'></img></td>
                                            <td>$name</td>
                                            <td>0$phone</td>
                                            <td>$date</td>
                                            <td>$update</td>
                                            <td><form action='admin-panel.php' method='POST'><button class='delete' type='submit' name='delete-driver' value='$id'>Delete</button></form></td>                                 
                                            <td><a class='point-up' href='update-data.php?driver-update-id=$id'>Update</a></td>
                                        </tr>";
                                    }
                                }else{
                                    echo "<tr>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                        </tr>
                                    ";
                                }
                            ?>

                        </table>
                        <div class="paging">
                            <ul>
                                <?php   
                                    $sql = "SELECT COUNT(*) FROM drivers";   
                                    $rs_result = mysqli_query($con, $sql);   
                                    $row = mysqli_fetch_row($rs_result);   
                                    $total_records = $row[0];   
                                    
                                    // Number of pages required. 
                                    $total_pages = ceil($total_records / $limit);   
                                    $pagLink = "";                         
                                    for ($i=1; $i<=$total_pages; $i++) { 
                                    if ($i==$pn) { 
                                        $pagLink .= "<a class='active' href='admin-panel.php?page=".$i."'>".$i."</a>"; 
                                    }             
                                    else  { 
                                        $pagLink .= "<a href='admin-panel.php?page=".$i."'>".$i."</a>";   
                                    } 
                                    };   
                                    echo $pagLink;   
                                ?> 
                            </ul>
                        </div>
                    </div>

                    <div class="box-2" style='overflow: vertical; width: 22%;'>
                        <form action="admin-panel.php" method="POST" enctype="multipart/form-data" style='margin-bottom: 20px'>
                            <div class="details">
                                <img id="blah" src="./img/user.png" style='width: 150px; height: 150px; border-radius: 150px;' />
                                <h2>Add Driver</h2>
                            </div>
                            <?php if(isset($_POST['add-driver'])){
                                if($errors){
                                    include('./apis/errors.php');
                                    }
                                } 
                            ?>
                            <input type="text" name="name" placeholder="Driver Name" autocomplete="off" >
                            <input type="number" name="phone_number" placeholder="Phone Number" autocomplete="off">
                            <input type="file" name="driver_img" onchange="readURL(this);">
                            <button type="submit" name="add-driver">Add Driver</button>
                            <?php 
                                if(isset($_POST['add-driver'])){
                                    if(isset($success)){
                                    echo $success;
                                    }
                                } 
                            ?>
                        </form>
                    </div>
                </div>
            </div>

            <!----Contact Section----->
            <div id="s5" class="section tabcontent">
                <h1 class="title">Contacts</h1>
                <?php 
                    if(isset($_POST['delete-contact'])){
                        if(isset($success)){
                            echo $success;
                        }
                    } 
                ?>
                <?php if(isset($_POST['delete-contact'])){
                        if($errors){
                            include('./apis/errors.php');
                        }
                    } 
                ?>
                <div class="table">
                <table>
                        <tr>
                            <th>id</th>
                            <th>email</th>
                            <th>name</th>
                            <th>Issued At</th>
                            <th>Message</th>
                            <th>Delete</th>
                            <th>Read_More</th>
                        </tr>
                            <?php 
                                require "./apis/init.php";
                                $sql = "SELECT * from contacts ORDER BY id DESC LIMIT $start_from, $limit ";
                                $res = mysqli_query($con, $sql);
                                while($row = mysqli_fetch_assoc($res)){
                                    $id = $row['id'];
                                    $email = $row['email'];
                                    $msg = $row['message'];
                                    $msg = implode(' ', array_slice(explode(' ', $msg), 0, 5));
                                    $msg = $msg."...";
                                    $name = $row['fullname'];
                                    $date= $row['contacted_at'];
                                    echo" 
                                    <tr>
                                        <td>$id</td>
                                        <td>$email</td>
                                        <td>$name</td>
                                        <td>$date</td>
                                        <td>$msg</td>
                                        <td><form action='admin-panel.php' method='POST'><button class='delete' type='submit' name='delete-contact' value='$id'>Delete</button></form></td>                               
                                        <td><a class='readmore' href='read-more.php?contact-id=$id'>Read <i class='fas fa-caret-right'></i></a></td>
                                    </tr>";
                                }
                            ?>
                    </table>
                    <div class="paging">
                        <ul>
                            <?php   
                                $sql = "SELECT COUNT(*) FROM contacts";   
                                $rs_result = mysqli_query($con, $sql);   
                                $row = mysqli_fetch_row($rs_result);   
                                $total_records = $row[0];   
                                            
                                            // Number of pages required. 
                                $total_pages = ceil($total_records / $limit);   
                                $pagLink = "";                         
                                for ($i=1; $i<=$total_pages; $i++) { 
                                    if ($i==$pn) { 
                                        $pagLink .= "<a class='active' href='admin-panel.php?rep_page=".$i."'>".$i."</a>"; 
                                } else { 
                                        $pagLink .= "<a href='admin-panel.php?rep_page=".$i."'>".$i."</a>";   
                                    } 
                                };   
                                echo $pagLink;   
                            ?>
                        </ul>
                    </div>
                </div>
            </div>


            <!----Sent issue Report----->
            <div id="s6" class="section tabcontent">
                <h1 class="title">Issue Reports</h1>
                <?php 
                    if(isset($_POST['delete-report'])){
                        if(isset($success)){
                            echo $success;
                        }
                    } 
                ?>
                <?php if(isset($_POST['delete-report'])){
                        if($errors){
                            include('./apis/errors.php');
                        }
                    } 
                ?>
                <div class="table">
                    <table>
                        <tr>
                            <th>id</th>
                            <th>email</th>
                            <th>name</th>
                            <th>Issued At</th>
                            <th>Message</th>
                            <th>Delete</th>
                            <th>Read_More</th>
                        </tr>
                            <?php 
                                require "./apis/init.php";
                                $sql = "SELECT * from reports ORDER BY id DESC LIMIT $start_from, $limit ";
                                $res = mysqli_query($con, $sql);
                                while($row = mysqli_fetch_assoc($res)){
                                    $id = $row['id'];
                                    $email = $row['email'];
                                    $msg = $row['complain'];
                                    $msg = implode(' ', array_slice(explode(' ', $msg), 0, 5));
                                    $msg = $msg."...";
                                    $name = $row['fullname'];
                                    $date= $row['issued_at'];
                                    echo" 
                                    <tr>
                                        <td>$id</td>
                                        <td>$email</td>
                                        <td>$name</td>
                                        <td>$date</td>
                                        <td>$msg</td>
                                        <td><form action='admin-panel.php' method='POST'><button class='delete' type='submit' name='delete-report' value='$id'>Delete</button></form></td>                                
                                        <td><a class='readmore' href='read-more.php?report-id=$id'>Read <i class='fas fa-caret-right'></i></a></td>
                                    </tr>";
                                }
                            ?>
                    </table>
                    <div class="paging">
                        <ul>
                            <?php   
                                $sql = "SELECT COUNT(*) FROM reports";   
                                $rs_result = mysqli_query($con, $sql);   
                                $row = mysqli_fetch_row($rs_result);   
                                $total_records = $row[0];   
                                            
                                            // Number of pages required. 
                                $total_pages = ceil($total_records / $limit);   
                                $pagLink = "";                         
                                for ($i=1; $i<=$total_pages; $i++) { 
                                    if ($i==$pn) { 
                                        $pagLink .= "<a class='active' href='admin-panel.php?rep_page=".$i."'>".$i."</a>"; 
                                } else { 
                                        $pagLink .= "<a href='admin-panel.php?rep_page=".$i."'>".$i."</a>";   
                                    } 
                                };   
                                echo $pagLink;   
                            ?>
                        </ul>
                    </div>
                </div>
            </div>


            <!----Email Section----->
            <div id="s8" class="section tabcontent">
                <h1 class="title">Emails</h1>
                <?php 
                    if(isset($_POST['delete-email'])){
                        if(isset($success)){
                            echo $success;
                        }
                    } 
                ?>
                <?php if(isset($_POST['delete-email'])){
                        if($errors){
                            include('./apis/errors.php');
                        }
                    } 
                ?>
                <div class="flex-sec">
                    <div class="table">
                        <table>
                            <tr>
                                <th>id</th>
                                <th>email</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Message</th>
                                <th>Delete</th>
                                <th>Read_More</th>
                            </tr>
                            <?php 
                                require "./apis/init.php";
                                $sql = "SELECT * from email ORDER BY id DESC LIMIT $start_from, $limit ";
                                $res = mysqli_query($con, $sql);
                                if(mysqli_num_rows($res) >= 1){
                                    while($row = mysqli_fetch_assoc($res)){
                                        $id = $row['id'];
                                        $email = $row['to_email'];
                                        $msg = $row['msg'];
                                        $msg = implode(' ', array_slice(explode(' ', $msg), 0, 5));
                                        $msg = $msg."...";
                                        $sbj = $row['subject'];
                                        $date= $row['date'];
                                        echo" 
                                        <tr>
                                            <td>$id</td>
                                            <td>$email</td>
                                            <td>$sbj</td>
                                            <td>$date</td>
                                            <td>$msg</td>
                                            <td><form action='admin-panel.php' method='POST'><button class='delete' type='submit' name='delete-email' value='$id'>Delete</button></form></td>                                 
                                            <td><a class='readmore' href='read-more.php?email-id=$id'>Read <i class='fas fa-caret-right'></i></a></td>
                                        </tr>";
                                    }
                                }else{
                                    echo "<tr>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                            <td>No Data</td>
                                        </tr>
                                    ";
                                }
                            ?>

                        </table>
                        <div class="paging">
                            <ul>
                                <?php   
                                    $sql = "SELECT COUNT(*) FROM email";   
                                    $rs_result = mysqli_query($con, $sql);   
                                    $row = mysqli_fetch_row($rs_result);   
                                    $total_records = $row[0];   
                                    
                                    // Number of pages required. 
                                    $total_pages = ceil($total_records / $limit);   
                                    $pagLink = "";                         
                                    for ($i=1; $i<=$total_pages; $i++) { 
                                    if ($i==$pn) { 
                                        $pagLink .= "<a class='active' href='admin-panel.php?page=".$i."'>".$i."</a>"; 
                                    }             
                                    else  { 
                                        $pagLink .= "<a href='admin-panel.php?page=".$i."'>".$i."</a>";   
                                    } 
                                    };   
                                    echo $pagLink;   
                                ?> 
                            </ul>
                            <ul class="move">
                            <?php /*if(isset($_GET['page'])){ echo "<a class='active' href='admin-panel.php?page=".$prev."'><i class='fas fa-caret-left'></i></a>";}else{echo "<a class='active' href='admin-panel.php?page=1'><i class='fas fa-caret-left'></i></a>";} ?>
                                <?php if(isset($_GET['page'])){ echo "<a class='active' href='admin-panel.php?page=".$next."'><i class='fas fa-caret-right'></i></a>";}else{if($total_pages == 1){echo "<a class='active' href='admin-panel.php?page=1'><i class='fas fa-caret-right'></i></a>";}else{echo "<a class='active' href='admin-panel.php?page=2'><i class='fas fa-caret-right'></i></a>";}} */?>
                            </ul>
                        </div>
                    </div>

                    <div class="box-2">
                        <form action="admin-panel.php" method="POST">
                            <div class="details">
                                <i class="fas fa-envelope"></i>
                                <h2>Send Email</h2>
                            </div>
                            <?php if(isset($_POST['send-email'])){
                                if($errors){
                                    include('./apis/errors.php');
                                    }
                                } 
                            ?>
                            <input type="email" name="email" placeholder="Receipent Email" autocomplete="off" >
                            <input type="text" name="subject" placeholder="Subject" autocomplete="off">
                            <textarea name="msg" id="" cols="30" rows="9" placeholder="Message.!" autocomplete="off"></textarea>
                            <button type="submit" name="send-email">Send Email</button>
                            <?php 
                                if(isset($_POST['send-email'])){
                                    if(isset($success)){
                                    echo $success;
                                    }
                                } 
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------->
    <div class="copy-rights">
        <p>
            Copyrights &copy;
            <script>
                document.write(new Date().getFullYear());
            </script> All rights reserved | To NFC IET
        </p>
    </div>


</body>
<script src="./js/script.js"></script>
<script>
    function openCity(service, elmnt, color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
        }
        document.getElementById(service).style.display = "block";
        elmnt.style.backgroundColor = color;

    }
    document.getElementById("defaultOpen").click();
</script>
<script>
    function initMap() {
        const myLatlng = {
            lat: 30.219910,
            lng: 71.537316
        };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: myLatlng,
        });

        
        const points = <?php echo $json; ?>;
        const stops = [];
        

        const university = new google.maps.Marker({
            position: {
                lat: 30.219910,
                lng: 71.537316
            },
            map,
            icon: "./img/bus_icons/943-nfc.png",
            title: "University",
        });

        
        while(points.length){
            stops.push(points.splice(0,5));
        }
        
        var y = document.getElementById('root').value;
        var z = parseInt(y);

        if (z != 0) {
            for (let i = 0; i < stops.length; i++) {
                if (stops[i][4] == z) {
                    const marker = new google.maps.Marker({
                        position: {
                            lat: stops[i][1],
                            lng: stops[i][2]
                        },
                        map,
                        icon: stops[i][3],
                        title: stops[i][0],
                        animation: google.maps.Animation.DROP,
                    });
                    
                    const info = new google.maps.InfoWindow({
                        content: stops[i][0],
                    });

                    marker.addListener("click", () => {
                        map.setZoom(17);
                        map.setCenter(marker.getPosition());
                        info.open(map, marker);
                        if (marker.getAnimation() !== null) {
                                marker.setAnimation(null);
                            } else {
                                marker.setAnimation(google.maps.Animation.BOUNCE);
                        }
                    });
                    university.addListener("click", () => {
                        map.setZoom(17);
                        map.setCenter(university.getPosition());
                    });


                }
            }
        } else {
            for (let k = 0; k < stops.length; k++) {
                const marker = new google.maps.Marker({
                    position: {
                        lat: stops[k][1],
                        lng: stops[k][2]
                    },
                    map,
                    icon: stops[k][3],
                    title: stops[k][0],
                    animation: google.maps.Animation.DROP,
                });

                const info = new google.maps.InfoWindow({
                    content: stops[k][0],
                });

                marker.addListener("click", () => {
                    map.setZoom(17);
                    map.setCenter(marker.getPosition());
                    info.open(map, marker);
                    if (marker.getAnimation() !== null) {
                        marker.setAnimation(null);
                    } else {
                        marker.setAnimation(google.maps.Animation.BOUNCE);
                        
                    }
                });
            }
        }

        var database = firebase.database().ref("Loc_db");
        let arrMarker = [];

        marker = new google.maps.Marker();
        database.on("value", function(snapshot) {
            var data = snapshot.val();
            console.log(data);
            removeMarkers();
            for (let i in data) {
                setMarkers(data[i].Coordinates.Latitude, data[i].Coordinates.Longitude, data[i].Coordinates.Route)
            }

        });

        /*=====================================================*/
        function setMarkers(lat, lng, title) {
            var myLatlng = new google.maps.LatLng(lat, lng, title);
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: title,
                icon: './img/bus-icon.png',
                zoom: 12,
            });
            arrMarker.push(marker);
        }

        function removeMarkers() {
            for (let k = 0; k < arrMarker.length; k++) {
                arrMarker[k].setMap(null);
            }
            arrMarker = [];
        }

        /*=====================================================*/
        var dbAdd = firebase.database().ref("Loc_db");
        var succ = "";
        <?php 
            if(isset($_POST['add-route'])){
                if(isset($success)){
                    $add_message = "Success";
                    $tracker = $track;
                    $title = $route;
        ?>
            succ = "<?php echo $add_message; ?>";
            var tracker = "<?php echo $tracker; ?>";
            var title = "<?php echo "Route # ".$title; ?>";

        <?php  } } ?>

        if(succ == "Success"){
            dbAdd.child(tracker).child("Coordinates").set({
                Latitude: 30.219813,
                Longitude: 71.537293,
                Route: title,
            });
        }



        /*=====================================================*/
        var stopDB = firebase.database().ref("Stops-101");
        var succ = "";
        <?php 
            if(isset($_POST['add-stop'])){
                if(isset($success)){
                    $add_message = "Success";
            ?>
            succ = "<?php echo $add_message; ?>";
            var stopNumber = "<?php echo $stopNumber; ?>";
            var route = "<?php echo $route; ?>";
            var stop = "<?php echo $mystop; ?>";
            var lat = "<?php echo $insetLat; ?>";
            var lng = "<?php echo $insetLng; ?>";
            console.log(lat);
            if(succ == "Success"){
                stopDB.child(stopNumber).set({
                    latitude: parseFloat(lat),
                    longitude: parseFloat(lng),
                    stopInfo: "Route #"+route+" Stop #"+stop,
                });
                document.getElementById('lat').value = "";
                document.getElementById('lng').value = "";
            }
        <?php  } } ?>

        <?php 
            if(isset($_POST['delete-stop'])){
                if(isset($success)){
                    $add_message = "Success";
        ?>
            succ = "<?php echo $add_message; ?>";
            var stop = "<?php echo $stopNow; ?>";
            var route = "<?php echo $routeNow; ?>";
            var text = route+"-"+stop;
            if(succ == "Success"){
                stopDB.child(text).remove();
            }
        <?php  } } ?>
    }
</script>
<script>

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</html>

        
        