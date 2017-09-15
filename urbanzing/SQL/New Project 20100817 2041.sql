
DROP TABLE IF EXISTS `mlm_admin`;
CREATE TABLE `mlm_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `login_status` tinyint(1) unsigned NOT NULL COMMENT '0=offline,1=online',
  `lastlogin` int(10) unsigned NOT NULL,
  `restricted` tinyint(1) unsigned NOT NULL COMMENT '0=disabale,1=enable',
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mlm_admin`
--

/*!40000 ALTER TABLE `mlm_admin` DISABLE KEYS */;
INSERT INTO `mlm_admin` (`id`,`name`,`username`,`password`,`login_status`,`lastlogin`,`restricted`,`email`) VALUES 
 (1,'admin','admin','7c4a8d09ca3762af61e59520943dc26494f8941b',1,1281954783,1,'debnath.rubel@gmail.com'),
 (3,'rubel debnath','rubel','7c4a8d09ca3762af61e59520943dc26494f8941b',0,0,1,'dynamichydra@gmail.com');
/*!40000 ALTER TABLE `mlm_admin` ENABLE KEYS */;


--
-- Definition of table `mlm_article`
--

DROP TABLE IF EXISTS `mlm_article`;
CREATE TABLE `mlm_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category_id` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keyword` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `creation_dt` int(10) NOT NULL,
  `update_dt` int(10) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `Index_2` (`title`),
  FULLTEXT KEY `Index_3` (`keyword`),
  FULLTEXT KEY `Index_4` (`description`),
  FULLTEXT KEY `Index_5` (`description`,`keyword`,`title`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mlm_article`
--

/*!40000 ALTER TABLE `mlm_article` DISABLE KEYS */;
INSERT INTO `mlm_article` (`id`,`category_id`,`title`,`keyword`,`description`,`status`,`creation_dt`,`update_dt`,`img`) VALUES 
 (1,'company_info','Company Info','','&lt;p&gt;Test company Info&lt;/p&gt;',1,1278748273,0,''),
 (4,'who_we_are','Who we are?','','&lt;p&gt;&lt;span style=&quot;color: #800000;&quot;&gt;&lt;span style=&quot;font-size: small;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: medium;&quot;&gt;If&lt;/span&gt; &lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;you are questing forward to earn money as well go for an outing this is exactly the place you have landed. Fulfill your dreams - Earn huge capital while viewing your dreamland. This is the most comprehensive company that deals with the welfare of health and wellness, life style. Vacation trips at the cheapest price you could ever imagine to the most beautiful places in the world at your convenience. A huge resource of resorts and hotels that will take your dream to the next level-where you will get both comfort as well as the best cuisine to meet your expectations in the best way.&lt;/p&gt;',1,1279029612,0,''),
 (3,'take_a_tour','dgdfg','','&lt;p&gt;dfgdfg sdfs gsgsdgsghlshglskdh glsdkhglskdhgsd ghhsdglskd hgklsdhgklsdhglsdkhioehshglshglshgsl hd gsldh glsdkhglsdgns,mgvnsldhfdkghsdlkh gklsdhg lskh glkh glksdh glksdhgiowr hgoihg lbnxm,bn ,xnb,x&lt;/p&gt;',1,1278748396,0,'article1278748391.JPG'),
 (5,'are_you_intrigued','Are You Intrigued?','','&lt;p&gt;This is no longer a secret that might keep you worried regarding the services that the company promises to offer. Just a quick search will reveal beyond doubt that you are absolutely at the best place you can dream of. Moreover, the customer feedback itself carries with it the word of self satisfaction that the company vows to provide you.&lt;/p&gt;',1,1279030036,0,''),
 (6,'company_info','About Us','','&lt;p&gt;Every day the world is entering into the new edge of development because of Binary System. We can use this system to add some more lives in our personal life as well, but still we are waiting! It might already late but not the end. Let&amp;rsquo;s start now, as we are the part and parcel of this existing world. Yes, Fairy Land Tours and Travels (popularly FLTT) is offering you the scope to utilize the Binary System to your personal life in an effective &amp;amp; efficient manner. FLTT is incorporated with the vision of providing the opportunity to add more values (both in terms of monetary &amp;amp; wellness) to everybody&amp;rsquo;s life by converting their unproductive time into productive one. Simply come, join and enjoy the power of Binary System.&lt;/p&gt;\n&lt;p style=&quot;font-weight:bold&quot;&gt;You can join with us if any of the following is happening with you.&lt;/p&gt;\n&lt;ul class=&quot;about_us&quot; style=&quot;list-style:circle; padding-left:20px; color:#7b572b;&quot;&gt;\n&lt;li&gt;May be you are tired of your Job?&lt;/li&gt;\n&lt;li&gt;May be you can&amp;rsquo;t see yourself getting ahead with your current income?&lt;/li&gt;\n&lt;li&gt;May be your dreams are still not fulfilled?&lt;/li&gt;\n&lt;li&gt;May be the commute to work and rat race have forced you to start looking for alternate ways to make money?&lt;/li&gt;\n&lt;li&gt;May be you want to spend more time with your family?&lt;/li&gt;\n&lt;li&gt;May be there is a piece missing in your life?&lt;/li&gt;\n&lt;/ul&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;Just take a decision and give your 1% to  us, FLTT is committed to give you rest of 99% to fulfill your expectations  100%.&lt;br /&gt; FLTT wishes you good luck in all your  endeavors.&lt;/p&gt;',1,1279030850,0,''),
 (7,'opportunity','opportunity','','&lt;p&gt;This is an incredibly easy way to earn Rs.90, 000/- per month. There&#039;s not just cash reward but a plethora of other kind of rewards. You just need to start from two referrals under you. The referrals would do the same thus forming two different branches of referrals on left and right hand sides. Picture this:&lt;/p&gt;\n&lt;p&gt;If you are the parent - the starting point in a binary system of networking - and left side or the number of referrals on the left hand side : right side or the number of referrals on the right hand side = 10:10, then you get a mobile or a cash award of Rs.1,000/-. Likewise, when it becomes 25:25 then you win a tour package for couple or Rs.2500/-. This way in just 12 months when the ratio becomes 800:800, you win a Malaysia trip for couple or Rs.1,00,000/-. Within three and a half years you can own a villa or have a bank balance of Rs.40 lakhs.&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;1st&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;10 : 10&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;1 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/mobile_phone.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;Mobile&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;1,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;2nd&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;25 : 25&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 2 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/tour_india.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;TOUR IN INDIA FOR Couple&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;2,500&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;3rd&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;50 : 50&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 4 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/laptop_img.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;LAOTOP&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;12,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;4th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;100 : 100&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 6 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/lcd_tour.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;L C D TV / BANGKOK TRIP&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;25,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;5th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;200 : 200&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 8 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/bike_tour.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;BIKE / SINGAPORE&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;35,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;6th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;400 : 400&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 10 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/tour_goldcoin.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;BANGKOK TOUR FOR COUPLE / GOLD COIN&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;60,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;7th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;800 : 800&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 12 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/malaysia_city.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;MALESIA TRIP FOR COUPLE&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;1,00,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;8th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;1500 : 1500&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 14 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/alto_delux.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;ALTO DELUX CAR&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;2,50,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;9th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;2000 : 2000&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 18 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/swift_car.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;SWEFT CAR&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;5,00,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;10th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;4000 : 4000&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 25 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/single_bed_room.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;1 BED ROOM FLAT&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;10,00,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;11th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;8000 : 8000&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 30 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/delux_flat.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;DELUX FLAT&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;20,00,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;12th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;16000 : 16000&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 40 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/villa.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;VILLA&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;40,00,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;',1,1279031574,0,''),
 (8,'travel_and_tourism','Travel and tourisn','','&lt;p&gt;Travel and tourism text&lt;/p&gt;',1,1279621816,0,''),
 (9,'work_from_home','work from home','','&lt;p&gt;work from home text&lt;/p&gt;',1,1279621835,0,''),
 (10,'earn_while_vaction','Earn while you are in vaction','','&lt;p&gt;Earn while you are in vaction detail&lt;/p&gt;',1,1279622297,0,''),
 (11,'testimonials','Testimonials','','&lt;p&gt;Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials&lt;/p&gt;',1,1279622719,0,''),
 (12,'business_plan','Business plan','','&lt;div id=&quot;about_us&quot;&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 1: To become an associate of FLTT, submit an application for registration. The details of the additional benefits received by the associate are mentioned below&lt;/h1&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;font-weight:bold&quot;&gt;By registering as an associate, you will get below mentioned value added benefits:&lt;/p&gt;\n&lt;ul class=&quot;about_us&quot; style=&quot;list-style:circle; padding-left:20px; color:#7b572b;&quot;&gt;\n&lt;li&gt;Get an unique ID&lt;/li&gt;\n&lt;li&gt;Rs: 60000/= Insurance of Accidental Death Benefit.&lt;/li&gt;\n&lt;li&gt;Attractive INCENTIVE.&lt;/li&gt;\n&lt;li&gt;Single Leg Income.&lt;/li&gt;\n&lt;li&gt;Plus the Opportunity to earn over RS. 90,000 per month in CASH.&lt;/li&gt;\n&lt;li&gt;Lifetime access to our promotional deals&lt;/li&gt;\n&lt;li&gt;Self Replicating Personalized Website&lt;/li&gt;\n&lt;li&gt;Virtual Office to manage your Business&lt;/li&gt;\n&lt;li&gt;One click access to discounted travel deals&lt;/li&gt;\n&lt;/ul&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h2 class=&quot;style1&quot;&gt;Registration Fee = Rs: 1500.00&lt;/h2&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 2(a): Now you are eligible to earn money. All you need to do, just refer 2 persons one at your left side and another one at your right side and your job is done&lt;/h1&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align:center; padding-top:10px;&quot;&gt;&lt;img src=&quot;../images/front/step1.png&quot; alt=&quot;&quot; /&gt;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 2(b): What you did in step2 (a), A and B will do the same in this step. You will get the incentive of Rs: 500.00 whenever the ratio of 1:2 or 2:1 is maintained irrespective of the side.&lt;/h1&gt;\n&lt;p style=&quot;text-align:center; padding-top:10px;&quot;&gt;&lt;img src=&quot;../images/front/step2b2.png&quot; alt=&quot;&quot; width=&quot;185&quot; height=&quot;248&quot; /&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;img src=&quot;../images/front/step2b.png&quot; alt=&quot;&quot; width=&quot;185&quot; height=&quot;248&quot; /&gt;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 3: You earned Rs: 500.00. Now your earning is much easier. From now onwards you don&amp;rsquo;t need to maintain the ratio of 1:2 or 2:1. Just maintain the pair, which means the ratio of 1:1 only and you will earn Rs: 500.00.&lt;/h1&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align:center; padding-top:10px;&quot;&gt;&lt;img src=&quot;../images/front/step3.png&quot; alt=&quot;&quot; width=&quot;320&quot; height=&quot;345&quot; /&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;img src=&quot;../images/front/step3b.png&quot; alt=&quot;&quot; width=&quot;320&quot; height=&quot;345&quot; /&gt;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 4: You earned Rs: 500.00. To earn another Rs : 500.00, you need to repeat the same thing what is done in Step3.&lt;/h1&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align:center; padding-top:10px;&quot;&gt;&lt;img src=&quot;../images/front/step4.png&quot; alt=&quot;&quot; width=&quot;350&quot; height=&quot;439&quot; /&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;img src=&quot;../images/front/step4b.png&quot; alt=&quot;&quot; width=&quot;350&quot; height=&quot;439&quot; /&gt;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 5: You earned Rs: 500.00. To earn another Rs : 500.00, again you need to repeat the same thing on continuous basis.&lt;/h1&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h2 class=&quot;style2&quot;&gt;Addional Earning:&lt;/h2&gt;\n&lt;span class=&quot;style3&quot;&gt;1.	By continuing this process, while you will have 50 references under you irrespective of the side, then you will earn Rs. 1500.00 (=50X30) as an advance single leg income.\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/span&gt;&lt;/div&gt;',1,1279624356,0,''),
 (13,'contact_us','Contact Us','','&lt;p&gt;Phone1: +91-7797039753&lt;/p&gt;\n&lt;p&gt;Phone2: +91-7797039753&lt;/p&gt;\n&lt;p&gt;Email: &lt;a href=&quot;mailto:info@fltt.in&quot;&gt;info@fltt.in&lt;/a&gt;&lt;/p&gt;',1,1279636168,0,''),
 (14,'profile_home_message','sdfgsdfg','','&lt;p&gt;This is profile home message&lt;/p&gt;',1,1280562687,0,''),
 (15,'welcome_letter','xcxcx','','&lt;div class=&quot;welcome&quot;&gt;&lt;img src=&quot;../images/front/design.png&quot; alt=&quot;&quot; /&gt;\n&lt;p&gt;&lt;strong&gt;Dear Customer,&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;Welcome to FLTT. We provide you with one of the easiest ways of earning big and fast from the comfort of your home, and even when you are on our sponsored tours.&lt;/p&gt;\n&lt;p&gt;Ours is a network marketing based on the binary referral system. Stay-at-home or working moms, busy dads, and just about anyone can do this business part time or full time. It&amp;rsquo;s incredibly easy.&lt;/p&gt;\n&lt;p&gt;Many thanks indeed to log in to our site. Now start earning, and win exciting gifts. Best of luck!&lt;/p&gt;\n&lt;h6&gt;Warm Regards, &lt;br /&gt;FLTT.&lt;/h6&gt;\n&lt;img src=&quot;../images/front/design02.png&quot; alt=&quot;&quot; /&gt;&lt;/div&gt;',1,1280569830,0,'');
