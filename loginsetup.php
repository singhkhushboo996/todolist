<?php
// session_start();
// $_SESSION['userid']="user";

// if(isset($_SESSION['userid']) && $_SESSION['userid'] === true){
//     header("location: todolist");
// }
require_once "config.php";

$username=$password=$confirmpassword="";
$usernameErr=$passErr=$confrimpassErr="";

$error[]="";

$sucess="verfication succed!";
if($_SERVER['REQUEST_METHOD']=="POST"){

    
            $username=$_POST['username'];
            $password=$_POST['pass'];
            $confrimpassword=$_POST['confirmpass'];


            if($_POST["username"]) {
                $username = test_input($_POST["username"]);
                if (!preg_match('/^[a-zA-Z0-9]{5,}$/', $username)) {
                    $usernameErr = "alphanumeric allowed and username length minimum 5 characters";
                    $error=$username;
                }
            }
           
    

             if($_POST["pass"] == $_POST["confirmpass"]) {
            $password = test_input($_POST["pass"]);
            $confirmpassword = test_input($_POST["confirmpass"]);

            if (strlen($_POST["pass"]) <= '6') {
            $passErr = "Your Password Must Contain At Least 6 Characters!";
            $error=$passErr;
            }
            elseif(!preg_match("#[0-9]+#",$password)) {
            $passErr = "Your Password Must Contain At Least 1 Number!";
            $error=$passErr;
            }
            elseif(!preg_match("#[A-Z]+#",$password)) {
            $passErr = "Your Password Must Contain At Least 1 Capital Letter!";
            $error=$passErr;
            }
            elseif(!preg_match("#[a-z]+#",$password)) {
            $passErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
            $error=$passErr;
            } else{
            // $confrimpassErr = "Please Check You've Entered Or Confirmed Your Password!";
            $error=$passErr;
                }
            }
        

       
           $sql = "INSERT INTO login(username,password,confrimpassword) VALUES ('$username','$password','$confirmpassword')";
           if (mysqli_query($conn, $sql)) {
            echo "<p>".$sucess."</p>";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }


}



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Setup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<div class="loginsetup">
<h1 style="color:green">Login Setup</h1>
<!-- <h3 class="sucess"><?php echo $success;?></h3> -->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">

<fieldset class="fieldsetclass">
<label for="username">Username:</label>
<input type="text" name="username" id="username" placeholder="Enter your username" required >
<span class="error">* <?php echo $usernameErr;?></span><br><br>
<label for="pass">Password:</label>
<input type="password" name="pass" id="pass" required>
<span class="error">* <?php echo $passErr;?></span><br><br>
<label for="confirmpass">Confirm Password:</label>
<input type="password" name="confirmpass" id="confirmpass" required>
<span class="error">* <?php echo $confrimpassErr;?></span><br><br>

<input type="submit" value="SUBMIT"><br><br><br>
</fieldset>
</form>
<p>Go to<a href="index.php">Login page</a></p>
</div>
</div>
</body>
</html>