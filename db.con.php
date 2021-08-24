<?php

$username = "root";
$password = "root";
$dbname = "online_clearance";
$host = "localhost";

try {
  @$con = mysqli_connect($host,$username,$password,$dbname);
  if (!$con) throw new Exception();
} catch(\Exception $e) {
  die( "Application cannot start without valid database connection" );
}
