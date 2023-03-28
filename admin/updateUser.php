<?php
session_start();
if(!isset($_SESSION["Log"])or $_SESSION["Log"]!=true){
  header("Location:login.php");
  exit;
}

include_once("conn.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){


	try{
		$sql="UPDATE `users` SET `firstName`= ?,`lastName`=?,`phone`=?,`email`=?,
			`password`=?,`gender`=?,`active`=? WHERE `id`=?;";
		$id        = $_POST["id"];
		$firstName = $_POST["firstName"];
		$lastName  = $_POST["lastName"];
		$phone     = $_POST["phone"];
		$email     = $_POST["email"];
		$password  = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$gender    = $_POST["gender"];
		

		if(isset($_POST["active"])) //this way to take value from the checkbox
		{
			$active = "1";
		}else
			$active = "0";

		$stmt = $conn->prepare($sql);
        $stmt->execute([$firstName,$lastName,$phone,$email,$password,$gender,$active,$id]);
		//echo "Updated Successfully";  
		header("Location: users.php");
      	exit();
  
	}catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
	}
} else {
	$id = $_GET["id"]; // to display the information from database in case not POST
}

try{
	$sql = "SELECT * FROM `users` where id = ?;";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);
	$result = $stmt->fetch();
	
	$genderType = $result["gender"];
	$active = $result["active"];

	//get the gender types and upload to the drop down list
	$sql1="SELECT DISTINCT gender FROM users;";
	$stmt2 = $conn->prepare($sql1);
	$stmt2->execute();
	
}catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}


?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Update User</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style1.css">
		<link rel="stylesheet" href="css/style2.css">
	</head>

	<body>
	<?php include_once("navbar.php"); ?>
	
		<div class="container">
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="m-auto" style="max-width:600px">
				<h3 class="my-4">Update User</h3>
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="firstName" class="col-md-5 col-form-label">First Name</label>
					<div class="col-md-7"><input type="text" value="<?php echo $result["firstName"];?>" class="form-control form-control-lg" id="firstName" name="firstName" required></div>
				</div>
                
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="lastName" class="col-md-5 col-form-label">Last Name</label>
					<div class="col-md-7"><input type="text" value="<?php echo $result["lastName"];?>"  class="form-control form-control-lg" id="lastName" name="lastName" required></div>
				</div>
                
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="phone" class="col-md-5 col-form-label">Phone</label>
					<div class="col-md-7"><input type="text" value="<?php echo $result["phone"];?>" class="form-control form-control-lg" id="phone" name="phone" required></div>
				</div>

				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="email" class="col-md-5 col-form-label">Email</label>
					<div class="col-md-7"><input type="text" value="<?php echo $result["email"];?>" class="form-control form-control-lg" id="email" name="email" required></div>
				</div>
			
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="password" class="col-md-5 col-form-label">Password</label>
					<div class="col-md-7"><input type="password" value="<?php echo $result["password"];?>" class="form-control form-control-lg" id="password" name="password" required></div>
				</div>

                <hr class="my-4" />
				<div class="form-group mb-3 row"><label for="gender" class="col-md-5 col-form-label">Gender</label>
					<select  class="form-select custom-select custom-select-lg" value="<?php echo $result["gender"];?>" id="gender" name="gender">
					<?php	
						foreach($stmt2->fetchAll() as $k){
							$currentType=$k["gender"];
							if($genderType == $currentType){
								echo "<option selected>$currentType</option>";
							}else{
								echo "<option>$currentType</option>";
							}
							}
					?>		
					</select>
				</div>
				
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="active" class="col-md-5 col-form-label">Active</label>
				<?php
					if($active == 1)
					{
						$checked = "checked";
					}else
						$checked = "";
				?>
					<div class="col-md-7"><input type="checkbox" id="active" name="active" value = "1" <?php echo $checked;?>></div>
					
				</div>

				<input type = "hidden" name ="id" value="<?php echo $id?>">

				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="insert10" class="col-md-5 col-form-label"></label>
					<div class="col-md-7"><button class="btn btn-primary btn-lg" type="submit">Update</button></div>
               </div>
			</form>
		</div>
	</body>

</html>

