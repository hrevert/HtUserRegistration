CREATE TABLE `user_registration` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(16) NOT NULL,
  `request_time` datetime NOT NULL,
  `responded` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `token_UNIQUE` (`token`),
  CONSTRAINT `user_registration_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8