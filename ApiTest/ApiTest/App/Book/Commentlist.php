<?php
/**
 * 发布图书评论列表接口
 * @author 严廷廷
 */
class App_Book_Commentlist extends Core_ApiApplication{
	public function run(){
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$rs = Service_Book::getInstance()-> getPubBookCommentList($this->params['pub_id'],$this->params['page'],$this->params['num']);
		
		if(isset($rs['list']))$ret = Vo_BookComment::process ( $rs['list']);
		return array(
				'havenext'=>isset($rs['havenext']) ? $rs['havenext'] : 0,
				'comment_list'=>isset($rs['list']) ? $ret : array()
		);
	}
	public function paramRules ()
	{
		return array(
			'pub_id' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty ()
						)
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