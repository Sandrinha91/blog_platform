<?php require('partials/admin.nav.php'); ?>

<!-- Search post by category -->
<div class="container mt-3" style= "margin-top:70px !important;">
        <div class="col-12 bg-light w-100 text-center">
            <h5>Display posts by category</h5>
        </div>
        <div class="col-12">
            <form action="/categories/filter/{<?php echo $username?>}/{1}" method = "POST" class="row" >
                <div class="col-6">
                    <select id="category" name="category" class="custom-select custom-select-md mb-3">
                        <option value="1">Highlights</option>
                        <option value="2">Health</option>
                        <option value="3">Chiropractic</option>
                        <option value="4">Science</option>
                        <option value="0" selected>All</option>
                        <option value="1">Istaknuto</option>
                        <option value="2">Zdravlje</option>
                        <option value="3">Kiropraktika</option>
                        <option value="4">Nauka</option>
                        <option value="0">Sve kategorije</option>
                    </select>
                </div>
                <div class="col-6">
                    <select id="language" name="language" class="custom-select custom-select-md mb-3">
                        <option value="en">en</option>
                        <option value="sr">sr</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" name="submit_search" class="btn btn-info w-100"><i class="fab fa-searchengin"></i> Search</button>
                </div>
            </form>
        </div>
    </div>
</div>
<hr>


<!-- Search post by key word -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <form action="/check/text/{<?php echo $username?>}/{1}" method = "POST" class="row" >
                <div class="col-9">
                    <input type="text" name="search" class="form-control" placeholder="Search post by key word..." value ='<?= $search ?? '' ?>'>
                </div>
                <div class="col-3">
                    <select id="language" name="language" class="custom-select custom-select-md mb-3">
                        <option value="en">en</option>
                        <option value="sr">sr</option>
                    </select>
                </div>
                <div class="col-12">
                    <!-- <buton type="submit" name="submit_search" class="btn btn-info w-100"><i class="fab fa-searchengin"></i> Search</button> -->
                    <input type="submit" name="submit_search" class="btn btn-info w-100" value = "Search">
                </div>
            </form>
        </div>
    </div>
    <?php echo $errorMsg ?? '' ?>
</div>
<hr>

<!-- PAGINATOR -->
    <div class='col-12'>
        <?= $paginator ?>
    </div>

<!-- Table view -->
<div class="container"  style= "margin-bottom:100px !important;">
    <table class="table table-striped mb-3 mt-3">
    <thead class="thead-dark">
        <tr>
            <th scope="col"></th>
            <th scope="col">Title</th>
            <th scope="col">Category</th>
            <th scope="col">Created at</th>
            <th scope="col" colspan='2'>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($posts as $post) : ?>
            <tr>
                <td><span class="bg-white text-info rounded p-1"><?= $numberOfPost ?? '' ?></span></td>
                <td>  
                    <span class="btn p-0" style="cursor:auto;">
                        <?php
                            $curentTime = time();
                        ?>
                        <?php if( $curentTime - $post->post_time <= 300 ) : ?>
                            <i class="fas fa-hand-point-right"></i>
                        <?php endif; ?>
                        
                        <a class="text-info" href='/text/%7B<?= $post->post_language ?>%7D/%7B<?= $post->id ?>%7D' target="_blank"> <?= $post->post_name ?> </a>
                    </span>
                </td>
                <td><span class="btn p-0" style="cursor:auto;"> <a href='/category/%7B<?=$post->post_language?>%7D/%7B<?=$post->id_category?>%7D' class='' target="_blank"><?=$post->category_name ?></a> </span></td>
                <td><span class="btn p-0" style="cursor:auto;"><?=$post->post_created_at ?></span></td>
                <td>
                    <a href='/edit/post/%7B<?=$username?>%7D/%7B<?=$post->id?>%7D/%7B<?=$lang?>%7D' class="text-warning btn p-0 mr-5"><i class="fas fa-edit"></i> Edit post</a>
                
                    <script>
                        var username = "<?=$username?>";
                        var lan = "<?=$lang?>";
                        
                        function reply_click(obj){
                            var post_id = obj.id;
                            
                            if (window.confirm(`Do you want to Delete ${post_id}?`)) 
                                location.href=`/erase/text/%7B${post_id}%7D/%7B${username}%7D/%7B${lan}%7D`;    
                        }
                    </script>
                    <button id="<?=$post->id?>" onclick="reply_click(this); " class="text-danger btn p-0" name="Delete"><i class="fas fa-trash"></i> Delete post</button>
                </td>
                <?php $numberOfPost ++ ?>
            </tr>       
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

<!-- footer -->

<div class="fixed-bottom">
    <?php require('partials/footer.php'); ?>
</div>