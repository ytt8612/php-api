<?php
/**
 * 图书信息采集接口
 * @author ytt@yiban.cn
 */
class App_Book_Info  extends Core_ApiApplication {

	public function run(){
		ini_set('display_errors', 'On');
		error_reporting(E_ALL);
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
   $rs = Service_Book::getInstance()->addBookInfo($this->params['isbn']);
   $book_image = Lib_Util::get_book_photo($rs['id']);
   $rs['image'] = $book_image ? $book_image : $rs['image'];
   return array('book'=>$rs);
	}
	public function paramRules ()
	{
		return array(
				'isbn' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty ()
						)
				)

		);
	}
}