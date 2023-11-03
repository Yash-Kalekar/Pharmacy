<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database connection code here using mysqli
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
    $password = $_POST["password"];

    // Query to retrieve user data by fullName
    $sql = "SELECT * FROM logsign WHERE fullName = ?";

    // Execute the SQL statement (make sure to establish a database connection first)
    // You should use prepared statements to prevent SQL injection
    // Replace 'your_db_connection' with your database connection code
    $stmt = $your_db_connection->prepare($sql);
    $stmt->bind_param("s", $fullName);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (isset($user["password"])) {
            $storedPassword = $user["password"];
            $providedPassword = $password;

            if ($storedPassword !== null && $providedPassword !== null && strcasecmp(trim($providedPassword), trim($storedPassword)) == 0) {
                // Password is correct; user is authenticated
                session_start();
                $_SESSION["user"] = $fullName;

                // Check the referrer to determine the redirect
                if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'doctor.html') !== false) {
                    // If coming from doctor.html, redirect to book.php
                    header("Location: book.php");
                } else {
                    // If logging in from login.html or elsewhere, redirect to index.html or any other page
                    header("Location: index.html?fromLogin=true");
                }
                exit();
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "Password is not set for the user.";
        }
    } else {
        echo "Username not found";
    }

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    // Close your database connection here
}
?>
