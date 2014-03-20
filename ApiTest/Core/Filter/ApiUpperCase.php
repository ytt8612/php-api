<?php

class Core_Filter_ApiUpperCase implements Core_Filter_ApiInterface
{
    public function execute ($data)
    {
        return strtoupper($data);
    }
}