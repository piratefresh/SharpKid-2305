<?php
require_once("config.php");
session_start();

$Email = $_GET['Email'];
$Acode = $_GET['Acode'];

print "Got email($Email) Acode($Acode) \n";
// Connect to DB
$conn = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
print "connected";
// Build a query
$query = "SELECT * FROM Sharpkid WHERE Email='$Email' AND Acode='$Acode'";
$status = mysqli_query($conn, $query);
// Check the status
if ($status) {
    $rows = mysqli_num_rows($status);
    if ($rows == 1) { // Exact match. Authenticated. Ready to set password.
        $_SESSION["RegState"] = 2;
        header("Location: ../SignUpForm.html?Email=$Email");
        die();
    } else {
        $_SESSION["RegState"] = -3;
        $_SESSION["Message"] = "Authentication Failed: " . mysqli_error($con);
        header("Location: ../index.html");
        die();
    }
}

exit();
