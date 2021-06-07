<?php 
    require_once "config.php";
    $id = $_GET['edit_task'];
    $sql="SELECT `task` FROM `todo` WHERE `id`='$id'";
    $result=mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $edited=$_POST['edittask'];
        $editid=$_POST['eid'];
        $sql2="UPDATE `todo` SET `task`='$edited' WHERE `id`= '$editid'";
        $result=mysqli_query($conn,$sql2);
        header('location: todo.php');
    }

    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit task</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="updation">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Task: <input type="text" name="edittask" value="<?php echo $row['task'];?>">
        <br><br>
        <input  type="hidden" name="eid" value="<?php echo $id;?>" >
        <button type="submit" name="submit">Update</button>
    

    </form>
    </div>
</body>
</html>