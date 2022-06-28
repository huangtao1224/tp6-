/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : tp

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2022-06-28 09:55:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `index_admin_classify`
-- ----------------------------
DROP TABLE IF EXISTS `index_admin_classify`;
CREATE TABLE `index_admin_classify` (
  `admin_classify_id` int(10) NOT NULL AUTO_INCREMENT,
  `classify_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `classify_icon` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `classify_pid` int(10) DEFAULT NULL,
  `level_id` int(10) DEFAULT NULL,
  `classify_url` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_delete` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  PRIMARY KEY (`admin_classify_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of index_admin_classify
-- ----------------------------
INSERT INTO `index_admin_classify` VALUES ('1', '根目录', null, '0', '0', null, null, null);
INSERT INTO `index_admin_classify` VALUES ('2', '站点设置', 'app-indicator', '1', '1', 'admin/site/', '1', '1649996768');
INSERT INTO `index_admin_classify` VALUES ('3', '分类管理', 'ui-checks-grid', '1', '1', '', '1', '1649996780');
INSERT INTO `index_admin_classify` VALUES ('4', '会员管理', 'people-fill', '1', '2', 'admin/member/', '1', '1649996800');
INSERT INTO `index_admin_classify` VALUES ('5', '订单管理', 'cart4', '1', '1', 'admin/order/', '1', '1649996828');
INSERT INTO `index_admin_classify` VALUES ('6', '地址管理', 'pin-map-fill', '1', '1', 'admin/region/', '1', '1649996850');
INSERT INTO `index_admin_classify` VALUES ('7', '管理员管理', 'person-lines-fill', '1', '1', '', '1', '1649996870');
INSERT INTO `index_admin_classify` VALUES ('8', '管理员列表', '', '7', '2', 'admin/administrator/', '1', '1649996889');
INSERT INTO `index_admin_classify` VALUES ('9', '角色管理', '', '7', '2', 'admin/administrator/role/', '1', '1649996903');
INSERT INTO `index_admin_classify` VALUES ('10', '高级设置', 'gear-fill', '1', '1', 'admin/admin_classify/', '1', '1649996951');
INSERT INTO `index_admin_classify` VALUES ('11', '类型设置', 'stack', '1', '1', 'admin/type/', '1', '1649996968');
INSERT INTO `index_admin_classify` VALUES ('12', '功能设置', 'tools', '1', '1', 'admin/config/', '1', '1649996980');

-- ----------------------------
-- Table structure for `index_banner`
-- ----------------------------
DROP TABLE IF EXISTS `index_banner`;
CREATE TABLE `index_banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_banner
-- ----------------------------

-- ----------------------------
-- Table structure for `index_classify`
-- ----------------------------
DROP TABLE IF EXISTS `index_classify`;
CREATE TABLE `index_classify` (
  `classify_id` int(11) NOT NULL AUTO_INCREMENT,
  `classify_pid` int(10) DEFAULT NULL,
  `type_id` int(10) DEFAULT NULL,
  `level_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  `classify_name` varchar(99) DEFAULT NULL,
  `sub_name` varchar(99) DEFAULT NULL,
  `en_name` varchar(99) DEFAULT NULL,
  `classify_url` varchar(99) DEFAULT NULL,
  `classify_note` longtext,
  `classify_intro` longtext,
  `classify_img` varchar(99) DEFAULT NULL,
  `page_img` varchar(99) DEFAULT NULL,
  `is_delete` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`classify_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_classify
-- ----------------------------
INSERT INTO `index_classify` VALUES ('1', '0', '1', '0', '1440559315', null, null, null, '1', '根目录', null, null, null, null, null, null, null, null);
INSERT INTO `index_classify` VALUES ('2', '1', '1', '1', '1650420659', null, null, null, '1', '顶部导航', null, null, null, null, null, null, null, '1');
INSERT INTO `index_classify` VALUES ('3', '2', '6', '2', '1650420719', '', '', '', '1', '首頁', null, null, '', '', '', null, null, '1');
INSERT INTO `index_classify` VALUES ('5', '1', '1', '1', '1650420839', '', '', '', '1', '商品', null, null, '', '', '', null, null, '1');
INSERT INTO `index_classify` VALUES ('6', '3', '6', '3', '1650420779', '', '', '', '1', '首页子类', null, null, '', '', '', null, null, '1');
INSERT INTO `index_classify` VALUES ('7', '5', '6', '2', '1650420899', '', '', '', '1', '商品子类', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', '4', '4', '5', '6', 'Uploads/images/2022/04/22/1650596795_classify_img.jpg', 'Uploads/images/2022/04/22/1650596795_page_img.jpg', '1');
INSERT INTO `index_classify` VALUES ('8', '5', '1', '3', '1655709213', '', '', '', '1', '商品子类2', null, null, '', '', '', null, null, null);
INSERT INTO `index_classify` VALUES ('9', '8', '6', '4', '1655709235', '', '', '', '1', '商品子类-子类', null, null, '', '', '', null, null, null);
INSERT INTO `index_classify` VALUES ('10', '1', '1', '1', '1655779600', '', '', '', '1', '测试', null, null, '', '', '', null, null, null);
INSERT INTO `index_classify` VALUES ('11', '10', '6', '2', '1655779614', '', '', '', '1', '测试子类', null, null, '', '', '', null, null, null);

-- ----------------------------
-- Table structure for `index_classify_type`
-- ----------------------------
DROP TABLE IF EXISTS `index_classify_type`;
CREATE TABLE `index_classify_type` (
  `type_id` int(10) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_id` int(1) DEFAULT '2',
  `page_name` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `glids` longtext COLLATE utf8_unicode_ci,
  `biaoshi` int(10) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of index_classify_type
-- ----------------------------
INSERT INTO `index_classify_type` VALUES ('1', '', '无', '2', '', '1649493776', null, null);
INSERT INTO `index_classify_type` VALUES ('2', 'site', '站点设置', '1', 'index', '1650009497', null, null);
INSERT INTO `index_classify_type` VALUES ('3', 'classify', '分类管理', '1', 'index', '1650357698', null, null);
INSERT INTO `index_classify_type` VALUES ('5', 'text', '图文', '2', 'index', '1650599367', null, null);
INSERT INTO `index_classify_type` VALUES ('6', 'goods', '商品', '2', 'index', '1650599396', null, null);
INSERT INTO `index_classify_type` VALUES ('7', 'banner', 'banner', '2', 'index', '1650599407', null, null);
INSERT INTO `index_classify_type` VALUES ('8', 'news', '新闻', '2', 'index', '1650599419', null, null);
INSERT INTO `index_classify_type` VALUES ('9', 'member', '会员', '2', 'index', '1650599439', null, null);
INSERT INTO `index_classify_type` VALUES ('10', 'link', '友情链接', '2', 'index', '1650599460', null, null);
INSERT INTO `index_classify_type` VALUES ('4', 'function_switch', '功能开关', '1', 'index', '1655521082', null, null);
INSERT INTO `index_classify_type` VALUES ('14', 'order', '订单', '2', 'index', '1655707942', null, null);
INSERT INTO `index_classify_type` VALUES ('15', 'imgs', 'imgs', '1', 'index', '1655785266', '6', '2');
INSERT INTO `index_classify_type` VALUES ('17', 'img2', '子栏目二', '1', 'index', '1655795841', '6', '2');

-- ----------------------------
-- Table structure for `index_data_type`
-- ----------------------------
DROP TABLE IF EXISTS `index_data_type`;
CREATE TABLE `index_data_type` (
  `data_type_id` int(10) NOT NULL AUTO_INCREMENT,
  `data_type_name` varchar(10) DEFAULT NULL,
  `value` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`data_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_data_type
-- ----------------------------
INSERT INTO `index_data_type` VALUES ('1', '字符', 'varchar');
INSERT INTO `index_data_type` VALUES ('2', '数字', 'int');
INSERT INTO `index_data_type` VALUES ('3', '浮点', 'decimal');
INSERT INTO `index_data_type` VALUES ('4', '大字段', 'longtext');

-- ----------------------------
-- Table structure for `index_function_switch`
-- ----------------------------
DROP TABLE IF EXISTS `index_function_switch`;
CREATE TABLE `index_function_switch` (
  `function_switch_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  `sms_switch` varchar(20) DEFAULT NULL,
  `xls_content` varchar(20) DEFAULT NULL,
  `xls_order` varchar(20) DEFAULT NULL,
  `xls_member` varchar(20) DEFAULT NULL,
  `batch_shared` varchar(20) DEFAULT NULL,
  `batch_move` varchar(20) DEFAULT NULL,
  `batch_copy` varchar(20) DEFAULT NULL,
  `batch_delete` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`function_switch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_function_switch
-- ----------------------------
INSERT INTO `index_function_switch` VALUES ('1', '4', null, null, null, null, '1', '1', '1', '1', '1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for `index_goods`
-- ----------------------------
DROP TABLE IF EXISTS `index_goods`;
CREATE TABLE `index_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  `goods_name` varchar(99) DEFAULT NULL,
  `goods_intro` varchar(255) DEFAULT NULL,
  `goods_img` varchar(99) DEFAULT NULL,
  `goods_type` longtext,
  `goods_type2` varchar(99) DEFAULT NULL,
  `goods_type3` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_goods
-- ----------------------------
INSERT INTO `index_goods` VALUES ('17', '6', '1656146421', '', '', '', '1', '测试', '', 'Uploads/images/2022/06/25/1656146421_goods_img.jpg', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', '3', '5');
INSERT INTO `index_goods` VALUES ('18', '6', '1656141296', '', '', '', '1', '测试', '', null, null, null, '');

-- ----------------------------
-- Table structure for `index_img2`
-- ----------------------------
DROP TABLE IF EXISTS `index_img2`;
CREATE TABLE `index_img2` (
  `img2_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  `goods_id` int(10) NOT NULL,
  PRIMARY KEY (`img2_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_img2
-- ----------------------------

-- ----------------------------
-- Table structure for `index_imgs`
-- ----------------------------
DROP TABLE IF EXISTS `index_imgs`;
CREATE TABLE `index_imgs` (
  `imgs_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  `goods_id` int(10) NOT NULL,
  `img` varchar(99) DEFAULT NULL,
  `imgs_title` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`imgs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_imgs
-- ----------------------------

-- ----------------------------
-- Table structure for `index_input`
-- ----------------------------
DROP TABLE IF EXISTS `index_input`;
CREATE TABLE `index_input` (
  `input_id` int(10) NOT NULL AUTO_INCREMENT,
  `input_pid` int(10) DEFAULT NULL,
  `type_id` int(10) NOT NULL,
  `input_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_value` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `input_value` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `field_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `input_type_id` int(10) DEFAULT NULL,
  `data_type_id` int(10) DEFAULT NULL,
  `data_length` int(5) DEFAULT '0',
  `edit_switch` int(1) unsigned zerofill DEFAULT '2',
  `list_switch` int(1) DEFAULT '1',
  `prompt` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  PRIMARY KEY (`input_id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of index_input
-- ----------------------------
INSERT INTO `index_input` VALUES ('1', null, '2', 'title标题', '', '', '', 'title', '1', '1', '99', '2', '1', '输入框', '', '1650012665');
INSERT INTO `index_input` VALUES ('2', null, '2', '网站关键词', '', '', '', 'keywords', '2', '1', '99', '2', '1', '', '', '1650013007');
INSERT INTO `index_input` VALUES ('3', null, '2', '网站描述', '', '', '', 'description', '4', '1', '99', '2', '1', '', '', '1650013038');
INSERT INTO `index_input` VALUES ('4', null, '2', '公司名', '', '', '', 'company_name', '5', '1', '99', '2', '1', '', '', '1650013051');
INSERT INTO `index_input` VALUES ('5', null, '2', '网址', '', '', '', 'url', '6', '1', '99', '2', '1', '', '', '1650013059');
INSERT INTO `index_input` VALUES ('6', null, '2', '手机', '', '', '', 'tel', '8', '1', '99', '2', '1', '', '', '1650013072');
INSERT INTO `index_input` VALUES ('7', null, '2', '手机', '', '', '', 'mobile', '7', '1', '99', '2', '1', '', '1', '1650013082');
INSERT INTO `index_input` VALUES ('8', null, '2', 'QQ', '', '', '', 'qq', '10', '1', '99', '2', '1', '', '', '1650013096');
INSERT INTO `index_input` VALUES ('9', null, '2', '剩余短信数量', '', '', '', 'sms_number', '1', '2', '10', '2', '1', '', '', '1650013113');
INSERT INTO `index_input` VALUES ('10', null, '2', 'logo', '', '', '', 'logo_img', '7', '1', '99', '2', '1', '', '', '1650013129');
INSERT INTO `index_input` VALUES ('11', null, '2', '落款', '', '', '', 'inscribe', '3', '4', '0', '2', '1', '', '', '1650013149');
INSERT INTO `index_input` VALUES ('13', '3', '2', '多选框1', '', '1', '', '', '1', '1', '0', '1', '1', '', '', '1650073427');
INSERT INTO `index_input` VALUES ('14', '3', '2', '多选框2', '', '2', '', '', '1', '1', '0', '1', '1', '', '', '1650073431');
INSERT INTO `index_input` VALUES ('16', '4', '2', '单选框1', '', '1', '', '', '1', '1', '0', '1', '1', '', '', '1650073479');
INSERT INTO `index_input` VALUES ('17', '4', '2', '单选框2', '', '2', '', '', '1', '1', '0', '1', '1', '', '', '1650073482');
INSERT INTO `index_input` VALUES ('18', '5', '2', '下拉框1', '', '1', '', '', '1', '1', '0', '1', '1', '', '', '1650073493');
INSERT INTO `index_input` VALUES ('19', '5', '2', '下拉框2', '', '2', '', '', '1', '1', '0', '1', '1', '', '', '1650073496');
INSERT INTO `index_input` VALUES ('20', null, '3', '分类名称', '', '', '', 'classify_name', '1', '1', '99', '1', '1', '', '', '1650357729');
INSERT INTO `index_input` VALUES ('21', null, '3', '副标题', '', '', '', 'sub_name', '4', '1', '99', '2', '1', '提示', '', '1650357736');
INSERT INTO `index_input` VALUES ('22', null, '3', '英文标题', '', '', '', 'en_name', '5', '1', '99', '2', '1', '', '', '1650357744');
INSERT INTO `index_input` VALUES ('23', null, '3', '自定义链接', '', '', '', 'classify_url', '1', '1', '99', '2', '1', '', '', '1650357758');
INSERT INTO `index_input` VALUES ('24', null, '3', '分类说明', '', '', '', 'classify_note', '2', '4', '0', '2', '1', '', '', '1650357782');
INSERT INTO `index_input` VALUES ('25', null, '3', '分类简介', '', '', '', 'classify_intro', '3', '4', '0', '2', '1', '', '', '1650357792');
INSERT INTO `index_input` VALUES ('26', null, '3', '分类图片', '', '', '', 'classify_img', '7', '1', '99', '2', '1', '', '', '1650357809');
INSERT INTO `index_input` VALUES ('27', null, '3', '内页插图', '', '', '', 'page_img', '7', '1', '99', '2', '1', '', '', '1650357817');
INSERT INTO `index_input` VALUES ('28', null, '3', '是否显示', '', '', '', 'is_delete', '6', '1', '99', '1', '1', '', '', '1650357844');
INSERT INTO `index_input` VALUES ('29', '28', '3', '显示', '', '1', '', '', '1', '1', '0', '1', '1', '', '', '1650357871');
INSERT INTO `index_input` VALUES ('30', '28', '3', '隐藏', '', '2', '', '', '1', '1', '0', '1', '1', '', '', '1650357876');
INSERT INTO `index_input` VALUES ('31', '21', '3', '测试1', null, '1', null, null, null, null, '0', '2', '1', null, null, '1650595344');
INSERT INTO `index_input` VALUES ('32', '21', '3', '测试2', null, '2', null, null, null, null, '0', '2', '1', null, null, '1650595347');
INSERT INTO `index_input` VALUES ('33', '22', '3', '测试3', null, '3', null, null, null, null, '0', '2', '1', null, null, '1650595355');
INSERT INTO `index_input` VALUES ('34', '22', '3', '测试4', null, '4', null, null, null, null, '0', '2', '1', null, null, '1650595357');
INSERT INTO `index_input` VALUES ('35', null, '6', '名称', '', '', '', 'goods_name', '1', '1', '99', '2', '2', '', '', '1650599546');
INSERT INTO `index_input` VALUES ('36', null, '6', '商品简介', '', '', '', 'goods_intro', '8', '1', '255', '2', '2', '', '', '1650599571');
INSERT INTO `index_input` VALUES ('37', null, '6', '图片上传', '', '', '', 'goods_img', '7', '1', '99', '2', '2', '', '', '1650599593');
INSERT INTO `index_input` VALUES ('38', null, '6', '类型', '', '', '', 'goods_type', '4', '4', '0', '2', '2', '', '', '1650612849');
INSERT INTO `index_input` VALUES ('39', null, '6', '类型2', '', '', '', 'goods_type2', '5', '1', '99', '2', '2', '', '', '1650612858');
INSERT INTO `index_input` VALUES ('40', null, '6', '类型3', '', '', '', 'goods_type3', '6', '1', '99', '2', '2', '', '', '1650612872');
INSERT INTO `index_input` VALUES ('41', '38', '6', '测试1', '', '1', '', '', '1', '1', '0', '1', '1', '', '', '1650613177');
INSERT INTO `index_input` VALUES ('42', '38', '6', '测试2', '', '2', '', '', '1', '1', '0', '1', '1', '', '', '1650613180');
INSERT INTO `index_input` VALUES ('43', '39', '6', '测试3', '', '3', '', '', '1', '1', '0', '1', '1', '', '', '1650613185');
INSERT INTO `index_input` VALUES ('44', '39', '6', '测试4', '', '4', '', '', '1', '1', '0', '1', '1', '', '', '1650613188');
INSERT INTO `index_input` VALUES ('45', '40', '6', '测试5', '', '5', '', '', '1', '1', '0', '1', '1', '', '', '1650613195');
INSERT INTO `index_input` VALUES ('46', '40', '6', '测试6', '', '6', '', '', '1', '1', '0', '1', '1', '', '', '1650613199');
INSERT INTO `index_input` VALUES ('47', null, '9', '用户名', '', '', '', 'username', '1', '1', '99', '2', '2', '', '', '1652155691');
INSERT INTO `index_input` VALUES ('48', null, '9', '密码', '', '', '', 'password', '1', '1', '99', '2', '2', '', '', '1652155704');
INSERT INTO `index_input` VALUES ('49', null, '9', '头像', '', '', '', 'head_img', '7', '1', '99', '2', '2', '', '', '1652155720');
INSERT INTO `index_input` VALUES ('50', null, '9', '性别', '', '', '', 'sex', '5', '1', '99', '2', '2', '', '', '1652155739');
INSERT INTO `index_input` VALUES ('51', '50', '9', '男', '', '1', '', '', '1', '1', '0', '1', '1', '', '', '1652156876');
INSERT INTO `index_input` VALUES ('52', '50', '9', '女', '', '2', '', '', '1', '1', '0', '1', '1', '', '', '1652156880');
INSERT INTO `index_input` VALUES ('74', null, '4', '批量删除', '', '', '', 'batch_delete', '5', '1', '20', '2', '1', '', '', '1655521850');
INSERT INTO `index_input` VALUES ('73', null, '4', '批量复制', '', '', '', 'batch_copy', '5', '1', '20', '2', '1', '', '', '1655521843');
INSERT INTO `index_input` VALUES ('72', null, '4', '批量移动', '', '', '', 'batch_move', '5', '1', '20', '2', '1', '', '', '1655521833');
INSERT INTO `index_input` VALUES ('71', null, '4', '批量共享', '', '', '', 'batch_shared', '5', '1', '20', '2', '1', '', '', '1655521823');
INSERT INTO `index_input` VALUES ('70', null, '4', '导出会员', '', '', '', 'xls_member', '5', '1', '20', '2', '1', '', '', '1655521791');
INSERT INTO `index_input` VALUES ('67', null, '4', '短信接口', '', '', '', 'sms_switch', '5', '1', '20', '2', '1', '', '', '1655521729');
INSERT INTO `index_input` VALUES ('68', null, '4', '导出内容', '', '', '', 'xls_content', '5', '1', '20', '2', '1', '', '', '1655521752');
INSERT INTO `index_input` VALUES ('69', null, '4', '导出订单', '', '', '', 'xls_order', '5', '1', '20', '2', '1', '', '', '1655521769');
INSERT INTO `index_input` VALUES ('75', '67', '4', '是', null, '1', null, null, null, null, '0', '2', '1', null, null, '1655543149');
INSERT INTO `index_input` VALUES ('76', '67', '4', '否', null, '2', null, null, null, null, '0', '2', '1', null, null, '1655543156');
INSERT INTO `index_input` VALUES ('77', '68', '4', '是', null, '1', null, null, null, null, '0', '2', '1', null, null, '1655543162');
INSERT INTO `index_input` VALUES ('78', '68', '4', '否', null, '2', null, null, null, null, '0', '2', '1', null, null, '1655543165');
INSERT INTO `index_input` VALUES ('79', '69', '4', '是', null, '1', null, null, null, null, '0', '2', '1', null, null, '1655543171');
INSERT INTO `index_input` VALUES ('80', '69', '4', '否', null, '2', null, null, null, null, '0', '2', '1', null, null, '1655543175');
INSERT INTO `index_input` VALUES ('81', '70', '4', '是', null, '1', null, null, null, null, '0', '2', '1', null, null, '1655543181');
INSERT INTO `index_input` VALUES ('82', '70', '4', '否', null, '2', null, null, null, null, '0', '2', '1', null, null, '1655543184');
INSERT INTO `index_input` VALUES ('83', '71', '4', '是', null, '1', null, null, null, null, '0', '2', '1', null, null, '1655543191');
INSERT INTO `index_input` VALUES ('84', '71', '4', '否', null, '2', null, null, null, null, '0', '2', '1', null, null, '1655543194');
INSERT INTO `index_input` VALUES ('85', '72', '4', '是', null, '1', null, null, null, null, '0', '2', '1', null, null, '1655543201');
INSERT INTO `index_input` VALUES ('86', '72', '4', '否', null, '2', null, null, null, null, '0', '2', '1', null, null, '1655543204');
INSERT INTO `index_input` VALUES ('87', '73', '4', '是', null, '1', null, null, null, null, '0', '2', '1', null, null, '1655543212');
INSERT INTO `index_input` VALUES ('88', '73', '4', '否', null, '2', null, null, null, null, '0', '2', '1', null, null, '1655543215');
INSERT INTO `index_input` VALUES ('89', '74', '4', '是', null, '1', null, null, null, null, '0', '2', '1', null, null, '1655543222');
INSERT INTO `index_input` VALUES ('90', '74', '4', '否', null, '2', null, null, null, null, '0', '2', '1', null, null, '1655543230');
INSERT INTO `index_input` VALUES ('91', null, '15', 'img', '', '', '', 'img', '7', '1', '99', '2', '2', '', '', '1655785289');
INSERT INTO `index_input` VALUES ('92', null, '15', '标题', '', '', '', 'imgs_title', '1', '1', '99', '2', '2', '', '', '1655882027');

-- ----------------------------
-- Table structure for `index_input_type`
-- ----------------------------
DROP TABLE IF EXISTS `index_input_type`;
CREATE TABLE `index_input_type` (
  `input_type_id` int(10) NOT NULL AUTO_INCREMENT,
  `input_type_name` varchar(10) DEFAULT NULL,
  `is_parent` int(10) DEFAULT NULL,
  PRIMARY KEY (`input_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_input_type
-- ----------------------------
INSERT INTO `index_input_type` VALUES ('1', '输入框', null);
INSERT INTO `index_input_type` VALUES ('2', '多行框', null);
INSERT INTO `index_input_type` VALUES ('3', '智能口', null);
INSERT INTO `index_input_type` VALUES ('4', '多选框', '2');
INSERT INTO `index_input_type` VALUES ('5', '单选框', '2');
INSERT INTO `index_input_type` VALUES ('6', '下拉框', '2');
INSERT INTO `index_input_type` VALUES ('7', '上传口', null);
INSERT INTO `index_input_type` VALUES ('8', '日期框', null);
INSERT INTO `index_input_type` VALUES ('9', '大文件上传口', null);
INSERT INTO `index_input_type` VALUES ('10', '颜色拾取', null);

-- ----------------------------
-- Table structure for `index_link`
-- ----------------------------
DROP TABLE IF EXISTS `index_link`;
CREATE TABLE `index_link` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_link
-- ----------------------------

-- ----------------------------
-- Table structure for `index_member`
-- ----------------------------
DROP TABLE IF EXISTS `index_member`;
CREATE TABLE `index_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  `username` varchar(99) DEFAULT NULL,
  `password` varchar(99) DEFAULT NULL,
  `head_img` varchar(99) DEFAULT NULL,
  `sex` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_member
-- ----------------------------
INSERT INTO `index_member` VALUES ('1', '8', '1652164414', '24', null, null, '1', '14', '1ff1de774005f8da13f42943881c655f', '3', '2');

-- ----------------------------
-- Table structure for `index_news`
-- ----------------------------
DROP TABLE IF EXISTS `index_news`;
CREATE TABLE `index_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_news
-- ----------------------------

-- ----------------------------
-- Table structure for `index_order`
-- ----------------------------
DROP TABLE IF EXISTS `index_order`;
CREATE TABLE `index_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_order
-- ----------------------------

-- ----------------------------
-- Table structure for `index_region`
-- ----------------------------
DROP TABLE IF EXISTS `index_region`;
CREATE TABLE `index_region` (
  `region_id` int(10) NOT NULL AUTO_INCREMENT,
  `region_pid` int(10) NOT NULL,
  `region_name` varchar(199) COLLATE utf8_unicode_ci NOT NULL,
  `region_type` int(10) NOT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of index_region
-- ----------------------------
INSERT INTO `index_region` VALUES ('1', '0', '中国', '0');

-- ----------------------------
-- Table structure for `index_relevance`
-- ----------------------------
DROP TABLE IF EXISTS `index_relevance`;
CREATE TABLE `index_relevance` (
  `relevance_id` int(10) NOT NULL AUTO_INCREMENT,
  `classify_id` int(10) NOT NULL,
  `content_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  PRIMARY KEY (`relevance_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of index_relevance
-- ----------------------------
INSERT INTO `index_relevance` VALUES ('24', '6', '18', '6');
INSERT INTO `index_relevance` VALUES ('23', '3', '17', '6');
INSERT INTO `index_relevance` VALUES ('14', '0', '2', '15');
INSERT INTO `index_relevance` VALUES ('20', '0', '3', '15');

-- ----------------------------
-- Table structure for `index_role`
-- ----------------------------
DROP TABLE IF EXISTS `index_role`;
CREATE TABLE `index_role` (
  `role_id` int(10) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `role_describe` varchar(199) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of index_role
-- ----------------------------
INSERT INTO `index_role` VALUES ('1', '开发者', '开发者权利');
INSERT INTO `index_role` VALUES ('2', '超级管理员', '拥有至高无上的权利');

-- ----------------------------
-- Table structure for `index_rule`
-- ----------------------------
DROP TABLE IF EXISTS `index_rule`;
CREATE TABLE `index_rule` (
  `rule_id` int(10) NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of index_rule
-- ----------------------------
INSERT INTO `index_rule` VALUES ('1', '查看');
INSERT INTO `index_rule` VALUES ('2', '添加');
INSERT INTO `index_rule` VALUES ('3', '修改');
INSERT INTO `index_rule` VALUES ('4', '删除');

-- ----------------------------
-- Table structure for `index_rule_role`
-- ----------------------------
DROP TABLE IF EXISTS `index_rule_role`;
CREATE TABLE `index_rule_role` (
  `role_rule_id` int(10) NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL,
  `admin_classify_id` int(10) DEFAULT NULL,
  `classify_id` int(10) DEFAULT NULL,
  `rule_id` int(10) NOT NULL,
  PRIMARY KEY (`role_rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of index_rule_role
-- ----------------------------
INSERT INTO `index_rule_role` VALUES ('52', '2', null, '5', '4');
INSERT INTO `index_rule_role` VALUES ('51', '2', null, '5', '3');
INSERT INTO `index_rule_role` VALUES ('50', '2', null, '5', '2');
INSERT INTO `index_rule_role` VALUES ('49', '2', null, '5', '1');
INSERT INTO `index_rule_role` VALUES ('48', '2', null, '2', '4');
INSERT INTO `index_rule_role` VALUES ('47', '2', null, '2', '3');
INSERT INTO `index_rule_role` VALUES ('46', '2', null, '2', '2');
INSERT INTO `index_rule_role` VALUES ('45', '2', null, '2', '1');
INSERT INTO `index_rule_role` VALUES ('44', '2', '2', null, '4');
INSERT INTO `index_rule_role` VALUES ('43', '2', '2', null, '3');
INSERT INTO `index_rule_role` VALUES ('42', '2', '2', null, '2');
INSERT INTO `index_rule_role` VALUES ('41', '2', '2', null, '1');

-- ----------------------------
-- Table structure for `index_site`
-- ----------------------------
DROP TABLE IF EXISTS `index_site`;
CREATE TABLE `index_site` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) NOT NULL,
  `date` int(10) NOT NULL,
  `version_id` int(10) NOT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(99) DEFAULT NULL,
  `description` varchar(99) DEFAULT NULL,
  `company_name` varchar(99) DEFAULT NULL,
  `url` varchar(99) DEFAULT NULL,
  `tel` varchar(99) DEFAULT NULL,
  `mobile` varchar(99) DEFAULT NULL,
  `qq` varchar(99) DEFAULT NULL,
  `sms_number` int(10) DEFAULT NULL,
  `logo_img` varchar(99) DEFAULT NULL,
  `inscribe` longtext,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_site
-- ----------------------------
INSERT INTO `index_site` VALUES ('1', '3', '0', '1', '', '', '', '2', '2', '1650079391', 'Uploads/images/2022/04/19/1650355547_mobile.jpg', '#bb4949', '999', 'Uploads/images/2022/04/19/1650355976_logo_img.jpg', 'inscribe');

-- ----------------------------
-- Table structure for `index_text`
-- ----------------------------
DROP TABLE IF EXISTS `index_text`;
CREATE TABLE `index_text` (
  `text_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `title` varchar(99) DEFAULT NULL,
  `keywords` varchar(199) DEFAULT NULL,
  `description` varchar(199) DEFAULT NULL,
  `version_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`text_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_text
-- ----------------------------

-- ----------------------------
-- Table structure for `index_user`
-- ----------------------------
DROP TABLE IF EXISTS `index_user`;
CREATE TABLE `index_user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(10) DEFAULT NULL,
  `secret` int(10) DEFAULT NULL,
  `state` int(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of index_user
-- ----------------------------
INSERT INTO `index_user` VALUES ('1', 'admin', 'c54be40322e7c5c82e4c61d33bbc54c7', '管理员', '1656381056', '853692', '1');
INSERT INTO `index_user` VALUES ('2', 'wz', '4b49c37e8caa2b9f21468e8756b8e27f', '网站', '1652696297', '460228', '1');
INSERT INTO `index_user` VALUES ('4', '开发者', '202cb962ac59075b964b07152d234b70', '开发者', '1649918087', null, '1');

-- ----------------------------
-- Table structure for `index_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `index_user_role`;
CREATE TABLE `index_user_role` (
  `user_role_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of index_user_role
-- ----------------------------
INSERT INTO `index_user_role` VALUES ('1', '4', '1');
INSERT INTO `index_user_role` VALUES ('6', '1', '1');
INSERT INTO `index_user_role` VALUES ('10', '2', '2');
