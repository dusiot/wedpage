<?php
// Start the session
session_start();

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['userid'])) {
    header("Location: admin_login.html");
    exit();
}

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "projectevent") or die("Unable to connect to server: " . mysqli_connect_error());

// Get the search query from the URL parameter
$search_query = isset($_GET['search_query']) ? mysqli_real_escape_string($con, $_GET['search_query']) : '';

// Fetch user details from the database
$sql = "SELECT ID, Username, Email FROM usertable WHERE Username LIKE '%$search_query%'";
$result = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="webpagedesign.css">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="uni10.png" alt="Logo">
        </div>
        <ul>
            <li><a href="admin_dashboard.php">Back</a></li>
        </ul>
    </nav>

    <!-- Search Results Section -->
    <section id="search-results">
        <h2>Search Results</h2>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($user_row = mysqli_fetch_assoc($result)) {
                $user_id = $user_row['ID'];
                $username = $user_row['Username'];
                $email = $user_row['Email'];

                echo "<div class='user-info'>";
                echo "<h3>User  Details</h3>";
                echo "<p><strong>User  ID:</strong> $user_id</p>";
                echo "<p><strong>Username:</strong> $username</p>";
                echo "<p><strong>Email:</strong> $email</p>";

                // Fetch registered events for the user
                $events_sql = "SELECT Event_Name FROM participant_table WHERE Username = '$username'";
                $events_result = mysqli_query($con, $events_sql);

                if (mysqli_num_rows($events_result) > 0) {
                    echo "<h4>Registered Events:</h4>";
                    echo "<ul>";
                    while ($event_row = mysqli_fetch_assoc($events_result)) {
                        echo "<li>" . $event_row['Event_Name'] . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No events registered.</p>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No users found.</p>";
        }
        ?>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Event Management System by group 15 2B_01</p>
    </footer>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
