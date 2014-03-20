<?php
/**
 * 乐享豆处理类
 * @author 严廷廷
 */
class Service_Pay extends Core_ApiService {

	/**
	 * @return Service_Pay
	 */
	public static function getInstance() {
		return parent::getInstance();
	}
	/**
	 * 获取用户乐享豆日志列表
	 * @param $userid 用户id
	 * @param $page 页数
	 * @param $num 条数
	 * @return array
	 */
	public function getCoinLogList($userid,$page,$num){
		$page = $page>=1 ? $page : 1;
		$rs['arr'] = Table_Usercoinlog::getInstance()->getCoinLogList($userid,$page,$num);
		$rs['havenext'] = 0;
		if (count($rs['arr']) >= $num ) {
			array_pop($rs['arr']);
			$rs['havenext'] = 1;
		}
		
		return $rs;
	}
	/**
	 * 获取乐享豆系统规则配置
	 * @return  array
	 */
	public function getActionConfigs(){
		return Table_Actionconfig::getInstance()->getActionConfigs();
	}
	/**
	 * 转增乐享豆
   * @param $fromuserid 当前操作的用户ID
	 * @param $to_userid  接受者ID
	 * @param $coin
	 * @return array
	 */
	public function rollOutCoin($fromuserid,$to_userid,$coin){
		$action_configs = Table_Actionconfig::getInstance()->getActionConfigs();
		//赠送着 转出乐享豆
		$code ='roll_out';
		$configs = isset($action_configs[$code]) ? $action_configs[$code] : false;
		$fromuser_info = Table_Userinfo::getInstance()->find($fromuserid);
		$user_info = Table_Userinfo::getInstance()->find($to_userid);
		if(empty($user_info)){
			return array('error'=>2,'message'=>'转赠用户不存在！');
		}
		$user_coin = $fromuser_info['coin'];
		if($user_coin<=0 || $user_coin<=$coin){
			return array('error'=>1,'message'=>'乐享豆余额不足！');
		}
		$coin_num = $user_coin - $coin;
		$entry = array(
				'userid'=>$fromuserid,
				'from_userid'=>$to_userid,
				'code'=>$code,
				'desc'=>$configs['name'],
				'coin'=>-$coin,
				'dayup'=>date('Ymd'),
				'dateline'=>date('Y-m-d H:i：s'),
				'kind'=>2
		);
		$logid = Table_Usercoinlog::getInstance()->insert($entry);
		if($logid){
			$data = array('user_id'=>$fromuserid,'coin'=>$coin_num);
			$rs = Table_Userinfo::getInstance()->update($data);
		}
		if($logid&&$rs){
			//受赠者增加乐享豆
			$code ='roll_in';
			$configs = isset($action_configs[$code]) ? $action_configs[$code] : false;
			$user_coin = $user_info['coin'];
			$coin_num = $user_coin + $coin;
			$entry2 = array(
					'userid'=>$to_userid,
					'from_userid'=>$fromuserid,
					'code'=>$code,
					'desc'=>$configs['name'],
					'coin'=>$coin,
					'dayup'=>date('Ymd'),
					'dateline'=>date('Y-m-d H:i：s'),
					'kind'=>2
			);
			$logid2 = Table_Usercoinlog::getInstance()->insert($entry2);
			if($logid2){
				$data = array('user_id'=>$to_userid,'coin'=>$coin_num);
				$rs2 = Table_Userinfo::getInstance()->update($data);
			}
		}
		return isset($rs2)&&$rs2 ? $logid2 : array('error'=>3,'message'=>'乐享豆入库失败！');
	}
	/**
	 * 添加乐享豆
	 * @param $to_userid  接受者ID
	 * @param $fromuserid 当前操作的用户ID
	 * @param $code 操作标示码
	 * @param $coin  乐享豆数目
	 * @param $kind 操作类型 1 系统 2 用户
	 * @return int
	 */
	public function addUserCoin($to_userid,$code,$from_userid=0,$coin=0,$kind=1){
		$action_configs = Table_Actionconfig::getInstance()->getActionConfigs();
		$configs = isset($action_configs[$code]) ? $action_configs[$code] : false;
		if(!empty($configs)){
			if($configs['coin_limit']>0){
				$action_coin = Table_Usercoinlog::getInstance()->getActionTotalByCode($to_userid,$code);
				if($action_coin>=$configs['coin_limit']){
					return array('error'=>1,'message'=>'乐享豆操作达到上限！');
				}
			}
			$coin = $configs['coin'] ? $configs['coin'] : $coin;
			//查询用户的乐享豆总数
			$user_info = Table_Userinfo::getInstance()->find($to_userid);
			$user_coin = $user_info['coin'];
			$coin_num = $user_coin + $coin;
			if($user_coin<=$coin){
				return array('error'=>2,'message'=>'乐享豆余额不足！');
			}
			$entry = array(
			  'userid'=>$to_userid,
				'from_userid'=>$from_userid,
				'code'=>$code,
				'desc'=>$configs['name'],
				'coin'=>$coin,
				'dayup'=>date('Ymd'),
				'dateline'=>date('Y-m-d H:i：s'),
				'kind'=>$kind
			);
			$logid = Table_Usercoinlog::getInstance()->insert($entry);
			if($logid){
			$data = array('user_id'=>$to_userid,'coin'=>$coin_num);
			$rs = Table_Userinfo::getInstance()->update($data);
			}
		}
		return isset($rs)&&$rs ? $coin_num : array('error'=>3,'message'=>'乐享豆入库失败！');
	}
}