<?php
$con = mysqli_connect("localhost", "root", "", "projectevent") or die ("Connection Error");

// Check if all fields are filled
if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
    echo "<script type='text/javascript'>
            alert('All fields are required!');
            window.history.back(); // Redirect back to the previous page
          </script>";
    exit();
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script type='text/javascript'>
            alert('Invalid email format!');
            window.history.back(); // Redirect back to the previous page
          </script>";
    exit();
}

// Check if password and confirm password match
if ($password !== $confirm_password) {
    echo "<script type='text/javascript'>
            alert('Passwords do not match!');
            window.history.back(); // Redirect back to the previous page
          </script>";
    exit();
}

$sql = "INSERT INTO usertable VALUES (null, '$username', '$password', '$email')";

if (mysqli_query($con, $sql)) {
    echo "<script type='text/javascript'>
            alert('Data successfully inserted!');
            window.location.href = 'user_login.html'; // Redirect to login page
          </script>";
} else {
    echo "<script type='text/javascript'>
            alert('Error inserting data.');
          </script>";
}

// Close the connection
mysqli_close($con);
?>
