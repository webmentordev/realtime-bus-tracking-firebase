<?php
    date_default_timezone_set("Asia/Karachi");
    header('Content-Type: application/json');

    require './apis/init.php';

    $errors = array();

    if(isset($_GET['api'])){
        if($_GET['api'] == 'qw4hd-dqcrg'){
            if(isset($_GET['email']) && isset($_GET['password'])){
                $email = htmlspecialchars(mysqli_real_escape_string($con, $_GET['email']));
                $password = htmlspecialchars(mysqli_real_escape_string($con, $_GET['password']));;
                
                if(empty($email) || empty($password)){
                    $response['status'] = "Fields Shouldn't Be Empty!";
                    echo json_encode($response);
                    array_push($errors, "Empty");
                }

                if(count($errors) == 0){
                    $enc_pass = md5(md5($password));
                    $date = date("d, M Y H:i:s A");
                    $sql = "SELECT * from students WHERE email ='$email' AND password='$enc_pass'";
                    $res = mysqli_query($con, $sql);
        
                    if(mysqli_num_rows($res) == 1){
                        $response['status'] = "Login Success";
                        echo json_encode($response);
                        $sql2 = "UPDATE students set lastLogin = '$date' WHERE email = '$email'";
                        $res2 = mysqli_query($con, $sql2);
                    }else{
                        $response['status'] = "Invalid Login Details";
                        echo json_encode($response);
                    }
                }else{
                    $response['status'] = "Email or Password Must Not Me Empty";
                    echo json_encode($response);
                }
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