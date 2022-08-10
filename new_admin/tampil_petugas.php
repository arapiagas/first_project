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

$maxRows_tampil_petugas = 500;
$pageNum_tampil_petugas = 0;
if (isset($_GET['pageNum_tampil_petugas'])) {
  $pageNum_tampil_petugas = $_GET['pageNum_tampil_petugas'];
}
$startRow_tampil_petugas = $pageNum_tampil_petugas * $maxRows_tampil_petugas;

mysql_select_db($database_koneksi, $koneksi);
$query_tampil_petugas = "SELECT * FROM petugas";
$query_limit_tampil_petugas = sprintf("%s LIMIT %d, %d", $query_tampil_petugas, $startRow_tampil_petugas, $maxRows_tampil_petugas);
$tampil_petugas = mysql_query($query_limit_tampil_petugas, $koneksi) or die(mysql_error());
$row_tampil_petugas = mysql_fetch_assoc($tampil_petugas);

if (isset($_GET['totalRows_tampil_petugas'])) {
  $totalRows_tampil_petugas = $_GET['totalRows_tampil_petugas'];
} else {
  $all_tampil_petugas = mysql_query($query_tampil_petugas);
  $totalRows_tampil_petugas = mysql_num_rows($all_tampil_petugas);
}
$totalPages_tampil_petugas = ceil($totalRows_tampil_petugas / $maxRows_tampil_petugas) - 1;
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Read_Petugas</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <style type="text/css">
    #img {
      width: 30px;
      height: 30px;
    }

    .td:nth-child(odd) {
      background: #ffe8a1;
    }
  </style>
</head>

<body>
  <p>&nbsp;</p>
  <h1>Data Petugas</h1>
  <h2><a href="create_petugas.php"><i class="fas fa-plus"></i> Create</a></h2>
  <div class="row mb-3">
    <form action="" method="post">
      <div class="col-sm-4">
        <div class="form-group form-inline">
          <input type="text" placeholder="Cari..." name="keyword" id="keyword" class="form-control">
          <img id="img" src="../loading.gif">
        </div>
      </div>
    </form>
  </div>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active"><i class="fas fa-table"></i> Tabel Data Petugas</li>
  </ol>
  <div id="container">
    <div class="table-responsive">
      <table id="tabel" class="table table-bordered table-warning table-hover">
        <tr class="text-light font-weight-bold bg-warning">
          <td>Id Petugas</td>
          <td>Username</td>
          <td>Password</td>
          <td>Nama Petugas</td>
          <td>Level</td>
          <td>Update/Delete</td>
        </tr>
        <?php do { ?>
          <tr class="td">
            <td><?php echo $row_tampil_petugas['id_petugas']; ?></td>
            <td><?php echo $row_tampil_petugas['username']; ?></td>
            <td><?php echo $row_tampil_petugas['password']; ?></td>
            <td><?php echo $row_tampil_petugas['nama_petugas']; ?></td>
            <td><?php echo $row_tampil_petugas['level']; ?></td>
            <td><a class="btn btn-sm btn-success col-sm-2" href="update_petugas.php?id_petugas=<?php echo $row_tampil_petugas['id_petugas']; ?>"><i class="fas fa-edit"></i></a> <a onClick="return confirm('Apa kamu yakin ingin menghapus Id Petugas <?php echo $row_tampil_petugas['id_petugas']; ?>?');" class="btn btn-sm btn-danger col-sm-2" href="delete_petugas.php?id_petugas=<?php echo $row_tampil_petugas['id_petugas']; ?>"><i class="fas fa-trash"></i></a></td>
          </tr>
        <?php } while ($row_tampil_petugas = mysql_fetch_assoc($tampil_petugas)); ?>
      </table>
    </div>
  </div>
  <script src="../js/jquery-3.5.1.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/all.min.js"></script>
  <script src="../js/script.js"></script>
  <script src="../js/petugas.js"></script>
</body>

</html>
<?php
mysql_free_result($tampil_petugas);
?>