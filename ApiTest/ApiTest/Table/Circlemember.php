<?php
class Table_Circlemember extends Core_Db_ApiTable{

    protected $_tablename = 'circle_member';
    
    protected $_pk = 'id';
    
    /**
     * 数据库字段名
     *
     * @var type array
     */
    protected $_fields = array ();
    /**
     *
     * @return Table_Cricle
     */
    public static function getInstance(){
        return parent::getInstance();
    }
    /**
     * 查询加入圈子数据
     * @param $userid 用户ID
     * @return  int
     */
    function getJoinCircleCount($user_id){
    	return $this->getQuery()->where('user_id = ?', $user_id)->count();
    }
    /**
     * 查询用户加入的圈子
     * @param  $userid 用户ID
     * @return array
     */
    function getJoinCircleByUid($user_id){
    	$rs = $this->getQuery()->where('user_id = ?', $user_id)->order('time DESC')->fetchAll();
    	return $rs;
    }
}
