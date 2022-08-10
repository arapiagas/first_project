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

$maxRows_tampil_siswa = 500;
$pageNum_tampil_siswa = 0;
if (isset($_GET['pageNum_tampil_siswa'])) {
  $pageNum_tampil_siswa = $_GET['pageNum_tampil_siswa'];
}
$startRow_tampil_siswa = $pageNum_tampil_siswa * $maxRows_tampil_siswa;

mysql_select_db($database_koneksi, $koneksi);
$query_tampil_siswa = "SELECT * FROM siswa";
$query_limit_tampil_siswa = sprintf("%s LIMIT %d, %d", $query_tampil_siswa, $startRow_tampil_siswa, $maxRows_tampil_siswa);
$tampil_siswa = mysql_query($query_limit_tampil_siswa, $koneksi) or die(mysql_error());
$row_tampil_siswa = mysql_fetch_assoc($tampil_siswa);

if (isset($_GET['totalRows_tampil_siswa'])) {
  $totalRows_tampil_siswa = $_GET['totalRows_tampil_siswa'];
} else {
  $all_tampil_siswa = mysql_query($query_tampil_siswa);
  $totalRows_tampil_siswa = mysql_num_rows($all_tampil_siswa);
}
$totalPages_tampil_siswa = ceil($totalRows_tampil_siswa / $maxRows_tampil_siswa) - 1;
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Read_Siswa</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <style type="text/css">
    #img {
      width: 30px;
      height: 30px;
    }

    .td:nth-child(odd) {
      background: #b1dfbb;
    }
  </style>
</head>

<body>
  <p>&nbsp;</p>
  <h1>Data Siswa</h1>
  <h2><a href="create_siswa.php"><i class="fas fa-plus"></i> Create</a></h2>
  <div class="row mb-3">
    <form action="" method="post">
      <div class="col-sm-4">
        <div class="form-group form-inline">
          <input type="text" placeholder="Cari..." name="saya" id="saya" class="form-control">
          <img id="img" src="../loading.gif">
        </div>
      </div>
    </form>
  </div>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active"><i class="fas fa-table"></i> Tabel Data Siswa</li>
  </ol>
  <div id="container">
    <div class="table-responsive">
      <table id="tabel" class="table table-bordered table-success table-hover">
        <tr class="text-light font-weight-bold bg-success">
          <td>Nisn</td>
          <td>Nis</td>
          <td>Nama</td>
          <td>Id Kelas</td>
          <td>Alamat</td>
          <td>No Telepon</td>
          <td>Id SPP</td>
          <td>Update/Delete</td>
        </tr>
        <?php do { ?>
          <tr class="td">
            <td><?php echo $row_tampil_siswa['nisn']; ?></td>
            <td><?php echo $row_tampil_siswa['nis']; ?></td>
            <td><?php echo $row_tampil_siswa['nama']; ?></td>
            <td><?php echo $row_tampil_siswa['id_kelas']; ?></td>
            <td><?php echo $row_tampil_siswa['alamat']; ?></td>
            <td><?php echo $row_tampil_siswa['no_telp']; ?></td>
            <td><?php echo $row_tampil_siswa['id_spp']; ?></td>
            <td><a class="btn btn-sm btn-success col-sm-2 sc" href="update_siswa.php?nisn=<?php echo $row_tampil_siswa['nisn']; ?>"><i class="fas fa-edit"></i></a> <a onClick="return confirm('Apa kamu yakin ingin menghapus Nisn <?php echo $row_tampil_siswa['nisn']; ?>?');" class="btn btn-sm btn-danger col-sm-2 dg" href="delete_siswa.php?nisn=<?php echo $row_tampil_siswa['nisn']; ?>"><i class="fas fa-trash"></i></a></td>
          </tr>
        <?php } while ($row_tampil_siswa = mysql_fetch_assoc($tampil_siswa)); ?>
      </table>
    </div>
  </div>
  <script src="../js/jquery-3.5.1.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/all.min.js"></script>
  <script src="../js/siswa.js"></script>
</body>

</html>
<?php
mysql_free_result($tampil_siswa);
?>