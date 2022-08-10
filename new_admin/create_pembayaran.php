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
    "INSERT INTO pembayaran (id_pembayaran, id_petugas, nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
    GetSQLValueString($_POST['id_pembayaran'], "int"),
    GetSQLValueString($_POST['id_petugas'], "int"),
    GetSQLValueString($_POST['nisn'], "int"),
    GetSQLValueString($_POST['tgl_bayar'], "date"),
    GetSQLValueString($_POST['bulan_dibayar'], "text"),
    GetSQLValueString($_POST['tahun_dibayar'], "text"),
    GetSQLValueString($_POST['id_spp'], "int"),
    GetSQLValueString($_POST['jumlah_bayar'], "int"),
    GetSQLValueString($_POST['keterangan'], "text")
  );

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "home.php?page=pembayaran";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_koneksi, $koneksi);
$query_siswa_pembayaran = "SELECT * FROM siswa";
$siswa_pembayaran = mysql_query($query_siswa_pembayaran, $koneksi) or die(mysql_error());
$row_siswa_pembayaran = mysql_fetch_assoc($siswa_pembayaran);
$totalRows_siswa_pembayaran = mysql_num_rows($siswa_pembayaran);

mysql_select_db($database_koneksi, $koneksi);
$query_spp_pembayaran = "SELECT * FROM siswa";
$spp_pembayaran = mysql_query($query_spp_pembayaran, $koneksi) or die(mysql_error());
$row_spp_pembayaran = mysql_fetch_assoc($spp_pembayaran);
$totalRows_spp_pembayaran = mysql_num_rows($spp_pembayaran);

mysql_select_db($database_koneksi, $koneksi);
$query_create_pembayaran = "SELECT * FROM pembayaran";
$create_pembayaran = mysql_query($query_create_pembayaran, $koneksi) or die(mysql_error());
$row_create_pembayaran = mysql_fetch_assoc($create_pembayaran);
$totalRows_create_pembayaran = mysql_num_rows($create_pembayaran);

