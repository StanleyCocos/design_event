<?php

final class Frame {

	public static function run() {
		self::initConfig();
		self::initLog();
		self::initRoute();
		self::initConst();
		self::initAutoLoad();
		self::initDispatch();
	}

	private static function initConfig() {
		$config = require_once './Config/Config.php';
		define('DB_HOST', $config['db_host']);
		define('DB_USER', $config['db_user']);
		define('DB_PASS', $config['db_pass']);
		define('DB_NAME', $config['db_name']);
		define('DB_CHARSET', $config['charset']);
		define('DEF_CTR', $config['default_controller']);
		define('DEF_ACT', $config['default_action']);
		// deifne('APP_DEBUG', $config['app_debug']);
	}

	private static function initLog() {
		if (1) {
			error_reporting(true);
			ini_set('display_errors', 'On');
		} else {
			error_reporting(0);
			ini_set("display_errors", "Off");
			ini_set("log_errors", "On");
		}
	}

	private static function initRoute() {
		$controller = isset($_GET['c']) ? $_GET['c'] : DEF_CTR;
		$action = isset($_GET['a']) ? $_GET['a'] : DEF_ACT;
		define('CONTROLLER', $controller);
		define('ACTION', $action);
	}

	private static function initConst() {
		define('DS', DIRECTORY_SEPARATOR);
		define('ROOT_PATH', getcwd() . DS);
		define('FRAME_PATH', ROOT_PATH . 'Frame' . DS);
		define('CONTROLLER_PATH', ROOT_PATH . 'Application' . DS . 'Controller' . DS);
		define('MODEL_PATH', ROOT_PATH . 'Application' . DS . 'Model' . DS);
		define('VIEW_PATH', ROOT_PATH . 'Application' . DS . 'View' . DS . CONTROLLER . DS);
	}

	private static function initAutoLoad() {
		spl_autoload_register(function ($className) {
			//类文件路径数组
			$arr = array(
				FRAME_PATH . "$className.class.php",
				MODEL_PATH . "$className.class.php",
				CONTROLLER_PATH . "$className.class.php",
			);
			//循环数组
			foreach ($arr as $filename) {
				//如果类文件路径存在，则包含
				if (file_exists($filename)) {
					require_once ($filename);
				}
			}
		});
	}

	private static function initDispatch() {
		$controllerClassName = CONTROLLER . "Controller";
		$controller = new $controllerClassName();
		$action = ACTION;
		$controller->$action();
	}

}
