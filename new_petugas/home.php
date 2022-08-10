<?php require_once('../Connections/koneksi.php'); ?>
<?php
session_start();
if (!isset($_SESSION['petugas'])) {
  header('location:../gagal.php');
}
?>
<?php $pe = $_SESSION['nama_petugas']; ?>
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
}

mysql_select_db($database_koneksi, $koneksi);
$query_siswa = "SELECT * FROM siswa";
$siswa = mysql_query($query_siswa, $koneksi) or die(mysql_error());
$row_siswa = mysql_fetch_assoc($siswa);
$totalRows_siswa = mysql_num_rows($siswa);

mysql_select_db($database_koneksi, $koneksi);
$query_spp = "SELECT * FROM siswa";
$spp = mysql_query($query_spp, $koneksi) or die(mysql_error());
$row_spp = mysql_fetch_assoc($spp);
$totalRows_spp = mysql_num_rows($spp);

mysql_select_db($database_koneksi, $koneksi);
$query_petugas = "SELECT * FROM petugas";
$petugas = mysql_query($query_petugas, $koneksi) or die(mysql_error());
$row_petugas = mysql_fetch_assoc($petugas);
$totalRows_petugas = mysql_num_rows($petugas);

$maxRows_pembayaran = 500;
$pageNum_pembayaran = 0;
if (isset($_GET['pageNum_pembayaran'])) {
  $pageNum_pembayaran = $_GET['pageNum_pembayaran'];
}
$startRow_pembayaran = $pageNum_pembayaran * $maxRows_pembayaran;

mysql_select_db($database_koneksi, $koneksi);
$query_pembayaran = "SELECT * FROM pembayaran";
$query_limit_pembayaran = sprintf("%s LIMIT %d, %d", $query_pembayaran, $startRow_pembayaran, $maxRows_pembayaran);
$pembayaran = mysql_query($query_limit_pembayaran, $koneksi) or die(mysql_error());
$row_pembayaran = mysql_fetch_assoc($pembayaran);

if (isset($_GET['totalRows_pembayaran'])) {
  $totalRows_pembayaran = $_GET['totalRows_pembayaran'];
} else {
  $all_pembayaran = mysql_query($query_pembayaran);
  $totalRows_pembayaran = mysql_num_rows($all_pembayaran);
}
$totalPages_pembayaran = ceil($totalRows_pembayaran / $maxRows_pembayaran) - 1;

$maxRows_history = 500;
$pageNum_history = 0;
if (isset($_GET['pageNum_history'])) {
  $pageNum_history = $_GET['pageNum_history'];
}
$startRow_history = $pageNum_history * $maxRows_history;

mysql_select_db($database_koneksi, $koneksi);
$query_history = "Select pembayaran.id_pembayaran,siswa.nama,pembayaran.nisn,pembayaran.tgl_bayar,pembayaran.bulan_dibayar,pembayaran.tahun_dibayar,spp.nominal,pembayaran.jumlah_bayar,pembayaran.keterangan FROM pembayaran JOIN siswa ON pembayaran.nisn = siswa.nisn JOIN spp ON pembayaran.nisn = spp.nisn";
$query_limit_history = sprintf("%s LIMIT %d, %d", $query_history, $startRow_history, $maxRows_history);
$history = mysql_query($query_limit_history, $koneksi) or die(mysql_error());
$row_history = mysql_fetch_assoc($history);

