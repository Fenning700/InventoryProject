<?php 
	session_start();

  //Connect to database
  $conn = mysqli_connect("localhost", "root", "secret", "inventoryDB");

  if (!$conn) {
    die("Error connecting to database: " . mysqli_connect_error());
  }



  // Define global constants
	define ('ROOT_PATH', __DIR__);
	define('BASE_URL', 'http://inventory.test');
?>