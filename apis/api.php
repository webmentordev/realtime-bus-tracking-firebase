<?php  
    require 'init.php';
    date_default_timezone_set('Asia/Karachi');
    //Array To Store Errors
    $errors = array();
    session_start();


    //Send Email API
    if(isset($_POST['send-email'])){
        $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
        $subject = htmlspecialchars(mysqli_real_escape_string($con, $_POST['subject']));
        $msg = htmlspecialchars(mysqli_real_escape_string($con, $_POST['msg']));

        if(empty($email)){array_push($errors, "Email is Empty");}
        if(empty($subject)){array_push($errors, "Subject is Empty");}
        if(empty($msg)){array_push($errors, "Message is Empty");}

        if(strpos($email, '@') !== false){}else{array_push($errors, "Email is not Correct");}

        if(count($errors) == 0){
            $date = date("d, M Y H:i:s A");
            $sql = "INSERT INTO email (to_email, subject, msg, date) VALUES ('$email', '$subject','$msg','$date')";
            $res = mysqli_query($con, $sql);
            if($res){
                $to = $email;
                $subject = $subject;
                $txt = $msg;
                $email = mail($to,$subject,$txt);
                if(!$email){
                    array_push($errors, "Email has Problem");
                }else{
                    $success = "<p class='success'>Email Successfully Sent</p>";
                }
            }
            else{
                array_push($errors, "Message Couldn't be Sent");
            }
        }
    }
?>

<?php 
    //Code Generator
    if(isset($_POST['generate-code'])){
        $code = $_POST['code'];
        if(empty($code)){array_push($errors, "Code is Empty");}
        if(count($errors) == 0){
            $code = md5(md5($code));
            $success = "<p class='success'>".$code."</p>";
        }
    }
?>

<?php
    //Add New Admin Code
    if(isset($_POST['admin-code'])){
        $main = htmlspecialchars(mysqli_real_escape_string($con, $_POST['main_code']));
        $g_code = $_POST['g_code'];

        if(empty($main)){array_push($errors, "Admin Code Field is Empty");}
        if(empty($g_code)){array_push($errors, "Generated Code Field is Empty");}


        $main = md5(md5($main));
        $sql = "SELECT * from administrator WHERE code = '$main'";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res) == 1){
            //
        }else{
            array_push($errors, "Admin Code Does't Match");
        }
        $sql = "SELECT * from admin_codes WHERE code = '$g_code' ";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res) >= 1){
            array_push($errors, "Code Already Exists");
        }else{
            //
        }

        if(count($errors) == 0){
            $date = date("d, M Y H:i:s A");
            $sql = "INSERT INTO admin_codes (code, generated_at) VALUES ('$g_code', '$date')";
            $res = mysqli_query($con, $sql);
            if($res){
                $success = "<p class='success'>Admin Code Is Successfully Added</p>";
            }
            else{
                array_push($errors, "Message Couldn't be Sent");
            }
        }
    }
?>