if (isset($_GET['totalRows_history'])) {
  $totalRows_history = $_GET['totalRows_history'];
} else {
  $all_history = mysql_query($query_history);
  $totalRows_history = mysql_num_rows($all_history);
}
$totalPages_history = ceil($totalRows_history / $maxRows_history) - 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap4.css">
  <style type="text/css">
    .td:nth-child(odd) {
      background: #9fcdff;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="home.php">Petugas</a>
    <ul class="navbar-nav">
      <li class="nav-item text-nowrap">
        <a class="nav-item active nav-link" onclick="return confirm('Apakah kamu sudah yakin ingin logout <?php echo $pe; ?>?');" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </nav>

  <h1>&nbsp;</h1>
  <h1 style="height: 60px;" class="breadcrumb mb-4">Selamat Datang <?php echo $pe; ?></h1>
  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary text-white mb-4">
        <div class="card-body"><i class="fas fa-users"></i> Jumlah Data Pembayaran = <?php echo $totalRows_pembayaran ?></div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a href="#" class="text-white" onclick="transaksi()"><i class="fas fa-eye"></i> Show Data</a>
          <a href="#" class="text-white" onclick="spp()"><i class="fas fa-eye-slash"></i> Hide Data</a>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary text-white mb-4">
        <div class="card-body"><i class="fas fa-users"></i> Jumlah Data History = <?php echo $totalRows_history = mysql_num_rows($all_history); ?></div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a href="#" class="text-white" onclick="history()"><i class="fas fa-eye"></i> Show Data</a>
          <a href="#" class="text-white" onclick="pembayaran()"><i class="fas fa-eye-slash"></i> Hide Data</a>
        </div>
      </div>
    </div>
  </div>
  </div>

  <p>&nbsp;</p>
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table class="table table-hover table-primary">
      <tr valign="baseline">
        <td><input type="text" class="form-control" placeholder="Id Pembayaran" name="id_pembayaran" value="" size="32"></td>
        <td><select class="form-control" name="id_petugas">
            <option value="#" disabled>Id Petugas</option>
            <?php
            do {
            ?>
              <option value="<?php echo $row_petugas['id_petugas'] ?>" <?php if (!(strcmp($row_petugas['id_petugas'], $row_petugas['id_petugas']))) {
                                                                          echo "SELECTED";
                                                                        } ?>><?php echo $row_petugas['nama_petugas'] ?></option>
            <?php
            } while ($row_petugas = mysql_fetch_assoc($petugas));
            ?>
          </select></td>
        <td><select class="form-control" name="nisn">
            <option value="#" disabled>Nisn</option>
            <?php
            do {
            ?>
              <option value="<?php echo $row_siswa['nisn'] ?>" <?php if (!(strcmp($row_siswa['nisn'], $row_siswa['nisn']))) {
                                                                  echo "SELECTED";
                                                                } ?>><?php echo $row_siswa['nama'] ?></option>
            <?php
            } while ($row_siswa = mysql_fetch_assoc($siswa));
            ?>
          </select></td>
        <td>
          <input type="date" class="form-control" placeholder="Tanggal Bayar" name="tgl_bayar" value="" size="32">
        </td>
      </tr>
      <tr>
        <td><select class="form-control" name="bulan_dibayar">
            <option value="#" disabled>Bulan Dibayar</option>
            <option value="Januari" <?php if (!(strcmp("Januari", ""))) {
                                      echo "SELECTED";
                                    } ?>>Januari</option>
            <option value="Februari" <?php if (!(strcmp("Februari", ""))) {
                                        echo "SELECTED";
                                      } ?>>Februari</option>
            <option value="Maret" <?php if (!(strcmp("Maret", ""))) {
                                    echo "SELECTED";
                                  } ?>>Maret</option>
            <option value="April" <?php if (!(strcmp("April", ""))) {
                                    echo "SELECTED";
                                  } ?>>April</option>
            <option value="Mei" <?php if (!(strcmp("Mei", ""))) {
                                  echo "SELECTED";
                                } ?>>Mei</option>
            <option value="Juni" <?php if (!(strcmp("Juni", ""))) {
                                    echo "SELECTED";
                                  } ?>>Juni</option>
            <option value="Juli" <?php if (!(strcmp("Juli", ""))) {
                                    echo "SELECTED";
                                  } ?>>Juli</option>
            <option value="Agustus" <?php if (!(strcmp("Agustus", ""))) {
                                      echo "SELECTED";
                                    } ?>>Agustus</option>
            <option value="September" <?php if (!(strcmp("September", ""))) {
                                        echo "SELECTED";
                                      } ?>>September</option>
            <option value="Oktober" <?php if (!(strcmp("Oktober", ""))) {
                                      echo "SELECTED";
                                    } ?>>Oktober</option>
            <option value="November" <?php if (!(strcmp("November", ""))) {
                                        echo "SELECTED";
                                      } ?>>November</option>
            <option value="Desember" <?php if (!(strcmp("Desember", ""))) {
                                        echo "SELECTED";
                                      } ?>>Desember</option>
          </select></td>
        <td><input type="text" class="form-control" placeholder="Tahun Dibayar" name="tahun_dibayar" value="" size="32"></td>
        <td><select class="form-control" name="id_spp">
            <option disabled value="#">Id SPP</option>
            <?php
            do {
            ?>
              <option value="<?php echo $row_spp['id_spp'] ?>" <?php if (!(strcmp($row_spp['id_spp'], $row_spp['id_spp']))) {
                                                                  echo "SELECTED";
                                                                } ?>><?php echo $row_spp['nama'] ?></option>
            <?php
            } while ($row_spp = mysql_fetch_assoc($spp));
            ?>
          </select></td>
        <td><input type="text" class="form-control" placeholder="Jumlah Bayar" name="jumlah_bayar" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td><select class="form-control" name="keterangan">
            <option value="Lunas" <?php if (!(strcmp("Lunas", $row_pembayaran['keterangan']))) {
                                    echo "selected=\"selected\"";
                                  } ?>>Lunas</option>
            <option value="Belum Lunas" <?php if (!(strcmp("Belum Lunas", $row_pembayaran['keterangan']))) {
                                          echo "selected=\"selected\"";
                                        } ?>>Belum Lunas</option>
          </select></td>
        <td><input class="btn btn-lg btn-block btn-primary" type="submit" value="Create"></td>
        <td>
          <p>&nbsp;</p>
        </td>
        <td>
          <p>&nbsp;</p>
        </td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1">
  </form>
  <div id="transaksi">
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active"><i class="fas fa-table"></i> Tabel Data Pembayaran</li>
    </ol>
    <div class="table-responsive">
      <table style="width: 100%" id="pembayaran" class="table table-bordered table-primary table-hover">
      	<thead>
	        <tr class="bg-primary font-weight-bold text-light">
	          <td>Id Pembayaran</td>
	          <td>Id Petugas</td>
	          <td>Nisn</td>
	          <td>Tanggal Bayar</td>
	          <td>Bulan Dibayar</td>
	          <td>Tahun Dibayar</td>
	          <td>Id SPP</td>
	          <td>Jumlah Bayar</td>
	          <td>Keterangan</td>
	          <td>Update Delete</td>
	        </tr>
        </thead>
        <tbody>
	        <?php do { ?>
	          <tr class="td">
	            <td><?php echo $row_pembayaran['id_pembayaran']; ?></td>
	            <td><?php echo $row_pembayaran['id_petugas']; ?></td>
	            <td><?php echo $row_pembayaran['nisn']; ?></td>
	            <td><?php echo $row_pembayaran['tgl_bayar']; ?></td>
	            <td><?php echo $row_pembayaran['bulan_dibayar']; ?></td>
	            <td><?php echo $row_pembayaran['tahun_dibayar']; ?></td>
	            <td><?php echo $row_pembayaran['id_spp']; ?></td>
	            <td><?php echo $row_pembayaran['jumlah_bayar']; ?></td>
	            <?php if ($row_pembayaran['keterangan'] == "Lunas") { ?>
	            <td class="text-success font-weight-bold"><?php echo $row_pembayaran['keterangan']; ?></td>
	            <?php } elseif ($row_pembayaran['keterangan'] == "Belum Lunas") { ?>
	            <td class="text-danger font-weight-bold"><?php echo $row_pembayaran['keterangan']; ?></td>
	          <?php } ?>
	            <td><a class="btn btn-success col-sm-4" href="update.php?id_pembayaran=<?php echo $row_pembayaran['id_pembayaran']; ?>"><i class="fas fa-edit"></i></a> <a class="btn btn-danger col-sm-4" onClick="return confirm('Apa kamu yakin ingin menghapus id pembayaran <?php echo $row_pembayaran['id_pembayaran']; ?>');" href="delete.php?id_pembayaran=<?php echo $row_pembayaran['id_pembayaran']; ?>"><i class="fas fa-trash"></i></a></td>
	          </tr>
	        <?php } while ($row_pembayaran = mysql_fetch_assoc($pembayaran)); ?>
        </tbody>
      </table>
    </div>
  </div>
  <div id="history" style="display: none;">
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active"><i class="fas fa-table"></i> Tabel Data History</li>
    </ol>
    <div class="table-responsive">
      <table style="width: 100%" id="hasil" class="table table-bordered table-hover table-primary">
      	<thead>
	        <tr class="text-light font-weight-bold bg-primary">
	          <td>Id Pembayaran</td>
	          <td>Nama</td>
	          <td>Nisn</td>
	          <td>Tanggal Bayar</td>
	          <td>Bulan Dibayar</td>
	          <td>Tahun Dibayar</td>
	          <td>Nominal</td>
	          <td>Jumlah Bayar</td>
	          <td>Keterangan</td>
	        </tr>
        </thead>
        <tbody>
	        <?php do { ?>
	          <tr class="td">
	            <td><?php echo $row_history['id_pembayaran']; ?></td>
	            <td><?php echo $row_history['nama']; ?></td>
	            <td><?php echo $row_history['nisn']; ?></td>
	            <td><?php echo $row_history['tgl_bayar']; ?></td>
	            <td><?php echo $row_history['bulan_dibayar']; ?></td>
	            <td><?php echo $row_history['tahun_dibayar']; ?></td>
	            <td><?php echo $row_history['nominal']; ?></td>
	            <td><?php echo $row_history['jumlah_bayar']; ?></td>
	            <?php if ($row_history['keterangan'] == "Lunas") { ?>
	            <td class="text-success font-weight-bold"><?php echo $row_history['keterangan']; ?></td>
	          <?php } elseif($row_history['keterangan'] == "Belum Lunas") { ?>
	            <td class="text-danger font-weight-bold"><?php echo $row_history['keterangan']; ?></td>
	          <?php } ?>
	          </tr>
	        <?php } while ($row_history = mysql_fetch_assoc($history)); ?>
        </tbody>
      </table>
    </div>
  </div>
  <footer class="footer mt-auto py-3 bottom">
    <div class="container">
      <span class="text-muted">Copyright &copy; SMK MA'ARIF WALISONGO KAJORAN 2021</span>
    </div>
  </footer>
  <script src="../js/jquery-3.5.1.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/all.min.js"></script>
  <script src="../js/jquery.dataTables.js"></script>
  <script src="../js/dataTables.bootstrap4.js"></script>
  <script>
  	$(document).ready(function() {
            $('#pembayaran').DataTable();
        });
  </script>
  <script>
  	$(document).ready(function() {
  		$('#hasil').DataTable();
  	});
  </script>
  <script type="text/javascript">
    function transaksi() {
      document.getElementById('transaksi').style.display = "block";
      document.getElementById('history').style.display = "none";
    }

    function spp() {
      document.getElementById('transaksi').style.display = "none";
    }

    function history() {
      document.getElementById('transaksi').style.display = "none";
      document.getElementById('history').style.display = "block";
    }

    function pembayaran() {
      document.getElementById('history').style.display = "none";
    }
  </script>
</body>

</html>
<?php
mysql_free_result($siswa);

mysql_free_result($spp);

mysql_free_result($petugas);

mysql_free_result($pembayaran);

mysql_free_result($history);
?>