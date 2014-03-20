<?php

class Core_Filter_ApiLowerCase implements Core_Filter_ApiInterface
{
    public function execute ($data)
    {
        return strtolower($data);
    }
}