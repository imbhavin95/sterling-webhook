<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = 'test';
	$dbname = 'web';
	$connection = new mysqli($dbhost, $dbuser, $dbpass,$dbname) or die("Connect failed: %s\n". $conn -> error);$sql = "INSERT INTO `jobs`(`queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES ('first','secod', 1, 1, 1, 1)";
if ($connection->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $connection->error;
}