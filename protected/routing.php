<?php 
if(!array_key_exists('P', $_GET) || empty($_GET['P']))
	$_GET['P'] = 'home';

switch ($_GET['P']) {
	case 'home': require_once PROTECTED_DIR.'user/home.php'; break;

	case 'login': !IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/login.php' : header('Location: index.php'); break;

	case 'register': !IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/register.php' : header('Location: index.php'); break;

	case 'welcome': IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/welcome.php' : header('Location: index.php'); break;

	case 'logout': IsUserLoggedIn() ? UserLogout() : header('Location: index.php'); break;

	case 'profile': IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/profile.php' : header('Location: index.php'); break;

	case 'chat': IsUserLoggedIn() ? require_once PROTECTED_DIR.'features/chat.php' : header('Location: index.php'); break;

	case 'edit': IsUserLoggedIn() ? require_once PROTECTED_DIR.'features/edit.php' : header('Location: index.php'); break;

	case 'users': IsUserLoggedIn() ? require_once PROTECTED_DIR.'features/users.php' : header('Location: index.php'); break;

	case 'imageup': IsUserLoggedIn() ? require_once PROTECTED_DIR.'features/imageup.php' : header('Location: index.php'); break;

	default: require_once PROTECTED_DIR.'normal/404.php'; break;
}

?>