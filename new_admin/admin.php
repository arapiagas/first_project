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

$maxRows_kelas = 500;
$pageNum_kelas = 0;
if (isset($_GET['pageNum_kelas'])) {
  $pageNum_kelas = $_GET['pageNum_kelas'];
}
$startRow_kelas = $pageNum_kelas * $maxRows_kelas;

mysql_select_db($database_koneksi, $koneksi);
$query_kelas = "SELECT * FROM kelas";
$query_limit_kelas = sprintf("%s LIMIT %d, %d", $query_kelas, $startRow_kelas, $maxRows_kelas);
$kelas = mysql_query($query_limit_kelas, $koneksi) or die(mysql_error());
$row_kelas = mysql_fetch_assoc($kelas);

if (isset($_GET['totalRows_kelas'])) {
  $totalRows_kelas = $_GET['totalRows_kelas'];
} else {
  $all_kelas = mysql_query($query_kelas);
  $totalRows_kelas = mysql_num_rows($all_kelas);
}
$totalPages_kelas = ceil($totalRows_kelas / $maxRows_kelas) - 1;

$maxRows_petugas = 500;
$pageNum_petugas = 0;
if (isset($_GET['pageNum_petugas'])) {
  $pageNum_petugas = $_GET['pageNum_petugas'];
}
$startRow_petugas = $pageNum_petugas * $maxRows_petugas;

mysql_select_db($database_koneksi, $koneksi);
$query_petugas = "SELECT * FROM petugas";
$query_limit_petugas = sprintf("%s LIMIT %d, %d", $query_petugas, $startRow_petugas, $maxRows_petugas);
$petugas = mysql_query($query_limit_petugas, $koneksi) or die(mysql_error());
$row_petugas = mysql_fetch_assoc($petugas);

if (isset($_GET['totalRows_petugas'])) {
  $totalRows_petugas = $_GET['totalRows_petugas'];
} else {
  $all_petugas = mysql_query($query_petugas);
  $totalRows_petugas = mysql_num_rows($all_petugas);
}
$totalPages_petugas = ceil($totalRows_petugas / $maxRows_petugas) - 1;

$maxRows_siswa = 500;
$pageNum_siswa = 0;
if (isset($_GET['pageNum_siswa'])) {
  $pageNum_siswa = $_GET['pageNum_siswa'];
}
$startRow_siswa = $pageNum_siswa * $maxRows_siswa;

mysql_select_db($database_koneksi, $koneksi);
$query_siswa = "SELECT * FROM siswa";
$query_limit_siswa = sprintf("%s LIMIT %d, %d", $query_siswa, $startRow_siswa, $maxRows_siswa);
$siswa = mysql_query($query_limit_siswa, $koneksi) or die(mysql_error());
$row_siswa = mysql_fetch_assoc($siswa);

if (isset($_GET['totalRows_siswa'])) {
  $totalRows_siswa = $_GET['totalRows_siswa'];
} else {
  $all_siswa = mysql_query($query_siswa);
  $totalRows_siswa = mysql_num_rows($all_siswa);
}
$totalPages_siswa = ceil($totalRows_siswa / $maxRows_siswa) - 1;

$maxRows_Recordset1 = 500;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_koneksi, $koneksi);
$query_Recordset1 = "SELECT * FROM spp";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $koneksi) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1 / $maxRows_Recordset1) - 1;
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap4.css">
  <style type="text/css">
    .kelas:nth-child(odd) {
      background: #9fcdff;
    }

    .petugas:nth-child(odd) {
      background: #ffe8a1;
    }

    .spp:nth-child(odd) {
      background: #f1b0b7;
    }

    .siswa:nth-child(odd) {
      background: #b1dfbb;
    }
  </style>
</head>

