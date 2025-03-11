<?php
$servername = "localhost";  // Database host (usually 'localhost')
$username = "blog_user";  // Your database username
$password = "Blog_Pass123!";  // Your database password
$dbname = "blog_db";  // Your database name

// Create connection
 $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection

if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
     }

     // If you reach here, the connection was successful
     // You can now use the $conn variable for database queries/     
?>

