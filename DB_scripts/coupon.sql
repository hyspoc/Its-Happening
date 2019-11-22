CREATE TABLE `coupon` (
  `coupon` varchar(25) NOT NULL,
  `discount` decimal(2,0) DEFAULT NULL,
  PRIMARY KEY (`coupon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1