-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2010 at 07:40 AM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `urbanzing`
--

-- --------------------------------------------------------

--
-- Table structure for table `urban_address_book`
--

DROP TABLE IF EXISTS `urban_address_book`;
CREATE TABLE IF NOT EXISTS `urban_address_book` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `f_name` varchar(150) NOT NULL,
  `l_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_address_book`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_article`
--

DROP TABLE IF EXISTS `urban_article`;
CREATE TABLE IF NOT EXISTS `urban_article` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=16 ;

--
-- Dumping data for table `urban_article`
--

INSERT INTO `urban_article` (`id`, `category_id`, `title`, `keyword`, `description`, `status`, `creation_dt`, `update_dt`, `img`) VALUES
(1, 'company_info', 'Company Info', '', '&lt;p&gt;Test company Info&lt;/p&gt;', 1, 1278748273, 0, ''),
(4, 'who_we_are', 'Who we are?', '', '&lt;p&gt;&lt;span style=&quot;color: #800000;&quot;&gt;&lt;span style=&quot;font-size: small;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: medium;&quot;&gt;If&lt;/span&gt; &lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;you are questing forward to earn money as well go for an outing this is exactly the place you have landed. Fulfill your dreams - Earn huge capital while viewing your dreamland. This is the most comprehensive company that deals with the welfare of health and wellness, life style. Vacation trips at the cheapest price you could ever imagine to the most beautiful places in the world at your convenience. A huge resource of resorts and hotels that will take your dream to the next level-where you will get both comfort as well as the best cuisine to meet your expectations in the best way.&lt;/p&gt;', 1, 1279029612, 0, ''),
(3, 'take_a_tour', 'dgdfg', '', '&lt;p&gt;dfgdfg sdfs gsgsdgsghlshglskdh glsdkhglskdhgsd ghhsdglskd hgklsdhgklsdhglsdkhioehshglshglshgsl hd gsldh glsdkhglsdgns,mgvnsldhfdkghsdlkh gklsdhg lskh glkh glksdh glksdhgiowr hgoihg lbnxm,bn ,xnb,x&lt;/p&gt;', 1, 1278748396, 0, 'article1278748391.JPG'),
(5, 'are_you_intrigued', 'Are You Intrigued?', '', '&lt;p&gt;This is no longer a secret that might keep you worried regarding the services that the company promises to offer. Just a quick search will reveal beyond doubt that you are absolutely at the best place you can dream of. Moreover, the customer feedback itself carries with it the word of self satisfaction that the company vows to provide you.&lt;/p&gt;', 1, 1279030036, 0, ''),
(6, 'company_info', 'About Us', '', '&lt;p&gt;Every day the world is entering into the new edge of development because of Binary System. We can use this system to add some more lives in our personal life as well, but still we are waiting! It might already late but not the end. Let&amp;rsquo;s start now, as we are the part and parcel of this existing world. Yes, Fairy Land Tours and Travels (popularly FLTT) is offering you the scope to utilize the Binary System to your personal life in an effective &amp;amp; efficient manner. FLTT is incorporated with the vision of providing the opportunity to add more values (both in terms of monetary &amp;amp; wellness) to everybody&amp;rsquo;s life by converting their unproductive time into productive one. Simply come, join and enjoy the power of Binary System.&lt;/p&gt;\n&lt;p style=&quot;font-weight:bold&quot;&gt;You can join with us if any of the following is happening with you.&lt;/p&gt;\n&lt;ul class=&quot;about_us&quot; style=&quot;list-style:circle; padding-left:20px; color:#7b572b;&quot;&gt;\n&lt;li&gt;May be you are tired of your Job?&lt;/li&gt;\n&lt;li&gt;May be you can&amp;rsquo;t see yourself getting ahead with your current income?&lt;/li&gt;\n&lt;li&gt;May be your dreams are still not fulfilled?&lt;/li&gt;\n&lt;li&gt;May be the commute to work and rat race have forced you to start looking for alternate ways to make money?&lt;/li&gt;\n&lt;li&gt;May be you want to spend more time with your family?&lt;/li&gt;\n&lt;li&gt;May be there is a piece missing in your life?&lt;/li&gt;\n&lt;/ul&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;Just take a decision and give your 1% to  us, FLTT is committed to give you rest of 99% to fulfill your expectations  100%.&lt;br /&gt; FLTT wishes you good luck in all your  endeavors.&lt;/p&gt;', 1, 1279030850, 0, ''),
(7, 'opportunity', 'opportunity', '', '&lt;p&gt;This is an incredibly easy way to earn Rs.90, 000/- per month. There&#039;s not just cash reward but a plethora of other kind of rewards. You just need to start from two referrals under you. The referrals would do the same thus forming two different branches of referrals on left and right hand sides. Picture this:&lt;/p&gt;\n&lt;p&gt;If you are the parent - the starting point in a binary system of networking - and left side or the number of referrals on the left hand side : right side or the number of referrals on the right hand side = 10:10, then you get a mobile or a cash award of Rs.1,000/-. Likewise, when it becomes 25:25 then you win a tour package for couple or Rs.2500/-. This way in just 12 months when the ratio becomes 800:800, you win a Malaysia trip for couple or Rs.1,00,000/-. Within three and a half years you can own a villa or have a bank balance of Rs.40 lakhs.&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;1st&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;10 : 10&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;1 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/mobile_phone.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;Mobile&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;1,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;2nd&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;25 : 25&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 2 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/tour_india.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;TOUR IN INDIA FOR Couple&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;2,500&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;3rd&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;50 : 50&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 4 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/laptop_img.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;LAOTOP&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;12,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;4th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;100 : 100&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 6 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/lcd_tour.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;L C D TV / BANGKOK TRIP&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;25,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;5th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;200 : 200&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 8 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/bike_tour.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;BIKE / SINGAPORE&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;35,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;6th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;400 : 400&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 10 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/tour_goldcoin.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;BANGKOK TOUR FOR COUPLE / GOLD COIN&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;60,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;7th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;800 : 800&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 12 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/malaysia_city.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;MALESIA TRIP FOR COUPLE&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;1,00,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;8th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;1500 : 1500&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 14 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/alto_delux.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;ALTO DELUX CAR&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;2,50,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;9th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;2000 : 2000&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 18 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/swift_car.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;SWEFT CAR&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;5,00,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;10th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;4000 : 4000&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 25 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/single_bed_room.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;1 BED ROOM FLAT&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;10,00,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;11th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;8000 : 8000&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 30 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/delux_flat.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;DELUX FLAT&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;20,00,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;offer_box&quot;&gt;\n&lt;div class=&quot;offer_header&quot;&gt;\n&lt;div class=&quot;cell_01&quot;&gt;12th&lt;/div&gt;\n&lt;div class=&quot;cell_02&quot;&gt;\n&lt;h5&gt;PAIR - &lt;span&gt;16000 : 16000&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;div class=&quot;cell_03&quot;&gt;\n&lt;h5&gt;DAyS/MLY : &lt;span&gt;NEXT 40 MOUNTH&lt;/span&gt;&lt;/h5&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;div class=&quot;offer_cont&quot;&gt;\n&lt;div class=&quot;left_cell&quot;&gt;&lt;img src=&quot;../images/front/villa.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;VILLA&lt;/h4&gt;\n&lt;/div&gt;\n&lt;div class=&quot;right_cell&quot;&gt;&lt;img src=&quot;../images/front/cash_prize.png&quot; alt=&quot;&quot; /&gt;\n&lt;h4&gt;CASH AWARD Rs:&lt;span&gt;40,00,000&lt;/span&gt;&lt;/h4&gt;\n&lt;/div&gt;\n&lt;br /&gt;&lt;/div&gt;\n&lt;/div&gt;', 1, 1279031574, 0, ''),
(8, 'travel_and_tourism', 'Travel and tourisn', '', '&lt;p&gt;Travel and tourism text&lt;/p&gt;', 1, 1279621816, 0, ''),
(9, 'work_from_home', 'work from home', '', '&lt;p&gt;work from home text&lt;/p&gt;', 1, 1279621835, 0, ''),
(10, 'earn_while_vaction', 'Earn while you are in vaction', '', '&lt;p&gt;Earn while you are in vaction detail&lt;/p&gt;', 1, 1279622297, 0, ''),
(11, 'testimonials', 'Testimonials', '', '&lt;p&gt;Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials Testimonials&lt;/p&gt;', 1, 1279622719, 0, ''),
(12, 'business_plan', 'Business plan', '', '&lt;div id=&quot;about_us&quot;&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 1: To become an associate of FLTT, submit an application for registration. The details of the additional benefits received by the associate are mentioned below&lt;/h1&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;font-weight:bold&quot;&gt;By registering as an associate, you will get below mentioned value added benefits:&lt;/p&gt;\n&lt;ul class=&quot;about_us&quot; style=&quot;list-style:circle; padding-left:20px; color:#7b572b;&quot;&gt;\n&lt;li&gt;Get an unique ID&lt;/li&gt;\n&lt;li&gt;Rs: 60000/= Insurance of Accidental Death Benefit.&lt;/li&gt;\n&lt;li&gt;Attractive INCENTIVE.&lt;/li&gt;\n&lt;li&gt;Single Leg Income.&lt;/li&gt;\n&lt;li&gt;Plus the Opportunity to earn over RS. 90,000 per month in CASH.&lt;/li&gt;\n&lt;li&gt;Lifetime access to our promotional deals&lt;/li&gt;\n&lt;li&gt;Self Replicating Personalized Website&lt;/li&gt;\n&lt;li&gt;Virtual Office to manage your Business&lt;/li&gt;\n&lt;li&gt;One click access to discounted travel deals&lt;/li&gt;\n&lt;/ul&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h2 class=&quot;style1&quot;&gt;Registration Fee = Rs: 1500.00&lt;/h2&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 2(a): Now you are eligible to earn money. All you need to do, just refer 2 persons one at your left side and another one at your right side and your job is done&lt;/h1&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align:center; padding-top:10px;&quot;&gt;&lt;img src=&quot;../images/front/step1.png&quot; alt=&quot;&quot; /&gt;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 2(b): What you did in step2 (a), A and B will do the same in this step. You will get the incentive of Rs: 500.00 whenever the ratio of 1:2 or 2:1 is maintained irrespective of the side.&lt;/h1&gt;\n&lt;p style=&quot;text-align:center; padding-top:10px;&quot;&gt;&lt;img src=&quot;../images/front/step2b2.png&quot; alt=&quot;&quot; width=&quot;185&quot; height=&quot;248&quot; /&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;img src=&quot;../images/front/step2b.png&quot; alt=&quot;&quot; width=&quot;185&quot; height=&quot;248&quot; /&gt;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 3: You earned Rs: 500.00. Now your earning is much easier. From now onwards you don&amp;rsquo;t need to maintain the ratio of 1:2 or 2:1. Just maintain the pair, which means the ratio of 1:1 only and you will earn Rs: 500.00.&lt;/h1&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align:center; padding-top:10px;&quot;&gt;&lt;img src=&quot;../images/front/step3.png&quot; alt=&quot;&quot; width=&quot;320&quot; height=&quot;345&quot; /&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;img src=&quot;../images/front/step3b.png&quot; alt=&quot;&quot; width=&quot;320&quot; height=&quot;345&quot; /&gt;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 4: You earned Rs: 500.00. To earn another Rs : 500.00, you need to repeat the same thing what is done in Step3.&lt;/h1&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align:center; padding-top:10px;&quot;&gt;&lt;img src=&quot;../images/front/step4.png&quot; alt=&quot;&quot; width=&quot;350&quot; height=&quot;439&quot; /&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;img src=&quot;../images/front/step4b.png&quot; alt=&quot;&quot; width=&quot;350&quot; height=&quot;439&quot; /&gt;&lt;/p&gt;\n&lt;p class=&quot;business-plan&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1&gt;Step 5: You earned Rs: 500.00. To earn another Rs : 500.00, again you need to repeat the same thing on continuous basis.&lt;/h1&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h2 class=&quot;style2&quot;&gt;Addional Earning:&lt;/h2&gt;\n&lt;span class=&quot;style3&quot;&gt;1.	By continuing this process, while you will have 50 references under you irrespective of the side, then you will earn Rs. 1500.00 (=50X30) as an advance single leg income.\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/span&gt;&lt;/div&gt;', 1, 1279624356, 0, ''),
(13, 'contact_us', 'Contact Us', '', '&lt;p&gt;Phone1: +91-7797039753&lt;/p&gt;\n&lt;p&gt;Phone2: +91-7797039753&lt;/p&gt;\n&lt;p&gt;Email: &lt;a href=&quot;mailto:info@fltt.in&quot;&gt;info@fltt.in&lt;/a&gt;&lt;/p&gt;', 1, 1279636168, 0, ''),
(14, 'profile_home_message', 'sdfgsdfg', '', '&lt;p&gt;This is profile home message&lt;/p&gt;', 1, 1280562687, 0, ''),
(15, 'welcome_letter', 'xcxcx', '', '&lt;div class=&quot;welcome&quot;&gt;&lt;img src=&quot;../images/front/design.png&quot; alt=&quot;&quot; /&gt;\n&lt;p&gt;&lt;strong&gt;Dear Customer,&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;Welcome to FLTT. We provide you with one of the easiest ways of earning big and fast from the comfort of your home, and even when you are on our sponsored tours.&lt;/p&gt;\n&lt;p&gt;Ours is a network marketing based on the binary referral system. Stay-at-home or working moms, busy dads, and just about anyone can do this business part time or full time. It&amp;rsquo;s incredibly easy.&lt;/p&gt;\n&lt;p&gt;Many thanks indeed to log in to our site. Now start earning, and win exciting gifts. Best of luck!&lt;/p&gt;\n&lt;h6&gt;Warm Regards, &lt;br /&gt;FLTT.&lt;/h6&gt;\n&lt;img src=&quot;../images/front/design02.png&quot; alt=&quot;&quot; /&gt;&lt;/div&gt;', 1, 1280569830, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `urban_automail`
--

DROP TABLE IF EXISTS `urban_automail`;
CREATE TABLE IF NOT EXISTS `urban_automail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `subject` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `urban_automail`
--

