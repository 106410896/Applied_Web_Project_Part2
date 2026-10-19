 
<?php
$conn = mysqli_connect('localhost', 'root', "", "travel_db"); // Create connection,there's no password attached to database travle_db 
if (!$conn) {
    die('Database connection failed.'); // if connection failed then database stops 

}
mysqli_set_charset($conn, 'utf8mb4');  // encodes text into data 
?>                                        
<?php
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $sql_db = "fantastic5";
?>
                      
