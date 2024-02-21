<!-- login
     Used to login a user 
     Determines which type of user and redirects them to appropriate page
-->

<?php

// Start the session
session_start();

// Connect to the database
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "467";
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);


// Check if the login form has been submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    
    // Get the login credentials from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query the database for the user with the given username and password
    $query = "SELECT * FROM ASSOCIATE WHERE UNAME='$username' AND PASS='$password'";
    $result = mysqli_query($conn, $query);

    // Check if the user exists in the database
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Set session variables
        $_SESSION['AID'] = $row['AID'];
 
        
        // Redirect the user to the appropriate page
        if ($row['UNAME'] == "Admin") {
            header("Location: Admin.php");
            exit();
        } elseif ($row['UNAME'] == "HQ") {
            header("Location: HQ.php");
            exit();
        } elseif ($row['UNAME'] == "B"){
            header("Location: quoteWEBpage.php");
            exit();
        }elseif ($row['UNAME'] == "K"){
            header("Location: quoteWEBpage.php");
            exit();
        } elseif ($row['UNAME'] == "J"){
            header("Location: quoteWEBpage.php");
            exit();
        } elseif ($row['UNAME'] == "JA"){
            header("Location: quoteWEBpage.php");
            exit();
        }
    } else {
        // Invalid login credentials
        $error = "Invalid username or password.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h1>Login Page</h1>
    <?php if (isset($error)) { ?>
        <div style="color: red;"><?php echo $error; ?></div>
    <?php } ?>
    <form method="post" action="">
        <label>Username:</label><br>
        <input type="text" name="username"><br>
        <label>Password:</label><br>
        <input type="password" name="password"><br>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
