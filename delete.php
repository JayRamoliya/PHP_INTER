
<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id'])) {
        $id = $_POST['id'];

        $query = "DELETE FROM FORM WHERE id = $id";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}
?>
