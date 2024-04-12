

<?php
include "header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"]) && isset($_POST["hobby_id"])) {
    $hobby_id = $_POST["hobby_id"];
    
    $updated_date = date('Y-m-d H:i:s');
    
    $status = isset($_POST['new_status']) ? 'active' : 'inactive';

    $sql = "UPDATE hobby SET status = ?, updatedate = ? WHERE id = ?";
    
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $status, $updated_date, $hobby_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Status updated successfully.";
        } else {
            echo "Error updating status: " . mysqli_error($connection);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing update statement: " . mysqli_error($connection);
    }
} else {
    echo "Invalid request.";
}

include "footer.php";
?>
