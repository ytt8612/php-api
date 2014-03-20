<?php

class Lib_Util {
	
	private function __construct() {
	}
	
 //订单号生成
  public static function createOrderCode($pub_id,$user_id){
  	$pub_id = $var=sprintf("%08d", $pub_id);
  	$user_id = $var=sprintf("%06d", $user_id);
  	$code= date('YmdHis').$user_id.$pub_id;
  	return $code;
  }
	//直接获取用户头像
	public static function getUserPic($kind = 0,$uid) {
		$url = 'http://' . Core_ApiRequest::getInstance ()->getHttpHeader ( 'host' ) . '/public/userphoto/';
	
		if ($uid == '' || $uid == null) {
			return '';
		}
		$path = self::getFacePath($uid);
		$base = $url . $path. '/';
		$pic = $uid.Lib_Util::getPicName($kind).'.jpg' ;
	
		//检查图片是否存在，不存在返回空
		$basepath =PROJECT_PATH."..public/userphoto/";
		if(!file_exists($basepath.$pic)){
			return $base .$pic;
		}
	
		return '';
	}
	public static function userPicArr($file,$path,$userid) {
		$arr['file'] = $file;
		$arr['path'] = $path;
		$arr['arr'] = array(
				array('w'=>120,'h'=>120,'cut'=>true,'name'=>$userid.'_s'),
				array('w'=>440,'h'=>440,'cut'=>true,'name'=>$userid.'_m'),
		);
		return $arr;
	}
	//创建文件夹
	public static function make_dir($folder) {
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
	public static function getFacePath($uid) {
		$key = "t"."21"."campus"."."."com$";
		$hash = md5($key."\t".$uid."\t".strlen($uid)."\t".$uid % 10);
		$path = $hash{$uid % 32} . "/" . abs(crc32($hash) % 100) . "/";
	
		return $path;
	}
	/**
	 * 获取图书封面图片
	 * @param  $book_id 图书ID
	 * @return string
	 */
	public static function get_book_photo($book_id,$type='small'){
		$basepath =  Core_ApiConfig::get ( 'attachment_dir' )."images/";
		$typeArr= array('small'=>'_s');
		$filename = $book_id.$typeArr[$type].'.jpg';
		if(file_exists($basepath.$filename)){
			return Core_ApiConfig::get ( 'attachment_domain' ).'images/'.$filename;
		}
		return false;
	}
	// 变量说明:
	// $url 是远程图片的完整URL地址，不能为空。
	// $filename 是可选变量: 如果为空，本地文件名将基于时间和日期
	// 自动生成.
	public static function get_photo($url,$filename='',$savefile='images/')
	{
		$imgArr = array('gif','bmp','png','ico','jpg','jepg');
		$savefile= Core_ApiConfig::get ( 'attachment_dir' ).$savefile;
		if(!$url) return false;
		if(!$filename) {
			$ext=strtolower(end(explode('.',$url)));
			if(!in_array($ext,$imgArr)) return false;
			$filename=date("dMYHis").'.'.$ext;
		}
		if(!is_dir($savefile)) mkdir($savefile, 0777);
		if(!is_readable($savefile)) chmod($savefile, 0777);
		$filename = $savefile.$filename;
		ob_start();
		readfile($url);
		$img = ob_get_contents();
		ob_end_clean();
		$size = strlen($img);
		$fp2=@fopen($filename, "a");
		fwrite($fp2,$img);
		fclose($fp2);
		return $filename;
	}
	/**
	 * 是否是邮箱
	 * @param  $email
	 * @return boolean
	 */
	public static function is_email($email){
		return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/", $email);
	}
	

	//判断手机号码:
	public static function is_mobile($str){
		return preg_match("/^((\(\d{3}\))|(\d{3}\-))?1\d{10}$/", $str);
	}
	/**
	 * 是否有下一页
	 *
	 * @param integer $offset 
	 * @param integer $num 
	 * @param integer $total 
	 * @return boolean $hasNext true|false
	 */
	public static function getHasNext($offset, $num, $total) {
		return ( boolean ) ($total > $num + $offset);
	}
	//生产随机数字组

	public static function getRandStr($len)
	{
	  $output =null;
		for ($i=0; $i<$len; $i++)
		{
		$output .= rand(0,9);
		}
		return $output;
	}
	
	//加密解密SESSIONID
	public static function decrypt($encrypted) {
		$encrypted = base64_decode ( $encrypted );
		$key = substr ( md5 ( Core_ApiConfig::get ( 'sess_key' ) ), 0, 24 );
		$key = str_pad ( $key, 24, '0' );
		$td = mcrypt_module_open ( MCRYPT_3DES, '', 'ecb', '' );
		$iv = @mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );
		
		$decrypted = mcrypt_decrypt ( MCRYPT_3DES, $key, $encrypted, MCRYPT_MODE_ECB, $iv );
		return Lib_Util::pkcs5_unpad ( $decrypted );
	
	}
	
