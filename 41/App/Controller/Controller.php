<?php
namespace Controller;

use Framework\Tpl;

class Controller extends Tpl
{
	public function __construct()
	{
		parent::__construct(
		$GLOBALS['config']['CACHE_DIR'],
		$GLOBALS['config']['TPL_DIR'],
		$GLOBALS['config']['CACHE_TIME']);
	}
	
	public function error($message, $url = null, $sec = 3)
	{
		$this->assign('message',$message);
		if (is_null($url)) {
			$url = $_SERVER['HTTP_REFERER'];
		}
		$this->assign('url',$url);
		$this->assign('sec',$sec);
		$this->display('error.html');
		exit;
	}
	
	public function success($message, $url = null, $sec = 3)
	{
		$this->assign('message',$message);
		if (is_null($url)) {
			$url = $_SERVER['HTTP_REFERER'];
		}
		$this->assign('url',$url);
		$this->assign('sec',$sec);
		$this->display('error.html');
	}
	
	public function display($filePath = null, $isExecute = true, $uri = null)
	{
		if (is_null($filePath)) {
			$filePath = $_GET['m'].'/'.$_GET['a'].'.html';
		}
	
		
		parent::display($filePath, $isExecute, $uri);
	}
	
}