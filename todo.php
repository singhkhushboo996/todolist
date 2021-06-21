<?php
session_start();
require_once "config.php";

$error="";

if($_SERVER['REQUEST_METHOD']=="POST")
{
    
    $task=$_POST["task"];
    $date=$_POST["duedate"];
    if(empty($task) && empty($date))
    {
        $error="You must fill the task and Due Date";
    
    }else{
        $sql="INSERT INTO `todo` ( `task`, `date`) VALUES ( '$task', '$date')";
        mysqli_query($conn,$sql);
        header('location: todo.php');
    }


    
}

if (isset($_GET['del_task'])) {
    echo "delete.........";
    
	$id = $_GET['del_task'];
    $sql2="DELETE FROM todo WHERE id=".$id;
	mysqli_query($conn, $sql2);
	header('location: todo.php');
}



if(isset($_GET['complete'])){
    $id = $_GET['complete'];

    $sql3="UPDATE todo SET status='completed'";
    mysqli_query($conn, $sql3);
    header('location: todo.php');

    
}


$sql1="SELECT * FROM `todo` WHERE userid='".$_SESSION["username"]."'";
$tasks = mysqli_query($conn,$sql1);





 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="style1.css">
    <script src="https://kit.fontawesome.com/a2029513e1.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="heading">
<?php
if($_SESSION["username"]) {
?>
 <h1> Welcome <?php echo $_SESSION["username"]; ?></h1>  
 <h3>Click here to <a href="logout.php" tite="Logout">Logout</a> </h3>
<?php
}else echo "<h1>.Please login first .</h1>";
?>
</div>

<form action="todo.php" method="post">
    <?php if (isset($error)) { ?>
	    <p><?php echo $error; ?></p>
    <?php } ?>
 Task:<input type="text" name="task" id="task" size=50 class="task_input"><br>
 Due Date: <input type="date" name="duedate" id="duedate">
<button type="submit" class="add_btn" name="_submit_">Add Task</button>

</form>
<table>
<thead>
    <tr>
        <th>Sno.</th>
        <th>Tasks to do</th>
        <th>Delete</th>
        <th>Edit</th>
        <th>Due Date</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
    <?php  $i=1; while ($row =mysqli_fetch_array($tasks)) { ?>
    <tr>
        <td class="sno"><?php echo $i; ?></td>
        <td class="tasktodo" onclick="myfun()"><?php echo $row['task']; ?></td>
        <td class="delete">
         <a href="todo.php?del_task=<?php echo $row['id'] ?>">Delete <i class="fas fa-trash-alt"></i></a>
        </td>
        <td class="edit">
         <a href="edittodo.php?edit_task=<?php echo $row['id'] ?>">Edit <i class="fas fa-edit"></i></a>
        </td>
        <td class="date"><?php echo $row['date']; ?></td>
        <td class="status"> 
        <a href="todo.php?complete=<?php echo $row['id'] ?>" >Mark as Done</a>
        </td>    
    </tr>
    <?php $i++; } ?>

</tbody>
</table>



</body>
</html>