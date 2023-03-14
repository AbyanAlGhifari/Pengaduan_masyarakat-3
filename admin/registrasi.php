<?php
SESSION_START();
include '../lib/database.php';

if ($_SESSION['level'] != 'admin') {
    header('Location:/masyarakat_ngadu/logout.php');
}

if (isset($_POST['daftar'])) {
    $nama = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $telp = $_POST['telp'];
    $level = $_POST['level'];

    $query = "INSERT INTO petugas (nama, username, password, telp) VALUE ('$nama', '$username', '$password', '$telp', '$level')";
    $execQuery = mysqli_query($konek, $query);

    if ($execQuery) {
        header('Location:/masyarakat_ngadu/admin/index.php');
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
    <title>Register - Admin</title>
    <link rel="stylesheet" href="../dist/css/bootstrap.min.css" type="text/css">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="navbar-nav">
            <li class="nav-item">
                    <a href="/masyarakat_ngadu/admin/verif/nonvalid.php" class="nav-link">Back</a>
                </li>
                <li class="nav-item">
                    <a href="/masyarakat_ngadu/logout.php" class="nav-link">Login</a>
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
                    <center>Register - Admin</center>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <input type="text" name="nama_petugas" placeholder="Nama Asli Anda" class="form-control" required>
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
                            <select name="level" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                            </select>
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