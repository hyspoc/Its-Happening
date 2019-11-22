CREATE TABLE `organizer` (
  `org_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `org_name` varchar(45) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(25) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `company_name` varchar(45) DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `ph_num` varchar(45) DEFAULT NULL,
  `org_image` longblob,
  `status` varchar(45) DEFAULT 'pending',
  PRIMARY KEY (`username`),
  UNIQUE KEY `org_id_UNIQUE` (`org_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1