<?php
$dbc = mysqli_connect('localhost','igra','4E0b2X0r','igra') or die('error db connect');
//print_r($dbc); die;
mysqli_set_charset ($dbc ,'utf8');
$time_created = strtotime('1 week ago');
//echo date('d.m.Y', $timehistory);
$query = "DELETE FROM `pay_in` WHERE created < {$time_created} AND complete = 0";
$query2 = "DELETE FROM `pay_in` WHERE created is NULL AND complete = 0";
mysqli_query($dbc, $query) or die(mysqli_error($dbc));
mysqli_query($dbc, $query2) or die(mysqli_error($dbc));

?>