<?php 
    //Admin Signup
    if(isset($_POST['admin-signup'])){
        $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['fullname']));
        $pass = htmlspecialchars(mysqli_real_escape_string($con, $_POST['password']));
        $pass2 = htmlspecialchars(mysqli_real_escape_string($con, $_POST['confirm_password']));
        $code = mysqli_real_escape_string($con, $_POST['code']);

        $pass = strtolower($pass);
        $pass2 = strtolower($pass2);
        
        $enc_code = md5(md5($code));
        $enc_pass = md5(md5($pass));

        if(empty($email)){array_push($errors, "Email is Empty");}
        if(empty($name)){array_push($errors, "Name is Empty");}
        if(empty($pass)){array_push($errors, "Password is Empty");}
        if(empty($pass2)){array_push($errors, "Confirm Password is Empty");}
        if(empty($code)){array_push($errors, "Code Field is Empty");}
        if($pass != $pass2){array_push($errors, "Both Password Does Not Match");}

        if(strpos($email, '@') !== false){}else{array_push($errors, "Email is not Correct");}
        
        $sql1 = "SELECT * from admin_register WHERE email = '$email' OR assigned_code = '$enc_code' LIMIT 1";
        $res1 = mysqli_query($con, $sql1);
        if(mysqli_num_rows($res1) == 1){
            array_push($errors, "Code Or Email Already Exists");
        }

        $sql2 = "SELECT * from admin_codes WHERE code = '$enc_code'";
        $res2 = mysqli_query($con, $sql2);
        if(mysqli_num_rows($res2) == 1){
            //
        }else{
            array_push($errors, "Code is Wrong");
        }
       
        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");
            $sql = "INSERT INTO admin_register (fullname, email, password, assigned_code, created_at) VALUES ('$name', '$email','$enc_pass', '$code', '$date')";
            $res = mysqli_query($con, $sql);
            if($res){
                $_SESSION['admin-panel-login-auth'] = 1;
                header('location: admin-panel.php');
                $to = $email;
                $subject = "NFC IET Bus Tracking";
                $txt = "You Have Successfully Signed Up for Admin!";
                $email = mail($to,$subject,$txt);
                if(!$email){
                    array_push($errors, "Email has Problem");
                }else{
                    $success = "<p class='success'>Email Successfully Sent</p>";
                }
            }
        }
    }
?>

<?php 
    //Admin Login
    if(isset($_POST['admin-login'])){
        $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
        $pass = htmlspecialchars(mysqli_real_escape_string($con, $_POST['password']));

        $pass = strtolower($pass);

        if(empty($email)){array_push($errors, "Email is Empty");}
        if(empty($pass)){array_push($errors, "Password is Empty");}

        if(strpos($email, '@') !== false){}else{array_push($errors, "Email is not Correct");}

        if(count($errors) == 0){
            $enc_pass = md5(md5($pass));
            $sql2 = "SELECT * from admin_register WHERE email = '$email' AND password = '$enc_pass' LIMIT 1";
            $res2 = mysqli_query($con, $sql2);
            if(mysqli_num_rows($res2) == 1){
               $_SESSION['admin-panel-login-auth'] = 1;
               header('location: admin-panel.php');
            }else{
                array_push($errors, "Email or Password is Wrong");
            }
        }
    }
?>

<?php 
    //Send Report
    if(isset($_POST['report-issue'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['fullname']));
        $msg = htmlspecialchars(mysqli_real_escape_string($con, $_POST['r_msg']));

        if(empty($email)){array_push($errors, "Email is Empty");}
        if(empty($name)){array_push($errors, "Name is Empty");}
        if(empty($msg)){array_push($errors, "Complain Field is Empty");}

        if(strpos($email, '@') !== false){}else{array_push($errors, "Email is not Correct");}

        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");
            $sql = "INSERT INTO reports (email, fullname, complain, issued_at) VALUES ('$email', '$name', '$msg', '$date')";
            $res = mysqli_query($con, $sql);
            if($res){
                $success = "<p class='success'>Complain Successfully Reported<i class='fas fa-check'></i></p>";
            }else{
                echo " Cant input";
            }
        }
    }
?>

<?php 
    //Contact
    if(isset($_POST['contact'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['fullname']));
        $msg = htmlspecialchars(mysqli_real_escape_string($con, $_POST['c_msg']));

        if(empty($email)){array_push($errors, "Email is Empty");}
        if(empty($name)){array_push($errors, "Name is Empty");}
        if(empty($msg)){array_push($errors, "Message Field is Empty");}

        if(strpos($email, '@') !== false){}else{array_push($errors, "Email is not Correct");}

        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");
            $sql = "INSERT INTO contacts (email, fullname, message, contacted_at) VALUES ('$email', '$name', '$msg', '$date')";
            $res = mysqli_query($con, $sql);
            if($res){
                $success = "<p class='success'>Message Successfully Sent<i class='fas fa-check'></i></p>";
            }else{
                echo "Cant input";
            }
        }
    }
?>

<?php 
    //Delete Contacts
    if(isset($_POST['delete-contact'])){
        $id = $_POST['delete-contact'];
        $sql = "DELETE from contacts WHERE id = '$id'";
        $res = mysqli_query($con, $sql);
        if($res){
            $success = "<p class='success' style='margin-bottom: 10px;'>Contact Message Successfully Deleted<i class='fas fa-check'></i></p>";
        }else{
            array_push($errors, "Data is Deleted or Doesn't Exist");
        }
    }
