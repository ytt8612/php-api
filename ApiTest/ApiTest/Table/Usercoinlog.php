<?php
/**
 * 用户乐享豆日志表
 * @author 严廷廷
 *
 */
class Table_Usercoinlog extends Core_Db_ApiTable{

	protected $_tablename = 'user_coin_log';

	protected $_pk = 'id';

	/**
	 * 数据库字段名
	 *
	 * @var type array
	 */
	protected $_fields = array ();
	/**
	 *
	 * @return Table_Bookcomment
	*/
	public static function getInstance(){
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
		$offset = $num*($page-1);
		$limit = $num;
		$rs = $this->getQuery()->where('userid = ?', $userid)->limit($limit,$offset)->order(' id DESC')->fetchAll();
		return $rs;
	}
	/**
	 * 根据action_code 查询用户乐享豆记录
	 * @param  $userid 用户id
	 * @param  $code action_code 操作代码
	 * @return  array
	 */
	public function getUserLogByCode($userid,$code){
		return $this->getQuery()->where('userid = ?', $userid)->where('code = ?', $code)->order('id desc')->fetchAll();
	}
	
	/**
	 * 根据action_code 查询用户乐享豆值
	 * @param  $userid 用户id
	 * @param  $code action_code 操作代码
	 * @param  $date 查询日期限制 格式ymd 
	 * @return  array
	 */
	public function getActionTotalByCode($userid,$code,$date=''){
		if($date){
			$rs = $this->getQuery()->where('userid = ?', $userid)->where('code = ?', $code)->where('dayup = ?', $date)->select(' sum( coin) as num')->fetch();
		}else{
		 $rs = $this->getQuery()->where('userid = ?', $userid)->where('code = ?', $code)->select(' sum( coin) as num')->fetch();
		}
		return $rs ? $rs['num']:0;
	}
}