<?php 
session_start();
session_destroy();
header('Location: /ponto_2.0/public_html/admin/main/index.php#');
exit;
?>