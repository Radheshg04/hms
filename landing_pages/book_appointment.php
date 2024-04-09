<?php
session_start();

$userName = $_SESSION['Username'];
$name = $_SESSION['name'];
$server = "localhost";
$usernameDB = "root";
$password = "";
$dbname = "hospital_management";

$conn = new mysqli($server, $usernameDB, $password, $dbname);

if ($conn->connect_error) {
    die("Connection to database failed due to " . $conn->connect_error);
}

$doctorQuery = "SELECT * FROM doctor INNER JOIN users on doctor.username = users.email";
$doctorResult = $conn->query($doctorQuery);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedDoctor = $_POST['doctor'];
    $selectedDate = $_POST['date'];
    $selectedTime = $_POST['time'];

    $availabilityQuery = "SELECT * FROM appointments WHERE appointed_to=? AND appointed_date=? AND appointed_time=?";
    $stmt = $conn->prepare($availabilityQuery);
    $stmt->bind_param("sss", $selectedDoctor, $selectedDate, $selectedTime);
    $stmt->execute();
    $availabilityResult = $stmt->get_result();

    if ($availabilityResult->num_rows == 0) {
        $insertQuery = "INSERT INTO appointments (patient_id, appointed_to, appointed_date, appointed_time) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $userName, $selectedDoctor, $selectedDate, $selectedTime);
        
        if ($stmt->execute()) {
            echo "<script>alert('Appointment booked successfully!');</script>";
        } else {
            echo "<script>alert('Error booking appointment. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('The selected time slot is not available. Please choose a different time.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="user.php">Manipal Hospitals</a> </p>
        </div>
        <div class="right-links">
            <a href="edit.php">Edit Profile</a>
            <a href="../php/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>

<main>
    <div class="main-box top">
        <div class="top">
                <div class="box">
                    <p>Welcome <b><?php echo $name; ?></b></p>
                </div>
                <div class="box">
                    <p>Logged in as <b><?php echo $userName; ?></b>.</p>
                </div>
            </div>
            <div class="bottom"></div>
        </div>
    </main>

    <!-- // booking the appointment -->
    <div class="form">
        <form method="post">
            <div>
                <label for="doctor">Select Doctor:</label>
                <select name="doctor" id="doctor" required>
                    <?php
                    while ($row = $doctorResult->fetch_assoc()) {
                        echo "<option value='" . $row['username'] . "'>" . $row['name'] . " (" . $row['speciality'] . ")</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="date">Select Date:</label>
                <input type="date" name="date" id="date" required>
            </div>

            <div>
                <label for="time">Select Time:</label>
                <input type="time" name="time" id="time" required>
            </div>

            <div>
                <input type="submit" name="book" value="Book Appointment">
            </div>
        </form>
    </div>
</body>
</html>
