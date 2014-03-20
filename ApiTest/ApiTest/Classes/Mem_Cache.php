
<?php
	Class Mem_Cache {
		
		public $enable=0,$get_notfound;
		private $keyprefix='BBSCORE_';
		
		private $server_pool=array(
				array('10.21.118.243',60000),
		);
		
		public $cas=NULL;
		private $result=NULL;
		
		function setDebug($oper,$key,$note='') {
			global $DEBUG_MODE,$init,$CLI,$Queries_P,$Queries_P_Mem;
			
			if (isset($CLI)) return;
			if (!isset($Queries_P)) $Queries_P=0;
			if (!isset($Queries_P_Mem)) $Queries_P_Mem=0;
			if ((isset($DEBUG_MODE) && $DEBUG_MODE==1)|| (isset($_SESSION["USERID"]) && in_array($_SESSION["USERID"],$init['debug_userid']))) {
				global $Queries;
				global $PAGE_time_start;
				if (!isset($Queries)) $Queries=array();
				global $MEM_CACHE;
				if ($oper!='GETARRAY'&&$oper!='SETARRAY') $keyinfo=$MEM_CACHE->getServerByKey($this->keyprefix.$key);
				else $keyinfo=array('host'=>'','port'=>''); 
				$Queries[$Queries_P][0]='Memcached: '.$keyinfo['host'].':'.$keyinfo['port'].' '.$oper.' '.$key;
				$Queries[$Queries_P][1]=$note;
				$Queries[$Queries_P][2]=getmicrotime() - $PAGE_time_start;
			}
			$Queries_P++;
			$Queries_P_Mem++;
		}
		
		function __construct() {
			global $init;
			if(empty($this->server_pool)) {
				require $init['yiban_config_dir'] . 'memcached.php';
				$this->server_pool = $server_pool;
			}
			
			global $CACHE;
			if (isset($CACHE)&&$CACHE==1) $this->enable=1;
			if (!$this->enable) return;
			global $MEM_CACHE;
			if (isset($MEM_CACHE)) return;
//			$MEM_CACHE=new Memcached();
//			$MEM_CACHE->addServers($this->server_pool);
			$MEM_CACHE=new Memcache();
			$MEM_CACHE->connect("10.21.118.243", 60000)or die ("Could not connect");
		}
		
		function set($key,$val,$expire=3600) {
			global $MEM_CACHE;
			$result=$MEM_CACHE->set($val,time()+$expire);
			//self::setDebug('SET',$key);
			return $result;
		}
		
		function get($key,$default_type=0) {
			global $MEM_CACHE;
		  try{
			  $result=$MEM_CACHE->get($key);
			 }catch (Exception $e){
				return false;
			 }
			return $result;
		}
		
		function inc($key,$offset=1) {
			if (!$this->enable) return;
			global $MEM_CACHE;
			$MEM_CACHE->increment($this->keyprefix.$key,$offset);
			self::setDebug('INC',$key,$offset);
		}
		
		function cas($key,$val,$expire=3600) {
			if (!$this->enable) return FALSE;
			global $MEM_CACHE;
			if ($this->cas==NULL&&$this->result===Memcached::RES_NOTFOUND) {
				$MEM_CACHE->add($this->keyprefix.$key,$val,time()+$expire);
				self::setDebug('CAS_ADD',$key);
				return ($MEM_CACHE->getResultCode()!==Memcached::RES_SUCCESS);
			}
			if ($this->cas==NULL) return FALSE;
			$MEM_CACHE->cas($this->cas,$this->keyprefix.$key,$val,time()+$expire);
			self::setDebug('CAS',$key);
			return ($MEM_CACHE->getResultCode()===Memcached::RES_DATA_EXISTS);
		}
		
		function getArray($key) {
			if (!$this->enable) return FALSE;
			global $MEM_CACHE;
			$s='';
			for ($i=0;$i<count($key);$i++) {
				$s.=$key[$i].' ';
				$key[$i]=$this->keyprefix.$key[$i];
			}
			$MEM_CACHE->getDelayed($key);
			self::setDebug('GETARRAY',$s);
			return $MEM_CACHE->fetchAll();
		}
		
		function setArray($key,$expire) {
			if (!$this->enable) return FALSE;
			global $MEM_CACHE;
			$s='';
			for ($i=0;$i<count($key);$i++) {
				$s.=$key[$i].' ';
				$key[$i]=$this->keyprefix.$key[$i];
			}
			$result=$MEM_CACHE->setMulti($key,time()+$expire);
			self::setDebug('SETARRAY',$s);
			return $result;
		}
		
		function remove($key) {
			if (!$this->enable) return FALSE;
			global $MEM_CACHE;
			$MEM_CACHE->delete($this->keyprefix.$key);
			self::setDebug('DEL',$key);
			return TRUE;
		}
		
		function flush() {
			if (!$this->enable) return;
			global $MEM_CACHE;
			$MEM_CACHE->flush();
			self::setDebug('FLUSH','');
		}
	}
?>
