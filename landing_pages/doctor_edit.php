<?php 
//    include("php/config.php");
//    if(!isset($_SESSION['valid'])){
//     header("Location: index.php");
//    }
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Change Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="doctor.php"> Manipal Hospitals</a></p>
        </div>

        <div class="right-links">
            <a href="../php/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php 
               if(isset($_POST['submit'])){
                // $username = $_POST['username'];
                // $email = $_POST['email'];
                $age = $_POST['age'];
                $phone = $_POST['phone'];
                $gender = $_POST['gender'];
                $speciality = $_POST['speciality'];
                $charges = $_POST['charges'];
                $room_no = $_POST['room_no'];

                // $id = $_SESSION['id'];
                $username = $_SESSION['Username'];

                $edit_query = mysqli_query($conn,"UPDATE users SET age='$age',phone='$phone',gender='$gender' WHERE email='$username' ") or die("error occurred");
                $edit_doc_table = mysqli_query($conn,"UPDATE doctor SET speciality='$speciality', charges = '$charges',room_no = '$room_no' WHERE username='$username'");

                if($edit_query){
                    echo "<div class='message'>
                    <p>Profile Updated!</p>
                </div> <br>";
                echo "<a href='doctor.php'><button class='btn'>Go Home</button>";
                }
               }else{

                $username = $_SESSION['Username'];
                $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$username' ");

                while($result = mysqli_fetch_assoc($query)){
                    $res_phone = $result['phone'];
                    $res_gender = $result['gender'];
                    $res_Age = $result['age'];
                }
                $query_doc = mysqli_query($conn,"SELECT * FROM doctor WHERE username='$username' ");

                while($result = mysqli_fetch_assoc($query_doc)){
                    $res_speciality = $result['speciality'];
                    $res_charges = $result['charges'];
                    $res_room_no = $result['room_no'];
                }

            ?>
            <header>Change Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="gender">Gender</label>
                    <input type="text" name="gender" id="gender" value="<?php echo $res_gender; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" value="<?php echo $res_phone; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="speciality">Speciality</label>
                    <input type="text" name="speciality" id="speciality" value="<?php echo $res_speciality; ?>" autocomplete="off" required>
                </div>
                
                <div class="field input">
                    <label for="charges">Charges</label>
                    <input type="text" name="charges" id="charges" value="<?php echo $res_charges; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="room_no">Room Number</label>
                    <input type="text" name="room_no" id="room_no" value="<?php echo $res_room_no; ?>" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Update" required>
                </div>
                
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>