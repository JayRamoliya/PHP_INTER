<?php
include "header.php";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if (isset($_POST['education'])) {
            $name = mysqli_real_escape_string($connection, $_POST['education']);
            $active = isset($_POST['status']) ? "enable" : "disable"; 

            $updated_date = date('Y-m-d H:i:s');
    
            $update_query = "UPDATE education_qualifications SET education = '$name', updatedAt = '$updated_date', status = '$active' WHERE id = '$id'";
            $update_result = mysqli_query($connection, $update_query);
    
            if ($update_result) {
                header("Location: educations.php");
                exit(); 
            } else {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
            echo "Error: Name field is missing.";
        }
    }
    

    $query = "SELECT * FROM education_qualifications WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Error fetching data: " . mysqli_error($connection));
    }

    $row = mysqli_fetch_assoc($result);
    $name = $row['education'];
    $active = $row['status'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Education Qualification</title>
    <style>
    </style>
</head>
<body>
    <h2>Edit Education Qualification</h2>
    <form method="POST">
        <input type="text" id="name" name="education" value="<?php echo $name; ?>"><br>
        <input type="checkbox" id="active" name="status" <?php echo ($active == "enable") ? 'checked' : ''; ?>>
        <input type="submit" value="Update">
    </form>
</body>
</html>
<?php
} else {
    echo "Error: ID not provided.";
}
?>
