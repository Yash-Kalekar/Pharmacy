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
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $address = $_POST["address"];

    // Insert user data into the database
    $sql = "INSERT INTO logsign (fullName, email, password, address) VALUES (?, ?, ?, ?)";
    
    // Execute the SQL statement (make sure to establish a database connection first)
    // You should use prepared statements to prevent SQL injection
    // Replace 'your_db_connection' with your database connection code
    $stmt = $your_db_connection->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssss", $fullName, $email, $password, $address);
        if ($stmt->execute()) {
            // Registration successful, display an alert and redirect
            echo '<script type="text/javascript">alert("Registration successful!");</script>';
            echo '<script type="text/javascript">window.location = "login.html";</script>';
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
