/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50611
Source Host           : 127.0.0.1:3306
Source Database       : db_jdyy

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2017-03-23 17:44:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for configs
-- ----------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置名称',
  `content` text NOT NULL COMMENT '配置内容',
  `describe` varchar(200) NOT NULL DEFAULT '' COMMENT '配置描述',
  `image` varchar(300) NOT NULL DEFAULT '' COMMENT '图片',
  `time_update` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站配置表';

-- ----------------------------
-- Records of configs
-- ----------------------------
INSERT INTO `configs` VALUES ('siteinfo', '{\"sitename\":\"\\u5317\\u4eac\\u4eac\\u90fd\\u513f\\u7ae5\\u533b\\u9662\",\"sitehost\":\"http:\\/\\/www.jdetyy.com\\/\",\"seokey\":\"\\u5317\\u4eac\\u4eac\\u90fd\\u513f\\u7ae5\\u533b\\u9662\",\"seodesc\":\"\\u5317\\u4eac\\u4eac\\u90fd\\u513f\\u7ae5\\u533b\\u9662\",\"copyright\":\"jdetyy.com \\u5317\\u4eac\\u4eac\\u90fd\\u513f\\u7ae5\\u533b\\u9662\",\"siteicp\":\"\\u4eacICP\\u590713016643-4\",\"sitecyber\":\"\\u4eac\\u516c\\u7f51\\u5b89\\u590788888888\\u53f7\",\"sitestatus\":1}', '网站信息', '', '0');

