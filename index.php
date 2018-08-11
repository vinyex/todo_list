<!DOCTYPE HTML>

<?php
	// initialize errors variable
	$errors = "";
	// connect to database
	$db = mysqli_connect("localhost", "root", "", "todo");
	
	//insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
			$errors = "You must fill in the task.";
		}else {
			$task = $_POST['task'];
			$sql = "insert into tasks (task) values ('$task')";
			mysqli_query($db, $sql);
			header('location: index.php');
		}
	}
?>

<html>
	<head>
		<title>ToDo List Application PHP and MySql</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<div class="heading">
			<h2 style="font-style: 'Hervetica';">ToDo List Application PHP and MySql Database</h2>
		</div>
		<form method="post" action="index.php" class="input_form">
			<input type="text" name="task" class="task_input">
			<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
		</form>
		
<table>
	<thead>
		<tr>
			<th>N</th>
			<th>Tasks</th>
			<th style="width: 60px;">Action</th>
		</tr>
	</thead>
	<tbody>		

		<?php 

		$id = "";
		
		if (!empty($_GET["del_task"])) {
			$id = $_GET["del_task"];
			$sql = "DELETE FROM tasks WHERE id = $id"; 
	
			if (mysqli_query($db, $sql)) {
    			mysqli_close($db);
    			header('Location: index.php'); //If index.php is your main page where you list your all records
    			exit;
			} else {
   	 			echo "Error deleting record";
			}
		}

	
		// select all tasks if page is visited or refreshed
		$tasks = mysqli_query($db, "SELECT * FROM tasks");

		$i = 1; 

		while ($row = mysqli_fetch_array($tasks)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="task"> <?php echo $row['task']; ?> </td>
				<td class="delete"> 
					<a 
						name="btn_delete"
						href="index.php?del_task=<?php echo $row['id'] ?>"
			
					>x</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	</tbody>
</table>

		<?php if (isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
		<?php } ?>
		
	</body>
</html>