?>

<?php 
    //Delete Reviews
    if(isset($_POST['delete-report'])){
        $id = $_POST['delete-report'];
        $sql = "DELETE from reports WHERE id = '$id'";
        $res = mysqli_query($con, $sql);
        if($res){
            $success = "<p class='success' style='margin-bottom: 10px;'>Issue Report Successfully Deleted<i class='fas fa-check'></i></p>";
        }else{
            array_push($errors, "Data is Deleted or Doesn't Exist");
        }
        
    }
?>

<?php 
    //Delete Emails
    if(isset($_POST['delete-email'])){
        $id = $_POST['delete-email'];
        $sql = "DELETE from email WHERE id = '$id'";
        $res = mysqli_query($con, $sql);
        if($res){
            $success = "<p class='success' style='margin-bottom: 10px;'>Email Successfully Deleted<i class='fas fa-check'></i></p>";
        }else{
            array_push($errors, "Data is Deleted or Doesn't Exist");
        }
    }
?>

<?php 
    //Add NEw Route / Bus Route
    if(isset($_POST['add-route'])){
        $number = htmlspecialchars(mysqli_real_escape_string($con, $_POST['route_number']));
        $tracker = htmlspecialchars(mysqli_real_escape_string($con, $_POST['tracker']));
        $image = $_FILES['route_icon']['name'];
        $driver = htmlspecialchars(mysqli_real_escape_string($con, $_POST['driver']));


        if(empty($number) || empty($tracker) || empty($image) || empty($driver)){array_push($errors, "Any Field is empty");}


        $sql2 = "SELECT * from routes WHERE route_number = '$number' OR tracker = '$tracker'";
        $res2 = mysqli_query($con, $sql2);
        if(mysqli_num_rows($res2) == 1){
            array_push($errors, "Route or Tracker Already Exists");
        }
        
        $file1 = rand(10,1000)."-".$_FILES['route_icon']['name'];
        $file_loc1 = $_FILES['route_icon']['tmp_name'];
        $folder1="./img/bus_icons/";
        $new_file_name1 = strtolower($file1);
        $final_file1=str_replace(' ','-',$new_file_name1);

        $size = $_FILES['route_icon']['size'];
        $f_size = $size / 1024;
        if($f_size >= 1024){ array_push($errors, "Image Must be Less then 1Mb"); }

        $allowed = array('jpeg', 'png', 'jpg');
        $filename = $image;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) { array_push($errors, "Image Must Be Png, Jpeg, Jpg"); }
        
        //If Everything is OK
        if(count($errors) == 0){
            if(move_uploaded_file($file_loc1,$folder1.$final_file1)){
                $date = date("d, M Y h:i:s A");
                $sql = "INSERT INTO routes (route_number, icon, driver_name, tracker, created_at) VALUES ($number, '$final_file1','$driver', '$tracker', '$date')";
                $res = mysqli_query($con, $sql);
                if($res){
                    $success = "<p class='success' style='margin-bottom: 10px;'>Route Added<i class='fas fa-check'></i></p>";
                    $track = $tracker;
                    $route = $number;
                }
            }
        }
    }
?>

