<?php
if (isset($_SESSION['logged_user'])) header('Location: /');
if (isset($_POST['do_singup'])) {
    $errors = array();
    if (trim($_POST['login']) == '') {
        $errors[0] = 'Логин не введен!';
    }
    if ($DB->GetUserID(trim($_POST['login']))) {
        $errors[8] = 'Пользователь существует!';
    }
    if (trim($_POST['name']) == '') {
        $errors[1] = 'Название не введено!';
    }
    if (trim($_POST['inn']) == '') {
        $errors[2] = 'ИНН не введен!';
    }
    if (trim($_POST['email']) == '') {
        $errors[3] = 'Email не введен!';
    }
    if (trim($_POST['phone']) == '') {
        $errors[4] = 'Номер телефона не введен!';
    }
    if (trim($_POST['address']) == '') {
        $errors[5] = 'Адрес организации не введен!';
    }
    if (trim($_POST['password']) == '') {
        $errors[6] = 'Пароль не введен!';
    }
    if (trim($_POST['password']) != trim($_POST['password_2'])) {
        $errors[7] = 'Пароли не совпадают!';
    }

    if (empty($errors)) {
        $DB->AddUser(trim($_POST['login']),
            trim($_POST['password']),
            trim($_POST['name']),
            trim($_POST['inn']),
            trim($_POST['email']),
            trim($_POST['phone']),
            trim($_POST['address']));

        $_SESSION['logged_user'] = $DB->GetUserID(trim($_POST['login']));
        header('Location: /');
    }
}
include $HTML_STATIC_FOLDER . '/register.html';
?>