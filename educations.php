
<?php
include "header.php";
include "session.php";

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

$query = "SELECT * FROM education_qualifications";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error fetching data: " . mysqli_error($connection));
}

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id' => $row['id'],
        'education' => $row['education'],
        'parentId' => $row['parentId'],
        'status' => $row['status'],
        'createdAt' => $row['createdAt'],
        'updatedAt' => $row['updatedAt'],
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

function buildTable($tree, $depth = 0) {
    $html = '';
    foreach ($tree as $node) {
        $indent = str_repeat('&nbsp;', $depth * 4);
        $statusColor = ($node['status'] == 'enable') ? 'green' : 'red'; 
        $createdAtFormatted = date('d-M-Y H:i:s', strtotime($node['createdAt'])); 
        $updatedAtFormatted = date('d-M-Y H:i:s', strtotime($node['updatedAt'])); 

        $html .= '<tr>';
        $html .= '<td>' . $indent . $node['education'] . '</td>';
        $html .= '<td>';
        $html .= '<a href="edit_edu.php?id=' . $node['id'] . '" class="edit-btn">Edit</a>';
        $html .= '<a href="delete_edu.php?id=' . $node['id'] . '" class="delete-btn">Delete</a>';
        $html .= '</td>';
        $html .= '<td style="color: ' . $statusColor . ';">' . $node['status'] . '</td>'; 
        $html .= '<td>' . $createdAtFormatted . '</td>';
        $html .= '<td>' . $updatedAtFormatted . '</td>';
        $html .= '</tr>';
        if (!empty($node['children'])) {
            $html .= buildTable($node['children'], $depth + 1);
        }
    }
    return $html;
}

$html = '<table>';
$html .= '<thead><tr><th>Education</th><th>Actions</th><th>Status</th><th>createdAt</th><th>updatedAt</th></tr></thead>';
$html .= '<tbody>';
$html .= buildTable($tree);
$html .= '</tbody>';
$html .= '</table>';

echo $html;

echo '<form method="POST" action="new_edu.php" id="headerform">
<button type="submit" name="delete">Add</button>
</form>';
?>

<style>
     #headerform {
        margin: 0;
        padding:0;
        width: 50px;
    }
    .edit-btn,
    .delete-btn {
        display: inline-block;
        padding: 8px 16px;
        margin-right: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
        background-color: #fff;
        font-size: 14px;
    }

    .edit-btn:hover,
    .delete-btn:hover {
        background-color: #f0f0f0;
    }

    table {
        width: 900px;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
</style>


<!-- function buildTable($tree, $depth = 0) {
    $html = '';
    foreach ($tree as $node) {
        $indent = str_repeat('&nbsp;', $depth * 4);
        $statusColor = ($node['status'] == 'enable') ? 'green' : 'red'; 
        
        $html .= '<tr>';
        $html .= '<td>' . $indent . $node['education'] . '</td>';
        $html .= '<td>';
        $html .= '<a href="edit_edu.php?id=' . $node['id'] . '" class="edit-btn">Edit</a>';
        $html .= '<a href="delete_edu.php?id=' . $node['id'] . '" class="delete-btn">Delete</a>';
        $html .= '</td>';
        $html .= '<td style="color: ' . $statusColor . ';">' . $node['status'] . '</td>'; 
        $html .= '<td>' . $createdAtFormatted . '</td>'; // Display formatted createdAt
        $html .= '<td>' . $updatedAtFormatted . '</td>'; // Display formatted updatedAt
        $html .= '</tr>';
        if (!empty($node['children'])) {
            $html .= buildTable($node['children'], $depth + 1);
        }
    }
    return $html;
} -->
