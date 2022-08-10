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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf(
    "INSERT INTO siswa (nisn, nis, nama, id_kelas, alamat, no_telp, id_spp) VALUES (%s, %s, %s, %s, %s, %s, %s)",
    GetSQLValueString($_POST['nisn'], "int"),
    GetSQLValueString($_POST['nis'], "text"),
    GetSQLValueString($_POST['nama'], "text"),
    GetSQLValueString($_POST['id_kelas'], "text"),
    GetSQLValueString($_POST['alamat'], "text"),
    GetSQLValueString($_POST['no_telp'], "text"),
    GetSQLValueString($_POST['id_spp'], "int")
  );

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "home.php?page=siswa";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_koneksi, $koneksi);
$query_kelas_siswa = "SELECT * FROM kelas";
$kelas_siswa = mysql_query($query_kelas_siswa, $koneksi) or die(mysql_error());
$row_kelas_siswa = mysql_fetch_assoc($kelas_siswa);
$totalRows_kelas_siswa = mysql_num_rows($kelas_siswa);
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Create data Siswa</title>
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

<body style="background: #324851">


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



  <form style="background: #34675C; border: 0; border-radius: 5px; margin-top: 50px;" class="form-signin" method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="nisn" placeholder="Nisn" name="nisn" class="form-control" value="" size="32">
        <label for="nisn">Nisn</label>
      </div>
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="nis" placeholder="Nis" name="nis" class="form-control" value="" size="32">
        <label for="nis">Nis</label>
      </div>
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="nama" placeholder="Nama" class="form-control" name="nama" value="" size="32">
        <label for="nama">Nama</label>
      </div>
      <div>
        <select class="form-control" name="id_kelas">
          <option disabled style="position: fixed;" value="Id Kelas">Id Kelas</option>
          <?php
          do {
          ?>
            <option value="<?php echo $row_kelas_siswa['id_kelas'] ?>" <?php if (!(strcmp($row_kelas_siswa['id_kelas'], $row_kelas_siswa['id_kelas']))) {
                                                                        echo "selected=\"selected\"";
                                                                      } ?>><?php echo $row_kelas_siswa['id_kelas'] ?></option>
          <?php
          } while ($row_kelas_siswa = mysql_fetch_assoc($kelas_siswa));
          $rows = mysql_num_rows($kelas_siswa);
          if ($rows > 0) {
            mysql_data_seek($kelas_siswa, 0);
            $row_kelas_siswa = mysql_fetch_assoc($kelas_siswa);
          }
          ?>
        </select>
      </div>
      <div class="form-label-group">
        <input type="text" autocomplete="off" placeholder="Alamat" id="alamat" class="form-control" name="alamat" value="" size="32">
        <label for="alamat">Alamat</label>
      </div>
      <div class="form-label-group">
        <input type="text" autocomplete="off" placeholder="No Telepon" id="no_telp" class="form-control" name="no_telp" value="" size="32">
        <label for="no_telp">No Telepon</label>
      </div>
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="id_spp" placeholder="Id SPP" name="id_spp" class="form-control" value="" size="32">
        <label for="id_spp">Id SPP</label>
      </div><br>
      <button class="btn btn-lg btn-primary btn-block" type="submit" class="btn btn-lg btn-block">Create</button>
    </table>
    <input type="hidden" name="MM_insert" value="form1">
  </form>
  <p>&nbsp;</p>
  
  <script src="../js/jquery-3.5.1.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/all.min.js"></script>
</body>

</html>
<?php
mysql_free_result($kelas_siswa);
?>