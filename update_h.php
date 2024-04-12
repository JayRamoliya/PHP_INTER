<!-- <?php
$hobbies = []; 

if (isset($_POST['new_hobby'])) {
    $hobbies[] = ['hobby' => $_POST['new_hobby'], 'status' => 'active'];
} else{
    $hobbies[] = ['hobby' => $_POST['old_hobby'], 'status' => 'deactivated'];
}

print_r($hobbies);

?> -->

<?php
$hobby = []; // Initialize an empty array to store hobbies

// Check if the 'new_hobby' checkbox is checked in the POST data
if (isset($_POST['new_hobby'])) {
    // If the checkbox is checked, add the new hobby to the array with status 'active'
    $hobby[] = ['hobby' => $_POST['new_hobby'], 'status' => 'active'];
} else {
    // If the checkbox is not checked, add the old hobby to the array with status 'deactivated'
    $hobby[] = ['hobby' => $_POST['old_hobby'], 'status' => 'deactivated'];
}

// Print the contents of the $hobby array
print_r($hobby);

$hobb = array("Reading", "Traveling", "Coding", "Sports");

foreach ($hobb as $index => $h) {
    if ($hobby[0]['status'] == 'deactivated' && $h == $hobby[0]['hobby']) {
        unset($hobb[$index]);
    }
}

print_r($hobb);
?>
