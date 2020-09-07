<?php require('partials/head.php'); ?>
<div style='margin-bottom:300px !important;'>
</div>

<!-- PAGINATOR -->
<div class='col-12'>
        <?= $paginator ?>
    </div>
<!-- <h1>View tekstova po kategoriji</h1> -->
    
<?php
    $lang = $_SESSION['lang'];  
    $uri = $_REQUEST['page'];
    // die(var_dump(stripos($uri,'4')));
?>

<!-- Search bar -->
<div class="row mb-2 mt-2">
    <div class="col-12">
        <form action="/user/search/post/category/{<?php echo $lang?>}/{<?php echo $id?>}/{1}" method = "POST" class="row" >
            <div class="col-9">
                <input type="text" name="search" class="form-control">
            </div>
            <div class="col-3">
                <select id="language" name="language" class="custom-select custom-select-md mb-3">
                    <option value="en" <?php if( $lang == 'en') { echo 'selected';}?> >en</option>
                    <option value="sr" <?php if( $lang == 'sr') { echo 'selected';}?> >sr</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" name="submit_search" class="btn btn-info w-100"><i class="fab fa-searchengin fa-2x"></i> <?php echo $_SESSION['wordsArray']['search'] ?></button>
            </div>
        </form>
    </div>
</div>
<div class='row text-center'>
    <?php echo $errorMsg ?? '' ?>
</div>


<!-- Categories menu NEEEEEEEEEEEEEEEEEEEEEEEEEEEEWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW -->
    <div class="list-group mb-3 ml-2 text-center flex-row my-wrap">
        <a href="/blog/%7B<?php echo $lang ?>%7D/%7B1%7D#category_all" class="list-group-item list-group-item-action"><i class="far fa-arrow-alt-circle-right"></i> <?php echo $_SESSION['wordsArray']['all'] ?></a>
        
        <?php foreach($categories as $category) : ?>
            <?php if(strpos($uri,$category->id_category) !== false && stripos($uri,$category->id_category) == 15 ) : ?>
                <a href='/category/%7B<?=$lang?>%7D/%7B<?=$category->id_category?>%7D/%7B1%7D' class='list-group-item list-group-item-action active bg-info' ><i class="far fa-arrow-alt-circle-right"></i> <?=$category->category_name?></a>
            <?php else : ?>
                <a href='/category/%7B<?=$lang?>%7D/%7B<?=$category->id_category?>%7D/%7B1%7D' class='list-group-item list-group-item-action' ><i class="far fa-arrow-alt-circle-right"></i> <?=$category->category_name?></a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>



<!-- Aside menu and post section -->
<div class='row'>
    <div class="col-3">
    <!-- aside menu - categories -->
        <div class="list-group mt-5 ml-2 text-center">
            <a href="/blog/%7B<?php echo $lang ?>%7D" class="list-group-item list-group-item-action active"><i class="far fa-arrow-alt-circle-right"></i> <?php echo $_SESSION['wordsArray']['all'] ?></a>
            <?php foreach($categories as $category) : ?>
                <a href='/category/%7B<?=$lang?>%7D/%7B<?=$category->id_category?>%7D' class='list-group-item list-group-item-action' ><i class="far fa-arrow-alt-circle-right"></i> <?=$category->category_name?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- post view section -->
    <div class="col-9" >
        <div class="row">
            <?php foreach($posts as $post) : ?>
                <div class="col-4">
                    <img class="rounded" src='/<?= $post->post_widget ?>'>
                </div>
                <div class="col-8 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <?php
                                $curentTime = time();
                            ?>
                            <?php if( $curentTime - $post->post_time <= 7200 ) : ?>
                                <span class="alert-success rounded p-2"> <i class="far fa-star"></i> NEW</span>
                            <?php endif; ?>
                            <h3><a href='/text/%7B<?= $lang ?>%7D/%7B<?= $post->id ?>%7D'> <?= $post->post_name ?> </a></h3>
                        </div>
                        <div class="card-body">
                            <!-- <h5 class="card-title">Special title treatment</h5> -->
                            <p class="card-text"><?= $post->post_review ?></p>
                            <small><?= $_SESSION['wordsArray']['post_author'] ?> : <?= $post->post_author ?></small>
                            <hr>
                            <small><?= $_SESSION['wordsArray']['post_published'] ?> : 
                                <?php
                                    $time = date('H:i:s',strtotime($post->post_created_at));
                                    $date = date('Y-m-d',strtotime($post->post_created_at));
                                    echo $time . ' / ' . $date;      
                                ?>
                            </small>
                            <br>
                            <small><?= $_SESSION['wordsArray']['post_category'] ?> : <?= $post->category_name ?></small>
                            <br>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>
</div>

<?php require('partials/footer.php'); ?>
