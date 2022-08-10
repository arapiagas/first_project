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

$maxRows_tampil_spp = 500;
$pageNum_tampil_spp = 0;
if (isset($_GET['pageNum_tampil_spp'])) {
  $pageNum_tampil_spp = $_GET['pageNum_tampil_spp'];
}
$startRow_tampil_spp = $pageNum_tampil_spp * $maxRows_tampil_spp;

$word = $_GET['word'];

mysql_select_db($database_koneksi, $koneksi);
$query_tampil_spp = "SELECT * FROM spp WHERE
                                      id_spp LIKE '%$word%' OR
                                      nisn LIKE '%$word%' OR
                                      tahun LIKE '%$word%' OR
                                      nominal LIKE '%$word%'";
$query_limit_tampil_spp = sprintf("%s LIMIT %d, %d", $query_tampil_spp, $startRow_tampil_spp, $maxRows_tampil_spp);
$tampil_spp = mysql_query($query_limit_tampil_spp, $koneksi) or die(mysql_error());
$row_tampil_spp = mysql_fetch_assoc($tampil_spp);

if (isset($_GET['totalRows_tampil_spp'])) {
  $totalRows_tampil_spp = $_GET['totalRows_tampil_spp'];
} else {
  $all_tampil_spp = mysql_query($query_tampil_spp);
  $totalRows_tampil_spp = mysql_num_rows($all_tampil_spp);
}
$totalPages_tampil_spp = ceil($totalRows_tampil_spp / $maxRows_tampil_spp) - 1;
?>

<div class="table-responsive">
  <table class="table table-bordered table-danger table-hover">
    <tr class="text-light font-weight-bold bg-danger">
      <td>Id SPP</td>
      <td>Nisn</td>
      <td>Tahun</td>
      <td>Nominal</td>
      <td>Update/Delete</td>
    </tr>
    <?php do { ?>
      <tr class="td">
        <td><?php echo $row_tampil_spp['id_spp']; ?></td>
        <td><?php echo $row_tampil_spp['nisn']; ?></td>
        <td><?php echo $row_tampil_spp['tahun']; ?></td>
        <td><?php echo $row_tampil_spp['nominal']; ?></td>
        <td><a class="btn btn-sm btn-success col-sm-2" href="update_spp.php?id_spp=<?php echo $row_tampil_spp['id_spp']; ?>"><i class="fas fa-edit"></i></a> <a onClick="return confirm('Apa kamu yakin igin menghapus Id SPP <?php echo $row_tampil_spp['id_spp']; ?>?');" class="btn btn-sm btn-danger col-sm-2" href="delete_spp.php?id_spp=<?php echo $row_tampil_spp['id_spp']; ?>"><i class="fas fa-trash"></i></a></td>
      </tr>
    <?php } while ($row_tampil_spp = mysql_fetch_assoc($tampil_spp)); ?>
  </table>
</div>
<?php
mysql_free_result($tampil_spp);
?>