<?php
session_start();

$exists = false;
$exec = false;
$admin = false;
$normUser = false;
$doctor = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server = "localhost";
    $username = "root";
    $pass = "";
    $dbname = "hospital_management";
    
    $conn = new mysqli($server, $username, $pass, $dbname);
    
    if ($conn->connect_error) {
        die("Connection to database failed due to " . $conn->connect_error);
    }

    $user = $_POST['Usrname'];
    $password = $_POST['Password'];
    
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $password);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $exists = true;
        $exec = true;
        
        $sqlRedirectAdmin = "SELECT * FROM roles WHERE username = ? AND role = 'admin'";
        $stmtAdmin = $conn->prepare($sqlRedirectAdmin);
        $stmtAdmin->bind_param("s", $user);
        $stmtAdmin->execute();
        
        $resultRedirectAdmin = $stmtAdmin->get_result();
        
        if ($resultRedirectAdmin->num_rows > 0) {
            $admin = true;
        }
        
        $sqlRedirectNormUser = "SELECT * FROM roles WHERE username = ? AND role = 'user'";
        $stmtNormUser = $conn->prepare($sqlRedirectNormUser);
        $stmtNormUser->bind_param("s", $user);
        $stmtNormUser->execute();

        $resultRedirectNormUser = $stmtNormUser->get_result();

        if ($resultRedirectNormUser->num_rows > 0) {
            $normUser = true;
        }

        $sqlDoc = "SELECT * FROM roles WHERE username = ? AND role = 'doctor'";
        $stmtDoc = $conn->prepare($sqlDoc);
        $stmtDoc->bind_param("s", $user);
        $stmtDoc->execute();
    
        $resultDoc = $stmtDoc->get_result();
    
        if ($resultDoc->num_rows > 0) {
            $doctor = true;

        }
    }
    else {
            $exec = true;
            $exists = false;
        }
        
    $_SESSION['Username'] = $user;
    
    $stmt->close();
    // $stmtAdmin->close();
    // $stmtNormUser->close();
    $conn->close();
} 


if ($exists && $exec) {
    if ($admin) {
        header("Location: ../landing_pages/admin.php");
        exit();
    }
    else if($doctor){
        header("Location: ../landing_pages/doctor.php");
        exit();
    }
     elseif ($normUser) {
        header("Location: ../landing_pages/user.php");
        exit();
    }
}
// elseif (!$exists && $exec) {
//     echo "<h2 style='text-align: center'>User not Found!<br> Please register </h2>";
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="login_page_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="login_page.php" method="post">
            <h1>Login</h1>
            <?php
            if ($exists && $exec) {
                // echo "Test";
                if($admin){
                    header("Location: ../landing_pages/admin.php");
                    exit();
                }
                elseif($normUser){
                    header("Location: ../landing_pages/user.php");
                    exit();
                }
                elseif($doctor){
                    header("Location: ../landing_pages/doctor.php");
                    exit();
                }
                // echo "<h2 style='text-align: center;'>User Exists!</h2>";
            }
            else if(!$exists&&$exec){
                echo"<h2 style='text-align: center'>User not Found!<br> Please register </h2>";
            }
            ?>
            <div class="input-box">
                <input type="text" name="Usrname" id="Usrname" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="Password" id="Password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">Remember Me</label>
                <a href="#">Forgot Password</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>Don't have an account? 
                <a href="../index.php">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
