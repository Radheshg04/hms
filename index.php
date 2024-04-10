<?php
session_start();
$userRegistered = false;
$submit = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server = "localhost";
    $username = "root";
    $pass = "";
    $dbname = "hospital_management";
    
    $conn = new mysqli($server, $username, $pass, $dbname);
    
    if ($conn->connect_error) {
        die("Connection to database failed due to " . $conn->connect_error);
    }
    
    $name = $_POST['Name'];
    $age = $_POST['Age'];
    $gender = $_POST['Gender'];
    $phone = $_POST['Phone'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    
    $_SESSION['Username'] = $email;
    
    $sqlRegisteredUserCheck = "SELECT * FROM users WHERE email=?";
    $stmtRegisteredUserCheck = $conn->prepare($sqlRegisteredUserCheck);
    $stmtRegisteredUserCheck->bind_param("s",$email);

    $stmtRegisteredUserCheck->execute();
    $resultRegisteredUserCheck = $stmtRegisteredUserCheck->get_result();
    if($resultRegisteredUserCheck->num_rows==0){
    
    $sql = "INSERT INTO users (name, age, gender, phone, email, date_of_registration, password) 
    VALUES (?, ?, ?, ?, ?, current_timestamp(), ?)";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $age, $gender, $phone, $email, $password);
    $sql_roles= "INSERT INTO roles (username, role) VALUES (?,'user')";

    $stmtroles = $conn->prepare($sql_roles);
    $stmtroles->bind_param("s",$email);
    
    if ($stmt->execute()) {
        if($stmtroles->execute()){
            $submit = true;
        }


    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $stmtroles->close();
} else {
    $userRegistered = true;
}
$stmtRegisteredUserCheck->close();
$conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Register</h1>
            <?php
        if($submit==true){
            echo "<h2 style='text-align: center;'>Account created!</h2>";
            sleep(0.25);
            echo("Redirecting...");
            header("Location: landing_pages/user.php");
            exit();
        }
        else if($userRegistered==true){
            echo "<h2 style='text-align: center;'>User already Exists!<br>Please login!</h2>";
        }
        ?>
            <div class="input-box">
                <input type="text" name="Name" id="Name" placeholder="Name" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="email" name="Email" id="Email" placeholder="Email (Username)" required>
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="input-box">
                <input type="password" name="Password" id="Password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="input-box">
                <input type="number" name="Age" id="Age" placeholder="Age" required>
                <i class="fa-solid fa-cake-candles"></i>
            </div>
            <div class="input-box">
                <input type="menu" name="Gender" id="Gender" placeholder="Gender" required>
                <i class="fa-solid fa-venus-mars"></i>
            </div>
            <div class="input-box">
                <input type="text" name="Phone" id="Phone" placeholder="Phone" required>
                <i class='bx bxs-phone-call'></i>
            </div>
            <button type="submit" class="btn">Register</button>
            <div class="register-link">
                <p>Already have an account? <a href="login_page/login_page.php">Login</a></p>
            </div>
        </form>
    </div>

    <!-- This script is for loading icons for name email age gender  -->
    <script src="https://kit.fontawesome.com/7bebefff04.js" crossorigin="anonymous"></script>
</body>
</html>
