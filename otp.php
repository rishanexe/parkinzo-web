<?php

    session_start();
    require('include/dbconnect.php');
    date_default_timezone_set('Asia/Kolkata');

    if(isset($_SESSION['username']) == false) {
        echo '<body style="display:none;"></body>';
        echo "<script>alert('You are not authenticated. Please login or signup.');</script>";
    }

    $startTime = $_SESSION['startTime'];
    $endTime = $_SESSION['endTime'];
    
    $spaceId = $_SESSION['spaceId'];

    $username = $_SESSION['username'];
    //$otp = rand(10000,99999);
    //$_SESSION['otp'] = $otp;
    $otp = $_SESSION['otp'];

    $query = "UPDATE users SET otp='$otp' WHERE username='$username'";
    $result = mysqli_query($conn,$query);

    $query = "SELECT * FROM spaces WHERE id='$spaceId'";
    $result = mysqli_query($conn,$query);
    $spaces = mysqli_fetch_all($result,MYSQLI_ASSOC);

    $username = $_SESSION['username'];
    $amount = $_SESSION['total'];

    if(isset($_SESSION['otp']) && $_SESSION['dbentered']==0) {
        $query = "INSERT INTO booking(username,starttime,endtime,spaceid,amount,otp) 
        VALUES('$username','$startTime','$endTime','$spaceId','$amount','$otp')";
        $result = mysqli_query($conn,$query);
        $_SESSION['dbentered'] = 1;
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/logo.png">
    <title>Parkinzo | Your OTP</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Blinker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <div class="otp-bg">
        <nav id="navbar">
            <!-- logo is specified below -->
            <img class="logo" src="images\logo.png" alt="park">
            <h1><span style="color: #ff4b20;">Park</span><span>inzo</span></h1>

            <ul>
                <li><a href="listing.php">HOME</a></li>
                <!-- <li><a href="about.html">ABOUT</a></li> -->
                <li><a href="contact.php">CONTACT</a></li>
                <li><i class="fa fa-user"></i>&nbsp;<a style="color: #ff4b20" href="#"><?php echo $_SESSION['username']; ?></a></li>
                <li><a href="login.php?logout=1">LOGOUT</a></li>
            </ul>
        </nav>

        <nav class="topnav" id="myTopnav">
            <img class="logo" src="images\logo.png" alt="park">
            <h1><span style="color: #ff4b20;">Park</span><span style="color: #fff;">inzo</span></h1>

            <a style="padding: 4% 0 0 4%; text-align:center;" href="listing.php">HOME</a>
            <!-- <a href="#news">ABOUT</a> -->
            <a style="margin: 3% 0 0 0%; text-align:center;" href="contact.php">CONTACT</a>
            <a style="margin: 3% 0 0 0%; text-align:center; color: #ff4b20;" href="#"><i class="fa fa-user"></i>&nbsp;<?php echo $_SESSION['username']; ?></a>
            <a style="margin: 3% 0 5% 0%; text-align:center;" href="login.php?logout=1">LOGOUT</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </nav>

        <div class="otp-add">
            <div>
                <h2 style="color: #ff4b20;"><?php echo $spaces[0]['name']; ?></h2>
                <h4 style="color: #ff4b20;"><?php echo $spaces[0]['city']; ?></h4>
                <p><?php echo $spaces[0]['address1']; ?>,</p>
                <p><?php echo $spaces[0]['address2']; ?>,</p>
                <p><?php echo $spaces[0]['address3']; ?>.</p>
            </div>
            <div class="otp-start-time" id="start-time">
                <h4>Start Time</h4>
                <h3 style="text-align: center; color: #ff4b20;"><?php echo $startTime; ?></h3>
            </div>
            <div class="otp-start-time">
                <h4>End Time</h4>
                <h3 style="text-align: center; color: #ff4b20;"><?php echo $endTime; ?></h3>
            </div>
            <div class="otp-start-time" id="start-time">
                <h4>Parking Slot</h4>
                <h3 style="text-align: center; color: #ff4b20;"><?php echo $spaces[0]['id']; ?></h3>
            </div>

            <div class="otp-start-time" id="start-time">
                <h4>Distance</h4>
                <h3 style="text-align: center;color: #ff4b20;"><?php echo $spaces[0]['distance']; ?> Km</h3>
            </div>
            <div class="otp-start-time">
                <h4>Amount Paid</h4>
                <h3 style="text-align: center;color: #ff4b20;">Rs. <?php echo $_SESSION['total']; ?></h3>
            </div>

            <?php echo $spaces[0]['map']; ?>

            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3767.222610388061!2d72.85372091490721!3d19.22912765213814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7b0d6e771d27b%3A0xcfe3c6ecba9c4c92!2sBhandarkar%20Bhavan%2C%20Sundar%20Nagar%2C%20Borivali%20West%2C%20Mumbai%2C%20Maharashtra%20400092!5e0!3m2!1sen!2sin!4v1566710714948!5m2!1sen!2sin" width="380" height="220" frameborder="0" style="border:0;" allowfullscreen="">
            </iframe> -->



        </div>

        <div class="otp-add">
            <div class="otp-start-time otp">
                <h4>Your OTP for this reservation is:</h4>
                <h1 style="text-align: center; color: #ff4b20;"><?php echo $otp; ?></h1>
            </div>
        </div>
        <br><br><br>
    </div>

    <script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
    </script>

    <div class="section-border-o"><br></div>

    <footer>
        <div id="footer">
            <div style="color: #ff4b20;" id="left-footer">
                <br><br><br>
                <div id="footer-site-links">
                    <ul style="list-style-type: none;">
                        <h2>Site Map</h2>
                        <div style="background-color: black;height: 5px;width:50%;"></div>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="#">Members</a></li>
                    </ul>
                    <ul style="list-style-type: none;">
                        <h2>Explore</h2>
                        <div style="background-color: black;height: 5px;width:50%;"></div>
                        <li><a href="partners.html">FAQ</a></li>
                        <li><a href="contact.php">Feedback</a></li>
                        <li><a href="rent.php">Rent Space</a></li>
                        <li><a href="terms.html">Terms & Conditions</a></li>
                    </ul>
                </div><br><br>
                <div class="wrapper">
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-google fa-2x" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>



            <div id="right-footer">
                <h2 style="color: #ff4b20;"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;Where are we
                    located ?</h2>
                <br>
                <div>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3767.222610388061!2d72.85372091490721!3d19.22912765213814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7b0d6e771d27b%3A0xcfe3c6ecba9c4c92!2sBhandarkar%20Bhavan%2C%20Sundar%20Nagar%2C%20Borivali%20West%2C%20Mumbai%2C%20Maharashtra%20400092!5e0!3m2!1sen!2sin!4v1566710714948!5m2!1sen!2sin"
                        width="380" height="220" frameborder="0" style="border:0;" allowfullscreen="">
                    </iframe>
                </div>
            </div>
        </div>



        <div style="background-color: #1c1c1c;text-align:center;">
            <p style="color: white;">&copy;Copyright &nbsp;Parkinzo&nbsp; 2019</p>
        </div>
    </footer>
</body>

</html>