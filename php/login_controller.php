<?php
require_once("config.php");
session_start();

$Email = $_POST['LoginEmail'];
$Password1 = $_POST['LoginPassword'];
/* Captcha */
/* $captcha = $_POST['g-recaptcha-response']; */
/* if the captcha is not checked we exit the script */
/* if (!$captcha) {
    $_SESSION["RegState"] = -7;
    $_SESSION["Message"] = "Please Check Recaptcha" . mysqli_error($conn);
    header("Location: ../index.html");
    die();
} */
/* $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Ld8IZQUAAAAANpNHGn8DyxvGwq5nehjAZoYWcKu&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
if ($response . success == false) {
    echo 'You are spammer!';
} else { */
print "Got Email($Email) Password($Password1) \n";
// Connect to DB
$conn = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Build a query
$query = "SELECT * FROM Sharpkid WHERE Email='$Email' AND Password='$Password1'";
$status = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($status)) {
    $Username = $row['Username'];
}
if ($status) {
    $rows = mysqli_num_rows($status);
    $cookie_name = "user";
    setcookie($cookie_name, $Password1, time() + (86400 * 30), "/");
    if ($rows == 1) { // Exact match. Logged In.
        $_SESSION["RegState"] = 4;
        $_SESSION["Message"] = "Successfully Logged In" . mysqli_error($conn);
        /* Set Session with user info */
        $userData = [
            'email' => $Email,
            'username' => $Username,
            'loggedin' => true
        ];
        $_SESSION["UserJson"] = $userData;
        header("Location: ../menu.html");
        die();
    }
} else {
    $_SESSION["RegState"] = -6;
    $_SESSION["Message"] = "Login Failed" . mysqli_error($conn);
    header("Location: ../index.html");
    die();
}
$_SESSION["RegState"] = -4;
$_SESSION["Message"] = "Database access failure:" . mysqli_error($conn);
header("Location: ../index.html");
die();
/* } */
