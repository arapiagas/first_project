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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE laporan SET tahun=%s, nominal=%s, jumlah_bayar=%s, sisa_bayar=%s WHERE nisn=%s",
                       GetSQLValueString($_POST['tahun'], "undefined"),
                       GetSQLValueString($_POST['nominal'], "undefined"),
                       GetSQLValueString($_POST['jumlah_bayar'], "undefined"),
                       GetSQLValueString($_POST['sisa_bayar'], "undefined"),
                       GetSQLValueString($_POST['nisn'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "tampil_laporan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_koneksi, $koneksi);
$nisn = $_GET['nisn'];
$query_siswa = "SELECT nama FROM siswa WHERE nisn=$nisn";
$siswa = mysql_query($query_siswa, $koneksi) or die(mysql_error());
$row_siswa = mysql_fetch_assoc($siswa);
$totalRows_siswa = mysql_num_rows($siswa);

mysql_select_db($database_koneksi, $koneksi);
$nisn = $_GET['nisn']; 
$query_preview = "SELECT * FROM laporan WHERE nisn=$nisn";
$preview = mysql_query($query_preview, $koneksi) or die(mysql_error());
$row_preview = mysql_fetch_assoc($preview);
$totalRows_preview = mysql_num_rows($preview);
?>

<?php
	header("Content-type: application/vnd-ms-word");
	header("Content-Disposition: attachment; filename=Laporan_Pembayaran.doc");
	?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Preview</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="left">
  <tr valign="baseline">
      <td nowrap align="left">Nama</td>
      <td>:</td>
      <td align="left"><?php echo htmlentities($row_siswa['nama'], ENT_COMPAT, 'utf-8'); ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="left">Nisn</td>
      <td>:</td>
      <td align="left"><?php echo $row_preview['nisn']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="left">Tahun</td>
      <td>:</td>
      <td align="left"><?php echo htmlentities($row_preview['tahun'], ENT_COMPAT, 'utf-8'); ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="left">Nominal</td>
      <td>:</td>
      <td align="left"><?php echo htmlentities($row_preview['nominal'], ENT_COMPAT, 'utf-8'); ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="left">Jumlah Bayar</td>
      <td>:</td>
      <td align="left"><?php echo htmlentities($row_preview['jumlah_bayar'], ENT_COMPAT, 'utf-8'); ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="left">Sisa Bayar</td>
      <td>:</td>
      <td align="left"><?php echo htmlentities($row_preview['sisa_bayar'], ENT_COMPAT, 'utf-8'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="nisn" value="<?php echo $row_preview['nisn']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($siswa);

mysql_free_result($preview);
?>
