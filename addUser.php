<?php
include "header.php";
// include "session.php";

// if (!isset($_SESSION['user'])) {
//     header("Location: login.php");
//     exit();
// }
// if (isset($_SESSION['id'])) {    
//     $encoded_id = $_SESSION['id'];

//     if (isset($_COOKIE['id'])) {
//         $en_id = $_COOKIE['id'];
    
//         if ($encoded_id !== $en_id) { 
//             header("Location: login.php");
//             exit(); 
//         }
//     } else {
//         // echo "Encoded ID cookie not found.sdfds";
//         header("Location: login.php");
//         exit();
//     }
// }
?>


<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-nHIi9wBSlNyVw2AvZiQ5k6vzbOqapDyf3f9zO1J7Dz3lh7gqgyU1d+oaJr8oSY/qBIlsC49Eo0yj8Ox6oNSURg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="script.js"></script>
    <style>
        .checkbox-label {
            display: inline-block;
            margin-bottom: 5px;
        }

        .education-name {
            display: inline-block;
            margin-left: 10px; /* Adjust as needed */
            vertical-align: middle;
        }

        .checkbox-container {
            margin-bottom: 20px; /* Adjust as needed */
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
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .error-message {
        color: red;
        font-size: 15px;
        margin-bottom: 5px;
        }

        button:hover {
            background-color: #45a049;
        }

        #label1,#label2,#label3,#label4{
            display: flex;
        }
        #label0{
            margin-bottom: 17px;
        }
        .dropdown-menu {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 300px; 
        }
    </style>
</head>

<body>

<?php

