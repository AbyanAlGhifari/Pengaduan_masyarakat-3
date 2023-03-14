<?php
SESSION_START();
include '../lib/database.php';

if ($_SESSION['level'] != 'masyarakat') {
    header('Location:/masyarakat_ngadu/logout.php');
}

$id = $_SESSION['id'];
$queryAduan = "SELECT * FROM pengaduan WHERE nik='$id'";
$execQueryAduan = mysqli_query($konek, $queryAduan);
$getDataAduan = mysqli_fetch_all($execQueryAduan, MYSQLI_ASSOC);

if (isset($_POST['adukan'])) {
    $pengaduan = $_POST['pengaduan'];

    $locationTemp = $_FILES['foto']['tmp_name'];
    $uploadFile = '../assets/img/';
    $ServerName = 'http://localhost/masyarakat_ngadu/assets/img/';

    $fileName = str_replace(' ', '', $_FILES['foto']['name']);
    $locationUpload = $uploadFile . $fileName;
    move_uploaded_file($locationTemp, $locationUpload);

    $query = "INSERT INTO pengaduan (tgl_pengaduan, nik, isi_laporan, foto, status) VALUE (now(),'$id','$pengaduan','$ServerName$fileName', NULL)";
    $execQuery = mysqli_query($konek, $query);
    if ($execQuery) {
        header('Location:/masyarakat_ngadu/rakat/pengaduan.php');
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
    <title>Menulis - Pengaduan</title>
    <link rel="stylesheet" href="../dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/masyarakat_ngadu/rakat/pengaduan.php" class="nav-link">Menulis - Pengajuan</a>
                </li>
            </ul>
            <div>
                <?php
                echo $_SESSION['nama'] . ' ' . '<a href="/masyarakat_ngadu/logout.php">Logout</a>';
                ?>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center align-middle">
            <div class="card col-lg-6">
                <div class="card-header">
                    <center>Menulis - Pengaduan</center>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Foto Penunjang</label>
                            <input type="file" name="foto" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Isi Laporan</label>
                            <textarea name="pengaduan" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="adukan" Value="Adukan" class="form-control btn btn-danger">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center align-middle">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Aduan</th>
                        <th>Foto</th>
                        <th>Isi Aduan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($getDataAduan as $data) {
                        if ($data['status'] == NULL) {
                            $status = "Belum Valid";
                        } else if ($data['status'] == '0') {
                            $status = "Valid";
                        } else {
                            $status = $data['status'];
                        }
                        $no += 1;
                        echo "
                            <tr>
                                <td>$no</td>
                                <td>$data[tgl_pengaduan]</td>
                                <td>
                                <img src=$data[foto] class='img img-thumbnail' width=100px >
                                </td>
                                <td>$data[isi_laporan]</td>
                                <td>$status</td>
                            </tr>                        
                        ";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>l