
<?php      
require_once "config.php";

    session_start();
    $message="";
    if(count($_POST)>0) {
        $sql= "SELECT * FROM login WHERE username='" . $_POST["username"] . "' and password = '". $_POST["pass"]."'";
       
        $result = mysqli_query($conn,$sql);
        $row  = mysqli_fetch_array($result);
        if(is_array($row)) {
        $_SESSION["username"] = $row['username'];
        
        } else {
         $message = "Invalid Username or Password!";
        }
    }
    if(isset($_SESSION["username"])) {
    header("Location:todo.php");
    }



         
?>  





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="container">
        <div class="loginfrom">
            <h1 style="color:green;">Login</h1>
            <p style="color:blue">Please fill in your username and password.</p>
            <div class="message"><?php if($message!="") { echo $message; } ?></div>
            <fieldset class="fieldsetclass">
            <legend>Login form</legend>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <label for="username">Username</label><br>
            <input type="text" name="username" id="lusername"  placeholder="Enter you email/username" size="50" required><br>
            <br><br>
            <label for="pass">Password</label><br>
            <input type="password" name="pass" id="pass"  size="50" required>
            <input type="checkbox" onclick="myFunction()">Show Password <br>
            
            <br><br>

            <button type="submit">SUBMIT</button><br><br>
            <p>Don't have an account? <a href="signup.php">Signup Here!</a></p>

            
            </fieldset>
        </form>

        </div>
    </div>
    
        <script>
         function myFunction() {
            var x = document.getElementById("pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
                }
            }

            </script>
           
            
</body>
</html>