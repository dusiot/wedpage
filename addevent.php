<?php
$con = mysqli_connect("localhost", "root", "", "projectevent") or die ("Connection Error");

$ev_name = $_POST['ev_name'];
$ev_venue = $_POST['ev_venue']; 
$ev_date = $_POST['ev_date'];
$ev_action = $_POST['ev_action'];

$sql = "INSERT INTO event_table VALUES (null, '$ev_name', '$ev_venue', '$ev_date', '$ev_action')";

if (mysqli_query($con, $sql)) {
     // Success
     echo "<script type='text/javascript'>
     alert('Data successfully inserted!');
     window.location.href = 'admin_dashboard.php'; // Redirect to the admin dashboard
   </script>";
} else {
// Error
echo "<script type='text/javascript'>
     alert('Error inserting data.');
   </script>";
}

// Close the connection
mysqli_close($con);
?>