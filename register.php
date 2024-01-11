<?php
session_start();

require_once 'koneksi.php';


function register($nama,$username, $password, $koneksi) {
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = mysqli_real_escape_string($koneksi, $password);

    
    $hashedPassword = md5($password);

    
    $checkQuery = "SELECT * FROM data_user WHERE user_name='$username'";
    $checkResult = $koneksi->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "Username already exists. Please choose a different one.";
        
    } else {
      
        $insertQuery = "INSERT INTO data_user (nama,user_name, password) VALUES ('$nama','$username', '$hashedPassword')";
        if ($koneksi->query($insertQuery) === TRUE) {
          echo "<script>
          alert('register berhasil')
          document.location.href = 'user.php'
          </script>";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $koneksi->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputnama = $_POST['namaLengkap'];
    $inputUsername = $_POST['userName'];
    $inputPassword = $_POST['passwordUser'];

    
    register($inputnama,$inputUsername, $inputPassword, $koneksi);
}


$koneksi->close();
?>
