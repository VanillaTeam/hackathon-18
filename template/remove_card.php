<?php
$DB->RemoveCard($_GET['id']);
header('Location: /cards');
?>