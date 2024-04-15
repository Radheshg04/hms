<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>success</title>
    <link rel="stylesheet" href="success.css">
    <?php
    session_start();
    
    $userName=$_SESSION['Username'];
    
    $servername="localhost";
    $username= "root";
    $password= "";
    $dbname= "hospital_management";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    $selectedDoctor=$_SESSION['selectedDoctor'];
    $selectedDate=$_SESSION['selectedDate'];
    $selectedTime=$_SESSION['selectedTime'];

    // echo "$selectedDoctor";

    $insertQuery = "INSERT INTO appointments (patient_id, appointed_to, appointed_date, appointed_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $userName, $selectedDoctor, $selectedDate, $selectedTime);
    
    if ($stmt->execute()) {
        echo "<script>alert('Appointment booked successfully!');</script>";
    } else {
        echo "<script>alert('Error booking appointment. Please try again.');</script>";
    }
    ?>
</head>
<body>
    <div class="wrapper">
        <div class="box">
            <h1>Payment Success!</h1>
            <p>Your appointment has been booked successfully!</p>
            <a href="../landing_pages/user.php"><button type="submit">Go back</button></a>
        </div>
    </div>
</body>
</html>