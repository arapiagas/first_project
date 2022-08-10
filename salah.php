<?php sleep(1); ?>
<?php session_start(); ?>
<?php 
$username = $_SESSION['username'];
$password = $_SESSION['password'];
 ?>
<!DOCTYPE html>
<html>

<head>
    <title>Error</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/all.min.css">
    <style type="text/css">
        .north {
            z-index: 1;
            width: 100%;
            max-width: 300px;
            margin: auto;
            margin-top: 200px;
        }
    </style>
</head>

<body>

    <h1 class="h2">Password Salah</h1>
    <h1 class="h1 text-dark">Username <i><?php echo $username; ?></i> tidak cocok dengan Password <i><?php echo $password; ?></i> Silahkan Login
        <div onclick="show()" id="show"><u>Kembali</u> <i class="fas fa-sign-out-alt"></i></div>
        <div style="display: none;" onclick="hide()" id="hide"><u>Kembali</u> <i class="fas fa-sign-out-alt"></i></div>
    </h1>
    <div class="north btn btn-lg btn-block btn-success">
        <div id="not" class="badge-success">
            <h3 id="jam">Jam</h3>
            <h3 id="menit">Menit</h3>
            <h3 id="detik">Detik</h3>
        </div>
        <div>
            <a id="back" class="text-light" style="display: none;" href="index.php">
                Kembali Ke Halaman Login<i class="fas fa-sign-in-alt"></i>
            </a>
        </div>
    </div>

    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/all.min.js"></script>
    <script type="text/javascript">
        //Halaman Kembali
        function show() {
            document.getElementById('hide').style.display = 'block';
            document.getElementById('back').style.display = 'block';
            document.getElementById('show').style.display = 'none';
            document.getElementById('not').style.display = 'none';
        }

        function hide() {
            document.getElementById('hide').style.display = 'none';
            document.getElementById('back').style.display = 'none';
            document.getElementById('show').style.display = 'block';
            document.getElementById('not').style.display = 'block';
        }
        //Jam
        window.setTimeout("waktu()", 1000);

        function waktu() {
            var waktu = new Date();
            setTimeout("waktu()", 1000);
            document.getElementById('jam').innerHTML = waktu.getHours();
            document.getElementById('menit').innerHTML = waktu.getMinutes();
            document.getElementById('detik').innerHTML = waktu.getSeconds();
        }
    </script>
</body>

</html>