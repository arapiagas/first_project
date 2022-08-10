<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Admin</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/all.min.css">
	<link rel="stylesheet" href="../css/dataTables.bootstrap4.css">
	<style>
		body {
			padding-top: 1.7rem;
		}

		.navbar {
			border-bottom: 4px solid #FF0000;
		}

		main > .container {
			padding: 60px 15px 0;
		}

		.footer {
			background-color: #f5f5f5;
		}

		.footer > .container {
			padding-right: 15px;
			padding-left: 15px;
		}

		code {
			font-size: 80%;
		}

	</style>
</head>

<body>

	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<a class="navbar-brand" href="home.php?page=admin">Administrator</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">CRUD DATA <i class="fas fa-angle-down"></i></a>
					<div class="dropdown-menu" aria-labelledby="dropdown01">
						<a class="dropdown-item" href="home.php?page=kelas">Kelas</a><br>
						<a class="dropdown-item" href="home.php?page=petugas">Petugas</a><br>
						<a class="dropdown-item" href="home.php?page=spp">SPP</a><br>
						<a class="dropdown-item" href="home.php?page=siswa">Siswa</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transaksi <i class="fas fa-angle-down"></i></a>
					<div class="dropdown-menu" aria-labelledby="dropdown01">
						<a class="dropdown-item" href="home.php?page=pembayaran">Pembayaran</a>
						<a class="dropdown-item" href="home.php?page=history">History</a>
						<a class="dropdown-item" href="home.php?page=laporan">Generate Laporan</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link sb-sidenav-collapse-arrow" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create data <i class="fas fa-angle-down"></i></a>
					<div class="dropdown-menu" aria-labelledby="dropdown01">
						<a class="dropdown-item" href="create_kelas.php">Kelas</a>
						<a class="dropdown-item" href="create_petugas.php">Petugas</a>
						<a class="dropdown-item" href="create_spp.php">SPP</a>
						<a class="dropdown-item" href="create_siswa.php">Siswa</a>
						<a class="dropdown-item" href="create_pembayaran.php">Pembayaran</a>
					</div>
				</li>
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a onclick="return confirm('Apakah kamu sudah yakin ingin logout <?php echo $ad; ?>?');" href="logout.php" class="nav-link">
							<i class="fas fa-sign-out-alt"></i> Logout
						</a>
					</li>
				</ul>
		</div>
	</nav>

<footer class="footer mt-auto py-3 bottom">
  <div class="container">
    <span class="text-muted">Copyright &copy; SMK MA'ARIF WALISONGO KAJORAN 2021</span>
  </div>
</footer>
		<script src="../js/jquery-3.5.1.js" crossorigin="anonymous"></script>
		<script>
			window.jQuery || document.write('<script src="../jquery.slim.min.js"><\/script>')
		</script>
		<script src="..js/bootstrap.bundle.min.js"></script>
		<script src="../js/jquery.dataTables.js"></script>
		<script src="../js/all.min.js"></script>
		<script src="../js/dataTables.bootstrap4.js"></script>
	</div>
</body>

</html>