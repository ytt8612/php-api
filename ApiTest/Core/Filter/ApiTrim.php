<?php

class Core_Filter_ApiTrim implements Core_Filter_ApiInterface
{
    public function execute ($data)
    {
        return trim($data);
    }
}