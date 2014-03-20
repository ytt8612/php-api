<?php

interface Core_Dao_ApiDataProviderInterface {
    //put your code here
    public function find($pk);

    public function findAll(array $pks);

    public function insert($data);

    public function update($data, array $where = null);

    public function delete($pk);
    
}
