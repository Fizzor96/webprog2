<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="#">GGWPEZ</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php">Home</a>
      <?php if(!IsUserLoggedIn()) : ?>
      	<a class="nav-item nav-link text-warning" href="index.php?P=login">Login</a>
      	<a class="nav-item nav-link text-danger" href="index.php?P=register">Register</a>
      <?php else : ?>
        <a class="nav-item nav-link" href="index.php?P=welcome">Welcome</a>
        <a class="nav-item nav-link" href="index.php?P=chat&A=''&S=0">Chat</a>
        <a class="nav-item nav-link" href="index.php?P=profile&A=''&S=0">Profile</a>
        <a class="nav-item nav-link" href="index.php?P=users&A=''&S=0">Users</a>
        <!--<a class="nav-item nav-link text-warning" href="index.php?P=imageup">ImageUP</a> -->

        

        <?php if(isset($_SESSION['permission']) && $_SESSION['permission'] >= 1) : ?>
          <a class="nav-item nav-link disabled" href="#">|</a>
          <a class="nav-item nav-link text-warning" href="index.php?P=users&A=''&S=0">Users</a>
		<?php endif; ?>
		<a class="nav-item nav-link text-danger" href="index.php?P=logout">Logout</a>
      <?php endif; ?>
    </div>
  </div>
</nav>