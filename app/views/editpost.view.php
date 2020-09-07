<?php require('partials/admin.nav.php'); ?>

<!-- success msg -->
<?php
$uri = $_REQUEST['page'];
?>

<!-- heading -->
<div class="container mt-3"  style= "margin-top:70px !important;">

    <?php if(strpos($uri,'finished/edit/post') !== false ) : ?>
        <div class="col-12 alert alert-success" role="alert"><span>Great job, your post is edited!!!</span></div>
    <?php endif; ?>

    <div class="col-12 bg-info w-100 text-center text-white rounded">
        <h5 class="p-2">Edit post</h5>
    </div>
</div>

<?php echo $errorField ?? '' ?> 
<?php echo $errorImg ?? '' ?> 
<?php echo $errorImgFormat ?? '' ?> 
<?php echo $msg_success ?? '' ?> 

<!-- form section -->
<div class="container mt-3 mb-8"  style= "margin-bottom:100px !important;">
    <div class="col-12 rounded">
        <form class="col-12" action="/update/article/{<?php echo $username?>}/{<?php echo $post[0]->id?>}" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputLanguage">Choose language:</label>
                        <select id="language" name="language" class="custom-select custom-select-md mb-3">
                            <option value="en" <?php if( $post[0]->post_language == 'en') { echo 'selected';}?> >En</option>
                            <option value="sr" <?php if( $post[0]->post_language == 'sr') { echo 'selected';}?> >Sr</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="exampleInputCategory">Choose category:</label>
                        <select id="category" name="category" class="custom-select custom-select-md mb-3">
                            <option value="Highlights" <?php if( $post[0]->category_name == 'Highlights') { echo 'selected';} ?>>Highlights</option>
                            <option value="Health" <?php if( $post[0]->category_name == 'Health') { echo 'selected';} ?> >Health</option>
                            <option value="Chiropractic" <?php if( $post[0]->category_name == 'Chiropractic') { echo 'selected';} ?>>Chiropractic</option>
                            <option value="Science" <?php if( $post[0]->category_name == 'Science') { echo 'selected';} ?> >Science</option>
                            <option value="Istaknuto" <?php if( $post[0]->category_name == 'Istaknuto') { echo 'selected';} ?>>Istaknuto</option>
                            <option value="Zdravlje" <?php if( $post[0]->category_name == 'Zdravlje') { echo 'selected';} ?> >Zdravlje</option>
                            <option value="Kiropraktika" <?php if( $post[0]->category_name == 'Kiropraktika') { echo 'selected';} ?> >Kiropraktika</option>
                            <option value="Nauka" <?php if( $post[0]->category_name == 'Nauka') { echo 'selected';} ?> >Nauka</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputAuthor">Author:</label>
                        <input type="text" name="author" class="form-control" value='<?php echo $post[0]->post_author ?>'>
                    </div>
                    <div class="col-6">
                        <label for="exampleInputFile">Insert widget picture:</label>
                        <div class="custom-file">
                            <input value='<?php echo $post[0]->post_widget ?>' type="file" class="custom-file-input" id="customFile" name="image_widget" accept="image/*' ">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputHeading">Heading:</label>
                <input type="text" name="heading" class="form-control" value='<?php echo $post[0]->post_name ?>'>
            </div>
            <div class="form-group">
                <label for="exampleInputReview">Post review:</label>
                <input type="text" name="review" class="form-control" value='<?php echo $post[0]->post_review ?>'>
            </div>
            <div class="form-group">
                <label for="exampleInputInsert">Insert post content:</label>
                <textarea cols="30" rows="10" name="post" class="form-control"><?php echo $post[0]->post_content ?></textarea>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info btn-sm w-75" name="add_text"><i class="far fa-edit"></i> Upload changes</button>
            </div>
            <hr>
        </form>
    </div>
</div>


<!-- footer section -->
<div class="fixed-bottom">
    <?php require('partials/footer.php'); ?>
</div>