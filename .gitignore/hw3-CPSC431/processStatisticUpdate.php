<?php

// create short variable names( now it is player indentifie by number not string anymore)
$player =   (int) trim(preg_replace("/\t|\R/",' ',$_POST['name_ID']));
$time       = preg_replace("/\t|\R/",' ',$_POST['time']);
$point     = (int) $_POST['points'];
$assists    = (int) $_POST['assists'];
$rebounds   = (int) $_POST['rebounds'];
require_once ('PlayerStatistic.php');

// checking $time with strpos if $ time min:sec ( slpit it into two parts )

if (strpos($time, ":") == false) {
  $min = $time;
  $sec = 0 ;
}else {
  list($min,$sec) = explode(":",$time);

}

require_once('config.php');
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// need to select player before adding value into database.
if(!empty($player)){
/// add row and col by the artribues listing same as database provided.
$sql = "INSERT INTO statistics SET
Player=?,
PlayingTimeMin =?,
PlayingTimeSec =?,
Points=?,
Assists=?,
Rebounds=?";
// prepare all quyery, blind and excute.
  $stmt=$link->prepare($sql);
  $stmt->bind_param('dddddd', $player,$min,$sec,$assists,$point,$rebunds);
  $stmt->execute();
  $link->close();

}
require('home_page.php');


?>
