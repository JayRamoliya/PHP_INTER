<?php
include "header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $hobby = $_POST['hobby'];
    $status = isset($_POST['status']) ? $_POST['status'] : 'inactive'; 
    
    $currentDateTime = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO hobby (name, status, createdate, updatedate) VALUES (?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($connection, $sql);    
    mysqli_stmt_bind_param($stmt, "ssss", $hobby, $status, $currentDateTime, $currentDateTime);
    
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "Hobby added successfully.";
    } else {
        echo "Error adding hobby.";
    }
}
?>
