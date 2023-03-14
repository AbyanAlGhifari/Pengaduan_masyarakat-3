<?php
SESSION_START();
include 'lib/database.php';

if (isset($_SESSION['id'])) {
    if ($_SESSION['level'] == 'masyarakat'){
        header('Location:/masyarakat_ngadu/rakat/pengaduan.php');
    } else if (($_SESSION['level'] == 'admin' OR ($_SESSION['level'] == 'petugas'))) {
        header('Location:/masyarakat_ngadu/admin/verif/nonvalid.php');
    } else {
        header('Location:/masyarakat_ngadu/logout.php');
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM masyarakat WHERE username = '$username' AND password = '$password';";
    $execQuery = mysqli_query($konek, $query);
    $getData = mysqli_fetch_all($execQuery, MYSQLI_ASSOC);
    $numRows = mysqli_num_rows($execQuery);

    if ($numRows) {
        foreach ($getData as $data) {
            $_SESSION['id'] = $data['nik'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = 'masyarakat';
        }
        header('Location:rakat/pengaduan.php');
    } else {
        echo '<script>alert("username atau password ada yang salah")</script>';
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
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="" class="nav-link"></a>
                </li>
            </ul>
            <div>

            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center align-middle">
            <div class="card col-lg-6">
                <div class="card-header">
                    <center>Login - Masyarakat</center>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <input type="text" name="username" placeholder="Username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="Password" name="password" placeholder="Password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="login" Value="Login" class="form-control btn btn-primary">
                        </div>
                    </form>
                    <div class="d-flex flex-row justify-content-between">
                        <a href="rakat/registrasi.php" class="nav-link">Registrasi</a>
                        <a href="admin/index.php" class="nav-link">Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>