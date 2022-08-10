<?php require_once('../Connections/koneksi.php'); ?>
<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('location:../gagal.php');
  }
  ?>
  <?php
  $ad = $_SESSION['nama_petugas']; ?>
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
  $updateSQL = sprintf("UPDATE pembayaran SET id_petugas=%s, nisn=%s, tgl_bayar=%s, bulan_dibayar=%s, tahun_dibayar=%s, id_spp=%s, jumlah_bayar=%s, keterangan=%s WHERE id_pembayaran=%s",
                       GetSQLValueString($_POST['id_petugas'], "int"),
                       GetSQLValueString($_POST['nisn'], "int"),
                       GetSQLValueString($_POST['tgl_bayar'], "date"),
                       GetSQLValueString($_POST['bulan_dibayar'], "text"),
                       GetSQLValueString($_POST['tahun_dibayar'], "text"),
                       GetSQLValueString($_POST['id_spp'], "int"),
                       GetSQLValueString($_POST['jumlah_bayar'], "int"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['id_pembayaran'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "home.php?page=pembayaran";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_koneksi, $koneksi);
$id = $_GET['id_pembayaran'];
$query_update_pembayaran = "SELECT * FROM pembayaran WHERE id_pembayaran=$id";
$update_pembayaran = mysql_query($query_update_pembayaran, $koneksi) or die(mysql_error());
$row_update_pembayaran = mysql_fetch_assoc($update_pembayaran);
$totalRows_update_pembayaran = mysql_num_rows($update_pembayaran);
?>
<!doctype html>
<html>
  <head>
    <title>Update data Pembayaran</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/all.min.css">
<style>
    body {
      padding-top: 1.7rem;
    }

    .navbar {
      border-bottom: 4px solid #FF0000;
    }
  </style>
</head>

<body style="background: #021C1E">


  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="home.php?page=admin">Administrator</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">CRUD DATA</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="home.php?page=kelas">Kelas</a><br>
            <a class="dropdown-item" href="home.php?page=petugas">Petugas</a><br>
            <a class="dropdown-item" href="home.php?page=spp">SPP</a><br>
            <a class="dropdown-item" href="home.php?page=siswa">Siswa</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transaksi</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="home.php?page=pembayaran">Pembayaran</a>
            <a class="dropdown-item" href="home.php?page=history">History</a>
            <a class="dropdown-item" href="home.php?page=laporan">Generate Laporan</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create data</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="create_kelas.php">Kelas</a>
            <a class="dropdown-item" href="create_petugas.php">Petugas</a>
            <a class="dropdown-item" href="create_spp.php">SPP</a>
            <a class="dropdown-item" href="create_siswa.php">Siswa</a>
            <a class="dropdown-item" href="create_pembayaran.php">Pembayaran</a>
          </div>
        </li>
        <li class="nav-item active">
          <a onclick="return confirm('Apakah kamu sudah yakin ingin logout <?php echo $ad; ?>?');" href="logout.php" class="nav-link">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </nav>



<form style="background: #004445; color: #2C7873; border: 0; border-radius: 5px; margin-top: 33px;" class="form-signin" method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <div>
      <label for="id_pembayaran">Id Pembayaran = <?php echo $row_update_pembayaran['id_pembayaran']; ?></label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" class="form-control" id="id_petugas" name="id_petugas" value="<?php echo htmlentities($row_update_pembayaran['id_petugas'], ENT_COMPAT, ''); ?>" size="32">
      <label for="id_petugas">Id Petugas</label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" class="form-control" id="nisn" name="nisn" value="<?php echo htmlentities($row_update_pembayaran['nisn'], ENT_COMPAT, ''); ?>" size="32">
      <label for="nisn">Nisn</label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="tgl_bayar" class="form-control" name="tgl_bayar" value="<?php echo htmlentities($row_update_pembayaran['tgl_bayar'], ENT_COMPAT, ''); ?>" size="32">
      <label for="tgl_bayar">Tgl Bayar</label>
    </div>
    <div>
      <select class="form-control" name="bulan_dibayar">
        <option disabled value="Bulan Bayar">Bulan Bayar</option>
        <option value="Januari" <?php if (!(strcmp("Januari", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Januari</option>
        <option value="Februari" <?php if (!(strcmp("Februari", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Februari</option>
        <option value="Maret" <?php if (!(strcmp("Maret", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Maret</option>
        <option value="April" <?php if (!(strcmp("April", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>April</option>
        <option value="Mei" <?php if (!(strcmp("Mei", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Mei</option>
        <option value="Juni" <?php if (!(strcmp("Juni", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Juni</option>
        <option value="Juli" <?php if (!(strcmp("Juli", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Juli</option>
        <option value="Agustus" <?php if (!(strcmp("Agustus", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Agustus</option>
        <option value="September" <?php if (!(strcmp("September", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>September</option>
        <option value="Oktober" <?php if (!(strcmp("Oktober", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Oktober</option>
        <option value="November" <?php if (!(strcmp("November", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>November</option>
        <option value="Desember" <?php if (!(strcmp("Desember", htmlentities($row_update_pembayaran['bulan_dibayar'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Desember</option>
      </select>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="tahun_dibayar" class="form-control" name="tahun_dibayar" value="<?php echo htmlentities($row_update_pembayaran['tahun_dibayar'], ENT_COMPAT, ''); ?>" size="32">
      <label for="tahun_dibayar">Tahun Dibayar</label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="id_spp" class="form-control" name="id_spp" value="<?php echo htmlentities($row_update_pembayaran['id_spp'], ENT_COMPAT, ''); ?>" size="32">
      <label for="id_spp">Id SPP</label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="jumlah_bayar" class="form-control" name="jumlah_bayar" value="<?php echo htmlentities($row_update_pembayaran['jumlah_bayar'], ENT_COMPAT, ''); ?>" size="32">
      <label for="jumlah_bayar">Jumlah Bayar</label>
    </div>
    <div>
         <select class="form-control" name="keterangan">
           <option value="#" disable <?php if (!(strcmp("#", $row_update_pembayaran['keterangan']))) {echo "selected=\"selected\"";} ?>>Keterangan</option>
           <option value="Lunas" <?php if (!(strcmp("Lunas", $row_update_pembayaran['keterangan']))) {echo "selected=\"selected\"";} ?>>Lunas</option>
           <option value="Belum Lunas" <?php if (!(strcmp("Belum Lunas", $row_update_pembayaran['keterangan']))) {echo "selected=\"selected\"";} ?>>Belum Lunas</option>
        </select>
      </div>
      <input class="btn btn-lg btn-danger btn-block" type="submit" value="Update">
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_pembayaran" value="<?php echo $row_update_pembayaran['id_pembayaran']; ?>">
</form>
<p>&nbsp;</p>
<script src="../js/jquery-3.5.1.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/all.min.js"></script>
</body>
</html>
<?php
mysql_free_result($update_pembayaran);
?>
