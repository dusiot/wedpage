<?php
// Start the session
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.html");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "projectevent");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from session
$user_id = $_SESSION['user_id'];
$user_query = $conn->query("SELECT Username, Password, Email FROM Usertable WHERE ID = $user_id");

// Check if the query was successful
if (!$user_query) {
    die("Error in SQL query: " . $conn->error);
}

// Fetch user data
if ($user_query->num_rows > 0) {
    $user_data = $user_query->fetch_assoc();
} else {
    die("User not found in the database.");
}

// Get event data from the form inputs
if (!isset($_POST['event_id']) || !isset($_POST['event_name'])) {
    die("Event data is missing.");
}

$event_id = $_POST['event_id'];
$event_name = $_POST['event_name'];

// Insert user and event data into Participant_table
$stmt = $conn->prepare("INSERT INTO Participant_table (Username, Password, Email, Event_ID, Event_Name) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Error preparing SQL statement: " . $conn->error);
}

$stmt->bind_param(
    "sssis",
    $user_data['Username'],
    $user_data['Password'],
    $user_data['Email'],
    $event_id,
    $event_name
);

if ($stmt->execute()) {
    echo "You have successfully registered for the event!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
