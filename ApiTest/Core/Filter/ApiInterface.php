<?php
interface Core_Filter_ApiInterface{
    /**
     * @return mixed filtered var
     */
    public function execute($data);
}