<?php
session_start();

if(!isset($_SESSION["Log"]) or $_SESSION["Log"]!=true){
  header("Location: login.php");
  exit();
}

include_once("conn.php");

try
{
    $sql  = "SELECT `id`, `postTitle`, `featured`,`date_created`, `views` FROM `posts` ORDER BY id DESC;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    if(isset($_GET['id'])) {
      $sql1  = "DELETE FROM `posts` WHERE `id`=?;";
      $id    = $_GET["id"];
      $stmt1 = $conn->prepare($sql1);
      $stmt1->execute([$id]);
      echo "Deleted Successfully";
      header("Location:posts.php");
      exit();   
    } 

}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
  }
  
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Posts</title>
    <link rel="stylesheet" href="css/posts.css">
    <link rel="stylesheet" href="css/style2.css">
</head>
<body>
<?php include_once("navbar.php"); ?>

        <div id="wrapper">
         <h1>Posts</h1>
         
         <table id="keywords" cellspacing="0" cellpadding="0">
           <thead>
             <tr>
               <th><span>Title</span></th>
			   <th><span>Date Published</span></th>
               <th><span>Featured</span></th>
               <th><span>Visits</span></th>
               <th><span>Delete</span></th>
               <th><span>Update</span></th>
             </tr>
           </thead>
           <tbody>
        <?php foreach($stmt->fetchAll() as $k){
              $id       = $k["id"];
              $title    = $k["postTitle"];
              $date     = $k["date_created"];
              $featured = $k["featured"];
              $visits   = $k["views"];
         ?>
             <tr>
               <td class="lalign"><?php echo $title; ?></td>
			         <td><?php echo $date; ?></td>
               <td>

              <?php 
                if($featured == 0) echo "No";
                elseif($featured == 1) echo "Yes";
              ?> 
              
               </td>
               <td><?php echo $visits; ?></td>
               <input type = "hidden" name ="id" value="<?php echo $id?>">
               <td><a onClick="javascript: return confirm('Please confirm deletion');"href="posts.php?id=<?php echo $id?>"><img  src="../assets/imgs/delete.jpg" alt="Delete"></a></td>
               <td><a href="updatePosts.php?id=<?php echo $id?>"><img  src="../assets/imgs/update.jpg" alt="Delete"></a></td>
             </tr>

        <?php } ?> 

           </tbody>
         </table>
        </div> 
</body>
</html>
