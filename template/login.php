<?php
if(isset($_SESSION['logged_user'])) header('Location: /');
if(isset($_POST['do_login'])){
	$errors = [];
	$user = $DB->GetUserID(trim($_POST['login']));
	if(!$user) {
		$errors[0] = 'Пользователь не найден!';
	} elseif (!$DB->GetUserID(trim($_POST['login']), trim($_POST['password']))) {
		$errors[0] = 'Неверный пароль!';
	} else {
		$_SESSION['logged_user'] = $user;
		header('Location: /');
	}
}
include $HTML_STATIC_FOLDER . '/login.html';
?>