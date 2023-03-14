<?php
SESSION_START();
include '../lib/database.php';

if (($_SESSION['level'] != 'admin') AND ($_SESSION['level'] != 'petugas')) {
    header('Location:/masyarakat_ngadu/logout.php');
}

if (empty($_GET['id'])) {
    header('Location:verif/valid.php');
}

if (isset($_POST['tanggap'])) {
    $id = $_GET['id'];
    $tanggapan = $_POST['tanggapan'];
    $id_petugas = $_SESSION['id'];
    $queryTanggapan = "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUE ('$id', now(), '$tanggapan', '$id_petugas');";
    var_dump($queryTanggapan);
    $execQueryTanggapan = mysqli_query($konek, $queryTanggapan);
    if ($execQueryTanggapan) {
        header('Location:./tanggapan.php');
    } else {
        echo '<script>alert("input ada yang salah")</script>';
    }
}

$id = $_GET['id'];
$queryAduan = "SELECT * FROM pengaduan WHERE id_pengaduan = '$id';";
$execQueryAduan = mysqli_query($konek, $queryAduan);
$getDataAduan = mysqli_fetch_all($execQueryAduan, MYSQLI_ASSOC);
foreach ($getDataAduan as $data) {
    if (($data['status'] != '0') AND ($data['status'] != 'proses')) {
        header('Location:verif/valid.php');
    }
}

$queryTampil = "SELECT p.nama_petugas as nama_petugas, t.tgl_tanggapan as tgl_tanggapan, t.tanggapan as tanggapan FROM petugas p JOIN tanggapan t WHERE p.id_petugas = t.id_petugas AND id_pengaduan='$id';";
$execQueryTampil = mysqli_query($konek, $queryTampil);
$getDataTanggap = mysqli_fetch_all($execQueryTampil, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanggapan</title>
    <link rel="stylesheet" href="../dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="./verif/nonvalid.php" class="nav-link">List - Nonvalid</a>
                </li>
                <li class="nav-item">
                    <a href="./verif/valid.php" class="nav-link">List - Valid</a>
                </li>
                <li class="nav-item">
                    <a href="./verif/proses.php" class="nav-link">List- Proses</a>
                </li>
                <li class="nav-item">
                    <a href="./verif/selesai.php" class="nav-link">List - Selesai</a>
                </li>
                <li class="nav-item">
                    <a href="./registrasi.php" class="nav-link">Register</a>
                </li>
                <li class="nav-item">
                    <a href="./print.php" class="nav-link">Generte - Laporan</a>
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
                    <center>Aduan</center>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Foto Penunjang</th>
                                <th>Tanggal Aduan</th>
                                <th>Isi Aduan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getDataAduan as $data) {
                                echo "
                                    <tr>
                                        <td>
                                            <img src=$data[foto] class='img img-thumbnail' width=100px >
                                        </td>
                                        <td>$data[tgl_pengaduan]</td>
                                        <td>$data[isi_laporan]</td>
                                    </tr>
                                ";
                            }
                            ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card col-lg-6 mb-6">
                <div class="card-header">
                    <center>Menulis - Tanggapan</center>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label>Isi Tangapan</label>
                            <textarea name="tanggapan" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="tanggap" Value="Tanggapi" class="form-control btn btn-danger">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center align-middle">
            <center><h2>List - Tanggpan</h2></center>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Tanggapan</th>
                        <th>Nama Penanggap</th>
                        <th>Isi Tanggapan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($getDataTanggap as $data) {
                        $no += 1;
                        echo "
                            <tr>
                                <td>$no</td>
                                <td>$data[tgl_tanggapan]</td>
                                <td>$data[nama_petugas]</td>
                                <td>$data[tanggapan]</td>
                            </tr>                        
                        ";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>