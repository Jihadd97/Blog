<?php 
session_start();

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    include_once("conn.php");

    $email    = $_POST["email"];
    $password = $_POST["password"];

  try{
        $sql    ="SELECT * FROM `users` where email = ? and active = 1 ;";
        $stmt   = $conn->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch();

        if(!$result){
          echo "Try again!";

        } else { 
           if (password_verify($password,$result["password"])){
             $_SESSION["firstName"]  = $result["firstName"];
			       $_SESSION["lastName"]   = $result["lastName"];
             $_SESSION["id"]         = $result["id"];
             $_SESSION["Log"]        = true;
             header("Location:../index.php");
             exit();    
        } else {
          echo "Invalid Password";
        }
      }
    }catch(PDOException $e){
          echo "Error: " . $e->getMessage();
        }
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <!-- Body of Form starts -->
  	<div class="container">
      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" autocomplete="on">
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
    					<input type="Password" required name="password" id="myInput" placeholder="Password" class="textBox"><br>
              <br><input type="checkbox" onclick="myFunction()"> Show Password
           
    <!-- this function to show/hide password --> 
          <script> 
          function myFunction() {
            var pass = document.getElementById("myInput");
            if (pass.type === "password") {
              pass.type = "text";
            } else {
              pass.type = "password";
            }
          }
        </script>
    			</div>
    			<div class="clr"></div>
    		</div>
    		<!---Password---->

    		<!---Submit Button------>
    		<center><br><div class="box" style="background: #2d3e3f"></center>
    			<input type="Submit" name="Submit" class="submit" value="Login">
    		</div>
    		<!---Submit Button----->
      </form>
  </div>
  <!--Body of Form ends--->
  </body>
</html>
