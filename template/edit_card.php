<?php

if (isset($_POST['edit_card'])) {
	$card = $_POST;
    $errors = array();
    if (trim($_POST['max']) == '') {
        $errors[0] = 'Лимит не установлен!';
    }
    if (empty($errors)) {
        $DB->UpdateCard($_GET['id'], $_SESSION['logged_user'], $_POST['type'], NULL, trim($_POST['max']), NULL);
        header('Location: /cards');
    }
}else{
	$card = $DB->GetCard($_GET['id']);
}
include $HTML_STATIC_FOLDER . '/edit_card.html';
?>