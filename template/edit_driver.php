<?php

if (isset($_POST['edit_driver'])) {
    $driver = $_POST;
    $errors = array();
    if (trim($_POST['name']) == '') {
        $errors[0] = 'ФИО водителя не введены!';
    }
    if (trim($_POST['passport']) == '') {
        $errors[1] = 'Серия и номер паспорта не введены!';
    }
    if (empty($errors)) {
        $DB->UpdateDriver($_GET['id'],
            $_SESSION['logged_user'],
            trim($_POST['name']),
            trim($_POST['passport']));
        header('Location: /drivers');
    }
}else{
    $driver = $DB->GetDriver($_GET['id']);
}
include $HTML_STATIC_FOLDER . '/edit_driver.html';
?>