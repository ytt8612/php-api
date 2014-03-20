<?php
/**
 * 图书处理类
 * @author 严廷廷
 *
 */
class Service_Book extends Core_ApiService {

	/**
	 * @return Service_Book
	 */
	public static function getInstance() {
		return parent::getInstance();
	}
	/**
	 *获取图书评论列表
	 * @param $pub_id 图书发布ID
	 * @param $page 页数
	 * @param $size 条数
	 * @return array
	 */
	public function getPubBookCommentList($pub_id,$page,$size){
		$offset = $page ? ($page-1)*$size : 0;
		$limit = $size+1;
		$rs = Table_Bookcomment::getInstance()->getPubBookCommentList($pub_id, $limit, $offset);
		if($rs){
			$data['havenext'] = 0;
			if(count($rs)>$size){
				$data['havenext'] = 1;
				array_pop($rs);
			}
			$data['list'] =$rs;
		}
		return $rs ? $data : array();
	}
	/**
	 * 发布图书发起评论
	 * @param  $userid 用户ID
	 * @param  $username 用户名
	 * @param  $pub_id 图书发布ID
	 * @param  $content 评论内容
	 * @param  $points 星级评分
	 * @return int
	 */
	public function addPubBookComment($userid,$username,$pub_id,$content,$points){
		$data = array(
				 'userid'=>$userid,
				 'username'=>$username,
				 'pub_id'=>$pub_id,
				 'content'=>$content,
				 'points'=>$points,
				 'time'=>date('Y-m-d H:i:s')
				);
		$commentid = Table_Bookcomment::getInstance()->insert($data);
		return $commentid;
	}
	/**
	 * 判断用户是否能发布图书
	 * @param  $userid 用户ID
	 * @param  $book_id
	 * @return bool
	 */
	public function canPubBook($userid,$book_id){
		$rs = Table_UserBook::getInstance()->getUserPubByBookId($userid,$book_id);
		$canPub = true;
		if($rs){
			foreach ($rs as $v){
				if($v['book_status']==1)$canPub=false;
			}
		}
		return $canPub;
	}
	/**
	 * 发起图书借阅申请
	 * @param  $from_userid 发起方ID
	 * @param  $to_userid 接受方ID
	 * @param  $pub_id 图书发布ID
	 * @param  $loan_time 借书时间
	 * @param  $address 借书地址
	 * @param  $content 私信内容
	 * @return boolean
	 */
	public function addLoanApplication($from_userid,$to_userid,$pub_id,$book_name,$loan_time,$address,$content){
		//$userInfo = Table_Userinfo::getInstance()->find($from_userid);
		//生成借书申请订单
		$order_id = self::createLoanBookOrder($from_userid,$to_userid,$pub_id,$loan_time,$address);
		$msgid = false;
		if($order_id){
		//生成消息
		$msg_content = Lang_Zh_Common:: LOAD_APPOINT.',书名：'.$book_name;
		$msgid = Table_Message::getInstance()->addMessage($from_userid, $to_userid, 2, $msg_content,2,'',$order_id);
		//发起借书私信对话
		if($msgid)$rs = Service_Message::getInstance()->sendMsg($from_userid,$to_userid,$content,2,$order_id);
		}
		return $msgid&&$order_id ? $order_id :  false;
	}
	
