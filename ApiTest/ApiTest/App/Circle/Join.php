<?php
/**
 * Circle_Join 加入圈子接口
 * @author anneyan
 */
class App_Circle_Join extends Core_ApiApplication {
	public function run() {
		ini_set ( 'display_errors', 'On' );
		error_reporting ( E_ALL );
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$circle_id = $this->params ['circle_id'];
		$circle = Service_Circle::getInstance ()->getCricleById ( $this->params ['circle_id'] );
		if (! $circle) {
			throw new Exception_Yiban ( Lang_Zh_Common::CRICULR_NOT_EXIT, 101 );
		}
		$Circles = Service_Circle::getInstance ()->getJoinCircleByUid ( $info ['userid'] );
		$ids = array_keys ( $Circles );
		if (in_array ( $circle_id, $ids )) {
			throw new Exception_Yiban ( Lang_Zh_Common::CRICULR_EXIT_JOIN, 101 );
		}
		if (count ( $Circles ) >= Lang_Zh_Common::CIRCLE_MAX) {
			throw new Exception_Yiban ( Lang_Zh_Common::CRICULR_MAX_JOIN, 101 );
		}
		$ret = Service_Circle::getInstance ()->joinCircle ( $info ['userid'], $info ['username'], $circle ['circle_id'], $circle ['circle_name'] );
		if ($ret) {
			return array (
					'result' => 1 
			);
		} else {
			throw new Exception_Yiban ( Lang_Zh_Common::ACTION_ERROR, 101 );
		}
	}
	public function paramRules() {
		return array (
				'circle_id' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty () 
						) 
				) 
		);
	}
}