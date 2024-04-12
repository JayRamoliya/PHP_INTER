<?php
include "connection.php";

$id = $_GET['id'];
$query = "SELECT * FROM FORM where id= '$id' ";

$data = mysqli_query($connection, $query);
$total = mysqli_num_rows($data);
$result = mysqli_fetch_assoc($data)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <style>
         #profileImageInput {
            display: none;
        }

        .custom-button {
            display: inline-block;
            background-color: #4caf50;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .custom-button-label {
            cursor: pointer;
        }
        img{
            width: 50px;
            height: 50px;
            border-radius:50%;
        }
        #imageDisplay {
            width: 300px;
            height: 250px;
        }

        #display {
            border: 1px solid #000;
            padding: 5px;
            margin: 10px;
            width: 400px;
            height: 650px;
        }

        #displayFormData {
            border: 2px solid #cd3c3c;
            padding: 5px;
            margin: 10px;
            width: 500px;
            height: 650px;
        }

        #formData {
            margin-top: 20px;
            padding: 10px;
            background-color: #949892;
            border: 1px solid #369437;
            border-radius: 4px;
            color: #3c763d;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            gap: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* height: 100vh; */
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin: 10px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            display: inline-block;
            background-color: #4caf50;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
        color: red;
        font-size: 15px;
        margin-bottom: 10px;
        }


    </style>

</head>

<body id="body">
<?php

