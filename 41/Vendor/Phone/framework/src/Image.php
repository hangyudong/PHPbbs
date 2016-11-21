<?php
namespace Framework;

class Image
{
	
	//路径
	protected $path;
	protected $isRandName;
	
	
	//初使化路径
	public function __construct($path = './', $r = true)
	{
		$this->path = rtrim($path,'/').'/';
		$this->isRandName = $r;	}
	
	//水印
	//1.检测文件是否存在
	
	//5. 合并图片
	//6. 保存图片
	//7. 销毁资源
	public function water($dst, $src, $pos = 9, $prefix = 'wa_',$tmd = 100)
	{
		//必须要传入一个路径
		//水印图片的路径是固定
		$src = $this->path . $src;
		if ( !file_exists($src) || !file_exists($dst)) {
			exit('水印图片者目标图片不存在');
		} 
		
		//提前获得图片的相关信息、宽高、名字、类型
		$dstInfo = self::getImageInfo($dst);
		$srcInfo = self::getImageInfo($src);
		
		//2.判断水印图片不能大于背景图片
		if (!$this->_checkSize($dstInfo,$srcInfo)) {
			exit('水印图片大小大于背景图片大小');
		}
		
		//3.获得位1,2,3,4,5,6,7,8,9,0
		$position = self::getPosition($dstInfo, $srcInfo, $pos);
		
		//4.打开图片资源
		$dstRes = self::openImg($dst,$dstInfo);
		$srcRes = self::openImg($src,$srcInfo);
		
		$newRes = $this->_mergeImg($dstRes, $srcRes, $dstInfo, $srcInfo, $position, $tmd);
		
		if ($this->isRandName) {
			$data = pathinfo($dstInfo['name']);
			$subfix = $data['extension'];
			$newPath = $this->path.$prefix.uniqid().'.'.$subfix;
		} else {
			$newPath = $this->path.$prefix.$dstInfo['name'];
		}
		
		self::saveImg($newRes,$newPath, $dstInfo);
		
		imagedestroy($srcRes);
		imagedestroy($newRes);
		
		return $newPath;
		
	}
	
	
	public function thumb($img, $width, $height, $prefix = 'thumb_')
	{
		if (!file_exists($img)) {
			exit('文件路径不正在');
		}
		
		$info = self::getImageInfo($img);
		$newSize = self::getNewSize($width,$height,$info);
		$res = self::openImg($img, $info);
		$newRes = self::kidOfImage($res,$newSize,$info);
		$newPath = $this->path.$prefix.$info['name'];
		self::saveImg($newRes,$newPath,$info);
		imagedestroy($newRes);
		return $newPath;
	}
	
	
	private static function kidOfImage($srcImg, $size, $imgInfo)
	{
		$newImg = imagecreatetruecolor($size["width"], $size["height"]);		
		$otsc = imagecolortransparent($srcImg);
		if ( $otsc >= 0 && $otsc < imagecolorstotal($srcImg)) {
			 $transparentcolor = imagecolorsforindex( $srcImg, $otsc );
				 $newtransparentcolor = imagecolorallocate(
				 $newImg,
				 $transparentcolor['red'],
					 $transparentcolor['green'],
				 $transparentcolor['blue']
			 );

			 imagefill( $newImg, 0, 0, $newtransparentcolor );
			 imagecolortransparent( $newImg, $newtransparentcolor );
		}

	
		imagecopyresized( $newImg, $srcImg, 0, 0, 0, 0, $size["width"], $size["height"], $imgInfo["width"], $imgInfo["height"] );
		imagedestroy($srcImg);
		return $newImg;
	}
	
	private static function getNewSize($width, $height, $imgInfo)
	{	
		$size["width"] = $imgInfo["width"];   //将原图片的宽度给数组中的$size["width"]
		$size["height"] = $imgInfo["height"];  //将原图片的高度给数组中的$size["height"]
		
		if($width < $imgInfo["width"]) {
			$size["width"] = $width;             //缩放的宽度如果比原图小才重新设置宽度
		}

		if ($width < $imgInfo["height"]) {
			$size["height"] = $height;            //缩放的高度如果比原图小才重新设置高度
		}

		if($imgInfo["width"]*$size["width"] > $imgInfo["height"] * $size["height"]) {
			$size["height"] = round($imgInfo["height"] * $size["width"] / $imgInfo["width"]);
		} else {
			$size["width"] = round($imgInfo["width"] * $size["height"] / $imgInfo["height"]);
		}

		return $size;
	}		
	
