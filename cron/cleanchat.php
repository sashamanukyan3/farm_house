<?php
$dbc = mysqli_connect('localhost','igra','4E0b2X0r','igra') or die('error db connect');
mysqli_set_charset ($dbc ,'utf8');
$time_created = strtotime('12 hours ago');
//echo date('d.m.Y', $timehistory);
$query = "DELETE FROM `chat` WHERE created_at < {$time_created}";
mysqli_query($dbc, $query) or die(mysqli_error($dbc));

?>