$firstNameErr = $lastNameErr = $emailErr = $passwordErr = $confirmPasswordErr = $genderErr = $hobbiesErr = $phoneNumberErr = "";
$firstName = $lastName = $email = $password = $confirmPassword = $gender = $phoneNumber = "";
$hobbies = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate First Name
    if (empty($_POST["firstName"])) {
        $firstNameErr = "First Name is required";
    } else {
        $firstName = test_input($_POST["firstName"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
            $firstNameErr = "Only letters and white space allowed";
        }
    }

    // Validate Last Name
    if (empty($_POST["lastName"])) {
        $lastNameErr = "Last Name is required";
    } else {
        $lastName = test_input($_POST["lastName"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $lastName)) {
            $lastNameErr = "Only letters and white space allowed";
        }
    }

    // Validate Email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate Password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters long";
        }
    }

    // Validate Confirm Password
    if (empty($_POST["confirmPassword"])) {
        $confirmPasswordErr = "Confirm Password is required";
    } else {
        $confirmPassword = test_input($_POST["confirmPassword"]);
        if ($confirmPassword !== $password) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    // Validate Gender
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    // Validate Hobbies
    if (empty($_POST["hobbies"]) || count($_POST["hobbies"]) < 2) {
        $hobbiesErr = "Please select at least two hobbies";
    } else {
        $hobbies = $_POST["hobbies"];
    }

    // Validate Phone Number
    if (empty($_POST["phoneNumber"])) {
        $phoneNumberErr = "Phone Number is required";
    } else {
        $phoneNumber = test_input($_POST["phoneNumber"]);
        if (!preg_match("/^[0-9]{10}$/", $phoneNumber)) {
            $phoneNumberErr = "Invalid phone number format";
        }
    }
    
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$queryi = "SELECT * FROM hobby WHERE status = 'active'";
$results = mysqli_query($connection, $queryi);

if ($results) {
    $active_hobbies = [];

    while ($row = mysqli_fetch_assoc($results)) {
        $active_hobbies[] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }
}

?>

<form id="myForm" name="myForm" method="POST" onsubmit="return validateForm()">
    
    <img src="http://localhost/PHP/images/<?php echo $result['profile'];?>" id="profileImage">
    <label for="profileImageInput" class="custom-button-label">
        <span class="custom-button">Edit</span>
    </label>
    <input type="file" id="profileImageInput" name="profileImage">
    <button type="button" id="removeProfileBtn">Remove</button>

    <label for="firstName" id="firstNamelabel">First Name:</label>
    <input type="text" id="firstName" name="firstName" oninput="validateFirstName()" value="<?php echo $result['firstname'] ?>">
    <div id="firstNameError" class="error-message"></div>
    <div class="error-message"><?php echo $firstNameErr;?></span></div>

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" oninput="validateLastName()" value="<?php echo $result['lastname'] ?>">
    <div id="lastNameError" class="error-message"></div>
    <div class="error-message"><?php echo $lastNameErr;?></span></div>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" oninput="validateEmail()" value="<?php echo $result['email'] ?>">
    <div id="emailError" class="error-message"></div>
    <div class="error-message"><?php echo $emailErr;?></span></div>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" oninput="validatePassword()">
    <div id="passwordError" class="error-message"></div>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" onchange="validateGender()">
        <option value="" disabled selected>Select your gender</option>
        <option value="male" 
        <?php
            if ($result['gender'] == 'male') {
                echo "selected";
            }
        ?>
        >Male</option>
        <option value="female"
        <?php
            if ($result['gender'] == 'female') {
                echo "selected";
            }
        ?>
        >Female</option>
        <option value="other">Other</option>
    </select>
    <div id="genderError" class="error-message"></div>
    <div class="error-message"><?php echo $genderErr;?></span></div>

    <label for="hobbies" id="label0">Hobbies (select at least two):</label>
    <div id="hobbiesError" class="error-message"><?php echo $hobbiesErr; ?></div>

    <div id="hobbiesCheckboxes">
    <?php
    foreach ($active_hobbies as $index => $hobby) {
        echo '<label id="label' . ($index + 1) . '">' . $hobby['name']; 
        echo '<input type="checkbox" name="hobbies[]" id="check' . ($index + 1) . '" value="' . $hobby['id'] . '" onchange="validateHobbies()">'; 
        echo '</label>';
    }
    ?>
    </div>

    <label for="phoneNumber">Phone Number:</label>
    <input type="tel" id="phoneNumber" name="phoneNumber" oninput="validatePhoneNumber()" value="<?php echo $result['phone'] ?>">
    <div id="phoneNumberError" class="error-message"></div>
    <div class="error-message"><?php echo $phoneNumberErr;?></span></div>

    <button type="submit" id="submitbutton" name="update">Update</button>
</form>

<script>

    document.addEventListener("DOMContentLoaded", function() {
    var myForm = document.getElementById('myForm');
    myForm.addEventListener("submit", function(event) {
        event.preventDefault();

        var urlParams = new URLSearchParams(window.location.search);
        var id = urlParams.get('id');

        var formData = new FormData(this);
        formData.append('id', id);

        var xhr = new XMLHttpRequest();

        xhr.open("POST", "post_update.php");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    // window.location.href = 'userList.php';
                } else {
                    console.error('Error:', xhr.status);
                }
            }
        };
        xhr.send(formData);
    });
    });


    var removeProfileBtn = document.getElementById('removeProfileBtn');

    const editBtn = document.querySelector('.custom-button');
    const profileImageInput = document.getElementById('profileImageInput');
    const profileImage = document.getElementById('profileImage');


    profileImageInput.addEventListener('change', function() {
        document.getElementById("profileImage").src = "";
        const reader = new FileReader();

        reader.onload = function(event) {
            src = event.target.result;
            document.getElementById("profileImage").src = src;
        };
        reader.readAsDataURL(profileImageInput.files[0]);
    });

    document.addEventListener("DOMContentLoaded", function () {
        var srcpath = document.getElementById("profileImage").src;

        document.getElementById("removeProfileBtn").addEventListener("click", function () {
            var confirmation = confirm("Are you sure you want to remove the profile image?");
            if (confirmation) {
                removeProfileImage();
            }
        });

        function removeProfileImage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById("profileImage").src = "";
                        alert("Profile image removed successfully.");
                    } else {
                        alert("Error: Unable to remove profile image.");
                    }
                }
            };
            xhr.open("POST", "delete_image.php", true); 
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("srcpath=" + srcpath);
        }
    });

    function validateFirstName() {
        const firstName = document.getElementById('firstName').value.trim();
        const firstNameError = document.getElementById('firstNameError');
        if (firstName === '') {
            firstNameError.textContent = 'Field cannot be empty';
        }
        else if (!/^[A-Za-z]+$/.test(firstName)) {
            firstNameError.textContent = 'Please enter only alphabetic characters';
        } else {
            firstNameError.textContent = '';
        }
    }

    function validateLastName() {
        const lastName = document.getElementById('lastName').value.trim();
        const lastNameError = document.getElementById('lastNameError');
        if (lastName === '') {
            lastNameError.textContent = 'Field cannot be empty';
        }
        else if (!/^[A-Za-z]+$/.test(lastName)) {
            lastNameError.textContent = 'Please enter only alphabetic characters';
        } else {
            lastNameError.textContent = '';
        }
    }

    function validateEmail() {
        const email = document.getElementById('email').value.trim();
        const emailError = document.getElementById('emailError');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '') {
            emailError.textContent = 'Field cannot be empty';
        }
        else if (!emailRegex.test(email)) {
            emailError.textContent = 'Please enter a valid email address';
        } else {
            emailError.textContent = '';
        }
    }

    function validatePassword() {
        const password = document.getElementById('password').value.trim();
        const passwordError = document.getElementById('passwordError');
        if (password.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters long';
        } else {
            passwordError.textContent = '';
        }
    }

    function validateGender() {
        const gender = document.getElementById('gender').value;
        const genderError = document.getElementById('genderError');

        if (gender === '') {
            genderError.textContent = 'Please select your gender';
        } else {
            genderError.textContent = '';
        }
    }

    function validateHobbies() {
        const hobbiesCheckboxes = document.querySelectorAll('input[name="hobbies[]"]:checked');
        const hobbiesError = document.getElementById('hobbiesError');

        if (hobbiesCheckboxes.length < 2) {
            hobbiesError.textContent = 'Please select at least two hobbies';
        } else {
            hobbiesError.textContent = '';
        }
    }

    function validatePhoneNumber() {
        const phoneNumber = document.getElementById('phoneNumber').value.trim();
        const phoneNumberError = document.getElementById('phoneNumberError');

        const phoneNumberRegex = /^\d{10}$/;

        if (phoneNumber === '') {
            phoneNumberError.textContent = 'Field cannot be empty.'; 
        } else if (!phoneNumberRegex.test(phoneNumber)) {
            phoneNumberError.textContent = 'Please enter a valid 10-digit phone number';
        } else {
            phoneNumberError.textContent = '';
        }
    }

    function validateForm() {
        let isValid = true;

        // Validate First Name
        const firstName = document.getElementById('firstName').value.trim();
        const firstNameError = document.getElementById('firstNameError');
        if (firstName === '') {
            firstNameError.textContent = 'First name cannot be blank.';
        }
        else if (!/^[A-Za-z]+$/.test(firstName)) {
            firstNameError.textContent = 'Please enter only alphabetic characters.';
            isValid = false;
        } else {
            firstNameError.textContent = '';
        }

        // Validate Last Name
        const lastName = document.getElementById('lastName').value.trim();
        const lastNameError = document.getElementById('lastNameError');
        if (lastName === '') {
            lastNameError.textContent = 'Last name cannot be blank.';
        }
        else if (!/^[A-Za-z]+$/.test(lastName)) {
            lastNameError.textContent = 'Please enter only alphabetic characters.';
            isValid = false;
        } else {
            lastNameError.textContent = '';
        }

        // Validate Email
        const email = document.getElementById('email').value.trim();

        const emailError = document.getElementById('emailError');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '') {
            emailError.textContent = 'email cannot be blank.';
        }
        else if (!emailRegex.test(email)) {
            emailError.textContent = 'Please enter a valid email address.';
            isValid = false;
        } else {
            emailError.textContent = '';
        }

        // Validate Password
        // const password = document.getElementById('password').value.trim();
        // const passwordError = document.getElementById('passwordError');
        // if (password.length < 6) {
        //     passwordError.textContent = 'Password must be at least 6 characters long.';
        //     isValid = false;
        // } else {
        //     passwordError.textContent = '';
        // }

        // Validate Gender
        const gender = document.getElementById('gender').value;
        const genderError = document.getElementById('genderError');
        if (gender === '') {
            genderError.textContent = 'Please select your gender.';
            isValid = false;
        } else {
            genderError.textContent = '';
        }

        // Validate Hobbies
        const hobbiesCheckboxes = document.querySelectorAll('input[name="hobbies[]"]:checked');
        const hobbiesError = document.getElementById('hobbiesError');
        if (hobbiesCheckboxes.length < 2) {
            hobbiesError.textContent = 'Please select at least two hobbies.';
            isValid = false;
        } else {
            hobbiesError.textContent = '';
        }

        // Validate Phone Number
        const phoneNumber = document.getElementById('phoneNumber').value.trim();
        const phoneNumberError = document.getElementById('phoneNumberError');
        if (phoneNumber === '') {
            phoneNumberError.textContent = 'phoneNumber cannot be blank.';
        }
        else if (phoneNumber !== '' && !/^\d{10}$/.test(phoneNumber)) {
            phoneNumberError.textContent = 'Please enter a valid 10-digit phone number.';
            isValid = false;
        } else {
            phoneNumberError.textContent = '';
        }

        return isValid;
    }

