<?php
if (isset($_POST['add_car'])) {
    $errors = array();
    if (trim($_POST['model']) == '') {
        $errors[0] = 'Модель не введена!';
    }
    if (trim($_POST['number']) == '') {
        $errors[1] = 'Номер не введён!';
    }
    if (trim($_POST['mileage']) == '') {
        $errors[2] = 'Пробег не введён!';
    }
    if (empty($errors)) {
        $DB->AddCar($_SESSION['logged_user'],
            trim($_POST['model']),
            trim($_POST['number']),
            trim($_POST['mileage']));
        header('Location: /cars');
    }
}
include $HTML_STATIC_FOLDER . '/add_car.html';
?>