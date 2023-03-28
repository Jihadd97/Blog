<?php
session_start();

if(!isset($_SESSION["Log"]) or $_SESSION["Log"]!=true){
  header("Location: login.php");
  exit();
}

if($_SERVER["REQUEST_METHOD"] === "POST"){

	include_once("conn.php");

    // Get reference to uploaded image
    $image_file = $_FILES["image"]; //image is the form input file element name

    // Exit if no file uploaded
    if (!isset($image_file)) {
        die('No file uploaded.');
    }

    // Exit if image file is zero bytes
    if (filesize($image_file["tmp_name"]) <= 0) {
        die('Uploaded file has no contents.');
    }

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
			__DIR__. "/../assets/imgs/" . $image_name);
	
	try{
     	$title     = $_POST["title"];
		$content   = $_POST["content"];
       
		if(isset($_POST["featured"])){
			$featured = 1;
		}else
			$featured = 0;

		if(isset($_POST["published"])){
			$published = 1;
		}else
			$published = 0;
		
		$sql  = "INSERT INTO `posts`(`postTitle`, `content`, `featured`, `published`,`image`) VALUES (?,?,?,?,?);";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$title,$content,$featured,$published,$image_name]);
        echo "Successfullly Inserted";
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
	}

?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Insert Post</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style1.css">
		<link rel="stylesheet" href="css/style2.css">
	</head>

	<body>
		<?php include_once("navbar.php"); ?>

		<div class="container">
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="m-auto" style="max-width:600px" enctype="multipart/form-data">
				<h3 class="my-4">Insert Post</h3>
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="title2" class="col-md-5 col-form-label">Post Title</label>
					<div class="col-md-7"><input type="text"  class="form-control form-control-lg" id="title2" name="title" required placeholder="Enter Post Title"></div>
				</div>
                
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="content4" class="col-md-5 col-form-label">Content</label>
					<div class="col-md-7"><textarea   class="form-control form-control-lg" id="content4" name="content" required placeholder="Enter Content"></textarea></div>
				</div>
                
                <hr class="my-4" />
				<div class="form-group mb-3 row"><label for="featured" class="col-md-5 col-form-label">Featured</label>
					<div class="col-md-7"><input type="checkbox"  id="featured" name="featured"></div>
				</div>

				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="published" class="col-md-5 col-form-label">Published</label>
					<div class="col-md-7"><input type="checkbox"  id="published" name="published"></div>
				</div>
				
				<hr class="my-4" />
				<div>
				<label for="image" class="col-md-5 col-form-label">Select Image</label>
					<input type="file" id="image" name="image" accept="image/*">
				</div>

				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="insert10" class="col-md-5 col-form-label"></label>
					<div class="col-md-7"><button class="btn btn-primary btn-lg" name ="submit" type="submit">Insert</button></div>
               </div>
			</form>
		</div>
	</body>

</html>

