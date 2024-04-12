<?php
include "header.php";
include "session.php";

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['id'])) {    
    $encoded_id = $_SESSION['id'];

    if (isset($_COOKIE['id'])) {

        $en_id = $_COOKIE['id'];
    
        if ($encoded_id !== $en_id) { 
            header("Location: login.php");
            exit(); 
        }
    } else {
        // echo "Encoded ID cookie not found.sdfds";
        header("Location: login.php");
        exit();
    }
}

?>