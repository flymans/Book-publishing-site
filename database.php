<?php
$cnct = mysql_connect("localhost", "root", "");
$dbselect = mysql_select_db("books");
mysql_set_charset("utf8");
error_reporting(E_ALL & ~E_NOTICE);
?>
