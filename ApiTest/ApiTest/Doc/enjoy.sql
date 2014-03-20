-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.16-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL version:             7.0.0.4156
-- Date/time:                    2014-02-19 14:02:06
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for enjoy
CREATE DATABASE IF NOT EXISTS `enjoy` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `enjoy`;


-- Dumping structure for table enjoy.book_comments
DROP TABLE IF EXISTS `book_comments`;
CREATE TABLE IF NOT EXISTS `book_comments` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `pub_id` int(10) NOT NULL DEFAULT '0' COMMENT '图书发布id',
  `userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户昵称',
  `points` tinyint(4) NOT NULL DEFAULT '0' COMMENT '星级数',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '评论内容',
  `time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `pub_id` (`pub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table enjoy.book_comments: ~3 rows (approximately)
/*!40000 ALTER TABLE `book_comments` DISABLE KEYS */;
INSERT INTO `book_comments` (`comment_id`, `pub_id`, `userid`, `username`, `points`, `content`, `time`) VALUES
	(1, 27, 1, 'test', 4, '评论测试', '2014-02-10 15:23:05'),
	(2, 26, 1, 'test', 5, '评论测试', '2014-02-10 15:23:34'),
	(3, 26, 1, 'test', 5, '评论测试', '2014-02-10 15:26:59');
/*!40000 ALTER TABLE `book_comments` ENABLE KEYS */;


-- Dumping structure for table enjoy.book_info
DROP TABLE IF EXISTS `book_info`;
CREATE TABLE IF NOT EXISTS `book_info` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `isbn10` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '10位条形码',
  `isbn13` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '13位条形码',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '书名',
  `summary` varchar(3000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图书描述',
  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `author_intro` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '作者介绍',
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `pages` int(8) NOT NULL DEFAULT '0' COMMENT '页数',
  `price` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '价格',
  `publisher` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '出版社',
  `pubdate` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '出版时间',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `isbn10` (`isbn10`,`isbn13`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table enjoy.book_info: ~18 rows (approximately)
/*!40000 ALTER TABLE `book_info` DISABLE KEYS */;
INSERT INTO `book_info` (`id`, `isbn10`, `isbn13`, `title`, `summary`, `author`, `author_intro`, `image`, `pages`, `price`, `publisher`, `pubdate`, `time`) VALUES
	(1, '7543639130', '9787543639133', '倘若我在彼岸', '《倘若我在彼岸》是作者在《在世界中心呼唤爱》后的首部爱情小说集。片山恭一，学生时代通读了包括夏目漱石和大江健三郎在内的日本近现代文学全集，同时读了从笛卡尔、莱布尼茨到结构主义的欧洲近现代哲学，也读了马克思。自二十二三岁开始创作小说，《气息》、《世界在你不知道的地方运转》、《别相信约翰·列侬》等均为他的代表作。', 'PIAN SHAN GONG', '', 'http://img5.douban.com/spic/s9097939.jpg', 193, '14.00元', '青岛出版社', '2007-1', '2014-01-23 13:16:16'),
	(2, '7302162069', '9787302162063', '大话设计模式', '《大话设计模式》通篇都是以情景对话的形式，用多个小故事或编程示例来组织讲解GoF（设计模式的经典名著——Design Patterns: Elements of Reusable Object-Oriented Software，中译本名为《设计模式——可复用面向对象软件的基础》的四位作者Erich Gamma、Richard Helm、Ralph Johnson，以及JohnVlissides，这四人常被称为GangofFour，即四人组，简称GoF）总结的23个设计模式。本书共分为29章。其中，第1、3、4、5章着重讲解了面向对象的意义、好处以及几个重要的设计原则；第2章，以及第6到第28章详细讲解了23个设计模式；第29章是对设计模式的全面总结。附录部分是通过一个例子的演变为初学者介绍了面向对象的基本概念。本书的特色是通过小菜与大鸟的趣味问答，在讲解程序的不断重构和演变过程中，把设计模式的学习门槛降低，让初学者可以更加容易地理解——为什么这样设计才是好的？是怎样想到这样设计的？以达到不但授之以“鱼”，还授之以“渔”的目的。引导读者体会设计演变过程中蕴藏的大智慧。', '程杰', '程杰：高级软件工程师 & 高级培训讲师。从事软件开发一线工作近八年时间。曾在申银万国证券公司、上海杨浦区政府、朝华集团下属网游公司、香港晨兴集团等多行业项目开发中担任主程及项目负责人，有丰富的大中型软件开发经验，以及多年的软件设计与项目管理经验。曾任加拿大慧桥培训中心金牌讲师，主持.NET高级软件工程师的培训工作；早年从事高中数学教学工作，曾在江苏常州重点高中任教时获得过市教学一等奖，这些教学和培训经历让作者对如何以易懂的语言讲解艰深的技术知识有了深刻的理解。\n\n    本书作者集多年实际项目开发经验和丰富教学培训经验于一身，准确把握住编程初学者的视角，以浅显幽默的语言向读者诠释了面向对象设计', 'http://img5.douban.com/spic/s6908318.jpg', 368, '45.00元', '清华大学出版社', '2007-12', '2014-01-23 13:16:35'),
	(3, '7811348543', '9787811348545', '民俗节日读本', '《民俗节日读本》内容简介：始于20世纪80年代的中国经济的快速成长及国力迅速崛起是一个具有世界意义的历史性的大事件。它不仅导致中国出现崭新的面貌，而且也在整体上改变了世界的格局。过去三十年里最引人瞩目的国际动向之一。就是中国以全新姿态和极大热情越来越深入地融入国际社会，而世界各国也越来越关注中国。在这样一个背景下，中外交流达到了波澜壮阔和细致入微的程度，无论广度与深度，都是历史上从未有过的。\n《民俗节日读本》有利于我们深入的了解我国的民俗。', '黎敏', '', 'http://img3.douban.com/spic/s6258503.jpg', 119, '13.00元', '', '2010-10', '2014-01-23 13:18:48'),
	(4, '7806999191', '9787806999196', '世界上最会说话的人全集', '《说话艺术全知道》主要内容：\n说话是一种技巧，更是一门艺术。职场上，每个人每一天和同事、领导难免有话要说；家庭中，同妻子、丈夫、父母、孩子必须进行交流；社交时，同朋友、客户势必联络感情。说什么？怎么说？什么话能说，什么话不能说？这些都需要我们掌握说话的艺术。在注重人际沟通的现代社会，说话的艺术也就是成功的艺术。', '李泉编著', '', 'http://img3.douban.com/spic/s8893463.jpg', 0, '28.00元', '黑龙江哈尔滨', '2010-5', '2014-01-23 13:19:46'),
	(5, '7115175624', '9787115175625', '深入浅出MySQL数据库开发、优化与管理维护', '本书从数据库的基础、开发、优化、管理维护4个方面对MySQL进行了详细的介绍，其中每一部分都独立成篇。本书内容实用，覆盖广泛，讲解由浅入深，适合于各个层次的读者。\n基础篇主要适合于MySQL的初学者，内容包括MySQL的安装与配置、SQL基础、MySQL支持的数据类型、MySQL中的运算符、常用函数、图形化工具的使用等。开发篇主要适合于MySQL的设计和开发人员，内容包括表类型(存储引擎)的选择、选择合适的数据类型、字符集、索引的设计和使用、视图、存储过程和函数、触发器、事务控制和锁定语句、SQL中的安全问题、SQL Mode及相关问题等。优化篇主要适合于开发人员和数据库管理员，内容包括常用SQL技巧和常见问题、SQL优化、优化数据库对象、锁问题、优化 MySQL Server、磁盘I/O问题、应用优化等。管理维护篇主要适合于数据库管理员，内容包括MySQL高级安装和升级、MySQL中的常用工具、MySQL 日志、备份与恢复、MySQL权限与安全、MySQL复制、MySQL Cluster、MySQL常见问题和应用技巧等。\n本书的作者都是MySQL方面的资深DBA。本书不但融入了他们丰富的工作经验和多年的使用心得，还提供了大量来自工作现场的实例，具有很强的实战性和可操作性。\n本书适用于数据库管理人员、数据库开发人员、系统维护人员、数据库初学者及其他数据库从业人员，也可以作为大中专院校相关专业师生的参考用书和相关培训机构的培训教材。', '申宝柱', '网易技术部DBA组员工', 'http://img3.douban.com/spic/s2996052.jpg', 476, '59.00元', '人民邮电出版社', '2008', '2014-01-23 13:20:34'),
	(6, '7504476676', '9787504476678', '数字营销', '《数字营销:世界上最成功的25个数字营销活动》内容简介：全球在社会化数字网络广告方面的花销将稳步增长至43亿美元，仅美国就将达到16亿多美元。《数字营销:世界上最成功的25个数字营销活动》选取了25个在创意和营销方面最成功的数字营销经典案例。每个案例都包括了“当前面临的挑战、活动预算、目标受众、行动计划、结果、经验总结、活动链接、专家观点”等方面的内容，并且配以相应的图片进行清晰说明。\n读者可以从每个案例中看到营销人员面对的不同挑战，他们部署的创造性数字化营销战略，以及对生意的最终影响。虽然这些案例源于不同的产品品牌，在不同的技术平台推出了不同的营销活动，但是，他们都选用了数字化媒体，设计了品牌营销的创新性方式。这些案例都有一个内在的、引人瞩目的因素，所以在纷乱的数字化网络世界可以脱颖而出——这些案例成功地整合了多种媒体和渠道，模糊了数字媒体与传统媒体之间的界限，利用数字化网络口碑带动传统大众媒体曝光，转而促使人们进行参与及消费活动。', '', '', 'http://img3.douban.com/spic/s23111254.jpg', 145, '35.00元', '', '2012-7', '2014-01-23 13:22:25'),
	(7, '7115173982', '9787115173980', '大师之路', '《大师之路:CorelDRAW X3完全解析(中文版)》是一本非常出色的CorelDRAW教程，是一本完全来源于实践的书。《大师之路:CorelDRAW X3完全解析(中文版)》共13章，详细且全面地介绍了CorelDRAW的基础知识及应用技巧，内容包括：CorelDRAW X3概述与入门，页面设置和辅助工具，绘制基本图形，控制对象，绘制和编辑曲线，处理文本，颜色和填充，应用特效，使用图层和样式，处理位图，打印和输出，以及综合案例，附录中还罗列了常用的快捷键。另外，《大师之路:CorelDRAW X3完全解析(中文版)》在讲解的过程中列举了一些典型的操作方法和案例，以帮助读者提高实际应用的能力。', '谭劲', '', 'http://img3.douban.com/spic/s5885674.jpg', 660, '79.00元', '', '2008-5', '2014-01-23 13:23:24'),
	(13, '7115204152', '9787115204158', '大话Oracle RAC', '《大话Oracle RAC集群、高可用性、备份与恢复》以Oracle 10g为基础，对Oracle RAC进行了全面的介绍和分析。全书分为两个部分，共14章，第一部分是集群理论篇，这部分从集群基础知识入手，通过分析集群环境和单机环境的不同，介绍了集群环境的各个组件及其作用，以及集群环境的一些专有技术，包括Oracle Clusterware、Oracle Database、ASM、Cache Fusion等。第二部分是实践篇，每一章都针对RAC的一个知识点展开讲解，包括Oracle Clusterware的维护、HA与LB、备份、恢复、Flashback家族、RAC和Data Guard的结合使用、RAC和Stream的结合使用，最后对ASM进行深入介绍，并给出性能调整的指导思想。\n《大话Oracle RAC集群、高可用性、备份与恢复》按照“发现问题→解决问题→实践与理论相结合”的方式进行介绍，首先对现实问题进行分析，然后提供合适的解决方案，最后自然地引出Oracle中的理论知识点，这种讲解方法能够有效地降低阅读难度，帮助读者更好地掌握相关技能。\n《大话Oracle RAC集群、高可用性、备份与恢复》可以作为数据库开发人员、数据库管理员、数据库初学者及其他数据库从业人员的工作参考手册，也可以作为大中专院校相关专业师生的参考用书和相关培训机构的培训教材。\n\n  点击链接进入新版：  大话Oracle RAC:集群 高可用性 备份与恢复', '张晓明', '张晓明，Oracle OGP，现用网名“石头狗”，名称来自于《和佛陀赏花去》中的故事：狗会因为人随手去出的一个东西茆而追逐，可能是一个骨头，一块肉，一个眼神。甚至是一个石头。警示一定要看清自己在追逐的东西。\n\n    上个世纪90年代末毕业于某著名的医科大学，毕业后分配到某著名医院从事治病救人的神圣工作。不幸的是，在大学最后一年的实习中我接触到了老式486，这让我魂牵梦系，再加上IT热潮对一个热血青年的巨大诱惑，我终于在行医3年后削尖了脑袋挤进了IT业。回想当年，身边有好几位来自知名医学院校的朋友和我一样义无反顾地加入IT工程师队伍，不知道这几位朋友现在安否？ 我在IT行业中最初是做开发，先后', 'http://img5.douban.com/spic/s6003517.jpg', 473, '65.00元', '人民邮电', '2009-4', '2014-01-23 13:51:57'),
	(14, '7302161844', '9787302161844', 'Oracle10g数据库管理应用与开发标准教程', '《Oracle 10g数据库管理 应用与开发标准教程》以Oracle lOg for WindowsXP为平台，由浅入深地介绍了Oracle lOg系统\n的使用方法和基本管理。主要内容包括：Oracle关系数据库，Oracle数据库体系结构，SQL基本查询，修改SQL数据与SQL*Plus命令，PL／SQL编程基础，用户、模式和表，高级查询，过程、函数和程序包，表类型，索引，视图、序列和同义词，触发器，事务与并发控制，安全，管理存储结构和基本的备份与恢复等知识。', '马晓玉', '', 'http://img3.douban.com/spic/s6325980.jpg', 424, '39.80元', '清华大学出版社', '2007-11', '2014-01-23 13:55:47'),
	(15, '7111396782', '9787111396789', '交互设计沉思录', '本书由交互设计领域的思想领袖Jon Kolko所著，是交互设计领域的里程碑之作。本书完美地将当代设计理论和研究成果融入交互设计实践中，将对交互设计的阐释和分析推向了新的高度。本书重点阐释了对交互设计领域的最新理解和洞察，以及人与科技之间的联系。作者通过引人入胜的内容实现对设计师的教化，帮助设计师教化商业人士，同时确立交互设计在商业领域中的地位。本书不但探讨了经济局面的变化、互联性的增强和全球化的科技普及如何影响针对人类行为的设计活动和设计本身，而且对交互设计的定义进行了更好地阐释，主要涵盖三个方面：其一，交互设计涉及的各个知识层面；其二，交互设计作为“以人为本”的学科所包含的基本概念；其三，交互设计师在实践当中获得的经验和采用的方法与手段。此外，本书还讨论了（设计）语言、观点和话术在产品、服务和系统的设计当中所扮演的角色，并介绍了交互设计师处理关乎行为和时间的复杂问题的过程，该过程包括构造大量的数据、考察用户、尝试为随时间不断演化的人类行为提供支持等。', 'Jon Kolko', 'Jon Kolko，交互设计领域的思想领袖，他的理想是通过设计和设计教育来改变社会。他对交互设计的研究和实践涉及众多领域，如消费类电子产品、移动、互联网、供应链管理、需求规划、客户关系管理……为推动交互设计这门学科的发展与演进做出了卓越贡献。\n他是奥斯汀设计中心（AC4D）的创始人，致力于为《财富》500强企业提供设计相关的解决方案和咨询服务，他的客户包括AT&T、HP、Nielsen、Bristol-Myers Squibb、Ford、IBM、Palm等知名企业。\n他曾担任Thinktiv的设计策略执行总监，负责设计和交付能引起情感共鸣且有竞争力的产品和服务。在此之前，他还曾担任设计公司Fr', 'http://img3.douban.com/spic/s17505146.jpg', 202, '49.00元', '机械工业出版社华章公司', '2012-10-1', '2014-01-23 13:57:32'),
	(16, '7504747017', '9787504747013', '女人,别让自己死于一事无成', '这是一本使你“重获新生”的书，它给天下所有女人以当头棒喝。它瞄准女人的惰性、懒于思考、毫无远见、安于现状，以犀利的文字“惊醒”了所有放任岁月流逝，活得不知所以的女人。　　凡走过的必留下痕迹，十年后、二十年后你的生存状态是由你今天的行为和选择所铺就的。那个时候，你容颜已逝，男人还会爱你如初吗？望着年迈的父母，你又是否为了没能给他们富足的生活而惭愧呢？看着那些已有所成就的闺密，你心中又是何许滋味呢？女人，别到了那个时候才知道后悔，更别让自己死于一事无成，现在，是时候静下心好好读读这本书，准备迎接灵魂的洗礼。', '张洁', '普洱，原名张洁，著名心灵理疗师，理财规划师，对心理学和经济学都有着较深入的研究和理解。活跃于时尚圈，曾做过电台主持人。思想独立、敏锐，先后担任多家报刊、杂志的专栏作家。著有畅销书《淡定?不浮躁的活法》《卡耐基写给女人的幸福书》《写给年轻人的经济学》等。', 'http://img3.douban.com/spic/s27192790.jpg', 213, '28.0', '中国财富出版社', '2013-7', '2014-01-26 11:15:49'),
	(18, '7209041060', '9787209041065', '设计中的设计', '设计到底是什么？作为一名从业二十余年并且具有世界影响的设计师，原研哉对自己提出了这样一个问题。为了给出自己的答案，他走了那么长的路，做了那么多的探索。“RE-DESIGN——二十一世纪的日常用品再设计”展真是一个有趣的展览，但又不仅仅是有趣，它分明是为我们揭示了“日常生活”所具有的无限可能性。若我们能以满怀新鲜的眼神去观照日常，“设计”的意义定会超越技术的层面，为我们的生活观和人生观注入力量。', '[日] 原研哉', '日本平面设计大师原研哉先生，日本设计中心代表，武藏野美术大学教授，无印良品咨询委员会委员\n他以一双无视外部世界飞速发展变化的眼睛面对“日常生活”，以谦虚但同时尖锐的目光寻找其设计被需要的所在，并将自己精确地安置在他的意图能够被赋予生命的地方。当我们的日常生活正在越来越陷入自身窠臼之时，他敏锐地感知到了设计的征候和迹象，并且自觉自主地挑战其中的未知领域。他的设计作品显现出来的不落陈规的清新，在于他找到了设计被需求的空间并在其中进行设计。在这样的态度下，他拓展了设计的视野和范畴，在他所经历之处，崭新的地平线不停地被发现和拓展。', 'http://img3.douban.com/spic/s2165932.jpg', 212, '48.00元', '山东人民出版社', '2006-11', '2014-01-26 13:55:30'),
	(19, '7115278717', '97871152787152', 'HTML5程序设计（第2版）', '内容简介：\n今天，HTML5在Web标准之争中已经胜出并被大多数浏览器所支持。体验HTML5带给Web开发的便捷、快速和强大功能，是每一位Web开发和设计人员的当务之急。\n本书由旧金山HTML5用户组创建人联合另外2位资深Web开发专家共同打造，为读者清晰解读了HTML5规范的缘由、发展和现状，全面展示了如何使用WebSocket、Geolocation、Web Storage、Canvas、SVG及音频/视频等前所未有的新特性构建最流行、最强大的Web应用，并以大量的示例涵盖全部HTML5 API。\n第2版进行了全面的修订，新增了针对HTML5视觉效果的SVG和针对用户体验的拖放这两部分内容，将助读者的Web设计和开发更上一层楼。', '[美] Frank Salim', '作者简介：\nPeter Lubbers\nKaazing技术交流资深总监，旧金山HTML5用户组创建人。作为HTML5和WebSocket的狂热爱好者，Peter经常在国际大会上发言，还在全球范围内开展HTML5的技术培训。在加盟Kaazing前，Peter在Oracle担任了近十年的资深信息架构师，获得过两项软件专利。\nBrian Albers\nKaazing研发中心副总裁。他有数十年的Web开发经验，曾在Oracle担任高级开发经理。Brian经常在Web 2.0博览会、AJAXWorld博览会和Web JavaOne等国际性会议上做讲演。\nFrank Salim\nKaazing的元老级工程', 'http://img3.douban.com/spic/s9066310.jpg', 276, '59.00元', '人民邮电出版社', '2012-5', '2014-01-26 13:56:34'),
	(20, '7111412478', '9787111412472', 'HTML 5与CSS 3权威指南（第2版·上册）', '第1版2年内印刷近10次，累计销量超过50000册，4大网上书店的读者评论超过4600条，98%以上的评论都是五星级的好评。不仅是HTML 5与CSS 3图书领域当之无愧的领头羊，而且在整个原创计算机图书领域也是佼佼者。本书已经成为HTML 5与CSS 3图书领域的一个标杆，被读者誉为“系统学习HTML 5与CSS 3技术的最佳指导参考书之一”和“Web前端工程师案头必备图书之一”。第2版首先从技术的角度结合最新的HTML 5和CSS 3标准对内容进行了更新和补充，其次从结构组织和写作方式的角度对原有的内容进行了进一步优化，使之更具价值且更便于读者阅读。\n全书共29章，本书分为上下两册：上册（1～17章）全面系统地讲解了HTML 5相关的技术，以HTML 5对现有Web应用产生的变革开篇，顺序讲解了HTML 5与HTML 4的区别、HTML 5的结构、表单元素、HTML编辑API、图形绘制、History API、本地存储、离线应用、文件API、通信API、扩展的XML HttpRequest API、Web Workers、地理位置信息、多媒体相关的API、页面显示相关的API、拖放API与通知API等内容；下册（18～29章）全面系统地讲解了CSS 3相关的技术，以CSS 3的功能和模块结构开篇，顺序讲解了各种选择器及其使用、文字与字体的相关样式、盒相关样式、背景与边框相关样式、布局相关样式、变形处理、动画、颜色相关样式等内容。上下两册共351个示例页面，所有代码均通过作者上机调试。下册的最后有2个综合案例，以迭代的方式详细讲解了整个案例的实现过程，可操作性极强。', '陆凌牛', '陆凌牛，资深Web开发工程师、软件开发工程师和系统设计师。从事Web开发多年，对各种Web开发技术（包括前端和后端）都有非常深入的研究，经验极其丰富。HTML 5和CSS 3等新技术的先驱者和布道者，不仅对HTML 5与CSS 3有非常深入的研究，而且对Sencha Touch等移动应用开发框架也有非常深刻的认识，并且付诸了大量实践。同时，他还擅长微软与Java的相关技术，在C#、VB.NET、ASP.NET、SQL Server 、Oracle、Java、Struts、Spring、Hibernate等方面也积累大量的实战经验。\n此外，他还是一位颇有影响力的技术作家：\n（1）处女作《HMTL', 'http://img3.douban.com/spic/s25807150.jpg', 488, '79.00元', '机械工业出版社华章公司', '2013-3-31', '2014-01-26 13:57:25'),
	(21, '7115278717', '9787115278715', 'HTML5程序设计（第2版）', '内容简介：\n今天，HTML5在Web标准之争中已经胜出并被大多数浏览器所支持。体验HTML5带给Web开发的便捷、快速和强大功能，是每一位Web开发和设计人员的当务之急。\n本书由旧金山HTML5用户组创建人联合另外2位资深Web开发专家共同打造，为读者清晰解读了HTML5规范的缘由、发展和现状，全面展示了如何使用WebSocket、Geolocation、Web Storage、Canvas、SVG及音频/视频等前所未有的新特性构建最流行、最强大的Web应用，并以大量的示例涵盖全部HTML5 API。\n第2版进行了全面的修订，新增了针对HTML5视觉效果的SVG和针对用户体验的拖放这两部分内容，将助读者的Web设计和开发更上一层楼。', '[美] Frank Salim', '作者简介：\nPeter Lubbers\nKaazing技术交流资深总监，旧金山HTML5用户组创建人。作为HTML5和WebSocket的狂热爱好者，Peter经常在国际大会上发言，还在全球范围内开展HTML5的技术培训。在加盟Kaazing前，Peter在Oracle担任了近十年的资深信息架构师，获得过两项软件专利。\nBrian Albers\nKaazing研发中心副总裁。他有数十年的Web开发经验，曾在Oracle担任高级开发经理。Brian经常在Web 2.0博览会、AJAXWorld博览会和Web JavaOne等国际性会议上做讲演。\nFrank Salim\nKaazing的元老级工程', 'http://img3.douban.com/spic/s9066310.jpg', 276, '59.00元', '人民邮电出版社', '2012-5', '2014-01-26 14:20:22'),
	(23, '730808325X', '9787308083256', '马云的颠覆智慧', '他是“教主”！是极具煽动力的“布道者”！是不走寻常路的企业家！\n在阿里巴巴、淘宝一个个大放异彩的案例中，他如何以颠覆完成超越？\n他自称完全不懂网络，却打造了阿里巴巴帝国，颠覆了中国互联网生态；他演讲激情澎湃，不走寻常路，成为一名孜孜不倦的布道者；他宣称在阿里巴巴，股东的地位在顾客、员工之后，股东却纷纷向他伸出橄榄枝！他如何以颠覆完成超越？\n本书正是从分析马云异于常人的企业运营智慧和理念出发，用清晰地案例和深刻的分析，展现其以颠覆完成超越的独到智慧。\n关于“颠覆”，马云如是说——\n做任何事，必须要有突破，没有突破，就等于没做。\n——马云在《赢在中国》节目中的点评\n世界永远不缺创新，永远不缺的是借口。\n——2010年马云在IT领袖峰会上的演讲\n今时今日，一场由互联网技术掀起的革命正初露端倪，这股浪潮必将永久改变顾客与企业之间的力量态势。在世界各地，能够把握这些新契机和新趋势的中小型企业必将在竞争中脱颖而出。\n——2009年马云在新加坡APEC中小企业高峰会议的演讲《因小而美》\n假如没有变革，怎么会有中小企业，假如没有变革，我们这些所有垄断的企业，怎么有利益在？所以说不破不立。\n——2008年马云新浪博客文章《呼唤企业家精神 坚持梦想敢于担当》\n\n蓝海战略是一种颠覆性的思考。\n——2006年马云在浙商大会暨首届浙商投资博览会上的发言\n阿里巴巴进入淘宝，将会颠覆C2C、B2C等概念，而未来两到三年内，阿里巴巴与淘宝也必然走向融合，这是一个大趋势。\n——2005年12月25日上海交通大学安泰管理学院演讲', '快刀洪七', '快刀洪七\n毕业于北师大中文系，现居广州。社会文化观察家、评论家、缔元信（万瑞数据）网络营销专家、《销售与市场》特约作者、《电脑报》产经评论作者，新浪名博、网易财经名博、第一营销网专家博主。拥有逾十年市场营销及公关传播、网络推广经验。受邀长期为《销售与市场》、《成功营销》、《国际公关》等业内知名营销期刊供稿。\n冯玉麟\n深圳市自主创业指导专家志愿团特邀专家、深圳市电子商务服务中心顾问，现供职于深圳市天使投资人俱乐部。曾任深圳市电子商务协会办公室主任兼政策研究部部长、中国互联网交易投资博览会组委会办公室主任。长期致力于电子商务政策研究、数据研究和投资研究。', 'http://img3.douban.com/spic/s4644461.jpg', 194, '35.00元', '浙江大学出版社', '2011-2', '2014-01-27 11:19:50');
/*!40000 ALTER TABLE `book_info` ENABLE KEYS */;


-- Dumping structure for table enjoy.book_tag
DROP TABLE IF EXISTS `book_tag`;
CREATE TABLE IF NOT EXISTS `book_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `tag_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `tag` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标签名',
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书标签表';

-- Dumping data for table enjoy.book_tag: 24 rows
/*!40000 ALTER TABLE `book_tag` DISABLE KEYS */;
INSERT INTO `book_tag` (`id`, `book_id`, `tag_id`, `tag`) VALUES
	(1, 18, 9, '设计'),
	(2, 18, 17, '原研哉'),
	(3, 18, 18, '日本'),
	(4, 18, 19, '设计中的设计'),
	(5, 18, 20, 'Design'),
	(6, 18, 21, '设计与文化'),
	(7, 18, 22, '艺术'),
	(8, 18, 23, '设计理论'),
	(30, 21, 28, '编程基础-编程语言-html'),
	(29, 21, 27, '编程'),
	(28, 21, 14, '计算机'),
	(27, 21, 26, 'WEB'),
	(26, 21, 25, 'Web开发'),
	(25, 21, 24, 'HTML5'),
	(17, 20, 24, 'HTML5'),
	(18, 20, 30, 'HTML'),
	(19, 20, 31, '5与CSS'),
	(20, 20, 32, '上下册)pdf'),
	(21, 20, 25, 'web开发'),
	(22, 20, 33, 'web/编程'),
	(23, 20, 34, 'html5与css3权威指南(第2版·上册)'),
	(24, 20, 35, 'css'),
	(31, 21, 26, 'Web'),
	(32, 21, 29, '随便看看');
/*!40000 ALTER TABLE `book_tag` ENABLE KEYS */;


-- Dumping structure for table enjoy.circle
DROP TABLE IF EXISTS `circle`;
CREATE TABLE IF NOT EXISTS `circle` (
  `circle_id` int(11) NOT NULL AUTO_INCREMENT,
  `circle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `moderator_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `kind` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型 1 生活圈 2 朋友圈',
  `address` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '位置',
  `lng` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '坐标经度',
  `lat` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '坐标维度',
  `sys` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是系统添加  0 不是  1 是 ',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，0 删除  1正常',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`circle_id`),
  KEY `circle_name` (`circle_name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='圈子表';

-- Dumping data for table enjoy.circle: 2 rows
/*!40000 ALTER TABLE `circle` DISABLE KEYS */;
INSERT INTO `circle` (`circle_id`, `circle_name`, `user_id`, `moderator_id`, `kind`, `address`, `lng`, `lat`, `sys`, `status`, `time`) VALUES
	(5, '好友生活圈2', 3, 3, 1, '上海市杨浦区密云路631号', '116.322987', '39.983424', 1, 1, '2014-01-24 17:29:44'),
	(4, '好友生活圈', 3, 3, 1, '上海市杨浦区密云路631号', '116.322987', '39.983424', 1, 1, '2014-01-24 16:48:51');
/*!40000 ALTER TABLE `circle` ENABLE KEYS */;


-- Dumping structure for table enjoy.circle_book
DROP TABLE IF EXISTS `circle_book`;
CREATE TABLE IF NOT EXISTS `circle_book` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `circle_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `pub_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`id`),
  KEY `circle_id` (`circle_id`),
  KEY `pub_id` (`pub_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='圈子图书关系表';

-- Dumping data for table enjoy.circle_book: 20 rows
/*!40000 ALTER TABLE `circle_book` DISABLE KEYS */;
INSERT INTO `circle_book` (`id`, `circle_id`, `pub_id`) VALUES
	(1, 5, 19),
	(2, 4, 19),
	(3, 5, 20),
	(4, 4, 20),
	(5, 5, 21),
	(6, 4, 21),
	(7, 5, 22),
	(8, 4, 22),
	(9, 5, 23),
	(10, 4, 23),
	(11, 5, 24),
	(12, 4, 24),
	(13, 5, 25),
	(14, 4, 25),
	(15, 5, 26),
	(16, 4, 26),
	(17, 5, 27),
	(18, 4, 27),
	(19, 5, 28),
	(20, 4, 28);
/*!40000 ALTER TABLE `circle_book` ENABLE KEYS */;


-- Dumping structure for table enjoy.circle_member
DROP TABLE IF EXISTS `circle_member`;
CREATE TABLE IF NOT EXISTS `circle_member` (
  `circle_id` int(11) NOT NULL,
  `circle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `circle_id_user_id` (`circle_id`,`user_id`),
  KEY `circle_id` (`circle_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='圈子成员表';

-- Dumping data for table enjoy.circle_member: 3 rows
/*!40000 ALTER TABLE `circle_member` DISABLE KEYS */;
INSERT INTO `circle_member` (`circle_id`, `circle_name`, `user_id`, `username`, `time`) VALUES
	(4, '好友生活圈', 1, 'test2', '2014-01-24 16:48:51'),
	(5, '好友生活圈2', 1, 'test2', '2014-01-24 17:29:44'),
	(5, '好友生活圈2', 2, 'test1', '2014-01-24 17:30:14');
/*!40000 ALTER TABLE `circle_member` ENABLE KEYS */;


-- Dumping structure for table enjoy.en_tag
DROP TABLE IF EXISTS `en_tag`;
CREATE TABLE IF NOT EXISTS `en_tag` (
  `tag_id` int(10) NOT NULL AUTO_INCREMENT,
  `cate` int(11) NOT NULL DEFAULT '0' COMMENT '分类：0 系统，1 图书,2玩具',
  `tag` varchar(50) NOT NULL DEFAULT '' COMMENT '标签名',
  `count` int(10) NOT NULL DEFAULT '0' COMMENT '数目',
  `sys` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1可以删除 2系统默认标签不可删除',
  PRIMARY KEY (`tag_id`),
  KEY `tag` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- Dumping data for table enjoy.en_tag: ~35 rows (approximately)
/*!40000 ALTER TABLE `en_tag` DISABLE KEYS */;
INSERT INTO `en_tag` (`tag_id`, `cate`, `tag`, `count`, `sys`) VALUES
	(1, 1, 'oracle', 3, 1),
	(2, 1, '数据库', 2, 1),
	(3, 1, 'RAC', 1, 1),
	(4, 1, 'Oracle_HighAvailability', 1, 1),
	(5, 1, 'Database', 1, 1),
	(6, 1, 'ORACLE_HA', 1, 1),
	(7, 1, '计算机科学', 1, 1),
	(8, 1, '交互设计', 1, 1),
	(9, 1, '设计', 3, 1),
	(10, 1, '用户体验', 1, 1),
	(11, 1, 'UI', 1, 1),
	(12, 1, '交互', 1, 1),
	(13, 1, '交互设计沉思录', 1, 1),
	(14, 1, '计算机', 3, 1),
	(15, 1, '很好！太棒了！中国就缺交互设计大师！', 1, 1),
	(16, 1, '女性', 1, 1),
	(17, 1, '原研哉', 2, 1),
	(18, 1, '日本', 2, 1),
	(19, 1, '设计中的设计', 2, 1),
	(20, 1, 'Design', 2, 1),
	(21, 1, '设计与文化', 2, 1),
	(22, 1, '艺术', 2, 1),
	(23, 1, '设计理论', 2, 1),
	(24, 1, 'HTML5', 3, 1),
	(25, 1, 'Web开发', 3, 1),
	(26, 1, 'Web', 4, 1),
	(27, 1, '编程', 2, 1),
	(28, 1, '编程基础-编程语言-html', 2, 1),
	(29, 1, '随便看看', 2, 1),
	(30, 1, 'HTML', 1, 1),
	(31, 1, '5与CSS', 1, 1),
	(32, 1, '上下册)pdf', 1, 1),
	(33, 1, 'web/编程', 1, 1),
	(34, 1, 'html5与css3权威指南(第2版·上册)', 1, 1),
	(35, 1, 'css', 1, 1);
/*!40000 ALTER TABLE `en_tag` ENABLE KEYS */;


-- Dumping structure for table enjoy.friend
DROP TABLE IF EXISTS `friend`;
CREATE TABLE IF NOT EXISTS `friend` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `friendid` int(10) NOT NULL DEFAULT '0',
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cid` tinyint(4) NOT NULL DEFAULT '0',
  `time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `friendid` (`friendid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table enjoy.friend: ~4 rows (approximately)
/*!40000 ALTER TABLE `friend` DISABLE KEYS */;
INSERT INTO `friend` (`id`, `userid`, `friendid`, `nickname`, `cid`, `time`) VALUES
	(1, 1, 2, 'test1', 0, '2014-02-17 10:57:17'),
	(2, 1, 3, 'test2', 0, '2014-02-17 10:57:34'),
	(3, 2, 1, 'test', 0, '2014-02-17 10:57:47'),
	(4, 3, 1, 'test', 0, '2014-02-17 10:58:00');
/*!40000 ALTER TABLE `friend` ENABLE KEYS */;


-- Dumping structure for table enjoy.msg_user
DROP TABLE IF EXISTS `msg_user`;
CREATE TABLE IF NOT EXISTS `msg_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '查询人id',
  `fid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '联系人id',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `net_file` text COLLATE utf8_unicode_ci NOT NULL,
  `inituid` int(10) NOT NULL DEFAULT '0',
  `var1` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '扩展字段',
  `kind` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型: 1 => 私信对话， 2 => 借书私信,3=>乐享豆交易',
  `union_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '两人消息的关联id，获取对话用',
  `time` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `userid` (`userid`),
  KEY `fid` (`fid`),
  KEY `del` (`del`),
  KEY `union_id` (`union_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户私信消息表';

-- Dumping data for table enjoy.msg_user: ~3 rows (approximately)
/*!40000 ALTER TABLE `msg_user` DISABLE KEYS */;
INSERT INTO `msg_user` (`id`, `userid`, `fid`, `content`, `del`, `net_file`, `inituid`, `var1`, `kind`, `union_id`, `time`) VALUES
	(1, 2, 1, '私消息测试112', 0, '', 0, '', 1, '2-1', '2014-02-17 17:28:22'),
	(2, 2, 1, '私消息测试112', 0, '', 0, '', 1, '2-1', '2014-02-17 17:28:26'),
	(3, 2, 1, '私消息测试112', 0, '', 0, '', 1, '2-1', '2014-02-17 17:28:27');
/*!40000 ALTER TABLE `msg_user` ENABLE KEYS */;


-- Dumping structure for table enjoy.system_msgs
DROP TABLE IF EXISTS `system_msgs`;
CREATE TABLE IF NOT EXISTS `system_msgs` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `from_userid` int(10) unsigned DEFAULT NULL COMMENT '发起方-用户ID-(交互类型)',
  `to_userid` int(10) unsigned NOT NULL COMMENT '接收方-用户ID',
  `msg_kind` smallint(5) unsigned DEFAULT NULL COMMENT '业务类型',
  `msg_type` enum('1','2') NOT NULL COMMENT '消息类型: 1 => 系统通知， 2 => 交互类型',
  `msg_content` text NOT NULL COMMENT '消息内容',
  `var1` varchar(300) NOT NULL DEFAULT '' COMMENT '扩展字段',
  `ext_id`  int(10) unsigned DEFAULT '0' L COMMENT '扩展ID字段',
  `msg_result` enum('0','1','2','3','4','5') DEFAULT NULL COMMENT '用户选择结果， 对应 msg_btn 字段交互类型',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '状态:0 => 未读;1 => 已读;2 => 删除',
  PRIMARY KEY (`msg_id`),
  KEY `fh_systemMsg_toUseridSts` (`to_userid`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统消息表';

-- Dumping data for table enjoy.system_msgs: ~1 rows (approximately)
/*!40000 ALTER TABLE `system_msgs` DISABLE KEYS */;
INSERT INTO `system_msgs` (`msg_id`, `from_userid`, `to_userid`, `msg_kind`, `msg_type`, `msg_content`, `var1`, `msg_result`, `create_time`, `status`) VALUES
	(1, 1, 3, 2, '2', '向你发起借书申请,书名：HTML5程序设计（第2版）', 'a:4:{s:6:"pub_id";s:2:"27";s:8:"username";s:4:"test";s:5:"email";s:23:"hvfghzrtcrf1112@bfg.com";s:9:"phone_num";s:11:"15026641450";}', NULL, '2014-01-26 17:25:56', '0');
/*!40000 ALTER TABLE `system_msgs` ENABLE KEYS */;


-- Dumping structure for table enjoy.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `passwd` varchar(32) NOT NULL COMMENT '密码',
  `lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上次登录时间',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户登录表';

-- Dumping data for table enjoy.user: 3 rows
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `username`, `passwd`, `lastlogin`) VALUES
	(1, 'test', 'b0baee9d279d34fa1dfd71aadb908c3f', '2014-01-23 15:57:15'),
	(2, 'test1', 'b0baee9d279d34fa1dfd71aadb908c3f', '2014-01-23 16:00:43'),
	(3, 'test2', 'b0baee9d279d34fa1dfd71aadb908c3f', '2014-01-23 16:28:11');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- Dumping structure for table enjoy.user_action_config
DROP TABLE IF EXISTS `user_action_config`;
CREATE TABLE IF NOT EXISTS `user_action_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(50) NOT NULL COMMENT '行为名称',
  `code` varchar(30) NOT NULL COMMENT '行为代码。程序区分的唯一标示',
  `coin` smallint(6) NOT NULL COMMENT '获得乐享豆数量',
  `coin_limit` smallint(6) NOT NULL COMMENT '获得乐享豆上限',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户行为配置表';

-- Dumping data for table enjoy.user_action_config: ~7 rows (approximately)
/*!40000 ALTER TABLE `user_action_config` DISABLE KEYS */;
INSERT INTO `user_action_config` (`id`, `name`, `code`, `coin`, `coin_limit`) VALUES
	(1, '上传图书', 'pub_book', 5, 5),
	(2, '第一次借入图书', 'borrow_book_first', 2, 2),
	(3, '借入图书', 'borrow_book ', -5, 0),
	(4, '借出图书', 'loan_book', 4, 0),
	(5, '转出', 'roll_out', 0, 0),
	(6, '转入', 'roll_in', 0, 0),
	(7, '充值', 'recharge_coin', 0, 0);
/*!40000 ALTER TABLE `user_action_config` ENABLE KEYS */;


-- Dumping structure for table enjoy.user_books
DROP TABLE IF EXISTS `user_books`;
CREATE TABLE IF NOT EXISTS `user_books` (
  `pub_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '图书id',
  `library_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '图书馆id',
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '书主id',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `remark` varchar(500) COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `book_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '图书状态，0 待审核1上架 2 下架',
  `loan_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '借阅状态，0 不可借 1可借2 借出 3 预约',
  `loan_way` tinyint(4) NOT NULL DEFAULT '1' COMMENT '借阅方式， 1 当面借阅 2 押金借阅',
  `lent_way` tinyint(4) NOT NULL DEFAULT '1' COMMENT '借出方式， 1 旅行 2 预约',
  `loan_period` int(8) NOT NULL DEFAULT '0' COMMENT '借阅期限/天',
  `deposit_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '押金方式，0 免费 1 乐享豆 2 密钥 3 现金',
  `deposit` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '押金',
  `sskey` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图书密钥',
  `address` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '位置',
  `lng` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '坐标经度',
  `lat` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '坐标维度',
  `public_time` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '发布时间',
  `last_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后修改时间',
  `public` tinyint(4) NOT NULL DEFAULT '1' COMMENT '隐私，0 不公开 1公开',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态，0 删除  1正常',
  PRIMARY KEY (`pub_id`),
  KEY `user_id` (`user_id`,`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户所属图书表';

-- Dumping data for table enjoy.user_books: ~38 rows (approximately)
/*!40000 ALTER TABLE `user_books` DISABLE KEYS */;
INSERT INTO `user_books` (`pub_id`, `book_id`, `library_id`, `user_id`, `username`, `remark`, `book_status`, `loan_status`, `loan_way`, `lent_way`, `loan_period`, `deposit_type`, `deposit`, `sskey`, `address`, `lng`, `lat`, `public_time`, `last_time`, `public`, `status`) VALUES
	(2, 15, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-24 13:56:50', 1, 1),
	(3, 15, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-24 13:59:06', 1, 1),
	(4, 15, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-24 14:00:09', 1, 1),
	(5, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:07:01', 1, 1),
	(6, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:13:44', 1, 1),
	(7, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:14:32', 1, 1),
	(8, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:15:13', 1, 1),
	(9, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:17:31', 1, 1),
	(10, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:18:56', 1, 1),
	(11, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:18:57', 1, 1),
	(12, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:19:14', 1, 1),
	(13, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:19:15', 1, 1),
	(14, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:19:18', 1, 1),
	(15, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:19:37', 1, 1),
	(16, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 10:21:33', 1, 1),
	(17, 15, 0, 2, 'test1', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 11:23:55', 1, 1),
	(18, 15, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 11:26:47', 1, 1),
	(19, 15, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 13:53:45', 1, 1),
	(20, 15, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 13:53:48', 1, 1),
	(21, 15, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 13:54:33', 1, 1),
	(22, 15, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 14:07:39', 1, 1),
	(23, 21, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 14:23:28', 1, 1),
	(24, 21, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 14:27:23', 1, 1),
	(25, 21, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 14:27:23', 1, 1),
	(26, 21, 0, 3, 'test2', '我的第一本图书', 1, 0, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 14:27:24', 1, 1),
	(27, 21, 0, 3, 'test2', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 15:34:55', 1, 1),
	(28, 21, 0, 3, 'test2', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-26 15:36:33', 1, 1),
	(29, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-01-27 09:43:10', 1, 1),
	(30, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-02-12 11:43:37', 1, 1),
	(31, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-02-12 11:44:34', 1, 1),
	(32, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-02-12 11:45:50', 1, 1),
	(33, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-02-12 11:46:24', 1, 1),
	(34, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-02-12 11:46:27', 1, 1),
	(35, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-02-12 11:46:32', 1, 1),
	(36, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-02-12 11:46:47', 1, 1),
	(37, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-02-12 11:46:48', 1, 1),
	(38, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-02-12 11:46:59', 1, 1),
	(39, 21, 0, 1, 'test', '我的第一本图书', 1, 1, 1, 1, 20, 1, '20', '', '', '', '', '', '2014-02-12 11:49:07', 1, 1);
/*!40000 ALTER TABLE `user_books` ENABLE KEYS */;


-- Dumping structure for table enjoy.user_coin_log
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
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='用户乐享豆日志表';

-- Dumping data for table enjoy.user_coin_log: ~21 rows (approximately)
/*!40000 ALTER TABLE `user_coin_log` DISABLE KEYS */;
INSERT INTO `user_coin_log` (`id`, `userid`, `from_userid`, `code`, `desc`, `coin`, `dayup`, `ext`, `dateline`, `kind`) VALUES
	(2, 1, 0, 'pub_book', '上传图书', 5, 20140212, 0, '2014-02-12 11:49:00', '1'),
	(3, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:39:00', '2'),
	(4, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:39:00', '2'),
	(5, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:42:00', '2'),
	(6, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:42:00', '2'),
	(7, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:42:00', '2'),
	(8, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:42:00', '2'),
	(9, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:42:00', '2'),
	(10, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:42:00', '2'),
	(11, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:46:00', '2'),
	(12, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:46:00', '2'),
	(13, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:47:00', '2'),
	(14, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:47:00', '2'),
	(15, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:48:00', '2'),
	(16, 3, 1, 'roll_in', '转入', 1, 20140212, 0, '2014-02-12 16:48:00', '2'),
	(17, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:48:00', '2'),
	(18, 3, 1, 'roll_in', '转入', 1, 20140212, 0, '2014-02-12 16:48:00', '2'),
	(19, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:49:00', '2'),
	(20, 3, 1, 'roll_in', '转入', 1, 20140212, 0, '2014-02-12 16:49:00', '2'),
	(21, 1, 3, 'roll_out', '转出', -1, 20140212, 0, '2014-02-12 16:52:00', '2'),
	(22, 3, 1, 'roll_in', '转入', 1, 20140212, 0, '2014-02-12 16:52:00', '2');
/*!40000 ALTER TABLE `user_coin_log` ENABLE KEYS */;


-- Dumping structure for table enjoy.user_contacts
DROP TABLE IF EXISTS `user_contacts`;
CREATE TABLE IF NOT EXISTS `user_contacts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '查询人id',
  `contact_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系人id',
  `is_receive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是收到消息，0发送消息1接收消息',
  `total_count` int(8) NOT NULL DEFAULT '0' COMMENT '联系人之间总消息数',
  `unread_count` int(8) NOT NULL DEFAULT '0' COMMENT '联系人之间未读数',
  `content` varchar(3000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '最后一条消息内容',
  `last_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后一条消息时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_contact_id` (`user_id`,`contact_id`),
  KEY `user_id` (`user_id`,`last_time`)
) ENGINE=InnoDB AUTO_INCREMENT=28798 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户私信联系人表';

-- Dumping data for table enjoy.user_contacts: ~2 rows (approximately)
/*!40000 ALTER TABLE `user_contacts` DISABLE KEYS */;
INSERT INTO `user_contacts` (`id`, `user_id`, `contact_id`, `is_receive`, `total_count`, `unread_count`, `content`, `last_time`) VALUES
	(28796, 1, 2, 0, 3, 0, '私消息测试112', '2014-02-17 17:28:27'),
	(28797, 2, 1, 1, 3, 0, '私消息测试112', '2014-02-17 17:28:27');
/*!40000 ALTER TABLE `user_contacts` ENABLE KEYS */;


-- Dumping structure for table enjoy.user_info
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE IF NOT EXISTS `user_info` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `realname` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `phone_num` bigint(20) NOT NULL DEFAULT '0' COMMENT '手机',
  `nick` varchar(100) NOT NULL DEFAULT '',
  `pic` varchar(100) DEFAULT NULL COMMENT '头像',
  `sex` enum('0','1') NOT NULL DEFAULT '0' COMMENT '性别0:男，1：女，默认0',
  `verify` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户类型：0：普通用户，1:系统用户',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户状态，0：受限用户，1：正常用户',
  `coin` bigint(20) NOT NULL DEFAULT '0' COMMENT '乐享豆',
  `sskey` varchar(100) NOT NULL DEFAULT '' COMMENT '密钥',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户基本信息表';

-- Dumping data for table enjoy.user_info: 3 rows
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` (`user_id`, `username`, `email`, `realname`, `phone_num`, `nick`, `pic`, `sex`, `verify`, `status`, `coin`, `sskey`) VALUES
	(1, 'test', 'hvfghzrtcrf1112@bfg.com', '', 15026641450, '', NULL, '0', 0, 1, 4, ''),
	(2, 'test1', 'hvfghzrtcrf1112@bfg.com', '', 15026641450, '', NULL, '0', 0, 1, 0, ''),
	(3, 'test2', '121943180@qq.com', '', 15026641450, '', NULL, '0', 0, 1, 14, '');
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;


-- Dumping structure for table enjoy.user_sessionid
DROP TABLE IF EXISTS `user_sessionid`;
CREATE TABLE IF NOT EXISTS `user_sessionid` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `user_id` bigint(20) NOT NULL COMMENT '用户ID',
  `sint` int(8) NOT NULL COMMENT '用户sessionid校验数值',
  `session` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'sessionid',
  `imei` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '客户端唯一标示',
  PRIMARY KEY (`id`),
  KEY `userid` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table enjoy.user_sessionid: ~3 rows (approximately)
/*!40000 ALTER TABLE `user_sessionid` DISABLE KEYS */;
INSERT INTO `user_sessionid` (`id`, `user_id`, `sint`, `session`, `imei`) VALUES
	(1, 3, 13, 'aNGIloCtR96nXmB3Ysgj04q37sqBSw4s1bhJ4wLaijhBi1894IusVg==', 'r0dE7PP8fku'),
	(2, 2, 1, 'mhVA77MEoAynXmB3Ysgj09mJ2STQJ3ae4yV286EJt+V95FZc5r4yedj1avUlNB41', 'r0dE7PP8fku'),
	(3, 1, 8, 'vj32O9K74pWnXmB3Ysgj01ZYD9f6KAgKXvQbYmL4I+uYDbHM/AketSVyjf3u8pv8', 'r0dE7PP8fku');
/*!40000 ALTER TABLE `user_sessionid` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
