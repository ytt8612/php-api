<?php
sendSms();

function sendSms(){
	$url ="http://www.6610086.cn/smsComputer/smsComputersend.asp?zh=149041668&mm=123456&hm=18516005286&nr=发送的短信内容&dxlbid=57";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_HEADER,FALSE);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$data = curl_exec($ch);
	curl_close($ch);
	var_dump($data);
}