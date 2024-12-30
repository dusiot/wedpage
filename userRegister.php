<?php
$con = mysqli_connect("localhost", "root", "", "projectevent") or die ("Connection Error");

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO usertable VALUES (null, '$username', '$password', '$email')";

if (mysqli_query($con, $sql)) {
    echo "Data successfully inserted!"; // Replace with javascript so it appears at landing page
    header("Location:user_login.html");
} else {
    echo "Error inserting data.";
}
?>