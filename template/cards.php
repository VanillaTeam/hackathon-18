<?php

$cards = $DB->GetCards($_SESSION['logged_user']); 
include $HTML_STATIC_FOLDER . '/cards.html';
?>