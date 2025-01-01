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
    echo "User  not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User  Dashboard</title>
    <link rel="stylesheet" href="webpagedesign.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="logo">
            <img src="uni10.png" alt="Logo">
        </div>
        <ul>
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
                <li><strong>User  ID:</strong> <?php echo $id; ?></li>
                <li><strong>Username:</strong> <?php echo $username; ?></li>
                <li><strong>Email:</strong> <?php echo $email; ?></li>
                <li><strong>Registered Events:</strong> 
                    <?php
                    // Fetch registered events for the user
                    $event_sql = "SELECT ev_name FROM event_table WHERE ID IN (SELECT EventID FROM registered_events WHERE UserID = '$id')";
                    $event_result = mysqli_query($con, $event_sql);
                    if (mysqli_num_rows($event_result) > 0) {
                        while ($event_row = mysqli_fetch_assoc($event_result)) {
                            echo $event_row['ev_name'] . ", ";
                        }
                    } else {
                        echo "No events registered.";
                    }
                    ?>
                </li>
            </ul>
        </div>

        <!-- Event Registration Section -->
        <div class="event-section">
            <h2>Register for Events</h2>
            <form action="register_event.php" method="POST">
                Select Event:
                <select name="event" id="event" required>
                    <option value="">-- Choose an event --</option>
                    <?php
                    // ni dia akan cari data dalam DB event mana yang user dah join
                    $all_events_sql = "SELECT * FROM event_table";
                    $all_events_result = mysqli_query($con, $all_events_sql);
                    while ($event_row = mysqli_fetch_assoc($all_events_result)) {
                        echo "<option value='" . $event_row['ID'] . "'>" . $event_row['ev_name'] . "</option>";
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
                    // (ambil event yang sudah didaftar untuk user pilih)
                    $registered_sql = "SELECT event_table.ev_name, event_table.ev_date, registered_events.EventID FROM event_table 
                                      INNER JOIN registered_events ON event_table.ID = registered_events.EventID 
                                      WHERE registered_events.UserID = '$id'"; //<-------function: mendapatkan semula detail event (ev_name, ev_date) dan EventID untuk event yang user telah daftar.
                    $registered_result = mysqli_query($con, $registered_sql);//<----untuk run sql query guna database punye connection($con = connection)

                   //yang if ni untuk check query bagi mana2 row event mana yang user dah dafatar
                    if (mysqli_num_rows($registered_result) > 0) {
                        // yang while ni pulak untuk dia display event yang  dh di register
                        //yang while ni jugak dia akan read semua row dalam (query/DB) punya result
                        while ($registered_row = mysqli_fetch_assoc($registered_result)) {
                            //sini dia display event name ngan date
                            echo "<tr>
                                    <td>" . $registered_row['ev_name'] . "</td>
                                    <td>" . $registered_row['ev_date'] . "</td>
                                    <td><a href='cancel_registration.php?event_id=" . $registered_row['EventID'] . "'>Cancel</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No registered events found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <footer>
  <p>&copy; 2024 Event Management System by group 15 2B_01</p>
</footer>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