<?php 
    //Add New Stop Of Route
    if(isset($_POST['add-stop'])){
        $number = htmlspecialchars(mysqli_real_escape_string($con, $_POST['number']));
        $lat = htmlspecialchars(mysqli_real_escape_string($con, $_POST['lat']));
        $lng = htmlspecialchars(mysqli_real_escape_string($con, $_POST['lng']));
        $route = htmlspecialchars(mysqli_real_escape_string($con, $_POST['route']));


        if(empty($number)){array_push($errors, "Stop Number is Empty");}
        if(empty($lat)){array_push($errors, "Latitude is Empty");}
        if(empty($lng)){array_push($errors, "Longitude is Empty");}
        if(empty($route)){array_push($errors, "Route Number is Empty");}
        
        $sql2 = "SELECT * from stops WHERE stop_number = '$number' AND route_registered = '$route' ";
        $res2 = mysqli_query($con, $sql2);
        if(mysqli_num_rows($res2) > 0){
            array_push($errors, "Stop On Route Already exists");
        }

        //If Everything is OK
        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");
            $icon = "SELECT * from routes WHERE route_number = $route";
            $res2 = mysqli_query($con, $icon);
            while($row = mysqli_fetch_array($res2)){
                $icon = $row['icon'];
            }
            $sql = "INSERT INTO stops (stop_number, lat, lng, icon, route_registered, created_at) VALUES ($number, '$lat', '$lng', '$icon' , $route, '$date')";
            $res = mysqli_query($con, $sql);
            if($res){
                $success = "<p class='success' style='margin-bottom: 10px;'>Stop Added<i class='fas fa-check'></i></p>";
                $stopNumber = $route."-".$number;
                $insetLat = $lat;
                $insetLng = $lng;
                $mystop = $number;
            }
            else{
                array_push($errors, "Something Wrong With Query");
            }
        }
    }
?>


<?php 
    //Update Marker
    if(isset($_POST['update-stop'])){
        $stop = htmlspecialchars(mysqli_real_escape_string($con, $_POST['stop']));
        $lat = htmlspecialchars(mysqli_real_escape_string($con, $_POST['lat']));
        $lng = htmlspecialchars(mysqli_real_escape_string($con, $_POST['lng']));
        $route = htmlspecialchars(mysqli_real_escape_string($con, $_POST['route']));
        $id = htmlspecialchars(mysqli_real_escape_string($con, $_POST['id']));

        if(empty($stop)){array_push($errors, "Stop Number is Empty");}
        if(empty($lat)){array_push($errors, "Latitude is Empty");}
        if(empty($lng)){array_push($errors, "Longitude is Empty");}
        if(empty($route)){array_push($errors, "Route Number is Empty");}
        if(empty($id)){array_push($errors, "Id Shoudn't Be Empty");}
 
        //If Everything is OK
        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");

            $icon = "SELECT * from routes WHERE route_number = $route";
            $res2 = mysqli_query($con, $icon);
            while($row = mysqli_fetch_array($res2)){
                $icon = $row['icon'];
            }
            $sql = "UPDATE stops SET  lat = '$lat', lng = '$lng', updated_at = '$date' WHERE id = '$id'";
            $res = mysqli_query($con, $sql);
            if($res){
                $success = "<p class='text-white bg-green-400 font-bold text-center w-4/12 p-3 rounded-lg m-auto'>Stop Successfully Updated <br><a class='underline text-red-500' href='admin-panel.php'>Go Back!</a></p>";
                $updateStop = $stop;
                $updateRoute = $route;
                $updateLat = $lat;
                $updateLng = $lng;
            }
            else{
                array_push($errors, "Something Wrong With Query");
            }
        }
    }
?>


<?php 
    //Add New Driver
    if(isset($_POST['add-driver'])){
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
        $phone = htmlspecialchars(mysqli_real_escape_string($con, $_POST['phone_number']));
        $image = $_FILES['driver_img']['name'];


        if(!is_numeric($phone)){
            array_push($errors, "Phone Should Be Number");
        }

        if(empty($name)){array_push($errors, "Name is Empty");}
        if(empty($phone)){array_push($errors, "Phone Number is Empty");}
        if(empty($image)){array_push($errors, "image is Empty");}

        $sql2 = "SELECT * from drivers WHERE name = '$name' || phone_number = '$phone'";
        $res2 = mysqli_query($con, $sql2);
        if(mysqli_num_rows($res2) == 1){
            array_push($errors, "Driver Already Exists");
        }
        
        $file1 = rand(10,1000)."-".$_FILES['driver_img']['name'];
        $file_loc1 = $_FILES['driver_img']['tmp_name'];
        $folder1="./img/drivers/";
        $new_file_name1 = strtolower($file1);
        $final_file1=str_replace(' ','-',$new_file_name1);

        $size = $_FILES['driver_img']['size'];
        $f_size = $size / 1024;
        if($f_size >= 1024){ array_push($errors, "Image Must be Less then 1Mb"); }

        $allowed = array('jpeg', 'png', 'jpg');
        $filename = $image;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) { array_push($errors, "Image Must Be Png, Jpeg, Jpg"); }
        
        //If Everything is OK
        if(count($errors) == 0){
            if(move_uploaded_file($file_loc1,$folder1.$final_file1)){
                $date = date("d, M Y h:i:s A");
                $sql = "INSERT INTO drivers (name, image, phone_number, created_at) VALUES ('$name', '$final_file1', $phone, '$date')";
                $res = mysqli_query($con, $sql);
                if($res){
                    $success = "<p class='success' style='margin-bottom: 10px;'>Route Added<i class='fas fa-check'></i></p>";
                }
            }
        }
    }
