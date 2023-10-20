<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "ssbaid";
$con = new mysqli($host, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);

    $query = "SELECT * FROM login WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        
        $_SESSION['logged_in'] = true;
        header("Location: welcome.php"); 
        
    } else {
        echo "Login failed. Please check your email and password.";
    }
}
?>