$firstNameErr = $lastNameErr = $emailErr = $passwordErr = $confirmPasswordErr = $genderErr = $hobbiesErr = $phoneNumberErr = "";
$firstName = $lastName = $email = $password = $confirmPassword = $gender = $phoneNumber = "";
$hobbies = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstName"])) {
        $firstNameErr = "First Name is required";
    } else {
        $firstName = test_input($_POST["firstName"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
            $firstNameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["lastName"])) {
        $lastNameErr = "Last Name is required";
    } else {
        $lastName = test_input($_POST["lastName"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $lastName)) {
            $lastNameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters long";
        }
    }

    if (empty($_POST["confirmPassword"])) {
        $confirmPasswordErr = "Confirm Password is required";
    } else {
        $confirmPassword = test_input($_POST["confirmPassword"]);
        if ($confirmPassword !== $password) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    if (empty($_POST["hobbies"]) || count($_POST["hobbies"]) < 2) {
        $hobbiesErr = "Please select at least two hobbies";
    } else {
        $hobbies = $_POST["hobbies"];
    }

    if (empty($_POST["phoneNumber"])) {
        $phoneNumberErr = "Phone Number is required";
    } else {
        $phoneNumber = test_input($_POST["phoneNumber"]);
        if (!preg_match("/^[0-9]{10}$/", $phoneNumber)) {
            $phoneNumberErr = "Invalid phone number format";
        }
    }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$query = "SELECT * FROM hobby WHERE status = 'active'";
$result = mysqli_query($connection, $query);


if ($result) {
    $active_hobbies = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $active_hobbies[] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }
}

?>

<div id="response"></div>

<form id="myForm" name="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" onsubmit="return validateForm()">

    <label for="firstName" id="firstNamelabel">First Name:</label>
    <input type="text" id="firstName" name="firstName" oninput="validateFirstName()">
    <div id="firstNameError" class="error-message"><?php echo $firstNameErr; ?></div>

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" oninput="validateLastName()">
    <div id="lastNameError" class="error-message"><?php echo $lastNameErr; ?></div>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" oninput="validateEmail()">
    <div id="emailError" class="error-message"><?php echo $emailErr; ?></div>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" oninput="validatePassword()">
    <div id="passwordError" class="error-message"><?php echo $passwordErr; ?></div>

    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" id="confirmPassword" name="confirmPassword" oninput="validateConfirmPassword()">
    <div id="confirmPasswordError" class="error-message"><?php echo $confirmPasswordErr; ?></div>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" onchange="validateGender()">
        <option value="" disabled selected>Select your gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>
    <div id="genderError" class="error-message"><?php echo $genderErr; ?></div>

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
    <input type="tel" id="phoneNumber" name="phoneNumber" oninput="validatePhoneNumber()">
    <div id="phoneNumberError" class="error-message"><?php echo $phoneNumberErr; ?></div>

    <label for="profilePhoto">Profile Photo:</label>
    <input type="file" id="profilePhoto" name="profilePhoto">

    <?php
        $query_edu = "SELECT * FROM education_qualifications WHERE status = 'enable'";
        $result_edu = mysqli_query($connection, $query_edu);

        if (!$result_edu) {
            die("Error fetching data: " . mysqli_error($connection));
        }

        $data = array();
        
        while ($row = mysqli_fetch_assoc($result_edu)) {
            $data[] = array(
                'id' => $row['id'],
                'education' => $row['education'],
                'parentId' => $row['parentId']
            );
        }

        function buildTree(array $data, $parentId = 0) {
            $tree = array();
            foreach ($data as $row) {
                if ($row['parentId'] == $parentId) {
                    $row['children'] = buildTree($data, $row['id']);
                    $tree[] = $row;
                }
            }
            return $tree;
        }

        $tree = buildTree($data);

        function buildDropdown($tree, $depth = 0) {
            $indent = str_repeat('&nbsp;', $depth * 4);
            $html = '';
            foreach ($tree as $node) {
                $html .= '<option value="' . $node['id'] . '">' . $indent . $node['education'] . '</option>';

                if (!empty($node['children'])) {
                    $html .= buildDropdown($node['children'], $depth + 1);
                }
            }
            return $html;
        }

    $html = '<select class="dropdown-menu" name="selected_education[]" multiple>'; 
    $html .= '<option value="">Select</option>';
    $html .= buildDropdown($tree);
    $html .= '</select>';

    echo $html;
    ?>

    <button type="submit" id="submitbutton">Submit</button>
</form>



<script>
    // $(document).ready(function() {
    //     $('#myForm').submit(function(event) {
    //         event.preventDefault();
    //         var formData = $(this).serialize();

    //         $.ajax({
    //             type: 'POST',
    //             url: 'post_form.php', 
    //             data: formData, 
    //             success: function(response) {
    //                 $('#response').html(response);
    //             }
    //         });
    //     });
    // });

    // document.addEventListener("DOMContentLoaded", function() {
    // var myForm = document.getElementById('myForm');
    // myForm.addEventListener("submit", function(event) {
    //     event.preventDefault();

    //         var formData = new FormData(this);
    //         var xhrr = new XMLHttpRequest();

    //         xhrr.open("POST", "post_form.php");
    //         xhrr.onreadystatechange = function() {
    //             if (xhrr.readyState === 4) {
    //                 if (xhrr.status === 200) {
    //                     document.getElementById('response').innerHTML = xhrr.responseText;
    //                 } else {
    //                     console.error('Error:', xhrr.status);
    //                 }
    //             }
    //         };
    //         xhrr.send(formData);
    //     });
    // });

    document.addEventListener("DOMContentLoaded", function() {
    var myForm = document.getElementById('myForm');
    myForm.addEventListener("submit", function(event) {
        event.preventDefault();

        var formData = new FormData(this);
        var params = new URLSearchParams();

        formData.forEach(function(value, key) {
            params.append(key, value);
        });

        var xhr = new XMLHttpRequest();

        xhr.open("GET", "get_form.php?" + params.toString());
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    document.getElementById('response').innerHTML = xhr.responseText;
                } else {
                    console.error('Error:', xhr.status);
                }
            }
        };
        xhr.send();
        });
    });


    // $(document).ready(function() {
    // $('#myForm').submit(function(event) {
    //     event.preventDefault(); 

    //     var formData = $(this).serialize();

    //     $.ajax({
    //         url: 'get_form.php',
    //         type: 'GET', 
    //         data: formData,
    //         success: function(response) {
    //             $('#response').html(response);
    //         }
    //         });
    //     });
    // });

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
        if (password === '') {
            passwordError.textContent = 'Field cannot be empty';
        }
        else if (password.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters long';
        } else {
            passwordError.textContent = '';
        }
    }

    function validateConfirmPassword() {
        const confirmPassword = document.getElementById('confirmPassword').value.trim();
        const password = document.getElementById('password').value.trim();
        const confirmPasswordError = document.getElementById('confirmPasswordError');

        if (confirmPassword !== password) {
            confirmPasswordError.textContent = 'Passwords do not match';
        } else {
            confirmPasswordError.textContent = '';
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
        const password = document.getElementById('password').value.trim();
        const passwordError = document.getElementById('passwordError');
        if (password === '') {
            passwordError.textContent = 'password cannot be blank.';
        }
        else if (password.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters long.';
            isValid = false;
        } else {
            passwordError.textContent = '';
        }

        // Validate Confirm Password
        const confirmPassword = document.getElementById('confirmPassword').value.trim();
        const confirmPasswordError = document.getElementById('confirmPasswordError');

        if (confirmPassword !== password) {
            confirmPasswordError.textContent = 'Passwords do not match.';
            isValid = false;
        } else {
            confirmPasswordError.textContent = '';
        }

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

<?php
include "footer.php";
?>

</body>
</html>

<?php
    // error_reporting(0);

    // $firstName = $_POST['firstName'];
    // $lastName = $_POST['lastName'];
    // $password = md5($_POST['password']);
    // $gender = $_POST['gender'];
    // $hobbies = implode(', ', $_POST['hobbies']);
    // $education = serialize($_POST['selected_education']);
    // $email = $_POST['email'];
    // $phoneNumber = $_POST['phoneNumber'];
    // $profilePhoto = $_POST['profilePhoto'];


    // if ($firstName != "" && $lastName != "" && $password != "" && $gender != "" && $hobbies != "" && $email != "") {

    //     $checkQuery = "SELECT * FROM FORM WHERE email = '$email'";
    //     $checkResult = mysqli_query($connection, $checkQuery);

    //     if (mysqli_num_rows($checkResult) > 0) {
    //         echo "Email already exists in the database";
    //     } else {
    //         $query = "INSERT INTO FORM (firstname, lastname, password, gender, hobbies, email) VALUES ('$firstName', '$lastName', '$password', '$gender', '$hobbies', '$email')";

    //         $query = "INSERT INTO FORM (firstname, lastname, password, gender, hobbies, email,phone, createdAt, updateDate,profile,education)
    //           VALUES ('$firstName', '$lastName', '$password', '$gender', '$hobbies', '$email','$phoneNumber', NOW(), NOW(),'$profilePhoto','$education')";

    //         $data = mysqli_query($connection, $query);

    //         if ($data) {
    //             echo "New record created successfully";
    //         } else {
    //             echo "Error: " . $query . "<br>" . $connection->error;
    //         }
    //     }
    // } else {
    //     echo "Empty fields. Please fill in all the required information.";
    // }

?>

