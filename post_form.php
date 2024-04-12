<?php
error_reporting(0);
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $password = md5($_POST['password']);
    $gender = $_POST['gender'];
    $hobbies = implode(', ', $_POST['hobbies']);
    $education = serialize($_POST['selected_education']);
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $profilePhoto = $_POST['profilePhoto'];

    if ($firstName != "" && $lastName != "" && $password != "" && $gender != "" && $hobbies != "" && $email != "" && $phoneNumber != "") {

        $checkQuery = "SELECT * FROM FORM WHERE email = '$email'";
        $checkResult = mysqli_query($connection, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "Email already exists in the database";
        } else {
            $query = "INSERT INTO FORM (firstname, lastname, password, gender, hobbies, email,phone, createdAt, updateDate,profile,education)
              VALUES ('$firstName', '$lastName', '$password', '$gender', '$hobbies', '$email','$phoneNumber', NOW(), NOW(),'$profilePhoto','$education')";

            $data = mysqli_query($connection, $query);

            if ($data) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $query . "<br>" . $connection->error;
            }
        }
    } else {
        echo "Empty fields. Please fill in all the required information.";
    }
    } else {
        echo "Error: Invalid request!";
    }
?>
