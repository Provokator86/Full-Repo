/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : eshoppj3_vaneloeshop

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2014-12-19 12:46:15
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `country_code`
-- ----------------------------
DROP TABLE IF EXISTS `country_code`;
CREATE TABLE `country_code` (
  `Country` varchar(80) NOT NULL,
  `Code` varchar(80) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of country_code
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_admin`
-- ----------------------------
DROP TABLE IF EXISTS `fc_admin`;
CREATE TABLE `fc_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `admin_name` varchar(24) NOT NULL,
  `admin_password` varchar(500) NOT NULL,
  `email` varchar(5000) NOT NULL,
  `admin_type` enum('super','sub') NOT NULL DEFAULT 'super',
  `privileges` text NOT NULL,
  `last_login_date` datetime NOT NULL,
  `last_logout_date` datetime NOT NULL,
  `last_login_ip` varchar(16) NOT NULL,
  `is_verified` enum('No','Yes') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_admin
-- ----------------------------
INSERT INTO fc_admin VALUES ('1', '2014-10-23', '2014-10-28', 'adminesh', '70f745ff18f79dcd42cda9c8f07fafa7', 'kishorela@gmail.com', 'super', '', '2014-12-05 11:16:07', '2014-11-20 11:43:15', '210.211.234.181', 'Yes', 'Active');

-- ----------------------------
-- Table structure for `fc_admin_settings`
-- ----------------------------
DROP TABLE IF EXISTS `fc_admin_settings`;
CREATE TABLE `fc_admin_settings` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `site_contact_mail` varchar(200) NOT NULL,
  `site_contact_number` varchar(50) NOT NULL,
  `email_title` varchar(400) NOT NULL,
  `google_verification` varchar(500) NOT NULL,
  `google_verification_code` longtext NOT NULL,
  `facebook_link` varchar(200) NOT NULL,
  `twitter_link` varchar(100) NOT NULL,
  `pinterest` varchar(500) NOT NULL,
  `googleplus_link` varchar(100) NOT NULL,
  `linkedin_link` varchar(500) NOT NULL,
  `rss_link` varchar(500) NOT NULL,
  `youtube_link` varchar(500) NOT NULL,
  `footer_content` varchar(255) NOT NULL,
  `logo_image` varchar(255) NOT NULL,
  `logo_icon` varchar(1000) NOT NULL,
  `meta_title` varchar(100) NOT NULL,
  `meta_keyword` varchar(150) NOT NULL,
  `meta_description` mediumtext NOT NULL,
  `fevicon_image` varchar(255) NOT NULL,
  `facebook_api` varchar(100) NOT NULL,
  `facebook_secret_key` varchar(100) NOT NULL,
  `paypal_api_name` varchar(100) NOT NULL,
  `paypal_api_pw` varchar(100) NOT NULL,
  `paypal_api_key` varchar(100) NOT NULL,
  `authorize_net_key` varchar(100) NOT NULL,
  `paypal_id` varchar(500) NOT NULL,
  `paypal_live` enum('1','2') NOT NULL,
  `smtp_port` int(200) NOT NULL,
  `smtp_uname` varchar(200) NOT NULL,
  `smtp_password` varchar(200) NOT NULL,
  `consumer_key` varchar(500) NOT NULL,
  `consumer_secret` varchar(500) NOT NULL,
  `google_client_secret` varchar(500) NOT NULL,
  `google_client_id` varchar(500) NOT NULL,
  `google_redirect_url` varchar(500) NOT NULL,
  `google_developer_key` varchar(500) NOT NULL,
  `facebook_app_id` text NOT NULL,
  `facebook_app_secret` text NOT NULL,
  `like_text` mediumtext NOT NULL,
  `unlike_text` mediumtext NOT NULL,
  `liked_text` mediumtext NOT NULL,
  `logo_icon_option` enum('yes','no') NOT NULL DEFAULT 'no',
  `payment_details` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_admin_settings
-- ----------------------------
INSERT INTO fc_admin_settings VALUES ('1', 'kishorela@gmail.com', '', 'eshoppinx', '', '', 'http://www.facebook.com/', 'http://twitter.com/', '', 'http://google.com', '', '', '', '&copy;  2013 Rights Reserved', 'logo.png', '', 'eshoppinx', 'eshoppinx', 'eshoppinx', 'logo.png', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', 'Like', 'Unlike', 'Like\'d', 'no', '');

-- ----------------------------
-- Table structure for `fc_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `fc_attribute`;
CREATE TABLE `fc_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(500) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `attribute_seourl` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_attribute
-- ----------------------------
INSERT INTO fc_attribute VALUES ('1', 'color', 'Active', '2013-08-16 01:21:38', 'color');
INSERT INTO fc_attribute VALUES ('2', 'price', 'Active', '2013-08-16 01:21:44', 'price');

-- ----------------------------
-- Table structure for `fc_banner_category`
-- ----------------------------
DROP TABLE IF EXISTS `fc_banner_category`;
CREATE TABLE `fc_banner_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` mediumtext NOT NULL,
  `image` mediumtext NOT NULL,
  `link` mediumtext NOT NULL,
  `status` enum('Publish','Unpublish') NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_banner_category
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_category`
-- ----------------------------
DROP TABLE IF EXISTS `fc_category`;
CREATE TABLE `fc_category` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(500) NOT NULL,
  `rootID` int(20) NOT NULL,
  `seourl` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` enum('Active','InActive') NOT NULL,
  `cat_position` int(11) NOT NULL,
  `seo_title` longblob NOT NULL,
  `seo_keyword` longblob NOT NULL,
  `seo_description` longblob NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_category
-- ----------------------------
INSERT INTO fc_category VALUES ('1', 'Technology', '0', 'technology', '', 'Active', '0', 0x546563686E6F6C6F6779, 0x546563686E6F6C6F6779, 0x546563686E6F6C6F6779, '2014-10-23 06:18:00');

-- ----------------------------
-- Table structure for `fc_cms`
-- ----------------------------
DROP TABLE IF EXISTS `fc_cms`;
CREATE TABLE `fc_cms` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(500) NOT NULL,
  `page_title` varchar(200) NOT NULL,
  `seourl` blob NOT NULL,
  `hidden_page` enum('Yes','No') NOT NULL DEFAULT 'No',
  `category` enum('Main','Sub') NOT NULL DEFAULT 'Main',
  `parent` int(11) NOT NULL DEFAULT '0',
  `meta_tag` varchar(500) NOT NULL,
  `meta_description` blob NOT NULL,
  `description` blob NOT NULL,
  `status` enum('Publish','UnPublish') NOT NULL,
  `meta_title` varchar(1000) NOT NULL,
  `priority` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_cms
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_contact_seller`
-- ----------------------------
DROP TABLE IF EXISTS `fc_contact_seller`;
CREATE TABLE `fc_contact_seller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` longblob NOT NULL,
  `name` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `selleremail` varchar(500) NOT NULL,
  `sellerid` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fc_contact_seller
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_country`
-- ----------------------------
DROP TABLE IF EXISTS `fc_country`;
CREATE TABLE `fc_country` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `contid` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `country_code` varchar(2) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `seourl` varchar(750) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `currency_type` char(3) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `currency_symbol` text NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `shipping_tax` decimal(10,2) NOT NULL,
  `meta_title` blob NOT NULL,
  `meta_keyword` blob NOT NULL,
  `meta_description` blob NOT NULL,
  `description` longblob NOT NULL,
  `status` enum('Active','InActive') CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL DEFAULT 'Active',
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `currency_default` enum('No','Yes') CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=232 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_country
-- ----------------------------
INSERT INTO fc_country VALUES ('1', 'EU', 'AD', 'Andorra', 'andorra', 'EUR', '$', '0.00', '0.00', '', '', '', '', 'Active', '2013-09-06 04:33:27', 'No');
INSERT INTO fc_country VALUES ('2', 'AS', 'AE', 'United Arab Emirates', 'united-arab-emirates', 'AED', '$', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('3', 'AS', 'AF', 'Afghanistan', 'afghanistan', 'AFN', 'â‚±', '3.00', '0.00', '', '', '', '', 'Active', '2013-09-13 21:38:13', 'No');
INSERT INTO fc_country VALUES ('4', 'NA', 'AG', 'Antigua And Barbuda', 'antigua-and-barbuda', 'XCD', '$', '2.00', '3.00', '', '', '', '', 'Active', '2013-08-21 23:08:52', 'No');
INSERT INTO fc_country VALUES ('5', 'EU', 'AL', 'Albania', 'albania', 'ALL', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('6', 'AS', 'AM', 'Armenia', 'armenia', 'AMD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('7', 'AF', 'AO', 'Angola', 'angola', 'AOA', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('8', 'AN', 'AQ', 'Antarctica', 'antarctica', 'XCD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('9', 'SA', 'AR', 'Argentina', 'argentina', 'ARS', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('10', 'OC', 'AS', 'American Samoa', 'american-samoa', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('11', 'EU', 'AT', 'Austria', 'austria', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('12', 'OC', 'AU', 'Australia', 'australia', 'AUD', '$', '0.00', '0.00', '', '', '', '', 'Active', '2013-09-06 01:40:37', 'No');
INSERT INTO fc_country VALUES ('13', 'NA', 'AW', 'Aruba', 'aruba', 'AWG', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('14', '', 'AX', 'Aland Islands', 'aland-islands', 'EUR', 'â‚¬', '0.00', '0.00', '', '', '', '', 'Active', '2013-09-10 18:39:28', 'No');
INSERT INTO fc_country VALUES ('15', 'AS', 'AZ', 'Azerbaijan', 'azerbaijan', 'AZN', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('16', '', 'BA', 'Bosnia And Herzegovina', 'bosnia-and-herzegovina', 'BAM', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('17', 'NA', 'BB', 'Barbados', 'barbados', 'BBD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('18', 'AS', 'BD', 'Bangladesh', 'bangladesh', 'BDT', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('19', 'EU', 'BE', 'Belgium', 'belgium', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('20', 'AF', 'BF', 'Burkina Faso', 'burkina-faso', 'XOF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('21', 'EU', 'BG', 'Bulgaria', 'bulgaria', 'BGN', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('22', 'AS', 'BH', 'Bahrain', 'bahrain', 'BHD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('23', 'AF', 'BI', 'Burundi', 'burundi', 'BIF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('24', 'AF', 'BJ', 'Benin', 'benin', 'XOF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('25', 'NA', 'BM', 'Bermuda', 'bermuda', 'BMD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('26', '', 'BN', 'Brunei', 'brunei', 'BND', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('27', 'SA', 'BO', 'Bolivia', 'bolivia', 'BOB', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('28', '', 'BQ', 'Bonaire, Saint Eustatius And Saba ', 'bonaire,-saint-eustatius-and-saba', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('29', 'SA', 'BR', 'Brazil', 'brazil', 'BRL', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('30', 'NA', 'BS', 'Bahamas', 'bahamas', 'BSD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('31', 'AS', 'BT', 'Bhutan', 'bhutan', 'BTN', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('32', 'AN', 'BV', 'Bouvet Island', 'bouvet-island', 'NOK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('33', 'AF', 'BW', 'Botswana', 'botswana', 'BWP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('34', 'EU', 'BY', 'Belarus', 'belarus', 'BYR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('35', 'NA', 'BZ', 'Belize', 'belize', 'BZD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('36', 'NA', 'CA', 'Canada', 'canada', 'CAD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('37', '', 'CD', 'Democratic Republic Of The Congo', 'democratic-republic-of-the-congo', 'DRC', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('38', 'AF', 'CF', 'Central African Republic', 'central-african-republic', 'XAF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('39', '', 'CG', 'Republic Of The Congo', 'republic-of-the-congo', 'DRC', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('40', 'EU', 'CH', 'Switzerland', 'switzerland', 'CHF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('41', '', 'CI', 'Ivory Coast', 'ivory-coast', 'XOF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('42', 'SA', 'CL', 'Chile', 'chile', 'CLP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('43', 'AF', 'CM', 'Cameroon', 'cameroon', 'XAF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('44', 'AS', 'CN', 'China', 'china', 'CNY', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('45', 'SA', 'CO', 'Colombia', 'colombia', 'COP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('46', 'NA', 'CR', 'Costa Rica', 'costa-rica', 'CRC', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('47', 'NA', 'CU', 'Cuba', 'cuba', 'CUP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('48', 'AF', 'CV', 'Cape Verde', 'cape-verde', 'CVE', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('49', 'EU', 'CY', 'Cyprus', 'cyprus', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('50', 'EU', 'CZ', 'Czech Republic', 'czech-republic', 'CZK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('51', 'EU', 'DE', 'Germany', 'germany', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('52', 'AF', 'DJ', 'Djibouti', 'djibouti', 'DJF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('53', 'EU', 'DK', 'Denmark', 'denmark', 'DKK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('54', 'NA', 'DM', 'Dominica', 'dominica', 'XCD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('55', 'NA', 'DO', 'Dominican Republic', 'dominican-republic', 'DOP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('56', 'AF', 'DZ', 'Algeria', 'algeria', 'DZD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('57', 'SA', 'EC', 'Ecuador', 'ecuador', 'ECS', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('58', 'EU', 'EE', 'Estonia', 'estonia', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('59', 'AF', 'EG', 'Egypt', 'egypt', 'EGP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('60', 'AF', 'EH', 'Western Sahara', 'western-sahara', 'MAD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('61', 'AF', 'ER', 'Eritrea', 'eritrea', 'ERN', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('62', 'EU', 'ES', 'Spain', 'spain', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('63', 'AF', 'ET', 'Ethiopia', 'ethiopia', 'ETB', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('64', 'EU', 'FI', 'Finland', 'finland', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('65', 'OC', 'FJ', 'Fiji', 'fiji', 'FJD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('66', '', 'FM', 'Micronesia', 'micronesia', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('67', 'EU', 'FO', 'Faroe Islands', 'faroe-islands', 'DKK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('68', 'EU', 'FR', 'France', 'france', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('69', 'AF', 'GA', 'Gabon', 'gabon', 'XAF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('70', 'EU', 'GB', 'United Kingdom', 'united-kingdom', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('71', 'NA', 'GD', 'Grenada', 'grenada', 'XCD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('72', 'AS', 'GE', 'Georgia', 'georgia', 'GEL', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('73', 'SA', 'GF', 'French Guiana', 'french-guiana', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('74', '', 'GG', 'Guernsey', 'guernsey', 'GGP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('75', 'AF', 'GH', 'Ghana', 'ghana', 'GHS', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('76', 'NA', 'GL', 'Greenland', 'greenland', 'DKK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('77', 'AF', 'GM', 'Gambia', 'gambia', 'GMD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('78', 'AF', 'GN', 'Guinea', 'guinea', 'GNF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('79', 'NA', 'GP', 'Guadeloupe', 'guadeloupe', 'EUD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('80', 'AF', 'GQ', 'Equatorial Guinea', 'equatorial-guinea', 'XAF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('81', 'EU', 'GR', 'Greece', 'greece', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('82', 'NA', 'GT', 'Guatemala', 'guatemala', 'QTQ', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('83', 'OC', 'GU', 'Guam', 'guam', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('84', 'AF', 'GW', 'Guinea-Bissau', 'guineabissau', 'GWP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('85', 'SA', 'GY', 'Guyana', 'guyana', 'GYD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('86', 'AS', 'HK', 'Hong Kong', 'hong-kong', 'HKD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('87', 'NA', 'HN', 'Honduras', 'honduras', 'HNL', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('88', 'EU', 'HR', 'Croatia', 'croatia', 'HRK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('89', 'NA', 'HT', 'Haiti', 'haiti', 'HTG', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('90', 'EU', 'HU', 'Hungary', 'hungary', 'HUF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('91', 'AS', 'ID', 'Indonesia', 'indonesia', 'IDR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('92', 'EU', 'IE', 'Ireland', 'ireland', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('93', 'AS', 'IL', 'Israel', 'israel', 'ILS', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('94', '', 'IM', 'Isle Of Man', 'isle-of-man', 'GBP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('95', 'AS', 'IN', 'India', 'india', 'INR', 'Rs', '15.00', '10.00', '', '', '', '', 'Active', '2013-08-21 23:09:55', 'No');
INSERT INTO fc_country VALUES ('96', 'AS', 'IO', 'British Indian Ocean Territory', 'british-indian-ocean-territory', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('97', 'AS', 'IQ', 'Iraq', 'iraq', 'IQD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('98', '', 'IR', 'Iran', 'iran', 'IRR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('99', 'EU', 'IS', 'Iceland', 'iceland', 'ISK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('100', 'EU', 'IT', 'Italy', 'italy', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('101', '', 'JE', 'Jersey', 'jersey', 'GBP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('102', 'NA', 'JM', 'Jamaica', 'jamaica', 'JMD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('103', 'AS', 'JO', 'Jordan', 'jordan', 'JOD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('104', 'AS', 'JP', 'Japan', 'japan', 'JPY', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('105', 'AF', 'KE', 'Kenya', 'kenya', 'KES', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('106', 'AS', 'KG', 'Kyrgyzstan', 'kyrgyzstan', 'KGS', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('107', 'AS', 'KH', 'Cambodia', 'cambodia', 'KHR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('108', 'OC', 'KI', 'Kiribati', 'kiribati', 'AUD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('109', 'AF', 'KM', 'Comoros', 'comoros', 'KMF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('110', 'NA', 'KN', 'Saint Kitts And Nevis', 'saint-kitts-and-nevis', 'XCD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('111', '', 'KP', 'North Korea', 'north-korea', 'KPW', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('112', '', 'KR', 'South Korea', 'south-korea', 'KRW', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('113', 'AS', 'KW', 'Kuwait', 'kuwait', 'KWD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('114', 'AS', 'KZ', 'Kazakhstan', 'kazakhstan', 'KZT', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('115', '', 'LA', 'Laos', 'laos', 'LAK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('116', 'AS', 'LB', 'Lebanon', 'lebanon', 'LBP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('117', 'NA', 'LC', 'Saint Lucia', 'saint-lucia', 'XCD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('118', 'EU', 'LI', 'Liechtenstein', 'liechtenstein', 'CHF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('119', 'AS', 'LK', 'Sri Lanka', 'sri-lanka', 'LKR', 'Rs', '20.00', '12.00', '', '', '', '', 'Active', '2013-08-21 23:35:34', 'No');
INSERT INTO fc_country VALUES ('120', 'AF', 'LR', 'Liberia', 'liberia', 'LRD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('121', 'AF', 'LS', 'Lesotho', 'lesotho', 'LSL', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('122', 'EU', 'LT', 'Lithuania', 'lithuania', 'LTL', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('123', 'EU', 'LU', 'Luxembourg', 'luxembourg', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('124', 'EU', 'LV', 'Latvia', 'latvia', 'LVL', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('125', '', 'LY', 'Libya', 'libya', 'LYD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('126', 'AF', 'MA', 'Morocco', 'morocco', 'MAD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('127', 'EU', 'MC', 'Monaco', 'monaco', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('128', '', 'MD', 'Moldova', 'moldova', 'MDL', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('129', '', 'ME', 'Montenegro', 'montenegro', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('130', 'AF', 'MG', 'Madagascar', 'madagascar', 'MGF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('131', 'OC', 'MH', 'Marshall Islands', 'marshall-islands', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('132', '', 'MK', 'Macedonia', 'macedonia', 'MKD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('133', 'AF', 'ML', 'Mali', 'mali', 'XOF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('134', 'AS', 'MM', 'Myanmar', 'myanmar', 'MMK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('135', 'AS', 'MN', 'Mongolia', 'mongolia', 'MNT', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('136', '', 'MO', 'Macao', 'macao', 'MOP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('137', 'OC', 'MP', 'Northern Mariana Islands', 'northern-mariana-islands', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('138', 'NA', 'MQ', 'Martinique', 'martinique', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('139', 'AF', 'MR', 'Mauritania', 'mauritania', 'MRO', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('140', 'NA', 'MS', 'Montserrat', 'montserrat', 'XCD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('141', 'AF', 'MU', 'Mauritius', 'mauritius', 'MUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('142', 'AS', 'MV', 'Maldives', 'maldives', 'MVR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('143', 'AF', 'MW', 'Malawi', 'malawi', 'MWK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('144', 'NA', 'MX', 'Mexico', 'mexico', 'MXN', '', '0.00', '0.00', '', '', '', 0x3C703E3C7374726F6E673E54726176656C696E6720746F204D657869636F3C2F7374726F6E673E3C2F703E0D0A3C703E4D657869636F207661636174696F6E2072656E74616C7320616E64204D657869636F207661636174696F6E20686F6D6573206861766520696E6372656173656420696E20766F6C756D652C206173206861732074686520746F757269736D20696E64757374727920696E2074686520617265612E2054686973206973206F6E65206F6620746865206D6F737420706F70756C617220706C6163657320746F20766973697420696E207468652077686F6C65206F66204E6F7274682020416D657269636120616E64206974206973206561737920746F20736565207768792E204D657869636F20636F766572732061206875676520737572666163652061726561206F662061726F756E64203736302C30303020737175617265206D696C65732C207768696368206D65616E73207468657265206973206365727461696E6C79206E6F7420612073686F7274616765206F66207468696E677320746F2073656520616E6420646F20686572652E3C2F703E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E5468696E677320746F20646F20696E204D657869636F3C2F7374726F6E673E3C2F703E0D0A3C703E416674657220636865636B696E6720696E746F204D657869636F207661636174696F6E2072656E74616C7320616E64204D657869636F207661636174696F6E20686F6D65732C206C697374696E672074686520706C6163657320746F207669736974206973206365727461696E6C79206120776F727468207768696C65207468696E6720746F20646F2E204F6E65207468696E672074686174207468697320706C616365206973206B6E6F776E20666F7220697320686176696E6720736F6D65206772656174207369746573206F66206172636861656F6C6F676963616C20696E7465726573742C2077686963682061726520677265617420776974682070656F706C652074686174206C6F766520746F206578706C6F72652E2049742077617320686572652074686174206D616E7920646966666572656E7420666F726D73206F6620636F6D6D756E69636174696F6E207765726520646576656C6F7065642C20696E636C7564696E672077726974696E672E20416C6F6E677369646520746869732C206C6F7473206F662061726974686D6574696320616E6420617374726F6E6F6D7920626173656420646973636F7665726965732068617665206265656E206D6164652068657265206F766572207468652063656E7475726965732C207768696368206D616B6573207468697320616E20696E746572657374696E6720706C61636520746F20766973697420666F7220616C6C206F66207468652066616D696C792E3C2F703E0D0A3C703E266E6273703B3C2F703E0D0A3C703E4F6620636F757273652C206120766973697420746F2061204D657869636F207661636174696F6E2072656E74616C2077696C6C20616C6C6F772070656F706C6520746F206578706C6F726520736F6D65206F6620746865206D616E792062656163686573207468617420617265206F6E206F666665722E20546865207265616C6974792069732074686174207468657265206973206365727461696E6C79206E6F7420612073686F7274616765206F6620746F70207175616C697479206265616368657320746F206578706C6F72652E204D657869636F20697320686F6D6520746F2061726F756E6420362C303030206D696C6573206F6620636F617374206C696E652C207768696368206D65616E7320746861742074686572652061726520612067726561742072616E6765206F6620646966666572656E7420626561636865732C20696E636C7564696E6720636F7665732C2063617665732062757420616C736F20736D616C6C20626179732E20546865207761766573206865726520617265206E6F7420706172746963756C61726C79206C617267652C20627574206D616E79206F66207468652062656163686573206172652077656C6C206B6E6F776E20666F7220696E636F72706F726174696E67206578636974696E672077617465722073706F72747320696E746F20657665727920646179206C6966652E3C2F703E0D0A3C703E266E6273703B3C2F703E0D0A3C703E416C6F6E677369646520746865206265616368657320616E6420746865206D616E79206172636861656F6C6F676963616C20646973636F76657269657320746861742061726520776F727468206578706C6F72696E672C20616E6F74686572206F7074696F6E20697320746F20657870657269656E6365206D616E79206F662074686520616476656E7475726573207468617420617265206F6E206F666665722E204D657869636F2069732066756C6C206F6620746F7572206775696465732074686174207370656369616C69736520696E20616C6C207479706573206F66207468696E67732E205468697320696E636C7564657320746865206C696B6573206F662034783420746F7572732C2062757420616C736F206775696465642077616C6B7320616E64206D6F756E7461696E2062696B652072696465732E205468697320616C6C6F77732070656F706C6520746F206578706C6F7265207468697320677265617420706C616365207573696E6720646966666572656E7420666F726D73206F66207472616E73706F72742C20776869636820616C6C6F7773207468656D20746F20736565204D657869636F20696E20612077686F6C65206E6577206C696768742E204F6620636F757273652C2074686572652061726520706C656E7479206F66206F7074696F6E7320746F2063686F6F73652066726F6D20686572652E3C2F703E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E4163636F6D6D6F646174696F6E7320696E204D657869636F3C2F7374726F6E673E3C2F703E0D0A3C703E4163636F6D6D6F646174696F6E7320696E204D657869636F2068617665206265656E206120687567652070617274206F662068656C70696E6720746F2067726F772074686520746F757269736D20696E64757374727920686572652E20546865205269747A204361726C746F6E206973206365727461696E6C79206F6E65206F6620746865206772656174657220686F74656C7320696E2074686520617265612E204A75737420696E2066726F6E74206F662069742C2069732061726F756E6420312C3230306674206F662077686974652073616E64792062656163682C207768696368206D65616E732072656C6178696E672068657265206973206365727461696E6C79206E6F7420676F696E6720746F20626520646966666963756C742E20497420697320636F6E76656E69656E746C79206C6F63617465642C207768696368206D65616E73207468617420616C6C20746865206D616A6F722061747472616374696F6E73206172652077697468696E20612073686F72742064697374616E6365206F662074686520686F74656C20686572652E2054686520666163696C6974696573206865726520617265206D6F7265207468616E206C75787572696F757320616E6420746865792068656C702070656F706C6520746F2073656520746865207472756520626561757479206F66204D657869636F2E3C2F703E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E5765617468657220696E204D657869636F3C2F7374726F6E673E3C2F703E0D0A3C703E546865207765617468657220696E204D657869636F206973206B6E6F776E20666F72206265696E6720657863657074696F6E616C20647572696E67207468652073756D6D6572206D6F6E7468732C207768696368206D616B6573206974207065726665637420666F7220612073756D6D6572207661636174696F6E2E20447572696E67207468652073756D6D6572206D6F6E7468732C207468726F7567686F757420746869732067726561742064657374696E6174696F6E2C2076697369746F72732073686F756C64206578706563742074656D706572617475726573206F662061726F756E6420323820266465673B43207768696368206973207761726D2C20627574206365727461696E6C7920636F6D666F727461626C65206174207468652073616D652074696D652E20497420697320647572696E67207468652073756D6D6572206D6F6E746873207468617420746865206D616A6F72697479206F662074686520746F757269737473207468617420766973697420686572652E3C2F703E, 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('145', 'AS', 'MY', 'Malaysia', 'malaysia', 'MYR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('146', 'AF', 'MZ', 'Mozambique', 'mozambique', 'MZN', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('147', 'AF', 'NA', 'Namibia', 'namibia', 'NAD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('148', 'OC', 'NC', 'New Caledonia', 'new-caledonia', 'CFP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('149', 'AF', 'NE', 'Niger', 'niger', 'XOF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('150', 'AF', 'NG', 'Nigeria', 'nigeria', 'NGN', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('151', 'NA', 'NI', 'Nicaragua', 'nicaragua', 'NIO', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('152', 'EU', 'NL', 'Netherlands', 'netherlands', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('153', 'EU', 'NO', 'Norway', 'norway', 'NOK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('154', 'AS', 'NP', 'Nepal', 'nepal', 'NPR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('155', 'OC', 'NR', 'Nauru', 'nauru', 'AUD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('156', 'OC', 'NZ', 'New Zealand', 'new-zealand', 'NZD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('157', 'AS', 'OM', 'Oman', 'oman', 'OMR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('158', 'NA', 'PA', 'Panama', 'panama', 'PAB', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('159', 'SA', 'PE', 'Peru', 'peru', 'PEN', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('160', 'OC', 'PF', 'French Polynesia', 'french-polynesia', 'CFP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('161', 'OC', 'PG', 'Papua New Guinea', 'papua-new-guinea', 'PGK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('162', 'AS', 'PH', 'Philippines', 'philippines', 'PHP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('163', 'AS', 'PK', 'Pakistan', 'pakistan', 'PKR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('164', 'EU', 'PL', 'Poland', 'poland', 'PLN', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('165', '', 'PM', 'Saint Pierre And Miquelon', 'saint-pierre-and-miquelon', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('166', 'NA', 'PR', 'Puerto Rico', 'puerto-rico', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('167', '', 'PS', 'Palestinian Territory', 'palestinian-territory', 'PAB', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('168', 'EU', 'PT', 'Portugal', 'portugal', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('169', 'OC', 'PW', 'Palau', 'palau', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('170', 'SA', 'PY', 'Paraguay', 'paraguay', 'PYG', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('171', 'AS', 'QA', 'Qatar', 'qatar', 'QAR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('172', 'AF', 'RE', 'Reunion', 'reunion', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('173', 'EU', 'RO', 'Romania', 'romania', 'RON', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('174', '', 'RS', 'Serbia', 'serbia', 'RSD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('175', '', 'RU', 'Russia', 'russia', 'RUB', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('176', 'AF', 'RW', 'Rwanda', 'rwanda', 'RWF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('177', 'AS', 'SA', 'Saudi Arabia', 'saudi-arabia', 'SAR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('178', 'OC', 'SB', 'Solomon Islands', 'solomon-islands', 'SBD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('179', 'AF', 'SC', 'Seychelles', 'seychelles', 'SCR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('180', 'AF', 'SD', 'Sudan', 'sudan', 'SDG', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('181', 'EU', 'SE', 'Sweden', 'sweden', 'SEK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('182', 'AS', 'SG', 'Singapore', 'singapore', 'SGD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('183', '', 'SH', 'Saint Helena', 'saint-helena', 'SHP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('184', 'EU', 'SI', 'Slovenia', 'slovenia', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('185', '', 'SJ', 'Svalbard And Jan Mayen', 'svalbard-and-jan-mayen', 'NOK', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('186', '', 'SK', 'Slovakia', 'slovakia', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('187', 'AF', 'SL', 'Sierra Leone', 'sierra-leone', 'SLL', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('188', 'EU', 'SM', 'San Marino', 'san-marino', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('189', 'AF', 'SN', 'Senegal', 'senegal', 'XOF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('190', 'AF', 'SO', 'Somalia', 'somalia', 'SOS', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('191', 'SA', 'SR', 'Suriname', 'suriname', 'SRD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('192', '', 'SS', 'South Sudan', 'south-sudan', 'SSP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('193', 'AF', 'ST', 'Sao Tome And Principe', 'sao-tome-and-principe', 'STD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('194', 'NA', 'SV', 'El Salvador', 'el-salvador', 'SVC', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('195', '', 'SY', 'Syria', 'syria', 'SYP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('196', 'AF', 'SZ', 'Swaziland', 'swaziland', 'SZL', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('197', 'AF', 'TD', 'Chad', 'chad', 'XAF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('198', 'AN', 'TF', 'French Southern Territories', 'french-southern-territories', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('199', 'AF', 'TG', 'Togo', 'togo', 'XOF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('200', 'AS', 'TH', 'Thailand', 'thailand', 'THB', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('201', 'AS', 'TJ', 'Tajikistan', 'tajikistan', 'TJS', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('202', 'OC', 'TK', 'Tokelau', 'tokelau', 'NZD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('203', 'OC', 'TL', 'East Timor', 'east-timor', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('204', 'AS', 'TM', 'Turkmenistan', 'turkmenistan', 'TMT', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('205', 'AF', 'TN', 'Tunisia', 'tunisia', 'TND', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('206', 'OC', 'TO', 'Tonga', 'tonga', 'TOP', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('207', 'AS', 'TR', 'Turkey', 'turkey', 'TRY', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('208', 'NA', 'TT', 'Trinidad And Tobago', 'trinidad-and-tobago', 'TTD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('209', 'OC', 'TV', 'Tuvalu', 'tuvalu', 'AUD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('210', 'AS', 'TW', 'Taiwan', 'taiwan', 'TWD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('211', '', 'TZ', 'Tanzania', 'tanzania', 'TZS', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('212', 'EU', 'UA', 'Ukraine', 'ukraine', 'UAH', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('213', 'AF', 'UG', 'Uganda', 'uganda', 'UGX', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('214', 'OC', 'UM', 'United States Minor Outlying Islands', 'united-states-minor-outlying-islands', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('215', 'NA', 'US', 'United States', 'united-states', 'USD', '$', '0.00', '0.00', '', '', '', '', 'Active', '2013-09-13 21:38:13', 'Yes');
INSERT INTO fc_country VALUES ('216', 'SA', 'UY', 'Uruguay', 'uruguay', 'UYU', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('217', 'AS', 'UZ', 'Uzbekistan', 'uzbekistan', 'UZS', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('218', 'NA', 'VC', 'Saint Vincent And The Grenadines', 'saint-vincent-and-the-grenadines', 'XCD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('219', 'SA', 'VE', 'Venezuela', 'venezuela', 'VEF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('220', '', 'VI', 'U.S. Virgin Islands', 'u.s.-virgin-islands', 'USD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('221', '', 'VN', 'Vietnam', 'vietnam', 'VND', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('222', 'OC', 'VU', 'Vanuatu', 'vanuatu', 'VUV', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('223', '', 'WF', 'Wallis And Futuna', 'wallis-and-futuna', 'XPF', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('224', 'OC', 'WS', 'Samoa', 'samoa', 'WST', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('225', '', 'XK', 'Kosovo', 'kosovo', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('226', 'AS', 'YE', 'Yemen', 'yemen', 'YER', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('227', 'AF', 'YT', 'Mayotte', 'mayotte', 'EUR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('228', 'AF', 'ZA', 'South Africa', 'south-africa', 'ZAR', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('229', 'AF', 'ZM', 'Zambia', 'zambia', 'ZMW', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');
INSERT INTO fc_country VALUES ('230', 'AF', 'ZW', 'Zimbabwe', 'zimbabwe', 'ZWD', '', '0.00', '0.00', '', '', '', '', 'Active', '2013-08-21 22:57:12', 'No');

-- ----------------------------
-- Table structure for `fc_couponcards`
-- ----------------------------
DROP TABLE IF EXISTS `fc_couponcards`;
CREATE TABLE `fc_couponcards` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `price_type` enum('1','2','3') NOT NULL DEFAULT '1',
  `coupon_type` varchar(500) NOT NULL,
  `price_value` float(10,2) NOT NULL,
  `quantity` int(100) NOT NULL,
  `description` blob NOT NULL,
  `datefrom` date NOT NULL,
  `dateto` date NOT NULL,
  `category_id` varchar(500) NOT NULL,
  `product_id` varchar(500) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `card_status` enum('redeemed','not used','expired') NOT NULL DEFAULT 'not used',
  `purchase_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_couponcards
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_fancybox`
-- ----------------------------
DROP TABLE IF EXISTS `fc_fancybox`;
CREATE TABLE `fc_fancybox` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` mediumtext NOT NULL,
  `excerpt` mediumtext NOT NULL,
  `description` longtext NOT NULL,
  `image` longtext NOT NULL,
  `price` float(10,2) NOT NULL,
  `likes` bigint(20) NOT NULL,
  `comments` bigint(20) NOT NULL,
  `shipping_cost` float(10,2) NOT NULL,
  `tax` float(10,2) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seourl` mediumtext NOT NULL,
  `category_id` longtext NOT NULL,
  `price_range` mediumtext NOT NULL,
  `purchased` bigint(20) NOT NULL,
  `status` enum('Publish','UnPublish') NOT NULL,
  `meta_title` mediumtext NOT NULL,
  `meta_keyword` mediumtext NOT NULL,
  `meta_description` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_fancybox
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_fancybox_temp`
-- ----------------------------
DROP TABLE IF EXISTS `fc_fancybox_temp`;
CREATE TABLE `fc_fancybox_temp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` mediumtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `fancybox_id` int(11) NOT NULL,
  `image` longtext NOT NULL,
  `price` float(10,2) NOT NULL,
  `fancy_ship_cost` float(10,2) NOT NULL,
  `fancy_tax_cost` float(10,2) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seourl` mediumtext NOT NULL,
  `category_id` longtext NOT NULL,
  `quantity` int(11) NOT NULL,
  `indtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `shipping_id` int(11) NOT NULL,
  `invoice_no` varchar(150) NOT NULL,
  `status` enum('Pending','Paid') NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_fancybox_temp
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_fancybox_uses`
-- ----------------------------
DROP TABLE IF EXISTS `fc_fancybox_uses`;
CREATE TABLE `fc_fancybox_uses` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` mediumtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `fancybox_id` int(11) NOT NULL,
  `image` longtext NOT NULL,
  `price` float(10,2) NOT NULL,
  `fancy_ship_cost` float(10,2) NOT NULL,
  `fancy_tax_cost` float(10,2) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seourl` mediumtext NOT NULL,
  `category_id` longtext NOT NULL,
  `quantity` int(11) NOT NULL,
  `indtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `status` enum('Pending','Paid','Expired') NOT NULL DEFAULT 'Pending',
  `shipping_id` int(11) NOT NULL,
  `invoice_no` varchar(150) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `trans_id` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_fancybox_uses
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_footer`
-- ----------------------------
DROP TABLE IF EXISTS `fc_footer`;
CREATE TABLE `fc_footer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_title` varchar(250) NOT NULL,
  `widget_name` longtext NOT NULL,
  `widget_link` longtext NOT NULL,
  `widget_icon` longtext NOT NULL,
  `status` enum('Active','InActive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_footer
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_giftcards`
-- ----------------------------
DROP TABLE IF EXISTS `fc_giftcards`;
CREATE TABLE `fc_giftcards` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient_name` varchar(200) NOT NULL,
  `recipient_mail` varchar(200) NOT NULL,
  `sender_name` varchar(200) NOT NULL,
  `sender_mail` varchar(200) NOT NULL,
  `price_value` float(10,2) NOT NULL,
  `description` blob NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expiry_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `card_status` enum('redeemed','not used','expired') NOT NULL DEFAULT 'not used',
  `payment_status` enum('Pending','Paid') NOT NULL DEFAULT 'Pending',
  `used_amount` decimal(10,2) NOT NULL,
  `payer_email` varchar(500) NOT NULL,
  `paypal_transaction_id` varchar(500) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_giftcards
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_giftcards_settings`
-- ----------------------------
DROP TABLE IF EXISTS `fc_giftcards_settings`;
CREATE TABLE `fc_giftcards_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `amounts` varchar(200) NOT NULL,
  `default_amount` varchar(100) NOT NULL,
  `expiry_days` int(11) NOT NULL,
  `status` enum('Enable','Disable') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_giftcards_settings
-- ----------------------------
INSERT INTO fc_giftcards_settings VALUES ('1', 'Fancyy Gift Card', 'The perfect present for any occasion. Send a Fancyy Gift Card today and let your friends choose what they love!', 'd342fa6bce0de522e7ae8f3ab672a279.png', '10,25,50,100,500,1000', '100', '90', 'Enable');

-- ----------------------------
-- Table structure for `fc_giftcards_temp`
-- ----------------------------
DROP TABLE IF EXISTS `fc_giftcards_temp`;
CREATE TABLE `fc_giftcards_temp` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient_name` varchar(200) NOT NULL,
  `recipient_mail` varchar(200) NOT NULL,
  `sender_name` varchar(200) NOT NULL,
  `sender_mail` varchar(200) NOT NULL,
  `price_value` float(10,2) NOT NULL,
  `description` blob NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expiry_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `card_status` enum('redeemed','not used','expired') NOT NULL DEFAULT 'not used',
  `payment_status` enum('Pending','Paid') NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_giftcards_temp
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_languages`
-- ----------------------------
DROP TABLE IF EXISTS `fc_languages`;
CREATE TABLE `fc_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_default` enum('No','Yes') NOT NULL,
  `name` varchar(200) NOT NULL,
  `lang_code` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_languages
-- ----------------------------
INSERT INTO fc_languages VALUES ('1', 'Yes', 'English', 'en', 'Active');
INSERT INTO fc_languages VALUES ('2', 'No', 'CatalÃ ', 'ca', 'Active');
INSERT INTO fc_languages VALUES ('4', 'No', 'dansk', 'da', 'Inactive');
INSERT INTO fc_languages VALUES ('5', 'No', 'Deutsch', 'de', 'Active');
INSERT INTO fc_languages VALUES ('7', 'No', 'EspaÃ±ol', 'es', 'Inactive');
INSERT INTO fc_languages VALUES ('8', 'No', 'Eesti', 'et', 'Inactive');
INSERT INTO fc_languages VALUES ('9', 'No', 'Basque', 'eu', 'Active');
INSERT INTO fc_languages VALUES ('10', 'No', 'Filipino', 'fil', 'Inactive');
INSERT INTO fc_languages VALUES ('11', 'No', 'franÃ§ais', 'fr', 'Inactive');
INSERT INTO fc_languages VALUES ('12', 'No', 'Indonesian', 'id', 'Inactive');
INSERT INTO fc_languages VALUES ('13', 'No', 'Ãslenska', 'is', 'Inactive');
INSERT INTO fc_languages VALUES ('14', 'No', 'Italiano', 'it', 'Inactive');
INSERT INTO fc_languages VALUES ('15', 'No', 'Lithuanian', 'lt', 'Inactive');
INSERT INTO fc_languages VALUES ('16', 'No', 'Nederlands', 'nl', 'Inactive');
INSERT INTO fc_languages VALUES ('17', 'No', 'norsk', 'no', 'Inactive');
INSERT INTO fc_languages VALUES ('18', 'No', 'Polski', 'pl', 'Inactive');
INSERT INTO fc_languages VALUES ('19', 'No', 'PortuguÃªs (br)', 'br', 'Inactive');
INSERT INTO fc_languages VALUES ('20', 'No', 'PortuguÃªs (pt)', 'pt', 'Inactive');
INSERT INTO fc_languages VALUES ('23', 'No', 'SlovenskÃ½', 'sk', 'Inactive');
INSERT INTO fc_languages VALUES ('24', 'No', 'Suomi', 'fi', 'Inactive');
INSERT INTO fc_languages VALUES ('27', 'No', 'TÃ¼rkÃ§e', 'tr', 'Inactive');
INSERT INTO fc_languages VALUES ('30', 'No', 'srpski (latinica)', 'sr-latn', 'Inactive');
INSERT INTO fc_languages VALUES ('31', 'No', 'svenska', 'sv', 'Inactive');
INSERT INTO fc_languages VALUES ('32', 'No', 'Thai', 'th', 'Inactive');

-- ----------------------------
-- Table structure for `fc_lists`
-- ----------------------------
DROP TABLE IF EXISTS `fc_lists`;
CREATE TABLE `fc_lists` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `product_id` longtext NOT NULL,
  `description` blob NOT NULL,
  `followers` longtext NOT NULL,
  `banner` varchar(200) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `contributors` longtext NOT NULL,
  `contributors_invited` longtext NOT NULL,
  `product_count` bigint(20) NOT NULL,
  `followers_count` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_lists
-- ----------------------------
INSERT INTO fc_lists VALUES ('1', 'Technology', '1', '1414345236,1414508137', '', '', '', '0', '', '', '0', '0');
INSERT INTO fc_lists VALUES ('2', 'Technology', '2', '1414507267', '', '', '', '0', '', '', '0', '0');
INSERT INTO fc_lists VALUES ('3', 'Technology', '3', ',1414345236,1414508137', '', '', '', '0', '', '', '0', '0');

-- ----------------------------
-- Table structure for `fc_list_values`
-- ----------------------------
DROP TABLE IF EXISTS `fc_list_values`;
CREATE TABLE `fc_list_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_id` int(11) NOT NULL,
  `list_value` varchar(200) NOT NULL,
  `products` longtext NOT NULL,
  `product_count` bigint(20) NOT NULL,
  `followers` longtext NOT NULL,
  `followers_count` bigint(20) NOT NULL,
  `list_value_seourl` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_list_values
-- ----------------------------
INSERT INTO fc_list_values VALUES ('1', '1', 'blue', ',3', '1', '', '0', 'blue');
INSERT INTO fc_list_values VALUES ('2', '1', 'white', '', '0', '', '0', 'white');
INSERT INTO fc_list_values VALUES ('3', '1', 'red', '', '0', '', '0', 'red');
INSERT INTO fc_list_values VALUES ('4', '1', 'pink', '', '0', '', '0', 'pink');
INSERT INTO fc_list_values VALUES ('5', '1', 'purple', '', '0', '', '0', 'purple');
INSERT INTO fc_list_values VALUES ('6', '1', 'skyblue', '', '0', '', '0', 'skyblue');
INSERT INTO fc_list_values VALUES ('7', '1', 'green', '', '0', '', '0', 'green');
INSERT INTO fc_list_values VALUES ('8', '1', 'yellow', '', '0', '', '0', 'yellow');
INSERT INTO fc_list_values VALUES ('9', '1', 'orange', '', '0', '', '0', 'orange');
INSERT INTO fc_list_values VALUES ('10', '1', 'brown', '', '0', '', '0', 'brown');
INSERT INTO fc_list_values VALUES ('11', '1', 'black', ',1382108663', '1', '', '0', 'black');
INSERT INTO fc_list_values VALUES ('12', '1', 'silver', '', '0', '', '0', 'silver');
INSERT INTO fc_list_values VALUES ('13', '1', 'gold', '', '0', '', '0', 'gold');
INSERT INTO fc_list_values VALUES ('14', '2', '1-20', ',4,21,25,13', '4', '', '0', '1-20');
INSERT INTO fc_list_values VALUES ('15', '2', '21-100', ',8,10,11,20,22,3', '6', '', '0', '21-100');
INSERT INTO fc_list_values VALUES ('16', '2', '101-200', ',7,17,18,19,23,1', '6', '', '0', '101-200');
INSERT INTO fc_list_values VALUES ('17', '2', '201-500', ',9,24,26,28,29,4', '6', '', '0', '201-500');
INSERT INTO fc_list_values VALUES ('18', '2', '501+', ',27,2', '2', '', '0', '501');

-- ----------------------------
-- Table structure for `fc_location`
-- ----------------------------
DROP TABLE IF EXISTS `fc_location`;
CREATE TABLE `fc_location` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(1000) NOT NULL,
  `location_code` varchar(500) NOT NULL,
  `iso_code2` varchar(500) NOT NULL,
  `iso_code3` varchar(500) NOT NULL,
  `country_tax` float(10,2) NOT NULL,
  `country_ship` decimal(10,2) NOT NULL,
  `seourl` varchar(1000) NOT NULL,
  `currency_type` varchar(500) NOT NULL,
  `currency_symbol` varchar(500) NOT NULL,
  `status` enum('Active','InActive') NOT NULL,
  `dateAdded` datetime NOT NULL,
  `meta_title` longblob NOT NULL,
  `meta_keyword` longblob NOT NULL,
  `meta_description` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_location
-- ----------------------------
INSERT INTO fc_location VALUES ('1', 'IN', '', '', '', '5.00', '15.00', 'india', 'INR', 'Rs', 'InActive', '2013-07-26 04:10:15', '', '', '');
INSERT INTO fc_location VALUES ('3', 'USA', '', 'US', 'USA', '1.00', '0.00', 'usa', 'USD', '$', 'Active', '2013-07-26 12:00:00', 0x555341, 0x555341, 0x555341);
INSERT INTO fc_location VALUES ('6', 'Uk', '', '', '', '10.00', '10.00', 'uk', 'USD', '$', 'InActive', '2013-07-29 13:00:00', '', '', '');
INSERT INTO fc_location VALUES ('7', 'Australia', '', 'AU', '', '10.00', '20.00', 'australia', 'AUD', '$', 'InActive', '2013-08-21 11:00:00', '', '', '');

-- ----------------------------
-- Table structure for `fc_newsletter`
-- ----------------------------
DROP TABLE IF EXISTS `fc_newsletter`;
CREATE TABLE `fc_newsletter` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(5000) NOT NULL,
  `news_descrip` blob NOT NULL,
  `status` enum('Active','InActive') NOT NULL,
  `dateAdded` datetime NOT NULL,
  `news_image` varchar(500) NOT NULL,
  `news_subject` varchar(1000) NOT NULL,
  `sender_name` varchar(500) NOT NULL,
  `sender_email` varchar(500) NOT NULL,
  `news_seourl` varchar(1000) NOT NULL,
  `typeVal` enum('1','2') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_newsletter
-- ----------------------------
INSERT INTO fc_newsletter VALUES ('1', 'Notification Mail', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0D0A3C74626F64793E0D0A3C74723E0D0A3C7464207374796C653D2270616464696E673A20343070783B223E0D0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F7D2220616C743D227B246D6574615F7469746C657D22202F3E3C2F613E3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74642076616C69676E3D22746F70223E0D0A3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C746420636F6C7370616E3D2232223E0D0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E4869207B2466756C6C5F6E616D657D2C3C2F68333E0D0A3C70207374796C653D2270616464696E673A203070782031357078203130707820313570783B20666F6E742D73697A653A20313270783B206D617267696E3A203070783B223E266E6273703B3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E7B2466756C6C5F6E616D657D20636F6D6D656E746564206F6E203C6120687265663D227B2470726F644C696E6B7D223E7B2470726F647563745F6E616D657D3C2F613E2E20546F20736565207B2466756C6C5F6E616D657D5C27732070726F66696C65203C6120687265663D227B626173655F75726C28297D757365722F7B24757365725F6E616D657D223E636C69636B20686572653C2F613E2E3C2F703E0D0A3C2F74643E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E2D207B24656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E, 'Active', '0000-00-00 00:00:00', '', 'Notification Mail', 'Wanelo-V2.0', 'support@waneloo.com', '', '2');
INSERT INTO fc_newsletter VALUES ('2', 'show you something', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0D0A3C74626F64793E0D0A3C74723E0D0A3C7464207374796C653D2270616464696E673A20343070783B223E0D0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F7D2220616C743D227B246D6574615F7469746C657D22202F3E3C2F613E3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74642076616C69676E3D22746F70223E0D0A3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C746420636F6C7370616E3D2232223E0D0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E7B24756E616D657D2074686F7567687420796F7520776F756C64206C696B653C2F68333E0D0A3C70207374796C653D2270616464696E673A203070782031357078203130707820313570783B20666F6E742D73697A653A20313270783B206D617267696E3A203070783B223E3C6120687265663D227B2475726C7D223E7B246E616D657D3C2F613E3C2F703E0D0A3C703E3C6120687265663D227B2475726C7D223E3C696D67207372633D227B2474696D6167657D2220616C743D2222202F3E3C2F613E3C2F703E0D0A3C703E7B246D73677D3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E2D202724656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E, 'Active', '0000-00-00 00:00:00', '', 'wants to show you something on', 'Wanelo-V2.0', 'support@waneloo.com', '', '2');
INSERT INTO fc_newsletter VALUES ('3', 'Registration Confirmation', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0A3C74626F64793E0A3C74723E0A3C7464207374796C653D2270616464696E673A20343070783B223E0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0A3C74626F64793E0A3C74723E0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F7D2220616C743D227B246D6574615F7469746C657D22202F3E3C2F613E3C2F74643E0A3C2F74723E0A3C74723E0A3C74642076616C69676E3D22746F70223E0A3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0A3C74626F64793E0A3C74723E0A3C746420636F6C7370616E3D2232223E0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E436F6E6669726D20796F757220656D61696C20616464726573733C2F68333E0A3C70207374796C653D2270616464696E673A203070782031357078203130707820313570783B20666F6E742D73697A653A20313270783B206D617267696E3A203070783B223E266E6273703B3C2F703E0A3C2F74643E0A3C2F74723E0A3C74723E0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0A3C703E3C6120687265663D227B2463666D75726C7D22207461726765743D225F626C616E6B223E436C69636B206865726520746F20636F6E6669726D20796F757220656D61696C206164647265737320696E207B24656D61696C5F7469746C652E7B3C2F613E3C2F703E0A3C2F74643E0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0A3C703E266E6273703B3C2F703E0A3C703E3C7374726F6E673E2D207B24656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0A3C2F74643E0A3C2F74723E0A3C2F74626F64793E0A3C2F7461626C653E0A3C2F74643E0A3C2F74723E0A3C2F74626F64793E0A3C2F7461626C653E0A3C2F74643E0A3C2F74723E0A3C2F74626F64793E0A3C2F7461626C653E, 'Active', '0000-00-00 00:00:00', '', 'Registration Confirmation', 'eshoppinx', 'support@eshoppinx.com', '', '2');
INSERT INTO fc_newsletter VALUES ('4', 'Password Reset', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0D0A3C74626F64793E0D0A3C74723E0D0A3C7464207374796C653D2270616464696E673A20343070783B223E0D0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F7D2220616C743D227B246D6574615F7469746C657D22202F3E3C2F613E3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74642076616C69676E3D22746F70223E0D0A3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C746420636F6C7370616E3D2232223E0D0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E486572655C277320596F7572204E65772050617373776F72643C2F68333E0D0A3C70207374796C653D2270616464696E673A203070782031357078203130707820313570783B20666F6E742D73697A653A20313270783B206D617267696E3A203070783B223E4861766520796F7520666F7267657474656E20796F75722070617373776F72643F20446F6E5C277420776F7272792E2057652061726520726573657420796F75722070617373776F72642E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E3C7374726F6E673E4E65772050617373776F7264203A3C2F7374726F6E673E207B247077647D3C2F703E0D0A3C703E596F752063616E206C6F67696E207573696E672061626F76652070617373776F726420616E64206368616E676520796F75722070617373776F726420696D6D6564696174656C792E3C2F703E0D0A3C2F74643E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E2D20546865207B24656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E, 'Active', '0000-00-00 00:00:00', '', 'Password Reset', 'Wanelo-V2.0', 'support@waneloo.com', '', '2');
INSERT INTO fc_newsletter VALUES ('5', 'Forgot Password', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0D0A3C74626F64793E0D0A3C74723E0D0A3C7464207374796C653D2270616464696E673A20343070783B223E0D0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F7D2220616C743D227B246D6574615F7469746C657D22202F3E3C2F613E3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74642076616C69676E3D22746F70223E0D0A3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C746420636F6C7370616E3D2232223E0D0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E486572655C277320596F7572204E65772050617373776F72643C2F68333E0D0A3C70207374796C653D2270616464696E673A203070782031357078203130707820313570783B20666F6E742D73697A653A20313270783B206D617267696E3A203070783B223E4861766520796F7520666F7267657474656E20796F75722070617373776F72643F20446F6E5C277420776F7272792E2057652061726520726573657420796F75722070617373776F72642E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E3C7374726F6E673E4E65772050617373776F7264203A3C2F7374726F6E673E207B247077647D3C2F703E0D0A3C703E596F752063616E206C6F67696E207573696E672061626F76652070617373776F726420616E64206368616E676520796F75722070617373776F726420696D6D6564696174656C792E3C2F703E0D0A3C2F74643E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E2D207B24656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E, 'Active', '0000-00-00 00:00:00', '', 'Forgot Password', 'Wanelo-V2.0', 'support@waneloo.com', '', '2');
INSERT INTO fc_newsletter VALUES ('6', 'send mail subcribers list', 0x3C646976207374796C653D2277696474683A2036303070783B206261636B67726F756E643A20234646464646463B206D617267696E3A2030206175746F3B20626F726465722D7261646975733A20313070783B20626F782D736861646F773A203020302035707820236363633B20626F726465723A2031707820736F6C696420234441374341463B223E0D0A3C646976207374796C653D226261636B67726F756E643A20236637663766373B2070616464696E673A20313070783B20626F726465722D7261646975733A20313070782031307078203020303B20746578742D616C69676E3A2063656E7465723B223E3C6120687265663D227B626173655F75726C28297D22207461726765743D225F626C616E6B223E3C696D67207374796C653D226D617267696E3A20357078203230707820307078203070783B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F5F696D6167657D2220626F726465723D22302220616C743D227B247469746C657D222077696474683D2232303522202F3E203C2F613E3C2F6469763E0D0A3C646976207374796C653D226261636B67726F756E643A20236666663B2070616464696E673A20313070783B2077696474683A2035383070783B223E0D0A3C646976207374796C653D22666F6E742D66616D696C793A204D79726961642050726F3B20666F6E742D73697A653A20323470783B20636F6C6F723A20236461376361663B2070616464696E672D626F74746F6D3A20313570783B20666F6E742D7765696768743A20626F6C643B223E7B246E6577735F7375626A6563747D3C2F6469763E0D0A3C646976207374796C653D22666F6E742D66616D696C793A204D79726961642050726F3B20666F6E742D73697A653A20313670783B20636F6C6F723A20233030303B2070616464696E672D626F74746F6D3A20313570783B206C696E652D6865696768743A20323470783B20746578742D616C69676E3A206A7573746966793B223E7B246E6577735F646573637269707D3C2F6469763E0D0A3C646976207374796C653D22666F6E742D66616D696C793A204D79726961642050726F3B20666F6E742D73697A653A20313670783B20636F6C6F723A20233030303B2070616464696E672D626F74746F6D3A20313570783B206C696E652D6865696768743A20323470783B20746578742D616C69676E3A206A7573746966793B223E496620796F75206861766520616E79207175657374696F6E7320706C6561736520656D61696C203C61207374796C653D22636F6C6F723A20233565613030383B20746578742D6465636F726174696F6E3A206E6F6E653B2220687265663D226D61696C746F3A7B24746869732D2667743B636F6E6669672D2667743B6974656D2827656D61696C27297D223E7B24656D61696C7D3C2F613E3C2F6469763E0D0A3C646976207374796C653D22666F6E742D66616D696C793A204D79726961642050726F3B20666F6E742D73697A653A20313870783B20636F6C6F723A20233030303B2070616464696E672D626F74746F6D3A20313570783B206C696E652D6865696768743A20323870783B223E53696E636572656C79202C203C6272202F3E204D616E6167656D656E743C2F6469763E0D0A3C2F6469763E0D0A3C2F6469763E, 'Active', '0000-00-00 00:00:00', '', 'send mail subcribers list', 'Wanelo-V2.0', 'support@waneloo.com', '', '2');
INSERT INTO fc_newsletter VALUES ('7', 'Follow User Details', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0D0A3C74626F64793E0D0A3C74723E0D0A3C7464207374796C653D2270616464696E673A20343070783B223E0D0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F7D2220616C743D227B246D6574615F7469746C657D22202F3E3C2F613E3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74642076616C69676E3D22746F70223E0D0A3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C746420636F6C7370616E3D2232223E0D0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E4869207B2466756C6C5F6E616D657D2C3C2F68333E0D0A3C70207374796C653D2270616464696E673A203070782031357078203130707820313570783B20666F6E742D73697A653A20313270783B206D617267696E3A203070783B223E266E6273703B3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E7B2466756C6C5F6E616D657D20666F6C6C6F777320796F75206F6E207B24656D61696C5F7469746C652E7B20546F20736565207B246366756C6C5F6E616D657D5C27732070726F66696C65203C6120687265663D227B626173655F75726C28297D757365722F7B24757365725F6E616D657D223E636C69636B20686572653C2F613E2E3C2F703E0D0A3C2F74643E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E2D207B24656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E, 'Active', '0000-00-00 00:00:00', '', 'Follow User Details', 'Wanelo-V2.0', 'support@waneloo.com', '', '2');
INSERT INTO fc_newsletter VALUES ('8', 'Notification Mail for Comments', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0D0A3C74626F64793E0D0A3C74723E0D0A3C7464207374796C653D2270616464696E673A20343070783B223E0D0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F7D2220616C743D227B246D6574615F7469746C657D22202F3E3C2F613E3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74642076616C69676E3D22746F70223E0D0A3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C746420636F6C7370616E3D2232223E0D0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E4869207B2466756C6C5F6E616D657D2C3C2F68333E0D0A3C70207374796C653D2270616464696E673A203070782031357078203130707820313570783B20666F6E742D73697A653A20313270783B206D617267696E3A203070783B223E266E6273703B3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E7B2466756C6C5F6E616D657D20636F6D6D656E746564206F6E203C6120687265663D227B2470726F644C696E6B7D223E7B2470726F647563745F6E616D657D3C2F613E2E20546F20736565207B246366756C6C5F6E616D657D5C27732070726F66696C65203C6120687265663D227B626173655F75726C28297D757365722F7B24757365725F6E616D657D223E636C69636B20686572653C2F613E2E3C2F703E0D0A3C2F74643E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E2D207B24656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E, 'Active', '0000-00-00 00:00:00', '', 'Notification Mail for Comments', 'Wanelo-V2.0', 'support@waneloo.com', '', '2');
INSERT INTO fc_newsletter VALUES ('9', 'Follows User Notification Mail', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0D0A3C74626F64793E0D0A3C74723E0D0A3C7464207374796C653D2270616464696E673A20343070783B223E0D0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F7D2220616C743D227B246D6574615F7469746C657D22202F3E3C2F613E3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74642076616C69676E3D22746F70223E0D0A3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C746420636F6C7370616E3D2232223E0D0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E4869207B2466756C6C5F6E616D657D2C3C2F68333E0D0A3C70207374796C653D2270616464696E673A203070782031357078203130707820313570783B20666F6E742D73697A653A20313270783B206D617267696E3A203070783B223E266E6273703B3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E7B2466756C6C5F6E616D657D20666F6C6C6F777320796F75206F6E207B24656D61696C5F7469746C652E7B20546F20736565207B246366756C6C5F6E616D657D5C27732070726F66696C65203C6120687265663D227B626173655F75726C28297D757365722F7B24757365725F6E616D657D223E636C69636B20686572653C2F613E2E3C2F703E0D0A3C2F74643E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E2D207B24656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E, 'Active', '2013-07-25 00:00:00', '', 'Follows User Notification Mail', 'Wanelo-V2.0', 'support@waneloo.com', '', '2');
INSERT INTO fc_newsletter VALUES ('10', 'Notification Mail Featured product', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0D0A3C74626F64793E0D0A3C74723E0D0A3C7464207374796C653D2270616464696E673A20343070783B223E0D0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B24746869732D2667743B646174615B276C6F676F7D2220616C743D227B24746869732D2667743B636F6E6669672D2667743B6974656D28276D6574615F7469746C6527297D22202F3E3C2F613E3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74642076616C69676E3D22746F70223E0D0A3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C746420636F6C7370616E3D2232223E0D0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E4869207B2466756C6C5F6E616D657D2C3C2F68333E0D0A3C70207374796C653D2270616464696E673A203070782031357078203130707820313570783B20666F6E742D73697A653A20313270783B206D617267696E3A203070783B223E266E6273703B3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E7B246366756C6C5F6E616D657D20666561747572656420796F75722070726F64756374203C6120687265663D227B2470726F644C696E6B7D223E7B2470726F647563745F6E616D657D3C2F613E2E20546F20736565207B246366756C6C5F6E616D657D5C27732070726F66696C65203C6120687265663D227B626173655F75726C28297D757365722F7B24757365725F6E616D657D223E636C69636B20686572653C2F613E2E3C2F703E0D0A3C2F74643E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E2D207B24656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E, 'Active', '2013-07-26 00:00:00', '', 'Notification Mail Featured product', 'Wanelo-V2.0', 'support@waneloo.com', '', '2');
INSERT INTO fc_newsletter VALUES ('11', 'Tag Notification', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0D0A3C74626F64793E0D0A3C74723E0D0A3C7464207374796C653D2270616464696E673A20343070783B223E0D0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F7D2220616C743D227B246D6574615F7469746C657D22202F3E3C2F613E3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74642076616C69676E3D22746F70223E0D0A3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C746420636F6C7370616E3D2232223E0D0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E3C6120687265663D227B626173655F75726C28297D757365722F7B24757365725F6E616D657D223E7B2466756C6C5F6E616D657D3C2F613E2074616767656420796F75206F6E20612070726F647563742E20546F20736565207468652070726F64756374203C6120687265663D227B2470726F644C696E6B7D223E636C69636B20686572653C2F613E3C2F68333E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222077696474683D22353025222076616C69676E3D22746F70223E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E2D207B24656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E, 'Active', '2013-07-26 00:00:00', '', 'Tag Notification', 'Wanelo-V2.0', 'support@waneloo.com', '', '2');
INSERT INTO fc_newsletter VALUES ('16', 'contactseller', 0x3C7461626C6520626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D2236343022206267636F6C6F723D2223376461326331223E0D0A3C74626F64793E0D0A3C74723E0D0A3C7464207374796C653D2270616464696E673A20343070783B223E0D0A3C7461626C65207374796C653D22626F726465723A20233164343536372031707820736F6C69643B20666F6E742D66616D696C793A20417269616C2C2048656C7665746963612C2073616E732D73657269663B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D2230222077696474683D22363130223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D223E3C696D67207374796C653D226D617267696E3A20313570782035707820303B2070616464696E673A203070783B20626F726465723A206E6F6E653B22207372633D227B626173655F75726C28297D696D616765732F6C6F676F2F7B246C6F676F7D2220616C743D227B246D6574615F7469746C657D22202F3E3C2F613E3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74642076616C69676E3D22746F70223E0D0A3C7461626C65207374796C653D2277696474683A20313030253B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C746420636F6C7370616E3D2232223E0D0A3C6833207374796C653D2270616464696E673A203130707820313570783B206D617267696E3A203070783B20636F6C6F723A20233064343837613B223E436F6E746163742053656C6C65723C2F68333E0D0A3C70207374796C653D2270616464696E673A203070782031357078203130707820313570783B20666F6E742D73697A653A20313270783B206D617267696E3A203070783B223E266E6273703B3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222076616C69676E3D22746F70223E0D0A3C703E3C7374726F6E673E436F6E74616374204E616D65203A3C2F7374726F6E673E207B246E616D657D3C2F703E0D0A3C703E3C7374726F6E673E436F6E7461637420456D61696C203A3C2F7374726F6E673E207B24656D61696C7D3C2F703E0D0A3C703E3C7374726F6E673E436F6E746163742050686F6E65203A3C2F7374726F6E673E207B2470686F6E657D3C2F703E0D0A3C703E3C7374726F6E673E436F6E74616374205175657374696F6E203A3C2F7374726F6E673E207B247175657374696F6E7D3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C7461626C65207374796C653D2277696474683A20313030253B2220626F726465723D2230222063656C6C73706163696E673D2230222063656C6C70616464696E673D223022206267636F6C6F723D2223464646464646223E0D0A3C74626F64793E0D0A3C74723E0D0A3C74643E50726F64756374204E616D653C2F74643E0D0A3C74643E50726F6475637420496D6167653C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C74643E3C6120687265663D227B626173655F75726C28297D7468696E67732F7B2470726F6475637449647D2F7B2470726F6475637453656F75726C7D223E7B2470726F647563744E616D657D3C2F613E3C2F74643E0D0A3C74643E3C696D67207372633D22696D616765732F70726F647563742F7B2470726F64756374496D6167657D2220616C743D227B2470726F64756374496D6167657D222077696474683D2231303022202F3E3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C74723E0D0A3C7464207374796C653D22666F6E742D73697A653A20313270783B2070616464696E673A203130707820313570783B222076616C69676E3D22746F70223E0D0A3C703E266E6273703B3C2F703E0D0A3C703E3C7374726F6E673E2D207B24656D61696C5F7469746C657D205465616D3C2F7374726F6E673E3C2F703E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E0D0A3C2F74643E0D0A3C2F74723E0D0A3C2F74626F64793E0D0A3C2F7461626C653E, 'Active', '2014-03-11 00:00:00', '', 'Someone Contacts You', 'Wanelo-V2.0', 'support@waneloo.com', '', '1');

-- ----------------------------
-- Table structure for `fc_notifications`
-- ----------------------------
DROP TABLE IF EXISTS `fc_notifications`;
CREATE TABLE `fc_notifications` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `activity` mediumtext COLLATE utf8_bin NOT NULL,
  `activity_id` bigint(20) NOT NULL,
  `activity_ip` mediumtext COLLATE utf8_bin NOT NULL,
  `comment_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of fc_notifications
-- ----------------------------
INSERT INTO fc_notifications VALUES ('1', '2014-10-26 05:40:53', '1', 0x6C696B65, '1414345236', 0x32332E3234302E3139342E313234, '0');
INSERT INTO fc_notifications VALUES ('2', '2014-10-28 04:14:09', '1', 0x666F6C6C6F77, '1', 0x32332E3234302E3139342E313234, '0');
INSERT INTO fc_notifications VALUES ('3', '2014-10-28 02:41:20', '2', 0x6C696B65, '1414507267', 0x3131352E3131382E3135332E3437, '0');
INSERT INTO fc_notifications VALUES ('4', '2014-10-28 02:55:52', '1', 0x6C696B65, '1414508137', 0x32332E3234302E3139342E313234, '0');
INSERT INTO fc_notifications VALUES ('5', '2014-12-17 10:14:52', '3', 0x666F6C6C6F772D73746F7265, '2', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('6', '2014-12-17 10:20:14', '3', 0x666F6C6C6F772D73746F7265, '2', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('7', '2014-12-17 10:20:24', '3', 0x666F6C6C6F77, '1', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('8', '2014-12-17 10:21:53', '3', 0x666F6C6C6F772D73746F7265, '6', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('9', '2014-12-17 10:22:44', '3', 0x6C696B65, '1414345236', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('10', '2014-12-17 10:22:58', '3', 0x6C696B65, '1414508137', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('11', '2014-12-17 10:23:05', '3', 0x6F776E2D70726F647563742D636F6D6D656E74, '1414508137', 0x3139322E3136382E312E3330, '1');
INSERT INTO fc_notifications VALUES ('15', '2014-12-17 10:36:08', '3', 0x666F6C6C6F772D73746F7265, '2', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('16', '2014-12-17 10:36:31', '3', 0x666F6C6C6F772D73746F7265, '2', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('17', '2014-12-17 10:36:39', '3', 0x666F6C6C6F772D73746F7265, '2', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('18', '2014-12-17 10:36:47', '3', 0x666F6C6C6F772D73746F7265, '2', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('19', '2014-12-17 10:37:42', '3', 0x666F6C6C6F77, '1', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('20', '2014-12-17 10:43:15', '3', 0x666F6C6C6F772D73746F7265, '3', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('21', '2014-12-17 10:43:24', '3', 0x666F6C6C6F772D73746F7265, '1', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('22', '2014-12-17 10:43:51', '3', 0x666F6C6C6F772D73746F7265, '1', 0x3139322E3136382E312E3330, '0');
INSERT INTO fc_notifications VALUES ('23', '2014-12-17 10:58:12', '3', 0x6F776E2D70726F647563742D636F6D6D656E74, '1414508137', 0x3139322E3136382E312E3330, '2');

-- ----------------------------
-- Table structure for `fc_payment`
-- ----------------------------
DROP TABLE IF EXISTS `fc_payment`;
CREATE TABLE `fc_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(100) NOT NULL,
  `sell_id` bigint(20) NOT NULL,
  `product_id` int(100) NOT NULL,
  `price` varchar(500) NOT NULL,
  `quantity` varchar(500) NOT NULL,
  `is_coupon_used` enum('Yes','No') NOT NULL,
  `session_id` varchar(200) NOT NULL,
  `coupon_id` varchar(200) NOT NULL,
  `discountAmount` varchar(500) NOT NULL,
  `couponCode` varchar(500) NOT NULL,
  `coupontype` varchar(500) NOT NULL,
  `shippingid` int(16) NOT NULL,
  `indtotal` varchar(500) NOT NULL,
  `sumtotal` decimal(10,2) NOT NULL,
  `total` varchar(100) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `shippingcost` varchar(500) NOT NULL,
  `shippingcountry` varchar(500) NOT NULL,
  `shippingcity` varchar(500) NOT NULL,
  `shippingstate` varchar(500) NOT NULL,
  `paidVoucherStatus` enum('Not Verified','Verified') NOT NULL,
  `paypal_transaction_id` varchar(500) NOT NULL,
  `dealCodeNumber` varchar(500) NOT NULL,
  `inserttime` varchar(65) NOT NULL,
  `status` enum('Pending','Paid') NOT NULL,
  `shipping_date` date NOT NULL,
  `tracking_id` varchar(100) NOT NULL,
  `shipping_status` varchar(100) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `attribute_values` text NOT NULL,
  `product_shipping_cost` decimal(10,2) NOT NULL,
  `product_tax_cost` decimal(10,2) NOT NULL,
  `note` blob NOT NULL,
  `order_gift` enum('0','1') NOT NULL DEFAULT '0',
  `payer_email` varchar(500) NOT NULL,
  `received_status` enum('Not received yet','Product received','Need refund') NOT NULL,
  `review_status` enum('Not open','Opened','Closed') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_payment
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_payment_gateway`
-- ----------------------------
DROP TABLE IF EXISTS `fc_payment_gateway`;
CREATE TABLE `fc_payment_gateway` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gateway_name` varchar(200) NOT NULL,
  `settings` text NOT NULL,
  `status` enum('Enable','Disable') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_payment_gateway
-- ----------------------------
INSERT INTO fc_payment_gateway VALUES ('1', 'Paypal IPN', 'a:3:{s:4:\"mode\";s:7:\"sandbox\";s:14:\"merchant_email\";s:35:\"vinubusiness1-facilitator@gmail.com\";s:14:\"paypal_ipn_url\";s:11:\"www.ipn.net\";}', 'Enable');
INSERT INTO fc_payment_gateway VALUES ('2', 'Credit Card (Paypal)', 'a:4:{s:4:\"mode\";s:7:\"sandbox\";s:19:\"Paypal_API_Username\";s:40:\"sandbo_1215254764_biz_api1.angelleye.com\";s:19:\"paypal_api_password\";s:10:\"1215254774\";s:20:\"paypal_api_Signature\";s:56:\"AiKZhEEPLJjSIccz.2M.tbyW5YFwAb6E3l6my.pY9br1z2qxKx96W18v\";}', 'Disable');
INSERT INTO fc_payment_gateway VALUES ('3', 'Credit Card (Authorize.net)', 'a:3:{s:4:\"mode\";s:7:\"sandbox\";s:8:\"Login_ID\";s:8:\"3Vf82YuX\";s:15:\"Transaction_Key\";s:16:\"47UfHXH638bbH26m\";}', 'Enable');

-- ----------------------------
-- Table structure for `fc_product`
-- ----------------------------
DROP TABLE IF EXISTS `fc_product`;
CREATE TABLE `fc_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_product_id` bigint(20) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `seourl` varchar(500) NOT NULL,
  `meta_title` longblob NOT NULL,
  `meta_keyword` longblob NOT NULL,
  `meta_description` longblob NOT NULL,
  `excerpt` varchar(500) NOT NULL,
  `category_id` varchar(500) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `price_range` varchar(100) NOT NULL,
  `sale_price` decimal(20,2) NOT NULL,
  `image` longtext NOT NULL,
  `description` longtext NOT NULL,
  `weight` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchasedCount` int(11) NOT NULL,
  `status` enum('Publish','UnPublish') NOT NULL DEFAULT 'Publish',
  `featured` enum('Yes','No') NOT NULL,
  `shipping_type` enum('Shippable','Not Shippable') NOT NULL,
  `shipping_cost` decimal(6,2) NOT NULL,
  `taxable_type` enum('Taxable','Not Taxable') NOT NULL,
  `tax_cost` decimal(6,2) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `option` longtext NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `likes` bigint(20) NOT NULL DEFAULT '0',
  `list_name` longtext NOT NULL,
  `list_value` longtext NOT NULL,
  `comment_count` bigint(20) NOT NULL,
  `ship_immediate` enum('false','true') NOT NULL,
  `youtube` text NOT NULL,
  `shipping_policies` longtext NOT NULL,
  `xchange_policy` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_product
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_product_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `fc_product_attribute`;
CREATE TABLE `fc_product_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(500) NOT NULL,
  `attr_seourl` varchar(500) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_product_attribute
-- ----------------------------
INSERT INTO fc_product_attribute VALUES ('1', 'Color', 'color', 'Active', '2014-07-05 02:26:21');
INSERT INTO fc_product_attribute VALUES ('2', 'Size', 'size', 'Active', '2014-07-05 02:23:50');

-- ----------------------------
-- Table structure for `fc_product_category`
-- ----------------------------
DROP TABLE IF EXISTS `fc_product_category`;
CREATE TABLE `fc_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_product_category
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_product_comments`
-- ----------------------------
DROP TABLE IF EXISTS `fc_product_comments`;
CREATE TABLE `fc_product_comments` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `user_id` int(200) NOT NULL,
  `product_id` int(200) NOT NULL,
  `comments` longblob NOT NULL,
  `status` enum('Active','InActive') NOT NULL,
  `dateAdded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_product_comments
-- ----------------------------
INSERT INTO fc_product_comments VALUES ('1', '3', '1414508137', 0x6869, 'InActive', '2014-12-17 10:23:05');
INSERT INTO fc_product_comments VALUES ('2', '3', '1414508137', 0x736C696E, 'InActive', '2014-12-17 10:58:12');

-- ----------------------------
-- Table structure for `fc_product_feedback`
-- ----------------------------
DROP TABLE IF EXISTS `fc_product_feedback`;
CREATE TABLE `fc_product_feedback` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `voter_id` int(50) NOT NULL,
  `product_id` int(50) NOT NULL,
  `seller_id` bigint(20) NOT NULL,
  `rating` int(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longblob NOT NULL,
  `status` enum('Active','InActive') NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_product_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_product_likes`
-- ----------------------------
DROP TABLE IF EXISTS `fc_product_likes`;
CREATE TABLE `fc_product_likes` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `product_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_product_likes
-- ----------------------------
INSERT INTO fc_product_likes VALUES ('1', '1414345236', '1', '2014-10-26 11:40:53', '23.240.194.124');
INSERT INTO fc_product_likes VALUES ('2', '1414507267', '2', '2014-10-28 08:41:20', '115.118.153.47');
INSERT INTO fc_product_likes VALUES ('3', '1414469763', '2', '2014-10-28 08:42:36', '115.118.153.47');
INSERT INTO fc_product_likes VALUES ('4', '1414508137', '1', '2014-10-28 08:55:52', '23.240.194.124');

-- ----------------------------
-- Table structure for `fc_reportissues`
-- ----------------------------
DROP TABLE IF EXISTS `fc_reportissues`;
CREATE TABLE `fc_reportissues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fc_reportissues
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_reportlinks`
-- ----------------------------
DROP TABLE IF EXISTS `fc_reportlinks`;
CREATE TABLE `fc_reportlinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fc_reportlinks
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_review_comments`
-- ----------------------------
DROP TABLE IF EXISTS `fc_review_comments`;
CREATE TABLE `fc_review_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `deal_code` mediumtext NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `commentor_id` bigint(20) NOT NULL,
  `comment` blob NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_from` enum('user','seller','admin') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_review_comments
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_shipping_address`
-- ----------------------------
DROP TABLE IF EXISTS `fc_shipping_address`;
CREATE TABLE `fc_shipping_address` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `nick_name` varchar(200) NOT NULL,
  `address1` varchar(500) NOT NULL,
  `address2` varchar(500) NOT NULL,
  `city` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(100) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `phone` bigint(9) NOT NULL,
  `primary` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_shipping_address
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_shopping_carts`
-- ----------------------------
DROP TABLE IF EXISTS `fc_shopping_carts`;
CREATE TABLE `fc_shopping_carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `sell_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `discountAmount` decimal(10,2) NOT NULL,
  `indtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `is_coupon_used` enum('Yes','No') NOT NULL DEFAULT 'No',
  `couponID` int(200) NOT NULL,
  `couponCode` varchar(100) NOT NULL,
  `coupontype` varchar(100) NOT NULL,
  `cate_id` varchar(100) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `product_shipping_cost` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `product_tax_cost` decimal(10,2) NOT NULL,
  `attribute_values` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_shopping_carts
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_shops`
-- ----------------------------
DROP TABLE IF EXISTS `fc_shops`;
CREATE TABLE `fc_shops` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_name` text CHARACTER SET utf8 NOT NULL,
  `products` mediumtext NOT NULL,
  `products_count` int(11) NOT NULL,
  `followers` mediumtext NOT NULL,
  `followers_count` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `store_url` text NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `store_logo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fc_shops
-- ----------------------------
INSERT INTO fc_shops VALUES ('1', '1sale.com', '1414075056', '1', ',3', '1', '2014-10-23 08:37:37', '1sale.com', '0', '', '');
INSERT INTO fc_shops VALUES ('2', 'www.amazon.com', '1414345236,1414508137', '2', '', '0', '2014-10-26 11:40:37', 'www.amazon.com', '0', '', '');
INSERT INTO fc_shops VALUES ('3', 'www.shoemetro.com', '1414345413', '1', '', '0', '2014-10-26 11:43:33', 'www.shoemetro.com', '0', '', '');
INSERT INTO fc_shops VALUES ('4', 'www.6pm.com', '1414469763,1414507407', '2', '', '0', '2014-10-27 22:16:03', 'www.6pm.com', '0', '', '');
INSERT INTO fc_shops VALUES ('5', 'fancy.com', '1414505853,1414507267', '2', '', '0', '2014-10-28 08:17:33', 'fancy.com', '0', '', '');
INSERT INTO fc_shops VALUES ('6', 'www.ebay.com', '1414507958', '1', ',3', '1', '2014-10-28 08:52:38', 'www.ebay.com', '0', '', '');

-- ----------------------------
-- Table structure for `fc_slider`
-- ----------------------------
DROP TABLE IF EXISTS `fc_slider`;
CREATE TABLE `fc_slider` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `slider_title` varchar(500) CHARACTER SET latin1 NOT NULL,
  `slider_name` varchar(500) CHARACTER SET latin1 NOT NULL,
  `slider_orig_name` varchar(500) CHARACTER SET latin1 NOT NULL,
  `slider_encrypt_name` varchar(500) CHARACTER SET latin1 NOT NULL,
  `image` varchar(1000) NOT NULL,
  `slider_text` blob NOT NULL,
  `seourl` varchar(200) CHARACTER SET latin1 NOT NULL,
  `status` enum('Active','InActive') CHARACTER SET latin1 NOT NULL DEFAULT 'Active',
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `slider_link` varchar(1000) NOT NULL,
  `slider_desc` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_slider
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_state_tax`
-- ----------------------------
DROP TABLE IF EXISTS `fc_state_tax`;
CREATE TABLE `fc_state_tax` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(500) NOT NULL,
  `state_code` varchar(500) NOT NULL,
  `status` enum('Active','InActive') NOT NULL,
  `dateAdded` datetime NOT NULL,
  `state_tax` float(10,2) NOT NULL,
  `country_id` int(100) NOT NULL,
  `country_code` varchar(500) NOT NULL,
  `country_name` varchar(500) NOT NULL,
  `seourl` varchar(500) NOT NULL,
  `meta_title` longblob NOT NULL,
  `meta_keyword` longblob NOT NULL,
  `meta_description` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_state_tax
-- ----------------------------
INSERT INTO fc_state_tax VALUES ('2', 'Alaska', 'AK', 'InActive', '2013-07-29 13:00:00', '2.00', '3', 'US', 'USA', 'alaska', '', '', '');
INSERT INTO fc_state_tax VALUES ('3', 'American Samoa', 'AS', 'Active', '2013-07-29 13:00:00', '1.00', '3', '', 'USA', '', '', '', '');
INSERT INTO fc_state_tax VALUES ('4', 'Arizona', 'AZ', 'Active', '2013-07-29 13:00:00', '1.00', '3', '', 'USA', 'arizona', '', '', '');
INSERT INTO fc_state_tax VALUES ('5', 'Armed Forces Africa', 'AF', 'Active', '2013-07-29 13:00:00', '1.00', '3', '', 'USA', 'armed-forces-africa', '', '', '');
INSERT INTO fc_state_tax VALUES ('6', 'Armed Forces Americas', 'AA', 'Active', '2013-07-29 13:00:00', '1.00', '3', 'US', 'USA', 'armed-forces-americas', '', '', '');
INSERT INTO fc_state_tax VALUES ('8', 'tamilnadu', 'TN', 'Active', '2013-07-31 06:00:00', '1.00', '1', '', 'India', 'tamilnadu', '', '', '');

-- ----------------------------
-- Table structure for `fc_store_claims`
-- ----------------------------
DROP TABLE IF EXISTS `fc_store_claims`;
CREATE TABLE `fc_store_claims` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET latin1 NOT NULL DEFAULT 'pending',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `store_name` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `address` text CHARACTER SET latin1 NOT NULL,
  `city` text CHARACTER SET latin1 NOT NULL,
  `state` text CHARACTER SET latin1 NOT NULL,
  `postal_code` text CHARACTER SET latin1 NOT NULL,
  `country` text CHARACTER SET latin1 NOT NULL,
  `phone_no` bigint(20) NOT NULL,
  `logo` text CHARACTER SET latin1 NOT NULL,
  `document` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of fc_store_claims
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_stories`
-- ----------------------------
DROP TABLE IF EXISTS `fc_stories`;
CREATE TABLE `fc_stories` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `description` blob NOT NULL,
  `user_id` varchar(1000) NOT NULL,
  `product_id` varchar(1000) NOT NULL,
  `seller_product_id` varchar(1000) NOT NULL,
  `comment_count` varchar(1000) NOT NULL,
  `like_count` varchar(1000) NOT NULL,
  `report_count` varchar(1000) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Publish','UnPublish') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_stories
-- ----------------------------
INSERT INTO fc_stories VALUES ('1', 0x647771, '1', '', '1414345236', '', '', '', '2014-11-18 17:48:21', 'Publish');
INSERT INTO fc_stories VALUES ('2', 0x54686973206973206D792066697273742073746F7279, '3', '', '1414507267', '', '', '', '2014-12-17 13:48:21', 'Publish');

-- ----------------------------
-- Table structure for `fc_stories_comments`
-- ----------------------------
DROP TABLE IF EXISTS `fc_stories_comments`;
CREATE TABLE `fc_stories_comments` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `user_id` int(200) NOT NULL,
  `stories_id` int(200) NOT NULL,
  `comments` longblob NOT NULL,
  `status` enum('Active','InActive') NOT NULL,
  `dateAdded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_stories_comments
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_subadmin`
-- ----------------------------
DROP TABLE IF EXISTS `fc_subadmin`;
CREATE TABLE `fc_subadmin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `admin_name` varchar(24) NOT NULL,
  `admin_password` varchar(500) NOT NULL,
  `email` varchar(5000) NOT NULL,
  `admin_type` enum('super','sub') NOT NULL DEFAULT 'super',
  `privileges` text NOT NULL,
  `last_login_date` datetime NOT NULL,
  `last_logout_date` datetime NOT NULL,
  `last_login_ip` varchar(16) NOT NULL,
  `is_verified` enum('No','Yes') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_subadmin
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_subproducts`
-- ----------------------------
DROP TABLE IF EXISTS `fc_subproducts`;
CREATE TABLE `fc_subproducts` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `attr_id` int(11) NOT NULL,
  `attr_name` text NOT NULL,
  `attr_price` decimal(10,2) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_subproducts
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_subscribers_list`
-- ----------------------------
DROP TABLE IF EXISTS `fc_subscribers_list`;
CREATE TABLE `fc_subscribers_list` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `subscrip_mail` varchar(500) NOT NULL,
  `active` int(255) NOT NULL,
  `status` enum('Active','InActive') NOT NULL,
  `dateAdded` date NOT NULL,
  `verification_mail` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_subscribers_list
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_tags`
-- ----------------------------
DROP TABLE IF EXISTS `fc_tags`;
CREATE TABLE `fc_tags` (
  `tag_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag_name` text NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `products` text NOT NULL,
  `products_count` bigint(20) NOT NULL,
  `stories` text NOT NULL,
  `stories_count` bigint(20) NOT NULL,
  `followers` text NOT NULL,
  `followers_count` bigint(20) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fc_tags
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_users`
-- ----------------------------
DROP TABLE IF EXISTS `fc_users`;
CREATE TABLE `fc_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loginUserType` enum('normal','twitter','facebook','google') NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `group` enum('User','Seller') NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `is_verified` enum('Yes','No') NOT NULL,
  `is_brand` enum('no','yes') NOT NULL DEFAULT 'no',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `last_login_date` datetime NOT NULL,
  `last_logout_date` datetime NOT NULL,
  `last_login_ip` varchar(50) NOT NULL,
  `thumbnail` varchar(100) NOT NULL,
  `user_doc_file` varchar(255) NOT NULL,
  `address` varchar(50) NOT NULL,
  `address2` varchar(500) NOT NULL,
  `city` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(20) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `s_address` varchar(100) NOT NULL,
  `s_city` varchar(50) NOT NULL,
  `s_district` varchar(50) NOT NULL,
  `s_state` varchar(50) NOT NULL,
  `s_country` varchar(20) NOT NULL,
  `s_postal_code` int(11) NOT NULL,
  `s_phone_no` varchar(20) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `brand_description` text NOT NULL,
  `commision` int(11) NOT NULL,
  `web_url` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `bank_no` varchar(100) NOT NULL,
  `bank_code` varchar(100) NOT NULL,
  `request_status` enum('Not Requested','Pending','Approved','Rejected') NOT NULL DEFAULT 'Not Requested',
  `verify_code` varchar(10) NOT NULL,
  `feature_product` int(100) NOT NULL,
  `followers_count` int(11) NOT NULL,
  `following_count` int(11) NOT NULL,
  `followers` varchar(200) NOT NULL,
  `following` varchar(200) NOT NULL,
  `twitter` varchar(50) NOT NULL,
  `facebook` varchar(50) NOT NULL,
  `google` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `about` varchar(200) NOT NULL,
  `age` enum('','13 to 17','18 to 24','25 to 34','35 to 44','45 to 54','55+') NOT NULL,
  `gender` enum('Male','Female','Unspecified') NOT NULL DEFAULT 'Unspecified',
  `language` varchar(10) NOT NULL DEFAULT 'en',
  `visibility` enum('Everyone','Only you') NOT NULL,
  `display_lists` enum('Yes','No') NOT NULL,
  `email_notifications` longtext NOT NULL,
  `notifications` longtext NOT NULL,
  `updates` enum('1','0') NOT NULL,
  `products` int(11) NOT NULL,
  `lists` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `location` mediumtext NOT NULL,
  `following_user_lists` longtext NOT NULL,
  `following_giftguide_lists` longtext NOT NULL,
  `api_id` bigint(20) NOT NULL,
  `own_products` longtext NOT NULL,
  `own_count` bigint(20) NOT NULL,
  `referId` int(11) NOT NULL,
  `want_count` bigint(20) NOT NULL,
  `refund_amount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `paypal_email` varchar(500) NOT NULL,
  `magic_cat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_users
-- ----------------------------
INSERT INTO fc_users VALUES ('1', 'normal', 'slin156', 'slin156', 'User', 'slin156@gmail.com', '52ee6f02c89d16e00704bd3d02f7e46c', 'Active', 'No', 'no', '2014-10-23 02:35:58', '0000-00-00 00:00:00', '2014-11-19 06:34:31', '2014-10-29 06:20:13', '23.240.194.124', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '0', '', '', '', '0', '', '', '', '', 'Not Requested', 'zYlDpkbgXT', '0', '1', '1', ',1', ',1', '', '', '', '0000-00-00', '', '', 'Unspecified', 'en', 'Everyone', 'Yes', '', '', '1', '6', '1', '2', '', '', '', '0', '', '0', '0', '0', '0.00', '', '1');
INSERT INTO fc_users VALUES ('3', 'normal', 'mrinsss', 'mrinsss', 'User', 'mrinsss@gmail.com', 'ef73781effc5774100f87fe2f437a435', 'Active', 'No', 'no', '2014-12-17 10:09:36', '0000-00-00 00:00:00', '2014-12-17 10:16:55', '2014-12-17 10:16:24', '192.168.1.30', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '0', '', '', '', '0', '', '', '', '', 'Not Requested', 'eoaUgCD82T', '0', '0', '0', '', '', '', '', '', '0000-00-19', 'hi', '25 to 34', 'Male', 'en', 'Only you', 'Yes', '0', '0', '0', '0', '1', '0', '', '', '', '0', '', '0', '0', '0', '0.00', '', '1');

-- ----------------------------
-- Table structure for `fc_user_activity`
-- ----------------------------
DROP TABLE IF EXISTS `fc_user_activity`;
CREATE TABLE `fc_user_activity` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(200) NOT NULL,
  `activity_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `activity_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activity_ip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_user_activity
-- ----------------------------
INSERT INTO fc_user_activity VALUES ('1', 'fancy', '1414345236', '1', '2014-10-26 11:40:53', '23.240.194.124');
INSERT INTO fc_user_activity VALUES ('2', 'follow', '1', '1', '2014-10-27 22:14:09', '23.240.194.124');
INSERT INTO fc_user_activity VALUES ('3', 'fancy', '1414507267', '2', '2014-10-28 08:41:20', '115.118.153.47');
INSERT INTO fc_user_activity VALUES ('4', 'fancy', '1414508137', '1', '2014-10-28 08:55:52', '23.240.194.124');
INSERT INTO fc_user_activity VALUES ('5', 'follow-store', '2', '3', '2014-12-17 13:44:52', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('6', 'unfollow-store', '2', '3', '2014-12-17 13:44:55', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('7', 'follow-store', '2', '3', '2014-12-17 13:50:14', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('8', 'follow', '1', '3', '2014-12-17 13:50:24', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('9', 'follow-store', '6', '3', '2014-12-17 13:51:53', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('10', 'fancy', '1414345236', '3', '2014-12-17 13:52:44', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('11', 'fancy', '1414508137', '3', '2014-12-17 13:52:58', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('12', 'unfollow-store', '2', '3', '2014-12-17 14:06:06', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('13', 'follow-store', '2', '3', '2014-12-17 14:06:08', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('14', 'unfollow-store', '2', '3', '2014-12-17 14:06:10', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('15', 'follow-store', '2', '3', '2014-12-17 14:06:31', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('16', 'unfollow-store', '2', '3', '2014-12-17 14:06:35', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('17', 'follow-store', '2', '3', '2014-12-17 14:06:39', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('18', 'unfollow-store', '2', '3', '2014-12-17 14:06:45', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('19', 'follow-store', '2', '3', '2014-12-17 14:06:47', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('20', 'unfollow-store', '2', '3', '2014-12-17 14:06:48', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('21', 'unfollow', '1', '3', '2014-12-17 14:07:41', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('22', 'follow', '1', '3', '2014-12-17 14:07:42', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('23', 'unfollow', '1', '3', '2014-12-17 14:07:46', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('24', 'follow-store', '3', '3', '2014-12-17 14:13:15', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('25', 'follow-store', '1', '3', '2014-12-17 14:13:24', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('26', 'unfollow-store', '3', '3', '2014-12-17 14:13:36', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('27', 'unfollow-store', '1', '3', '2014-12-17 14:13:41', '192.168.1.30');
INSERT INTO fc_user_activity VALUES ('28', 'follow-store', '1', '3', '2014-12-17 14:13:51', '192.168.1.30');

-- ----------------------------
-- Table structure for `fc_user_product`
-- ----------------------------
DROP TABLE IF EXISTS `fc_user_product`;
CREATE TABLE `fc_user_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_product_id` bigint(20) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `product_name` varchar(100) NOT NULL,
  `seourl` varchar(500) NOT NULL,
  `meta_title` longblob NOT NULL,
  `meta_keyword` longblob NOT NULL,
  `meta_description` longblob NOT NULL,
  `excerpt` varchar(500) NOT NULL,
  `category_id` varchar(500) NOT NULL,
  `image` longtext NOT NULL,
  `description` longtext NOT NULL,
  `status` enum('Publish','UnPublish') NOT NULL DEFAULT 'Publish',
  `featured` enum('Yes','No') NOT NULL DEFAULT 'No',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `likes` bigint(20) NOT NULL DEFAULT '0',
  `list_name` longtext NOT NULL,
  `list_value` longtext NOT NULL,
  `web_link` mediumtext NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `youtube` text NOT NULL,
  `store_name` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `affiliate_code` text NOT NULL,
  `affiliate_script` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_user_product
-- ----------------------------
INSERT INTO fc_user_product VALUES ('1', '1414075056', '2014-10-23 08:37:37', '0000-00-00 00:00:00', 'ring', 'ring', '', '', '', '', '1', '89266-Marquis-Diamond-Ring1414075057.jpg1413995009', '', 'Publish', 'No', '1', '0', '', '', 'http://1sale.com/jewelry/other/slot-1-marquise-diamond/', '100', '', 0x3173616C652E636F6D, '', '');
INSERT INTO fc_user_product VALUES ('2', '1414345236', '2014-10-26 11:40:37', '0000-00-00 00:00:00', 'Laptop', 'Laptop', '', '', '', 'Laptop deals', '1', '51KvVA01s-L1414345237._SL500_SR100100_', '', 'Publish', 'No', '1', '1', '', '', 'http://www.amazon.com/Asus-X551MAV-RCLN06-16-Inch-2-16GHz-Processor/dp/B00LNG8UPC/ref=as_sl_pc_ss_til?tag=1sale06-20&linkCode=w01&linkId=COR4RKKSOXGMUHMB&creativeASIN=B00LNG8UPC', '250', '', 0x7777772E616D617A6F6E2E636F6D, '', '');
INSERT INTO fc_user_product VALUES ('3', '1414345413', '2014-10-26 11:43:33', '0000-00-00 00:00:00', 'purse', 'purse', '', '', '', 'purse', '1', 'HUg97bphgw7LnCA1AT68OlG12FvfCnse-121414345413.jpg', '', 'Publish', 'No', '1', '0', '', '', 'http://www.shoemetro.com/p-347989-adalyn.aspx?color=Black/001&material=Leather&utm_campaign=cj_affiliate_sale&utm_medium=affiliate&utm_source=cj&utm_content=7321941&utm_term=11553970', '50', '', 0x7777772E73686F656D6574726F2E636F6D, '', '');
INSERT INTO fc_user_product VALUES ('4', '1414469763', '2014-10-27 22:16:03', '0000-00-00 00:00:00', 'Blue shoes', 'Blue-shoes', '', '', '', 'shoes', '1', '2300312-p-MULTIVIEW1414469763.jpg', '', 'Publish', 'No', '1', '1', '', '', 'http://www.6pm.com/ugg-kaldwell-night-nubuck?zlfid=72&PID=7321941&AID=11554188&utm_source=4168957&Pub_Name=Community.1Sale.com&splash=none&zhlfid=209&utm_medium=affiliate', '20', '', 0x7777772E36706D2E636F6D, '', '');
INSERT INTO fc_user_product VALUES ('6', '1414507267', '2014-10-28 08:41:07', '0000-00-00 00:00:00', 'Test product', 'Test-product', '', '', '', '', '1', '732619495268417826_5f583cb025fd1414507267.jpg', '', 'Publish', 'No', '2', '1', '', '', 'http://fancy.com/teste', '456', '', 0x66616E63792E636F6D, 'aid=23', '');
INSERT INTO fc_user_product VALUES ('7', '1414507407', '2014-10-28 08:43:28', '0000-00-00 00:00:00', 'Shoe', 'Shoe', '', '', '', '', '', '2300312-p-MULTIVIEW1414507408.jpg', '', 'Publish', 'No', '2', '0', '', '', 'http://www.6pm.com/ugg-kaldwelllll-night-nubuck?zlfid=72&PID=7321941&AID=11554188&utm_source=4168957&Pub_Name=Community.1Sale.com&splash=none&zhlfid=209&utm_medium=affiliate', '75', '', 0x7777772E36706D2E636F6D, '', '');
INSERT INTO fc_user_product VALUES ('8', '1414507958', '2014-10-28 08:52:38', '0000-00-00 00:00:00', 'az', 'az', '', '', '', 'tab', '1', '$_571414507958.JPG', '', 'Publish', 'No', '1', '0', '', '', 'http://www.ebay.com/itm/Asus-Google-Nexus-7-32GB-Wi-Fi-7-Tablet-/191132688112', '20', '', 0x7777772E656261792E636F6D, '', '');
INSERT INTO fc_user_product VALUES ('9', '1414508137', '2014-10-28 08:55:37', '0000-00-00 00:00:00', 'kid', 'kid', '', '', '', 'kid', '1', '415hklQa28L1414508137._SL500_SR100100_', '', 'Publish', 'No', '1', '1', '', '', 'http://www.amazon.com/KidKraft-Annabelle-Dollhouse-with-Furniture/dp/B002OED6I8/ref=as_sl_pc_ss_til?tag=1sale06-20&linkCode=w01&linkId=ZQ7CX3477BGIPQRZ&creativeASIN=B002OED6I8', '10', '', 0x7777772E616D617A6F6E2E636F6D, '', '');

-- ----------------------------
-- Table structure for `fc_vendor_payment_table`
-- ----------------------------
DROP TABLE IF EXISTS `fc_vendor_payment_table`;
CREATE TABLE `fc_vendor_payment_table` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `transaction_id` mediumtext COLLATE utf8_bin NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_type` mediumtext COLLATE utf8_bin NOT NULL,
  `amount` float(20,2) NOT NULL,
  `status` enum('pending','success','failed') COLLATE utf8_bin NOT NULL,
  `vendor_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of fc_vendor_payment_table
-- ----------------------------

-- ----------------------------
-- Table structure for `fc_wants`
-- ----------------------------
DROP TABLE IF EXISTS `fc_wants`;
CREATE TABLE `fc_wants` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `product_id` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fc_wants
-- ----------------------------
