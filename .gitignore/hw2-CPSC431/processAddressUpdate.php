<?php

// create short variable names
$fname     =preg_replace("/\t|\R/",' ', $_POST['firstName']);
$lname     = preg_replace("/\t|\R/",' ', $_POST['lastName']);
$name      = $fname.",".$lname;
$street   = (string) $_POST['street'];
$city     = (string) $_POST['city'];
$state    = (string) $_POST['state'];
$zip      = (int) $_POST['zipCode'];


require('Address.php');

$newStat = new information($name, $street, $city, $state, $zip);

if( ! empty($name) )
{
  file_put_contents('data/roster.txt', $newStat->toTSV()."\n", FILE_APPEND | LOCK_EX);
}

require('home_page.php');
?>
