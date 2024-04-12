<?php
include "header.php";

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit(); 
}

if (isset($_SESSION['id'])) {    
    $encoded_id = $_SESSION['id'];

    if (isset($_COOKIE['id'])) {
        $en_id = $_COOKIE['id'];
    
        if ($encoded_id !== $en_id) { 
            header("Location: login.php");
            exit(); 
        }
    } else {
        // echo "Encoded ID cookie not found.sdfds";
        header("Location: login.php");
        exit();
    }
}


if(isset($_COOKIE['id'])) {
    $id = $_COOKIE['id'];
    $decoded_id = base64_decode($id);
  
    // $query = "SELECT * FROM FORM WHERE id = $decoded_id";
    $query = "SELECT * FROM hobby";
    
    $data = mysqli_query($connection, $query);
    $total = mysqli_num_rows($data);
    $result = mysqli_fetch_assoc($data);
  }
?>


<style>
    #headerform {
        margin: 0;
        padding:0;
        width: 70px;
    }
    table {
        width: 800px;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    button{
        width: 70px;
    }
</style>


<?php
$query = "SELECT * FROM hobby";

$result = mysqli_query($connection, $query);


echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th>Hobby Name</th>';
echo '<th>Status</th>';
echo '<th>Created Date</th>';
echo '<th>Updated Date</th>';
echo '<th>Edit</th>';
echo '<th>Delete</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';


if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $createdAtFormatted = date('d-M-Y', strtotime($row['createdate'])); 
        $updatedAtFormatted = date('d-M-Y', strtotime($row['updatedate'])); 
        echo '<tr>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['status'] . '</td>';
        echo '<td>' . $createdAtFormatted . '</td>';
        echo '<td>' . $updatedAtFormatted . '</td>'; 
        echo '<td>' . '<form method="POST" action="delete_hobby.php" id="headerform">
                        <input type="hidden" name="hobby_id" value="' . $row['id'] . '">
                        <button type="submit" name="delete">Delete</button>
                    </form>'  . '</td>'; 
        echo '<td>' . '<form method="GET" action="edit_hobby.php" id="headerform">
                        <input type="hidden" name="hobby_id" value="' . $row['id'] . '">
                        <button type="submit" name="edit">Edit</button>
                    </form>'  . '</td>'; 
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">Error: ' . mysqli_error($connection) . '</td></tr>';
}

echo '</tbody>';
echo '</table>';

echo '<form method="POST" action="newhobbies.php" id="headerform">
<button type="submit" name="delete">Add</button>
</form>';

?>

<?php
include "footer.php"
?>



       