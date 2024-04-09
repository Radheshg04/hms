<?php
session_start();

$server = "localhost";
$username = "root";
$pass = "";
$dbname = "hospital_management";

$con = new mysqli($server, $username, $pass, $dbname);

if ($con->connect_error) {
    die("Connection to database failed due to " . $con->connect_error);
}

$patientQuery = "SELECT * FROM users INNER JOIN roles ON users.email = roles.username where role='user'";
$patientResult = mysqli_query($con, $patientQuery);

$doctorQuery = "SELECT * FROM users INNER JOIN roles ON users.email = roles.username INNER JOIN doctor ON users.email = doctor.username where role='doctor'";
$doctorResult = mysqli_query($con, $doctorQuery);

$userName = $_SESSION['Username'];
$sql = "SELECT * FROM users where email='$userName'";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$name = $_SESSION['name'] = $row['name'];
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="nav">
        <div class="logo">
            <p><a href="admin.php">Manipal Hospitals</a> </p>
        </div>

        <div class="right-links">

           
            <a href="edit_admin.php">Edit Profile</a>
            <a href="../php/logout.php"> <button class="btn">Log Out</button> </a>

        </div>
    </div>
    <main>

       <div class="main-box top">
          <div class="top">
            <div class="box">
                <p>Hello <b><?php
                echo "$name";
                ?></b></p>
            </div>
            <div class="box">
                <p>Logged in as <b><?php echo "$userName" ?></b>.</p>
            </div>
          </div>
    <div class="bottom">
    <div class="table">
        <table width="100%" id="usertable">
            <tr>
                <th colspan="9">
                    <h2>Patient Record</h2>
                </th>
            </tr>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Contact</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Promote to Doctor</th>
            
            <tr>
                <?php
                while ($rows = mysqli_fetch_assoc($patientResult)) {
                    ?>
                    <td>
                        <?php echo $rows['name']; ?>
                    </td>
                    <td>
                        <?php echo $rows['email']; ?>
                    </td>
                    <td>
                        <?php echo $rows['age']; ?>
                    </td>
                    <td>
                        <?php echo $rows['gender']; ?>
                    </td>
                    <td>
                        <?php echo $rows['phone']; ?>
                    </td>
                    <td>
                        <form action="../php/edit_patient.php" method="get" style="display:inline;" >
                            <input type="hidden" name="edit_email" value="<?php echo $rows['email']; ?>">
                            <input type="submit" value="Edit" class="btn">
                        </form>
                    </td>
                    <td>
                        <form action="../php/delete_user.php" method="get" style="display:inline;">
                            <input type="hidden" name="delete_email" value="<?php echo $rows['email']; ?>">
                            <input type="submit" value="Delete" class="btn" onclick="return confirm('Are you sure you want to delete this record?');">
                        </form>
                    </td>
                    <td>
                        <form action="../php/promote_user.php" method="get" style="display:inline;">
                            <input type="hidden" name="promote_email" value="<?php echo $rows['email']; ?>">
                            <input type="submit" value="Promote" class="btn">
                        </form>
                    </td>
                </tr>
            <?php 
        }?>
        </table>
        </div>
        <br><br><br>
        
        <div class="table">
            
        <table width="100%" id="doctortable">
            <tr>
                <th colspan="9">
                    <h2>Doctor Record</h2>
                </th>
            </tr>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Contact</th>
            <th>Speciality</th>
            <th>Charges</th>
            <th>Room Number</th>
            <th>Edit</th>
            <th>Delete</th>
            <tr>
                <?php
                while ($rows = mysqli_fetch_assoc($doctorResult)) {
                    ?>
                    <td>
                        <?php echo $rows['name']; ?>
                    </td>
                    <td>
                        <?php echo $rows['email']; ?>
                    </td>
                    <td>
                        <?php echo $rows['age']; ?>
                    </td>
                    <td>
                        <?php echo $rows['gender']; ?>
                    </td>
                    <td>
                        <?php echo $rows['phone']; ?>
                    </td>
                    <td>
                        <?php echo $rows['speciality']; ?>
                    </td>
                    <td>
                        <?php echo $rows['charges']; ?>
                    </td>
                    <td>
                        <?php echo $rows['room_no']; ?>
                    </td>
                    <td>
                        <form action="../php/edit_doctor.php" method="get" style="display:inline;">
                            <input type="hidden" name="edit_email" value="<?php echo $rows['email']; ?>">
                            <input type="submit" class="btn" value="Edit">
                        </form>
                    </td>
                    <td>
                        <form action="../php/delete_user.php" method="get" style="display:inline;">
                            <input type="hidden" name="delete_email" value="<?php echo $rows['email']; ?>">
                            <input type="submit" class = "btn" value="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                        </form>
                    </td>
            </tr>
                <?php 
                }?>
        </table>
    </div>
</body>
</html>