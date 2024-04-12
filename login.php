
<?php
include "header.php";

$emailErr = $passwordErr = "";
$email = $password = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    // if (empty($emailErr) && empty($passwordErr)) {
        $email = $_POST["email"];
        $password = md5($_POST['password']);

        $query = "SELECT * FROM FORM WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($connection, $query);
        $user_data = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) > 0) {
            // $user_json = json_encode($user_data);
            // setcookie('user_data', $user_json, time() + 3600, '/');

            $encoded_id = base64_encode($user_data['id']);
            setcookie('id', $encoded_id, time() + 3600, '/'); 


            $_SESSION['user'] = $user_data;
            $_SESSION['id'] = $encoded_id;
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    // }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<style>
    #headerform {
    background-color: #333;
    padding: 20px;
    margin-left: 10px;
    color:white;
    margin-top: 20px;
    width: 100px;
}
</style>

<form name="myForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" oninput="validateEmail()">
    <div id="emailError" class="error-message"><?php echo $emailErr; ?></div>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" oninput="validatePassword()">
    <div id="passwordError" class="error-message"><?php echo $passwordErr; ?></div>

    <button type="submit" id="submitbutton">Submit</button>
</form>

<?php
include "footer.php";
?>