/*!40000 ALTER TABLE `mlm_article` ENABLE KEYS */;


--
-- Definition of table `mlm_automail`
--

DROP TABLE IF EXISTS `mlm_automail`;
CREATE TABLE `mlm_automail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `subject` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mlm_automail`
--

/*!40000 ALTER TABLE `mlm_automail` DISABLE KEYS */;
INSERT INTO `mlm_automail` (`id`,`item_type`,`description`,`subject`) VALUES 
 (1,'0','Jmx0O3AmZ3Q7RGVhciAlJXVzZXJfX3VzZXJuYW1lJSUsJmx0Oy9wJmd0OwombHQ7cCZndDsmYW1wO25ic3A7Jmx0Oy9wJmd0Ow==','0'),
 (2,'add_user','Jmx0O3AmZ3Q7RGVhciAlJXVzZXJfX25hbWUlJSwmbHQ7L3AmZ3Q7CiZsdDtwJmd0OyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsgWW91ciBhY2NvdW50IGhhc2JlZW4gY3JlYXRlZCBieSBzaXRlIGFkbWluLiBZb3VyIGxvZ2luIGRldGFpbHMgYXJlIGZvbGxvdy4mbHQ7L3AmZ3Q7CiZsdDtwJmd0OyZhbXA7bmJzcDsmbHQ7L3AmZ3Q7CiZsdDtwJmd0O0xvZ2luIElEOiAlJXVzZXJfX3VzZXJuYW1lJSUmbHQ7L3AmZ3Q7CiZsdDtwJmd0O1Bhc3N3b3JkOiAlJXVzZXJfX3Bhc3N3b3JkJSUmbHQ7L3AmZ3Q7CiZsdDtwJmd0O1lvdXIgQ29kZTogJSV1c2VyX191c2VyX2NvZGUlJSZsdDsvcCZndDsKJmx0O3AmZ3Q7JmFtcDtuYnNwOyZsdDsvcCZndDsKJmx0O3AmZ3Q7UGxlYXNlICUlY2xpY2toZXJlJSUgdG8gdmlzaXQgdGhlIHNpdGUuJmx0Oy9wJmd0OwombHQ7cCZndDsmYW1wO25ic3A7Jmx0Oy9wJmd0OwombHQ7cCZndDtUaGFua3MmbHQ7L3AmZ3Q7','New user added'),
 (3,'forgot_password_admin','Jmx0O3AmZ3Q7RGVhciAlJWFkbWluX19uYW1lJSUsJmx0Oy9wJmd0OwombHQ7cCZndDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyBZb3VyIHBhc3N3b3JkIGhhc2JlZW4gY2hhbmdlZC4geW91ciBuZXcgcGFzc3dvcmQgaXMgJSVhZG1pbl9fcGFzc3dvcmQlJS4mbHQ7L3AmZ3Q7CiZsdDtwJmd0O1RoYW5rcyZsdDsvcCZndDs=','Forgot password'),
 (4,'block_user_admin','Jmx0O3AmZ3Q7RGVhciAlJWFkbWluX19uYW1lJSUsJmx0Oy9wJmd0OwombHQ7cCZndDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsgWW91ciBhY2NvdW50IGhhc2JlZW4gYmxvY2tlZC4gUGxlYXNlIGRvIGNvbnRhY3Qgd2l0aCBzdXBlciBhZG1pbiBmb3IgZGV0YWlsLiZsdDsvcCZndDsKJmx0O3AmZ3Q7JmFtcDtuYnNwOyZsdDsvcCZndDsKJmx0O3AmZ3Q7VGhhbmtzJmx0Oy9wJmd0Ow==','Block account'),
 (5,'unblock_user_admin','Jmx0O3AmZ3Q7RGVhciAlJWFkbWluX19uYW1lJSUsJmx0Oy9wJmd0OwombHQ7cCZndDtZb3VyIGFjY291bnQgaGFzYmVlbiB1bmJsb2NrZWQuIFlvdSBjYW4gdXNlIHRoZSBhY2NvdW50IG5vdy4mbHQ7L3AmZ3Q7CiZsdDtwJmd0OyZsdDticiAvJmd0O1RoYW5rcyZsdDsvcCZndDsKJmx0O3AmZ3Q7JmFtcDtuYnNwOyZsdDsvcCZndDs=','Unblock account'),
 (6,'block_user','Jmx0O3AmZ3Q7RGVhciAlJXVzZXJfX25hbWUlJSwmbHQ7L3AmZ3Q7CiZsdDtwJmd0O1lvdXIgYWNjb3VudCBoYXNiZWVuIGJsb2NrZWQuIFBsZWFzZSBkbyBjb250YWN0IHdpdGggc3VwZXIgYWRtaW4gZm9yIGRldGFpbC4mbHQ7L3AmZ3Q7CiZsdDtwJmd0OyZsdDticiAvJmd0O1RoYW5rcyZsdDsvcCZndDsKJmx0O3AmZ3Q7JmFtcDtuYnNwOyZsdDsvcCZndDs=','Block account'),
 (7,'unblock_user','Jmx0O3AmZ3Q7RGVhciAlJXVzZXJfX25hbWUlJSwmbHQ7L3AmZ3Q7CiZsdDtwJmd0O1lvdXIgYWNjb3VudCBoYXNiZWVuIHVuIGJsb2NrZWQuIFlvdSBjYW4gZG8gbG9naW4gbm93LiZsdDsvcCZndDsKJmx0O3AmZ3Q7Jmx0O2JyIC8mZ3Q7VGhhbmtzJmx0Oy9wJmd0OwombHQ7cCZndDsmYW1wO25ic3A7Jmx0Oy9wJmd0Ow==','Unblock account'),
 (8,'forgot_password','Jmx0O3AmZ3Q7RGVhciAlJXVzZXJfX25hbWUlJSwmbHQ7L3AmZ3Q7CiZsdDtwJmd0O1lvdXIgcGFzc3dvcmQgaGFzYmVlbiBjaGFuZ2VkLiB5b3VyIG5ldyBwYXNzd29yZCBpcyAlJXVzZXJfX3Bhc3N3b3JkJSUuJmx0Oy9wJmd0OwombHQ7cCZndDtUaGFua3MmbHQ7L3AmZ3Q7CiZsdDtwJmd0OyZhbXA7bmJzcDsmbHQ7L3AmZ3Q7','Forgot password');
