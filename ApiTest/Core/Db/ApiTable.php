<?php

abstract class Core_Db_ApiTable extends Core_ApiSingleton implements Core_Dao_ApiDataProviderInterface {

    protected $_pk = 'id';
    protected $_tablename;

    /**
     * @var PDO
     */
    protected $_conn;

    /**
     *
     * @var Core_Db_Query
     */
    protected $_query;
    protected $_model;

    protected function __construct() {
        parent::__construct();
        $class = get_called_class();
        if (!$this->_tablename) {
            $this->_tablename = strtolower(preg_replace('([A-Z])', '_\0', lcfirst(substr($class, 6))));
        }
        $this->_model = str_replace('Table_', 'Model_', $class);
    }

    /**
     *
     * @return PDO
     */
    public function getConnection($name = 'default') {
        if (!$this->_conn) {
            $this->_conn = Core_Db_ApiConnection::getInstance($name);
        }
        return $this->_conn;
    }

    protected function switchConnection($name) {
        $this->_conn = Core_Db_ApiConnection::getInstance($name);
    }

    /**
     *
     * @return Core_Db_Table
     */
    public function getQuery() {
        $this->_query = new Core_Db_ApiQuery();
        return $this;
    }

    /**
     *
     * @return Core_Db_Table
     */
    public function select($columns = '*') {
        $this->_query->select($columns);
        return $this;
    }

    public function getSql() {
        return strval($this->_query);
    }

    public function getPK() {
        return $this->_pk;
    }

    public function __toString() {
        return $this->_tablename;
    }

    /**
     *
     * @param type $query
     * @return PDOStatment
     */
    protected function _prepareQuery($query) {
        if (!$query) {
            $query = $this->_query;
        }

        $statement = $this->getConnection()->prepare($query->getSql($this->_tablename), array(
            PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY,
                ));
        $statement->execute($query->getParams());
        return $statement;
    }

