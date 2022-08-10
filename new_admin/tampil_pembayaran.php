<?php 

if (!isset($_GET['page'])){
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('location:../gagal.php');
  }
}

 ?>

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

$maxRows_tampil_pembayaran = 500;
$pageNum_tampil_pembayaran = 0;
if (isset($_GET['pageNum_tampil_pembayaran'])) {
  $pageNum_tampil_pembayaran = $_GET['pageNum_tampil_pembayaran'];
}
$startRow_tampil_pembayaran = $pageNum_tampil_pembayaran * $maxRows_tampil_pembayaran;

mysql_select_db($database_koneksi, $koneksi);
$query_tampil_pembayaran = "SELECT * FROM pembayaran";
$query_limit_tampil_pembayaran = sprintf("%s LIMIT %d, %d", $query_tampil_pembayaran, $startRow_tampil_pembayaran, $maxRows_tampil_pembayaran);
$tampil_pembayaran = mysql_query($query_limit_tampil_pembayaran, $koneksi) or die(mysql_error());
$row_tampil_pembayaran = mysql_fetch_assoc($tampil_pembayaran);

if (isset($_GET['totalRows_tampil_pembayaran'])) {
  $totalRows_tampil_pembayaran = $_GET['totalRows_tampil_pembayaran'];
} else {
  $all_tampil_pembayaran = mysql_query($query_tampil_pembayaran);
  $totalRows_tampil_pembayaran = mysql_num_rows($all_tampil_pembayaran);
}
$totalPages_tampil_pembayaran = ceil($totalRows_tampil_pembayaran / $maxRows_tampil_pembayaran) - 1;
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Read_Pembayaran</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <style type="text/css">
    #img {
      width: 30px;
      height: 30px;
    }

    .td:nth-child(odd) {
      background: #ececf6;
    }
  </style>
</head>

<body>
  <p>&nbsp;</p>
  <h1>Data Pembayaran</h1>
  <h2><a href="create_pembayaran.php"><i class="fas fa-plus"></i> Create</a></h2>
  <div class="row mb-3">
    <form action="" method="post">
      <div class="col-sm-4">
        <div class="form-group form-inline">
          <input type="text" placeholder="Cari..." name="kw" id="kw" class="form-control">
          <img id="img" src="../loading.gif">
        </div>
      </div>
    </form>
  </div>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active"><i class="fas fa-table"></i> Tabel Data Pembayaran</li>
  </ol>
  <div id="container">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <tr class="font-weight-bold bg-secondary text-light">
          <td>Id Pembayaran</td>
          <td>Id Petugas</td>
          <td>Nisn</td>
          <td>Tanggal Bayar</td>
          <td>Bulan Dibayar</td>
          <td>Tahun Dibayar</td>
          <td>Id SPP</td>
          <td>Jumlah Bayar</td>
          <td>Keterangan</td>
          <td>Update/Delete</td>
        </tr>
        <?php do { ?>
          <tr class="td">
            <td><?php echo $row_tampil_pembayaran['id_pembayaran']; ?></td>
            <td><?php echo $row_tampil_pembayaran['id_petugas']; ?></td>
            <td><?php echo $row_tampil_pembayaran['nisn']; ?></td>
            <td><?php echo $row_tampil_pembayaran['tgl_bayar']; ?></td>
            <td><?php echo $row_tampil_pembayaran['bulan_dibayar']; ?></td>
            <td><?php echo $row_tampil_pembayaran['tahun_dibayar']; ?></td>
            <td><?php echo $row_tampil_pembayaran['id_spp']; ?></td>
            <td><?php echo $row_tampil_pembayaran['jumlah_bayar']; ?></td>
            <?php if ($row_tampil_pembayaran['keterangan'] == "Lunas") { ?>
            <td class="font-weight-bold text-success"><?php echo $row_tampil_pembayaran['keterangan']; ?></td>
            <?php } elseif ($row_tampil_pembayaran['keterangan'] == "Belum Lunas") { ?>
            <td class="font-weight-bold text-danger"><?php echo $row_tampil_pembayaran['keterangan']; ?></td>
            <?php } ?>
            <td><a class="btn btn-sm btn-success col-sm-4" href="update_pembayaran.php?id_pembayaran=<?php echo $row_tampil_pembayaran['id_pembayaran']; ?>"><i class="fas fa-edit"></i></a> <a class="btn btn-sm btn-danger col-sm-4" onClick="return confirm('Apa kamu yakin ingin menghapus Id Pembayaran <?php echo $row_tampil_pembayaran['id_pembayaran'];?>?');" href="delete_pembayaran.php?id_pembayaran=<?php echo $row_tampil_pembayaran['id_pembayaran']; ?>"><i class="fas fa-trash"></i> </a></td>
          </tr>
        <?php } while ($row_tampil_pembayaran = mysql_fetch_assoc($tampil_pembayaran)); ?>
      </table>
    </div>
  </div>
  <script src="../js/jquery-3.5.1.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/all.min.js"></script>
  <script src="../js/pembayaran.js"></script>
</body>

</html>
<?php
mysql_free_result($tampil_pembayaran);
?>