INSERT INTO `urban_automail` (`id`, `item_type`, `description`, `subject`) VALUES
(1, '0', 'Jmx0O3AmZ3Q7RGVhciAlJXVzZXJfX3VzZXJuYW1lJSUsJmx0Oy9wJmd0OwombHQ7cCZndDsmYW1wO25ic3A7Jmx0Oy9wJmd0Ow==', '0'),
(2, 'add_user', 'Jmx0O3AmZ3Q7RGVhciAlJXVzZXJfX25hbWUlJSwmbHQ7L3AmZ3Q7CiZsdDtwJmd0OyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsgWW91ciBhY2NvdW50IGhhc2JlZW4gY3JlYXRlZCBieSBzaXRlIGFkbWluLiBZb3VyIGxvZ2luIGRldGFpbHMgYXJlIGZvbGxvdy4mbHQ7L3AmZ3Q7CiZsdDtwJmd0OyZhbXA7bmJzcDsmbHQ7L3AmZ3Q7CiZsdDtwJmd0O0xvZ2luIElEOiAlJXVzZXJfX3VzZXJuYW1lJSUmbHQ7L3AmZ3Q7CiZsdDtwJmd0O1Bhc3N3b3JkOiAlJXVzZXJfX3Bhc3N3b3JkJSUmbHQ7L3AmZ3Q7CiZsdDtwJmd0O1lvdXIgQ29kZTogJSV1c2VyX191c2VyX2NvZGUlJSZsdDsvcCZndDsKJmx0O3AmZ3Q7JmFtcDtuYnNwOyZsdDsvcCZndDsKJmx0O3AmZ3Q7UGxlYXNlICUlY2xpY2toZXJlJSUgdG8gdmlzaXQgdGhlIHNpdGUuJmx0Oy9wJmd0OwombHQ7cCZndDsmYW1wO25ic3A7Jmx0Oy9wJmd0OwombHQ7cCZndDtUaGFua3MmbHQ7L3AmZ3Q7', 'New user added'),
(3, 'forgot_password_admin', 'Jmx0O3AmZ3Q7RGVhciAlJWFkbWluX19uYW1lJSUsJmx0Oy9wJmd0OwombHQ7cCZndDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyBZb3VyIHBhc3N3b3JkIGhhc2JlZW4gY2hhbmdlZC4geW91ciBuZXcgcGFzc3dvcmQgaXMgJSVhZG1pbl9fcGFzc3dvcmQlJS4mbHQ7L3AmZ3Q7CiZsdDtwJmd0O1RoYW5rcyZsdDsvcCZndDs=', 'Forgot password'),
(4, 'block_user_admin', 'Jmx0O3AmZ3Q7RGVhciAlJWFkbWluX19uYW1lJSUsJmx0Oy9wJmd0OwombHQ7cCZndDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsmYW1wO25ic3A7JmFtcDtuYnNwOyZhbXA7bmJzcDsgWW91ciBhY2NvdW50IGhhc2JlZW4gYmxvY2tlZC4gUGxlYXNlIGRvIGNvbnRhY3Qgd2l0aCBzdXBlciBhZG1pbiBmb3IgZGV0YWlsLiZsdDsvcCZndDsKJmx0O3AmZ3Q7JmFtcDtuYnNwOyZsdDsvcCZndDsKJmx0O3AmZ3Q7VGhhbmtzJmx0Oy9wJmd0Ow==', 'Block account'),
(5, 'unblock_user_admin', 'Jmx0O3AmZ3Q7RGVhciAlJWFkbWluX19uYW1lJSUsJmx0Oy9wJmd0OwombHQ7cCZndDtZb3VyIGFjY291bnQgaGFzYmVlbiB1bmJsb2NrZWQuIFlvdSBjYW4gdXNlIHRoZSBhY2NvdW50IG5vdy4mbHQ7L3AmZ3Q7CiZsdDtwJmd0OyZsdDticiAvJmd0O1RoYW5rcyZsdDsvcCZndDsKJmx0O3AmZ3Q7JmFtcDtuYnNwOyZsdDsvcCZndDs=', 'Unblock account'),
(6, 'block_user', 'Jmx0O3AmZ3Q7RGVhciAlJXVzZXJfX25hbWUlJSwmbHQ7L3AmZ3Q7CiZsdDtwJmd0O1lvdXIgYWNjb3VudCBoYXNiZWVuIGJsb2NrZWQuIFBsZWFzZSBkbyBjb250YWN0IHdpdGggc3VwZXIgYWRtaW4gZm9yIGRldGFpbC4mbHQ7L3AmZ3Q7CiZsdDtwJmd0OyZsdDticiAvJmd0O1RoYW5rcyZsdDsvcCZndDsKJmx0O3AmZ3Q7JmFtcDtuYnNwOyZsdDsvcCZndDs=', 'Block account'),
(7, 'unblock_user', 'Jmx0O3AmZ3Q7RGVhciAlJXVzZXJfX25hbWUlJSwmbHQ7L3AmZ3Q7CiZsdDtwJmd0O1lvdXIgYWNjb3VudCBoYXNiZWVuIHVuIGJsb2NrZWQuIFlvdSBjYW4gZG8gbG9naW4gbm93LiZsdDsvcCZndDsKJmx0O3AmZ3Q7Jmx0O2JyIC8mZ3Q7VGhhbmtzJmx0Oy9wJmd0OwombHQ7cCZndDsmYW1wO25ic3A7Jmx0Oy9wJmd0Ow==', 'Unblock account'),
(8, 'forgot_password', 'Jmx0O3AmZ3Q7RGVhciAlJXVzZXJfX25hbWUlJSwmbHQ7L3AmZ3Q7CiZsdDtwJmd0O1lvdXIgcGFzc3dvcmQgaGFzYmVlbiBjaGFuZ2VkLiB5b3VyIG5ldyBwYXNzd29yZCBpcyAlJXVzZXJfX3Bhc3N3b3JkJSUuJmx0Oy9wJmd0OwombHQ7cCZndDtUaGFua3MmbHQ7L3AmZ3Q7CiZsdDtwJmd0OyZhbXA7bmJzcDsmbHQ7L3AmZ3Q7', 'Forgot password');

