<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);


  #Database configuration
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "DEMODATABASE";

  #Create a new MySQLi connection
  $connection = new mysqli($servername, $username, $password, $dbname) or die("Connection Failed");
?>
