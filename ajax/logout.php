<?php
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
session_start();
echo '<response>';
	unset($_SESSION['edrpadmin_login']);
	session_destroy();
	echo('1');
echo '</response>';
?>