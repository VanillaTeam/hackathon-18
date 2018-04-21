<?php
$DB->RemoveDriver($_GET['id']);
header('Location: /drivers');
?>