<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){
	include_once("conn.php");
	try{
		$firstName = $_POST["firstName"];
		$lastName  = $_POST["lastName"];
		$phone     = $_POST["phoneNo"];
		$email     = $_POST["email"];
		$password  = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$gender    = $_POST["Gender"];

		if(isset($_POST["Gender"])) //this way to take value from the checkbox
		{
			$gender = "1";
		}else{
			$gender = "0";
		}
		
		$sql       = "INSERT INTO `users`(`firstName`, `lastName`, `phone`, `email`, `password`, `gender`, `active`) VALUES (?,?,?,?,?,?,0)";
		$stmt      = $conn->prepare($sql);
		$stmt->execute([$firstName,$lastName,$phone,$email,$password,$gender]);
		header("Location: login.php");
		exit();
	}catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registration Form</title>
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <!-- Body of Form starts -->
  	<div class="container">
      <form method="POST" action=<?php echo $_SERVER['PHP_SELF']?> autocomplete="on">
        <!--First name-->
    		<div class="box">
          <label for="firstName" class="fl fontLabel"> First Name: </label>
    			<div class="new iconBox">
            <i class="fa fa-user" aria-hidden="true"></i>
          </div>
    			<div class="fr">
    					<input type="text" name="firstName" placeholder="First Name"
              class="textBox" autofocus="on" required>
    			</div>
    			<div class="clr"></div>
    		</div>
    		<!--First name-->


        <!--Last name-->
    		<div class="box">
          <label for="secondName" class="fl fontLabel"> Last Name: </label>
    			<div class="fl iconBox"><i class="fa fa-user" aria-hidden="true"></i></div>
    			<div class="fr">
    					<input type="text" required name="lastName"
              placeholder="Last Name" class="textBox">
    			</div>
    			<div class="clr"></div>
    		</div>
    		<!--Last name-->


    		<!---Phone No.------>
    		<div class="box">
          <label for="phone" class="fl fontLabel"> Phone No.: </label>
    			<div class="fl iconBox"><i class="fa fa-phone-square" aria-hidden="true"></i></div>
    			<div class="fr">
    					<input type="text" required name="phoneNo" maxlength="11" placeholder="Phone No." class="textBox">
    			</div>
    			<div class="clr"></div>
    		</div>
    		<!---Phone No.---->


    		<!---Email ID---->
    		<div class="box">
          <label for="email" class="fl fontLabel"> Email ID: </label>
    			<div class="fl iconBox"><i class="fa fa-envelope" aria-hidden="true"></i></div>
    			<div class="fr">
    					<input type="email" required name="email" placeholder="Email Id" class="textBox">
    			</div>
    			<div class="clr"></div>
    		</div>
    		<!--Email ID----->


    		<!---Password------>
    		<div class="box">
          <label for="password" class="fl fontLabel"> Password </label>
    			<div class="fl iconBox"><i class="fa fa-key" aria-hidden="true"></i></div>
    			<div class="fr">
    					<input type="Password" required name="password" placeholder="Password" class="textBox">
    			</div>
    			<div class="clr"></div>
    		</div>
    		<!---Password---->

    		<!---Gender----->
    		<div class="box radio">
          <label for="gender" class="fl fontLabel"> Gender: </label>
    				<input type="radio" name="Gender" <?php if (isset($gender) && $gender=="Male") echo "Male";?> 
						value=1 required> Male &nbsp; &nbsp; &nbsp; &nbsp;
    				<input type="radio" name="Gender" <?php if (isset($gender) && $gender=="Female") echo "Female";?> 
						value=0 required> Female
    		</div>
    		<!---Gender--->


    		<!--Terms and Conditions------>
    		<div class="box terms">
    				<input type="checkbox" name="Terms" required> &nbsp; I accept the terms and conditions
    		</div>
    		<!--Terms and Conditions------>



    		<!---Submit Button------>
    		<div class="box" style="background: #2d3e3f">
    				<input type="Submit" name="Submit" class="submit" value="SUBMIT">
    		</div>
    		<!---Submit Button----->
      </form>
  </div>
  <!--Body of Form ends--->
  </body>
</html>
