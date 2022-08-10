<?php
//mengaktifkan Session php 
session_start();
//menghapus Session php
session_unset();
session_destroy();
echo "
<script>
	alert('Berhasil Logout.');
	window.location.href = '../index.php';
</script>";
?>