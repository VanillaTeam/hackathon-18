<?php
$DB->RemoveCommand($_GET['id']);
header('Location: /commands');
?>