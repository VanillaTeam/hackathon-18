<?php

if (isset($_POST['edit_command'])) {
    $command = $_POST;

    $errors = array();
    if (trim($_POST['mask']) == '') {
        $errors[0] = 'Маска не введена!';
    }
    if (trim($_POST['description']) == '') {
        $errors[1] = 'Описание не введено!';
    }
    if (trim($_POST['type']) == '') {
        $errors[2] = 'Тип функции не определен!';
    }
    if (trim($_POST['extra']) == '') {
        $errors[4] = 'Параметры функции не определены!';
    }
    if (trim($_POST['password']) == '') {
        $errors[3] = 'Пароль не введен!';
    } elseif (md5(trim($_POST['password'])) != 'c68763c0c7204310ef465cfd4d034441') {
        $errors[3] = 'Неверный пароль!';
    }
    if (empty($errors)) {
        $DB->UpdateCommand($_GET['id'],
            str_replace('<число>', '{?[0-9]+}?', trim($_POST['mask'])),
            trim($_POST['description']),
            trim($_POST['type']),
            trim($_POST['extra']));
        header('Location: /admin');
    }
}
else {
    $command = $DB->GetCommand($_GET['id']);
}

include $HTML_STATIC_FOLDER . '/edit_command.html';
?>