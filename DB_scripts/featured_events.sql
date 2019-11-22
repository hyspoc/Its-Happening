CREATE TABLE `featured_events` (
  `feature_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `image` varchar(225) NOT NULL,
  PRIMARY KEY (`feature_id`),
  KEY `event_id_idx` (`event_id`),
  KEY `event_id_featured` (`event_id`),
  CONSTRAINT `event_id_featured` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1