?>
<?php 
    //Delete Stop
    if(isset($_POST['delete-stop'])){
        $id = $_POST['delete-stop'];
        $stopNow = $_POST['stop'];
        $routeNow = $_POST['route'];
        $sql = "DELETE from stops WHERE id = '$id'";
        $res = mysqli_query($con, $sql);
        if($res){
            $success = "<p class='success' style='margin-bottom: 10px;'>Stop Successfully Deleted<i class='fas fa-check'></i></p>";
        }else{
            array_push($errors, "Data is Deleted or Doesn't Exist");
        }
    }
?>

<?php 
    //Delete Driver
    if(isset($_POST['delete-driver'])){
        $id = $_POST['delete-driver'];
        $sql = "DELETE from drivers WHERE id = '$id'";
        $res = mysqli_query($con, $sql);
        if($res){
            $success = "<p class='success' style='margin-bottom: 10px;'>Driver Successfully Deleted<i class='fas fa-check'></i></p>";
        }else{
            array_push($errors, "Data is Deleted or Doesn't Exist");
        }
    }
?>

<?php 
    //Add Students
    if(isset($_POST['add_student'])){
        $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
        $rollnumber = htmlspecialchars(mysqli_real_escape_string($con, $_POST['rollnumber']));
        $pass = htmlspecialchars(mysqli_real_escape_string($con, $_POST['password']));

        
        if(empty($email)){array_push($errors, "Email is Empty");}
        if(empty($pass)){array_push($errors, "Password is Empty");}
        if(empty($rollnumber)){array_push($errors, "Roll Number is Empty");}


        $pass = strtolower($pass);
        $enc_pass = md5(md5($pass));

        if(strpos($email, '@') !== false){}else{array_push($errors, "Email is Incorrect");}
        
        $sql1 = "SELECT * from students WHERE email = '$email' LIMIT 1";
        $res1 = mysqli_query($con, $sql1);
        if(mysqli_num_rows($res1) == 1){
            array_push($errors, "Student with Same Email Already Exists");
        }

        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");
            $sql = "INSERT INTO students (email, rollnumber, password, created_at, status) VALUES ('$email', '$rollnumber', '$enc_pass', '$date', 'verified')";
            $res = mysqli_query($con, $sql);
            if($res){
                echo '<script>alert("Student Added")</script>';
            }
        }
    }
?>


<?php 
    //Recover
    if(isset($_POST['recover'])){
        $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
        $pass = htmlspecialchars(mysqli_real_escape_string($con, $_POST['password1']));
        $pass2 = htmlspecialchars(mysqli_real_escape_string($con, $_POST['confirm_password']));
        $code = mysqli_real_escape_string($con, $_POST['code']);

        $pass = strtolower($pass);
        $pass2 = strtolower($pass2);
        
        $enc_code = md5(md5($code));
        $enc_pass = md5(md5($pass));

        if(empty($email)){array_push($errors, "Email is Empty");}
        if(empty($pass)){array_push($errors, "Password is Empty");}
        if(empty($pass2)){array_push($errors, "Confirm Password is Empty");}
        if(empty($code)){array_push($errors, "Code Field is Empty");}
        if($pass != $pass2){array_push($errors, "Both Password Does Not Match");}

        if(strpos($email, '@') !== false){}else{array_push($errors, "Email is not Correct");}
        
        $sql1 = "SELECT * from admin_register WHERE email = '$email' OR assigned_code = '$code' LIMIT 1";
        $res1 = mysqli_query($con, $sql1);
        if(mysqli_num_rows($res1) == 1){
            //
        }else{
            array_push($errors, "Code Or Email Do not Exists / Match");
        }

        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");
            $sql = "UPDATE admin_register SET password = '$enc_pass', updated_at = '$date' WHERE email = '$email'";
            $res = mysqli_query($con, $sql);
            if($res){
                $success = "<p class='success'>Password Successfully Changed <i class='fas fa-check'></i></p></p>";
            }else{
                array_push($errors, "Something Wrong! Contact Institute");
            }
        }
    }
