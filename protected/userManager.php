<?php 
function IsUserLoggedIn() {
	return $_SESSION  != null && array_key_exists('uid', $_SESSION) && is_numeric($_SESSION['uid']);
}

function UserLogout() {
	session_unset();
	session_destroy();
	header('Location: index.php?P=login');
}

function UserLogin($email, $password) {
	$query = "SELECT id, username, email, permission FROM users WHERE username = :username AND password = :password";
	$params = [
		':username' => $email,
		':password' => sha1($password)
	]; 

	require_once DATABASE_CONTROLLER;
	$record = getRecord($query, $params);
	if(!empty($record)) {
		$_SESSION['uid'] = $record['id'];
		$_SESSION['username'] = $record['username'];
		$_SESSION['email'] = $record['email'];
		$_SESSION['permission'] = $record['permission'];
		header('Location: index.php?P=welcome');
	}
	return false;
}

function UserRegister($username, $password, $email) {
	$query = "SELECT id FROM users username = :username";
	$params = [ ':username' => $username ];

	require_once DATABASE_CONTROLLER;
	$record = getRecord($query, $params);
	if(empty($record)) {
		$query = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
		$params = [
			':username' => $username,
			':password' => sha1($password),
			':email' => $email
		];

		if(executeDML($query, $params)) 
			header('Location: index.php?P=login');
	} 
	return false;
}

?>