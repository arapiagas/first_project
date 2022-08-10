<?php session_start(); ?>
<?php
if (isset($_SESSION['admin'])) {
  header('location:new_admin/home.php');
  exit;
}
?>

<?php
if (isset($_SESSION['petugas'])) {
  header('location:new_petugas/home.php');
  exit;
}
?>

<?php
if (isset($_SESSION['siswa'])) {
  header('location:new_siswa/home.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="icon" href="loading.gif">

  <style type="text/css">
    .tombol {
      margin: auto;
      margin-top: 280px;
      width: 100%;
      max-width: 330px;
    }

    .proses {
      background-image: url(img/road2.jpg);
      background-size: cover;
      -webkit-background-size: cover;
    }

    .form-group {
      margin-top: 35px;
      margin-bottom: 35px;
    }

    #username,
    #password {
      margin-top: 25px;
      opacity: 55%;
      height: 60px;
      font-size: 20px;
      font-family: sans-serif;
      color: #fff;
    }

    #img {
      width: 30px;
      height: 30px;
    }
  </style>
</head>

<body>
  <button type="button" class="tombol btn btn-lg btn-block btn-dark" data-toggle="modal" data-target="#login">
    Klik Saya untuk Login <i class="fas fa-arrow-right"></i>
  </button>
  <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="login">Silahkan Login dulu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body proses">
          <form action="proses.php" method="POST" name="form1">
            <div class="form-group">
              <div>
                <p>
                  <label for="username" class="sr-only">Username</label>
                  <input id="username" type="text" class="form-control bg-dark" name="username" autocomplete="off" placeholder="Username"><br>
                  <label for="password" class="sr-only">Password</label>
                  <input id="password" type="password" class="form-control bg-dark" name="password" placeholder="Password">
                </p>
              </div>
            </div>
        </div>
          <div class="modal-footer">
            <img id="img" src="loading.gif">
            <input class="btn btn-md btn-dark" type="submit" name="submit" id="submit" value="Login">
            <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/all.min.js"></script>
  <script src="js/index.js"></script>
</body>

</html>