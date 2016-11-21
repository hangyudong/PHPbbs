<?php

class Start
{
	static $init;
	
	
	public static function init()
	{
		self::$init = new Psr4AutoloadClass();
		self::$init->register();
		
	}
	
	//按照控制器、找下面应的成员方法
	public static function router()
	{
		//放置初使化init里面
		$_GET['m'] = isset($_GET['m']) ? $_GET['m'] : 'Index';
		
		$action = isset($_GET['a']) ? $_GET['a'] : 'index';
		
		$_GET['a'] = $action;

		$className = 'Controller\\'.ucfirst(strtolower($_GET['m'])).'Controller';

		$controller = new $className();
		

		call_user_func(array($controller,$action));
	}
	

	
	
}

Start::init();