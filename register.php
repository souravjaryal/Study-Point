<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="register.css">
</head>

<body>
<?php
$conn = mysqli_connect("localhost", "root", "", "questionpaperwebsite") or die("Connection Failed");

if (isset($_POST['submit'])) {
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    if (!empty($Username) && !empty($Email) && !empty($Password)) {
        $SELECT = "SELECT `Email address` FROM register WHERE `Email address` = ? LIMIT 1";
        $INSERT = "INSERT INTO register (`Name`, `Email address`, `password`) VALUES (?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sss", $Username, $Email, $Password);
            $stmt->execute();
            $stmt->close();

            echo "<div class='full-height' style='background-color:red'><p style='text-align: center;'><span style='font-size: large; font-family: georgia,palatino; color: #004436;background-color:pink;'>Registration successful!</p>";
        } else {
            echo "<p style='text-align: center; font-size: 30px; font-family: georgia,palatino; color:black;background-color:pink;'>Someone has already registered using this email!</p>";
        }
    } else {
        echo "<p style='text-align: center; font-size: 30px; font-family: georgia,palatino; color:black;background-color:pink;'>All fields are required</p>";
    }
    $conn->close();
}
?>
<div class="wrapper">
    <div class="headline">
        <h1>Welcome</h1>
    </div>
    <form class="form" method="post" action="register.php">
        <div class="signup">
            <div class="form-group">
                <input type="text" name="Username" placeholder="Username" required="">
            </div>
            <div class="form-group">
                <input type="email" name="Email" placeholder="Email" required="">
            </div>
            <div class="form-group">
                <input type="password" name="Password" placeholder="Password" required="">
            </div>
            <button type="submit" name="submit" class="btn">SIGN UP</button>
            <div class="account-exist">
                Already have an account? <a href="login.php" id="login">Login</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>
