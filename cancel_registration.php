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

// Get the event ID from the URL parameter
$event_id = intval($_GET['event_id']);

// Get the user's username from the session
$username = $_SESSION['userid'];

// Delete the user's registration for the event
$sql = "DELETE FROM participant_table WHERE Event_ID = '$event_id' AND Username = '$username'";
if (mysqli_query($con, $sql)) {
    mysqli_close($con); // Close the connection before redirecting
    echo "<script>alert('Event registration canceled successfully!');</script>";
    header("Location: user_dashboard.php");
    exit();
} else {
    mysqli_close($con); // Close the connection before redirecting
    echo "<script>alert('Error canceling event registration.');</script>";
    header("Location: user_dashboard.php");
    exit();
}
?>
