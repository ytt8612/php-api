<?php
/**
 * Circle_Add 添加圈子接口
 * @author anneyan
 */
Class App_Circle_Add extends Core_ApiApplication {
	public function run() {
		ini_set('display_errors', 'On');
		error_reporting(E_ALL);
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$rs = Service_Circle::getInstance()->getCricleByName($this->params['circle_name']);
		if($rs){
			throw new Exception_Yiban ( Lang_Zh_Common::CRICULR_EXIT, 101 );
		}
		
		$circle_id = Service_Circle::getInstance()->createCircle($info['userid'], $info['username'], $this->params['circle_name'], $this->params['kind'], $this->params['address'], $this->params['lat'], $this->params['lng']);
		if($circle_id){
			return array('circle_id'=>$circle_id);
		}else{
			throw new Exception_Yiban ( Lang_Zh_Common::CREATE_CRICULR_ERROR, 101 );
		}
	}
	public function paramRules() {
		return array(
				'circle_name' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				),
				'address' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				),
				'lng' => array(
						'validators' => array(
								new Core_Validator_ApiNumeric()
						)
				),
				'lat' => array(
						'validators' => array(
								new Core_Validator_ApiNumeric()
						)
				),
				'kind' => array(
						'default' => '1'
				)
		);
	}
}