mysql_select_db($database_koneksi, $koneksi);
$query_petugas_pembayaran = "SELECT * FROM petugas";
$petugas_pembayaran = mysql_query($query_petugas_pembayaran, $koneksi) or die(mysql_error());
$row_petugas_pembayaran = mysql_fetch_assoc($petugas_pembayaran);
$totalRows_petugas_pembayaran = mysql_num_rows($petugas_pembayaran);
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Create data Pembayaran</title>
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


  <form style="background: #34675C; border: 0; border-radius: 5px; margin-top: 33px;" class="form-signin" method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="id_pembayaran" class="form-control" placeholder="Id Pembayaran" name="id_pembayaran" value="" size="32">
        <label for="id_pembayaran">Id Pembayaran</label>
      </div>
      <div>
        <select id="id_petugas" class="form-control" name="id_petugas">
          <option disabled style="position: fixed;" value="Id Petugas">Id Petugas</option>
          <?php
          do {
          ?>
            <option value="<?php echo $row_petugas_pembayaran['id_petugas'] ?>" <?php if (!(strcmp($row_petugas_pembayaran['id_petugas'], $row_petugas_pembayaran['id_petugas']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo $row_petugas_pembayaran['nama_petugas'] ?></option>
          <?php
          } while ($row_petugas_pembayaran = mysql_fetch_assoc($petugas_pembayaran));
          $rows = mysql_num_rows($petugas_pembayaran);
          if ($rows > 0) {
            mysql_data_seek($petugas_pembayaran, 0);
            $row_petugas_pembayaran = mysql_fetch_assoc($petugas_pembayaran);
          }
          ?>
        </select>
      </div>
      <div>
        <select id="nisn" class="form-control" name="nisn">
          <option disabled style="position: fixed;" value="Nisn">Nisn</option>
          <?php
          do {
          ?>
            <option value="<?php echo $row_siswa_pembayaran['nisn'] ?>" <?php if (!(strcmp($row_siswa_pembayaran['nisn'], $row_siswa_pembayaran['nisn']))) {
                                                                          echo "SELECTED";
                                                                        } ?>><?php echo $row_siswa_pembayaran['nama'] ?></option>
          <?php
          } while ($row_siswa_pembayaran = mysql_fetch_assoc($siswa_pembayaran));
          ?>
        </select>
      </div>
      <div class="form-label-group">
        <input type="date" id="tgl_bayar" class="form-control" placeholder="Tgl Bayar" name="tgl_bayar" value="" size="32">
        <label for="tgl_bayar">Tgl Bayar</label>
      </div>
      <div>
        <select id="bulan_bayar" class="form-control" name="bulan_dibayar">
          <option disabled style="position: fixed;" value="Bulan Bayar">Bulan Bayar</option>
          <option value="Januari" <?php if (!(strcmp("Januari", $row_siswa_pembayaran['']))) {
                                    echo "selected=\"selected\"";
                                  } ?>>Januari</option>
          <option value="Februari" <?php if (!(strcmp("Februari", $row_siswa_pembayaran['']))) {
                                      echo "selected=\"selected\"";
                                    } ?>>Februari</option>
          <option value="Maret" <?php if (!(strcmp("Maret", $row_siswa_pembayaran['']))) {
                                  echo "selected=\"selected\"";
                                } ?>>Maret</option>
          <option value="April" <?php if (!(strcmp("April", $row_siswa_pembayaran['']))) {
                                  echo "selected=\"selected\"";
                                } ?>>April</option>
          <option value="Mei" <?php if (!(strcmp("Mei", $row_siswa_pembayaran['']))) {
                                echo "selected=\"selected\"";
                              } ?>>Mei</option>
          <option value="Juni" <?php if (!(strcmp("Juni", $row_siswa_pembayaran['']))) {
                                  echo "selected=\"selected\"";
                                } ?>>Juni</option>
          <option value="Juli" <?php if (!(strcmp("Juli", $row_siswa_pembayaran['']))) {
                                  echo "selected=\"selected\"";
                                } ?>>Juli</option>
          <option value="Agustus" <?php if (!(strcmp("Agustus", $row_siswa_pembayaran['']))) {
                                    echo "selected=\"selected\"";
                                  } ?>>Agustus</option>
          <option value="September" <?php if (!(strcmp("September", $row_siswa_pembayaran['']))) {
                                      echo "selected=\"selected\"";
                                    } ?>>September</option>
          <option value="Oktober" <?php if (!(strcmp("Oktober", $row_siswa_pembayaran['']))) {
                                    echo "selected=\"selected\"";
                                  } ?>>Oktober</option>
          <option value="November" <?php if (!(strcmp("November", $row_siswa_pembayaran['']))) {
                                      echo "selected=\"selected\"";
                                    } ?>>November</option>
          <option value="Desember" <?php if (!(strcmp("Desember", $row_siswa_pembayaran['']))) {
                                      echo "selected=\"selected\"";
                                    } ?>>Desember</option>
        </select>
      </div>
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="tahun_dibayar" class="form-control" placeholder="Tahun Dibayar" name="tahun_dibayar" value="" size="32">
        <label for="tahun_dibayar">Tahun Dibayar</label>
      </div>
      <div>
        <select id="id_spp" class="form-control" name="id_spp">
          <option disabled style="position: fixed;" value="Id SPP">Id SPP</option>
          <?php
          do {
          ?>
            <option value="<?php echo $row_spp_pembayaran['id_spp'] ?>" <?php if (!(strcmp($row_spp_pembayaran['id_spp'], $row_spp_pembayaran['id_spp']))) {
                                                                          echo "SELECTED";
                                                                        } ?>><?php echo $row_spp_pembayaran['nama'] ?></option>
          <?php
          } while ($row_spp_pembayaran = mysql_fetch_assoc($spp_pembayaran));
          ?>
        </select>
      </div>
      <div class="form-label-group">
        <input type="text" autocomplete="off" id="jumlah_bayar" class="form-control" placeholder="Jumlah Bayar" name="jumlah_bayar" value="" size="32">
        <label for="jumlah_bayar">Jumlah Bayar</label>
      </div>
      <div>
        <select class="form-control" name="keterangan">
          <option value="Lunas" <?php if (!(strcmp("Lunas", $row_create_pembayaran['keterangan']))) {
                                  echo "selected=\"selected\"";
                                } ?>>Lunas</option>
          <option value="Belum Lunas" <?php if (!(strcmp("Belum Lunas", $row_create_pembayaran['keterangan']))) {
                                        echo "selected=\"selected\"";
                                      } ?>>Belum Lunas</option>
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
mysql_free_result($siswa_pembayaran);

mysql_free_result($spp_pembayaran);

mysql_free_result($create_pembayaran);

mysql_free_result($petugas_pembayaran);
?>