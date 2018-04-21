<?php
/**
 * File: index.php
 *
 * @copyright 2018 Vanilla
 * @author Vanilla Team
 * @version 0.1
 * @package Hackathon
 *
 */

require_once 'config.php';

try {
	// Загрузка страницы
	$REQUEST = new Router($_SERVER['REQUEST_URI']);
	include $HTML_STATIC_FOLDER . '/header.html';
	include $REQUEST->getTemplate();
	include $HTML_STATIC_FOLDER . '/footer.html';
}
catch(Exception $e) {
	$CONSOLE->Error($e->getMessage());
	echo '<div class="message" style="font-size: 30px; width: 100%; padding: 1em; text-align: center; color: red;">' . $e->getMessage() . '</div>';
}
?>