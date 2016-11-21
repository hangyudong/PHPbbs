<?php
namespace Framework;

class Image
{
	
	//·��
	protected $path;
	protected $isRandName;
	
	
	//��ʹ��·��
	public function __construct($path = './', $r = true)
	{
		$this->path = rtrim($path,'/').'/';
		$this->isRandName = $r;	}
	
	//ˮӡ
	//1.����ļ��Ƿ����
	
	//5. �ϲ�ͼƬ
	//6. ����ͼƬ
	//7. ������Դ
	public function water($dst, $src, $pos = 9, $prefix = 'wa_',$tmd = 100)
	{
		//����Ҫ����һ��·��
		//ˮӡͼƬ��·���ǹ̶�
		$src = $this->path . $src;
		if ( !file_exists($src) || !file_exists($dst)) {
			exit('ˮӡͼƬ��Ŀ��ͼƬ������');
		} 
		
		//��ǰ���ͼƬ�������Ϣ����ߡ����֡�����
		$dstInfo = self::getImageInfo($dst);
		$srcInfo = self::getImageInfo($src);
		
		//2.�ж�ˮӡͼƬ���ܴ��ڱ���ͼƬ
		if (!$this->_checkSize($dstInfo,$srcInfo)) {
			exit('ˮӡͼƬ��С���ڱ���ͼƬ��С');
		}
		
		//3.���λ1,2,3,4,5,6,7,8,9,0
		$position = self::getPosition($dstInfo, $srcInfo, $pos);
		
		//4.��ͼƬ��Դ
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
			exit('�ļ�·��������');
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
		$size["width"] = $imgInfo["width"];   //��ԭͼƬ�Ŀ�ȸ������е�$size["width"]
		$size["height"] = $imgInfo["height"];  //��ԭͼƬ�ĸ߶ȸ������е�$size["height"]
		
		if($width < $imgInfo["width"]) {
			$size["width"] = $width;             //���ŵĿ�������ԭͼС���������ÿ��
		}

		if ($width < $imgInfo["height"]) {
			$size["height"] = $height;            //���ŵĸ߶������ԭͼС���������ø߶�
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
	
	
	
	//����
	//1.����ļ��Ƿ���ڣ����һ��ͼƬ�������Ϣ
	//2.��ͼƬ
	//3.����µĳߴ��С
	//4.��ͼƬ������С��������ͼƬ������һ��gif͸������������
	//5.����ͼƬ
	//over
	
	
}