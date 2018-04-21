<?php

$drivers = $DB->GetDrivers($_SESSION['logged_user']); 

include $HTML_STATIC_FOLDER . '/drivers.html';
?>