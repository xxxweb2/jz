/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : jz

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-05-19 09:09:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `addr`
-- ----------------------------
DROP TABLE IF EXISTS `addr`;
CREATE TABLE `addr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL COMMENT '地址名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of addr
-- ----------------------------
INSERT INTO `addr` VALUES ('1', '环翠区');
INSERT INTO `addr` VALUES ('2', '文登区');
INSERT INTO `addr` VALUES ('3', '荣成区');
INSERT INTO `addr` VALUES ('4', '乳山市');
INSERT INTO `addr` VALUES ('5', '其他区');

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `time` varchar(40) DEFAULT NULL,
  `click` mediumint(10) DEFAULT '0' COMMENT '点击次数',
  `msg` text COMMENT '新闻详细内容',
  `flag` tinyint(1) DEFAULT '0' COMMENT '0 正常 1关闭',
  `img` varchar(50) DEFAULT '/public/static/images/news-item.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', '成功举办“志坚剪纸”杯家政服务创新大赛', '2018/04/26 14:57', '456', '县政府副县长姚凤腾，县总工会主席常敬玉，县委组织部副部长许峰，县妇联主席刘素芹，县妇联副主席杨冬玲，县委两新工委副书记、县人才办副主任王华东，县人社局党委委员、就业管理处主任王得辉等相关领导参加了活动。', '0', '20180518\\76805aedc61de67ea9c578c70b0b1ebe.jpg');
INSERT INTO `news` VALUES ('3', '进京做家政 收入翻了好几倍', '2018/04/2 12:45', '852', '连挂烫机都没有见过的学员们在老师的指导下笨拙地操作着机器，将一件皱巴巴的衣服熨平；参加养老护理员培训的男学员们轮流扮演失能老人，躺在床上，让同学们学习如何把不能动弹的老人搬到轮椅上；育婴师班的学员们每个人手里抱着一个塑料娃娃，嘴里唱着儿歌，给“宝宝”做抚触练习……这种家政服务的技能培训其实也是一种扶贫的方式，越来越多的贫困户通过培训拿到技能证书，从而闯出一条脱贫新路。', '0', '20180518\\e95f5f2237289723a8e84198edbb42eb.jpg');
INSERT INTO `news` VALUES ('4', '杭州保姆放火案二审庭审结束 择期宣判', '18/05/16 10:22', '25', '莫焕晶在二审庭审中陈述其上诉理由时表示认罪，但提出本案后果的发生不是其所想看到的。且一审认定的部分事实与实际不符，量刑未考虑物业和公安消防部门的责任，且她在案发后并未逃跑，同时还如实供述犯罪事实，有坦白情节，一审量刑畸重，请求改判。', '0', '20180518\\066c58bd18011ebe913aede13c7e2a67.jpg');

-- ----------------------------
-- Table structure for `service`
-- ----------------------------
DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL COMMENT '服务类型名称',
  `order` mediumint(3) DEFAULT '255' COMMENT '排序 255最高 1最低',
  `flag` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of service
-- ----------------------------
INSERT INTO `service` VALUES ('1', '育儿师', '255', '0');
INSERT INTO `service` VALUES ('2', '月嫂', '255', '0');
INSERT INTO `service` VALUES ('3', '保洁人员', '255', '0');
INSERT INTO `service` VALUES ('4', '保姆', '255', '0');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT '用户名',
  `password` varchar(30) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL COMMENT '邮箱',
  `tel` varchar(11) DEFAULT NULL COMMENT '手机号',
  `addr` varchar(200) DEFAULT NULL COMMENT '详细地址',
  `img` varchar(100) DEFAULT '/public/static/images/user.jpg' COMMENT '头像',
  `flag` tinyint(1) DEFAULT '0',
  `isemail` tinyint(1) DEFAULT '1' COMMENT '0 未邮箱 ',
  `emilestr` varchar(200) DEFAULT NULL COMMENT '随机串用于邮箱验证',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'qwe', 'admin', 'admin', '13221296662', null, null, '0', '0', null);
INSERT INTO `user` VALUES ('7', '周五', '123123123', '1070529431@qq.com', '13221296662', 'd\r\n', '/public/static/images/user.jpg', '0', '0', '3f408b21207a7249e53313a73a59c1a2ea035f4c');
INSERT INTO `user` VALUES ('8', 'qwe', 'qweqwe', '10@qq.com', '13221296662', '123', '/public/static/images/user.jpg', '0', '1', '79f95eae38c3595ff80c854e1179dd0bca7ef93e');
INSERT INTO `user` VALUES ('9', 'user', 'user', 'user', '13221296662', null, '/public/static/images/user.jpg', '0', '1', null);

-- ----------------------------
-- Table structure for `user_yuan`
-- ----------------------------
DROP TABLE IF EXISTS `user_yuan`;
CREATE TABLE `user_yuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yuanid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `create_time` varchar(50) DEFAULT NULL,
  `state` tinyint(1) DEFAULT '0' COMMENT '订单状态',
  `flag` tinyint(1) DEFAULT '0',
  `info` text COMMENT '取消订单理由',
  `eva` text COMMENT '订单评价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_yuan
