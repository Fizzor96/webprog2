<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
  $postData = [
    'username' => $_POST['username'],
    'password' => $_POST['password']
  ];

  if(empty($postData['username']) || empty($postData['password'])) {
    $alert = "Hiányzó adat(ok)!";
  } else if(!UserLogin($postData['username'], $postData['password'])) {
    $alert = "Hibás felhasználónév vagy jelszó!";
  }

  $postData['password'] = "";
}
?>

<div class="">
  <div class="module">
    <h1>Login</h1>
    <form class="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?php if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login']))echo $alert; ?></div>
      <input type="text" placeholder="User Name" name="username" required />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="submit" value="Login" name="login" class="btn btn-block btn-primary" />
    </form>
  </div>
  <div class="module">
  <center><em></em><center>
  </div>
</div>