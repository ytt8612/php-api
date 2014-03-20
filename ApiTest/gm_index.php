<?php

$jsonstr = isset ( $_REQUEST ['json'] ) ? $_REQUEST ['json'] : '';
if (! empty ( $jsonstr )) {
	$json = urldecode ( $jsonstr );
	$json = json_decode ( $json, true );

	if (! empty ( $json )) {
		$file = $json['file'];
		$path = $json['path'];
		$gmagick = new Gmagick_Handler ( );
		$picsize = $gmagick->getImgeSize ( $file );

		foreach ($json['arr'] as $v){
			if($v['w']=='w'){
				$v['w'] = $picsize ['w'];
			}
			if($v['h']=='h'){
				$v['h'] = $picsize ['h'];
			}
			$gmagick->make_thumb ( $file, $v['w'], $v['h'], $v['cut'], $v['quality'], $path, $v['name'] );
		}
	}
}

/*
 *
 * $gmagick = new Gmagick_Handler();
 * $gmagick->make_thumb("images/1.jpg",200,300,true,80,"newimage/1.jpg");
 *
 *
 */
class Gmagick_Handler {
	//透明填充
	var $fillcolor = "#000000";
	
	function __construct() {
	
	}
	
	/**
	 *
	 *@param  $img:源图片地址; $path: 生成图片路径; $thumb_width: 最终宽度; $thumb_height: 最终高度; $crop: 是否裁剪,默认为否.$quality为生成图片的压缩质量; $path为生成文件的路径,$name文件名，不包括后缀
	 *@return 创建成功返回生成的文件名，否则返回false
	 */
	function make_thumb($img, $thumb_width = 0, $thumb_height = 0, $crop = false, $quality = 90, $path = '',$name = '') {
		
		$max_width=$max_height=1200;
		
		/* 检查缩略图宽度和高度是否合法 */
		if ($thumb_width == 0 && $thumb_height == 0) {
			throw new Exception ( "width and height Invalid!" );
		}
		
		/* 检查原始文件是否存在及获得原始文件的信息 */
		$org_info = @getimagesize ( $img );
		if (! $org_info) {
			throw new Exception ( "image not exists" );
		}
		
		/* 创建当月目录 */
		if (empty ( $path )) {
			throw new Exception ( "path not exists" );
		} else {
			$dir = $path;
		}
		
		/* 如果目标目录不存在，则创建它 */
		if (! file_exists ( $dir )) {
			if (! $this->make_dir ( $dir )) {
				/* 创建目录失败 */
				throw new Exception ( "directory readonly" );
			}
		}
		
		$filename = $name.'.jpg';
		
		if(file_exists ( $dir. $filename)){
			return $dir . $filename;
		}
		
		try {
			
			$gmagick = new Gmagick ( $img );
			$gw = $gmagick->getimagewidth ();
			$gh = $gmagick->getimageheight ();
			
			if($gw>$max_width&&$thumb_width>$max_width){
				$thumb_width = $max_width;
			}
			if($gh>$max_height&&$thumb_height>$max_height){
				$thumb_height = $max_height;
			}
			
			if($gh<$thumb_height){
				$thumb_height = $gh;
			}
			
			if($gw<$thumb_width){
				$thumb_width = $gw;
			}
			
			if ($crop == false) {
				$gmagick->scaleimage ( $thumb_width, 0 );
				
				/* $canvas = new Gmagick ( );
				$canvas->newimage ( $thumb_width, $thumb_height, $this->fillcolor, 'jpeg' );
				// 取得缩图的实际大小 
				$x = ($thumb_width - $gw) / 2;
				$y = ($thumb_height - $gh) / 2;
				$tempgmagick = $gmagick;
				
				$gmagick = $canvas->compositeimage ( $gmagick, Gmagick::COMPOSITE_OVER, $x, $y );
			 */
			} else {
				
				$gmagick->cropthumbnailimage ( $thumb_width, $thumb_height );
			
			}
			$gmagick->setCompressionQuality ( $quality );
			$gmagick->write ( $dir . $filename );
			$gmagick->destroy ();
			
//			if ($canvas != null) {
//				
//				$canvas->destroy ();
//				$tempgmagick->destroy ();
//			}
			
			//确认文件是否生成
			if (file_exists ( $dir . $filename )) {
				return $dir . $filename;
			} else {
				//生成图片失败!
				throw new Exception ( "create image error!" );
			}
		
		} catch ( Exception $e ) {
			
			throw new Exception ( $e );
		
		}
	
	}
	
