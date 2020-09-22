<?php

$dbc = mysqli_connect('localhost','igra','4E0b2X0r','igra') or die('error db connect');
mysqli_set_charset ($dbc ,'utf8');
$timehistory = strtotime('2 month ago');
//echo date('d.m.Y', $timehistory);
$query = "DELETE FROM `login_history` WHERE login_date < {$timehistory}";
$data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

?>