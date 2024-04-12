<?php
include "header.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Education</title>
</head>
<body>
    <h2>Add Education</h2>
    <form method="POST" action="store_education.php">
        <label for="education">Education:</label>
        <input type="text" id="education" name="education" required>
        <br><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
        <br><br>
        <label for="parentEducation">Parent Education:</label>
        <select id="parentEducation" name="parentEducation">
            <option value="0">None</option>
            <?php
            $query = "SELECT id, education FROM education_qualifications";
            $result = mysqli_query($connection, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id'] . '">' . $row['education'] . '</option>';
                }
            }
            ?>
        </select>
        <br><br>
        <label for="status">Status:</label>
        <input type="checkbox" id="status" name="status" value="enable" checked>
        <br><br>
        <button type="submit">Add Education</button>
    </form>
</body>
</html>