-- --------------------------------------------------------

--
-- Table structure for table `urban_business`
--

DROP TABLE IF EXISTS `urban_business`;
CREATE TABLE IF NOT EXISTS `urban_business` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city_id` smallint(4) NOT NULL,
  `state_id` smallint(4) NOT NULL,
  `country_id` smallint(4) NOT NULL,
  `region_id` smallint(4) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `land_mark` varchar(150) NOT NULL,
  `phone_number` varchar(150) NOT NULL,
  `website` varchar(100) NOT NULL,
  `contact_person` varchar(150) NOT NULL,
  `contact_email` varchar(150) NOT NULL,
  `business_type_id` smallint(4) NOT NULL,
  `menu_image_name` varchar(100) NOT NULL,
  `price_range_id` smallint(4) NOT NULL,
  `credit_card` smallint(4) NOT NULL,
  `delivery` smallint(4) NOT NULL,
  `vegetarian` smallint(4) NOT NULL,
  `parking` smallint(4) NOT NULL,
  `take_reservation` smallint(4) NOT NULL,
  `air_conditioned` smallint(4) NOT NULL,
  `serving_alcohol` smallint(4) NOT NULL,
  `business_owner_id` int(10) NOT NULL,
  `tags` text NOT NULL,
  `status` enum('0','1','2','3','4') NOT NULL COMMENT '0->Pending,1->Approved,2->Rejected,3->Active,4->Inactive',
  `is_featured` enum('Y','N') NOT NULL COMMENT 'Y->Yes,N->No',
  `editorial_comments` text NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_business`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_business_claimed`
--

DROP TABLE IF EXISTS `urban_business_claimed`;
CREATE TABLE IF NOT EXISTS `urban_business_claimed` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `business_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `verification_code` varchar(150) NOT NULL,
  `verified` enum('Y','N') NOT NULL COMMENT 'Y->Yes,N->No',
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_business_claimed`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_business_correction`
--

