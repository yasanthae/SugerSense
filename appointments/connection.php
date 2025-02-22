<?php

    $database= new mysqli("db","sugersense","Kingswood@123","SUGERSENSE");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>