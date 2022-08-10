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
  $updateSQL = sprintf("UPDATE siswa SET nis=%s, nama=%s, id_kelas=%s, alamat=%s, no_telp=%s, id_spp=%s WHERE nisn=%s",
                       GetSQLValueString($_POST['nis'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['id_kelas'], "int"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telp'], "text"),
                       GetSQLValueString($_POST['id_spp'], "int"),
                       GetSQLValueString($_POST['nisn'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "home.php?page=siswa";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_koneksi, $koneksi);
$nisn = $_GET['nisn'];
$query_update_siswa = "SELECT * FROM siswa WHERE nisn=$nisn";
$update_siswa = mysql_query($query_update_siswa, $koneksi) or die(mysql_error());
$row_update_siswa = mysql_fetch_assoc($update_siswa);
$totalRows_update_siswa = mysql_num_rows($update_siswa);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Update data Siswa</title>
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



<form style="background: #004445; color: #2C7873; border: 0; border-radius: 5px; margin-top: 95px;" class="form-signin" method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <div>
      <label>Nisn = <?php echo $row_update_siswa['nisn']; ?></label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="nis" class="form-control" name="nis" value="<?php echo htmlentities($row_update_siswa['nis'], ENT_COMPAT, 'utf-8'); ?>" size="32">
      <label for="nis">Nis</label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="nama" class="form-control" name="nama" value="<?php echo htmlentities($row_update_siswa['nama'], ENT_COMPAT, 'utf-8'); ?>" size="32">
      <label for="nama">Nama</label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="id_kelas" class="form-control" name="id_kelas" value="<?php echo htmlentities($row_update_siswa['id_kelas'], ENT_COMPAT, 'utf-8'); ?>" size="32">
      <label for="id_kelas">Id Kelas</label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="alamat" class="form-control" name="alamat" value="<?php echo htmlentities($row_update_siswa['alamat'], ENT_COMPAT, 'utf-8'); ?>" size="32">
      <label for="alamat">Alamat</label>
    </div>
    <div class="form-label-group">
	  <input type="text" autocomplete="off" id="no_telp" class="form-control" name="no_telp" value="<?php echo htmlentities($row_update_siswa['no_telp'], ENT_COMPAT, 'utf-8'); ?>" size="32">
      <label for="no_telp">No Telepon</label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="id_spp" class="form-control" name="id_spp" value="<?php echo htmlentities($row_update_siswa['id_spp'], ENT_COMPAT, 'utf-8'); ?>" size="32">
      <label for="id_spp">Id SPP</label>
    </div>
      <input class="btn btn-lg btn-danger btn-block" type="submit" value="Update">
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="nisn" value="<?php echo $row_update_siswa['nisn']; ?>">
</form>
<p>&nbsp;</p>
<script src="../js/jquery-3.5.1.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/all.min.js"></script>
</body>
</html>
<?php
mysql_free_result($update_siswa);
?>
