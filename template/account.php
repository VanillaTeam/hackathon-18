<?php

if (isset($_POST['do_upload'])) {
    $user = $_POST;

    $errors = array();
    if (trim($_POST['login']) == '') {
        $errors[0] = 'Логин не введён!';
    } else {
        $id = $DB->GetUserID(trim($_POST['login']));
        if ($id && $id != $_SESSION['logged_user']) {
            $errors[8] = 'Пользователь существует!';
        }
    }
    if (trim($_POST['name']) == '') {
        $errors[1] = 'Название организации не введёно!';
    }
    if (trim($_POST['inn']) == '') {
        $errors[2] = 'ИНН не введён!';
    }
    if (trim($_POST['email']) == '') {
        $errors[3] = 'Email не введён!';
    }
    if (trim($_POST['phone']) == '') {
        $errors[4] = 'Номер телефона не введён!';
    }
    if (trim($_POST['address']) == '') {
        $errors[5] = 'Адрес организации не введён!';
    }
    if (empty($errors)) {
        $DB->UpdateUser($_SESSION['logged_user'],
            trim($_POST['login']),
            trim($_POST['name']),
            trim($_POST['inn']),
            trim($_POST['email']),
            trim($_POST['phone']),
            trim($_POST['address']));
        $errors[9] = 'Изменения сохранены!';

        if (trim($_POST['password']) != '')
            if (trim($_POST['password']) != trim($_POST['password_2'])) {
                $errors[7] = 'Пароли не совпадают!';
            } else {
                $DB->UpdateUserPassword($_SESSION['logged_user'], trim($_POST['password']));
                $errors[9] = 'Изменения сохранены!';
            }
    }
} else {
    $user = $DB->GetUser($_SESSION['logged_user']);
}


include $HTML_STATIC_FOLDER . '/account.html';
?>