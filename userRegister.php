<?php
$con = mysqli_connect("localhost", "root", "", "projectevent") or die ("Connection Error");

$username = $_POST['username'];
$email = $_POST['email']; 
$password = $_POST['password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // If the email is not valid, display an error message and stop the script
    echo "Invalid email format!";
    exit;
}

$sql = "INSERT INTO usertable VALUES (null, '$username', '$password', '$email')";

if (mysqli_query($con, $sql)) {
    echo "<script type='text/javascript'>
            alert('Data successfully inserted!');
            window.location.href = 'user_login.html'; // Redirect to login page
          </script>";
} else {
    // Error: Use JavaScript to show error message
    echo "<script type='text/javascript'>
            alert('Error inserting data.');
          </script>";
}

// Close the connection
mysqli_close($con);
?>