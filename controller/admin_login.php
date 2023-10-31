<?php
include('connection.php');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($_COOKIE['credentials'])) {
        $encryptedConcatenated = $_COOKIE['credentials'];
        $concatenated = openssl_decrypt($encryptedConcatenated, "AES-128-CTR", "concatenated", 0, '1234567890123456');
        list($email, $password) = explode('-', $concatenated);

        echo "Welcome to the welcome page!<br>";
        echo "Decrypted Email: " . $email . "<br>";
        echo "Decrypted Password: " . $password;
    } else {
        $query = "SELECT * FROM login WHERE email = '$email'";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $storedEmail = $row['email'];
            $storedPassword = openssl_decrypt($row['password'], "AES-128-CTR", "password", 0, '1234567890123456');

            if ($email === $storedEmail && $password === $storedPassword) {
                $concatenated = $email . '-' . $password;
                $encryptedConcatenated = openssl_encrypt($concatenated, "AES-128-CTR", "concatenated", 0, '1234567890123456');

                setcookie('credentials', $encryptedConcatenated, time() + 3600, '/');

                header('Location: welcome.php');
                exit();
            } else {
                echo "Login failed. Please check your email and password.";
            }
        } else {
            echo "Login failed. Please check your email and password.";
        }
    }
} else {
    echo "Please enter both email and password.";
}
?>
