<?php  

$block = $DB->GetCard($_GET['id'])['blocked'];
$DB->UpdateCard($_GET['id'], $_SESSION['logged_user'], NULL, NULL, NULL, $block==1 ? 0 : 1);
header('Location: /cards');
?>