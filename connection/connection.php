<?php
$servername = "localhost";
$username = "root";
$password = "2474";
$dbname = "cdm-internship-database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}