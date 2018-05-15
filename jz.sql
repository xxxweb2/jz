/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : jz

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-05-15 13:06:02
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
  `img` varchar(100) DEFAULT '/public/static/images/ico.jpg' COMMENT '头像',
  `flag` tinyint(1) DEFAULT '0',
  `isemail` tinyint(1) DEFAULT '1' COMMENT '0 未邮箱 ',
  `emilestr` varchar(200) DEFAULT NULL COMMENT '随机串用于邮箱验证',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'admin', 'admin', '13221296662', null, null, '0', '0', null);
INSERT INTO `user` VALUES ('7', '许欣欣', '123123', '1070529431@qq.com', '13221296662', 'd\r\n', '/public/static/images/ico.jpg', '0', '0', '3f408b21207a7249e53313a73a59c1a2ea035f4c');
INSERT INTO `user` VALUES ('8', 'qwe', 'qweqwe', '10@qq.com', '13221296662', '123', '/public/static/images/ico.jpg', '0', '1', '79f95eae38c3595ff80c854e1179dd0bca7ef93e');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_yuan
-- ----------------------------
INSERT INTO `user_yuan` VALUES ('1', '2', '7', '2018-05-15 09:12:09', '0');

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
  `sort` tinyint(4) DEFAULT '0' COMMENT '评分',
  `emilestr` varchar(200) DEFAULT NULL,
  `addrid` int(11) DEFAULT '1' COMMENT '地址编号',
  `age` tinyint(2) DEFAULT NULL COMMENT '年龄',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yuan
-- ----------------------------
INSERT INTO `yuan` VALUES ('1', '王一丹', '123123', '1090@qq.com', '13221296662', null, null, '3', null, '/public/static/images/ico.jpg', '0', '0', '0', '1', null, '1', null);
INSERT INTO `yuan` VALUES ('2', '王一丹', '123123', 'wang@qq.com', '13221296662', '23230219995010659160', '9', '4', '', '/public/static/images/ico.jpg', '0', '1', '0', '0', 'd684b44e627fa7ee96644ca4797c8f712faeb6a5', '1', null);