DROP TABLE IF EXISTS `urban_business_correction`;
CREATE TABLE IF NOT EXISTS `urban_business_correction` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `business_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `status` enum('D','C','I','O') NOT NULL COMMENT 'D-> Duplicate; I-> Inaccurate; C->Closed; O-> Other',
  `comment` text NOT NULL,
  `submission_date` int(10) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_business_correction`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_business_cuisine`
--

DROP TABLE IF EXISTS `urban_business_cuisine`;
CREATE TABLE IF NOT EXISTS `urban_business_cuisine` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `business_id` int(10) NOT NULL,
  `cuisine_id` smallint(4) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_business_cuisine`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_business_hour`
--

DROP TABLE IF EXISTS `urban_business_hour`;
CREATE TABLE IF NOT EXISTS `urban_business_hour` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `business_id` int(10) NOT NULL,
  `day` varchar(50) NOT NULL,
  `hour_from` varchar(50) NOT NULL,
  `hour_to` varchar(50) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_business_hour`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_business_picture`
--

DROP TABLE IF EXISTS `urban_business_picture`;
CREATE TABLE IF NOT EXISTS `urban_business_picture` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `business_id` int(10) NOT NULL,
  `img_name` varchar(50) NOT NULL,
  `cover_picture` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Y->Yes,N->No',
  `user_id` int(10) NOT NULL,
  `status` enum('0','1','2') NOT NULL COMMENT '0->Inactive,1->Active,2->Rejected',
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `updated_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_business_picture`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_business_reviews`
--

