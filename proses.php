<?php 
	session_start();
	require_once("Connections/koneksi.php");
	mysql_select_db($database_koneksi, $koneksi);
	$username = mysql_real_escape_string(trim($_POST['username']));
	$password = mysql_real_escape_string($_POST['password']);
	$cek = mysql_query("SELECT * FROM petugas WHERE username = '$username'");
	$hasil = mysql_fetch_array($cek);
	$nama = $hasil['nama_petugas'];
	if (mysql_num_rows($cek) == 0) {
		echo "
		<script>
        	alert('Login gagal...');
        	alert('Silahkan Login Kembali...');
        	window.location.href = 'index.php';
    	</script>";
	} elseif ($password <> $hasil['password']) {
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		header('location:salah.php');
	} elseif ($hasil['level'] == "admin") {
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "admin";
		$_SESSION['admin'] = true;
		$_SESSION['nama_petugas'] = $hasil['nama_petugas'];
		echo "
		<script>
		alert('Login Sebagai Admin Berhasil');
		alert('Selamat Datang $nama');
		window.location.href = 'new_admin/home.php';
		</script>";
	} elseif ($hasil['level'] == "petugas") {
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "petugas";
		$_SESSION['petugas'] = true;
		$_SESSION['nama_petugas'] = $hasil['nama_petugas'];
		echo "
		<script>
		alert('Login Sebagai Petugas Berhasil');
		alert('Selamat Datang $nama');
		window.location.href = 'new_petugas/home.php';
		</script>";
	} elseif ($hasil['level'] == "siswa") {
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "siswa";
		$_SESSION['siswa'] = true;
		$_SESSION['nama_petugas'] = $hasil['nama_petugas'];
		$_SESSION['id_petugas'] = $hasil['id_petugas'];
		echo "
		<script>
		alert('Login Sebagai Siswa Berhasil.');
		alert('Selamat Datang $nama');
		window.location.href = 'new_siswa/home.php';
		</script>";
	} else {
		echo "
		<script>
			window.location.href = 'index.php';
		</script>";
	}
 ?>