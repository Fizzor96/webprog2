<?php session_start(); ?>
<?php require_once 'protected/config.php'; ?>
<?php require_once USER_MANAGER; ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Beadandó</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/style.css" type="text/css">
	<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
</head>
<body>
	<nav><?php require_once PROTECTED_DIR.'nav.php'; ?></nav>
	<div class="body-content">
		<content class=""><?php require_once PROTECTED_DIR.'routing.php'; ?></content>
		<footer id="footer"><?php include_once PROTECTED_DIR.'footer.php'; ?></footer>
	</div>
</body>
</html>