CREATE TABLE `event_ticket` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `type` varchar(45) NOT NULL COMMENT 'general, vip, etc',
  `price` decimal(13,2) NOT NULL,
  `total_tickets` int(11) DEFAULT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `event_id_idx` (`event_id`),
  CONSTRAINT `event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1