<?php
if(isset($_GET['promote_email'])) {
    $promote_email = $_GET['promote_email'];
    
    $server = "localhost";
    $usernameDB = "root";
    $password = "";
    $dbname = "hospital_management";

    $con = new mysqli($server, $usernameDB, $password, $dbname);

    if ($con->connect_error) {
        die("Connection to database failed due to " . $con->connect_error);
    }
    $con->begin_transaction();

    $promoteQuery = "UPDATE `roles` SET `role` = 'doctor' WHERE `roles`.`username` = ?";
    $stmt1 = $con->prepare($promoteQuery);
    $stmt1->bind_param("s", $promote_email);

    if(!$stmt1->execute()) {
        echo "Error promoting user: " . $con->error;
        $con->rollback(); 
        exit();
    }

    $insertDoctorQuery = "INSERT INTO doctor (username) VALUES (?)";
    $stmt2 = $con->prepare($insertDoctorQuery);
    $stmt2->bind_param("s", $promote_email);

    if(!$stmt2->execute()) {
        echo "Error inserting into doctors table: " . $con->error;
        $con->rollback(); 
        exit();
    }

    $con->commit();
    
    echo 
    "<div class='message'>
    <p>USER PROMOTED!</p>
    </div> <br>";
    echo "<a href='../landing_pages/admin.php'><button class='btn'>Go Home</button>";

    $stmt1->close();
    $stmt2->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
</body>
</html>
