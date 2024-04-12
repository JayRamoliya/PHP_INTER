<?php
include "header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $education = $_POST['education'];
    $description = $_POST['description'];
    $parentEducation = $_POST['parentEducation'];
    $status = isset($_POST['status']) ? $_POST['status'] : 'disable'; 

    $query = "INSERT INTO education_qualifications (education, description, parentId, status) 
              VALUES ('$education', '$description', '$parentEducation', '$status')";

    if (mysqli_query($connection, $query)) {
        header("Location: educations.php");
        exit(); 
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    mysqli_close($connection);
}
?>
