<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "booksharingsys";

// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // echo "Connected successfully";
} catch(PDOException $e) {
    // echo "Connection Failed" . $e->geMessage();
}

// Check connection
// if ($conn->connect_error) {
    // die("Connection failed: " . $conn->connect_error);
// }
# echo "Connected successfully";
// echo "DB Connected!";
?>