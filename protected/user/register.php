<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
	$postData = [
		'username' => $_POST['username'],
		'password' => $_POST['password'],
		'email' => $_POST['email'],
		'confirmpassword' => $_POST['confirmpassword']
  ];
  
  $alert;

	if(empty($postData['username']) || empty($postData['email']) || empty($postData['password']) || empty($postData['confirmpassword'])) {
		$alert = "Hiányzó adat(ok)!";
	}  else if(!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
		$alert = "Hibás email formátum!";
	} else if ($postData['password'] != $postData['confirmpassword']) {
		$alert = "A jelszavak nem egyeznek!";
	} else if(strlen($postData['confirmpassword']) < 6) {
		$alert = "A jelszó túl rövid! Legalább 6 karakter hosszúnak kell lennie!";
	} else if(!UserRegister($postData['username'], $postData['password'], $postData['email'])) {
		$alert = "Sikertelen regisztráció! A felhasználónév már foglalt!";
	}

	$postData['password'] = $postData['confirmpassword'] = "";
}
?>



<div class="">
  <div class="module">
    <h1>Create an account</h1>
    <form class="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?php if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) echo $alert ?></div>
      <input type="text" placeholder="User Name" name="username" required />
      <input type="email" placeholder="Email" name="email" required />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
      <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
    </form>
  </div>
  <div class="module">
  <center><em></em><center>
  </div>
</div>