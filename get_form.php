<?php
error_reporting(0);
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $firstName = $_GET['firstName'];
    $lastName = $_GET['lastName'];
    $password = md5($_GET['password']);
    $gender = $_GET['gender'];
    $hobbies = implode(', ', $_GET['hobbies']);
    $education = serialize($_GET['selected_education']);
    $email = $_GET['email'];
    $phoneNumber = $_GET['phoneNumber'];

    if ($firstName != "" && $lastName != "" && $password != "" && $gender != "" && $hobbies != "" && $email != ""  && $phoneNumber != "") {

        $checkQuery = "SELECT * FROM FORM WHERE email = '$email'";
        $checkResult = mysqli_query($connection, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "Email already exists in the database";
        } else {    
            $query = "INSERT INTO FORM (firstname, lastname, password, gender, hobbies, email,phone, createdAt, updateDate,education)
              VALUES ('$firstName', '$lastName', '$password', '$gender', '$hobbies', '$email','$phoneNumber', NOW(), NOW(),'$education')";

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
