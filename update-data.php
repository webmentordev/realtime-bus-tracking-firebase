<?php require './apis/api.php'; ?>
<?php 
    /*if(isset($_GET['point-update-id']) || isset($_GET['driver-update-id'])){
        //
    }else{
        header('location: admin-panel.php');
    }*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Point - Admin Panel</title>
    <link rel="stylesheet" href="./css/read.css">
    <meta name="author" content="Muhammad Ahmer Tahir, iLoBBer">
    <link rel="shortcut icon" href="./img/bus_logo.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500;900&family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://www.gstatic.com/firebasejs/8.3.3/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.3/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.3/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.3/firebase-firestore.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
</head>
<body>
    <header class="text-gray-600 body-font mb-3 border-b border-gray-200">
        <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
            <a href='index.php' class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <i class="fas fa-bus text-yellow-400 bg-gray-700 p-3 rounded-full"></i>
            <span class="ml-3 text-xl">Bus Tracking</span>
            </a>
            <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
            </nav>
            <a href='admin-panel.php' class=" text-white bg-gray-700 inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">Go Back
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
            </a>
        </div>
    </header>

    <?php 
        if(isset($_POST['update-stop'])){
            if(isset($success)){
                echo $success;
            }else{
                include('./apis/update-errors.php');
            }
        }
    ?>

    <?php 
        if(isset($_GET['point-update-id'])){
            $id = $_GET['point-update-id'];
            $sql = "SELECT * from stops WHERE id = '$id'";
            $res = mysqli_query($con, $sql);
            while($row = mysqli_fetch_assoc($res)){
            ?>
            <div class="para flex flex-col max-w-screen-sm m-auto">
                <h1 class="text-center">Update Markers</h1>
                <form action="update-data.php" class="flex flex-col" method="POST" enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $id ?>" class="my-3 border p-2" name="id"  autocomplete="off" required>
                    <h2 class="font-semibold">Latitude:</h2>
                    <input type="text" value="<?php echo $row['lat']; ?>" class="my-3 border p-2" name="lat" placeholder="Enter Latitude" required>
                    <h2 class="font-semibold">Longitude:</h2>
                    <input type="text" value="<?php echo $row['lng']; ?>" class="my-3 border p-2" name="lng" placeholder="Enter Longitude" required>
                    <input type="hidden" value="<?php echo $row['stop_number']; ?>" class="my-3 border p-2" name="stop" placeholder="Enter Stop Number"  autocomplete="off" required>
                    <input type="hidden" value="<?php echo $row['route_registered']; ?>" class="my-3 border p-2" name="route" placeholder="Enter Route"  autocomplete="off" required>
                    <button class="border-1 text-white py-3 px-10 bg-blue-500 rounded-lg my-3" type="submit" name="update-stop">Update Marker</button>
                </form>
            </div>
    <?php } } ?>


    <?php 
        if(isset($_POST['update-driver'])){
            if(isset($success)){
                echo $success;
            }else{
                include('./apis/update-errors.php');
            }
        }
    ?>

    <?php 
        if(isset($_GET['driver-update-id'])){
            $id = $_GET['driver-update-id'];
            $sql = "SELECT * from drivers WHERE id = '$id'";
            $res = mysqli_query($con, $sql);
            while($row = mysqli_fetch_assoc($res)){
            ?>
            <div class="para flex flex-col max-w-screen-sm m-auto">
                <h1 class="text-center">Update Driver</h1>
                <form action="update-data.php" class="flex flex-col" method="POST" enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $id ?>" class="my-3 border p-2" name="id" required>
                    <h2 class="font-semibold">Name:</h2>
                    <input type="text" value="<?php echo $row['name']; ?>" class="my-3 border p-2" name="name" placeholder="Enter Name"  autocomplete="off" required>
                    <h2 class="font-semibold">PhoneNumber:</h2>
                    <input type="number" value="<?php echo $row['phone_number']; ?>" class="my-3 border p-2" name="phone_number" placeholder="Phone Number"  autocomplete="off" required>
                    <h2 class="font-semibold">Image:</h2>
                    <input type="file" class="my-3 border p-2" name="driver_img">
                    <button class="border-1 text-white py-3 px-10 bg-blue-500 rounded-lg my-3" type="submit" name="update-driver">Update Driver</button>
                </form>
            </div>
    <?php } }?>
</body>
<script>

    var firebaseConfig = {
        apiKey: "AIzaSyDIv86QQNmAtq1t5j5nYjwZGBbBT4CFDyM",
        authDomain: "mymybus.firebaseapp.com",
        databaseURL: "https://mymybus-default-rtdb.firebaseio.com",
        projectId: "mymybus",
        storageBucket: "mymybus.appspot.com",
        messagingSenderId: "799948635739",
        appId: "1:799948635739:web:eb9ac789bb7d5b7bef097e",
        measurementId: "G-EJ469SQS21"
    };
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();

    var firedb = firebase.database().ref("Stops-101");
    var succ = "";
    <?php 
        if(isset($_POST['update-stop'])){
            if(isset($success)){
                $add_message = "Updated";

        ?>
        var message = "<?php echo $add_message; ?>";
        var stop = "<?php echo $updateStop; ?>";
        var route = "<?php echo $updateRoute; ?>";
        var del = route+'-'+stop;
        var lat = "<?php echo $updateLat; ?>";
        var lng = "<?php echo $updateLng; ?>";
        console.log(lat);
        if(message == "Updated"){
            firedb.child(del).remove();
            firedb.child(del).set({
                latitude: parseFloat(lat),
                longitude: parseFloat(lng),
                stopInfo: "Route # "+route+" Stop # "+stop,
            });
        }
    <?php  } } ?>

</script>
</html>