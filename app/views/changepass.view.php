<!-- Pss change form form -->
<div class="container-fluid">
    <div class="text-center mt-4 col-12 row justify-content-center">
        <form class="col-lg-6 col-md-10 col-sm-12" action="/change/pwd/new" method="POST">
            <div class="form-group">
                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">
                <label for="exampleInputPassword1" class="bg-dark text-light rounded p-1 w-100">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="pwd">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="bg-dark text-light rounded p-1 w-100">Re-Type Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Re-Type Password" name="re_pwd">
            </div>
            <button type="submit" class="btn btn-info" name="submit_email">Change password</button>
        </form>
    </div>
    <div class= "text-center col-lg-8 col-md-10 col-sm-12 m-auto" style='margin-top: 10px !important;margin-bottom: 10px !important;'>
        <?php echo $errors['password'] ?? '' ?>
    </div>
    <div class= "text-center col-lg-8 col-md-10 col-sm-12 m-auto"  style='margin-top: 10px !important;margin-bottom: 10px !important;'>
        <?php echo $errors['re-password'] ?? '' ?>
    </div>
</div>

    
<!-- footer section -->
<div class="fixed-bottom">
    <?php require('partials/footer.php'); ?>
</div>