?>




<?php 
    //Add New Driver
    if(isset($_POST['update-driver'])){
        $id = htmlspecialchars(mysqli_real_escape_string($con, $_POST['id']));
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
        $phone = htmlspecialchars(mysqli_real_escape_string($con, $_POST['phone_number']));
        $image = $_FILES['driver_img']['name'];

        if(!is_numeric($phone)){ array_push($errors, "Phone Should Be Number");}

        if(empty($name)){array_push($errors, "Name is Empty");}
        if(empty($phone)){array_push($errors, "Phone Number is Empty");}
        
        if(!empty($image)){
            $file1 = rand(10,1000)."-".$_FILES['driver_img']['name'];
            $file_loc1 = $_FILES['driver_img']['tmp_name'];
            $folder1="./img/drivers/";
            $new_file_name1 = strtolower($file1);
            $final_file1=str_replace(' ','-',$new_file_name1);

            $size = $_FILES['driver_img']['size'];
            $f_size = $size / 1024;
            if($f_size >= 1024){ array_push($errors, "Image Must be Less then 1Mb"); }

            $allowed = array('jpeg', 'png', 'jpg');
            $filename = $image;
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) { array_push($errors, "Image Must Be Png, Jpeg, Jpg"); }
        }
        
        //If Everything is OK
        if(count($errors) == 0){
            if(!empty($image)){
                if(move_uploaded_file($file_loc1,$folder1.$final_file1)){
                    $date = date("d, M Y h:i:s A");
                    $sql = "UPDATE drivers SET name = '$name', phone_number = '$phone', updated_at = '$date', image='$final_file1' WHERE id = '$id'";
                    $res = mysqli_query($con, $sql);
                    if($res){
                        $success = "<p class='text-white bg-green-400 font-bold text-center w-4/12 p-3 rounded-lg m-auto'>Driver Info Successfully Updated <br><a class='underline text-red-500' href='admin-panel.php'>Go Back!</a></p>";
                    }else{
                        echo "Something Went Wrong with image!";
                    }
                }
            }else{
                $date = date("d, M Y h:i:s A");
                $sql = "UPDATE drivers SET name = '$name', phone_number = '$phone', updated_at = '$date' WHERE id = '$id'";
                $res = mysqli_query($con, $sql);
                if($res){
                    $success = "<p class='text-white bg-green-400 font-bold text-center w-4/12 p-3 rounded-lg m-auto'>Driver Info Successfully Updated <br><a class='underline text-red-500' href='admin-panel.php'>Go Back!</a></p>";
                }else{
                    echo 'Somthing Went Wrong!';
                }
            }
        }
    }
?>

