<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "p_booking";
$port = 3306;

$your_db_connection = new mysqli($host, $username, $password, $database, $port);

if ($your_db_connection->connect_error) {
    die("Connection failed: " . $your_db_connection->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect or handle the case where the user is not logged in
    header("Location: login.html");
    exit();
} 

// Fetch appointments associated with the logged-in user
$loggedInUser = $_SESSION['user']; // Assuming the username is stored in the session

// Fetch appointments from the database
$sql = "SELECT * FROM appointment WHERE fullName = '$loggedInUser'"; // Adjust the SQL query as per your database structure
$result = $your_db_connection->query($sql);
$currentDate = date("Y-m-d");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/datepicker.css">
    <link rel="stylesheet" href="assets/css/book.css">
        <!--BOX ICONS-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
</head>
    <!--HEADER-->
    <header class="header">
        <!--NAV-->
        <div class="nav-container">
            <span id="logo">
            <i class='bx bx-user' id="user-icon"></i>
            <?php 
                if (isset($_SESSION['user'])) {
                    echo $_SESSION['user']; // Display the logged-in user's name
                } else {
                    echo "Guest"; // Or handle the case where the user is not logged in
                }
            ?>
            </span>
            <a href="index.html" class="logo">Home</a>
            <a href="login.html" class="logo">Login</a>
            <a href="medicine.html" class="logo">Medicines</a>
            <a href="contact.html" class="logo">Contact</a>
        
                        <!--CART ICON-->
            <i class='bx bx-calendar' id="cart-icon"></i>
            
            
            <!--CART-->
            <div class="cart">
                <h2 class="cart-title">Your Appointments</h2>
                <!--CONTENT-->
                
                <div class="cart-content">
                <!-- Appointment details will be displayed here -->
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $appointmentDate = $row["Date"];
            // Check if the appointment date is in the future or today
            if ($appointmentDate >= $currentDate) {
                echo "<div class='cart-box'>";
                echo "ID: " . $row["randomId"] . "<br>";
                echo "Name: " . $row["fullName"] . "<br>";
                echo "Consultant: " . $row["consult"] . "<br>";
                echo "Date: " . $appointmentDate . "<br>";
                // ... Display other appointment details accordingly
                echo "</div>";
            }
        }
    } else {
        echo "No appointments found for $loggedInUser.";
    }
    $your_db_connection->close();
    ?>
                </div>
                <!--BUY BUTTON-->
                
                <!--Cart Close-->
                <i class="bx bx-x" id="close-cart"></i>
            </div>


    </header>

<body>
    
    <div class="inner-layer">
        <div class="container">
            <div class="row no-margin">
                <div class="col-sm-7">
                    <div class="content">
                        <h1>Book Your Slot Now and Save Your Time</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sagittis at lacus at rhoncus. Integer pharetra lacus vitae sapien blandit eleifend.</p>
                        <h2>For Help Call : +189-123-453</h2>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-data">
                        <div class="form-head">
                            <h2>Book Appointment</h2>
                        </div>

                        <div class="form-body">
                            <form id="appointment-form" action="connect.php" method="POST">

                                <input type="hidden" name="randomId" id="randomId">

                                <div class="row form-row">
                                    <input type="text" placeholder="Enter Full Name" class="form-control" id="full-name" name="fullName" required>
                                </div>
                                <div class="row form-row">
                                    <input type="text" placeholder="Enter Mobile Number" class="form-control" id="mobile-number" data-mask="0000000000" name="mNumber" required>
                                </div>
                                <div class="row form-row">
                                    <input type="email" placeholder="Enter Email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="row form-row">
                                    <input type="date" placeholder="Appointment Date" class="form-control" id="appointment-date" name="Date" required>
                                </div>
                                <div class="row form-row">
                                    <div class="col-sm-6">
                                        <select class="form-control" id="consultant" name="consult" required>
                                            <option value="" disabled selected>Select Consultant</option>
                                            <option value="General Physician" name ="consult">General Physician</option>
                                            <option value="Cardiologist"  name ="consult">Cardiologist</option>
                                            <option value="Pediatrician"  name ="consult">Pediatrician</option>
                                            <option value="Neurologist"  name ="consult">Neurologist</option>
                                            <option value="Dermatologist"  name ="consult">Dermatologist</option>
                                            <option value="Dentist"  name ="consult">Dentist</option>
                                            <option value="Hematologist"  name ="consult">Hematologist</option>
                                            <option value="Urology"  name ="consult">Urology</option>
                                            
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="Enter City" class="form-control" id="city" name="city" required>
                                    </div>
                                </div>
                                <div class="row form-row">
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="Enter Age" class="form-control" id="age" name="age" data-mask="00" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option name="gender" value="male">Male</option>
                                            <option name="gender" value="female">Female</option>
                                            <option name="gender" value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row form-row">
                                    <button type="submit" value="booking" name="submit" class="btn btn-success btn-custom">Book Appointment</button>
                                    <a href="index.html" class="btn btn-custom">Return Home</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="book.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</body>
</html>
