<?PHP
        
/*---------------------------------------------------------------
  SQL DB BACKUP 16.12.2016 01:57 
  DATABASE: cms
  TABLES: *
  ---------------------------------------------------------------*/

/*---------------------------------------------------------------
  TABLE: `admin_logs`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `admin_logs`;";
$create[] = "CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `logMsg` text NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `date_edited` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

/*---------------------------------------------------------------
  TABLE: `announcements`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `announcements`;";
$create[] = "CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` text NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `date_last_edited` varchar(255) NOT NULL COMMENT 'Edit Date',
  `edited_by` varchar(255) NOT NULL COMMENT 'Edit Author',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `announcements` VALUES   ("2","FREE MONEY FOR EVERYBODY!","Nobody Ever","[Verse 1: Abe Lincoln]\r\nFour score and 65 years in the past\r\nI won the Civil War with my beard\r\nNow I\'m here to whup your ass\r\nI\'ve read up on your facts\r\nYou cure cancer with your tears?\r\nWell, tell me Chuck how come you never sat down and cried on your career?\r\nYou\'re a washed up has been on TV selling Total Gyms\r\nAnd you\'re gonna lose this battle\r\nLike you lost Return of the Dragon\r\nI\'ll rip your chest hairs out\r\nPut em\' in my mouth\r\nI\'ll squash you like I squashed the South\r\nI never told a lie\r\nAnd I won\'t start now\r\nYou\'re a horse with a limp\r\nI\'ll put you down\r\n\r\n[Verse 2: Chuck Norris]\r\nThis isn\'t Gettysburg, punk\r\nI\'d suggest retreating\r\nFor I invented rap music\r\nWhen my heart started beating\r\nChuck Norris doesn\'t battle\r\nHe just allow you to lose\r\nMy raps will blow your mind like a verbal John Wilkes Booth\r\n\r\n[Verse 3: Abe Lincoln]\r\nI\'ve got my face on the side of a mountain\r\nYou voted for John McCain\r\nI\'ve got a bucket full of my head and I\'m about to make it rain\r\nYou block bullets with your beard?\r\nI catch em\' with my skull\r\nI\'d make fun of Walker, Texas Ranger but I\'ve never ever seen that show\r\n\r\n[Verse 4: Chuck Norris]\r\nI am Chuck Fucking Norris!\r\nI\'ve spread more blood and gore\r\nThan forty score of your puny Civil Wars, bitch\r\nI split the Union with a roundhouse kick\r\nI wear a black belt on the beard that I grow on my dick\r\nI attack sharks when I smell them bleed\r\nI don\'t go swimming\r\nWater just wants to be around me\r\nMy fists make the speed of light wish that it was faster\r\nYou may have freed the slaves\r\nBut Chuck is everyone\'s master","6/6/6666","1478207377","Travis Bell");';
$insert[] = 'INSERT INTO `announcements` VALUES ("3","Test Subject","Crypticity","This is a test article and should represent everything working correctly. EDITED","Saturday, September 27 2014 ","Saturday, September 27 2014 ","Crypticity");';
$insert[] = 'INSERT INTO `announcements` VALUES ("5","Test Subject","Crypticity","This article will be edited. EDIT","Saturday, September 27 2014 ","Saturday, September 27 2014 ","Crypticity");';
$insert[] = 'INSERT INTO `announcements` VALUES ("6","Tournament Yesterday","Crypticity","Guess what... YOU MISSED IT!!!","Thursday, October 09 2014 ","0","0");';
$insert[] = 'INSERT INTO `announcements` VALUES ("8","AHHHHHH!","Crypticity","Zombie Invasion!","Sunday, October 19 2014 ","0","0");';
$insert[] = 'INSERT INTO `announcements` VALUES ("9","Good News Everyone!!","Crypticity","I\'m giving you all a raise! Unfortunately, I\'m also selling the company, so you\'re all fired.\r\n\r\nAlso, I\'ll be using your bonuses to fund my retirement.\r\n\r\n-Todd","Sunday, October 19 2014 ","1478207803","Travis Bell");';
$insert[] = 'INSERT INTO `announcements` VALUES ("10","Test","Travis Bell","Welcome to the real world motha\' fucka\'!","1478207837","","");';

/*---------------------------------------------------------------
  TABLE: `calendar`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `calendar`;";
$create[] = "CREATE TABLE `calendar` (
  `year` mediumint(5) NOT NULL,
  `month` smallint(3) NOT NULL,
  `day` smallint(3) NOT NULL,
  `hour` smallint(3) NOT NULL,
  `minute` smallint(3) NOT NULL,
  `meridiem` tinyint(2) NOT NULL,
  `venueID` int(11) NOT NULL,
  `tournamentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

/*---------------------------------------------------------------
  TABLE: `gallery_albums`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `gallery_albums`;";
$create[] = "CREATE TABLE `gallery_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_last_edited` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `gallery_albums` VALUES   ("1","Default","This is a default gallery!","Sunday, October 26 2014 ","Crypticity","Monday, October 27 2014","Crypticity");';
$insert[] = 'INSERT INTO `gallery_albums` VALUES ("3","Test","Test","Monday, October 27 2014","Crypticity","Monday, October 27 2014 ","Crypticity");';

/*---------------------------------------------------------------
  TABLE: `gallery_photos`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `gallery_photos`;";
$create[] = "CREATE TABLE `gallery_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `albumID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `directory` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_last_edited` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `gallery_photos` VALUES   ("9","1252828536928","3","1252828536928","767534","jpg","test","","","","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("10","1252819890330","3","1252819890330","188042","jpg","test","","","","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("11","1252953553391","3","1252953553391","1457533","jpg","test","","","","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("12","1252977300260","3","1252977300260","83992","jpg","test","","","","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("14","1252815199586","3","1252815199586","841420","jpg","test","","","","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("15","1252953644143","3","1252953644143","246259","jpg","test","","","","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("16","1252821772598","3","1252821772598","467612","jpg","test","","","","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("24","Sfgh","3","sfgh","188042","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("25","Dfgjd","3","dfgjd","1457533","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("26","Dghjfdghj","3","dghjfdghj","83992","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("27","Rfllryul","3","rfllryul","98414","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("28","Dghkdghk","3","dghkdghk","841420","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("29","Dghjdghk","3","dghjdghk","246259","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("30","Dghjdgh","3","dghjdgh","467612","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("39","Srtusy","3","srtusy","767534","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("40","Dtyud","3","dtyud","188042","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("41","Avsz","3","avsz","1457533","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("42","Sfghs","3","sfghs","83992","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("43","Zdfbvgz","3","zdfbvgz","98414","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("44","Fjyx","3","fjyx","841420","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("45","Xfxm","3","xfxm","246259","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("46","Xfjhd","3","xfjhd","467612","jpg","test","","Monday, October 27 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("61","Delete","1","delete","4565","png","default","","Wednesday, October 29 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("62","Home","1","home","4397","png","default","","Wednesday, October 29 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `gallery_photos` VALUES ("63","LArrows","1","lArrows","4185","png","default","","Wednesday, October 29 2014 ","Crypticity","","");';

/*---------------------------------------------------------------
  TABLE: `leaderboard`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `leaderboard`;";
$create[] = "CREATE TABLE `leaderboard` (
  `year` smallint(5) NOT NULL,
  `month` smallint(5) NOT NULL,
  `playerID` int(12) NOT NULL,
  `winsVenue` int(11) NOT NULL,
  `chipBonusVenues` int(11) NOT NULL,
  `chipBonusWins` int(11) NOT NULL,
  `totalWins` int(11) NOT NULL,
  `chipsEarned` int(11) NOT NULL,
  `pointsEarned` int(11) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_last_edited` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `leaderboard` VALUES   ("2014","9","1","2","0","0","13","30500","4000","Thursday, October 09 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","2","2","0","0","0","0","0","300","Thursday, October 09 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","2","1","1","0","0","1","0","500","Thursday, October 09 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","1","1","0","0","0","0","0","200","Thursday, October 09 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","2","3","0","0","0","1","0","300","Thursday, October 09 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","4","2","0","0","0","1","0","800","Thursday, October 09 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","4","1","0","0","0","3","21000","1600","Thursday, October 09 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","4","3","0","0","0","1","0","700","Thursday, October 09 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","4","4","0","0","0","3","44500","2200","Thursday, October 09 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","2","4","0","0","0","5","42502","3500","Thursday, October 09 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","10","1","0","0","0","1","0","1100","Friday, October 17 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","1","3","0","0","0","3","20500","1200","Sunday, October 19 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","4","5","0","0","0","9","26000","3600","Tuesday, October 21 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","3","4","0","0","0","6","43502","3700","Wednesday, October 29 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","3","3","0","0","0","1","0","300","Wednesday, October 29 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","3","1","1","0","0","1","0","500","Wednesday, October 29 2014 ","Crypticity","","");';
$insert[] = 'INSERT INTO `leaderboard` VALUES ("2014","3","2","0","0","0","0","0","300","Wednesday, October 29 2014 ","Crypticity","","");';

/*---------------------------------------------------------------
  TABLE: `page_viewers`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `page_viewers`;";
$create[] = "CREATE TABLE `page_viewers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `cookie` varchar(255) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `pageID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `page_viewers` VALUES   ("1","Wednesday, October 08 2014 ","127.0.0.1","jlrsbu5li6q6jjfvpdfb78s7v0","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("3","Wednesday, October 08 2014 ","127.0.0.1","jlrsbu5li6q6jjfvpdfb78s7v0","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36","1");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("4","Wednesday, October 08 2014 ","127.0.0.1","jlrsbu5li6q6jjfvpdfb78s7v0","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("5","Wednesday, October 08 2014 ","127.0.0.1","jlrsbu5li6q6jjfvpdfb78s7v0","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36","3");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("6","Wednesday, October 08 2014 ","","7em94v8nsuk7nbgsfnqo5bs593","","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("7","Thursday, October 09 2014 ","127.0.0.1","jlrsbu5li6q6jjfvpdfb78s7v0","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("8","Sunday, October 12 2014 ","192.168.1.3","pfcl4d0d6c68gpuphmdm6g84i4","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("9","Sunday, October 12 2014 ","192.168.1.3","pfcl4d0d6c68gpuphmdm6g84i4","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("10","Sunday, October 12 2014 ","192.168.1.3","pfcl4d0d6c68gpuphmdm6g84i4","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("11","Sunday, October 12 2014 ","192.168.1.3","pfcl4d0d6c68gpuphmdm6g84i4","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","3");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("12","Friday, October 17 2014 ","127.0.0.1","toasic6915j9rfkghj1k5ara76","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("13","Friday, October 17 2014 ","127.0.0.1","k7safv5pb48r1t7i954ok3f5h2","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("14","Friday, October 17 2014 ","127.0.0.1","toasic6915j9rfkghj1k5ara76","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("15","Friday, October 17 2014 ","127.0.0.1","k7safv5pb48r1t7i954ok3f5h2","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("16","Friday, October 17 2014 ","127.0.0.1","k7safv5pb48r1t7i954ok3f5h2","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("17","Friday, October 17 2014 ","127.0.0.1","k7safv5pb48r1t7i954ok3f5h2","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","3");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("18","Friday, October 17 2014 ","127.0.0.1","r0ph1pf3vq0jdrs92l2ohvbrd3","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("19","Friday, October 17 2014 ","127.0.0.1","r0ph1pf3vq0jdrs92l2ohvbrd3","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("20","Friday, October 17 2014 ","127.0.0.1","r0ph1pf3vq0jdrs92l2ohvbrd3","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("21","Friday, October 17 2014 ","127.0.0.1","h9gum34nm89qo96a00nugk03m6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("22","Friday, October 17 2014 ","127.0.0.1","h9gum34nm89qo96a00nugk03m6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("23","Friday, October 17 2014 ","127.0.0.1","toasic6915j9rfkghj1k5ara76","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36","3");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("24","Friday, October 17 2014 ","127.0.0.1","44apr0m6keudrlnorvf3d3e795","Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.17","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("25","Friday, October 17 2014 ","127.0.0.1","h9gum34nm89qo96a00nugk03m6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("26","Friday, October 17 2014 ","127.0.0.1","h9gum34nm89qo96a00nugk03m6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","3");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("27","Friday, October 17 2014 ","127.0.0.1","e8e4g3o4b85kv11f5thtckdj51","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("28","Friday, October 17 2014 ","127.0.0.1","4qvi5vkv9c2u2smp39ijdl72o0","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("29","Saturday, October 18 2014 ","127.0.0.1","dimjqto6lcjv4v9bhjo1ihm401","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("30","Saturday, October 18 2014 ","127.0.0.1","qu78c9t96t07kamsfvmu5mqkq0","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("31","Saturday, October 18 2014 ","127.0.0.1","i3a6rq4qva2d7ndbd81kgikim1","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("32","Saturday, October 18 2014 ","127.0.0.1","6q3v2co98afibni9pnbu3r8nt5","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("33","Saturday, October 18 2014 ","127.0.0.1","6q3v2co98afibni9pnbu3r8nt5","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("34","Saturday, October 18 2014 ","127.0.0.1","6q3v2co98afibni9pnbu3r8nt5","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("35","Saturday, October 18 2014 ","127.0.0.1","c7b7peifl43s824l8od0iprag6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("36","Saturday, October 18 2014 ","127.0.0.1","c7b7peifl43s824l8od0iprag6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("37","Saturday, October 18 2014 ","127.0.0.1","toasic6915j9rfkghj1k5ara76","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("38","Saturday, October 18 2014 ","127.0.0.1","c7b7peifl43s824l8od0iprag6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("39","Saturday, October 18 2014 ","127.0.0.1","63lmverf1mvmlc0oslu767oai1","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("40","Saturday, October 18 2014 ","127.0.0.1","63lmverf1mvmlc0oslu767oai1","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("41","Saturday, October 18 2014 ","127.0.0.1","54n8gufgnsq0pkt72j0g1cdr03","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("42","Saturday, October 18 2014 ","127.0.0.1","metcp7dah6n0c7jqkqn4c7rqj2","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("43","Saturday, October 18 2014 ","127.0.0.1","t734pdhptdnmtc2pfb4tfue546","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("44","Saturday, October 18 2014 ","127.0.0.1","opl94cebi03bdv4hpfo9vp9774","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("45","Saturday, October 18 2014 ","127.0.0.1","mn9s2912hs9qfntdf4u126j0h0","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("46","Saturday, October 18 2014 ","192.168.1.2","8ubdt4oi8nagn2fvq3opcnblh7","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("47","Saturday, October 18 2014 ","192.168.1.2","bmokasq8on27pi7u46eug0p3f6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("48","Saturday, October 18 2014 ","192.168.1.2","bmokasq8on27pi7u46eug0p3f6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("49","Saturday, October 18 2014 ","192.168.1.2","8ubdt4oi8nagn2fvq3opcnblh7","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36","3");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("50","Saturday, October 18 2014 ","192.168.1.2","8ubdt4oi8nagn2fvq3opcnblh7","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("51","Saturday, October 18 2014 ","192.168.1.2","8ubdt4oi8nagn2fvq3opcnblh7","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36","1");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("52","Saturday, October 18 2014 ","192.168.1.2","8ubdt4oi8nagn2fvq3opcnblh7","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36","7");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("53","Sunday, October 19 2014 ","192.168.1.2","8ubdt4oi8nagn2fvq3opcnblh7","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("54","Sunday, October 19 2014 ","","k2ds7cd8cuohjhkq29bptmr9a2","","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("55","Sunday, October 19 2014 ","192.168.1.2","bmokasq8on27pi7u46eug0p3f6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","1");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("56","Sunday, October 19 2014 ","192.168.1.2","bmokasq8on27pi7u46eug0p3f6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("57","Tuesday, October 21 2014 ","192.168.1.3","0updd39a30v6f44o89upepom00","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("58","Tuesday, October 21 2014 ","192.168.1.3","0updd39a30v6f44o89upepom00","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","1");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("59","Tuesday, October 21 2014 ","192.168.1.3","0updd39a30v6f44o89upepom00","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("60","Tuesday, October 21 2014 ","192.168.1.3","0updd39a30v6f44o89upepom00","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("61","Tuesday, October 21 2014 ","192.168.1.3","0updd39a30v6f44o89upepom00","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","3");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("62","Tuesday, October 21 2014 ","","q2voh7ckmqht9irp9oclt775s6","","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("63","Wednesday, October 22 2014 ","192.168.1.3","rum5lmo4nern7isla3ad15jkh4","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("64","Wednesday, October 22 2014 ","192.168.1.3","rum5lmo4nern7isla3ad15jkh4","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","1");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("65","Wednesday, October 22 2014 ","192.168.1.3","rum5lmo4nern7isla3ad15jkh4","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("66","Wednesday, October 22 2014 ","192.168.1.3","rum5lmo4nern7isla3ad15jkh4","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("67","Wednesday, October 22 2014 ","192.168.1.3","rum5lmo4nern7isla3ad15jkh4","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Mobile Safari/537.36","3");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("68","Monday, October 27 2014 ","192.168.1.6","fqonv2pkr5h07r3l5p0qjli0d4","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("69","Tuesday, October 28 2014 ","192.168.1.2","8ubdt4oi8nagn2fvq3opcnblh7","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("70","Wednesday, October 29 2014 ","192.168.1.2","hkv3thkh6vdpl041j29g8oojm6","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("71","Wednesday, October 29 2014 ","192.168.1.2","bafnblhf34j4t3a2utm1mqfi06","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("72","Wednesday, October 29 2014 ","192.168.1.2","hkv3thkh6vdpl041j29g8oojm6","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("73","Wednesday, October 29 2014 ","192.168.1.2","hkv3thkh6vdpl041j29g8oojm6","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0","1");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("74","Wednesday, October 29 2014 ","192.168.1.2","hkv3thkh6vdpl041j29g8oojm6","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("75","Wednesday, October 29 2014 ","192.168.1.2","hkv3thkh6vdpl041j29g8oojm6","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("76","Wednesday, October 29 2014 ","192.168.1.3","4h5ar354vgs02d82a1ok72rs00","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.114 Mobile Safari/537.36","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("77","Wednesday, October 29 2014 ","192.168.1.3","4h5ar354vgs02d82a1ok72rs00","Mozilla/5.0 (Linux; Android 4.4.2; SPH-L710 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.114 Mobile Safari/537.36","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("78","Wednesday, October 29 2014 ","192.168.1.2","drp3rgu9gj0gqljiav67qlc1k3","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("79","Wednesday, October 29 2014 ","192.168.1.2","drp3rgu9gj0gqljiav67qlc1k3","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("80","Wednesday, October 29 2014 ","192.168.1.2","u38250od7lpqrtoivj461q4bb5","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("81","Wednesday, October 29 2014 ","192.168.1.2","u38250od7lpqrtoivj461q4bb5","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("82","Wednesday, October 29 2014 ","192.168.1.2","mb6k3iu33qn42rckbc2i8gkle7","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("83","Wednesday, October 29 2014 ","192.168.1.2","mb6k3iu33qn42rckbc2i8gkle7","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("84","Wednesday, October 29 2014 ","192.168.1.2","rmhcph5e6tv6f5jg8gbsj72vs6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("85","Wednesday, October 29 2014 ","192.168.1.2","rmhcph5e6tv6f5jg8gbsj72vs6","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("86","Wednesday, October 29 2014 ","192.168.1.2","41tktb9jiqt096em6v8gf6p8k1","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("87","Wednesday, October 29 2014 ","192.168.1.2","41tktb9jiqt096em6v8gf6p8k1","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("88","Wednesday, October 29 2014 ","192.168.1.2","3417cspm63sihdhekb45fuel82","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("89","Wednesday, October 29 2014 ","192.168.1.2","3417cspm63sihdhekb45fuel82","Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; BTRS100194; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("90","Wednesday, October 29 2014 ","192.168.1.6","fqonv2pkr5h07r3l5p0qjli0d4","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("91","Wednesday, November 05 2014 ","192.168.1.2","i2puar8c157fld1fh5e1bgs660","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("92","Wednesday, November 05 2014 ","192.168.1.2","0rsqj9rfa41t3d6pigr8kq9cb2","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("93","Wednesday, November 05 2014 ","192.168.1.2","i2puar8c157fld1fh5e1bgs660","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","1");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("94","Wednesday, November 05 2014 ","192.168.1.2","i2puar8c157fld1fh5e1bgs660","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("95","Wednesday, November 05 2014 ","192.168.1.2","i2puar8c157fld1fh5e1bgs660","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","3");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("96","Wednesday, November 05 2014 ","192.168.1.2","ia1mail64eqehk3056gehg4l72","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("97","Friday, November 07 2014 ","192.168.1.2","i2puar8c157fld1fh5e1bgs660","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("98","Friday, November 07 2014 ","192.168.1.2","i2puar8c157fld1fh5e1bgs660","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","9");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("99","Friday, November 07 2014 ","192.168.1.2","i2puar8c157fld1fh5e1bgs660","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","6");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("100","Friday, November 07 2014 ","192.168.1.2","q945e0l4lthvp5kjf9eh32p0j0","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("101","Friday, November 14 2014 ","192.168.1.3","vv4bonrtlsd2ceceadhrqp0ug0","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("102","Friday, November 14 2014 ","192.168.1.3","csgd692ablqiqkk49d8mg22ah2","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("103","Friday, November 14 2014 ","192.168.1.3","vv4bonrtlsd2ceceadhrqp0ug0","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","1");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("104","Friday, November 14 2014 ","192.168.1.3","vv4bonrtlsd2ceceadhrqp0ug0","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("105","Friday, November 14 2014 ","192.168.1.3","6ju6p0v06q7lshqhkcfrcn2b00","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("106","Sunday, November 16 2014 ","192.168.1.3","vv4bonrtlsd2ceceadhrqp0ug0","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("107","Monday, November 17 2014 ","127.0.0.1","qa40cgqgsr9ccpj97a56290oi7","Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.17","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("108","Monday, November 17 2014 ","192.168.1.3","750tevikv75t7om2ijibcija86","Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.17","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("109","Monday, November 17 2014 ","192.168.1.3","h1l44cihcqps7pq78joitkoia1","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36 OPR/25.0.1614.68","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("110","Monday, November 17 2014 ","192.168.1.3","h1l44cihcqps7pq78joitkoia1","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36 OPR/25.0.1614.68","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("111","Monday, November 17 2014 ","192.168.1.3","aq7rsbh0e8uvjvt3cqpg674921","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("112","Monday, November 17 2014 ","192.168.1.3","6ju6p0v06q7lshqhkcfrcn2b00","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36","8");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("113","Monday, November 17 2014 ","192.168.1.3","h1l44cihcqps7pq78joitkoia1","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36 OPR/25.0.1614.68","3");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("114","Monday, November 17 2014 ","192.168.1.3","h1l44cihcqps7pq78joitkoia1","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36 OPR/25.0.1614.68","2");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("115","Thursday, November 20 2014 ","192.168.1.3","h1l44cihcqps7pq78joitkoia1","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36 OPR/25.0.1614.68","9");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("116","Thursday, November 20 2014 ","192.168.1.3","h1l44cihcqps7pq78joitkoia1","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36 OPR/25.0.1614.68","1");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("117","Friday, November 21 2014 ","127.0.0.1","csmmsuguhf2964scamaqptnv93","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36 OPR/25.0.1614.68","5");';
$insert[] = 'INSERT INTO `page_viewers` VALUES ("118","Monday, November 24 2014 ","192.168.1.7","g791dkaiku6p46jqoacqdfuno5","Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0","8");';

/*---------------------------------------------------------------
  TABLE: `pages`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `pages`;";
$create[] = "CREATE TABLE `pages` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `default` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `online` tinyint(2) NOT NULL,
  `user_restriction` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Default',
  `image` varchar(255) NOT NULL,
  `stylesheet` varchar(255) DEFAULT NULL,
  `clock` tinyint(2) NOT NULL,
  `calendar` tinyint(2) NOT NULL,
  `page_default_content` text,
  `date_created` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_last_edited` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `pageViews` int(11) NOT NULL,
  `lastViewDate` varchar(255) NOT NULL,
  `lastViewTime` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `pages` VALUES   ("0","0","admin","1","2","Admin Login","Administrative Login Page.","Login","",NULL,"0","0","Admin Login","","","","","0","","");';
$insert[] = 'INSERT INTO `pages` VALUES ("1","0","announcements","1","0","Announcements","","Default","",NULL,"1","1","Test Content","Saturday, September 27 2014 ","default","Saturday, September 27 2014 ","Crypticity","10","Thursday, November 20 2014 ","7:26 pm");';
$insert[] = 'INSERT INTO `pages` VALUES ("2","0","venues","1","0","Venues","","Default","",NULL,"1","1","This is a default venues home page. Information on how to set up your location as a venue and other related data goes here. <a href=\"index.php?p=venues&search\">Click Here</a> If you wish to search our venues.","Saturday, September 27 2014 ","default","Sunday, September 28 2014 ","Crypticity","17","Monday, November 17 2014 ","7:12 pm");';
$insert[] = 'INSERT INTO `pages` VALUES ("3","0","tournaments","1","0","Tournaments","","Default","",NULL,"1","1","This is a default tournaments home page. Information on how to schedule your venue for a tournament, register yourself as a player at a tournament, or just find out when a tournament is held will go here.","Saturday, September 27 2014 ","default","Thursday, October 02 2014 ","Crypticity","10","Monday, November 17 2014 ","6:47 am");';
$insert[] = 'INSERT INTO `pages` VALUES ("5","1","home","1","0","Home","This is the home page.","Default","",NULL,"1","1","This is a <a href=\"index.php?p=announcements\">Test</a>.","Sunday, September 28 2014 ","default","Saturday, October 18 2014 ","Crypticity","46","Friday, November 21 2014 ","6:25 pm");';
$insert[] = 'INSERT INTO `pages` VALUES ("6","0","leaderboard","1","0","Leaderboard","","Default","",NULL,"1","1","This is a default leaderboard home page. Information on what is going on with current statistics and currently calculated leaderboard statistics and global player data from official events will go here.","Thursday, October 09 2014 ","Crypticity","","","14","Friday, November 07 2014 ","4:52 pm");';
$insert[] = 'INSERT INTO `pages` VALUES ("7","0","faq","1","0","FAQ","","Default","",NULL,"1","1","<p><b>If you are interested in hosting Texas Holdâ€™em in your establishment, please contact Steve at (352) 400-9488.</b></p>\r\n\r\n<article>\r\n<dl>\r\n<dt>WELCOME TO PLAYERS POKER TOUR!!</dt>\r\n\r\n<dd>We are Central Floridaâ€™s Premier FREE Texas Holdâ€™em Poker entertainment company.Our locations span Citrus and Marion Counties. Becoming a Players Poker Tour Host is a great way to draw customers into your business.Our fee includes set up and dismantling of tables and professional dealers who are committed to the success of your business.</dd>\r\n\r\n<dt>How it works</dt>\r\n\r\n<dd>We run our no-limit tournaments once a month. ;Standard No-Limit Texas Holdâ€™em rules apply.To qualify for the monthly tournament each player must win three (3) tables within the month at any of our daily events.Our daily events are held in bars and restaurants that are completely free to enter, and a great way for beginning players to get their feet wet and learn the game, as well as for more seasoned players to polish their skills in live competition.</dd>\r\n\r\n<dt>How to earn additional chips</dt>\r\n\r\n<dd>First 3 wins;qualifies you for our tournament with 20,000 chips. Each additional win is worth 1,000 additional chips. Each bounty that you eliminate during the month will earn you 500 extra chips;There is no limit to the number of;chips you can start with. The;more;wins you have in the month, the more chips you will start with at the tournament!</dd>\r\n</article>","Tuesday, October 21 2014 ","Crypticity","Tuesday, October 21 2014 ","Crypticity","0","","");';
$insert[] = 'INSERT INTO `pages` VALUES ("8","0","gallery","1","0","Gallery","","Default","",NULL,"1","1","Default gallery home page will go here.","Tuesday, October 28 2014 ","Crypticity","","","18","Monday, November 24 2014 ","12:22 pm");';
$insert[] = 'INSERT INTO `pages` VALUES ("9","0","login","1","0","Login","","Login","",NULL,"0","0","{Login::loginSection()}","","","","","0","","");';
$insert[] = 'INSERT INTO `pages` VALUES ("10","0","user","1","1","User Panel","The Sites User Panel","User Panel","",NULL,"0","0","Test Panel","","","","","0","","");';
$insert[] = 'INSERT INTO `pages` VALUES ("11","0","registration","1","0","User Registration","Allows the user to register to the site.","Registration","",NULL,"0","0","User Registration","","","","","0","","");';

/*---------------------------------------------------------------
  TABLE: `player_mail`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `player_mail`;";
$create[] = "CREATE TABLE `player_mail` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `receiver_id` int(12) NOT NULL,
  `sender_id` int(12) NOT NULL,
  `unread` tinyint(1) NOT NULL DEFAULT '1',
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `player_mail` VALUES   ("1","1","1","0","Test Subject","Test Message");';
$insert[] = 'INSERT INTO `player_mail` VALUES ("2","1","1","1","New Test Subject","New Test Message");';

/*---------------------------------------------------------------
  TABLE: `player_settings`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `player_settings`;";
$create[] = "CREATE TABLE `player_settings` (
  `player_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  UNIQUE KEY `player_id` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `player_settings` VALUES   ("0","1");';
$insert[] = 'INSERT INTO `player_settings` VALUES ("1","1");';
$insert[] = 'INSERT INTO `player_settings` VALUES ("2","1");';
$insert[] = 'INSERT INTO `player_settings` VALUES ("3","1");';
$insert[] = 'INSERT INTO `player_settings` VALUES ("4","1");';
$insert[] = 'INSERT INTO `player_settings` VALUES ("5","1");';

/*---------------------------------------------------------------
  TABLE: `player_statistics`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `player_statistics`;";
$create[] = "CREATE TABLE `player_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` smallint(5) NOT NULL,
  `month` smallint(3) NOT NULL,
  `day` int(11) NOT NULL DEFAULT '0',
  `player_id` int(12) NOT NULL,
  `venue_id` int(12) NOT NULL,
  `nonvenue` int(11) NOT NULL,
  `venue_wins` int(11) NOT NULL,
  `bounty` int(11) NOT NULL,
  `high_hand` int(11) NOT NULL,
  `xtra_points` int(11) NOT NULL,
  `hands_played` int(11) NOT NULL,
  `event_points` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `year` (`year`),
  KEY `player_id` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `player_statistics` VALUES   ("1","2016","11","3","1","7","666","3","666","666","666","666","666");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("2","2016","10","5","2","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("3","2016","10","5","3","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("4","2016","10","5","4","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("5","2016","10","5","5","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("6","2016","10","5","6","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("7","2016","10","5","7","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("8","2016","10","5","8","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("9","2016","10","5","9","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("10","2016","10","5","10","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("11","2016","10","5","11","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("12","2016","10","5","12","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("13","2016","10","5","13","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("14","2016","10","5","14","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("15","2016","10","5","15","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("16","2016","10","5","16","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("17","2016","10","5","17","2","3","2","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("18","2016","10","5","18","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("19","2016","10","5","19","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("20","2016","10","5","20","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("21","2016","10","5","21","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("22","2016","10","5","22","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("23","2016","10","5","23","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("24","2016","10","5","24","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("25","2016","10","5","25","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("26","2016","10","5","26","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("27","2016","10","5","27","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("28","2016","10","5","28","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("29","2016","10","5","29","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("30","2016","10","5","30","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("31","2016","10","5","31","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("32","2016","10","5","32","2","3","0","5","7","345","12","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("33","2016","10","5","33","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("34","2016","10","5","34","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("35","2016","10","5","35","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("36","2016","10","5","36","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("37","2016","10","5","37","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("38","2016","10","5","38","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("39","2016","10","5","39","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("40","2016","10","5","40","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("41","2016","10","5","41","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("42","2016","10","5","42","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("43","2016","10","5","43","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("44","2016","10","5","44","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("45","2016","10","5","45","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("46","2016","10","5","46","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("47","2016","10","5","47","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("48","2016","10","5","48","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("49","2016","10","5","49","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("50","2016","10","5","50","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("51","2016","10","5","51","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("52","2016","10","5","52","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("53","2016","10","5","53","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("54","2016","10","5","54","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("55","2016","10","5","55","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("56","2016","10","5","56","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("57","2016","10","5","57","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("58","2016","10","5","58","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("59","2016","10","5","59","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("60","2016","10","5","60","3","75","0","3","6","12","4","56");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("61","2016","11","1","15","3","5","0","5","6","756","345","346");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("62","2016","11","1","1","3","666","3","666","666","666666","666","666666");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("63","2016","11","2","15","5","3","0","6","34","123","4","1234");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("64","2016","11","2","1","5","54","0","34","55","63","56","5433");';
$insert[] = 'INSERT INTO `player_statistics` VALUES ("65","2016","10","6","1","2","435","3","453","546","765","754","463");';

/*---------------------------------------------------------------
  TABLE: `player_venue_statistics`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `player_venue_statistics`;";
$create[] = "CREATE TABLE `player_venue_statistics` (
  `player_id` int(12) NOT NULL,
  `venue_id` int(12) NOT NULL,
  `win_count` int(11) NOT NULL,
  `day` int(11) NOT NULL DEFAULT '0',
  `month` varchar(255) NOT NULL,
  `year` smallint(5) NOT NULL,
  KEY `playerID` (`player_id`,`venue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `player_venue_statistics` VALUES   ("1","5","2","0","1","2014");';
$insert[] = 'INSERT INTO `player_venue_statistics` VALUES ("1","6","3","0","1","2014");';
$insert[] = 'INSERT INTO `player_venue_statistics` VALUES ("1","3","3","0","2","2014");';
$insert[] = 'INSERT INTO `player_venue_statistics` VALUES ("1","8","1","0","2","2014");';
$insert[] = 'INSERT INTO `player_venue_statistics` VALUES ("1","5","2","5","10","2016");';

/*---------------------------------------------------------------
  TABLE: `players`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `players`;";
$create[] = "CREATE TABLE `players` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_last_edited` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '3',
  `lastName` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `players` VALUES   ("0","","","","","","0","User","Guest","","");';
$insert[] = 'INSERT INTO `players` VALUES ("1","test","Saturday, September 27 2014","","","","1","Bell","Travis","slypher@gmail.com","3522194130");';
$insert[] = 'INSERT INTO `players` VALUES ("2","test","Sunday, September 28 2014","","","","2","One","Test","test@test.com","");';
$insert[] = 'INSERT INTO `players` VALUES ("3","","Monday, September 29 2014","","","","3","Two","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("4","test","Thursday, October 09 2014 ","Crypticity","","","3","Strempel","Sara","sara.strempel@gmail.com","");';
$insert[] = 'INSERT INTO `players` VALUES ("5","","Sunday, October 19 2014 ","Crypticity","","","3","Three","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("6","test","","","","","3","One","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("7","test","","","","","3","Two","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("8","test","","","","","3","Three","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("9","test","","","","","3","Four","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("10","test","","","","","3","5","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("11","test","","","","","3","6","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("12","test","","","","","3","7","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("13","test","","","","","3","8","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("14","test","","","","","3","9","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("15","test","","","","","3","10","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("16","test","","","","","3","11","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("17","test","","","","","3","12","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("18","test","","","","","3","13","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("19","test","","","","","3","14","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("20","test","","","","","3","15","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("21","test","","","","","3","16","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("22","test","","","","","3","17","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("23","test","","","","","3","18","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("24","test","","","","","3","19","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("25","test","","","","","3","20","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("26","test","","","","","3","21","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("27","test","","","","","3","22","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("28","test","","","","","3","23","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("29","test","","","","","3","24","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("30","test","","","","","3","25","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("31","test","","","","","3","26","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("32","test","","","","","3","27","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("33","test","","","","","3","28","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("34","test","","","","","3","29","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("35","test","","","","","3","30","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("36","test","","","","","3","31","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("37","test","","","","","3","32","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("38","test","","","","","3","33","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("39","test","","","","","3","34","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("40","test","","","","","3","35","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("41","test","","","","","3","36","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("42","test","","","","","3","37","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("43","test","","","","","3","38","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("44","test","","","","","3","39","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("45","test","","","","","3","40","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("46","test","","","","","3","41","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("47","test","","","","","3","42","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("48","test","","","","","3","43","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("49","test","","","","","3","44","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("50","test","","","","","3","45","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("51","test","","","","","3","46","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("52","test","","","","","3","47","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("53","test","","","","","3","48","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("54","test","","","","","3","49","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("55","test","","","","","3","50","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("56","test","","","","","3","51","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("57","test","","","","","3","52","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("58","test","","","","","3","53","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("59","test","","","","","3","54","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("60","test","","","","","3","55","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("62","test","","","","","3","57","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("63","test","","","","","3","58","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("64","test","","","","","3","59","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("65","test","","","","","3","60","Test","","");';
$insert[] = 'INSERT INTO `players` VALUES ("67","test","","","","","3","62","Test","","");';

/*---------------------------------------------------------------
  TABLE: `settings`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `settings`;";
$create[] = "CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteTitle` varchar(255) NOT NULL,
  `defaultTimeZone` varchar(255) NOT NULL,
  `defaultTimestamp` varchar(255) NOT NULL,
  `defaultURL` varchar(255) NOT NULL,
  `charSet` varchar(255) NOT NULL DEFAULT 'UTF-8',
  `uploadDir` varchar(255) NOT NULL,
  `online` tinyint(1) NOT NULL,
  `debugMode` tinyint(1) NOT NULL,
  `defaultPage` varchar(255) NOT NULL,
  `defaultTemplate` int(11) NOT NULL,
  `facebook` text NOT NULL,
  `twitter` text NOT NULL,
  `googlePlus` text NOT NULL,
  `youTube` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `settings` VALUES   ("1","Test Title","US/Eastern","l, F d Y ","http://192.168.1.2/cms","UTF-8","/uploads/gallery/","1","0","1","1","http://www.facebook.com/playerspokertour","http://www.twitter.com","http://plus.google.com","http://www.youtube.com");';

/*---------------------------------------------------------------
  TABLE: `sub_pages`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `sub_pages`;";
$create[] = "CREATE TABLE `sub_pages` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `online` tinyint(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Default',
  `image` varchar(255) NOT NULL,
  `stylesheet` varchar(255) DEFAULT NULL,
  `page_default_content` text,
  `date_created` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_last_edited` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `pageViews` int(11) NOT NULL,
  `lastViewDate` varchar(255) NOT NULL,
  `lastViewTime` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `sub_pages` VALUES   ("1","10","settings","1","User Settings","This is the users settings main page.","User Settings","",NULL,"Test User Settings main Page","","","","","0","","");';
$insert[] = 'INSERT INTO `sub_pages` VALUES ("2","10","update","1","Update Account","Update User Account Information","User Account","",NULL,"Test User Account Page","","","","","0","","");';

/*---------------------------------------------------------------
  TABLE: `template_cache`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `template_cache`;";
$create[] = "CREATE TABLE `template_cache` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `skin_name` varchar(255) NOT NULL,
  `parent_skin` varchar(255) NOT NULL,
  `func_name` text NOT NULL,
  `func_attr` text NOT NULL,
  `func_inner` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `template_cache` VALUES   ("1","global","1","form_success","$msg","		<p>\n			<table id=\'successTable\' cellpadding=0 cellspacing=0>\n				<tr>\n					<th>\n						<b>Success!</b>\n					</th>\n				</tr>\n				<tr>\n					<td>\n						<p>\n							{$msg}\n						</p>\n					</td>\n				</tr>\n			</table>\n		</p>");';
$insert[] = 'INSERT INTO `template_cache` VALUES ("2","global","1","form_error","$msg","		<p>\n			<table id=\'errorTable\' cellpadding=0 cellspacing=0>\n				<tr>\n					<th>\n						<b>Error!</b>\n					</th>\n				</tr>\n				<tr>\n					<td>\n						<p>\n							{$msg}\n						</p>\n					</td>\n				</tr>\n			</table>\n		</p>");';
$insert[] = 'INSERT INTO `template_cache` VALUES ("3","global","1","header","","<html>\n	<head>\n		<link rel=\'shortcut icon\' href=\'/favicon.ico\'> \n		<link rel=\'icon\' href=\'/favicon.ico\' type=\'image/ico\'>\n		<meta http-equiv=\'X-UA-Compatible\' content=\'IE=9\' />\n		<meta http-equiv=\'content-type\' content=\'text/html; charset=iso-8859-1\' />\n		<script type=\'text/javascript\' src=\'jquery-1.7.2.js\'></script> \n		<link rel=\'stylesheet\' type=\'text/css\' href=\'stylesheet.css\' />\n		<title>{$Panel->siteData[\'siteTitle\']}</title>\n	</head>");';
$insert[] = 'INSERT INTO `template_cache` VALUES ("4","global","1","calendar","","		<script type=\"text/javascript\" src=\"jquery.1.4.2.js\"></script>\n<script type=\"text/javascript\" src=\"jsDatePick.jquery.min.1.3.js\"></script>\n<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"jsDatePick_ltr.min.css\" />\n<script type=\"text/javascript\">\n	window.onload = function(){		\n		\n		g_globalObject = new JsDatePick({\n			useMode:1,\n			isStripped:true,\n			target:\"ppt_calendar\"\n		});\n		\n		g_globalObject.setOnSelectedDelegate(function(){\n			var obj = g_globalObject.getSelectedDay();\n			alert(\"a date was just selected and the date is : \" + obj.day + \"/\" + obj.month + \"/\" + obj.year);\n			document.getElementById(\"div3_example_result\").innerHTML = obj.day + \"/\" + obj.month + \"/\" + obj.year;\n		});	\n		\n	};\n</script>\n\n\n					<table id=\'Table\' class=\'clockTable\'>\n						<tr>\n							<th>Calendar <img align=\'right\' src=\'images/mini_c.gif\'></th>\n						</tr>\n		<tr>\n			<td>\n    <div id=\"ppt_calendar\"></div>\n			</td>\n		 </tr>\n		 </table>");';
$insert[] = 'INSERT INTO `template_cache` VALUES ("5","global","1","body","","		<body>\n			<div id=\'fb-root\'></div>\n<script>(function(d, s, id) {\n  var js, fjs = d.getElementsByTagName(s)[0];\n  if (d.getElementById(id)) return;\n  js = d.createElement(s); js.id = id;\n  js.src = \'//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=72391920426&version=v2.0\';\n  fjs.parentNode.insertBefore(js, fjs);\n}(document, \'script\', \'facebook-jssdk\'));</script>\n			<table cellspacing=0 id=\'mainTable\'>\n				<tr>\n					<td colspan=2  id=\'logBar\'>\n				<table id=\'logBarL\' cellpadding=0 cellspacing=0>\n					<tr>\n						<td>\n						<b>&nbsp;&nbsp; {$Panel->siteData[\'siteTitle\']}</b>\n						</td>\n						<td align=\'right\'>\n							<a href=\'{$Panel->siteData[\'facebook\']}\'><img src=\'images/Facebook.png\'></a>&nbsp;&nbsp;\n							<a href=\'{$Panel->siteData[\'googlePlus\']}\'><img src=\'images/GooglePlus.png\'></a>&nbsp;&nbsp;\n							<a href=\'{$Panel->siteData[\'twitter\']}\'><img src=\'images/Twitter.png\'></a>&nbsp;&nbsp;\n							<a href=\'{$Panel->siteData[\'youTube\']}\'><img src=\'images/Youtube.png\'>\n						</td>\n					</tr>\n				</table>\n					</td>\n				</tr>\n						<tr>\n					<td id=\'leftlogo\'>\n				<img src=\'images/pptlogo.jpg\'>\n					</td>\n					<td id=\'navSec\'>\n			<table cellpadding=0 cellspacing=0 id=\'navBar\'>\n				<tr>\n					<td>\n						<a href=\'index.php?p=home\'>Home</a>\n					</td>\n					<td>\n						<a href=\'index.php?p=venues\'>Venues</a>\n					</td>\n					<td>\n						<a href=\'index.php?p=leaderboard\'>Leader Board</a>\n					</td>\n				</tr>\n				<tr>\n					<td>\n						<a href=\'index.php?p=tournaments\'>Tourna ments</a>\n					</td>\n					<td>\n						<a href=\'index.php?p=gallery\'>Gallery</a>\n					</td>\n					<td>\n						<a href=\'index.php?p=faq\'>FAQ</a>\n					</td>\n				</tr>\n			</table>\n					</td>\n				</tr>\n				<tr>\n					<td colspan=2>");';
$insert[] = 'INSERT INTO `template_cache` VALUES ("6","global","1","clock","","		    <script type=\"text/javascript\" src=\"jquery-1.2.6.min.js\"></script>\n    <script type=\"text/javascript\">\n    \n        $(document).ready(function() {\n         \n              setInterval( function() {\n              var seconds = new Date().getSeconds();\n              var sdegree = seconds * 6;\n              var srotate = \"rotate(\" + sdegree + \"deg)\";\n              \n              $(\"#sec\").css({\"-moz-transform\" : srotate, \"-webkit-transform\" : srotate});\n                  \n              }, 1000 );\n              \n         \n              setInterval( function() {\n              var hours = new Date().getHours();\n              var mins = new Date().getMinutes();\n              var hdegree = hours * 30 + (mins / 2);\n              var hrotate = \"rotate(\" + hdegree + \"deg)\";\n              \n              $(\"#hour\").css({\"-moz-transform\" : hrotate, \"-webkit-transform\" : hrotate});\n                  \n              }, 1000 );\n        \n        \n              setInterval( function() {\n              var mins = new Date().getMinutes();\n              var mdegree = mins * 6;\n              var mrotate = \"rotate(\" + mdegree + \"deg)\";\n              \n              $(\"#min\").css({\"-moz-transform\" : mrotate, \"-webkit-transform\" : mrotate});\n                  \n              }, 1000 );\n         \n        }); \n    \n    </script>\n					<table id=\'Table\' class=\'clockTable\'>\n						<tr>\n							<th>Clock <img align=\'right\' src=\'images/mini_c.gif\'></th>\n						</tr>\n		<tr>\n			<td>\n	<ul id=\"clock\">	\n	   	<li id=\"sec\"></li>\n	   	<li id=\"hour\"></li>\n		<li id=\"min\"></li>\n	</ul>\n			</td>\n		 </tr>\n		 </table>");';
$insert[] = 'INSERT INTO `template_cache` VALUES ("7","global","1","copyright","","				</td>\n			</tr>\n		</table>\n	</body>\n</html>");';
$insert[] = 'INSERT INTO `template_cache` VALUES ("9","news","1","show_article","$article","		<p>\r\n			<table cellpadding=0 cellspacing=0 id=\'newsArticle\'>\r\n				<tr>\r\n					<th class=\'subject\'><span class=\'articleSubject\'>{$article[\'subject\']}</span></th>\r\n				</tr>\r\n				<tr>\r\n					<td class=\'composer\'>\r\n						<span class=\'textTitle\'>Author: </span><span class=\'articleAuthor\'>{$article[\'author\']}</span><br />\r\n						<span class=\'textTitle\'>Date: </span><span class=\'articleDate\'>{$article[\'date\']}</span>\r\n					</td>\r\n				</tr>\r\n				<tr>\r\n					<td class=\'article\'>\r\n						{$article[\'content\']}\r\n					</td>\r\n				</tr>\r\n				{$Panel->Template->Skins[\'s_global\']->platform_table_fb()}\r\n			</table>\r\n		</p>");';

/*---------------------------------------------------------------
  TABLE: `templates`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `templates`;";
$create[] = "CREATE TABLE `templates` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `date_created` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_last_edited` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `skin_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `directory` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `templates` VALUES   ("1","Saturday, September 27 2014","Crypticity","","","PPT_Classic","Players Poker Tour (Classic)","1","default/");';

/*---------------------------------------------------------------
  TABLE: `tournaments`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `tournaments`;";
$create[] = "CREATE TABLE `tournaments` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `date_created` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_last_edited` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `year` smallint(5) NOT NULL,
  `month` smallint(4) NOT NULL,
  `day` smallint(4) NOT NULL,
  `time` varchar(10) NOT NULL,
  `venueID` varchar(255) NOT NULL,
  `information` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `tournaments` VALUES   ("5","1481619155","Travis Bell","","","2016","12","19","3:00 PM","11","Test");';
$insert[] = 'INSERT INTO `tournaments` VALUES ("6","1481620064","Travis Bell","1481633951","Travis Bell","2016","12","3","3:10 PM","10","Test Edit");';

/*---------------------------------------------------------------
  TABLE: `venue_features`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `venue_features`;";
$create[] = "CREATE TABLE `venue_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `venue_features` VALUES   ("1","Beer","This place serves beer.","beer.png");';
$insert[] = 'INSERT INTO `venue_features` VALUES ("2","Liquor","This place serves many kinds of liquor.","alcohol.png");';
$insert[] = 'INSERT INTO `venue_features` VALUES ("3","Smoking","This place allows smoking inside the building.","smoking.png");';
$insert[] = 'INSERT INTO `venue_features` VALUES ("4","Some Food","This place serves some food items. No full course meals.","someFood.png");';
$insert[] = 'INSERT INTO `venue_features` VALUES ("5","Full Food","This place can serve full course meals.","fullFood.png");';
$insert[] = 'INSERT INTO `venue_features` VALUES ("6","Pool Tables","This venue has at least one pool table.","pool.png");';
$insert[] = 'INSERT INTO `venue_features` VALUES ("7","Darts","This place includes at least one regular or electronic dartboard.","darts.png");';
$insert[] = 'INSERT INTO `venue_features` VALUES ("8","Wine","This venue offers a selection of wines.","wine.png");';

/*---------------------------------------------------------------
  TABLE: `venues`
  ---------------------------------------------------------------*/
