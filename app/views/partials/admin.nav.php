<?php
    $uri = $_SERVER['REQUEST_URI'];
    //die(var_dump($uri));
?>

<div class="position-fixed w-100 zindex-fixed" style="z-index:1030; top: 0;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#"><i class="fas fa-users-cog"></i> Admin Dashboard</a>
      <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <?php if(strpos($uri,'add') !== false ) : ?>
              <li class="nav-item active">
            <?php else : ?>
              <li class="nav-item">
            <?php endif; ?>
              <a class="nav-link" href="/add/new/post/{<?php echo $username?>}"><i class="fas fa-user-plus"></i> Add post<span class="sr-only">(current)</span></a>
            </li>
            <?php if(strpos($uri,'en') !== false ) : ?>
              <li class="nav-item active">
            <?php else : ?>
              <li class="nav-item">
            <?php endif; ?>
              <a class="nav-link" href="/en/all/post/{<?php echo $username?>}/%7B1%7D"><i class="fas fa-file-alt"></i> All posts</a>
            </li>
            <?php if(strpos($uri,'newsletter') !== false ) : ?>
              <li class="nav-item active">
            <?php else : ?>
              <li class="nav-item">
            <?php endif; ?>
              <a class="nav-link" href="/read/all/newsletter/{<?php echo $username?>}/{1}"><i class="fas fa-envelope-open-text"></i> Newsletter list</a></li>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/logout/admin/blog/{<?php echo $username?>}"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
            </li>
        </ul>
    </div>
  </nav>
</div>
