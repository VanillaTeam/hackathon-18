<?php

$cars = $DB->GetCars($_SESSION['logged_user']); 

include $HTML_STATIC_FOLDER . '/cars.html';
?>