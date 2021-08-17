<?php

    date_default_timezone_set("Asia/Karachi");
    header('Content-Type: application/json');

    require './apis/init.php';

    $errors = array();

    if(isset($_GET['api'])){
        if($_GET['api'] == 'qw4hd-dqcrg'){
            if(isset($_GET['email']) && isset($_GET['password1']) && isset($_GET['password2']) && isset($_GET['rollnumber']) ){
                $email = htmlspecialchars(mysqli_real_escape_string($con, $_GET['email']));
                $password1 = htmlspecialchars(mysqli_real_escape_string($con, $_GET['password1']));
                $password2 = htmlspecialchars(mysqli_real_escape_string($con, $_GET['password2']));
                $rollnumber = htmlspecialchars(mysqli_real_escape_string($con, $_GET['rollnumber']));

                if(empty($rollnumber) || empty($password2) || empty($email) || empty($password1)){
                    $response['status'] = "Fields shouldn't Be Empty!";
                    echo json_encode($response);
                    array_push($errors, "Empty");
                }

                if(!strcmp("@undergrad.nfciet.edu.pk", $email)){
                    $response['status'] = "Use Email Provided By NFC IET!";
                    echo json_encode($response);
                    array_push($errors, "Email Not Correct");
                }

                if($password1 != $password2){
                    $response['status'] = "Both Password Do Not Match!";
                    echo json_encode($response);
                    array_push($errors, "Password Doesn't Match");
                }

                $sql = "SELECT * from students WHERE email = '$email' OR rollnumber = '$rollnumber'";
                $res = mysqli_query($con, $sql);
                if(mysqli_num_rows($res) > 0){
                    $response['status'] = "Roll Number or Email Already Exists!";
                    echo json_encode($response);
                    array_push($errors, "Already Exists");
                }

                if(count($errors) == 0){
                    $enc_pass = md5(md5($password1));
                    $date = date("d, M Y H:i:s A");
                    $sql = "INSERT into students (rollnumber, email, password, created_at) 
                            values ('$rollnumber', '$email', '$enc_pass', '$date')";
                    $res = mysqli_query($con, $sql);
        
                    if($res){
                        $response['status'] = "Register Success";
                        echo json_encode($response);
                        array_push($errors, "Match");
                    }else{
                        $response['status'] = "Something is Wrong with Database!";
                        echo json_encode($response);
                        array_push($errors, "Database Problem");
                    }
                }else{
                    $response['status'] = "Email or Password Must Not Me Empty";
                    echo json_encode($response);
                    array_push($errors, "Something is Wrong!");
                }
            }else{
                $response['status'] = "Details are Not Complete";
                echo json_encode($response);
            }
        }else{
            $response['status'] = "API Failure!";
            echo json_encode($response);
        }
    }else{
        $response['status'] = "You Must Have API to Proceed!";
        echo json_encode($response);
    }

    mysqli_close($con);
?>