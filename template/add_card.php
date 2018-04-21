<?php
if (isset($_POST['add_card'])) {
    $errors = array();
    if (trim($_POST['max']) == '') {
        $errors[0] = 'Дневной лимит не введён!';
    }

    if (empty($errors)) {
        $DB->AddCard($_SESSION['logged_user'],
            $_POST['type'],
            trim($_POST['max']));
        header('Location: /cards');
    }
}
include $HTML_STATIC_FOLDER . '/add_card.html';
?>