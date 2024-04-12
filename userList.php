<?php
include "header.php";
// include "session.php";

// if(!isset($_SESSION['user'])) {
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

$limit = 3; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .data-table {
            top: 7%;
            width: 87%;
            margin-left: 13%;
            margin-top: 30px;
            border-collapse: collapse;
            border: 3px solid #ddd;
            margin-bottom: 20px;
        }

        .data-table th, .data-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .data-table th {
            background-color: #f2f2f2;
        }

        .data-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .data-table tr:hover {
            background-color: #ddd;
        }
        .edit{
            background: green;
            border:0;
            outline:none;
            color:white;
            padding: 10px;
            border-radius:10px;
            width: 70px;
            cursor: pointer;
        }
        .delete{
            background: red;
            border:0;
            outline:none;
            color:white;
            padding: 10px;
            border-radius:10px;
            width: 70px;
            cursor: pointer;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            padding: 10px 15px;
            margin: 0 5px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: black;
            border-radius:5px;
            margin-bottom: 20px;
        }
        .pagination a:hover {
            border: 1px solid #ddd;
            background: #ddd;
            color: white;
            font-weight: bold;
        }
        
        .pagination a.active {
            background-color: #f2f2f2;
        }
        img{
            width: 50px;
            height: 50px;
            border-radius:50%;
        }

    </style>
    <script>
    function deleteRecord(id) {
    if (confirm('Are you sure you want to delete the record?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    document.getElementById('response').innerHTML = xhr.responseText;
                    // window.location.href = 'index.php';
                    location.reload();
                } else {
                    console.error('Error:', xhr.status);
                }
            }
        };
        xhr.send('id=' + id);
    }
    }
    </script>

</head>
<body>

<?php
error_reporting(0);

$query = "SELECT *, DATE_FORMAT(createdAt, '%d-%M-%Y %H:%i:%s') AS created_at_formatted, DATE_FORMAT(updateDate, '%d-%M-%Y %H:%i:%s') AS updated_at_formatted FROM FORM LIMIT $start, $limit";

$data = mysqli_query($connection, $query);
$total = mysqli_num_rows($data);


if ($total != 0) {
?>
<div id="response"></div>
    <table border="1" class="data-table">
        <tr>
            <th>Id</th>
            <th>Profile</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Hobbies</th>
            <th>Email</th>
            <th>Phone No</th>
            <th>Education</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Operations</th>
        </tr>

<?php
    while ($result = mysqli_fetch_assoc($data)) {

        $education_ids = unserialize($result['education']);
        $education_names = array();

        foreach ($education_ids as $edu_id) {
            $query_edu = "SELECT education FROM education_qualifications WHERE id = '$edu_id'";
            $result_edu = mysqli_query($connection, $query_edu);

            if ($result_edu && mysqli_num_rows($result_edu) > 0) {
                $row_edu = mysqli_fetch_assoc($result_edu);
                $education_names[] = $row_edu['education'];
            }
        }

        if (count($education_names) > 1) {
            $education_str = implode(', ', $education_names);
        } else {
            $education_str = !empty($education_names) ? $education_names[0] : '';
        }


        $hobbies_ids = explode(',', $result['hobbies']);
        $hobbies_names = array();

        foreach ($hobbies_ids as $h_id) {
            $query_edu = "SELECT name FROM hobby WHERE id = '$h_id'";
            $result_edu = mysqli_query($connection, $query_edu);

            if ($result_edu && mysqli_num_rows($result_edu) > 0) {
                $row_edu = mysqli_fetch_assoc($result_edu);
                $hobbies_names[] = $row_edu['name'];
            }
        }

        if (count($hobbies_names) > 1) {
            $hobbies_str = implode(', ', $hobbies_names);
        } else {
            $hobbies_str = !empty($hobbies_names) ? $hobbies_names[0] : '';
        }


        echo "
        <tr>
            <td>" . $result['id'] . "</td>
            <td>
                <img src='http://localhost/PHP/images/" . $result['profile'] . "'>
            </td>
            <td>" . $result['firstname'] . "</td>
            <td>" . $result['lastname'] . "</td>
            <td>" . $result['gender'] . "</td>
            <td>" . $hobbies_str . "</td>
            <td>" . $result['email'] . "</td>
            <td>" . $result['phone'] . "</td>
            <td>" . $education_str . "</td>
            <td>" . $result['created_at_formatted'] . "</td>
            <td>" . $result['updated_at_formatted'] . "</td>
            <td>
            <a href='update.php?id=" . $result['id'] . "'><input type='submit' value='Edit' class='edit'/></a>
            <button onclick='deleteRecord(".$result['id'].")'>Delete</button>
            </td>
        </tr>
        ";
    }
}
?>

</table>

<div class="pagination">
    <?php

    $query = "SELECT COUNT(*) AS total FROM FORM";
    $result = mysqli_query($connection, $query);

    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];
    $total_pages = ceil($total_records / $limit);

    if ($page > 1) {
        echo "<a href='?page=1'>First</a>";
        $prev_page = $page - 1;
        echo "<a href='?page=$prev_page'>Previous</a>";
    }

    for ($i = max(1, $page - 5); $i <= min($page + 5, $total_pages); $i++) {
        echo "<a href='?page=" . $i . "' " . (($i == $page) ? "class='active'" : "") . ">" . $i . "</a>";
    }

    if ($page < $total_pages) {
        $next_page = $page + 1;
        echo "<a href='?page=$next_page'>Next</a>";
        echo "<a href='?page=$total_pages'>Last</a>";
    }
    ?>
</div>

<?php
    $education_ids = array($result['education']);
    $education_names = array();

    foreach ($education_ids as $id) {
        $query = "SELECT education FROM education_qualifications WHERE id = '$id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $education_name = $row['education'];
            $education_names[] = $education_name;
        } else {
            die("Error fetching education name: " . mysqli_error($connection));
        }
    }

?>



<?php
include "footer.php";
?>

</body>
</html>

