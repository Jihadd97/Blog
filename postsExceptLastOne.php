<?php
try{
    //*******for displaying the posts except the last entered one*******//
    $sql  = "SELECT * FROM `posts` WHERE `id` !=(SELECT MAX(`id`) FROM `posts`) AND `published` = 1 ORDER BY `date_created` DESC  ;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
?>

<!-- Other Posts -->
        <div class="row">  
                <?php foreach($stmt->fetchAll() as $k){
                    $id      = $k["id"]; 
                    $title   = $k["postTitle"];
                    $content = $k["content"];
                    $date    = $k["date_created"];
                    $image   = $k["image"];
                 ?>                     
                    <div class="col-lg-6">
                        <div class="card text-center mb-5">
                            <div class="card-header p-0">                                   
                                <div class="blog-media">
                                    <img src="assets/imgs/<?php echo $image;?>" alt="<?php echo $title;?>" class="w-100">
                                    <a href="#" class="badge badge-primary">#Placeat</a>        
                                </div>  
                            </div>
                            <div class="card-body px-0">
                                <h5 class="card-title mb-2"><?php echo $title;?></h5>    
                                <small class="small text-muted"><?php echo $date;?>
                                    <span class="px-2">-</span>
                                    <a href="#" class="text-muted">34 Comments</a>
                                </small>
                                <p class="my-2"><?php echo substr("$content",0,50,);?></p>
                            </div>
                            
                            <div class="card-footer p-0 text-center">
                                <a href="single-post.php?id=<?php echo $id;?>" class="btn btn-outline-dark btn-sm">READ MORE</a>
                            </div>                  
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <button class="btn btn-primary btn-block my-4">Load More Posts</button>
            </div>
        <!-- End of Other Posts -->