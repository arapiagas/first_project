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
    "INSERT INTO petugas (id_petugas, username, password, nama_petugas, `level`) VALUES (%s, %s, %s, %s, %s)",
    GetSQLValueString($_POST['id_petugas'], "int"),
    GetSQLValueString($_POST['username'], "text"),
    GetSQLValueString($_POST['password'], "text"),
    GetSQLValueString($_POST['nama_petugas'], "text"),
    GetSQLValueString($_POST['level'], "text")
  );

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "home.php?page=petugas";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_koneksi, $koneksi);
$query_petugas = "SELECT * FROM petugas";
$petugas = mysql_query($query_petugas, $koneksi) or die(mysql_error());
$row_petugas = mysql_fetch_assoc($petugas);
$totalRows_petugas = mysql_num_rows($petugas);
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Create data Petugas</title>
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

<body style="background: #324851;">


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


  <form style="background: #34675C; border: 0; border-radius: 5px;" class="form-signin" method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="id_petugas" class="form-control" placeholder="Id Petugas" name="id_petugas" value="" size="32">
        <label for="id_petugas">Id Petugas</label>
      </div>
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="username" placeholder="Username" class="form-control" name="username" value="" size="32">
        <label for="username">Username</label>
      </div>
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="password" placeholder="Password" class="form-control" name="password" value="" size="32">
        <label for="password">Password</label>
      </div>
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="nama_petugas" placeholder="Nama Petugas" class="form-control" name="nama_petugas" value="" size="32">
        <label for="nama_petugas">Nama Petugas</label>
      </div>
      <div>
        <select class="form-control" name="level">
          <option disabled style="position: fixed;" value="Level" <?php if (!(strcmp("Level", $row_petugas['level']))) {
                                                                    echo "selected=\"selected\"";
                                                                  } ?>>Level</option>
          <option value="Admin" <?php if (!(strcmp("Admin", $row_petugas['level']))) {
                                  echo "selected=\"selected\"";
                                } ?>>Admin</option>
          <option value="Petugas" <?php if (!(strcmp("Petugas", $row_petugas['level']))) {
                                    echo "selected=\"selected\"";
                                  } ?>>Petugas</option>
          <option value="Siswa" <?php if (!(strcmp("Siswa", $row_petugas['level']))) {
                                  echo "selected=\"selected\"";
                                } ?>>Siswa</option>
        </select>
      </div>
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
mysql_free_result($petugas);
?>