/*!40000 ALTER TABLE `mlm_automail` ENABLE KEYS */;


--
-- Definition of table `mlm_category`
--

DROP TABLE IF EXISTS `mlm_category`;
CREATE TABLE `mlm_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `item_type` varchar(30) NOT NULL,
  `creation_dt` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mlm_category`
--

/*!40000 ALTER TABLE `mlm_category` DISABLE KEYS */;
INSERT INTO `mlm_category` (`id`,`name`,`item_type`,`creation_dt`,`parent_id`) VALUES 
 (1,'Test Contact','contact_us',1278747069,0),
 (2,'Test Contact 1','contact_us',1278747084,1),
 (4,'afsd','site_faq',1278941366,0),
 (5,'sdsd','site_faq',1278941388,0);
/*!40000 ALTER TABLE `mlm_category` ENABLE KEYS */;


--
-- Definition of table `mlm_countries`
--

DROP TABLE IF EXISTS `mlm_countries`;
CREATE TABLE `mlm_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_fr` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) NOT NULL,
  `default_country` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `mlm_countries`
--

/*!40000 ALTER TABLE `mlm_countries` DISABLE KEYS */;
INSERT INTO `mlm_countries` (`id`,`name_fr`,`name_en`,`default_country`) VALUES 
 (-1,'No country specified','No country specified','N'),
 (1,'Afghanistan','Afghanistan','N'),
 (2,'Afrique du Sud','South Africa','N'),
 (3,'Albanie','Albania','N'),
 (4,'Algérie','Algeria','N'),
 (5,'Allemagne','Germany','N'),
 (6,'Andorre','Andorra','N'),
 (7,'Angola','Angola','N'),
 (8,'Anguilla','Anguilla','N'),
 (9,'Antilles','Caribbean','N'),
 (10,'Arabie Saoudite','Saudi Arabia','N'),
 (11,'Argentine','Argentina','N'),
 (12,'Arménie','Armenia','N'),
 (13,'Australie','Australia','N'),
 (14,'Autriche','Austria','N'),
 (15,'Azerbaïdjan','Azerbaijan','N'),
 (16,'Bahamas','Bahamas','N'),
 (17,'Bahreïn','Bahrain','N'),
 (18,'Bangladesh','Bangladesh','N'),
 (19,'Barbade','Barbados','N'),
 (20,'Bélarus','Belarus','N'),
 (21,'Belgique','Belgium','N'),
 (22,'Belize','Belize','N'),
 (23,'Bénin','Benin','N'),
 (24,'Bermudes','Bermuda','N'),
 (25,'Bolivie','Bolivia','N'),
 (26,'Bosnie-Herzégovine','Bosnia and Herzegovina','N'),
 (27,'Brésil','Brazil','N'),
 (28,'Brunéi','Brunei','N'),
 (29,'Bulgarie','Bulgaria','N'),
 (30,'Burkina Faso','Burkina Faso','N'),
 (31,'Burundi','Burundi','N'),
 (32,'Cambodge','Cambodge','N'),
 (33,'Cameroun','Cameroon','N'),
 (34,'Canada','Canada','N'),
 (35,'Chili','Chile','N'),
 (36,'Chine','China','N'),
 (37,'Chypre','Cyprus','N'),
 (38,'Colombie','Colombia','N'),
 (39,'Comores','Comoros','N'),
 (40,'Congo','Congo','N'),
 (41,'République Démocratique du Congo','Democratic Republic of Congo','N'),
 (42,'Corée','Korea','N'),
 (43,'Costa Rica','Costa Rica','N'),
 (44,'Côte d\'Ivoire','Ivory Coast','N'),
 (45,'Croatie Cuba','Cuba Croatia','N'),
 (46,'Danemark','Denmark','N'),
 (47,'Djibouti','Djibouti','N'),
 (48,'République Dominicaine','Dominican Republic','N'),
 (49,'Égypte','Egypt','N'),
 (50,'El Salvador','El Salvador','N'),
 (51,'Émirats Arabes Unis','UAE','N'),
 (52,'Équateur','Ecuador','N'),
 (53,'Espagne','Spain','N'),
 (54,'Estonie','Estonia','N'),
 (55,'États-Unis','United States','N'),
 (56,'Éthiopie','Ethiopia','N'),
 (57,'Îles Féroé','Faroe Islands','N'),
 (58,'Fidji','Fiji','N'),
 (59,'Finlande','Finland','N'),
 (60,'France','France','Y'),
 (61,'Gabon','Gabon','N'),
 (62,'Gambie','Gambia','N'),
 (63,'Géorgie','Georgia','N'),
 (64,'Géorgie','Georgia','N'),
 (65,'Gibraltar','Gibraltar','N'),
 (66,'Grèce','Greece','N'),
 (67,'Grenade','Grenada','N'),
 (68,'Guadeloupe','Guadeloupe','N'),
 (69,'Guatemala','Guatemala','N'),
 (70,'Guyane Française','French Guiana','N'),
 (71,'Haïti','Haiti','N'),
 (72,'Honduras','Honduras','N'),
 (73,'Hong-Kong','Hong-Kong','N'),
 (74,'Hongrie','Hungary','N'),
 (75,'Inde','India','N'),
 (76,'Indonésie','Indonesia','N'),
 (77,'Iran','Iran','N'),
 (78,'Iraq','Iraq','N'),
 (79,'Irlande','Ireland','N'),
 (80,'Islande','Iceland','N'),
 (81,'Israël','Israel','N'),
 (82,'Italie','Italy','N'),
 (83,'Jamaïque','Jamaica','N'),
 (84,'Japon','Japan','N'),
 (85,'Jersey','Jersey','N'),
 (86,'Jordanie','Jordan','N'),
 (87,'Kazakhstan','Kazakhstan','N'),
 (88,'Kenya','Kenya','N'),
 (89,'Kirghizistan','Kyrgyzstan','N'),
 (90,'Kiribati','Kiribati','N'),
 (91,'Koweït','Kuwait','N'),
 (92,'Lettonie','Latvia','N'),
 (93,'Liban','Lebanon','N'),
 (94,'Libéria','Liberia','N'),
 (95,'Libye','Libya','N'),
 (96,'Liechtenstein','Liechtenstein','N'),
 (97,'Lituanie','Lithuania','N'),
 (98,'Luxembourg','Luxembourg','N'),
 (99,'Macao','Macao','N'),
 (100,'Macédoine Madagascar','Macedonia Madagascar','N'),
 (101,'Malaisie','Malaysia','N'),
 (102,'Maldives','Maldives','N'),
 (103,'Mali','Mali','N'),
 (104,'Malte','Malta','N'),
 (105,'Maroc','Morocco','N'),
 (106,'Martinique','Martinique','N'),
 (107,'Mauritanie','Mauritania','N'),
 (108,'Maurice','Mauritius','N'),
 (109,'Mayotte','Mayotte','N'),
 (110,'Mexique','Mexico','N'),
 (111,'Monaco','Monaco','N'),
 (112,'Mongolie','Mongolia','N'),
 (113,'Monténégro','Montenegro','N'),
 (114,'Montserrat','Montserrat','N'),
 (115,'Mozambique','Mozambique','N'),
 (116,'Myanmar','Myanmar','N'),
 (117,'Namibie','Namibia','N'),
 (118,'Népal','Nepal','N'),
 (119,'Nicaragua','Nicaragua','N'),
 (120,'NigerNorvège','NigerNorvège','N'),
 (121,'Nouvelle-Calédonie','New Caledonia','N'),
 (122,'Nouvelle-Zélande','New Zealand','N'),
 (123,'Oman','Oman','N'),
 (124,'Ouganda','Uganda','N'),
 (125,'Ouzbékistan','Uzbekistan','N'),
 (126,'PakistanPanama','PakistanPanama','N'),
 (127,'Nouvelle-Guinée','New Guinea','N'),
 (128,'Paraguay','Paraguay','N'),
 (129,'Pays-Bas','Netherlands','N'),
 (130,'Pérou','Peru','N'),
 (131,'Philippines','Philippines','N'),
 (132,'Pologne','Poland','N'),
 (133,'Polynésie Française','French Polynesia','N'),
 (134,'Porto Rico','Puerto Rico','N'),
 (135,'Portugal','Portugal','N'),
 (136,'Qatar','Qatar','N'),
 (137,'Réunion','Réunion','N'),
 (138,'Roumanie Royaume-Uni','Romania United Kingdom','N'),
 (139,'Fédération de Russie','Russian Federation','N'),
 (140,'Sénégal','Senegal','N'),
 (141,'Serbie','Serbia','N'),
 (142,'Seychelles','Seychelles','N'),
 (143,'Sierra Leone Singapour','Sierra Leone Singapore','N'),
 (144,'Slovaquie','Slovakia','N'),
 (145,'Slovénie','Slovenia','N'),
 (146,'Somalie','Somalia','N'),
 (147,'Soudan','Sudan','N'),
 (148,'Sri Lanka','Sri Lanka','N'),
 (149,'Suède','Sweden','N'),
 (150,'Suisse','Switzerland','N'),
 (151,'Syrie','Syria','N'),
 (152,'Tadjikistan','Tajikistan','N'),
 (153,'Taïwan','Taiwan','N'),
 (154,'Tanzanie','Tanzania','N'),
 (155,'Tchad','Chad','N'),
 (156,'République Tchèque','Czech Republic','N'),
 (157,'Thaïlande','Thailand','N'),
 (158,'Togo','Togo','N'),
 (159,'Tunisie','Tunisia','N'),
 (160,'Turkménistan','Turkmenistan','N'),
 (161,'Turquie','Turkey','N'),
 (162,'Ukraine','Ukraine','N'),
 (163,'Uruguay','Uruguay','N'),
 (164,'Venezuela','Venezuela','N'),
 (165,'Yémen','Yemen','N'),
 (166,'Zambie','Zambia','N'),
 (167,'Zimbabwe','Zimbabwe','N'),
 (168,'Botswana','Botswana','N'),
 (169,'Nigeria','Nigeria','N'),
 (170,'Ghana','Ghana','N'),
 (171,'Trinité-et-Tobago','Trinidad & Tobago','N');
