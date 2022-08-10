<?php require_once('../Connections/koneksi.php'); ?>
<?php
session_start();
if (!isset($_SESSION['siswa'])) {
  header('location:../gagal.php');
}
?>
<?php
$ed = $_SESSION['nama_petugas']; ?>
<?php
if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
  {
    if (PHP_VERSION < 6) {
      $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }
}

$id = $_SESSION['id_petugas'];
mysql_select_db($database_koneksi, $koneksi);
$query_petugas = "SELECT * FROM pembayaran WHERE id_petugas=$id";
$petugas = mysql_query($query_petugas, $koneksi) or die(mysql_error());
$row_petugas = mysql_fetch_assoc($petugas);
$totalRows_petugas = mysql_num_rows($petugas);

$maxRows_petugas = 500;
$pageNum_petugas = 0;
if (isset($_GET['pageNum_petugas'])) {
  $pageNum_petugas = $_GET['pageNum_petugas'];
}
$startRow_petugas = $pageNum_petugas * $maxRows_petugas;

mysql_select_db($database_koneksi, $koneksi);
$query_join_history = "SELECT pembayaran.id_petugas,siswa.nama,pembayaran.nisn,pembayaran.tgl_bayar,pembayaran.bulan_dibayar,pembayaran.tahun_dibayar,spp.nominal,pembayaran.jumlah_bayar,pembayaran.keterangan FROM pembayaran JOIN siswa ON pembayaran.nisn = siswa.nisn JOIN spp ON pembayaran.nisn = spp.nisn WHERE id_petugas=$id";
$join_history = mysql_query($query_join_history, $koneksi) or die(mysql_error());
$row_join_history = mysql_fetch_assoc($join_history);
$totalRows_join_history = mysql_num_rows($join_history);

$maxRows_join_history = 500;
$pageNum_join_history = 0;
if (isset($_GET['pageNum_join_history'])) {
  $pageNum_join_history = $_GET['pageNum_join_history'];
}
$startRow_join_history = $pageNum_join_history * $maxRows_join_history;
?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>History</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <style type="text/css">
    .td:nth-child(odd) {
      background: #f1b0b7;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">Siswa</a>
    <ul class="navbar-nav">
      <li class="nav-item text-nowrap">
        <a class="nav-item active nav-link" onclick="return confirm('Apakah kamu sudah yakin ingin logout <?php echo $ed; ?>?');" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </nav>

  <h1>&nbsp;</h1>
  <h1 class="breadcrumb mb-4">Selamat Datang <?php echo $ed; ?> <i class="fas fa-smile"></i></h1>

  <h1>Data History</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active"><i class="fas fa-history"></i> History Pembayaran</li>
  </ol>

  <div class="table-responsive">
    <table class="table table-bordered table-danger table-hover">
      <tr class="font-weight-bold text-light bg-danger">
        <td style="display: none;">Id Petugas</td>
        <td>Id Pembayaran</td>
        <td>Nama</td>
        <td>Nisn</td>
        <td>Tgl Bayar</td>
        <td>Bulan Dibayar</td>
        <td>Tahun Dibayar</td>
        <td>Nominal</td>
        <td>Jumlah Bayar</td>
        <td>Keterangan</td>
      </tr>
      <?php do { ?>
        <?php do { ?>
          <tr class="td">
            <td style="display: none;"><?php echo $row_join_history['id_petugas']; ?></td>
            <td><?php echo $row_petugas['id_pembayaran']; ?></td>
            <td><?php echo $row_join_history['nama']; ?></td>
            <td><?php echo $row_join_history['nisn']; ?></td>
            <td><?php echo $row_join_history['tgl_bayar']; ?></td>
            <td><?php echo $row_join_history['bulan_dibayar']; ?></td>
            <td><?php echo $row_join_history['tahun_dibayar']; ?></td>
            <td><?php echo $row_join_history['nominal']; ?></td>
            <td><?php echo $row_join_history['jumlah_bayar']; ?></td>
            <?php if ($row_join_history['keterangan'] == "Lunas") { ?>
            <td class="text-success font-weight-bold"><?php echo $row_join_history['keterangan']; ?></td>
            <?php } elseif ($row_join_history['keterangan'] == "Belum Lunas") { ?>
            <td class="text-danger font-weight-bold"><?php echo $row_join_history['keterangan']; ?></td>
            <?php } ?>
          </tr>
        <?php } while ($row_petugas = mysql_fetch_assoc($petugas)); ?>
      <?php } while ($row_join_history = mysql_fetch_assoc($join_history)); ?>
    </table>
  </div>
  <footer class="footer mt-auto py-3 bottom">
    <div class="container">
      <span class="text-muted">Copyright &copy; SMK MA'ARIF WALISONGO KAJORAN 2021</span>
    </div>
  </footer>
  <script src="../js/jquery-3.5.1.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/all.min.js"></script>
</body>

</html>
<?php
mysql_free_result($petugas);

mysql_free_result($join_history);
?>