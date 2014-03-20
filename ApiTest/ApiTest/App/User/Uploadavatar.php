<?php
/**
 * App_User_Uploadavatar 用户上传头像接口
 * @author 严廷廷
 *
 */
class App_User_Uploadavatar extends Core_ApiApplication
{

    public function run ()
    { 
    	ini_set('display_errors', 'On');
    	error_reporting(E_ALL);
        $info = Service_Security::getInstance()->getInfoFromSessionId(Core_ApiRequest::getInstance()->getSessID());
        if (! $info) {
            throw new Exception_Yiban(Lang_Zh_Common::SESSID_ERROR, 106);
        }
        $filedata = array();
        $file = Core_ApiRequest::getInstance()->getFiles();
        if (empty($file)) {
            throw new Exception_Yiban(Lang_Zh_Common::CONTENT_EMPTY_ERROR, 105);
        }
        foreach ($file as $f) {
            $filedata = $f['tmp_name'];
        }
        $filedata = isset($file['tmp_name']) ? $file['tmp_name'] :$filedata;
        if(is_array($filedata)) $filedata = $filedata[0];
        $ret = Service_User::getInstance()->addUserPic($info['userid'], $filedata);
        if ($ret) {
            $album['pic'] =  $ret;
        } else {
            throw new Exception_Yiban(Lang_Zh_Common::UPLOAD_ERROR, 101);
        }
        
        return $album;
    }

    public function paramRules ()
    {
        return array(
                'index' => array(
                        'default' => ''
                )
        );
    }
}