	/**
	 *  生成指定目录不重名的文件名
	 *
	 * @access  public
	 * @param   string      $dir        要检查是否有同名文件的目录
	 *
	 * @return  string      文件名
	 */
	function unique_name($dir) {
		$filename = '';
		
		while ( empty ( $filename ) ) {
			
			$filename = $this->random_filename ();
			
			if (file_exists ( $dir . $filename . '.jpg' ) || file_exists ( $dir . $filename . '.gif' ) || file_exists ( $dir . $filename . '.png' )) {
				$filename = '';
			}
		}
		
		return $filename;
	}
	
	/**
	 * 生成随机的数字串
	 *
	 * @return string
	 */
	function random_filename() {
		
		$str = '';
		for($i = 0; $i < 9; $i ++) {
			$str .= mt_rand ( 0, 9 );
		}
		
		return $this->gmtime () . $str;
	
	}
	
	/**
	 *
	 * 批量处理图片
	 *
	 */
	function file_list($path) {
		if ($handle = opendir ( $path )) {
			while ( false !== ($file = readdir ( $handle )) ) {
				if ($file != "." && $file != "..") {
					if (is_dir ( $path . "/" . $file )) {
						echo $path . "/" . $file . "<br>"; //去掉此行显示的是所有的非目录文件
						file_list ( $path . "/" . $file );
					} else {
						
						$arr = explode ( '.', $file );
						echo end ( $arr );
						echo $path . "/" . $file . "<br>";
					}
				}
			}
		}
	}
	
	/**
	 * 获得当前格林威治时间的时间戳
	 *
	 * @return  integer
	 */
	function gmtime() {
		return (time () - date ( 'Z' ));
	}
	
	function make_dir($folder) {
		$reval = false;
		
		if (! file_exists ( $folder )) {
			/* 如果目录不存在则尝试创建该目录 */
			@umask ( 0 );
			
			/* 将目录路径拆分成数组 */
			preg_match_all ( '/([^\/]*)\/?/i', $folder, $atmp );
			
			/* 如果第一个字符为/则当作物理路径处理 */
			$base = ($atmp [0] [0] == '/') ? '/' : '';
			
			/* 遍历包含路径信息的数组 */
			foreach ( $atmp [1] as $val ) {
				if ('' != $val) {
					$base .= $val;
					
					if ('..' == $val || '.' == $val) {
						/* 如果目录为.或者..则直接补/继续下一个循环 */
						$base .= '/';
						
						continue;
					}
				} else {
					continue;
				}
				
				$base .= '/';
				
				if (! file_exists ( $base )) {
					/* 尝试创建目录，如果创建失败则继续循环 */
					if (@mkdir ( rtrim ( $base, '/' ), 0777 )) {
						@chmod ( $base, 0777 );
						$reval = true;
					}
				}
			}
		} else {
			/* 路径已经存在。返回该路径是不是一个目录 */
			$reval = is_dir ( $folder );
		}
		
		clearstatcache ();
		
		return $reval;
	}
	
	function getImgeSize($img){
		try{
		$gmagick = new Gmagick ( $img );
		$gw = $gmagick->getimagewidth ();
		$gh = $gmagick->getimageheight ();
		return array('w'=>$gw,'h'=>$gh);
		} catch ( Exception $e ) {
			
			throw new Exception ( $e );
		
		}
	}
}



//记得要处理异常哦!这里省略try catch代码
//记得图片生成完以后要调用Gmagick的destory方法释放内存哦

/**
//初始用例,准备两张图片
$image = new Gmagick('images/1-1.jpg');
//生成thumbnail image
$image->thumbnailImage(200, 0,FALSE);
$image->borderImage("yellow", 1, 1)->oilPaintImage(0.3);
//提高图片质量
$image->enhanceimage();
$image->write('images/1-2.jpg');
**/

/**
//组合图片，将两张图片组合为一张图
$imgMain = new Gmagick('images/1-1.jpg');
$width = (int) ($imgMain->getimagewidth() /2) - 150;
$imgBarcode = new Gmagick('images/1-2.jpg');
$imgMain->compositeimage($imgBarcode, 1, $width, 150);
$imgMain->write('images/withBarcode.jpg');
**/

