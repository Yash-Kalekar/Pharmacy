<?php
session_start();

if (isset($_GET['logout'])) {
    logout();
} else {
    // Redirect to index if the user is not attempting to log out
    header("Location: index.html");
    exit;
}

function logout() {
    session_unset();
    session_destroy();
    header("Location: index.html");
    exit;
}
?>
