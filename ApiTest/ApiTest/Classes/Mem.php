<?php

class Mem
{
    private $memcache = null;
    private $HOST = '10.21.118.243';
    private $PORT = 60000;
    
    
    
    public function __construct()
   {
       
        $this->memcache = new Memcache;
        $this->memcache->connect($this->HOST, $this->PORT);
    }
   
   
   
    public function get($name) {
       
        $value = $this->memcache->get($name);
        return $value;
    }
   
    public function set($name, $value, $ext1 = false, $ttl= 0) {
       
          return $this->memcache->set($name, $value, $ext1, $ttl);
    }
   
    public function add($name, $value, $ext1 = false, $ttl= 0) {
       
        return $this->memcache->add($name, $value , $ext1, $ttl);
    }
    
    public function delete($name) {
       
        return $this->memcache->delete($name);
    }
   
   
    public function close() {
       
        return $this->memcache->close();
    }
   
    public function increment($name , $value) {
       
        return $this->memcache->increment($name, $vlaue);
    }
   
   
    public function decrement($name , $value) {
       
        return $this->memcache->decrement($name,  $value);
    }
   
   
    public function getExtendedStats() {
       
        return $this->memcache->getExtendedStats();
    }
   
   
    public function getStats() {
       
        return $this->memcache->getStats();
    }
   
    public function flush() {
       
        return $this->memcache->flush();
    }
       
    
}


?>

