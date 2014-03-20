<?php

class Core_Filter_ApiFloat implements Core_Filter_ApiInterface
{
    public function execute ($data)
    {
        return floatval($data);
    }
}