-- ----------------------------
-- Table structure for mg_authaccess
-- ----------------------------
DROP TABLE IF EXISTS `mg_authaccess`;
CREATE TABLE `mg_authaccess` (
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色 id',
  `rule_name` varchar(255) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台权限授权表';

-- ----------------------------
-- Records of mg_authaccess
-- ----------------------------
INSERT INTO `mg_authaccess` VALUES ('2', 'menu/default');
INSERT INTO `mg_authaccess` VALUES ('2', 'menu/index');
INSERT INTO `mg_authaccess` VALUES ('2', 'common/default');
INSERT INTO `mg_authaccess` VALUES ('2', 'index/index');
INSERT INTO `mg_authaccess` VALUES ('2', 'myinfo/repasswd');
INSERT INTO `mg_authaccess` VALUES ('2', 'main/index');
INSERT INTO `mg_authaccess` VALUES ('3', 'common/default');
INSERT INTO `mg_authaccess` VALUES ('3', 'index/index');
INSERT INTO `mg_authaccess` VALUES ('3', 'myinfo/repasswd');
INSERT INTO `mg_authaccess` VALUES ('3', 'main/index');

-- ----------------------------
-- Table structure for mg_logs
-- ----------------------------
DROP TABLE IF EXISTS `mg_logs`;
CREATE TABLE `mg_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '管理员 id',
  `actions` varchar(50) NOT NULL DEFAULT '' COMMENT '操作类型',
  `content` text NOT NULL COMMENT '操作内容',
  `time_create` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='后台日志表';

-- ----------------------------
-- Records of mg_logs
-- ----------------------------
INSERT INTO `mg_logs` VALUES ('1', '1', '注销', '', '1489631368');
INSERT INTO `mg_logs` VALUES ('2', '1', '登陆', '{\"login_ip\":3232243969,\"time_login\":1489631376,\"login_count\":57}', '1489631376');
INSERT INTO `mg_logs` VALUES ('3', '1', '添加后台菜单', '{\"pid\":0,\"name\":\"\\u5185\\u5bb9\\u7ba1\\u7406\",\"model\":\"article\",\"action\":\"default\",\"icon\":\"file\",\"status\":1,\"type\":1,\"topid\":0,\"path\":\"0-65\"}', '1489632301');
INSERT INTO `mg_logs` VALUES ('4', '1', '添加后台菜单', '{\"pid\":65,\"name\":\"\\u533b\\u9662\\u52a8\\u6001\",\"model\":\"article\",\"action\":\"index\",\"icon\":\"\",\"status\":0,\"type\":1,\"topid\":\"65\",\"path\":\"0-65-66\"}', '1489632329');
INSERT INTO `mg_logs` VALUES ('5', '1', '编辑后台菜单', '{\"name\":\"\\u5185\\u5bb9\\u7ba1\\u7406\",\"model\":\"article\",\"action\":\"\",\"icon\":\"file\",\"status\":1,\"type\":1}', '1489632353');
INSERT INTO `mg_logs` VALUES ('6', '1', '编辑后台菜单', '{\"name\":\"\\u5185\\u5bb9\\u7ba1\\u7406\",\"model\":\"article\",\"action\":\"\",\"icon\":\"file\",\"status\":1,\"type\":0}', '1489632387');
INSERT INTO `mg_logs` VALUES ('7', '1', '编辑后台菜单', '{\"name\":\"\\u5185\\u5bb9\\u7ba1\\u7406\",\"model\":\"article\",\"action\":\"default\",\"icon\":\"file\",\"status\":1,\"type\":0}', '1489632398');
INSERT INTO `mg_logs` VALUES ('8', '1', '编辑后台菜单', '{\"name\":\"\\u5185\\u5bb9\\u7ba1\\u7406\",\"model\":\"article\",\"action\":\"default\",\"icon\":\"file\",\"status\":1,\"type\":1}', '1489632467');
INSERT INTO `mg_logs` VALUES ('9', '1', '编辑后台菜单', '{\"name\":\"\\u533b\\u9662\\u52a8\\u6001\",\"model\":\"article\",\"action\":\"news\",\"icon\":\"\",\"status\":0,\"type\":1}', '1489632497');
INSERT INTO `mg_logs` VALUES ('10', '1', '添加后台菜单', '{\"pid\":66,\"name\":\"\\u4fdd\\u5b58\\u533b\\u9662\\u52a8\\u6001\",\"model\":\"article\",\"action\":\"newstosave\",\"icon\":\"\",\"status\":0,\"type\":1,\"topid\":\"65\",\"path\":\"0-65-66-67\"}', '1489632541');
INSERT INTO `mg_logs` VALUES ('11', '1', '编辑后台菜单', '{\"name\":\"\\u4fdd\\u5b58\\u533b\\u9662\\u52a8\\u6001\",\"model\":\"article\",\"action\":\"newssave\",\"icon\":\"\",\"status\":0,\"type\":1}', '1489632560');
INSERT INTO `mg_logs` VALUES ('12', '1', '注销', '', '1489632566');
INSERT INTO `mg_logs` VALUES ('13', '1', '登陆', '{\"login_ip\":3232243969,\"time_login\":1489632577,\"login_count\":58}', '1489632577');
INSERT INTO `mg_logs` VALUES ('14', '1', '编辑后台菜单', '{\"name\":\"\\u533b\\u9662\\u52a8\\u6001\",\"model\":\"article\",\"action\":\"news\",\"icon\":\"\",\"status\":1,\"type\":1}', '1489632624');
INSERT INTO `mg_logs` VALUES ('15', '1', '登陆', '{\"login_ip\":3232243969,\"time_login\":1489642670,\"login_count\":59}', '1489642670');
INSERT INTO `mg_logs` VALUES ('16', '1', '登陆', '{\"login_ip\":3232243969,\"time_login\":1489654955,\"login_count\":60}', '1489654955');
INSERT INTO `mg_logs` VALUES ('17', '1', '登陆', '{\"login_ip\":3232243969,\"time_login\":1489715706,\"login_count\":61}', '1489715706');
INSERT INTO `mg_logs` VALUES ('18', '1', '登陆', '{\"login_ip\":-1062728219,\"time_login\":1490249723,\"login_count\":62}', '1490249723');
INSERT INTO `mg_logs` VALUES ('19', '1', '登陆', '{\"login_ip\":-1062728219,\"time_login\":1490249739,\"login_count\":63}', '1490249739');
INSERT INTO `mg_logs` VALUES ('20', '1', '登陆', '{\"login_ip\":-1062728219,\"time_login\":1490249878,\"login_count\":64}', '1490249878');
INSERT INTO `mg_logs` VALUES ('21', '1', '登陆', '{\"login_ip\":-1062728219,\"time_login\":1490250139,\"login_count\":67}', '1490250139');
INSERT INTO `mg_logs` VALUES ('22', '1', '注销', '', '1490250230');
INSERT INTO `mg_logs` VALUES ('23', '1', '登陆', '{\"login_ip\":-1062728219,\"time_login\":1490250247,\"login_count\":68}', '1490250247');
INSERT INTO `mg_logs` VALUES ('24', '1', '添加后台菜单', '{\"pid\":0,\"name\":\"\\u5546\\u54c1\\u7ba1\\u7406\",\"model\":\"product\",\"action\":\"product_class\",\"icon\":\"address-book\",\"status\":1,\"type\":0,\"topid\":0,\"path\":\"0-68\"}', '1490251362');
INSERT INTO `mg_logs` VALUES ('25', '1', '编辑后台菜单', '{\"name\":\"\\u5546\\u54c1\\u7ba1\\u7406\",\"model\":\"product\",\"action\":\"default\",\"icon\":\"address-book\",\"status\":1,\"type\":0}', '1490251397');
INSERT INTO `mg_logs` VALUES ('26', '1', '编辑后台菜单', '{\"name\":\"\\u5546\\u54c1\\u7ba1\\u7406\",\"model\":\"product\",\"action\":\"default\",\"icon\":\"address-book\",\"status\":1,\"type\":1}', '1490251410');
INSERT INTO `mg_logs` VALUES ('27', '1', '添加后台菜单', '{\"pid\":68,\"name\":\"\\u5206\\u7c7b\\u7ba1\\u7406\",\"model\":\"productClass\",\"action\":\"productClass\",\"icon\":\"calendar\",\"status\":1,\"type\":1,\"topid\":\"68\",\"path\":\"0-68-69\"}', '1490252497');
INSERT INTO `mg_logs` VALUES ('28', '1', '编辑后台菜单', '{\"name\":\"\\u5206\\u7c7b\\u7ba1\\u7406\",\"model\":\"product\",\"action\":\"productClass\",\"icon\":\"calendar\",\"status\":1,\"type\":1}', '1490252544');
INSERT INTO `mg_logs` VALUES ('29', '1', '编辑后台菜单', '{\"name\":\"\\u5546\\u54c1\\u5206\\u7c7b\",\"model\":\"product\",\"action\":\"productClass\",\"icon\":\"calendar\",\"status\":1,\"type\":1}', '1490252585');
INSERT INTO `mg_logs` VALUES ('30', '1', '添加后台菜单', '{\"pid\":69,\"name\":\"\\u5206\\u7c7b\\u5217\\u8868\",\"model\":\"product\",\"action\":\"productList\",\"icon\":\"bars\",\"status\":1,\"type\":1,\"topid\":\"68\",\"path\":\"0-68-69-70\"}', '1490252795');
INSERT INTO `mg_logs` VALUES ('31', '1', '添加后台菜单', '{\"pid\":69,\"name\":\"\\u6dfb\\u52a0\\u5206\\u7c7b\",\"model\":\"product\",\"action\":\"addProduct\",\"icon\":\"address-book-o\",\"status\":1,\"type\":1,\"topid\":\"68\",\"path\":\"0-68-69-71\"}', '1490252923');
INSERT INTO `mg_logs` VALUES ('32', '1', '编辑后台菜单', '{\"name\":\"\\u5546\\u54c1\\u5206\\u7c7b\",\"model\":\"product\",\"action\":\"productClass\",\"icon\":\"address-book\",\"status\":1,\"type\":1}', '1490252992');
INSERT INTO `mg_logs` VALUES ('33', '1', '编辑后台菜单', '{\"name\":\"\\u5206\\u7c7b\\u5217\\u8868\",\"model\":\"product\",\"action\":\"productList\",\"icon\":\"\",\"status\":1,\"type\":1}', '1490253011');
INSERT INTO `mg_logs` VALUES ('34', '1', '编辑后台菜单', '{\"name\":\"\\u5546\\u54c1\\u5206\\u7c7b\",\"model\":\"product\",\"action\":\"productClass\",\"icon\":\"\",\"status\":1,\"type\":1}', '1490253020');
INSERT INTO `mg_logs` VALUES ('35', '1', '编辑后台菜单', '{\"name\":\"\\u6dfb\\u52a0\\u5206\\u7c7b\",\"model\":\"product\",\"action\":\"addProduct\",\"icon\":\"\",\"status\":1,\"type\":1}', '1490253037');
INSERT INTO `mg_logs` VALUES ('36', '1', '编辑后台菜单', '{\"name\":\"\\u6dfb\\u52a0\\u5206\\u7c7b\",\"model\":\"product\",\"action\":\"addProduct\",\"icon\":\"\",\"status\":0,\"type\":0}', '1490257956');

-- ----------------------------
-- Table structure for mg_menu
-- ----------------------------
DROP TABLE IF EXISTS `mg_menu`;
CREATE TABLE `mg_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `topid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属顶级 id',
  `model` char(20) NOT NULL DEFAULT '' COMMENT '控制器',
  `action` char(20) NOT NULL DEFAULT '' COMMENT '操作名称',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(50) DEFAULT '' COMMENT '菜单图标',
  `path` varchar(50) NOT NULL DEFAULT '' COMMENT '层级关系',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `topid` (`topid`),
  KEY `model` (`model`),
  KEY `action` (`action`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of mg_menu
-- ----------------------------
INSERT INTO `mg_menu` VALUES ('1', '0', '0', 'menu', 'default', '0', '1', '菜单管理', 'list', '0-1');
INSERT INTO `mg_menu` VALUES ('2', '1', '1', 'menu', 'index', '1', '1', '后台菜单', '', '0-1-2');
INSERT INTO `mg_menu` VALUES ('3', '2', '1', 'menu', 'add', '1', '0', '添加后台菜单', '', '0-1-2-3');
INSERT INTO `mg_menu` VALUES ('4', '3', '1', 'menu', 'addsave', '1', '0', '保存添加后台菜单', '', '0-1-2-3-4');
INSERT INTO `mg_menu` VALUES ('5', '2', '1', 'menu', 'edit', '1', '0', '编辑后台菜单', '', '0-1-2-5');
INSERT INTO `mg_menu` VALUES ('6', '5', '1', 'menu', 'editsave', '1', '0', '保存编辑后台菜单', '', '0-1-2-5-6');
INSERT INTO `mg_menu` VALUES ('7', '0', '0', 'mausers', 'default', '1', '1', '用户管理', 'user', '0-7');
INSERT INTO `mg_menu` VALUES ('8', '7', '7', 'manager', 'default', '1', '1', '管理组管理', '', '0-7-8');
INSERT INTO `mg_menu` VALUES ('9', '8', '7', 'rbac', 'index', '1', '1', '角色管理', '', '0-7-8-9');
INSERT INTO `mg_menu` VALUES ('10', '9', '7', 'rbac', 'add', '1', '0', '添加角色', '', '0-7-8-9-10');
INSERT INTO `mg_menu` VALUES ('11', '10', '7', 'rbac', 'addsave', '1', '0', '保存添加角色', '', '0-7-8-9-10-11');
INSERT INTO `mg_menu` VALUES ('12', '9', '7', 'rbac', 'edit', '1', '0', '编辑角色', '', '0-7-8-9-12');
INSERT INTO `mg_menu` VALUES ('13', '12', '7', 'rbad', 'editsave', '1', '0', '保存编辑角色', '', '0-7-8-9-12-13');
INSERT INTO `mg_menu` VALUES ('14', '9', '7', 'rbad', 'authorize', '1', '0', '角色权限设置', '', '0-7-8-9-14');
INSERT INTO `mg_menu` VALUES ('15', '14', '7', 'rbac', 'saveauthorize', '1', '0', '保存角色权限设置', '', '0-7-8-9-14-15');
INSERT INTO `mg_menu` VALUES ('16', '8', '7', 'users', 'index', '1', '1', '管理员管理', '', '0-7-8-16');
INSERT INTO `mg_menu` VALUES ('17', '16', '7', 'users', 'add', '1', '0', '添加管理员', '', '0-7-8-16-17');
INSERT INTO `mg_menu` VALUES ('18', '17', '7', 'users', 'addsave', '1', '0', '保存添加管理员', '', '0-7-8-16-17-18');
INSERT INTO `mg_menu` VALUES ('19', '16', '7', 'users', 'edit', '1', '0', '编辑管理员', '', '0-7-8-16-19');
INSERT INTO `mg_menu` VALUES ('20', '19', '7', 'users', 'editsave', '1', '0', '保存编辑管理员', '', '0-7-8-16-19-20');
INSERT INTO `mg_menu` VALUES ('21', '16', '7', 'users', 'repasswd', '1', '0', '重置管理员密码', '', '0-7-8-16-21');
INSERT INTO `mg_menu` VALUES ('22', '16', '7', 'users', 'editstatus', '1', '0', '编辑管理员状态', '', '0-7-8-16-22');
INSERT INTO `mg_menu` VALUES ('23', '0', '0', 'common', 'default', '1', '0', '公共项目', 'pie-chart', '0-23');
INSERT INTO `mg_menu` VALUES ('24', '23', '23', 'index', 'index', '1', '0', '后台首页', '', '0-23-24');
INSERT INTO `mg_menu` VALUES ('25', '23', '23', 'myinfo', 'repasswd', '1', '0', '修改个人密码', '', '0-23-25');
INSERT INTO `mg_menu` VALUES ('26', '23', '23', 'main', 'index', '1', '0', '后台公共信息', '', '0-23-26');
INSERT INTO `mg_menu` VALUES ('27', '0', '0', 'setting', 'default', '0', '1', '网站配置', 'cogs', '0-27');
INSERT INTO `mg_menu` VALUES ('28', '27', '27', 'setting', 'siteinfo', '1', '1', '网站信息', 'info-circle', '0-27-28');
INSERT INTO `mg_menu` VALUES ('29', '28', '27', 'setting', 'siteinfosave', '1', '0', '保存网站信息', '', '0-27-28-29');
INSERT INTO `mg_menu` VALUES ('65', '0', '0', 'article', 'default', '1', '1', '内容管理', 'file', '0-65');
INSERT INTO `mg_menu` VALUES ('66', '65', '65', 'article', 'news', '1', '1', '医院动态', '', '0-65-66');
INSERT INTO `mg_menu` VALUES ('67', '66', '65', 'article', 'newssave', '1', '0', '保存医院动态', '', '0-65-66-67');
INSERT INTO `mg_menu` VALUES ('68', '0', '0', 'product', 'default', '1', '1', '商品管理', 'address-book', '0-68');
INSERT INTO `mg_menu` VALUES ('69', '68', '68', 'product', 'productClass', '1', '1', '商品分类', '', '0-68-69');
INSERT INTO `mg_menu` VALUES ('70', '69', '68', 'product', 'productList', '1', '1', '分类列表', '', '0-68-69-70');
INSERT INTO `mg_menu` VALUES ('71', '69', '68', 'product', 'addProduct', '0', '0', '添加分类', '', '0-68-69-71');

-- ----------------------------
-- Table structure for mg_role
-- ----------------------------
DROP TABLE IF EXISTS `mg_role`;
CREATE TABLE `mg_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '角色名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，默认 0 禁用 1 启用',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台角色表';

-- ----------------------------
-- Records of mg_role
-- ----------------------------
INSERT INTO `mg_role` VALUES ('1', '超级管理员', '1', '拥有网站最高管理员权限！');
INSERT INTO `mg_role` VALUES ('2', '编辑组', '1', '后台的编辑');

-- ----------------------------
-- Table structure for mg_roleuser
-- ----------------------------
DROP TABLE IF EXISTS `mg_roleuser`;
CREATE TABLE `mg_roleuser` (
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色 id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  KEY `role_id` (`role_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台用户角色对应表';

-- ----------------------------
-- Records of mg_roleuser
-- ----------------------------
INSERT INTO `mg_roleuser` VALUES ('2', '501');
INSERT INTO `mg_roleuser` VALUES ('3', '502');

-- ----------------------------
-- Table structure for mg_users
-- ----------------------------
DROP TABLE IF EXISTS `mg_users`;
CREATE TABLE `mg_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `passwd` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录ip',
  `login_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `time_login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `time_create` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，0 禁用 1 正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

-- ----------------------------
-- Records of mg_users
-- ----------------------------
INSERT INTO `mg_users` VALUES ('1', 'admins', '管理员', '5ead8b3fc013b0dd70ed5067e2a35d55', '0', '68', '1490250247', '1462541400', '1');

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT '' COMMENT '新闻标题',
  `title2` varchar(200) DEFAULT '' COMMENT '副标题',
  `ctime` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `image` varchar(255) DEFAULT '' COMMENT '图片',
  `content` text COMMENT '新闻内容',
  `summary` varchar(400) DEFAULT '' COMMENT '新闻摘要',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '操作人',
  `etime` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------

-- ----------------------------
-- Table structure for product_class
-- ----------------------------
DROP TABLE IF EXISTS `product_class`;
CREATE TABLE `product_class` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cname` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `kg` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '权重',
  `photo` varchar(100) NOT NULL DEFAULT '' COMMENT '分类图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='产品分类表';

-- ----------------------------
-- Records of product_class
-- ----------------------------
INSERT INTO `product_class` VALUES ('1', '分类1', '0', '');
INSERT INTO `product_class` VALUES ('2', '分类2', '0', '');
INSERT INTO `product_class` VALUES ('3', '分类3', '0', '');
