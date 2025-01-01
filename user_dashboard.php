<?php
// Start the session
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['userid'])) {
    header("Location: user_login.html");
    exit();
}

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "projectevent") or die("Unable to connect to server: " . mysqli_connect_error());

// Fetch user details from the database
$username = $_SESSION['userid'];
$sql = "SELECT ID, Username, Email FROM usertable WHERE Username = '$username'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $id = $user_data['ID'];
    $email = $user_data['Email'];
} else {
    echo "User not found.";
    exit();
}

// Handle email change
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_email'])) {
    $new_email = mysqli_real_escape_string($con, $_POST['new_email']);

    // Validate the new email
    if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        // Update email in the database
        $update_sql = "UPDATE usertable SET Email = '$new_email' WHERE ID = '$id'";
        if (mysqli_query($con, $update_sql)) {
            $email = $new_email; // Update the email in the session
            $message = "Email updated successfully."; // Success message
            $alert_type = 'success'; // Notification type (success)
        } else {
            $message = "Error updating email: " . mysqli_error($con);
            $alert_type = 'error'; // Notification type (error)
        }
    } else {
        $message = "Invalid email format.";
        $alert_type = 'error'; // Notification type (error)
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="webpagedesign.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="logo">
            <img src="uni10.png" alt="Logo">
        </div>
        <ul>
            <li><a href="register_event.php">Events</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- User Dashboard Section -->
    <section id="user-dashboard">
        <h1>Welcome, <?php echo $username; ?></h1>
        <p>Here is your dashboard where you can manage your profile and event registrations.</p>

        <!-- User Profile -->
        <div class="profile-section">
            <h2>Your Profile</h2>
            <ul>
                <li><strong>User ID:</strong> <?php echo $id; ?></li>
                <li><strong>Username:</strong> <?php echo $username; ?></li>
                <li><strong>Email:</strong> <?php echo $email; ?></li>
                <li><strong>Registered Events:</strong> 
                    <?php
                    // Fetch registered events for the user
                    $event_sql = "SELECT Event_Name FROM participant_table WHERE Username = '$username'";
                    $event_result = mysqli_query($con, $event_sql);
                    if (mysqli_num_rows($event_result) > 0) {
                        while ($event_row = mysqli_fetch_assoc($event_result)) {
                            echo $event_row['Event_Name'] . ", ";
                        }
                    } else {
                        echo "No events registered.";
                    }
                    ?>
                </li>
            </ul>
        </div>

        <!-- Email Change Section -->
        <div class="email-change-section">
            <h2>Change Your Email</h2>
            <form action="" method="POST">
                <label for="new_email">New Email:</label>
                <input type="email" name="new_email" id="new_email" value="<?php echo $email; ?>" required>
                <button type="submit">Change Email</button>
            </form>
        </div>

        <!-- Event Registration Section -->
        <div class="event-section">
            <h2>Register for Events</h2>
            <form action="register_event.php" method="POST">
                Select Event:
                <select name="event" id="event" required>
                    <option value="">-- Choose an event --</option>
                    <?php
                    // Fetch all available events from the database
                    $all_events_sql = "SELECT * FROM event_table";
                    $all_events_result = mysqli_query($con, $all_events_sql);
                    while ($event_row = mysqli_fetch_assoc($all_events_result)) {
                        echo "<option value='" . $event_row['EventID'] . "'>" . $event_row['Name'] . "</option>";
                    }
                    ?>
                </select>
                <button type="submit">Register</button>
            </form>
        </div>

        <!-- List of Registered Events -->
        <div class="registered-events">
            <h2>Your Registered Events</h2>
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch registered events for the user
                    $registered_sql = "SELECT Event_Name, Event_ID FROM participant_table WHERE Username = '$username'";
                    $registered_result = mysqli_query($con, $registered_sql);

                    if (mysqli_num_rows($registered_result) > 0) {
                        while ($registered_row = mysqli_fetch_assoc($registered_result)) {
                            // Fetch event date from event_table
                            $event_id = $registered_row['Event_ID'];
                            $event_date_sql = "SELECT Date FROM event_table WHERE EventID = '$event_id'";
                            $event_date_result = mysqli_query($con, $event_date_sql);
                            $event_date_row = mysqli_fetch_assoc($event_date_result);
                            $event_date = isset($event_date_row['Date']) ? $event_date_row['Date'] : 'Date not found';

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($registered_row['Event_Name']) . "</td>";
                            echo "<td>" . htmlspecialchars($event_date) . "</td>";
                            echo "<td><a href='cancel_registration.php?event_id=" . htmlspecialchars($registered_row['Event_ID']) . "' onclick='return confirm(\"Are you sure you want to cancel this event?\");'>Cancel</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No registered events found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <script>
        // Show a JavaScript alert when a message is set
        <?php if (isset($message)): ?>
            alert("<?php echo $message; ?>");
        <?php endif; ?>
    </script>
</body>
</html>
