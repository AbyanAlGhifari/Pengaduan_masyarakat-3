<?php
SESSION_START();
include '../lib/database.php';

if ($_SESSION['level'] != 'admin') {
    header('Location:/masyarakat_ngadu/logout.php');
}

$queryAduan = "SELECT m.nama as nama, p.tgl_pengaduan as tgl_pengaduan, p.isi_laporan as isi_laporan, p.foto as foto, p.status as status FROM pengaduan p JOIN masyarakat m WHERE p.nik = m.nik";
$execQueryAduan = mysqli_query($konek, $queryAduan);
$getDataAduan = mysqli_fetch_all($execQueryAduan, MYSQLI_ASSOC);

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
    <div class="row justify-content-center align-middle">
        <center>
            <h2>List Pengaduan Masyarakat</h2>
        </center>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pengadu</th>
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
                                <td>$data[nama]</td>
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
</body>
<script>
    window.print()
</script>

</html>l