</script>

</body>
</html>


<?php

// if (isset($_POST['update'])) {
//     $firstName = $_POST['firstName'];
//     $lastName = $_POST['lastName'];
//     $password = md5($_POST['password']);
//     $gender = $_POST['gender'];
//     $hobbies = implode(', ', $_POST['hobbies']);
//     $email = $_POST['email'];
//     $phoneNumber = $_POST['phoneNumber'];
//     $profileImage = $_POST['profileImage'];

//     if ($firstName != "" && $lastName != "" && $gender != "" && $email != "") {

//         $checkQuery = "SELECT * FROM FORM WHERE email = '$email' AND id != '$id'";
//         $checkResult = mysqli_query($connection, $checkQuery);

//         // if (mysqli_num_rows($checkResult) > 0) {
//         //     echo "<script>alert('Email already exists in the database')</script>";
//         // } else {

//             $updateQuery = "UPDATE FORM
//                 SET profile='$profileImage', firstName='$firstName', lastname='$lastName', password='$password' ,gender='$gender', hobbies='$hobbies', email='$email',phone='$phoneNumber', updateDate=NOW() WHERE id='$id'";

//             $updateData = mysqli_query($connection, $updateQuery);

//             if ($updateData) {
//                 // echo "<script>alert('Record updated successfully')</script>";
//                 echo "<meta http-equiv='refresh' content='0; url=http://localhost/PHP/userList.php' />";
//                 // echo "suss";
//             } else {
//                 echo "Error: " . $updateQuery . "<br>" . $connection->error;
//             }
//         // }
//     } else {
//         echo "Empty fields. Please fill in all the required information.";
//     }
// }

?>


