<?php
try{
    //*******for displaying featured posts only*******//
    $sql   = "SELECT * FROM `posts` WHERE `featured` = 1 AND `published` = 1 ORDER BY `date_created` DESC Limit 4 ;";
    $stmt  = $conn->prepare($sql);
    $stmt->execute();
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
?>
<!-- feature posts -->
<div class="container">
        <section>
            <div class="feature-posts">
        
                <a href="" class="feature-post-item">                       
                    <span>Featured Posts</span>
                </a>
        <?php
        
            foreach($stmt->fetchAll() as $k){
                $id    = $k["id"];
                $title = $k["postTitle"];
                $image = $k["image"];            
        ?>
                <a href="single-post.php?id=<?php echo $id;?>"  class="feature-post-item">
                    <img src="assets/imgs/<?php echo $image;?>" class="w-100"  alt="<?php echo $image;?>">
                   <div class= "feature-post-caption"><?php echo $title;?></div>
                </a>
            <?php } ?>

            </div>
        </section>
        <!-- end of feature posts -->