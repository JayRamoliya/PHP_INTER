<?php
include "header.php"; 

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);

    // $delete_query = "DELETE FROM education_qualifications WHERE id = '$id'";
    $delete_query = "DELETE FROM education_qualifications WHERE id = '$id' OR parentId = '$id'";
    
    $delete_result = mysqli_query($connection, $delete_query);

    if ($delete_result) {
        header("Location: educations.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($connection);
    }
} else {
    echo "Error: ID not provided.";
}
?>
