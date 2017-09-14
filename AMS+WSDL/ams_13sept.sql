/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50628
Source Host           : 192.168.1.38:3306
Source Database       : ams

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2017-09-13 15:03:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ams_admin_site_settings`
-- ----------------------------
DROP TABLE IF EXISTS `ams_admin_site_settings`;
CREATE TABLE `ams_admin_site_settings` (
  `i_id` int(4) NOT NULL AUTO_INCREMENT,
  `s_admin_email` varchar(255) NOT NULL,
  `s_smtp_host` varchar(255) DEFAULT NULL,
  `s_smtp_password` varchar(255) DEFAULT NULL,
  `s_smtp_userid` varchar(255) DEFAULT NULL,
  `i_records_per_page` int(11) NOT NULL,
  `s_footer_text` varchar(255) DEFAULT NULL,
  `s_tin` varchar(255) DEFAULT NULL,
  `s_tcc` varchar(255) DEFAULT NULL,
  `s_tm_name` varchar(255) DEFAULT NULL COMMENT 'Transmitter Name',
  `s_tm_name_cont` varchar(255) DEFAULT NULL COMMENT 'Trasmitter name continuation',
  `s_company_name` varchar(255) DEFAULT NULL,
  `s_company_name_cont` varchar(255) DEFAULT NULL,
  `s_company_address` varchar(255) DEFAULT NULL,
  `s_company_city` varchar(100) DEFAULT NULL,
  `s_company_state` varchar(20) DEFAULT NULL,
  `s_company_zip` varchar(20) DEFAULT NULL,
  `s_contact_name` varchar(255) DEFAULT NULL,
  `s_contact_number` varchar(255) DEFAULT NULL,
  `s_contact_email` varchar(255) DEFAULT NULL,
  `s_vendor_name` varchar(255) DEFAULT NULL,
  `s_vendor_address` varchar(255) DEFAULT NULL,
  `s_vendor_city` varchar(100) DEFAULT NULL,
  `s_vendor_state` varchar(20) DEFAULT NULL,
  `s_vendor_zip` varchar(20) DEFAULT NULL,
  `s_vendor_contact_name` varchar(255) DEFAULT NULL,
  `s_vendor_contact_number` varchar(255) DEFAULT NULL,
  `i_starting_batch_no` int(10) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_admin_site_settings
-- ----------------------------
INSERT INTO `ams_admin_site_settings` VALUES ('1', 'mmondal@codeuridea.com', 'mail.acumencs.com', 'smtp1234', 'smtp@acumencs.com', '20', 'Copyright © 2016-2017 Codeuridea. All rights reserved.', '121234567', '12345', 'TAX GETTERS', '', 'TAX GETTERS', '', '1709 S STATE ST', 'EDMOND', 'OK', '73013', 'JACK TAXUM', '4053400697', 'jack76@aol.com', 'ADVANCED MICRO SOLUTIONS', '1709 S. STATE STREET', 'EDMOND', 'OK', '73013', 'KYLE MCCORKLE', '4053400697', '100001');

-- ----------------------------
-- Table structure for `ams_admin_user_type`
-- ----------------------------
DROP TABLE IF EXISTS `ams_admin_user_type`;
CREATE TABLE `ams_admin_user_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `s_user_type` varchar(100) CHARACTER SET latin1 NOT NULL,
  `s_key` varchar(100) DEFAULT NULL,
  `dt_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(1) NOT NULL DEFAULT '1',
  `e_is_deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `i_display_order` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_admin_user_type
-- ----------------------------
INSERT INTO `ams_admin_user_type` VALUES ('1', 'System Admin', 'dev', '2015-08-18 13:52:39', '1', 'No', '1');
INSERT INTO `ams_admin_user_type` VALUES ('2', 'Administrators', 'administrators', '2015-08-18 13:52:59', '1', 'No', '2');
INSERT INTO `ams_admin_user_type` VALUES ('3', 'Creators', 'creators', '2017-08-14 13:04:48', '1', 'No', '3');
INSERT INTO `ams_admin_user_type` VALUES ('4', 'Techs', 'techs', '2017-08-14 13:05:02', '1', 'No', '4');

