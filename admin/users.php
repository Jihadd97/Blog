<?php
session_start();
//for checking if the user is logged in or not
if(!isset($_SESSION["Log"])or $_SESSION["Log"]!=true){
  header("Location:login.php");
  exit;
}

include_once("conn.php");

try
{
  $sql  = "SELECT `id`, `firstName`, `lastName`, `email`,`active` FROM `users`;";
  $stmt = $conn->prepare($sql);
	$stmt->execute();
    
    if(isset($_REQUEST['id'])) {
        $sql1 ="DELETE FROM `users` WHERE `id`=?;";
        $id   = $_GET["id"];
        $stmt = $conn->prepare($sql1);
        $stmt->execute([$id]);
        echo "Deleted Successfully";
        header("Location:users.php");
        exit();
  } 
}catch(PDOException $e){
      echo "Connection failed: " . $e->getMessage();
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users</title>
    <link rel="stylesheet" href="css/posts.css">
    <link rel="stylesheet" href="css/style2.css">
</head>
<body>
<?php include_once("navbar.php"); ?>

        <div id="wrapper">
         <h1>Users</h1>
         
         <table id="keywords" cellspacing="0" cellpadding="0">
           <thead>
             <tr>
               <th><span>First Name</span></th>
			         <th><span>Last Name</span></th>
               <th><span>Email</span></th>
               <th><span>Active</span></th>
               <th><span>Delete</span></th>
               <th><span>Update</span></th>
             </tr>
           </thead>
           <tbody>
            
           <?php foreach($stmt->fetchAll() as $k){
              $id        = $k["id"];
              $firstName = $k["firstName"];
              $lastName  = $k["lastName"];
              $email     = $k["email"];
              $active    = $k["active"];
            ?>
             <tr>
               <td class="lalign"><?php echo $firstName;?></td>
			         <td><?php echo $lastName;?></td>
               <td><?php echo $email;?></td>
               <td>
               <?php 
                if($active == 0) echo "No";
                elseif($active == 1) echo "Yes";
               ?>
               </td>
               <input type = "hidden" name ="id" value="<?php echo $id?>">

               <td><a onClick="javascript: return confirm('Please confirm deletion');" href="users.php?id=<?php echo $id?>"><img src="../assets/imgs/delete.jpg" alt="Delete"></a></td>
               <td><a href="updateUser.php?id=<?php echo $id?>"><img src="../assets/imgs/update.jpg" alt="Update"></a></td>
             </tr>
            <?php
                 }
            ?> 
           </tbody>
         </table>
        </div> 
</body>
</html>
