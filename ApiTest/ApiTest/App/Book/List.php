<?php
/**
 * App_Book_List 图书列表接口
 * @author naneYan
 */
Class App_Book_List extends Core_ApiApplication{
	public function run(){
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$rs = Service_Book::getInstance()->getBooksByTagId($this->params['tag_id'], $this->params['page'], $this->params['num']);
		if(isset($rs['list']))$ret = Vo_BookList::process ( $rs['list']);
		return array(
				  'havenext'=>isset($rs['havenext']) ? $rs['havenext'] :0,
				  'book_list'=>isset($rs['list']) ? $ret : array()
				);
		
	}
	public function paramRules ()
	{
		return array(
				'tag_id'=>array(
						'default'=>0
				),
				'page' => array (
						'default'=>1
				),
				'num' => array (
						'default'=>10
				),
	
		);
	}
}