<?php
SESSION_START();
include '../../lib/database.php';

if (($_SESSION['level'] != 'admin') AND ($_SESSION['level'] != 'petugas')) {
    header('Location:/masyarakat_ngadu/logout.php');
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "UPDATE pengaduan SET status='proses' WHERE id_pengaduan='$id'";
    $execQuery = mysqli_query($konek, $query);
    if ($execQuery) {
        header('Location:/masyarakat_ngadu/admin/verif/valid.php');
    } else {
        echo '<script>alert("ada yang salah")</script>';
    }
}

$queryTampil = "SELECT p.id_pengaduan as id_pengaduan, m.nama as nama, p.tgl_pengaduan as tgl_pengaduan, p.foto as foto, p.isi_laporan as isi_laporan, p.status as status FROM pengaduan p JOIN masyarakat m WHERE p.nik = m.nik AND status = '0';";
$execQueryTampil  = mysqli_query($konek, $queryTampil);
$getData = mysqli_fetch_all($execQueryTampil, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan - Valid</title>
    <link rel="stylesheet" href="../../dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="./nonvalid.php" class="nav-link">List - Nonvalid</a>
                </li>
                <li class="nav-item">
                    <a href="./valid.php" class="nav-link">List - Valid</a>
                </li>
                <li class="nav-item">
                    <a href="./proses.php" class="nav-link">List- Proses</a>
                </li>
                <li class="nav-item">
                    <a href="./selesai.php" class="nav-link">List - Selesai</a>
                </li>
                <li class="nav-item">
                    <a href="../registrasi.php" class="nav-link">Register</a>
                </li>
                <li class="nav-item">
                    <a href="../print.php" class="nav-link">Generte - Laporan</a>
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
            <center><h2>List Pengaduan - Valid</h2></center>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pengadu</th>
                        <th>Tanggal Aduan</th>
                        <th>Foto</th>
                        <th>Aduan</th>
                        <th>Status</th>
                        <th>Tanggapan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $no = 0;
                    foreach ($getData as $data) {
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
                                <td>$data[nama]</td>
                                <td>$data[tgl_pengaduan]</td>
                                <td>
                                <img src=$data[foto] class='img img-thumbnail' width=100px >
                                </td>
                                <td>$data[isi_laporan]</td>
                                <td>$status</td>
                                <td>
                                    <a href=/masyarakat_ngadu/admin/tanggapan.php?id=$data[id_pengaduan]>
                                        <button class='btn btn-danger'>
                                            Tanggapi                                     
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href=?id=$data[id_pengaduan]>
                                        <button class='btn btn-primary'>
                                            Akan Di Proses                                     
                                        </button>
                                    </a>
                                </td>
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