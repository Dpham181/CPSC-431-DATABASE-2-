<?php

// create short variable names
$name       = preg_replace("/\t|\R/",' ',$_POST['name']);
$time       = preg_replace("/\t|\R/",' ',$_POST['time']);
$points     = (int) $_POST['points'];
$assists    = (int) $_POST['assists'];
$rebounds   = (int) $_POST['rebounds'];


require('PlayerStatistic.php');

$newStat = new PlayerStatistic($name, $time, $points, $assists, $rebounds);

if( ! empty($name) )
{
  file_put_contents('statistics.txt', $newStat->toTSV()."\n", FILE_APPEND | LOCK_EX);
}

require('home_page.php');
?>
