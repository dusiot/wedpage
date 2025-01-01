<?php

$conn = new mysqli("localhost", "root", "", "projectevent");

//connectchek
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//search qeury
if (isset($_GET['search_query'])) {
    $search_query = $conn->real_escape_string($_GET['search_query']);


    $sql = "SELECT * FROM usertable WHERE username LIKE '%$search_query%' OR email LIKE '%$search_query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['ID'] . "</td>
                    <td>" . $row['Username'] . "</td>
                    <td>" . $row['Email'] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No users found matching the query.";
    }
} else {
    echo "Please enter a search query.";
}

//end
$conn->close();
?>
