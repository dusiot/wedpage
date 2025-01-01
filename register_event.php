<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['userid'])) {
    header("Location: user_login.html");
    exit();
}

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "projectevent") or die("Unable to connect to server: " . mysqli_connect_error());

// Fetch all available events from the database
$sql = "SELECT * FROM event_table";
$result = mysqli_query($con, $sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = intval($_POST['event']);
    $user_id = $_SESSION['userid'];

    // Debug: Check if $user_id is set correctly
    if (empty($user_id)) {
        die("User ID is not set in the session.");
    }

    // Fetch user data from the database (assuming session stores username, not ID)
    $sql_user = "SELECT Username, Email FROM usertable WHERE Username = '$user_id'";
    $result_user = mysqli_query($con, $sql_user);

    // Debug: Check if the query failed
    if (!$result_user) {
        die("Query failed: " . mysqli_error($con));
    }

    // Debug: Check if the user exists
    if (mysqli_num_rows($result_user) == 0) {
        echo "User not found in the database. User ID: $user_id";
        exit();
    }

    $user_data = mysqli_fetch_assoc($result_user);

    // Fetch event data from the database
    $event_sql = "SELECT Name FROM event_table WHERE EventID = '$event_id'";
    $event_result = mysqli_query($con, $event_sql);

    // Debug: Check if the query failed
    if (!$event_result) {
        die("Query failed: " . mysqli_error($con));
    }

    // Debug: Check if the event exists
    if (mysqli_num_rows($event_result) == 0) {
        echo "<script>alert('Event not found!');</script>";
        exit();
    }

    $event_name = mysqli_fetch_assoc($event_result)['Name'];

    // Check if the user is already registered for the event
    $sql_check = "SELECT * FROM participant_table WHERE Username = '$user_data[Username]' AND Event_ID = '$event_id'";
    $check_result = mysqli_query($con, $sql_check);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('You are already registered for this event!'); window.location.href='register_event.php';</script>";
    } else {
        // Insert the registration into the database
        $sql_insert = "INSERT INTO participant_table (part_ID, Username, Email, Event_ID, Event_Name) VALUES (null, '$user_data[Username]', '$user_data[Email]', '$event_id', '$event_name')";
        if (mysqli_query($con, $sql_insert)) {
            echo "<script>alert('Successfully registered for the event!'); window.location.href='user_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error registering for the event.'); window.location.href='register_event.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for an Event</title>
    <link rel="stylesheet" href="webpagedesign.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="logo">
            <img src="uni10.png" alt="Logo">
        </div>
        <ul>
            <li><a href="user_dashboard.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Register for Event Section -->
    <section id="register-event">
        <h2>Register for an Event</h2>
        <p>Choose an event from the list below to register:</p>
        <form action="register_event.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Venue</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Dynamically populate the table with events
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Venue']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Action']) . "</td>"; // Adjusted field name
                            echo "<td><button type='submit' name='event' value='" . $row['EventID'] . "'>Register</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No events available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
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