/*!40000 ALTER TABLE `mlm_countries` ENABLE KEYS */;


--
-- Definition of table `mlm_faq`
--

DROP TABLE IF EXISTS `mlm_faq`;
CREATE TABLE `mlm_faq` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(250) NOT NULL,
  `faq_category` varchar(250) NOT NULL,
  `faq_question` varchar(250) NOT NULL,
  `faq_answer` text NOT NULL,
  `poted_date` datetime NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1' COMMENT '1 for active,0 forinactive',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `Index_2` (`faq_question`),
  FULLTEXT KEY `Index_3` (`faq_answer`),
  FULLTEXT KEY `Index_4` (`faq_question`,`faq_answer`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mlm_faq`
--

/*!40000 ALTER TABLE `mlm_faq` DISABLE KEYS */;
INSERT INTO `mlm_faq` (`id`,`item_type`,`faq_category`,`faq_question`,`faq_answer`,`poted_date`,`status`) VALUES 
 (1,'site_faq','4','question one','&lt;p&gt;answer one....&lt;/p&gt;','2010-07-12 19:00:18',1);
/*!40000 ALTER TABLE `mlm_faq` ENABLE KEYS */;


--
-- Definition of table `mlm_inter_message`
--

DROP TABLE IF EXISTS `mlm_inter_message`;
CREATE TABLE `mlm_inter_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `item_type` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL,
  `read_status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mlm_inter_message`
--

/*!40000 ALTER TABLE `mlm_inter_message` DISABLE KEYS */;
INSERT INTO `mlm_inter_message` (`id`,`category_id`,`name`,`email`,`message`,`date`,`item_type`,`status`,`read_status`) VALUES 
 (1,0,'fgh','fgh@sss.com','fgh',1279637555,'contact_us','inbox','read'),
 (2,0,'fhgf hf','debnath.rubel@gmail.com','sdkjfhs dfh skdjfhskjdfh skdjfhs djkfh skjdfh sdkjfh skjfhsdiofrysdof hsldjkfh slhflshkdflise ohs ldhfl shdgl shdlgkhsl dghsoieoasjldfjalfjalfj al;fj a;fj; ajf; afj;a sfjsadfj sdkf spd fpsd fpo  fsd',1279637670,'contact_us','archive','read');
/*!40000 ALTER TABLE `mlm_inter_message` ENABLE KEYS */;


--
-- Definition of table `mlm_payout`
--

DROP TABLE IF EXISTS `mlm_payout`;
CREATE TABLE `mlm_payout` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_code` varchar(30) NOT NULL,
  `payout_date` int(10) unsigned NOT NULL,
  `level_for` int(5) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `pay_date` int(10) unsigned NOT NULL,
  `pay_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mlm_payout`
--

/*!40000 ALTER TABLE `mlm_payout` DISABLE KEYS */;
INSERT INTO `mlm_payout` (`id`,`user_code`,`payout_date`,`level_for`,`status`,`pay_date`,`pay_amount`) VALUES 
 (40,'rJMtsJm6',1281360438,1,0,0,'500.00'),
 (41,'A2hq12xi',1281360438,1,0,0,'500.00'),
 (42,'5fa1L6Zv',1281360438,1,0,0,'500.00'),
 (43,'5fa1L6Zv',1281360438,2,0,0,'500.00'),
 (44,'5fa1L6Zv',1281360438,3,0,0,'500.00'),
 (45,'RGEdb6HF',1281360438,1,0,0,'500.00'),
 (46,'5rm2NLk3',1281360438,1,0,0,'500.00');
/*!40000 ALTER TABLE `mlm_payout` ENABLE KEYS */;


--
-- Definition of trigger `update_user_amount`
--

DROP TRIGGER /*!50030 IF EXISTS */ `update_user_amount`;

DELIMITER $$

CREATE DEFINER = `root`@`localhost` TRIGGER `update_user_amount` AFTER INSERT ON `mlm_payout` FOR EACH ROW begin
UPDATE mlm_user SET total_income=total_income+new.pay_amount WHERE user_code=new.user_code;
end $$

DELIMITER ;

--
-- Definition of table `mlm_product`
--

DROP TABLE IF EXISTS `mlm_product`;
CREATE TABLE `mlm_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `in_rule` varchar(30) NOT NULL,
  `img` varchar(255) NOT NULL,
  `code_prefix` varchar(10) NOT NULL,
  `join_amount` decimal(10,2) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mlm_product`
--

/*!40000 ALTER TABLE `mlm_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_product` ENABLE KEYS */;


--
-- Definition of table `mlm_site_settings`
--

DROP TABLE IF EXISTS `mlm_site_settings`;
CREATE TABLE `mlm_site_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_page_limit` int(3) unsigned NOT NULL,
  `default_language` varchar(20) NOT NULL,
  `max_image_file_size` int(6) unsigned NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `site_moto` varchar(255) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `paypal_email` varchar(100) NOT NULL,
  `default_currency` varchar(10) NOT NULL,
  `mail_from_name` varchar(100) NOT NULL,
  `mail_from_email` varchar(100) NOT NULL,
  `mail_replay_name` varchar(100) NOT NULL,
  `mail_replay_email` varchar(100) NOT NULL,
  `mail_protocol` varchar(30) NOT NULL,
  `paypal_currency` varchar(10) NOT NULL,
  `registration_charge` decimal(10,2) NOT NULL,
  `smtp_host` varchar(100) NOT NULL,
  `smtp_user` varchar(100) NOT NULL,
  `smtp_pass` varchar(100) NOT NULL,
  `conversion_rate` decimal(10,2) NOT NULL,
  `paypal_charge` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mlm_site_settings`
--

/*!40000 ALTER TABLE `mlm_site_settings` DISABLE KEYS */;
INSERT INTO `mlm_site_settings` (`id`,`admin_page_limit`,`default_language`,`max_image_file_size`,`site_name`,`site_moto`,`admin_email`,`paypal_email`,`default_currency`,`mail_from_name`,`mail_from_email`,`mail_replay_name`,`mail_replay_email`,`mail_protocol`,`paypal_currency`,`registration_charge`,`smtp_host`,`smtp_user`,`smtp_pass`,`conversion_rate`,`paypal_charge`) VALUES 
 (1,10,'1',1500,'1','1','debnath.rubel@gmail.com','admin@admin.com','#36;','MLM Admin','admin@admin.com','donotReply','donotReply@mlm.com','smtp','USD','1200.00','mail.acumensofttech.com','testing@acumensofttech.com','hello@mail','0.00','0.00');
/*!40000 ALTER TABLE `mlm_site_settings` ENABLE KEYS */;


--
-- Definition of table `mlm_sms`
--

DROP TABLE IF EXISTS `mlm_sms`;
CREATE TABLE `mlm_sms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mlm_sms`
--

/*!40000 ALTER TABLE `mlm_sms` DISABLE KEYS */;
INSERT INTO `mlm_sms` (`id`,`title`,`category`,`description`,`status`) VALUES 
 (1,'111','user_registration','sfsd fs fsdfsdfsdfsdfsfsfs',1),
 (3,'sfdertert erte','user_registration','hkjhsdk fskfshk jfshfk jsdkf shkf hsjkf hksjf',0),
 (4,'sfsd sdfsdfsdf','user_registration','sd fsf sfhskfhkhsdf fkjsh k',1);
/*!40000 ALTER TABLE `mlm_sms` ENABLE KEYS */;


--
-- Definition of table `mlm_uesr_payment`
--

DROP TABLE IF EXISTS `mlm_uesr_payment`;
CREATE TABLE `mlm_uesr_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pay_type` varchar(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `p_date` int(10) unsigned NOT NULL,
  `referance` varchar(100) NOT NULL,
  `user_code` varchar(30) NOT NULL,
  `card_type` varchar(30) NOT NULL,
  `card_number` varchar(30) NOT NULL,
  `e_date` varchar(10) NOT NULL,
  `card_v_number` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mlm_uesr_payment`
--

/*!40000 ALTER TABLE `mlm_uesr_payment` DISABLE KEYS */;
INSERT INTO `mlm_uesr_payment` (`id`,`pay_type`,`amount`,`p_date`,`referance`,`user_code`,`card_type`,`card_number`,`e_date`,`card_v_number`) VALUES 
 (1,'Card','1200.00',1279552827,'','QTSb99TA','Visa','11111111111111','2-2024','0000'),
 (2,'Card','1200.00',1279552911,'','QTSb99TA','Visa','11111111111111','2-2024','0000'),
 (3,'Card','1200.00',1279553535,'','m7mxz5Fr','MasterCard','11111111111111','5-2017','0000'),
 (4,'Card','1200.00',1279553670,'','1qL84QyG','MasterCard','11111111111111','3-2026','0000'),
 (5,'Card','1200.00',1279553834,'','HpkN8BjB','Discover','11111111111111','7-2025','0000'),
 (6,'Card','1200.00',1279554019,'','HpkN8BjB','Discover','11111111111111','7-2025','0000'),
 (7,'Card','1200.00',1279554475,'','Dff8xx7p','Discover','11111111111111','5-2024','0000'),
 (8,'Paypal','1200.00',1279555087,'','TsmYAi4C','','','','');
/*!40000 ALTER TABLE `mlm_uesr_payment` ENABLE KEYS */;


--
-- Definition of table `mlm_user`
--

DROP TABLE IF EXISTS `mlm_user`;
CREATE TABLE `mlm_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `postal_address` varchar(255) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `sex` char(1) NOT NULL,
  `dob` int(10) unsigned NOT NULL,
  `m_status` char(1) NOT NULL COMMENT 'm=married,s=single',
  `phone` varchar(15) NOT NULL,
  `phone_1` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pan_no` varchar(15) NOT NULL,
  `p_id` varchar(15) NOT NULL,
  `level` int(10) unsigned NOT NULL,
  `serial_code` varchar(30) NOT NULL,
  `user_code` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `restricted` tinyint(1) unsigned NOT NULL COMMENT '0=disebale,1=enable',
  `left_child` varchar(15) NOT NULL,
  `right_child` varchar(15) NOT NULL,
  `join_date` int(10) unsigned NOT NULL,
  `total_income` decimal(10,2) NOT NULL,
  `lastlogin` int(10) unsigned NOT NULL,
  `online_status` tinyint(1) unsigned NOT NULL,
  `verification_code` varchar(30) NOT NULL,
  `nominee_name` varchar(200) NOT NULL,
  `nominee_postal_address` varchar(500) NOT NULL,
  `nominee_dob` int(10) unsigned NOT NULL,
  `nominee_relation` varchar(100) NOT NULL,
  `acc_name` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `acc_no` varchar(50) NOT NULL,
  `acc_type` char(1) NOT NULL,
  `activation_code` varchar(30) NOT NULL,
  `pay_out_no` int(10) NOT NULL,
  `total_paid` decimal(10,2) NOT NULL,
  `country` varchar(50) NOT NULL,
  `ifsc_code` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mlm_user`
--

/*!40000 ALTER TABLE `mlm_user` DISABLE KEYS */;
INSERT INTO `mlm_user` (`id`,`username`,`name`,`postal_address`,`city`,`state`,`sex`,`dob`,`m_status`,`phone`,`phone_1`,`email`,`pan_no`,`p_id`,`level`,`serial_code`,`user_code`,`password`,`restricted`,`left_child`,`right_child`,`join_date`,`total_income`,`lastlogin`,`online_status`,`verification_code`,`nominee_name`,`nominee_postal_address`,`nominee_dob`,`nominee_relation`,`acc_name`,`bank_name`,`branch_name`,`acc_no`,`acc_type`,`activation_code`,`pay_out_no`,`total_paid`,`country`,`ifsc_code`) VALUES 
 (1,'rubel','rubel debnath','dasda','kolkata','west bengal','M',315513000,'S','bb','sefrs','debnath.rubel1@gmail.com','fsdfsdf','',0,'','5fa1L6Zv','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'RGEdb6HF','8DPNcHWH',1278418575,'1500.00',1281649991,1,'','fgdgdf','dfgdfg',1970,'dfgdfg','dfgdfgdfgd','dfgdf','dfgdf','dfg','S','',3,'1200.00','India','fsdfsdf'),
 (4,'iman','iman biswas','hgsdgfj','hjgjh','jhghj','M',0,'S','','','iman@acumensoft.info','','RGEdb6HF',2,'4c0YCuM0zs05','A2hq12xi','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'TsmYAi4C','5rm2NLk3',1278426481,'500.00',0,0,'','','',0,'','','','','','0','',1,'0.00','',''),
 (7,'suman','suman chalki','kjklj','lkjlkj','lkjlkj','M',2010,'S','','','suman_c@acumensoft.info','','5fa1L6Zv',1,'QLqx29imLD99','8DPNcHWH','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'XCNd3bsa','751jha1x',1278426623,'0.00',0,0,'','','',0,'','','','','','0','',0,'0.00','',''),
 (8,'soma','soma bose','jkhk','khkjh','kjhkjh','M',0,'S','','','soma@acumensoft.info','','5fa1L6Zv',1,'yHXkb9zn0W29','RGEdb6HF','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'A2hq12xi','R59kH7sC',1278426810,'500.00',0,0,'','','',0,'','','','','','0','',1,'0.00','',''),
 (9,'kunal','kunal roy','jhg','hjgjh','jhgj','M',2010,'S','','','kunal@acumensoft.info','','RGEdb6HF',2,'4cCD2VU7E4zP','R59kH7sC','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'','',1278427258,'0.00',0,0,'','','',0,'','','','','','0','',0,'0.00','',''),
 (10,'subashis','subashis roy','jhk','hkjhkjh','kjhk','M',1278354600,'S','','','subhashis@acumensoft.info','','A2hq12xi',3,'4063m524n4y9','5rm2NLk3','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'rJMtsJm6','f189mz90',1278604935,'500.00',0,0,'','','',0,'','','','','','0','',1,'0.00','',''),
 (11,'amar','amar shing','kjhk','hkh','kjhk','M',1278527400,'S','','','amar@acumensoft.info','','5rm2NLk3',4,'8FGugv81W4i5','rJMtsJm6','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'Dff8xx7p','QTSb99TA',1278605364,'500.00',0,0,'','','',0,'','','','','','0','',1,'0.00','',''),
 (12,'arijit','arijit','asdjkhkj','jkhjk','kjhjk','M',1279477800,'S','','','arigit@gmail.com','','rJMtsJm6',5,'','QTSb99TA','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'XiqkybUu','yZ505M1s',1279552824,'0.00',0,0,'','','',0,'','','','','','0','',0,'0.00','',''),
 (18,'alok','alok','sdkfskhf sk','jkhkj hkj ','sdfs dfsdfsd','M',1279477800,'S','','','alok@gmail.com','','rJMtsJm6',5,'','Dff8xx7p','7c4a8d09ca3762af61e59520943dc26494f8941b',0,'00RNzSTD','X4txrYLc',1279554473,'0.00',0,0,'','','',0,'','','','','','0','',0,'0.00','',''),
 (19,'susmita','susmita','kjhsdkf kj ','jklkj asdkl','kljl jk ','M',1279477800,'S','','','susmita@gmail.com','','A2hq12xi',3,'','TsmYAi4C','7c4a8d09ca3762af61e59520943dc26494f8941b',0,'','',1279555055,'0.00',0,0,'','','',0,'','','','','','0','',0,'0.00','',''),
 (22,'nabarun','nabarun','kjk','kjhkj','kjhjk','M',1279477800,'S','','','nabarun@gmail.com','','5rm2NLk3',4,'G336JDbyFu3G','f189mz90','7c4a8d09ca3762af61e59520943dc26494f8941b',0,'','',1279555498,'0.00',0,0,'','','',0,'','','','','','0','',0,'0.00','',''),
 (23,'ghan','ghan','kljkl','j lk','j lj','M',1279737000,'S','353453','','ghan@gmail.com','','QTSb99TA',6,'MpXLL3BpR32s','XiqkybUu','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'51bWA7Dq','',1279797049,'0.00',0,0,'','','',0,'','','','','','0','',0,'0.00','',''),
 (24,'sambo','sambo','dsfksdhfk js','jkh jk',' jkh ','M',1279737000,'S','','','debnassth.rubel@gmail.com','','QTSb99TA',6,'4Ar3stySm6Ci','yZ505M1s','0a304c1c01bf3ff98c4dd3331345ed2be37beeb9',1,'','',1279798185,'0.00',0,0,'','','',0,'','','','','','0','',0,'0.00','',''),
 (25,'samba','samba','sdfksgk','khk','hjkjh','M',334348200,'S','','','samba@gmail.com','','8DPNcHWH',2,'f77LJDYyg5d1','XCNd3bsa','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'','',1281080126,'0.00',0,0,'','','',0,'','','','','','','',0,'0.00','',''),
 (26,'vaskar','vaskar','jkhykkj','kjhkjh','kjhk','M',649881000,'S','','','vaskar@gmail.com','','8DPNcHWH',2,'ad2423vS3B9Y','751jha1x','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'','',1281080182,'0.00',0,0,'','','',0,'','','','','','','',0,'0.00','',''),
 (27,'testtest','test test','qwewrw','kjh','dfgdfgd','M',1280773800,'S','4564564','9674005916','desdfdbnath.rubel@gmail.com','fsdfsdf','Dff8xx7p',6,'5rhA62L3bKBP','X4txrYLc','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'','',1281542770,'0.00',0,0,'SUk0iL0Vg907WJs','','',0,'','','','','','','',0,'0.00','',''),
 (28,'tapan','tapan','jh','kjhkjh','kjhk','M',1281465000,'S','345345','9674005916','debnasdfsdth.rubel@gmail.com','trytryr','Dff8xx7p',6,'5rhA62L3bKBP','00RNzSTD','7c4a8d09ca3762af61e59520943dc26494f8941b',1,'','',1281543279,'0.00',0,0,'d1Yh0J1s6np6zFD','','',0,'','','','','','','',0,'0.00','',''),
 (29,'kjhjkhjkh','1nbm,','jhgjhg','hjghj','jhghjg','M',1281465000,'S','','9674005916','debnath.rubel@gmail.com','','XiqkybUu',7,'45k7K099xCy0','51bWA7Dq','7c4a8d09ca3762af61e59520943dc26494f8941b',0,'','',1281543732,'0.00',0,0,'bt6yAHG3m7a75D9','','',0,'','','','','','','',0,'0.00','','');
/*!40000 ALTER TABLE `mlm_user` ENABLE KEYS */;


--
-- Definition of trigger `trigger_update_user_pin`
--

DROP TRIGGER /*!50030 IF EXISTS */ `trigger_update_user_pin`;

DELIMITER $$

CREATE DEFINER = `root`@`localhost` TRIGGER `trigger_update_user_pin` AFTER INSERT ON `mlm_user` FOR EACH ROW begin
UPDATE mlm_user_pincode SET status=1,used_user=new.user_code WHERE  pin_code=new.serial_code;
end $$

DELIMITER ;

--
-- Definition of trigger `trigger_change_user_pin`
--

DROP TRIGGER /*!50030 IF EXISTS */ `trigger_change_user_pin`;

DELIMITER $$

CREATE DEFINER = `root`@`localhost` TRIGGER `trigger_change_user_pin` AFTER UPDATE ON `mlm_user` FOR EACH ROW begin
UPDATE mlm_user_pincode SET status=1,used_user=new.user_code,used_date=NOW() WHERE  pin_code=new.serial_code;
end $$

DELIMITER ;

--
-- Definition of table `mlm_user_pincode`
--

DROP TABLE IF EXISTS `mlm_user_pincode`;
CREATE TABLE `mlm_user_pincode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_code` varchar(15) NOT NULL,
  `pin_code` varchar(15) NOT NULL,
  `date_creation` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL COMMENT '1=used,0=unused',
  `used_user` varchar(15) NOT NULL,
  `used_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mlm_user_pincode`
--

/*!40000 ALTER TABLE `mlm_user_pincode` DISABLE KEYS */;
INSERT INTO `mlm_user_pincode` (`id`,`user_code`,`pin_code`,`date_creation`,`status`,`used_user`,`used_date`) VALUES 
 (5,'5fa1L6Zv','88G9pc9G87Ep',1278425955,0,'','0000-00-00 00:00:00'),
 (6,'5fa1L6Zv','QLqx29imLD99',1278425955,1,'8DPNcHWH','0000-00-00 00:00:00'),
 (7,'5fa1L6Zv','yHXkb9zn0W29',1278425955,1,'RGEdb6HF','0000-00-00 00:00:00'),
 (8,'5fa1L6Zv','M1jArwyt1PxZ',1278425955,0,'','0000-00-00 00:00:00'),
 (9,'5fa1L6Zv','Hkv52CDkdB34',1278425955,0,'','0000-00-00 00:00:00'),
 (10,'5fa1L6Zv','ip9uw1C4t7vb',1278425955,0,'','0000-00-00 00:00:00'),
 (11,'5fa1L6Zv','2q7pL44z1NQE',1278425955,0,'','0000-00-00 00:00:00'),
 (12,'5fa1L6Zv','YT859RjxQ1GD',1278425955,0,'','0000-00-00 00:00:00'),
 (13,'5fa1L6Zv','5rhA62L3bKBP',1278425955,0,'','0000-00-00 00:00:00'),
 (14,'RGEdb6HF','4cCD2VU7E4zP',1278427246,1,'R59kH7sC','0000-00-00 00:00:00'),
 (15,'RGEdb6HF','4c0YCuM0zs05',1278427246,1,'A2hq12xi','0000-00-00 00:00:00'),
 (16,'RGEdb6HF','r0x26Q8B5Enp',1278427246,0,'','0000-00-00 00:00:00'),
 (17,'RGEdb6HF','9rmKhX44izh3',1278427246,0,'','0000-00-00 00:00:00'),
 (18,'RGEdb6HF','awz47Z95T3aw',1278427246,0,'','0000-00-00 00:00:00'),
 (19,'8DPNcHWH','f77LJDYyg5d1',1278432148,1,'XCNd3bsa','0000-00-00 00:00:00'),
 (20,'8DPNcHWH','ad2423vS3B9Y',1278432148,1,'751jha1x','0000-00-00 00:00:00'),
 (21,'8DPNcHWH','k7kQrtGXDwrT',1278432148,0,'','0000-00-00 00:00:00'),
 (22,'8DPNcHWH','ajGTC9iB7MJy',1278432148,0,'','0000-00-00 00:00:00'),
 (23,'A2hq12xi','4063m524n4y9',1278438028,1,'5rm2NLk3','0000-00-00 00:00:00'),
 (24,'A2hq12xi','826HxdY9isbg',1278438028,0,'','0000-00-00 00:00:00'),
 (25,'A2hq12xi','8xWjyGf1Q2zr',1278438028,0,'','0000-00-00 00:00:00'),
 (26,'5rm2NLk3','8FGugv81W4i5',1278605356,1,'rJMtsJm6','0000-00-00 00:00:00'),
 (27,'5rm2NLk3','G336JDbyFu3G',1279555189,1,'f189mz90','0000-00-00 00:00:00'),
 (28,'5rm2NLk3','16F7pxN016B3',1279555189,0,'','0000-00-00 00:00:00'),
 (29,'5rm2NLk3','7G2Vub73SEzV',1279555189,0,'','0000-00-00 00:00:00'),
 (30,'QTSb99TA','MpXLL3BpR32s',1279797038,1,'XiqkybUu','0000-00-00 00:00:00'),
 (31,'QTSb99TA','4Ar3stySm6Ci',1279797038,1,'yZ505M1s','0000-00-00 00:00:00'),
 (32,'QTSb99TA','V9c26iaPsLBU',1279797038,0,'','0000-00-00 00:00:00'),
 (33,'rJMtsJm6','X83TV30JLxn1',1281079454,0,'','0000-00-00 00:00:00'),
 (34,'rJMtsJm6','S3Tw3DrNypp4',1281079454,0,'','0000-00-00 00:00:00'),
 (35,'rJMtsJm6','F2Kt6h7AQyP8',1281079454,0,'','0000-00-00 00:00:00'),
 (36,'rJMtsJm6','86N9BjjLQDk3',1281079454,0,'','0000-00-00 00:00:00'),
 (37,'5fa1L6Zv','4rXNPK0UJjR3',1281519063,0,'','0000-00-00 00:00:00'),
 (38,'5fa1L6Zv','45k7K099xCy0',1281519160,0,'','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `mlm_user_pincode` ENABLE KEYS */;


--
-- Definition of table `mlm_user_tmp`
--

DROP TABLE IF EXISTS `mlm_user_tmp`;
CREATE TABLE `mlm_user_tmp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `postal_address` varchar(255) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `sex` char(1) NOT NULL,
  `dob` int(10) unsigned NOT NULL,
  `m_status` char(1) NOT NULL COMMENT 'm=married,s=single',
  `phone` varchar(15) NOT NULL,
  `phone_1` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pan_no` varchar(15) NOT NULL,
  `p_id` varchar(15) NOT NULL,
  `level` int(10) unsigned NOT NULL,
  `serial_code` varchar(30) NOT NULL,
  `user_code` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `restricted` tinyint(1) unsigned NOT NULL COMMENT '0=disebale,1=enable',
  `left_child` varchar(15) NOT NULL,
  `right_child` varchar(15) NOT NULL,
  `join_date` int(10) unsigned NOT NULL,
  `total_income` decimal(10,2) NOT NULL,
  `lastlogin` int(10) unsigned NOT NULL,
  `online_status` tinyint(1) unsigned NOT NULL,
  `verification_code` varchar(30) NOT NULL,
  `nominee_name` varchar(200) NOT NULL,
  `nominee_postal_address` varchar(500) NOT NULL,
  `nominee_dob` int(10) unsigned NOT NULL,
  `nominee_relation` varchar(100) NOT NULL,
  `acc_name` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `acc_no` varchar(50) NOT NULL,
  `acc_type` char(1) NOT NULL,
  `activation_code` varchar(30) NOT NULL,
  `pay_out_no` int(10) NOT NULL,
  `total_paid` decimal(10,2) NOT NULL,
  `country` varchar(50) NOT NULL,
  `ifsc_code` varchar(100) NOT NULL,
  `p_status` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mlm_user_tmp`
--

/*!40000 ALTER TABLE `mlm_user_tmp` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_user_tmp` ENABLE KEYS */;


--
-- Definition of table `wd_dict`
--

DROP TABLE IF EXISTS `wd_dict`;
CREATE TABLE `wd_dict` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(65268) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `tag` varchar(250) NOT NULL DEFAULT '',
  `files` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wd_dict`
--

/*!40000 ALTER TABLE `wd_dict` DISABLE KEYS */;
INSERT INTO `wd_dict` (`id`,`word`,`tag`,`files`) VALUES 
 (1,0x476976652070726F706572206C6F67696E2064657461696C2E2E,'','|mlm/index.php|'),
 (2,0x5573657220616464207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (3,0x557365722064656C65746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (4,0x5573657220757064617465207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (5,0x476976652070726F706572206F6C642070617373776F72642E2E,'','|mlm/index.php|'),
 (6,0x50617373776F7264206368616E6765207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (7,0x536974652073657474696E67732075706461746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (8,0x556E61626C6520746F2061646420757365722070696E20636F64652E2E,'','|mlm/index.php|'),
 (9,0x557365722070696E20636F646520616464207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (10,0x557365722070696E2064656C65746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (11,0x44617461206E6F7420666F756E6420666F72207468697320757365722E2E,'','|mlm/index.php|'),
 (12,0x556E61626C6520746F2075706461746520757365722E2E,'','|mlm/index.php|'),
 (13,0x596F752073686F756C642073656C65637420616E2075736572,'','|mlm/index.php|'),
 (14,0x43617465676F727920616464207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (15,0x43617465676F727920757064617465207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (16,0x43617465676F72792064656C65746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (17,0x41727469636C6520616464207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (18,0x41727469636C6520757064617465207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (19,0x5468652075706C6F6164207061746820646F6573206E6F742061707065617220746F2062652076616C69642E,'','|mlm/index.php|'),
 (20,0x41727469636C652064656C65746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (21,0x41646420757365722075706461746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (22,0x46415120616464207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (23,0x6661712075706461746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (24,0x6661712064656C65746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (25,0x456E676C697368,'','|mlm/index.php|'),
 (26,0x5475726B6579,'','|mlm/index.php|'),
 (27,0x57656C636F6D65,'','|mlm/index.php|'),
 (28,0x4775657374,'','|mlm/index.php|'),
 (29,0x4C6F67696E,'','|mlm/index.php|'),
 (30,0x5265676973746572,'','|mlm/index.php|'),
 (31,0x4D79204A6F6273,'','|mlm/index.php|'),
 (32,0x48656C70,'','|mlm/index.php|'),
 (33,0x486F6D65,'','|mlm/index.php|'),
 (34,0x506F73742061204A6F62,'','|mlm/index.php|'),
 (35,0x46696E64204A6F6273,'','|mlm/index.php|'),
 (36,0x486F7720697420576F726B73,'','|mlm/index.php|'),
 (37,0x4C6F72656D20497073756D2069732073696D706C792064756D6D792074657874206F6620746865207072696E74696E6720616E64207479706573657474696E6720696E6475737472792E,'','|mlm/index.php|'),
 (38,0x4765742051756F746573,'','|mlm/index.php|'),
 (39,0x436F6E747261727920746F20706F70756C61722062656C6965662C204C6F72656D20497073756D206973206E6F742073696D706C792072616E646F6D20746578742E,'','|mlm/index.php|'),
 (40,0x486972652061205472616465736D616E,'','|mlm/index.php|'),
 (41,0x476F6F642050726F66696C65,'','|mlm/index.php|'),
 (42,0x47726561742051756F7465,'','|mlm/index.php|'),
 (43,0x506F73697469766520466565646261636B,'','|mlm/index.php|'),
 (44,0x4C6561766520466565646261636B,'','|mlm/index.php|'),
 (45,0x4A6F62732042792043617465676F7279,'','|mlm/index.php|'),
 (46,0x546F702043617465676F72696573,'','|mlm/index.php|'),
 (47,0x416C6C2043617465676F7269657320412D5A,'','|mlm/index.php|'),
 (48,0x4665617475726564205472616465736D616E,'','|mlm/index.php|'),
 (49,0x4672656520506F7374696E67204A6F6273,'','|mlm/index.php|'),
 (50,0x41726520796F752061205472616465736D616E3F,'','|mlm/index.php|'),
 (51,0x506F737420596F7572204A6F62,'','|mlm/index.php|'),
 (52,0x4D6F726520496E666F,'','|mlm/index.php|'),
 (53,0x4C6574205472616465736D656E7420436F6D6520746F20596F75,'','|mlm/index.php|'),
 (54,0x43686F6F73652061205472616465736D616E,'','|mlm/index.php|'),
 (55,0x49206C6F7665204D792053697465,'','|mlm/index.php|'),
 (56,0x526563656E746C7920636F6D706C65746564204A6F6273,'','|mlm/index.php|'),
 (57,0x4A6F622044657461696C73,'','|mlm/index.php|'),
 (58,0x54797065206F66204A6F62,'','|mlm/index.php|'),
 (59,0x4E65656420746F2066696E642061204772656174204275696C6465723F,'','|mlm/index.php|'),
 (60,0x47657420636F6D70657469746976652071756F7465732066726F6D206F757220657870657274207472616465736D656E,'','|mlm/index.php|'),
 (61,0x536176652074696D652026206D6F6E6579,'','|mlm/index.php|'),
 (62,0x546F74616C6C7920467265652073657276696365,'','|mlm/index.php|'),
 (63,0x393625206F66206A6F627320676574206174206C6561737420332071756F74657321,'','|mlm/index.php|'),
 (64,0x41626F7574205573,'','|mlm/index.php|'),
 (65,0x54726164652043617465676F72696573,'','|mlm/index.php|'),
 (66,0x5465726D73202620436F6E646974696F6E73,'','|mlm/index.php|'),
 (67,0x5072697661637920506F6C696379,'','|mlm/index.php|'),
 (68,0x44657369676E6564202620446576656C6F706564206279,'','|mlm/index.php|'),
 (69,0x4D656D626572204C6F67696E,'','|mlm/index.php|'),
 (70,0x4D656D626572,'','|mlm/index.php|'),
 (71,0x50617373776F7264,'','|mlm/index.php|'),
 (72,0x666F72676F742070617373776F7264203F,'','|mlm/index.php|'),
 (73,0x4C6F676F75743F,'','|mlm/index.php|'),
 (74,0x4C6F676F7574,'','|mlm/index.php|'),
 (75,0x436F6D70616E79,'','|mlm/index.php|'),
 (76,0x4F70706F7274756E697479,'','|mlm/index.php|'),
 (77,0x6C6F67696E20666F722075736572,'','|mlm/index.php|'),
 (78,0x55736572204E616D65,'','|mlm/index.php|'),
 (79,0x466F72676F7420557365726E616D65202F2050617373776F72643F,'','|mlm/index.php|'),
 (80,0x4B656570206D65206C6F6767656420696E206F6E207468697320636F6D7075746572,'','|mlm/index.php|'),
 (81,0x416476616E7461676573,'','|mlm/index.php|'),
 (82,0x666F72204A6F6220506F7374657273,'','|mlm/index.php|'),
 (83,0x5361766520757020746F,'','|mlm/index.php|'),
 (84,0x333025,'','|mlm/index.php|'),
 (85,0x616E64206D6F726520666F72205472616465736D656E20616E6420536572766963652050726F766964657273,'','|mlm/index.php|'),
 (86,0x4D6F72652071756F74657320616E6420696E206C6573732074696D65207468616E207769746820616E79206F7468657220736561726368206D6574686F64,'','|mlm/index.php|'),
 (87,0x436F6D706C657465207472616E73706172656E637920696E636C2E207265666572656E63657320616E6420726174696E67732066726F6D206F746865722055736572732E20596F752063686F6F736520796F757220547261646572,'','|mlm/index.php|'),
 (88,0x54686F7573616E6473206F66207175616C696669666564205472616465736D656E20616E6420536572766963652050726F7669646572732061726520616C72656164792072656769737465726564,'','|mlm/index.php|'),
 (89,0x526567697374726174696F6E20666F72206E6577207472616465736D616E,'','|mlm/index.php|'),
 (90,0x4920616D2061,'','|mlm/index.php|'),
 (91,0x4A4F4220504F53544552,'','|mlm/index.php|'),
 (92,0x6C6F6F6B696E6720666F722061206C6F63616C20726174656420747261646573706572736F6E,'','|mlm/index.php|'),
 (93,0x547261646573706572736F6E,'','|mlm/index.php|'),
 (94,0x6C6F6F6B696E6720746F207265636569766520667265650D0A09096A6F62206C6561647320616E642077696E206E657720627573696E657373,'','|mlm/index.php|'),
 (95,0x5265717569726564206669656C64732061726520696E6469636174656420776974682061,'','|mlm/index.php|'),
 (96,0x4669727374204E616D65,'','|mlm/index.php|'),
 (97,0x41646472657373,'','|mlm/index.php|'),
 (98,0x5375726E616D65,'','|mlm/index.php|'),
 (99,0x43697479,'','|mlm/index.php|'),
 (100,0x53656C65637420612063697479,'','|mlm/index.php|'),
 (101,0x456D61696C2041646472657373,'','|mlm/index.php|'),
 (102,0x41726561,'','|mlm/index.php|'),
 (103,0x53656C65637420616E2061726561,'','|mlm/index.php|'),
 (104,0x436F6E74616374204E756D626572,'','|mlm/index.php|'),
 (105,0x526567696F6E,'','|mlm/index.php|'),
 (106,0x53656C656374206120726567696F6E,'','|mlm/index.php|'),
 (107,0x466178,'','|mlm/index.php|'),
 (108,0x5A697020636F6465,'','|mlm/index.php|'),
 (109,0x53656C6563742061207A6970,'','|mlm/index.php|'),
 (110,0x436F6E6669726D2050617373776F7264,'','|mlm/index.php|'),
 (111,0x506C6561736520696E666F726D206D652061626F7574206C617465737420736176696E67207469707320616E6420696D706F7274616E74206E6577732E,'','|mlm/index.php|'),
 (112,0x492061636365707420746865,'','|mlm/index.php|'),
 (113,0x616E6420746865,'','|mlm/index.php|'),
 (114,0x506C656173652073656C65637420757365722074797065,'','|mlm/index.php|'),
 (115,0x506C65617365206769766520746865206669727374206E616D65,'','|mlm/index.php|'),
 (116,0x506C656173652067697665206C617374206E616D65,'','|mlm/index.php|'),
 (117,0x506C656173652073656C65637420612063697479,'','|mlm/index.php|'),
 (118,0x506C65617365206769766520656D61696C2061646472657373,'','|mlm/index.php|'),
 (119,0x506C656173652073656C65637420616E2061726561,'','|mlm/index.php|'),
 (120,0x506C656173652073656C656374206120726567696F6E,'','|mlm/index.php|'),
 (121,0x506C656173652073656C6563742061207A697020636F6465,'','|mlm/index.php|'),
 (122,0x506C656173652067697665207468652075736572204944,'','|mlm/index.php|'),
 (123,0x506C656173652067697665207468652070617373776F7264,'','|mlm/index.php|'),
 (124,0x506C6561736520726577726974652070617373776F7264,'','|mlm/index.php|'),
 (125,0x506C65617365206769766520612070726F70657220656D61696C204944,'','|mlm/index.php|'),
 (126,0x54776F2070617373776F726420646F6573206E6F74206D61746368,'','|mlm/index.php|'),
 (127,0x596F75206861766520746F20616363657074205465726D73202620436F6E646974696F6E7320616E6420746865205072697661637920506F6C696379,'','|mlm/index.php|'),
 (128,0x55736572206E616D65,'','|mlm/index.php|'),
 (129,0x4F7264657220746F74616C206973206D697373696E672E,'','|mlm/index.php|'),
 (130,0x596F75206172652068657265,'','|mlm/index.php|'),
 (131,0x486F6D6570616765,'','|mlm/index.php|'),
 (132,0x4D657373616765,'','|mlm/index.php|'),
 (133,0x54686572652061726520736F6D652070726F626C656D206174207468652074696D65206F66207061796D656E742E,'','|mlm/index.php|'),
 (134,0x596F7572207265676973726174696F6E20636F6D706C657465207375636365737366756C6C792E20416E2061637469766174696F6E206D61696C20686173206265656E2073656E6420746F20796F757220656D61696C206163636F756E742E20506C6561736520616374697661746520796F757220656D61696C20746F2061636365737320746865206163636F756E742E,'','|mlm/index.php|'),
 (135,0x54686572652061726520736F6D652070726F626C656D206174207468652074696D65206F66207061796D656E742E2E,'','|mlm/index.php|'),
 (136,0x4D6573736167652073656E64207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (137,0x4D657373616765206D6F76656420746F2061726368697665207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (138,0x466F72676F742070617373776F7264202861646D696E292075706461746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (139,0x4E65772070617373776F726420686173206265656E2073656E64207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (140,0x426C6F636B2075736572202861646D696E292075706461746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (141,0x556E626C6F636B2075736572202861646D696E292075706461746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (142,0x426C6F636B20757365722075706461746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (143,0x556E626C6F636B20757365722075706461746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (144,0x466F726765742070617373776F7264,'','|mlm/index.php|'),
 (145,0x456D61696C,'','|mlm/index.php|'),
 (146,0x506C65617365206769766520796F757220656D61696C206164647265737320686572652E2041206E65772067656E6572617465642070617373776F72642077696C6C2062652073656E6420746F20796F757220656D61696C20616464726573732E,'','|mlm/index.php|'),
 (147,0x466F72676F742070617373776F72642075706461746564207375636365737366756C6C792E2E,'','|mlm/index.php|'),
 (148,0x57656C636F6D65204C6574746572,'','|mlm/index.php|'),
 (149,0x456469742050726F66696C65,'','|mlm/index.php|'),
 (150,0x5061796D656E7420737461747573206368616E6765207375636365737366756C6C792E2E,'','|mlm_general/index.php|'),
 (151,0x534D5320616464207375636365737366756C6C792E2E,'','|mlm_general/index.php|'),
 (152,0x534D5320757064617465207375636365737366756C6C792E2E,'','|mlm_general/index.php|'),
 (153,0x534D532064656C65746564207375636365737366756C6C792E2E,'','|mlm_general/index.php|'),
 (154,0x55736572204944,'','|mlm_general/index.php|'),
 (155,0x55736572204964,'','|mlm_general/index.php|'),
 (156,0x4D6573736167652064656C65746564207375636365737366756C6C792E2E,'','|mlm_general/index.php|'),
 (157,0x466F72676F742070617373776F7264203F,'','|mlm_general/index.php|');
/*!40000 ALTER TABLE `wd_dict` ENABLE KEYS */;


--
-- Definition of table `wd_lang`
--

DROP TABLE IF EXISTS `wd_lang`;
CREATE TABLE `wd_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `display` text NOT NULL,
  `fontfile1` text NOT NULL,
  `flagfile1` text NOT NULL,
  `admin_flag` int(11) NOT NULL DEFAULT '1',
  `front_flag` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wd_lang`
--

/*!40000 ALTER TABLE `wd_lang` DISABLE KEYS */;
INSERT INTO `wd_lang` (`id`,`name`,`display`,`fontfile1`,`flagfile1`,`admin_flag`,`front_flag`) VALUES 
 (1,'English','en','1_img.gif','1_img.gif',1,1);
/*!40000 ALTER TABLE `wd_lang` ENABLE KEYS */;


--
-- Definition of table `wd_trans`
--

DROP TABLE IF EXISTS `wd_trans`;
CREATE TABLE `wd_trans` (
  `lang_id` int(11) NOT NULL DEFAULT '0',
  `word_id` int(11) NOT NULL DEFAULT '0',
  `tword` text NOT NULL,
  UNIQUE KEY `lang_id` (`lang_id`,`word_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wd_trans`
--

/*!40000 ALTER TABLE `wd_trans` DISABLE KEYS */;
/*!40000 ALTER TABLE `wd_trans` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
