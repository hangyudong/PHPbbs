<?php
namespace Framework;


class Verify
{
	//宽
	protected $width;
	//高
	protected $height;
	//图片类型
	protected $imgType;
	//文字类型
	protected $codeType;
	//文字的个数
	protected $num;
	//保存的验证码字符串
	protected $verifyCode;
	//保存验证码资源的一个成员属性
	protected $res;
	
	
	//初始化成员
	//上面这些参数
	public function __construct($width = 100, $height = 50, $imgType = 'png', $codeType = 3, $num = 4)
	{
		$this->width = $width;
		$this->height = $height;
		$this->imgType = $imgType;
		$this->codeType = $codeType;
		$this->num = $num;
		$this->verifyCode = $this->createVerifyCode();
		
	}
	
	protected function  createVerifyCode()
	{
		$string = '';
		
		switch ($this->codeType) {
			case 1:
				$string = implode('',array_rand(range(0,9),$this->num));
				break;
			case 2:
				$string = join('',array_rand(array_flip(range('a','z')),4));
				break;
			case 3:
				/*
				for ($i = 0; $i < $this->num; $i++) {
					$r= mt_rand(0,2);
					switch ($r) {
						case 0:
							$ascii = mt_rand(48,57);
							break;
						case 1:
							$ascii = mt_rand(65,90);
							break;
						case 2:
							$ascii = mt_rand(97,122);
							break;
					}
					$string .= chr($ascii);
					
				}
				*/
				$str = 'abcdefghijkmnpqrstuvwxzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
				$string = substr(str_shuffle($str),0,$this->num);
				break;
		}
		
		return $string;
	}
	
	
	
	//调验证码显示的一个方法 output
	//1.画图
	//2.分配颜色(写两个成员方法，调的时候直接调对应的成员方法即可)
	//3.背景填充
	//4.画干扰点
	//5.画干扰线
	//6.写字 
	//7. 输出类型
	//8. 输出图片
	public function outImg()
	{
		$this->createImg();
		$this->fillBgColor();
		$this->fillPix();
		$this->fillArc();
		$this->writeFont();
		$this->output();
	}
	
	protected function output()
	{
		//imagepng
		$func = 'image'.$this->imgType;
		$mime = 'Content-type:image/'.$this->imgType;
		header($mime);
		$func($this->res);
	}
	
	protected function writeFont()
	{
		for ($i = 0; $i < $this->num; $i++) {
			
			$width = ceil($this->width / $this->num);
			$x = $width * $i;
			$y= mt_rand(5,$this->height - 10);
			$c = $this->verifyCode[$i];
			imagechar($this->res,5,$x,$y,$c,$this->darkColor());
		}
		
	}
	
	protected function fillArc()
	{
		for($i = 0; $i < 10; $i++) {
			imagearc($this->res,
					mt_rand(10,$this->width - 10),
					mt_rand(10,$this->height - 10),
					mt_rand(0,$this->width),
					mt_rand(0,$this->height),
					mt_rand(0,180),
					mt_rand(181,360),
					$this->lightColor()
					);
		}
	}
	
	protected function fillPix()
	{
		$num = $this->pixNum();
		for ($i = 0; $i < $num; $i++) {
			
			imagesetpixel($this->res,mt_rand(0,$this->width),mt_rand(0,$this->height),$this->darkColor());
		}
	}
	
	protected function pixNum()
	{
		$area = ceil(($this->width * $this->height) / 20);
		return $area;
	}
	
	
	protected function fillBgColor()
	{
		imagefill($this->res,0,0,$this->lightColor());
	}
	
	
	protected function lightColor()
	{
		return imagecolorallocate($this->res,
						   mt_rand(130,255),
						   mt_rand(130,255),
						   mt_rand(130,255)
							);
	}
	
	protected function darkColor()
	{
		return imagecolorallocate($this->res,
						   mt_rand(0,120),
						   mt_rand(0,120),
						   mt_rand(0,120)
							);
	}
	
	protected function createImg()
	{
		$this->res = imagecreatetruecolor($this->width,$this->height);
	}
	
	
	//9 .销毁图片资源
	public function __destruct()
	{
		//imagedestroy($this->res);
	}
	
	//可以做一个魔术方法__get专门用于得到验证码字符串
	public function __get($key)
	{
		if ($key == 'verifyCode') {
			return $this->$key;
		}
		
		return false;
	}
	
	
}