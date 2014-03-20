<?php

class Core_ApiArrayObject implements ArrayAccess {

    /****************************************************
     * Realize ArrayAccess Interface
     ****************************************************/
    public function offsetExists ($index) {
        return property_exists($this, $index);
    }

    public function offsetGet ($index) {
        return $this->$index;
    }

    public function offsetSet ($index, $value) {
        $this->$index = $value;
    }

    public function offsetUnset ($index) {
        unset($this->$index);
    }

}
