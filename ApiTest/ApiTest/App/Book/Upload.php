<?php
/**
 * 图书发布接口
 * @author ytt@yiban.cn
 */
class App_Book_Upload extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (empty ( $info )) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$book = Service_Book::getInstance ()->getBookInfoById ( $this->params ['book_id'] );
		if (empty ( $book )) {
			throw new Exception_Yiban ( Lang_Zh_Common::BOOK_NOT_EXIT, 101 );
		}
		//不能重复上架图书
		/* $canPub = Service_Book::getInstance ()->canPubBook ( $info ['userid'], $this->params ['book_id'] );
		if (! $canPub) {
			throw new Exception_Yiban ( Lang_Zh_Common::BOOK_PUB_EXIT, 101 );
		} */
		$pub_id = Service_Book::getInstance ()->pubBook ( $book ['id'], $info ['userid'], $info ['username'], $this->params ['lent_way'], $this->params ['deposit_type'], $this->params ['deposit'], $this->params ['loan_period'], $this->params ['sskey'], $this->params ['public'], $this->params ['remark'],$this->params ['lat'],$this->params ['lng'],$this->params ['address'] );
		if ($pub_id ) {
			//第一次上传图书加乐享豆
			Service_Pay::getInstance()->addUserCoin($info ['userid'],'pub_book',0,0,1);
			
		}else{
			throw new Exception_Yiban ( Lang_Zh_Common::BOOK_PUB_ERROR, 101 );
		}
		return array (
				'pub_id' => $pub_id 
		);
	}
	public function paramRules() {
		return array (
				'book_id' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty () 
						) 
				),
				'lent_way' => array (
						'default' => 1 
				),
				'deposit_type' => array (
						'default' => 1 
				),
				'deposit' => array (
						'default' => 0 
				),
				'loan_period' => array (
						'default' => 0 
				),
				'sskey' => array (
						'default' => '' 
				),
				'public' => array (
						'default' => 1 
				),
				'lat' => array (
						'default' => ''
				),
				'lng' => array (
						'default' => 1
				),
				'address' => array (
						'default' => 1
				),
				'remark' => array (
						'default' => '' 
				) 
		);
	}
}