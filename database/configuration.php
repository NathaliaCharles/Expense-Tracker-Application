<?php

    $host= "localhost";
    $user = "root";
    $password = "";
    $db_name = "db";


    $conn = new mysqli ($host, $user, $password, $db_name); 
    if ($conn -> connect_error) {
        die ("Failed to connect mysql: " .$_conn -> connect_error);
    }
    //echo "Connected successfully";

?>