-- ----------------------------
-- Table structure for `ams_amount_codes`
-- ----------------------------
DROP TABLE IF EXISTS `ams_amount_codes`;
CREATE TABLE `ams_amount_codes` (
  `i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_form_id` varchar(255) DEFAULT NULL,
  `s_amount_type` varchar(255) DEFAULT NULL,
  `s_amount_codes` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_amount_codes
-- ----------------------------
INSERT INTO `ams_amount_codes` VALUES ('29', '1', null, '1');
INSERT INTO `ams_amount_codes` VALUES ('30', '1', null, '2');
INSERT INTO `ams_amount_codes` VALUES ('31', '1', null, '3');
INSERT INTO `ams_amount_codes` VALUES ('32', '1', null, '4');
INSERT INTO `ams_amount_codes` VALUES ('33', '1', null, '5');
INSERT INTO `ams_amount_codes` VALUES ('34', '1', null, '6');
INSERT INTO `ams_amount_codes` VALUES ('35', '1', null, '7');
INSERT INTO `ams_amount_codes` VALUES ('36', '1', null, '8');
INSERT INTO `ams_amount_codes` VALUES ('37', '1', null, '9');
INSERT INTO `ams_amount_codes` VALUES ('38', '1', null, 'A');
INSERT INTO `ams_amount_codes` VALUES ('39', '1', null, 'B');
INSERT INTO `ams_amount_codes` VALUES ('40', '1', null, 'C');
INSERT INTO `ams_amount_codes` VALUES ('41', '1', null, 'D');
INSERT INTO `ams_amount_codes` VALUES ('42', '1', null, 'E');
INSERT INTO `ams_amount_codes` VALUES ('43', '1', null, 'F');
INSERT INTO `ams_amount_codes` VALUES ('44', '1', null, 'G');
INSERT INTO `ams_amount_codes` VALUES ('45', '2', null, '1');
INSERT INTO `ams_amount_codes` VALUES ('46', '2', null, '2');
INSERT INTO `ams_amount_codes` VALUES ('47', '2', null, '3');
INSERT INTO `ams_amount_codes` VALUES ('48', '2', null, '4');
INSERT INTO `ams_amount_codes` VALUES ('49', '2', null, '5');
INSERT INTO `ams_amount_codes` VALUES ('50', '2', null, 'A');
INSERT INTO `ams_amount_codes` VALUES ('51', '2', null, 'B');
INSERT INTO `ams_amount_codes` VALUES ('52', '2', null, 'C');

-- ----------------------------
-- Table structure for `ams_batch_files_download_mapping`
-- ----------------------------
DROP TABLE IF EXISTS `ams_batch_files_download_mapping`;
CREATE TABLE `ams_batch_files_download_mapping` (
  `i_id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `s_batch_id` varchar(255) DEFAULT NULL COMMENT 'comma seperated batch codes downloaded with this file',
  `i_file_pk` int(11) DEFAULT NULL COMMENT 'PK of files_download tbl',
  `i_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0->Downloaded',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_batch_files_download_mapping
-- ----------------------------
INSERT INTO `ams_batch_files_download_mapping` VALUES ('1', '100001', '1', '0');

-- ----------------------------
-- Table structure for `ams_batch_files_downloaded`
-- ----------------------------
DROP TABLE IF EXISTS `ams_batch_files_downloaded`;
CREATE TABLE `ams_batch_files_downloaded` (
  `i_id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `i_owner_id` bigint(30) DEFAULT NULL COMMENT 'field added to see user wise records',
  `s_batch_ids` text COMMENT 'comma seperated batch codes downloaded with this file',
  `s_file` text,
  `i_created_by` int(11) DEFAULT NULL,
  `dt_download` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0->Downloaded',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_batch_files_downloaded
-- ----------------------------
INSERT INTO `ams_batch_files_downloaded` VALUES ('1', null, '100001', 'Submission1492675480.txt', '1', '2017-04-20 13:34:40', '0');

-- ----------------------------
-- Table structure for `ams_batch_master`
-- ----------------------------
DROP TABLE IF EXISTS `ams_batch_master`;
CREATE TABLE `ams_batch_master` (
  `i_id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `s_batch_id` varchar(255) DEFAULT NULL,
  `s_username` varchar(255) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(4) DEFAULT '1' COMMENT '''1''=>''Invoice Pending'', ''2''=>''Invoice Paid'',	''3''=>''Filing Queued'',	''4''=>''Filing Complete'',	''5''=>''Filing Accepted'',\r''6''=>''Filing Rejected''',
  `i_processed` tinyint(2) DEFAULT '0' COMMENT '0->No, 1->Yes',
  `s_dataProcessFor` varchar(255) DEFAULT '1' COMMENT '1->electronic filling, 2->printing, 3->both',
  `d_paid_price` decimal(15,2) DEFAULT NULL,
  `d_updated_price` decimal(15,2) DEFAULT NULL,
  `dt_updated_price` datetime DEFAULT NULL,
  `dt_change_status` datetime DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_batch_master
-- ----------------------------
INSERT INTO `ams_batch_master` VALUES ('1', '100001', 'shieldwatch', '2017-02-21 12:51:43', '3', '1', '1', '2.76', '2.76', '2017-03-01 11:53:41', '2017-05-26 07:08:25');
INSERT INTO `ams_batch_master` VALUES ('2', '100002', 'shieldwatch', '2017-02-21 13:05:35', '1', '0', '1', '2.76', null, null, null);
INSERT INTO `ams_batch_master` VALUES ('3', '100003', 'shieldwatch', '2017-03-06 13:00:52', '1', '0', '1', '2.76', null, null, null);
INSERT INTO `ams_batch_master` VALUES ('4', '100004', 'shieldwatch', '2017-03-06 13:00:53', '1', '0', '1', '2.76', null, null, null);
INSERT INTO `ams_batch_master` VALUES ('5', '100005', 'shieldwatch', '2017-04-13 15:09:48', '4', '0', '1', '2.76', null, null, '2017-04-20 09:17:49');

-- ----------------------------
-- Table structure for `ams_batch_status_history`
-- ----------------------------
DROP TABLE IF EXISTS `ams_batch_status_history`;
CREATE TABLE `ams_batch_status_history` (
  `i_id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `s_batch_id` varchar(255) DEFAULT NULL,
  `s_action` text,
  `s_comment` text,
  `i_created_by` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(4) DEFAULT '1' COMMENT '''1''=>''Invoice Pending'', ''2''=>''Invoice Paid'',	''3''=>''Filing Queued'',	''4''=>''Filing Complete'',	''5''=>''Filing Accepted'',\r''6''=>''Filing Rejected''',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_batch_status_history
-- ----------------------------
INSERT INTO `ams_batch_status_history` VALUES ('1', '100001', 'created', null, '2', '2017-02-21 12:51:44', '1');
INSERT INTO `ams_batch_status_history` VALUES ('2', '100002', 'created', null, '2', '2017-02-21 13:05:36', '1');
INSERT INTO `ams_batch_status_history` VALUES ('3', '100004', 'created', null, '2', '2017-03-06 13:00:55', '1');
INSERT INTO `ams_batch_status_history` VALUES ('4', '100003', 'created', null, '2', '2017-03-06 13:00:55', '1');
INSERT INTO `ams_batch_status_history` VALUES ('5', '100001', 'Filing Rejected', 'test rejected', '1', '2017-03-06 17:25:26', '6');
INSERT INTO `ams_batch_status_history` VALUES ('6', '100001', 'Invoice Paid', 'Invoice Paid', '2', '2017-03-09 16:24:49', '2');
INSERT INTO `ams_batch_status_history` VALUES ('7', '100001', 'Filing Queued', 'Filing Queued', '2', '2017-03-09 16:24:50', '3');
INSERT INTO `ams_batch_status_history` VALUES ('8', '100001', 'Invoice Paid', 'Invoice Paid', '2', '2017-03-10 13:36:15', '2');
INSERT INTO `ams_batch_status_history` VALUES ('9', '100001', 'Filing Queued', 'Filing Queued', '2', '2017-03-10 13:36:15', '3');
INSERT INTO `ams_batch_status_history` VALUES ('10', '100005', 'created', null, '2', '2017-04-13 15:09:50', '6');
INSERT INTO `ams_batch_status_history` VALUES ('11', '100001', 'Filing Accepted', 'accepteed', '1', '2017-04-20 13:16:00', '5');
INSERT INTO `ams_batch_status_history` VALUES ('12', '100005', 'Filing Complete', 'filling completed', '1', '2017-04-20 13:47:49', '4');
INSERT INTO `ams_batch_status_history` VALUES ('13', '100001', 'Invoice Paid', 'invoice paid', '1', '2017-05-26 11:24:56', '2');
INSERT INTO `ams_batch_status_history` VALUES ('14', '100001', 'Invoice Paid', 'paid', '1', '2017-05-26 11:36:50', '2');
INSERT INTO `ams_batch_status_history` VALUES ('15', '100001', 'Invoice Pending', '', '1', '2017-05-26 11:38:25', '1');
INSERT INTO `ams_batch_status_history` VALUES ('16', '100001', 'Invoice Paid', 'Invoice Paid', '2', '2017-08-21 11:57:35', '2');
INSERT INTO `ams_batch_status_history` VALUES ('17', '100001', 'Filing Queued', 'Filing Queued', '2', '2017-08-21 11:57:35', '3');

-- ----------------------------
-- Table structure for `ams_category`
-- ----------------------------
DROP TABLE IF EXISTS `ams_category`;
CREATE TABLE `ams_category` (
  `i_id` int(10) NOT NULL AUTO_INCREMENT,
  `s_category` varchar(255) DEFAULT NULL,
  `i_parent_id` int(10) NOT NULL DEFAULT '0',
  `i_status` int(3) NOT NULL DEFAULT '1' COMMENT '1->Active, 0->Inactive',
  `e_deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1542 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_category
-- ----------------------------
INSERT INTO `ams_category` VALUES ('1', 'Accounting', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('2', 'Advertising', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('3', 'Agricultural', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('4', 'Animals/Pets', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('5', 'Antiques', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('6', 'Appliances', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('7', 'Arts/Crafts/Floral', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('8', 'Automotive', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('9', 'Aviation', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('10', 'Awards/Prizes', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('11', 'Beauty/Personal Care', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('12', 'Building Materials', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('13', 'Business Services', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('14', 'Cards/Gifts/Books', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('15', 'Child Care', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('16', 'Cleaning', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('17', 'Clothing', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('18', 'Communications', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('19', 'Construction', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('20', 'Consulting Business', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('21', 'Convenience Stores', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('22', 'Crafts/Hobbies', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('23', 'Delivery', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('24', 'Dental Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('25', 'Distribution', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('26', 'Educational/School', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('27', 'Electronics/Computer', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('28', 'Engineering', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('29', 'Environmental Rltd', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('30', 'Equipment S & S', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('31', 'Financial Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('32', 'Firearms', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('33', 'Fitness', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('34', 'Flooring', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('35', 'Flower Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('36', 'Food Business Retail', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('37', 'Furniture Retail', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('38', 'Gas Station', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('39', 'Glass', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('40', 'Hardware Ret Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('41', 'Hobby Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('42', 'Ice Cream/Yogurt/Ice', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('43', 'Import/Export', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('44', 'Insurance', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('45', 'Interior Design/Dec', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('46', 'Internet Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('47', 'Jewelry', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('48', 'Lawn/Landscaping', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('49', 'Liquor Related Biz', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('50', 'Locksmith', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('51', 'Machine Shop', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('52', 'Mail Order', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('53', 'Manufacturing', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('54', 'Marine Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('55', 'Medical Related Biz', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('56', 'Metal Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('57', 'Miscellaneous/Other', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('58', 'Mobile Homes', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('59', 'Motorcycle', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('60', 'Moving', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('61', 'Music', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('62', 'New Franchises', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('63', 'Newspaper/Magazines', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('64', 'Office Supplies', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('65', 'Optical Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('66', 'Pack/Ship/Postal', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('67', 'Personal Services', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('68', 'Personnel Services', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('69', 'Pest Control', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('70', 'Photography', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('71', 'Pool & Spa Business', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('72', 'Printing/Typesetting', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('73', 'Professnl Practices', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('74', 'Publishing', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('75', 'Real Estate Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('76', 'Real Property Rltd', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('77', 'Recreation', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('78', 'Rental Business', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('79', 'Restaurants', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('80', 'Retail Miscellaneous', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('81', 'Routes', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('82', 'Sales & Marketing', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('83', 'Security Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('84', 'Shoes/Footwear', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('85', 'Signs', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('86', 'Sports Related Biz', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('87', 'Start Up Businesses', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('88', 'Tailoring', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('89', 'Technology', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('90', 'Telephone & Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('91', 'Toys', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('92', 'Transportation', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('93', 'Travel', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('94', 'Upholstery/Fabrics', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('95', 'Vending Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('96', 'Video Related Biz', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('97', 'Water Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('98', 'Wholesale', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('99', 'Bookkeeping', '1', '1', 'No');
INSERT INTO `ams_category` VALUES ('100', 'CPA Practice', '1', '1', 'No');
INSERT INTO `ams_category` VALUES ('101', 'Tax Practice', '1', '1', 'No');
INSERT INTO `ams_category` VALUES ('102', 'Advertising Agency', '2', '1', 'No');
INSERT INTO `ams_category` VALUES ('103', 'Advertising Specialties', '2', '1', 'No');
INSERT INTO `ams_category` VALUES ('104', 'Advertising/Promotion', '2', '1', 'No');
INSERT INTO `ams_category` VALUES ('105', 'Art & Graphic Design', '2', '1', 'No');
INSERT INTO `ams_category` VALUES ('106', 'Direct Mailing', '2', '1', 'No');
INSERT INTO `ams_category` VALUES ('107', 'Mobile Billboard', '2', '1', 'No');
INSERT INTO `ams_category` VALUES ('108', 'Print Media', '2', '1', 'No');
INSERT INTO `ams_category` VALUES ('109', 'Public Relations', '2', '1', 'No');
INSERT INTO `ams_category` VALUES ('110', 'TV Media', '2', '1', 'No');
INSERT INTO `ams_category` VALUES ('111', 'Christmas Trees', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('112', 'Crop Preparation', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('113', 'Crop Spraying', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('114', 'Dist-Seed', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('115', 'Farm Equipment Sales/Service', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('116', 'Farm Supplies', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('117', 'Fertilizer', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('118', 'Fish Farm', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('119', 'Irrigation', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('120', 'Livestock', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('121', 'Meat Processing', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('122', 'Mulch Products', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('123', 'Nursery/Plants', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('124', 'Plant Leasing/Maintenance', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('125', 'Sod Distribution', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('126', 'Tree Farm', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('127', 'Vineyard/Wines', '3', '1', 'No');
INSERT INTO `ams_category` VALUES ('128', 'Aquarium Store', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('129', 'Dog Training', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('130', 'Kennel', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('131', 'Other Pet Services', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('132', 'Pet Clothing', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('133', 'Pet Containment', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('134', 'Pet Grooming', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('135', 'Pet Shop', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('136', 'Pet Sitting', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('137', 'Pet Supplies', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('138', 'Tack Store', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('139', 'Veterinary Clinic', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('140', 'Antiques Dealer', '5', '1', 'No');
INSERT INTO `ams_category` VALUES ('141', 'Antiques/Repairs', '5', '1', 'No');
INSERT INTO `ams_category` VALUES ('142', 'Appliance Repairs', '6', '1', 'No');
INSERT INTO `ams_category` VALUES ('143', 'Appliance Sales', '6', '1', 'No');
INSERT INTO `ams_category` VALUES ('144', 'Art Catalog Sales', '7', '1', 'No');
INSERT INTO `ams_category` VALUES ('145', 'Art Dealer', '7', '1', 'No');
INSERT INTO `ams_category` VALUES ('146', 'Art Framing', '7', '1', 'No');
INSERT INTO `ams_category` VALUES ('147', 'Art Framing/Gallery', '7', '1', 'No');
INSERT INTO `ams_category` VALUES ('148', 'Art Galleries', '7', '1', 'No');
INSERT INTO `ams_category` VALUES ('149', 'Art Reproduction', '7', '1', 'No');
INSERT INTO `ams_category` VALUES ('150', 'Art Supplies', '7', '1', 'No');
INSERT INTO `ams_category` VALUES ('151', 'Auto Accessories', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('152', 'Auto Air Condition', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('153', 'Auto Body Shop', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('154', 'Auto Brake Shop', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('155', 'Auto Broker', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('156', 'Auto Car Wash', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('157', 'Auto Customizing', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('158', 'Auto Dealership', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('159', 'Auto Detailing', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('160', 'Auto Engine Rebuilding', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('161', 'Auto General Repair', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('162', 'Auto Glass', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('163', 'Auto Inspection Service', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('164', 'Auto Interior', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('165', 'Auto Muffler Shop', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('166', 'Auto Parts Store', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('167', 'Auto Quick Lube', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('168', 'Auto Radiator Shop', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('169', 'Auto Restoration', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('170', 'Auto Salvage', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('171', 'Auto Speed Shop', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('172', 'Auto Tune Up', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('173', 'Auto Upholstery', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('174', 'Auto Used Cars', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('175', 'Auto Window Tinting', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('176', 'Automotive Auction', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('177', 'Automotive Painting', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('178', 'Custom Auto Builder', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('179', 'Electrical Repair', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('180', 'Engine Installation', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('181', 'Fleet Service', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('182', 'Motor Home Sales', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('183', 'Painting/Touch Up', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('184', 'Radio Installations', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('185', 'Rustproofing', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('186', 'RV Sales/Service', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('187', 'Speciality Repairs', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('188', 'Tire Dealer', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('189', 'Tk Tanker Cleaning', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('190', 'Towing Service', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('191', 'Trailer Hitches', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('192', 'Trailer Refrigeration', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('193', 'Trailer Sales/Services', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('194', 'Transmission Shop', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('195', 'Truck Accessories', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('196', 'Truck Dealership', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('197', 'Truck Repairs', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('198', 'Truck Trailer Sales', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('199', 'Van Conversions', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('200', 'Wrecker/Carrier Dealers', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('201', 'Aircraft Cleaning', '9', '1', 'No');
INSERT INTO `ams_category` VALUES ('202', 'Aircraft Dealership', '9', '1', 'No');
INSERT INTO `ams_category` VALUES ('203', 'Aircraft Maintenance', '9', '1', 'No');
INSERT INTO `ams_category` VALUES ('204', 'Aircraft Painting', '9', '1', 'No');
INSERT INTO `ams_category` VALUES ('205', 'Aviation FBO', '9', '1', 'No');
INSERT INTO `ams_category` VALUES ('206', 'Charter/Tour Airline', '9', '1', 'No');
INSERT INTO `ams_category` VALUES ('207', 'Flight School', '9', '1', 'No');
INSERT INTO `ams_category` VALUES ('208', 'Parts and Supply', '9', '1', 'No');
INSERT INTO `ams_category` VALUES ('209', 'Awards Engraving', '10', '1', 'No');
INSERT INTO `ams_category` VALUES ('210', 'Barber Shop', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('211', 'Beauty Supply House', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('212', 'Body Wrapping', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('213', 'Hair Extension', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('214', 'Hair Removal', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('215', 'Hair Replacement', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('216', 'Hair Salon', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('217', 'Hair Salon/Day Spa', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('218', 'Nail Salon', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('219', 'Shoe Shine', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('220', 'Skin and/or Massage', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('221', 'Tanning Salon', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('222', 'Tattoo Parlor', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('223', 'Wigs', '11', '1', 'No');
INSERT INTO `ams_category` VALUES ('224', 'Building Materials', '12', '1', 'No');
INSERT INTO `ams_category` VALUES ('225', 'Applicant Screening', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('226', 'Asset Recovery', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('227', 'Christmas Lights', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('228', 'Cleaning/Janitorial', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('229', 'Construction Consulting', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('230', 'Consulting/Training', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('231', 'Convention Consulting', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('232', 'Court Recorder', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('233', 'Cryogenic Tempering', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('234', 'Data Entry', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('235', 'Data Management', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('236', 'Database Sales', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('237', 'Document Shredding', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('238', 'Equipment Testing', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('239', 'Event Planning', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('240', 'Fund Raising Service', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('241', 'Inspection Reports Preparation', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('242', 'Inventory Service', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('243', 'Investigation Agency', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('244', 'Law Firm', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('245', 'Liquidation Services', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('246', 'Litigation Support', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('247', 'Mail/Package Service', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('248', 'Management Services', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('249', 'Mfg Representative', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('250', 'Nuclear Gages S & S', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('251', 'Office Services', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('252', 'Para-Legal Services', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('253', 'Power Plant', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('254', 'Process Server', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('255', 'Production/Staging', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('256', 'Referral Service', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('257', 'Registered Agent', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('258', 'Reservation Service', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('259', 'Secretarial Services', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('260', 'Specialty Services', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('261', 'Timekeeping/Payroll', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('262', 'Translation Service', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('263', 'UFOC Preparation', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('264', 'Valet Parking', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('265', 'Book Store', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('266', 'Books Adult Rated XX', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('267', 'Cards/Greeting', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('268', 'Cigar Store', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('269', 'Gift Baskets', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('270', 'Gift Shop', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('271', 'Gifts Collectables', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('272', 'Gifts/Adult/Novelty', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('273', 'Gifts/Tobacco', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('274', 'Lobby Shop', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('275', 'Party Goods', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('276', 'Used Books - CDs', '14', '1', 'No');
INSERT INTO `ams_category` VALUES ('277', 'Childs Play Center', '15', '1', 'No');
INSERT INTO `ams_category` VALUES ('278', 'Day Care & After School', '15', '1', 'No');
INSERT INTO `ams_category` VALUES ('279', 'Day Nursery Infants', '15', '1', 'No');
INSERT INTO `ams_category` VALUES ('280', 'Day Nursery/Kindergarten', '15', '1', 'No');
INSERT INTO `ams_category` VALUES ('281', 'Childs Play Center', '15', '1', 'No');
INSERT INTO `ams_category` VALUES ('282', 'Day Care & After School', '15', '1', 'No');
INSERT INTO `ams_category` VALUES ('283', 'Aquarium Tank Cleaning', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('284', 'Carpet Cleaning', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('285', 'Carpet Dyeing/Cleaning', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('286', 'Cleaners Drop Store', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('287', 'Cleaning Air Ducts', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('288', 'Cleaning Chimneys', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('289', 'Cleaning/Clothing', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('290', 'Coin Laundry', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('291', 'Commercial Laundry', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('292', 'Construction Cleanup', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('293', 'Drape/Curtain Cleaning', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('294', 'Dry Cleaners', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('295', 'Floor Stripping/Wax', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('296', 'Hazardous Garments', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('297', 'Janitorial Service', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('298', 'Maid Service', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('299', 'Mold Remediation', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('300', 'Parking Lot Cleaning', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('301', 'Pressure Cleaning', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('302', 'Rest Equipment Cleaning', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('303', 'Water Damage/Restore', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('304', 'Window Cleaning', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('305', 'Bridal Salon', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('306', 'Clothing Beachwear', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('307', 'Clothing Boutique', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('308', 'Clothing Bridal Shop', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('309', 'Clothing Children', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('310', 'Clothing Hats', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('311', 'Clothing Lingerie', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('312', 'Clothing Men', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('313', 'Clothing Sportswear', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('314', 'Clothing Tee Shirts', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('315', 'Clothing Uniforms', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('316', 'Clothing Used', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('317', 'Clothing Western', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('318', 'Clothing Women', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('319', 'Costume Rental', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('320', 'Embroidery Service', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('321', 'Formal Wear Boutique', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('322', 'Formal Wear Rental', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('323', 'Sewing Contractor', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('324', 'Silk Screening', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('325', 'Textile Dying', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('326', 'Vintage Clothing', '17', '1', 'No');
INSERT INTO `ams_category` VALUES ('327', 'Commercial Sound Systems', '18', '1', 'No');
INSERT INTO `ams_category` VALUES ('328', 'Radio Sales & Services', '18', '1', 'No');
INSERT INTO `ams_category` VALUES ('329', 'Radio Station', '18', '1', 'No');
INSERT INTO `ams_category` VALUES ('330', 'Satellite Dishes', '18', '1', 'No');
INSERT INTO `ams_category` VALUES ('331', 'T.V. Station', '18', '1', 'No');
INSERT INTO `ams_category` VALUES ('332', 'Wireless Phone Store', '18', '1', 'No');
INSERT INTO `ams_category` VALUES ('333', 'Bldg Renovations', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('334', 'Bridge Construction', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('335', 'Cabinet Resurfacing', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('336', 'Concrete Coating', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('337', 'Construction Contractor Other', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('338', 'Construction RollOff', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('339', 'Contractor A/C & Heating', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('340', 'Contractor Aluminum Products', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('341', 'Contractor Boring', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('342', 'Contractor Cabinets', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('343', 'Contractor Carpenter', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('344', 'Contractor Ceilings', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('345', 'Contractor Coatings', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('346', 'Contractor Commercial', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('347', 'Contractor Concrete', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('348', 'Contractor Counters', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('349', 'Contractor Drywall', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('350', 'Contractor Electric', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('351', 'Contractor Fencing', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('352', 'Contractor Fireplace', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('353', 'Contractor Flooring', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('354', 'Contractor General', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('355', 'Contractor Gutters', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('356', 'Contractor Home Improvement', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('357', 'Contractor Hurricane Shutters', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('358', 'Contractor Installer', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('359', 'Contractor Insulation', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('360', 'Contractor Marine', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('361', 'Contractor Masonry', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('362', 'Contractor New Homes', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('363', 'Contractor Painting', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('364', 'Contractor Paving', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('365', 'Contractor Plumber', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('366', 'Contractor Pool', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('367', 'Contractor Refrigeration', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('368', 'Contractor Roofing', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('369', 'Contractor Sandblasting', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('370', 'Contractor Screening', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('371', 'Contractor Tiling', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('372', 'Contractor Welding', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('373', 'Contractor Windows & Doors', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('374', 'Crane Service', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('375', 'Demolition', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('376', 'Drain Cleaning', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('377', 'Driveway Sealcoat', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('378', 'Excavating/Trucking', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('379', 'Fire Damage Restoration', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('380', 'Fire Sprinklers', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('381', 'Foundation Contractor', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('382', 'Furniture Repair', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('383', 'Glass Company', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('384', 'Grout & Tile Repair', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('385', 'Handyman Service', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('386', 'Heavy Construction Parts', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('387', 'Hotel Refurbishing', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('388', 'Install Prison Equipment', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('389', 'Installation Building Equipment', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('390', 'Leak Detection', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('391', 'Lighting Contractor', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('392', 'Overhead Doors', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('393', 'Parking Lot Maintenance', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('394', 'Permitting Service', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('395', 'Pipeline Maintenance', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('396', 'Protective Coatings', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('397', 'Rigging Company', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('398', 'Roof Cleaning', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('399', 'Sheet Metal', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('400', 'Site Preparation', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('401', 'Steel Erection', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('402', 'Storm Shutters', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('403', 'Surface Preparation', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('404', 'Telecommunications', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('405', 'Tennis Court Refinishing', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('406', 'Traffic Control Supplies', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('407', 'Tub Refinishing', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('408', 'Underground Utilities', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('409', 'Waterproofing', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('410', 'Well Drilling', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('411', 'Woodworking', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('412', 'Buying Service', '20', '1', 'No');
INSERT INTO `ams_category` VALUES ('413', 'Consultant Weddings', '20', '1', 'No');
INSERT INTO `ams_category` VALUES ('414', 'Consulting Computers', '20', '1', 'No');
INSERT INTO `ams_category` VALUES ('415', 'Consulting Financial', '20', '1', 'No');
INSERT INTO `ams_category` VALUES ('416', 'Consulting Human Resources', '20', '1', 'No');
INSERT INTO `ams_category` VALUES ('417', 'Consulting Insurance', '20', '1', 'No');
INSERT INTO `ams_category` VALUES ('418', 'Consulting Party', '20', '1', 'No');
INSERT INTO `ams_category` VALUES ('419', 'Consulting Roofing', '20', '1', 'No');
INSERT INTO `ams_category` VALUES ('420', 'Beverage Store', '21', '1', 'No');
INSERT INTO `ams_category` VALUES ('421', 'C-Store & Drive Thru', '21', '1', 'No');
INSERT INTO `ams_category` VALUES ('422', 'C-Store & Restaurant', '21', '1', 'No');
INSERT INTO `ams_category` VALUES ('423', 'C-Store Only', '21', '1', 'No');
INSERT INTO `ams_category` VALUES ('424', 'Small Grocery Store', '21', '1', 'No');
INSERT INTO `ams_category` VALUES ('425', 'Arts & Crafts Supply', '22', '1', 'No');
INSERT INTO `ams_category` VALUES ('426', 'Ceramics', '22', '1', 'No');
INSERT INTO `ams_category` VALUES ('427', 'Coin & Stamp Dealer', '22', '1', 'No');
INSERT INTO `ams_category` VALUES ('428', 'Crafts Shells', '22', '1', 'No');
INSERT INTO `ams_category` VALUES ('429', 'Crafts Studio', '22', '1', 'No');
INSERT INTO `ams_category` VALUES ('430', 'Hobby/Models Store', '22', '1', 'No');
INSERT INTO `ams_category` VALUES ('431', 'Knitting Supplies', '22', '1', 'No');
INSERT INTO `ams_category` VALUES ('432', 'Needlework', '22', '1', 'No');
INSERT INTO `ams_category` VALUES ('433', 'Scrapbook Supplies', '22', '1', 'No');
INSERT INTO `ams_category` VALUES ('434', 'Stained Glass', '22', '1', 'No');
INSERT INTO `ams_category` VALUES ('435', 'Delivery Automobiles', '23', '1', 'No');
INSERT INTO `ams_category` VALUES ('436', 'Delivery Food', '23', '1', 'No');
INSERT INTO `ams_category` VALUES ('437', 'Delivery/Courier', '23', '1', 'No');
INSERT INTO `ams_category` VALUES ('438', 'Delivery/Freight', '23', '1', 'No');
INSERT INTO `ams_category` VALUES ('439', 'Office Furniture', '23', '1', 'No');
INSERT INTO `ams_category` VALUES ('440', 'Dental Lab', '24', '1', 'No');
INSERT INTO `ams_category` VALUES ('441', 'Dental Practice', '24', '1', 'No');
INSERT INTO `ams_category` VALUES ('442', 'Dental Supplies', '24', '1', 'No');
INSERT INTO `ams_category` VALUES ('443', 'Teeth Whitening', '24', '1', 'No');
INSERT INTO `ams_category` VALUES ('444', 'Dist-A/C & Heat Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('445', 'Dist-Agricultural Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('446', 'Dist-Aircraft Parts', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('447', 'Dist-Aluminum Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('448', 'Dist-Animals Live', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('449', 'Dist-Auto Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('450', 'Dist-Beer Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('451', 'Dist-Bev Alcoholic', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('452', 'Dist-Bev Non Alcohol', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('453', 'Dist-Bicycle Supply', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('454', 'Dist-Building Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('455', 'Dist-Ceramic Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('456', 'Dist-Chemical Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('457', 'Dist-Clothing', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('458', 'Dist-Clothing Accessories', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('459', 'Dist-Coffee', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('460', 'Dist-Communication Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('461', 'Dist-Computer Hardware', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('462', 'Dist-Computer Software', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('463', 'Dist-Construction Material', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('464', 'Dist-Consumer Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('465', 'Dist-Education Items', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('466', 'Dist-Electronics', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('467', 'Dist-Entertainment Media', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('468', 'Dist-Film Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('469', 'Dist-Fireworks', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('470', 'Dist-Fitness Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('471', 'Dist-Flags', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('472', 'Dist-Floral Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('473', 'Dist-Food Products Dry', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('474', 'Dist-Food Service Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('475', 'Dist-Footwear', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('476', 'Dist-Fragrances', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('477', 'Dist-Framing Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('478', 'Dist-Frozen Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('479', 'Dist-Funeral Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('480', 'Dist-Gifts & Crafts', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('481', 'Dist-Golf Accessory', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('482', 'Dist-Graphics', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('483', 'Dist-Hardware', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('484', 'Dist-Health/Beauty', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('485', 'Dist-Heating Fuels', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('486', 'Dist-Home Accessory', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('487', 'Dist-Home Furniture', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('488', 'Dist-Hospital Supply', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('489', 'Dist-Industrial Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('490', 'Dist-Industrial Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('491', 'Dist-Janitorial Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('492', 'Dist-Jewelry Costume', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('493', 'Dist-Jewelry Fine', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('494', 'Dist-Lawn Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('495', 'Dist-Lighting Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('496', 'Dist-Lubricants', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('497', 'Dist-Lumber', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('498', 'Dist-M R O Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('499', 'Dist-Magazines', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('500', 'Dist-Mailing Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('501', 'Dist-Marine Accessory', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('502', 'Dist-Marine Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('503', 'Dist-Material Handling', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('504', 'Dist-Medical Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('505', 'Dist-Medical Supply', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('506', 'Dist-Motorcycles', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('507', 'Dist-Office Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('508', 'Dist-Office Furniture', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('509', 'Dist-Office Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('510', 'Dist-Optical Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('511', 'Dist-Outdoor Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('512', 'Dist-Packaging Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('513', 'Dist-Paint', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('514', 'Dist-Paper Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('515', 'Dist-Pet Foods', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('516', 'Dist-Petroleum Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('517', 'Dist-Plants', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('518', 'Dist-Plastic Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('519', 'Dist-Plumbing Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('520', 'Dist-Pool/Spa Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('521', 'Dist-Pool/Spa Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('522', 'Dist-Prepared Meals', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('523', 'Dist-Printing Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('524', 'Dist-Propane', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('525', 'Dist-Religious Goods', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('526', 'Dist-Restaurant Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('527', 'Dist-Restaurant Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('528', 'Dist-Routes Newspaper', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('529', 'Dist-Safety Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('530', 'Dist-Security Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('531', 'Dist-Skin Care Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('532', 'Dist-Snack Items', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('533', 'Dist-Specialty Equipment', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('534', 'Dist-Sporting Goods', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('535', 'Dist-Steel', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('536', 'Dist-Sundry Items', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('537', 'Dist-Tobacco Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('538', 'Dist-Tools', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('539', 'Dist-Toys', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('540', 'Dist-Upholstery', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('541', 'Dist-Window Covering', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('542', 'Dist-Wood Products', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('543', 'Bartending School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('544', 'Casino Gaming', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('545', 'Children Art Center', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('546', 'College', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('547', 'Computer School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('548', 'Cooking School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('549', 'Cosmetologist School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('550', 'Dance Academy', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('551', 'Driving School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('552', 'Education Tutoring', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('553', 'Education/Publishing', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('554', 'Educational Material', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('555', 'Horse Riding Academy', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('556', 'Massage School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('557', 'Music School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('558', 'Performing Arts', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('559', 'Pre-School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('560', 'Private School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('561', 'School Nails/Massage', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('562', 'Testing & Evaluation', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('563', 'Trade/Vocational School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('564', 'Traffic School', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('565', 'Computer Graphics', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('566', 'Computer Parts/System', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('567', 'Computer Programming', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('568', 'Computer Repair', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('569', 'Computer Software', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('570', 'Computer Supplies', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('571', 'Computers Sales/Service', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('572', 'Consulting', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('573', 'Data Processing', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('574', 'Electric Shaver Repair', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('575', 'Electronic Equipment Sale', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('576', 'Electronic Service', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('577', 'Electronic TV Repair', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('578', 'Electronic VCR Repair', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('579', 'Sound/Video Systems', '27', '1', 'No');
INSERT INTO `ams_category` VALUES ('580', 'Architecture Service', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('581', 'Drafting & Blue Prints', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('582', 'Engineering Chemical', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('583', 'Engineering Civil', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('584', 'Engineering Construction', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('585', 'Engineering Drilling', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('586', 'Engineering Electric', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('587', 'Engineering Environmental', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('588', 'Engineering Mechanic', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('589', 'Engineering Soil', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('590', 'Engineering-Logistic', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('591', 'Engineering/Consulting', '28', '1', 'No');
INSERT INTO `ams_category` VALUES ('592', 'Air Filters Sales/Service', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('593', 'Air Fresheners System', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('594', 'Consulting', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('595', 'Environmental Cleanup', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('596', 'Environmental Lab', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('597', 'Erosion Control', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('598', 'Indoor Air Quality', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('599', 'Landfill', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('600', 'Mining Non Metalic', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('601', 'Mining Pumice', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('602', 'Mining Sand', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('603', 'Odor Eliminator', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('604', 'Oil Refinery', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('605', 'Petroleum Products', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('606', 'Portable Septic Unit', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('607', 'Portable Toilets', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('608', 'Recycling Business', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('609', 'Refrigerant Reclaim', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('610', 'Research Company', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('611', 'Scrap Metal', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('612', 'Septic Tank Cleaning', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('613', 'Septic Tank Service', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('614', 'Slate Mine', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('615', 'Solar Products', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('616', 'Trash Hauling', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('617', 'Waste Management', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('618', 'Waste Water', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('619', 'Alt-Gen-DC Motors S/S', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('620', 'Electric Motors S/S', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('621', 'Equipment Rental', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('622', 'Fire Extinguisher Service', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('623', 'Fire Suppression Equipment', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('624', 'Heavy Equipment Parts/Repair', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('625', 'Hydraulic Equipment Repair', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('626', 'Pump Repair', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('627', 'Restaurant Equipment Repair', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('628', 'Restaurant Equipment S/S', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('629', 'Shopping Cart Repair', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('630', 'Tools Repairs', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('631', 'Tools Sharpening', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('632', 'Vacuum/Sewing Machine', '30', '1', 'No');
INSERT INTO `ams_category` VALUES ('633', 'ATM Machines', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('634', 'Banking/Finance', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('635', 'Barter Club', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('636', 'Check Cashing', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('637', 'Coll Child Support', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('638', 'Collection Agency', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('639', 'Currency Exchange', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('640', 'Debt Counseling Service', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('641', 'Equipment Leasing', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('642', 'Factoring Company', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('643', 'Finance Company', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('644', 'Independent Stock Broker', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('645', 'Pawn Shop', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('646', 'Payment Processing', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('647', 'Title Company', '31', '1', 'No');
INSERT INTO `ams_category` VALUES ('648', 'Firearms Range', '32', '1', 'No');
INSERT INTO `ams_category` VALUES ('649', 'Gun Shop', '32', '1', 'No');
INSERT INTO `ams_category` VALUES ('650', 'Fitness Aerobic', '33', '1', 'No');
INSERT INTO `ams_category` VALUES ('651', 'Fitness Center', '33', '1', 'No');
INSERT INTO `ams_category` VALUES ('652', 'Fitness Equipment', '33', '1', 'No');
INSERT INTO `ams_category` VALUES ('653', 'Fitness Gym', '33', '1', 'No');
INSERT INTO `ams_category` VALUES ('654', 'Fitness Health Club', '33', '1', 'No');
INSERT INTO `ams_category` VALUES ('655', 'Fitness Pro Shop', '33', '1', 'No');
INSERT INTO `ams_category` VALUES ('656', 'Massage Center', '33', '1', 'No');
INSERT INTO `ams_category` VALUES ('657', 'Pilates & Therapy', '33', '1', 'No');
INSERT INTO `ams_category` VALUES ('658', 'Yoga Studio', '33', '1', 'No');
INSERT INTO `ams_category` VALUES ('659', 'Floor Restoration', '34', '1', 'No');
INSERT INTO `ams_category` VALUES ('660', 'Flooring Products', '34', '1', 'No');
INSERT INTO `ams_category` VALUES ('661', 'Flooring/Carpeting', '34', '1', 'No');
INSERT INTO `ams_category` VALUES ('662', 'Flooring/Tile', '34', '1', 'No');
INSERT INTO `ams_category` VALUES ('663', 'Hardwood Floors', '34', '1', 'No');
INSERT INTO `ams_category` VALUES ('664', 'Artificial Flowers', '35', '1', 'No');
INSERT INTO `ams_category` VALUES ('665', 'Florist', '35', '1', 'No');
INSERT INTO `ams_category` VALUES ('666', 'Flower Preservation', '35', '1', 'No');
INSERT INTO `ams_category` VALUES ('667', 'Fresh Flowers', '35', '1', 'No');
INSERT INTO `ams_category` VALUES ('668', 'Silk Flowers', '35', '1', 'No');
INSERT INTO `ams_category` VALUES ('669', 'Deli/Catering', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('670', 'Food Deli Take Out', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('671', 'Food Retail Bakery', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('672', 'Food Retail Donuts', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('673', 'Food Retail Fish', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('674', 'Food Retail Grocery', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('675', 'Food Retail Health', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('676', 'Food Retail Meats', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('677', 'Food Retail Produce', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('678', 'Food Retail Snacks', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('679', 'Italian Deli/Grocery', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('680', 'Retail Coffee & Tea', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('681', 'Specialty Bakery', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('682', 'Furn Refinishing', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('683', 'Furn Repair Service', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('684', 'Furn Retail Dinettes', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('685', 'Furn Retail Home/Bed', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('686', 'Furn Retail Lawn/Patio', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('687', 'Furn Retail Office', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('688', 'Furniture Childrens', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('689', 'Furniture Imports', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('690', 'Furniture Liquidation', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('691', 'Furniture Oriental', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('692', 'Furniture Rental', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('693', 'Furniture Store', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('694', 'Furniture Used', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('695', 'Unfinished Furniture', '37', '1', 'No');
INSERT INTO `ams_category` VALUES ('696', 'Gas Sta/Truck Stop', '38', '1', 'No');
INSERT INTO `ams_category` VALUES ('697', 'Gas Station/C-Store', '38', '1', 'No');
INSERT INTO `ams_category` VALUES ('698', 'Gas Station/Repairs', '38', '1', 'No');
INSERT INTO `ams_category` VALUES ('699', 'Glass Creations', '39', '1', 'No');
INSERT INTO `ams_category` VALUES ('700', 'Glass Etching', '39', '1', 'No');
INSERT INTO `ams_category` VALUES ('701', 'Glass Tinting', '39', '1', 'No');
INSERT INTO `ams_category` VALUES ('702', 'Glass Win/Drs/Mirrs', '39', '1', 'No');
INSERT INTO `ams_category` VALUES ('703', 'Hardware Retail', '40', '1', 'No');
INSERT INTO `ams_category` VALUES ('704', 'Hardware/Lumber', '40', '1', 'No');
INSERT INTO `ams_category` VALUES ('705', 'Lighting Store Retail', '40', '1', 'No');
INSERT INTO `ams_category` VALUES ('706', 'Paint Store Retail', '40', '1', 'No');
INSERT INTO `ams_category` VALUES ('707', 'Coin Distributor', '41', '1', 'No');
INSERT INTO `ams_category` VALUES ('708', 'Coins Store', '41', '1', 'No');
INSERT INTO `ams_category` VALUES ('709', 'Collectibles', '41', '1', 'No');
INSERT INTO `ams_category` VALUES ('710', 'Doll Manufacturer', '41', '1', 'No');
INSERT INTO `ams_category` VALUES ('711', 'Hobby/Toys', '41', '1', 'No');
INSERT INTO `ams_category` VALUES ('712', 'Stamp & Coin Store', '41', '1', 'No');
INSERT INTO `ams_category` VALUES ('713', 'Stamp Collector Business', '41', '1', 'No');
INSERT INTO `ams_category` VALUES ('714', 'Flavored Ice', '42', '1', 'No');
INSERT INTO `ams_category` VALUES ('715', 'Ice Cream & Yogurt', '42', '1', 'No');
INSERT INTO `ams_category` VALUES ('716', 'Ice Cream Store', '42', '1', 'No');
INSERT INTO `ams_category` VALUES ('717', 'Smoothie Business', '42', '1', 'No');
INSERT INTO `ams_category` VALUES ('718', 'Yogurt Store', '42', '1', 'No');
INSERT INTO `ams_category` VALUES ('719', 'Custom House/Distrib', '43', '1', 'No');
INSERT INTO `ams_category` VALUES ('720', 'Export Graphic Arts', '43', '1', 'No');
INSERT INTO `ams_category` VALUES ('721', 'Import Collectables', '43', '1', 'No');
INSERT INTO `ams_category` VALUES ('722', 'Import Glassware', '43', '1', 'No');
INSERT INTO `ams_category` VALUES ('723', 'Import Housewares', '43', '1', 'No');
INSERT INTO `ams_category` VALUES ('724', 'Import Jewelry', '43', '1', 'No');
INSERT INTO `ams_category` VALUES ('725', 'Import Medical Supp', '43', '1', 'No');
INSERT INTO `ams_category` VALUES ('726', 'Import Metal Product', '43', '1', 'No');
INSERT INTO `ams_category` VALUES ('727', 'Import-baskets', '43', '1', 'No');
INSERT INTO `ams_category` VALUES ('728', 'Industrial Machinery', '43', '1', 'No');
INSERT INTO `ams_category` VALUES ('729', 'Insurance Adjusters', '44', '1', 'No');
INSERT INTO `ams_category` VALUES ('730', 'Insurance Administrators', '44', '1', 'No');
INSERT INTO `ams_category` VALUES ('731', 'Insurance Appraisal', '44', '1', 'No');
INSERT INTO `ams_category` VALUES ('732', 'Insurance Auto', '44', '1', 'No');
INSERT INTO `ams_category` VALUES ('733', 'Insurance General', '44', '1', 'No');
INSERT INTO `ams_category` VALUES ('734', 'Insurance Medical Assessment', '44', '1', 'No');
INSERT INTO `ams_category` VALUES ('735', 'Home Interior Design', '45', '1', 'No');
INSERT INTO `ams_category` VALUES ('736', 'Office Inter Design', '45', '1', 'No');
INSERT INTO `ams_category` VALUES ('737', 'Wallcoverings', '45', '1', 'No');
INSERT INTO `ams_category` VALUES ('738', 'Window Coverings', '45', '1', 'No');
INSERT INTO `ams_category` VALUES ('739', 'Window Tinting', '45', '1', 'No');
INSERT INTO `ams_category` VALUES ('740', 'E-Bay Drop Store', '46', '1', 'No');
INSERT INTO `ams_category` VALUES ('741', 'Internet Business', '46', '1', 'No');
INSERT INTO `ams_category` VALUES ('742', 'Internet/Online Service', '46', '1', 'No');
INSERT INTO `ams_category` VALUES ('743', 'Online Retail Store', '46', '1', 'No');
INSERT INTO `ams_category` VALUES ('744', 'Web Based Publishing', '46', '1', 'No');
INSERT INTO `ams_category` VALUES ('745', 'Web Development', '46', '1', 'No');
INSERT INTO `ams_category` VALUES ('746', 'Clock & Watch Repair', '47', '1', 'No');
INSERT INTO `ams_category` VALUES ('747', 'Jewelry Manufact', '47', '1', 'No');
INSERT INTO `ams_category` VALUES ('748', 'Jewelry Retail', '47', '1', 'No');
INSERT INTO `ams_category` VALUES ('749', 'Jewelry Wholesale', '47', '1', 'No');
INSERT INTO `ams_category` VALUES ('750', 'Comm Mowing/Grading', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('751', 'Fertilization', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('752', 'Irrigation/Sprinkler', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('753', 'Landscape Borders', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('754', 'Landscape Lighting', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('755', 'Lawn & Garden Supply', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('756', 'Lawn Biz Commercial', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('757', 'Lawn Biz Landscaping', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('758', 'Lawn Biz Residential', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('759', 'Lawn Equipment Sales', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('760', 'Lawn Mower Repairs', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('761', 'Lawn Spraying', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('762', 'Specialized Grass Services', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('763', 'Tree Service', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('764', 'Adult Entertainment', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('765', 'Adult Nite Club', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('766', 'Bar/Restaurant', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('767', 'Beer/Wine Bar', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('768', 'Bottle Club', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('769', 'Liquor Bar/Lounge', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('770', 'Liquor Dance Club', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('771', 'Liquor License Only', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('772', 'Liquor Nite Club', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('773', 'Liquor Package Store', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('774', 'Lounge & Package Store', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('775', 'Sports Bar', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('776', 'Tavern', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('777', 'Wine Sampling', '49', '1', 'No');
INSERT INTO `ams_category` VALUES ('778', 'Locksmith', '50', '1', 'No');
INSERT INTO `ams_category` VALUES ('779', 'Machine Shop/Metal', '51', '1', 'No');
INSERT INTO `ams_category` VALUES ('780', 'Mail Order Business', '52', '1', 'No');
INSERT INTO `ams_category` VALUES ('781', 'Mfg-A/C & Heat Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('782', 'Mfg-Adv Specialities', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('783', 'Mfg-Agrarian Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('784', 'Mfg-Agri Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('785', 'Mfg-Aircraft Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('786', 'Mfg-Alum Foundry', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('787', 'Mfg-Aluminum Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('788', 'Mfg-Aquarium Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('789', 'Mfg-Art Supplies', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('790', 'Mfg-Assembler-Fabrication', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('791', 'Mfg-Auto Accessories', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('792', 'Mfg-Automotive Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('793', 'Mfg-Awards/Plaques', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('794', 'Mfg-Ball Bearings', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('795', 'Mfg-Beverages', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('796', 'Mfg-Boats', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('797', 'Mfg-Canvas Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('798', 'Mfg-Caskets', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('799', 'Mfg-Cement Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('800', 'Mfg-Ceramic Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('801', 'Mfg-Chemicals', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('802', 'Mfg-Chocolate', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('803', 'Mfg-Clothing', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('804', 'Mfg-Consumable Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('805', 'Mfg-Cosmetics', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('806', 'Mfg-Decorative Fountains', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('807', 'Mfg-Doors/Partitions', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('808', 'Mfg-Electrical Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('809', 'Mfg-Electrical Supplies', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('810', 'Mfg-Electronic Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('811', 'Mfg-Electroplated Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('812', 'Mfg-Elevator Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('813', 'Mfg-Equipment', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('814', 'Mfg-Fabrication', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('815', 'Mfg-Fencing', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('816', 'Mfg-Fiberglass Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('817', 'Mfg-Fishing Tackle', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('818', 'Mfg-Flags', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('819', 'Mfg-Flowers Artificial', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('820', 'Mfg-Food Bottled', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('821', 'Mfg-Foods Canned', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('822', 'Mfg-Foods Dry', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('823', 'Mfg-Foods Frozen', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('824', 'Mfg-Foods Snack', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('825', 'Mfg-Foot Apparel', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('826', 'Mfg-Furniture Home', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('827', 'Mfg-Furniture Leather', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('828', 'Mfg-Furniture Office', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('829', 'Mfg-Furniture Restaurants', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('830', 'Mfg-Giftware Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('831', 'Mfg-Home Accessories', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('832', 'Mfg-Home Improv Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('833', 'Mfg-Ice Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('834', 'Mfg-Industrial Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('835', 'Mfg-Insulation', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('836', 'Mfg-Iron Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('837', 'Mfg-Jewelry', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('838', 'Mfg-Leather Goods', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('839', 'Mfg-Lighting Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('840', 'Mfg-Machine Shop', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('841', 'Mfg-Machinery', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('842', 'Mfg-Manufacturer Rep', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('843', 'Mfg-Marble Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('844', 'Mfg-Marine Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('845', 'Mfg-Medical Equipment', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('846', 'Mfg-Medical Equipment', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('847', 'Mfg-Medical Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('848', 'Mfg-Metal Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('849', 'Mfg-Millwork', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('850', 'Mfg-Mint', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('851', 'Mfg-Munitions', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('852', 'Mfg-Office Equipment', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('853', 'Mfg-Office Supplies', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('854', 'Mfg-Paint', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('855', 'Mfg-Paper Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('856', 'Mfg-Pet Food Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('857', 'Mfg-Pet Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('858', 'Mfg-Plastic Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('859', 'Mfg-Pre Built Homes', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('860', 'Mfg-Promo Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('861', 'Mfg-Quartz or Glass', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('862', 'Mfg-Recreational Equipment', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('863', 'Mfg-Restaurant Accessories', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('864', 'Mfg-Restaurant Equipment', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('865', 'Mfg-Sandwiches', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('866', 'Mfg-Shoes', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('867', 'Mfg-Signs', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('868', 'Mfg-Silk Screen Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('869', 'Mfg-Sporting Goods', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('870', 'Mfg-Table Tops', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('871', 'Mfg-Tool & Die Shop', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('872', 'Mfg-Tools', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('873', 'Mfg-Traffic Devices', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('874', 'Mfg-Trailers', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('875', 'Mfg-Truck Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('876', 'Mfg-Wallpaper', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('877', 'Mfg-Window Coverings', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('878', 'Mfg-Wood Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('879', 'Bait & Tackle Store', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('880', 'Boat Accessories', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('881', 'Boat Broker', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('882', 'Boat Club', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('883', 'Boat Dealer', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('884', 'Boat Detailing', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('885', 'Boat Rentals', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('886', 'Boat Repairs', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('887', 'Boat Transportation', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('888', 'Charter Fishing', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('889', 'Dive Boat', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('890', 'Dive Shop', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('891', 'Electric Motors', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('892', 'Entertainment - Poker', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('893', 'Jet Ski/WR Rental', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('894', 'Marinas', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('895', 'Marine A/C Sales/Services', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('896', 'Marine Canvas Products', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('897', 'Marine Contractor', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('898', 'Marine Electronics', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('899', 'Marine Gift & Accessories', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('900', 'Marine Oil Changing', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('901', 'Marine Props S & S', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('902', 'Marine Rescue/Towing', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('903', 'Marine Services', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('904', 'Personal Water Craft', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('905', 'Sailing School', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('906', 'Taxidermy', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('907', 'Yacht Chartering', '54', '1', 'No');
INSERT INTO `ams_category` VALUES ('908', 'A.F.C.H.', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('909', 'A.L.F.', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('910', 'Adult Day Care', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('911', 'Elder Care', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('912', 'Half Way/Recovery House', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('913', 'Health Information Management', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('914', 'HMO', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('915', 'Laser Clinic', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('916', 'Medical - Hypnosis', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('917', 'Medical Asst Living', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('918', 'Medical Billing Service', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('919', 'Medical Case Management', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('920', 'Medical Chiropractic', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('921', 'Medical Clinic', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('922', 'Medical Discount Organization', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('923', 'Medical Equip Lease', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('924', 'Medical Equipment', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('925', 'Medical Furniture', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('926', 'Medical Hearing Aids', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('927', 'Medical Home Care', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('928', 'Medical Laboratory', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('929', 'Medical Licensing', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('930', 'Medical MD Practice', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('931', 'Medical Nursing Home', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('932', 'Medical Pharmacy', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('933', 'Medical Software', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('934', 'Medical Spa', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('935', 'Medical Speech Therapy', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('936', 'Medical Staffing', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('937', 'Medical Supplies', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('938', 'Medical Testing', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('939', 'Medical Transcribing', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('940', 'Medical Uniform Sales', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('941', 'Medical Weight Loss', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('942', 'Medical-MRI', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('943', 'Mental Health Service', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('944', 'Non-Med Home Care', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('945', 'Physical Therapy', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('946', 'Podiatry Care', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('947', 'Psychotherapy', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('948', 'Retirement Home', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('949', 'Specialty Hospital', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('950', 'Substance Abuse', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('951', 'Unborn Imaging', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('952', 'Wholesale Pharmacy', '55', '1', 'No');
INSERT INTO `ams_category` VALUES ('953', 'Metal Coatings', '56', '1', 'No');
INSERT INTO `ams_category` VALUES ('954', 'Metal Painting', '56', '1', 'No');
INSERT INTO `ams_category` VALUES ('955', 'Metal Plating', '56', '1', 'No');
INSERT INTO `ams_category` VALUES ('956', 'Metal Restoration', '56', '1', 'No');
INSERT INTO `ams_category` VALUES ('957', 'To Be Classified', '57', '1', 'No');
INSERT INTO `ams_category` VALUES ('958', 'Mobile Homes Repairs', '58', '1', 'No');
INSERT INTO `ams_category` VALUES ('959', 'Mobile Homes Sales', '58', '1', 'No');
INSERT INTO `ams_category` VALUES ('960', 'Motorcycle  Dealership', '59', '1', 'No');
INSERT INTO `ams_category` VALUES ('961', 'Motorcycle Accessories', '59', '1', 'No');
INSERT INTO `ams_category` VALUES ('962', 'Motorcycle Parts', '59', '1', 'No');
INSERT INTO `ams_category` VALUES ('963', 'Motorcycle Repairs', '59', '1', 'No');
INSERT INTO `ams_category` VALUES ('964', 'Motorcycle Sls & Ser', '59', '1', 'No');
INSERT INTO `ams_category` VALUES ('965', 'Crating Services', '60', '1', 'No');
INSERT INTO `ams_category` VALUES ('966', 'Moving Company', '60', '1', 'No');
INSERT INTO `ams_category` VALUES ('967', 'Moving Storage Company', '60', '1', 'No');
INSERT INTO `ams_category` VALUES ('968', 'Music Retail Store', '61', '1', 'No');
INSERT INTO `ams_category` VALUES ('969', 'Musical Contests', '61', '1', 'No');
INSERT INTO `ams_category` VALUES ('970', 'Musical Instruments', '61', '1', 'No');
INSERT INTO `ams_category` VALUES ('971', 'Recording Studio', '61', '1', 'No');
INSERT INTO `ams_category` VALUES ('972', 'Wholesale Music', '61', '1', 'No');
INSERT INTO `ams_category` VALUES ('973', 'NF Automotive Industry', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('974', 'NF Check Cashing', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('975', 'NF Childs Fitness Gym', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('976', 'NF Cleaning', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('977', 'NF Coffee Shop', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('978', 'NF Computer S & S', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('979', 'NF Const Materials', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('980', 'NF Consultant', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('981', 'NF Convenience Kiosk', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('982', 'NF Dating Service', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('983', 'NF Digital Media', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('984', 'NF Direct Mail Services', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('985', 'NF Distribution Chocolate', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('986', 'NF Donut', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('987', 'NF Dry Cleaning', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('988', 'NF Education', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('989', 'NF Employment/Personnel', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('990', 'NF Event Hosting', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('991', 'NF Executive Coaching', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('992', 'NF Executive Offices', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('993', 'NF Fast Foods', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('994', 'NF Financial Service', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('995', 'NF Fitness Centers', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('996', 'NF Fund Raising', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('997', 'NF Gifts/Collectable', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('998', 'NF Gourmet Mkt/Deli', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('999', 'NF Hair Care', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1000', 'NF Home Furnishings', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1001', 'NF Home Improvement', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1002', 'NF Ink Cartridge Refill', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1003', 'NF Janitorial Service', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1004', 'NF Maid Service', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1005', 'NF Massage Therapy', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1006', 'NF Medical Care Industry', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1007', 'NF Motel/Hotel', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1008', 'NF Moving Company', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1009', 'NF Nail Salon', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1010', 'NF Nursery Service', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1011', 'NF On-Line Retail Store', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1012', 'NF Pack & Ship', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1013', 'NF Paralegal', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1014', 'NF Party Supplies', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1015', 'NF Pet Care', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1016', 'NF Photography', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1017', 'NF Portable Storage', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1018', 'NF Pressure Cleaning', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1019', 'NF Printing', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1020', 'NF Property Maintenance', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1021', 'NF Real Estate Office', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1022', 'NF Restaurants', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1023', 'NF Restoration Services', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1024', 'NF Retail Establishment', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1025', 'NF Screen Printing', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1026', 'NF Signs', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1027', 'NF Tanning', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1028', 'NF Tax Preparation', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1029', 'NF Telephones', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1030', 'NF Uniforms', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1031', 'NF Vending Business', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1032', 'NF Wedding Consultant', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1033', 'NF Yogurt/Ice Cream', '62', '1', 'No');
INSERT INTO `ams_category` VALUES ('1034', 'Newsstand', '63', '1', 'No');
INSERT INTO `ams_category` VALUES ('1035', 'Office Furniture', '64', '1', 'No');
INSERT INTO `ams_category` VALUES ('1036', 'Office Machines ', '64', '1', 'No');
INSERT INTO `ams_category` VALUES ('1037', 'Office Supplies', '64', '1', 'No');
INSERT INTO `ams_category` VALUES ('1038', 'Eye Wear Sales', '65', '1', 'No');
INSERT INTO `ams_category` VALUES ('1039', 'Ophthalmologist', '65', '1', 'No');
INSERT INTO `ams_category` VALUES ('1040', 'Optical Lab', '65', '1', 'No');
INSERT INTO `ams_category` VALUES ('1041', 'Optical Repairs', '65', '1', 'No');
INSERT INTO `ams_category` VALUES ('1042', 'Optician Practice', '65', '1', 'No');
INSERT INTO `ams_category` VALUES ('1043', 'Optometrist', '65', '1', 'No');
INSERT INTO `ams_category` VALUES ('1044', 'Pack/Ship Service', '66', '1', 'No');
INSERT INTO `ams_category` VALUES ('1045', 'Postal/Mailbox/Misc', '66', '1', 'No');
INSERT INTO `ams_category` VALUES ('1046', 'Credit Repair Service', '67', '1', 'No');
INSERT INTO `ams_category` VALUES ('1047', 'Dating Service', '67', '1', 'No');
INSERT INTO `ams_category` VALUES ('1048', 'Detective Agency', '67', '1', 'No');
INSERT INTO `ams_category` VALUES ('1049', 'Fitness Testing', '67', '1', 'No');
INSERT INTO `ams_category` VALUES ('1050', 'Funeral Home', '67', '1', 'No');
INSERT INTO `ams_category` VALUES ('1051', 'Monuments', '67', '1', 'No');
INSERT INTO `ams_category` VALUES ('1052', 'Remailing Service', '67', '1', 'No');
INSERT INTO `ams_category` VALUES ('1053', 'Social Club', '67', '1', 'No');
INSERT INTO `ams_category` VALUES ('1054', 'Talent Agency', '67', '1', 'No');
INSERT INTO `ams_category` VALUES ('1055', 'Wedding Chapel', '67', '1', 'No');
INSERT INTO `ams_category` VALUES ('1056', 'Children ID System', '68', '1', 'No');
INSERT INTO `ams_category` VALUES ('1057', 'Employee Leasing', '68', '1', 'No');
INSERT INTO `ams_category` VALUES ('1058', 'Employment Agency', '68', '1', 'No');
INSERT INTO `ams_category` VALUES ('1059', 'Executive Searching', '68', '1', 'No');
INSERT INTO `ams_category` VALUES ('1060', 'Greeting Service', '68', '1', 'No');
INSERT INTO `ams_category` VALUES ('1061', 'Model Training', '68', '1', 'No');
INSERT INTO `ams_category` VALUES ('1062', 'Party Planning', '68', '1', 'No');
INSERT INTO `ams_category` VALUES ('1063', 'Performance Training', '68', '1', 'No');
INSERT INTO `ams_category` VALUES ('1064', 'Personal Assistant', '68', '1', 'No');
INSERT INTO `ams_category` VALUES ('1065', 'Temporary Help', '68', '1', 'No');
INSERT INTO `ams_category` VALUES ('1066', 'Pest Control Service', '69', '1', 'No');
INSERT INTO `ams_category` VALUES ('1067', 'Pest Control Supplies', '69', '1', 'No');
INSERT INTO `ams_category` VALUES ('1068', 'Aerial Photo System', '70', '1', 'No');
INSERT INTO `ams_category` VALUES ('1069', 'Aerial Photography', '70', '1', 'No');
INSERT INTO `ams_category` VALUES ('1070', 'Camera Repairs', '70', '1', 'No');
INSERT INTO `ams_category` VALUES ('1071', 'Camera Store', '70', '1', 'No');
INSERT INTO `ams_category` VALUES ('1072', 'Digital Photo System', '70', '1', 'No');
INSERT INTO `ams_category` VALUES ('1073', 'Microfilm Service', '70', '1', 'No');
INSERT INTO `ams_category` VALUES ('1074', 'One Hour Photo Shop', '70', '1', 'No');
INSERT INTO `ams_category` VALUES ('1075', 'Photo Lab', '70', '1', 'No');
INSERT INTO `ams_category` VALUES ('1076', 'Photo Studio', '70', '1', 'No');
INSERT INTO `ams_category` VALUES ('1077', 'Stock Footage Library', '70', '1', 'No');
INSERT INTO `ams_category` VALUES ('1078', 'Pool Heating', '71', '1', 'No');
INSERT INTO `ams_category` VALUES ('1079', 'Pool Repairs', '71', '1', 'No');
INSERT INTO `ams_category` VALUES ('1080', 'Pool Sales/Service', '71', '1', 'No');
INSERT INTO `ams_category` VALUES ('1081', 'Pool Service', '71', '1', 'No');
INSERT INTO `ams_category` VALUES ('1082', 'Pool Supplies', '71', '1', 'No');
INSERT INTO `ams_category` VALUES ('1083', 'Pool/Spa Sales', '71', '1', 'No');
INSERT INTO `ams_category` VALUES ('1084', 'Pool/Spa Supply Store', '71', '1', 'No');
INSERT INTO `ams_category` VALUES ('1085', 'Bindery', '72', '1', 'No');
INSERT INTO `ams_category` VALUES ('1086', 'Color Copying', '72', '1', 'No');
INSERT INTO `ams_category` VALUES ('1087', 'Copying Blue Prints', '72', '1', 'No');
INSERT INTO `ams_category` VALUES ('1088', 'Graphics/Layout', '72', '1', 'No');
INSERT INTO `ams_category` VALUES ('1089', 'Laminating Services', '72', '1', 'No');
INSERT INTO `ams_category` VALUES ('1090', 'Print Equip Repair', '72', '1', 'No');
INSERT INTO `ams_category` VALUES ('1091', 'Printing Broker', '72', '1', 'No');
INSERT INTO `ams_category` VALUES ('1092', 'Printing Business', '72', '1', 'No');
INSERT INTO `ams_category` VALUES ('1093', 'Typesetting Business', '72', '1', 'No');
INSERT INTO `ams_category` VALUES ('1094', 'Legal Practice', '73', '1', 'No');
INSERT INTO `ams_category` VALUES ('1095', 'Directory Publishing', '74', '1', 'No');
INSERT INTO `ams_category` VALUES ('1096', 'Publishing', '74', '1', 'No');
INSERT INTO `ams_category` VALUES ('1097', 'Publishing Maps', '74', '1', 'No');
INSERT INTO `ams_category` VALUES ('1098', 'Broker Business', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1099', 'Broker Mortgage', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1100', 'Broker Real Estate', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1101', 'Home Inspection Service', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1102', 'Inspection Service', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1103', 'Mfg Home Dealer', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1104', 'Property Management', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1105', 'R/E Appraisal', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1106', 'Radon Services', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1107', 'Renting/Leasing', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1108', 'Surveyors', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1109', 'Time Sharing Rental/Sales', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1110', 'Apartment Building', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1111', 'Auction Services', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1112', 'Bed & Breakfast', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1113', 'Comm Improved Property', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1114', 'Commercial Building', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1115', 'Commercial Lease', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1116', 'Development', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1117', 'Flea Market', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1118', 'Hotel', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1119', 'Income Property', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1120', 'Industrial Building', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1121', 'Industrial Park', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1122', 'Mobile Home Park', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1123', 'Motel', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1124', 'Office Building', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1125', 'R.V. Park', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1126', 'Rental of Booths', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1127', 'Resort', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1128', 'Restaurant Lease', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1129', 'Retail/Warehouse', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1130', 'Self Storage', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1131', 'Shopping Center', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1132', 'Storage Facility', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1133', 'Timeshare', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1134', 'Truck Stop/Property', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1135', 'Vacant Comml Land', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1136', 'Vacant Farm Land', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1137', 'Vacant Residential Land', '76', '1', 'No');
INSERT INTO `ams_category` VALUES ('1138', 'Amusement', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1139', 'ATV Sales & Service', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1140', 'Billiard Parlor', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1141', 'Bingo', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1142', 'Boat Rental', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1143', 'Bounce Houses', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1144', 'Bowling Alley', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1145', 'Casino', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1146', 'Casino Ship', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1147', 'Coin Operated', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1148', 'Dinner Theater', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1149', 'Entertainment', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1150', 'Game Room', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1151', 'Go Carts Sales/Service', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1152', 'Golf Course', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1153', 'Golf Driving Range', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1154', 'Indoor Soccer', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1155', 'Indy Racing Team', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1156', 'Lodge/Camping/Etc', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1157', 'Miniature Golf Course', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1158', 'Movie Theater', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1159', 'Movies & Restaurant', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1160', 'Off Road R V Park', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1161', 'Parasailing', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1162', 'Poker', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1163', 'Race Track', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1164', 'Riding Club', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1165', 'Skating Programs', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1166', 'Skating Rink', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1167', 'Ski Resort', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1168', 'Snowmobile Dealership', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1169', 'Tourist Attraction', '77', '1', 'No');
INSERT INTO `ams_category` VALUES ('1170', 'Rental Audio/Visual', '78', '1', 'No');
INSERT INTO `ams_category` VALUES ('1171', 'Rental Automobiles', '78', '1', 'No');
INSERT INTO `ams_category` VALUES ('1172', 'Rental Equipment', '78', '1', 'No');
INSERT INTO `ams_category` VALUES ('1173', 'Rental Linens/Access', '78', '1', 'No');
INSERT INTO `ams_category` VALUES ('1174', 'Rental Office Equipment', '78', '1', 'No');
INSERT INTO `ams_category` VALUES ('1175', 'Rental Party Goods', '78', '1', 'No');
INSERT INTO `ams_category` VALUES ('1176', 'Rental Scaffolding', '78', '1', 'No');
INSERT INTO `ams_category` VALUES ('1177', 'Rental Tents', '78', '1', 'No');
INSERT INTO `ams_category` VALUES ('1178', 'American Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1179', 'Bagel Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1180', 'Banquet Hall/Caterer', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1181', 'Barbecue Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1182', 'Boarding & Catering', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1183', 'Breakfast Lunch', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1184', 'Brew/Pub', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1185', 'Buffett', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1186', 'Cafe Type Eatery', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1187', 'Cafeteria', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1188', 'Catering', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1189', 'Coffee Shop/House', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1190', 'Concession Stand', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1191', 'Deli Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1192', 'Dessert Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1193', 'Diner', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1194', 'Donut Shop', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1195', 'Ethnic Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1196', 'Family Style', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1197', 'Fast Food Franchise', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1198', 'Fast Food Mall', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1199', 'Fast Food-No Franchise', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1200', 'Floating Fast Food', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1201', 'Food Est+Drive Thru', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1202', 'Gourmet Dining', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1203', 'Italian Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1204', 'Latin Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1205', 'Mexican Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1206', 'Office Bldg Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1207', 'Pizza Shop', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1208', 'Restaurant Kosher', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1209', 'Restaurant Tea Room', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1210', 'Restaurant/Mail', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1211', 'Sandwich Shop', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1212', 'Seafood Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1213', 'Specialty Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1214', 'Steak Restaurant', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1215', 'Sub Shop', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1216', 'Take Out Only', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1217', 'Army/Navy Surplus', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1218', 'Consignment Shop', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1219', 'Department Store', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1220', 'Educational Supplies', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1221', 'Fireplaces', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1222', 'Kiosk', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1223', 'Kitchen Cabinets', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1224', 'Police Supplies', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1225', 'Retail Batteries', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1226', 'Retail Candy Store', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1227', 'Retail Chimney Products', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1228', 'Retail Cosmetic', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1229', 'Retail Dollar Store', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1230', 'Retail Fine Wines', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1231', 'Retail Flags', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1232', 'Retail Games/Accessories', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1233', 'Retail Health Products', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1234', 'Retail Home Accessories', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1235', 'Retail Housewares', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1236', 'Retail Jewelry', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1237', 'Retail Luggage', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1238', 'Retail Nut Store', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1239', 'Retail Portable Building', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1240', 'Retail Safe/Security', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1241', 'Retail Space Lease', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1242', 'Retail Specialties', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1243', 'Retail Stationary Store', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1244', 'Retail Store Sewing', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1245', 'Retail Thrift Store', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1246', 'Retail Upholstery', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1247', 'Retail Variety Store', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1248', 'Retail Western Goods', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1249', 'Retail Wine/Cheese', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1250', 'Retail-Comic Books', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1251', 'Retail-Fashion Accessories', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1252', 'Retail-Table Games', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1253', 'Retail-Toys', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1254', 'Sunglasses & Beachwear', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1255', 'Surf/Activewear Shop', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1256', 'Used Clothing', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1257', 'Wedding/Party Supply', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1258', 'Window Coverings', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1259', 'Routes Air Freshener', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1260', 'Routes Auto Supplies', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1261', 'Routes Bread', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1262', 'Routes Cards', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1263', 'Routes Coffee Serv', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1264', 'Routes Dry Cleaning', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1265', 'Routes Fed Ex', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1266', 'Routes Firewood', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1267', 'Routes Hosiery', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1268', 'Routes Ice Cream', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1269', 'Routes Lunch Truck', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1270', 'Routes Meats & Food', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1271', 'Routes Milk', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1272', 'Routes Newspaper', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1273', 'Routes Pastry', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1274', 'Routes Plants', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1275', 'Routes Potato Chips', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1276', 'Routes Produce', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1277', 'Routes Snacks', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1278', 'Routes Soda/Juice', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1279', 'Routes Sundries', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1280', 'Routes Supplies', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1281', 'Routes Tools', '81', '1', 'No');
INSERT INTO `ams_category` VALUES ('1282', 'Market Research Company', '82', '1', 'No');
INSERT INTO `ams_category` VALUES ('1283', 'Market Company', '82', '1', 'No');
INSERT INTO `ams_category` VALUES ('1284', 'Guard Company', '83', '1', 'No');
INSERT INTO `ams_category` VALUES ('1285', 'Guard Dogs', '83', '1', 'No');
INSERT INTO `ams_category` VALUES ('1286', 'Security Systems', '83', '1', 'No');
INSERT INTO `ams_category` VALUES ('1287', 'Athletic Footwear', '84', '1', 'No');
INSERT INTO `ams_category` VALUES ('1288', 'Shoes Repairs', '84', '1', 'No');
INSERT INTO `ams_category` VALUES ('1289', 'Shoes Retail', '84', '1', 'No');
INSERT INTO `ams_category` VALUES ('1290', 'Sign Companies', '85', '1', 'No');
INSERT INTO `ams_category` VALUES ('1291', 'Baseball Academy', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1292', 'Bicycles Sales/Service', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1293', 'Fitness Equipment Sales', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1294', 'Golf Cart Sales/Services', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1295', 'Golf Store', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1296', 'Parasailing', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1297', 'Playground Equipment', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1298', 'Shooting Range', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1299', 'Sporting Goods Store', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1300', 'Sports Cards Dealer', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1301', 'Sports Center', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1302', 'Sports Equipment Repair', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1303', 'Sports Equipment Sales', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1304', 'Sports Fantasy', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1305', 'Sports Franchises', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1306', 'Sports Instruction', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1307', 'Sports Memorabilia', '86', '1', 'No');
INSERT INTO `ams_category` VALUES ('1308', 'Accounting & Tax', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1309', 'Air Craft Mfg', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1310', 'Architech\'l Concrete', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1311', 'Automotive Related', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1312', 'Awards Incentives', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1313', 'Building Products', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1314', 'Chemical Products', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1315', 'Chocolate Products', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1316', 'Concrete Products', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1317', 'Copyrights/Trademark', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1318', 'Dating Service', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1319', 'Dry Cleaner', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1320', 'Dry Cleaning Route', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1321', 'Fast Food', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1322', 'Financial Services', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1323', 'Fitness Center', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1324', 'Floor Safety', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1325', 'Home Improvements', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1326', 'Importing Granite', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1327', 'Internet Business', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1328', 'Jewelry', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1329', 'Light Manufacturing', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1330', 'Medical Related', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1331', 'Nutrition Products', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1332', 'Patented Ideas', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1333', 'Pest Control', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1334', 'Pharmacy', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1335', 'Pool Related', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1336', 'Publishing', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1337', 'Refinishing', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1338', 'Retail Establishment', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1339', 'Retractable Awnings', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1340', 'Route', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1341', 'Route Ink Products', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1342', 'Shoes Retail', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1343', 'Sports Related', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1344', 'Start Up Day Care', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1345', 'Telephone Service', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1346', 'Vending', '87', '1', 'No');
INSERT INTO `ams_category` VALUES ('1347', 'Alterations', '88', '1', 'No');
INSERT INTO `ams_category` VALUES ('1348', 'Seamstress/Sewing', '88', '1', 'No');
INSERT INTO `ams_category` VALUES ('1349', 'Tailor Shop', '88', '1', 'No');
INSERT INTO `ams_category` VALUES ('1350', 'Information Technology', '89', '1', 'No');
INSERT INTO `ams_category` VALUES ('1351', 'Answering Service', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1352', 'Beeper/Paging Service', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1353', 'Cable/Wire Installation', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1354', 'Cellular/Beeper Sales', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1355', 'Long Distance Resell', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1356', 'On Hold Service', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1357', 'Pay Telephones', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1358', 'Telemarketing', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1359', 'Telephone Equipment Repair', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1360', 'Telephone Equipment Sales', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1361', 'Telephone Rental', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1362', 'Telephone-Communication Agent', '90', '1', 'No');
INSERT INTO `ams_category` VALUES ('1363', 'Toys', '91', '1', 'No');
INSERT INTO `ams_category` VALUES ('1364', 'Auto Delivery', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1365', 'Bicycle Cabs', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1366', 'Charter Buses', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1367', 'Child Transportation', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1368', 'Construction Hauling', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1369', 'Delivery of Trucks', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1370', 'Equip Delivery', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1371', 'Freight Company', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1372', 'Freight Forwarding', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1373', 'Fuel Delivery', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1374', 'Funeral Industry Transportation', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1375', 'Group Transportation', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1376', 'Guided Tours', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1377', 'Limo Business', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1378', 'Medical Transport', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1379', 'Parking Service', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1380', 'School Buses', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1381', 'Taxi Business', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1382', 'Transport Livestock', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1383', 'Transport Mobil Home', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1384', 'Truck (Hauling) Broker', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1385', 'Reservation Center', '93', '1', 'No');
INSERT INTO `ams_category` VALUES ('1386', 'Tour Operator', '93', '1', 'No');
INSERT INTO `ams_category` VALUES ('1387', 'Travel Agency', '93', '1', 'No');
INSERT INTO `ams_category` VALUES ('1388', 'Leather/Vinyl Repair', '94', '1', 'No');
INSERT INTO `ams_category` VALUES ('1389', 'Upholstery', '94', '1', 'No');
INSERT INTO `ams_category` VALUES ('1390', 'Locations Locator', '95', '1', 'No');
INSERT INTO `ams_category` VALUES ('1391', 'Vend Personal Items', '95', '1', 'No');
INSERT INTO `ams_category` VALUES ('1392', 'Vending Candy', '95', '1', 'No');
INSERT INTO `ams_category` VALUES ('1393', 'Vending Games', '95', '1', 'No');
INSERT INTO `ams_category` VALUES ('1394', 'Vending Hard Goods', '95', '1', 'No');
INSERT INTO `ams_category` VALUES ('1395', 'Vending Ice', '95', '1', 'No');
INSERT INTO `ams_category` VALUES ('1396', 'Vending Machine Repair', '95', '1', 'No');
INSERT INTO `ams_category` VALUES ('1397', 'Vending Snack Foods', '95', '1', 'No');
INSERT INTO `ams_category` VALUES ('1398', 'Vending Soft Drinks', '95', '1', 'No');
INSERT INTO `ams_category` VALUES ('1399', 'Vending Water', '95', '1', 'No');
INSERT INTO `ams_category` VALUES ('1400', 'Adult Video Store', '96', '1', 'No');
INSERT INTO `ams_category` VALUES ('1401', 'Vending Cds Videos', '96', '1', 'No');
INSERT INTO `ams_category` VALUES ('1402', 'Video Games', '96', '1', 'No');
INSERT INTO `ams_category` VALUES ('1403', 'Video Production', '96', '1', 'No');
INSERT INTO `ams_category` VALUES ('1404', 'Video Stores', '96', '1', 'No');
INSERT INTO `ams_category` VALUES ('1405', 'Bottled Water', '97', '1', 'No');
INSERT INTO `ams_category` VALUES ('1406', 'Pump Service', '97', '1', 'No');
INSERT INTO `ams_category` VALUES ('1407', 'Water Conservation', '97', '1', 'No');
INSERT INTO `ams_category` VALUES ('1408', 'Water Ice', '97', '1', 'No');
INSERT INTO `ams_category` VALUES ('1409', 'Water Purification', '97', '1', 'No');
INSERT INTO `ams_category` VALUES ('1410', 'Wholesale Appliances', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1411', 'Wholesale Bait', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1412', 'Wholesale Bakery', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1413', 'Wholesale Batteries', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1414', 'Wholesale Cell Phone', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1415', 'Wholesale Dry Goods', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1416', 'Wholesale Electrical Supplies', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1417', 'Wholesale Fabric', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1418', 'Wholesale Farmers Market', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1419', 'Wholesale Fashion Accessories', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1420', 'Wholesale Floor Coverings', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1421', 'Wholesale Flowers', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1422', 'Wholesale Food Broker', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1423', 'Wholesale Footwear', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1424', 'Wholesale Frozen Food', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1425', 'Wholesale Grain and Field Beans', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1426', 'Wholesale Grocery', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1427', 'Wholesale Hand Bags', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1428', 'Wholesale Hardware', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1429', 'Wholesale HVAC', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1430', 'Wholesale Lumber Products', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1431', 'Wholesale Meats', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1432', 'Wholesale Nutrition Supplement', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1433', 'Wholesale Pets', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1434', 'Wholesale Plumbing', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1435', 'Wholesale Produce', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1436', 'Wholesale Seafood', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1437', 'Wholesale Snack Items', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1438', 'Wholesale Windows & Doors', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1439', 'Wholesale-Lawn Products', '98', '1', 'No');
INSERT INTO `ams_category` VALUES ('1440', 'Amusement/Recreation', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1441', 'Hair & Beauty', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1442', 'Telecommunications', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1443', 'Healthcare/Medical', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1444', 'Lodging', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1445', 'Staffing /Employment', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1446', 'Services', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1447', 'Alcohol Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1448', 'Marketing', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1449', 'Mining', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1450', 'Repair', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1451', 'Legal', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1452', 'Industrial', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1453', 'Consignment/Resale', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1454', 'Camping Related', '0', '1', 'No');
INSERT INTO `ams_category` VALUES ('1456', 'Moving & Storage', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1457', 'Packagin & Shipping', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1458', 'Other Business Services', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1459', 'Security Services/Systems', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1460', 'Architectural Services', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1461', 'Environment Control', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1462', 'Packaging (industrial)', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1463', 'Other Personal Services', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1464', 'Management Consulting', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1465', 'Pool Service (swimming)', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1466', 'Pest Control', '1446', '1', 'No');
INSERT INTO `ams_category` VALUES ('1467', 'Garden Centers/Nurseries', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1468', 'Gourmet Shops', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1469', 'Gift Shops', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1470', 'Miscellaneous Retail', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1471', 'Convenience Stores', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1472', 'Apparel/Accessory Shops', '80', '1', 'No');
INSERT INTO `ams_category` VALUES ('1473', 'Miscellaneous Repair', '1450', '1', 'No');
INSERT INTO `ams_category` VALUES ('1474', 'Office Machines S/S', '64', '1', 'No');
INSERT INTO `ams_category` VALUES ('1475', 'Powder Metallurgy Processing', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('1476', 'Plastic and Rubber Machinery', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('1477', 'Miscellaneous', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('1478', 'Plastic Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('1479', 'General', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('1480', 'Job Shop/Contract Manufacturing', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('1481', 'Food/Kindred Products', '53', '1', 'No');
INSERT INTO `ams_category` VALUES ('1482', 'Hotels', '1444', '1', 'No');
INSERT INTO `ams_category` VALUES ('1483', 'Lawn Maintenance & Service', '48', '1', 'No');
INSERT INTO `ams_category` VALUES ('1484', 'Office Inter. Design', '45', '1', 'No');
INSERT INTO `ams_category` VALUES ('1485', 'Home Health-Care/Nursing', '1443', '1', 'No');
INSERT INTO `ams_category` VALUES ('1486', 'Assisted Living Facilities', '1443', '1', 'No');
INSERT INTO `ams_category` VALUES ('1487', 'Home Nursing Agencies', '1443', '1', 'No');
INSERT INTO `ams_category` VALUES ('1488', 'Optometry Practices', '1443', '1', 'No');
INSERT INTO `ams_category` VALUES ('1489', 'Nursing Homes', '1443', '1', 'No');
INSERT INTO `ams_category` VALUES ('1490', 'Ambulance Services', '1443', '1', 'No');
INSERT INTO `ams_category` VALUES ('1491', 'Physical Therapy', '1443', '1', 'No');
INSERT INTO `ams_category` VALUES ('1492', 'Optical Shops', '1443', '1', 'No');
INSERT INTO `ams_category` VALUES ('1493', 'Health & Safety Industries', '1443', '1', 'No');
INSERT INTO `ams_category` VALUES ('1494', 'Service Stations', '38', '1', 'No');
INSERT INTO `ams_category` VALUES ('1495', 'Vending Machines', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('1496', 'Grocery Stores', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('1497', 'Produce Markets', '36', '1', 'No');
INSERT INTO `ams_category` VALUES ('1498', 'General Computer Services', '46', '1', 'No');
INSERT INTO `ams_category` VALUES ('1499', 'E-commerce/Internet Shopping', '46', '1', 'No');
INSERT INTO `ams_category` VALUES ('1500', 'Software Companies', '46', '1', 'No');
INSERT INTO `ams_category` VALUES ('1501', 'Arts & Crafts Stores', '7', '1', 'No');
INSERT INTO `ams_category` VALUES ('1502', 'Floral Designers', '7', '1', 'No');
INSERT INTO `ams_category` VALUES ('1503', 'Family Entertainment Centers', '1440', '1', 'No');
INSERT INTO `ams_category` VALUES ('1504', 'Amusement/Theme Parks', '1440', '1', 'No');
INSERT INTO `ams_category` VALUES ('1505', 'Video Stores', '1440', '1', 'No');
INSERT INTO `ams_category` VALUES ('1506', 'Amusement Arcades', '1440', '1', 'No');
INSERT INTO `ams_category` VALUES ('1507', 'Bars', '1447', '1', 'No');
INSERT INTO `ams_category` VALUES ('1508', 'Brew Pubs', '1447', '1', 'No');
INSERT INTO `ams_category` VALUES ('1509', 'Cocktail Lounges', '1447', '1', 'No');
INSERT INTO `ams_category` VALUES ('1510', 'Night Clubs', '1447', '1', 'No');
INSERT INTO `ams_category` VALUES ('1511', 'Taverns', '1447', '1', 'No');
INSERT INTO `ams_category` VALUES ('1512', 'Trucking Companies', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1513', 'Freight Transport. Arrangement', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1514', 'Ground Transport. Companies', '92', '1', 'No');
INSERT INTO `ams_category` VALUES ('1515', 'Marketing Company', '82', '1', 'No');
INSERT INTO `ams_category` VALUES ('1516', 'Full-Service Restaurants', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1517', 'Limited-Service Restaurants', '79', '1', 'No');
INSERT INTO `ams_category` VALUES ('1518', 'property management companies (non-residential)', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1519', 'property management companies (residential)', '75', '1', 'No');
INSERT INTO `ams_category` VALUES ('1520', 'Environment Testing', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('1521', 'Other Green Businesses', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('1522', 'Wind Farms', '29', '1', 'No');
INSERT INTO `ams_category` VALUES ('1523', 'Math & Reading Centers', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('1524', 'Montessory Schools', '26', '1', 'No');
INSERT INTO `ams_category` VALUES ('1525', 'Industrial Supplies', '25', '1', 'No');
INSERT INTO `ams_category` VALUES ('1526', 'Contractors-Plumbing & Heating', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('1527', 'Construction-HVAC', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('1528', 'Construction-Electrical', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('1529', 'Bldg Materials/Home Centers', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('1530', 'Construction-Specialty Trades', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('1531', 'Handyman Professionals', '19', '1', 'No');
INSERT INTO `ams_category` VALUES ('1532', 'Maid Services', '16', '1', 'No');
INSERT INTO `ams_category` VALUES ('1533', 'Broker Business', '13', '1', 'No');
INSERT INTO `ams_category` VALUES ('1534', 'Aviation and Aerospace', '9', '1', 'No');
INSERT INTO `ams_category` VALUES ('1535', 'Auto Painting', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('1536', 'Auto Tire Stores', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('1537', 'Auto Body Repair', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('1538', 'Auto Parts/Accessories', '8', '1', 'No');
INSERT INTO `ams_category` VALUES ('1539', 'Veterinary Practices', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('1540', 'Pet Shops', '4', '1', 'No');
INSERT INTO `ams_category` VALUES ('1541', 'Feed/Farm Supplies', '3', '1', 'No');

-- ----------------------------
-- Table structure for `ams_city`
-- ----------------------------
DROP TABLE IF EXISTS `ams_city`;
CREATE TABLE `ams_city` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `i_country_id` int(11) DEFAULT NULL,
  `i_state_id` int(11) DEFAULT NULL,
  `i_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0->Inactive, 1->Active',
  `i_is_deleted` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0->No, 1->yes',
  PRIMARY KEY (`i_id`),
  UNIQUE KEY `CountryStateCity` (`i_country_id`,`i_state_id`,`name`) USING BTREE,
  KEY `city` (`name`) USING BTREE,
  KEY `status_deleted` (`i_status`,`i_is_deleted`) USING BTREE,
  KEY `stateId` (`i_state_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ams_city
-- ----------------------------

-- ----------------------------
-- Table structure for `ams_cms`
-- ----------------------------
DROP TABLE IF EXISTS `ams_cms`;
CREATE TABLE `ams_cms` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'cms ID PK',
  `i_cms_type` tinyint(2) DEFAULT '1' COMMENT '1->General CMS Pages, 2->FAQ,News etc',
  `i_parent_id` int(11) NOT NULL,
  `s_key` varchar(25) DEFAULT NULL,
  `s_title` varchar(255) DEFAULT NULL,
  `s_summary` text,
  `s_description` text,
  `s_url` varchar(500) DEFAULT NULL,
  `s_redirect_url` text,
  `dt_created_on` datetime DEFAULT NULL,
  `dt_published_on` datetime DEFAULT NULL,
  `s_meta_title` varchar(255) DEFAULT NULL,
  `s_meta_keyword` varchar(255) DEFAULT NULL,
  `s_meta_description` varchar(255) DEFAULT NULL,
  `s_additional_page` varchar(255) DEFAULT NULL,
  `e_status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `s_parent_url` varchar(255) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_cms
-- ----------------------------

-- ----------------------------
-- Table structure for `ams_cms_master`
-- ----------------------------
DROP TABLE IF EXISTS `ams_cms_master`;
CREATE TABLE `ams_cms_master` (
  `i_id` int(10) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_cms_master
-- ----------------------------

-- ----------------------------
-- Table structure for `ams_country`
-- ----------------------------
DROP TABLE IF EXISTS `ams_country`;
CREATE TABLE `ams_country` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `FIPS104` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ISO2` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ISO3` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ISON` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Internet` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Capital` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `MapReference` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `NationalitySingular` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `NationalityPlural` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Currency` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `CurrencyCode` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Population` int(11) DEFAULT NULL,
  `Title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Comment` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `i_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0->Inactive, 1->Active',
  `i_is_deleted` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0->No, 1->Yes',
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM AUTO_INCREMENT=276 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_country
-- ----------------------------
INSERT INTO `ams_country` VALUES ('43', 'Canada', 'CA', 'CA', 'CAN', '124', 'CA', 'Ottawa', 'North America', 'Canadian', 'Canadians', 'Canadian Dollar', 'CAD', '31592805', 'Canada', null, '1', '0');
INSERT INTO `ams_country` VALUES ('113', 'India', 'IN', 'IN', 'IND', '356', 'IN', 'New Delhi', 'Asia', 'Indian', 'Indians', 'Indian Rupee', 'INR', '1029991145', 'India', null, '1', '1');
INSERT INTO `ams_country` VALUES ('254', 'United States', 'US', 'US', 'USA', '840', 'US', 'Washington, DC', 'North America', 'American', 'Americans', 'US Dollar', 'USD', '278058881', 'The United States', null, '1', '0');

-- ----------------------------
-- Table structure for `ams_email_template`
-- ----------------------------
DROP TABLE IF EXISTS `ams_email_template`;
CREATE TABLE `ams_email_template` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_subject` varchar(255) DEFAULT NULL,
  `s_content` text,
  `s_key` varchar(255) DEFAULT NULL,
  `i_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0->inactive, 1->Active',
  `e_deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_email_template
-- ----------------------------
INSERT INTO `ams_email_template` VALUES ('3', 'Forgot Password', '<p>Dear User,</p>\r\n\r\n<p>Your password has been reset. Please login with this new temporary password and change it immediatly.</p>\r\n\r\n<p>Login Details:&nbsp;<br />\r\nEmail: ##EMAIL##<br />\r\nPassword: ##PASSWORD##</p>\r\n\r\n<p>Best Regards,&nbsp;<br />\r\nAdvanced Micro System Team</p>', 'forgot', '1', 'No');

-- ----------------------------
-- Table structure for `ams_email_template_bk_blank`
-- ----------------------------
DROP TABLE IF EXISTS `ams_email_template_bk_blank`;
CREATE TABLE `ams_email_template_bk_blank` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_subject` varchar(255) DEFAULT NULL,
  `s_content` text,
  `s_key` varchar(255) DEFAULT NULL,
  `i_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0->inactive, 1->Active',
  `e_deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_email_template_bk_blank
-- ----------------------------

-- ----------------------------
-- Table structure for `ams_faq`
-- ----------------------------
DROP TABLE IF EXISTS `ams_faq`;
CREATE TABLE `ams_faq` (
  `i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `i_user_id` int(10) DEFAULT NULL,
  `s_question` varchar(255) DEFAULT NULL,
  `s_answer` text,
  `dt_added` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  `e_deleted` enum('Yes','No') DEFAULT 'No',
  `i_sort_order` int(11) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_faq
-- ----------------------------

-- ----------------------------
-- Table structure for `ams_forms_details`
-- ----------------------------
DROP TABLE IF EXISTS `ams_forms_details`;
CREATE TABLE `ams_forms_details` (
  `i_id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `i_form_id` int(10) NOT NULL,
  `e_record_type` enum('T','A','B') DEFAULT NULL,
  `i_field_pos_start` int(5) DEFAULT NULL,
  `i_field_pos_end` int(5) DEFAULT NULL,
  `s_purpose_fileds` text,
  `s_xml_tag` varchar(255) DEFAULT NULL,
  `s_validation_rules` text,
  `dt_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `i_status` tinyint(2) DEFAULT '1' COMMENT '1->Active, 0->Inactive',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_forms_details
-- ----------------------------
INSERT INTO `ams_forms_details` VALUES ('1', '1', 'T', '7', '15', 'Required. Enter the transmitter’s nine-digit taxpayer identification number (TIN).', 'TIN', '', '2016-06-07 14:26:13', '1');
INSERT INTO `ams_forms_details` VALUES ('2', '1', 'A', '12', '20', 'Required. Enter the valid nine-digit taxpayer identification\nnumber assigned to the payer. Do not enter blanks, hyphens,\nor alpha characters. Filling the field with all zeros, ones, twos,\netc., will result in an incorrect TIN.', 'TIN', 'Note: For foreign entities that are not required to have a TIN,\nthis field must be blank; however, the Foreign Entity Indicator,\nposition 52 of the “A” Record, must be set to one (1).', '2016-06-07 14:36:15', '1');
INSERT INTO `ams_forms_details` VALUES ('3', '1', 'B', '21', '40', 'Payer’s Account Number For Payee', 'AcctNumber', 'Required if submitting more than one information return of the\nsame type for the same payee. Enter any number assigned\nby the payer to the payee that can be used by the IRS to\ndistinguish between information returns. This number must\nbe unique for each information return of the same type for\nthe same payee. If a payee has more than one reporting of\nthe same document type, it is vital that each reporting have\na unique account number. For example, if a payer has three\nseparate pension distributions for the same payee and three\nseparate Forms 1099-R are filed, three separate unique\naccount numbers are required.', '2016-06-07 14:56:42', '1');

-- ----------------------------
-- Table structure for `ams_forms_master`
-- ----------------------------
DROP TABLE IF EXISTS `ams_forms_master`;
CREATE TABLE `ams_forms_master` (
  `i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_form_title` varchar(255) DEFAULT NULL,
  `s_org_title` varchar(255) DEFAULT NULL,
  `s_form_description` varchar(500) DEFAULT NULL,
  `s_type_of_return` varchar(10) DEFAULT NULL,
  `s_amount_codes` varchar(255) DEFAULT NULL,
  `d_form_price` decimal(20,2) DEFAULT '0.00',
  `i_status` tinyint(2) DEFAULT '1' COMMENT '0->Inactive, 1->Active, 2->deleted',
  `dt_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_forms_master
-- ----------------------------
INSERT INTO `ams_forms_master` VALUES ('1', '1099A', '1099-A', 'Acquisition or Abandonment of Secured Property', '4', '123456789ABCDEFG', '100.00', '1', '2017-01-12 13:07:57');
INSERT INTO `ams_forms_master` VALUES ('2', '1099B', '1099-B', 'Proceeds From Broker and Barter Exchange Transactions', 'B', '12345ABC', '100.00', '1', '2017-01-12 13:08:07');
INSERT INTO `ams_forms_master` VALUES ('3', '1099C', '1099-C', 'Cancellation of Debt', '5', null, '0.00', '1', '2016-11-03 12:08:22');
INSERT INTO `ams_forms_master` VALUES ('4', '1099CAP', '1099-CAP', 'Bond Tax Credit', 'P', null, '0.00', '1', '2016-11-03 12:08:27');
INSERT INTO `ams_forms_master` VALUES ('5', '1099DIV', '1099-DIV', 'Mortgage Interest Statement', '1', null, '0.00', '1', '2016-11-03 12:08:31');
INSERT INTO `ams_forms_master` VALUES ('6', '1099G', '1099-G', 'Contributions of Motor Vehicles, Boats, and Airplanes', 'F', null, '0.00', '1', '2016-11-03 12:08:35');
INSERT INTO `ams_forms_master` VALUES ('7', '1099INT', '1099-INT', 'Student Loan Interest Statement', '6', null, '0.00', '1', '2016-11-03 12:08:39');
INSERT INTO `ams_forms_master` VALUES ('8', '1099K', '1099-K', 'Payment Card and Third Party Network Transactions', 'MC', null, '0.00', '1', '2016-11-03 12:08:44');
INSERT INTO `ams_forms_master` VALUES ('9', '1099LTC', '1099-LTC', 'Long-Term Care and Accelerated Death Benefits', 'T', null, '0.00', '1', '2016-11-03 12:08:48');
INSERT INTO `ams_forms_master` VALUES ('10', '1099MISC', '1099-MISC', 'Miscellaneous Income', 'A', null, '0.00', '1', '2016-11-03 12:08:51');
INSERT INTO `ams_forms_master` VALUES ('11', '1099OID', '1099-OID', 'Original Issue Discount', 'D', null, '0.00', '1', '2016-11-03 12:08:55');
INSERT INTO `ams_forms_master` VALUES ('12', '1099PATR', '1099-PATR', 'Taxable Distributions Received From Cooperatives', '7', null, '0.00', '1', '2016-11-03 12:08:59');
INSERT INTO `ams_forms_master` VALUES ('13', '1099Q', '1099-Q', 'Payments From Qualified Education Programs (Under Sections 529 and 530)', 'Q', null, '0.00', '1', '2016-11-03 12:09:04');
INSERT INTO `ams_forms_master` VALUES ('14', '1099R', '1099-R', 'Distributions From Pensions, Annuities, Retirement or Profit-Sharing Plans, IRAs, Insurance Contracts, etc.', '9', null, '0.00', '1', '2016-11-03 12:09:08');
INSERT INTO `ams_forms_master` VALUES ('15', '1099S', '1099-S', 'Proceeds From Real Estate Transactions', 'S', null, '0.00', '1', '2016-11-03 12:09:12');
INSERT INTO `ams_forms_master` VALUES ('16', '1099SA', '1099-SA', 'Distributions From an HSA,Archer MSA, or Medicare Advantage MSA', 'M', null, '0.00', '1', '2016-11-03 12:09:15');
INSERT INTO `ams_forms_master` VALUES ('17', '5498', '5498', 'IRA Contribution Information', 'L', null, '0.00', '1', '2016-11-03 12:18:58');
INSERT INTO `ams_forms_master` VALUES ('18', '5498ESA', '5498-ESA', 'Coverdell ESA Contribution Information', 'V', null, '0.00', '1', '2016-11-03 12:19:00');
INSERT INTO `ams_forms_master` VALUES ('19', '5498SA', '5498-SA', 'HSA, Archer MSA or Medicare Advantage MSA Information', 'K', null, '0.00', '1', '2016-11-03 12:19:02');
INSERT INTO `ams_forms_master` VALUES ('20', '1098', '1098', 'Mortgage Interest Statement', '3', null, '0.00', '1', '2016-11-17 18:50:51');
INSERT INTO `ams_forms_master` VALUES ('21', '1098C', '1098-C', 'Contributions of Motor Vehicles, Boats, and Airplanes', 'X', null, '0.00', '1', '2016-11-17 18:50:54');
INSERT INTO `ams_forms_master` VALUES ('22', '1098E', '1098-E', 'Student Loan Interest Statement', '2', null, '0.00', '1', '2016-11-17 18:50:57');
INSERT INTO `ams_forms_master` VALUES ('23', '1098T', '1098-T', 'Tuition Statement', '8', null, '0.00', '1', '2016-11-17 18:51:02');
INSERT INTO `ams_forms_master` VALUES ('24', '1098Q', '1098-Q', 'Qualifying Longevity Annuity Contract Information', 'QL', null, '0.00', '1', '2016-11-17 18:51:04');
INSERT INTO `ams_forms_master` VALUES ('25', 'W2G', 'W-2G', 'Certain Gambling Winnings', 'W', null, '100.00', '1', '2017-01-12 13:07:14');
INSERT INTO `ams_forms_master` VALUES ('26', 'W2C', 'W-2C', 'Corrected Wage and Tax Statements', 'W2C', null, '0.00', '1', '2016-11-29 15:27:06');
INSERT INTO `ams_forms_master` VALUES ('27', 'W2', 'W-2', 'Wage and Tax Statement', 'W2', null, '0.00', '1', '2016-11-29 15:27:08');
INSERT INTO `ams_forms_master` VALUES ('28', '940', '940', null, '940', null, '0.00', '1', '2016-12-15 12:21:32');
INSERT INTO `ams_forms_master` VALUES ('29', '941', '941', null, '941', null, '0.00', '1', '2016-12-15 12:21:44');
INSERT INTO `ams_forms_master` VALUES ('30', '944', '944', null, '944', null, '0.00', '1', '2016-12-15 12:21:54');

-- ----------------------------
-- Table structure for `ams_forms_payer_payee_history`
-- ----------------------------
DROP TABLE IF EXISTS `ams_forms_payer_payee_history`;
CREATE TABLE `ams_forms_payer_payee_history` (
  `i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_batch_code` varchar(255) DEFAULT NULL,
  `s_form_id` varchar(255) DEFAULT NULL,
  `i_payer_id` int(10) DEFAULT NULL,
  `i_payee_id` int(10) DEFAULT NULL,
  `i_status` tinyint(4) DEFAULT '0' COMMENT '0->Not Send, 1->Send',
  `dt_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_forms_payer_payee_history
-- ----------------------------
INSERT INTO `ams_forms_payer_payee_history` VALUES ('1', '100001', '1', '1', '1', '0', '2017-02-21 12:51:43', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('2', '100001', '1', '1', '2', '0', '2017-02-21 12:51:44', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('3', '100001', '1', '2', '3', '0', '2017-02-21 12:51:44', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('4', '100001', '1', '2', '4', '0', '2017-02-21 12:51:44', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('5', '100002', '1', '3', '5', '0', '2017-02-21 13:05:35', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('6', '100002', '1', '3', '6', '0', '2017-02-21 13:05:35', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('7', '100002', '1', '4', '7', '0', '2017-02-21 13:05:36', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('8', '100002', '1', '4', '8', '0', '2017-02-21 13:05:36', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('9', '100003', '1', '5', '9', '0', '2017-03-06 13:00:54', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('10', '100004', '1', '7', '10', '0', '2017-03-06 13:00:54', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('11', '100004', '1', '7', '11', '0', '2017-03-06 13:00:54', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('12', '100003', '1', '5', '12', '0', '2017-03-06 13:00:54', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('13', '100004', '1', '8', '13', '0', '2017-03-06 13:00:55', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('14', '100003', '1', '6', '14', '0', '2017-03-06 13:00:55', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('15', '100004', '1', '8', '15', '0', '2017-03-06 13:00:55', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('16', '100003', '1', '6', '16', '0', '2017-03-06 13:00:55', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('17', '100005', '1', '9', '17', '0', '2017-04-13 15:09:48', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('18', '100005', '1', '9', '18', '0', '2017-04-13 15:09:49', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('19', '100005', '1', '10', '19', '0', '2017-04-13 15:09:49', null);
INSERT INTO `ams_forms_payer_payee_history` VALUES ('20', '100005', '1', '10', '20', '0', '2017-04-13 15:09:50', null);

-- ----------------------------
-- Table structure for `ams_forms_price_set_details`
-- ----------------------------
DROP TABLE IF EXISTS `ams_forms_price_set_details`;
CREATE TABLE `ams_forms_price_set_details` (
  `i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `i_master_id` varchar(255) DEFAULT NULL,
  `i_start` int(10) DEFAULT NULL,
  `i_end` int(10) DEFAULT NULL,
  `d_price` decimal(20,2) DEFAULT NULL,
  `i_status` tinyint(2) DEFAULT '1' COMMENT '0->Inactive, 1->Active, 2->deleted',
  `dt_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_forms_price_set_details
-- ----------------------------
INSERT INTO `ams_forms_price_set_details` VALUES ('39', '2', '1', '50', '0.59', '1', '2017-01-25 15:50:35');
INSERT INTO `ams_forms_price_set_details` VALUES ('40', '2', '51', '250', '0.49', '1', '2017-01-25 15:50:35');
INSERT INTO `ams_forms_price_set_details` VALUES ('41', '2', '251', '500', '0.45', '1', '2017-01-25 15:50:35');
INSERT INTO `ams_forms_price_set_details` VALUES ('42', '2', '501', '1000', '0.39', '1', '2017-01-25 15:50:35');
INSERT INTO `ams_forms_price_set_details` VALUES ('43', '2', '1001', '0', '0.37', '1', '2017-01-25 15:50:35');
INSERT INTO `ams_forms_price_set_details` VALUES ('44', '3', '1', '50', '2.50', '1', '2017-01-25 15:51:36');
INSERT INTO `ams_forms_price_set_details` VALUES ('45', '3', '51', '250', '2.25', '1', '2017-01-25 15:51:36');
INSERT INTO `ams_forms_price_set_details` VALUES ('46', '3', '251', '500', '2.00', '1', '2017-01-25 15:51:36');
INSERT INTO `ams_forms_price_set_details` VALUES ('47', '3', '501', '1000', '1.90', '1', '2017-01-25 15:51:36');
INSERT INTO `ams_forms_price_set_details` VALUES ('48', '3', '1001', '0', '1.75', '1', '2017-01-25 15:51:36');
INSERT INTO `ams_forms_price_set_details` VALUES ('89', '1', '1', '2', '0.75', '1', '2017-02-21 16:07:00');
INSERT INTO `ams_forms_price_set_details` VALUES ('90', '1', '3', '250', '0.69', '1', '2017-02-21 16:07:00');
INSERT INTO `ams_forms_price_set_details` VALUES ('91', '1', '251', '500', '0.65', '1', '2017-02-21 16:07:00');
INSERT INTO `ams_forms_price_set_details` VALUES ('92', '1', '501', '1000', '0.55', '1', '2017-02-21 16:07:01');
INSERT INTO `ams_forms_price_set_details` VALUES ('93', '1', '1001', '0', '0.45', '1', '2017-02-21 16:07:01');

-- ----------------------------
-- Table structure for `ams_forms_price_set_master`
-- ----------------------------
DROP TABLE IF EXISTS `ams_forms_price_set_master`;
CREATE TABLE `ams_forms_price_set_master` (
  `i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_category` varchar(255) DEFAULT NULL,
  `i_status` tinyint(2) DEFAULT '1',
  `dt_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_forms_price_set_master
-- ----------------------------
INSERT INTO `ams_forms_price_set_master` VALUES ('1', '1099', '1', '2017-01-19 16:50:49');
INSERT INTO `ams_forms_price_set_master` VALUES ('2', 'W2', '1', '2017-01-25 15:45:06');
INSERT INTO `ams_forms_price_set_master` VALUES ('3', '941', '1', '2017-01-25 15:45:11');

-- ----------------------------
-- Table structure for `ams_master_type_return`
-- ----------------------------
DROP TABLE IF EXISTS `ams_master_type_return`;
CREATE TABLE `ams_master_type_return` (
  `i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_type_return` varchar(50) DEFAULT NULL,
  `s_code` varchar(20) DEFAULT NULL,
  `i_status` tinyint(2) DEFAULT '1' COMMENT '0->Inactive, 1->Active, 2->deleted',
  `dt_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_master_type_return
-- ----------------------------
INSERT INTO `ams_master_type_return` VALUES ('1', '1097-BTC', 'BT', '1', '2016-06-23 13:21:48');
INSERT INTO `ams_master_type_return` VALUES ('2', '1098', '3', '1', '2016-06-23 13:22:09');
INSERT INTO `ams_master_type_return` VALUES ('3', '1098-C', 'X', '1', '2016-06-23 13:22:40');
INSERT INTO `ams_master_type_return` VALUES ('4', '1098-E', '2', '1', '2016-06-23 13:22:59');
INSERT INTO `ams_master_type_return` VALUES ('5', '1098-T', '8', '1', '2016-06-23 13:23:17');
INSERT INTO `ams_master_type_return` VALUES ('6', '1099-A', '4', '1', '2016-06-23 13:23:31');
INSERT INTO `ams_master_type_return` VALUES ('7', '1099-B', 'B', '1', '2016-06-23 13:23:46');
INSERT INTO `ams_master_type_return` VALUES ('8', '1099-C', '5', '1', '2016-06-23 13:23:53');
INSERT INTO `ams_master_type_return` VALUES ('9', '1099-CAP', 'P', '1', '2016-06-23 13:24:07');
INSERT INTO `ams_master_type_return` VALUES ('10', '1099-DIV', '1', '1', '2016-06-23 13:24:20');
INSERT INTO `ams_master_type_return` VALUES ('11', '1099-G', 'F', '1', '2016-06-23 13:24:41');
INSERT INTO `ams_master_type_return` VALUES ('12', '1099-INT', '6', '1', '2016-06-23 13:24:55');
INSERT INTO `ams_master_type_return` VALUES ('13', '1099-K', 'MC', '1', '2016-06-23 13:25:11');
INSERT INTO `ams_master_type_return` VALUES ('14', '1099-LTC', 'T', '1', '2016-06-23 13:25:30');
INSERT INTO `ams_master_type_return` VALUES ('15', '1099-MISC', 'A', '1', '2016-06-23 13:25:41');
INSERT INTO `ams_master_type_return` VALUES ('16', '1099-OID', 'D', '1', '2016-06-23 13:25:55');
INSERT INTO `ams_master_type_return` VALUES ('17', '1099-PATR', '7', '1', '2016-06-23 13:26:12');
INSERT INTO `ams_master_type_return` VALUES ('18', '1099-Q', 'Q', '1', '2016-06-23 13:26:25');
INSERT INTO `ams_master_type_return` VALUES ('19', '1099-R', '9', '1', '2016-06-23 13:26:38');
INSERT INTO `ams_master_type_return` VALUES ('20', '1099-S', 'S', '1', '2016-06-23 13:27:06');
INSERT INTO `ams_master_type_return` VALUES ('21', '1099-SA', 'M', '1', '2016-06-23 13:27:09');
INSERT INTO `ams_master_type_return` VALUES ('22', '3921', 'N', '1', '2016-06-23 13:27:25');
INSERT INTO `ams_master_type_return` VALUES ('23', '3922', 'Z', '1', '2016-06-23 13:27:39');
INSERT INTO `ams_master_type_return` VALUES ('24', '5498', 'L', '1', '2016-06-23 13:27:50');
INSERT INTO `ams_master_type_return` VALUES ('25', '5498-ESA', 'V', '1', '2016-06-23 13:28:06');
INSERT INTO `ams_master_type_return` VALUES ('26', '5498-SA', 'K', '1', '2016-06-23 13:28:19');
INSERT INTO `ams_master_type_return` VALUES ('27', 'W-2G', 'W', '1', '2016-06-23 13:28:33');

-- ----------------------------
-- Table structure for `ams_menu`
-- ----------------------------
DROP TABLE IF EXISTS `ams_menu`;
CREATE TABLE `ams_menu` (
  `i_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '(PK)',
  `s_name` varchar(255) NOT NULL,
  `s_link` text NOT NULL COMMENT 'excluding the base_url(). e.g.-dashboard/',
  `i_parent_id` smallint(4) NOT NULL,
  `i_main_id` smallint(4) NOT NULL,
  `s_action_permit` text NOT NULL,
  `s_icon_class` varchar(100) NOT NULL DEFAULT 'home',
  `en_s_name` varchar(255) NOT NULL,
  `ar_s_name` varchar(255) NOT NULL,
  `i_display_order` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_menu
-- ----------------------------
INSERT INTO `ams_menu` VALUES ('1', 'General', '', '0', '0', '', 'th', 'General', 'General', '0');
INSERT INTO `ams_menu` VALUES ('2', 'Dashboard', 'dashboard/', '1', '1', 'View List', 'home', 'Dashboard', 'Dashboard', '1');
INSERT INTO `ams_menu` VALUES ('3', 'My Account ', 'my_account/', '1', '1', 'Edit', 'home', 'My Account', 'My Account', '2');
INSERT INTO `ams_menu` VALUES ('4', 'Site Setting', 'site_setting/', '1', '1', 'Edit', 'home', 'Site Setting', 'Site Setting', '3');
INSERT INTO `ams_menu` VALUES ('5', 'Admin User', '', '0', '0', '', 'users', 'Admin User', 'Admin User', '2');
INSERT INTO `ams_menu` VALUES ('6', 'User Type Access', 'user_type_master/', '5', '5', 'View List||Add||Edit||Access Control', 'home', 'User Type Access', 'User Type Access', '1');
INSERT INTO `ams_menu` VALUES ('7', 'Manage Users', 'manage_admin_user/', '-99', '-99', 'View List||Add||Edit||Delete', 'home', 'Manage Users', 'Manage Users', '2');
INSERT INTO `ams_menu` VALUES ('8', 'Core', '', '0', '0', '', 'wrench', 'Core', 'Core', '3');
INSERT INTO `ams_menu` VALUES ('9', 'Generate CRUD', 'generate_crud/', '-99', '8', 'View List', 'home', 'Generate CRUD', 'Generate CRUD', '1');
INSERT INTO `ams_menu` VALUES ('10', 'Menu Setting', 'menu_setting/', '-99', '8', 'View List', 'home', 'Menu Setting', 'Menu Setting', '2');
INSERT INTO `ams_menu` VALUES ('14', 'Master Settings', '', '-99', '-99', '', 'gear', 'Master Setting', '', '100');
INSERT INTO `ams_menu` VALUES ('15', 'Automail', 'email_template/', '1', '1', 'View List||Add||Edit||Delete', 'home', 'Automail', 'Automail', '4');
INSERT INTO `ams_menu` VALUES ('47', 'Manage Information', '', '0', '0', '', 'at', 'Manage Information', '', '10');
INSERT INTO `ams_menu` VALUES ('56', 'Manage Content', 'cms/', '-99', '47', 'View List||Add||Edit', 'home', 'Manage Content', '', '8');
INSERT INTO `ams_menu` VALUES ('59', 'Menu Management', 'menu_list/', '-99', '-99', 'View List||Add||Edit||Delete', 'home', 'Menu Management', '', '11');
INSERT INTO `ams_menu` VALUES ('60', 'Download', '', '0', '0', '', 'gear', 'Download', '', '15');
INSERT INTO `ams_menu` VALUES ('76', 'Change Password', 'change_password/', '1', '1', 'Edit', 'home', 'Change Password', 'Change Password', '10');
INSERT INTO `ams_menu` VALUES ('77', 'Form Details', 'form_details/', '-99', '47', 'View List||View Detail||Add||Edit||Status', 'home', 'Form Details', '', '11');
INSERT INTO `ams_menu` VALUES ('78', 'Payer Record', 'payer_record/', '47', '47', 'View List||Add||Edit', 'home', 'Payer Record', '', '14');
INSERT INTO `ams_menu` VALUES ('79', 'Manage Forms', 'manage_forms/', '47', '47', 'View List||Add||Edit', 'home', 'Manage Forms', '', '12');
INSERT INTO `ams_menu` VALUES ('80', 'Manage Amount Codes', 'amount_codes/', '-99', '47', 'View List||View Detail||Add||Edit', 'home', 'Manage Amount Codes', '', '13');
INSERT INTO `ams_menu` VALUES ('81', '1099 Series', 'download_efile/', '60', '60', 'View List', 'home', '1099 Series', '', '15');
INSERT INTO `ams_menu` VALUES ('82', 'Batch Information', 'batches/', '60', '60', 'View List||Download||Status', 'home', 'Batch Information', '', '16');
INSERT INTO `ams_menu` VALUES ('83', 'ASCII File Download', 'file_downloaded/', '60', '60', 'View List||Status||View Detail', 'home', 'ASCII File Download', '', '17');
INSERT INTO `ams_menu` VALUES ('84', 'Manage Forms Price', 'forms_price/', '47', '47', 'View List||Add||Edit||Reset', 'home', 'Manage Forms Price', '', '15');
INSERT INTO `ams_menu` VALUES ('85', 'Manage Customers', 'customers/', '47', '47', 'View List||Status', 'home', 'Manage Customers', '', '16');
INSERT INTO `ams_menu` VALUES ('86', 'Manage Users', 'manage_user/', '5', '5', 'View List||Add||Edit||Delete||Status', 'home', 'Manage Users', '', '3');

-- ----------------------------
-- Table structure for `ams_menu_copy`
-- ----------------------------
DROP TABLE IF EXISTS `ams_menu_copy`;
CREATE TABLE `ams_menu_copy` (
  `i_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '(PK)',
  `s_name` varchar(255) NOT NULL,
  `s_link` text NOT NULL COMMENT 'excluding the base_url(). e.g.-dashboard/',
  `i_parent_id` smallint(4) NOT NULL,
  `i_main_id` smallint(4) NOT NULL,
  `s_action_permit` text NOT NULL,
  `s_icon_class` varchar(100) NOT NULL DEFAULT 'home',
  `en_s_name` varchar(255) NOT NULL,
  `ar_s_name` varchar(255) NOT NULL,
  `i_display_order` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_menu_copy
-- ----------------------------
INSERT INTO `ams_menu_copy` VALUES ('1', 'General', '', '0', '0', '', 'th', 'General', 'General', '0');
INSERT INTO `ams_menu_copy` VALUES ('2', 'Dashboard', 'dashboard/', '1', '1', 'View List', 'home', 'Dashboard', 'Dashboard', '1');
INSERT INTO `ams_menu_copy` VALUES ('3', 'My Account ', 'my_account/', '1', '1', 'Edit', 'home', 'My Account', 'My Account', '2');
INSERT INTO `ams_menu_copy` VALUES ('4', 'Site Setting', 'site_setting/', '1', '1', 'Edit', 'home', 'Site Setting', 'Site Setting', '3');
INSERT INTO `ams_menu_copy` VALUES ('5', 'Admin User', '', '0', '0', '', 'users', 'Admin User', 'Admin User', '2');
INSERT INTO `ams_menu_copy` VALUES ('6', 'User Type Access', 'user_type_master/', '5', '5', 'View List||Add||Edit||Access Control', 'home', 'User Type Access', 'User Type Access', '1');
INSERT INTO `ams_menu_copy` VALUES ('7', 'Manage Users', 'manage_admin_user/', '-99', '-99', 'View List||Add||Edit||Delete', 'home', 'Manage Users', 'Manage Users', '2');
INSERT INTO `ams_menu_copy` VALUES ('8', 'Core', '', '0', '0', '', 'wrench', 'Core', 'Core', '3');
INSERT INTO `ams_menu_copy` VALUES ('9', 'Generate CRUD', 'generate_crud/', '-99', '8', 'View List', 'home', 'Generate CRUD', 'Generate CRUD', '1');
INSERT INTO `ams_menu_copy` VALUES ('10', 'Menu Setting', 'menu_setting/', '-99', '8', 'View List', 'home', 'Menu Setting', 'Menu Setting', '2');
INSERT INTO `ams_menu_copy` VALUES ('14', 'Master Settings', '', '-99', '-99', '', 'gear', 'Master Setting', '', '100');
INSERT INTO `ams_menu_copy` VALUES ('15', 'Automail', 'email_template/', '1', '1', 'View List||Add||Edit||Delete', 'home', 'Automail', 'Automail', '4');
INSERT INTO `ams_menu_copy` VALUES ('47', 'Manage Information', '', '0', '0', '', 'at', 'Manage Information', '', '10');
INSERT INTO `ams_menu_copy` VALUES ('56', 'Manage Content', 'cms/', '-99', '47', 'View List||Add||Edit', 'home', 'Manage Content', '', '8');
INSERT INTO `ams_menu_copy` VALUES ('59', 'Menu Management', 'menu_list/', '-99', '-99', 'View List||Add||Edit||Delete', 'home', 'Menu Management', '', '11');
INSERT INTO `ams_menu_copy` VALUES ('60', 'Download', '', '0', '0', '', 'gear', 'Download', '', '15');
INSERT INTO `ams_menu_copy` VALUES ('76', 'Change Password', 'change_password/', '1', '1', 'Edit', 'home', 'Change Password', 'Change Password', '10');
INSERT INTO `ams_menu_copy` VALUES ('77', 'Form Details', 'form_details/', '-99', '47', 'View List||View Detail||Add||Edit||Status', 'home', 'Form Details', '', '11');
INSERT INTO `ams_menu_copy` VALUES ('78', 'Payer Record', 'payer_record/', '47', '47', 'View List||Add||Edit', 'home', 'Payer Record', '', '14');
INSERT INTO `ams_menu_copy` VALUES ('79', 'Manage Forms', 'manage_forms/', '47', '47', 'View List||Add||Edit', 'home', 'Manage Forms', '', '12');
INSERT INTO `ams_menu_copy` VALUES ('80', 'Manage Amount Codes', 'amount_codes/', '-99', '47', 'View List||View Detail||Add||Edit', 'home', 'Manage Amount Codes', '', '13');
INSERT INTO `ams_menu_copy` VALUES ('81', '1099 Series', 'download_efile/', '60', '60', 'View List', 'home', '1099 Series', '', '15');
INSERT INTO `ams_menu_copy` VALUES ('82', 'Batch Information', 'batches/', '60', '60', 'View List||Download||Status', 'home', 'Batch Information', '', '16');
INSERT INTO `ams_menu_copy` VALUES ('83', 'ASCII File Download', 'file_downloaded/', '60', '60', 'View List||Status||View Detail', 'home', 'ASCII File Download', '', '17');
INSERT INTO `ams_menu_copy` VALUES ('84', 'Manage Forms Price', 'forms_price/', '47', '47', 'View List||Add||Edit||Reset', 'home', 'Manage Forms Price', '', '15');
INSERT INTO `ams_menu_copy` VALUES ('85', 'Manage Customers', 'customers/', '47', '47', 'View List||Status', 'home', 'Manage Customers', '', '16');
INSERT INTO `ams_menu_copy` VALUES ('86', 'Manage Users', 'manage_user/', '5', '5', 'View List||Add||Edit||Delete||Status', 'home', 'Manage Users', '', '3');

-- ----------------------------
-- Table structure for `ams_menu_list`
-- ----------------------------
DROP TABLE IF EXISTS `ams_menu_list`;
CREATE TABLE `ams_menu_list` (
  `i_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `s_name` varchar(255) NOT NULL,
  `s_details` text NOT NULL,
  `i_status` tinyint(1) NOT NULL COMMENT '0->inactive;1->active',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_menu_list
-- ----------------------------
INSERT INTO `ams_menu_list` VALUES ('1', 'Header', 'Header Menu', '0');
INSERT INTO `ams_menu_list` VALUES ('2', 'Footer', 'Footer Menu ', '0');
INSERT INTO `ams_menu_list` VALUES ('3', 'Left', 'This is left menu', '1');

-- ----------------------------
-- Table structure for `ams_menu_page`
-- ----------------------------
DROP TABLE IF EXISTS `ams_menu_page`;
CREATE TABLE `ams_menu_page` (
  `i_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `i_parent_id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `page_title_default` varchar(250) DEFAULT NULL,
  `page_title` varchar(250) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `page_order` int(5) DEFAULT NULL,
  `page_link` varchar(250) DEFAULT NULL,
  `page_class` varchar(250) DEFAULT NULL,
  `page_target` varchar(20) DEFAULT NULL,
  `s_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_menu_page
-- ----------------------------
INSERT INTO `ams_menu_page` VALUES ('1', '0', '3', 'Business Brokerage', 'Business Brokerage', '2', '1', 'business-brokerage', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('2', '1', '3', 'Overview of Business Brokerage', 'Overview of Business Brokerage', '3', '1', 'overview-of-business-brokerage', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('3', '1', '3', 'Sell a Business', 'Sell a Business', '4', '2', 'sell-a-business', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('4', '1', '3', ' Buy a Business ', 'Buy a Business ', '5', '3', 'buy-a-business', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('6', '0', '3', 'Franchise Sales', 'Franchise Sales', '7', '2', 'franchise-sales', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('7', '6', '3', 'Overview of Franchise Sales', 'Overview of Franchise Sales', '8', '1', 'overview-of-franchise-sales', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('8', '6', '3', 'History of Franchising', 'History of Franchising', '9', '2', 'history-of-franchising', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('9', '6', '3', 'Franchise Facts', 'Franchise Facts', '10', '3', 'franchise-facts', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('10', '6', '3', 'Who Buys a Franchise?', 'Who Buys a Franchise?', '11', '4', 'who-buys-a-franchise', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('11', '6', '3', 'Top 3 Franchise Questions', 'Top 3 Franchise Questions', '12', '5', 'top-3-franchise-questions', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('12', '0', '3', 'Commercial Real Estate', 'Commercial Real Estate', '21', '3', 'commercial-real-estate', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('13', '12', '3', 'Overview of Commercial Real Estate', 'Overview of Commercial Real Estate', '22', '1', 'overview-of-commercial-real-estate', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('14', '12', '3', 'Property Management', 'Property Management', '23', '4', 'property-management', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('15', '12', '3', 'Tenant Space Construction', 'Tenant Space Construction', '24', '5', 'tenant-space-construction', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('16', '12', '3', 'Commercial Sales', 'Commercial Sales', '25', '2', 'commercial-sales', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('17', '12', '3', 'Buyer / Tenant Representation', 'Buyer / Tenant Representation', '26', '3', 'buyer-tenant-representation', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('18', '0', '3', 'Business Valuation Services', 'Business Valuation Services', '13', '4', 'business-valuation-services', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('19', '18', '3', 'Overview of Business Valuation Services', 'Overview of Business Valuation Services', '14', '1', 'overview-of-business-valuation-services', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('24', '18', '3', 'The Valuation Process', 'The Valuation Process', '15', '3', 'the-valuation-process', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('25', '18', '3', 'Valuation Products', 'Valuation Products', '16', '4', 'valuation-products', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('26', '18', '3', 'Reasons for Valuations', 'Reasons for Valuations', '17', '2', 'reasons-for-valuations', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('29', '1', '3', 'View Our Listings', 'View Our Listings', '34', '4', 'view-our-listings', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('28', '18', '3', 'Industry Appraisals', 'Industry Appraisals', '18', '5', 'industry-appraisals', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('30', '6', '3', 'Franchise Listings', 'Franchise Listings', '35', '6', 'franchise-sales/franchise-listings', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('31', '12', '3', 'Search Commercial Properties', 'Search Commercial Properties', '36', '6', 'commercial-real-estate/search-commercial-properties', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('32', '0', '3', 'Mergers & Acquisitions', 'Mergers & Acquisitions', '6', '5', 'mergers-and-acquisitions', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('33', '32', '3', 'Mergers and Acquisitions Division', 'Mergers and Acquisitions Division', '27', '1', 'overview-of-m-a', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('34', '32', '3', 'M&A Listings', 'M&A Listings', '37', '2', 'mergers-acquisitions/m-a-listings', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('35', '0', '3', 'Machinery & Equipment', 'Machinery & Equipment', '19', '6', 'machinery-and-equipment', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('36', '35', '3', 'Machinery & Equipment Appraisal Services', 'Machinery & Equipment Appraisal Services', '20', '1', 'machinery-and-equipment-appraisal-services', null, '_self', null);
INSERT INTO `ams_menu_page` VALUES ('37', '35', '3', 'Machinery & Equipment Listings', 'Machinery & Equipment Listings', '38', '2', 'machinery-equipment-services/machinery-equipment-listings', null, '_self', null);

-- ----------------------------
-- Table structure for `ams_menu_permit`
-- ----------------------------
DROP TABLE IF EXISTS `ams_menu_permit`;
CREATE TABLE `ams_menu_permit` (
  `i_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `i_menu_id` int(11) NOT NULL COMMENT 'this can be 0 if the action is default',
  `s_action` varchar(100) NOT NULL COMMENT 'Default =>available for all user types, ex: ajax, login page, home page etc.',
  `s_link` text NOT NULL COMMENT 'excluding the base_url(). e.g.-dashboard/',
  `i_user_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0->Super Admin,1->Sub Admin',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_menu_permit
-- ----------------------------
INSERT INTO `ams_menu_permit` VALUES ('1', '0', 'Default', 'home/', '1');
INSERT INTO `ams_menu_permit` VALUES ('2', '0', 'Default', 'home/logout', '1');
INSERT INTO `ams_menu_permit` VALUES ('3', '0', 'Default', 'home/ajax_menu_track/', '1');
INSERT INTO `ams_menu_permit` VALUES ('4', '0', 'Default', 'error_404/', '1');
INSERT INTO `ams_menu_permit` VALUES ('5', '10', 'Menu Permission', 'menu_setting/menu_permission/', '1');
INSERT INTO `ams_menu_permit` VALUES ('6', '10', 'View List', 'menu_setting/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('7', '10', 'Sub Menu List', 'menu_setting/sub_menu_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('8', '4', 'Edit', 'site_setting/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('9', '6', 'View List', 'user_type_master/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('10', '6', 'Add', 'user_type_master/add_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('11', '6', 'Edit', 'user_type_master/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('12', '6', 'Access Control', 'user_type_master/access_control/', '1');
INSERT INTO `ams_menu_permit` VALUES ('13', '7', 'View List', 'manage_admin_user/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('14', '7', 'Add', 'manage_admin_user/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('15', '7', 'Edit', 'manage_admin_user/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('16', '7', 'Delete', 'manage_admin_user/remove_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('17', '9', 'View List', 'generate_crud/index/', '1');
INSERT INTO `ams_menu_permit` VALUES ('18', '9', 'Generate', 'generate_crud/generate/', '1');
INSERT INTO `ams_menu_permit` VALUES ('19', '16', 'View List', 'country/show_list/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('20', '16', 'Add', 'country/add_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('21', '16', 'Edit', 'country/modify_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('23', '17', 'View List', 'state/show_list/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('24', '17', 'Add', 'state/add_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('25', '17', 'Edit', 'state/modify_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('27', '19', 'View List', 'category/show_list/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('28', '19', 'Add', 'category/add_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('29', '19', 'Edit', 'category/modify_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('31', '20', 'View List', 'city/show_list/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('32', '20', 'Add', 'city/add_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('33', '20', 'Edit', 'city/modify_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('35', '3', 'Edit', 'my_account/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('36', '15', 'Add', 'email_template/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('37', '15', 'Edit', 'email_template/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('38', '15', 'View List', 'email_template/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('39', '15', 'Delete', 'email_template/remove_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('40', '6', 'Delete', 'user_type_master/remove_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('41', '2', 'View List', 'dashboard/', '1');
INSERT INTO `ams_menu_permit` VALUES ('42', '34', 'View List', 'sub_category/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('43', '34', 'Add', 'sub_category/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('44', '34', 'Edit', 'sub_category/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('46', '0', 'Default', 'home/forgot_password/', '1');
INSERT INTO `ams_menu_permit` VALUES ('47', '56', 'View List', 'cms/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('48', '56', 'Add', 'cms/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('49', '56', 'Edit', 'cms/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('50', '56', 'Delete', 'cms/delete_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('51', '56', 'View List', 'cms/show_list/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('52', '56', 'Add', 'cms/add_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('53', '56', 'Edit', 'cms/modify_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('55', '57', 'View List', 'faq/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('56', '57', 'Add', 'faq/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('57', '57', 'Edit', 'faq/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('59', '58', 'View List', 'news/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('60', '58', 'Add', 'news/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('61', '58', 'Edit', 'news/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('63', '59', 'Add', 'menu_list/add_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('64', '59', 'Edit', 'menu_list/modify_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('65', '59', 'Delete', 'menu_list/delete_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('66', '59', 'Assign', 'menu_list/assign_pages/', '1');
INSERT INTO `ams_menu_permit` VALUES ('67', '59', 'View List', 'menu_list/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('68', '76', 'Edit', 'change_password/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('69', '76', 'Edit', 'change_password/modify_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('70', '76', 'Edit', 'change_password/modify_information/', '3');
INSERT INTO `ams_menu_permit` VALUES ('71', '76', 'Edit', 'change_password/modify_information/', '4');
INSERT INTO `ams_menu_permit` VALUES ('72', '76', 'Edit', 'change_password/modify_information/', '5');
INSERT INTO `ams_menu_permit` VALUES ('73', '76', 'Edit', 'change_password/modify_information/', '6');
INSERT INTO `ams_menu_permit` VALUES ('74', '76', 'Edit', 'change_password/modify_information/', '7');
INSERT INTO `ams_menu_permit` VALUES ('75', '76', 'Edit', 'change_password/modify_information/', '8');
INSERT INTO `ams_menu_permit` VALUES ('76', '76', 'Edit', 'change_password/modify_information/', '9');
INSERT INTO `ams_menu_permit` VALUES ('77', '77', 'View List', 'form_details/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('78', '77', 'View Detail', 'form_details/view_detail/', '1');
INSERT INTO `ams_menu_permit` VALUES ('79', '77', 'Add', 'form_details/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('80', '77', 'Edit', 'form_details/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('81', '77', 'Status', 'form_details/ajax_change_status/', '1');
INSERT INTO `ams_menu_permit` VALUES ('82', '78', 'View List', 'payer_record/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('83', '78', 'View Detail', 'payer_record/view_detail/', '1');
INSERT INTO `ams_menu_permit` VALUES ('84', '78', 'Add', 'payer_record/add_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('85', '78', 'Edit', 'payer_record/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('86', '78', 'Delete', 'payer_record/remove_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('128', '79', 'View List', 'manage_forms/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('129', '79', 'View Detail', 'manage_forms/view_detail/', '1');
INSERT INTO `ams_menu_permit` VALUES ('130', '79', 'Add', 'manage_forms/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('131', '79', 'Edit', 'manage_forms/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('132', '79', 'Delete', 'manage_forms/remove_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('133', '80', 'View List', 'amount_codes/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('134', '80', 'View Detail', 'amount_codes/view_detail/', '1');
INSERT INTO `ams_menu_permit` VALUES ('135', '80', 'Add', 'amount_codes/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('136', '80', 'Edit', 'amount_codes/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('137', '80', 'Delete', 'amount_codes/remove_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('138', '81', 'View List', 'download_efile/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('139', '81', 'View Detail', 'download_efile/view_detail/', '1');
INSERT INTO `ams_menu_permit` VALUES ('140', '81', 'Add', 'download_efile/add_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('141', '81', 'Edit', 'download_efile/modify_information/', '-99');
INSERT INTO `ams_menu_permit` VALUES ('142', '82', 'View List', 'batches/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('143', '82', 'Status', 'batches/view_detail/', '1');
INSERT INTO `ams_menu_permit` VALUES ('144', '83', 'View List', 'file_downloaded/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('145', '83', 'View Detail', 'file_downloaded/view_detail/', '1');
INSERT INTO `ams_menu_permit` VALUES ('146', '83', 'Status', 'file_downloaded/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('147', '2', 'View List', 'dashboard/', '2');
INSERT INTO `ams_menu_permit` VALUES ('148', '81', 'View List', 'download_efile/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('149', '82', 'View List', 'batches/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('150', '83', 'View List', 'file_downloaded/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('151', '3', 'Edit', 'my_account/modify_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('152', '84', 'View List', 'forms_price/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('153', '84', 'Add', 'forms_price/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('154', '84', 'Edit', 'forms_price/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('155', '84', 'Reset', 'forms_price/show_detail/', '1');
INSERT INTO `ams_menu_permit` VALUES ('156', '85', 'View List', 'customers/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('157', '85', 'Status', 'customers/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('158', '85', 'Edit', 'customers/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('159', '86', 'View List', 'manage_user/show_list/', '1');
INSERT INTO `ams_menu_permit` VALUES ('160', '86', 'Add', 'manage_user/add_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('161', '86', 'Edit', 'manage_user/modify_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('162', '86', 'Delete', 'manage_user/remove_information/', '1');
INSERT INTO `ams_menu_permit` VALUES ('163', '86', 'Status', 'manage_user/ajax_change_status/', '1');
INSERT INTO `ams_menu_permit` VALUES ('164', '4', 'Edit', 'site_setting/modify_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('165', '15', 'View List', 'email_template/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('166', '15', 'Add', 'email_template/add_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('167', '15', 'Edit', 'email_template/modify_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('168', '15', 'Delete', 'email_template/remove_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('169', '6', 'View List', 'user_type_master/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('170', '6', 'Add', '', '2');
INSERT INTO `ams_menu_permit` VALUES ('171', '6', 'Edit', 'user_type_master/modify_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('173', '6', 'Access Control', 'user_type_master/access_control/', '2');
INSERT INTO `ams_menu_permit` VALUES ('174', '86', 'View List', 'manage_user/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('175', '86', 'Add', 'manage_user/add_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('176', '86', 'Edit', 'manage_user/modify_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('177', '86', 'Delete', 'manage_user/remove_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('178', '79', 'View List', 'manage_forms/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('179', '79', 'Add', 'manage_forms/add_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('180', '79', 'Edit', 'manage_forms/modify_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('182', '78', 'View List', 'payer_record/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('183', '78', 'Add', '', '2');
INSERT INTO `ams_menu_permit` VALUES ('184', '78', 'Edit', 'payer_record/modify_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('186', '84', 'View List', 'forms_price/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('187', '84', 'Add', 'forms_price/add_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('188', '84', 'Edit', 'forms_price/modify_information/', '2');
INSERT INTO `ams_menu_permit` VALUES ('190', '85', 'View List', 'customers/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('191', '79', 'View Detail', 'manage_forms/view_detail/', '2');
INSERT INTO `ams_menu_permit` VALUES ('192', '78', 'View Detail', 'payer_record/view_detail/', '2');
INSERT INTO `ams_menu_permit` VALUES ('193', '84', 'Reset', 'forms_price/show_detail/', '2');
INSERT INTO `ams_menu_permit` VALUES ('194', '85', 'Status', 'customers/show_list/', '2');
INSERT INTO `ams_menu_permit` VALUES ('195', '82', 'Download', 'batches/ajax_download_ascii_file/', '1');
INSERT INTO `ams_menu_permit` VALUES ('196', '86', 'Status', 'manage_user/show_list/', '1');

-- ----------------------------
-- Table structure for `ams_menu_permit_copy`
-- ----------------------------
DROP TABLE IF EXISTS `ams_menu_permit_copy`;
CREATE TABLE `ams_menu_permit_copy` (
  `i_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `i_menu_id` int(11) NOT NULL COMMENT 'this can be 0 if the action is default',
  `s_action` varchar(100) NOT NULL COMMENT 'Default =>available for all user types, ex: ajax, login page, home page etc.',
  `s_link` text NOT NULL COMMENT 'excluding the base_url(). e.g.-dashboard/',
  `i_user_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0->Super Admin,1->Sub Admin',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_menu_permit_copy
-- ----------------------------
INSERT INTO `ams_menu_permit_copy` VALUES ('1', '0', 'Default', 'home/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('2', '0', 'Default', 'home/logout', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('3', '0', 'Default', 'home/ajax_menu_track/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('4', '0', 'Default', 'error_404/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('5', '10', 'Menu Permission', 'menu_setting/menu_permission/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('6', '10', 'View List', 'menu_setting/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('7', '10', 'Sub Menu List', 'menu_setting/sub_menu_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('8', '4', 'Edit', 'site_setting/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('9', '6', 'View List', 'user_type_master/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('10', '6', 'Add', 'user_type_master/add_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('11', '6', 'Edit', 'user_type_master/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('12', '6', 'Access Control', 'user_type_master/access_control/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('13', '7', 'View List', 'manage_admin_user/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('14', '7', 'Add', 'manage_admin_user/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('15', '7', 'Edit', 'manage_admin_user/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('16', '7', 'Delete', 'manage_admin_user/remove_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('17', '9', 'View List', 'generate_crud/index/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('18', '9', 'Generate', 'generate_crud/generate/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('19', '16', 'View List', 'country/show_list/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('20', '16', 'Add', 'country/add_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('21', '16', 'Edit', 'country/modify_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('23', '17', 'View List', 'state/show_list/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('24', '17', 'Add', 'state/add_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('25', '17', 'Edit', 'state/modify_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('27', '19', 'View List', 'category/show_list/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('28', '19', 'Add', 'category/add_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('29', '19', 'Edit', 'category/modify_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('31', '20', 'View List', 'city/show_list/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('32', '20', 'Add', 'city/add_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('33', '20', 'Edit', 'city/modify_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('35', '3', 'Edit', 'my_account/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('36', '15', 'Add', 'email_template/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('37', '15', 'Edit', 'email_template/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('38', '15', 'View List', 'email_template/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('39', '15', 'Delete', 'email_template/remove_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('40', '6', 'Delete', 'user_type_master/remove_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('41', '2', 'View List', 'dashboard/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('42', '34', 'View List', 'sub_category/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('43', '34', 'Add', 'sub_category/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('44', '34', 'Edit', 'sub_category/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('46', '0', 'Default', 'home/forgot_password/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('47', '56', 'View List', 'cms/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('48', '56', 'Add', 'cms/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('49', '56', 'Edit', 'cms/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('50', '56', 'Delete', 'cms/delete_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('51', '56', 'View List', 'cms/show_list/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('52', '56', 'Add', 'cms/add_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('53', '56', 'Edit', 'cms/modify_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('55', '57', 'View List', 'faq/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('56', '57', 'Add', 'faq/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('57', '57', 'Edit', 'faq/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('59', '58', 'View List', 'news/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('60', '58', 'Add', 'news/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('61', '58', 'Edit', 'news/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('63', '59', 'Add', 'menu_list/add_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('64', '59', 'Edit', 'menu_list/modify_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('65', '59', 'Delete', 'menu_list/delete_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('66', '59', 'Assign', 'menu_list/assign_pages/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('67', '59', 'View List', 'menu_list/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('68', '76', 'Edit', 'change_password/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('69', '76', 'Edit', 'change_password/modify_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('70', '76', 'Edit', 'change_password/modify_information/', '3');
INSERT INTO `ams_menu_permit_copy` VALUES ('71', '76', 'Edit', 'change_password/modify_information/', '4');
INSERT INTO `ams_menu_permit_copy` VALUES ('72', '76', 'Edit', 'change_password/modify_information/', '5');
INSERT INTO `ams_menu_permit_copy` VALUES ('73', '76', 'Edit', 'change_password/modify_information/', '6');
INSERT INTO `ams_menu_permit_copy` VALUES ('74', '76', 'Edit', 'change_password/modify_information/', '7');
INSERT INTO `ams_menu_permit_copy` VALUES ('75', '76', 'Edit', 'change_password/modify_information/', '8');
INSERT INTO `ams_menu_permit_copy` VALUES ('76', '76', 'Edit', 'change_password/modify_information/', '9');
INSERT INTO `ams_menu_permit_copy` VALUES ('77', '77', 'View List', 'form_details/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('78', '77', 'View Detail', 'form_details/view_detail/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('79', '77', 'Add', 'form_details/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('80', '77', 'Edit', 'form_details/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('81', '77', 'Status', 'form_details/ajax_change_status/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('82', '78', 'View List', 'payer_record/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('83', '78', 'View Detail', 'payer_record/view_detail/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('84', '78', 'Add', 'payer_record/add_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('85', '78', 'Edit', 'payer_record/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('86', '78', 'Delete', 'payer_record/remove_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('128', '79', 'View List', 'manage_forms/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('129', '79', 'View Detail', 'manage_forms/view_detail/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('130', '79', 'Add', 'manage_forms/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('131', '79', 'Edit', 'manage_forms/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('132', '79', 'Delete', 'manage_forms/remove_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('133', '80', 'View List', 'amount_codes/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('134', '80', 'View Detail', 'amount_codes/view_detail/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('135', '80', 'Add', 'amount_codes/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('136', '80', 'Edit', 'amount_codes/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('137', '80', 'Delete', 'amount_codes/remove_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('138', '81', 'View List', 'download_efile/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('139', '81', 'View Detail', 'download_efile/view_detail/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('140', '81', 'Add', 'download_efile/add_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('141', '81', 'Edit', 'download_efile/modify_information/', '-99');
INSERT INTO `ams_menu_permit_copy` VALUES ('142', '82', 'View List', 'batches/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('143', '82', 'Status', 'batches/view_detail/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('144', '83', 'View List', 'file_downloaded/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('145', '83', 'View Detail', 'file_downloaded/view_detail/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('146', '83', 'Status', 'file_downloaded/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('147', '2', 'View List', 'dashboard/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('148', '81', 'View List', 'download_efile/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('149', '82', 'View List', 'batches/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('150', '83', 'View List', 'file_downloaded/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('151', '3', 'Edit', 'my_account/modify_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('152', '84', 'View List', 'forms_price/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('153', '84', 'Add', 'forms_price/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('154', '84', 'Edit', 'forms_price/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('155', '84', 'Reset', 'forms_price/show_detail/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('156', '85', 'View List', 'customers/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('157', '85', 'Status', 'customers/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('158', '85', 'Edit', 'customers/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('159', '86', 'View List', 'manage_user/show_list/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('160', '86', 'Add', 'manage_user/add_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('161', '86', 'Edit', 'manage_user/modify_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('162', '86', 'Delete', 'manage_user/remove_information/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('163', '86', 'Status', 'manage_user/ajax_change_status/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('164', '4', 'Edit', 'site_setting/modify_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('165', '15', 'View List', 'email_template/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('166', '15', 'Add', 'email_template/add_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('167', '15', 'Edit', 'email_template/modify_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('168', '15', 'Delete', 'email_template/remove_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('169', '6', 'View List', 'user_type_master/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('170', '6', 'Add', '', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('171', '6', 'Edit', 'user_type_master/modify_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('173', '6', 'Access Control', 'user_type_master/access_control/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('174', '86', 'View List', 'manage_user/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('175', '86', 'Add', 'manage_user/add_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('176', '86', 'Edit', 'manage_user/modify_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('177', '86', 'Delete', 'manage_user/remove_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('178', '79', 'View List', 'manage_forms/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('179', '79', 'Add', 'manage_forms/add_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('180', '79', 'Edit', 'manage_forms/modify_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('182', '78', 'View List', 'payer_record/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('183', '78', 'Add', '', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('184', '78', 'Edit', 'payer_record/modify_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('186', '84', 'View List', 'forms_price/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('187', '84', 'Add', 'forms_price/add_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('188', '84', 'Edit', 'forms_price/modify_information/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('190', '85', 'View List', 'customers/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('191', '79', 'View Detail', 'manage_forms/view_detail/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('192', '78', 'View Detail', 'payer_record/view_detail/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('193', '84', 'Reset', 'forms_price/show_detail/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('194', '85', 'Status', 'customers/show_list/', '2');
INSERT INTO `ams_menu_permit_copy` VALUES ('195', '82', 'Download', 'batches/ajax_download_ascii_file/', '1');
INSERT INTO `ams_menu_permit_copy` VALUES ('196', '86', 'Status', 'manage_user/show_list/', '1');

-- ----------------------------
-- Table structure for `ams_news`
-- ----------------------------
DROP TABLE IF EXISTS `ams_news`;
CREATE TABLE `ams_news` (
  `i_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `i_user_id` int(10) DEFAULT NULL,
  `s_title` varchar(255) DEFAULT NULL,
  `s_summary` text,
  `s_author` varchar(255) DEFAULT NULL,
  `s_description` text,
  `s_url` varchar(255) DEFAULT NULL,
  `dt_added` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  `dt_published` datetime DEFAULT NULL,
  `e_deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `i_sort_order` int(11) NOT NULL,
  `e_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_news
-- ----------------------------

-- ----------------------------
-- Table structure for `ams_payee_info`
-- ----------------------------
DROP TABLE IF EXISTS `ams_payee_info`;
CREATE TABLE `ams_payee_info` (
  `i_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `s_batch_code` varchar(255) DEFAULT NULL,
  `i_payer_id` int(11) DEFAULT NULL COMMENT 'PK of ams_payer_info tbl',
  `e_record_type` enum('T','A','B','C','K') NOT NULL DEFAULT 'B',
  `s_form_id` varchar(50) DEFAULT NULL,
  `i_payment_year` int(4) DEFAULT NULL,
  `s_payee_tin` int(20) DEFAULT NULL COMMENT 'Payer’s Taxpayer\rIdentification Number\r(TIN)',
  `s_type_of_tin` varchar(2) DEFAULT NULL COMMENT 'Type of Return',
  `s_corrected_return_indicator` varchar(16) DEFAULT NULL COMMENT 'Amount Codes',
  `s_payer_account_number` varchar(255) DEFAULT NULL COMMENT 'Foreign Entity\rIndicator',
  `s_payer_office_code` varchar(255) DEFAULT NULL,
  `s_payment_amount1` decimal(15,2) DEFAULT NULL,
  `s_payment_amount2` decimal(15,2) DEFAULT NULL,
  `s_payment_amount3` decimal(15,2) DEFAULT NULL,
  `s_payment_amount4` decimal(15,2) DEFAULT NULL,
  `s_payment_amount5` decimal(15,2) DEFAULT NULL,
  `s_payment_amount6` decimal(15,2) DEFAULT NULL,
  `s_payment_amount7` decimal(15,2) DEFAULT NULL,
  `s_payment_amount8` decimal(15,2) DEFAULT NULL,
  `s_payment_amount9` decimal(15,2) DEFAULT NULL,
  `s_payment_amount10` decimal(15,2) DEFAULT NULL,
  `s_payment_amount11` decimal(15,2) DEFAULT NULL,
  `s_payment_amount12` decimal(15,2) DEFAULT NULL,
  `s_payment_amount13` decimal(15,2) DEFAULT NULL,
  `s_payment_amount14` decimal(15,2) DEFAULT NULL,
  `s_payment_amount15` decimal(15,2) DEFAULT NULL,
  `s_payment_amount16` decimal(15,2) DEFAULT NULL,
  `s_first_payee_name_line` varchar(50) DEFAULT NULL COMMENT 'First Payer Name Line',
  `s_last_payee_name_line` varchar(50) DEFAULT NULL,
  `s_second_payee_name_line` varchar(50) DEFAULT NULL COMMENT 'Second Payer Name\r\nLine',
  `s_payee_shipping_address` varchar(255) DEFAULT NULL COMMENT 'Payer Shipping Address',
  `s_payee_city` varchar(50) DEFAULT NULL COMMENT 'Payer City',
  `s_payee_state` varchar(20) DEFAULT NULL COMMENT 'Payer State',
  `s_payee_zip_code` varchar(10) DEFAULT NULL COMMENT 'Payer ZIP Code',
  `s_payere_telephone_number_and_extension` varchar(20) DEFAULT NULL COMMENT 'Payer’s Telephone\rNumber and\rExtension',
  `s_personal_liability` varchar(10) DEFAULT NULL,
  `dt_lender_aquisition` datetime DEFAULT NULL,
  `s_description_property` varchar(1000) DEFAULT NULL,
  `s_special_data` varchar(1000) DEFAULT NULL,
  `s_AcctNumber` varchar(255) DEFAULT NULL,
  `s_EmployeeContrib` decimal(20,2) DEFAULT NULL COMMENT '5498 form field start take a look at transmit code',
  `s_TotalContribReturnYr` decimal(20,2) DEFAULT NULL,
  `s_FairMarketValue` decimal(20,2) DEFAULT NULL,
  `s_ArcherMSAInd` varchar(255) DEFAULT NULL,
  `s_CoverdellESAContribAmt` decimal(20,2) DEFAULT NULL,
  `s_MortgageInt` decimal(20,2) DEFAULT NULL COMMENT '1098 series starts',
  `s_PointsInDollarsAmt` decimal(20,2) DEFAULT NULL,
  `s_RefundOfOverpaidInt` decimal(20,2) DEFAULT NULL,
  `s_DateOfContribution` datetime DEFAULT NULL,
  `s_Year` varchar(255) DEFAULT NULL,
  `s_Make` varchar(255) DEFAULT NULL,
  `s_Model` varchar(255) DEFAULT NULL,
  `s_IDNumber` varchar(255) DEFAULT NULL COMMENT 'vehicle identification number',
  `e_LessFMVInd` enum('true','false') DEFAULT NULL,
  `e_ProvideGoodsSvcsInExchInd` enum('true','false') DEFAULT NULL,
  `s_ValueOfGoodsAndSvcsProvided` decimal(20,2) DEFAULT NULL,
  `s_DescrGoodsSvcsOne` text,
  `e_IntangibleReligiousBenefitsCk` enum('true','false') DEFAULT NULL,
  `s_StudentLoanInt` decimal(20,2) DEFAULT NULL,
  `dt_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `i_status` tinyint(4) DEFAULT '1' COMMENT '0->Inactive, 1->Active, 2->Deleted',
  `DateofAcquisition` datetime DEFAULT NULL COMMENT '1099B form fields start',
  `LongTermLossInd` enum('true','false') DEFAULT NULL,
  `CusipNumber` varchar(255) DEFAULT NULL,
  `StocksBonds` decimal(20,2) DEFAULT NULL,
  `NetProceedsInd` enum('true','false') DEFAULT NULL,
  `CostOrOtherBasis` decimal(20,2) DEFAULT NULL,
  `WCDCode` varchar(255) DEFAULT NULL,
  `s_FITWithh` decimal(20,2) DEFAULT NULL COMMENT 'only for 1099B, for W2 series its in another tbl',
  `BarteringAmt` decimal(20,2) DEFAULT NULL,
  `DateCanceled` datetime DEFAULT NULL,
  `AmtOfDebtCanceled` decimal(20,2) DEFAULT NULL,
  `InterestIncluded` decimal(20,2) DEFAULT NULL,
  `DebtDescrOne` text,
  `BorrowerLiabInd` enum('true','false') DEFAULT NULL,
  `IdentifiableEventCode` varchar(50) DEFAULT NULL,
  `DateofSale` datetime DEFAULT NULL COMMENT '1099CAP form fields',
  `NumSharesExchanged` varchar(255) DEFAULT NULL,
  `ClassesStockExchanged` varchar(255) DEFAULT NULL,
  `AggregateAmtRec` decimal(20,2) DEFAULT NULL,
  `ForeignCountryOrUSPoss` varchar(255) DEFAULT NULL COMMENT '1099DIV form fields',
  `OrdinaryDiv` decimal(20,2) DEFAULT NULL,
  `QualifiedDiv` decimal(20,2) DEFAULT NULL,
  `NonTaxDist` decimal(20,2) DEFAULT NULL,
  `InvestmentExp` decimal(20,2) DEFAULT NULL,
  `ForeignTaxPaid` decimal(20,2) DEFAULT NULL,
  `CashLiquidDistr` decimal(20,2) DEFAULT NULL,
  `SpecPrivateActivityBondInterestDiv` decimal(20,2) DEFAULT NULL,
  `StateLocalRefund` decimal(20,2) DEFAULT NULL COMMENT '1099G form fields starts',
  `RefundTaxYr` int(10) DEFAULT NULL,
  `TaxableGrants` decimal(20,2) DEFAULT NULL,
  `MarketGain` decimal(20,2) DEFAULT NULL,
  `PayersRTN` varchar(50) DEFAULT NULL COMMENT '1099INT form fields',
  `TaxExemptBondCusipNum` varchar(50) DEFAULT NULL,
  `InterestIncome` decimal(20,2) DEFAULT NULL,
  `EarlyWithdrawal` decimal(20,2) DEFAULT NULL,
  `IntOnUSTreas` decimal(20,2) DEFAULT NULL,
  `InvestmentExpenses` decimal(20,2) DEFAULT NULL,
  `TaxExemptInterest` decimal(20,2) DEFAULT NULL,
  `GrossLTBenefitsPd` decimal(20,2) DEFAULT NULL COMMENT '1099LTC form fields starts',
  `AccelDeathBenPd` decimal(20,2) DEFAULT NULL,
  `ReimbursedAmtInd` enum('true','false') DEFAULT NULL,
  `InsuredsSSN` varchar(50) DEFAULT NULL,
  `InsuredsNameOne` varchar(255) DEFAULT NULL,
  `InsuredsStreetAddr` varchar(255) DEFAULT NULL,
  `InsuredsCity` varchar(100) DEFAULT NULL,
  `InsuredsState` varchar(50) DEFAULT NULL,
  `InsuredsZip` varchar(50) DEFAULT NULL,
  `ChronicallyillInd` enum('') DEFAULT NULL,
  `DateCertified` datetime DEFAULT NULL,
  `s_StateNameOne` varchar(255) DEFAULT NULL COMMENT '1099MISC form fields starts',
  `s_StateIdOne` varchar(255) DEFAULT NULL,
  `OtherIncome` decimal(20,2) DEFAULT NULL,
  `NonEmpComp` decimal(20,2) DEFAULT NULL,
  `GrossAttorneyProc` decimal(20,2) DEFAULT NULL,
  `s_StateTaxWithhOne` decimal(20,2) DEFAULT NULL,
  `s_StateIncomeOne` decimal(20,2) DEFAULT NULL,
  `Form1099MISCAgencies` varchar(50) DEFAULT NULL,
  `OIDForThisYrAmt` decimal(20,2) DEFAULT NULL COMMENT '1099OID form fields starts',
  `OtherPeriodicInt` decimal(20,2) DEFAULT NULL,
  `AcquisitionPremium` decimal(20,2) DEFAULT NULL,
  `DescrOne` varchar(255) DEFAULT NULL,
  `DescrTwo` varchar(255) DEFAULT NULL,
  `NonPatrDistrib` decimal(20,2) DEFAULT NULL COMMENT '1099PATR form fields starts',
  `RedemptionOfNonQualAmt` decimal(20,2) DEFAULT NULL,
  `OtherCredits` decimal(20,2) DEFAULT NULL,
  `InvestmentCredit` decimal(20,2) DEFAULT NULL,
  `WorkOppCredit` decimal(20,2) DEFAULT NULL,
  `GrossDistrib` decimal(20,2) DEFAULT NULL COMMENT '1099Q form fields starts',
  `Earnings` decimal(20,2) DEFAULT NULL,
  `Basis` decimal(20,2) DEFAULT NULL,
  `TrustToTrustRolloverInd` enum('true','false') DEFAULT NULL,
  `PrivateInd` enum('true','false') DEFAULT NULL,
  `WrongAmountOrFiling` enum('true','false') DEFAULT NULL COMMENT '1099R form fields starts',
  `DistributionCode` varchar(25) DEFAULT NULL,
  `OtherPercent` varchar(20) DEFAULT NULL,
  `GrossDistribution` decimal(20,2) DEFAULT NULL,
  `TaxableAmt` decimal(20,2) DEFAULT NULL,
  `s_Other` decimal(20,2) DEFAULT NULL,
  `StateDistribOne` decimal(20,2) DEFAULT NULL,
  `DateOfClosing` datetime DEFAULT NULL COMMENT '1099S form fields starts',
  `GrossProceeds` decimal(20,2) DEFAULT NULL,
  `DescrThree` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_payee_info
-- ----------------------------
INSERT INTO `ams_payee_info` VALUES ('1', '100001', '1', 'B', '1', '2015', '222222222', '1', null, null, null, '452.67', '125.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'RONALDO', 'TRUEDOE', 'RE', '111 S PALMTREE CT', 'SOMECITY', 'OK', '743451111', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-02-21 12:51:43', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('2', '100001', '1', 'B', '1', '2015', '333333333', '1', null, null, null, '4520.67', '1250.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ALLENO', 'CAPSTONE', 'AC', '222 W STONEWAY PL', 'RIGHTHERE', 'OK', '733452222', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-02-21 12:51:44', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('3', '100001', '2', 'B', '1', '2015', '555555555', '1', null, null, null, '452.67', '125.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'RONALDO', 'TRUEDOE', 'RE', '111 S PALMTREE CT', 'SOMECITY', 'OK', '743451111', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-02-21 12:51:44', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('4', '100001', '2', 'B', '1', '2015', '666666666', '1', null, null, null, '4520.67', '1250.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ALLENO', 'CAPSTONE', 'AC', '222 W STONEWAY PL', 'RIGHTHERE', 'OK', '733452222', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-02-21 12:51:44', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('5', '100002', '3', 'B', '1', '2015', '222222222', '1', null, null, null, '452.67', '125.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'RONALDO', 'TRUEDOE', 'RE', '111 S PALMTREE CT', 'SOMECITY', 'OK', '743451111', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-02-21 13:05:35', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('6', '100002', '3', 'B', '1', '2015', '333333333', '1', null, null, null, '4520.67', '1250.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ALLENO', 'CAPSTONE', 'AC', '222 W STONEWAY PL', 'RIGHTHERE', 'OK', '733452222', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-02-21 13:05:35', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('7', '100002', '4', 'B', '1', '2015', '555555555', '1', null, null, null, '452.67', '125.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'RONALDO', 'TRUEDOE', 'RE', '111 S PALMTREE CT', 'SOMECITY', 'OK', '743451111', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-02-21 13:05:36', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('8', '100002', '4', 'B', '1', '2015', '666666666', '1', null, null, null, '4520.67', '1250.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ALLENO', 'CAPSTONE', 'AC', '222 W STONEWAY PL', 'RIGHTHERE', 'OK', '733452222', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-02-21 13:05:36', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('9', '100003', '5', 'B', '1', '2015', '222222222', '1', null, null, null, '452.67', '125.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'RONALDO', 'TRUEDOE', 'RE', '111 S PALMTREE CT', 'SOMECITY', 'OK', '743451111', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-03-06 13:00:53', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('10', '100004', '7', 'B', '1', '2015', '222222222', '1', null, null, null, '452.67', '125.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'RONALDO', 'TRUEDOE', 'RE', '111 S PALMTREE CT', 'SOMECITY', 'OK', '743451111', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-03-06 13:00:54', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('11', '100004', '7', 'B', '1', '2015', '333333333', '1', null, null, null, '4520.67', '1250.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ALLENO', 'CAPSTONE', 'AC', '222 W STONEWAY PL', 'RIGHTHERE', 'OK', '733452222', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-03-06 13:00:54', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('12', '100003', '5', 'B', '1', '2015', '333333333', '1', null, null, null, '4520.67', '1250.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ALLENO', 'CAPSTONE', 'AC', '222 W STONEWAY PL', 'RIGHTHERE', 'OK', '733452222', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-03-06 13:00:54', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('13', '100004', '8', 'B', '1', '2015', '555555555', '1', null, null, null, '452.67', '125.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'RONALDO', 'TRUEDOE', 'RE', '111 S PALMTREE CT', 'SOMECITY', 'OK', '743451111', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-03-06 13:00:55', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('14', '100003', '6', 'B', '1', '2015', '555555555', '1', null, null, null, '452.67', '125.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'RONALDO', 'TRUEDOE', 'RE', '111 S PALMTREE CT', 'SOMECITY', 'OK', '743451111', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-03-06 13:00:55', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('15', '100004', '8', 'B', '1', '2015', '666666666', '1', null, null, null, '4520.67', '1250.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ALLENO', 'CAPSTONE', 'AC', '222 W STONEWAY PL', 'RIGHTHERE', 'OK', '733452222', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-03-06 13:00:55', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('16', '100003', '6', 'B', '1', '2015', '666666666', '1', null, null, null, '4520.67', '1250.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ALLENO', 'CAPSTONE', 'AC', '222 W STONEWAY PL', 'RIGHTHERE', 'OK', '733452222', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-03-06 13:00:55', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('17', '100005', '9', 'B', '1', '2015', '222222222', '1', null, null, null, '452.67', '125.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'RONALDO', 'TRUEDOE', 'RE', '111 S PALMTREE CT', 'SOMECITY', 'OK', '743451111', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-04-13 15:09:48', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('18', '100005', '9', 'B', '1', '2015', '333333333', '1', null, null, null, '4520.67', '1250.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ALLENO', 'CAPSTONE', 'AC', '222 W STONEWAY PL', 'RIGHTHERE', 'OK', '733452222', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-04-13 15:09:49', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('19', '100005', '10', 'B', '1', '2015', '555555555', '1', null, null, null, '452.67', '125.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'RONALDO', 'TRUEDOE', 'RE', '111 S PALMTREE CT', 'SOMECITY', 'OK', '743451111', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-04-13 15:09:49', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');
INSERT INTO `ams_payee_info` VALUES ('20', '100005', '10', 'B', '1', '2015', '666666666', '1', null, null, null, '4520.67', '1250.51', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ALLENO', 'CAPSTONE', 'AC', '222 W STONEWAY PL', 'RIGHTHERE', 'OK', '733452222', null, null, null, null, null, '', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '2015', '', '', '', '', '', '0.00', '', '', '0.00', '2017-04-13 15:09:50', '1', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '', '0.00', '0.00', '0.00', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0000-00-00 00:00:00', '0.00', '');

-- ----------------------------
-- Table structure for `ams_payee_others_info`
-- ----------------------------
DROP TABLE IF EXISTS `ams_payee_others_info`;
CREATE TABLE `ams_payee_others_info` (
  `i_pk_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `i_payee_id` int(10) DEFAULT NULL,
  `s_batchId` varchar(255) DEFAULT NULL,
  `TypeOfWagerCode` int(10) DEFAULT NULL COMMENT 'W2G form fields start',
  `TypeOfWagerCategory` varchar(255) DEFAULT NULL,
  `DateWon` datetime DEFAULT NULL,
  `GrossWinnings` decimal(20,2) NOT NULL DEFAULT '0.00',
  `FITWithh` decimal(20,2) NOT NULL DEFAULT '0.00',
  `StateNameOne` varchar(255) DEFAULT NULL,
  `StateIdOne` varchar(255) DEFAULT NULL,
  `StateTaxWithhOne` decimal(20,2) NOT NULL DEFAULT '0.00',
  `StateWinningsOne` decimal(20,2) NOT NULL DEFAULT '0.00',
  `EmploymentType` varchar(255) DEFAULT NULL COMMENT 'W2 form fields starts',
  `Box14TextOne` varchar(255) DEFAULT NULL,
  `Code_a` varchar(255) DEFAULT NULL,
  `Amt_a` decimal(20,2) NOT NULL DEFAULT '0.00',
  `StatutoryInd` enum('true','false') DEFAULT NULL,
  `RetirementPlanInd` enum('true','false') DEFAULT NULL,
  `ThirdPartySickPayInd` enum('true','false') DEFAULT NULL,
  `W2ControlNumber` varchar(255) DEFAULT NULL,
  `MedicareWithh` decimal(20,2) NOT NULL DEFAULT '0.00',
  `MedWagesAndTips` decimal(20,2) NOT NULL DEFAULT '0.00',
  `SocSecWages` decimal(20,2) NOT NULL DEFAULT '0.00',
  `SocSecWithh` decimal(20,2) NOT NULL DEFAULT '0.00',
  `StateWagesTipsEtcOne` decimal(20,2) NOT NULL DEFAULT '0.00',
  `WagesTipsOtherComp` decimal(20,2) NOT NULL DEFAULT '0.00',
  `YearFormCorrected` varchar(4) DEFAULT NULL COMMENT 'W2C form fields starts',
  `CorrectedNameInd` enum('true','false') DEFAULT NULL,
  `EmployeesIncorrectSSN` varchar(255) DEFAULT NULL,
  `EmployeesFirstNamePreviouslyReported` varchar(255) DEFAULT NULL,
  `EmployeesMiddleInitialPreviouslyReported` varchar(255) DEFAULT NULL,
  `EmployeesLastNamePreviouslyReported` varchar(255) DEFAULT NULL,
  `EmploymentTypePreviouslyReported` varchar(255) DEFAULT NULL,
  `WagesTipsPreviouslyReported` decimal(20,2) NOT NULL DEFAULT '0.00',
  `WagesTipsCorrected` decimal(20,2) NOT NULL DEFAULT '0.00',
  `FITWithhPreviouslyReported` decimal(20,2) NOT NULL DEFAULT '0.00',
  `FITWithhCorrected` decimal(20,2) NOT NULL DEFAULT '0.00',
  `SocialSecurityWagesPreviouslyReported` decimal(20,2) NOT NULL DEFAULT '0.00',
  `SocialSecurityWagesCorrected` decimal(20,2) NOT NULL,
  `SocialSecurityTaxWithhPreviouslyReported` decimal(20,2) NOT NULL,
  `SocialSecurityTaxWithhCorrected` decimal(20,2) NOT NULL,
  `MedicareWagesAndTipsPreviouslyReported` decimal(20,2) NOT NULL DEFAULT '0.00',
  `MedicareWagesAndTipsCorrected` decimal(20,2) NOT NULL DEFAULT '0.00',
  `MedicareTaxWithhPreviouslyReported` decimal(20,2) NOT NULL DEFAULT '0.00',
  `MedicareTaxWithhCorrected` decimal(20,2) NOT NULL DEFAULT '0.00',
  `AllocatedTipsPreviouslyReported` decimal(20,2) NOT NULL,
  `AllocatedTipsCorrected` decimal(20,2) NOT NULL DEFAULT '0.00',
  `DependentCarePreviouslyReported` decimal(20,2) NOT NULL DEFAULT '0.00',
  `DependentCareCorrected` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Code_aPreviouslyReported` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Code_aCorrected` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Amt_aPreviouslyReported` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Amt_aCorrected` decimal(20,2) NOT NULL DEFAULT '0.00',
  `RetirementPlanCorrectedInd` enum('true','false') DEFAULT NULL,
  `DateofAcquisition` datetime DEFAULT NULL COMMENT '1099B form fields start',
  `LongTermLossInd` enum('true','false') DEFAULT NULL,
  `CusipNumber` varchar(255) DEFAULT NULL,
  `StocksBonds` decimal(20,2) NOT NULL DEFAULT '0.00',
  `NetProceedsInd` enum('true','false') DEFAULT NULL,
  `CostOrOtherBasis` decimal(20,2) NOT NULL DEFAULT '0.00',
  `WCDCode` varchar(255) DEFAULT NULL,
  `BarteringAmt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `DateCanceled` datetime DEFAULT NULL,
  `AmtOfDebtCanceled` decimal(20,2) NOT NULL DEFAULT '0.00',
  `InterestIncluded` decimal(20,2) NOT NULL DEFAULT '0.00',
  `DebtDescrOne` varchar(255) DEFAULT NULL,
  `BorrowerLiabInd` enum('true','false') DEFAULT NULL,
  `IdentifiableEventCode` varchar(255) DEFAULT NULL,
  `DateofSale` datetime DEFAULT NULL COMMENT '1099CAP form fields start',
  `NumSharesExchanged` varchar(255) DEFAULT NULL,
  `ClassesStockExchanged` varchar(255) DEFAULT NULL,
  `AggregateAmtRec` decimal(20,2) NOT NULL DEFAULT '0.00',
  `ForeignCountryOrUSPoss` varchar(255) DEFAULT NULL COMMENT '1099DIV form fields start',
  `OrdinaryDiv` decimal(20,2) NOT NULL DEFAULT '0.00',
  `QualifiedDiv` decimal(20,2) NOT NULL DEFAULT '0.00',
  `NonTaxDist` decimal(20,2) NOT NULL DEFAULT '0.00',
  `InvestmentExp` decimal(20,2) NOT NULL DEFAULT '0.00',
  `ForeignTaxPaid` decimal(20,2) NOT NULL DEFAULT '0.00',
  `CashLiquidDistr` decimal(20,2) NOT NULL DEFAULT '0.00',
  `SpecPrivateActivityBondInterestDiv` decimal(20,2) NOT NULL DEFAULT '0.00',
  `ForeignAddress` enum('true','false') DEFAULT NULL,
  `ForeignStateOrProvince` varchar(255) DEFAULT NULL,
  `ForeignPostalCode` varchar(255) DEFAULT NULL,
  `CountryCode` varchar(255) DEFAULT NULL,
  `StateLocalRefund` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '1099G form fields start',
  `RefundTaxYr` int(4) DEFAULT NULL,
  `TaxableGrants` decimal(20,2) NOT NULL DEFAULT '0.00',
  `MarketGain` decimal(20,2) NOT NULL DEFAULT '0.00',
  `PayersRTN` varchar(50) DEFAULT NULL COMMENT '1099INT form fields start',
  `TaxExemptBondCusipNum` varchar(255) DEFAULT NULL,
  `InterestIncome` decimal(20,2) NOT NULL DEFAULT '0.00',
  `EarlyWithdrawal` decimal(20,2) NOT NULL DEFAULT '0.00',
  `IntOnUSTreas` decimal(20,2) NOT NULL,
  `InvestmentExpenses` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxExemptInterest` decimal(20,2) NOT NULL DEFAULT '0.00',
  `GrossLTBenefitsPd` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '1099LTC form fields start',
  `AccelDeathBenPd` decimal(20,2) NOT NULL DEFAULT '0.00',
  `ReimbursedAmtInd` enum('true','false') DEFAULT NULL,
  `InsuredsSSN` varchar(255) DEFAULT NULL,
  `InsuredsNameOne` varchar(255) DEFAULT NULL,
  `InsuredsStreetAddr` varchar(255) DEFAULT NULL,
  `InsuredsCity` varchar(255) DEFAULT NULL,
  `InsuredsState` varchar(255) DEFAULT NULL,
  `InsuredsZip` varchar(255) DEFAULT NULL,
  `ChronicallyillInd` enum('true','false') DEFAULT NULL,
  `DateCertified` datetime DEFAULT NULL,
  `OtherIncome` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '1099MISC form fields start',
  `NonEmpComp` decimal(20,2) NOT NULL DEFAULT '0.00',
  `GrossAttorneyProc` decimal(20,2) NOT NULL DEFAULT '0.00',
  `StateIncomeOne` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Form1099MISCAgencies` varchar(10) DEFAULT NULL,
  `OIDForThisYrAmt` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '1099OID form fields start',
  `OtherPeriodicInt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `AcquisitionPremium` decimal(20,2) NOT NULL DEFAULT '0.00',
  `DescrOne` text,
  `DescrTwo` text,
  `NonPatrDistrib` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '1099PATR form fields start',
  `RedemptionOfNonQualAmt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `OtherCredits` decimal(20,2) NOT NULL DEFAULT '0.00',
  `InvestmentCredit` decimal(20,2) NOT NULL DEFAULT '0.00',
  `WorkOppCredit` decimal(20,2) NOT NULL DEFAULT '0.00',
  `GrossDistrib` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '1099Q form fields start',
  `Earnings` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Basis` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TrustToTrustRolloverInd` enum('true','false') DEFAULT NULL,
  `PrivateInd` enum('true','false') DEFAULT NULL,
  `WrongAmountOrFiling` enum('true','false') DEFAULT NULL COMMENT '1099R form fields start',
  `DistributionCode` varchar(10) DEFAULT NULL,
  `OtherPercent` int(10) NOT NULL DEFAULT '0',
  `GrossDistribution` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxableAmt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Other` decimal(20,2) NOT NULL DEFAULT '0.00',
  `StateDistribOne` decimal(20,2) NOT NULL DEFAULT '0.00',
  `DateOfClosing` datetime DEFAULT NULL COMMENT '1099S form fields start',
  `GrossProceeds` decimal(20,2) NOT NULL DEFAULT '0.00',
  `DescrThree` text,
  PRIMARY KEY (`i_pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_payee_others_info
-- ----------------------------
INSERT INTO `ams_payee_others_info` VALUES ('1', '1', '100001', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('2', '2', '100001', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('3', '3', '100001', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('4', '4', '100001', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('5', '5', '100002', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('6', '6', '100002', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('7', '7', '100002', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('8', '8', '100002', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('9', '10', '100004', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('10', '9', '100003', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('11', '11', '100004', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('12', '12', '100003', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('13', '13', '100004', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('14', '14', '100003', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('15', '15', '100004', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('16', '16', '100003', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('17', '17', '100005', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('18', '18', '100005', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('19', '19', '100005', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);
INSERT INTO `ams_payee_others_info` VALUES ('20', '20', '100005', '0', '', '0000-00-00 00:00:00', '0.00', '0.00', '', '', '0.00', '0.00', '', '', '', '0.00', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', null, null, null, '0.00', null, '0.00', null, '0.00', null, '0.00', '0.00', null, null, null, null, null, null, '0.00', null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0.00', null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', null, '0.00', '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, null, '0', '0.00', '0.00', '0.00', '0.00', null, '0.00', null);

-- ----------------------------
-- Table structure for `ams_payee_others_info_94seies`
-- ----------------------------
DROP TABLE IF EXISTS `ams_payee_others_info_94seies`;
CREATE TABLE `ams_payee_others_info_94seies` (
  `i_prime_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `i_Payee_Id` int(10) DEFAULT NULL,
  `s_BatchId` varchar(255) DEFAULT NULL,
  `TaxPeriodEndDate` datetime DEFAULT NULL,
  `DepositStateCode` varchar(255) DEFAULT NULL,
  `TotalFUTAWages` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalExemptFUTAWages` decimal(20,2) NOT NULL DEFAULT '0.00',
  `FringeBenefitsInd` enum('true','false') DEFAULT NULL,
  `DependentCareInd` enum('true','false') DEFAULT NULL,
  `TotalExcessFUTAWages` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalExemptAndExcessFUTAWages` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalTxblFUTAWages` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalFUTATaxBeforeAdj` decimal(20,2) NOT NULL DEFAULT '0.00',
  `AdjToTax` decimal(20,2) NOT NULL DEFAULT '0.00',
  `CreditAmt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalFUTATaxAfterAdj` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalFUTATaxDeposited` decimal(20,2) NOT NULL DEFAULT '0.00',
  `OverpaymentAmt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `RefundOrCredit` varchar(255) DEFAULT '0.00',
  `TaxWithhQtr1` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxWithhQtr2` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxWithhQtr3` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxWithhQtr4` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalTaxWithh` decimal(20,2) NOT NULL DEFAULT '0.00',
  `FinalReturnInd` enum('true','false') DEFAULT NULL COMMENT '941 Forms fields start',
  `DateFinalWagesPaid` datetime DEFAULT NULL COMMENT '1099CAP form fields start',
  `NumberOfEmployees` varchar(255) DEFAULT NULL,
  `TotalWages` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalIncomeTaxWithh` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxableSocialSecurityWages` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxOnSocialSecurityWages` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxableMedicareWagesTips` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxOnMedicareTips` decimal(20,2) NOT NULL DEFAULT '0.00',
  `AddedMedicareWagesTips` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxOnAddedMedicareWagesTips` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalSocialSecurityMedTaxes` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '1099G form fields start',
  `SickPayAdjustment` decimal(20,2) NOT NULL DEFAULT '0.00',
  `FractionsOfCentsAdjustment` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalDepositsOverpaymentForQtr` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TaxOnUnreportedTips` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalTax` decimal(20,2) NOT NULL,
  `Amount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Refund` enum('true','false') DEFAULT NULL,
  `SemiWeeklyScheduleDepositor` enum('true','false') DEFAULT NULL,
  `TotalTaxesBeforeAdjustmentsAmt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `DateQuarterEnding` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Name` varchar(255) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Signature` varchar(255) DEFAULT NULL,
  `DateSigned` datetime DEFAULT NULL,
  `Month1Day3` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month1Day10` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month1Day17` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month1Day24` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month1Day31` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month2Day7` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month2Day14` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month2Day21` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month2Day28` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month3Day7` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month3Day14` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month3Day21` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month3Day28` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalMonth1Liab` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalMonth2Liab` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalMonth3Liab` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalQuarterLiab` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalDepositsOverpaymentForYr` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '944 Forms starts',
  `MonthlyDepositorCheckbox` enum('true','false') NOT NULL,
  `Month1Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month2Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month3Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month4Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month5Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month6Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month7Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month8Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month9Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month10Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month11Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Month12Liability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalYearLiability` decimal(20,2) NOT NULL DEFAULT '0.00',
  `EmailAddress` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`i_prime_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_payee_others_info_94seies
-- ----------------------------
INSERT INTO `ams_payee_others_info_94seies` VALUES ('1', '1', '100001', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('2', '2', '100001', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('3', '3', '100001', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('4', '4', '100001', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('5', '5', '100002', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('6', '6', '100002', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('7', '7', '100002', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('8', '8', '100002', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('9', '9', '100003', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('10', '10', '100004', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('11', '11', '100004', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('12', '12', '100003', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('13', '13', '100004', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('14', '14', '100003', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('15', '15', '100004', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('16', '16', '100003', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('17', '17', '100005', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('18', '18', '100005', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('19', '19', '100005', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);
INSERT INTO `ams_payee_others_info_94seies` VALUES ('20', '20', '100005', null, null, '0.00', '0.00', null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null, null, '0.00', '0000-00-00 00:00:00', null, null, null, null, null, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'true', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', null);

-- ----------------------------
-- Table structure for `ams_payer_info`
-- ----------------------------
DROP TABLE IF EXISTS `ams_payer_info`;
CREATE TABLE `ams_payer_info` (
  `i_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `s_batch_code` varchar(255) DEFAULT NULL,
  `s_form_type` varchar(255) DEFAULT NULL,
  `e_record_type` enum('T','A','B','C','K') NOT NULL DEFAULT 'A',
  `i_payment_year` int(4) DEFAULT NULL,
  `i_cf_sf` tinyint(1) DEFAULT NULL COMMENT 'Combined Federal/\rState Filing Program',
  `s_payer_tin` int(20) DEFAULT NULL COMMENT 'Payer’s Taxpayer\rIdentification Number\r(TIN)',
  `s_type_of_return` varchar(2) DEFAULT NULL COMMENT 'Type of Return',
  `s_amount_codes` varchar(16) DEFAULT NULL COMMENT 'Amount Codes',
  `i_foreign_entity_indicator` tinyint(1) DEFAULT NULL COMMENT 'Foreign Entity\rIndicator',
  `s_first_payer_name_line` varchar(50) DEFAULT NULL COMMENT 'First Payer Name Line',
  `s_second_payer_name_line` varchar(50) DEFAULT NULL COMMENT 'Second Payer Name\r\nLine',
  `i_transfer_agent_indicator` tinyint(2) DEFAULT NULL COMMENT 'Transfer Agent\rIndicator',
  `s_payer_shipping_address` varchar(255) DEFAULT NULL COMMENT 'Payer Shipping Address',
  `s_payer_city` varchar(50) DEFAULT NULL COMMENT 'Payer City',
  `s_payer_state` varchar(20) DEFAULT NULL COMMENT 'Payer State',
  `s_payer_zip_code` varchar(10) DEFAULT NULL COMMENT 'Payer ZIP Code',
  `s_payers_telephone_number_and_extension` varchar(20) DEFAULT NULL COMMENT 'Payer’s Telephone\rNumber and\rExtension',
  `dt_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `i_status` tinyint(4) DEFAULT '1' COMMENT '0->Inactive, 1->Active, 2->Deleted',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_payer_info
-- ----------------------------
INSERT INTO `ams_payer_info` VALUES ('1', '100001', '1', 'A', '2015', null, '111111111', '4', null, null, 'ABC Company', 'ABC Company', null, '123 Some Street', 'Some City', 'ST', '123445', '8152264352', '2017-02-21 12:51:43', '1');
INSERT INTO `ams_payer_info` VALUES ('2', '100001', '1', 'A', '2015', null, '444444444', '4', null, null, 'ABC Company', 'ABC Company', null, '123 Some Street', 'Some City', 'ST', '123445', '8152264352', '2017-02-21 12:51:43', '1');
INSERT INTO `ams_payer_info` VALUES ('3', '100002', '1', 'A', '2015', null, '111111111', '4', null, null, 'ABC Company', 'ABC Company', null, '123 Some Street', 'Some City', 'ST', '123445', '8152264352', '2017-02-21 13:05:35', '1');
INSERT INTO `ams_payer_info` VALUES ('4', '100002', '1', 'A', '2015', null, '444444444', '4', null, null, 'ABC Company', 'ABC Company', null, '123 Some Street', 'Some City', 'ST', '123445', '8152264352', '2017-02-21 13:05:35', '1');
INSERT INTO `ams_payer_info` VALUES ('5', '100003', '1', 'A', '2015', null, '111111111', '4', null, null, 'ABC Company', 'ABC Company', null, '123 Some Street', 'Some City', 'ST', '123445', '8152264352', '2017-03-06 13:00:53', '1');
INSERT INTO `ams_payer_info` VALUES ('6', '100003', '1', 'A', '2015', null, '444444444', '4', null, null, 'ABC Company', 'ABC Company', null, '123 Some Street', 'Some City', 'ST', '123445', '8152264352', '2017-03-06 13:00:53', '1');
INSERT INTO `ams_payer_info` VALUES ('7', '100004', '1', 'A', '2015', null, '111111111', '4', null, null, 'ABC Company', 'ABC Company', null, '123 Some Street', 'Some City', 'ST', '123445', '8152264352', '2017-03-06 13:00:53', '1');
INSERT INTO `ams_payer_info` VALUES ('8', '100004', '1', 'A', '2015', null, '444444444', '4', null, null, 'ABC Company', 'ABC Company', null, '123 Some Street', 'Some City', 'ST', '123445', '8152264352', '2017-03-06 13:00:53', '1');
INSERT INTO `ams_payer_info` VALUES ('9', '100005', '1', 'A', '2015', null, '111111111', '4', null, null, 'ABC Company', 'ABC Company', null, '123 Some Street', 'Some City', 'ST', '123445', '8152264352', '2017-04-13 15:09:48', '1');
INSERT INTO `ams_payer_info` VALUES ('10', '100005', '1', 'A', '2015', null, '444444444', '4', null, null, 'ABC Company', 'ABC Company', null, '123 Some Street', 'Some City', 'ST', '123445', '8152264352', '2017-04-13 15:09:48', '1');

-- ----------------------------
-- Table structure for `ams_payment_history`
-- ----------------------------
DROP TABLE IF EXISTS `ams_payment_history`;
CREATE TABLE `ams_payment_history` (
  `i_id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `s_batch` varchar(255) NOT NULL,
  `s_transaction_id` varchar(255) DEFAULT NULL,
  `s_transaction_description` text,
  `d_amount` decimal(20,2) DEFAULT NULL,
  `s_user` varchar(255) DEFAULT NULL,
  `i_user_id` int(11) DEFAULT NULL,
  `dt_payment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(4) DEFAULT '1' COMMENT '1->Success, 2->Failed, 3->No response',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_payment_history
-- ----------------------------

-- ----------------------------
-- Table structure for `ams_payment_history_copy`
-- ----------------------------
DROP TABLE IF EXISTS `ams_payment_history_copy`;
CREATE TABLE `ams_payment_history_copy` (
  `i_id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `s_batch` varchar(255) NOT NULL,
  `s_transaction_id` varchar(255) DEFAULT NULL,
  `s_transaction_description` text,
  `d_amount` decimal(20,2) DEFAULT NULL,
  `s_user` varchar(255) DEFAULT NULL,
  `i_user_id` int(11) DEFAULT NULL,
  `dt_payment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(4) DEFAULT '1' COMMENT '1->Success, 2->Failed, 3->No response',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_payment_history_copy
-- ----------------------------
INSERT INTO `ams_payment_history_copy` VALUES ('1', '100001', '60019497583', 'This transaction has been approved.', '2.76', 'shieldwatch', '2', '2017-03-10 13:36:14', '1');

-- ----------------------------
-- Table structure for `ams_state`
-- ----------------------------
DROP TABLE IF EXISTS `ams_state`;
CREATE TABLE `ams_state` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_country_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `s_identification_no` varchar(255) DEFAULT NULL,
  `Code` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ADM1Code` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `i_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0->Inactive, 1->Active',
  `i_is_deleted` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0->No, 1->Yes',
  PRIMARY KEY (`i_id`),
  UNIQUE KEY `StateWithCountryId` (`name`,`i_country_id`),
  KEY `countryId` (`i_country_id`),
  KEY `state` (`name`),
  KEY `statusDeleted` (`i_status`,`i_is_deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_state
-- ----------------------------

-- ----------------------------
-- Table structure for `ams_user`
-- ----------------------------
DROP TABLE IF EXISTS `ams_user`;
CREATE TABLE `ams_user` (
  `i_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `s_first_name` varchar(255) DEFAULT NULL,
  `s_last_name` varchar(255) DEFAULT NULL,
  `s_user_name` varchar(255) DEFAULT NULL,
  `s_email` varchar(255) DEFAULT NULL,
  `s_password` varchar(255) DEFAULT NULL,
  `dt_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `s_avatar` varchar(255) DEFAULT NULL,
  `s_profile_image` varchar(255) DEFAULT NULL,
  `i_user_type` int(5) NOT NULL DEFAULT '5' COMMENT 'Primary id of the mp_admin_user_type table, \r\n1 => Has preserved for Dev only',
  `e_deleted` enum('Yes','No') DEFAULT 'No',
  `i_status` int(3) DEFAULT '1' COMMENT '1-> Active',
  `e_access_type` enum('default','customize') NOT NULL DEFAULT 'default',
  `s_customer_name` varchar(255) DEFAULT NULL,
  `s_company_name` varchar(255) DEFAULT NULL,
  `s_company_fein_number` varchar(255) DEFAULT NULL,
  `s_company_address` varchar(255) DEFAULT NULL,
  `s_company_state` varchar(255) DEFAULT NULL COMMENT 'PK i_id of mp_city table',
  `s_company_city` varchar(255) DEFAULT NULL,
  `s_company_zip` varchar(255) DEFAULT NULL,
  `s_company_phone` varchar(50) DEFAULT NULL,
  `i_sort_order` int(11) NOT NULL,
  `i_front_display` tinyint(4) DEFAULT '1' COMMENT '1->Yes, 0->No',
  `i_auto_email` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1->On, 2->Off',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='User Type comes from the mp_admin_user_type table';

-- ----------------------------
-- Records of ams_user
-- ----------------------------
INSERT INTO `ams_user` VALUES ('1', 'Shieldwatch', 'Admin', 'sys_admin', 'sys_admin@gmail.com', 'ebac15f0c2963985eb7794dbfa88ebae', '2015-05-26 12:05:39', 'northwatch150x185_1443547787.jpg', null, '1', 'No', '1', 'default', 'customer2', 'company', '1234321234', 'address', '0', null, '', '', '2', '0', '1');
INSERT INTO `ams_user` VALUES ('2', 'Mrinmoy', 'Mondal', 'shieldwatch', 'mmondal@codeuridea.com', '9beac2e4c0f847a4f752a1036e08f194', '2015-05-26 12:05:39', '', '', '5', 'No', '1', 'default', 'Mrinmoy Mondal', 'shieldwatch', '1234321234', 'test', '28886', '', '95662', '', '1', '0', '1');
INSERT INTO `ams_user` VALUES ('3', 'Jagannath', 'Samanta', 'ban2demo@gmail.com', 'ban2demo@gmail.com', '350a6fc11cc411ca3043551484682444', '2016-10-12 15:25:32', null, null, '5', 'No', '1', 'default', 'Jagannath Samanta', 'shieldwatch', '123456', 'test', '', '', '', '', '3', '1', '1');
INSERT INTO `ams_user` VALUES ('4', 'mrinmoy', 'mondal', 'testsd1', 'test_user@gmail.com', '146310f3cae21f412b3f733a8b970e79', '2017-06-16 17:57:22', null, null, '5', 'No', '1', 'default', 'mrinmoy mondal', 'shieldwatch', 'ss', 'test', null, null, null, null, '4', '1', '2');
INSERT INTO `ams_user` VALUES ('6', 'Mrinmoy', 'Mondal', 'mrinsss1@gmail.com', 'mrinsss1@gmail.com', 'ebac15f0c2963985eb7794dbfa88ebae', '2017-08-17 16:09:44', null, null, '2', 'No', '1', 'default', null, 'SWIPL', null, 'SWIPL', null, null, null, null, '5', '1', '1');
INSERT INTO `ams_user` VALUES ('7', 'Mrinmoy', 'Mondal', 'mrinsss@gmail.com', 'mrinsss@gmail.com', 'ebac15f0c2963985eb7794dbfa88ebae', '2017-08-17 20:15:23', null, null, '3', 'No', '1', 'default', null, 'SWIPL', null, 'kolkata', null, null, null, null, '6', '1', '1');

-- ----------------------------
-- Table structure for `ams_user_forms_paid_count`
-- ----------------------------
DROP TABLE IF EXISTS `ams_user_forms_paid_count`;
CREATE TABLE `ams_user_forms_paid_count` (
  `i_id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `s_batch_id` varchar(250) DEFAULT NULL,
  `s_user` varchar(255) DEFAULT NULL,
  `i_user_id` int(11) DEFAULT NULL,
  `i_filling_type` tinyint(2) DEFAULT '1' COMMENT '1->E-fill, 2->Print',
  `s_form_type` varchar(10) DEFAULT '1' COMMENT 'like 1->1099,2->w2, 3->941 etc',
  `i_forms_no` int(10) DEFAULT NULL,
  `dt_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(4) DEFAULT '1' COMMENT '1->Active, 0->Inactive',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_user_forms_paid_count
-- ----------------------------
INSERT INTO `ams_user_forms_paid_count` VALUES ('1', '100001', 'shieldwatch', '2', '1', '1', '4', '2017-02-21 12:51:43', '1');
INSERT INTO `ams_user_forms_paid_count` VALUES ('2', '100002', 'shieldwatch', '2', '1', '1', '4', '2017-02-21 13:05:35', '1');
INSERT INTO `ams_user_forms_paid_count` VALUES ('3', '100003', 'shieldwatch', '2', '1', '1', '4', '2017-03-06 13:00:53', '1');
INSERT INTO `ams_user_forms_paid_count` VALUES ('4', '100004', 'shieldwatch', '2', '1', '1', '4', '2017-03-06 13:00:53', '1');
INSERT INTO `ams_user_forms_paid_count` VALUES ('5', '100005', 'shieldwatch', '2', '1', '1', '4', '2017-04-13 15:09:48', '1');

-- ----------------------------
-- Table structure for `ams_user_menu`
-- ----------------------------
DROP TABLE IF EXISTS `ams_user_menu`;
CREATE TABLE `ams_user_menu` (
  `i_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `i_menu_id` int(10) unsigned NOT NULL COMMENT 'Main Menu table primary id ',
  `i_parent_id` int(10) NOT NULL DEFAULT '0',
  `i_user_id` bigint(20) unsigned NOT NULL,
  `i_role_id` int(3) NOT NULL,
  `s_set_of_action` varchar(1000) DEFAULT NULL,
  `s_set_of_menu` varchar(1000) DEFAULT NULL,
  `dt_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=260 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_user_menu
-- ----------------------------
INSERT INTO `ams_user_menu` VALUES ('111', '2', '1', '3', '2', '\'View List\'', null, '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('112', '3', '1', '3', '2', '\'Edit\'', 'my_account/modify_information/', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('113', '4', '1', '3', '2', '\'Edit\'', 'site_setting/modify_information/', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('114', '15', '1', '3', '2', '\'Edit\'', 'email_template/modify_information/', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('115', '6', '5', '3', '2', '\'View List\',\'Add\',\'Edit\',\'Delete\'', 'user_type_master/show_list/,user_type_master/add_information/,user_type_master/modify_information/,user_type_master/remove_information/', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('116', '7', '5', '3', '2', '\'View List\',\'Add\',\'Edit\',\'Delete\'', 'manage_admin_user/show_list/,manage_admin_user/add_information/,manage_admin_user/modify_information/,manage_admin_user/remove_information/', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('117', '12', '11', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('118', '13', '11', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('119', '16', '14', '3', '2', '\'View List\',\'Add\',\'Edit\',\'Delete\'', 'country/show_list/,country/add_information/,country/modify_information/,country/remove_information/', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('120', '17', '14', '3', '2', '\'View List\',\'Add\',\'Edit\',\'Delete\'', 'state/show_list/,state/add_information/,state/modify_information/,state/remove_information/', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('121', '19', '14', '3', '2', '\'View List\',\'Add\'', 'category/show_list/,category/add_information/', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('122', '20', '14', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('123', '21', '14', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('124', '22', '14', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('125', '23', '14', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('126', '24', '14', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('127', '25', '14', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('128', '26', '14', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('129', '27', '14', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('130', '28', '14', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('131', '29', '14', '3', '2', '', '', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('132', '30', '14', '3', '2', '\'View List\',\'Add\',\'Edit\'', 'naics/show_list/,naics/add_information/,naics/modify_information/', '2015-06-15 13:44:16');
INSERT INTO `ams_user_menu` VALUES ('226', '2', '1', '5', '5', '', '', '2015-08-18 14:58:29');
INSERT INTO `ams_user_menu` VALUES ('227', '3', '1', '5', '5', '', '', '2015-08-18 14:57:44');
INSERT INTO `ams_user_menu` VALUES ('228', '4', '1', '5', '5', '', '', '2015-08-18 14:57:45');
INSERT INTO `ams_user_menu` VALUES ('229', '15', '1', '5', '5', '', '', '2015-08-18 14:57:45');
INSERT INTO `ams_user_menu` VALUES ('230', '33', '1', '5', '5', '\'View List\',\'Add\',\'Edit\',\'Delete\'', 'region/show_list/,region/add_information/,region/modify_information/,region/remove_information/', '2015-08-18 14:57:45');
INSERT INTO `ams_user_menu` VALUES ('231', '31', '1', '5', '5', '', '', '2015-08-18 14:57:46');
INSERT INTO `ams_user_menu` VALUES ('232', '35', '1', '5', '5', '', '', '2015-08-18 14:57:46');
INSERT INTO `ams_user_menu` VALUES ('233', '6', '5', '5', '5', '', '', '2015-08-18 14:57:47');
INSERT INTO `ams_user_menu` VALUES ('234', '7', '5', '5', '5', '', '', '2015-08-18 14:57:47');
INSERT INTO `ams_user_menu` VALUES ('235', '40', '39', '5', '5', '', '', '2015-08-18 14:57:48');
INSERT INTO `ams_user_menu` VALUES ('236', '41', '39', '5', '5', '', '', '2015-08-18 14:57:48');
INSERT INTO `ams_user_menu` VALUES ('237', '37', '36', '5', '5', '\'View List\',\'Add\',\'Edit\',\'Delete\'', 'region/team_list/,region/add_team/,region/edit_team/,region/delete_team/', '2015-08-18 14:57:49');
INSERT INTO `ams_user_menu` VALUES ('238', '38', '36', '5', '5', '', '', '2015-08-18 14:57:49');
INSERT INTO `ams_user_menu` VALUES ('239', '16', '14', '5', '5', '', '', '2015-08-18 14:57:49');
INSERT INTO `ams_user_menu` VALUES ('240', '17', '14', '5', '5', '', '', '2015-08-18 14:57:50');
INSERT INTO `ams_user_menu` VALUES ('241', '20', '14', '5', '5', '', '', '2015-08-18 14:57:50');
INSERT INTO `ams_user_menu` VALUES ('242', '19', '14', '5', '5', '', '', '2015-08-18 14:57:51');
INSERT INTO `ams_user_menu` VALUES ('243', '21', '14', '5', '5', '', '', '2015-08-18 14:57:51');
INSERT INTO `ams_user_menu` VALUES ('244', '22', '14', '5', '5', '', '', '2015-08-18 14:57:52');
INSERT INTO `ams_user_menu` VALUES ('245', '23', '14', '5', '5', '', '', '2015-08-18 14:57:52');
INSERT INTO `ams_user_menu` VALUES ('246', '24', '14', '5', '5', '', '', '2015-08-18 14:57:52');
INSERT INTO `ams_user_menu` VALUES ('247', '25', '14', '5', '5', '', '', '2015-08-18 14:57:53');
INSERT INTO `ams_user_menu` VALUES ('248', '26', '14', '5', '5', '', '', '2015-08-18 14:57:53');
INSERT INTO `ams_user_menu` VALUES ('249', '27', '14', '5', '5', '', '', '2015-08-18 14:57:54');
INSERT INTO `ams_user_menu` VALUES ('250', '28', '14', '5', '5', '', '', '2015-08-18 14:57:54');
INSERT INTO `ams_user_menu` VALUES ('251', '29', '14', '5', '5', '', '', '2015-08-18 14:57:54');
INSERT INTO `ams_user_menu` VALUES ('252', '30', '14', '5', '5', '', '', '2015-08-18 14:57:55');
INSERT INTO `ams_user_menu` VALUES ('253', '0', '0', '0', '5', null, null, '2015-08-18 14:57:56');
INSERT INTO `ams_user_menu` VALUES ('259', '0', '0', '0', '14', null, null, '2015-08-18 14:58:20');

-- ----------------------------
-- Table structure for `ams_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `ams_user_role`;
CREATE TABLE `ams_user_role` (
  `i_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `i_region_id` int(11) unsigned DEFAULT NULL,
  `i_franchise_id` int(11) DEFAULT NULL,
  `i_user_id` bigint(20) unsigned NOT NULL,
  `i_role_id` int(5) NOT NULL COMMENT 'Generally it will be user type id',
  `dt_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `i_created_by` bigint(20) unsigned DEFAULT NULL,
  `i_creator_user_type_id` int(5) DEFAULT NULL,
  `e_access_type` enum('default','customize') NOT NULL DEFAULT 'default',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_user_role
-- ----------------------------
INSERT INTO `ams_user_role` VALUES ('1', '0', '0', '1', '1', '2016-06-03 15:23:57', '1', '1', 'default');

-- ----------------------------
-- Table structure for `ams_zipcode`
-- ----------------------------
DROP TABLE IF EXISTS `ams_zipcode`;
CREATE TABLE `ams_zipcode` (
  `id` bigint(30) NOT NULL AUTO_INCREMENT,
  `postal_code` varchar(255) CHARACTER SET latin1 NOT NULL,
  `city_id` bigint(20) NOT NULL,
  `state_id` bigint(30) NOT NULL,
  `country_id` int(5) NOT NULL,
  `latitude` varchar(255) CHARACTER SET latin1 NOT NULL,
  `longitude` varchar(255) CHARACTER SET latin1 NOT NULL,
  `i_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1->Active,2->Inactive',
  `i_is_deleted` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `CountryStateCityZip` (`country_id`,`state_id`,`city_id`,`postal_code`) USING BTREE,
  KEY `postalCode` (`postal_code`) USING BTREE,
  KEY `Statuss` (`i_status`) USING BTREE,
  KEY `state_id_city_id` (`state_id`,`city_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_zipcode
-- ----------------------------

-- ----------------------------
-- Table structure for `oauth_consumer_registry`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_consumer_registry`;
CREATE TABLE `oauth_consumer_registry` (
  `ocr_id` int(11) NOT NULL AUTO_INCREMENT,
  `ocr_usa_id_ref` int(11) DEFAULT NULL,
  `ocr_consumer_key` varchar(128) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `ocr_consumer_secret` varchar(128) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `ocr_signature_methods` varchar(255) NOT NULL DEFAULT 'HMAC-SHA1,PLAINTEXT',
  `ocr_server_uri` varchar(255) NOT NULL,
  `ocr_server_uri_host` varchar(128) NOT NULL,
  `ocr_server_uri_path` varchar(128) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `ocr_request_token_uri` varchar(255) NOT NULL,
  `ocr_authorize_uri` varchar(255) NOT NULL,
  `ocr_access_token_uri` varchar(255) NOT NULL,
  `ocr_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ocr_id`),
  UNIQUE KEY `ocr_consumer_key` (`ocr_consumer_key`,`ocr_usa_id_ref`,`ocr_server_uri`),
  KEY `ocr_server_uri` (`ocr_server_uri`),
  KEY `ocr_server_uri_host` (`ocr_server_uri_host`,`ocr_server_uri_path`),
  KEY `ocr_usa_id_ref` (`ocr_usa_id_ref`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of oauth_consumer_registry
-- ----------------------------
INSERT INTO `oauth_consumer_registry` VALUES ('5', '3', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f24d93848aed0950d49d89af81b7834c', 'HMAC-SHA1,PLAINTEXT', 'http://192.168.1.38/ams_oauth/', '192.168.1.38', '/ams_oauth/', 'http://192.168.1.38/ams_oauth/server-call/oauth-secure/request-token', 'http://192.168.1.38/ams_oauth/server-call/oauth-secure/verify-authorization', 'http://192.168.1.38/ams_oauth/server-call/oauth-secure/access-token', '2016-07-13 13:40:01');

-- ----------------------------
-- Table structure for `oauth_consumer_token`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_consumer_token`;
CREATE TABLE `oauth_consumer_token` (
  `oct_id` int(11) NOT NULL AUTO_INCREMENT,
  `oct_ocr_id_ref` int(11) NOT NULL,
  `oct_usa_id_ref` int(11) NOT NULL,
  `oct_name` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `oct_token` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `oct_token_secret` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `oct_token_type` enum('request','authorized','access') DEFAULT NULL,
  `oct_token_ttl` datetime NOT NULL DEFAULT '9999-12-31 00:00:00',
  `oct_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`oct_id`),
  UNIQUE KEY `oct_ocr_id_ref` (`oct_ocr_id_ref`,`oct_token`),
  UNIQUE KEY `oct_usa_id_ref` (`oct_usa_id_ref`,`oct_ocr_id_ref`,`oct_token_type`,`oct_name`),
  KEY `oct_token_ttl` (`oct_token_ttl`),
  CONSTRAINT `oauth_consumer_token_ibfk_1` FOREIGN KEY (`oct_ocr_id_ref`) REFERENCES `oauth_consumer_registry` (`ocr_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of oauth_consumer_token
-- ----------------------------
INSERT INTO `oauth_consumer_token` VALUES ('71', '5', '3', '', '0a2f5fb3541d92d41e8e3e6a95f0a385057ab095a', '76efcb88746b744a0a650bfed1536ef8', 'access', '9999-12-31 00:00:00', '2016-08-10 16:30:42');

-- ----------------------------
-- Table structure for `oauth_log`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_log`;
CREATE TABLE `oauth_log` (
  `olg_id` int(11) NOT NULL AUTO_INCREMENT,
  `olg_osr_consumer_key` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `olg_ost_token` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `olg_ocr_consumer_key` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `olg_oct_token` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `olg_usa_id_ref` int(11) DEFAULT NULL,
  `olg_received` text NOT NULL,
  `olg_sent` text NOT NULL,
  `olg_base_string` text NOT NULL,
  `olg_notes` text NOT NULL,
  `olg_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `olg_remote_ip` bigint(20) NOT NULL,
  PRIMARY KEY (`olg_id`),
  KEY `olg_osr_consumer_key` (`olg_osr_consumer_key`,`olg_id`),
  KEY `olg_ost_token` (`olg_ost_token`,`olg_id`),
  KEY `olg_ocr_consumer_key` (`olg_ocr_consumer_key`,`olg_id`),
  KEY `olg_oct_token` (`olg_oct_token`,`olg_id`),
  KEY `olg_usa_id_ref` (`olg_usa_id_ref`,`olg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of oauth_log
-- ----------------------------

-- ----------------------------
-- Table structure for `oauth_server_nonce`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_server_nonce`;
CREATE TABLE `oauth_server_nonce` (
  `osn_id` int(11) NOT NULL AUTO_INCREMENT,
  `osn_consumer_key` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `osn_token` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `osn_timestamp` bigint(20) NOT NULL,
  `osn_nonce` varchar(80) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`osn_id`),
  UNIQUE KEY `osn_consumer_key` (`osn_consumer_key`,`osn_token`,`osn_timestamp`,`osn_nonce`)
) ENGINE=InnoDB AUTO_INCREMENT=1056 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of oauth_server_nonce
-- ----------------------------
INSERT INTO `oauth_server_nonce` VALUES ('1054', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0', '1470826841', '57ab095948fa1');
INSERT INTO `oauth_server_nonce` VALUES ('154', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '004d90f564f41f224258e4f4ffe2463205788902d', '1468567598', '5788902e1c578');
INSERT INTO `oauth_server_nonce` VALUES ('31', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '008b1a491eae7d13de2c9ce7c1ee67f0057861047', '1468403784', '5786104813ebd');
INSERT INTO `oauth_server_nonce` VALUES ('627', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '01b8eeb0dc332c4a322cfb9ce16f90d30578cbddc', '1468841437', '578cbddd110d7');
INSERT INTO `oauth_server_nonce` VALUES ('212', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0237462e454a71620261025c6e94b4e4057889c23', '1468570659', '57889c2355da0');
INSERT INTO `oauth_server_nonce` VALUES ('101', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '02758dd2f866d91bf772fc0b5aa6d3a30578886c6', '1468565191', '578886c701800');
INSERT INTO `oauth_server_nonce` VALUES ('305', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '02f861ecb3279934f3826c8f76c8134705788cd20', '1468583201', '5788cd2177486');
INSERT INTO `oauth_server_nonce` VALUES ('660', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '034a89d080ab04ab0aa5d4db2e9f63d10578df482', '1468920963', '578df48389b98');
INSERT INTO `oauth_server_nonce` VALUES ('117', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '03f7967ce958c9f85d562739797b58810578887e0', '1468565472', '578887e060836');
INSERT INTO `oauth_server_nonce` VALUES ('841', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0451106867b21344a5be36e106c6c41e057973429', '1469527081', '57973429b8f56');
INSERT INTO `oauth_server_nonce` VALUES ('327', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '05e889a282b7773f57974ed21f206b1005788d8a2', '1468586146', '5788d8a2e0444');
INSERT INTO `oauth_server_nonce` VALUES ('143', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '05f3e49183dd11b40bedcb6c3392e247057888b51', '1468566354', '57888b52083c5');
INSERT INTO `oauth_server_nonce` VALUES ('412', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '07650db234e127d5888d2fb8c068d36c0578c8372', '1468826482', '578c83727705f');
INSERT INTO `oauth_server_nonce` VALUES ('704', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '09c95788c989faba2a913b4334bc783e057905ec7', '1469079239', '57905ec7d91c9');
INSERT INTO `oauth_server_nonce` VALUES ('226', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '09d44238f2deea9496501fae7a7d51c705788a81f', '1468573728', '5788a82022105');
INSERT INTO `oauth_server_nonce` VALUES ('406', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0a5588c5046f31cfdd8e01695bdeeb220578c8174', '1468825973', '578c817509659');
INSERT INTO `oauth_server_nonce` VALUES ('567', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0aa1bb93aff7c2eb7537be1ec22b293a0578c8e95', '1468829333', '578c8e9578c73');
INSERT INTO `oauth_server_nonce` VALUES ('343', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0ad4a07416d835bd0edc9c9527fab6f405788da13', '1468586515', '5788da133a602');
INSERT INTO `oauth_server_nonce` VALUES ('571', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0aeb377f980dc054ef3a57af3ab784ca0578c8eb1', '1468829362', '578c8eb236d3f');
INSERT INTO `oauth_server_nonce` VALUES ('981', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0bc9911fb900f29746d6558c0c8d930005797591c', '1469536540', '5797591c6d49a');
INSERT INTO `oauth_server_nonce` VALUES ('520', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0c372dabc06afadef52996780ea044cd0578c8d2c', '1468828972', '578c8d2cdd942');
INSERT INTO `oauth_server_nonce` VALUES ('944', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0ca153167e9aadc719384bf8934ab23c0579753ce', '1469535182', '579753cebf236');
INSERT INTO `oauth_server_nonce` VALUES ('619', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0cccb5d42279e8edfe6e1b5e70d936530578cbd52', '1468841299', '578cbd534ef01');
INSERT INTO `oauth_server_nonce` VALUES ('790', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0dcf3c2977c28d479fc43f5609ea1a16057971c66', '1469520998', '57971c669ed35');
INSERT INTO `oauth_server_nonce` VALUES ('85', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '0f44e1df016fb89c8b1d25bee7b33a8605788863f', '1468565055', '5788863fc340c');
INSERT INTO `oauth_server_nonce` VALUES ('43', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '10da0a5f01b820e1f891964d34b911d9057862762', '1468409698', '57862762c9f27');
INSERT INTO `oauth_server_nonce` VALUES ('398', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '10f5101470d6f8e673f0ed0f5a7f5a350578c810a', '1468825867', '578c810b92647');
INSERT INTO `oauth_server_nonce` VALUES ('601', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '11a8789fa06bddb74a780c16ec562d190578c920e', '1468830222', '578c920e9c573');
INSERT INTO `oauth_server_nonce` VALUES ('623', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '132cd3b2a403795431252247b01d63c00578cbdbb', '1468841403', '578cbdbbe30a8');
INSERT INTO `oauth_server_nonce` VALUES ('621', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '15477d5845a73c35485a0c16808327660578cbdaf', '1468841391', '578cbdafddd09');
INSERT INTO `oauth_server_nonce` VALUES ('906', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '15d5c32c31d468abb9bbfa3f5e65e112057974bd9', '1469533145', '57974bd9a96fd');
INSERT INTO `oauth_server_nonce` VALUES ('408', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '16e52708b1c40949007747f2ba2dee4b0578c82aa', '1468826282', '578c82aa90385');
INSERT INTO `oauth_server_nonce` VALUES ('463', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '17ecb1f432781c4c4cde3a0bd56501420578c8a27', '1468828200', '578c8a282b4e2');
INSERT INTO `oauth_server_nonce` VALUES ('581', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '183bd68105916a45c9adde6e7507485a0578c8fa1', '1468829601', '578c8fa1c92da');
INSERT INTO `oauth_server_nonce` VALUES ('710', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '18429883fe6d230bbda1e080b36f510c0579062e2', '1469080290', '579062e2baa3a');
INSERT INTO `oauth_server_nonce` VALUES ('59', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '198337ed2d946922838e34329f6907ae057878c37', '1468501048', '57878c38b4d1c');
INSERT INTO `oauth_server_nonce` VALUES ('280', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '1a923ad87486e54e72d54982af62dd9005788ae56', '1468575318', '5788ae5654bbe');
INSERT INTO `oauth_server_nonce` VALUES ('686', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '1c13bdbd09e487c870c8a307373170990578f8b01', '1469025025', '578f8b01e145e');
INSERT INTO `oauth_server_nonce` VALUES ('131', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '1c8979d6cf08b20dc21fb1625ef73de10578889c8', '1468565960', '578889c893a20');
INSERT INTO `oauth_server_nonce` VALUES ('595', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '1c909d9ee2d4b822c14bf46432f1ef530578c9017', '1468829719', '578c90178d50f');
INSERT INTO `oauth_server_nonce` VALUES ('307', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '1ec7216afc52f61bc7181a44df513f4605788d070', '1468584048', '5788d070bca86');
INSERT INTO `oauth_server_nonce` VALUES ('803', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '1f91fd2e7d7303a5e70a0d905433cd0405797205b', '1469522011', '5797205b94a99');
INSERT INTO `oauth_server_nonce` VALUES ('89', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '20154340dfc9eaeb49a93608688d4daf057888648', '1468565064', '57888648c96a0');
INSERT INTO `oauth_server_nonce` VALUES ('809', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2039d1d72126dae9343e940ba1bb100e0579720f6', '1469522167', '579720f715d49');
INSERT INTO `oauth_server_nonce` VALUES ('641', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '204cb7e6ed4b41e6f9b4a61525181d1a0578cbe96', '1468841622', '578cbe96f3eb5');
INSERT INTO `oauth_server_nonce` VALUES ('75', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2097a48d0a94248225d5d979426481200578885c1', '1468564930', '578885c20cb8c');
INSERT INTO `oauth_server_nonce` VALUES ('690', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2119abf02d3b04cc079561bc3492ef910578f8b37', '1469025079', '578f8b37eeb25');
INSERT INTO `oauth_server_nonce` VALUES ('615', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '21487e200984b3e35a65fbf027b882b50578cbbf2', '1468840946', '578cbbf280618');
INSERT INTO `oauth_server_nonce` VALUES ('843', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '21950e0439537473f57ceaa12f5393f4057973444', '1469527108', '57973444c25f7');
INSERT INTO `oauth_server_nonce` VALUES ('29', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '21aab09f1a8f5c1b522f3dbc35f09ba1057860f27', '1468403496', '57860f2805f0e');
INSERT INTO `oauth_server_nonce` VALUES ('335', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '21ad14d3ff5d096e42afb9939c52328005788d965', '1468586342', '5788d9661a702');
INSERT INTO `oauth_server_nonce` VALUES ('522', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '21db75d8cea8039b1e563c97bf13ceb80578c8d2d', '1468828973', '578c8d2d849ac');
INSERT INTO `oauth_server_nonce` VALUES ('930', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '221e981e57eaf45bd933113ec4d8f1550579751b1', '1469534641', '579751b1e1d78');
INSERT INTO `oauth_server_nonce` VALUES ('565', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2351633879a6eae3c116651410e11e420578c8e80', '1468829312', '578c8e80b3a66');
INSERT INTO `oauth_server_nonce` VALUES ('37', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '260e7c2551abbeed393dcfeeccdcf62d05786263d', '1468409405', '5786263d8ed79');
INSERT INTO `oauth_server_nonce` VALUES ('1053', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '260f87621bcdb732561daefb431bb660057988c83', '1469615235', '57988c83b8d28');
INSERT INTO `oauth_server_nonce` VALUES ('678', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '26fc1769f71bdda77f5d79c94d73e6ed0578f7501', '1469019393', '578f7501e2486');
INSERT INTO `oauth_server_nonce` VALUES ('221', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2749f332c6394ff27bf3c921f07da7f105788a7f3', '1468573684', '5788a7f457f1f');
INSERT INTO `oauth_server_nonce` VALUES ('938', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '27dd24c1b1b702095251f22f6c77ff5105797526c', '1469534828', '5797526c8ed8d');
INSERT INTO `oauth_server_nonce` VALUES ('181', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2824882238abde14286c96144a2533660578897ac', '1468569517', '578897ad1bb9b');
INSERT INTO `oauth_server_nonce` VALUES ('551', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '29724cb4635be8f5e8d8806be771c7e50578c8e28', '1468829225', '578c8e2909eeb');
INSERT INTO `oauth_server_nonce` VALUES ('318', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2c8a69786fc5d6862a5293a729c79d0a05788d1a4', '1468584356', '5788d1a4c63c5');
INSERT INTO `oauth_server_nonce` VALUES ('125', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2e0589e3594513ef7038b37f5add24470578888de', '1468565726', '578888dec5e73');
INSERT INTO `oauth_server_nonce` VALUES ('278', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2e6969782fcebae16e5b9c5eb323499f05788ae41', '1468575297', '5788ae415ec50');
INSERT INTO `oauth_server_nonce` VALUES ('360', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2ee15a7b9b4a35e3db6194f1c79df89105788dc58', '1468587096', '5788dc58f3e8f');
INSERT INTO `oauth_server_nonce` VALUES ('533', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2efdd1ae4a663d78cabe0b3902b607cc0578c8dd3', '1468829140', '578c8dd41eb48');
INSERT INTO `oauth_server_nonce` VALUES ('549', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2f156aa4fe7388ace60d400d367261880578c8e21', '1468829217', '578c8e21be641');
INSERT INTO `oauth_server_nonce` VALUES ('467', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '2faf923a2d0168fb375308e40c8b0aa30578c8ada', '1468828378', '578c8ada541ef');
INSERT INTO `oauth_server_nonce` VALUES ('977', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '31aa64102809a301611b529377f81e5d0579758af', '1469536431', '579758af8e26b');
INSERT INTO `oauth_server_nonce` VALUES ('453', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '31d628fb9eeb0a008008519a745f65c20578c89b0', '1468828080', '578c89b0a0fd4');
INSERT INTO `oauth_server_nonce` VALUES ('288', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '33f01d9b46f7f1250e560ab735336ca805788af5a', '1468575579', '5788af5baf26b');
INSERT INTO `oauth_server_nonce` VALUES ('390', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '33f5878eee0ac22e711979e226a778a60578c809e', '1468825758', '578c809e747ef');
INSERT INTO `oauth_server_nonce` VALUES ('441', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3514531853b0cce1b039ae407851ec010578c86fc', '1468827388', '578c86fcd41d0');
INSERT INTO `oauth_server_nonce` VALUES ('830', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '35446dd1593a9badfe745eb7a703967b057972ebe', '1469525695', '57972ebf24f97');
INSERT INTO `oauth_server_nonce` VALUES ('55', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '35df2f90e815200f3c57825efd187ee3057864362', '1468416866', '57864362c8e9e');
INSERT INTO `oauth_server_nonce` VALUES ('362', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3696e34b0c8b80ca53b58864f9117f5705788dc59', '1468587097', '5788dc59eca2c');
INSERT INTO `oauth_server_nonce` VALUES ('268', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '36c94e7d406ad3fce39814cd9489855905788ab35', '1468574517', '5788ab35c5468');
INSERT INTO `oauth_server_nonce` VALUES ('516', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '371cb93650b6416dddaa8a5b35fda5950578c8d20', '1468828960', '578c8d20e38df');
INSERT INTO `oauth_server_nonce` VALUES ('353', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '37b88f40f12a91e75fea58b79e7af6ad05788dbdc', '1468586973', '5788dbdd1f354');
INSERT INTO `oauth_server_nonce` VALUES ('589', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '396cd77c10e7c2ccd11597686da100d80578c8fe1', '1468829665', '578c8fe1c8b78');
INSERT INTO `oauth_server_nonce` VALUES ('702', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3975d48d6b66390c357743e81ad16cce057905e60', '1469079136', '57905e6070f30');
INSERT INTO `oauth_server_nonce` VALUES ('649', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3a5f89fc1b13033313be472b4c0060650578df01a', '1468919835', '578df01bc078b');
INSERT INTO `oauth_server_nonce` VALUES ('502', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3ac15baa0038c65d9847300a3b571d800578c8bf6', '1468828663', '578c8bf71fcf3');
INSERT INTO `oauth_server_nonce` VALUES ('171', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3baab7d5bf6c9dd6f554154f88f1069205788969c', '1468569244', '5788969c88bab');
INSERT INTO `oauth_server_nonce` VALUES ('316', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3c6f1ccef2a0503b2aee8391568cca2e05788d1a3', '1468584355', '5788d1a35edb6');
INSERT INTO `oauth_server_nonce` VALUES ('698', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3c9cd5e8460b0c5b4e9e84ebd10ceda8057904b1d', '1469074205', '57904b1dd06ec');
INSERT INTO `oauth_server_nonce` VALUES ('175', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3d9ce775466090486070eb0e8a43f7360578896f9', '1468569338', '578896fa3b2f5');
INSERT INTO `oauth_server_nonce` VALUES ('561', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3dcf6caadc5148609bbc135a35a6e5c40578c8e5b', '1468829276', '578c8e5c34c60');
INSERT INTO `oauth_server_nonce` VALUES ('781', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3e06bcf0af00ec3c98aa8f0552fe95300579713d3', '1469518803', '579713d3be88a');
INSERT INTO `oauth_server_nonce` VALUES ('297', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3e67a71c1d07c275d8e4ef1e8a5176f705788c8a1', '1468582050', '5788c8a253ca0');
INSERT INTO `oauth_server_nonce` VALUES ('266', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3eb022e6bd90f90728896bc3f806cd5505788ab15', '1468574485', '5788ab1573ecf');
INSERT INTO `oauth_server_nonce` VALUES ('437', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3f93b820a38f2a78943436f12f4b70800578c86d1', '1468827345', '578c86d1bee6c');
INSERT INTO `oauth_server_nonce` VALUES ('323', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '3fd699b6944ba88529650997e6c5e6ad05788d86c', '1468586092', '5788d86c44df0');
INSERT INTO `oauth_server_nonce` VALUES ('708', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4013c0a054e52805052d25c5154e9b2a0579061f0', '1469080048', '579061f0997d9');
INSERT INTO `oauth_server_nonce` VALUES ('926', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '408e383412459d87b619bf40af796850057975113', '1469534483', '57975113423d5');
INSERT INTO `oauth_server_nonce` VALUES ('173', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '40a65238133e5c5fe6eacf9cf5ede65f05788969c', '1468569245', '5788969d4e057');
INSERT INTO `oauth_server_nonce` VALUES ('99', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '40eeb26787edbb4c4b8fb5db03c7c8590578886c0', '1468565184', '578886c088dd0');
INSERT INTO `oauth_server_nonce` VALUES ('370', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4108530c8153b8af8cdbe41f15bb3ce205788ddd4', '1468587477', '5788ddd5180ec');
INSERT INTO `oauth_server_nonce` VALUES ('376', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '414321aab264dbf9a60d8d97ea54bfab05788f40f', '1468593167', '5788f40f5670c');
INSERT INTO `oauth_server_nonce` VALUES ('264', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '41814c291e555dc1acabb68cd72615d305788ab10', '1468574480', '5788ab1076709');
INSERT INTO `oauth_server_nonce` VALUES ('474', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '41dbc03fa129cbac4ead268f950425490578c8af5', '1468828405', '578c8af55826e');
INSERT INTO `oauth_server_nonce` VALUES ('244', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '41ea900e15a6c9f8fae746e49483154205788a908', '1468573961', '5788a90902e8a');
INSERT INTO `oauth_server_nonce` VALUES ('404', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '422468cdcedf2f5c0835fee4c7eb203c0578c8173', '1468825972', '578c817426abb');
INSERT INTO `oauth_server_nonce` VALUES ('410', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '43f90f9aefd26407db1a2f3493d4e4210578c82aa', '1468826283', '578c82ab88e11');
INSERT INTO `oauth_server_nonce` VALUES ('664', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '44028b9251988d8e958331e40cab0d270578dff89', '1468923785', '578dff89af916');
INSERT INTO `oauth_server_nonce` VALUES ('539', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '442c4abc94c429c580c4de07f45c07fb0578c8e06', '1468829191', '578c8e071a9ad');
INSERT INTO `oauth_server_nonce` VALUES ('240', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '44c4406cbf08ef05bb4c198b559ad7c105788a8e9', '1468573929', '5788a8e9d705e');
INSERT INTO `oauth_server_nonce` VALUES ('469', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '454b20b3e8c06016b87a64f5217ba3950578c8ae8', '1468828392', '578c8ae88bda2');
INSERT INTO `oauth_server_nonce` VALUES ('807', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '458c7bd6d46f90700e32155b7af142b80579720a9', '1469522089', '579720a97115c');
INSERT INTO `oauth_server_nonce` VALUES ('388', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '463d5dcb89570da8e9cb93f3642797760578c8005', '1468825605', '578c8005b4493');
INSERT INTO `oauth_server_nonce` VALUES ('417', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4936aa31602375d56b590f686e3f25720578c83f3', '1468826611', '578c83f394255');
INSERT INTO `oauth_server_nonce` VALUES ('195', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4980259c1d0ce98c265e84dbd5b7a532057889873', '1468569716', '5788987414cfa');
INSERT INTO `oauth_server_nonce` VALUES ('779', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '49a86417e7f00bf17ac1dad748aa34ff0579713ba', '1469518779', '579713bb1da6b');
INSERT INTO `oauth_server_nonce` VALUES ('498', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '49f7f4ce564382b0f3ade4f2f0483ed10578c8bc0', '1468828609', '578c8bc14354a');
INSERT INTO `oauth_server_nonce` VALUES ('952', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4a16a51609d58e21bc28bf9ee2075f800579754a9', '1469535401', '579754a9c791c');
INSERT INTO `oauth_server_nonce` VALUES ('934', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4aee019e7143a303875259bac15cdeac05797523c', '1469534781', '5797523d2b2e2');
INSERT INTO `oauth_server_nonce` VALUES ('53', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4bec7d6ee188310f53b19838990ad60a0578639b0', '1468414384', '578639b0ee451');
INSERT INTO `oauth_server_nonce` VALUES ('506', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4cd9b20b0e9f410219da6550208a4d640578c8caf', '1468828847', '578c8caf6cc56');
INSERT INTO `oauth_server_nonce` VALUES ('433', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4da2fde4db4b2451dd3a2633be0748f10578c86ac', '1468827308', '578c86ac76e55');
INSERT INTO `oauth_server_nonce` VALUES ('922', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4da69186a5d9ff73d8f754f7168e938d057974ff5', '1469534197', '57974ff5dc8cf');
INSERT INTO `oauth_server_nonce` VALUES ('162', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4dfa2a077caa89d2e9a5d44cd03a3c6205788907a', '1468567675', '5788907b3bfbd');
INSERT INTO `oauth_server_nonce` VALUES ('206', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4e69493932bb33f3293f6eaea0d72841057889b3e', '1468570430', '57889b3e88f4b');
INSERT INTO `oauth_server_nonce` VALUES ('488', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '4f0e3fe7ff4d81c59c7c382e83b374830578c8ba9', '1468828586', '578c8baa2aa25');
INSERT INTO `oauth_server_nonce` VALUES ('392', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '51da5fc787a661fb76e034d4c41da5820578c80e6', '1468825831', '578c80e72cfb2');
INSERT INTO `oauth_server_nonce` VALUES ('95', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '521a6e8920d95a0c8c7642efbb931939057888697', '1468565144', '578886983fff2');
INSERT INTO `oauth_server_nonce` VALUES ('983', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '522f77da1ccbeeb5a6b4afa02109d558057975a0f', '1469536783', '57975a0fe4198');
INSERT INTO `oauth_server_nonce` VALUES ('9', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '52a00f735a14813993088112490dd15f05785f867', '1468397672', '5785f868280a7');
INSERT INTO `oauth_server_nonce` VALUES ('683', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '52eb2785402ccc31cd3f1102b5defb2e0578f8add', '1469024989', '578f8addb7766');
INSERT INTO `oauth_server_nonce` VALUES ('920', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5342b7a60185d4b901190e95dc55afba057974fcb', '1469534155', '57974fcb6a2f9');
INSERT INTO `oauth_server_nonce` VALUES ('775', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '548c9b8661fc50ab51403e61315d156d057971390', '1469518737', '579713910ac3d');
INSERT INTO `oauth_server_nonce` VALUES ('908', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '549d7fa343cf67016c36f13c745fcfc3057974cfe', '1469533439', '57974cff0707d');
INSERT INTO `oauth_server_nonce` VALUES ('333', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '54a8cf2b8c47ddb9dd1af0e948fab2db05788d8f9', '1468586234', '5788d8fa1b7ee');
INSERT INTO `oauth_server_nonce` VALUES ('805', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '54b9ee10029c7f677b92e8bd381b4589057972069', '1469522026', '5797206a3e7da');
INSERT INTO `oauth_server_nonce` VALUES ('461', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '553018288f82230519a4694d2ec7b8e10578c89fa', '1468828155', '578c89fb3077a');
INSERT INTO `oauth_server_nonce` VALUES ('292', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '55ea39b124050a0a7a7d2cfdbc28414805788c7d4', '1468581845', '5788c7d502297');
INSERT INTO `oauth_server_nonce` VALUES ('121', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '562114f5b0e3bd40d439fa3d4fa7c11005788881f', '1468565535', '5788881fb63b4');
INSERT INTO `oauth_server_nonce` VALUES ('374', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '562245dc0c6056ca220cd8038daf174005788eec2', '1468591811', '5788eec313616');
INSERT INTO `oauth_server_nonce` VALUES ('113', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5638d2bb43e8257eaca15377c77e4594057888790', '1468565392', '578887903973d');
INSERT INTO `oauth_server_nonce` VALUES ('766', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5730344d5505baa9746844374e6ce95205797127a', '1469518458', '5797127ab2ea7');
INSERT INTO `oauth_server_nonce` VALUES ('427', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '57b25258ac63adff7493439a3125f8ea0578c84e1', '1468826850', '578c84e239c8f');
INSERT INTO `oauth_server_nonce` VALUES ('309', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5894470373542fa145466ee0ddf8841805788d071', '1468584049', '5788d071afd99');
INSERT INTO `oauth_server_nonce` VALUES ('942', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5acdff5bb19a03aed5ac4729ff86f3f90579753ad', '1469535150', '579753ae0f294');
INSERT INTO `oauth_server_nonce` VALUES ('242', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5af218785b6a83f1cca9ddb0228d4ee505788a907', '1468573960', '5788a9081cdde');
INSERT INTO `oauth_server_nonce` VALUES ('67', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5b4322f0259d72bfa8d22a86c671a2c105787936d', '1468502894', '5787936e3256b');
INSERT INTO `oauth_server_nonce` VALUES ('537', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5b79500db87a788ee880598d51e771040578c8de1', '1468829153', '578c8de1a315c');
INSERT INTO `oauth_server_nonce` VALUES ('51', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5bb8311e9f0fe6d33131b7015f73ab74057862967', '1468410216', '578629681ec9c');
INSERT INTO `oauth_server_nonce` VALUES ('345', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5bc88c9a554a6899fbc5dec9f939768105788dae6', '1468586727', '5788dae748849');
INSERT INTO `oauth_server_nonce` VALUES ('525', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5c0a42d27fc526edec92544fda1d39eb0578c8d36', '1468828982', '578c8d365fa14');
INSERT INTO `oauth_server_nonce` VALUES ('793', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5c83d9b5c2a91f13251d3ed188162935057971ca0', '1469521056', '57971ca05edc7');
INSERT INTO `oauth_server_nonce` VALUES ('378', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5cc83fa7979a150cee114b36b9986fbf05788f40f', '1468593168', '5788f4104b131');
INSERT INTO `oauth_server_nonce` VALUES ('210', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5ce5739730281b4cd9865c826144c538057889bf7', '1468570615', '57889bf79fc8d');
INSERT INTO `oauth_server_nonce` VALUES ('400', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5e91e9a89965bd242bd6f64e7dfa39bd0578c815b', '1468825947', '578c815b392e2');
INSERT INTO `oauth_server_nonce` VALUES ('553', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5ef7536e89ebb75f12ee73d9b2fe133d0578c8e2e', '1468829231', '578c8e2f39ea4');
INSERT INTO `oauth_server_nonce` VALUES ('127', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '5f4727ea22b9ae2f9ef014387dc590cf057888945', '1468565830', '5788894642c0a');
INSERT INTO `oauth_server_nonce` VALUES ('445', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6032ee995974f98901c3f214108789920578c8720', '1468827424', '578c8720b2525');
INSERT INTO `oauth_server_nonce` VALUES ('695', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '60628b3fbc157b6c65a6d757ee1cd9b30578f8f08', '1469026057', '578f8f094184f');
INSERT INTO `oauth_server_nonce` VALUES ('141', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6139c01a396a240e4ed472a1b6c9f856057888b50', '1468566353', '57888b5127cc9');
INSERT INTO `oauth_server_nonce` VALUES ('639', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '61cfea456b4892cb96e3a1958e2a2c610578cbe59', '1468841561', '578cbe59c8416');
INSERT INTO `oauth_server_nonce` VALUES ('797', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '62619f628c415d631970430fc05f5356057971d2e', '1469521198', '57971d2e53b68');
INSERT INTO `oauth_server_nonce` VALUES ('858', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '638c3a50b312563d89aea2cecc5f38ff05797388e', '1469528206', '5797388ee1df7');
INSERT INTO `oauth_server_nonce` VALUES ('303', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6487a45eb25c71f5f310e6d045ed96f205788cd20', '1468583200', '5788cd20781ec');
INSERT INTO `oauth_server_nonce` VALUES ('49', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6569ffa0f19e23c61da01b5a1a0881e005786293a', '1468410171', '5786293b144ea');
INSERT INTO `oauth_server_nonce` VALUES ('197', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6612b72b68a8cbf69ab4901ca74c9be50578898cd', '1468569806', '578898ce31b21');
INSERT INTO `oauth_server_nonce` VALUES ('425', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '66319df35342ea9a9561b5658d04e21d0578c84d7', '1468826839', '578c84d771f71');
INSERT INTO `oauth_server_nonce` VALUES ('563', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '669ac3c1b6381d023df19b3aeec66fbc0578c8e62', '1468829282', '578c8e6274ff5');
INSERT INTO `oauth_server_nonce` VALUES ('635', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '67d3acc8f98e959e6b54c5f8971ce1100578cbe2e', '1468841518', '578cbe2e96514');
INSERT INTO `oauth_server_nonce` VALUES ('613', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '67f133e7fe748ee1987f1b4734e349690578c99c4', '1468832196', '578c99c4ddb2d');
INSERT INTO `oauth_server_nonce` VALUES ('967', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '681cf39f3c35d4f9daae49d5c2d8e79605797564f', '1469535823', '5797564f622b7');
INSERT INTO `oauth_server_nonce` VALUES ('587', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '693f8ba2069113c14a079ee7ed620fb80578c8fde', '1468829663', '578c8fdf11230');
INSERT INTO `oauth_server_nonce` VALUES ('948', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6a10fc44c050e2d5e37da5059a19830105797540e', '1469535246', '5797540ed0dd5');
INSERT INTO `oauth_server_nonce` VALUES ('248', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6b007c893b6506507e82508ad6ff75e905788a985', '1468574086', '5788a9862b0ff');
INSERT INTO `oauth_server_nonce` VALUES ('256', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6bfd1cbf71069198b43a795464d8158605788a9c8', '1468574152', '5788a9c89714a');
INSERT INTO `oauth_server_nonce` VALUES ('262', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6c596fe68719b59a547fb0886b92788505788aaeb', '1468574443', '5788aaebcc5a8');
INSERT INTO `oauth_server_nonce` VALUES ('435', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6d2d2790102e9541978a64faad5b7e0c0578c86b5', '1468827317', '578c86b5ae2c6');
INSERT INTO `oauth_server_nonce` VALUES ('107', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6da5f414806af2de27d894901f85a438057888713', '1468565268', '578887141858d');
INSERT INTO `oauth_server_nonce` VALUES ('21', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '6ed2329bc365cfdf67daa433d50b826005785f928', '1468397864', '5785f928e347b');
INSERT INTO `oauth_server_nonce` VALUES ('547', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '70e5ab8c5b3dd18c3f409749a1b8db520578c8e15', '1468829206', '578c8e1631ce1');
INSERT INTO `oauth_server_nonce` VALUES ('431', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '71cdf21b040ca90da5f76166d150f9c70578c8653', '1468827219', '578c86533ceea');
INSERT INTO `oauth_server_nonce` VALUES ('238', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7297d3a258dd81657f39bcf256c5364505788a8d7', '1468573911', '5788a8d7deffc');
INSERT INTO `oauth_server_nonce` VALUES ('625', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '72aa0e2622b962ac7e3fe0b87f4115910578cbdcf', '1468841424', '578cbdd01f840');
INSERT INTO `oauth_server_nonce` VALUES ('457', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '72c2a0e92e2ca6dd80a7e68424f5bf170578c89ec', '1468828140', '578c89ec741c0');
INSERT INTO `oauth_server_nonce` VALUES ('482', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '74db3cbf60ec8f36f0252456437c4d1e0578c8b0a', '1468828426', '578c8b0ab832d');
INSERT INTO `oauth_server_nonce` VALUES ('940', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '74ea67a518dbf3e8e40db4c0752fc925057975311', '1469534993', '57975311dd409');
INSERT INTO `oauth_server_nonce` VALUES ('480', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '765979ec9c454e5add836651e9730bef0578c8b03', '1468828419', '578c8b04008b2');
INSERT INTO `oauth_server_nonce` VALUES ('79', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '76ad05eeab99a4135c5016ced4ce05b50578885cc', '1468564940', '578885cc5c218');
INSERT INTO `oauth_server_nonce` VALUES ('276', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '77c10c209ce115d55a00db6d6aab938f05788abc5', '1468574661', '5788abc5e0eca');
INSERT INTO `oauth_server_nonce` VALUES ('191', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '77f57a748c101b9e5a1dd06ffc00a9a7057889855', '1468569685', '5788985598ea2');
INSERT INTO `oauth_server_nonce` VALUES ('832', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '78ba7a0f4b47541e1f97e1cc9bd891b5057972f70', '1469525872', '57972f70d16a5');
INSERT INTO `oauth_server_nonce` VALUES ('500', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '79e9a97da5e0287f2532a32c0d0abe6c0578c8bf6', '1468828662', '578c8bf66829b');
INSERT INTO `oauth_server_nonce` VALUES ('199', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7af9da3ff22750aa94f4868db6ed8b430578898ce', '1468569807', '578898cf0e9e9');
INSERT INTO `oauth_server_nonce` VALUES ('770', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7d04395b438afe3d17758e25463f498505797130d', '1469518606', '5797130e12955');
INSERT INTO `oauth_server_nonce` VALUES ('936', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7d7c9ba84c149af72f6edbc4a040942e057975256', '1469534807', '579752571e1a3');
INSERT INTO `oauth_server_nonce` VALUES ('928', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7e03bc471ed2fd2cea4589693984e2f2057975156', '1469534550', '57975156c943f');
INSERT INTO `oauth_server_nonce` VALUES ('510', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7eb919d9def5edfa17f8e52155f107d80578c8ccb', '1468828875', '578c8ccb5acae');
INSERT INTO `oauth_server_nonce` VALUES ('672', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7ee2ca133faac318ba50ceab310d5a8f0578e00cd', '1468924109', '578e00cd5f195');
INSERT INTO `oauth_server_nonce` VALUES ('924', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7f2e1c833f7ba0f21a5362186cbfea3c0579750b2', '1469534386', '579750b251b44');
INSERT INTO `oauth_server_nonce` VALUES ('339', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7f5e701b74a3a695c064c0f36cf4837605788d9c9', '1468586441', '5788d9c96a7e4');
INSERT INTO `oauth_server_nonce` VALUES ('643', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7fb8453e49a8661d44241c2fd6160ccf0578cbf4e', '1468841806', '578cbf4e7d49f');
INSERT INTO `oauth_server_nonce` VALUES ('555', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '7fc73af8a91648c85ab670f5c0dbb17a0578c8e36', '1468829238', '578c8e3686250');
INSERT INTO `oauth_server_nonce` VALUES ('91', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '81661affc61b3fabd1ad0f34af60212505788864d', '1468565069', '5788864df19c3');
INSERT INTO `oauth_server_nonce` VALUES ('179', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8166282d608a0fefa5150326ebb7ed490578897ac', '1468569516', '578897ac6e69b');
INSERT INTO `oauth_server_nonce` VALUES ('185', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '83cf5ec272432e5d31ea956f4861f7850578897bd', '1468569533', '578897bd782af');
INSERT INTO `oauth_server_nonce` VALUES ('149', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '842521668d28af4a5d332219a1d9e5a1057888e2d', '1468567086', '57888e2e16e93');
INSERT INTO `oauth_server_nonce` VALUES ('177', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '845db40c9511524953ebbaa41065ef5a05788979e', '1468569502', '5788979e80de7');
INSERT INTO `oauth_server_nonce` VALUES ('904', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '851014b67d54fc556d254a8b95f67b1a057974a08', '1469532680', '57974a089489f');
INSERT INTO `oauth_server_nonce` VALUES ('232', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '852f314a3d89f39012c0333cf334dc0c05788a8bd', '1468573886', '5788a8be2c412');
INSERT INTO `oauth_server_nonce` VALUES ('963', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8655c3284f3a6bc5b22b47338f1d354f0579755f8', '1469535737', '579755f90b398');
INSERT INTO `oauth_server_nonce` VALUES ('535', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '86b38e68cb87c5d7fb5538ab45422a8e0578c8dd9', '1468829146', '578c8dda29931');
INSERT INTO `oauth_server_nonce` VALUES ('364', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8975667246b283f97a4103f4c00a764b05788dda7', '1468587431', '5788dda7977db');
INSERT INTO `oauth_server_nonce` VALUES ('193', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '89f53bae8366b1b6ed601aad9a554ffc057889873', '1468569715', '578898734b082');
INSERT INTO `oauth_server_nonce` VALUES ('465', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8b662285f603a15ab32cf465cf3cdb720578c8a28', '1468828200', '578c8a28bc3e9');
INSERT INTO `oauth_server_nonce` VALUES ('1049', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8c6518e00fda541ea6728ddab1129a1e0579885ed', '1469613549', '579885edd4edf');
INSERT INTO `oauth_server_nonce` VALUES ('653', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8c6a588032c6af3a124bb5c7268579d40578df3a8', '1468920744', '578df3a8eb0d4');
INSERT INTO `oauth_server_nonce` VALUES ('421', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8c82af4915e1458c80332a06908b8c950578c8400', '1468826624', '578c8400a514c');
INSERT INTO `oauth_server_nonce` VALUES ('867', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8cbb9ccf1d233f9270587134291e73cc057973951', '1469528402', '57973952403bb');
INSERT INTO `oauth_server_nonce` VALUES ('543', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8d2279c68e81ed9e597a9a042d87c55b0578c8e0f', '1468829200', '578c8e101fde0');
INSERT INTO `oauth_server_nonce` VALUES ('973', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8d7149896a36bdffa1af34e041eb19eb0579756fd', '1469535997', '579756fdf00f2');
INSERT INTO `oauth_server_nonce` VALUES ('41', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8d8f6651cb1edb061ad41ddd3842e6a5057862746', '1468409670', '5786274645f10');
INSERT INTO `oauth_server_nonce` VALUES ('768', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8d9264e06558d78c86e0bbf45fb832ec0579712ed', '1469518574', '579712ee58f48');
INSERT INTO `oauth_server_nonce` VALUES ('674', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8e1756038e247afc928a1468d58ba7870578e00f9', '1468924153', '578e00f9977e8');
INSERT INTO `oauth_server_nonce` VALUES ('272', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8e1a86778c46f696dcc2bc14da44426905788ab66', '1468574566', '5788ab667ce5e');
INSERT INTO `oauth_server_nonce` VALUES ('230', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8e6d2f3aad18a8185b0f5f110fb2c11205788a8a2', '1468573858', '5788a8a2e693d');
INSERT INTO `oauth_server_nonce` VALUES ('119', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '8ecdfa9628a0d9a22f1952d4d16d4fcd05788881e', '1468565534', '5788881ef0878');
INSERT INTO `oauth_server_nonce` VALUES ('274', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '9089580f914e06456fe552a78e11447f05788abc4', '1468574660', '5788abc44f87d');
INSERT INTO `oauth_server_nonce` VALUES ('688', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '911462f21bd3c9c3ad79c3fb4780412b0578f8b32', '1469025074', '578f8b32dced2');
INSERT INTO `oauth_server_nonce` VALUES ('234', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '91410e5e7a6b02ba27063bfc9791747d05788a8cb', '1468573900', '5788a8cc20034');
INSERT INTO `oauth_server_nonce` VALUES ('599', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '91bd4712210bf14a5fec29d7aa7784e10578c914a', '1468830026', '578c914a893f9');
INSERT INTO `oauth_server_nonce` VALUES ('129', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '91eacde707090ead12aa0226dfb43ab00578889b4', '1468565940', '578889b4d4e82');
INSERT INTO `oauth_server_nonce` VALUES ('386', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '923fc10bfc8bc2304b1b876e9e68f0f50578c7ff0', '1468825584', '578c7ff050f8c');
INSERT INTO `oauth_server_nonce` VALUES ('314', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '932882b83091c60f9c3f219c31e6d91f05788d137', '1468584248', '5788d1384261e');
INSERT INTO `oauth_server_nonce` VALUES ('668', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '94502dc8ef1e8d0436a91f4c33516f210578e0027', '1468923944', '578e0028b0baa');
INSERT INTO `oauth_server_nonce` VALUES ('157', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '9513f47e46fbf45192272b57770c335b057889049', '1468567626', '5788904a02264');
INSERT INTO `oauth_server_nonce` VALUES ('111', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '9595fdf77b64ddd41680a03cf0a763f505788874c', '1468565324', '5788874ca084b');
INSERT INTO `oauth_server_nonce` VALUES ('47', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '968e66bd237a3af813151b7967fe9be0057862824', '1468409892', '5786282496341');
INSERT INTO `oauth_server_nonce` VALUES ('975', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '96fc004b93970fa0e1a443cf2f1aca27057975726', '1469536038', '57975726ef3ee');
INSERT INTO `oauth_server_nonce` VALUES ('662', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '9741736df2dc5d2c0c82072bedaba0b30578dfde1', '1468923362', '578dfde233271');
INSERT INTO `oauth_server_nonce` VALUES ('676', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '97c1436727e721dfceb103ef8d34db450578f74f3', '1469019379', '578f74f3cbdf1');
INSERT INTO `oauth_server_nonce` VALUES ('706', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '98117f952f4d068eb820f3b65d8fe380057905ec8', '1469079240', '57905ec8d1fa3');
INSERT INTO `oauth_server_nonce` VALUES ('294', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '9842ef240d6569bcf591071144f2089205788c7d5', '1468581845', '5788c7d5c28c2');
INSERT INTO `oauth_server_nonce` VALUES ('902', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '98e476483de907fb6886710e93e2753a057974951', '1469532497', '57974951d592f');
INSERT INTO `oauth_server_nonce` VALUES ('109', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '99ca0bc3db38af36f32fb2698d0f437f057888714', '1468565268', '57888714a7b12');
INSERT INTO `oauth_server_nonce` VALUES ('133', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '99cd1883907716cdd5e11c38d3e1934d057888a29', '1468566058', '57888a2a4aadf');
INSERT INTO `oauth_server_nonce` VALUES ('647', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '99eaa5ca5949f70ae020ccc7bf104e5a0578cc389', '1468842889', '578cc389536fb');
INSERT INTO `oauth_server_nonce` VALUES ('471', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '9a47de7f0cba45bf4ba43e9f7fbf34350578c8ae8', '1468828393', '578c8ae920815');
INSERT INTO `oauth_server_nonce` VALUES ('337', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '9aa22b096a0e38bfc443246c5a805a7e05788d966', '1468586343', '5788d96787e72');
INSERT INTO `oauth_server_nonce` VALUES ('900', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '9ccc77cc4ee4e94b210e5144fcb45222057974935', '1469532469', '57974935a8ab6');
INSERT INTO `oauth_server_nonce` VALUES ('216', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '9e1897d0516acc7c32697e7d88086314057889c36', '1468570678', '57889c367439f');
INSERT INTO `oauth_server_nonce` VALUES ('65', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', '9f817013f4f86d2f674b3d56c73fa76a057879358', '1468502873', '5787935968502');
INSERT INTO `oauth_server_nonce` VALUES ('527', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a0b05b12f6953264947cf58b41ab1fd80578c8d46', '1468828998', '578c8d463f890');
INSERT INTO `oauth_server_nonce` VALUES ('839', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a11f65d2eb99e3a4d05a356cdf19297a057973400', '1469527041', '579734012a083');
INSERT INTO `oauth_server_nonce` VALUES ('397', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a2264472686ff14693f65cf1d4da0ad60578c810a', '1468825866', '578c810ab9194');
INSERT INTO `oauth_server_nonce` VALUES ('477', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a269b8d58e85d76cfcd23f477d8b3ff00578c8afc', '1468828412', '578c8afc53d4f');
INSERT INTO `oauth_server_nonce` VALUES ('484', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a3af1a495c17cece469f6fb9540e8fe60578c8b0b', '1468828427', '578c8b0b67bf3');
INSERT INTO `oauth_server_nonce` VALUES ('228', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a3f78bc365752fc9b61e4d83afce273b05788a857', '1468573784', '5788a85806b0a');
INSERT INTO `oauth_server_nonce` VALUES ('801', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a4a3442d073ba857a04938e67c20789e057972041', '1469521985', '5797204159e76');
INSERT INTO `oauth_server_nonce` VALUES ('577', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a4ab13e45a755ad259d19f372b825d460578c8f94', '1468829588', '578c8f94eb6f0');
INSERT INTO `oauth_server_nonce` VALUES ('312', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a5091dab6fb51f51fb2d74547f36a9af05788d0f5', '1468584181', '5788d0f5da1cd');
INSERT INTO `oauth_server_nonce` VALUES ('189', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a5b070c580361aa16a87d88b25fa7672057889854', '1468569684', '57889854db535');
INSERT INTO `oauth_server_nonce` VALUES ('270', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a5d20003c27f9e38c868b4a438b51b5b05788ab49', '1468574538', '5788ab4a2ada2');
INSERT INTO `oauth_server_nonce` VALUES ('545', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a6b377e6c8b8890f767efea3dbf5b74e0578c8e11', '1468829201', '578c8e113abe0');
INSERT INTO `oauth_server_nonce` VALUES ('916', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a72253393db7a4fc4c287d3d51ed5289057974e7f', '1469533823', '57974e7f4070f');
INSERT INTO `oauth_server_nonce` VALUES ('512', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a7d017017e085c6a5c222ea95e5ebb550578c8ccf', '1468828879', '578c8ccf74f0f');
INSERT INTO `oauth_server_nonce` VALUES ('631', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a929ee5c5701d7c7583e2293129d331c0578cbdff', '1468841471', '578cbdffb51ba');
INSERT INTO `oauth_server_nonce` VALUES ('795', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a93bbd47780fb46b4f19ae0add1444fd057971ceb', '1469521131', '57971ceb4b94c');
INSERT INTO `oauth_server_nonce` VALUES ('81', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'a9f30a27f59e132b41cff33705cd7cc4057888622', '1468565027', '5788862314098');
INSERT INTO `oauth_server_nonce` VALUES ('971', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'abc3e07b77627d3e021473c63bde0f280579756eb', '1469535980', '579756ec11792');
INSERT INTO `oauth_server_nonce` VALUES ('402', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ac42343a418f05f3c550874a69f2450f0578c815b', '1468825948', '578c815c1bd69');
INSERT INTO `oauth_server_nonce` VALUES ('208', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ac5a3274b8a6546618b45646490b3f64057889b95', '1468570517', '57889b95f00a1');
INSERT INTO `oauth_server_nonce` VALUES ('19', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ad42ef9a48839b4a599e5d6cbd8a7e2d05785f912', '1468397842', '5785f912a1425');
INSERT INTO `oauth_server_nonce` VALUES ('139', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ad65b115b3b8d226be6fd6c283955558057888b16', '1468566294', '57888b16c524c');
INSERT INTO `oauth_server_nonce` VALUES ('329', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ad6631a1988b9b1e0fb659a77cc6a85f05788d8a3', '1468586147', '5788d8a3ae0a7');
INSERT INTO `oauth_server_nonce` VALUES ('158', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'adeb62041302851688ac0a86eb6b21d405788904a', '1468567626', '5788904a9241c');
INSERT INTO `oauth_server_nonce` VALUES ('965', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'afb2768b779e1eeb6cf1b54ddd26c7fb05797561d', '1469535773', '5797561d7ec32');
INSERT INTO `oauth_server_nonce` VALUES ('15', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b0e39cd6e383b5a8998426d6a1dcfbd205785f8a5', '1468397734', '5785f8a6189fc');
INSERT INTO `oauth_server_nonce` VALUES ('33', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b1587d4cc9b31aeb59fefe6288cd4b85057861f73', '1468407668', '57861f7408542');
INSERT INTO `oauth_server_nonce` VALUES ('959', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b189f6c6459429eda7a2623507d01bc2057975597', '1469535640', '5797559810e0d');
INSERT INTO `oauth_server_nonce` VALUES ('583', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b2218757190d46077edb3f671e59f3240578c8faa', '1468829610', '578c8faade3b8');
INSERT INTO `oauth_server_nonce` VALUES ('1055', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b32268e8334a99a3ba96bc07f56ee50c057ab0959', '1470826842', '57ab095a5a4aa');
INSERT INTO `oauth_server_nonce` VALUES ('39', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b49571821fc8b42b16fec159cd6d6c0d057862714', '1468409620', '5786271473c4c');
INSERT INTO `oauth_server_nonce` VALUES ('629', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b49ced8a480da4ca9dfa58ec38fb11ad0578cbdf8', '1468841465', '578cbdf9357f2');
INSERT INTO `oauth_server_nonce` VALUES ('912', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b4b3771c6f0eaaf18ac3f2cc6d71ce86057974dcd', '1469533645', '57974dcd90f75');
INSERT INTO `oauth_server_nonce` VALUES ('455', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b4b4b94bf5b1b039d40eb88b750e0c740578c89b1', '1468828081', '578c89b14e14f');
INSERT INTO `oauth_server_nonce` VALUES ('609', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b56ad9a40ff2f673c3ac1a7dcd8651610578c99a1', '1468832161', '578c99a14f4e0');
INSERT INTO `oauth_server_nonce` VALUES ('918', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b59a3f42e057a4c1d1989103a239acfc057974f92', '1469534098', '57974f92bf240');
INSERT INTO `oauth_server_nonce` VALUES ('784', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b69b13d15518ba21a4b41fc272ec0a7b057971424', '1469518884', '57971424b2287');
INSERT INTO `oauth_server_nonce` VALUES ('69', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b8b5fbbd64296895e5dfae5fb6e67eb2057879404', '1468503045', '5787940550ab4');
INSERT INTO `oauth_server_nonce` VALUES ('451', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b8ef99a920cd57a4b867274e407bfb050578c8997', '1468828055', '578c899788093');
INSERT INTO `oauth_server_nonce` VALUES ('585', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b9018e8c19d0ef58f3ae5a3fa5eb9ee20578c8fd8', '1468829656', '578c8fd89c27d');
INSERT INTO `oauth_server_nonce` VALUES ('218', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'b922acc40bb829972de98463345c09fa057889c60', '1468570720', '57889c60ab046');
INSERT INTO `oauth_server_nonce` VALUES ('23', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ba6b389adc9e0a7b9d387345210f7ee505785f969', '1468397929', '5785f9698ab6f');
INSERT INTO `oauth_server_nonce` VALUES ('837', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'bb273f8e0dd8fed2fa84840ee4f5adad0579733db', '1469527003', '579733dbcb53d');
INSERT INTO `oauth_server_nonce` VALUES ('954', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'bb36ce596c7d34fb9ac11b805c0728bf0579754c1', '1469535426', '579754c21cb9f');
INSERT INTO `oauth_server_nonce` VALUES ('286', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'bb85d267896c0d39ea139d32d150485a05788aea1', '1468575393', '5788aea1971ad');
INSERT INTO `oauth_server_nonce` VALUES ('25', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'bd06c42f5e844b60f554456cb9e6565d05785f9e1', '1468398049', '5785f9e14e104');
INSERT INTO `oauth_server_nonce` VALUES ('183', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'bd4e095e6c0924eb93c8d4416ca7380e0578897bc', '1468569532', '578897bcbc2a6');
INSERT INTO `oauth_server_nonce` VALUES ('788', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'bd54c20a6e9634c12d054c6ee84e50ce0579717f6', '1469519862', '579717f6b447e');
INSERT INTO `oauth_server_nonce` VALUES ('284', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'bd5ebf5f86e8d16672035db9c067e5e705788aea0', '1468575392', '5788aea0db206');
INSERT INTO `oauth_server_nonce` VALUES ('258', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'be784ace1b5e8f1ddfdaa08218da36ed05788aae1', '1468574434', '5788aae245ebe');
INSERT INTO `oauth_server_nonce` VALUES ('486', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'bee51f1eb6f661fb8495b1a7881b0eec0578c8b98', '1468828568', '578c8b98d9b64');
INSERT INTO `oauth_server_nonce` VALUES ('123', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'bfe9b955e6db754921e04fa02f0aa0de057888888', '1468565641', '578888892c664');
INSERT INTO `oauth_server_nonce` VALUES ('597', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c03024912766652d2f03dc575f55d1f80578c9027', '1468829736', '578c90283d2fb');
INSERT INTO `oauth_server_nonce` VALUES ('657', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c0ccad5af7c7a92050d1b851feaf53df0578df44f', '1468920911', '578df44fba92a');
INSERT INTO `oauth_server_nonce` VALUES ('447', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c29d2afcd1ebf5785409314bf74932c40578c8981', '1468828033', '578c89819b64f');
INSERT INTO `oauth_server_nonce` VALUES ('260', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c2b84e3eb89d857d385be6b2cb1c9b7605788aae2', '1468574434', '5788aae2f3e86');
INSERT INTO `oauth_server_nonce` VALUES ('103', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c342a57b2207a3e5fdfb596bedfda67f0578886e3', '1468565219', '578886e380d37');
INSERT INTO `oauth_server_nonce` VALUES ('325', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c345feb7cefd6c26dc51060a61106c9b05788d86c', '1468586092', '5788d86cf1c3a');
INSERT INTO `oauth_server_nonce` VALUES ('541', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c459defb8d29a81f38f63ba5cee7f2220578c8e07', '1468829191', '578c8e07d4477');
INSERT INTO `oauth_server_nonce` VALUES ('633', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c504cda6d4ddf0f54f4732796eeb0c960578cbe0b', '1468841483', '578cbe0ba5fca');
INSERT INTO `oauth_server_nonce` VALUES ('651', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c51fff2b1bae8349ac717fb79f9683200578df0a4', '1468919972', '578df0a4a14bd');
INSERT INTO `oauth_server_nonce` VALUES ('449', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c622173cd62020369804ef3513c1a3020578c8982', '1468828035', '578c8983034b4');
INSERT INTO `oauth_server_nonce` VALUES ('83', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c654255918c334921dd40e0fbdbf37ed057888638', '1468565049', '5788863937edb');
INSERT INTO `oauth_server_nonce` VALUES ('504', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c8f939443c4a36ff151c27d43f2a03790578c8c7b', '1468828795', '578c8c7bc9f68');
INSERT INTO `oauth_server_nonce` VALUES ('341', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c95e6931d50fffe5e489e0db26f67d8005788d9ca', '1468586442', '5788d9cabb1cb');
INSERT INTO `oauth_server_nonce` VALUES ('969', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c9a2491e27ae1c68a506c9c67202481d05797568a', '1469535882', '5797568a8bcd0');
INSERT INTO `oauth_server_nonce` VALUES ('160', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'c9bd841fdff1114bd5337e8a4c675a5905788907a', '1468567674', '5788907a7e37c');
INSERT INTO `oauth_server_nonce` VALUES ('637', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'cb32a9d19e4d615f736df91d0b90dca90578cbe4c', '1468841549', '578cbe4d18f4c');
INSERT INTO `oauth_server_nonce` VALUES ('645', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'cb55d1a56edccbbfb5e3ebcb273dbd690578cbf9b', '1468841883', '578cbf9b47d75');
INSERT INTO `oauth_server_nonce` VALUES ('603', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'cbd77478da4f7147bddd2b08906634a50578c9225', '1468830246', '578c92265cbaf');
INSERT INTO `oauth_server_nonce` VALUES ('351', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ccb2b9032fe529aa57f0d31764ebd6a005788db0b', '1468586764', '5788db0c2934b');
INSERT INTO `oauth_server_nonce` VALUES ('105', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ccc9a80dbab8ed46970f7e304cb9cf56057888707', '1468565255', '578887075011e');
INSERT INTO `oauth_server_nonce` VALUES ('670', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'cced4e28e4706fa7f9f10899e45c2a320578e0032', '1468923954', '578e0032d3bf5');
INSERT INTO `oauth_server_nonce` VALUES ('347', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'cd4429010daf2a290124fd9b0e0571c305788daeb', '1468586731', '5788daeb8cc1e');
INSERT INTO `oauth_server_nonce` VALUES ('459', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'cd5bd144ab3b02400c9a38d98b7503d70578c89fa', '1468828154', '578c89faac2bf');
INSERT INTO `oauth_server_nonce` VALUES ('368', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'cddcdb09c8dbb82eb4e8df4e40d1348605788ddd4', '1468587476', '5788ddd45e166');
INSERT INTO `oauth_server_nonce` VALUES ('223', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ce35a65a7afe971e9429805bdbfe042505788a808', '1468573705', '5788a8092e509');
INSERT INTO `oauth_server_nonce` VALUES ('166', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'cf13f4ec65bc472e6aceb5054ccadc5a05788961f', '1468569119', '5788961f8da59');
INSERT INTO `oauth_server_nonce` VALUES ('419', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'cf3fc193d007573895ab26c3c1eea4340578c83ff', '1468826623', '578c83ffd49aa');
INSERT INTO `oauth_server_nonce` VALUES ('355', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd01730bd7314a1b64d57b428f173eb6105788dbdd', '1468586974', '5788dbde02229');
INSERT INTO `oauth_server_nonce` VALUES ('579', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd0ada81bf3b25eec6baf59aab7d2739b0578c8f9a', '1468829594', '578c8f9a599a5');
INSERT INTO `oauth_server_nonce` VALUES ('910', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd14155a84b9c35a7d0d0cc27f004847c057974d77', '1469533559', '57974d77e01a1');
INSERT INTO `oauth_server_nonce` VALUES ('514', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd25166f5226eb14bd64e5009d25b56df0578c8cd0', '1468828880', '578c8cd0b2f7f');
INSERT INTO `oauth_server_nonce` VALUES ('13', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd2b3fb5199b3cca338e5cd28dd1bf9be05785f891', '1468397713', '5785f891905d3');
INSERT INTO `oauth_server_nonce` VALUES ('236', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd2c65cb3b1c9945e0359ca47fccbc0ab05788a8cc', '1468573901', '5788a8cd31fc9');
INSERT INTO `oauth_server_nonce` VALUES ('826', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd30f85799ec33b772f258e08d735ddba057972d03', '1469525252', '57972d0437ae4');
INSERT INTO `oauth_server_nonce` VALUES ('301', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd310221e19b85c3819b8b381cb8ed18405788c8fe', '1468582143', '5788c8ff15dcd');
INSERT INTO `oauth_server_nonce` VALUES ('559', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd3186056766cbbe8edfce83d1b4150400578c8e56', '1468829271', '578c8e571e6c2');
INSERT INTO `oauth_server_nonce` VALUES ('214', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd4703cab7495443cab3cd10a48d2770e057889c2e', '1468570670', '57889c2e4ae73');
INSERT INTO `oauth_server_nonce` VALUES ('950', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd5f44c9d92b42d2eb42dc13486a9315505797544f', '1469535311', '5797544fd442b');
INSERT INTO `oauth_server_nonce` VALUES ('169', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd6fd0a3754fda37de2a19983795cacf5057889656', '1468569175', '5788965759864');
INSERT INTO `oauth_server_nonce` VALUES ('35', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd7235318314d14db787b6d4a077d8c51057862049', '1468407882', '5786204a20ce9');
INSERT INTO `oauth_server_nonce` VALUES ('439', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd7291ac938973f2ad1343ef9cf91839c0578c86f5', '1468827381', '578c86f589f10');
INSERT INTO `oauth_server_nonce` VALUES ('946', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd7613f480f13f0c77f4123d1fd1f1f03057975407', '1469535239', '57975407ca408');
INSERT INTO `oauth_server_nonce` VALUES ('573', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd88daebefd03f794e770388fc086d4370578c8ef7', '1468829432', '578c8ef83be7b');
INSERT INTO `oauth_server_nonce` VALUES ('508', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd8c8bd46be5eb9f937f0abe281bc5a930578c8cbb', '1468828859', '578c8cbb5f32f');
INSERT INTO `oauth_server_nonce` VALUES ('932', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd8e28098d305a7857400c13139a6101a0579751f1', '1469534705', '579751f155817');
INSERT INTO `oauth_server_nonce` VALUES ('423', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd9375b84a8d561a507863f9c6d8194ab0578c84c1', '1468826818', '578c84c2146f9');
INSERT INTO `oauth_server_nonce` VALUES ('591', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd94ae18b1f93dcb5504c41c2ded3e8fb0578c8fea', '1468829674', '578c8feaa4a16');
INSERT INTO `oauth_server_nonce` VALUES ('115', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'd956c8237c11ed3276901dd4d7a690e20578887d9', '1468565465', '578887d96db3f');
INSERT INTO `oauth_server_nonce` VALUES ('414', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'db62693f205c0db18a63386695799df90578c83e4', '1468826597', '578c83e50f2d4');
INSERT INTO `oauth_server_nonce` VALUES ('93', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'dc5fe6f8f207e46c26d57a224bfea36f057888691', '1468565137', '578886915e78d');
INSERT INTO `oauth_server_nonce` VALUES ('246', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'dd460cc268563f97a9582a10d7027c8c05788a985', '1468574085', '5788a9857bde5');
INSERT INTO `oauth_server_nonce` VALUES ('786', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'dd67bb468093fdb7f5f451ba46b7df190579716c7', '1469519559', '579716c7dbac0');
INSERT INTO `oauth_server_nonce` VALUES ('147', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'dea30ae86bbb46ee3ad0bd0bf4af9721057888e18', '1468567065', '57888e190a028');
INSERT INTO `oauth_server_nonce` VALUES ('77', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'deb3094fd781ac4601ce47e182f6885c0578885c6', '1468564935', '578885c72a43b');
INSERT INTO `oauth_server_nonce` VALUES ('491', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'df365b38265dba322df6941766fdbb8b0578c8bb2', '1468828594', '578c8bb2ba085');
INSERT INTO `oauth_server_nonce` VALUES ('250', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e01bc6cb7bcd2a961b01161165bdbe1705788a9b5', '1468574134', '5788a9b61c5b2');
INSERT INTO `oauth_server_nonce` VALUES ('282', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e0356698e149eb1875c3402eec89b7cf05788ae56', '1468575319', '5788ae5718e0c');
INSERT INTO `oauth_server_nonce` VALUES ('17', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e08d3a7b1314c8da8d290e8a0145325205785f8e7', '1468397800', '5785f8e868581');
INSERT INTO `oauth_server_nonce` VALUES ('956', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e0ba9720ca080b929a34c0b6aac82107057975522', '1469535522', '579755227ec7b');
INSERT INTO `oauth_server_nonce` VALUES ('202', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e0dcc8baa0c21f308f02389fcd5dc8b8057889ab4', '1468570292', '57889ab4c6916');
INSERT INTO `oauth_server_nonce` VALUES ('813', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e1b19a9b9250272c67bef8b08cb4513705797260f', '1469523471', '5797260f7f042');
INSERT INTO `oauth_server_nonce` VALUES ('593', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e23498dee93ccaaed66baf3b3e5b7b2e0578c9010', '1468829712', '578c9010437cf');
INSERT INTO `oauth_server_nonce` VALUES ('254', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e25c54f4de331d6ede9948fe7f16f87d05788a9c7', '1468574152', '5788a9c80c32b');
INSERT INTO `oauth_server_nonce` VALUES ('372', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e3db073e08da4a27b01e0f852a1be65f05788eec1', '1468591809', '5788eec1d3d23');
INSERT INTO `oauth_server_nonce` VALUES ('152', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e3f38077ba84855290c80030e1d0f585057889026', '1468567590', '57889026b2429');
INSERT INTO `oauth_server_nonce` VALUES ('135', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e49af1279f795e8601ba0673391b844e057888a67', '1468566120', '57888a6845c91');
INSERT INTO `oauth_server_nonce` VALUES ('384', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e51299455458c61b10719f30edb8eae20578c779c', '1468823453', '578c779d5b561');
INSERT INTO `oauth_server_nonce` VALUES ('137', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e6489065e29fef8106cd8281e54cb8af057888ab0', '1468566192', '57888ab0a341e');
INSERT INTO `oauth_server_nonce` VALUES ('349', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e721cc967970d536018dcb718fd2752905788db0b', '1468586763', '5788db0b6d271');
INSERT INTO `oauth_server_nonce` VALUES ('299', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e76aaeee02749b3d95c0a1073582386f05788c8fe', '1468582142', '5788c8fe5de51');
INSERT INTO `oauth_server_nonce` VALUES ('518', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e7ccbffbba98dc2b3ec492fb5408b1520578c8d22', '1468828962', '578c8d22b35ee');
INSERT INTO `oauth_server_nonce` VALUES ('252', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e8065cfb3d1f0e440cf6f57b2209435b05788a9b6', '1468574134', '5788a9b6a3407');
INSERT INTO `oauth_server_nonce` VALUES ('666', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e89330ee9e445580a03967530f969e470578dffe4', '1468923876', '578dffe45e95c');
INSERT INTO `oauth_server_nonce` VALUES ('712', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e972e459f68fa2d3ec2c0efb3be4bd4705790670b', '1469081355', '5790670bec104');
INSERT INTO `oauth_server_nonce` VALUES ('164', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'e9eea4893f00ca179dddab2e02d499b105788961e', '1468569118', '5788961eaf4fb');
INSERT INTO `oauth_server_nonce` VALUES ('187', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ebc5b8987b18a57e2bb49444fdb232eb057889850', '1468569681', '578898511f366');
INSERT INTO `oauth_server_nonce` VALUES ('605', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ecae4f733e21f1369b5b3af97944b3490578c9245', '1468830277', '578c92457c532');
INSERT INTO `oauth_server_nonce` VALUES ('429', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ecb15db1d13b6361ed2fee9ec32ba5480578c8648', '1468827209', '578c864968979');
INSERT INTO `oauth_server_nonce` VALUES ('811', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ef6181fcf0858acd288b0c258ad3246305797210b', '1469522187', '5797210bb6e57');
INSERT INTO `oauth_server_nonce` VALUES ('71', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ef90791fae378420e161270f1c692b6d057879419', '1468503066', '5787941a13ff1');
INSERT INTO `oauth_server_nonce` VALUES ('557', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ef90c09d5a7d91b54d253418c5e2484e0578c8e43', '1468829252', '578c8e440b78f');
INSERT INTO `oauth_server_nonce` VALUES ('655', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f11d411d469984e79432bd867b2093570578df44e', '1468920910', '578df44ece297');
INSERT INTO `oauth_server_nonce` VALUES ('62', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f1d120165b7d6f2ebc2b93ad7539d97a05787923a', '1468502730', '578792cac2825');
INSERT INTO `oauth_server_nonce` VALUES ('496', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f27003b492862c483067ca671271685a0578c8bc0', '1468828608', '578c8bc099e3e');
INSERT INTO `oauth_server_nonce` VALUES ('531', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f2725acdf9fd62cbfb1073a3126a782f0578c8d7d', '1468829053', '578c8d7da5687');
INSERT INTO `oauth_server_nonce` VALUES ('914', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f28591154dfef6fa3e2eaf9433ed5c2f057974e48', '1469533769', '57974e4903c50');
INSERT INTO `oauth_server_nonce` VALUES ('97', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f3aa08e7321d4f1624b42b3e91434b6c0578886a7', '1468565159', '578886a757945');
INSERT INTO `oauth_server_nonce` VALUES ('494', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f3f28a67289c7a2c98b5c964611df4b50578c8bb9', '1468828601', '578c8bb962049');
INSERT INTO `oauth_server_nonce` VALUES ('575', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f413174aacee2a5d0fac84027ae9593a0578c8f8d', '1468829582', '578c8f8e16ba6');
INSERT INTO `oauth_server_nonce` VALUES ('321', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f41b62eb53846ebf94ac73dcd25fcfb605788d80d', '1468585998', '5788d80e022c8');
INSERT INTO `oauth_server_nonce` VALUES ('204', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f47f8f5c3cc69f090c0d5b9676854954057889b29', '1468570409', '57889b295bad2');
INSERT INTO `oauth_server_nonce` VALUES ('617', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f4b48f3b27c7b0c274dd582bebf4ced80578cbbf3', '1468840947', '578cbbf37f186');
INSERT INTO `oauth_server_nonce` VALUES ('611', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f5861260eccda4059a76bdc6298736550578c99ab', '1468832171', '578c99abc94c1');
INSERT INTO `oauth_server_nonce` VALUES ('961', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f68520091efaefd343b2d4c4e29f9dcc0579755b4', '1469535669', '579755b54d24e');
INSERT INTO `oauth_server_nonce` VALUES ('979', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f68f8a51affc2bd8060e0eeb4dc3f5960579758cb', '1469536459', '579758cbf0b76');
INSERT INTO `oauth_server_nonce` VALUES ('607', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f7afbe8ca084817eba16c789e832c1830578c998c', '1468832141', '578c998d31d63');
INSERT INTO `oauth_server_nonce` VALUES ('331', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f8100a48ce0a9aa8196d848324e14d0805788d8f8', '1468586232', '5788d8f8ea1bc');
INSERT INTO `oauth_server_nonce` VALUES ('87', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f83553509c7a4958f58bffc54cb9d00c057888644', '1468565061', '578886451be96');
INSERT INTO `oauth_server_nonce` VALUES ('1051', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f9637bf3b16da438bc2f6245cf6167a20579886fa', '1469613819', '579886fb69710');
INSERT INTO `oauth_server_nonce` VALUES ('11', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f9aa32983a8ea8335c3e2d60ca118d7205785f877', '1468397687', '5785f8778a0d2');
INSERT INTO `oauth_server_nonce` VALUES ('381', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'fa4674e4de18b5d287c450058e31f19e0578c7787', '1468823432', '578c77885ac39');
INSERT INTO `oauth_server_nonce` VALUES ('569', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'fa70a08a5492ad531196f6999b2467980578c8e96', '1468829334', '578c8e96d3370');
INSERT INTO `oauth_server_nonce` VALUES ('443', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'fac9e07da98eb8fbc4b5197e30ab3ab30578c86fd', '1468827389', '578c86fd6ccf8');
INSERT INTO `oauth_server_nonce` VALUES ('394', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'fb0b3dab0192dc5cb2d108e6db0ff1410578c80e7', '1468825832', '578c80e8079b2');
INSERT INTO `oauth_server_nonce` VALUES ('27', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'fb8b284d7075dd89a60fdb99bd519fcd057860e31', '1468403249', '57860e31d315a');
INSERT INTO `oauth_server_nonce` VALUES ('358', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'fcbcd811d0d3e93bbb9a748137f1c26205788dc42', '1468587074', '5788dc42ea9d6');
INSERT INTO `oauth_server_nonce` VALUES ('45', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'fdc4e20367723562ae735acdf41c9a7b05786278c', '1468409741', '5786278d3b1fa');
INSERT INTO `oauth_server_nonce` VALUES ('799', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'fdd6868afdd1e3f1f1adaa3060d4418e05797201d', '1469521950', '5797201e114af');
INSERT INTO `oauth_server_nonce` VALUES ('777', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ff1f184ab85601a9761ab02c9b2ccf180579713ae', '1469518766', '579713aeb2fe7');
INSERT INTO `oauth_server_nonce` VALUES ('145', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ff6d3dbba0fbb4d53abe49ed4a44bbeb057888e04', '1468567044', '57888e049a18a');
INSERT INTO `oauth_server_nonce` VALUES ('366', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ff95acc5f26d57f6999dcd126b8621a605788ddb7', '1468587447', '5788ddb7bdcd7');
INSERT INTO `oauth_server_nonce` VALUES ('529', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'ffdd3aae6c2b52f80a7c85c1435669910578c8d7b', '1468829051', '578c8d7bcefd5');

-- ----------------------------
-- Table structure for `oauth_server_registry`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_server_registry`;
CREATE TABLE `oauth_server_registry` (
  `osr_id` int(11) NOT NULL AUTO_INCREMENT,
  `osr_usa_id_ref` int(11) DEFAULT NULL,
  `osr_consumer_key` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `osr_consumer_secret` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `osr_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `osr_status` varchar(16) NOT NULL,
  `osr_requester_name` varchar(64) NOT NULL,
  `osr_requester_email` varchar(64) NOT NULL,
  `osr_callback_uri` varchar(255) NOT NULL,
  `osr_application_uri` varchar(255) NOT NULL,
  `osr_application_title` varchar(80) NOT NULL,
  `osr_application_descr` text NOT NULL,
  `osr_application_notes` text NOT NULL,
  `osr_application_type` varchar(20) NOT NULL,
  `osr_application_commercial` tinyint(1) NOT NULL DEFAULT '0',
  `osr_issue_date` datetime NOT NULL,
  `osr_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`osr_id`),
  UNIQUE KEY `osr_consumer_key` (`osr_consumer_key`),
  KEY `osr_usa_id_ref` (`osr_usa_id_ref`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of oauth_server_registry
-- ----------------------------
INSERT INTO `oauth_server_registry` VALUES ('5', '3', '950f03aeee9e26d5ef09e7044e37cc1c05785f759', 'f24d93848aed0950d49d89af81b7834c', '1', 'active', 'mrins', 'mrins@test.com', '', 'http://192.168.1.38/ams_api/api/example/user/id/1/format/xml', '', '', '', '', '0', '2016-07-13 13:40:01', '2016-07-13 13:40:01');

-- ----------------------------
-- Table structure for `oauth_server_token`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_server_token`;
CREATE TABLE `oauth_server_token` (
  `ost_id` int(11) NOT NULL AUTO_INCREMENT,
  `ost_osr_id_ref` int(11) NOT NULL,
  `ost_usa_id_ref` int(11) NOT NULL,
  `ost_token` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `ost_token_secret` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `ost_token_type` enum('request','access') DEFAULT NULL,
  `ost_authorized` tinyint(1) NOT NULL DEFAULT '0',
  `ost_referrer_host` varchar(128) NOT NULL DEFAULT '',
  `ost_token_ttl` datetime NOT NULL DEFAULT '9999-12-31 00:00:00',
  `ost_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ost_verifier` char(10) DEFAULT NULL,
  `ost_callback_url` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`ost_id`),
  UNIQUE KEY `ost_token` (`ost_token`),
  KEY `ost_osr_id_ref` (`ost_osr_id_ref`),
  KEY `ost_token_ttl` (`ost_token_ttl`),
  CONSTRAINT `oauth_server_token_ibfk_1` FOREIGN KEY (`ost_osr_id_ref`) REFERENCES `oauth_server_registry` (`osr_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of oauth_server_token
-- ----------------------------
INSERT INTO `oauth_server_token` VALUES ('1', '5', '3', 'f348d259f85bbaf73e47dbf4b46a913b057975bd4', '3bfa1a94d17838317df0ea649b90f173', 'request', '1', '192.168.1.38', '2016-07-26 19:17:16', '2016-07-26 18:17:16', 'da3b8382e9', 'oob');
INSERT INTO `oauth_server_token` VALUES ('2', '5', '3', '316818f5b872bb803e8af5c9a0b42bad057975c24', '03afb3dd237ebed8130b64a5ec193a54', 'request', '1', '192.168.1.38', '2016-07-26 19:18:36', '2016-07-26 18:18:36', '6dec94b82a', 'oob');
INSERT INTO `oauth_server_token` VALUES ('3', '5', '3', '6fc0c2abadcb70217d9b4e5c05c81fb0057975c4c', '9ac26146096c47dff9cf4f0380354fed', 'request', '1', '192.168.1.38', '2016-07-26 19:19:16', '2016-07-26 18:19:16', '827309d5a9', 'oob');
INSERT INTO `oauth_server_token` VALUES ('4', '5', '3', '5c07d09aaca6e733883d8fed79de4f18057975c66', '8ab34f0b87eac279e80f4904208dfecd', 'request', '1', '192.168.1.38', '2016-07-26 19:19:42', '2016-07-26 18:19:42', 'd6212621c2', 'oob');
INSERT INTO `oauth_server_token` VALUES ('5', '5', '3', '3d6f2e70ecca40bba5d33eb74a316ac6057975cc5', '851ee0972ee43386cb9c48f2c1b0af9f', 'request', '1', '192.168.1.38', '2016-07-26 19:21:17', '2016-07-26 18:21:17', '0a68464c78', 'oob');
INSERT INTO `oauth_server_token` VALUES ('6', '5', '3', '0ab1c4f41844e178e8a402955694d35c057975d40', '57f0236b366c73442a4f2f22671ece9a', 'request', '1', '192.168.1.38', '2016-07-26 19:23:20', '2016-07-26 18:23:20', '7275102a5b', 'oob');
INSERT INTO `oauth_server_token` VALUES ('7', '5', '0', '9f4dd8d7187b814a2b9a32d8404ab07d057975e2e', 'b1ab1125add7a854e33fa9a201e360c0', 'request', '1', '', '2016-07-26 19:27:18', '2016-07-26 18:27:18', '4ca0a97ecf', 'oob');
INSERT INTO `oauth_server_token` VALUES ('8', '5', '0', '641b6933db55b92738c1d9340c9c29b1057975e56', 'c37e7ca962e1141f0778944ed627765f', 'request', '1', '', '2016-07-26 19:27:58', '2016-07-26 18:27:58', 'a0c8331191', 'oob');
INSERT INTO `oauth_server_token` VALUES ('9', '5', '0', 'a82dc2315c6cd9e4d1aa21fd3a751134057975f5f', '1f4a416f0f70a6855cc4f64c994e9d7d', 'request', '1', '', '2016-07-26 19:32:23', '2016-07-26 18:32:23', '6639a2f242', 'oob');
INSERT INTO `oauth_server_token` VALUES ('10', '5', '0', 'fb620ba1111cc1bc0c681bee5981e75b057975f7e', '6f829c3b54def3da9cd959fea7a25d99', 'request', '1', '', '2016-07-26 19:32:54', '2016-07-26 18:32:55', '94f1cc17ae', 'oob');
INSERT INTO `oauth_server_token` VALUES ('11', '5', '0', 'c48148d708ccb6e9c79437b508aca4b3057975fca', 'bd14a1e24e72e7cfcbae681cc59c9d9e', 'request', '1', '', '2016-07-26 19:34:10', '2016-07-26 18:34:10', '7df155dd3b', 'oob');
INSERT INTO `oauth_server_token` VALUES ('12', '5', '0', '0123142e85bed46ed6bbf52912a56a3505797605b', 'da8aed79835ef9367ee616ed6d1afe2f', 'request', '1', '', '2016-07-26 19:36:35', '2016-07-26 18:36:35', '6b42154276', 'oob');
INSERT INTO `oauth_server_token` VALUES ('13', '5', '0', 'ce2689020e5a9aeb391e25d152950685057976127', '36fc9a8d745d761028ebfdac0ab77761', 'request', '1', '', '2016-07-26 19:39:59', '2016-07-26 18:40:00', '66aefe98a3', 'oob');
INSERT INTO `oauth_server_token` VALUES ('14', '5', '0', 'fad3e822b55d2d87ba802e017fbee0ad05797613e', '2210dccf173442d29adc1609d18d1b35', 'request', '1', '192.168.1.38', '2016-07-26 19:40:22', '2016-07-26 18:40:22', '7838353ed6', 'oob');
INSERT INTO `oauth_server_token` VALUES ('15', '5', '0', 'de8611fcbaac78e0f96242414699465305797615a', '9bd1cd95db77d26d274eeb63139b259c', 'request', '1', '192.168.1.38', '2016-07-26 19:40:50', '2016-07-26 18:40:50', '20beafe031', 'oob');
INSERT INTO `oauth_server_token` VALUES ('16', '5', '0', 'f261e6ae0471feb910d0bd27369a5da90579761aa', '5d700d4b2fe3ee885a91dc91a38fac2a', 'request', '1', '192.168.1.38', '2016-07-26 19:42:10', '2016-07-26 18:42:10', 'af3c37cb08', 'oob');
INSERT INTO `oauth_server_token` VALUES ('17', '5', '0', 'ef8ba2882029c307d26a56474094e7fc057976252', 'ce81a56d6a5bff40560543dc212c9f7a', 'request', '1', '192.168.1.38', '2016-07-26 19:44:58', '2016-07-26 18:44:58', 'e9e0be8107', 'oob');
INSERT INTO `oauth_server_token` VALUES ('18', '5', '0', 'af938dddf36763b4ab6829977a4a49600579762c0', '097b9d26462943aa8494703cfc2c944f', 'request', '1', '192.168.1.38', '2016-07-26 19:46:48', '2016-07-26 18:46:48', '5d93498336', 'oob');
INSERT INTO `oauth_server_token` VALUES ('19', '5', '0', '3f908ec0e155a43b29dec7ab9cb4b4e6057976399', '33e57995255793620af931845a4d6c0e', 'request', '1', '192.168.1.38', '2016-07-26 19:50:25', '2016-07-26 18:50:26', '44b442658f', 'oob');
INSERT INTO `oauth_server_token` VALUES ('20', '5', '1', '05a025f193491e5bdc8be4007d74eec50579850ab', '22a699bdedeab4393b33ef95dc6a2d18', 'request', '0', '', '2016-07-27 12:41:55', '2016-07-27 11:41:55', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('21', '5', '1', '127f9d752a45b5c1b8df45214762302c0579850c6', '711348c0beadd0938424c2273cb3949a', 'request', '0', '', '2016-07-27 12:42:22', '2016-07-27 11:42:22', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('22', '5', '1', 'db9683d371bf2135b88e5c40ad8afa7c0579850e2', 'b0bdea37d227bb95ebfc6361a51de05d', 'request', '0', '', '2016-07-27 12:42:50', '2016-07-27 11:42:50', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('23', '5', '1', '53d8020af3aa8b9d5024b455d318d2a505798512b', '8b253099bf01d01f039df20f084daff3', 'request', '0', '', '2016-07-27 12:44:03', '2016-07-27 11:44:03', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('24', '5', '1', '9728a4807aa3bc6b6be49e7a0db20b4605798519b', 'b8aadffea8418ff4c5ee4382b4d9f8f7', 'request', '0', '', '2016-07-27 12:45:55', '2016-07-27 11:45:55', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('25', '5', '1', '87e5497f351b3ffa36b0869d990d4e230579852d0', 'd558ba4652914270f9f5bc0ecf5726c8', 'request', '0', '', '2016-07-27 12:51:04', '2016-07-27 11:51:04', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('26', '5', '1', 'abf90031309854b9b3b563bbab6f0759057985489', '6707f32ba24c85c25294efbef0719fea', 'request', '0', '', '2016-07-27 12:58:25', '2016-07-27 11:58:25', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('27', '5', '1', '5e1e86cb9f4d550e7b2452fe8b81422a0579855a2', '0b64a0ca8cc1a562149b32b51af81851', 'request', '0', '', '2016-07-27 13:03:06', '2016-07-27 12:03:06', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('28', '5', '1', 'db1f24dd459b58275ac4e2c0bbf907af0579855d5', '3066d85a959bc26c6d8b55b0773d6388', 'request', '0', '', '2016-07-27 13:03:57', '2016-07-27 12:03:57', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('29', '5', '1', 'f631b6338ac63549bcacb17a2940cf2c05798563c', 'e440ab6372e98984fba5d45cbd5b5eb3', 'request', '0', '', '2016-07-27 13:05:40', '2016-07-27 12:05:40', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('30', '5', '1', '13569ae445bf0d25afd84a404413d18505798564a', 'e0da9eee7818c2e7bea3372749eae27f', 'request', '0', '', '2016-07-27 13:05:54', '2016-07-27 12:05:54', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('31', '5', '1', '1dc2418576a951fd5e61ad2b7be79c5d05798572c', '7109bbc4d369e253dc21be71bce98fc2', 'request', '0', '', '2016-07-27 13:09:40', '2016-07-27 12:09:40', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('32', '5', '1', '8160c39f0a65eee7ea9a4e2fe2da7245057985750', 'c57cfa924361c876f221e919cc7a59b4', 'request', '0', '', '2016-07-27 13:10:16', '2016-07-27 12:10:16', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('33', '5', '1', 'b28a78ea88b4003c35b637d3ecffee22057985757', 'f6bf98e6a615389acefd13b81c654949', 'request', '0', '', '2016-07-27 13:10:23', '2016-07-27 12:10:23', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('34', '5', '1', '7f2572c060822b5ee9a417e5310c191205798580a', '077c3258ef4856f852639dac82494684', 'request', '0', '', '2016-07-27 13:13:22', '2016-07-27 12:13:22', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('35', '5', '1', 'b9106c9652b4328771ec8f4574014491057985815', 'f0fcad14d8e46f17d51431b07d0fe7e0', 'request', '0', '', '2016-07-27 13:13:33', '2016-07-27 12:13:33', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('36', '5', '1', '653f56baa4e0ef692d6b5f78a52b34ab057985890', '99795eaae12dd8bda67d9b280986966a', 'request', '0', '', '2016-07-27 13:15:36', '2016-07-27 12:15:36', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('37', '5', '1', '281ee26619cef98ccdb95c485d4b60510579858cb', '585516ed5d655fe6ab6d5fa579e75859', 'request', '0', '', '2016-07-27 13:16:35', '2016-07-27 12:16:35', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('38', '5', '1', '2ceba9234b9de2c6be41efaa64db2b0e05798595f', '2d07ecd2b2d9d180aecda77796d7ebfe', 'request', '0', '', '2016-07-27 13:19:03', '2016-07-27 12:19:03', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('39', '5', '1', '3e04ae2e02a7f552e2a70fe9af8c8a11057985978', '598a101e50144f8865cc1cc4fe658877', 'request', '0', '', '2016-07-27 13:19:28', '2016-07-27 12:19:28', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('40', '5', '1', '14dbd1e0a21ea5e056e580cc608545f4057985a78', '7606bac076a20a48b461773695797a20', 'request', '0', '', '2016-07-27 13:23:44', '2016-07-27 12:23:44', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('41', '5', '1', 'c2ad55ec3820b33bdc2191d51e145319057985acd', '49ce0f6511e7922bd0040e4d598b15f9', 'request', '0', '', '2016-07-27 13:25:09', '2016-07-27 12:25:09', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('42', '5', '1', '907423434590b95c4533ad1a3353615d057985d3a', 'f8f69d6132e2f92cd6501c8ca77a0dc8', 'request', '0', '', '2016-07-27 13:35:30', '2016-07-27 12:35:30', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('43', '5', '1', '3d29161a0864a0eef7b65e633667d7d7057985d60', '88baa5344fcf4adc5f081012252b1cb0', 'request', '0', '', '2016-07-27 13:36:08', '2016-07-27 12:36:08', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('44', '5', '1', 'aa572ddf578e12112347136ba97e3044057985d7b', 'f7e207a0532c334ab83b455d7114a18b', 'request', '0', '', '2016-07-27 13:36:35', '2016-07-27 12:36:35', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('45', '5', '1', '6eb331a8ca5a130d7cf09f06ab9a882c057985ef2', 'b165eb4f0284a2847592cb00069ad795', 'request', '0', '', '2016-07-27 13:42:50', '2016-07-27 12:42:50', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('46', '5', '1', '9f93bc96299c5bbb04b4429c040e77ec057985fd5', '19f1b78d6faffa93c2c239f7a4c7aa5f', 'request', '0', '', '2016-07-27 13:46:37', '2016-07-27 12:46:37', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('47', '5', '1', '2ccbdc579f32c20288dd1df8139d7709057986473', '785735256ca524dacc93c6721fa76c36', 'request', '0', '', '2016-07-27 14:06:19', '2016-07-27 13:06:19', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('48', '5', '1', '61731af4b2de4f26d7ca8b007ab76881057986686', '2a129ee5d1c4cf32fa91643fab03c40f', 'request', '0', '', '2016-07-27 14:15:10', '2016-07-27 13:15:10', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('49', '5', '1', 'fdeef1a1a67b25f579e4f15fc6c54191057986751', 'c7603e92cef69f07e1453a79c1588dbd', 'request', '0', '', '2016-07-27 14:18:33', '2016-07-27 13:18:33', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('50', '5', '1', '81d478f733c88fc9122274fe0d17bf8f057986860', 'e7bc55cd6b7c265f4eec8674994fd232', 'request', '0', '', '2016-07-27 14:23:04', '2016-07-27 13:23:04', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('51', '5', '1', 'e31c3615486c84b39c60acf30dcfbe6005798686d', '9980c89a27684d5dbaefc42954740bbe', 'request', '0', '', '2016-07-27 14:23:17', '2016-07-27 13:23:17', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('52', '5', '1', '905c2ecd48c981030dcacffdc64e463405798689c', 'db31abd317d05e62026465234992b4b9', 'request', '0', '', '2016-07-27 14:24:04', '2016-07-27 13:24:04', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('53', '5', '1', '7778e80b8dcafcff72e62dd95eca14cd057986a29', '97be8de21b5ed7bd9a87003f95724cef', 'request', '0', '', '2016-07-27 14:30:41', '2016-07-27 13:30:41', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('54', '5', '1', '9f622ecea19c58ceab6a8a6ad45dc5d1057986cdc', 'b57cf74ec2da9a4f7eec8c835deb0203', 'request', '0', '', '2016-07-27 14:42:12', '2016-07-27 13:42:12', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('55', '5', '1', '15e2c742836ed1c86be1ac223fda682305798795f', 'ca305c4558d8db96451fd47dc6a1ab23', 'request', '0', '', '2016-07-27 15:35:35', '2016-07-27 14:35:35', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('56', '5', '1', '9068499c62aa06f31c6eb3e6d90eafa20579879f0', '8ce9c451b0ebc04bdccefc784ad42600', 'request', '0', '', '2016-07-27 15:38:00', '2016-07-27 14:38:00', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('57', '5', '1', '54240353009089477bec2ff1f7f0965c057987a09', 'a5f6291c25ad1c882cc8e1efbec4a0c8', 'request', '0', '', '2016-07-27 15:38:25', '2016-07-27 14:38:25', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('58', '5', '1', '0be74fd5ddbda9750d4248ef12b6bd57057987a41', 'ea3468a65018ac7a57fdf1574b258421', 'request', '0', '', '2016-07-27 15:39:21', '2016-07-27 14:39:21', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('59', '5', '1', '2ec89e7ecd3190ce2efa2ef5b5e08e4c057987aa0', '48bfec8d9ae3996eca8df2b453d6fb27', 'request', '0', '', '2016-07-27 15:40:56', '2016-07-27 14:40:56', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('60', '5', '1', '213cd24ff185818418d5c89f927a18aa057987b53', '3010249e80a1db7637c7ce417082bcc2', 'request', '0', '', '2016-07-27 15:43:55', '2016-07-27 14:43:55', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('61', '5', '1', '4212f43bd775ad3a09009722f265f4ec057987ce2', '2a16e240eefe00afef781ea3458263c1', 'request', '0', '', '2016-07-27 15:50:34', '2016-07-27 14:50:34', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('62', '5', '1', 'ca9f641ded2f35421acdcb1624e2cc1f057987d27', '826e39300f8d3da42640dea04e2a8d52', 'request', '0', '', '2016-07-27 15:51:43', '2016-07-27 14:51:43', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('63', '5', '1', 'cd4d204fb56e9893c3059b710bbe2e40057987d51', '80626eab8111a43fd4c929b176f32304', 'request', '0', '', '2016-07-27 15:52:25', '2016-07-27 14:52:25', null, 'oob');
INSERT INTO `oauth_server_token` VALUES ('64', '5', '0', '69e9dab6206347f2c49956a8d2210c220579885ee', '1bf8bc0b2f2c582970bbc4a9d7f99e2c', 'access', '1', '192.168.1.38', '9999-12-31 00:00:00', '2016-07-27 15:29:10', '60b8dd47bb', 'oob');
INSERT INTO `oauth_server_token` VALUES ('65', '5', '0', '51de3c8bb6898cc6f3d2ba2835b64eb10579886fb', '1af7c56f73065d8ac01132eed5075b68', 'access', '1', '192.168.1.38', '9999-12-31 00:00:00', '2016-07-27 15:33:39', '9c65c48f53', 'oob');
INSERT INTO `oauth_server_token` VALUES ('66', '5', '0', '8d79a96f11a6db94b56974653d718771057988c83', '212407099a72c8cd9b2481d97d5e27a3', 'access', '1', '192.168.1.38', '9999-12-31 00:00:00', '2016-07-27 15:57:15', '57133d4c56', 'oob');
INSERT INTO `oauth_server_token` VALUES ('67', '5', '0', '0a2f5fb3541d92d41e8e3e6a95f0a385057ab095a', '76efcb88746b744a0a650bfed1536ef8', 'access', '1', '192.168.1.38', '9999-12-31 00:00:00', '2016-08-10 16:30:42', '01c54bf1fb', 'oob');

-- ----------------------------
-- Table structure for `oauth_users`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_users`;
CREATE TABLE `oauth_users` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_portal_company_id` int(10) NOT NULL DEFAULT '0',
  `s_portal_account_number` varchar(255) DEFAULT '0',
  `s_username` varchar(255) DEFAULT NULL,
  `s_password` varchar(255) DEFAULT NULL,
  `s_email` varchar(255) DEFAULT NULL,
  `s_consumer_key` varchar(255) DEFAULT NULL,
  `s_consumer_secret` varchar(255) DEFAULT NULL,
  `i_user_type` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1->Admin, 2->Users',
  `dt_created` datetime DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of oauth_users
-- ----------------------------
INSERT INTO `oauth_users` VALUES ('1', '0', '0', 'admin', 'adb8835820ebfbfb94d78a5023ba2e03', 'admin@tste.com', '95647413a6d2f4b4899daf7ff6d0e789055bb6ac7', 'aca24a42422ab4947d55d95f35f43e25', '1', '2015-07-31 08:32:07');
INSERT INTO `oauth_users` VALUES ('3', '0', '0', 'shieldwatch', '9beac2e4c0f847a4f752a1036e08f194', 'mrinsss@gmail.com', 'adb8835820ebfbfb94d78a5023ba2e03', 'f24d93848aed0950d49d89af81b7834c', '2', '2016-07-13 13:40:01');
INSERT INTO `oauth_users` VALUES ('5', '0', '0', 'test_user', '155b14319c26820c34f61ceb56614889', 'mmondal@codeuridea.com', null, null, '2', null);
INSERT INTO `oauth_users` VALUES ('6', '0', '0', 'testsd1', '146310f3cae21f412b3f733a8b970e79', 'test_user@gmail.com', null, null, '2', null);
DROP TRIGGER IF EXISTS `sortorder_faq`;
DELIMITER ;;
CREATE TRIGGER `sortorder_faq` BEFORE INSERT ON `ams_faq` FOR EACH ROW SET NEW.i_sort_order = (SELECT MAX(i_sort_order)+1 FROM mp_faq)
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `Auto_menu_order`;
DELIMITER ;;
CREATE TRIGGER `Auto_menu_order` BEFORE INSERT ON `ams_menu` FOR EACH ROW SET NEW.i_display_order = (SELECT MAX(i_display_order)+1 FROM ams_menu WHERE i_parent_id = NEW.i_parent_id)
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `Auto_menu_order_copy`;
DELIMITER ;;
CREATE TRIGGER `Auto_menu_order_copy` BEFORE INSERT ON `ams_menu_copy` FOR EACH ROW SET NEW.i_display_order = (SELECT MAX(i_display_order)+1 FROM ams_menu WHERE i_parent_id = NEW.i_parent_id)
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `sortorder_news`;
DELIMITER ;;
CREATE TRIGGER `sortorder_news` BEFORE INSERT ON `ams_news` FOR EACH ROW SET NEW.i_sort_order = (SELECT MAX(i_sort_order)+1 FROM mp_news)
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `sortorder_user_copy`;
DELIMITER ;;
CREATE TRIGGER `sortorder_user_copy` BEFORE INSERT ON `ams_user` FOR EACH ROW SET NEW.i_sort_order = (SELECT MAX(i_sort_order)+1 FROM ams_user)
;;
DELIMITER ;
