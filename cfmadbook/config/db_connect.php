<?php
    //Connect to database (phpmyadmin)
    $conn = mysqli_connect('localhost', 'ryan', 'Test123$Test123!', 'cfm_clients');

    //Test connection is successful 
    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }
?>