<?php require('partials/head.php'); ?>
<?php
    $lang = $_SESSION['lang'];
    foreach($posts as $post)
    {
        $id = $post->category_id;
    }
?>  
<!-- container start -->
<div class="container-fluid m-0 mb-2" style="margin-top: 96px !important;">

    <!-- blog picture section -->
    <div class="row">
        <div class="my-cover">
        </div>
    </div> 

    <!-- welcome to blog section -->
    <div class='row'>
        <div class="col-12 alert myBgGrColor text-light  myBorderColorWhite bg-dark myBorderBotColor" id="category_all">
            <h4 class="text-center"> <?php echo $_SESSION['wordsArray']['welcome_blog'] ?></h4>
        </div>
    </div>

    <!-- Categories menu -->
    <div class="list-group mb-3 ml-2 text-center flex-row my-wrap">
        <a href="/blog/%7B<?php echo $lang ?>%7D/%7B1%7D" class="list-group-item list-group-item-action justify-content-center d-flex"><p class="p-0 m-0 c-menu-p text-left"><i class="far fa-arrow-alt-circle-right pr-2"></i><?php echo $_SESSION['wordsArray']['all'] ?></p></a>
        
        <?php foreach($categories as $category) : ?>
            <?php if($category->id_category == $id) : ?>
              <a href='/category/%7B<?=$lang?>%7D/%7B<?=$category->id_category?>%7D/%7B1>%7D' class='list-group-item list-group-item-action justify-content-center d-flex nav-item bg-info text-light'><p class="p-0 m-0 text-left c-menu-p"><i class="far fa-arrow-alt-circle-right  pr-2"></i> <?=$category->category_name?></p></a>
            <?php else : ?>
                <a href='/category/%7B<?=$lang?>%7D/%7B<?=$category->id_category?>%7D/%7B1>%7D' class='list-group-item list-group-item-action justify-content-center d-flex'><p class="p-0 m-0 text-left c-menu-p"><i class="far fa-arrow-alt-circle-right  pr-2"></i> <?=$category->category_name?></p></a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Post section -->
    <div class='row'>
        <!-- post view section -->
        <div class="col-12" >
            <div class="row  justify-content-center">
                <?php foreach($posts as $post) : ?>
                    <div class="col-xl-7 col-lg-11 col-md-12 col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <?php
                                    $curentTime = time();
                                ?>
                                <?php if( $curentTime - $post->post_time <= 86400 ) : ?>
                                    <span class="alert-success rounded p-2"> <i class="far fa-star"></i> NEW</span>
                                <?php endif; ?>
                                <h3 class="text-center bg-dark text-light rounded p-1"><?= $post->post_name ?></h3>
                                <hr>
                                <div class='text-center bg-white mb-1 rounded p-1'><small> <?= $_SESSION['wordsArray']['post_author'] ?> : <i><?= $post->post_author ?></i> </small></div>
                                <div class='text-center bg-white rounded'><small>Category: <i><?= $post->category_name ?></i></small></div>
                            </div>
                            <img class="rounded m-auto mt-3" style="max-width: 90%;" src='/<?= $post->post_widget ?>'>
                            <div class="card-body">
                                <!-- <h5 class="card-title">Special title treatment</h5> -->
                                <p class="card-text text-center bg-light rounded"><?= $post->post_content ?></p>
                                
                                <hr>
                                <small>
                                <?= $_SESSION['wordsArray']['post_published'] ?> : 
                                <?php
                                    $time = date('H:i:s',strtotime($post->post_created_at));
                                    $date = date('Y-m-d',strtotime($post->post_created_at));
                                    echo '<i>' . $time . ' / ' . $date . '</i>';      
                                ?>
                                
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>  
        </div>
    </div>

    <!-- related text -->
    <div class='row text-center col-12 m-auto'>
        <div class="col-12 bg-dark rounded "   style='margin-bottom:18px !important;'>
            <h5 class="text-center text-light p-1"> Related text </h5>
        </div>
        <!-- <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 m-auto"> -->
            <div class="card-group col-xl-12 col-lg-12 col-md-12 flex-md-column flex-lg-row flex-sm-column col-sm-12 justify-content-center">
                <?php foreach($related_posts as $post) : ?>
                    <div class="card col-xl-4 col-lg-6 col-md-11 col-sm-12" style='margin-left:5px !important;margin-bottom:5px !important; '>
                        <!-- <img class="card-img-top rounded-circle" src="https://pngimg.com/uploads/linkedIn/linkedIn_PNG36.png" alt="Card image cap"> -->
                        <div class="card-body">
                                <?php if( $curentTime - $post->post_time <= 86400 ) : ?>
                                    <span class="alert-success rounded p-2"> <i class="far fa-star"></i> <?= $_SESSION['wordsArray']['new'] ?> </span>
                                <?php endif; ?>
                            <h5 class="text-center rounded p-1">
                                <a href='/text/%7B<?= $lang ?>%7D/%7B<?= $post->id ?>%7D' class="text-secondary"> <?= $post->post_name ?> </a>
                            </h5>
                            <img class="rounded m-auto" style="max-width: 324px;" src='/<?= $post->post_widget ?>'>
                            
                            <p class="card-text text-center bg-light rounded mt-3"><?= $post->post_review ?></p>
                        </div>
                        <div class="card-footer"> 
                            <small><?= $_SESSION['wordsArray']['post_author'] ?> : <i><?= $post->post_author ?></i> </small>
                            <br>
                            <small><?= $_SESSION['wordsArray']['post_published'] ?> : 
                                <?php 
                                    $time = date('H:i:s',strtotime($post->post_created_at));
                                    $date = date('Y-m-d',strtotime($post->post_created_at));
                                    echo '<i>' .  $time . ' / ' . $date . '</i>'; 
                                ?>
                            </small>
                            <br>
                            <small><?= $_SESSION['wordsArray']['post_category'] ?> : <i><?= $post->category_name ?></i></small>
                            <p class="bg-info btn-sm rounded p-2 col-md-4 col-sm-12 text-center ml-auto mr-auto mt-3"><a class="text-white" href='/text/%7B<?= $lang ?>%7D/%7B<?= $post->id ?>%7D'>Read text <i class="fab fa-readme"></i></a></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <!-- </div>  -->
    </div>

<!-- container end -->
</div>

<?php require('partials/footer.php'); ?>
