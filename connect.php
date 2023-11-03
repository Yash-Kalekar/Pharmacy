<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database connection code here (e.g., using mysqli or PDO)
$host = "localhost"; // Your database host
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "p_booking"; // Your database name
$port = 3306;

// Create a mysqli connection
$your_db_connection = new mysqli($host, $username, $password, $database, $port);

// Check for connection errors
if ($your_db_connection->connect_error) {
    die("Connection failed: " . $your_db_connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $randomId = mt_rand(100000, 999999);
    $fullName = $_POST["fullName"];
    $mNumber = $_POST["mNumber"];
    $email = $_POST["email"];
    $Date = $_POST["Date"];
    $consult = $_POST["consult"];
    $city = $_POST["city"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    

    // Insert user data into the database
    $sql = "INSERT INTO appointment (randomId, fullName, mNumber, email, Date, consult, city, age, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Execute the SQL emailment (make sure to establish a database connection first)
    // You should use prepared emailments to prevent SQL injection
    // Replace 'your_db_connection' with your database connection code
    $stmt = $your_db_connection->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("issssssss", $randomId, $fullName, $mNumber, $email, $Date, $consult, $city, $age, $gender);
        if ($stmt->execute()) {
            // Registration successful, display an alert and redirect
            echo '<script type="text/javascript">alert("Booking successful!");</script>';
            echo '<script type="text/javascript">window.location = "book.php";</script>';
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error in preparing the SQL statement: " . $your_db_connection->error;
    }

    // Close your database connection here
    $your_db_connection->close();
}
?>
