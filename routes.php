<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read More - Admin Panel</title>
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
    <script src="./js/firebase.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
</head>
<?php require './apis/api.php'; ?>
<?php
    if(isset($_SESSION['admin-panel-login-auth'])){
    }else{
        header('location: admin-panel.php');
    }
?>
<body>
    <header class="text-gray-600 body-font mb-4 border-b border-gray-200">
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

    <?php if(isset($_POST['update-route-now'])){
            if(isset($success)){
                echo $success;
            }else{
                include('./apis/update-errors.php');
            }
        } 
    ?>

    
    <?php if(isset($_POST['delete-route'])){
            if(isset($success)){
                echo $success;
            }else{
                include('./apis/update-errors.php');
            }
        } 
    ?>

    <div class="w-6/12 p-3 m-auto">
        <table class="w-full mb-8">
            <tr>
                <th class="text-center bg-gray-100 p-3">Id</th>
                <th class="text-center bg-gray-100 p-3">Route Number</th>
                <th class="text-center bg-gray-100 p-3">Icon</th>
                <th class="text-center bg-gray-100 p-3">Tracker</th>
                <th class="text-center bg-gray-100 p-3">Driver Name</th>
                <th class="text-center bg-gray-100 p-3">Created_AT</th>
                <th class="text-center bg-gray-100 p-3">Update</th>
                <th class="text-center bg-gray-100 p-3">Delete</th>
            </tr>

            <?php 
                $sql = 'SELECT * from routes';
                $res = mysqli_query($con, $sql);

                if(mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_assoc($res)){
                        $id =  $row['id']
            ?>
            <tr class="text-gray-600">
                <td class="text-center p-3"><?php echo $id ?></td>
                <td class="text-center p-3">Route Number: <?php echo $row['route_number'] ?></td>
                <td class="text-center p-3"><img class="ml-2" src="<?php echo './img/bus_icons/'.$row['icon'] ?>"></td>
                <td class="text-center p-3"><?php echo $row['tracker'] ?></td>
                <td class="text-center p-3"><?php echo $row['driver_name'] ?></td>
                <td class="text-center p-3"><?php echo $row['created_at'] ?></td>
                <td class="text-center"><form action="routes.php" method="post"><input type="hidden" name="tracker" value="<?php echo $row['tracker'] ?>"><button class="font-bold px-4 py-2 text-white inline bg-red-500 rounded-lg" type="submit" name="delete-route" value="<?php echo $row['route_number'] ?>">Delete</button></form></td>
                <td class="text-center"><a class="px-4 py-2 text-white inline bg-green-600 rounded-lg font-bold" href='routes.php?update-route=<?php echo $id ?>'>Update</a></td>
            </tr>

            <?php } } ?>
        </table>


            <?php 
                if(isset($_GET['update-route'])){
                    $id = $_GET['update-route'];
                    $sql = "SELECT * from routes WHERE id = '$id'";
                    $res = mysqli_query($con, $sql);
                    while($row = mysqli_fetch_assoc($res)){ 
            ?>

            <form class="w-6/12 m-auto" action="routes.php" method="post" enctype="multipart/form-data">
                    <input class="p-3 bg-gray-100 rounded-lg w-full my-2 border" type="hidden" name="id" value="<?php echo $id ?>">
                    <input class="p-3 bg-gray-100 rounded-lg w-full my-2 border" type="hidden" name="number" value="<?php echo $row['route_number'] ?>" placeholder="Route Number">
                    <h1 class="font-bold">Tracker:</h1>
                    <input class="p-3 bg-gray-100 rounded-lg w-full my-2 border" type="number" name="tracker" min="1" value="<?php echo $row['tracker'] ?>" placeholder="Tracker Number">
                    <h1 class="font-bold">Icon:</h1>
                    <input class="p-3 bg-gray-100 rounded-lg w-full my-2 border" type="file" name="route_icon">
                    
                    <h1 class="font-bold">Driver:</h1>
                    <select name="driver" class="p-3 bg-gray-100 rounded-lg w-full my-2 border">
                    <option value="<?php echo $row['driver_name'] ?>">Active: <?php echo $row['driver_name'] ?></option>;
                        <?php 
                            $sql2 = 'SELECT * from drivers';
                            $res2 = mysqli_query($con, $sql2);
                            if(mysqli_num_rows($res2) > 0){
                                while($rows = mysqli_fetch_assoc($res2)){
                                    $name = $rows['name'];
                        ?>
                            <option value="<?php echo $name ?>"><?php echo $name ?></option>
                        <?php 
                                }
                            }else{
                                echo '<option>None</option>';
                            } ?>
                    </select>
                    <button class="bg-blue-500 text-white w-full p-3 rounded-lg font-bold" name="update-route-now">Update</button>  
            </form>
            <?php } } ?>
    </div>
</body>


<script>
    var firedb = firebase.database().ref("Loc_db");
    var succ = "";
        <?php 
            if(isset($_POST['delete-route'])){
                if(isset($success)){
                    $add_message = "Success";
                    $trackerid = $tracker;

            ?>
            succ = "<?php echo $add_message; ?>";
            var tracker = "<?php echo $trackerid; ?>";
            console.log(tracker);
        <?php  } } ?>

        if(succ == "Success"){
            firedb.child(tracker).remove();
        }
    /*========================*/

    <?php 
        if(isset($_POST['update-route-now'])){
            if(isset($success)){
                $add_message = "Updated";

        ?>
        var message = "<?php echo $add_message; ?>";
        var tracker = "<?php echo $mytracker; ?>";
        var newtracker = "<?php echo $tracker; ?>";
        var title = "Route # "+"<?php echo $route_number; ?>";
        
        if(message == "Updated"){
            firedb.child(tracker).remove();
            firedb.child(newtracker).child("Coordinates").set({
                Latitude: 30.219813,
                Longitude: 71.537293,
                Route: title,
            });
        }
    <?php  } } ?>

</script>
</html>