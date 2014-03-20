DROP TABLE IF EXISTS `book_info`;
CREATE TABLE `book_info` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `isbn10` varchar(30) NOT NULL DEFAULT '' COMMENT '10位条形码',
  `isbn13` varchar(30) NOT NULL DEFAULT '' COMMENT '13位条形码',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '书名',
  `summary` varchar(3000) NOT NULL DEFAULT '' COMMENT '图书描述',
  `author` varchar(100) NOT NULL DEFAULT '' COMMENT '作者',
  `author_intro` varchar(300) NOT NULL DEFAULT '' COMMENT '作者介绍',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '作者',
  `pages` int(8) NOT NULL DEFAULT '0' COMMENT '页数',
  `price` varchar(30) NOT NULL DEFAULT '' COMMENT '价格',
  `publisher` varchar(100) NOT NULL DEFAULT '' COMMENT '出版社',
  `pubdate` varchar(30) NOT NULL DEFAULT '' COMMENT '出版时间',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  index(`isbn10`,`isbn13`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `enjoy`.`en_tag` (
  `tag_id` int(10) NOT NULL AUTO_INCREMENT,
  `cate` int(11) NOT NULL DEFAULT '0' COMMENT '分类：0 系统，1 图书,2玩具',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '数目',
  `tag` varchar(50) NOT NULL DEFAULT '' COMMENT '标签名',
  `sys` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '1可以删除 2系统默认标签不可删除',
  PRIMARY KEY (`tag_id`),
  index(`tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `passwd` varchar(32) NOT NULL COMMENT '密码',
  `lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上次登录时间',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录表';

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE IF NOT EXISTS `user_info` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `realname` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `phone_num` varchar(100) NOT NULL DEFAULT '0' COMMENT '手机',
  `coin` BIGINT(20) NOT NULL DEFAULT '0' COMMENT '乐享豆',
  `good_credit` BIGINT(20) NOT NULL DEFAULT '0' COMMENT '信用好评数',
  `bad_credit` BIGINT(20) NOT NULL DEFAULT '0' COMMENT '信用差评数',
  `nick` varchar(100) NOT NULL DEFAULT '',
  `pic` varchar(100) DEFAULT NULL COMMENT '头像',
  `sex` enum('0','1') NOT NULL DEFAULT '0' COMMENT '性别0:男，1：女，默认0',
  `verify` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户类型：0：普通用户，1:系统用户',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户状态，0：受限用户，1：正常用户',
  `sskey` varchar(100) NOT NULL DEFAULT '' COMMENT '密钥',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户基本信息表';

DROP TABLE IF EXISTS `user_action_config`;
CREATE TABLE IF NOT EXISTS `user_action_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(50) NOT NULL COMMENT '行为名称',
  `code` varchar(30) NOT NULL COMMENT '行为代码。程序区分的唯一标示',
  `coin` smallint(6) NOT NULL COMMENT '获得乐享豆数量',
  `coin_limit` smallint(6) NOT NULL COMMENT '获得乐享豆上限',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户行为配置表';

DROP TABLE IF EXISTS `user_coin_log`;
CREATE TABLE IF NOT EXISTS `user_coin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL COMMENT '用户ID',
  `from_userid` int(10) unsigned DEFAULT NULL COMMENT '发起方-用户ID-(交互类型)',
  `code` char(50) NOT NULL COMMENT '对应操作code，此code对应会员系统中user_action_config中的code',
  `desc` varchar(50) DEFAULT NULL COMMENT '行为名称',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '乐享豆变化数',
  `dayup` int(11) NOT NULL DEFAULT '0' COMMENT '奖励年月日',
  `ext` int(11) NOT NULL DEFAULT '0' COMMENT '预留字段',
  `dateline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间',
  `kind` enum('1','2') NOT NULL DEFAULT '1' COMMENT '类型: 1 => 系统发放， 2 => 用户转入',
  PRIMARY KEY (`id`),
  KEY `INX_UID` (`userid`),
  index `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户乐享豆日志表';

DROP TABLE IF EXISTS `user_sessionid`;
CREATE TABLE `user_sessionid` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `user_id` bigint(20) NOT NULL COMMENT '用户ID',
  `sint` int(8) NOT NULL  COMMENT '用户sessionid校验数值',
  `session` varchar(100) NOT NULL COMMENT 'sessionid',
  `imei` varchar(100) NOT NULL COMMENT '客户端唯一标示',
  PRIMARY KEY `id` (`id`),
  KEY `userid` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `user_books`;
CREATE TABLE `user_books` (
  `pub_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '图书id',
  `library_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '图书馆id',
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '书主id',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `remark` varchar(500) NOT NULL COMMENT '备注',
  `book_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '图书状态，0 待审核1上架 2 下架',
  `loan_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '借阅状态，0 不可借 1可借2 借出 3 预约',
  `loan_way` tinyint(4) NOT NULL DEFAULT '1' COMMENT '借阅方式， 1 做客 2 旅行',
  `lent_way` tinyint(4) NOT NULL DEFAULT '1' COMMENT '借出方式， 1 旅行 2 预约',
  `loan_period` int(8) NOT NULL DEFAULT '0' COMMENT '借阅期限/天',
  `deposit_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '押金方式，0 免费 1 乐享豆 2 密钥 3 现金',
  `deposit` varchar(100) NOT NULL DEFAULT '0' COMMENT '押金',
  `sskey` varchar(100) NOT NULL DEFAULT '' COMMENT '图书密钥',
  `address` varchar(300) NOT NULL DEFAULT '' COMMENT '位置',
  `lng` varchar(300) NOT NULL DEFAULT '' COMMENT '坐标经度' ,
	`lat` varchar(300) NOT NULL DEFAULT '' COMMENT '坐标维度' ,
  `public_time` varchar(300) NOT NULL DEFAULT '' COMMENT '发布时间',
  `last_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后修改时间',
  `public` tinyint(4) NOT NULL DEFAULT '1' COMMENT '隐私，0 全网  1生活圈 ',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，0 删除  1正常',
  PRIMARY KEY (`pub_id`),
  index(`user_id`,`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci COMMENT='用户所属图书表';

CREATE TABLE IF NOT EXISTS `circle` (
  `circle_id` int(11) NOT NULL AUTO_INCREMENT,
  `circle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `moderator_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `kind` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型 1 生活圈 2 朋友圈',
  `address` varchar(300) NOT NULL DEFAULT '' COMMENT '位置',
  `lng` varchar(300) NOT NULL DEFAULT '' COMMENT '坐标经度' ,
	`lat` varchar(300) NOT NULL DEFAULT '' COMMENT '坐标维度' ,
	`sys` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是系统添加  0 不是  1 是 ',
	`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，0 删除  1正常',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`circle_id`),
   index(`circle_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='圈子表';

CREATE TABLE IF NOT EXISTS `circle_member` (
  `circle_id` int(11) NOT NULL,
  `circle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `circle_id_user_id` (`circle_id`,`user_id`),
  KEY `circle_id` (`circle_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='圈子成员表';

CREATE TABLE IF NOT EXISTS `circle_book` (
   `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `circle_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '圈子id',
  `pub_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '图书发布id',
  PRIMARY KEY (`id`),
  KEY `circle_id` (`circle_id`),
  KEY `pub_id` (`pub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='圈子图书关系表';

CREATE TABLE IF NOT EXISTS `book_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `tag_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `tag` varchar(50) NOT NULL DEFAULT '' COMMENT '标签名',
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书标签表';

DROP TABLE IF EXISTS `system_msgs`;
CREATE TABLE IF NOT EXISTS `system_msgs` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `from_userid` int(10) unsigned DEFAULT NULL COMMENT '发起方-用户ID-(交互类型)',
  `to_userid` int(10) unsigned NOT NULL COMMENT '接收方-用户ID',
  `msg_kind` smallint(5) unsigned DEFAULT NULL COMMENT '业务类型',
  `msg_type` enum('1','2') NOT NULL COMMENT '消息类型: 1 => 系统通知， 2 => 交互类型',
  `msg_content` text NOT NULL COMMENT '消息内容',
  `var1` varchar(300) NOT NULL DEFAULT '' COMMENT '扩展字段' ,
  `msg_result` enum('0','1','2','3','4','5') DEFAULT NULL COMMENT '用户选择结果， 对应 msg_btn 字段交互类型',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '状态:0 => 未读;1 => 已读;2 => 删除',
  PRIMARY KEY (`msg_id`),
  KEY `fh_systemMsg_toUseridSts` (`to_userid`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统消息表';

CREATE TABLE IF NOT EXISTS `friend` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `friendid` int(10) NOT NULL DEFAULT '0',
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cid` tinyint(4) NOT NULL DEFAULT '0',
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `friendid` (`friendid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `book_comments` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `pub_id` int(10) NOT NULL DEFAULT '0' COMMENT '图书发布id',
  `userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户昵称',
  `points` tinyint(4) NOT NULL DEFAULT '0' COMMENT '星级数',
  `content` text NOT NULL COMMENT '评论内容',
  `time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `pub_id` (`pub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `user_contacts`;
CREATE TABLE `user_contacts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '查询人id',
  `contact_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系人id',
  `is_receive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是收到消息，0发送消息1接收消息',
  `total_count` int(8) NOT NULL DEFAULT '0' COMMENT '联系人之间总消息数',
  `unread_count` int(8) NOT NULL DEFAULT '0' COMMENT '联系人之间未读数',
  `content` varchar(3000) NOT NULL DEFAULT '' COMMENT '最后一条消息内容',
  `last_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后一条消息时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_contact_id` (`user_id`,`contact_id`),
  KEY `user_id` (`user_id`,`last_time`)
) ENGINE=InnoDB AUTO_INCREMENT=28796 DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci COMMENT='用户私信联系人表';

DROP TABLE IF EXISTS `msg_user`;
CREATE TABLE IF NOT EXISTS `msg_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '查询人id',
  `fid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '联系人id',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `net_file` text COLLATE utf8_unicode_ci NOT NULL,
  `inituid` int(10) NOT NULL DEFAULT '0',
  `var1` varchar(300) NOT NULL DEFAULT '' COMMENT '扩展字段' ,
  `kind` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型: 1 => 私信对话， 2 => 借书私信,3=>乐享豆交易',
  `union_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '两人消息的关联id，获取对话用',
  `time` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `userid` (`userid`),
  KEY `fid` (`fid`),
  KEY `del` (`del`),
  KEY `union_id` (`union_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户私信消息表';

DROP TABLE IF EXISTS `user_auth_code`;
CREATE TABLE IF NOT EXISTS `user_auth_code` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(20) NOT NULL COMMENT '用户ID',
  `phone_num` bigint(20) NOT NULL COMMENT '手机号码',
  `auth_code` varchar(50) NOT NULL COMMENT '验证码',
  `send_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发送时间',
  `kind` tinyint(4) NOT NULL DEFAULT '0' COMMENT '验证码类型 0 注册验证码 1 修改密码验证码',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '有效状态 0 未使用 1已使用',
  PRIMARY KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户认证码发送记录表';

CREATE TABLE IF NOT EXISTS `user_order` (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `order_code` varchar(50) NOT NULL DEFAULT '0' COMMENT '订单号',
  `from_userid` int(10) unsigned DEFAULT NULL COMMENT '发起方-用户ID-(交互类型)',
  `to_userid` int(10) unsigned NOT NULL COMMENT '接收方-用户ID',
  `pub_id` int(10) unsigned NOT NULL COMMENT '上架ID',
  `points` tinyint(4) NOT NULL DEFAULT '0' COMMENT '星级数',
  `good` tinyint(4) NOT NULL DEFAULT '0' COMMENT '信用 1 好评 0 差评',
  `address` varchar(500) NOT NULL DEFAULT '' COMMENT '地址',
  `loan_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '借阅时间',
  `coin` BIGINT(20) NOT NULL DEFAULT '0' COMMENT '乐享豆',
  `money` BIGINT(20) NOT NULL DEFAULT '0' COMMENT '人民币',
  `last_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '备注',
  `order_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态: 0 取消  1 等待处理  2 书主同意 3 书主拒绝 4 付款 5 收到书  6还书  7订单结束',
  `kind` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型: 1 => 图书， 2 =>玩具,3=>其他',
  `var1` varchar(1000) NOT NULL DEFAULT '' COMMENT '扩展字段' ,
  `remark` varchar(500) NOT NULL DEFAULT '' COMMENT '地址',
  `create_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `order_code` (`order_code`),
  KEY `pub_id` (`pub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户订单表';

