<?php

class Core_Filter_ApiArray implements Core_Filter_ApiInterface
{
    public $filter;

    public function __construct(Core_Filter_ApiInterface $filter) {
        $this->filter = $filter;
    }

    public function execute ($data)
    {
        return array_map(array($this->filter, 'execute'), (array)$data);
    }
}