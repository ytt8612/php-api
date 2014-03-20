<?php
class Task_Statua_Sync extends Core_ApiTask {

	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
	
		 Service_Status::getInstance()->sendSyncStatus($this->params['status_id'],$this->params['sync_tag'], $info['userid']);
		 
	}

	public function paramRules() {
		return array(
				'status_id' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				),
				'sync_tag' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				),
		);
	}

}