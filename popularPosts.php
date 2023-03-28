<?php
try{
 //*******for displaying popular posts*******//
 $sql  = "SELECT * FROM `posts` WHERE `published` = 1 ORDER BY `views` DESC LIMIT 4;";
 $stmt = $conn->prepare($sql);
 $stmt->execute();
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
?>
<!-- Popular Posts -->
 <h6 class="sidebar-title mt-5 mb-4">Popular Posts</h6>
    <?php foreach($stmt->fetchAll() as $k){
        $id      = $k["id"]; 
        $title   = $k["postTitle"];
        $content = $k["content"];
        $date    = $k["date_created"];
        $views   = $k["views"];
        $image   = $k["image"];
    ?>    
     <div class="card mb-4">
        <a href="single-post.php?id=<?php echo $id;?>" class="overlay-link"></a>  
            <div class="card-header p-0">                                   
                <div class="blog-media">
                  <img src="assets/imgs/<?php echo $image;?>" alt="" class="w-100">
                    <a href="#" class="badge badge-primary">#Lorem</a>      
                </div>  
            </div>
    <div class="card-body px-0">
        <h5 class="card-title mb-2"><?php echo substr("$title",0,30);?>...</h5>   
          <small class="small text-muted"><i class="ti-calendar pr-1"></i><?php echo "The views: ".$views." // ". $date;?>
          </small>
        <p class="my-2"><?php echo substr("$content",0,30,);?> ...</p>
    </div>      
    </div>          
    <?php } ?>
    
    <div class="ad-card d-flex text-center align-items-center justify-content-center">
                    <span href="#" class="font-weight-bold">ADS</span>
                </div>
            </div>
        </div>
    </div>
             
 <!-- End of Popular Posts -->