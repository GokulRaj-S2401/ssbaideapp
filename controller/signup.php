<?php

 $host="localhost";
 $username="root";
 $password="";
 $database="ssbaid";
 $con=new mysqli($host,$username,$password,$database);
 if($con->connect_error){
     die("connection failed :".$con->connect_error);
    }
    else{
        echo("connect success");
    }
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = openssl_encrypt($_POST['password'], "AES-128-CTR", "password", 0, '1234567890123456');
        $query = "INSERT INTO login (email, password) VALUES ('$email', '$password')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "Signup successful. You can now log in.";
        }   
        else {
            echo "Signup failed. Please try again.";
        }
    } 
else {
    echo "Please enter both email and password.";
}
?>