<?php 
    //Update Route Information
    if(isset($_POST['update-route-now'])){
        $id = htmlspecialchars(mysqli_real_escape_string($con, $_POST['id']));
        $number = htmlspecialchars(mysqli_real_escape_string($con, $_POST['number']));
        $tracker = htmlspecialchars(mysqli_real_escape_string($con, $_POST['tracker']));
        $driver = htmlspecialchars(mysqli_real_escape_string($con, $_POST['driver']));
        $image = $_FILES['route_icon']['name'];

        if(empty($id)){array_push($errors, "Something Went Wrong!");}
        if(empty($number)){array_push($errors, "Route is Empty");}
        if(empty($driver)){array_push($errors, "Driver Name is Empty");}
        if(empty($tracker)){array_push($errors, "Tracker should not be Empty");}
        
        $sql2 = "SELECT * from routes WHERE id = '$id'";
        $res2 = mysqli_query($con, $sql2);
        while($row = mysqli_fetch_assoc($res2)){
            $mytracker = $row['tracker'];
            $route_number = $row['route_number'];
        }


        $sql3 = "SELECT * from routes WHERE tracker = '$tracker'";
        $res3 = mysqli_query($con, $sql3);
        if(mysqli_num_rows($res3) > 0){
            array_push($errors, "Updating Marker Already Exists");
        }


        if(!empty($image)){
            $file1 = rand(10,1000)."-".$_FILES['route_icon']['name'];
            $file_loc1 = $_FILES['route_icon']['tmp_name'];
            $folder1="./img/bus_icons/";
            $new_file_name1 = strtolower($file1);
            $final_file1=str_replace(' ','-',$new_file_name1);

            $size = $_FILES['route_icon']['size'];
            $f_size = $size / 1024;
            if($f_size >= 1024){ array_push($errors, "Image Must be Less then 1Mb"); }

            $allowed = array('jpeg', 'png', 'jpg');
            $filename = $image;
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) { array_push($errors, "Image Must Be Png, Jpeg, Jpg"); }
        }
        
        //If Everything is OK
        if(count($errors) == 0){
            if(!empty($image)){
                if(move_uploaded_file($file_loc1,$folder1.$final_file1)){
                    $date = date("d, M Y h:i:s A");
                    $sql = "UPDATE routes SET tracker = '$tracker', route_number = '$number', driver_name = '$driver', icon = '$final_file1', updated_at = '$date' WHERE id = '$id'";
                    $res = mysqli_query($con, $sql);
                    
                    $sql2 = "UPDATE stops SET icon = '$final_file1' WHERE route_registered = '$number'";
                    $res2 = mysqli_query($con, $sql2);
                    if($res && $res2){
                        $success = "<p class='text-white bg-green-600 font-bold text-center w-4/12 p-3 rounded-lg m-auto'>Route Successfully Updated</p>";
                    }else{
                        echo "Something Went Wrong with image!";
                        $trackerid = $tracker;
                    }
                }
            }else{
                $date = date("d, M Y h:i:s A");
                $sql = "UPDATE routes SET tracker = '$tracker', route_number = '$number', driver_name = '$driver', updated_at = '$date' WHERE id = '$id'";
                $res = mysqli_query($con, $sql);
                if($res){
                    $success = "<p class='text-white bg-green-600 font-bold text-center w-4/12 p-3 rounded-lg m-auto'>Route Info Successfully Updated</p>";
                }else{
                    echo 'Somthing Went Wrong!';
                    $trackerid = $tracker;
                }
            }
        }
    }
?>

<?php 
    //Delete Route
    if(isset($_POST['delete-route'])){
        $id = $_POST['delete-route'];
        $tracker = $_POST['tracker'];

        $sql3 = "SELECT * from stops WHERE route_registered = '$id'";
        $res3 = mysqli_query($con, $sql3);
        while($row = mysqli_fetch_assoc($res3)){
            $red_route = $id;
            $reg_stop = $row['stop_number'];
            $text = $red_route."-".$reg_stop;
?>

    <script>
        var delStops = firebase.database().ref("Stops-101");
        var delRoute = "<?php echo $text; ?>";
        console.log(delRoute);
        delStops.child(delRoute).remove();
    </script>
<?php
        }

        $sql = "DELETE from routes WHERE route_number = '$id'";
        $sql2 = "DELETE from stops WHERE route_registered = '$id'";
        $res = mysqli_query($con, $sql);
        $res2 = mysqli_query($con, $sql2);
        if($res && $res2){
            $success = "<p class='text-white border-2 border-green-600 bg-green-600 font-bold text-center w-4/12 p-3 rounded-lg m-auto'>Route Successfully Deleted</p>";
            $tracker = $tracker;

            

        }else{
            array_push($errors, "Data is already Deleted or Doesn't Exist");
        }
    }
?>