<?php

try{
  //*******for displaying the last post entered*******//
    $sql  = "SELECT `id`,`postTitle`,`content`,`date_created`,`image` FROM `posts` WHERE `published` = 1 ORDER BY `id` DESC LIMIT 1;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
?>
<!-- Last Entered Post -->
<div class="page-container">
            <div class="page-content">
            <?php 
                foreach($stmt->fetchAll() as $k){ 
                    $id      = $k["id"];
                    $title   = $k["postTitle"];
                    $content = $k["content"];
                    $date    = $k["date_created"];
                    $image   = $k["image"];
            ?>
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="card-title"><?php echo $title;?></h5> 
                        <small class="small text-muted"><?php echo $date;?> 
                            <span class="px-2">-</span>
                            <a href="#" class="text-muted">32 Comments</a>
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="blog-media">
                            <img src="assets/imgs/<?php echo $image;?>" alt="<?php echo $title;?>" class="w-100">
                            <a href="#" class="badge badge-primary">#Salupt</a>     
                        </div>  
                        <p class="my-3"><?php echo substr("$content",0,100);?></p>
                    </div>
                    
                    <div class="card-footer d-flex justify-content-between align-items-center flex-basis-0">
                        <button class="btn btn-primary circle-35 mr-4"><i class="ti-back-right"></i></button>
                        <a href="single-post.php?id=<?php echo $id;?>" class="btn btn-outline-dark btn-sm">READ MORE</a>
                        <a href="#" class="text-dark small text-muted">By : Joe Mitchell</a>
                    </div>                  
                </div>
            <?php } ?>
        <!-- end of Last Entered Post -->