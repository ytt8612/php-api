<?php
header("Content-Type: text/html; charset=utf-8");
set_time_limit(0);
require ('JSONServer.php');
//JSONServer::setApiServerType('http://api.local/ApiTest/index_dev.php');         // 本地
JSONServer::setApiServerType('http://112.124.69.33/ApiTest/ApiTest/index_dev.php');         // 本地

$action = $_GET ['action'];
$havepic = false;
$picdata = '';

$data = array();
$data['ct'] = '1';
$data['rv'] = 'AppStore';
$data['v'] = '3.1.0';
$data['apn'] = 'wifi';
$data ['identify'] = 'r0dE7PP8fku';
$data ['imei'] = 'r0dE7PP8fku';
$data ['token'] = '';
$data['device'] ='ios7';
$data['sversion'] ='ios6.0.2';
//$data['error'] = '1';
$sid = '';
if (isset ( $_COOKIE ['sid'] )) {
	$sid = $_COOKIE ['sid'];
}
$data['sessID'] = $sid;
if ($action == 'security_reg') {
	$data ['data'] ['username'] = 'test';
	$data ['data'] ['email'] = '121943180@qq.com';
	$data ['data'] ['password'] = '11111';
	$data ['data'] ['phone_num'] = '15026641450';
	$data ['do'] = 'security_reg';
}elseif($action=='security_login'){
	$data ['data'] ['username'] = 'Test';
	$data ['data'] ['password'] = '11111';
}elseif ($action == 'book_info') {
	$data ['data']['isbn'] = '9787308083256';

}elseif ($action == 'book_list') {
	$data ['data']['tag_id'] = '26';

}elseif ($action == 'book_commentlist') {
	$data ['data']['pub_id'] = '26';

}elseif ($action == 'book_detail') {
	$data ['data']['pub_id'] = '27';

}elseif ($action == 'user_detail') {
	$data ['data']['user_id'] = '1';

}elseif ($action == 'book_reserve') {
	$data ['data']['pub_id'] = '27';
	$data ['data']['type'] = '2';

}elseif ($action == 'book_loan') {
	$data ['data']['pub_id'] = '27';
	$data ['data']['content'] = '借书发起';
	$data ['data']['loan_time'] = '2014-03-01';
	$data['data']['address'] = '上海市杨浦区密云路631号';
}elseif ($action == 'book_comment') {
	$data ['data']['pub_id'] = '26';
	$data ['data']['content'] = '评论测试';
	$data ['data']['points'] = '5';
}elseif ($action == 'book_upload') {
	$data ['data']['book_id'] = '21';
	$data ['data']['lent_way'] = '1';
	$data ['data']['remark'] = '我的第一本图书';
	$data ['data']['deposit']=20;
	$data ['data']['loan_period']=20;
	$data ['data']['public'] = '1';
}elseif($action == 'circle_add'){
	$data ['data']['circle_name'] = '好友生活圈2';
	$data['data']['lng'] = '116.322987';
	$data['data']['lat'] = '39.983424';
	$data['data']['address'] = '上海市杨浦区密云路631号';
	$data ['data']['kind'] = '1';
}elseif($action == 'circle_join'){
	$data ['data']['circle_id'] = '5';
}elseif($action=='message_send'){
	$data ['data']['content'] = '私消息测试112';
	$data ['data']['userid'] = '2';
}elseif($action=='message_chat'){
	$data ['data']['userid'] = '2';
}elseif($action=='message_contacts'){
	$data ['data']['userid'] = '3';
}elseif($action=='message_loanbook'){
	$data ['data']['mid'] = '4';
}elseif($action=='pay_rollout'){
	$data ['data']['userid'] = '3';
	$data ['data']['coin'] = '1';
}elseif($action=='pay_logs'){
	$data ['data']['userid'] = '1';
}elseif($action=='order_detail'){
	$data ['data']['order_id'] = '4';
}
$data ['do'] = $action;
//var_dump($data);
if ($havepic) {
	print_r(json_encode($data));
	$ret = jsonPicCall ( $data, $picdata,$updatepicurl );
	print_r ( '<br />' );
	print_r ( $ret );
	print_r ( '<br />' );
	//if(isset($ret ['sessID'])){
	//		setcookie ( 'sid', urlencode ( $ret ['sessID'] ) );
	//		}
} else {
	print_r(json_encode($data));
	echo '<br />';
	$ret = jsonCall ( $data );
	print_r ( '<br />' );
	print_r ( $ret );
	print_r ( '<br />' );
	if($action == 'security_login'||$action == 'security_reg'){
		if(isset($ret ['sessID'])){
			setcookie ( 'sid', urlencode ( $ret ['sessID'] ) );
		}
	}
}

function jsonCall($param) {

	$json = new JSONServer ( );
	$ret = $json->call ( $param );
	return $ret;
}

function jsonPicCall($param, $picdata,$updatepicurl) {

	//	if (is_array ( $param )) {
	//		$data = array_merge ( $param, $data );
	//	}
	$data = $param;
	print_r ( json_encode ( $data ) );
	print_r ( '<br />' );
	print_r ( '<br />' );
	$boundray = time ();
	$h = array ();
	$m_line = "\r\n";

	$h [] = "Content-Type:  multipart/form-data; boundary=" . $boundray;
	$h [] = "Connection: Keep-Alive";
	$content = json_encode ( $data );
	$t = array ();
	$t [] = "--" . $boundray;
	$t [] = "Content-Disposition: form-data; name=\"UPLOAD_IDENTIFIER\"" . $m_line;
	$t [] = "34f4eec9d2922ab59d23c8b02291dd4f";
	$t [] = "--" . $boundray;
	$t [] = "Content-Disposition: form-data; name=\"json\"" . $m_line;
	$t [] = $content;
	$t [] = "--" . $boundray;
	$t [] = "Content-Disposition: form-data; name=\"sig\"" . $m_line;
	$t [] = md5($content);;
	$t [] = "--" . $boundray;
	$t [] = "Content-Disposition: form-data; name=\"File_1\"; filename=\33.jpg\"";
	$t [] = "Content-Type: image/jpeg" . $m_line . $m_line;
	$c = implode ( $m_line, $t );

	$upload_fp = fopen ( $picdata, "rb" );
	//var_dump($u);
	while ( ! @feof ( $upload_fp ) ) {
		$file_piece = @fread ( $upload_fp, 4096 );
		$c .= $file_piece;
	}
	fclose ( $upload_fp );
	$c .= $m_line . "--" . $boundray;
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $updatepicurl );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $h );
	curl_setopt ( $ch, CURLOPT_POST, TRUE );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $c );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );

	$rsp = curl_exec ( $ch );
	curl_close ( $ch );

	$ret = json_decode ( $rsp, true );
	if ($ret == null) {
		$ret = $rsp;
	}
	return $ret;
}
