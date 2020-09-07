<?php
$uri = $_REQUEST['page'];
?>

<!-- Email form -->
<div class="container-fluid">

    <div class="row col-12 justify-content-center">
        <?php if(strpos($uri,'password/forgot') !== false ) : ?>
            <div class="col-lg-8 col-md-10 col-sm-12 alert alert-success" role="alert"><span>Check your e-mail!!!</span></div>
        <?php endif; ?>
    </div>

    <div class="col-12 row justify-content-center text-center mt-4">
        <form class="col-lg-6 col-md-10 col-sm-12" action="/submit/email/recover" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1" class="bg-dark text-light rounded p-1 w-100">Insert your email, to recive instructioons!</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name='email'>
                <?php echo $errors['email'] ?? '' ?>
            </div>
            <button type="submit" class="btn btn-info" name="submit_email">Send instructions</button>
            <hr>
        </form>
    </div>

    <div class= "text-center col-lg-8 col-md-10 col-sm-12">
        <?php echo $success ?? '' ?>
    </div>
</div>

<!-- footer section -->
<div class="fixed-bottom">
    <?php require('partials/footer.php'); ?>
</div>