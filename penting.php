<!-- Cadangan -->


<!-- Mysql -->
<!-- Koneksi -->
<?php 
	$hostname = "localhost";
	$username = "root";
	$password = "";
	$dbname = "agas";
	$db = mysql_connect($hostname, $username, $password) or die('koneksi gagal');

	// Kode Login 
	session_start();
	require_once("Connections/koneksi.php");
	mysql_select_db($database_koneksi, $koneksi);
	$username = mysql_real_escape_string(trim($_POST['username']));
	$password = mysql_real_escape_string($_POST['password']);
	$cek = mysql_query("SELECT * FROM petugas WHERE username = '$username'");
	$hasil = mysql_fetch_array($cek);
	if (mysql_num_rows($cek) == 0) {
		$_SESSION['level'] == "";
		header('location:gagal.php');
	} elseif ($password <> $hasil['password']) {
		header('location:gagal.php');
	} elseif ($hasil['level'] == "admin") {
		$_SESSION['username'] = $nama;
		$_SESSION['level'] = "admin";
		$_SESSION['nama_petugas'] = $hasil['nama_petugas'];
		header('location:new_admin/home.php');
	} elseif ($hasil['level'] == "petugas") {
		$_SESSION['username'] = $nama;
		$_SESSION['level'] = "petugas";
		$_SESSION['nama_petugas'] = $hasil['nama_petugas'];
		header('location:new_petugas/home.php');
	} elseif ($hasil['level'] == "siswa") {
		$_SESSION['username'] = $nama;
		$_SESSION['level'] = "siswa";
		$_SESSION['nama_petugas'] = $hasil['nama_petugas'];
		header('location:new_siswa/home.php?v='. $hasil['id_petugas']);
	} else {
		$_SESSION['level'] == "";
		header('location:gagal.php');
	}
 ?>

<!-- Mysqli -->
<!-- Koneksi -->
<?php 
	$hostname = "localhost";
	$username = "root";
	$password = "";
	$dbname = "agas";
	$db = new mysqli($hostname, $username, $password, $dbname);

	// Kode Login 
	session_start();
	require_once("login.php");
	$nama = $_POST['username'];
	$id = $_POST['password'];
	$sql = "SELECT * FROM petugas WHERE username = '$nama'";
	$query = $db->query($sql);
	$hasil = $query->fetch_assoc();
	if ($query->num_rows == 0) {
		$_SESSION['level'] == "";
		header('location:gagal.php');
	} elseif ($id <> $hasil['password']) {
		echo "Password <b>$id</b> salah";
	} elseif ($hasil['level'] == "admin") {
		$_SESSION['username'] = $nama;
		$_SESSION['level'] = "admin";
		$_SESSION['nama_petugas'] = $hasil['nama_petugas'];
		header('location:new_admin/home.php');
	} elseif ($hasil['level'] == "petugas") {
		$_SESSION['username'] = $nama;
		$_SESSION['level'] = "petugas";
		$_SESSION['nama_petugas'] = $hasil['nama_petugas'];
		header('location:new_petugas/home.php');
	} elseif ($hasil['level'] == "siswa") {
		$_SESSION['username'] = $nama;
		$_SESSION['level'] = "siswa";
		$_SESSION['nama_petugas'] = $hasil['nama_petugas'];
		header('location:new_siswa/home.php?v='. $hasil['id_petugas']);
	} else {
		$_SESSION['level'] == "";
		header('location:gagal.php');
	}
?>