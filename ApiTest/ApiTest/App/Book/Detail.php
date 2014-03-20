<?php
/**
 * App_Book_Detail 图书详情接口
 * @author 严廷廷  20140126
 */
class App_Book_Detail extends Core_ApiApplication{
	public function run(){
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$rs = Service_Book::getInstance()->getBookDetailById($this->params['pub_id']);
		if(empty($rs)){
			throw new Exception_Yiban( Lang_Zh_Common::BOOK_NOT_EXIT, 101);
		}
		$book =  Vo_Book::process ( $rs);
		return array('book_detail'=>$book);
	}
	public function paramRules ()
	{
		return array(
				'pub_id' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty ()
						)
				)
		);
	}
}