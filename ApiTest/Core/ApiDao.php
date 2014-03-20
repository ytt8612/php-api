<?php

abstract class Core_ApiDao extends Core_ApiSingleton{

    protected $_tableClass;

    protected function __construct() {
        parent::__construct();
        $class = get_called_class();
        $this->_tableClass = str_replace('Dao_', 'Table_', $class);
    }

    /**
     * @return Core_Db_Table
     */
    public function getTable()
    {
        $class = $this->_tableClass;
        return $class::getInstance();
    }

    public function find($pk){
        return $this->getTable()->find($pk);
    }

    public function findAll(array $pks)
    {
        return $this->getTable()->findAll($pks);
    }

    public function insert($data)
    {
        return $this->getTable()->insert($data);
    }

    public function update($data, array $where = null)
    {
        return $this->getTable()->update($data, $where);
    }

    public function delete($where)
    {
        return $this->getTable()->delete($where);
    }

}
