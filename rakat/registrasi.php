<?php
SESSION_START();
include '../lib/database.php';

if (isset($_POST['daftar'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $telp = $_POST['telp'];

    $query = "INSERT INTO masyarakat (nik, nama, username, password, telp) VALUE ('$nik', '$nama', '$username', '$password', '$telp')";
    $execQuery = mysqli_query($konek, $query);

    if ($execQuery) {
        header('Location:/masyarakat_ngadu/index.php');
    } else {
        echo '<script>alert("input ada yang salah")</script>';
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Masyarakat</title>
    <link rel="stylesheet" href="../dist/css/bootstrap.min.css" type="text/css">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/masyarakat_ngadu/index.php" class="nav-link">Login</a>
                </li>
            </ul>
            <div>

            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row jutify-content-center align-middle">
            <div class="card col-lg-12">
                <div class="card-header">
                    <center>Register - Masyarakat</center>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <input type="text" name="nik" placeholder="Nik Anda" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="nama" placeholder="Nama Asli Anda" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="username" placeholder="Username Anda" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="password" placeholder="Password Anda" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="telp" placeholder="Nomor Telepon Anda" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="daftar" Value="Daftar" class="form-control btn btn-warning">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>