<body>
  <main>
    <div class="container-fluid">
      <h1 class="breadcrumb mt-4">Selamat Datang <?php echo $_SESSION['nama_petugas']; ?></h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><i class="fas fa-users"></i> Jumlah Data</li>
      </ol>
      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card bg-primary text-white mb-4">
            <div class="card-body"><i class="fas fa-users"></i> Jumlah Data Kelas = <?php echo $totalRows_kelas = mysql_num_rows($kelas); ?></div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a href="#" class="text-white" onclick="siswa()"><i class="fas fa-eye"></i> Show Data</a>
              <a href="#" class="text-white" onclick="siswi()"><i class="fas fa-eye-slash"></i> Hide Data</a>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-warning text-white mb-4">
            <div class="card-body"><i class="fas fa-users"></i> Jumlah Data Petugas = <?php echo $totalRows_petugas = mysql_num_rows($petugas); ?></div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a href="#" class="text-white" onclick="admin()"><i class="fas fa-eye"></i> Show Data</a>
              <a href="#" class="text-white" onclick="petugas()"><i class="fas fa-eye-slash"></i> Hide Data</a>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-danger text-white mb-4">
            <div class="card-body"><i class="fas fa-users"></i> Jumlah Data SPP = <?php echo $totalRows_Recordset1 = mysql_num_rows($Recordset1); ?></div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a href="#" class="text-white" onclick="show()"><i class="fas fa-eye"></i> Show Data</a>
              <a href="#" class="text-white" onclick="hide()"><i class="fas fa-eye-slash"></i> Hide Data</a>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-success text-white mb-4">
            <div class="card-body"><i class="fas fa-users"></i> Jumlah Data Siswa = <?php echo $totalRows_siswa = mysql_num_rows($siswa); ?></div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a href="#" class="text-white" onclick="nisn()"><i class="fas fa-eye"></i> Show Data</a>
              <a href="#" class="text-white" onclick="nis()"><i class="fas fa-eye-slash"></i> Hide Data</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <div>
    <div id="kelas" style="display: none;">
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><i class="fas fa-table"></i> Tabel Data</li>
      </ol>
        <h2>Data Kelas</h2>
        <div class="table-responsive">
          <table style="width: 100%" id="table_kelas1" class="table table-bordered table-primary table-hover">
            <thead>
              <tr class="text-light font-weight-bold bg-primary">
                <td>Id Kelas</td>
                <td>Nama Kelas</td>
                <td>Kompetensi Keahlian</td>
              </tr>
            </thead>
            <tbody>
              <?php do { ?>
                <tr class="kelas">
                  <td><?php echo $row_kelas['id_kelas']; ?></td>
                  <td><?php echo $row_kelas['nama_kelas']; ?></td>
                  <td><?php echo $row_kelas['kompetensi_keahlian']; ?></td>
                </tr>
              <?php } while ($row_kelas = mysql_fetch_assoc($kelas)); ?>
          </tbody>
          </table>
        </div>
    </div>
    <div id="petugas" style="display: none;">
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><i class="fas fa-table"></i> Tabel Data</li>
      </ol>
        <h2>Data Petugas</h2>
        <div class="table-responsive">
          <table style="width: 100%" id="table_petugas1" class="table table-bordered table-warning table-hover">
            <thead>
              <tr class="text-light font-weight-bold bg-warning">
                <td>Id Petugas</td>
                <td>Username</td>
                <td>Password</td>
                <td>Nama Petugas</td>
                <td>Level</td>
              </tr>
            </thead>
            <tbody>
              <?php do { ?>
                <tr class="petugas">
                  <td><?php echo $row_petugas['id_petugas']; ?></td>
                  <td><?php echo $row_petugas['username']; ?></td>
                  <td><?php echo $row_petugas['password']; ?></td>
                  <td><?php echo $row_petugas['nama_petugas']; ?></td>
                  <td><?php echo $row_petugas['level']; ?></td>
                </tr>
              <?php } while ($row_petugas = mysql_fetch_assoc($petugas)); ?>
          </tbody>
          </table>
        </div>
    </div>
    <div id="siswa" style="display: none;">
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><i class="fas fa-table"></i> Tabel Data</li>
      </ol>
        <h2>Data Siswa</h2>
        <div class="table-responsive">
          <table style="width: 100%" id="table_siswa1" class="table table-bordered table-success table-hover">
            <thead>
              <tr class="text-light font-weight-bold bg-success">
                <td>Nisn</td>
                <td>Nis</td>
                <td>Nama</td>
                <td>Id Kelas</td>
                <td>Alamat</td>
                <td>No Telepon</td>
                <td>Id SPP</td>
              </tr>
            </thead>
            <tbody>
              <?php do { ?>
                <tr class="siswa">
                  <td><?php echo $row_siswa['nisn']; ?></td>
                  <td><?php echo $row_siswa['nis']; ?></td>
                  <td><?php echo $row_siswa['nama']; ?></td>
                  <td><?php echo $row_siswa['id_kelas']; ?></td>
                  <td><?php echo $row_siswa['alamat']; ?></td>
                  <td><?php echo $row_siswa['no_telp']; ?></td>
                  <td><?php echo $row_siswa['id_spp']; ?></td>
                </tr>
              <?php } while ($row_siswa = mysql_fetch_assoc($siswa)); ?>
            </tbody>
          </table>
        </div>
    </div>
    <div id="spp" style="display: none;">
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><i class="fas fa-table"></i> Tabel Data</li>
      </ol>
        <h2>Data SPP</h2>
        <div class="table-responsive">
          <table style="width: 100%" id="table_spp1" class="table table-bordered table-danger table-hover">
            <thead>
              <tr class="text-light font-weight-bold bg-danger">
                <td>Nisn</td>
                <td>Id SPP</td>
                <td>Tahun</td>
                <td>Nominal</td>
              </tr>
          </thead>
            <tbody>
              <?php do { ?>
                <tr class="spp">
                  <td><?php echo $row_Recordset1['nisn']; ?></td>
                  <td><?php echo $row_Recordset1['id_spp']; ?></td>
                  <td><?php echo $row_Recordset1['tahun']; ?></td>
                  <td><?php echo $row_Recordset1['nominal']; ?></td>
                </tr>
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
            </tbody>
          </table>
        </div>
    </div>
  </div>
  <script src="../js/jquery-3.5.1.js" crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script src="../jquery.slim.min.js"><\/script>')
  </script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/jquery.dataTables.js"></script>
  <script src="../js/all.min.js"></script>
  <script src="../js/dataTables.bootstrap4.js"></script>
  <script type="text/javascript">
    function siswa() {
      document.getElementById('kelas').style.display = "block";
      document.getElementById('petugas').style.display = "none";
      document.getElementById('siswa').style.display = "none";
      document.getElementById('spp').style.display = "none";
    }

    function siswi() {
      document.getElementById('kelas').style.display = "none";
    }

    function admin() {
      document.getElementById('petugas').style.display = "block";
      document.getElementById('kelas').style.display = "none";
      document.getElementById('siswa').style.display = "none";
      document.getElementById('spp').style.display = "none";
    }

    function petugas() {
      document.getElementById('petugas').style.display = "none";
    }

    function nisn() {
      document.getElementById('siswa').style.display = "block";
      document.getElementById('kelas').style.display = "none";
      document.getElementById('petugas').style.display = "none";
      document.getElementById('spp').style.display = "none";
    }

    function nis() {
      document.getElementById('siswa').style.display = "none";
    }

    function show() {
      document.getElementById('spp').style.display = "block";
      document.getElementById('kelas').style.display = "none";
      document.getElementById('petugas').style.display = "none";
      document.getElementById('siswa').style.display = "none";
    }

    function hide() {
      document.getElementById('spp').style.display = "none";
    }
  </script>
  <script>
        $(document).ready(function() {
            $('#table_kelas1').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#table_petugas1').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#table_siswa1').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#table_spp1').DataTable();
        });
    </script>
</body>

</html>
<?php
mysql_free_result($kelas);

mysql_free_result($petugas);

mysql_free_result($siswa);

mysql_free_result($Recordset1);
?>