<?php require_once('../Connections/koneksi.php'); ?>
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

$maxRows_join_history = 500;
$pageNum_join_history = 0;
if (isset($_GET['pageNum_join_history'])) {
  $pageNum_join_history = $_GET['pageNum_join_history'];
}
$startRow_join_history = $pageNum_join_history * $maxRows_join_history;

mysql_select_db($database_koneksi, $koneksi);
$query_join_history = "SELECT pembayaran.id_pembayaran,siswa.nama,pembayaran.nisn,pembayaran.tgl_bayar,pembayaran.bulan_dibayar,pembayaran.tahun_dibayar,spp.nominal,pembayaran.jumlah_bayar, pembayaran.keterangan FROM pembayaran JOIN siswa ON pembayaran.nisn = siswa.nisn JOIN spp ON pembayaran.nisn = spp.nisn";
$query_limit_join_history = sprintf("%s LIMIT %d, %d", $query_join_history, $startRow_join_history, $maxRows_join_history);
$join_history = mysql_query($query_limit_join_history, $koneksi) or die(mysql_error());
$row_join_history = mysql_fetch_assoc($join_history);

if (isset($_GET['totalRows_join_history'])) {
  $totalRows_join_history = $_GET['totalRows_join_history'];
} else {
  $all_join_history = mysql_query($query_join_history);
  $totalRows_join_history = mysql_num_rows($all_join_history);
}
$totalPages_join_history = ceil($totalRows_join_history / $maxRows_join_history) - 1;
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Historyt</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/all.min.css">\
  <style type="text/css">
    .td:nth-child(odd) {
      background: #c8cbcf;
    }
  </style>
</head>

<body>
  <h1>&nbsp;</h1>
  <h1 class="text-dark">Data History</h1>
  <ol class="breadcrumb mb-4 bg-dark">
    <li class="breadcrumb-item active text-light"><i class="fas fa-history"></i> History Pembayaran</li>
  </ol>
  <div class="table-responsive">
    <table class="table table-bordered table-secondary table-hover">
      <tr class="font-weight-bold bg-dark text-light">
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
        <tr class="td">
          <td><?php echo $row_join_history['id_pembayaran']; ?></td>
          <td><?php echo $row_join_history['nama']; ?></td>
          <td><?php echo $row_join_history['nisn']; ?></td>
          <td><?php echo $row_join_history['tgl_bayar']; ?></td>
          <td><?php echo $row_join_history['bulan_dibayar']; ?></td>
          <td><?php echo $row_join_history['tahun_dibayar']; ?></td>
          <td><?php echo $row_join_history['nominal']; ?></td>
          <td><?php echo $row_join_history['jumlah_bayar']; ?></td>
          <?php if ($row_join_history['keterangan'] == "Lunas") { ?>
          <td class="font-weight-bold text-success"><?php echo $row_join_history['keterangan']; ?></td>
        <?php } elseif ($row_join_history['keterangan'] == "Belum Lunas") { ?>
          <td class="font-weight-bold text-danger"><?php echo $row_join_history['keterangan']; ?></td>
        <?php } ?>
        </tr>
      <?php } while ($row_join_history = mysql_fetch_assoc($join_history)); ?>
    </table>
  </div>
  <script src="../js/jquery-3.5.1.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/all.min.js"></script>
</body>

</html>
<?php
mysql_free_result($join_history);
?>