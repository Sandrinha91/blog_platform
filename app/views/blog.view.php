<?php require('partials/head.php'); ?>

<!-- container start -->
<div class="container-fluid m-0 mb-2" style="margin-top: 96px !important;">
    <?php
        $lang = $_SESSION['lang'];
    ?>  

    <!-- blog picture section -->
    <div class="row">
        <div class="my-cover">
        </div>
    </div> 

    <!-- Search bar -->   
    <form action="/search/view/user/check/{<?php echo $lang?>}/{1}" method = "POST" class="row mt-3" >
        <div class ="row col-xl-8 col-lg-8 col-md-8 col-sm-12 m-auto">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <input type="text" name="search" class="form-control mb-3" placeholder="<?php echo $_SESSION['wordsArray']['types_earch'] ?>" value='<?= $search ?? '' ?>'>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <select id="language" name="language" class="custom-select custom-select-md mb-3">
                    <option value="en" <?php if( $lang == 'en') { echo 'selected';}?> >en</option>
                    <option value="sr" <?php if( $lang == 'sr') { echo 'selected';}?> >sr</option>
                </select>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 m-auto">
            <div class="col-12">
                <button type="submit" name="submit_search" class="btn btn-info w-100 mb-3"><i class="fab fa-searchengin"></i> <?php echo $_SESSION['wordsArray']['search'] ?></button>
            </div>
        </div>
    </form>
    <div class='row text-center'>
        <?= $errorMsg ?? '' ?>
    </div>
    
    <!-- Welcome to blog section -->
    <div class='row'>
        <div class="col-12 alert myBgGrColor text-light  myBorderColor" id="category_all">
            <h4 class="text-center"> <?= $_SESSION['wordsArray']['welcome_blog'] ?></h4>
        </div>
    </div>

    <!-- Categories menu -->
    <div class="list-group mb-3 ml-2 text-center flex-row my-wrap">
        <a href="/blog/%7B<?= $lang ?>%7D/%7B1%7D" class="list-group-item list-group-item-action active bg-info justify-content-center d-flex"><p class="p-0 m-0 c-menu-p text-left"><i class="far fa-arrow-alt-circle-right pr-2"></i><?php echo $_SESSION['wordsArray']['all'] ?></p></a>
        
        <?php foreach($categories as $category) : ?>
                <a href='/category/%7B<?=$lang?>%7D/%7B<?=$category->id_category?>%7D/%7B1%7D' class='list-group-item list-group-item-action justify-content-center d-flex'><p class="p-0 m-0 text-left c-menu-p"><i class="far fa-arrow-alt-circle-right  pr-2"></i> <?=$category->category_name?></p></a>
        <?php endforeach; ?>
    </div>

    <!-- PAGINATOR -->
    <div class='col-12'>
        <?= $paginator ?>
    </div>

    <!-- post view section -->
    <div class="row col-xl-10 col-md-12  justify-content-center m-auto">
        <?php foreach($posts as $post) : ?>
            <div class="row col-12 justify-content-center" style="align-items:end;">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <?php
                                $curentTime = time();
                            ?>
                            <?php if( $curentTime - $post->post_time <= 86400 ) : ?>
                                <span class="alert-success rounded p-2"> <i class="far fa-star"></i> <?= $_SESSION['wordsArray']['new'] ?> </span>
                            <?php endif; ?>
                            
                            <h3 class="text-center"><a class="text-secondary" href='/text/%7B<?= $lang ?>%7D/%7B<?= $post->id ?>%7D'> <?= $post->post_name ?> </a></h3>
                        </div>
                        <div class="row pl-2">
                            <div class="col-lg-4 col-sm-12 text-center">
                                <img class="rounded p-4" style="max-width: 324px;" src='/<?= $post->post_widget ?>'>
                            </div>
                            <div class="card-body col-lg-8 col-sm-12 tcenter text-center">
                                <!-- <h5 class="card-title">Special title treatment</h5> -->
                                <p class="card-text hreview"><?= $post->post_review ?></p>
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
                                <p class="bg-info btn-sm rounded p-2 col-md-4 col-sm-12 text-center ml-auto mr-auto mt-3"><a class="text-white" href='/text/%7B<?= $lang ?>%7D/%7B<?= $post->id ?>%7D'>Read text <i class="fab fa-readme"></i></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


</div>

<?php require('partials/footer.php'); ?>
