  <!--ADMIN-->  

<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "projectevent") or die("Unable to connect to server".mysqli_connect_error());

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql_delete = "DELETE FROM usertable WHERE ID = ?";
    $stmt = $con->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        // Set a session variable for success
        $_SESSION['delete_message'] = 'Row deleted successfully!';
    } else {
        // Set a session variable for error
        $_SESSION['delete_message'] = 'Error deleting row!';
    }
    $stmt->close();

    // Redirect to the same page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// SQL query to retrieve data
$sql = "SELECT * FROM usertable";
$result = mysqli_query($con,$sql);
?>

    <!DOCTYPE html>
    <html>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="webpagedesign.css">
        <body>
            
            <!-- Display Alert if Session Message is Set -->
        <?php if (isset($_SESSION['delete_message'])): ?>
            <script>alert('<?php echo $_SESSION['delete_message']; ?>');</script>
            <?php unset($_SESSION['delete_message']); // Clear session after displaying message ?>
        <?php endif; ?>

            <nav>
                <div class="logo">
                    <img src="uni10.png" alt="Logo">
                </div>
                <ul>
                    <li><a href="home_page.html">Home</a></li>
                </ul>
            </nav>
    <!-- View Participants Page -->
    <section id="view-participants">
        <h2>Registered Participants</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th> 
                    
                </tr>
            </thead>
            <tbody>
            <?php
            //TAMBAH GAMBAR TONG SAMPAH TEPI COLUMN EMAIL
            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Output each row of data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Password']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                    echo "<td><a class='delete-button' href='?delete_id=" . $row['ID'] . "' onclick='return confirm(\"Are you sure you want to delete this row?\");'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No participants found</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </section>
    <footer>
        <p>&copy; 2024 Event Management System by group 15 2B_01</p>
    </footer>
</body>
></html>

<?php
// Close the database connection
$con->close();
?>