DROP TABLE IF EXISTS `urban_business_reviews`;
CREATE TABLE IF NOT EXISTS `urban_business_reviews` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `business_id` int(10) NOT NULL,
  `comment` text NOT NULL,
  `review_title` varchar(250) NOT NULL,
  `star_rating` smallint(4) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_business_reviews`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_business_review_rating`
--

DROP TABLE IF EXISTS `urban_business_review_rating`;
CREATE TABLE IF NOT EXISTS `urban_business_review_rating` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `review_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `type` enum('L','O') NOT NULL COMMENT 'l->Like,o->Offensive',
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_business_review_rating`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_business_type`
--

DROP TABLE IF EXISTS `urban_business_type`;
CREATE TABLE IF NOT EXISTS `urban_business_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `business_type` varchar(250) NOT NULL,
  `parent_id` smallint(4) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_business_type`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_city`
--

DROP TABLE IF EXISTS `urban_city`;
CREATE TABLE IF NOT EXISTS `urban_city` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `state_id` smallint(4) NOT NULL,
  `country_id` smallint(4) NOT NULL,
  `city` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_city`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_country`
--

DROP TABLE IF EXISTS `urban_country`;
CREATE TABLE IF NOT EXISTS `urban_country` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country_abbr` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  `currency_symbol` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_country`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_cuisine`
--

DROP TABLE IF EXISTS `urban_cuisine`;
CREATE TABLE IF NOT EXISTS `urban_cuisine` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0->Inactive,1->Active',
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_cuisine`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_deal_status`
--

DROP TABLE IF EXISTS `urban_deal_status`;
CREATE TABLE IF NOT EXISTS `urban_deal_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `updated_by` int(10) NOT NULL,
  `updated_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_deal_status`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_home_page_image`
--

DROP TABLE IF EXISTS `urban_home_page_image`;
CREATE TABLE IF NOT EXISTS `urban_home_page_image` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img_name` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0->Inactive,1->Active',
  `region_id` smallint(4) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_home_page_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_invites`
--

DROP TABLE IF EXISTS `urban_invites`;
CREATE TABLE IF NOT EXISTS `urban_invites` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `party_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `email_id` varchar(150) NOT NULL,
  `rsvp_status` enum('Y','N') NOT NULL,
  `comment` text NOT NULL,
  `no_of_guest` smallint(4) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `updated_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_invites`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_occasion`
--

DROP TABLE IF EXISTS `urban_occasion`;
CREATE TABLE IF NOT EXISTS `urban_occasion` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `occasion` varchar(250) NOT NULL,
  `img_name` varchar(100) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_occasion`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_occupation`
--

DROP TABLE IF EXISTS `urban_occupation`;
CREATE TABLE IF NOT EXISTS `urban_occupation` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `occupation` varchar(250) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0->Inactive,1->Active',
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_occupation`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_party`
--

DROP TABLE IF EXISTS `urban_party`;
CREATE TABLE IF NOT EXISTS `urban_party` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `business_id` int(10) NOT NULL,
  `venue` varchar(250) NOT NULL,
  `user_id` int(10) NOT NULL,
  `start_date` int(10) NOT NULL,
  `message` text NOT NULL,
  `occasion_id` smallint(4) NOT NULL,
  `event_title` varchar(250) NOT NULL,
  `guest_cansee_each_other` enum('Y','N') NOT NULL,
  `rsvp_required` enum('Y','N') NOT NULL,
  `notify_guest_reply` enum('Y','N') NOT NULL,
  `status` enum('0','1') NOT NULL,
  `img_name` varchar(150) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_party`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_party_status`
--

DROP TABLE IF EXISTS `urban_party_status`;
CREATE TABLE IF NOT EXISTS `urban_party_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `status` varchar(250) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_party_status`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_price_range`
--

