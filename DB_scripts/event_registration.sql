CREATE TABLE `event_registration` (
  `reg_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(45) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reg_id`),
  KEY `event_id_ticket_idx` (`ticket_id`),
  CONSTRAINT `event_id_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `event_ticket` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1