<?php
/**
 * 加好友申请接口
 * @author 严廷廷
 *
 */

class App_Message_Applyfriend extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$ids = explode ( ',', $this->params ['ids'] );
		$userids = array ();
			foreach ( $ids as $i ) {
				$re = Service_Message::getInstance ()->addFriendMsg ( $info ['userid'], $i, $this->params ['content'] );
				if ($re && ! in_array ( $i, $userids )) {
					$userids [] = $i;
				}
			}
			if ($re && ! empty ( $userids )) {
				return array (
						'apply' => 1 
				);
			} else {
				return array (
						'apply' => 0 
				);
			}

	}
	public function paramRules() {
		return array (
				'ids' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty () 
						) 
				),
				'content' => array (
						'default' => '' 
				) 
		);
	}
}