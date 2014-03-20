<?php
/**
 * 用户行为乐享豆配置表
 * @author 严廷廷
 *
 */
class Table_Actionconfig extends Core_Db_ApiTable{

	protected $_tablename = 'user_action_config';

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
	 * 获取乐享豆规则列表
	 * @return array
	 */
	public function getActionConfigs(){
		$rs = $this->getQuery()->fetchAll();
		$data = array();
		if($rs){
			foreach ($rs as $val) {
				$data[$val['code']] = $val;
			}
		}
		return $data;
	}
}