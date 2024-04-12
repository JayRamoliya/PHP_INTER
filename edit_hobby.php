<?php
include "header.php";

if(isset($_GET['hobby_id'])) {
    $hobby_id = $_GET['hobby_id'];
    
    $query = "SELECT * FROM hobby WHERE id = $hobby_id";
    $result = mysqli_query($connection, $query);
    
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        $hobby_name = $row['name'];
        $status = $row['status'];
        
        mysqli_free_result($result);
?>
        <form method="POST" action="update_hobby.php">
            <input type="hidden" name="hobby_id" value="<?php echo $hobby_id; ?>">
            <input type="text" id="hobby_name" readonly name="hobby_name" value="<?php echo $hobby_name; ?>"><br>
            <label for="status">Status:</label>
            <input type="checkbox" id="status" name="new_status" <?php if($status == 'active') echo 'checked'; ?>><br>
            <button type="submit" name="update">Update</button>
        </form>    
<?php
    } else {
        echo "Error: Hobby not found.";
    }
} else {
    echo "Error: Hobby ID not provided.";
}

include "footer.php";
?>
