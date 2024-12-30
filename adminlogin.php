<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "projectevent") or die("Unable to connect to server".mysqli_connect_error());

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "Select * from admintable where AdminName='$username'";
$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result)== 0)
    echo "Username does not exist";

else
{
    $data=mysqli_fetch_array($result,MYSQLI_BOTH);
    if($data[1]==$password)
    {
        session_start();

            $_SESSION["userid"]= $username;
            header("Location:admin_dashboard.php");
    }
    else
        echo "Password is wrong";
}
?>