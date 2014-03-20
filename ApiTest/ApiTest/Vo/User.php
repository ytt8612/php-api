<?php

class Vo_User extends Core_ApiVo{

    public static function process($data) {
    
         $user = array(
         		 'user_id'=>$data['user_id'],
         		 'username'=>$data['username'],
         		 'email'=>$data['email'],
         		 'phone_num'=>$data['phone_num'],
         		 'sex'=>$data['sex'],
         		 'good_credit'=>$data['good_credit'],
         		 'bad_credit'=>$data['bad_credit'],
         		 'pic' => Lib_Util::getUserPic(3,$data['user_id']),
             'pic_s' => Lib_Util::getUserPic(1,$data['user_id']),
         		);
            
        return $user;

    }

}