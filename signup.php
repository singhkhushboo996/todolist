<?php

require_once "config.php";

$imgErr=$fnameErr=$emailErr=$linkedinErr=$githubErr=$uninameErr=$courseErr=$coursecompErr=$mobileErr=$addErr=$dobErr=$genderErr=$disciErr="";
$image=$fname=$lname=$email=$linkedin=$github=$university=$coursename=$discipline=
$course_completion=$mobile=$country=$state=$city=$dob=$gender="";

$success="data added sucessfully!";

$errors = array();
$valid=0; 
  if($_SERVER['REQUEST_METHOD']=="POST")
  {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

    $lname=$_POST["lname"];
    $course_completion= $_POST['course_completion'];

    if(empty($_FILES['image'])){
        $imgErr = "Image is required";
        $errors[]= $imgErr;
    }else{
        // echo "<pre>";
        // print_r($_FILES);
        // echo "</pre>";
        // $filename= $_FILES['image']['name'];
        // $filesize= $_FILES['image']['size'];
        // $filetempname= $_FILES['image']['tmp_name'];
        // $filetype= $_FILES['image']['type'];
        // move_uploaded_file($filetempname,"images/".$filename);
        // $image = file_get_contents($_FILES['image']['tmp_name']);

        // move_uploaded_file($filetempname,"images/".$filename);

        $name = $_FILES['image']['name'];
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $extensions_arr = array("jpg","jpeg","png","gif");

        if(in_array($imageFileType,$extensions_arr)){
        move_uploaded_file($_FILES['image']['tmp_name'],$target_dir.$name);
        $valid++;
        }

    }

    if (empty($_POST["fname"])) {
        $fnameErr = "Firstname is required";
        $errors[]=$fnameErr;
    } else {
        if (!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
          $nameErr = "Only letters and white space allowed";
          $error[]=$nameErr;
        }else{
          $fname = test_input($_POST["fname"]);
          $valid++;
        }
    }

     
    

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $errors[]=$emailErr;
      } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format";
          $errors[]=$emailErr;
        }
        else{
          $email = test_input($_POST["email"]);
          $valid++;
        }
    }

    if (empty($_POST["linkedin"])) {
        $linkedinErr = "link is required";
        $errors[]=$linkedinErr;
      } else {
        $linkedin = test_input($_POST["linkedin"]);
        if (!filter_var($linkedin, FILTER_VALIDATE_URL)) {
          $linkedinErr = "Invalid URL";
          $errors[]=$linkedinErr;
        }else{
          $linkedin = test_input($_POST["linkedin"]);
          $valid++;
        }
    }

    if (empty($_POST["github"])) {
        $githubErr = "link is required";
        $errors[]=$githubErr;
      } else {
        $github = test_input($_POST["github"]);
        if (!filter_var($github, FILTER_VALIDATE_URL)) {
          $githubErr = "Invalid URL";
          $errors[]=$githubErr;
        }else{
          $github = test_input($_POST["github"]);
          $valid++;
        }
    }

    // if(!empty($_POST['check_list'])) {
    //   foreach($_POST['check_list'] as $check) {
    //           echo $check;
    //   }}else{
    //     $courseErr="please select at least one course";
    //   }

    if(empty($_POST['coursename'])) {
      $courseErr ='Please select the value.';
      $errors[]=$courseErr;
      
    } else {
      
      $coursename = $_POST['coursename'];
      $valid++;
    }


    if (empty($_POST["gender"])) {
      $genderErr = "Gender is required";
      $errors[]=$genderErr;
    } else {
      $gender = test_input($_POST["gender"]);
      $valid++;
    }

    if (empty($_POST["mobile"])) {
      $mobileErr = "mobile number is required";
      $errors[]=$mobileErr;
    } else {
      $mobile = test_input($_POST["mobile"]);
      if (!preg_match('/^[0-9]{3}[0-9]{3}[0-9]{4}$/',$mobile)) {
        $mobileErr = 'Invalid Number!';
      }
      else
      {
        $mobile = test_input($_POST["mobile"]);
        $valid++;
      }
    }

    if (empty($_POST["discipline"])) {
      $disciErr = "discipline of qualifing degree is required";
      $errors[]=$disciErr;
    } else {
      if (!preg_match("/^[a-zA-Z-' ]*$/",$discipline)) {
        $disciErr = "Only letters and white space allowed";
        $errors[]=$disciErr;
      }else{
        $discipline = test_input($_POST["discipline"]);
        $valid++;
      }
    }

    if (empty($_POST["university"])) {
    $uninameErr = "University name is required";
    $errors[]=$uninameErr;
    } else {
    if (!preg_match("/^[a-zA-Z-' ]*$/",$university)) {
      $uninameErr = "Only letters and white space allowed";
      }
      else{
        $university = test_input($_POST["university"]);
        $valid++;
      }
    }

    if(!empty($_POST['country'])) {
      $country = $_POST['country'];
      $valid++;
    } else {
      $addErr ='Please select the value.';
      $errors[]=$addErr;
    }

    if(!empty($_POST['dob'])){
      $dob = $_POST['dob'];
      $today = date("Y-m-d");
      $diff = date_diff(date_create($dob), date_create($today));
      
      if($diff->format("%a") <= 18){
         $dobErr="you are too young to register";
         $errors[]=$dobErr;
      }
      else{
        $valid++;
      }
    } 
  }

  if($valid == 12)
  {
    $sql="INSERT INTO signup (image,firstname, lastname,email,linkedinlink,githubink,universityname,coursename,discipline,course_completion_date,mobile,address,dateofbirth,gender) VALUES (
     '.$name.','$fname','$lname','$email','$linkedin','$github','$university','$coursename','$discipline','$course_completion','$mobile','$country','$dob','$gender')";

  
    if (mysqli_query($conn, $sql)) {
      echo "sucessfully added";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    mysqli_close($conn);

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
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<div class="fromclass">
<h1 style="color:green">Sign Up</h1>
<p style="color:blue">Please fill this from to create new account.</p>
<p><span class="error">* required field</span></p>
<!-- <h3 class="sucess"><?php echo $success;?></h3> -->
<form action="<?php if($valid < 12){ echo htmlspecialchars($_SERVER["PHP_SELF"]);}?>" method="post" enctype="multipart/form-data">
<fieldset class="fieldsetclass"><legend ><b>Personal Detail</b></legend>
<label for="image">Display picture:</label>
<input type="file"  id="image" name="image" required/>
<span class="error">* <?php echo $imgErr;?></span><br><br>
<label for="fname">First Name:</label>
<input type="text" name="fname" id="fname" required>
<span class="error">* <?php echo $fnameErr;?></span><br><br>
<label for="lname">Last Name:</label>
<input type="text" name="lname" id="lname">
<br><br>
<label for="email">Email:</label>
<input type="email" name="email" id="email" required>
<span class="error">* <?php echo $emailErr;?></span><br><br>
<label for="linkedin">Linkedin Profile Link:</label>
<input type="url" name="linkedin" id="linkedin" required>
<span class="error">* <?php echo $linkedinErr;?></span><br><br>
<label for="github">Github Link:</label>
<input type="url" name="github" id="github" required>
<span class="error">* <?php echo $githubErr;?></span><br><br>
<label for="university">University Name:</label>
<input type="text" name="university" id="university" autocomplete="on" required>
<span class="error">* <?php echo $uninameErr;?></span><br><br>

<label class="coursename">Course name:</label>
<!-- <input type="checkbox" name="check_list[]" value="HTML"><label>HTML</label>
<input type="checkbox" name="check_list[]" value="CSS"><label>CSS</label>
<input type="checkbox" name="check_list[]" value="Javascript"><label>Javascript</label>
<input type="checkbox" name="check_list[]" value="jQuery"><label>jQuery</label>
<input type="checkbox" name="check_list[]" value="PHP"><label>PHP</label> -->
<select name="coursename" required>
        <option value="" disabled selected>Choose course</option>
        <option value="HTML">HTML</option>
        <option value="CSS">CSS</option>
        <option value="javascript">JavaScript</option>
        <option value="jquery">jQuery</option>
        <option value="php">PHP</option>
    </select>


<span class="error">* <?php echo $courseErr;?></span><br><br>
  
<label for="discipline">Discipline:</label>
<input type="text" name="discipline" id="discipline" required>
<span class="error">* <?php echo $disciErr;?></span><br><br>
<label for="course_completion">Course Completion Date:</label>
<input type="date" id="course_completion" name="course_completion" required>
<span class="error">* <?php echo $coursecompErr;?></span><br><br>
<label for="mobile">Mobile Number:</label>
<input type="tel" name="mobile" id="mobile" required>
<span class="error">* <?php echo $mobileErr;?></span><br><br>

<label for="address">Address: </label>
<ol type ="a">
<li><label for="country">Country:</label></li>
<select name="country">
        <option value="" disabled selected>Choose country</option>
        <option value="india">India</option>
        <option value="korea">Korea</option>
        <option value="usa">USA</option>
        <option value="france">France</option>
        <option value="Spain">Spain</option>
    </select>
    <li><label for="state">States:</label></li>
<select name="state">
        <option value="" disabled selected>Choose state</option>
        <option value="haryana">haryana</option>
        <option value="punjab">Punjab</option>
        <option value="delhi">Delhi</option>
        <option value="sikkim">Sikkim</option>
        <option value="assam">Assam</option>
    </select>
    <li><label for="city">City:</label></li>
<select name="city">
        <option value="" disabled selected>Choose city</option>
        <option value="gurugram">Gurugram</option>
        <option value="rohtak">Rohtak</option>
        <option value="faridabad">Faridabad</option>
        <option value="karnal">Karnak</option>
        <option value="hisar">Hisar</option>
    </select>
</ol>
<span class="error">* <?php echo $addErr;?></span><br><br>
<label for="dob">Date of Birth:</label>
<input type="date" name="dob" id="dob" required>
<span class="error">* <?php echo $dobErr;?></span><br><br>

<label for="gender">Gender:</label>
<input type="radio" name="gender" value="female"
<?php if (isset($gender) && $gender=="female") echo "checked";?>
><label>Female</label>
<input type="radio" name="gender" value="male"
<?php if (isset($gender) && $gender=="male") echo "checked";?>
><label>male</label>
<input type="radio" name="gender" value="other"
<?php if (isset($gender) && $gender=="other") echo "checked";?>
><label>Others</label>
<span class="error">* <?php echo $genderErr;?></span><br><br>

<br><br>

<input type="submit" value="SUBMIT"><br><br><br>
<button><a href="loginsetup.php">Next Step ></a></button><br><br>
</fieldset>

</form>




</div>
</div>
    
</body>
</html>