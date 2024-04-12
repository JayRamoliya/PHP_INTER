<?php
include "header.php";
session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
         .centered-content {
            text-align: center;
            margin-top: 50px;
        }
        .profile-card {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 20px;
    width: 300px;
    margin: 20px auto;
    background-color: #f9f9f9;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.profile-card:hover {
    border-radius: 10px;
    padding: 20px;
    outline:none;
    width: 300px;
    margin: 20px auto;
    background-color: #f9f9f9;
    box-shadow: 3px 2px 30px black;
}

.profile-card h2 {
    text-align: center;
    color: #333;
}

.profile-info {
    margin-top: 20px;
}

.profile-info p {
    margin: 10px 10px;
}

.profile-info p strong {
    font-weight: bold;
}

    </style>
</head>

<body>
<div class="centered-content">
        <?php
        if(isset($_SESSION['user'])) {
            $user_data = $_SESSION['user'];

        $encoded_id = base64_encode($user_data['id']);
        $_SESSION['encoded_id'] = $encoded_id;
        } else {
            header("Location: login.php");
            exit();
        }

        if(isset($_SESSION['encoded_id'])) {
            $encoded_id = $_SESSION['encoded_id'];
            $decoded_id = base64_decode($encoded_id);

            $query = "SELECT * FROM FORM where id= '$decoded_id' ";

            $data = mysqli_query($connection, $query);
            $total = mysqli_num_rows($data);
            $result = mysqli_fetch_assoc($data);
        } else {
            echo "Encoded ID not found in session.";
        }
        ?>
    </div>
    <div class="profile-card">
    <h2>Profile</h2>
    <div class="profile-info">
        <p><strong>First Name:</strong> <?php echo $result['firstname'] ?></p>
        <p><strong>Last Name:</strong> <?php echo $result['lastname'] ?></p>
        <p><strong>Gender:</strong> <?php echo $result['gender'] ?></p>
        <p><strong>Email:</strong> <?php echo $result['email'] ?></p>
        <p><strong>Phone Number:</strong><?php echo $result['phone'] ?></p>
        <p><strong>Hobbies:</strong> <?php 
    $hobbies = explode(', ', $result['hobbies']);
    foreach ($hobbies as $hobby) {
        echo $hobby . ', ';
    }
    ?></p>
    </div>
</div>

</body>
</html>



