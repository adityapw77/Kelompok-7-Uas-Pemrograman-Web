<?php

session_start();

require_once 'koneksi.php';


function login($username, $password, $koneksi) {
    
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = mysqli_real_escape_string($koneksi, $password);

    
    $hashedPassword = md5($password);

    
    $query = "SELECT * FROM data_user WHERE user_name='$username' AND password='$hashedPassword'";
    $result = $koneksi->query($query);

    if ($result->num_rows == 1) {
        
        $_SESSION['user_name'] = $username;
        header("Location: index.php");
    } else {
      $_SESSION['error'] = true;  
      header("Location: login.php");
      exit();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

  
    login($inputUsername, $inputPassword, $koneksi);
}

$koneksi->close();
?>