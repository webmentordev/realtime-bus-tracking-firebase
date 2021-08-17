<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6d5ca9b667.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/404.css">
    <meta name="author" content="Muhammad Ahmer Tahir, iLoBBer">
    <link rel="shortcut icon" href="./img/bus_logo.png">
    <title>Page Not Found - Error 404</title>
</head>

<body>
    <!-------->
    <div class="side" id="bar">
        <button type="button" onclick="closeBar()"><i class="fas fa-times"></i></button>
        <ul>
            <a class="first" href="admin-login.php">Login</a>
            <a class="first" href="admin-signup.php">Signup</a>
            <a href="contact.php">Contact</a>
        </ul>
    </div>
    <!-------->
    <div class="nav">
        <div class="nav-con">
            <div class="nav-1">
                <a href="index.php">
                    <i class="fas fa-bus"></i>
                    <h3>nfc iet bus tracking</h3>
                </a>
            </div>

            <div class="nav-2">
                <ul>
                    <a class="first" href="admin-login.php">Admin-Login</a>
                    <a class="first" href="admin-signup.php">Admin-Signup</a>
                    <a href="contact.php">Contact</a>
                </ul>
            </div>

            <div class="nav-3" id="btn">
                <button type="button" onclick="showBar()">
                    <ul>
                        <li></li>
                        <li style="width: 30px;"></li>
                        <li style="width: 10px;"></li>
                    </ul>
                </button>
            </div>
        </div>
    </div>

    <!-------->
    <div class="body">
        <div class="body-con">
            <div class="box">
                <h2 class="title">404</h2>
                <p>OOps! - Page Not Found</p>
                <a href="index.php">Go Back</a>
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

</html>