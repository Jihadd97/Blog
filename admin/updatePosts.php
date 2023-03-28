<?php
session_start();

if(!isset($_SESSION["Log"])or $_SESSION["Log"]!=true){
  header("Location:login.php");
  exit;
}

include_once("conn.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){

 // Get reference to uploaded image
 $image_file = $_FILES["image"]; //image is the form input file element name

 // Exit if no file uploaded
 if (!isset($image_file)) {
	 die('No file uploaded.');
 }

 // Add old image details if no file uploaded or replace the new image
 if ($image_file["tmp_name"] != "") {
 // Exit if image file is zero bytes
 	if (filesize($image_file["tmp_name"]) <= 0) {
		 die('Uploaded file has no contents.'); }
		

 // Exit if is not a valid image file
 $image_type = exif_imagetype($image_file["tmp_name"]);
 if (!$image_type) {
	 die('Uploaded file is not an image.');
 }

 // Get file extension based on file type, to prepend a dot we pass true as the second parameter
 $image_extension = image_type_to_extension($image_type, true);

 // Create a unique image name
 $image_name = bin2hex(random_bytes(16)) . $image_extension;

 // Move the temp image file to the images directory
 move_uploaded_file(
	 // Temp image location
	 $image_file["tmp_name"],

	 // New image location
	 __DIR__ . "/../assets/imgs/" . $image_name );
	 $image=$image_name;

 } else {
	$image=$_POST["oldImage"];
}

try{
	$sql        = "UPDATE `posts` SET `postTitle`=?,`content`=?,`featured`=?,`published`=?,
			       `date_created`=?,`views`=?,`image`=? WHERE `id`=?;";
	$id         = $_POST["id"];
	$title      = $_POST["title"];
	$content    = $_POST["content"];
	

	if(isset($_POST["featured"])) //this way to take value from the checkbox
		{
			$featured = "1";
		}else{
			$featured = "0";
		}
	if(isset($_POST["published"]))
		{
			$published = "1";
		}else{
			$published = "0";
		}

	$date       = $_POST["date_created"];
	$views      = $_POST["views"];
	$stmt       = $conn->prepare($sql);
	$stmt->execute([$title,$content,$featured,$published,$date,$views,$image,$id]);
	//echo "Updated Successfully";  
	header("Location: posts.php");
	exit();

} catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}

}else{
	$id= $_GET["id"];
}

try{
	$sql1   = "SELECT * FROM `posts` where id = ?;";
	$stmt1  = $conn->prepare($sql1);
	$stmt1  ->execute([$id]);
	$result = $stmt1->fetch();
	$featured = $result["featured"];
	$published = $result["published"];
} catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Update Post</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style1.css">
		<link rel="stylesheet" href="css/style2.css">
	</head>

	<body>
	<?php include_once("navbar.php"); ?>

		<div class="container">
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="m-auto" style="max-width:600px" enctype="multipart/form-data">
				<h3 class="my-4">Update Post</h3>
				<hr class="my-4" />

				<div class="form-group mb-3 row"><label for="title2" class="col-md-5 col-form-label">Post Title</label>
					<div class="col-md-7"><input type="text"  class="form-control form-control-lg" value="<?php echo $result["postTitle"];?>" id="title2" name="title" required placeholder="Enter Post Title"></div>
				</div>
                
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="content4" class="col-md-5 col-form-label">Content</label>
					<div class="col-md-7"><textarea   class="form-control form-control-lg" id="content4" name="content" required placeholder="Enter Content"><?php echo $result["content"];?></textarea></div>
				</div>
                
                <hr class="my-4" />
				<div class="form-group mb-3 row"><label for="featured" class="col-md-5 col-form-label">Featured</label>
				<?php
				if($featured){
					$checked = "checked";
				}else
					$checked = " ";
				?>
					<div class="col-md-7"><input type="checkbox" id="featured" name="featured" value="1"<?php echo $checked?>></div>
				</div>
				
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="published" class="col-md-5 col-form-label">Published</label>
				<?php
				if($published == 1){
					$checked = "checked";
				}else
					$checked = "";
				?>
					<div class="col-md-7"><input type="checkbox" id="published"  name="published" value="1" <?php echo $checked?>></div>
				</div>
				
				<hr class="my-4" />
				<div>
					<img src="../assets/imgs/<?php echo $result["image"];?>" alt="<?php echo $result["image"];?>" style="width:150px; height:100px;">
				 	<br>
					<label for="image" class="col-md-5 col-form-label">Select Image</label>
					<input type="file" value="<?php echo $result["image"];?>" id="image" name="image" accept="image/*">

					<input type = "hidden" name ="id" value="<?php echo $id?>">
					<input type = "hidden" name ="oldImage" value="<?php echo $result["image"];?>">
					<input type = "hidden" name ="date_created" value="<?php echo $result["date_created"];?>">
					<input type = "hidden" name ="views" value="<?php echo $result["views"];?>">

				</div>

				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="insert10" class="col-md-5 col-form-label"></label>
					<div class="col-md-7"><button class="btn btn-primary btn-lg" type="submit">Update</button></div>
               </div>
			</form>
		</div>
	</body>

</html>

