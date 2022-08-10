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
  $updateSQL = sprintf("UPDATE petugas SET username=%s, password=%s, nama_petugas=%s, `level`=%s WHERE id_petugas=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['nama_petugas'], "text"),
                       GetSQLValueString($_POST['level'], "text"),
                       GetSQLValueString($_POST['id_petugas'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "home.php?page=petugas";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_koneksi, $koneksi);
$petugas=$_GET['id_petugas'];
$query_update_petugas = "SELECT * FROM petugas WHERE id_petugas=$petugas";
$update_petugas = mysql_query($query_update_petugas, $koneksi) or die(mysql_error());
$row_update_petugas = mysql_fetch_assoc($update_petugas);
$totalRows_update_petugas = mysql_num_rows($update_petugas);
?>

<!doctype html>
<html>
<head>
	<title>Update data Petugas</title>
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



<form style="background: #004445; color: #2C7873; border: 0; border-radius: 5px;" class="form-signin" method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <div>
      <label for="id_petugas">Id Petugas = <?php echo $row_update_petugas['id_petugas']; ?></label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="username" class="form-control" name="username" value="<?php echo htmlentities($row_update_petugas['username'], ENT_COMPAT, ''); ?>" size="32">
      <label for="username">Username</label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="password" class="form-control" name="password" value="<?php echo htmlentities($row_update_petugas['password'], ENT_COMPAT, ''); ?>" size="32">
      <label for="password">Password</label>
    </div>
    <div class="form-label-group">
      <input type="text" autocomplete="off" id="nama_petugas" class="form-control" name="nama_petugas" value="<?php echo htmlentities($row_update_petugas['nama_petugas'], ENT_COMPAT, ''); ?>" size="32">
      <label for="nama_petugas">Nama Petugas</label>
    </div>
    <div>
		<select class="form-control" name="level">
      <option disabled style="position: fixed;" value="Level">Level</option>
        <option value="Admin" <?php if (!(strcmp("Admin", htmlentities($row_update_petugas['level'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Admin</option>
        <option value="Petugas" <?php if (!(strcmp("Petugas", htmlentities($row_update_petugas['level'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Petugas</option>
        <option value="Siswa" <?php if (!(strcmp("Siswa", htmlentities($row_update_petugas['level'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Siswa</option>
      </select>
    </div>
	<input class="btn btn-lg btn-danger btn-block" type="submit" value="Update">
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_petugas" value="<?php echo $row_update_petugas['id_petugas']; ?>">
</form>
<p>&nbsp;</p>
<script src="../js/jquery-3.5.1.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/all.min.js"></script>
</body>
</html>
<?php 
mysql_free_result($update_petugas);
 ?>