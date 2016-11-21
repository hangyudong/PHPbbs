<?php
namespace Framework;

class Upload
{
	//路径
	private $_path = './upload/';
	//准许的MIMIE
	private $_allowMime = ['image/jpg','image/pjpeg','image/jpeg','image/png','image/gif','image/bmp','image/wbmp','image/x-png'];
	//准许的subfix
	private $_allowSubfix = ['jpg','jpeg','png','gif','bmp'];
	//准许的文件大小
	private $_allowSize = 2000000;
	//是否是随机文名
	private $_isRandName = true;
	//是否准许日期目录
	private $_isDatePath = true;
	//前缀
	private $_prefix = 'up_';
	
	//错误号
	private $_errorNo;
	//错误信息
	private $_errorInfo;
	//文件大小
	private $_size;
	//文件源名
	private $_orgName;
	//文件MIMIE类型
	private $_mime;
	//临时文件名
	private $_tmpName;
	//新名
	private $_newName;
	//全新的路径
	private $_newPath;
	//后缀
	private $_subfix;
	
	//写一个构造方法初使化我的成员属性
	public function __construct(Array $attr = [])
	{
			foreach ($attr as $key => $value) {
				$this->setOption($key,$value);
			}
	}
	
	protected function setOption($key,$value)
	{
		
		$key = '_'.ltrim($key,'_');
		
		if (array_key_exists($key,get_class_vars(__CLASS__))) {
				$this->$key = $value;
		}

		//get_class_vars(__CLASS__);
		//get_class_vars(get_clas($this))
		//$this->$key = $value;
	}
	//上传方法
	
	
	//了解input type="file" 的字是谁？？？表单对吗？
	//检查错误号
	
	
	
	public function uploadFile($field)
	{
		//检查路径是否存在
		if (empty($this->_path)) {
			$this->setOption('errorNo',-7);
			return false;
		}
		
		//检查路径是否可写
		//检查路径是否是目录
		if (!$this->_checkPath()) {
			return false;
		}
		
		
		
		$name = $_FILES[$field]['name'];
		$size = $_FILES[$field]['size'];
		$type = $_FILES[$field]['type'];
		$tmpName = $_FILES[$field]['tmp_name'];
		$error = $_FILES[$field]['error'];
		
		
		//处理源名、后缀、MIME、文件大小
		if (!$this->_setFiles($name,$size,$type,$tmpName,$error)) {
			return false;
		}
		
		
		//判断MIME，判断后缀，判断大小
		if (!$this->_checkMime() || !$this->_checkSubfix() || !$this->_checkSize() ){
			return false;
		}
		
		//创建新名
		$this->_newName = $this->_createNewName();
		//创建 日期路径
		$this->_newPath  = $this->_createPath();
		//判断是否是上传文件
		if (is_uploaded_file($this->_tmpName)) {
			//移动上传文件
			if (move_uploaded_file($this->_tmpName,$this->_newPath.$this->_newName)) {
				return true;
			} else {
				$this->setOption('errorNo',-1);
				return false;
			}
			
		} else {
			$this->setOption('errorNo',-2);
			return false;
		}
		
		
	}
	
	private function _createPath()
	{
		if ($this->_isDatePath) {
			$path = $this->_path . date('Y/m/d/');
			if (!file_exists($path)) {
				mkdir($path,0755,true);
			}
			return $path;
		} else{
			return $this->_path;
		}
	}
	
	private  function _createNewName()
	{
		if ($this->_isRandName) {
			return $this->_prefix . uniqid().'.'.$this->_subfix;
		} else {
			return $this->_prefix.$this->_orgName;
		}
	}
	
	
	private function _checkSubfix()
	{
		if (in_array($this->_subfix,$this->_allowSubfix)) {
			return true;
		} else {
			$this->setOption('_errorNo',-5);
			return false;
		}
	}
	
	
	private function _checkSize()
	{
		if ($this->_size > $this->_allowSize) {
			$this->setOption('errorNo',-4);
			return false;
		} else{
			return true;
		}
	}
	
	
	private function _checkMime()
	{
		if (in_array($this->_mime,$this->_allowMime)) {
			return true;
		} else {
			$this->setOption('errorNo',-3);
			return false;
		}
		
	}
	
	
	private function _setFiles($name,$size,$type,$tmpName,$error)
	{
		//正常0  错误123467
		if ($error) {
			$this->setOption('errorNo',$error);
			return false;
		}
		
		$this->_orgName = $name;
		$this->_size = $size;
		$this->_tmpName = $tmpName;
		$this->_mime = $type;
		$arr = pathinfo($name);
		$this->_subfix = $arr['extension'];
		
		/*
		$arr = explode('.',$name);
		$this->_subfix = array_pop($arr);
		
		$pos = strrpos($name,'.') + 1;
		$this->_subfix = substr($name,$pos);
		*/
		return true;
		
		//查找最后一个.出现的位置  +1  substr截取后缀
		//用explode 分割. 弹出最后一个数组单元
		//pathinfo
	}
	
	
	private function _checkPath()
	{
		if ( !file_exists($this->_path) ) {
			$this->setOption('_errorNo',-6);
			return false;
		}
		
		if (!is_dir($this->_path)) {
			return mkdir($this->_path,0755,true);
		}
		
		if (!is_writeable($this->_path)) {
			return chmod($this->_path,0755);
		}
		
		return true;
		
	}
	
	
	
	//调用一个错误号的方法
	public function __get($key)
	{
		if ($key == '_errorNo') {
			return $this->_errorNo;
		} elseif($key == '_errorInfo') {
			return $this->_getErrorInfo();
		}
	}
	
	//调用一个错误信息的方法
	private function _getErrorInfo()
	{
		switch ($this->_errorNo) {
			case -7:
				$str = '没有设置保存文件的路径';
				break;
			case -6:
				$str = '文件路径不存在';
				break;
			case -5:
				$str = '文件后缀不准许';
				break;
			case -4:
				$str = '文件大小不准许';
				break;
			case -3:
				$str = 'MIME类型不准许';
				break;
			case -2:
				$str = '不是上传文件';
				break;
			case -1:
				$str = '移动上传文件失败';
				break;
			case 1:
				$str = '超过了php.ini规定的大小';
				break;
			case 2:
				$str = '超过了表单规定的大小';
				break;
			case 3:
				$str = '部份文件被上传';
				break;
			case 4:
				$str = '没有件被上传';
				break;
			case 6:
				$str = '找不到临时文件夹';
				break;
			case 7:
				$str = '临时文件写入失败';
				break;
				
		}
		return $str;
	}
	
}