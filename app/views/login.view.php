<div class="container-fluid">
    <!-- Login form -->
    <div class="text-center mt-4 col-12 row justify-content-center">
        <form class="col-lg-8 col-md-10 col-sm-12" action="/admin/view/authorized" method="POST">
            <div class="form-group">
                <label for="exampleInputUsername" class="bg-dark text-light rounded p-1 w-100">Username</label>
                <input type="text" class="form-control" placeholder="First name" name='username'>
                <?= $errors['username'] ?? '' ?>
                <!-- <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"> -->
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="bg-dark text-light rounded p-1 w-100">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name='mail'>
                <?= $errors['email'] ?? '' ?>
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="bg-dark text-light rounded p-1 w-100">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name='password'>
                <?= $errors['password'] ?? '' ?>
            </div>
            <button type="submit" class="btn btn-info btn-sm" name='submit'>Login</button>
            <hr>
            <a href="/forgot/password">Forgot password?</a>
        </form>
        <div class= "text-center col-lg-8 col-md-10 col-sm-12">
            <?= $error ?? '' ?>
            <?= $counter ?? '' ?>   
            <?= $time ?? '' ?>    
            <?= $refresh ?? '' ?>   
            <?= $loginMsg ?? '' ?>
        </div>
    </div>
<!-- container ends -->
</div>

<!-- footer section -->
<div class="fixed-bottom">
    <?php require('partials/footer.php'); ?>
</div>
