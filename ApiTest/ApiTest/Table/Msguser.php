<?php
class Table_Msguser extends Core_Db_ApiTable{

	protected $_tablename = 'msg_user';

	protected $_pk = 'id';
	/**
	 * @return Table_Msguser
	 */
	public static function getInstance() {
		return parent::getInstance ();
	}
		/**
	 * 发私信
	 * @param $fromUserid 发信人ID
	 * @param $to_userid 收信人ID
	 * @param $content 私信内容
	 * @param $kind   1 => 私信对话， 2 => 借书私信,3=>乐享豆交易
	 * @param $var1  扩展字段
	 * @return int
	 */
	public function sendMsg($fromUserid,$to_userid,$content,$kind=1,$var1=''){
		if ($to_userid > $fromUserid) {
			$union_id = $to_userid . '-' . $fromUserid;
		} else {
			$union_id = $fromUserid . '-' . $to_userid;
		}
		$data = array(
				  'userid'=>$to_userid,
				  'fid'=>$fromUserid,
				  'content'=>$content,
				  'union_id'=>$union_id,
				  'kind'=>$kind,
				  'var1'=>$var1,
				  'time'=>date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'])
				);
		return $this->insert($data);
	}
	/**
	 * 获取私信对话列表
	 * @param $fromUserid 发件人ID
	 * @param $to_userid 收件人ID
	 * @param $last_id 
	 * @param $page
	 * @param $num
	 * @return array
	 */
	public function getMsgChat($from_userid,$to_userid,$page=1,$num=20,$last_id=0){
		$offset = $num*($page-1);
		$limit = $num;
		$undeleted_flag = array();
		if ($to_userid > $from_userid) {
			$union_id = $to_userid . '-' . $from_userid;
			$undeleted_flag = array(0, 1);
		} else {
			$union_id = $from_userid . '-' . $to_userid;
			$undeleted_flag = array(0, 2);
		}
		if($last_id){
			$rs = $this->getQuery()->where('union_id = ?', $union_id)->where('id < ?', $last_id)->whereIn('del',$undeleted_flag)->limit($limit,0)->order(' id DESC')->fetchAll();
		}else{
			$rs = $this->getQuery()->where('union_id = ?', $union_id)->whereIn('del',$undeleted_flag)->limit($limit,$offset)->order(' id DESC')->fetchAll();
		}
		return $rs;
	}
	/**
	 * 获取借书私信对话列表
	 * @param  $to_userid 收信人ID
	 * @param  $from_userid 发件人ID
	 * @param  $kind  消息类型
	 * @param  $var1 扩展字段 消息ID
	 * @return $list
	 */
	function getLoanMsgChat($to_userid, $from_userid,$msg_kind,$var1=''){
		$undeleted_flag = array();
		if ($to_userid > $from_userid) {
			$union_id = $to_userid . '-' . $from_userid;
			$undeleted_flag = array(0, 1);
		} else {
			$union_id = $from_userid . '-' . $to_userid;
			$undeleted_flag = array(0, 2);
		}
		if($var1){
			$rs = $this->getQuery()->where('union_id = ?', $union_id)->where('kind = ?', $msg_kind)->where('var1 = ?', $var1)->whereIn('del',$undeleted_flag)->order(' id DESC')->fetchAll();
		}else{
		  $rs = $this->getQuery()->where('union_id = ?', $union_id)->where('kind = ?', $msg_kind)->whereIn('del',$undeleted_flag)->order(' id DESC')->fetchAll();
		}
		return $rs;
	}
}