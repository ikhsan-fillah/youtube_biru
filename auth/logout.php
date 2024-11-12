<?php
//mulaikan session
session_start();

//hapus session
session_destroy();

//redirect ke halaman index sebelum login
header("Location: ../index.php");
exit();
?>