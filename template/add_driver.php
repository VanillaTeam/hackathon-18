<?php
if (isset($_POST['add_driver'])) {
    $errors = array();
    if (trim($_POST['name']) == '') {
        $errors[0] = 'ФИО не введены!';
    }
    if (trim($_POST['passport']) == '') {
        $errors[1] = 'Серия и номер паспорта не введены!';
    }
    if (empty($errors)) {
        $DB->AddDriver($_SESSION['logged_user'],
            trim($_POST['name']),
            trim($_POST['passport']));
        header('Location: /drivers');
    }
}
include $HTML_STATIC_FOLDER . '/add_driver.html';
?>