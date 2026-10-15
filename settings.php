<?php
$conn = mysqli_connect('localhost', 'root', "", "travel_db"); // Create connection,there's no password attached to database travle_db 
if (!$conn) {
    die('Database connection failed.'); // if connection failed then database stops 

}