DROP TABLE IF EXISTS `urban_price_range`;
CREATE TABLE IF NOT EXISTS `urban_price_range` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `price_from` float NOT NULL,
  `price_to` float NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0->Inactive,1->Active',
  `country_id` smallint(4) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_price_range`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_region`
--

DROP TABLE IF EXISTS `urban_region`;
CREATE TABLE IF NOT EXISTS `urban_region` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `region` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_region`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_request_for_coupon`
--

DROP TABLE IF EXISTS `urban_request_for_coupon`;
CREATE TABLE IF NOT EXISTS `urban_request_for_coupon` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `business_id` int(10) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0->Pending,1->Active',
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_request_for_coupon`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_reviews`
--

DROP TABLE IF EXISTS `urban_reviews`;
CREATE TABLE IF NOT EXISTS `urban_reviews` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `business_id` int(10) NOT NULL,
  `comment` text NOT NULL,
  `review_title` varchar(250) NOT NULL,
  `star_rating` smallint(4) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_reviews`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_site_settings`
--

DROP TABLE IF EXISTS `urban_site_settings`;
CREATE TABLE IF NOT EXISTS `urban_site_settings` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

--
-- Dumping data for table `urban_site_settings`
--

INSERT INTO `urban_site_settings` (`id`, `admin_page_limit`, `default_language`, `max_image_file_size`, `site_name`, `site_moto`, `admin_email`, `paypal_email`, `default_currency`, `mail_from_name`, `mail_from_email`, `mail_replay_name`, `mail_replay_email`, `mail_protocol`, `paypal_currency`, `registration_charge`, `smtp_host`, `smtp_user`, `smtp_pass`, `conversion_rate`, `paypal_charge`) VALUES
(1, 10, '1', 1500, '1', '1', 'debnath.rubel@gmail.com', 'admin@admin.com', '#36;', 'MLM Admin', 'admin@admin.com', 'donotReply', 'donotReply@mlm.com', 'smtp', 'USD', 1200.00, 'mail.acumensofttech.com', 'testing@acumensofttech.com', 'hello@mail', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `urban_state`
--

DROP TABLE IF EXISTS `urban_state`;
CREATE TABLE IF NOT EXISTS `urban_state` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country_id` smallint(10) NOT NULL,
  `state` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_state`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_users`
--

DROP TABLE IF EXISTS `urban_users`;
CREATE TABLE IF NOT EXISTS `urban_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(250) NOT NULL,
  `l_name` varchar(250) NOT NULL,
  `screen_name` varchar(250) NOT NULL,
  `gender` enum('M','F') NOT NULL COMMENT 'M->Male,F->Female',
  `dob` int(10) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `country_id` smallint(4) NOT NULL,
  `state_id` smallint(4) NOT NULL,
  `city_id` smallint(4) NOT NULL,
  `zip_id` varchar(100) NOT NULL,
  `occupation_id` smallint(4) NOT NULL,
  `email_opt_in` enum('Y','N') NOT NULL COMMENT 'Y->Yes,N->No',
  `img_name` varchar(150) NOT NULL,
  `face_book_connect` enum('Y','N') NOT NULL DEFAULT 'N',
  `date_created` int(10) NOT NULL,
  `date_updated` int(10) NOT NULL,
  `user_type_id` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_user_type`
--

DROP TABLE IF EXISTS `urban_user_type`;
CREATE TABLE IF NOT EXISTS `urban_user_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(250) NOT NULL,
  `cr_by` int(10) NOT NULL,
  `cr_date` int(10) NOT NULL,
  `update_by` int(10) NOT NULL,
  `update_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_user_type`
--


-- --------------------------------------------------------

--
-- Table structure for table `urban_zipcode`
--

DROP TABLE IF EXISTS `urban_zipcode`;
CREATE TABLE IF NOT EXISTS `urban_zipcode` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `zip_code` varchar(250) NOT NULL,
  `city_id` smallint(4) NOT NULL,
  `state_id` smallint(4) NOT NULL,
  `country_id` smallint(4) NOT NULL,
  `locality` varchar(250) NOT NULL,
  `region_id` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `urban_zipcode`
--

