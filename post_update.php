<?php
error_reporting(0);
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $password = md5($_POST['password']);
        $gender = $_POST['gender'];
        $hobbies = implode(', ', $_POST['hobbies']);
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $profileImage = $_POST['profileImage'];

            if ($firstName != "" && $lastName != "" && $gender != "" && $email != "") {
            
                    $checkQuery = "SELECT * FROM FORM WHERE email = '$email' AND id != '$id'";
                    $checkResult = mysqli_query($connection, $checkQuery);
                
                    // if (mysqli_num_rows($checkResult) > 0) {
                    //     echo "<script>alert('Email already exists in the database')</script>";
                    // } else {
                
                    $updateQuery = "UPDATE FORM
                        SET profile='$profileImage', firstName='$firstName', lastname='$lastName', password='$password' ,gender='$gender', hobbies='$hobbies', email='$email',phone='$phoneNumber', updateDate=NOW() WHERE id='$id'";
                    $updateData = mysqli_query($connection, $updateQuery);
                
                    if ($updateData) {
                        echo "record update successfully";
                    } else {
                        echo "Error: " . $updateQuery . "<br>" . $connection->error;
                    }
                // }
            } else {
                echo "Empty fields. Please fill in all the required information.";
            }
        } else {
            echo "Error: Invalid request!";
        }
}
?>
