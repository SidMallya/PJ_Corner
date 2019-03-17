# PJ_Corner
A place where you can post your original poor jokes (PJ), read others jokes, rate them and rise through your ratings from New Born PJer to PJ God.

Prerequistes:

1) The code used here requires below set up in MySQL:  

   User: root
   
   Password: changeme
   
   DB: test
   
   Update the user_defined_functions.php if you wish to use a different user, password or db.
   
2) Run the below DDL in MySQL command prompt:

```
   use test;
   
  CREATE TABLE `member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_reg_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `member_update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `member_first_name` varchar(16) NOT NULL,
  `member_last_name` varchar(28) NOT NULL,
  `member_email` varchar(50) NOT NULL,
  `member_password` char(40) NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `member_email` (`member_email`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  CREATE TABLE `pj` (
  `pj_id` int(11) NOT NULL AUTO_INCREMENT,
  `pj_post_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pj_update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pj_member_id` int(11) NOT NULL,
  `pj_heading` varchar(60) NOT NULL,
  `pj_content` text NOT NULL,
  `pj_views` int(11) NOT NULL DEFAULT '0',
  `pj_rating` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pj_id`),
  KEY `pj_member_id` (`pj_member_id`),
  CONSTRAINT `pj_ibfk_1` FOREIGN KEY (`pj_member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE ON UPDATE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `rating_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rating_pj_id` int(11) NOT NULL,
  `rating_by_member_id` int(11) NOT NULL,
  `rating_member_rating` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '0',
  PRIMARY KEY (`rating_id`),
  KEY `rating_pj_id` (`rating_pj_id`),
  KEY `rating_by_member_id` (`rating_by_member_id`),
  CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`rating_pj_id`) REFERENCES `pj` (`pj_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`rating_by_member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE ON UPDATE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
```
  
3) Use registration code "e05678b3fcf4f11551586a3f3c2b65fde212ed2a" for first time user registration.    
