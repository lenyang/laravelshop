-- MySQL dump 10.13  Distrib 5.6.29, for osx10.8 (x86_64)
--
-- Host: localhost    Database: php32
-- ------------------------------------------------------
-- Server version	5.6.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `php32_admin`
--

DROP TABLE IF EXISTS `php32_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_admin` (
  `id` smallint(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '用户密码',
  `is_admin` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_use` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用，1启用，0禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_admin`
--

LOCK TABLES `php32_admin` WRITE;
/*!40000 ALTER TABLE `php32_admin` DISABLE KEYS */;
INSERT INTO `php32_admin` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3',1,1),(6,'xiaogang11','01cfcd4f6b8770febfb40cb906715822',0,0);
/*!40000 ALTER TABLE `php32_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_admin_role`
--

DROP TABLE IF EXISTS `php32_admin_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_admin_role` (
  `admin_id` smallint(5) unsigned NOT NULL COMMENT '管理员id',
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色id',
  KEY `admin_id` (`admin_id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_admin_role`
--

LOCK TABLES `php32_admin_role` WRITE;
/*!40000 ALTER TABLE `php32_admin_role` DISABLE KEYS */;
INSERT INTO `php32_admin_role` VALUES (1,1),(6,22),(6,26);
/*!40000 ALTER TABLE `php32_admin_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_attribute`
--

DROP TABLE IF EXISTS `php32_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性名称',
  `attr_type` tinyint(3) unsigned NOT NULL COMMENT '属性类型，0：唯一，1：可选',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性的可选值，用,号分开',
  `type_id` int(11) NOT NULL COMMENT '属性对应的商品类型',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='商品属性表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_attribute`
--

LOCK TABLES `php32_attribute` WRITE;
/*!40000 ALTER TABLE `php32_attribute` DISABLE KEYS */;
INSERT INTO `php32_attribute` VALUES (1,'作者',0,'',1),(2,'外观样式',1,'翻盖,滑盖,直板,折叠,手写',2),(3,'内存容量',0,'16G,32G,64G,128G',2),(4,'操作系统',1,'windows,android,ios',2),(5,'长度',0,'',2),(6,'颜色',1,'红色,金色,黑色',2),(7,'系统',0,'MACXOS,WINDOWS,LINUX',3),(8,'尺寸',0,'',3),(9,'品牌',0,'lenove,thinkpad,hp,dell,acer',3),(10,'处理器',1,'单核,双核,四核,八核',3);
/*!40000 ALTER TABLE `php32_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_cart`
--

DROP TABLE IF EXISTS `php32_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL,
  `goods_attr_ids` varchar(255) NOT NULL,
  `goods_number` int(10) unsigned NOT NULL,
  `member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='购物车';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_cart`
--

LOCK TABLES `php32_cart` WRITE;
/*!40000 ALTER TABLE `php32_cart` DISABLE KEYS */;
INSERT INTO `php32_cart` VALUES (12,7,'60,65',100,9),(14,7,'61,66',1,9),(7,9,'97,100,103',1,9),(6,9,'96,100,104',2,9),(8,3,'72,76,80',1,9),(13,8,'87,90,94',37,9);
/*!40000 ALTER TABLE `php32_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_category`
--

DROP TABLE IF EXISTS `php32_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(30) NOT NULL COMMENT '分类名称',
  `parent_id` int(10) unsigned NOT NULL COMMENT '父级分类id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_category`
--

LOCK TABLES `php32_category` WRITE;
/*!40000 ALTER TABLE `php32_category` DISABLE KEYS */;
INSERT INTO `php32_category` VALUES (1,'手机类型',0),(2,'GSM手机',1),(3,'4g手机',1),(4,'双模手机',1),(5,'手机配件',0),(6,'充电器',5),(7,'耳机',5),(8,'电池',5),(9,'联通合约4g机',3),(10,'移动合约4g',3),(11,'家电',0),(12,'冰箱',11),(13,'电视',11),(14,'乐视电视',13),(15,'智能电视',13),(21,'美的空调',18),(18,'空调',11),(19,'数码',0),(20,'笔记本',19),(22,'海尔空调',18),(23,'柜式冰箱',12),(24,'小型冰箱',12),(25,'相机',19),(26,'超级本',20),(27,'游戏本',20),(28,'GSM单卡单待',2),(29,'GSM双卡双待',2),(30,'身体护肤',0),(31,'沐浴露',30),(32,'清爽沐浴露',31);
/*!40000 ALTER TABLE `php32_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_click_use`
--

DROP TABLE IF EXISTS `php32_click_use`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_click_use` (
  `member_id` int(10) unsigned NOT NULL,
  `comment_id` int(11) NOT NULL,
  PRIMARY KEY (`member_id`,`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员点击过的有用评论';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_click_use`
--

LOCK TABLES `php32_click_use` WRITE;
/*!40000 ALTER TABLE `php32_click_use` DISABLE KEYS */;
/*!40000 ALTER TABLE `php32_click_use` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_comment`
--

DROP TABLE IF EXISTS `php32_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL COMMENT '会员id',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `content` varchar(1000) NOT NULL COMMENT '评论的内容',
  `star` tinyint(4) NOT NULL DEFAULT '3' COMMENT '打的分',
  `is_used` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '有用的数量',
  `addtime` int(10) unsigned NOT NULL COMMENT '添加的时间',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_comment`
--

LOCK TABLES `php32_comment` WRITE;
/*!40000 ALTER TABLE `php32_comment` DISABLE KEYS */;
INSERT INTO `php32_comment` VALUES (7,9,6,'很好很傲',3,0,1464083641),(8,9,6,'很好很强大',3,0,1464091313),(5,9,6,'的味道闻',3,0,1464083535),(9,9,6,'很好很强大',3,0,1464091344),(10,9,6,'很好很强大',3,0,1464091447),(11,9,6,'很好很强大',3,0,1464091899),(12,9,6,'这么快',3,0,1464091918),(13,9,6,'这么快111',3,0,1464091992),(14,9,6,'时代的',3,0,1464092020),(15,9,6,'用的感觉很好',4,0,1464092804),(16,9,6,'用的感觉很好',4,0,1464092811),(17,9,6,'用的感觉很好111',4,0,1464092817),(18,9,6,'整体不错',3,0,1464092923),(19,9,6,'整体不错11',3,0,1464092930),(20,9,6,'整体不错112',4,0,1464092948),(21,9,6,'整体不错113',4,0,1464092954),(22,9,6,'整体不错114',4,0,1464092963),(23,9,6,'还不错',4,0,1464093027),(24,9,6,'还不错11',4,0,1464093031),(25,9,6,'还不错112',4,0,1464093040),(26,9,6,'还不错112',4,0,1464093057),(27,9,6,'测试评论一',4,0,1464094025),(28,9,6,'测试2',3,0,1464094068),(29,9,6,'测试22',3,0,1464094076),(30,9,6,'测试3',3,0,1464094096),(31,9,6,'测试33',3,0,1464094106),(32,9,6,'测试4',3,0,1464094122),(33,9,6,'测试46',4,0,1464094185),(34,9,6,'测试46',4,0,1464098808),(35,9,6,'测试46',4,0,1464098812);
/*!40000 ALTER TABLE `php32_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_goods`
--

DROP TABLE IF EXISTS `php32_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(45) NOT NULL COMMENT '商品名称',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '商品logo',
  `sm_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '商品缩略图logo',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_desc` longtext COMMENT '商品描述',
  `is_on_sale` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架：1：上架，0：下架',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否已经删除，1：已经删除 0：未删除',
  `addtime` int(10) unsigned NOT NULL COMMENT '添加时间',
  `market_price` decimal(10,2) DEFAULT NULL,
  `type_id` int(11) NOT NULL DEFAULT '0',
  `cat_id` int(11) DEFAULT '0',
  `is_new` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否新品，1是，0否',
  `is_best` tinyint(4) NOT NULL DEFAULT '0',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0',
  `is_promote` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否促销',
  `promote_start_time` int(11) NOT NULL DEFAULT '0' COMMENT '促销开始时间',
  `promote_end_time` int(11) NOT NULL DEFAULT '0' COMMENT '促销结束时间',
  `sort_num` tinyint(4) DEFAULT '100' COMMENT '排序数字',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价',
  PRIMARY KEY (`id`),
  KEY `is_on_sale` (`is_on_sale`),
  KEY `is_delete` (`is_delete`),
  KEY `addtime` (`addtime`),
  KEY `price` (`shop_price`) USING BTREE,
  KEY ` cat_id` (`cat_id`),
  KEY `type_id` (`type_id`),
  KEY `is_new` (`is_new`),
  KEY `is_best` (`is_best`),
  KEY `is_hot` (`is_hot`),
  KEY `srot_num` (`sort_num`),
  KEY `promote_start_time` (`promote_start_time`),
  KEY `promote_end_time` (`promote_end_time`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_goods`
--

LOCK TABLES `php32_goods` WRITE;
/*!40000 ALTER TABLE `php32_goods` DISABLE KEYS */;
INSERT INTO `php32_goods` VALUES (3,'iphone 6s plus','uploads/20160517174807177.jpg','uploads/thumb_0_20160517174807177.jpg',4880.00,'<p>其他性能全新 1200 万像素 iSight 摄像头，单个像素尺寸为 1.22 微米<br/>Live Photos<br/>Focus Pixels 自动对焦<br/>光学图像防抖功能 (仅限于 iPhone 6s Plus)<br/>True Tone 闪光灯<br/>全景模式 (高达 6300 万像素)<br/>自动 HDR 照片<br/>曝光控制<br/>连拍快照模式<br/>计时模式<br/>F/2.2 光圈<br/>五镜式镜头<br/>混合红外线滤镜<br/>背照式感光元件<br/>自动图像防抖功能<br/>优化的局部色调映射功能<br/>优化的降噪功能<br/>面部识别功能<br/>照片地理标记功能</p><p>11111111<br/></p>',1,0,1463384623,5288.00,2,4,0,1,0,1,1463500800,1464624000,98,4700.00),(5,'小米','uploads/20160516155745722.jpg','uploads/thumb_0_20160516155745722.jpg',1800.00,'<ul class=\"attributes-list list-paddingleft-2\"><li><p>CPU品牌:&nbsp;高通</p></li><li><p>CPU型号:&nbsp;骁龙808</p></li><li><p>产品名称:&nbsp;MIUI/小米 小米4C</p></li><li><p>品牌:&nbsp;Xiaomi/小米</p></li><li><p>型号:&nbsp;小米4S</p></li><li><p>上市时间:&nbsp;2015年9月</p></li><li><p>网络类型:&nbsp;移动4G/联通4G/电信4G</p></li><li><p>款式:&nbsp;直板</p></li><li><p>尺寸:&nbsp;5.0英寸</p></li><li><p>机身颜色:&nbsp;【当天发】全网通 灰色 【当天发】全网通 粉色 【当天发】全网通 白色</p></li><li><p>套餐类型:&nbsp;官方标配 套餐一 套餐二 套餐三</p></li><li><p>后置摄像头:&nbsp;1300万像素</p></li><li><p>操作系统:&nbsp;MIUI</p></li><li><p>附加功能:&nbsp;OTG 光线感应 电子罗盘 距离感应 重力感应 WIFI上网 GPS导航 双卡双待 高清视频 GPRS上网</p></li><li><p>宝贝成色:&nbsp;全新</p></li><li><p>售后服务:&nbsp;全国联保</p></li><li><p>触摸屏类型:&nbsp;电容式</p></li><li><p>机身内存:&nbsp;16GB 32GB</p></li><li><p>键盘类型:&nbsp;虚拟触屏键盘</p></li><li><p>厚度:&nbsp;9mm以下</p></li><li><p>分辨率:&nbsp;1920x1080</p></li><li><p>手机类型:&nbsp;拍照手机 音乐手机 时尚手机 智能手机 3G手机 4G手机 商务手机 女性手机</p></li><li><p>电池类型:&nbsp;不可拆卸式电池</p></li><li><p>摄像头类型:&nbsp;双摄像头（前后）</p></li><li><p>视频显示格式:&nbsp;1080P(全高清D5)</p></li><li><p>网络模式:&nbsp;双卡多模</p></li><li><p>核心数:&nbsp;六核</p></li><li><p>版本类型:&nbsp;中国大陆</p></li></ul><p><br/></p>',1,0,1463385465,2199.00,2,4,0,1,1,1,1463414400,1464710400,97,1750.00),(6,'荣耀7','uploads/20160516160036118.jpg','uploads/thumb_0_20160516160036118.jpg',1699.00,'<p><strong>瓮声瓮气萨科齐万水千山空气为节省空间请问是轻微咳嗽完全是完全失去我就是去玩是清武弘嗣千瓦时去万科社区思考和轻微咳嗽请问思考和千瓦时请问社区卫生</strong>q<br/></p>',1,0,1463385636,1799.00,2,2,1,1,0,1,1463328000,1463587200,89,1600.00),(7,'锤子t2','uploads/20160516160332570.jpg','uploads/thumb_0_20160516160332570.jpg',2300.00,'<p>',1,0,1463385812,2500.00,2,2,1,0,1,1,1463414400,1464624000,90,2200.00),(8,'oppo','uploads/20160519122627742.jpg','uploads/thumb_0_20160519122627742.jpg',1900.00,'<p><em><strong>oppo很漂亮<em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em><em style=\"white-space: normal;\"><strong>oppo很漂亮</strong></em>2016-05-1912:24:46℃</strong></em></p>',1,0,1463631987,2000.00,2,3,1,0,1,1,1463673600,1464278400,99,1800.00),(9,'三星 s7','uploads/20160519123100390.jpg','uploads/thumb_0_20160519123100390.jpg',4800.00,'<p><strong>曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;曲面屏3d弧度&nbsp;</strong></p>',1,0,1463632260,5299.00,2,2,1,1,0,0,0,0,100,0.00),(10,'魅族note3','uploads/20160519123323269.jpg','uploads/thumb_0_20160519123323269.jpg',899.00,'<p>良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价良心价</p>',1,0,1463632403,999.00,2,3,0,1,1,0,0,0,96,0.00),(11,'ThinkPadX2301','uploads/20160519143608500.jpg','uploads/thumb_0_20160519143608500.jpg',6000.00,'<ul style=\"list-style-type: none;\" class=\" list-paddingleft-2\"><li><p>商品名称：ThinkPadX230(2306 3T4）</p></li><li><p>商品编号：979631</p></li><li><p>品牌：联想（Thinkpad）</p></li><li><p>上架时间：2013-09-18 17:58:12</p></li><li><p>商品毛重：2.47kg</p></li><li><p>商品产地：中国大陆</p></li><li><p>显卡：集成显卡</p></li><li><p>触控：非触控</p></li><li><p>厚度：正常厚度（&gt;25mm）</p></li><li><p>处理器：Intel i5</p></li><li><p>尺寸：12英寸</p></li></ul><p><br/></p>',1,0,1463639768,6300.00,3,20,1,1,0,1,1463673600,1464624000,87,5600.00),(12,'坚果手机','uploads/20160531164442239.jpg','uploads/thumb_0_20160531164442239.jpg',1200.00,'<p>的的我的味道闻<br/></p>',1,0,1464684282,1300.00,2,1,1,1,0,0,0,0,100,0.00),(13,'水果手机','uploads/20160531164606935.jpg','uploads/thumb_0_20160531164606935.jpg',1300.00,'<p>离开家去上课我秦岭山区我坚强<br/></p>',1,0,1464684366,1400.00,2,1,1,1,0,0,0,0,100,0.00);
/*!40000 ALTER TABLE `php32_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_goods_attr`
--

DROP TABLE IF EXISTS `php32_goods_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_goods_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `attr_id` int(11) NOT NULL COMMENT '商品属性id',
  `attr_value` varchar(255) NOT NULL COMMENT '属性对应的值',
  `attr_price` decimal(10,2) unsigned DEFAULT NULL COMMENT '这个属性对应的价格',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 COMMENT='商品属性中间表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_goods_attr`
--

LOCK TABLES `php32_goods_attr` WRITE;
/*!40000 ALTER TABLE `php32_goods_attr` DISABLE KEYS */;
INSERT INTO `php32_goods_attr` VALUES (82,3,6,'红色',100.00),(81,3,6,'黑色',90.00),(80,3,6,'金色',80.00),(79,3,5,'34',0.00),(78,3,4,'ios',70.00),(77,3,4,'android',60.00),(76,3,4,'windows',50.00),(75,3,3,'64G',0.00),(74,3,2,'直板',40.00),(89,8,4,'windows',70.00),(88,8,3,'64G',0.00),(87,8,2,'手写',60.00),(86,8,2,'折叠',50.00),(85,8,2,'直板',40.00),(84,8,2,'滑盖',30.00),(83,8,2,'翻盖',20.00),(47,5,2,'翻盖',30.00),(48,5,2,'滑盖',40.00),(49,5,2,'直板',50.00),(50,5,3,'64G',0.00),(51,5,4,'windows',0.00),(52,5,4,'android',0.00),(53,5,5,'43',0.00),(54,6,2,'滑盖',30.00),(55,6,2,'折叠',40.00),(56,6,3,'128G',0.00),(57,6,4,'windows',70.00),(58,6,4,'android',80.00),(59,6,5,'46',0.00),(60,7,2,'翻盖',30.00),(61,7,2,'滑盖',40.00),(62,7,2,'直板',50.00),(63,7,2,'折叠',60.00),(64,7,3,'32G',0.00),(65,7,4,'windows',70.00),(66,7,4,'android',80.00),(67,7,4,'ios',90.00),(68,7,5,'75',0.00),(73,3,2,'滑盖',30.00),(72,3,2,'翻盖',20.00),(90,8,4,'android',80.00),(91,8,4,'ios',90.00),(92,8,5,'5.5',0.00),(93,8,6,'红色',100.00),(94,8,6,'金色',110.00),(95,8,6,'黑色',120.00),(96,9,2,'滑盖',20.00),(97,9,2,'直板',30.00),(98,9,2,'折叠',40.00),(99,9,3,'64G',0.00),(100,9,4,'windows',50.00),(101,9,4,'android',21.00),(102,9,5,'5.8',0.00),(103,9,6,'红色',45.00),(104,9,6,'金色',55.00),(105,9,6,'金色',65.00),(106,10,2,'翻盖',54.00),(107,10,2,'滑盖',36.00),(108,10,2,'直板',76.00),(109,10,3,'64G',0.00),(110,10,4,'windows',45.00),(111,10,4,'android',67.00),(112,10,5,'5.5',0.00),(113,10,6,'红色',53.00),(114,10,6,'金色',52.00),(115,11,7,'WINDOWS',0.00),(116,11,8,'14',0.00),(117,11,9,'thinkpad',0.00),(118,11,10,'双核',500.00),(119,11,10,'四核',1000.00),(120,11,10,'八核',1500.00),(121,12,2,'滑盖',13.00),(122,12,3,'32G',0.00),(123,12,4,'android',14.00),(124,12,5,'5.8',0.00),(125,12,6,'金色',14.00),(126,13,2,'滑盖',12.00),(127,13,3,'32G',0.00),(128,13,4,'android',13.00),(129,13,5,'5.8',0.00),(130,13,6,'金色',14.00);
/*!40000 ALTER TABLE `php32_goods_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_goods_number`
--

DROP TABLE IF EXISTS `php32_goods_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_goods_number` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品的id',
  `goods_number` int(10) unsigned NOT NULL COMMENT '库存量',
  `goods_attr_ids` varchar(150) NOT NULL COMMENT '商品属性ID列表-注释：这里的ID保存的是上面php34_goods_attr表中的ID，通过这个ID即可以知道值是什么也可以是知道属性是什么,如果有多个ID组合就用，号隔开保存一个字符串，并且存时要按ID的升序存,将来前台查询库存量时也要先把商品属性ID升序拼成字符串然后查询数据库',
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品库存量';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_goods_number`
--

LOCK TABLES `php32_goods_number` WRITE;
/*!40000 ALTER TABLE `php32_goods_number` DISABLE KEYS */;
INSERT INTO `php32_goods_number` VALUES (3,32,'74,78,81'),(3,45,'72,78,81'),(3,10,'74,78,82'),(5,20,'47,52'),(5,32,'48,51'),(5,31,'47,51'),(6,41,'54,57'),(6,43,'55,58'),(7,34,'60,65'),(7,42,'62,66'),(8,100,'87,89,93'),(8,43,'86,90,94'),(10,153,'106,110,113'),(10,63,'107,111,114'),(9,40,'97,100,104'),(9,24,'98,101,104'),(11,14,'118'),(11,34,'119'),(11,31,'120');
/*!40000 ALTER TABLE `php32_goods_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_goods_pics`
--

DROP TABLE IF EXISTS `php32_goods_pics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_goods_pics` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pic` varchar(150) NOT NULL COMMENT '图片',
  `sm_pic` varchar(150) NOT NULL COMMENT '缩略图',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品的id',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='商品图片';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_goods_pics`
--

LOCK TABLES `php32_goods_pics` WRITE;
/*!40000 ALTER TABLE `php32_goods_pics` DISABLE KEYS */;
INSERT INTO `php32_goods_pics` VALUES (34,'uploads/Goods/20160517215251398.jpg','uploads/Goods/thumb_0_20160517215251398.jpg',3),(35,'uploads/Goods/20160517215251156.jpg','uploads/Goods/thumb_0_20160517215251156.jpg',3),(38,'uploads/Goods/20160519123100843.jpg','uploads/Goods/thumb_0_20160519123100843.jpg',9),(37,'uploads/Goods/20160519122627324.jpg','uploads/Goods/thumb_0_20160519122627324.jpg',8),(36,'uploads/Goods/20160519122627922.jpg','uploads/Goods/thumb_0_20160519122627922.jpg',8),(12,'uploads/Goods/20160516155745504.jpg','uploads/Goods/thumb_0_20160516155745504.jpg',5),(13,'uploads/Goods/20160516155745894.jpg','uploads/Goods/thumb_0_20160516155745894.jpg',5),(14,'uploads/Goods/20160516155745984.jpg','uploads/Goods/thumb_0_20160516155745984.jpg',5),(15,'uploads/Goods/20160516160036193.jpg','uploads/Goods/thumb_0_20160516160036193.jpg',6),(16,'uploads/Goods/20160516160036625.jpg','uploads/Goods/thumb_0_20160516160036625.jpg',6),(17,'uploads/Goods/20160516160036421.jpg','uploads/Goods/thumb_0_20160516160036421.jpg',6),(18,'uploads/Goods/20160516160332799.jpg','uploads/Goods/thumb_0_20160516160332799.jpg',7),(19,'uploads/Goods/20160516160332824.jpg','uploads/Goods/thumb_0_20160516160332824.jpg',7),(20,'uploads/Goods/20160516160332298.jpg','uploads/Goods/thumb_0_20160516160332298.jpg',7),(39,'uploads/Goods/20160519123100788.jpg','uploads/Goods/thumb_0_20160519123100788.jpg',9),(40,'uploads/Goods/20160519123323635.jpg','uploads/Goods/thumb_0_20160519123323635.jpg',10),(41,'uploads/Goods/20160519123323270.jpg','uploads/Goods/thumb_0_20160519123323270.jpg',10),(42,'uploads/Goods/20160519123323252.jpg','uploads/Goods/thumb_0_20160519123323252.jpg',10),(43,'uploads/Goods/20160519143608879.jpg','uploads/Goods/thumb_0_20160519143608879.jpg',11),(44,'uploads/Goods/20160519143608514.jpg','uploads/Goods/thumb_0_20160519143608514.jpg',11),(46,'uploads/Goods/20160519144710964.jpg','uploads/Goods/thumb_0_20160519144710964.jpg',11),(47,'uploads/Goods/20160519144710447.jpg','uploads/Goods/thumb_0_20160519144710447.jpg',11),(49,'uploads/Goods/20160531164442663.jpg','uploads/Goods/thumb_0_20160531164442663.jpg',12),(50,'uploads/Goods/20160531164442501.jpg','uploads/Goods/thumb_0_20160531164442501.jpg',12),(51,'uploads/Goods/20160531164606430.jpg','uploads/Goods/thumb_0_20160531164606430.jpg',13);
/*!40000 ALTER TABLE `php32_goods_pics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_impression`
--

DROP TABLE IF EXISTS `php32_impression`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_impression` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imp_name` varchar(255) NOT NULL COMMENT '印象名称',
  `imp_count` smallint(6) NOT NULL DEFAULT '1' COMMENT '印象出现的次数',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='商品印象表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_impression`
--

LOCK TABLES `php32_impression` WRITE;
/*!40000 ALTER TABLE `php32_impression` DISABLE KEYS */;
INSERT INTO `php32_impression` VALUES (1,'屏幕大',15,6),(2,'所见所闻',7,6),(3,'外观漂亮',14,6),(4,'系统流畅',1,6),(5,'分辨率高',3,6);
/*!40000 ALTER TABLE `php32_impression` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_member`
--

DROP TABLE IF EXISTS `php32_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_member` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL COMMENT '会员账号',
  `password` char(32) NOT NULL COMMENT '密码',
  `face` varchar(150) NOT NULL DEFAULT '' COMMENT '头像',
  `addtime` int(10) unsigned NOT NULL COMMENT '注册时间',
  `email_code` char(32) NOT NULL DEFAULT '' COMMENT '邮件验证的验证码，当会员验证通过之后，会把这个字段清空，所以如果这个字段为空就说明会员已经通过email验证了',
  `jifen` int(11) NOT NULL DEFAULT '0' COMMENT '会员积分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='会员';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_member`
--

LOCK TABLES `php32_member` WRITE;
/*!40000 ALTER TABLE `php32_member` DISABLE KEYS */;
INSERT INTO `php32_member` VALUES (9,'azhu0914@qq.com','64296b5f4809d396b7bc98d069752cd0','',1463715703,'',101),(20,'13798041375@163.com','64296b5f4809d396b7bc98d069752cd0','',1463732214,'',0);
/*!40000 ALTER TABLE `php32_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_member_level`
--

DROP TABLE IF EXISTS `php32_member_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_member_level` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level_name` varchar(255) NOT NULL COMMENT '会员级别名称',
  `bottom_num` int(10) unsigned NOT NULL COMMENT '积分下限',
  `top_num` int(11) NOT NULL COMMENT '积分上限',
  `rate` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '折扣率',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员级别表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_member_level`
--

LOCK TABLES `php32_member_level` WRITE;
/*!40000 ALTER TABLE `php32_member_level` DISABLE KEYS */;
INSERT INTO `php32_member_level` VALUES (1,'注册会员',0,100,100),(2,'初级会员',101,200,98),(3,'高级会员',201,300,95);
/*!40000 ALTER TABLE `php32_member_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_member_price`
--

DROP TABLE IF EXISTS `php32_member_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_member_price` (
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `level_id` int(11) NOT NULL COMMENT '会员级别id',
  `price` decimal(10,2) DEFAULT NULL COMMENT '这个级别的价格',
  KEY `goods_id` (`goods_id`),
  KEY `level_id` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员价格表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_member_price`
--

LOCK TABLES `php32_member_price` WRITE;
/*!40000 ALTER TABLE `php32_member_price` DISABLE KEYS */;
INSERT INTO `php32_member_price` VALUES (3,3,3000.00),(3,2,3300.00),(3,1,3500.00),(8,3,-1.00),(8,2,-1.00),(8,1,-1.00),(5,1,1800.00),(5,2,1760.00),(5,3,1730.00),(6,1,-1.00),(6,2,-1.00),(6,3,-1.00),(7,1,2280.00),(7,2,2250.00),(7,3,2210.00),(9,1,4800.00),(9,2,4750.00),(9,3,4600.00),(10,1,899.00),(10,2,850.00),(10,3,799.00),(11,3,5850.00),(11,2,5900.00),(11,1,6000.00),(12,1,-1.00),(12,2,-1.00),(12,3,-1.00),(13,1,1300.00),(13,2,1280.00),(13,3,1250.00);
/*!40000 ALTER TABLE `php32_member_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_migrations`
--

DROP TABLE IF EXISTS `php32_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_migrations`
--

LOCK TABLES `php32_migrations` WRITE;
/*!40000 ALTER TABLE `php32_migrations` DISABLE KEYS */;
INSERT INTO `php32_migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_01_18_071439_create_admin_users',2),('2016_01_18_071720_create_admin_password_resets_table',2),('2016_01_23_031442_entrust_base',2),('2016_01_23_031518_entrust_pivot_admin_user_role',2);
/*!40000 ALTER TABLE `php32_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_order`
--

DROP TABLE IF EXISTS `php32_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `addtime` int(11) NOT NULL COMMENT '下单时间',
  `total_price` decimal(10,0) unsigned NOT NULL COMMENT '订单总价',
  `pay_status` enum('是','否') NOT NULL DEFAULT '否',
  `pay_method` varchar(100) NOT NULL,
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `shipping_method` varchar(10) NOT NULL COMMENT '快递名称',
  `shr_name` varchar(50) NOT NULL COMMENT '收货人姓名',
  `shr_tel` varchar(30) NOT NULL COMMENT '收货人电话',
  `shr_address` varchar(100) NOT NULL COMMENT '收货人地址',
  `shr_province` varchar(10) NOT NULL COMMENT '收货人省份',
  `shr_city` varchar(30) NOT NULL COMMENT '收货人城市',
  `shr_area` varchar(30) NOT NULL COMMENT '收货人地区',
  `post_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态，0等待发货，1已经发货',
  `post_number` varchar(30) NOT NULL DEFAULT '' COMMENT '快递单号',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `addtime` (`addtime`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='订单表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_order`
--

LOCK TABLES `php32_order` WRITE;
/*!40000 ALTER TABLE `php32_order` DISABLE KEYS */;
INSERT INTO `php32_order` VALUES (9,9,1464342541,6887,'是','支付宝',0,'顺丰','wc','13333333333','关山光谷软件园1号201','北京','朝阳区','西二旗',0,''),(10,9,1464399512,4460,'是','支付宝',0,'顺丰','吴超','13555555555','建材城西路金燕龙办公楼一层','上海','东城区','三环以内',0,''),(11,9,1464400281,2230,'是','支付宝',0,'顺丰','王超平 ','13333333333','关山光谷软件园1号201','武汉','东城区','三环以内',0,''),(13,9,1464400455,2230,'是','支付宝',0,'顺丰','cw','13333333333','关山光谷软件园1号201','天津','西城区','西二旗',0,''),(14,9,1464400582,2230,'是','支付宝',0,'顺丰','王超平 ','13333333333',' 建材城西路金燕龙办公楼一层','上海','西城区','西二旗',0,''),(15,9,1464400730,2230,'是','支付宝',0,'顺丰','王超平 ','13333333333',' 建材城西路金燕龙办公楼一层','天津','东城区','西三旗',0,''),(17,9,1464512633,2230,'是','支付宝',0,'顺丰','王超平 ','13555555555','建材城西路金燕龙办公楼一层','北京','东城区','西三旗',0,''),(19,9,1464513356,6690,'是','支付宝',0,'顺丰','cw','13333333333','关山光谷软件园1号201','上海','昌平区','三环以内',0,''),(20,9,1464519483,4460,'是','支付宝',0,'顺丰','wc','13333333333','关山光谷软件园1号201','上海','西城区','西二旗',0,'');
/*!40000 ALTER TABLE `php32_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_order_goods`
--

DROP TABLE IF EXISTS `php32_order_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `goods_attr_ids` varchar(150) NOT NULL COMMENT '商品属性id',
  `goods_number` int(11) NOT NULL COMMENT '购买的商品数量',
  `price` decimal(10,0) NOT NULL COMMENT '购买的价格',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='订单商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_order_goods`
--

LOCK TABLES `php32_order_goods` WRITE;
/*!40000 ALTER TABLE `php32_order_goods` DISABLE KEYS */;
INSERT INTO `php32_order_goods` VALUES (6,9,10,'106,110,113',1,3452),(7,9,9,'97,100,104',1,3435),(8,10,5,'47,52',2,2230),(9,11,5,'47,52',1,2230),(10,13,5,'47,52',1,2230),(11,14,5,'47,52',1,2230),(12,15,5,'47,52',1,2230),(13,17,5,'47,52',1,2230),(14,19,5,'47,52',3,2230),(15,20,5,'47,52',2,2230);
/*!40000 ALTER TABLE `php32_order_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_privilege`
--

DROP TABLE IF EXISTS `php32_privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_privilege` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pri_name` varchar(10) NOT NULL COMMENT '//权限名称',
  `module_name` varchar(10) DEFAULT NULL COMMENT '//模块名称',
  `controller_name` varchar(30) DEFAULT NULL COMMENT '//控制器名称',
  `action_name` varchar(30) DEFAULT NULL COMMENT '//方法名称',
  `parent_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '//上级权限名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_privilege`
--

LOCK TABLES `php32_privilege` WRITE;
/*!40000 ALTER TABLE `php32_privilege` DISABLE KEYS */;
INSERT INTO `php32_privilege` VALUES (1,'商品管理','null','null','null',0),(2,'商品列表','admin','goods','',1),(3,'添加商品','admin','goods','create',1),(4,'修改商品','admin','goods','edit',2),(5,'删除商品','admin','goods','delete',2),(7,'商品分类列表','admin','category','',1),(8,'添加分类','admin','category','create',7),(9,' 修改分类','admin','category','edit',7),(10,'删除分类','admin','category','delete',7),(11,'管理员管理','null','null','null',0),(12,'权限管理','null','null','null',0),(13,'权限列表','admin','privilege','',12),(14,'添加权限','admin','privilege','create',13),(15,'管理员列表','admin','admin','',11),(16,'商品类型','admin','type','',1),(17,'会员管理','null','null','null',0),(18,'会员列表','admin','memberlevel','',17),(20,'商品回收站','admin','goodstore','recyclelist',1);
/*!40000 ALTER TABLE `php32_privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_reply`
--

DROP TABLE IF EXISTS `php32_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL COMMENT '回复的评论的id',
  `content` varchar(1000) NOT NULL COMMENT '回复的内容',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `addtime` int(11) NOT NULL COMMENT '回复的时间',
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论回复表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_reply`
--

LOCK TABLES `php32_reply` WRITE;
/*!40000 ALTER TABLE `php32_reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `php32_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_role`
--

DROP TABLE IF EXISTS `php32_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_role`
--

LOCK TABLES `php32_role` WRITE;
/*!40000 ALTER TABLE `php32_role` DISABLE KEYS */;
INSERT INTO `php32_role` VALUES (26,'项目经理'),(22,'老板'),(25,'主管');
/*!40000 ALTER TABLE `php32_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_role_privilege`
--

DROP TABLE IF EXISTS `php32_role_privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_role_privilege` (
  `pri_id` varchar(50) NOT NULL COMMENT '权限id',
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色id',
  KEY `pri_id` (`pri_id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_role_privilege`
--

LOCK TABLES `php32_role_privilege` WRITE;
/*!40000 ALTER TABLE `php32_role_privilege` DISABLE KEYS */;
INSERT INTO `php32_role_privilege` VALUES ('10',25),('9',25),('8',25),('7',25),('1',25),('1',22),('2',22),('3',22),('4',22),('5',22),('7',22),('8',22),('9',22),('10',22),('11',25),('1',26),('2',26),('4',26),('7',26),('8',26);
/*!40000 ALTER TABLE `php32_role_privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php32_type`
--

DROP TABLE IF EXISTS `php32_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `php32_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL DEFAULT '' COMMENT '类型名称',
  PRIMARY KEY (`id`),
  KEY `type_name` (`type_name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品类型表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php32_type`
--

LOCK TABLES `php32_type` WRITE;
/*!40000 ALTER TABLE `php32_type` DISABLE KEYS */;
INSERT INTO `php32_type` VALUES (1,'书'),(2,'手机'),(3,'笔记本电脑'),(4,'化妆品'),(5,'数码相机');
/*!40000 ALTER TABLE `php32_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-01 14:45:58
