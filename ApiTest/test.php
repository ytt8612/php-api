<?php 
 //phpinfo();
 
set_time_limit(0);
require ('resizeimage.php');
$file =  new resizeimage("public/images/23_s.jpg", "200", "100", "0","public/images/1.jpg");
var_dump($file);
//$gmagick = new Gmagick_Handler();
// $gmagick->make_thumb("public/images/23_s.jpg",200,300,true,80,"newimage/1.jpg");