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

$keyword = $_GET["keyword"];

mysql_select_db($database_koneksi, $koneksi);
$query_tampil_petugas = "SELECT * FROM petugas WHERE
                                                id_petugas LIKE '%$keyword%' OR
                                                username LIKE '%$keyword%' OR
                                                password LIKE '%$keyword%' OR
                                                nama_petugas LIKE '%$keyword%' OR
                                                level LIKE '%$keyword%'";
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
<?php
mysql_free_result($tampil_petugas);
?>