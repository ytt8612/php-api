<?php
$mem = new Memcache
;
$mem->connect("10.21.118.243", 60000)or die ("Could not connect");
 
//$mem->set('key', 'This is a test!', 0, 360);
$val = $mem->get('key');
echo $val;
?>