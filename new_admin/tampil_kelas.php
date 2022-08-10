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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_tampil_kelas = 500;
$pageNum_tampil_kelas = 0;
if (isset($_GET['pageNum_tampil_kelas'])) {
  $pageNum_tampil_kelas = $_GET['pageNum_tampil_kelas'];
}
$startRow_tampil_kelas = $pageNum_tampil_kelas * $maxRows_tampil_kelas;

mysql_select_db($database_koneksi, $koneksi);
$query_tampil_kelas = "SELECT * FROM kelas";
$query_limit_tampil_kelas = sprintf("%s LIMIT %d, %d", $query_tampil_kelas, $startRow_tampil_kelas, $maxRows_tampil_kelas);
$tampil_kelas = mysql_query($query_limit_tampil_kelas, $koneksi) or die(mysql_error());
$row_tampil_kelas = mysql_fetch_assoc($tampil_kelas);

if (isset($_GET['totalRows_tampil_kelas'])) {
  $totalRows_tampil_kelas = $_GET['totalRows_tampil_kelas'];
} else {
  $all_tampil_kelas = mysql_query($query_tampil_kelas);
  $totalRows_tampil_kelas = mysql_num_rows($all_tampil_kelas);
}
$totalPages_tampil_kelas = ceil($totalRows_tampil_kelas / $maxRows_tampil_kelas) - 1;
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Read_Kelas</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <style type="text/css">
    #i {
      height: 30px;
      width: 30px;
    }

    .td:nth-child(odd) {
      background: #9fcdff;
    }
  </style>
</head>

<body>
  <p>&nbsp;</p>
  <h1>Data Kelas</h1>
  <h2><a href="create_kelas.php"><i class="fas fa-plus"></i> Create</a></h2>
  <div class="row mb-3">
    <form action="" method="post">
      <div class="col-sm-4">
        <div class="form-group form-inline">
          <input type="text" placeholder="Cari..." name="key" id="key" class="form-control">
          <img id="i" src="../loading.gif">
        </div>
      </div>
    </form>
  </div>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active"><i class="fas fa-table"></i> Tabel Data Kelas</li>
  </ol>
  <div id="container">
    <div class="table-responsive">
      <table class="table table-bordered table-primary table-hover">
        <tr class="text-light font-weight-bold bg-primary">
          <td>Id Kelas</td>
          <td>Nama Kelas</td>
          <td>Kompetensi Keahlian</td>
          <td>Update/Delete</td>
        </tr>
        <?php do { ?>
          <tr class="td">
            <td><?php echo $row_tampil_kelas['id_kelas']; ?></td>
            <td><?php echo $row_tampil_kelas['nama_kelas']; ?></td>
            <td><?php echo $row_tampil_kelas['kompetensi_keahlian']; ?></td>
            <td><a class="btn btn-sm btn-success col-sm-2" href="update_kelas.php?id_kelas=<?php echo $row_tampil_kelas['id_kelas']; ?>"><i class="fas fa-edit"></i></a> <a onClick="return confirm('Apa kamu yakin ingin menghapus Id Kelas <?php echo $row_tampil_kelas['id_kelas']; ?>?');" class="btn btn-sm btn-danger col-sm-2" href="delete_kelas.php?id_kelas=<?php echo $row_tampil_kelas['id_kelas']; ?>"><i class="fas fa-trash"></i></a></td>
          </tr>
        <?php } while ($row_tampil_kelas = mysql_fetch_assoc($tampil_kelas)); ?>
      </table>
    </div>
  </div>

  <script src="../js/jquery-3.5.1.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../all.min.js"></script>
  <script src="../js/kelas.js"></script>

</body>

</html>
<?php
mysql_free_result($tampil_kelas);
?>