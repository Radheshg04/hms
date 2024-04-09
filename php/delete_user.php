<?php
if(isset($_GET['delete_email'])) {
    $delete_email = $_GET['delete_email'];
    
    $server = "localhost";
    $username = "root";
    $pass = "";
    $dbname = "hospital_management";

    $con = new mysqli($server, $username, $pass, $dbname);

    if ($con->connect_error) {
        die("Connection to database failed due to " . $con->connect_error);
    }

    $deleteQuery = "DELETE FROM `users` WHERE `users`.`email` = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param("s", $delete_email);
    
    if($stmt->execute()) {
        echo 
        "<div class='message'>
            <p>RECORD DELETED!</p>
        </div> <br>";
        echo "<a href='../landing_pages/admin.php'><button class='btn'>Go Home</button>";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletion Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
</body>
</html>
