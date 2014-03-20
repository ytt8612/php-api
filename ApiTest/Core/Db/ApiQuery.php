<?php
class Core_Db_ApiQuery {

    protected $select = '*';
    protected $condition = '';
    protected $num = 0;
    protected $offset = 0;
    protected $order = '';
    protected $group = '';
    protected $having = '';
    protected $_params = array();

    /**
     *
     * @return string the sql
     */
    public function __toString() {
        return $this->getSql('{$tablename}');
    }

    /**
     *
     * @return array
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     *
     * @param string $tablename
     * @return string
     */
    public function getSql($tablename) {
        $sql = 'SELECT ' . $this->select . ' FROM ' . $tablename;
        $sql = (!empty($this->condition) ) ? $sql . ' WHERE ' . $this->condition : $sql;
        $sql = (!empty($this->group) ) ? $sql . ' GROUP BY  ' . $this->group : $sql;
        $sql = (!empty($this->having) ) ? $sql . ' HAVING  ' . $this->having : $sql;
        $sql = (!empty($this->order) ) ? $sql . ' ORDER BY ' . $this->order : $sql;
        if ($this->num > 0) {
            $sql .= ' LIMIT ' . $this->offset . ',' . $this->num;
        }
        return $sql;
    }

    public function __construct() {
        ;
    }

    /**
     *
     * @param type $condition
     * @param array $values
     * @param type $operator
     * @return Core_Db_Query
     */
    public function addCondition($condition, $values = array(), $operator = 'AND') {
        if ($this->condition == '') {
            $this->condition = $condition;
        } else {
            $this->condition = '(' . $this->condition . ') ' . $operator . ' (' . $condition . ')';
        }
        $this->_params = array_merge($this->_params, (array)$values);
        return $this;
    }

    /**
     *
     * @param type $column
     * @param array $values
     * @param type $operator
     * @return type
     */
    public function addInCondition($column, array $values, $operator = 'AND') {

        $condition = $column . " IN (" . rtrim(str_repeat('?,', count($values)), ',') . ")";

        return $this->addCondition($condition, $values, $operator);
    }

    /**
     *
     * @param type $num
     * @param type $offset
     * @return Core_Db_Query
     */
    public function limit($num, $offset = 0) {
        $this->num = intval($num);
        $this->offset = intval($offset);
        return $this;
    }

    public function sort($sort)
    {
        $this->order = $sort;
    }

    /**
     *
     * @param type $columns
     * @return Core_Db_Query
     */
    public function select($columns = '*') {
        $this->select = $columns;
        return $this;
    }

}