$drop[] = "DROP TABLE IF EXISTS `venues`;";
$create[] = "CREATE TABLE `venues` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `date_created` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_last_edited` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `img` text NOT NULL,
  `features` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `startTime` varchar(255) NOT NULL,
  `day` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipCode` int(5) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";
$insert[] = 'INSERT INTO `venues` VALUES   ("0","1","","Default","","","","","Wild Card","","","","","","0","","");';
$insert[] = 'INSERT INTO `venues` VALUES ("1","1","Saturday, September 27 2014","Crypticity","1481596010","Travis Bell","","1,7,2","The Break Room Billiards","7:00 PM","1","210A Tompkins Street","Inverness","FL","34450","3523412777","Beer/Wine/Non-Smoking/Food Delivery Available");';
$insert[] = 'INSERT INTO `venues` VALUES ("2","1","Saturday, September 27 2014","Crypticity","","","","1,2,4,5,8","Grumpy Gator\'s","7:00 PM","1","4828 S. SunCoast Blvd.","Homosassa","FL","34446","3525032064","Beer & Wine/Non-Smoking/Food");';
$insert[] = 'INSERT INTO `venues` VALUES ("3","1","Saturday, September 27 2014","Crypticity","1481612934","Travis Bell","","1,5,2,3","Castaway\'s Bar &amp; Grill","3:00 PM|6:00 PM","2|5","5430 N Suncoast Blvd.","Crystal River","FL","34428","3527953653","Full Liquor/Smoking/Food ");';
$insert[] = 'INSERT INTO `venues` VALUES ("4","1","Saturday, September 27 2014","Crypticity","","","","","Griff\'s Lounge","7:00 PM|7:00 PM","2|5","825 W. Main Street","Inverness","FL","34450","3524194814","Full Liquor/Smoking");';
$insert[] = 'INSERT INTO `venues` VALUES ("5","1","Saturday, September 27 2014","Crypticity","","","","1,2,3,5,6,7","Crock\'s Pub","7:00 PM","2","20199 E. Pennsylvania Avenue ","Dunnellon","FL","34432","3524650500","Full Liquor/Smoking/Food");';
$insert[] = 'INSERT INTO `venues` VALUES ("6","1","Saturday, September 27 2014","Crypticity","","","","1,2,3,5,6,7","Sparrows Tavern","6:00 PM|6:00 PM","3|6","9542 N. Citrus Springs Blvd.","Citrus Springs","FL","34474","3524650053","Full Liquor/Smoking/Some Food");';
$insert[] = 'INSERT INTO `venues` VALUES ("7","1","Saturday, September 27 2014","Crypticity","","","","1,2,5","Two Guys From Italy","7:00 PM|2:00 PM","3|7","5792 S Suncoast Blvd.","Homosassa","FL","34446","3526286955","Full Liquor/Non Smoking/Food ");';
$insert[] = 'INSERT INTO `venues` VALUES ("8","1","Saturday, September 27 2014","Crypticity","","","","","Giovanni\'s Pub","7:00 PM","4","3451 E Louise Ln.","Hernando","FL","34442","3526374118","Full Liquor/Smoking/ Some Food");';
$insert[] = 'INSERT INTO `venues` VALUES ("9","1","Saturday, September 27 2014","Crypticity","","","","1,3,4,8","Mousetrap Saloon","7:00 PM","4","48  U.S. Hwy. 19 N","Inglis","FL","34449","3524475920","Beer & Wine/Smoking/Some food  offered");';
$insert[] = 'INSERT INTO `venues` VALUES ("10","1","Saturday, September 27 2014","Crypticity","","","","","Frog\'s Lounge","6:00 PM","6","3171 S. Stonebrook Drive","Homosassa","FL","34448","3526281076","Beer & Wine/Smoking/Bar Menu");';
$insert[] = 'INSERT INTO `venues` VALUES ("11","1","Saturday, September 27 2014","Crypticity","1481595877","Travis Bell","","1,2,3,4","Silvermoon Tavern","1:00 PM","7","3025 S. US Hwy  41","Dunnellon","FL","34432","3524890062","Test Edit Description");';
$insert[] = 'INSERT INTO `venues` VALUES ("12","1","1480147439","Travis Bell","","","","","Test Venue","8:00am","5","asdf","Inverness","FL","34432","","Test");';
$insert[] = 'INSERT INTO `venues` VALUES ("15","0","1481612202","Travis Bell","1481613351","Travis Bell","","1,5,6,4","Test","2:05 PM","2","test","test","FL","12345","","Test");';

?>