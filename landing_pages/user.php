<?php
    session_start();
    $userName = $_SESSION['Username'];
    $server = "localhost";
    $username = "root";
    $pass = "";
    $dbname = "hospital_management";
    
    $conn = new mysqli($server, $username, $pass, $dbname);
    
    if ($conn->connect_error) {
        die("Connection to database failed due to " . $conn->connect_error);
    }

    // Setup id as session variable
    $sql = "SELECT * FROM users where email='$userName'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $name = $_SESSION['name'] = $row['name'];
    $_SESSION['name'] = $name;
    

    // Logic for appointment
    $sqlAppointment = "SELECT * FROM appointments INNER JOIN users ON users.email=appointments.appointed_to where patient_id='$userName'";
    $resultAppointment = $conn->query($sqlAppointment);
    $appointments = $resultAppointment->fetch_all(MYSQLI_ASSOC);
    $display = count($appointments);

    // Cancellation logic
    if(isset($cancelDoctor)){
        echo 'TEST';
        $cancelDoctor = $_POST['cancel_doc'];
        $cancelDate = $_POST['cancel_date'];
        $cancelTime = $_POST['cancel_time'];

        $sqlCancellation = "SELECT * FROM appointments WHERE patient_id='$userName' AND appointed_to='$cancelDoctor' AND appointed_time='$cancelTime' AND appointed_date='$cancelDate'";
        if($conn->query($sqlCancellation)){
            echo"<script>alert('Appointment cancelled successfully')</script>";
        }
    }
    
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="user.php">Manipal Hospitals</a> </p>
        </div>

        <div class="right-links">
            <a href="edit.php">Edit Profile</a>
            <a href="book_appointment.php">Book appointment</a>
            <a href="../php/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>
    <main>
       <div class="main-box top">
          <div class="top">
            <div class="box">
                <p>Hello <b><?php echo "$name"; ?></b></p>
            </div>
            <div class="box">
                <p>Logged in as <b><?php echo "$userName" ?></b>.</p>
            </div>
          </div>
          <div class="bottom">
            <div class="box">
                <p>You currently have <b><?php echo "$display" ?></b> appointments scheduled.</p>
            </div>
            <br>
            <div class="box">
                <h3 style="font-size: 20px;">Your Appointments:</h3><br>
                <ul style="list-style-type: none;">
                    <?php
                        foreach ($appointments as $appointment) {
                            echo "<li style='padding:10px;'><b>Doctor:</b> Dr. ".$appointment['name']. 
                            " <b>&emsp;Date: </b>" . $appointment['appointed_date'] . 
                            " <b>&emsp;Time: </b>" . $appointment['appointed_time'] . 
                            "<input type='hidden' name='cancel_doc' value=".$appointment['name'].">
                            <input type='hidden' name='cancel_time' value=".$appointment['appointed_date'].">
                            <input type='hidden' name='cancel_date' value=".$appointment['appointed_time'].">
                            <button type='submit' class='btn' id='cancel' name='cancel' style='float: right;
                            margin-top:0px; height:37px;'>Cancel Appointment</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    </main>
</body>
</html>
