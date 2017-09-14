/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50628
Source Host           : 192.168.1.38:3306
Source Database       : jae

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2017-09-13 12:43:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `jae_admin_site_settings`
-- ----------------------------
DROP TABLE IF EXISTS `jae_admin_site_settings`;
CREATE TABLE `jae_admin_site_settings` (
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
-- Records of jae_admin_site_settings
-- ----------------------------
INSERT INTO `jae_admin_site_settings` VALUES ('1', 'mmondal@codeuridea.com', 'mail.acumencs.com', 'smtp1234', 'smtp@acumencs.com', '20', 'Copyright © 2016-2017 Codeuridea. All rights reserved.', '121234567', '12345', 'TAX GETTERS', '', 'TAX GETTERS', '', '1709 S STATE ST', 'EDMOND', 'OK', '73013', 'JACK TAXUM', '4053400697', 'jack76@aol.com', 'ADVANCED MICRO SOLUTIONS', '1709 S. STATE STREET', 'EDMOND', 'OK', '73013', 'KYLE MCCORKLE', '4053400697', '100001');

-- ----------------------------
-- Table structure for `jae_admin_user_type`
-- ----------------------------
DROP TABLE IF EXISTS `jae_admin_user_type`;
CREATE TABLE `jae_admin_user_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `s_user_type` varchar(100) CHARACTER SET latin1 NOT NULL,
  `s_key` varchar(100) DEFAULT NULL,
  `dt_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(1) NOT NULL DEFAULT '1',
  `e_is_deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `i_display_order` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jae_admin_user_type
-- ----------------------------
INSERT INTO `jae_admin_user_type` VALUES ('1', 'System Admin', 'dev', '2015-08-18 13:52:39', '1', 'No', '1');

-- ----------------------------
-- Table structure for `jae_exam_question_answers`
-- ----------------------------
DROP TABLE IF EXISTS `jae_exam_question_answers`;
CREATE TABLE `jae_exam_question_answers` (
  `i_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `i_exam_id` int(10) NOT NULL COMMENT 'PK of examination tbl',
  `s_question` text CHARACTER SET latin1,
  `s_option1` text,
  `s_option2` text,
  `s_option3` text,
  `s_option4` text,
  `dt_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(1) NOT NULL DEFAULT '1',
  `i_is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->No, 1->Yes',
  `i_download_no` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jae_exam_question_answers
-- ----------------------------
INSERT INTO `jae_exam_question_answers` VALUES ('45', '1', 'Blood looks red because of', 'hemoglobin', 'plasma', 'certain secretions', 'red corpuscles', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('46', '1', 'The water that does not produce good lather with soap is called', 'polluted water', 'hard water', 'heavy water', 'soft water', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('47', '1', 'Who among the following was the first Home Minister of India?', 'Govind Ballabh Pant', 'Sardar Patel', 'Babu Jagjivan Ram', 'Morarji Desai', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('48', '1', 'The unit used to measure the supersonic speed is', 'hertz', 'Mach', 'Knot', 'Richter', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('49', '1', 'During Mughal period, in-charge of police force was called', 'Kotwal', 'Daroga', 'Fauzdar', 'Subedar', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('50', '1', '\'Golden Pen of Freedom\' award is associated with', 'Literacy Writing', 'Journalism', 'Art of Cinema', 'Sports Editorials', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('51', '1', 'In Ramayana, Mandavi was the wife of', 'Laxman', 'Bharat', 'Meghnad', 'Sugreev', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('52', '1', 'Which is the oldest Veda?', 'Samaveda', 'Rigveda', 'Atharvaveda', 'Yajurveda', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('53', '1', 'Which among the following bites fastest in the world?', 'Indian Cobra', 'African Scorpian', 'Panamanian Termite', 'Australian Squirrel', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('54', '1', 'Tarla Dalal is a famous', 'Classical Dancer', 'Cookery Specialist', 'Child Psychologist', 'Media Manager', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('55', '1', 'Which of the following was a recommendation of Hunter\'s Commission? ', 'Women\'s education', 'New regulation for organized system', 'withdrawal support for higher education', 'Introduction of civic education', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('56', '1', 'Who is known as the \'Grand Old Man of India\'? ', 'C. Rajagopalachari', 'Dadabhai Naoroji', 'Lala Lajpat Rai', 'Khan Abdul Ghaffar Khan', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('57', '1', 'Arya Samaj was started by', 'Swami Vivekananda', 'Raja Ram Mohan Roy', 'Swami Dayanand Saraswati', 'Gopal Krishna Gokhale', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('58', '1', 'The theory of economic drain of India during British imperialism was propounded by', 'M. K. Gandhi', 'Jawaharlal Nehru', 'Dadabhai Naoroji', 'R. C. Dutt', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('59', '1', 'Who amongst the following was involved in the Alipore Bomb case?', 'S. N. Banerjea', 'Bipin Chandra Pal', 'Jatin Das', 'Aurobindo Ghosh', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('60', '1', 'Which one of the following upheavals took place in Bengal immediately after the Revolt of 1857? ', 'Sanyasi Rebellion', 'Santal Rebellion', 'Indigo Disturbances', 'Pabna Disturbances', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('61', '1', 'Which of the following was not founded by Dr.B. R. Ambedkar? ', 'Deccan Education Society', 'Samaj Samata Sangh', 'Peoples Education Society', 'Depressed Classes Institute', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('62', '1', 'Who among the following was called as \'Father of Indian Renaissance\'?', 'B. G. Tilak', 'Gopal Krishna Gokhale', 'Lala Lajpat Rai', 'Raja Ram Mohan Roy', '2017-09-12 17:28:02', '1', '0', '2');
INSERT INTO `jae_exam_question_answers` VALUES ('69', '2', 'Which is the oldest Veda?', 'Samaveda', 'Rigveda', 'Atharvaveda', 'Yajurveda', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('70', '2', 'Which of the following was not founded by Dr.B. R. Ambedkar? ', 'Deccan Education Society', 'Samaj Samata Sangh', 'Peoples Education Society', 'Depressed Classes Institute', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('71', '2', 'Tarla Dalal is a famous', 'Classical Dancer', 'Cookery Specialist', 'Child Psychologist', 'Media Manager', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('72', '2', 'The water that does not produce good lather with soap is called', 'polluted water', 'hard water', 'heavy water', 'soft water', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('73', '2', 'The theory of economic drain of India during British imperialism was propounded by', 'M. K. Gandhi', 'Jawaharlal Nehru', 'Dadabhai Naoroji', 'R. C. Dutt', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('74', '2', 'Arya Samaj was started by', 'Swami Vivekananda', 'Raja Ram Mohan Roy', 'Swami Dayanand Saraswati', 'Gopal Krishna Gokhale', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('75', '2', 'During Mughal period, in-charge of police force was called', 'Kotwal', 'Daroga', 'Fauzdar', 'Subedar', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('76', '2', 'Who amongst the following was involved in the Alipore Bomb case?', 'S. N. Banerjea', 'Bipin Chandra Pal', 'Jatin Das', 'Aurobindo Ghosh', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('77', '2', 'Blood looks red because of', 'hemoglobin', 'plasma', 'certain secretions', 'red corpuscles', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('78', '2', 'The unit used to measure the supersonic speed is', 'hertz', 'Mach', 'Knot', 'Richter', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('79', '2', 'Which of the following was a recommendation of Hunter\'s Commission? ', 'Women\'s education', 'New regulation for organized system', 'withdrawal support for higher education', 'Introduction of civic education', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('80', '2', 'In Ramayana, Mandavi was the wife of', 'Laxman', 'Bharat', 'Meghnad', 'Sugreev', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('81', '2', 'Who among the following was the first Home Minister of India?', 'Govind Ballabh Pant', 'Sardar Patel', 'Babu Jagjivan Ram', 'Morarji Desai', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('82', '2', 'Which among the following bites fastest in the world?', 'Indian Cobra', 'African Scorpian', 'Panamanian Termite', 'Australian Squirrel', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('83', '2', 'Which one of the following upheavals took place in Bengal immediately after the Revolt of 1857? ', 'Sanyasi Rebellion', 'Santal Rebellion', 'Indigo Disturbances', 'Pabna Disturbances', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('84', '2', '\'Golden Pen of Freedom\' award is associated with', 'Literacy Writing', 'Journalism', 'Art of Cinema', 'Sports Editorials', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('85', '2', 'Who among the following was called as \'Father of Indian Renaissance\'?', 'B. G. Tilak', 'Gopal Krishna Gokhale', 'Lala Lajpat Rai', 'Raja Ram Mohan Roy', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('86', '2', 'Who is known as the \'Grand Old Man of India\'? ', 'C. Rajagopalachari', 'Dadabhai Naoroji', 'Lala Lajpat Rai', 'Khan Abdul Ghaffar Khan', '2017-09-12 17:41:04', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('87', '3', 'Tarla Dalal is a famous', 'Classical Dancer', 'Cookery Specialist', 'Child Psychologist', 'Media Manager', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('88', '3', 'During Mughal period, in-charge of police force was called', 'Kotwal', 'Daroga', 'Fauzdar', 'Subedar', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('89', '3', 'Who among the following was called as \'Father of Indian Renaissance\'?', 'B. G. Tilak', 'Gopal Krishna Gokhale', 'Lala Lajpat Rai', 'Raja Ram Mohan Roy', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('90', '3', 'Which of the following was a recommendation of Hunter\'s Commission? ', 'Women\'s education', 'New regulation for organized system', 'withdrawal support for higher education', 'Introduction of civic education', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('91', '3', 'Blood looks red because of', 'hemoglobin', 'plasma', 'certain secretions', 'red corpuscles', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('92', '3', 'The unit used to measure the supersonic speed is', 'hertz', 'Mach', 'Knot', 'Richter', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('93', '3', 'The theory of economic drain of India during British imperialism was propounded by', 'M. K. Gandhi', 'Jawaharlal Nehru', 'Dadabhai Naoroji', 'R. C. Dutt', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('94', '3', 'Who is known as the \'Grand Old Man of India\'? ', 'C. Rajagopalachari', 'Dadabhai Naoroji', 'Lala Lajpat Rai', 'Khan Abdul Ghaffar Khan', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('95', '3', 'Who among the following was the first Home Minister of India?', 'Govind Ballabh Pant', 'Sardar Patel', 'Babu Jagjivan Ram', 'Morarji Desai', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('96', '3', 'Arya Samaj was started by', 'Swami Vivekananda', 'Raja Ram Mohan Roy', 'Swami Dayanand Saraswati', 'Gopal Krishna Gokhale', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('97', '3', 'In Ramayana, Mandavi was the wife of', 'Laxman', 'Bharat', 'Meghnad', 'Sugreev', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('98', '3', '\'Golden Pen of Freedom\' award is associated with', 'Literacy Writing', 'Journalism', 'Art of Cinema', 'Sports Editorials', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('99', '3', 'The water that does not produce good lather with soap is called', 'polluted water', 'hard water', 'heavy water', 'soft water', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('100', '3', 'Which among the following bites fastest in the world?', 'Indian Cobra', 'African Scorpian', 'Panamanian Termite', 'Australian Squirrel', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('101', '3', 'Which is the oldest Veda?', 'Samaveda', 'Rigveda', 'Atharvaveda', 'Yajurveda', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('102', '3', 'Who amongst the following was involved in the Alipore Bomb case?', 'S. N. Banerjea', 'Bipin Chandra Pal', 'Jatin Das', 'Aurobindo Ghosh', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('103', '3', 'Which one of the following upheavals took place in Bengal immediately after the Revolt of 1857? ', 'Sanyasi Rebellion', 'Santal Rebellion', 'Indigo Disturbances', 'Pabna Disturbances', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('104', '3', 'Which of the following was not founded by Dr.B. R. Ambedkar? ', 'Deccan Education Society', 'Samaj Samata Sangh', 'Peoples Education Society', 'Depressed Classes Institute', '2017-09-12 17:41:18', '1', '0', '1');
INSERT INTO `jae_exam_question_answers` VALUES ('105', '4', 'Which is the oldest Veda?', 'Samaveda', 'Rigveda', 'Atharvaveda', 'Yajurveda', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('106', '4', 'Arya Samaj was started by', 'Swami Vivekananda', 'Raja Ram Mohan Roy', 'Swami Dayanand Saraswati', 'Gopal Krishna Gokhale', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('107', '4', 'Which of the following was a recommendation of Hunter\'s Commission? ', 'Women\'s education', 'New regulation for organized system', 'withdrawal support for higher education', 'Introduction of civic education', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('108', '4', 'During Mughal period, in-charge of police force was called', 'Kotwal', 'Daroga', 'Fauzdar', 'Subedar', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('109', '4', 'The unit used to measure the supersonic speed is', 'hertz', 'Mach', 'Knot', 'Richter', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('110', '4', '\'Golden Pen of Freedom\' award is associated with', 'Literacy Writing', 'Journalism', 'Art of Cinema', 'Sports Editorials', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('111', '4', 'In Ramayana, Mandavi was the wife of', 'Laxman', 'Bharat', 'Meghnad', 'Sugreev', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('112', '4', 'Which of the following was not founded by Dr.B. R. Ambedkar? ', 'Deccan Education Society', 'Samaj Samata Sangh', 'Peoples Education Society', 'Depressed Classes Institute', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('113', '4', 'Which among the following bites fastest in the world?', 'Indian Cobra', 'African Scorpian', 'Panamanian Termite', 'Australian Squirrel', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('114', '4', 'Who is known as the \'Grand Old Man of India\'? ', 'C. Rajagopalachari', 'Dadabhai Naoroji', 'Lala Lajpat Rai', 'Khan Abdul Ghaffar Khan', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('115', '4', 'Who amongst the following was involved in the Alipore Bomb case?', 'S. N. Banerjea', 'Bipin Chandra Pal', 'Jatin Das', 'Aurobindo Ghosh', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('116', '4', 'Which one of the following upheavals took place in Bengal immediately after the Revolt of 1857? ', 'Sanyasi Rebellion', 'Santal Rebellion', 'Indigo Disturbances', 'Pabna Disturbances', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('117', '4', 'Tarla Dalal is a famous', 'Classical Dancer', 'Cookery Specialist', 'Child Psychologist', 'Media Manager', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('118', '4', 'Blood looks red because of', 'hemoglobin', 'plasma', 'certain secretions', 'red corpuscles', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('119', '4', 'Who among the following was called as \'Father of Indian Renaissance\'?', 'B. G. Tilak', 'Gopal Krishna Gokhale', 'Lala Lajpat Rai', 'Raja Ram Mohan Roy', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('120', '4', 'Who among the following was the first Home Minister of India?', 'Govind Ballabh Pant', 'Sardar Patel', 'Babu Jagjivan Ram', 'Morarji Desai', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('121', '4', 'The theory of economic drain of India during British imperialism was propounded by', 'M. K. Gandhi', 'Jawaharlal Nehru', 'Dadabhai Naoroji', 'R. C. Dutt', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('122', '4', 'The water that does not produce good lather with soap is called', 'polluted water', 'hard water', 'heavy water', 'soft water', '2017-09-12 17:41:32', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('157', '5', '\'Golden Pen of Freedom\' award is associated with', 'Literacy Writing', 'Journalism', 'Art of Cinema', 'Sports Editorials', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('158', '5', 'Which of the following was a recommendation of Hunter\'s Commission? ', 'Women\'s education', 'New regulation for organized system', 'withdrawal support for higher education', 'Introduction of civic education', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('159', '5', 'Who amongst the following was involved in the Alipore Bomb case?', 'S. N. Banerjea', 'Bipin Chandra Pal', 'Jatin Das', 'Aurobindo Ghosh', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('160', '5', 'The water that does not produce good lather with soap is called', 'polluted water', 'hard water', 'heavy water', 'soft water', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('161', '5', 'Who among the following was called as \'Father of Indian Renaissance\'?', 'B. G. Tilak', 'Gopal Krishna Gokhale', 'Lala Lajpat Rai', 'Raja Ram Mohan Roy', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('162', '5', 'Which one of the following upheavals took place in Bengal immediately after the Revolt of 1857? ', 'Sanyasi Rebellion', 'Santal Rebellion', 'Indigo Disturbances', 'Pabna Disturbances', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('163', '5', 'Blood looks red because of', 'hemoglobin', 'plasma', 'certain secretions', 'red corpuscles', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('164', '5', 'Who is known as the \'Grand Old Man of India\'? ', 'C. Rajagopalachari', 'Dadabhai Naoroji', 'Lala Lajpat Rai', 'Khan Abdul Ghaffar Khan', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('165', '5', 'Tarla Dalal is a famous', 'Classical Dancer', 'Cookery Specialist', 'Child Psychologist', 'Media Manager', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('166', '5', 'Arya Samaj was started by', 'Swami Vivekananda', 'Raja Ram Mohan Roy', 'Swami Dayanand Saraswati', 'Gopal Krishna Gokhale', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('167', '5', 'Which of the following was not founded by Dr.B. R. Ambedkar? ', 'Deccan Education Society', 'Samaj Samata Sangh', 'Peoples Education Society', 'Depressed Classes Institute', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('168', '5', 'In Ramayana, Mandavi was the wife of', 'Laxman', 'Bharat', 'Meghnad', 'Sugreev', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('169', '5', 'During Mughal period, in-charge of police force was called', 'Kotwal', 'Daroga', 'Fauzdar', 'Subedar', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('170', '5', 'Which is the oldest Veda?', 'Samaveda', 'Rigveda', 'Atharvaveda', 'Yajurveda', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('171', '5', 'Which among the following bites fastest in the world?', 'Indian Cobra', 'African Scorpian', 'Panamanian Termite', 'Australian Squirrel', '2017-09-12 07:19:27', '1', '0', '0');
INSERT INTO `jae_exam_question_answers` VALUES ('172', '5', 'The theory of economic drain of India during British imperialism was propounded by', 'M. K. Gandhi', 'Jawaharlal Nehru', 'Dadabhai Naoroji', 'R. C. Dutt', '2017-09-12 07:19:27', '1', '0', '0');

-- ----------------------------
-- Table structure for `jae_exam_question_answers_bk_empty`
-- ----------------------------
DROP TABLE IF EXISTS `jae_exam_question_answers_bk_empty`;
CREATE TABLE `jae_exam_question_answers_bk_empty` (
  `i_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `i_exam_id` int(10) NOT NULL COMMENT 'PK of examination tbl',
  `s_question` text CHARACTER SET latin1,
  `s_option1` text,
  `s_option2` text,
  `s_option3` text,
  `s_option4` text,
  `dt_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(1) NOT NULL DEFAULT '1',
  `i_is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->No, 1->Yes',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jae_exam_question_answers_bk_empty
-- ----------------------------

-- ----------------------------
-- Table structure for `jae_examinations`
-- ----------------------------
DROP TABLE IF EXISTS `jae_examinations`;
CREATE TABLE `jae_examinations` (
  `i_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `s_key` varchar(255) DEFAULT NULL,
  `dt_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_status` tinyint(1) NOT NULL DEFAULT '1',
  `i_is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->No, 1->Yes',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jae_examinations
-- ----------------------------
INSERT INTO `jae_examinations` VALUES ('1', 'Test 1', 'test-1', '2017-09-11 13:08:18', '1', '0');
INSERT INTO `jae_examinations` VALUES ('2', 'Test 2', 'test-2', '2017-09-11 13:24:09', '1', '0');
INSERT INTO `jae_examinations` VALUES ('3', 'Test 3', 'test-3', '2017-09-11 13:24:18', '1', '0');
INSERT INTO `jae_examinations` VALUES ('4', 'Test 4', 'test-4', '2017-09-11 13:24:27', '1', '0');
INSERT INTO `jae_examinations` VALUES ('5', 'Test', 'test', '2017-09-11 20:44:46', '1', '0');

-- ----------------------------
-- Table structure for `jae_menu`
-- ----------------------------
DROP TABLE IF EXISTS `jae_menu`;
CREATE TABLE `jae_menu` (
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jae_menu
-- ----------------------------
INSERT INTO `jae_menu` VALUES ('1', 'General', '', '0', '0', '', 'th', 'General', 'General', '0');
INSERT INTO `jae_menu` VALUES ('2', 'Dashboard', 'dashboard/', '1', '1', 'View List', 'home', 'Dashboard', 'Dashboard', '1');
INSERT INTO `jae_menu` VALUES ('3', 'My Account ', 'my_account/', '1', '1', 'Edit', 'home', 'My Account', 'My Account', '2');
INSERT INTO `jae_menu` VALUES ('4', 'Site Setting', 'site_setting/', '1', '1', 'Edit', 'home', 'Site Setting', 'Site Setting', '3');
INSERT INTO `jae_menu` VALUES ('5', 'Admin User', '', '0', '0', '', 'users', 'Admin User', 'Admin User', '1');
INSERT INTO `jae_menu` VALUES ('6', 'User Type Access', 'user_type_master/', '-99', '-99', 'View List||Add||Edit', 'home', 'User Type Access', 'User Type Access', '1');
INSERT INTO `jae_menu` VALUES ('7', 'Manage Users', 'manage_admin_user/', '-99', '-99', 'View List||Add||Edit||Delete', 'home', 'Manage Users', 'Manage Users', '2');
INSERT INTO `jae_menu` VALUES ('8', 'Change Password', 'change_password/', '1', '1', 'Edit', 'home', 'Change Password', 'Change Password', '4');
INSERT INTO `jae_menu` VALUES ('9', 'Information', '', '0', '0', '', 'home', 'Information', 'Information', '2');
INSERT INTO `jae_menu` VALUES ('10', 'Manage Examination', 'manage_examination/', '9', '9', 'View List||Add||Edit||Delete', 'home', 'Manage Examination', 'Manage Examination', '1');
INSERT INTO `jae_menu` VALUES ('11', 'Manage Questions', 'manage_questions/', '-99', '-99', 'View List||Add||Edit||Delete', 'home', 'Manage Questions', 'Manage Questions', '2');

-- ----------------------------
-- Table structure for `jae_menu_permit`
-- ----------------------------
DROP TABLE IF EXISTS `jae_menu_permit`;
CREATE TABLE `jae_menu_permit` (
  `i_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `i_menu_id` int(11) NOT NULL COMMENT 'this can be 0 if the action is default',
  `s_action` varchar(100) NOT NULL COMMENT 'Default =>available for all user types, ex: ajax, login page, home page etc.',
  `s_link` text NOT NULL COMMENT 'excluding the base_url(). e.g.-dashboard/',
  `i_user_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0->Super Admin,1->Sub Admin',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jae_menu_permit
-- ----------------------------
INSERT INTO `jae_menu_permit` VALUES ('1', '0', 'Default', 'home/', '1');
INSERT INTO `jae_menu_permit` VALUES ('2', '0', 'Default', 'home/logout', '1');
INSERT INTO `jae_menu_permit` VALUES ('3', '0', 'Default', 'home/ajax_menu_track/', '1');
INSERT INTO `jae_menu_permit` VALUES ('4', '0', 'Default', 'error_404/', '1');
INSERT INTO `jae_menu_permit` VALUES ('8', '4', 'Edit', 'site_setting/modify_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('9', '6', 'View List', 'user_type_master/show_list/', '1');
INSERT INTO `jae_menu_permit` VALUES ('10', '6', 'Add', 'user_type_master/add_information/', '-99');
INSERT INTO `jae_menu_permit` VALUES ('11', '6', 'Edit', 'user_type_master/modify_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('12', '6', 'Access Control', 'user_type_master/access_control/', '1');
INSERT INTO `jae_menu_permit` VALUES ('13', '7', 'View List', 'manage_admin_user/show_list/', '1');
INSERT INTO `jae_menu_permit` VALUES ('14', '7', 'Add', 'manage_admin_user/add_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('15', '7', 'Edit', 'manage_admin_user/modify_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('16', '7', 'Delete', 'manage_admin_user/remove_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('17', '3', 'Edit', 'my_account/modify_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('18', '6', 'Delete', 'user_type_master/remove_information/', '-99');
INSERT INTO `jae_menu_permit` VALUES ('19', '2', 'View List', 'dashboard/', '1');
INSERT INTO `jae_menu_permit` VALUES ('20', '0', 'Default', 'home/forgot_password/', '1');
INSERT INTO `jae_menu_permit` VALUES ('21', '8', 'Edit', 'change_password/modify_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('22', '10', 'View List', 'manage_examination/show_list/', '1');
INSERT INTO `jae_menu_permit` VALUES ('23', '10', 'Add', 'manage_examination/add_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('24', '10', 'Edit', 'manage_examination/modify_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('25', '10', 'Delete', 'manage_examination/remove_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('26', '11', 'View List', 'manage_questions/show_list/', '1');
INSERT INTO `jae_menu_permit` VALUES ('27', '11', 'Add', 'manage_questions/add_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('28', '11', 'Edit', 'manage_questions/modify_information/', '1');
INSERT INTO `jae_menu_permit` VALUES ('29', '11', 'Delete', 'manage_questions/remove_information/', '1');

-- ----------------------------
-- Table structure for `jae_user`
-- ----------------------------
DROP TABLE IF EXISTS `jae_user`;
CREATE TABLE `jae_user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='User Type comes from the mp_admin_user_type table';

-- ----------------------------
-- Records of jae_user
-- ----------------------------
INSERT INTO `jae_user` VALUES ('1', 'Shieldwatch', 'Admin', 'sys_admin', 'mmondal@codeuridea.com', '314d54b67c78964df93b3f36133a51eb', '2015-05-26 12:05:39', 'northwatch150x185_1443547787.jpg', null, '1', 'No', '1', 'default', 'customer2', 'company', '1234321234', 'address', '0', null, '', '', '2', '0', '1');

-- ----------------------------
-- Table structure for `jae_user_menu`
-- ----------------------------
DROP TABLE IF EXISTS `jae_user_menu`;
CREATE TABLE `jae_user_menu` (
  `i_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `i_menu_id` int(10) unsigned NOT NULL COMMENT 'Main Menu table primary id ',
  `i_parent_id` int(10) NOT NULL DEFAULT '0',
  `i_user_id` bigint(20) unsigned NOT NULL,
  `i_role_id` int(3) NOT NULL,
  `s_set_of_action` varchar(1000) DEFAULT NULL,
  `s_set_of_menu` varchar(1000) DEFAULT NULL,
  `dt_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jae_user_menu
-- ----------------------------

-- ----------------------------
-- Table structure for `jae_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `jae_user_role`;
CREATE TABLE `jae_user_role` (
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
-- Records of jae_user_role
-- ----------------------------
INSERT INTO `jae_user_role` VALUES ('1', '0', '0', '1', '1', '2016-06-03 15:23:57', '1', '1', 'default');
DROP TRIGGER IF EXISTS `Auto_menu_order`;
DELIMITER ;;
CREATE TRIGGER `Auto_menu_order` BEFORE INSERT ON `jae_menu` FOR EACH ROW SET NEW.i_display_order = (SELECT MAX(i_display_order)+1 FROM jae_menu WHERE i_parent_id = NEW.i_parent_id)
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `sortorder_user_copy`;
DELIMITER ;;
CREATE TRIGGER `sortorder_user_copy` BEFORE INSERT ON `jae_user` FOR EACH ROW SET NEW.i_sort_order = (SELECT MAX(i_sort_order)+1 FROM ams_user)
;;
DELIMITER ;
