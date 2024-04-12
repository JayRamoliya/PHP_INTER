
<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['srcpath'])) {
        $srcpath = $_POST['srcpath'];
        $filename = basename($srcpath);

        $url= "C:/xampp/htdocs/PHP/images/".$filename;
        unlink($url);
    } else {
        echo "Error: Source path of the image is missing.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>