	/**
	 * 生成图书订单
	 * @param  $from_userid 发起方ID
	 * @param  $to_userid 接受方ID
	 * @param  $pub_id 图书发布ID
	 * @param  $loan_time 借书时间
	 * @param  $address 借书地址
	 * @return int $order_id
	 */
	public function createLoanBookOrder($from_userid,$to_userid,$pub_id,$loan_time,$address){
		$book = self::getBookDetailById($pub_id);
		if(empty($book)){
			return flase;
		}
		$var1 = array('pub_id'=>$pub_id,'user_id'=>$book['user_id'],'username'=>$book['username'],'bood_id'=>$book['id'],'bood_name'=>$book['title'],'book_author'=>$book['author'],'book_summary'=>$book['summary'],'deposit'=>$book['deposit'],'loan_way'=>$book['loan_way'],'loan_period'=>$book['loan_period']);
		$var1 = serialize($var1);
		$now = date('Y-m-d H:i:s');
		$order_data = array(
				'order_code'=>Lib_Util::createOrderCode($pub_id,$from_userid),
				'from_userid'=>$from_userid,
				'to_userid'=>$to_userid,
				'pub_id'=>$pub_id,
				'loan_time'=>$loan_time,
				'address'=>$address,
				'coin'=>$book['deposit'],
				'order_status'=>1,
				'var1'=>$var1,
				'last_time'=>$now,
				'create_time'=>$now
		);
		$oder_id = Table_UserOrder::getInstance()->insert($order_data);
		return $oder_id;
	}
	/**
	 * 发起图书借阅预约
	 * @param  $from_userid 发起方ID
	 * @param  $to_userid 接受方ID
	 * @param  $pub_id 图书发布ID
	 * @param  $book_name 图书名称
	 */
	public function addBookReserve($from_userid,$to_userid,$pub_id,$book_name){
		$userInfo = Table_Userinfo::getInstance()->find($from_userid);
		$var1 = array('pub_id'=>$pub_id,'username'=>$userInfo['username'],'email'=>$userInfo['email'],'phone_num'=>$userInfo['phone_num']);
		$msg_content = Lang_Zh_Common::LEND_APPOINT.',书名'.$book_name;
		$var1 = serialize($var1);
		return Table_Message::getInstance()->addMessage($from_userid, $to_userid, 1, $msg_content,$var1,2);
	}
	/**
	 * 根据pub_id获取图书详情
	 * @param $pub_id 图书发布ID
	 * @return array
	 */
	public function getBookDetailById($pub_id){
		$pudInfo = Table_UserBook::getInstance()->find($pub_id);
		$bookInfo = array();
		if($pudInfo){
			$bookInfo = Table_Bookinfo::getInstance()->find($pudInfo['book_id']);
		}
		if($pudInfo && $bookInfo) $data = array_merge($pudInfo,$bookInfo);
		return isset($data) ? $data : false;
	}
	/**
	 * 获取图书列表
	 * @param $tag_id 分类ID
	 * @param $page 页数
	 * @param $num
	 */
	function getBooksByTagId($tag_id,$page,$num){
		$pub_ids = array();
		if($tag_id){
			$book_ids = Table_Booktag::getInstance()->getBookIdsByTagId($tag_id);
			if(empty($tag_id)){
				return false;
			}
			$rs = Table_Bookinfo::getInstance()->getBooksByIds($book_ids,$page,$num+1);
		}else{
		  $rs = Table_Bookinfo::getInstance()->getAllBookByPage($page,$num+1);
		}
	   if($rs){
	   	$data['havenext'] = 0;
	   	if(count($rs)>$num){
	   		$data['havenext'] = 1;
	   		array_pop($rs);
	   	}
	   	$data['list'] =$rs;
	   }
	   return $rs ? $data : array();
	}
	/**
	 * 图书上架
	 * @param  $book_id 图书ID
	 * @param  $userid 用户ID
	 * @param  $username 用户名
	 * @param  $lent_way 借出方式
	 * @param  $deposit_type 押金方式
	 * @param  $deposit 押金
	 * @param  $loan_period 借阅期限
	 * @param  $sskey 图书馆密钥
	 * @param  $public 公开权限
	 * @param  $lat 经度
	 * @param  $lng 维度
	 * @param  $address 位置
	 * @return  int;
	 */
	function pubBook($book_id,$userid,$username,$lent_way,$deposit_type,$deposit,$loan_period,$sskey,$public,$remark,$lat='',$lng='',$address=''){
	
		$data = array(
				 'book_id'=>$book_id,
				 'user_id'=>$userid,
				 'username'=>$username,
				 'lent_way'=>$lent_way,
				 'deposit_type'=>$deposit_type,
				 'deposit'=>$deposit,
				 'loan_period'=>$loan_period,
				 'sskey'=>$sskey,
				 'book_status'=>1,
				 'loan_status'=>1,
				 'public'=>$public,
				 'remark'=>$remark,
				 'lat'=>$lat,
				 'lng'=>$lng,
				 'address'=>$address,
				 'public_time'=>date('Y-m-d H:i:s')
				);
		$dt = Table_UserBook::getInstance()->insert($data);
		if($dt){
			$user_circles = Service_Circle::getInstance()->getJoinCircleByUid($userid);
			//不公开数据发布到 发布到生活圈的图书
			if(!empty($user_circles) && $public==0){
			foreach($user_circles as $val){
				Table_Circlebook::getInstance()->insert(array('circle_id'=>$val['circle_id'],'pub_id'=>$dt));
			}
			}
		}
		return $dt;
	}
	/**
	 * 图书所属的圈子
	 * @
	 */
	/**
	 * 获取根据图书信息
	 * @param $id 图书ID
	 */
	function getBookInfoById($id){
		return Table_Bookinfo::getInstance()->find($id);
	}
/**
 * 导入图书信息
 * @param string $isbn
 */
	function addBookInfo($isbn){
		$infoArr = $this->DBxml($isbn);
		$entry = Table_Bookinfo::getInstance()->getBookByIsbn($isbn);
		if(empty($entry)){
		$entry = array (
				'isbn10'=>$infoArr['isbn10'],
				'isbn13'=>$infoArr['isbn13'],
				'title'=>$infoArr['title'],
				'summary'=>$infoArr['summary'],
				'author'=>isset($infoArr['author']) ? $infoArr['author'] : '',
				'author_intro'=>isset($infoArr['author-intro']) ? $infoArr['author-intro'] :'',
				'image'=>$infoArr['image'],
				'pages'=>isset($infoArr['pages']) ? $infoArr['pages'] : 0,
				'price'=>$infoArr['price'],
				'publisher'=>isset($infoArr['publisher']) ? $infoArr['publisher']: '',
				'pubdate'=>isset($infoArr['pubdate']) ? $infoArr['pubdate'] :'',
				'time'=>date('y-m-d H:i:s')
				);

		$dt = Table_Bookinfo::getInstance()->addBook($entry);
		//获取图书封面图片
		if($dt && $infoArr['image']){
		$filename = $dt.'_s.jpg';
		$image = Lib_Util::get_photo($infoArr['image'],$filename);
		}
		$entry['id']=$dt;
		if($dt && isset($infoArr['tag'])){
			foreach ($infoArr['tag'] as $v) {
				$tag = Table_Tags::getInstance()->getTag($v['name']);
				if(!empty($tag)){
					$tag_id = $tag['tag_id'];
					$en =array(
							 'tag_id'=>$tag['tag_id'],
							 'count' =>$tag['count']+1,
							 'tag'=>$v['name']
							);
				 Table_Tags::getInstance()->update($en);
				 
				}else{
					$en =array(
							'count' =>1,
							'tag'=>$v['name'],
							'cate'=>1
					);
					$tag_id = Table_Tags::getInstance()->insert($en);
				}
				
				Table_Booktag::getInstance()->insert(array('book_id'=>$dt,'tag_id'=>$tag_id,'tag'=>$v['name']));
			}
		}
		}{
			$dt = $entry['id'];
		}
		return $dt ? $entry :false;
	}
	/**
	 * 根据条形码从豆瓣API获取图书信息
	 * @param string $isbn
	 * @return boolean||array
	 */
	function DBxml($isbn)//从传入的ISBN中获取xml文件并解析
	{
		//$q = file_get_contents('http://api.douban.com/book/subject/isbn/'.$isbn.'?apikey='.apikey);
		$q = file_get_contents('http://api.douban.com/book/subject/isbn/'.$isbn);
		$xml=simplexml_load_string($q,null,null,"http://www.douban.com/xmlns/");
		//用来获取书籍的图片
		$arr= array();
		foreach($xml->children() as $child)
		{
			$name  = $child->getName();
			if($name=='link'&& $child['rel'] == 'image'){
				$arr['image'] = (string) $child['href'];
			}elseif($name=='category'){
				$arr[$name] = (string)$child['term'];
			}else{
				$arr[$name] = (string) $child;
			}
		}
		//获取书名、作者等信息
		foreach($xml->attribute as $value){
			$name = (string)$value->attributes();
			$arr[$name] =(string) $value;
	
		}
		//以下对tag进行解析
		foreach($xml->tag as $value){
			$attr=$value->attributes();
			$arr['tag'][]=array(
					'count'=>(string)$attr['count'],
					'name'=>(string)$attr['name']
			);
		}
		return $arr;
	}
}