	public static function  saveImg($res, $path, $info)
	{
		switch ($info['mime']) {
			case 'image/png':
			case 'image/x-png':
				imagepng($res,$path);
				break;
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($res,$path);
				break;
			case 'image/gif':
				imagegif($res,$path);
				break;
			case 'image/bmp':
			case 'image/wbmp':
				imagewbmp($res,$path);
				break;
		}
	}
	
	private function _mergeImg($dstRes, $srcRes, $dstInfo, $srcInfo, $position, $tmd)
	{
		imagecopymerge($dstRes,$srcRes,$position['x'],$position['y'],0,0,$srcInfo['width'],$srcInfo['height'],$tmd);
		return $dstRes;
	}
	
	public static function openImg($path, $info)
	{
		switch ($info['mime']) {
			case 'image/png':
			case 'image/x-png':
				$res = imagecreatefrompng($path);
				break;
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				$res = imagecreatefromjpeg($path);
				break;
			case 'image/gif':
				$res = imagecreatefromgif($path);
				break;
			case 'image/bmp':
			case 'image/wbmp':
				$res = imagecreatefromwbmp($path);
				break;
			
		}
		return $res;
	}
	
	public static function getPosition($dstInfo, $srcInfo, $pos)
	{
		switch($pos)
		{
			case 1:
				$x = 0;
				$y = 0;
				break;
			case 2:
				$x = ceil(($dstInfo['width'] - $srcInfo['width']) /2);
				$y = 0;
				break;
			case 3:
				$x = $dstInfo['width'] - $srcInfo['width'];
				$y = 0;
				break;
			case 4:
				$x = 0;
				$y = ceil(($dstInfo['height'] - $srcInfo['height']) / 2);
				break;
			case 5:
				$x = ceil(($dstInfo['width'] - $srcInfo['width']) /2);
				$y = ceil(($dstInfo['height'] - $srcInfo['height']) / 2);
				break;
			case 6:
				$x = $dstInfo['width'] - $srcInfo['width'];
				$y = ceil(($dstInfo['height'] - $srcInfo['height']) / 2);
				break;
			case 7:
				$x = 0;
				$y = $dstInfo['height'] - $srcInfo['height'];
				break;
			case 8:
				$x = ceil(($dstInfo['width'] - $srcInfo['width']) /2);
				$y = $dstInfo['height'] - $srcInfo['height'];
				break;
			case 9:
				$x = $dstInfo['width'] - $srcInfo['width'];
				$y = $dstInfo['height'] - $srcInfo['height'];
				break;
			
			default:
				$x = mt_rand(0,$dstInfo['width'] - $srcInfo['width']);
				$y = mt_rand(0,$dstInfo['height'] - $srcInfo['height']);
				break;
		}
		
		return [
				'x' => $x,
				'y' => $y,
				];
	}
	
	private function _checkSize($dstInfo,$srcInfo)
	{
		if ($srcInfo['height'] > $dstInfo['height'] 
			||
			$srcInfo['width'] > $dstInfo['width']
			) {
				return false;
			} else {
				return true;
			}
	}
	
	
	public static function getImageInfo($path)
	{
		
		$data =  getimagesize($path);
		$info['width'] = $data[0];
		$info['height'] = $data[1];
		$info['mime'] = $data['mime'];
		$info['name'] = basename($path);
		
		return $info;
	}
	
	
	
	//缩放
	//1.检测文件是否存在，并且获得图片的相关信息
	//2.打开图片
	//3.获得新的尺寸大小
	//4.把图片调整大小，并且让图片背景万一是gif透明处理变黑下周
	//5.保存图片
	//over
	
	
}