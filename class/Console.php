<?php
/**
 * File: Console.php
 *
 * @copyright 2018 Vanilla
 * @author Vanilla Team
 * @version 0.1
 * @package Hackathon
 *
 */

class Console {

	public function __construct() {
		define("NL","\r\n");
	}

	public function Debug($str) {
		if ($str) {
			echo '<script type="text/javascript">'.NL;
			echo 'console.debug("' . $str . '");'.NL;
			echo '</script>'.NL;
		}
	}
	
	public function Info($str) {
		if ($str) {
			echo '<script type="text/javascript">'.NL;
			echo 'console.info("' . $str . '");'.NL;
			echo '</script>'.NL;
		}
	}
	
	public function Warn($str) {
		if ($str) {
			echo '<script type="text/javascript">'.NL;
			echo 'console.warn("' . $str . '");'.NL;
			echo '</script>'.NL;
		}
	}

	public function Error($str) {
		if ($str) {
			echo '<script type="text/javascript">'.NL;
			echo 'console.error("' . $str . '");'.NL;
			echo '</script>'.NL;
		}
	}
	
	public function php_log($errno, $errstr, $errfile, $errline) {
		if (!(error_reporting() & $errno)) {
			// Этот код ошибки не включен в error_reporting
			return;
		}
		
		$errstr = addslashes( $errstr );
		$errfile = addslashes( $errfile );
		$errline = addslashes( $errline );
		
		echo '<script type="text/javascript">'.NL;
		switch ($errno) {
		case E_ERROR:
			echo 'console.error("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_PARSE:
			echo 'console.error("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_CORE_ERROR:
			echo 'console.error("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_COMPILE_ERROR:
			echo 'console.error("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_USER_ERROR:
			echo 'console.error("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_USER_ERROR:
			echo 'console.error("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_WARNING:
			echo 'console.warn("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_CORE_WARNING:
			echo 'console.warn("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_COMPILE_WARNING:
			echo 'console.warn("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_USER_WARNING:
			echo 'console.warn("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_DEPRECATED:
			echo 'console.warn("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_USER_DEPRECATED:
			echo 'console.warn("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_NOTICE:
			echo 'console.info("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_USER_NOTICE:
			echo 'console.info("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		case E_STRICT:
			echo 'console.info("' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;

		default:
			echo 'console.error("Unknown ' . $errstr . ' in ' . $errfile . ' on line ' . $errline . '");'.NL;
			break;
		}
		echo '</script>'.NL;

		/* Не запускаем внутренний обработчик ошибок PHP */
		return true;
	}
	
}
?>