-- ----------------------------
INSERT INTO `user_yuan` VALUES ('1', '2', '7', '2018-05-15 09:12:09', '5', '0', '点错了', null);
INSERT INTO `user_yuan` VALUES ('2', '2', '7', '2018-05-18 16:25:33', '3', '0', 'asd', '');
INSERT INTO `user_yuan` VALUES ('3', '2', '7', '2018-05-18 17:32:45', '0', '0', null, null);
INSERT INTO `user_yuan` VALUES ('4', '3', '7', '2018-05-18 19:59:58', '0', '0', null, null);
INSERT INTO `user_yuan` VALUES ('5', '3', '7', '2018-05-18 20:05:22', '0', '0', null, null);

-- ----------------------------
-- Table structure for `yuan`
-- ----------------------------
DROP TABLE IF EXISTS `yuan`;
CREATE TABLE `yuan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL COMMENT '真实姓名',
  `password` varchar(20) DEFAULT NULL COMMENT '密码',
  `email` varchar(20) DEFAULT NULL COMMENT '邮箱',
  `tel` varchar(11) DEFAULT NULL,
  `cardid` varchar(20) DEFAULT NULL COMMENT '身份证号',
  `exper` tinyint(2) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '服务列别',
  `info` text COMMENT '个人简介',
  `img` varchar(50) DEFAULT '/public/static/images/ico.jpg',
  `flag` tinyint(1) DEFAULT '0',
  `state` tinyint(1) DEFAULT '0' COMMENT '0 待审核',
  `isemail` tinyint(1) DEFAULT '1' COMMENT '是否邮箱注册 0 未 1已点击',
  `sort` tinyint(4) DEFAULT '5' COMMENT '评分',
  `emilestr` varchar(200) DEFAULT NULL,
  `addrid` int(11) DEFAULT '1' COMMENT '地址编号',
  `age` tinyint(2) DEFAULT NULL COMMENT '年龄',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yuan
-- ----------------------------
INSERT INTO `yuan` VALUES ('1', '张三', '123123741', '1090@qq.com', '13221296662', null, '2', '3', null, '/public/static/images/ico.jpg', '0', '2', '0', '5', null, '1', null);
INSERT INTO `yuan` VALUES ('2', '李四', '123123', 'wang@qq.com', '13221296662', '23230219995010659160', '9', '4', '', '/public/static/images/ico.jpg', '0', '2', '0', '4', 'd684b44e627fa7ee96644ca4797c8f712faeb6a5', '2', null);
INSERT INTO `yuan` VALUES ('3', '王六', 'yuan', 'yuan', '13221296662', '232302199501065916', '5', '2', null, '/public/static/images/ico.jpg', '0', '2', '1', '5', null, '3', null);
