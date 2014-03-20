<?php
/**
 * Filter Class
 *
 * *************************************************************************
 * @example
 *       $filter = new Filter('<HTML>\'"&');
 *       $filter->addFilter(new Filter_Html());
 *       $filter->addFilter(new Filter_LowerCase());
 *       echo 'Raw Data:', $filter->getRawData();
 *       echo 'Clean Data:', $filter;
 *
 * *************************************************************************
 */

class Core_ApiFilter
{

    private $_filterStack = array();

    protected $_rawData;

    protected $_cleanData;

    public function __construct ($data = NULL)
    {
        $this->setData($data);
    }

    public function setData ($data)
    {
        $this->_rawData = $data;
        $this->_cleanData = $data;
    }

    public function getRawData ()
    {
        return $this->_rawData;
    }

    public function addFilter ($filter)
    {
        $this->_filterStack[] = $filter;
    }

    public function setFilters (array $filters)
    {
        $this->_filterStack = $filters;
    }

    /**
     * @return $this->_cleanData
     */
    public function execute ()
    {
        foreach ($this->_filterStack as $filter) {
            $this->_cleanData = $filter->execute($this->_cleanData);
        }
        return $this->_cleanData;
    }

    public function __toString ()
    {
        return $this->execute();
    }
}
?>