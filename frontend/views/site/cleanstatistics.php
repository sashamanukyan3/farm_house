<?php

$dbc = mysqli_connect('localhost','igra','4E0b2X0r','igra') or die('error db connect');
mysqli_set_charset ($dbc ,'utf8');
$query = "UPDATE `statistics` SET 
	`today_bought_feed_chickens`='0:0.00',
	`today_sold_feed_chickens`='0:0.00',
	`today_bought_feed_bulls`='0:0.00',
	`today_sold_feed_bulls`='0:0.00',
	`today_bought_feed_goats`='0:0.00',
	`today_sold_feed_goats`='0:0.00',
	`today_bought_feed_cows`='0:0.00',
	`today_sold_feed_cows`='0:0.00',
	`today_bought_eggs`='0:0.00',
	`today_sold_eggs`='0:0.00',
	`today_bought_meat`='0:0.00',
	`today_sold_meat`='0:0.00',
	`today_bought_goat_milk`='0:0.00',
	`today_sold_goat_milk`='0:0.00',
	`today_bought_cow_milk`='0:0.00',
	`today_sold_cow_milk`='0:0.00',
	`today_bought_dough`='0:0.00',
	`today_sold_dough`='0:0.00',
	`today_bought_mince`='0:0.00',
	`today_sold_mince`='0:0.00',
	`today_bought_cheese`='0:0.00',
	`today_sold_cheese`='0:0.00',
	`today_bought_curd`='0:0.00',
	`today_sold_curd`='0:0.00',
	`today_bought_chickens`='0:0.00',
	`today_bought_bulls`='0:0.00',
	`today_bought_goats`='0:0.00',
	`today_bought_cows`='0:0.00',
	`today_bought_paddock_chickens`='0:0.00',
	`today_bought_paddock_bulls`='0:0.00',
	`today_bought_paddock_goats`='0:0.00',
	`today_bought_paddock_cows`='0:0.00',
	`today_bought_factory_dough`='0:0.00',
	`today_bought_factory_mince`='0:0.00',
	`today_bought_factory_cheese`='0:0.00',
	`today_bought_factory_curd`='0:0.00',
	`today_bought_meat_bakery`='0:0.00',
	`today_bought_cheese_bakery`='0:0.00',
	`today_bought_curd_bakery`='0:0.00' WHERE 1";
$data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

?>