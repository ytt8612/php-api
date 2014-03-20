<?php

class Core_Filter_ApiBoolean implements Core_Filter_ApiInterface
{
    public function execute ($data)
    {
        return (bool)$data;
    }
}