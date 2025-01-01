<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "projectevent") or die("Unable to connect to server".mysqli_connect_error());

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "Select * from usertable where Username='$username'";
$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result)== 0)
    echo "Username does not exist";

else
{
    $data=mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($data['Password']==$password)
    {
            $_SESSION["userid"]= $username;
            header("Location:user_dashboard.php");
            exit();
    }
    else
        echo "Password is wrong";
}
?>
