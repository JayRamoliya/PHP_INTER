<?php
// error_reporting(0);
include "connection.php";
session_start();

if(isset($_COOKIE['id'])) {
  $id = $_COOKIE['id'];
  $decoded_id = base64_decode($id);

  $query = "SELECT * FROM FORM WHERE id = $decoded_id";
  
  $data = mysqli_query($connection, $query);
  $total = mysqli_num_rows($data);
  $result = mysqli_fetch_assoc($data);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Jay Ramoliya</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
  <h1 class="website-name"><a href="http://localhost/PHP/" id="logo">Jay Ramoliya</a></h1>
</header>

<div class="sidebar" id="sidebar">
  <nav class="sidebar-nav">
    <ul>
      <li><a href="http://localhost/PHP/">Home</a></li>
      <li><a href="http://localhost/PHP/addUser.php">Add User</a></li>
      <li><a href="http://localhost/PHP/userList.php">User List</a></li>
      <li><a href="http://localhost/PHP/contact.php">Contact</a></li>
      <li><a href="http://localhost/PHP/hobbies.php">Hobbies</a></li>
      <li><a href="http://localhost/PHP/educations.php">Educations</a></li>
      <li>
        <a href="logout.php">
          <?php
            if (isset($_SESSION['id'])) {
              echo 'Log out';
            }
            else{
              echo "Login";
            }
          ?>
        </a>
      </li>
    </ul>
  </nav>
</div>


<!-- <script>
  document.getElementById('menu-icon').addEventListener('click', function() {
  document.getElementById('sidebar').style.left = '0';
});

document.addEventListener('click', function(event) {
  if (!event.target.closest('.sidebar') && !event.target.closest('.menu-icon')) {
    document.getElementById('sidebar').style.left = '-250px';
  }
});

</script> -->

