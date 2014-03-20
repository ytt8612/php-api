<?php
/**
 * App_Circle_List 圈子列表接口
 * @author anneyan
 * 
 */
class App_Circle_List extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		if ($this->params['type']==1){
			$rs = Service_Circle::getInstance()->getJoinCircleByUid($info['userid']);
		}elseif($this->params['type']==2){
			$ret = Service_Circle::getInstance()->getCircleList($this->params['page'],$this->params['num']);
			$rs = $ret['arr'];
		}
		$rs = array_values($rs);
		$list = array();
		if(!empty($rs)){
			foreach ($rs as &$val){
				$val['time']=strtotime($val['time']);
			}
		}
		return array('havenext'=>isset($ret['havenext']) ? $ret['havenext'] : 0,'list'=>$rs);
	}
	public function paramRules() {
		return array (
				'type' => array (
						'default'=>1
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