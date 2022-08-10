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

$saya = $_GET['saya'];

mysql_select_db($database_koneksi, $koneksi);
$query_tampil_siswa = "SELECT * FROM siswa WHERE
                                          nisn LIKE '%$saya%' OR
                                          nis LIKE '%$saya%' OR
                                          nama LIKE '%$saya%' OR
                                          id_kelas LIKE '%$saya%' OR
                                          alamat LIKE '%$saya%' OR
                                          no_telp LIKE '%$saya%' OR
                                          id_spp LIKE '%$saya%'";
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

<div class="table-responsive">
  <table id="tabel" class="table table-bordered table-success table-hover">
    <tr class="text-light font-weight-bold bg-success">
      <td>Nisn</td>
      <td>Nis</td>
      <td>Nama</td>
      <td>Id Kelas</td>
      <td>Alamat</td>
      <td>No Telephone</td>
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
        <td><a class="btn btn-sm btn-success col-sm-2" href="update_siswa.php?nisn=<?php echo $row_tampil_siswa['nisn']; ?>"><i class="fas fa-edit"></i></a> <a onClick="return confirm('Apa kamu yakin ingin menghapus Nisn <?php echo $row_tampil_siswa['nisn']; ?>?');" class="btn btn-sm btn-danger col-sm-2" href="delete_siswa.php?nisn=<?php echo $row_tampil_siswa['nisn']; ?>"><i class="fas fa-trash"></i></a></td>
      </tr>
    <?php } while ($row_tampil_siswa = mysql_fetch_assoc($tampil_siswa)); ?>
  </table>
</div>
<?php
mysql_free_result($tampil_siswa);
?>