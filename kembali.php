<?php
//mengaktifkan Session php 
session_start();
//menghapus Session php
session_unset();
session_destroy();
header("location:index.php");
?>