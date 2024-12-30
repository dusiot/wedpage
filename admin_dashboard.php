   <!--ADMIN-->  

<?php
   // Start the session
   session_start();
   
   if (!isset($_SESSION['userid'])) {
    echo "Session not set. Redirecting...";
    header("Location: admin_login.html");
    exit();
} else {
    echo "Session is active. User: " . $_SESSION['userid'];
}   
?>

 <!DOCTYPE html>
 <html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="webpagedesign.css">
    <body>
      <nav>
        <div class="logo">
            <img src="uni10.png" alt="Logo">
        </div>
         <ul>
             <li><a href="home_page.html">Home</a></li>
         </ul>
     </nav>
 <!-- Admin Dashboard Page -->
 <section id="admin-dashboard">
    <h2>Admin Dashboard</h2>
   <center> 
    <a href="add_sub_event.html" class="button">Add Sub-Event/Category</a>
    <a href="view_participants.php" class="button">View Participants</a>
    <a href="search_user.html" class="button">Search Users</a>
   </center>
</section>
<footer>
    <p>&copy; 2024 Event Management System by group 15 2B_01</p>
</footer>
</body>
</html>