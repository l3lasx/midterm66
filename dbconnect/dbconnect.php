<?php
$servername = "localhost";
$username = "music";
$password = "abc123";
$dbname = "music_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conection Failed: " . $conn->connect_error);
}
?>