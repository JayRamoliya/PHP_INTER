
<?php
include "connection.php";

if (isset($_COOKIE['id'])) {

    $encoded_id = $_COOKIE['id'];
    $decoded_id = base64_decode($encoded_id);

    $query = "SELECT * FROM FORM WHERE id = '$decoded_id' ";
    $data = mysqli_query($connection, $query);
    $total = mysqli_num_rows($data);
    
    if ($total > 0) {
        $result = mysqli_fetch_assoc($data);
        $email = $result['email'];
        $password = $result['password'];

        $query = "SELECT * FROM FORM WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            // $_SESSION['user'] = $user_data;
            // header("Location: index.php");
            // exit();
        }
    }
} else {
    echo "Encoded ID cookie not found.";
    header("Location: login.php");
    exit();
}

?>

