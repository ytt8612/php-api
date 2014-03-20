<?php
/**
 * Book_Comment 图书添加评论接口
 * @author 严廷廷
 */
class App_Book_Comment extends Core_ApiApplication{
	public function run(){
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$book = Service_Book::getInstance()->getBookDetailById($this->params['pub_id']);
		if(empty($book)){
			throw new Exception_Yiban( Lang_Zh_Common::BOOK_NOT_EXIT, 101);
		}
		if(!in_array($this->params['points'],array(0,1,2,3,4,5))){
			throw new Exception_Yiban( Lang_Zh_Common::PARAM_ERROR, 101);
		}
		$commentid = Service_Book::getInstance()->addPubBookComment($info['userid'],$info['username'],$this->params['pub_id'],$this->params['content'],$this->params['points']);
		if($commentid){
			return array('comment_id'=>$commentid);
		}else{
			throw new Exception_Yiban( Lang_Zh_Common::ACTION_ERROR, 101);
		}
	}
	public function paramRules ()
	{
		return array(
				'pub_id' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty ()
						)
				),
				'content' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty ()
						)
				),
				'points' => array (
								new Core_Validator_ApiNumeric() 
						)
		);
	}
}