/**
//切割图片
$image = new Gmagick('images/1-1.jpg');
//参数依次为切割的宽，高和切割的起始坐标x,y
$image->cropimage(200,200,300,300);
$image->write('images/cropimage.jpg');
**/

/**
//切割thumbnail image，会有图片缺失情况存在。
$image = new Gmagick('images/1-1.jpg');
//参数依次为切割的宽，高
$image->cropthumbnailimage(300,100);
$image->write('images/cropthumbnailimage.jpg');
**/

/**
//浮雕效果,返回具有立体效果的灰度图像
$image = new Gmagick('images/1-1.jpg');
$image->cropthumbnailimage(200,200);
//参数依次为：半径，浮雕程度
$image->embossimage(10.5, 5.2);
$image->write('images/embossimage.jpg');
**/

/**
//边缘效果
$image = new Gmagick('images/1-1.jpg');
$image->cropthumbnailimage(200,200);
//参数依次为：半径，浮雕程度
$image->edgeimage(10.5);
$image->write('images/edgeimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//垂直翻转图片效果
$image->flipimage();
//横向翻转效果
$image->flopimage();
$image->write('images/flipimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//伽玛效果
$image->gammaimage(10.3);
$image->write('images/gammaimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//模糊滤镜效果,参数为半径，标准偏差
$image->blurimage(10,20);
$image->write('images/blurimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//模拟木炭画效果,参数为半径，标准偏差
$image->charcoalimage(10,20.5);
$image->write('images/charcoalimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//印章效果,参数：宽度，高度，坐标x,y
$image->chopimage(100,100,200,200);
$image->write('images/chopimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//图片缩放效果,参数：宽度（为0时按高度等比缩放图片），高度（为0时按宽度等比缩放图片）
$image->scaleimage(100,0);
$image->write('images/scaleimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//偏移效果,参数：x(x轴方向偏移量),y(y轴轴方向偏移量)
$image->rollimage(200,300);
$image->write('images/rollimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//模拟3D按钮效果
$image->raiseimage(200,300,100,50,true);
$image->write('images/raiseimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//增强图片对比度
$image->normalizeimage(3);
$image->write('images/normalizeimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//模拟油画效果
$image->oilpaintimage(13);
$image->write('images/oilpaintimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//放大两倍
$image->magnifyimage();
$image->write('images/magnifyimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//创建一个副本，参数为0时，图片副本跟原图一样
$image->implodeimage(0);
$image->write('images/implodeimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//随机置换每个像素块
$image->spreadimage(100);
$image->write('images/spreadimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//solarize效果
$image->solarizeimage(100);
$image->write('images/solarizeimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//创建一个平行四边形，参数依次为：填充色，x方向度数，y方向度数
$image->shearimage('#cccccc',100.4,100.5);
$image->write('images/shearimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//翻飞效果，参数为：密度
$image->swirlimage(100.5);
$image->write('images/swirlimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//翻飞效果，参数为：密度
$image->swirlimage(100.5);
$image->write('images/swirlimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//平滑图像轮廓,参数：半径
$image->reducenoiseimage(50.5);
$image->write('images/reducenoiseimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//创建一张不同分辨率的图片,参数：x方向分辨率，y方向分辨率，滤镜数，模糊数
$image->resampleimage(50.5,13.5,5,10);
$image->write('images/resampleimage.jpg');
**/

/**
$image = new Gmagick('images/1-1.jpg');
//旋转图片,参数:填充色，角度
$image->rotateimage("#cccccc",50);
$image->write('images/rotateimage.jpg');
**/

//Gmagick设置生成图片质量的方法，Gmagick默认生成的图片质量有点差。
//这里设置质量为90,注意设置质量为90以上的(包括90)可能会导致生成后的图片所占的空间比原图还要大，还要注意在write()的时候再设置这个压缩质量，不要在把图片经过各种处理之前设置这个值，这样write的时候质量就不生效了，生成的图片可以用picasa来查看质量，目前这个方法官方文档居然还木有描述，在imagick中有这个方法的描述，我是在网上找了很久才找到的，很无语。
//$image->setCompressionQuality(90); //注意graphicsmagick1.3.7以上才支持setCompressionQuality，相对的getCompressionQuality方法目前还木有提供
