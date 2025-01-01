<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "projectevent") or die("Unable to connect to server: " . mysqli_connect_error());

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT ID, Username, Password FROM usertable WHERE Username = '$username'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Username does not exist";
} else {
    $data = mysqli_fetch_assoc($result);
    if ($data['Password'] == $password) {
        $_SESSION['userid'] = $data['ID']; // Set session to user ID
        echo "User  ID stored in session: " . $_SESSION['userid']; // Debugging
        header("Location: user_dashboard.php");
        exit();
    } else {
        echo "Password is wrong";
    }
}
?>
