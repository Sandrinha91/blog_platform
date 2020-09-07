<?php require('partials/admin.nav.php'); ?>

<!-- success msg -->
<?php
$uri = $_REQUEST['page'];
?>

<!-- heading -->
<div class="container mt-3"  style= "margin-top:70px !important;">

    <?php if(strpos($uri,'new/post/added') !== false ) : ?>
        <div class="col-12 alert alert-success" role="alert"><span>Great job, your post is added!!!</span></div>
    <?php endif; ?>

    <div class="col-12 bg-info w-100 text-center text-white rounded">
        <h5 class="p-2">Add new post</h5>
    </div>
</div>

<?php echo $errorField ?? '' ?> 
<?php echo $errorImg ?? '' ?> 
<?php echo $errorImgFormat ?? '' ?> 
<?php echo $msg_success ?? '' ?> 


<!-- form section -->
<div class="container mt-3 mb-8" style= "margin-bottom:100px !important;">
    <div class="col-12 rounded">
        <form class="col-12" action="/plus/one/new/post/{<?php echo $username?>}" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputLanguage">Choose language:</label>
                        <select id="language" name="language" class="custom-select custom-select-md mb-3">
                            <option value="en" selected>En</option>
                            <option value="sr">Sr</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="exampleInputCategory">Choose category:</label>
                        <select id="category" name="category" class="custom-select custom-select-md mb-3">
                            <option value="Highlights">Highlights</option>
                            <option value="Health">Health</option>
                            <option value="Chiropractic">Chiropractic</option>
                            <option value="Science">Science</option>
                            <option value="Istaknuto">Istaknuto</option>
                            <option value="Zdravlje">Zdravlje</option>
                            <option value="Kiropraktika">Kiropraktika</option>
                            <option value="Nauka">Nauka</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputAuthor">Author:</label>
                        <input type="text" name="author" class="form-control" placeholder="Insert author name...">
                    </div>
                    <div class="col-6">
                        <label for="exampleInputFile">Insert widget picture:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="image_widget" accept="image/*">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputHeading">Heading:</label>
                <input type="text" name="heading" class="form-control" placeholder="Insert post title......">
            </div>
            <div class="form-group">
                <label for="exampleInputReview">Post review:</label>
                <input type="text" name="review" class="form-control" placeholder="Insert post review......">
            </div>
            <div class="form-group">
                <label for="exampleInputInsert">Insert post content:</label>
                <textarea cols="30" rows="10" name="post" class="form-control"></textarea>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info btn-sm w-75" name="add_text"><i class="fas fa-plus"></i> Add text</button>
            </div>
            <hr>
        </form>
    </div>
</div>

<!-- footer section -->
<div class="fixed-bottom">
    <?php require('partials/footer.php'); ?>
</div>