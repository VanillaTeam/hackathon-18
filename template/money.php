<?php
	$money = $DB->GetUserMoney($_SESSION['logged_user']);
	if(isset($_POST['add_money'])){
		$errors = array();

		if($_POST['money'] == 0){
			$errors[0] = 'Сумма не введена!';
		}		if(empty($errors)){
			$money+=$_POST['money'];
			$DB->UpdateUserMoney($_SESSION['logged_user'], $money);
			header('Location: /'); 	
		}
	}
	
	
	include $HTML_STATIC_FOLDER . '/money.html';
?>