<?php
    $uri = $_SERVER['REQUEST_URI'];
    //die(var_dump($uri));
?>

<div class="position-fixed w-100 zindex-fixed" style="z-index:1030; top: 0;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#"><i class="fas fa-blog"></i> Massage</a>
      <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0 text-center">
            <?php if(strpos($uri,'homepage') !== false ) : ?>
              <li class="nav-item active">
            <?php elseif( strpos($uri,'homepage') === false && strpos($uri,'blog') === false && strpos($uri,'category') === false && strpos($uri,'text') === false ) : ?>
              <li class="nav-item active">
            <?php else : ?>
              <li class="nav-item">
            <?php endif; ?>
              <a class="nav-link" href="/homepage/{<?php echo $_SESSION['lang']?>}"> <i class="fas fa-house-user"> </i> <?= $_SESSION['wordsArray']['homepage'] ?><span class="sr-only">(current)</span></a>
            </li>
            <?php if(strpos($uri,'blog') !== false || strpos($uri,'category') !== false || strpos($uri,'text') !== false ) : ?>
              <li class="nav-item active">
            <?php else : ?>
              <li class="nav-item">
            <?php endif; ?>
              <a class="nav-link" href="/blog/{<?php echo $_SESSION['lang']?>}/{1}"><i class="fas fa-blog"></i> <?= $_SESSION['wordsArray']['blog'] ?></a>
            </li>
            <?php if(strpos($uri,'#services') !== false ) : ?>
              <li class="nav-item active">
            <?php else : ?>
              <li class="nav-item">
            <?php endif; ?>
              <a class="nav-link" href="/homepage/{<?php echo $_SESSION['lang']?>}/#services"><i class="fas fa-house-user"></i> <?= $_SESSION['wordsArray']['services'] ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/homepage/{<?php echo $_SESSION['lang']?>}/#contact"><i class="fas fa-phone-square-alt"></i> <?= $_SESSION['wordsArray']['contact'] ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/homepage/{<?php echo $_SESSION['lang']?>}/#about"><i class="fas fa-info-circle"></i> <?= $_SESSION['wordsArray']['about_us'] ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/homepage/{<?php echo $_SESSION['lang']?>}/#newsletter"><i class="fas fa-envelope-open-text"></i> <?= $_SESSION['wordsArray']['newsleter'] ?></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-europe"></i> <?= $_SESSION['wordsArray']['choose'] ?></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/homepage/{en}"> <i class="fas fa-angle-double-right"></i> <?php echo $_SESSION['wordsArray']['english'] ?> </a>
                    <div role="separator" class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/homepage/{sr}"> <i class="fas fa-angle-double-right"></i> <?php echo $_SESSION['wordsArray']['serbian'] ?></a>
                </div>
            </li>
        </ul>
    </div>
  </nav>
  <div class="row align-items-center  justify-content-center bg-white" style="height: 40px; display:none">
    <div class="col-5">
      <p class='text-secondary pl-3 text-right'> <?= $_SESSION['wordsArray']['folowUs'] ?> </p>
    </div>
    <div class="divider mb-3"> </div>
    <div class="col-5">
      <p class='pl-3'>
        <a href="https://www.facebook.com/aleksandra.grujic.7547" target="_blank"><i class="fab fa-facebook-square fa-2x"></i></a> 
        <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
      </p>
    </div>
  </div>
</div>
