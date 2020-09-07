<!-- header -->
<?php require('partials/head.php'); ?>

<!-- start container div carouselExampleIndicators
carousel -->
<div class="container-fluid m-0 p-0" style="margin-top: 56px !important;">

    <!-- showcase carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="cover-color"></div>
                <img class="d-block w-100" src="https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/spa-woman-female-enjoying-massage-in-spa-centre-royalty-free-image-492676582-1549988720.jpg" alt="First slide">
                <div class="carousel-caption d-none d-md-block text-secondary anime">
                    <h1 class="display-4">First slide label</h1>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
            <div class="carousel-item">
                <div class="cover-color"></div>
                <img class="d-block w-100" src="https://i0.wp.com/cdn-prod.medicalnewstoday.com/content/images/articles/325/325288/types-of-massage-hot-stone.jpg?w=1155&h=1541" alt="Second slide">
                <div class="carousel-caption d-none d-md-block anime">
                    <h1 class="display-4">Second slide label</h1>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
            <div class="carousel-item">
                <div class="cover-color"></div>
                <img class="d-block w-100" src="https://img.grouponcdn.com/seocms/hRWqXBksRDjQuZu2gtQhsGMjAeS/hot-stone-massage_jpeg-600x390" alt="Third slide">
                <div class="carousel-caption d-none d-md-block anime">
                    <h1 class="display-4">Third slide label</h1>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <i class="fas fa-chevron-left slick-arrow" aria-hidden="true"></i>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <i class="fas fa-chevron-right slick-arrow"></i>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- newsletter heading -->
    <div class='row'>
        <div class="col-12 alert bg-dark text-light  myBorderColor">
            <h4 class="text-center"> <?php echo $_SESSION['wordsArray']['heading'] ?></h4>
        </div>
    </div>

    <!-- newsletter form -->
    <form class="row align-items-center w-50 m-auto pt-5 pb-5" action="/newsletter/{<?php echo $_SESSION['lang']?>}" method="POST" id="newsletter">
        <div class="col-sm-8 text-center">
            <div class="form-group">
                <label for="exampleInputEmail1"> <?php echo $_SESSION['wordsArray']['newsletter_check'] ?> </label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $_SESSION['wordsArray']['newsletter_email'] ?>">
                <i class="far fa-envelope" style="position:absolute; top:40%; right: 10%;"></i>
                <small id="emailHelp" class="form-text text-muted"><?php echo $_SESSION['wordsArray']['newsletter_info'] ?></small>
            </div>
        </div>
        <div class="col-sm-4 text-center">
            <button type="submit" class="btn btn-primary bg-info margin" style="margin-bottom: 6px;"><?php echo $_SESSION['wordsArray']['newsletter_register'] ?></button>
        </div>
        
        <?php echo $error ?? '' ?>
        
        <?php echo $successMsg ?? '' ?>

        <?php //echo $errors['email'] ?? '' ?>
        
    </form>


    <!-- Our services area -->
    <div id="services" class='row text-center myBorderColor'>
        <div class="col-12 alert bg-dark text-light">
            <h4 class="text-center"> <?php echo $_SESSION['wordsArray']['ourServices'] ?> </g3>
        </div>
        <div class="col-12 text-center justify-content-center">
            <div class="card-group justify-content-center">
                <div class="row col-xl-6 col-lg-12 col-md-6 col-sm-12 justify-content-center margin-auto">
                    <div class="card align-items-center col-lg-6 col-md-12 col-sm-12 pt-3">
                        <img class="card-img-top rounded-circle w-75" src="/public/img/RelaxMassage.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"> <?php echo $_SESSION['wordsArray']['relax'] ?> </h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        </div>
                        
                    </div>
                    <div class="card align-items-center col-lg-6 col-md-12 col-sm-12 pt-3">
                        <img class="card-img-top rounded-circle w-75" src="/public/img/Chiropractic.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"> <?php echo $_SESSION['wordsArray']['chiropractic'] ?> </h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                        </div>
                    </div>
                </div>
                <div class="row col-xl-6 col-lg-12 col-md-6 col-sm-12 justify-content-center margin-auto">
                    <div class="card align-items-center col-lg-6 col-md-12 col-sm-12 pt-3">
                        <img class="card-img-top rounded-circle w-75" src="/public/img/SportsMassage.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"> <?php echo $_SESSION['wordsArray']['sport'] ?> </h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                        </div>
                        
                    </div>
                    <div class="card align-items-center col-lg-6 col-md-12 col-sm-12 pt-3">
                        <img class="card-img-top rounded-circle w-75" src="/public/img/TherapyMassage.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"> <?php echo $_SESSION['wordsArray']['therapy'] ?> </h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 align-center">
            <button type="button" class="btn btn-info mt-3"> <?php echo $_SESSION['wordsArray']['moreAbout'] ?> </button>
        </div>   
    </div>

    <hr>

    <!-- About us section-->
    <div class="row  myBorderColor" id="about">
        <div class="col-12 alert bg-dark text-light">
            <h4 class="text-center"> <i class="fas fa-info-circle pr-3 pl-3"></i>  <?php echo $_SESSION['wordsArray']['about_us'] ?> </h4>
        </div>
        <div class="col-lg-10 col-sm-12 m-auto">
            <p> Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC.</p> 
            
            <p>This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

    The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
        </div>
    </div>

    <!-- Contact us section email-->
    <div class="row" id="contact">
        <div class="col-12 alert bg-dark text-light myBorderColor">
            <h4 class="text-center"> <?= $_SESSION['wordsArray']['send_msg'] ?></h4>
        </div>
        <div class="col-lg-4 col-sm-12 d-flex">
            <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                <div>
                    <p><i class="fas fa-mobile-alt pr-3 pl-3" ></i> <?= $_SESSION['wordsArray']['mobile_phone'] ?> : +64 333 555</p>
                    <p><i class="fas fa-envelope pr-3 pl-3"></i> <?= $_SESSION['wordsArray']['email'] ?> : mirko@mirko.com</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-sm-12">

            <form class="row d-flex align-items-center w-75 m-auto justify-content-center" action="/guest/send/email/{<?php echo $_SESSION['lang']?>}" method="POST" id="email">
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control mt-2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $_SESSION['wordsArray']['newsletter_email'] ?>">
                        <?php echo $errors['e_mail'] ?? '' ?>
                        <?php echo $errors['email_val'] ?? '' ?>
                        <textarea cols="30" rows="5" name="message" class="form-control mt-2" placeholder="<?= $_SESSION['wordsArray']['message'] ?>"></textarea>
                        <?php echo $errors['message'] ?? '' ?>
                    </div>
                </div>
                <div class="col-sm-12 d-flex align-items-center w-75 m-auto justify-content-center">
                    <button type="submit" class="btn btn-primary bg-info mb-2"><?= $_SESSION['wordsArray']['mail_btn'] ?></button>
                </div>
                <p class="text-center"> <?= $_SESSION['wordsArray']['notification'] ?></p>
            </form>


            
        </div>
    </div>

<!-- end container div -->
</div>

<!-- footer -->
<?php require('partials/footer.php'); ?>
