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
    <title>Edit Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="admin.php"> Manipal Hospitals</a></p>
        </div>

        <div class="right-links">
            <a href="#"></a>
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
                $name = $_POST['name'];
                $password = $_POST['password'];

                // $id = $_SESSION['id'];
                $username = $_SESSION['Username'];

                $edit_query = mysqli_query($conn,"UPDATE users SET name='$name',age='$age',phone='$phone',gender='$gender',password='$password' WHERE email='$username' ") or die("error occurred");

                if($edit_query){
                    echo "<div class='message'>
                    <p>Profile Updated!</p>
                </div> <br>";
                echo "<a href='../landing_pages/admin.php'><button class='btn'>Go Home</button>";
                }
               }else{

                $username = $_SESSION['Username'];
                $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$username' ");

                while($result = mysqli_fetch_assoc($query)){
                    $res_phone = $result['phone'];
                    $res_gender = $result['gender'];
                    $res_Age = $result['age'];
                    $res_name = $result['name'];
                    $res_password = $result['password'];
                }
                
                ?>
            <header>Edit Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $res_name; ?>" autocomplete="off" required>
                </div>
                
                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="gender">Gender</label>
                    <input type="text" name="gender" id="gender" value="<?php echo $res_gender; ?>" autocomplete="off" required>
                </div>


                <div class="field input">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" value="<?php echo $res_phone; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" value="<?php echo $res_password; ?>" autocomplete="off" required>
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