	public static function encrypt($input) {
		$key = substr ( md5 ( Core_ApiConfig::get ( 'sess_key' ) ), 0, 24 );
		$key = str_pad ( $key, 24, '0' );
		$size = mcrypt_get_block_size ( MCRYPT_3DES, 'ecb' );
		$input = Lib_Util::pkcs5_pad ( $input, $size );
		$td = mcrypt_module_open ( MCRYPT_3DES, '', 'ecb', '' );
		$iv = @mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );
		
		$data = mcrypt_encrypt ( MCRYPT_3DES, $key, $input, MCRYPT_MODE_ECB, $iv );
		$data = base64_encode ( $data );
		return $data;
	}
	
	public static function pkcs5_pad($text, $blocksize) {
		$pad = $blocksize - (strlen ( $text ) % $blocksize);
		return $text . str_repeat ( chr ( $pad ), $pad );
	}
	
	public static function pkcs5_unpad($text) {
		$pad = ord ( $text {strlen ( $text ) - 1} );
		if ($pad > strlen ( $text )) {
			return false;
		}
		if (strspn ( $text, chr ( $pad ), strlen ( $text ) - $pad ) != $pad) {
			return false;
		}
		return substr ( $text, 0, - 1 * $pad );
	}
	
	public static function std_class_object_to_array($stdclassobject) {
		$_array = is_object ( $stdclassobject ) ? get_object_vars ( $stdclassobject ) : $stdclassobject;
		$array = array ();
		foreach ( $_array as $key => $value ) {
			$value = (is_array ( $value ) || is_object ( $value )) ? $this->std_class_object_to_array ( $value ) : $value;
			$array [$key] = $value;
		}
		
		return $array;
	}
	
	public static function get_ip() {
		$ip = getenv ( "REMOTE_ADDR" );
		if ($ip == "" || $ip == "127.0.0.1") {
			$addr = getenv ( "HTTP_X_FORWARDED_FOR" );
			if ($addr != "") {
				$arr = split ( ",", $addr );
				If (count ( $arr ) > 0) {
					$i = count ( $arr ) - 1;
					$ip = $arr [$i];
				} else
					$ip = $addr;
			}
			$ip = trim ( $ip );
		}
		return $ip;
	}
	
	public static function mkdir($pathname, $mode = 0777) {
		if (! is_dir ( $pathname )) {
			$old_mask = umask ();
			umask ( 0 );
			mkdir ( $pathname, $mode, true );
			umask ( $old_mask );
		}
	}
	
	public static function getAvatarUrl($userid, $filename) {
		return 'http://' . Core_ApiRequest::getInstance ()->getHttpHeader ( 'host' ).'/clientphoto/' . $userid . '/' . $filename;
	}
 public static function getStrLen($str) 	// 算中英文混合字符串的长度
	{
		$len=strlen($str);
	   $i=0;
	   $n =0;
	 while($i<$len){
		if(preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$str[$i])){
			$i+=2;
		}else{
			$i+=1;
		}
		$n+=1;
	 }
	   Return $n;
	} 

	public static function addTask($do,$arr,$para){
		$data['ct'] = $para['ct'];
		$data['rv'] = $para['ct'];
		$data['v'] = $para['ct'];
		$data['apn'] = $para['ct'];
		$data['identify'] = $para['ct'];
		$data ['sessID'] = $para ['sessID'];

		$data ['data'] = $arr;
		$data ['do'] = $do;
		$data ['istask'] = true;
		$content = 'json=' . urlencode(json_encode($data)).'&sig='.md5(json_encode($data));;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, Core_ApiConfig::get ( 'json_url' ));
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_exec($ch);
		curl_close($ch);
	}
	
	public static function sendSms($phone,$content){
		$content = 'content=' . urlencode($content).'&phone='.$phone;;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://10.21.66.29/function/user_sms.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_exec($ch);
		curl_close($ch);
	}
	
	public static function sendSync($userid,$tag,$content,$pic=''){
		$content = 'content=' . $content.'&userid='.$userid.'&synctag='.$tag.'&url='.$pic;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://10.21.66.29/function/client_sync.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		$rs = curl_exec($ch);
		curl_close($ch);
	}
	
 //请求豆瓣API获取图书信息
  public static  function getBookInfo($isbn){
  	$url = 'http://api.douban.com/book/subject/isbn/'.$isbn;
    $ch = curl_init();
	  curl_setopt($ch,CURLOPT_URL,$url);
	  curl_setopt($ch,CURLOPT_HEADER,FALSE);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	  $data = curl_exec($ch);
	  curl_close($ch);
  	return $data;
  }
  //解析XML格式数据
  public static function getXmlData($string){
  	$xml = new SimpleXMLElement();
  	$p = xml_parser_create();
  	xml_parse_into_struct($p, $xml, $values, $tags);
  	xml_parser_free($p);
  	return $values;
  }
	public static function getAddress($lng,$lat){
		$content = 'lat=' . $lat.'&lng='.$lng;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://10.21.66.29/function/map_get_address.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$rs = curl_exec($ch);
		curl_close($ch);
		return $rs;
	}
	//内容筛选，话题和@
	public static function filterContent($content, $char='@'){
		if($char=='@'){
			$match = array();
			if(preg_match_all('/@(.*?)[:@\s+]/i', $content.' ', $match)){
				if (is_array ( $match [1] ) && count ( $match [1] )){
					foreach ( $match [1] as $k => $v ) {
						$v = trim ( $v );
						if ('　' == substr ( $v, - 2 )) {
							$v = substr ( $v, 0, - 2 );
						}
						
						if ($v && strlen ( $v ) < 16) {
							$match [1] [$k] = $v;
						}
					}
				}
				unset($match[0]);
				return $match[1];
			}
		}elseif($char=='@#'){
			$match = array();
			if(preg_match_all('/@#(.*?)[:@#\s+]/i', $content.' ', $match)){
				if (is_array ( $match [1] ) && count ( $match [1] )){
					foreach ( $match [1] as $k => $v ) {
						$v = trim ( $v );
						if ('　' == substr ( $v, - 2 )) {
							$v = substr ( $v, 0, - 2 );
						}
			
						if ($v && strlen ( $v ) < 16) {
							$match [1] [$k] = $v;
						}
					}
				}
				unset($match[0]);
				return $match[1];
			}
			
		}elseif($char=='#'){ //话题
			if(preg_match_all('/#(.*)#/', $content, $content)){
				unset($content[0]);
				return $content;
			}
		}
	}


	/**
	 * 检测最新版本
	 */
	
	public static function isSecondBigger($first, $second) {
		//纯数字比较
		if (is_numeric ( $first ) && is_numeric ( $second )) {
			if ($second > $first) {
				return true;
			} else {
				return false;
			}
		}
		$first = str_replace('.','',$first);
		$second = str_replace('.','',$second);
		$f =  strlen($first);
		$s =  strlen($second);
		
		if ($f>$s) {
			$n = $f-$s;
			$m = 1;
			for ($i=0;$i<$n;$i++){
				$m = $m*10;
			}
			$second = $second * $m;
		}else if($s>$f) {
			$n = $s-$f;
			$m = 1;
			for ($i=0;$i<$n;$i++){
				$m = $m*10;
			}
			$first = $first * $m;
		}
		if (intval($second) > intval($first)) {
				return true;
			} 

    return false;
	}
	
	public static function getPicName($kind = 0) {
		$type = array(
			'','_s','_m','_o'
		);
		return $type[$kind];
	}

	//图片分发类型
	public static function getPicType() {
		$os = Core_ApiRequest::getInstance()->getCt();
		$apn = Core_ApiRequest::getInstance()->getApn();
		$apn = strtolower($apn);
		if($apn=='wifi' && $os == 1){
			//iphone +wifi
			return 0;
		}elseif($apn=='wifi' && $os == 2){
			//android +wifi
			return 1;
		}elseif(preg_match("/3g/",$apn) && $os == 1 ){
			//iphone +3G
			return 2;
		}elseif(preg_match("/3g/",$apn) && $os == 2 ){
			//android +3G
			return 3;
		}elseif($os == 1){
			//iphone
			return 4;
		}else{
			//android
			return 5;
		}
	}
	
	
	//截取所有内容的链接
	public static function getContentUrl($content) {
		$match = array ();
		if (preg_match_all ( '/(http:\/\/|https:\/\/|ftp:\/\/|www.)([\w:\/\.\?=&-_]+)/is', $content, $match )) {
			return $match[0];
		}
	}
	
	//截取所有内容的链接
	public static function getWeiboPic($picid,$type) {
		if(empty($picid)||$picid==0){
			return '';
		}
		$typearr = array('75'=>'cs','120'=>'s','150'=>'p','440'=>'m','60%'=>'60b','80%'=>'80b','big'=>'b','ori'=>'o');
		if(!isset($typearr[$type])){
			return '';
		}
		global $init;
		$url = 'http://' . Core_ApiRequest::getInstance ()->getHttpHeader ( 'host' ) . '/userphoto/weibo/';
		$key = "t"."21"."campus"."."."com$";
		$hash = md5($key."\t".$picid."\t".strlen($picid)."\t".$picid % 10);
		$path = $hash{$picid % 32} . "/" . abs(crc32($hash) % 100) . "/";
		$url .= $path . $picid . '_'.$typearr[$type].'.jpg';
		$file = 'userphoto/weibo/' . $path . $picid . '_'.$typearr[$type].'.jpg';
		if ($init ['base_dir'].$file) {
			return $url;
		}
		return '';
	}
	
	/**
	 * 去除内容中的样式
	 * @param $content
	 */
	public static function strip_style($content){
		$reg ="/style=.+?['|\"]/i";
		return preg_replace($reg,"",$content);
	}
	/**
	 * 截取中文函数
	 */
	public static function cnSubstr($str, $start, $len) {
		$str_tmp = $len - $start;
		if (strlen($str) < $str_tmp) {
			$tmpstr = $str;
		} else {
			$tmpstr = "";
			$strlen = $start + $len;
			for($i = 0; $i < $strlen; $i++) {
				if(ord(substr($str, $i, 1)) > 0xa0) {
					$tmpstr .= substr($str, $i, 2);
					$i++;
				} else {
					$tmpstr .= substr($str, $i, 1);
				}
			}
		//	$tmpstr .= "......";
		}
		return $tmpstr;
	}
	
	
	/**
 * 谷歌地图根据经纬度获取具体坐标位置
 */

  public static function latandlngToAddress($lng,$lat){
  	$str = $lat.','.$lng;
  	$url = Core_ApiConfig::get ( 'goolemapapi.url' );
	  $url .= '?latlng='.$str.'&language=zh-CN&sensor=false';
	  $ch = curl_init();
	  curl_setopt($ch,CURLOPT_URL,$url);
	  curl_setopt($ch,CURLOPT_HEADER,FALSE);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  $data = json_decode($data,true);
    if ($data['status'] =='OK' && isset($data['results'][0])) {
    	$rs = $data['results'][0];
    	return $rs['formatted_address'];
    }
  	 return '';
  }
  
  /**
   * 百度地图根据经纬度获取具体的坐标位置
   */
  
  public static function bLatandlngToAddress($lng,$lat,$key=''){
  	$key =Core_ApiConfig::get ( 'baidumapapi.key' );
  	$str = $lat.','.$lng;
  	$url =  Core_ApiConfig::get ( 'baidumapapi.url' );
  	$url .="?output=json&location=$str&key=$key";
  	$ch = curl_init();
  	curl_setopt($ch,CURLOPT_URL,$url);
  	curl_setopt($ch,CURLOPT_HEADER,FALSE);
  	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  	$data = curl_exec($ch);
  	curl_close($ch);
  	$data = json_decode($data,true);
    if ($data['status'] =='OK' && isset($data['result'])) {
    	$rs = $data['result'];
    	return $rs['formatted_address'];
    }
    return '';
  	
  }
  
  /**
   * 返回两点之间的距离
   * @param unknown_type $a_lat
   * @param unknown_type $a_lng
   * @param unknown_type $b_lat
   * @param unknown_type $b_lng
   * @return 距离 number
   */
  public static function getDistanceBylatandlng($lat1,$lon1,$lat2,$lon2) {
  
  	$r = 6371.137; // km
  	$lat1 = number_format($lat1,6);
  	$lon1 = number_format($lon1,6);
  	$dLat = deg2rad($lat2-$lat1);
  	$dLon = deg2rad($lon2-$lon1);
  	$lat1 = deg2rad($lat1);
  	$lat2 = deg2rad($lat2);
  
  	$a = pow(sin($dLat/2),2) + pow(sin($dLon/2),2) * cos($lat1) * cos($lat2);
  	$c = 2 *  atan2(sqrt($a), sqrt(1-$a));
  	$range = $r * $c;
  
  	$range = number_format($range,3);
  	$range .='KM';
  	return $range;
  
  }
  
  /**
   * 计算用户资料完成率
   * @param $email 邮箱地址
   * @param $phone_num 手机号码
   * @param $qq QQ号码
   * @param $brithday 生日
   * @param $hometown 家乡
   * @retuen 百分比
   */
  
  public static function getInfoRate($email,$phone_num,$qq,$brithday,$hometown){
  	$rate = 30;
  	if (!empty($email)) {
  		$rate +=15;
  	}
  	if (!empty($phone_num)) {
  		$rate +=15;
  	}
  	if (!empty($qq)) {
  		$rate +=15;
  	}
  	if (!empty($brithday)) {
  		$rate +=10;
  	}
  	if (!empty($hometown)) {
  		$rate +=15;
  	}
  	
  	return $rate.'%';
  }
  
  /**
   * 判断是否有权限  权限 0：保密，1：公开，2：好友同学校友，3：好友 
   * @param $private 权限设置
   * @param $is_friend 是否是好友
   * @param $is_classmate 是否是同学
   * @param $is_schoolmate 是否是校友
   * @return boolean
   */
  public static function hasPrivate($private,$is_friend,$is_classmate,$is_schoolmate){
  	
  	  if ($private==0) {
  	  	return false;
  	  }else if ($private==2 && !$is_classmate && !$is_friend && !$is_schoolmate) {
  	  	return false;
  	  }else if ($private==3 && !$is_friend) {
  	  	return false;
  	  }
  	  return true;
  }
  
  /**
   * 判断个人主页权限  0 所以人可见  1仅好友可见 2 仅自己可见 3 好友 ，同学 ，校友可见
    * @param $private 权限设置
   * @param $is_friend 是否是好友
   * @param $is_classmate 是否是同学
   * @param $is_schoolmate 是否是校友
   * @return boolean
   * 
   */
  public static function hasVistPrivate($private,$is_friend,$is_classmate,$is_schoolmate){
  	 
  	if ($private==1 && !$is_friend) {
  		return false;
  	}else if ($private==2) {
  		return false;
  	}else if ($private==3 && !$is_classmate && !$is_friend && !$is_schoolmate) {
  		return false;
  	}
  	return true;
  }
  
  /**
   * 模拟浏览器请求获取请求页面内容
   * @param $url 请求地址
   * @return data
   */
  public static function getCurlPage($url){
  	$ch = curl_init();
  	curl_setopt($ch,CURLOPT_URL,$url);
  	curl_setopt($ch,CURLOPT_HEADER,FALSE);
  	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  	$data = curl_exec($ch);
  	curl_close($ch);
  	return $data;
  }
  /**
   * 根据日前获取相对应得星座
   * @param $date 日期
   * @return 星座名称
   */
  public static function getDateSx($date){
  	$time = strtotime($date);
  	$getMonth = date('m',$time);
  	$getDate = date('d',$time);
  	switch($getMonth) {
  	case 1:
  		if($getDate < 20) {
  			$constellation = '摩羯座';
  		} else {
  			$constellation = '水瓶座';
  		}
  		break;
  	case 2:
  		if($getDate < 19) {
  			$constellation = '水瓶座';
  		} else {
  			$constellation = '双鱼座';
  		}
  		break;
  	case 3:
  		if($getDate < 21) {
  			$constellation = '双鱼座';
  		} else {
  			$constellation = '白羊座';
  		}
  		break;
  	case 4:
  		if($getDate < 20) {
  			$constellation = '白羊座';
  		} else {
  			$constellation = '金牛座';
  		}
  		break;
  	case 5:
  		if($getDate < 21) {
  			$constellation = '金牛座';
  		} else {
  			$constellation = '双子座';
  		}
  		break;
  	case 6:
  		if($getDate < 22) {
  			$constellation = '双子座';
  		} else {
  			$constellation = '巨蟹座';
  		}
  		break;
  	case 7:
  		if($getDate < 23) {
  			$constellation = '巨蟹座';
  		} else {
  			$constellation = '狮子座';
  		}
  		break;
  	case 8:
  		if($getDate < 23) {
  			$constellation = '狮子座';
  		} else {
  			$constellation = '处女座';
  		}
  		break;
  	case 9:
  		if($getDate < 23) {
  			$constellation = '处女座';
  		} else {
  			$constellation = '天秤座';
  		}
  		break;
  	case 10:
  		if($getDate < 24) {
  			$constellation = '天秤座';
  		} else {
  			$constellation = '天蝎座';
  		}
  		break;
  	case 11:
  		if($getDate < 23) {
  			$constellation = '天蝎座';
  		} else {
  			$constellation = '射手座';
  		}
  		break;
  	case 12:
  		if($getDate < 22) {
  			$constellation = '射手座';
  		} else {
  			$constellation = '摩羯座';
  		}
  		break;
  	default:
  		$constellation = '未知';
  		break;
  	}
  	return $constellation;
  }
}