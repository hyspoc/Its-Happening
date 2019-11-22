CREATE TABLE `event_image` (
  `image_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `image` varchar(225) NOT NULL,
  `e_image` longblob,
  PRIMARY KEY (`image_id`),
  KEY `event_id_idx` (`event_id`),
  CONSTRAINT `event_id_images` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1