CREATE TABLE `customer` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(25) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `ctype` varchar(1) DEFAULT NULL,
  `phone_num` varchar(15) DEFAULT NULL,
  `user_image` longblob,
  PRIMARY KEY (`username`),
  UNIQUE KEY `phone_num_UNIQUE` (`phone_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1