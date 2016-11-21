<?php

class Psr4AutoloadClass
{
	protected $prefixes;
	
	
	public function register()
	{
		spl_autoload_register(array($this,'loadClass'));
	}
	
	public function addNamespace($prefix, $path)
	{
		$prefix = trim($prefix,'\\').'\\';
		$path = rtrim($path,DIRECTORY_SEPARATOR);
		
		if (isset($this->prefixes[$prefix]) == false) {
			$this->prefixes[$prefix] = array();
		}
		
		array_push($this->prefixes[$prefix],$path);
	}
	
	protected function loadClass($class)
	{
		$pos = strrpos($class,'\\');
		$prefix = substr($class,0,$pos + 1);
		$realClass = substr($class,$pos + 1);
		
		$this->mapLoad($prefix,$realClass);
	}
	
	public function mapLoad($prefix,$realClass)
	{
	
		if (isset($this->prefixes[$prefix]) == false) {
			$prefix = str_replace('\\','/',$prefix);
			$filePath = $prefix.$realClass.'.php';
			
			$this->requireFile($filePath);
			
			return;
		} 
		
		foreach ($this->prefixes[$prefix] as $path) {
			
			$filePath = $path.str_replace('\\','/',$realClass).'.php';
			$this->requireFile($filePath);
		}
		
		
	}
	
	public function requireFile($path)
	{
		
		if (file_exists($path)) {
			
			include $path;
			return true;
		}
		return false;
	}
	
}
