<?php require './apis/init.php'; ?>
<?php 
    if(isset($_GET['contact-id']) || isset($_GET['report-id']) || isset($_GET['email-id'])){
        //
    }else{
        header('location: admin-login.php');
    }
?>
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
</head>
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

    <?php 
        if(isset($_GET['contact-id'])){
            $id = $_GET['contact-id'];
            $sql = "SELECT * from contacts WHERE id = '$id'";
            $res = mysqli_query($con, $sql);
            while($row = mysqli_fetch_assoc($res)){
    
        ?>
        <div class="para">
            <h1>Contact Mail</h1>
            <div class="details mb-4">
                <h2><i class="fas fa-user"></i>From: <span class="text-white bg-gray-700 p-1 pr-6 pl-6 rounded-sm inline-block"><?php echo $row['fullname'] ?></span></h2>
                <h2><i class="fas fa-clock"></i>Date (PKT): <span class="text-white bg-gray-700 p-1 pr-6 pl-6 rounded-sm inline-block"><?php echo $row['contacted_at'] ?></span></h2>
                <h2><i class="fas fa-envelope"></i> Email: <span class="text-white bg-gray-700 p-1 pr-6 pl-6 rounded-sm inline-block"><?php echo $row['email'] ?></span></h2>
            </div>
            <p class="text-gray-300 text-lg leading-8"><?php echo $row['message'] ?></p>
        </div>

    <?php }} ?>
        
    <?php 
        if(isset($_GET['report-id'])){
            $id = $_GET['report-id'];
            $sql = "SELECT * from reports WHERE id = '$id'";
            $res = mysqli_query($con, $sql);
            while($row = mysqli_fetch_assoc($res)){
    
        ?>
        <div class="para">
            <h1>Complain / Report</h1>
            <div class="details mb-4">
                <h2><i class="fas fa-user"></i>From: <span class="text-white bg-gray-700 p-1 pr-6 pl-6 rounded-sm inline-block"><?php echo $row['fullname'] ?></span></h2>
                <h2><i class="fas fa-clock"></i>Date (PKT): <span class="text-white bg-gray-700 p-1 pr-6 pl-6 rounded-sm inline-block"><?php echo $row['issued_at'] ?></span></h2>
                <h2><i class="fas fa-envelope"></i> Email: <span class="text-white bg-gray-700 p-1 pr-6 pl-6 rounded-sm inline-block"><?php echo $row['email'] ?></span></h2>
            </div>
            <p class="text-gray-300 text-lg leading-8"><?php echo $row['complain'] ?></p>
        </div>
    <?php  }} ?>


    <?php 
        if(isset($_GET['email-id'])){
            $id = $_GET['email-id'];
            $sql = "SELECT * from email WHERE id = '$id'";
            $res = mysqli_query($con, $sql);
            while($row = mysqli_fetch_assoc($res)){
    
        ?>
        <div class="para">
            <h1>Emails Sent</h1>
            <div class="details mb-4">
                <h2><i class="fas fa-book"></i>Subject: <span class="text-white bg-gray-700 p-1 pr-6 pl-6 rounded-sm inline-block"><?php echo $row['subject'] ?></span></h2>
                <h2><i class="fas fa-clock"></i>Date (PKT): <span class="text-white bg-gray-700 p-1 pr-6 pl-6 rounded-sm inline-block"><?php echo $row['date'] ?></span></h2>
                <h2><i class="fas fa-envelope"></i>Sent_To: <span class="text-white bg-gray-700 p-1 pr-6 pl-6 rounded-sm inline-block"><?php echo $row['to_email'] ?></span></h2>
            </div>
            <p class="text-gray-300 text-lg leading-8"><?php echo $row['msg'] ?></p>
        </div>
    <?php  }} ?>
</body>
</html>