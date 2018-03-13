<?php

// create short variable names
$fname     = preg_replace("/\t|\R/",' ', $_POST['firstName']);
$lname     = preg_replace("/\t|\R/",' ', $_POST['lastName']);
$name      = $fname.",".$lname;
$street   = preg_replace("/\t|\R/",' ', $_POST['street']);
$city     = preg_replace("/\t|\R/",' ', $_POST['city']);
$state    = preg_replace("/\t|\R/",' ', $_POST['state']);
$country  = preg_replace("/\t|\R/",' ',$_POST['country']);
$zip      = (int) $_POST['zipCode'];
// if we only accpect lastname to be add into our database without the rest is emtpy
if(empty($fname)&&empty($street)&&empty($city)&&empty($state)&&empty($country)&&empty($zip)){
  $fname = null;
  $street= null;
  $city = null;
  $state= null;
  $country = null;
  $zip = null;
}

require_once ('Address.php');
require_once ('config.php'); // all credentials listed
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// if lname holding string then prepare, blind , excute the query for insert into our database. 
if(!empty($lname)){


$sql = "INSERT INTO teamroster SET
  Name_First = ?,
  Name_Last =?,
  Street=?,
  City=?,
  State=?,
  Country=?,
  ZipCode=?";
  $stmt=$link->prepare($sql);
  $stmt->bind_param('sssssss', $fname,$lname,$street,$city,$state,$country,$zip);

  $stmt->execute();
  $link->close();
}
require('home_page.php');
?>
