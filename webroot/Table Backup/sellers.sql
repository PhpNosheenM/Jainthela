-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `sellers`;
CREATE TABLE `sellers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `gstin` varchar(50) NOT NULL,
  `pan` varchar(50) NOT NULL,
  `gstin_holder_name` varchar(100) NOT NULL,
  `gstin_holder_address` text NOT NULL,
  `firm_name` varchar(100) NOT NULL,
  `firm_address` text NOT NULL,
  `registration_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `termination_reason` text NOT NULL,
  `breif_decription` text NOT NULL,
  `passkey` text NOT NULL COMMENT 'One time password',
  `timeout` bigint(100) NOT NULL COMMENT 'time out for one time password',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  `bill_to_bill_accounting` varchar(10) NOT NULL,
  `opening_balance_value` decimal(15,2) NOT NULL,
  `debit_credit` varchar(10) NOT NULL,
  `saller_image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `sellers_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `sellers` (`id`, `city_id`, `location_id`, `name`, `username`, `password`, `email`, `mobile_no`, `latitude`, `longitude`, `gstin`, `pan`, `gstin_holder_name`, `gstin_holder_address`, `firm_name`, `firm_address`, `registration_date`, `termination_date`, `termination_reason`, `breif_decription`, `passkey`, `timeout`, `created_on`, `created_by`, `status`, `bill_to_bill_accounting`, `opening_balance_value`, `debit_credit`, `saller_image`) VALUES
(1,	0,	1,	'Shailendra',	'shelu',	'$2y$10$jBpoXOULChgAikJKibJXGOkuvLrk2zyZ6opRrGVKSMuCtlCqgmn66',	'shelunagori@gmail.com',	'9694981008',	'',	'',	'',	'',	'',	'',	'PHP POETS',	'udaipur',	'2018-05-03',	'0000-00-00',	'',	'',	'',	0,	'2018-05-03 05:34:32',	1,	'Active',	'no',	10000000.00,	'Dr',	''),
(2,	0,	1,	'Anil Lodha',	'anil',	'$2y$10$vglLFo9Wieu3vWeq7f5gGu17JmQM8leF4oEt3uYK7rEppoWRmNmje',	'ghjk@gmail.com',	'9829041695',	'',	'',	'',	'',	'',	'',	'Variety Handloom',	'vgbhnjkl',	'2018-05-04',	'0000-00-00',	'',	'',	'',	0,	'2018-05-04 11:16:17',	1,	'Active',	'yes',	0.00,	'Dr',	'');

-- 2018-05-07 07:22:08
