<?php
include_once('databaseValues.php');
$conn = @mysql_pconnect($hostName,$dbUserName,$dbPassword) or die("Database Connection Failed<br>". mysql_error());

mysql_select_db($databaseName, $conn) or die('DB not selected'); 
echo 'Add affilate '.mysql_query("ALTER TABLE  `fc_user_product` ADD  `affiliate_code` TEXT NOT NULL ,
ADD  `affiliate_script` TEXT NOT NULL");
echo 'Add xchange_policy '.mysql_query("ALTER TABLE  `fc_product` ADD  `xchange_policy` longtext NOT NULL");
echo 'Add magic '.mysql_query("ALTER TABLE  `fc_users` ADD  `magic_cat` LONGTEXT NOT NULL");
echo 'create tags '.mysql_query("CREATE TABLE if not exists `fc_tags` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1");
echo 'Add store_name '.mysql_query("ALTER TABLE  `fc_user_product` ADD  `store_name` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL");
echo 'Alter store '.mysql_query("ALTER TABLE  `fc_shops` ADD  `store_url` TEXT NOT NULL ,
ADD  `user_id` BIGINT NOT NULL ,
ADD  `description` TEXT NOT NULL ,
ADD  `store_logo` TEXT NOT NULL");
echo 'Add store_name '.mysql_query("CREATE TABLE `fc_store_claims` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");

mysql_close();

 ?>