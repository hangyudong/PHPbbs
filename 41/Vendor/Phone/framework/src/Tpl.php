<?php

namespace Framework;

class Tpl
{
	//缓存目录
	protected $cacheDir = './cache/';
	//模板目录
	protected $tplDir = './tpl/';
	//全局保存分配过来变量的成员属性
	protected $vars = [];
	//过期时间（缓存有效期）
	protected $cacheLifeTime = 3600;
	
	
	//初始化成员属性
	public function __construct($cacheDir = null, $tplDir = null, $cacheLifeTime = null)
	{
		if (isset($cacheDir)) {
			if ($this->checkDir($cacheDir)) {
				$this->cacheDir = $cacheDir;
			}
		}
		
		if (isset($tplDir)) {
			if ($this->checkDir($tplDir)) {
				$this->tplDir = $tplDir;
			}
		}
		
		if (isset($cacheLifeTime)) {
			$this->cacheLifeTime = $cacheLifeTime;
		}
	}
	
	protected function checkDir($path)
	{
		if (!file_exists($path) || !is_dir($path)) {
			return mkdir($path,0755,true);
		}
		
		if (!is_writeable($path) || !is_readable($path)) {
			return chmod($path,0755);
		}
		return true;
	}
	
	//分配变量的成员方法
	public function assign($name,$value)
	{
		$this->vars[$name] = $value;
	}
	
	
	//显示模版页的成员方法
	//1. 如果模版文件不存在，给出错误提示
	//2. 拼接新的缓存文件. $uri进行拼接
	//3. 产生缓存路径（目录径+文件路径）
	//4. 判断文件是否存在，如果文件不存在，重新编译生成文件
	//5. 判断有效期、判断模板文件 和 编译文件的修改时间
	//6. 如果有效期不对的，重新生成。
	//7. 如果确的直接生成
	//8. 判断是否需要显示、解释变量和是否需要执行编译文件
	public function display($filePath, $isExecute = true, $uri = null)
	{
		if (empty($filePath)) {
			exit('没有传入文件');
		}
		
		
		
		$tplFilePath = rtrim($this->tplDir,'/').'/'.$filePath;
	
		
		if (!file_exists($tplFilePath)) {
			echo $tplFilePath;
			exit('模板不存在');
		}
		
		$cacheFileName = md5($filePath.$uri).'.php';
		
		$cacheFilePath = rtrim($this->cacheDir,'/').'/'.$cacheFileName;
		
		if (!file_exists($cacheFilePath)) {
			$html = $this->compile($tplFilePath);
			if (!file_put_contents($cacheFilePath,$html)) {
				exit('编译写入失败');
			}
		}
		
		//判断有效期、判断模板文件 和 编译文件的修改时间
		//false 没有过期
		//true过期了
		$isTimeout = (filectime($cacheFilePath) + $this->cacheLifeTime) > time() ? false :true;
		if ($isTimeout || (filemtime($tplFilePath) > filemtime($cacheFilePath))) {
			unlink($cacheFilePath);
			$html = $this->compile($tplFilePath);
			if (!file_put_contents($cacheFilePath,$html)) {
				exit('编译写入失败');
			}
		}
		
		if ($isExecute) {
			extract($this->vars);
			include $cacheFilePath;
		}
	}
	
	
	public function clearCache()
	{
		
		$this->delDir($this->cacheDir);
		
	}
	
	
	public function delDir($path)
	{
		$dh = opendir($path);
		
		while ($newDir = readdir($dh)) {
			if ($newDir == '.' || $newDir == '..') {
				continue;
			}
			$newPath = $path.$newDir;
			
			if(is_dir($newPath)) {
				$this->delDir($newPath);
			} else {
				unlink($newPath);
			}
		}
		
	}
	
	
	//编译的成员方法
	protected function compile($path)
	{
		$html = file_get_contents($path);
		
		$keys = [
			'{if %%}' => '<?php if(\1): ?>',
            '{else}' => '<?php else : ?>',
            '{else if %%}' => '<?php elseif(\1) : ?>',
            '{elseif %%}' => '<?php elseif(\1) : ?>',
            '{/if}' => '<?php endif;?>',
            '{$%%}' => '<?=$\1;?>',
            '{foreach %%}' => '<?php foreach(\1) :?>',
            '{/foreach}' => '<?php endforeach;?>',
            '{for %%}' => '<?php for(\1):?>',
            '{/for}' => '<?php endfor;?>',
            '{while %%}' => '<?php while(\1):?>',
            '{/while}' => '<?php endwhile;?>',
            '{continue}' => '<?php continue;?>',
            '{break}' => '<?php break;?>',
            '{$%% = $%%}' => '<?php $\1 = $\2;?>',
            '{$%%++}' => '<?php $\1++;?>',
            '{$%%--}' => '<?php $\1--;?>',
            '{comment}' => '<?php /* ',
            '{/comment}' => ' */ ?>',
            '{/*}' => '<?php /* ',
            '{*/}' => '* ?>',
            '{section}' => '<?php ',
            '{/section}' => '?>',
			'{{%%(%%)}}' => '<?=\1(\2);?>',
			'{include %%}' => '<?php include "\1";?>',
		
		];
		foreach ($keys as $key => $val) {
			
			$pattern = '#'. str_replace('%%','(.+)',preg_quote($key,'#')) .'#imsU';
			$replace = $val;
			
			if (stripos($pattern,'include')) {
				$html = preg_replace_callback($pattern,array($this,'parseInclude'),$html);
			} else {
				$html = preg_replace($pattern,$replace,$html);
			}
		}
		
		return $html;
	}
	
	
	
	
	protected function parseInclude($data)
	{
	
		$file = str_replace('\'','',$data[1]);
		$path = $this->parsePath($file);
		
		$this->display($file,false);
		$string = '<?php include "'.$path.'";?>';
		return $string;
	}
	
	protected function parsePath($path)
	{
		return rtrim($this->cacheDir,'/').'/'.md5($path).'.php';
	}
	
	
}