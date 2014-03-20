<?php
class Model_Usertoken extends Core_ApiModel{

	public $uid;
	public $access_token;
	public $expired;
	public $gentime;

	public function rules()
	{
		return array(
		);
	}

}