<?php

class Start
{
	static $init;
	
	
	public static function init()
	{
		self::$init = new Psr4AutoloadClass();
		self::$init->register();
		
	}
	
	//���տ�������������Ӧ�ĳ�Ա����
	public static function router()
	{
		//���ó�ʹ��init����
		$_GET['m'] = isset($_GET['m']) ? $_GET['m'] : 'Index';
		
		$action = isset($_GET['a']) ? $_GET['a'] : 'index';
		
		$_GET['a'] = $action;

		$className = 'Controller\\'.ucfirst(strtolower($_GET['m'])).'Controller';

		$controller = new $className();
		

		call_user_func(array($controller,$action));
	}
	

	
	
}

Start::init();