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

$maxRows_tampil_kelas = 500;
$pageNum_tampil_kelas = 0;
if (isset($_GET['pageNum_tampil_kelas'])) {
  $pageNum_tampil_kelas = $_GET['pageNum_tampil_kelas'];
}
$startRow_tampil_kelas = $pageNum_tampil_kelas * $maxRows_tampil_kelas;

$key = $_GET['key'];

mysql_select_db($database_koneksi, $koneksi);
$query_tampil_kelas = "SELECT * FROM kelas WHERE
                                        id_kelas LIKE '%$key%' OR
                                        nama_kelas LIKE '%$key%' OR
                                        kompetensi_keahlian LIKE '%$key%'";
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
<?php
mysql_free_result($tampil_kelas);
?>