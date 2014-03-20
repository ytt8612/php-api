<?php
class Table_Message extends Core_Db_ApiTable{

	protected $_tablename = 'system_msgs';

	protected $_pk = 'msg_id';

	/**
	 * 数据库字段名
	 *
	 * @var type array
	 */
	protected $_fields = array ();
	/**
	 *
	 * @return Table_Message
	*/
	public static function getInstance(){
		return parent::getInstance();
	}
	
	/**
	 * 添加消息
	 * @param  $from_userid 发起方ID
	 * @param  $to_userid 接受方ID
	 * @param  $msg_kind 消息类型
	 * @param  $msg_content 消息内容
	 * @param  $msg_type 消息类型: 1 => 系统通知， 2 => 交互类型
	 * @param  $var1 扩展字段
	 * @param  $ext_id 扩展字段
	 * @return  int|boolean
	 */
	public function addMessage($from_userid,$to_userid,$msg_kind,$msg_content,$msg_type=1,$var1='',$ext_id=0){
		$data = array(
				 'from_userid'=>$from_userid,
				 'to_userid'=>$to_userid,
				 'msg_kind'=>$msg_kind,
				 'msg_content'=>$msg_content,
				 'msg_type'=>$msg_type,
				 'var1'=>$var1,
				 'ext_id'=>$ext_id,
				 'create_time'=>date('Y-m-d H:i:s')
				);
		return $this->getQuery()->insert($data);
	}
	/**
	 * 获取用户收到的消息
	 * @param $userid 用户id
	 * @param $msg_kind 消息类型
	 * @return array
	 */
	public function getMsgByKind($userid,$msg_kind){
		$rs = $this->getQuery()->where('to_userid = ?', $userid)->where('msg_kind= ?', $msg_kind)->fetchAll();
		return $rs;
	}
	/**
	 * 是否收到过加好友申请
	 * @param  $from_userid 发起方ID
	 * @param  $to_userid 接受方ID
	 * @return array
	 * 
	 */
	public function getReqMsg($from_userid,$to_userid,$msg_kind){
		$rs = $this->getQuery()->where('from_userid = ?', $from_userid)->where('to_userid = ?', $to_userid)->where('msg_kind= ?', $msg_kind)->fetchAll();
		return $rs;
	}
	/**
	 * 修改申请好友消息
	* @param $userid 用户id
	 * @param $msg_kind 消息类型
	 */
	public function updateRegMsg($from_userid,$to_userid,$msg_kind,$result){
		$sql ="update system_msgs set result = 1 where from_userid = $from_userid and to_userid = $to_userid and msg_kind = 2 ";
		$rs= $this->query($sql);
		return $rs;
	}
}