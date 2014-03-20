<?php
/**
 * App_Book_Reserve  图书借阅接口
 * @author ytt
 */
class App_Book_Loan extends Core_ApiApplication {
	public function run(){
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$book = Service_Book::getInstance()->getBookDetailById($this->params['pub_id']);
		if(empty($book)){
			throw new Exception_Yiban( Lang_Zh_Common::BOOK_NOT_EXIT, 101);
		}
		if($book['book_status']!=1 || $book['loan_status']!=1){
			throw new Exception_Yiban( Lang_Zh_Common::BOOK_LENT_ERROE, 101);
		}
		if($book['user_id']==$info['userid']){
			throw new Exception_Yiban( Lang_Zh_Common::BOOK_LENT_ERROE, 101);
		}
			//图书借阅申请
		//	$rs = Service_Book::getInstance()->addLoanApplication($info['userid'],$book['user_id'],$this->params['pub_id'],$book['id'],$book['title'],$book['author'],$this->params['content'],$this->params['loan_time']);
		 $rs = Service_Book::getInstance()->addLoanApplication($info['userid'],$book['user_id'],$this->params['pub_id'],$book['title'],$this->params['loan_time'],$this->params['address'],$this->params['content']);
		return array('result'=>$rs);
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
				'loan_time' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty ()
						)
				),
				'address' => array (
						'default'=>''
				),
				'type' => array (
						'default'=>1
				)
		);
	}
}