<?php
/**
 * File: Router.php
 *
 * @copyright 2018 Vanilla
 * @author Vanilla Team
 * @version 0.1
 * @package Hackathon
 *
 */

class Router extends ArrayIterator
{	
	private static $routes = [
		'' => 'home',
	];
	
	private $file = '';
	private $params = [];
	
	public function __construct($url) {
		$request = explode('/',
			trim( 
				preg_replace('/(\?|\#).*$/', '', $url),
			'/')
		);
		$this->makeRoute($request[0]);
		
		global $TEMPLATE_FOLDER;
		$this->file = $TEMPLATE_FOLDER . '/' . $request[0] . '.php';
		if (file_exists($this->file)) {
			for($i = 1; $i < count($request); $i++) {
				$this->params[$i - 1] = $request[$i];
			}
		}
		else {
			throw new Exception('Incorrect URL!');
		}
	}
	
	private function makeRoute(&$name) {
		if (isset(self::$routes[$name])) {
			$name = self::$routes[$name];
		}
	}

	public function getTemplate() {
		return $this->file;
	}

	public function getParams() {
		return $this->params;
	}

	public function getParam($i) {
		return $this->params[$i];
	}
	
	public function offsetGet($offset) {
        return $this->params[$offset];
    }
}
?>