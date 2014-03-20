<?php

/**
 * 一个简易的对称加密解密算法实现类
 *
 */
class Lib_Crypt {

	//密钥
	private static $key = 'yiban_21campus';

	private function __construct() {
	}
	
	/**
	 * 加密
	 *
	 * @param string $string  需要加密的字符串
	 *
	 */
	public static function encode($string) {
			
		$encode_str = '';

		$base64_str = base64_encode($string);
		$base64_str_len = strlen($base64_str);
		$base64_key = base64_encode(self::$key);
		$base64_key_len = strlen($base64_key);
			
		for($i = 0; $i < $base64_str_len ; $i ++) {

			$str_ord = ord($base64_str[$i]);
			$key_ord = ord($base64_key[$i % $base64_key_len]);
			$ord = $str_ord ^ $key_ord;
			$chr = chr($ord);
			$encode_str .= $chr;
		}
			
		return base64_encode($encode_str);
	}
	/**
	 * 加密
	 *
	 * @param string $string  需要解密的字符串
	 *
	 */
	public static function decode($string) {
			
		$decode_str = '';
			
		$base64_str = base64_decode($string);
		$base64_str_len = strlen($base64_str);
		$base64_key = base64_encode(self::$key);
		$base64_key_len = strlen($base64_key);
			
		for($i = 0; $i < $base64_str_len ; $i ++) {

			$ord = ord($base64_str[$i]);
			$key_ord = ord($base64_key[$i % $base64_key_len]);
			$str_ord = $ord ^ $key_ord;
			$chr = chr($str_ord);
			$decode_str .= $chr;
		}
			
		return base64_decode($decode_str);
	}
}