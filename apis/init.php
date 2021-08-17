<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "bustracking";

    $con = mysqli_connect($host, $user, $pass, $db);
    
    if($con){
        //echo "connected";
    }
    else{
        //echo "Not Connected";
    }
?>