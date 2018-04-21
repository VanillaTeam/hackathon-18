<?php

if (isset($_POST['edit_car'])) {
    $car = $_POST;
    $errors = array();
    if (trim($_POST['model']) == '') {
        $errors[0] = 'Модель не введена!';
    }
    if (trim($_POST['number']) == '') {
        $errors[1] = 'Номер автомобиля не введён!';
    }
    if (trim($_POST['mileage']) == '') {
        $errors[2] = 'Пробег не введён!';
    }
    if (empty($errors)) {
        $DB->UpdateCar($_GET['id'],
            $_SESSION['logged_user'],
            trim($_POST['model']),
            trim($_POST['number']),
            trim($_POST['mileage']));
        header('Location: /cars');
    }
}else{
    $car = $DB->GetCar($_GET['id']);
}
include $HTML_STATIC_FOLDER . '/edit_car.html';
?>