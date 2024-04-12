<?php
include "header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && isset($_POST["hobby_id"])) {
    $hobby_id = $_POST["hobby_id"];

    $sql = "DELETE FROM hobby WHERE id = ?";
    
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $hobby_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Hobby deleted successfully.";
        } else {
            echo "Error deleting hobby: " . mysqli_error($connection);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing delete statement: " . mysqli_error($connection);
    }
} else {
    echo "Invalid request.";
}

include "footer.php";
?>