    /**
     *
     * @param Core_Db_Query $query
     * @return Model class | false on failure
     */
    public function fetch(Core_Db_ApiQuery $query = null) {
        $statement  = $this->_prepareQuery($query);
        $statement->setFetchMode(PDO::FETCH_CLASS, $this->_model);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    /**
     *
     * @param Core_Db_Query $query
     * @return mixed | false on failure
     */
    public function count(Core_Db_ApiQuery $query = null) {
        if (!$query) {
            $query = $this->_query;
        }
        $query->select("count({$this->_pk})");
        return $this->_prepareQuery($query)->fetchColumn();
    }

    /**
     *
     * @param array $params
     * @return array of Model class | false on failure
     */
    public function fetchAll(Core_Db_ApiQuery $query = null) {
        $statement  = $this->_prepareQuery($query);
       // print_r( $statement);
        $statement->setFetchMode(PDO::FETCH_CLASS, $this->_model);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function where($condition, $param = array(), $operator = 'AND') {
        $this->_query->addCondition($condition, $param, $operator);
        return $this;
    }

    public function whereIn($condition, $param, $operator = 'AND') {
        $this->_query->addInCondition($condition, $param, $operator);
        return $this;
    }

    public function limit($num, $offset = 0) {
        $this->_query->limit($num, $offset);
        return $this;
    }

    public function sort($sort) {
        $this->_query->sort($sort);
        return $this;
    }

    public function order($sort)
    {
        return $this->sort($sort);
    }

    /* *******************************************
     * implement interface
     * ***************************************** */

    /**
     *
     * @param type $data
     * @return int last_insert_id | false on failure
     */
    public function insert($data) {
        $columns = '(';
        $values = array();
        $takens = '(';
        foreach ($data as $column => $value) {
        	
            if ($value !== null){
                if (is_array($value)){
                    $columns .= "`{$column}`,";
                    $takens .= "{$value['sql']},";
                }else{
                    $columns .= "`{$column}`,";
                    $takens .= ":{$column},";
                    $values[":{$column}"] = $value;
                }
            }
        }
        $columns = rtrim($columns, ',') . ')';
        $takens = rtrim($takens, ',') . ')';

        $statement = $this->getConnection()->prepare('INSERT INTO ' . $this->_tablename . $columns . ' VALUES ' . $takens);

       //var_dump('INSERT INTO ' . $this->_tablename . $columns . ' VALUES ' . $takens);exit();

        if ($statement->execute($values)) {
            return $this->getConnection()->lastInsertId();
        } else {
            $error = $statement->errorInfo();
            //var_dump($error);
            throw new Core_Db_ApiException($error[2], $error[0]);
        }
    }

    public function update($data, array $where = null) {
        $columns = '';
        $where_arr = array();
        $values = array();
        foreach ($data as $column => $value) {
            if ($value !== null) {
                if ($column == $this->_pk) {
                    $where_arr[] = "`{$this->_pk}` = :_pk";
                    $values[':_pk'] = $value;
                } else {
                    if (is_array($value)){
                        $columns .= "`{$column}` = {$value['sql']},";
                    }else{
                        $columns .= "`{$column}` = :{$column},";
                        $values[":{$column}"] = $value;
                    }
                }
            }
        }
        $columns = rtrim($columns, ',');

        if ($where) {
            foreach ($where as $column => $value) {
                $column = explode(' ', trim($column));
                if (count($column) == 2) {
                    $colname = $column[0];
                    $column = "`$colname` $column[1]";
                } else {
                    $colname = $column[0];
                    $column = "`$colname` =";
                }
                if (is_array($value)){
                    $where_arr[] = "{$column} {$value['sql']}";
                }else{
                    $where_arr[] = "{$column} :_where_{$colname}";
                    $values["_where_{$colname}"] = $value;
                }
            }
        }
        $sql_where = ' WHERE 1 = 1';
        foreach ($where_arr as $w) {
            $sql_where .= " AND $w";
        }

//        var_dump('UPDATE ' . $this->_tablename . ' SET ' . $columns . $sql_where);exit();

        $statement = $this->getConnection()->prepare('UPDATE ' . $this->_tablename . ' SET ' . $columns . $sql_where);
        if ($statement->execute($values)) {
            return true;
        } else {
            $error = $statement->errorInfo();
            throw new Core_Db_ApiException($error[2], $error[0]);
        }
    }

    public function delete($where) {
        $where_arr = array();
        $values = array();
        if (is_array($where)) {
            foreach ($where as $column => $value) {
                $column = explode(' ', trim($column));
                if (count($column) == 2) {
                    $colname = $column[0];
                    $column = "`$colname` $column[1]";
                } else {
                    $colname = $column[0];
                    $column = "`$colname` =";
                }

                $where_arr[] = "{$column} :_where_{$colname}";
                $values["_where_{$colname}"] = $value;
            }

        } else {
            $where_arr[] = "{$this->_pk} = :_where_pk";
            $values[':_where_pk'] = $where;
        }
        $sql_where = ' WHERE 1 = 1';
        foreach ($where_arr as $w) {
            $sql_where .= " AND $w";
        }

//        var_dump('DELETE FROM ' . $this->_tablename . $sql_where);exit();
        $statement = $this->getConnection()->prepare('DELETE FROM ' . $this->_tablename . $sql_where);
        if ($statement->execute($values)) {
            return true;
        } else {
            $error = $statement->errorInfo();
            throw new Core_Db_ApiException($error[2], $error[0]);
        }
    }

    /**
     * find row by pk
     *
     * @param mixed
     */
    public function find($pk) {
        return $this->getQuery()->where("{$this->_pk} = ?", $pk)->fetch();
    }

    public function findAll(array $pks, $keep_order = false) {
        $q = $this->getQuery()->whereIn($this->_pk, $pks);
        if ($keep_order) {
            $in_str = implode(',', $pks);
            $q->sort("FIND_IN_SET(id, '{$in_str}')");
        }
        return $q->fetchAll();
    }
    
   /**
    * @param  $sql
    * @return PDOStatment
    */
    public function query($sql){
    	$statement = $this->getConnection()->query($sql);
    	if($statement){
    	return $statement->fetchAll(PDO::FETCH_ASSOC);
    	}else{
    	//$error = $statement->errorInfo();
    	//var_dump($error);
    	//throw new Core_Db_ApiException($error[2], $error[0]);
    	return false;
    	}
    }

}
