<?php
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hobby</title>
</head>
<body>
    <h2>Add Hobby</h2>
    <form method="POST" action="store_hobby.php">
        <label for="hobby">Hobby:</label>
        <input type="text" id="hobby" name="hobby" required>
        <br><br>
        <label for="status">Status:</label>
        <input type="checkbox" id="status" name="status" value="active" checked>
        <br><br>
        <button type="submit">Add Hobby</button>
    </form>
</body>
</html>
