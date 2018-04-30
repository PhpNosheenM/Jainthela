-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `accounting_entries`;
CREATE TABLE `accounting_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ledger_id` int(10) NOT NULL,
  `debit` decimal(12,2) DEFAULT NULL,
  `credit` decimal(15,2) DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `location_id` int(10) NOT NULL,
  `city_id` int(11) NOT NULL,
  `purchase_voucher_id` int(10) DEFAULT NULL,
  `purchase_voucher_row_id` int(10) DEFAULT NULL,
  `is_opening_balance` varchar(10) DEFAULT NULL,
  `sales_invoice_id` int(10) NOT NULL,
  `sale_return_id` int(10) DEFAULT NULL,
  `purchase_invoice_id` int(10) DEFAULT NULL,
  `purchase_return_id` int(10) DEFAULT NULL,
  `receipt_id` int(11) DEFAULT NULL,
  `receipt_row_id` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `payment_row_id` int(11) DEFAULT NULL,
  `credit_note_id` int(11) DEFAULT NULL,
  `credit_note_row_id` int(11) DEFAULT NULL,
  `debit_note_id` int(11) DEFAULT NULL,
  `debit_note_row_id` int(11) DEFAULT NULL,
  `sales_voucher_id` int(10) DEFAULT NULL,
  `sales_voucher_row_id` int(10) DEFAULT NULL,
  `journal_voucher_id` int(10) DEFAULT NULL,
  `journal_voucher_row_id` int(10) DEFAULT NULL,
  `contra_voucher_id` int(10) DEFAULT NULL,
  `contra_voucher_row_id` int(10) DEFAULT NULL,
  `reconciliation_date` date DEFAULT NULL,
  `entry_from` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `accounting_entries` (`id`, `ledger_id`, `debit`, `credit`, `transaction_date`, `location_id`, `city_id`, `purchase_voucher_id`, `purchase_voucher_row_id`, `is_opening_balance`, `sales_invoice_id`, `sale_return_id`, `purchase_invoice_id`, `purchase_return_id`, `receipt_id`, `receipt_row_id`, `payment_id`, `payment_row_id`, `credit_note_id`, `credit_note_row_id`, `debit_note_id`, `debit_note_row_id`, `sales_voucher_id`, `sales_voucher_row_id`, `journal_voucher_id`, `journal_voucher_row_id`, `contra_voucher_id`, `contra_voucher_row_id`, `reconciliation_date`, `entry_from`) VALUES
(1,	56,	100.00,	NULL,	'2018-04-01',	0,	0,	NULL,	NULL,	'yes',	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	''),
(2,	45,	500.00,	0.00,	'2018-04-16',	1,	1,	NULL,	NULL,	NULL,	0,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Web'),
(3,	48,	0.00,	525.00,	'2018-04-16',	1,	1,	NULL,	NULL,	NULL,	0,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Web'),
(4,	7,	12.50,	0.00,	'2018-04-16',	1,	1,	NULL,	NULL,	NULL,	0,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Web'),
(5,	8,	12.50,	0.00,	'2018-04-16',	1,	1,	NULL,	NULL,	NULL,	0,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Web'),
(6,	70,	1000.00,	NULL,	'2018-04-01',	1,	1,	NULL,	NULL,	'yes',	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'');

DROP TABLE IF EXISTS `accounting_groups`;
CREATE TABLE `accounting_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nature_of_group_id` int(10) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `customer` tinyint(1) DEFAULT NULL,
  `supplier` tinyint(1) DEFAULT NULL,
  `purchase_voucher_first_ledger` tinyint(1) DEFAULT NULL,
  `purchase_voucher_purchase_ledger` tinyint(1) DEFAULT NULL,
  `purchase_voucher_all_ledger` tinyint(1) DEFAULT NULL,
  `sale_invoice_party` tinyint(4) DEFAULT NULL,
  `sale_invoice_sales_account` tinyint(4) DEFAULT NULL,
  `credit_note_party` int(10) DEFAULT NULL,
  `credit_note_sales_account` int(10) DEFAULT NULL,
  `bank` int(10) NOT NULL,
  `cash` tinyint(1) DEFAULT NULL,
  `purchase_invoice_purchase_account` tinyint(1) DEFAULT NULL,
  `purchase_invoice_party` tinyint(1) DEFAULT NULL,
  `receipt_ledger` tinyint(1) DEFAULT NULL,
  `payment_ledger` tinyint(1) DEFAULT NULL,
  `credit_note_first_row` tinyint(1) DEFAULT NULL,
  `credit_note_all_row` tinyint(1) DEFAULT NULL,
  `debit_note_first_row` tinyint(1) DEFAULT NULL,
  `debit_note_all_row` tinyint(1) DEFAULT NULL,
  `sales_voucher_first_ledger` tinyint(1) DEFAULT NULL,
  `sales_voucher_sales_ledger` tinyint(1) DEFAULT NULL,
  `sales_voucher_all_ledger` tinyint(1) DEFAULT NULL,
  `journal_voucher_ledger` tinyint(1) DEFAULT NULL,
  `contra_voucher_ledger` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `accounting_groups` (`id`, `nature_of_group_id`, `name`, `parent_id`, `lft`, `rght`, `customer`, `supplier`, `purchase_voucher_first_ledger`, `purchase_voucher_purchase_ledger`, `purchase_voucher_all_ledger`, `sale_invoice_party`, `sale_invoice_sales_account`, `credit_note_party`, `credit_note_sales_account`, `bank`, `cash`, `purchase_invoice_purchase_account`, `purchase_invoice_party`, `receipt_ledger`, `payment_ledger`, `credit_note_first_row`, `credit_note_all_row`, `debit_note_first_row`, `debit_note_all_row`, `sales_voucher_first_ledger`, `sales_voucher_sales_ledger`, `sales_voucher_all_ledger`, `journal_voucher_ledger`, `contra_voucher_ledger`) VALUES
(1,	2,	'Branch / Divisions',	NULL,	1,	2,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	1,	1,	1,	1,	1,	NULL,	NULL,	NULL,	NULL),
(2,	2,	'Capital Account',	NULL,	3,	6,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(3,	1,	'Current Assets',	NULL,	7,	20,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL),
(4,	2,	'Current Liabilities',	NULL,	21,	32,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL),
(5,	4,	'Direct Expenses',	NULL,	33,	34,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL),
(6,	3,	'Direct Incomes',	NULL,	35,	36,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL),
(7,	1,	'Fixed Assets',	NULL,	37,	38,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(8,	4,	'Indirect Expenses',	NULL,	39,	40,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL),
(9,	3,	'Indirect Incomes',	NULL,	41,	42,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL),
(10,	1,	'Investments',	NULL,	43,	44,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(11,	2,	'Loans (Liability)',	NULL,	45,	52,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(12,	1,	'Misc. Expenses (ASSET)',	NULL,	53,	54,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(13,	4,	'Purchase Accounts',	NULL,	55,	56,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	1,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(14,	3,	'Sales Accounts',	NULL,	57,	58,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	1,	1,	NULL,	NULL),
(15,	2,	'Suspense A/c',	NULL,	59,	60,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(16,	NULL,	'Reserves & Surplus',	2,	4,	5,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(17,	NULL,	'Bank Accounts',	3,	8,	9,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL),
(18,	NULL,	'Cash-in-hand',	3,	10,	11,	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	0,	1,	NULL,	NULL,	1,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL),
(19,	NULL,	'Deposits (Asset)',	3,	12,	13,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(20,	NULL,	'Loans & Advances (Asset)',	3,	14,	15,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(21,	NULL,	'Stock-in-hand',	3,	16,	17,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(22,	NULL,	'Sundry Debtors',	3,	18,	19,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	1,	NULL,	0,	NULL,	NULL,	NULL,	1,	1,	1,	1,	1,	1,	1,	NULL,	NULL,	NULL,	NULL),
(23,	NULL,	'Duties & Taxes',	4,	22,	27,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL),
(24,	NULL,	'Provisions',	4,	28,	29,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(25,	NULL,	'Sundry Creditors',	4,	30,	31,	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	1,	1,	NULL,	1,	1,	1,	1,	1,	NULL,	NULL,	NULL,	NULL),
(26,	NULL,	'Bank OD A/c',	11,	46,	47,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL),
(27,	NULL,	'Secured Loans',	11,	48,	49,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(28,	NULL,	'Unsecured Loans',	11,	50,	51,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(29,	NULL,	'Input GST',	23,	23,	24,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(30,	NULL,	'Output GST',	23,	25,	26,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile_no` varchar(30) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `passkey` text NOT NULL COMMENT 'one time password',
  `timeout` bigint(100) NOT NULL COMMENT 'time out for one time password',
  `status` tinyint(2) NOT NULL COMMENT '1 for continoue and 0 for delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admins` (`id`, `location_id`, `role_id`, `name`, `username`, `password`, `email`, `mobile_no`, `created_on`, `created_by`, `passkey`, `timeout`, `status`) VALUES
(1,	1,	1,	'Ashish',	'ashish',	'$2y$10$xMXvmyPVbhwUy43ZS8EWDehvDcmNqiE7t6jPiCanbXc4JdLGggstq',	'ashishbohara1008@gmail.com',	'8058483636',	'2018-03-05 17:14:27',	1,	'',	0,	1);

DROP TABLE IF EXISTS `api_versions`;
CREATE TABLE `api_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `api_versions` (`id`, `version`) VALUES
(1,	'1');

DROP TABLE IF EXISTS `app_menus`;
CREATE TABLE `app_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `title_content` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `app_menus` (`id`, `name`, `link`, `city_id`, `status`, `parent_id`, `lft`, `rght`, `title_content`) VALUES
(1,	'Home',	'a',	1,	0,	NULL,	1,	2,	'Menu'),
(2,	'Bulk Booking',	'a',	1,	0,	NULL,	3,	4,	'Menu'),
(3,	'My Order',	'c',	1,	0,	NULL,	5,	6,	'My Information'),
(4,	'My Account',	'a',	1,	0,	NULL,	7,	22,	'My Information'),
(5,	'My Cart',	'a',	1,	0,	NULL,	23,	24,	'My Information'),
(6,	'My Address',	'a',	1,	0,	NULL,	25,	26,	'My Information'),
(7,	'Popular Item',	'a',	1,	0,	NULL,	27,	28,	'My Information'),
(8,	'Offer Zone',	'a',	1,	0,	NULL,	29,	30,	'My Information'),
(9,	'My Profile',	'a',	1,	0,	4,	8,	9,	''),
(10,	'My Order',	'a',	1,	0,	4,	10,	11,	''),
(11,	'Delivery Address',	'a',	1,	0,	4,	12,	13,	''),
(12,	'My Wallet',	'a',	1,	0,	4,	14,	15,	''),
(13,	'Cashback Details',	'a',	1,	0,	4,	16,	17,	''),
(14,	'Invite Friends',	'a',	1,	0,	4,	18,	19,	''),
(15,	'Notifications',	'a',	1,	0,	4,	20,	21,	''),
(16,	'About Us',	'a',	1,	0,	NULL,	31,	32,	'Other'),
(17,	'FAQ',	'a',	1,	0,	NULL,	33,	34,	'Other'),
(18,	'Terms & Conditions',	'a',	1,	0,	NULL,	35,	36,	'Other'),
(19,	'Privacy Policy',	'a',	1,	0,	NULL,	37,	38,	'Other'),
(20,	'Shop By Category',	'a',	1,	0,	NULL,	39,	40,	'Menu');

DROP TABLE IF EXISTS `app_notifications`;
CREATE TABLE `app_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `app_link` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `screen_type` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_by` int(11) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `app_notification_customers`;
CREATE TABLE `app_notification_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_notification_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sent` int(11) NOT NULL,
  `send_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `aws_files`;
CREATE TABLE `aws_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bucket_name` varchar(100) NOT NULL,
  `access_key` varchar(255) NOT NULL,
  `secret_access_key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `aws_files` (`id`, `bucket_name`, `access_key`, `secret_access_key`) VALUES
(1,	'uccidata',	'AKIAJ3M4MZWCSIJO5FJQ',	'L1iBdTrYJbXymIsgPnHkDmBq59nZmdX9qbSZKGms');

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `link_name` varchar(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `banner_image_web` varchar(100) NOT NULL,
  `banner_image` varchar(100) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `banners` (`id`, `city_id`, `link_name`, `name`, `banner_image_web`, `banner_image`, `created_on`, `status`) VALUES
(1,	1,	'Banners',	'BAnners',	'banner/1/web/banner1524032778.jpeg',	'banner/1/web/banner1524032778.jpeg',	'2018-03-15 12:53:29',	'Active'),
(2,	1,	'Banners 2',	'BAnners 2',	'banner/2/web/banner1524032804.jpeg',	'banner/2/app/banner1524032804.jpeg',	'2018-03-15 12:53:29',	'Active'),
(3,	1,	'Plan',	'plan',	'banner/3/web/banner1524032833.jpeg',	'banner/3/app/banner1524032833.jpeg',	'2018-03-20 11:20:36',	'Active'),
(4,	1,	'Plan',	'plan',	'banner/4/web/banner1524032858.jpeg',	'banner/4/app/banner1524032858.jpeg',	'2018-03-20 11:21:10',	'Active'),
(5,	1,	'gsd',	'zf',	'banner/5/web/banner1524641597.png',	'banner/5/app/banner1524641597.png',	'2018-04-24 12:22:07',	'Active'),
(6,	1,	'gpp',	'GPs',	'banner/6/web/banner1524645898.png',	'banner/6/app/banner1524645898.png',	'2018-04-25 08:44:48',	'Active'),
(7,	1,	'ds',	'ccvnu',	'banner/7/web/banner1524647770.png',	'banner/7/app/banner1524647770.png',	'2018-04-25 09:16:52',	'Active'),
(8,	1,	'fd',	'af',	'banner/8/web/banner1524647973.png',	'banner/8/app/banner1524647973.png',	'2018-04-25 09:19:18',	'Active');

DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `brand_image` varchar(250) NOT NULL,
  `brand_image_web` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `brands` (`id`, `city_id`, `name`, `status`, `created_by`, `created_on`, `brand_image`, `brand_image_web`) VALUES
(1,	1,	'Eclairs',	'Active',	1,	'2018-03-10 10:46:12',	'brand/1/app/download.png',	'brand/1/web/download.png'),
(2,	1,	'Amul',	'Active',	1,	'2018-03-10 10:46:44',	'brand/2/app/Colgate-Logo.png',	'brand/2/web/Colgate-Logo.png'),
(3,	1,	'Saras',	'Active',	1,	'2018-03-10 10:46:52',	'brand/3/app/logo-mamypoko_1_R.png',	'brand/3/web/logo-mamypoko_1_R.png'),
(4,	1,	'Lakme',	'Active',	1,	'2018-03-10 10:47:07',	'brand/4/app/Surf_Excel.svg.png',	'brand/4/web/Surf_Excel.svg.png'),
(5,	1,	'Test-I',	'Active',	1,	'2018-04-26 11:13:13',	'brand/5/app/brand1524743692.png',	'brand/5/web/brand1524743692.png'),
(6,	1,	'Test-II',	'Active',	1,	'2018-04-26 11:13:53',	'brand/6/app/brand1524742558.png',	'brand/6/web/brand1524742558.png');

DROP TABLE IF EXISTS `bulk_booking_leads`;
CREATE TABLE `bulk_booking_leads` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `lead_no` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `lead_description` text NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_time` varchar(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL DEFAULT 'Open',
  `reason` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bulk_booking_leads` (`id`, `city_id`, `customer_id`, `lead_no`, `name`, `mobile`, `lead_description`, `delivery_date`, `delivery_time`, `created_on`, `status`, `reason`) VALUES
(1,	1,	11,	1,	'brnj',	'5455946565',	'',	'2018-04-12',	'07:30 PM',	'2018-04-26 07:15:49',	'Open',	'dbmghbv'),
(2,	1,	11,	2,	'brnj',	'5455946565',	'',	'2018-04-12',	'07:30 PM',	'2018-04-26 07:17:04',	'Open',	'dbmghbv'),
(4,	1,	38,	4,	'vvvv',	'1234567899',	'',	'2018-04-28',	'05:24 AM',	'2018-04-26 10:55:49',	'Open',	'tedf'),
(5,	1,	38,	5,	'vvvv',	'1234567899',	'',	'2018-04-28',	'05:24 AM',	'2018-04-26 10:55:50',	'Open',	'tedf'),
(6,	1,	38,	6,	'vvvv',	'1234567899',	'',	'2018-04-28',	'05:24 AM',	'2018-04-26 10:56:16',	'Open',	'tedf'),
(7,	1,	38,	7,	'vvgv',	'6666666666',	'',	'2018-04-26',	'07:28 PM',	'2018-04-26 10:59:54',	'Open',	'ggh'),
(8,	1,	0,	8,	'GOpesh SIngh ',	'8233199728',	'Jai ho........................................',	'2018-04-27',	'2:45 PM',	'2018-04-28 05:56:25',	'Open',	''),
(9,	1,	0,	9,	'gps',	'867875857858',	'hgkkgkg',	'2018-04-13',	'2:15 PM',	'2018-04-28 08:47:06',	'Open',	''),
(10,	1,	0,	10,	'gdhs',	'8654365356',	'hgdbgfdd',	'2018-05-05',	'3:30 PM',	'2018-04-28 09:54:53',	'Open',	''),
(11,	1,	0,	11,	'gfd',	'98765432',	'ndfjnf bn',	'2018-05-04',	'3:30 PM',	'2018-04-28 09:56:06',	'Open',	''),
(12,	1,	0,	12,	'gfd',	'98765432',	'ndfjnf bn',	'2018-05-04',	'3:30 PM',	'2018-04-28 09:57:06',	'Open',	''),
(13,	1,	0,	13,	'gfd',	'98765432',	'ndfjnf bn',	'2018-05-04',	'3:30 PM',	'2018-04-28 09:57:39',	'Open',	''),
(14,	1,	0,	14,	'gfd',	'98765432',	'ndfjnf bn',	'2018-05-04',	'3:30 PM',	'2018-04-28 09:58:20',	'Open',	''),
(15,	1,	0,	15,	'gfd',	'98765432',	'ndfjnf bn',	'2018-05-04',	'3:30 PM',	'2018-04-28 09:58:32',	'Open',	''),
(16,	1,	0,	16,	'gfd',	'98765432',	'ndfjnf bn',	'2018-05-04',	'3:30 PM',	'2018-04-28 10:00:22',	'Open',	''),
(18,	1,	0,	17,	'hh',	'9999999999999999',	'tjytyrhtjt jmymjy',	'2018-04-26',	'4:00 PM',	'2018-04-28 10:31:23',	'Open',	''),
(19,	1,	0,	18,	'dgsag',	'876543456',	' vzdfgdcx b  xzdz ',	'2018-04-26',	'4:15 PM',	'2018-04-28 10:34:49',	'Open',	''),
(21,	1,	0,	19,	'fd',	'876543',	'grfsdv',	'2018-05-05',	'4:45 PM',	'2018-04-28 11:02:13',	'Open',	''),
(22,	1,	0,	20,	'dsv',	'9876543234',	'bzf oji Sbheo Om Banna sa',	'2018-05-05',	'4:45 PM',	'2018-04-28 11:06:07',	'Open',	''),
(23,	1,	0,	21,	'nlk',	'0987654444678',	'87ytu6',	'2018-05-02',	'4:45 PM',	'2018-04-28 11:08:24',	'Open',	''),
(24,	1,	0,	22,	'cxzfd',	'9876543',	'sbgbx',	'2018-05-04',	'5:15 PM',	'2018-04-28 11:38:44',	'Open',	''),
(25,	1,	0,	23,	'Ashish',	'8058483636',	'szhk',	'2018-04-28',	'5:15 PM',	'2018-04-28 11:43:12',	'Open',	''),
(26,	1,	0,	24,	'Asnish',	'8058483636',	'csdsfs',	'2018-04-18',	'5:15 PM',	'2018-04-28 11:55:38',	'Open',	''),
(27,	1,	0,	25,	'fdfsfssd',	'8058483636',	'hskjfhsdjkfsdfk',	'2018-04-25',	'5:30 PM',	'2018-04-28 11:58:35',	'Open',	'');

DROP TABLE IF EXISTS `bulk_booking_lead_rows`;
CREATE TABLE `bulk_booking_lead_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bulk_booking_lead_id` int(10) NOT NULL,
  `image_name` varchar(50) NOT NULL,
  `image_name_web` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bulk_booking_lead_id` (`bulk_booking_lead_id`),
  CONSTRAINT `bulk_booking_lead_rows_ibfk_1` FOREIGN KEY (`bulk_booking_lead_id`) REFERENCES `bulk_booking_leads` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bulk_booking_lead_rows` (`id`, `bulk_booking_lead_id`, `image_name`, `image_name_web`) VALUES
(1,	1,	'Bulk_Booking1524726949716843072.jpeg',	''),
(2,	7,	'',	''),
(3,	8,	'',	''),
(6,	9,	'',	''),
(7,	10,	'',	''),
(9,	11,	'',	''),
(12,	12,	'',	''),
(14,	13,	'',	''),
(16,	14,	'',	''),
(18,	15,	'',	''),
(21,	16,	'',	''),
(31,	18,	'bulk_booking_lead/31/app/bulk_booking_lead15249114',	''),
(32,	18,	'bulk_booking_lead/32/app/bulk_booking_lead15249114',	''),
(36,	19,	'bulk_booking_lead/36/app/bulk_booking_lead15249116',	'bulk_booking_lead/36/web/bulk_booking_lead15249116'),
(40,	21,	'',	''),
(42,	22,	'',	''),
(45,	23,	'bulk_booking_lead/45/app/bulk_booking_lead15249136',	'bulk_booking_lead/45/web/bulk_booking_lead15249136'),
(46,	24,	'',	''),
(48,	25,	'bulk_booking_lead/48/app/bulk_booking_lead15249157',	'bulk_booking_lead/48/web/bulk_booking_lead15249157'),
(50,	26,	'bulk_booking_lead/50/app/bulk_booking_lead15249164',	'bulk_booking_lead/50/web/bulk_booking_lead15249164'),
(52,	27,	'bulk_booking_lead/52/app/bulk_booking_lead15249166',	'bulk_booking_lead/52/web/bulk_booking_lead15249166');

DROP TABLE IF EXISTS `cancel_reasons`;
CREATE TABLE `cancel_reasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cancel_reasons` (`id`, `reason`, `created_on`, `created_by`, `status`) VALUES
(1,	'Other',	'2018-03-03 10:58:16',	1,	'Active'),
(2,	'Already Purchased',	'2018-03-03 10:58:16',	1,	'Active');

DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `item_variation_id` int(10) NOT NULL,
  `combo_offer_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `cart_count` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `carts` (`id`, `city_id`, `customer_id`, `item_variation_id`, `combo_offer_id`, `unit_id`, `quantity`, `rate`, `amount`, `cart_count`, `created_on`) VALUES
(76,	1,	38,	2,	0,	2,	0.50,	115.61,	57.81,	1,	'2018-04-20 07:27:40'),
(81,	1,	33,	2,	0,	2,	1.00,	115.61,	115.61,	2,	'2018-04-20 08:43:20'),
(82,	1,	38,	1,	0,	2,	0.50,	11.56,	5.78,	1,	'2018-04-20 11:43:54'),
(106,	1,	11,	9,	0,	1,	2.00,	129.60,	259.20,	1,	'2018-04-23 09:28:24'),
(107,	1,	39,	9,	0,	1,	2.00,	129.60,	259.20,	1,	'2018-04-23 12:13:36'),
(108,	1,	39,	1,	0,	2,	0.50,	11.56,	5.78,	1,	'2018-04-23 12:13:39'),
(109,	1,	40,	9,	0,	1,	2.00,	129.60,	259.20,	1,	'2018-04-24 06:34:54'),
(111,	11,	11,	2,	0,	2,	1.00,	115.61,	115.61,	2,	'2018-04-25 04:55:37'),
(112,	11,	11,	1,	0,	2,	0.50,	11.56,	5.78,	1,	'2018-04-25 06:35:00'),
(113,	11,	11,	9,	0,	1,	4.00,	129.60,	518.40,	2,	'2018-04-25 06:41:09'),
(114,	1,	33,	9,	0,	1,	8.00,	129.60,	1036.80,	4,	'2018-04-25 08:55:40'),
(115,	1,	33,	1,	0,	2,	0.50,	11.56,	5.78,	1,	'2018-04-25 08:55:55'),
(117,	1,	11,	0,	1,	0,	1050.00,	300.00,	315000.00,	3,	'2018-04-26 06:28:37'),
(118,	1,	11,	0,	12,	0,	1.00,	298.14,	298.14,	1,	'2018-04-26 06:29:01'),
(120,	1,	11,	0,	2,	0,	1050.00,	500.00,	525000.00,	3,	'2018-04-26 12:41:14'),
(121,	1,	11,	13,	0,	2,	0.50,	0.00,	0.00,	1,	'2018-04-27 10:54:38'),
(122,	1,	45,	21,	0,	2,	1.00,	0.00,	0.00,	2,	'2018-04-28 11:30:30'),
(123,	1,	45,	20,	0,	1,	900.00,	0.00,	0.00,	1,	'2018-04-28 11:31:24'),
(124,	1,	1,	20,	0,	1,	900.00,	0.00,	0.00,	1,	'2018-04-30 09:10:11'),
(125,	1,	46,	20,	0,	1,	9900.00,	0.00,	0.00,	11,	'2018-04-30 09:38:12');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `section_show` varchar(5) NOT NULL COMMENT 'Yes or No',
  `category_image_web` varchar(50) NOT NULL,
  `category_image` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `edited_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `categories` (`id`, `city_id`, `name`, `parent_id`, `lft`, `rght`, `section_show`, `category_image_web`, `category_image`, `created_on`, `created_by`, `edited_on`, `edited_by`, `status`) VALUES
(1,	1,	'Vegitable',	NULL,	1,	8,	'Yes',	'category/1/web/category1524837247.jpeg',	'category/1/app/category1524837247.jpeg',	'2018-04-26 10:14:54',	1,	'2018-04-30 07:20:49',	1,	'Active'),
(2,	1,	'Fruits',	NULL,	9,	16,	'Yes',	'category/1/web/category1524837247.jpeg',	'category1525069000.png',	'2018-04-30 06:16:40',	1,	'2018-04-30 07:34:08',	0,	'Active'),
(4,	1,	'Cut Fruits',	2,	10,	11,	'Yes',	'category/1/web/category1524837247.jpeg',	'category1525070181.png',	'2018-04-30 06:36:21',	1,	'2018-04-30 07:34:12',	0,	'Active'),
(5,	1,	'Round Fruits',	2,	12,	13,	'Yes',	'category/1/web/category1524837247.jpeg',	'category1525070222.png',	'2018-04-30 06:37:02',	1,	'2018-04-30 07:34:17',	0,	'Active'),
(6,	1,	'Long Fruits',	2,	14,	15,	'Yes',	'category/1/web/category1524837247.jpeg',	'category1525070252.png',	'2018-04-30 06:37:32',	1,	'2018-04-30 07:34:23',	0,	'Active'),
(7,	1,	'Long Vegetables',	1,	2,	3,	'Yes',	'category/1/web/category1524837247.jpeg',	'category1525070282.png',	'2018-04-30 06:38:02',	1,	'2018-04-30 07:34:33',	0,	'Active'),
(8,	1,	'Cut Vegetables',	1,	4,	5,	'Yes',	'category/1/web/category1524837247.jpeg',	'category1525070307.png',	'2018-04-30 06:38:27',	1,	'2018-04-30 07:34:39',	0,	'Active'),
(9,	1,	'Grocery & Staples',	NULL,	17,	22,	'Yes',	'category/1/web/category1524837247.jpeg',	'category1525070586.jpeg',	'2018-04-30 06:43:06',	1,	'2018-04-30 07:34:50',	0,	'Active'),
(10,	1,	'Biscuits',	9,	18,	19,	'Yes',	'category/1/web/category1524837247.jpeg',	'category1525070694.jpeg',	'2018-04-30 06:44:54',	1,	'2018-04-30 07:34:57',	0,	'Active'),
(11,	1,	'Noodles',	9,	20,	21,	'Yes',	'category/1/web/category1524837247.jpeg',	'category1525070787.jpeg',	'2018-04-30 06:46:27',	1,	'2018-04-30 07:35:04',	0,	'Active'),
(12,	1,	'Test',	1,	6,	7,	'Yes',	'category/12/web/category1525072805.jpeg',	'category/12/app/category1525072805.jpeg',	'2018-04-30 07:20:49',	1,	'2018-04-30 07:35:23',	0,	'Active');

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active and Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cities` (`id`, `state_id`, `name`, `created_on`, `created_by`, `status`) VALUES
(1,	1,	'Udaipur',	'2018-03-05 17:11:43',	1,	'Active'),
(2,	1,	'Jaipur',	'2018-03-15 06:27:56',	1,	'Active');

DROP TABLE IF EXISTS `combo_offers`;
CREATE TABLE `combo_offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `print_rate` decimal(10,2) NOT NULL COMMENT 'for display and cross price',
  `discount_per` decimal(6,2) NOT NULL COMMENT 'For Given discount on item in percentage',
  `sales_rate` decimal(10,2) NOT NULL COMMENT 'For Display rate after discount',
  `print_quantity` decimal(6,2) NOT NULL,
  `maximum_quantity_purchase` decimal(10,2) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stock_in_quantity` int(10) NOT NULL,
  `stock_out_quantity` int(10) NOT NULL,
  `out_of_stock` varchar(5) NOT NULL DEFAULT 'No',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `ready_to_sale` varchar(10) NOT NULL COMMENT 'Item which are ready for sale',
  `status` varchar(10) NOT NULL COMMENT 'Active for continoue and Deactive for delete',
  `combo_offer_image_web` varchar(150) NOT NULL,
  `combo_offer_image` varchar(150) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `combo_offers` (`id`, `city_id`, `admin_id`, `name`, `print_rate`, `discount_per`, `sales_rate`, `print_quantity`, `maximum_quantity_purchase`, `start_date`, `end_date`, `stock_in_quantity`, `stock_out_quantity`, `out_of_stock`, `created_on`, `created_by`, `edited_on`, `ready_to_sale`, `status`, `combo_offer_image_web`, `combo_offer_image`, `description`) VALUES
(1,	1,	0,	'Chatpat Offers',	300.00,	10.00,	250.00,	350.00,	2.00,	'2018-03-23 00:00:00',	'2018-03-30 00:00:00',	1,	1,	'No',	'2018-03-23 00:00:00',	0,	'2018-04-26 05:39:47',	'5',	'Active',	'combo_offer/1/web/Bannerb4.jpg',	'combo_offer/1/app/Bannerb4.jpg',	'Amazon Echo is a hands-free smart speaker that you control using your voice. It connects to Alexa - a cloud based voice service to play music, make calls, check weather and news, set alarms, control smart home devices, and much more.\r\nEcho has powerful speakers that fill the room with immersive 360° omnidirectional audio, and deliver crisp vocals and dynamic bass response.\r\nJust ask for a song, artist, or genre from your favourite music services like Amazon Prime Music, Saavn, and TuneIn. Using multi-room music, you can even play music across multiple Echo devices at the same time.\r\nWith seven microphones, beam-forming technology, and noise cancellation, Echo hears you from any direction-even in noisy environments or while playing music.\r\nCall or message anyone hands-free who also has an Echo device or the Alexa App. Simply ask \"Alexa, how do I set up calling?\" to get started.\r\nControls lights, plugs, and more with compatible connected devices from Philips, Syska, TP-Link and Oakter.\r\nAlexa is always getting smarter and adding new features and skills. Just ask Alexa to order food from Zomato, request a ride from Ola, book a carpenter from Urbanclap, and more.'),
(2,	1,	0,	'Holi Offers',	500.00,	20.00,	350.00,	350.00,	2.00,	'2018-03-23 00:00:00',	'2018-03-30 00:00:00',	1,	1,	'No',	'2018-03-23 00:00:00',	0,	'2018-04-26 05:40:10',	'5',	'Active',	'combo_offer/2/web/Banners2.jpg',	'combo_offer/2/app/Banners2.jpg',	'Amazon Echo is a hands-free smart speaker that you control using your voice. It connects to Alexa - a cloud based voice service to play music, make calls, check weather and news, set alarms, control smart home devices, and much more.\r\nEcho has powerful speakers that fill the room with immersive 360° omnidirectional audio, and deliver crisp vocals and dynamic bass response.\r\nJust ask for a song, artist, or genre from your favourite music services like Amazon Prime Music, Saavn, and TuneIn. Using multi-room music, you can even play music across multiple Echo devices at the same time.\r\nWith seven microphones, beam-forming technology, and noise cancellation, Echo hears you from any direction-even in noisy environments or while playing music.\r\nCall or message anyone hands-free who also has an Echo device or the Alexa App. Simply ask \"Alexa, how do I set up calling?\" to get started.\r\nControls lights, plugs, and more with compatible connected devices from Philips, Syska, TP-Link and Oakter.\r\nAlexa is always getting smarter and adding new features and skills. Just ask Alexa to order food from Zomato, request a ride from Ola, book a carpenter from Urbanclap, and more.'),
(3,	1,	0,	'mansson offer',	276.67,	10.00,	250.00,	1.00,	2.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	25,	0,	'No',	'2018-03-27 05:42:24',	0,	'2018-04-26 05:40:39',	'No',	'Active',	'combo_offer/3/web/Bannerb4.jpg',	'combo_offer/3/app/Bannerb4.jpg',	'Amazon Echo is a hands-free smart speaker that you control using your voice. It connects to Alexa - a cloud based voice service to play music, make calls, check weather and news, set alarms, control smart home devices, and much more.\r\nEcho has powerful speakers that fill the room with immersive 360° omnidirectional audio, and deliver crisp vocals and dynamic bass response.\r\nJust ask for a song, artist, or genre from your favourite music services like Amazon Prime Music, Saavn, and TuneIn. Using multi-room music, you can even play music across multiple Echo devices at the same time.\r\nWith seven microphones, beam-forming technology, and noise cancellation, Echo hears you from any direction-even in noisy environments or while playing music.\r\nCall or message anyone hands-free who also has an Echo device or the Alexa App. Simply ask \"Alexa, how do I set up calling?\" to get started.\r\nControls lights, plugs, and more with compatible connected devices from Philips, Syska, TP-Link and Oakter.\r\nAlexa is always getting smarter and adding new features and skills. Just ask Alexa to order food from Zomato, request a ride from Ola, book a carpenter from Urbanclap, and more.'),
(4,	1,	0,	'summer offer',	261.72,	10.00,	240.00,	1.00,	2.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	25,	0,	'No',	'2018-03-27 06:57:47',	1,	'2018-04-26 05:41:03',	'Yes',	'Active',	'combo_offer/4/web/wall_10.jpg',	'combo_offer/4/app/wall_10.jpg',	'Amazon Echo is a hands-free smart speaker that you control using your voice. It connects to Alexa - a cloud based voice service to play music, make calls, check weather and news, set alarms, control smart home devices, and much more.\r\nEcho has powerful speakers that fill the room with immersive 360° omnidirectional audio, and deliver crisp vocals and dynamic bass response.\r\nJust ask for a song, artist, or genre from your favourite music services like Amazon Prime Music, Saavn, and TuneIn. Using multi-room music, you can even play music across multiple Echo devices at the same time.\r\nWith seven microphones, beam-forming technology, and noise cancellation, Echo hears you from any direction-even in noisy environments or while playing music.\r\nCall or message anyone hands-free who also has an Echo device or the Alexa App. Simply ask \"Alexa, how do I set up calling?\" to get started.\r\nControls lights, plugs, and more with compatible connected devices from Philips, Syska, TP-Link and Oakter.\r\nAlexa is always getting smarter and adding new features and skills. Just ask Alexa to order food from Zomato, request a ride from Ola, book a carpenter from Urbanclap, and more.'),
(5,	1,	0,	'summer1',	261.72,	2.00,	1.00,	1.00,	2.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	20,	0,	'No',	'2018-03-27 07:20:14',	1,	'2018-04-26 06:03:49',	'Yes',	'Deactive',	'',	'',	'Amazon Echo is a hands-free smart speaker that you control using your voice. It connects to Alexa - a cloud based voice service to play music, make calls, check weather and news, set alarms, control smart home devices, and much more.\r\nEcho has powerful speakers that fill the room with immersive 360° omnidirectional audio, and deliver crisp vocals and dynamic bass response.\r\nJust ask for a song, artist, or genre from your favourite music services like Amazon Prime Music, Saavn, and TuneIn. Using multi-room music, you can even play music across multiple Echo devices at the same time.\r\nWith seven microphones, beam-forming technology, and noise cancellation, Echo hears you from any direction-even in noisy environments or while playing music.\r\nCall or message anyone hands-free who also has an Echo device or the Alexa App. Simply ask \"Alexa, how do I set up calling?\" to get started.\r\nControls lights, plugs, and more with compatible connected devices from Philips, Syska, TP-Link and Oakter.\r\nAlexa is always getting smarter and adding new features and skills. Just ask Alexa to order food from Zomato, request a ride from Ola, book a carpenter from Urbanclap, and more.'),
(6,	1,	0,	'summer1',	129.60,	2.00,	1.00,	1.00,	2.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	20,	0,	'No',	'2018-03-27 07:21:56',	1,	'2018-04-26 06:05:02',	'Yes',	'Deactive',	'',	'',	'Amazon Echo is a hands-free smart speaker that you control using your voice. It connects to Alexa - a cloud based voice service to play music, make calls, check weather and news, set alarms, control smart home devices, and much more.\r\nEcho has powerful speakers that fill the room with immersive 360° omnidirectional audio, and deliver crisp vocals and dynamic bass response.\r\nJust ask for a song, artist, or genre from your favourite music services like Amazon Prime Music, Saavn, and TuneIn. Using multi-room music, you can even play music across multiple Echo devices at the same time.\r\nWith seven microphones, beam-forming technology, and noise cancellation, Echo hears you from any direction-even in noisy environments or while playing music.\r\nCall or message anyone hands-free who also has an Echo device or the Alexa App. Simply ask \"Alexa, how do I set up calling?\" to get started.\r\nControls lights, plugs, and more with compatible connected devices from Philips, Syska, TP-Link and Oakter.\r\nAlexa is always getting smarter and adding new features and skills. Just ask Alexa to order food from Zomato, request a ride from Ola, book a carpenter from Urbanclap, and more.'),
(7,	1,	1,	'wertyj',	261.72,	10.00,	250.00,	1.00,	2.00,	'2018-03-30 18:30:00',	'2018-04-04 18:30:00',	15,	0,	'No',	'2018-03-27 07:25:41',	1,	'2018-04-26 06:05:08',	'Yes',	'Deactive',	'',	'',	'Amazon Echo is a hands-free smart speaker that you control using your voice. It connects to Alexa - a cloud based voice service to play music, make calls, check weather and news, set alarms, control smart home devices, and much more.\r\nEcho has powerful speakers that fill the room with immersive 360° omnidirectional audio, and deliver crisp vocals and dynamic bass response.\r\nJust ask for a song, artist, or genre from your favourite music services like Amazon Prime Music, Saavn, and TuneIn. Using multi-room music, you can even play music across multiple Echo devices at the same time.\r\nWith seven microphones, beam-forming technology, and noise cancellation, Echo hears you from any direction-even in noisy environments or while playing music.\r\nCall or message anyone hands-free who also has an Echo device or the Alexa App. Simply ask \"Alexa, how do I set up calling?\" to get started.\r\nControls lights, plugs, and more with compatible connected devices from Philips, Syska, TP-Link and Oakter.\r\nAlexa is always getting smarter and adding new features and skills. Just ask Alexa to order food from Zomato, request a ride from Ola, book a carpenter from Urbanclap, and more.'),
(8,	1,	1,	'2323454ytuulk/',	525.96,	10.00,	500.00,	1.00,	5.00,	'2018-03-30 18:30:00',	'2018-03-06 18:30:00',	15,	0,	'No',	'2018-03-27 07:29:02',	1,	'2018-04-26 06:05:15',	'No',	'Deactive',	'',	'',	'Amazon Echo is a hands-free smart speaker that you control using your voice. It connects to Alexa - a cloud based voice service to play music, make calls, check weather and news, set alarms, control smart home devices, and much more.\r\nEcho has powerful speakers that fill the room with immersive 360° omnidirectional audio, and deliver crisp vocals and dynamic bass response.\r\nJust ask for a song, artist, or genre from your favourite music services like Amazon Prime Music, Saavn, and TuneIn. Using multi-room music, you can even play music across multiple Echo devices at the same time.\r\nWith seven microphones, beam-forming technology, and noise cancellation, Echo hears you from any direction-even in noisy environments or while playing music.\r\nCall or message anyone hands-free who also has an Echo device or the Alexa App. Simply ask \"Alexa, how do I set up calling?\" to get started.\r\nControls lights, plugs, and more with compatible connected devices from Philips, Syska, TP-Link and Oakter.\r\nAlexa is always getting smarter and adding new features and skills. Just ask Alexa to order food from Zomato, request a ride from Ola, book a carpenter from Urbanclap, and more.'),
(9,	1,	1,	'kjljlhgfhd',	164.28,	10.00,	150.00,	1.00,	3.00,	'2018-03-30 18:30:00',	'2018-03-03 18:30:00',	22,	0,	'No',	'2018-03-27 07:33:28',	1,	'2018-04-26 05:39:16',	'Yes',	'Active',	'combo_offer/9/web/combo_offer1522136006.jpeg',	'combo_offer/9/app/combo_offer1522136006.jpeg',	'Amazon Echo is a hands-free smart speaker that you control using your voice. It connects to Alexa - a cloud based voice service to play music, make calls, check weather and news, set alarms, control smart home devices, and much more.\r\nEcho has powerful speakers that fill the room with immersive 360° omnidirectional audio, and deliver crisp vocals and dynamic bass response.\r\nJust ask for a song, artist, or genre from your favourite music services like Amazon Prime Music, Saavn, and TuneIn. Using multi-room music, you can even play music across multiple Echo devices at the same time.\r\nWith seven microphones, beam-forming technology, and noise cancellation, Echo hears you from any direction-even in noisy environments or while playing music.\r\nCall or message anyone hands-free who also has an Echo device or the Alexa App. Simply ask \"Alexa, how do I set up calling?\" to get started.\r\nControls lights, plugs, and more with compatible connected devices from Philips, Syska, TP-Link and Oakter.\r\nAlexa is always getting smarter and adding new features and skills. Just ask Alexa to order food from Zomato, request a ride from Ola, book a carpenter from Urbanclap, and more.'),
(10,	1,	1,	'abc',	129.60,	50.00,	250.00,	2.00,	2.00,	'2018-04-30 18:30:00',	'2018-06-08 18:30:00',	6,	0,	'No',	'2018-04-25 08:54:09',	1,	'2018-04-26 10:57:03',	'Yes',	'Active',	'combo_offer/10/web/combo_offer1524646408.png',	'combo_offer/10/app/combo_offer1524646408.png',	''),
(12,	1,	1,	'TEST-2',	298.14,	50.00,	200.00,	1.00,	1.00,	'2018-04-02 18:30:00',	'2018-05-04 18:30:00',	5,	0,	'No',	'2018-04-25 08:59:39',	1,	'2018-04-26 10:57:32',	'Yes',	'Active',	'combo_offer/12/web/combo_offer1524655940.png',	'combo_offer/12/app/combo_offer1524655940.png',	'JAi ndkhv jkhkd');

DROP TABLE IF EXISTS `combo_offer_details`;
CREATE TABLE `combo_offer_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `combo_offer_id` int(11) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `combo_offer_details` (`id`, `combo_offer_id`, `item_variation_id`, `quantity`) VALUES
(1,	1,	1,	1.00),
(2,	1,	2,	1.00),
(3,	1,	9,	1.00),
(4,	2,	1,	2.00),
(5,	3,	9,	1.00),
(6,	3,	2,	1.00),
(7,	3,	12,	1.00),
(8,	4,	9,	1.00),
(9,	4,	2,	1.00),
(10,	5,	9,	1.00),
(11,	5,	2,	1.00),
(12,	6,	9,	1.00),
(13,	7,	9,	1.00),
(14,	7,	2,	1.00),
(15,	8,	9,	1.00),
(16,	8,	2,	3.00),
(17,	9,	9,	1.00),
(18,	9,	1,	3.00),
(19,	10,	9,	1.00),
(20,	10,	13,	1.00),
(21,	11,	9,	1.00),
(22,	11,	20,	2.00),
(23,	11,	1,	1.00),
(39,	12,	9,	2.00),
(40,	12,	12,	3.00);

DROP TABLE IF EXISTS `company_details`;
CREATE TABLE `company_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `web` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `company_details` (`id`, `city_id`, `email`, `web`, `mobile`, `address`, `flag`) VALUES
(1,	1,	'info@jainthela.com',	'www.jainthela.com',	'9116336666',	'Pratapnagar, udaipur (Raj.)',	0);

DROP TABLE IF EXISTS `contra_vouchers`;
CREATE TABLE `contra_vouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `credit_notes`;
CREATE TABLE `credit_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(10) NOT NULL,
  `voucher_no` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `credit_note_rows`;
CREATE TABLE `credit_note_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_note_id` int(11) NOT NULL,
  `cr_dr` varchar(10) NOT NULL,
  `ledger_id` int(10) NOT NULL,
  `debit` decimal(15,2) DEFAULT NULL,
  `credit` decimal(15,2) DEFAULT NULL,
  `mode_of_payment` varchar(30) NOT NULL,
  `cheque_no` varchar(30) NOT NULL,
  `cheque_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'One time password',
  `otp` varchar(10) NOT NULL,
  `device_id` text NOT NULL,
  `fcm_token` text NOT NULL,
  `referral_code` varchar(100) NOT NULL,
  `discount_in_percentage` decimal(6,2) NOT NULL,
  `timeout` bigint(100) NOT NULL COMMENT 'time out for one time password',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  `gstin` varchar(100) NOT NULL,
  `gstin_holder_name` varchar(100) NOT NULL,
  `gstin_holder_address` text NOT NULL,
  `firm_name` varchar(100) NOT NULL,
  `firm_address` text NOT NULL,
  `discount_created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `discount_expiry` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `customer_image` varchar(50) NOT NULL,
  `token` text NOT NULL,
  `edited_by` int(10) NOT NULL,
  `edited_on` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile_no` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `customers` (`id`, `city_id`, `name`, `email`, `username`, `password`, `otp`, `device_id`, `fcm_token`, `referral_code`, `discount_in_percentage`, `timeout`, `created_on`, `created_by`, `status`, `gstin`, `gstin_holder_name`, `gstin_holder_address`, `firm_name`, `firm_address`, `discount_created_on`, `discount_expiry`, `customer_image`, `token`, `edited_by`, `edited_on`) VALUES
(1,	0,	'',	'',	'ashish',	'$2y$10$Qj7pPb8VPULR4oQhF1cCiOn3OxI8OGrNXvFrtXi2DwfPtAkoZPSLW',	'',	'',	'',	'',	0.00,	0,	'2018-03-10 13:02:29',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'',	0,	NULL),
(4,	1,	'asertj',	'etrytjy@erthjh.com',	'9876543430',	'',	'',	'',	'',	'',	0.00,	0,	'2018-03-13 11:28:59',	1,	'Active',	'',	'',	'',	'ewrtythjh',	'',	'2018-02-28 18:30:00',	'2019-03-30 18:30:00',	'',	'',	1,	'2018-03-14 10:37:16'),
(7,	1,	'tina',	'tina@gmail.com',	'9462110136',	'',	'',	'',	'',	'',	0.00,	0,	'2018-03-14 07:30:14',	1,	'Active',	'',	'',	'',	'sdfvb',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'',	0,	NULL),
(8,	1,	'gopal patel',	'purchase@mogragroup.com',	'9001855886',	'',	'',	'',	'',	'',	12.00,	0,	'2018-03-14 07:31:11',	1,	'Active',	'1312313',	'fwe',	'wfw',	'gops',	'eqdqwd',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'',	0,	NULL),
(9,	1,	'Avinash',	'avinash@yahoo.in',	'77426896290',	'',	'',	'',	'',	'',	2.00,	0,	'2018-03-14 11:39:30',	1,	'Active',	'08ADVPJ5338D1ZB',	'Dinesh ',	'',	'mahaveer generl store',	'lakhara chowk udaipur',	'2018-03-26 18:30:00',	'2018-03-28 18:30:00',	'',	'',	0,	NULL),
(11,	1,	'Shailendra Nagori',	'shelunagori@abc.com',	'9694981008',	'$2y$10$qxtBmJHzlQdg3/VNZNTsLuY7qRtk/7ga9y6WNF5LkRgsqQrQkyGRm',	'',	'',	'',	'',	0.00,	0,	'2018-03-19 14:37:40',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'customer1524732542.png',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjExLCJleHAiOjE1MjU0OTk5MTR9.C3k6DYnPP5PU_aAeFFlr2sMXvaorUPPXRj_pKZLpYX0',	11,	'2018-04-28 05:58:34'),
(13,	0,	'Raja',	'rohit@gmail.com',	'9887779196',	'$2y$10$BvJAe/kzOAJg9LveSWU/.e4k6R/F6kvP/k6CiWrjuMD89.C.TloVC',	'4852',	'',	'',	'',	0.00,	0,	'2018-03-20 11:02:57',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'',	0,	'2018-04-28 13:11:13'),
(14,	0,	'Raja',	'rohit1@gmail.com',	'9887779124',	'$2y$10$I06qC8.EpLLvFYSZ6LckYOVrwiputCscb.srR9vUttCeXi5iHG24G',	'1942',	'',	'',	'',	0.00,	0,	'2018-03-20 11:23:49',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE0LCJleHAiOjE1MjIxNDk4NDd9.6bXaa0bCbHQHOgAU6xgT7dIQZotpUo32udMSNs2pWXI',	0,	'2018-03-20 11:23:49'),
(15,	0,	'Raja',	'rohit12@gmail.com',	'9887779125',	'$2y$10$oz16WTV1FAWIVBLpwF0uR.v2wA9e0Gb9/hakYqV5vYERwDM074tO6',	'2318',	'',	'',	'',	0.00,	0,	'2018-03-20 11:33:05',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE1LCJleHAiOjE1MjIxNTA0MDR9._8c3IfcuCM9XI6CKHpDs8yN9SsiMX7D3LTiYIYqRFTI',	0,	'2018-03-20 11:33:05'),
(16,	0,	'Raja',	'rohit123@gmail.com',	'9887779126',	'$2y$10$OWAv/ajbUu7syDEEW4kntOmkm3mquQO5A/z4h215JfxGAw/WXPoLe',	'6046',	'',	'',	'',	0.00,	0,	'2018-03-20 11:35:58',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE2LCJleHAiOjE1MjIxNTA1NzZ9.z4uiVszZFKlAWNfNnRULBLO6rJhWmDukDOKHT5vJQt4',	0,	'2018-03-20 11:35:58'),
(17,	0,	'Raja',	'rohit18@gmail.com',	'9887779129',	'$2y$10$N2dYoXlTcCI4nh.cufiLTeoaQkvNSbI0y1aNSm7rENoflWP8AX2xy',	'3279',	'',	'',	'',	0.00,	0,	'2018-03-20 11:36:55',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE3LCJleHAiOjE1MjIxNTA2MzR9.e97cgH1BqbM9N2MXhBl72mwfYnIOU-6BHkTCu0IZxVE',	0,	'2018-03-20 11:36:55'),
(18,	0,	'Raja',	'rohit19@gmail.com',	'9887779128',	'$2y$10$AcKaM5bJrM1ejzI2uMxGUeGvXLXTb9Jp6K4b.wJF4seoT.5B/Abye',	'8476',	'',	'',	'',	0.00,	0,	'2018-03-20 11:38:33',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE4LCJleHAiOjE1MjIxNTA3MzF9.oFGRA_oAyZl4U4ai6Fzlc_SInGAaVwrwrvUJTd68Iwc',	0,	'2018-03-20 11:38:33'),
(19,	0,	'Raja',	'rohit63@gmail.com',	'9887779158',	'$2y$10$SpYje70RwTYvX8Mv..YFue5ekHGMphMqDP9TpeDw.cRw.R3cOhcde',	'7255',	'',	'',	'',	0.00,	0,	'2018-03-20 11:39:08',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE5LCJleHAiOjE1MjIxNTA3Njd9.tfOppfS_MyWZvn6zeoxBLjCRpBGq9L1xRH8S7iN4WTM',	0,	'2018-03-20 11:39:09'),
(20,	0,	'Raja',	'rohit62@gmail.com',	'9887779159',	'$2y$10$roK/egbKaBdzRvEoeFN/seiwvh5UzQ2WO8o7GvwDL1NdOjJzyRFxm',	'1050',	'',	'',	'',	0.00,	0,	'2018-03-20 11:39:59',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'',	0,	NULL),
(21,	0,	'Raja',	'rohit862@gmail.com',	'9887774158',	'$2y$10$Mfk2k8OCe.TGZouf.Cd3t.vV60OZSxO.koB5IGZwcv4XpeUtifVRy',	'6785',	'',	'',	'',	0.00,	0,	'2018-03-20 11:45:14',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIxLCJleHAiOjE1MjIxNTExMzJ9.lQtpEuDocjW8BIiZXHZFpxErVaDAZAyuZBFBYNEeBgU',	0,	'2018-03-20 11:45:14'),
(22,	0,	'Raja',	'joshi@gmail.com',	'988777231',	'$2y$10$5PI6JFxY/RzqoaAl2ejJzuiePkr5/gHqh7QEk4a1I.w.zze0Ano/u',	'9867',	'',	'',	'',	0.00,	0,	'2018-03-20 11:47:09',	0,	'',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIyLCJleHAiOjE1MjIxNTEyNDh9.K9Zgkitdp8n0Jy_wprwpc1yTFxBx2dwgbjYLBNf318A',	0,	'2018-03-20 11:47:10'),
(23,	0,	'Raja',	'joshi12@gmail.com',	'988778231',	'$2y$10$zUZF9HOewWrw2UXWP0rD7ufszWvrte5CZ3MoeWB0eDs/9ior6dvXy',	'1683',	'',	'',	'',	0.00,	0,	'2018-03-20 11:49:18',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIzLCJleHAiOjE1MjIxNTEzNzd9.n7ENBqPBfkLM6WXyCFYE0elGOaJKfcXf4Pis_rfSuOw',	0,	'2018-03-20 13:01:51'),
(24,	0,	'rohit',	'abc@phppoets.in',	'887779123',	'$2y$10$fdKztU38STwVoEi6zkSoTe9Dj5q1n/WCmvVG4vxqdLjyqN.qXrnlK',	'1381',	'',	'',	'',	0.00,	0,	'2018-03-21 12:15:41',	0,	'Deactive',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI0LCJleHAiOjE1MjIyMzkzNDF9.2ttNXCOuaCmMWPDdLes-0u1IWwa1TmwkHXnnVGjrQg8',	0,	'2018-03-21 12:15:41'),
(25,	1,	'rohit',	'abcd@phppoets.com',	'8769975294',	'$2y$10$HBlMVrQL7BT2rI5L9GWd8.tQOpL.YLJLQqveKkQUhi51cnpMSzU4G',	'2144',	'',	'',	'',	0.00,	0,	'2018-03-22 06:10:48',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI1LCJleHAiOjE1MjI5MDU3MzF9.xilNXppGIsBuvIUcRrcp7zGWnNyv7OeKYXKYnGD_s1E',	25,	'2018-03-29 05:22:11'),
(26,	0,	'Raja',	'joshi2@gmail.com',	'988778271',	'$2y$10$ItQrmbfO1V/eichAuRonWuj.S884ikPCz5gaPcrfiAXhZwL/76J5e',	'',	'',	'',	'',	0.00,	0,	'2018-03-22 12:39:55',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI2LCJleHAiOjE1MjIzMjcyMTN9.ZJ6FU8u8ST-mDbOtE-UCf5gY_-vtAGs15wdPxYo9EXw',	0,	'2018-03-22 12:39:55'),
(27,	0,	'Raja',	'joshi21@gmail.com',	'988798271',	'$2y$10$VM1TBd2wJrn2k6CtYUeMxOM/bu/jPGdkdBV8IgviDrIUWKAri8u/y',	'',	'',	'',	'',	0.00,	0,	'2018-03-22 12:40:56',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI3LCJleHAiOjE1MjIzMjcyNzR9.wMwsprR4kHbFcndWOUZY3XXq_qa0CKDRGcdmJEGsLdg',	0,	'2018-03-22 12:40:56'),
(28,	1,	'gopesh',	'gopesh@phppoets.in',	'9875641250',	'',	'',	'',	'',	'',	10.00,	0,	'2018-03-24 10:19:34',	1,	'Active',	'',	'',	'',	'',	'',	'2018-02-28 18:30:00',	'2018-03-30 18:30:00',	'',	'',	1,	'2018-03-24 11:30:16'),
(29,	1,	'ashish',	'fds2RH@fg.cv',	'987456123',	'',	'',	'',	'',	'',	0.00,	0,	'2018-03-24 10:24:33',	1,	'Active',	'',	'',	'',	'',	'',	'2018-03-29 18:30:00',	'2018-09-29 18:30:00',	'',	'',	1,	'2018-03-24 10:26:07'),
(30,	0,	'rohit',	'rohituu@phppoets.in',	'9887779741',	'$2y$10$78GXnto6gHahos/Cl4UUtuQ2HlEJzepues3xYoj2BDyAQ7VPvfNt6',	'',	'',	'',	'',	0.00,	0,	'2018-03-24 12:11:49',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMwLCJleHAiOjE1MjI0OTgzMDl9.jNLqkW1xawaIWjrYpPdFS5mrRceNRIl20lOsnxr1u24',	0,	'2018-03-24 12:11:49'),
(31,	0,	'rohit',	'rohit12@phppoets.in',	'9887759741',	'$2y$10$JJi7eDzmnxKcKratiWJR6OYvIHcGKRrUStAXaK/UNSoYSE0udMy4a',	'',	'1123',	'1245555',	'',	0.00,	0,	'2018-03-24 12:13:34',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMxLCJleHAiOjE1MjI0OTg0MzN9.JBTFpbAUsHNR2YX-hvqmdsBjpmqrkkKgT_DFr0Do2uU',	0,	'2018-03-24 12:13:34'),
(32,	0,	'rohit',	'rohit123@phppoets.in',	'9887979123',	'$2y$10$RM80gWGSCvONgYvrgZbCLewf05fQDU9n5xSgG5kwGXaXc3mKBTMSa',	'',	'112345788899',	'12455554333',	'',	0.00,	0,	'2018-03-24 12:15:21',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMyLCJleHAiOjE1MjI0OTg1MjF9.8pZFIkg1NjbSM7lQbZcZyRzkYaGRNxTG0xYs2nkwkO8',	0,	'2018-03-24 12:15:21'),
(33,	1,	'shail',	'cm124@gmail.com',	'9649427857',	'$2y$10$.gpAuaXrq3g4pWV8BtZFUe0XL55tiatmI0..OzyGEPNodOi5g/UXa',	'',	'123',	'',	'',	0.00,	0,	'2018-04-16 07:01:47',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'customer1524831838.jpeg',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMzLCJleHAiOjE1MjU0MzExMjl9.kJMEDQ95eGbXiivXeBuGdzbxZlwi-ApqYjmFGeJkjcc',	33,	'2018-04-27 12:23:58'),
(34,	0,	'Cm',	'Cmdhakar001@Gmail.co',	'964942785',	'$2y$10$ySAS1aOpOlVFYFgeuyEGsu97BHbrauvHXxZydhhGejMw6STVBh7/O',	'',	'123',	'',	'',	0.00,	0,	'2018-04-16 07:26:52',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjM0LCJleHAiOjE1MjQ0Njg0MTJ9.cCiJ-DU9wabn7X_3xRjIg8uI1QVYamafjqt91nutsEY',	0,	'2018-04-16 07:26:52'),
(35,	0,	'Dhakar',	'Cm@gmail.com',	'8852902100',	'$2y$10$UJFDGIsFSiyWP96WY.JvcuYEv1MChYQPYb1xt8FTYOmuEDg0I61gG',	'',	'123',	'',	'',	0.00,	0,	'2018-04-16 11:40:31',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjM1LCJleHAiOjE1MjQ0ODM2MzF9.AcdYekOcmIY67uggOCfRzOauh-kLQY7P4V8GqQir2UE',	0,	'2018-04-16 11:40:31'),
(36,	0,	'Jain',	'Jt@gmail.com',	'9876543210',	'$2y$10$srHfiiAV3elAkX4fH7/Toef1lGAOTHWe7L/j0M.NNb5ueMzdjUUni',	'',	'123',	'',	'',	0.00,	0,	'2018-04-16 11:43:44',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjM2LCJleHAiOjE1MjQ0ODM4MjR9.FWkr-suoq3_RVXQEapHAtP31LtorSUbifgHhNjnN18Y',	0,	'2018-04-16 11:43:44'),
(37,	0,	'Abc',	'Abc@gmail.com',	'1234567890',	'$2y$10$DXOw/4FPbdjyMBuPsCRrSOI/b1/97267t6ubekI7jJ6aldoLq7SXa',	'',	'123',	'',	'',	0.00,	0,	'2018-04-16 11:45:45',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjM3LCJleHAiOjE1MjQ0ODM5NDV9.da3ibzP2ukoO4UsBVNz_ZrkA_kOPkfg7lK0gTY8jF7w',	0,	'2018-04-16 11:45:45'),
(38,	1,	'shail',	'shailu@gmail.com',	'9999999999',	'$2y$10$qh91PXgrlyqt8EaC4kuzAObAShzq3z7TKjMz9lb2/QnDFgp0gihJy',	'',	'123',	'',	'',	0.00,	0,	'2018-04-16 11:49:00',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'customer1524904821.jpeg',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjM4LCJleHAiOjE1MjU1MTE4ODh9.d-WdfPVkElGCsFGi-FCsTbPutv7tf4Ash9l8q8XXqeg',	38,	'2018-04-28 09:18:08'),
(39,	0,	'vaibhav',	'vaibhav@gmail.com',	'8233068030',	'$2y$10$dAueZ/oKoMFq7Z5sF1FUw.C0.TQuKJRcZSY8w66F/lgBAZAejYE7G',	'',	'ebb29e47edfe0d15',	'clStJrjFiko:APA91bG_MNfBXkcTVEHP5QTCg4eX9uQujiN4e2t04IIBTzYxeNl5nAfZofEaS-fe34lI2ym4ty02pNAcdyKUk_UwXUlQOpRA2GQMPKkoOYCOfzldvgkbqRIol2RdBK5f-pp28VKYMzA-',	'',	0.00,	0,	'2018-04-23 12:11:42',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjM5LCJleHAiOjE1MjUwOTAzMDJ9.laQvWk4QRqwadUA63cU2GrTsB9H4f5IqVOmX1Vfydhg',	0,	'2018-04-23 12:11:42'),
(40,	1,	'priyanka jinger',	'priyankajinger@gmail.com',	'9694561206',	'$2y$10$LLJpZ/LunPUzbaQnUbgdjeBMSvVVN5HYhEmfW/TKutTwpbV.84S2S',	'',	'9b82a2608708ea5a',	'dQDW-SptCw8:APA91bGGwHKc34a_bLhty1h5WibNjOAVOF1E7v5sM121WCZIjPJGV82PSRSFUf92ysS8tCiZ_eBX65_h8qpwHnorMT81AF7uk38meoHLYOi54IVW6CamGeXDNOpaVY8gPJZcub0wTgs2',	'',	0.00,	0,	'2018-04-24 05:34:09',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQwLCJleHAiOjE1MjUzMzkxNzJ9.nQZiO4wPt5XctrbMCAxRSOVQcCFp62cGG5wF74TTvbc',	0,	'2018-04-26 09:19:32'),
(41,	0,	'jonty',	'jonty@gmail.com',	'9352823161',	'$2y$10$BEGWv4ves2FvWRzoLV9IfuxMGQSl5XNjAIibHG3KvRbBQkNmjT55y',	'',	'e1b844c197941a95',	'ep6uCInbtL0:APA91bHoLaRK5sQpAQvqD6zHSioKCW5cUfMBAjlU_sIXx3HyxEJqfuSR7auBb83R3za3X_6ktdEUxEL39BM2pQSeqrGLpvw1bYdEPnIiIMInU2EcuBK54-wCA8PmL1LsUhagWluE1vkb',	'',	0.00,	0,	'2018-04-24 11:26:54',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQxLCJleHAiOjE1MjUxNzQwMTR9.mgn53spHYFPzHG-1r3Jq0R-4hr-SN-c67LaSa-8mpgo',	0,	'2018-04-24 11:26:54'),
(43,	0,	'CMdhakar',	'Cmd@gmail.com',	'9116727857',	'$2y$10$AbRhIHmjRCp5q5epjy3w1ukaiTukAuGL6ckvMGkAXa0H/KdkQu5zC',	'',	'123',	'',	'',	0.00,	0,	'2018-04-26 10:46:35',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQzLCJleHAiOjE1MjUzNDQ5ODJ9.DivGEhrSLCaOFn6ip1SSU-KM6JlEBb9djAJp3c53HvA',	0,	'2018-04-26 10:56:22'),
(45,	1,	'vivek bhatt',	'vivekbhatt119@gmail.com',	'9461882490',	'$2y$10$TfitBHQA3z0uoaUfVRY3neyJei6ljlCXQFK4ImcgFiykmHcJoOwOS',	'',	'',	'',	'',	0.00,	0,	'2018-04-27 12:05:09',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQ1LCJleHAiOjE1MjU1MTk3MTR9.P1IusF25c6KoHQPQWAPwLl-E7hoJizMheoo8dlpjz0I',	0,	'2018-04-28 11:28:34'),
(46,	1,	'Rohit Joshi',	'rohit@phppoets.in',	'9887779123',	'$2y$10$MHHDtkYY1V7rmvf.oLVP9.L3nRFowAjFtbjgLfJbuqq2z5WRtIfFi',	'',	'',	'',	'',	0.00,	0,	'2018-04-28 13:11:54',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQ2LCJleHAiOjE1MjU2ODI0ODV9.5nWPzLBeNmg3bBQq3lebJfRJTJumvfBFsaRMYpGDna0',	0,	'2018-04-30 08:41:25');

DROP TABLE IF EXISTS `customer_addresses`;
CREATE TABLE `customer_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `receiver_name` varchar(30) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `city_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `pincode` bigint(100) NOT NULL,
  `house_no` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `landmark` text NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `default_address` tinyint(2) NOT NULL COMMENT '1 for default selected address',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `customer_addresses` (`id`, `customer_id`, `receiver_name`, `gender`, `mobile_no`, `city_id`, `location_id`, `pincode`, `house_no`, `address`, `landmark`, `latitude`, `longitude`, `default_address`, `is_deleted`) VALUES
(1,	11,	'yash',	'male',	'987654321',	1,	1,	313001,	'1',	'sewashram 123 45678',	'php poets',	'21',	'11',	0,	1),
(2,	3,	'',	'',	'',	1,	1,	313001,	'1',	'prstap Colony Badgaon',	'23erfgrfdefg',	'',	'',	0,	0),
(5,	7,	'',	'',	'',	1,	1,	3103001,	'1',	'sdfgb',	'sdfvbvb',	'',	'',	0,	0),
(6,	8,	'',	'',	'',	1,	1,	12312312,	'd12e21',	'f23r32r2',	'ed32331',	'123123',	'213213',	0,	0),
(13,	4,	'',	'',	'',	1,	1,	98765,	'30',	'erdtfyghkjlk',	'wertyyuii',	'',	'',	0,	0),
(14,	4,	'',	'',	'',	1,	1,	3245,	'qwertgh',	'wertyujk,',	'qwertyujk',	'',	'',	0,	0),
(15,	11,	'',	'',	'',	1,	1,	8765,	'1',	'pratp colony badgaon',	'aefgn',	'',	'',	0,	1),
(26,	29,	'',	'',	'',	1,	1,	321,	'20',	'ftyuio',	'r5678o',	'',	'',	1,	0),
(29,	28,	'',	'',	'',	1,	1,	313001,	'1',	'w4ertrytuyiuio;',	'2q34retyjkj,.',	'',	'',	0,	0),
(30,	28,	'',	'',	'',	1,	1,	313001,	'2',	'wertytuiui;',	'ertyuio',	'',	'',	1,	0),
(33,	11,	'yash',	'male',	'987654321',	1,	1,	313001,	'1',	'sewashram 123 45678',	'php poets',	'',	'',	0,	1),
(37,	11,	'yash',	'male',	'987654321',	1,	1,	0,	'1',	'sewashram 123 45678',	'php poets',	'',	'',	0,	1),
(38,	11,	'yash',	'male',	'987654321',	1,	1,	0,	'1',	'sewashram 123 45678',	'php poets',	'',	'',	0,	1),
(39,	11,	'yash',	'male',	'987654321',	1,	1,	0,	'1',	'sewashram 123 45678',	'php poets',	'',	'',	0,	1),
(40,	11,	'abc',	'Female',	'1234567890',	1,	1,	0,	'123',	'ejjesjjd',	'sevasharam',	'21',	'11',	0,	1),
(41,	11,	'abc',	'Female',	'1234567890',	1,	1,	0,	'123',	'ejjesjjd',	'sevasharam',	'21',	'11',	0,	1),
(42,	11,	'shgwje',	'Male',	'4646645549',	1,	1,	0,	'1355',	'gwethtw',	'sevasharam',	'21',	'11',	0,	1),
(43,	11,	'yash',	'male',	'987654321',	1,	1,	313001,	'1',	'sewashram 123 45678',	'php poets',	'',	'',	0,	1),
(44,	25,	'Vaibhav',	'',	'9352823161',	1,	1,	0,	'302',	'Kothari complex',	'near canera bank ',	'21',	'11',	0,	0),
(45,	25,	'jonty',	'Male',	'9352823161',	1,	1,	0,	'hn',	'gbbh',	'bbjj',	'21',	'11',	0,	0),
(46,	11,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram 123 45678',	'php poets',	'21',	'11',	0,	1),
(47,	11,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram 123 45678',	'php poets',	'21',	'11',	0,	1),
(48,	25,	'test',	'Male',	'9352823161',	1,	1,	0,	'HD hch',	'fhc',	'hcj',	'21',	'11',	0,	0),
(49,	25,	'test',	'Male',	'8899550085',	1,	1,	0,	'chhh',	'ghcx',	'cfghj',	'21',	'11',	0,	0),
(50,	25,	'yx',	'Male',	'4585828688',	1,	1,	0,	'Ha cy',	'in if u',	'tct',	'21',	'11',	0,	0),
(51,	25,	'yx',	'Male',	'4585828688',	1,	1,	0,	'Ha cy',	'in if u',	'tct',	'21',	'11',	1,	0),
(52,	11,	'Vaibhav',	'',	'9352823161',	1,	2,	0,	'12',	'Phppoets it solutions pvt ltd near passport office',	'near passport office ',	'121',	'2',	0,	1),
(53,	11,	'wxtz',	'',	'1234567890',	1,	1,	0,	'aghwgwe',	'dbhshx+_#?&!&?-#?&-?-!\'!_;!_;?_;?_;_;?;?_;?_?_+!!_;',	'sgsbsgbs',	'21',	'11',	0,	1),
(54,	11,	'wxtz',	'',	'1234567890',	1,	1,	0,	'aghwgwe',	'dbhshx+_#?&!&?-#?&-?-!\'!_;!_;?_;?_;_;?;?_;?_?_+!!_;',	'sgsbsgbs',	'21',	'11',	0,	1),
(55,	11,	'tjehr',	'',	'5223296262',	1,	1,	0,	'the to ntng',	'to b Ed f we rjrjrbrabfanfxs see bxbejegbsgbegbebeegbeg',	'gntt to t',	'21',	'11',	0,	1),
(56,	11,	'ccsbdb',	'',	'5645511848',	1,	2,	0,	'dvdff',	'svdvvdbfff',	'cffffb',	'121',	'2',	0,	1),
(57,	11,	'if ngym',	'',	'5995525665',	1,	1,	0,	'frngnt',	'etef',	'dgbe r eg',	'21',	'11',	0,	1),
(58,	11,	'tkgj',	'Female',	'2555555622',	1,	2,	0,	'fnnffffjfnf',	'fndnfnfngn',	'fnfgntj',	'121',	'2',	0,	1),
(59,	38,	'cm',	'',	'9699999999',	1,	1,	0,	'1',	'thoakr',	'thokar',	'21',	'11',	1,	0),
(60,	39,	'vaibhav',	'',	'9352823161',	1,	2,	0,	'test',	'test',	'test',	'121',	'2',	1,	0),
(61,	33,	'Cm',	'',	'',	1,	0,	0,	'',	'',	'',	'',	'',	0,	1),
(62,	33,	'Cm',	'',	'',	1,	0,	0,	'',	'',	'',	'',	'',	0,	1),
(63,	33,	'yash',	'Male',	'987654321',	1,	1,	313001,	'1',	'sewashram',	'php poets',	'',	'',	0,	0),
(64,	33,	'Uhb',	'Male',	'',	1,	0,	0,	'',	'',	'',	'',	'',	0,	1),
(65,	33,	'Uhb',	'Male',	'',	1,	0,	0,	'',	'',	'',	'',	'',	0,	1),
(66,	33,	'Uhb',	'Male',	'',	1,	0,	0,	'',	'',	'',	'',	'',	0,	1),
(67,	33,	'Uhb',	'Male',	'',	1,	0,	0,	'',	'',	'',	'',	'',	0,	1),
(68,	33,	'Cm',	'Male',	'1234567890',	1,	0,	0,	'123',	'Pratapnagar',	'Design heights ',	'',	'',	0,	1),
(69,	33,	'Cm',	'Male',	'1234567890',	1,	0,	0,	'12e',	'Prtapnagar',	'Rto',	'',	'',	0,	1),
(70,	33,	'Cmdhakar',	'0',	'1234567890',	1,	0,	0,	'12e',	'Prtapnagar',	'Rto',	'',	'',	0,	1),
(71,	33,	'Cmd',	'Male',	'1234567890',	1,	2,	0,	'123abc',	'Prtapnagar ',	'Rto',	'',	'',	0,	1),
(72,	33,	'Angel',	'Female',	'1234567890',	1,	2,	0,	'A51',	'Sector4',	'Bsnl',	'',	'',	0,	1),
(73,	33,	'Cm dhakar',	'Male',	'1234567890',	1,	2,	0,	'1',	'Subhash nagar',	'Passport office ',	'',	'',	0,	0),
(74,	33,	'',	'0',	'',	1,	0,	0,	'',	'',	'',	'',	'',	0,	1),
(75,	33,	'Cmdhakar',	'Male',	'',	1,	0,	0,	'',	'',	'',	'',	'',	0,	1),
(76,	1,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram 123 45678',	'php poets',	'',	'',	0,	0),
(77,	1,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram 1',	'php poets',	'',	'',	0,	0),
(78,	1,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram 1',	'php poets',	'',	'',	0,	0),
(79,	1,	'Cm',	'Male',	'1234567890',	1,	1,	0,	'111',	'Abc',	'Kxjxnxb',	'',	'',	0,	0),
(80,	1,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram',	'php poets',	'',	'',	0,	0),
(81,	1,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram',	'php poets',	'',	'',	0,	0),
(82,	1,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram',	'php poets',	'',	'',	0,	0),
(83,	1,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram',	'php poets',	'',	'',	0,	0),
(84,	1,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram',	'php',	'',	'',	0,	0),
(85,	1,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram',	'php',	'',	'',	0,	0),
(86,	1,	'yash',	'Male',	'987654321',	1,	1,	0,	'1',	'sewashram',	'php',	'',	'',	0,	0),
(87,	1,	'Cm',	'Male',	'1234567890',	1,	1,	0,	'Abc6',	'Abc',	'Abc',	'',	'',	0,	0),
(88,	11,	'wtdh',	'',	'75545754',	1,	2,	0,	'xnfhdfn',	'cnfnxgz',	'xbgsbffn',	'121',	'2',	0,	1),
(89,	11,	'djdjj',	'',	'8956589895',	1,	2,	0,	'ha hdhdj',	'bdbdbsbdb',	'ndndj',	'121',	'2',	0,	1),
(90,	11,	'do dvdbfb',	'Female',	'5559999995',	1,	1,	0,	'bdhddj',	'bdbd',	'hdhdj',	'21',	'11',	1,	0),
(91,	11,	'vaibhav',	'',	'9352823161',	1,	1,	0,	'12',	'test',	'Sevashram ',	'21',	'11',	0,	0);

DROP TABLE IF EXISTS `debit_notes`;
CREATE TABLE `debit_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `debit_note_rows`;
CREATE TABLE `debit_note_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `debit_note_id` int(11) NOT NULL,
  `cr_dr` varchar(10) NOT NULL,
  `ledger_id` int(10) NOT NULL,
  `debit` decimal(15,2) DEFAULT NULL,
  `credit` decimal(15,2) DEFAULT NULL,
  `mode_of_payment` varchar(30) NOT NULL,
  `cheque_no` varchar(30) NOT NULL,
  `cheque_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `delivery_charges`;
CREATE TABLE `delivery_charges` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `charge` decimal(10,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `delivery_charges` (`id`, `city_id`, `amount`, `charge`, `status`, `created_on`, `created_by`) VALUES
(1,	4,	100.00,	50.00,	'Normal',	'2017-06-23 04:40:12',	1),
(2,	2,	300.00,	50.00,	'Active',	'2018-03-14 10:52:51',	1),
(3,	1,	500.00,	30.00,	'Active',	'2018-03-14 11:01:45',	1),
(4,	1,	800.00,	20.00,	'Deactive',	'2018-04-27 05:46:03',	1);

DROP TABLE IF EXISTS `delivery_dates`;
CREATE TABLE `delivery_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `same_day` varchar(10) NOT NULL DEFAULT 'Active',
  `next_day` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `delivery_dates` (`id`, `city_id`, `same_day`, `next_day`, `status`) VALUES
(1,	1,	'Active',	3,	'Active');

DROP TABLE IF EXISTS `delivery_times`;
CREATE TABLE `delivery_times` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `time_from` varchar(15) NOT NULL,
  `time_to` varchar(15) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `delivery_times` (`id`, `city_id`, `time_from`, `time_to`, `status`) VALUES
(1,	1,	'10:00 am',	'01:00 pm',	'Active'),
(2,	1,	'01:00 pm',	'04:00 pm',	'Active'),
(3,	1,	'04:00 pm',	'07:00 pm',	'Active'),
(4,	1,	'9:00 AM',	'3:00 AM',	'Deactive');

DROP TABLE IF EXISTS `drivers`;
CREATE TABLE `drivers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `location_id` int(10) NOT NULL,
  `device_token` text NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `supplier_type` varchar(20) NOT NULL DEFAULT 'jainthela',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `drivers` (`id`, `name`, `user_name`, `password`, `mobile_no`, `location_id`, `device_token`, `latitude`, `longitude`, `supplier_type`) VALUES
(1,	'Jainthela',	'jain',	'bf76b73579ee889af8815b497e5c6bbe',	'8233334988',	1,	'fZD12x0OGgc:APA91bF4Vy0OuWGYcKLF9PuH-i9vgc-Dv6vxFvkLvcHzRdH62v8JoGIAJiiCYy3c13-0fRuB4gjShofk7Hr1sRflhneuzWsGeuuFJAHqoCgMUSBKByieaQ_w4foZFDtpLZCKNAAniT9M',	'24.5832109',	'73.7220595',	'jainthela'),
(3,	'Mukesh',	'9116138309',	'3bce4bb5d9664d0cdbdebb659a2846be',	'9116138309',	1,	'e57u8GmleWk:APA91bGK-TvUQgm1iYk2yetnMLRcjF6Pf3OoXP2wG9pHIqri9CyYs9bkuryBEfHA4vZPES2j1k_raJ_od84pdqPlw8OqhibFoWC8iARYU8WZfWdKUrnbP4Db0-j_pvnhLKbAsyBziaS5',	'24.59944128849224',	'73.74629461262217',	'jainthela'),
(4,	'Omprakash',	'9116138306',	'71d47b98e54bb00d0d3cfd01655cdbe5',	'9116138306',	1,	'c55cc60KS7s:APA91bFe7gYhQEtOdmvBOJt4A4E6MFIC5A9nJ77QY4355hiq_Fsna8wqEjLmMyaYjPodICH_1gLYThvw1G10RWUHRG1eHOg0ZOYPRyO1RxlTSTnRCPCp5x-K4P9J3vySXoc0tArpoM1p',	'24.5893889',	'73.7319605',	'jainthela'),
(5,	'Rajkumar',	'9116138308',	'eda30fb0bc9402cd26e6b1c2b5e3414a',	'9116138308',	1,	'cHj1eqZU72c:APA91bF_rS1fQoBXTF9NklYIi_m1waTXQPTRoK7WIUXxMcwLERrJyY5_6-wzKIcEbt8B8lLEJ8W5d8oE38BQ209fe_VSbbmczVj_fA-Hvm2VMFyLPuFYuL5sHShhh_dR2WCsEs-dV3is',	'24.5841984',	'73.6865467',	'jainthela'),
(6,	'Manish Mishra',	'302',	'577bcc914f9e55d5e4e4f82f9f00e7d4',	'9116138302',	1,	'cSnEWhAKaz4:APA91bFQu0Rhf7zMoxtiVVxle6Yzqbp-lYYeebZe5KPppW7admAyJRC9rdjoacSq8254T6tfd0QnrLy2iWuEWqzLjaL5PyFIw2Svx-7VcmwXbh91HJ7cLOcJSaU2ymQ3zByfc81YIwSr',	'24.5991378',	'73.7461653',	'jainthela'),
(7,	'narendra singh',	'9116138307',	'ec895a564d707ee4a7c18f1e611f83ab',	'9116138307',	1,	'cm7OxQD00Hg:APA91bGf895ED3En1MSiVXKW1VaeJ0kQFb5kDZkvnCNlumqeY0MIEpxLezhf6O2KG5UCY7BB4Gw1aubf9vU4oPiWWm7rBt0ip0I-oH-sJ-2IuT-tXXgySMM2GEkSfmpV41kBupth1037',	'24.591910871440227',	'73.70019295718284',	'jainthela'),
(9,	'heera lal',	'9116138303',	'c8837b23ff8aaa8a2dde915473ce0991',	'9116138303',	1,	'AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU',	'24.5950658',	'73.7424533',	'jainthela');

DROP TABLE IF EXISTS `driver_locations`;
CREATE TABLE `driver_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `drive_id` int(11) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `express_deliveries`;
CREATE TABLE `express_deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `icon_web` varchar(50) NOT NULL,
  `content_data` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `city_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `express_deliveries` (`id`, `title`, `icon`, `icon_web`, `content_data`, `status`, `city_id`) VALUES
(1,	'Express Delivery',	'express_delivery/1/app/express1524725131.png',	'express_delivery/1/web/express1524725131.png',	'Get express ',	'Active',	1),
(2,	'Test1',	'express_delivery/2/app/express1524725103.png',	'express_delivery/2/web/express1524725103.png',	'Testings1',	'Active',	1),
(3,	'Test',	'express_delivery/3/app/express1524724939.png',	'express_delivery/3/web/express1524724939.png',	'Testings',	'Active',	2);

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `faqs` (`id`, `city_id`, `question`, `answer`, `status`) VALUES
(1,	1,	'When does Jainthela deliver',	'Your product will be delivered upto 3 hours from the time of placing the order',	0),
(2,	1,	'Can I cancel my order ?',	'Yes ',	0),
(3,	2,	'How to change my location?',	'In my setting option change addres.',	1),
(4,	1,	'abc>?',	'DEF',	1),
(5,	1,	'What is the return process?',	'Please read our Return Policy.',	0);

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `comment` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `feedbacks` (`id`, `customer_id`, `city_id`, `name`, `email`, `mobile_no`, `comment`, `created_on`) VALUES
(1,	1,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 12:27:59'),
(2,	1,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 12:45:26'),
(3,	1,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 12:45:42'),
(4,	1,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 12:46:56'),
(5,	10,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 12:47:12'),
(6,	10,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 12:54:54'),
(7,	10,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 12:57:42'),
(8,	1,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 12:59:23'),
(9,	1,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 12:59:46'),
(10,	1,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 13:00:09'),
(11,	10,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-21 13:01:42'),
(12,	10,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-22 06:39:44'),
(13,	25,	1,	'rohit',	'abcd@phppoets.in',	'8769975294',	'hello',	'2018-03-22 06:49:35'),
(14,	25,	1,	'rohit',	'abcd@phppoets.in',	'8769975294',	'hello',	'2018-03-22 06:51:16'),
(15,	10,	1,	'Rohit',	'rohit@phppoets.in',	'9887779123',	'hello',	'2018-03-22 06:53:03'),
(16,	25,	1,	'rohit',	'abcd@phppoets.in',	'8769975294',	'hello hjkl',	'2018-03-22 07:02:21'),
(17,	25,	1,	'rohit',	'abcd@phppoets.in',	'8769975294',	'hello hjkl mnm,nm',	'2018-03-22 07:02:29'),
(18,	25,	1,	'rohit',	'abcd@phppoets.in',	'8769975294',	'hello hjkl mnm,nm,m,.m',	'2018-03-22 07:02:36'),
(19,	25,	1,	'rohit',	'abcd@phppoets.in',	'8769975294',	'hello hjkl mnm,nm,m,.m',	'2018-03-22 07:39:39'),
(20,	11,	1,	'Shailendra Nagori',	'shelunagori@abc.com',	'9694981008',	'nice app',	'2018-04-02 13:07:43'),
(21,	11,	1,	'Shailendra Nagori',	'shelunagori@gmail.com',	'9694981008',	'rhytej',	'2018-04-07 06:41:16'),
(22,	11,	1,	'Shailendra Nagori',	'shelunagori@gmail.com',	'9694981008',	'ssss\n',	'2018-04-07 08:55:30'),
(23,	11,	1,	'Shailendra Nagori',	'shelunagori@gmail.com',	'9694981008',	' df dv',	'2018-04-11 09:52:56'),
(24,	11,	1,	'Shailendra Nagori',	'shelunagori@gmail.com',	'9694981008',	' r of tyn',	'2018-04-11 10:28:54'),
(25,	33,	1,	'rohit',	'rohit@gmail.com',	'9887779123',	'hello',	'2018-04-21 10:16:59'),
(26,	33,	1,	'Shailendra Nagori',	'shelunagori@abc.com',	'9649427857',	'nsnsns',	'2018-04-24 10:29:10'),
(27,	1,	1,	'rohit',	'rohit@gmail.com',	'9887779123',	'hello',	'2018-04-25 08:50:43'),
(28,	1,	1,	'pinu',	'rohit@gmail.com',	'9887779123',	'hello',	'2018-04-25 09:05:35'),
(29,	1,	1,	'pinu',	'rohit@gmail.com',	'98844',	'hello',	'2018-04-25 09:05:46'),
(30,	1,	1,	'pinu',	'rohit@gmail.com',	'98844',	'hello',	'2018-04-25 09:21:57'),
(31,	1,	1,	'priyanka',	'priyankajinger0@gmail.com',	'9694561206',	'test',	'2018-04-25 09:38:38'),
(32,	1,	1,	'priyanka',	'priyankajinger0@gmail.com',	'9694561206',	'test',	'2018-04-25 09:38:52'),
(33,	1,	1,	'priyanka',	'priyankajinger0@gmail.com',	'9694561206',	'test',	'2018-04-25 09:40:07'),
(34,	1,	1,	'vivek',	'vivek@gmail.com',	'123456789',	'start',	'2018-04-25 09:59:35');

DROP TABLE IF EXISTS `filters`;
CREATE TABLE `filters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `filters` (`id`, `name`, `status`) VALUES
(1,	'Category',	0),
(2,	'Discount',	0),
(3,	'Price',	0),
(4,	'Brand',	0);

DROP TABLE IF EXISTS `financial_years`;
CREATE TABLE `financial_years` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fy_from` date NOT NULL,
  `fy_to` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `financial_years` (`id`, `fy_from`, `fy_to`, `status`, `company_id`) VALUES
(1,	'2017-04-01',	'2018-03-31',	'open',	1),
(2,	'2017-04-01',	'2018-03-31',	'open',	2),
(3,	'2017-04-01',	'2018-03-31',	'open',	3);

DROP TABLE IF EXISTS `grns`;
CREATE TABLE `grns` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL,
  `voucher_no` int(10) NOT NULL,
  `grn_no` varchar(100) NOT NULL,
  `location_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `total_taxable_value` decimal(15,2) NOT NULL,
  `total_gst` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `grn_rows`;
CREATE TABLE `grn_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `taxable_value` decimal(15,2) NOT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  `gst_percentage` int(10) NOT NULL,
  `gst_value` decimal(10,2) NOT NULL,
  `purchase_rate` decimal(15,2) NOT NULL,
  `sales_rate` decimal(15,2) NOT NULL,
  `gst_type` varchar(100) NOT NULL,
  `mrp` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `gst_figures`;
CREATE TABLE `gst_figures` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location_id` int(10) NOT NULL,
  `tax_percentage` decimal(5,2) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL COMMENT 'active or deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `gst_figures` (`id`, `name`, `location_id`, `tax_percentage`, `created_by`, `created_on`, `status`) VALUES
(1,	'0%',	1,	0.00,	0,	'2018-03-15 06:22:45',	''),
(2,	'5%',	1,	5.00,	0,	'2018-03-15 06:22:45',	''),
(3,	'12%',	1,	12.00,	0,	'2018-03-15 06:22:45',	''),
(4,	'18%',	1,	18.00,	0,	'2018-03-15 06:22:45',	''),
(5,	'28%',	1,	28.00,	0,	'2018-03-15 06:22:45',	'');

DROP TABLE IF EXISTS `home_screens`;
CREATE TABLE `home_screens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `layout` varchar(50) NOT NULL,
  `section_show` varchar(10) NOT NULL,
  `preference` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `screen_type` varchar(15) NOT NULL,
  `model_name` varchar(30) NOT NULL,
  `city_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link_name` varchar(255) NOT NULL,
  `web_preference` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `home_screens` (`id`, `title`, `layout`, `section_show`, `preference`, `category_id`, `screen_type`, `model_name`, `city_id`, `image`, `link_name`, `web_preference`) VALUES
(1,	'Express Delivery',	'rectangle',	'Yes',	5,	0,	'Home',	'ExpressDeliveries',	1,	'',	'',	7),
(2,	'Brand Store',	'circle',	'Yes',	2,	0,	'Home',	'Brands',	1,	'',	'',	6),
(3,	'Dry Fruits',	'horizontal',	'Yes',	3,	1,	'Home',	'Category',	1,	'',	'category_wise',	5),
(4,	'Medicin',	'horizontal',	'Yes',	4,	1,	'Home',	'Category',	1,	'',	'',	8),
(5,	'Other Releted Items',	'horizontal',	'Yes',	1,	0,	'Product Detail',	'Items',	1,	'',	'',	9),
(6,	'Banner',	'banner',	'Yes',	1,	0,	'Home',	'Banners',	1,	'',	'',	1),
(7,	'Store Directory',	'store directory',	'Yes',	6,	0,	'Home',	'SubCategory',	1,	'',	'',	3),
(8,	'Shop By Category',	'horizental',	'Yes',	7,	0,	'Home',	'MainCategory',	1,	'',	'category_wise',	4),
(9,	'Tie Image',	'tie up',	'Yes',	8,	0,	'Home',	'Combooffer',	1,	'',	'',	10),
(10,	'Single Image & two Item',	'Single Image & two Item',	'Yes',	9,	1,	'Home',	'Categorytwoitem',	1,	'image',	'',	11),
(11,	'Combo offers',	'combo_offer',	'Yes',	8,	0,	'Home',	'Combooffer',	1,	'',	'item_wise_combo',	2);

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL COMMENT 'For seller Information which create item',
  `city_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `alias_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `minimum_stock` decimal(10,2) NOT NULL COMMENT 'for notification item is below  to range please purchase',
  `next_day_requirement` decimal(10,2) NOT NULL,
  `request_for_sample` varchar(10) NOT NULL DEFAULT 'No',
  `default_grade` varchar(20) NOT NULL,
  `tax` decimal(6,2) NOT NULL,
  `gst_figure_id` int(11) NOT NULL,
  `item_maintain_by` varchar(50) NOT NULL COMMENT 'item maintain by main item id or item variation id',
  `out_of_stock` varchar(5) NOT NULL DEFAULT 'Yes' COMMENT 'For Item which are available or not. Yes or No',
  `ready_to_sale` varchar(5) NOT NULL DEFAULT 'No' COMMENT 'Item which are ready for sale.. Yes or No',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `approve` varchar(15) NOT NULL DEFAULT 'Pending' COMMENT 'Pending/Approved/Not Approved, By default Pending',
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  `section_show` varchar(10) NOT NULL COMMENT 'Show Item For App',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `items` (`id`, `category_id`, `admin_id`, `seller_id`, `city_id`, `brand_id`, `name`, `alias_name`, `description`, `minimum_stock`, `next_day_requirement`, `request_for_sample`, `default_grade`, `tax`, `gst_figure_id`, `item_maintain_by`, `out_of_stock`, `ready_to_sale`, `created_on`, `edited_on`, `approve`, `status`, `section_show`) VALUES
(1,	1,	0,	2,	1,	1,	'Lady Fingure',	'Bhindi',	'Testing',	20.00,	0.00,	'No',	'',	0.00,	1,	'itemwise',	'Yes',	'Yes',	'2018-04-26 10:25:48',	'2018-04-28 11:22:13',	'Approved',	'Active',	'Yes'),
(2,	1,	0,	2,	1,	1,	'Tomato',	'tmatar',	'Testing',	20.00,	0.00,	'No',	'',	0.00,	1,	'itemwise',	'Yes',	'Yes',	'2018-04-26 10:25:48',	'2018-04-28 11:22:23',	'Approved',	'Active',	'Yes'),
(3,	1,	0,	2,	1,	5,	'Potato',	'aalu',	'garib ki sabji',	10.00,	0.00,	'No',	'',	0.00,	4,	'itemwise',	'Yes',	'No',	'2018-04-28 07:15:29',	'2018-04-28 11:22:30',	'Pending',	'Active',	'Yes'),
(4,	6,	0,	0,	1,	0,	'Banan',	'Banana',	'',	5.00,	0.00,	'No',	'',	0.00,	1,	'variationwise',	'Yes',	'No',	'2018-04-30 06:55:20',	'0000-00-00 00:00:00',	'Pending',	'Active',	'Yes'),
(5,	6,	0,	0,	1,	0,	'Banana',	'Banana',	'',	5.00,	0.00,	'No',	'',	0.00,	1,	'variationwise',	'Yes',	'No',	'2018-04-30 07:05:58',	'0000-00-00 00:00:00',	'Pending',	'Active',	'Yes'),
(6,	0,	0,	0,	1,	1,	'loki',	'loki',	'2',	2.00,	0.00,	'No',	'',	0.00,	1,	'itemwise',	'Yes',	'No',	'2018-04-30 07:09:51',	'0000-00-00 00:00:00',	'Pending',	'Active',	'No'),
(7,	1,	0,	0,	1,	0,	'ginger',	'ginger',	'',	0.00,	0.00,	'No',	'',	0.00,	1,	'itemwise',	'Yes',	'No',	'2018-04-30 07:11:23',	'0000-00-00 00:00:00',	'Pending',	'Active',	'No'),
(8,	5,	0,	0,	1,	0,	'Mango',	'Mango',	'Mango',	5.00,	0.00,	'No',	'',	0.00,	1,	'variationwise',	'Yes',	'No',	'2018-04-30 09:46:28',	'0000-00-00 00:00:00',	'Pending',	'Active',	'Yes');

DROP TABLE IF EXISTS `item_ledgers`;
CREATE TABLE `item_ledgers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_id` int(10) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  `is_opening_balance` varchar(10) DEFAULT NULL,
  `sale_rate` decimal(15,2) DEFAULT NULL,
  `purchase_rate` decimal(10,2) NOT NULL,
  `sales_invoice_id` int(10) NOT NULL,
  `sales_invoice_row_id` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `credit_note_id` int(11) NOT NULL,
  `credit_note_row_id` int(11) NOT NULL,
  `sale_return_id` int(11) DEFAULT NULL,
  `sale_return_row_id` int(11) DEFAULT NULL,
  `grn_id` int(11) NOT NULL,
  `grn_row_id` int(11) NOT NULL,
  `purchase_invoice_id` int(11) DEFAULT NULL,
  `purchase_invoice_row_id` int(11) DEFAULT NULL,
  `purchase_return_id` int(11) DEFAULT NULL,
  `purchase_return_row_id` int(11) DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `entry_from` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `item_review_ratings`;
CREATE TABLE `item_review_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `item_review_ratings_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `item_review_ratings_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `item_review_ratings` (`id`, `item_id`, `customer_id`, `rating`, `comment`, `status`, `created_on`) VALUES
(16,	10,	13,	4.0,	'dfdf',	0,	'2018-04-03 06:23:23'),
(17,	10,	13,	5.0,	'dfdf',	0,	'2018-04-03 06:22:52'),
(18,	10,	11,	4.4,	'rview testing',	0,	'2018-04-02 12:40:56'),
(19,	2,	11,	1.4,	'rview testing',	0,	'2018-04-02 12:41:13'),
(20,	3,	11,	1.4,	'rview testing',	0,	'2018-04-02 12:41:28'),
(21,	3,	13,	1.4,	'',	0,	'0000-00-00 00:00:00'),
(22,	4,	11,	1.4,	'rview testing',	0,	'0000-00-00 00:00:00'),
(23,	10,	8,	2.5,	'dfdf',	0,	'2018-04-02 12:41:51'),
(24,	10,	9,	3.0,	'fsdfds',	0,	'2018-04-02 12:42:06'),
(26,	10,	11,	5.0,	'Test',	0,	'2018-04-03 09:59:47'),
(27,	1,	11,	3.5,	'',	0,	'2018-04-03 10:29:14'),
(28,	1,	33,	3.0,	'',	0,	'2018-04-20 08:44:28'),
(29,	8,	33,	3.0,	'kmnnnmmm',	0,	'2018-04-23 04:58:36'),
(30,	1,	38,	2.0,	'rview testing',	0,	'2018-04-24 09:21:22'),
(31,	10,	38,	3.0,	'vvbbbvcffghh',	0,	'2018-04-24 09:27:29');

DROP TABLE IF EXISTS `item_variations`;
CREATE TABLE `item_variations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `unit_variation_id` int(11) NOT NULL,
  `item_variation_master_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `current_stock` decimal(15,2) NOT NULL,
  `purchase_rate` decimal(10,2) NOT NULL,
  `print_rate` decimal(10,2) NOT NULL COMMENT 'for display and cross price',
  `discount_per` decimal(6,2) NOT NULL COMMENT 'For Given discount on item in percentage',
  `commission` decimal(5,2) NOT NULL,
  `sales_rate` decimal(10,2) NOT NULL COMMENT 'For Display rate after discount',
  `mrp` decimal(15,2) NOT NULL,
  `maximum_quantity_purchase` int(10) NOT NULL,
  `out_of_stock` varchar(5) NOT NULL DEFAULT 'Yes' COMMENT 'For Item which are available or not. Yes or No',
  `ready_to_sale` varchar(5) NOT NULL DEFAULT 'No' COMMENT 'Item which are ready for sale.. Yes or No',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_on` date NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Deactive' COMMENT 'Active or Deactive',
  `section_show` varchar(10) NOT NULL COMMENT 'Iteam show for app screen ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `item_variations` (`id`, `item_id`, `unit_variation_id`, `item_variation_master_id`, `seller_id`, `current_stock`, `purchase_rate`, `print_rate`, `discount_per`, `commission`, `sales_rate`, `mrp`, `maximum_quantity_purchase`, `out_of_stock`, `ready_to_sale`, `created_on`, `update_on`, `status`, `section_show`) VALUES
(20,	1,	7,	3,	2,	50.00,	0.00,	0.00,	0.00,	100.00,	0.00,	0.00,	1,	'Yes',	'Yes',	'2018-04-27 12:12:09',	'0000-00-00',	'Active',	'Yes'),
(21,	1,	1,	1,	2,	50.00,	0.00,	0.00,	0.00,	100.00,	0.00,	0.00,	2,	'Yes',	'Yes',	'2018-04-27 12:12:09',	'0000-00-00',	'Deactive',	'Yes'),
(22,	1,	4,	2,	2,	50.00,	0.00,	0.00,	0.00,	100.00,	0.00,	0.00,	3,	'Yes',	'Yes',	'2018-04-27 12:12:09',	'0000-00-00',	'Deactive',	'Yes');

DROP TABLE IF EXISTS `item_variation_masters`;
CREATE TABLE `item_variation_masters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `unit_variation_id` int(11) NOT NULL,
  `item_image` varchar(50) NOT NULL,
  `item_image_web` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_on` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  `status` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `item_variation_masters` (`id`, `item_id`, `unit_variation_id`, `item_image`, `item_image_web`, `created_on`, `edited_on`, `created_by`, `edited_by`, `status`) VALUES
(1,	1,	1,	'item/1/app/item1524738347.jpeg',	'item/1/web/item1524738347.jpeg',	'2018-04-26 10:25:49',	'2018-04-28 12:11:06',	1,	0,	'Active'),
(2,	1,	4,	'item/2/app/item1524738350.png',	'item/2/web/item1524738350.png',	'2018-04-26 10:25:52',	'2018-04-28 12:11:06',	1,	0,	'Active'),
(3,	1,	7,	'item/3/app/item1524738352.png',	'item/3/web/item1524738352.jpg',	'2018-04-26 10:25:54',	'2018-04-28 12:11:06',	1,	0,	'Active'),
(4,	3,	1,	'item/4/app/item1524899715.jpeg',	'item/4/web/item1524899715.jpeg',	'2018-04-28 07:15:31',	'2018-04-28 12:11:06',	1,	0,	'Active'),
(5,	3,	2,	'item/5/app/item1524918284.jpeg',	'item/5/web/item1524918284.jpeg',	'2018-04-28 07:15:46',	'2018-04-28 12:25:02',	1,	0,	'Active'),
(13,	3,	3,	'item/13/app/item1524918397.jpeg',	'item/13/web/item1524918397.jpeg',	'2018-04-28 11:46:02',	'2018-04-28 12:26:56',	1,	0,	'Active'),
(14,	3,	4,	'item/14/app/item1524918347.jpeg',	'item/14/web/item1524918347.jpeg',	'2018-04-28 12:26:03',	'2018-04-28 12:26:08',	1,	0,	'Active'),
(15,	4,	1,	'item/14/app/item1524918347.jpeg',	'item/14/app/item1524918347.jpeg',	'2018-04-30 06:55:20',	'2018-04-30 07:32:19',	1,	0,	'Active'),
(16,	5,	1,	'item/14/app/item1524918347.jpeg',	'item/14/app/item1524918347.jpeg',	'2018-04-30 07:05:58',	'2018-04-30 07:32:26',	1,	0,	'Active'),
(17,	6,	1,	'item/17/app/item1525072191.jpeg',	'item/17/web/item1525072191.jpeg',	'2018-04-30 07:09:52',	'2018-04-30 07:09:54',	1,	0,	'Active'),
(18,	7,	1,	'item/14/app/item1524918347.jpeg',	'item/14/app/item1524918347.jpeg',	'2018-04-30 07:11:23',	'2018-04-30 07:32:32',	1,	0,	'Active'),
(19,	8,	1,	'',	'',	'2018-04-30 09:46:28',	'0000-00-00 00:00:00',	1,	0,	'Active');

DROP TABLE IF EXISTS `journal_vouchers`;
CREATE TABLE `journal_vouchers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(10) NOT NULL,
  `reference_no` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  `total_credit_amount` decimal(15,2) NOT NULL,
  `total_debit_amount` decimal(15,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `journal_voucher_rows`;
CREATE TABLE `journal_voucher_rows` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `journal_voucher_id` int(10) NOT NULL,
  `cr_dr` varchar(10) NOT NULL,
  `ledger_id` int(10) NOT NULL,
  `debit` decimal(15,2) DEFAULT NULL,
  `credit` decimal(15,2) DEFAULT NULL,
  `mode_of_payment` varchar(30) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `cheque_date` date DEFAULT NULL,
  `total` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ledgers`;
CREATE TABLE `ledgers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `accounting_group_id` int(10) NOT NULL,
  `freeze` tinyint(1) NOT NULL COMMENT '0==unfreezed 1==freezed',
  `supplier_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `tax_percentage` decimal(5,2) NOT NULL,
  `gst_type` varchar(10) DEFAULT NULL,
  `input_output` varchar(10) DEFAULT NULL,
  `gst_figure_id` int(10) DEFAULT NULL,
  `bill_to_bill_accounting` varchar(10) NOT NULL DEFAULT 'no',
  `round_off` int(10) NOT NULL,
  `cash` int(11) NOT NULL,
  `flag` int(11) NOT NULL,
  `default_credit_days` int(11) NOT NULL DEFAULT '0',
  `commission` int(10) DEFAULT NULL,
  `sales_account` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `ledgers` (`id`, `name`, `accounting_group_id`, `freeze`, `supplier_id`, `customer_id`, `seller_id`, `tax_percentage`, `gst_type`, `input_output`, `gst_figure_id`, `bill_to_bill_accounting`, `round_off`, `cash`, `flag`, `default_credit_days`, `commission`, `sales_account`) VALUES
(1,	'0% CGST (input)',	29,	0,	0,	0,	0,	0.00,	'CGST',	'input',	1,	'no',	0,	0,	1,	0,	NULL,	NULL),
(2,	'0% SGST (input)',	29,	0,	0,	0,	0,	0.00,	'SGST',	'input',	1,	'no',	0,	0,	1,	0,	NULL,	NULL),
(3,	'0% IGST (input)',	29,	0,	0,	0,	0,	0.00,	'IGST',	'input',	1,	'no',	0,	0,	1,	0,	NULL,	NULL),
(4,	'0% CGST (output)',	30,	0,	0,	0,	0,	0.00,	'CGST',	'output',	1,	'no',	0,	0,	1,	0,	NULL,	NULL),
(5,	'0% SGST (output)',	30,	0,	0,	0,	0,	0.00,	'SGST',	'output',	1,	'no',	0,	0,	1,	0,	NULL,	NULL),
(6,	'0% IGST (output)',	30,	0,	0,	0,	0,	0.00,	'IGST',	'output',	1,	'no',	0,	0,	1,	0,	NULL,	NULL),
(7,	'2.5% CGST (input)',	29,	0,	0,	0,	0,	0.00,	'CGST',	'input',	2,	'no',	0,	0,	1,	0,	NULL,	NULL),
(8,	'2.5% SGST (input)',	29,	0,	0,	0,	0,	0.00,	'SGST',	'input',	2,	'no',	0,	0,	1,	0,	NULL,	NULL),
(9,	'5% IGST (input)',	29,	0,	0,	0,	0,	0.00,	'IGST',	'input',	2,	'no',	0,	0,	1,	0,	NULL,	NULL),
(10,	'2.5% CGST (output)',	30,	0,	0,	0,	0,	0.00,	'CGST',	'output',	2,	'no',	0,	0,	1,	0,	NULL,	NULL),
(11,	'2.5% SGST (output)',	30,	0,	0,	0,	0,	0.00,	'SGST',	'output',	2,	'no',	0,	0,	1,	0,	NULL,	NULL),
(12,	'5% IGST (output)',	30,	0,	0,	0,	0,	0.00,	'IGST',	'output',	2,	'no',	0,	0,	1,	0,	NULL,	NULL),
(13,	'6% CGST (input)',	29,	0,	0,	0,	0,	0.00,	'CGST',	'input',	3,	'no',	0,	0,	1,	0,	NULL,	NULL),
(14,	'6% SGST (input)',	29,	0,	0,	0,	0,	0.00,	'SGST',	'input',	3,	'no',	0,	0,	1,	0,	NULL,	NULL),
(15,	'12% IGST (input)',	29,	0,	0,	0,	0,	0.00,	'IGST',	'input',	3,	'no',	0,	0,	1,	0,	NULL,	NULL),
(16,	'6% CGST (output)',	30,	0,	0,	0,	0,	0.00,	'CGST',	'output',	3,	'no',	0,	0,	1,	0,	NULL,	NULL),
(17,	'6% SGST (output)',	30,	0,	0,	0,	0,	0.00,	'SGST',	'output',	3,	'no',	0,	0,	1,	0,	NULL,	NULL),
(18,	'12% IGST (output)',	30,	0,	0,	0,	0,	0.00,	'IGST',	'output',	3,	'no',	0,	0,	1,	0,	NULL,	NULL),
(19,	'9% CGST (input)',	29,	0,	0,	0,	0,	0.00,	'CGST',	'input',	4,	'no',	0,	0,	1,	0,	NULL,	NULL),
(20,	'9% SGST (input)',	29,	0,	0,	0,	0,	0.00,	'SGST',	'input',	4,	'no',	0,	0,	1,	0,	NULL,	NULL),
(21,	'18% IGST (input)',	29,	0,	0,	0,	0,	0.00,	'IGST',	'input',	4,	'no',	0,	0,	1,	0,	NULL,	NULL),
(22,	'9% CGST (output)',	30,	0,	0,	0,	0,	0.00,	'CGST',	'output',	4,	'no',	0,	0,	1,	0,	NULL,	NULL),
(23,	'9% SGST (output)',	30,	0,	0,	0,	0,	0.00,	'SGST',	'output',	4,	'no',	0,	0,	1,	0,	NULL,	NULL),
(24,	'18% IGST (output)',	30,	0,	0,	0,	0,	0.00,	'IGST',	'output',	4,	'no',	0,	0,	1,	0,	NULL,	NULL),
(25,	'14% CGST (input)',	29,	0,	0,	0,	0,	0.00,	'CGST',	'input',	5,	'no',	0,	0,	1,	0,	NULL,	NULL),
(26,	'14% SGST (input)',	29,	0,	0,	0,	0,	0.00,	'SGST',	'input',	5,	'no',	0,	0,	1,	0,	NULL,	NULL),
(27,	'28% IGST (input)',	29,	0,	0,	0,	0,	0.00,	'IGST',	'input',	5,	'no',	0,	0,	1,	0,	NULL,	NULL),
(28,	'14% CGST (output)',	30,	0,	0,	0,	0,	0.00,	'CGST',	'output',	5,	'no',	0,	0,	1,	0,	NULL,	NULL),
(29,	'14% SGST (output)',	30,	0,	0,	0,	0,	0.00,	'SGST',	'output',	5,	'no',	0,	0,	1,	0,	NULL,	NULL),
(30,	'28% IGST (output)',	30,	0,	0,	0,	0,	0.00,	'IGST',	'output',	5,	'no',	0,	0,	1,	0,	NULL,	NULL),
(31,	'Round off',	8,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	1,	0,	1,	0,	NULL,	NULL),
(32,	'Cash',	18,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	1,	1,	0,	NULL,	NULL),
(33,	'Sales Accounts',	14,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	1),
(44,	'Jain Thela',	25,	0,	0,	0,	6,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(45,	'Purchase Account',	13,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL),
(46,	'Discount Allowed',	8,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL),
(47,	'Commission Received',	9,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	1,	NULL),
(48,	'Rajsthan Bakery',	25,	0,	0,	0,	7,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(49,	'Raja',	22,	0,	0,	23,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(50,	'rohit',	22,	0,	0,	25,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(51,	'Raja',	22,	0,	0,	27,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(52,	'Canara Bank',	17,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL),
(53,	'rohit',	22,	0,	0,	30,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(54,	'rohit',	22,	0,	0,	31,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(55,	'rohit',	22,	0,	0,	32,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(57,	'Cm',	22,	0,	0,	33,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(58,	'Cm',	22,	0,	0,	34,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(59,	'Dhakar',	22,	0,	0,	35,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(60,	'Jain',	22,	0,	0,	36,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(61,	'Abc',	22,	0,	0,	37,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(62,	'Vhj',	22,	0,	0,	38,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(63,	'vaibhav',	22,	0,	0,	39,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(64,	'priyanka jinger',	22,	0,	0,	40,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(65,	'jonty',	22,	0,	0,	41,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(66,	'vivek',	22,	0,	0,	42,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(67,	'CMdhakar',	22,	0,	0,	43,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(68,	'vivek',	22,	0,	0,	44,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(69,	'vivek bhatt',	22,	0,	0,	45,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(70,	'jain thela',	25,	0,	0,	0,	2,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL),
(71,	'Rohit Joshi',	22,	0,	0,	46,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL);

DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `alise` varchar(100) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `created_on` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '1 for continoue and 0 for delete',
  `financial_year_begins_from` date NOT NULL,
  `financial_year_valid_to` date NOT NULL,
  `books_beginning_from` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `locations` (`id`, `city_id`, `name`, `alise`, `latitude`, `longitude`, `created_on`, `created_by`, `status`, `financial_year_begins_from`, `financial_year_valid_to`, `books_beginning_from`) VALUES
(1,	1,	'fatehpura',	'FP',	'21',	'11',	1,	1,	1,	'2018-04-01',	'2019-03-31',	'2018-04-01'),
(2,	1,	'PratapNagar',	'PN',	'121',	'2',	123,	1,	127,	'2018-04-01',	'2019-03-31',	'2018-04-01');

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `preference` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 for continue and 0 for discontinue',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `menus` (`id`, `name`, `icon`, `controller`, `action`, `parent_id`, `lft`, `rght`, `preference`, `status`) VALUES
(1,	'Dashboard',	'fa fa-dashboard',	'Admins',	'index',	NULL,	1,	2,	0,	1),
(2,	'Unit',	'',	'Units',	'index',	NULL,	3,	4,	0,	1),
(3,	'Menu',	'',	'Menus',	'add',	NULL,	5,	6,	0,	1),
(4,	'City',	'',	'Cities',	'index',	NULL,	7,	8,	0,	1),
(5,	'State',	'',	'States',	'index',	NULL,	9,	10,	0,	1),
(6,	'Category',	'',	'Categories',	'index',	NULL,	11,	12,	0,	1),
(7,	'Delivery Charge',	'',	'delivery-charges',	'index',	NULL,	13,	14,	0,	1),
(8,	'Item',	'',	'',	'',	NULL,	15,	20,	0,	1),
(9,	'Add',	'',	'items',	'add',	8,	16,	17,	0,	1),
(10,	'List',	'',	'items',	'index',	8,	18,	19,	0,	1),
(11,	'Cusotmer',	'',	'',	'',	NULL,	21,	26,	0,	1),
(12,	'Add',	'',	'Customers',	'Add',	11,	22,	23,	0,	1),
(13,	'List',	'',	'Customers',	'index',	11,	24,	25,	0,	1),
(14,	'Seller',	'',	'',	'',	NULL,	27,	38,	0,	1),
(15,	'Add',	'',	'Sellers',	'Add',	14,	28,	29,	0,	1),
(16,	'List',	'',	'Sellers',	'index',	14,	30,	31,	0,	1),
(20,	'Banner',	'',	'Banners',	'index',	NULL,	39,	40,	0,	1),
(21,	'Seller Item',	'',	'SellerItems',	'add',	14,	32,	33,	0,	1),
(22,	'Receipt Voucher',	'',	'',	'',	NULL,	41,	44,	0,	1),
(23,	'Add',	'',	'receipts',	'add',	22,	42,	43,	0,	1),
(24,	'Payment Voucher',	'',	'',	'',	NULL,	45,	48,	0,	1),
(25,	'Add',	'',	'payments',	'add',	24,	46,	47,	0,	1),
(26,	'Delivery Time',	'',	'DeliveryTimes',	'index',	NULL,	49,	50,	0,	1),
(27,	' UNIT VARIATION',	'',	' UnitVariations',	'index',	NULL,	0,	0,	0,	1),
(28,	'Combo Add',	'fa fa-add',	'ComboOffers',	'add',	35,	62,	63,	0,	1),
(29,	'Combo List',	'fa fa-edit',	'combo-offers',	'index',	35,	64,	65,	0,	1),
(30,	'Cancel Reasons',	'fa fa-list',	'cancel-reasons',	'index',	NULL,	51,	52,	0,	1),
(31,	'FAQ',	'fa fa-list',	'faqs',	'index',	NULL,	53,	54,	0,	1),
(32,	'Express Deliveries',	'fa fa-list',	'expressDeliveries',	'index',	NULL,	55,	56,	0,	1),
(33,	'Feedback',	'fa fa-list',	'Feedbacks',	'index',	NULL,	57,	58,	0,	1),
(34,	'Terms Conditions',	'fa fa-list',	'termConditions',	'index',	NULL,	59,	60,	0,	1),
(35,	'Combo Offer',	'',	'',	'',	NULL,	61,	66,	0,	1),
(36,	'Brand',	'fa fa-list',	'Brands',	'index',	NULL,	67,	68,	0,	1),
(37,	'Promo Code',	'',	'',	'',	NULL,	69,	74,	0,	1),
(38,	'Add',	'',	'Promotions',	'add',	37,	70,	71,	0,	1),
(39,	'Item Variation',	'',	'SellerItems',	'itemVariation',	14,	34,	35,	0,	1),
(41,	'Index',	'',	'Promotions',	'index',	37,	72,	73,	0,	1),
(42,	'Plans',	'fa fa-list',	'Plans',	'index',	NULL,	75,	76,	0,	1),
(43,	'Delivery',	'',	'',	'',	NULL,	77,	84,	0,	1),
(44,	'Charges',	'fa fa-list',	'DeliveryCharges',	'index',	43,	80,	81,	0,	1),
(45,	'Dates',	'fa fa-list',	'DeliveryDates',	'index',	43,	78,	79,	0,	1),
(46,	'Times',	'fa fa-list',	'DeliveryTimes',	'index',	43,	82,	83,	0,	1),
(47,	'Bulk Booking',	'',	'',	'',	NULL,	85,	88,	0,	1),
(48,	'Add',	'fa fa-add',	'bulkBookingLeads',	'index',	47,	86,	87,	0,	1),
(49,	'Notify List',	'fa fa-list',	'Notifies',	'index',	NULL,	89,	90,	0,	1),
(50,	'Approve Seller Item',	'',	'SellerItems',	'sellerItemApproval',	14,	36,	37,	0,	1);

DROP TABLE IF EXISTS `nature_of_groups`;
CREATE TABLE `nature_of_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `nature_of_groups` (`id`, `name`) VALUES
(1,	'Assets'),
(2,	'Liabilities'),
(3,	'Income'),
(4,	'Expenses');

DROP TABLE IF EXISTS `notification_keys`;
CREATE TABLE `notification_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `notifies`;
CREATE TABLE `notifies` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `send_flag` varchar(10) NOT NULL DEFAULT 'Unsend' COMMENT 'Send,Unsend,Notsend',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `item_variation_id` (`item_variation_id`),
  CONSTRAINT `notifies_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `notifies_ibfk_2` FOREIGN KEY (`item_variation_id`) REFERENCES `item_variations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `notifies` (`id`, `customer_id`, `item_variation_id`, `send_flag`) VALUES
(1,	8,	21,	'Unsend');

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `sales_ledger_id` int(11) NOT NULL,
  `party_ledger_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `customer_address_id` int(11) NOT NULL,
  `promotion_detail_id` int(11) NOT NULL,
  `order_no` varchar(100) NOT NULL,
  `voucher_no` int(11) NOT NULL,
  `ccavvenue_tracking_no` varchar(200) NOT NULL,
  `amount_from_wallet` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `discount_percent` decimal(6,2) NOT NULL,
  `total_gst` decimal(15,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `pay_amount` decimal(10,2) NOT NULL,
  `online_amount` decimal(10,2) NOT NULL,
  `delivery_charge_id` int(11) NOT NULL,
  `order_type` varchar(50) NOT NULL COMMENT 'Online,COD,Bulkorder etc',
  `delivery_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `delivery_time_id` int(11) NOT NULL,
  `order_status` varchar(30) NOT NULL COMMENT 'Cancel,Delivered,placed',
  `cancel_reason_id` int(11) NOT NULL,
  `cancel_reason_other` text NOT NULL,
  `cancel_date` date NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_status` varchar(30) NOT NULL,
  `order_from` varchar(30) NOT NULL COMMENT 'App,Web',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `orders` (`id`, `location_id`, `city_id`, `sales_ledger_id`, `party_ledger_id`, `customer_id`, `driver_id`, `customer_address_id`, `promotion_detail_id`, `order_no`, `voucher_no`, `ccavvenue_tracking_no`, `amount_from_wallet`, `total_amount`, `discount_percent`, `total_gst`, `grand_total`, `pay_amount`, `online_amount`, `delivery_charge_id`, `order_type`, `delivery_date`, `delivery_time_id`, `order_status`, `cancel_reason_id`, `cancel_reason_other`, `cancel_date`, `order_date`, `payment_status`, `order_from`) VALUES
(2,	1,	1,	33,	32,	11,	0,	1,	0,	'1234',	1,	'',	0.00,	1000.00,	0.00,	0.00,	1000.00,	1000.00,	1000.00,	1,	'Online',	'2018-03-26 00:00:00',	2,	'Cancel',	0,	'',	'2018-03-31',	'2018-03-25 00:00:00',	'Complete',	'App'),
(7,	1,	1,	33,	0,	11,	0,	1,	0,	'5ad5ecd8e0779',	2,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-16 18:30:00',	'Success',	'App'),
(8,	1,	1,	33,	0,	11,	0,	1,	0,	'5ad5ecd8e0779',	3,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-16 18:30:00',	'Success',	'App'),
(9,	1,	1,	33,	0,	11,	0,	1,	0,	'5ad5ecd8e0779',	4,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-17 18:30:00',	'Success',	'App'),
(10,	1,	1,	33,	0,	11,	0,	1,	0,	'5ad5ecd8e0779',	5,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-17 18:30:00',	'Success',	'App'),
(11,	1,	1,	33,	0,	11,	0,	1,	1,	'5ad5ecd8e0779',	6,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-17 18:30:00',	'Success',	'App'),
(12,	1,	1,	33,	0,	11,	0,	1,	1,	'5ad5ecd8e0779',	7,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-17 18:30:00',	'Success',	'App'),
(13,	1,	1,	33,	0,	11,	0,	1,	1,	'5ad5ecd8e0779',	8,	'6sddsf78fasf87asfa',	1.00,	1000.00,	10.00,	12.00,	1050.00,	1000.00,	1.00,	1,	'online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-17 18:30:00',	'Success',	'app'),
(14,	1,	1,	33,	0,	11,	0,	1,	1,	'5ad7373a470e2',	9,	'6sddsf78fasf87asfa',	1.00,	1000.00,	10.00,	12.00,	1050.00,	1000.00,	1.00,	1,	'online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-17 18:30:00',	'Success',	'app'),
(15,	1,	1,	33,	0,	11,	0,	1,	1,	'5ad737a75b855',	10,	'6sddsf78fasf87asfa',	1.00,	1000.00,	10.00,	12.00,	1050.00,	1000.00,	1.00,	1,	'online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-17 18:30:00',	'Success',	'app'),
(16,	1,	1,	33,	0,	11,	0,	1,	0,	'5ad5ecd8e0779',	11,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-17 18:30:00',	'Success',	'App'),
(17,	1,	1,	33,	0,	11,	0,	1,	0,	'5ad5ecd8e0779',	12,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-17 18:30:00',	'Success',	'App'),
(18,	1,	1,	33,	0,	11,	0,	1,	0,	'5ad5ecd8e0779',	13,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'2018-04-17 18:30:00',	'Success',	'App'),
(19,	1,	1,	33,	0,	39,	0,	1,	1,	'5addce25bb095',	14,	'6sddsf78fasf87asfa',	1.00,	1000.00,	10.00,	12.00,	1050.00,	1000.00,	1.00,	1,	'online',	'2018-03-10 18:30:00',	1,	'In Progress',	0,	'',	'0000-00-00',	'2018-04-22 18:30:00',	'Success',	'app'),
(20,	2,	1,	33,	0,	33,	0,	73,	0,	'5ad5ecd8e0880',	1,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'packed',	0,	'',	'0000-00-00',	'2018-04-23 18:30:00',	'Success',	'App'),
(21,	1,	1,	33,	0,	33,	0,	1,	0,	'5ad5ecd8e0779',	15,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'on the way',	0,	'',	'0000-00-00',	'2018-04-23 18:30:00',	'Success',	'App'),
(22,	1,	1,	33,	0,	33,	1,	1,	0,	'd34234dfd',	16,	'',	0.00,	1000.00,	0.00,	100.00,	1100.00,	1100.00,	1100.00,	1,	'Online',	'2018-04-24 00:00:00',	1,	'Cancel',	0,	'',	'0000-00-00',	'2018-04-24 00:00:00',	'',	'App');

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `item_variation_id` int(11) DEFAULT NULL,
  `combo_offer_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `order_details` (`id`, `order_id`, `item_variation_id`, `combo_offer_id`, `quantity`, `rate`, `amount`) VALUES
(2,	2,	2,	NULL,	2.00,	130.00,	260.00),
(4,	2,	0,	1,	2.00,	130.00,	260.00),
(5,	2,	1,	NULL,	2.00,	100.00,	200.00),
(6,	2,	0,	2,	2.00,	150.00,	300.00),
(9,	7,	1,	0,	3.00,	11.56,	69.36),
(10,	7,	9,	0,	10.00,	129.60,	648.00),
(11,	7,	12,	0,	0.50,	12.98,	25.96),
(12,	7,	2,	0,	1.50,	115.61,	346.83),
(13,	7,	21,	0,	0.25,	0.00,	0.00),
(14,	8,	1,	0,	3.00,	11.56,	69.36),
(15,	8,	9,	0,	10.00,	129.60,	648.00),
(16,	8,	12,	0,	0.50,	12.98,	25.96),
(17,	8,	2,	0,	1.50,	115.61,	346.83),
(18,	8,	21,	0,	0.25,	0.00,	0.00),
(19,	9,	1,	0,	3.50,	11.56,	80.92),
(20,	9,	9,	0,	10.00,	129.60,	648.00),
(21,	9,	12,	0,	0.50,	12.98,	25.96),
(22,	9,	2,	0,	2.00,	115.61,	462.44),
(23,	9,	21,	0,	0.25,	0.00,	0.00),
(24,	10,	1,	0,	3.00,	11.56,	69.36),
(25,	10,	9,	0,	10.00,	129.60,	648.00),
(26,	10,	12,	0,	0.50,	12.98,	25.96),
(27,	10,	2,	0,	2.00,	115.61,	462.44),
(28,	10,	21,	0,	0.25,	0.00,	0.00),
(29,	11,	1,	0,	3.00,	11.56,	69.36),
(30,	11,	9,	0,	10.00,	129.60,	648.00),
(31,	11,	12,	0,	0.50,	12.98,	25.96),
(32,	11,	2,	0,	2.00,	115.61,	462.44),
(33,	11,	21,	0,	0.25,	0.00,	0.00),
(34,	12,	1,	0,	3.00,	11.56,	69.36),
(35,	12,	9,	0,	10.00,	129.60,	648.00),
(36,	12,	12,	0,	0.50,	12.98,	25.96),
(37,	12,	2,	0,	2.00,	115.61,	462.44),
(38,	12,	21,	0,	0.25,	0.00,	0.00),
(39,	13,	1,	0,	3.00,	11.56,	69.36),
(40,	13,	9,	0,	10.00,	129.60,	648.00),
(41,	13,	12,	0,	0.50,	12.98,	25.96),
(42,	13,	2,	0,	2.00,	115.61,	462.44),
(43,	13,	21,	0,	0.25,	0.00,	0.00),
(44,	14,	1,	0,	3.00,	11.56,	69.36),
(45,	14,	9,	0,	10.00,	129.60,	648.00),
(46,	14,	12,	0,	0.50,	12.98,	25.96),
(47,	14,	2,	0,	2.00,	115.61,	462.44),
(48,	14,	21,	0,	0.25,	0.00,	0.00),
(49,	15,	1,	0,	3.00,	11.56,	69.36),
(50,	15,	9,	0,	10.00,	129.60,	648.00),
(51,	15,	12,	0,	0.50,	12.98,	25.96),
(52,	15,	2,	0,	2.00,	115.61,	462.44),
(53,	15,	21,	0,	0.25,	0.00,	0.00),
(54,	16,	1,	0,	3.00,	11.56,	69.36),
(55,	16,	9,	0,	10.00,	129.60,	648.00),
(56,	16,	12,	0,	0.50,	12.98,	25.96),
(57,	16,	2,	0,	2.00,	115.61,	462.44),
(58,	16,	21,	0,	0.25,	0.00,	0.00),
(59,	17,	1,	0,	3.00,	11.56,	69.36),
(60,	17,	9,	0,	10.00,	129.60,	648.00),
(61,	17,	12,	0,	0.50,	12.98,	25.96),
(62,	17,	2,	0,	2.00,	115.61,	462.44),
(63,	17,	21,	0,	0.25,	0.00,	0.00),
(64,	18,	1,	0,	3.00,	11.56,	69.36),
(65,	18,	9,	0,	10.00,	129.60,	648.00),
(66,	18,	12,	0,	0.50,	12.98,	25.96),
(67,	18,	2,	0,	2.00,	115.61,	462.44),
(68,	18,	21,	0,	0.25,	0.00,	0.00),
(69,	19,	9,	0,	2.00,	129.60,	129.60),
(70,	19,	1,	0,	0.50,	11.56,	11.56),
(71,	20,	2,	0,	1.00,	115.61,	231.22),
(72,	20,	1,	0,	5.00,	11.56,	115.60),
(73,	21,	2,	0,	1.00,	115.61,	231.22),
(74,	21,	1,	0,	5.00,	11.56,	115.60);

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `payments` (`id`, `voucher_no`, `location_id`, `transaction_date`, `narration`, `status`) VALUES
(1,	1,	1,	'2018-03-24',	'Narration',	'');

DROP TABLE IF EXISTS `payment_rows`;
CREATE TABLE `payment_rows` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_id` int(10) NOT NULL,
  `cr_dr` varchar(10) NOT NULL,
  `ledger_id` int(10) NOT NULL,
  `debit` decimal(15,2) DEFAULT NULL,
  `credit` decimal(15,2) DEFAULT NULL,
  `mode_of_payment` varchar(30) NOT NULL,
  `cheque_no` varchar(30) NOT NULL,
  `cheque_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `payment_rows` (`id`, `payment_id`, `cr_dr`, `ledger_id`, `debit`, `credit`, `mode_of_payment`, `cheque_no`, `cheque_date`) VALUES
(1,	1,	'Dr',	44,	500.00,	NULL,	'',	'',	'1970-01-01'),
(2,	1,	'Cr',	52,	NULL,	500.00,	'NEFT/RTGS',	'',	'1970-01-01');

DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `benifit_per` decimal(5,2) NOT NULL COMMENT 'Percentage of amount',
  `total_amount` decimal(10,2) NOT NULL COMMENT 'add percetange of amount in total_amount',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `plans` (`id`, `admin_id`, `city_id`, `name`, `amount`, `benifit_per`, `total_amount`, `created_on`, `status`) VALUES
(1,	1,	1,	'Golden Plan',	5000.00,	20.00,	6000.00,	'2018-03-21 05:09:33',	'Active'),
(2,	1,	1,	'Silver Plan',	3000.00,	25.00,	3750.00,	'2018-04-27 04:41:19',	'Active');

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `offer_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `promotions` (`id`, `admin_id`, `city_id`, `offer_name`, `description`, `start_date`, `end_date`, `created_on`, `status`) VALUES
(1,	1,	1,	'Cash Back',	'Cash Back 10%',	'2018-03-19 18:30:00',	'2018-03-24 18:30:00',	'2018-03-21 13:14:08',	'0'),
(6,	1,	1,	'offer2',	'dcdscdc',	'2018-04-25 18:30:00',	'2018-05-02 18:30:00',	'2018-04-26 09:55:19',	'Active'),
(7,	1,	1,	'Welcome Offer',	'Install and get 100 rs Off on your first order.',	'2018-04-04 18:30:00',	'2018-05-14 18:30:00',	'2018-04-30 07:16:31',	'Active');

DROP TABLE IF EXISTS `promotion_details`;
CREATE TABLE `promotion_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `discount_in_percentage` decimal(6,2) DEFAULT NULL,
  `discount_in_amount` decimal(10,2) DEFAULT NULL,
  `discount_of_max_amount` decimal(10,2) DEFAULT NULL,
  `coupon_name` varchar(50) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `buy_quntity` decimal(10,2) DEFAULT NULL,
  `get_quntity` decimal(10,2) DEFAULT NULL,
  `get_item_id` int(11) DEFAULT NULL,
  `in_wallet` varchar(10) NOT NULL,
  `is_free_shipping` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `promotion_details` (`id`, `promotion_id`, `category_id`, `item_id`, `discount_in_percentage`, `discount_in_amount`, `discount_of_max_amount`, `coupon_name`, `coupon_code`, `buy_quntity`, `get_quntity`, `get_item_id`, `in_wallet`, `is_free_shipping`) VALUES
(1,	1,	1,	1,	10.00,	0.00,	0.00,	'jainthela',	'1001',	10.00,	10.00,	1,	'Yes',	'Yes'),
(3,	6,	1,	1,	NULL,	100.00,	1000.00,	'zzz',	'zz1q3',	10.00,	1.00,	1,	'No',	'Yes'),
(4,	7,	1,	1,	NULL,	100.00,	100.00,	'WLCM100',	'WLCM100',	1000.00,	NULL,	1,	'No',	'No');

DROP TABLE IF EXISTS `purchase_invoices`;
CREATE TABLE `purchase_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(10) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `location_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `seller_ledger_id` int(10) NOT NULL,
  `purchase_ledger_id` int(11) NOT NULL,
  `narration` text NOT NULL,
  `total_taxable_value` decimal(15,2) NOT NULL,
  `total_gst` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `entry_from` varchar(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_by` int(10) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `purchase_invoices` (`id`, `voucher_no`, `invoice_no`, `location_id`, `transaction_date`, `seller_ledger_id`, `purchase_ledger_id`, `narration`, `total_taxable_value`, `total_gst`, `total_amount`, `entry_from`, `city_id`, `created_by`, `created_on`, `edited_by`, `edited_on`) VALUES
(1,	1,	'FP/PI/20180416/1',	1,	'2018-04-16',	48,	45,	'34e5r6yui',	500.00,	25.00,	525.00,	'Web',	1,	1,	'2018-04-15 18:30:00',	0,	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `purchase_invoice_rows`;
CREATE TABLE `purchase_invoice_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_invoice_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `discount_percentage` decimal(15,3) DEFAULT NULL,
  `discount_amount` decimal(15,2) DEFAULT NULL,
  `taxable_value` decimal(15,2) NOT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  `gst_percentage` int(10) NOT NULL,
  `gst_value` decimal(10,2) NOT NULL,
  `round_off` decimal(15,2) DEFAULT NULL,
  `purchase_rate` decimal(15,2) NOT NULL,
  `sales_rate` decimal(15,2) NOT NULL,
  `gst_type` varchar(100) NOT NULL,
  `mrp` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `purchase_invoice_rows` (`id`, `purchase_invoice_id`, `item_id`, `item_variation_id`, `quantity`, `rate`, `discount_percentage`, `discount_amount`, `taxable_value`, `net_amount`, `gst_percentage`, `gst_value`, `round_off`, `purchase_rate`, `sales_rate`, `gst_type`, `mrp`) VALUES
(1,	1,	1,	0,	5.00,	100.00,	NULL,	NULL,	500.00,	525.00,	2,	25.00,	NULL,	105.00,	115.61,	'excluding',	115.61);

DROP TABLE IF EXISTS `purchase_returns`;
CREATE TABLE `purchase_returns` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_invoice_id` int(10) NOT NULL,
  `voucher_no` varchar(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `purchase_return_rows`;
CREATE TABLE `purchase_return_rows` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_return_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `discount_percentage` decimal(15,3) DEFAULT NULL,
  `discount_amount` decimal(15,2) DEFAULT NULL,
  `pnf_percentage` decimal(15,3) DEFAULT NULL,
  `pnf_amount` decimal(15,2) DEFAULT NULL,
  `taxable_value` decimal(15,2) NOT NULL,
  `item_gst_figure_id` decimal(15,2) NOT NULL,
  `gst_value` decimal(15,2) NOT NULL,
  `round_off` decimal(10,2) DEFAULT NULL,
  `net_amount` decimal(15,2) NOT NULL,
  `purchase_invoice_row_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `purchase_vouchers`;
CREATE TABLE `purchase_vouchers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `supplier_invoice_no` varchar(50) NOT NULL,
  `supplier_invoice_date` date NOT NULL,
  `narration` text NOT NULL,
  `total_credit_amount` decimal(15,2) NOT NULL,
  `total_debit_amount` decimal(15,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `purchase_voucher_rows`;
CREATE TABLE `purchase_voucher_rows` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_voucher_id` int(10) NOT NULL,
  `cr_dr` varchar(10) NOT NULL,
  `ledger_id` int(10) NOT NULL,
  `debit` decimal(15,2) DEFAULT NULL,
  `credit` decimal(15,2) DEFAULT NULL,
  `mode_of_payment` varchar(30) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `cheque_date` date DEFAULT NULL,
  `total` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `receipts`;
CREATE TABLE `receipts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  `sales_invoice_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `receipt_rows`;
CREATE TABLE `receipt_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_id` int(11) NOT NULL,
  `cr_dr` varchar(10) NOT NULL COMMENT 'Dr/Cr',
  `ledger_id` int(11) NOT NULL,
  `debit` decimal(15,2) DEFAULT NULL,
  `credit` decimal(15,2) DEFAULT NULL,
  `mode_of_payment` varchar(30) NOT NULL COMMENT 'Cheque/RTGS/NEFT',
  `cheque_no` varchar(255) NOT NULL,
  `cheque_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `reference_details`;
CREATE TABLE `reference_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `city_id` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `ledger_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL COMMENT 'New/Agst Ref/Advance/On Account',
  `ref_name` varchar(255) NOT NULL,
  `debit` decimal(15,2) NOT NULL,
  `credit` decimal(15,2) NOT NULL,
  `receipt_id` int(11) NOT NULL,
  `receipt_row_id` int(11) NOT NULL,
  `payment_row_id` int(11) NOT NULL,
  `credit_note_id` int(11) DEFAULT NULL,
  `credit_note_row_id` int(11) NOT NULL,
  `debit_note_id` int(11) DEFAULT NULL,
  `debit_note_row_id` int(11) DEFAULT NULL,
  `sales_voucher_row_id` int(11) DEFAULT NULL,
  `purchase_voucher_row_id` int(10) NOT NULL,
  `journal_voucher_row_id` int(10) NOT NULL,
  `sale_return_id` int(10) DEFAULT NULL,
  `purchase_invoice_id` int(10) DEFAULT NULL,
  `purchase_return_id` int(10) DEFAULT NULL,
  `sales_invoice_id` int(10) DEFAULT NULL,
  `opening_balance` varchar(10) DEFAULT NULL,
  `due_days` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `reference_details` (`id`, `customer_id`, `supplier_id`, `seller_id`, `transaction_date`, `city_id`, `location_id`, `ledger_id`, `type`, `ref_name`, `debit`, `credit`, `receipt_id`, `receipt_row_id`, `payment_row_id`, `credit_note_id`, `credit_note_row_id`, `debit_note_id`, `debit_note_row_id`, `sales_voucher_row_id`, `purchase_voucher_row_id`, `journal_voucher_row_id`, `sale_return_id`, `purchase_invoice_id`, `purchase_return_id`, `sales_invoice_id`, `opening_balance`, `due_days`) VALUES
(1,	NULL,	NULL,	0,	'2018-04-16',	1,	1,	48,	'New Ref',	'FP/PI/20180416/1',	0.00,	525.00,	0,	0,	0,	NULL,	0,	NULL,	NULL,	NULL,	0,	0,	NULL,	1,	NULL,	NULL,	NULL,	0),
(2,	NULL,	NULL,	2,	'2018-04-01',	0,	0,	70,	'New Ref',	'op',	1000.00,	0.00,	0,	0,	0,	NULL,	0,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	'yes',	0);

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '1 for continoue and 0 for delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `roles` (`id`, `city_id`, `name`, `created_on`, `created_by`, `status`) VALUES
(1,	1,	'Admin',	'2018-03-05 17:13:19',	1,	1);

DROP TABLE IF EXISTS `sales_invoices`;
CREATE TABLE `sales_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `customer_id` int(10) NOT NULL,
  `amount_before_tax` decimal(15,2) NOT NULL,
  `total_cgst` decimal(15,2) NOT NULL,
  `total_sgst` double(15,2) NOT NULL,
  `total_igst` decimal(15,2) NOT NULL,
  `amount_after_tax` decimal(15,2) NOT NULL,
  `round_off` decimal(10,2) NOT NULL,
  `sales_ledger_id` int(10) NOT NULL,
  `party_ledger_id` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `invoice_receipt_type` varchar(50) NOT NULL,
  `receipt_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sales_invoice_rows`;
CREATE TABLE `sales_invoice_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_invoice_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `discount_percentage` decimal(15,3) NOT NULL,
  `taxable_value` decimal(15,2) NOT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  `gst_figure_id` int(10) NOT NULL,
  `gst_value` decimal(10,2) NOT NULL,
  `is_gst_excluded` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sales_vouchers`;
CREATE TABLE `sales_vouchers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `reference_no` varchar(100) NOT NULL,
  `narration` text NOT NULL,
  `totalMainDr` decimal(15,2) NOT NULL,
  `totalMainCr` decimal(15,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sales_voucher_rows`;
CREATE TABLE `sales_voucher_rows` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sales_voucher_id` int(10) NOT NULL,
  `cr_dr` varchar(10) NOT NULL,
  `ledger_id` int(10) NOT NULL,
  `debit` decimal(15,2) DEFAULT NULL,
  `credit` decimal(15,2) DEFAULT NULL,
  `mode_of_payment` varchar(30) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `cheque_date` date DEFAULT NULL,
  `total` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sale_returns`;
CREATE TABLE `sale_returns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `customer_id` int(10) NOT NULL,
  `amount_before_tax` decimal(15,2) NOT NULL,
  `total_cgst` decimal(15,2) NOT NULL,
  `total_sgst` double(15,2) NOT NULL,
  `total_igst` decimal(15,2) NOT NULL,
  `amount_after_tax` decimal(15,2) NOT NULL,
  `round_off` decimal(10,2) NOT NULL,
  `sales_ledger_id` int(10) NOT NULL,
  `party_ledger_id` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `sales_invoice_id` int(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sale_return_rows`;
CREATE TABLE `sale_return_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_return_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `return_quantity` decimal(15,2) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `discount_percentage` decimal(15,3) DEFAULT NULL,
  `taxable_value` decimal(15,2) NOT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  `gst_figure_id` int(10) DEFAULT NULL,
  `gst_value` decimal(10,2) NOT NULL,
  `sales_invoice_row_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sellers`;
CREATE TABLE `sellers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `gstin` varchar(50) NOT NULL,
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

INSERT INTO `sellers` (`id`, `location_id`, `name`, `username`, `password`, `email`, `mobile_no`, `latitude`, `longitude`, `gstin`, `gstin_holder_name`, `gstin_holder_address`, `firm_name`, `firm_address`, `registration_date`, `termination_date`, `termination_reason`, `breif_decription`, `passkey`, `timeout`, `created_on`, `created_by`, `status`, `bill_to_bill_accounting`, `opening_balance_value`, `debit_credit`, `saller_image`) VALUES
(1,	1,	'Seller Test',	'seller',	'$2y$10$xMXvmyPVbhwUy43ZS8EWDehvDcmNqiE7t6jPiCanbXc4JdLGggstq',	'seller@gmail.com',	'',	'',	'',	'',	'',	'',	'',	'',	'0000-00-00',	'0000-00-00',	'',	'',	'',	0,	'2018-04-26 10:27:14',	0,	'Active',	'Yes',	0.00,	'',	''),
(2,	1,	'jain thela',	'ankit',	'$2y$10$Pry4gEvS3q4qcfxug8q2QOUuxH2RxuRCClVkcFOJsouFYVaKYMVp6',	'qwerty@mail.com',	'9001855886',	'',	'',	'',	'',	'',	'jain thela',	'jain thela',	'2018-04-28',	'0000-00-00',	'',	'',	'',	0,	'2018-04-28 11:14:20',	1,	'Active',	'yes',	1000.00,	'Dr',	'');

DROP TABLE IF EXISTS `seller_items`;
CREATE TABLE `seller_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `commission_percentage` decimal(6,2) NOT NULL,
  `commission_created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expiry_on_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `seller_items` (`id`, `item_id`, `seller_id`, `created_on`, `created_by`, `commission_percentage`, `commission_created_on`, `expiry_on_date`) VALUES
(1,	1,	1,	'2018-04-26 10:31:42',	0,	100.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(7,	2,	1,	'2018-04-28 11:01:39',	0,	200.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `seller_item_variations`;
CREATE TABLE `seller_item_variations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_item_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit_variation_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_on` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `seller_ratings`;
CREATE TABLE `seller_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` decimal(5,2) NOT NULL,
  `comment` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `seller_requests`;
CREATE TABLE `seller_requests` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL,
  `voucher_no` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `total_taxable_value` decimal(15,2) NOT NULL,
  `total_gst` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `seller_requests` (`id`, `seller_id`, `voucher_no`, `location_id`, `transaction_date`, `status`, `total_taxable_value`, `total_gst`, `total_amount`) VALUES
(1,	3,	1,	1,	'2018-03-27',	'Approve',	100.00,	18.00,	118.00);

DROP TABLE IF EXISTS `seller_request_rows`;
CREATE TABLE `seller_request_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_request_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `taxable_value` decimal(15,2) NOT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  `gst_percentage` int(10) NOT NULL,
  `gst_value` decimal(10,2) NOT NULL,
  `purchase_rate` decimal(15,2) NOT NULL,
  `sales_rate` decimal(15,2) NOT NULL,
  `gst_type` varchar(100) NOT NULL,
  `mrp` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `seller_request_rows` (`id`, `seller_request_id`, `item_id`, `item_variation_id`, `quantity`, `rate`, `taxable_value`, `net_amount`, `gst_percentage`, `gst_value`, `purchase_rate`, `sales_rate`, `gst_type`, `mrp`) VALUES
(1,	1,	3,	12,	10.00,	10.00,	100.00,	118.00,	4,	18.00,	11.80,	12.98,	'excluding',	12.98);

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `data` blob NOT NULL,
  `expires` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `sessions` (`id`, `data`, `expires`) VALUES
('2fj07op28oomldoltk232kr9s7',	'Config|a:1:{s:4:\"time\";i:1525068867;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Auth|a:1:{s:4:\"User\";a:13:{s:2:\"id\";i:1;s:11:\"location_id\";i:1;s:7:\"role_id\";i:1;s:4:\"name\";s:6:\"Ashish\";s:8:\"username\";s:6:\"ashish\";s:5:\"email\";s:26:\"ashishbohara1008@gmail.com\";s:9:\"mobile_no\";s:10:\"8058483636\";s:10:\"created_on\";O:20:\"Cake\\I18n\\FrozenTime\":3:{s:4:\"date\";s:26:\"2018-03-05 22:44:27.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:10:\"created_by\";i:1;s:7:\"passkey\";s:0:\"\";s:7:\"timeout\";i:0;s:6:\"status\";i:1;s:7:\"city_id\";i:1;}}',	1525068867),
('2lb16gqdh8mda385mk2tsqrlm6',	'Config|a:1:{s:4:\"time\";i:1525069480;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}',	1525069480),
('2rum2m90u700d1kl98mfv8dgc1',	'Config|a:1:{s:4:\"time\";i:1524808797;}city_id|s:1:\"1\";',	1524808797),
('2s0st7j9dj5gms9goan5pcuh02',	'Config|a:1:{s:4:\"time\";i:1525081988;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Auth|a:0:{}',	1525081988),
('3g42g7dp6os1phqhpd4pk5htg2',	'Config|a:1:{s:4:\"time\";i:1525069480;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}',	1525069480),
('4hib56h6bsvg0gt823hiq7lq72',	'Config|a:1:{s:4:\"time\";i:1525071089;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Auth|a:1:{s:4:\"User\";a:13:{s:2:\"id\";i:1;s:11:\"location_id\";i:1;s:7:\"role_id\";i:1;s:4:\"name\";s:6:\"Ashish\";s:8:\"username\";s:6:\"ashish\";s:5:\"email\";s:26:\"ashishbohara1008@gmail.com\";s:9:\"mobile_no\";s:10:\"8058483636\";s:10:\"created_on\";O:20:\"Cake\\I18n\\FrozenTime\":3:{s:4:\"date\";s:26:\"2018-03-05 22:44:27.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:10:\"created_by\";i:1;s:7:\"passkey\";s:0:\"\";s:7:\"timeout\";i:0;s:6:\"status\";i:1;s:7:\"city_id\";i:1;}}',	1525071089),
('66n49h5mud06odq8h7lntug8c6',	'Config|a:1:{s:4:\"time\";i:1525081723;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Flash|a:1:{s:5:\"flash\";a:1:{i:0;a:4:{s:7:\"message\";s:47:\"You are not authorized to access that location.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"Flash/error\";s:6:\"params\";a:1:{s:5:\"class\";s:5:\"error\";}}}}',	1525081723),
('78ocnj2vj4uroq73uemjlb4gh3',	'Config|a:1:{s:4:\"time\";i:1524659975;}city_id|s:1:\"1\";',	1524659975),
('8dlqphi0u0penuglje0mvqi2p5',	'Config|a:1:{s:4:\"time\";i:1525082107;}city_id|s:1:\"1\";customer_id|i:46;token|s:117:\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQ2LCJleHAiOjE1MjU2ODI0ODV9.5nWPzLBeNmg3bBQq3lebJfRJTJumvfBFsaRMYpGDna0\";',	1525082107),
('8lglvhn7ugt4birfs05s07due1',	'Config|a:1:{s:4:\"time\";i:1525071269;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Auth|a:0:{}',	1525071269),
('aibreo3j90rec432mbfl27m560',	'Config|a:1:{s:4:\"time\";i:1525072591;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Auth|a:1:{s:4:\"User\";a:15:{s:2:\"id\";i:1;s:11:\"location_id\";i:1;s:7:\"role_id\";i:1;s:4:\"name\";s:6:\"Ashish\";s:8:\"username\";s:6:\"ashish\";s:5:\"email\";s:26:\"ashishbohara1008@gmail.com\";s:9:\"mobile_no\";s:10:\"8058483636\";s:10:\"created_on\";O:20:\"Cake\\I18n\\FrozenTime\":3:{s:4:\"date\";s:26:\"2018-03-05 22:44:27.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:10:\"created_by\";i:1;s:7:\"passkey\";s:0:\"\";s:7:\"timeout\";i:0;s:6:\"status\";i:1;s:7:\"city_id\";i:1;s:8:\"state_id\";i:1;s:8:\"pass_key\";s:32:\"wt1U5MAhhJFTXGenFoZoiLwQGrLgdbhh\";}}Flash|a:1:{s:5:\"flash\";a:2:{i:0;a:4:{s:7:\"message\";s:23:\"The Faq has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"Flash/success\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:29:\"The promotion has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"Flash/success\";s:6:\"params\";a:0:{}}}}',	1525072591),
('bu0sdgi6su0hml4kdhhiddrj47',	'Config|a:1:{s:4:\"time\";i:1525082023;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Flash|a:1:{s:5:\"flash\";a:1:{i:0;a:4:{s:7:\"message\";s:47:\"You are not authorized to access that location.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"Flash/error\";s:6:\"params\";a:1:{s:5:\"class\";s:5:\"error\";}}}}',	1525082023),
('eeiqk2ldbeko36bg99l1hrffo5',	'Config|a:1:{s:4:\"time\";i:1525072283;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Flash|a:0:{}Auth|a:1:{s:4:\"User\";a:15:{s:2:\"id\";i:1;s:11:\"location_id\";i:1;s:7:\"role_id\";i:1;s:4:\"name\";s:6:\"Ashish\";s:8:\"username\";s:6:\"ashish\";s:5:\"email\";s:26:\"ashishbohara1008@gmail.com\";s:9:\"mobile_no\";s:10:\"8058483636\";s:10:\"created_on\";O:20:\"Cake\\I18n\\FrozenTime\":3:{s:4:\"date\";s:26:\"2018-03-05 22:44:27.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:10:\"created_by\";i:1;s:7:\"passkey\";s:0:\"\";s:7:\"timeout\";i:0;s:6:\"status\";i:1;s:7:\"city_id\";i:1;s:8:\"state_id\";i:1;s:8:\"pass_key\";s:32:\"wt1U5MAnCJFTXGenFoZoiLwQGrLgdbnC\";}}',	1525072283),
('fc5jdi0471dap87vagkvg1tit6',	'Config|a:1:{s:4:\"time\";i:1525070223;}Flash|a:1:{s:5:\"flash\";a:1:{i:0;a:4:{s:7:\"message\";s:47:\"You are not authorized to access that location.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"Flash/error\";s:6:\"params\";a:1:{s:5:\"class\";s:5:\"error\";}}}}',	1525070223),
('gb5n00opbhfdfkufuds46q9212',	'Config|a:1:{s:4:\"time\";i:1525070138;}Flash|a:1:{s:5:\"flash\";a:1:{i:0;a:4:{s:7:\"message\";s:47:\"You are not authorized to access that location.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"Flash/error\";s:6:\"params\";a:1:{s:5:\"class\";s:5:\"error\";}}}}',	1525070138),
('k9j8uuhk73eq18jaklhsk8mn27',	'Config|a:1:{s:4:\"time\";i:1524922498;}city_id|s:1:\"1\";customer_id|i:46;token|s:117:\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQ2LCJleHAiOjE1MjU1MjY5NzF9.MOU_m7h5nrdJXTvQINimO3AL4iBL7qIHB2vV5znmAnY\";',	1524922511),
('murua048ta5fj1gnjk6tm9p2v6',	'Config|a:1:{s:4:\"time\";i:1525072969;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Auth|a:1:{s:4:\"User\";a:15:{s:2:\"id\";i:1;s:11:\"location_id\";i:1;s:7:\"role_id\";i:1;s:4:\"name\";s:6:\"Ashish\";s:8:\"username\";s:6:\"ashish\";s:5:\"email\";s:26:\"ashishbohara1008@gmail.com\";s:9:\"mobile_no\";s:10:\"8058483636\";s:10:\"created_on\";O:20:\"Cake\\I18n\\FrozenTime\":3:{s:4:\"date\";s:26:\"2018-03-05 22:44:27.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Asia/Kolkata\";}s:10:\"created_by\";i:1;s:7:\"passkey\";s:0:\"\";s:7:\"timeout\";i:0;s:6:\"status\";i:1;s:7:\"city_id\";i:1;s:8:\"state_id\";i:1;s:8:\"pass_key\";s:32:\"wt1U5MAkoJFTXGenFoZoiLwQGrLgdbko\";}}',	1525072971),
('oa9t5tckg5sse4nr0t387tngq6',	'Config|a:1:{s:4:\"time\";i:1525081603;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Auth|a:1:{s:4:\"User\";a:15:{s:2:\"id\";i:1;s:11:\"location_id\";i:1;s:7:\"role_id\";i:1;s:4:\"name\";s:6:\"Ashish\";s:8:\"username\";s:6:\"ashish\";s:5:\"email\";s:26:\"ashishbohara1008@gmail.com\";s:9:\"mobile_no\";s:10:\"8058483636\";s:10:\"created_on\";O:20:\"Cake\\I18n\\FrozenTime\":3:{s:4:\"date\";s:26:\"2018-03-05 22:44:27.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:10:\"created_by\";i:1;s:7:\"passkey\";s:0:\"\";s:7:\"timeout\";i:0;s:6:\"status\";i:1;s:7:\"city_id\";i:1;s:8:\"state_id\";i:1;s:8:\"pass_key\";s:32:\"wt1U5MAGBJFTXGenFoZoiLwQGrLgdbGB\";}}Flash|a:1:{s:5:\"flash\";a:2:{i:0;a:4:{s:7:\"message\";s:24:\"The item has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"Flash/success\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:24:\"The item has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"Flash/success\";s:6:\"params\";a:0:{}}}}',	1525081603),
('oodbi34pqv6fpk9cisip973fl4',	'Config|a:1:{s:4:\"time\";i:1524916697;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Flash|a:1:{s:5:\"flash\";a:1:{i:0;a:4:{s:7:\"message\";s:26:\"The seller has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"Flash/success\";s:6:\"params\";a:0:{}}}}Auth|a:1:{s:4:\"User\";a:14:{s:2:\"id\";i:1;s:11:\"location_id\";i:1;s:7:\"role_id\";i:1;s:4:\"name\";s:6:\"Ashish\";s:8:\"username\";s:6:\"ashish\";s:5:\"email\";s:26:\"ashishbohara1008@gmail.com\";s:9:\"mobile_no\";s:10:\"8058483636\";s:10:\"created_on\";O:20:\"Cake\\I18n\\FrozenTime\":3:{s:4:\"date\";s:26:\"2018-03-05 22:44:27.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:10:\"created_by\";i:1;s:7:\"passkey\";s:0:\"\";s:7:\"timeout\";i:0;s:6:\"status\";i:1;s:7:\"city_id\";i:1;s:8:\"state_id\";i:1;}}',	1524916697),
('ph5oh6bvlu2s7g876hrpv0dsi4',	'Config|a:1:{s:4:\"time\";i:1524636761;}city_id|s:1:\"1\";',	1524636764),
('qec69rrr66tugknhldvqjahqp2',	'Config|a:1:{s:4:\"time\";i:1525081729;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}',	1525081729),
('r8ansgcboma47819saub9asni5',	'Config|a:1:{s:4:\"time\";i:1525070807;}Flash|a:1:{s:5:\"flash\";a:1:{i:0;a:4:{s:7:\"message\";s:47:\"You are not authorized to access that location.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"Flash/error\";s:6:\"params\";a:1:{s:5:\"class\";s:5:\"error\";}}}}',	1525070807),
('s97i4r6lv47avtv6iflupea606',	'Config|a:1:{s:4:\"time\";i:1524746022;}city_id|s:1:\"1\";',	1524746022);

DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active and Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `states` (`id`, `name`, `created_on`, `created_by`, `status`) VALUES
(1,	'Rajasthan',	'2018-03-05 17:10:49',	1,	'Active'),
(2,	'Gujrat',	'2018-03-08 10:08:32',	1,	'Active'),
(3,	'Delhi',	'2018-03-08 10:29:23',	1,	'Deactive');

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `edited_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `bill_to_bill_accounting` varchar(10) NOT NULL,
  `debit_credit` varchar(10) NOT NULL,
  `opening_balance_value` decimal(10,0) NOT NULL,
  `gstin` varchar(20) NOT NULL,
  `gstin_holder_name` varchar(100) NOT NULL,
  `gstin_holder_address` varchar(100) NOT NULL,
  `firm_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `suppliers` (`id`, `location_id`, `city_id`, `name`, `address`, `mobile_no`, `email`, `created_on`, `created_by`, `edited_on`, `edited_by`, `status`, `bill_to_bill_accounting`, `debit_credit`, `opening_balance_value`, `gstin`, `gstin_holder_name`, `gstin_holder_address`, `firm_name`) VALUES
(3,	1,	1,	'YASWANT',	'dfvfd',	'9001855886',	'ankit.sisodiya27@gmail.com',	'2018-03-13 18:30:00',	1,	'0000-00-00 00:00:00',	0,	'Active',	'no',	'Dr',	1345,	'',	'',	'',	''),
(4,	1,	1,	'gopal patel',	'savina',	'9001855886',	'purchase@mogragroup1.com',	'2018-03-14 18:30:00',	1,	'0000-00-00 00:00:00',	0,	'Active',	'yes',	'Dr',	1500,	'22ASDFR0967W6Z5',	'gops',	'titrdi',	'gops');

DROP TABLE IF EXISTS `supplier_areas`;
CREATE TABLE `supplier_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `supplier_areas` (`id`, `city_id`, `name`, `status`) VALUES
(1,	1,	'Ambamata',	0);

DROP TABLE IF EXISTS `term_conditions`;
CREATE TABLE `term_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term_name` varchar(50) NOT NULL,
  `term` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `term_conditions` (`id`, `term_name`, `term`, `status`) VALUES
(2,	'privacy',	'<p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-outline-level: 1;\"><strong><span style=\"font-size: 14.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-font-kerning: 18.0pt;\">Privacy Policy</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 13.5pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">Personal Information</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">The Company respects your privacy and values the trust you place in it. Set out below is the Company&rsquo;s &lsquo;Privacy Policy&rsquo; which details the manner in which information relating to you is collected, used and disclosed.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><em><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">All visitors to <span style=\"mso-spacerun: yes;\">&nbsp;</span></span></em><a href=\"http://www.jainthella.com\"><em><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">www.jainthella.com</span></em></a><em><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\"> (Site) are advised to read and understand our Privacy Policy carefully, as by accessing the you agree to be bound by the terms and conditions of the Privacy Policy and consent to the collection, storage and use of information relating to you as provided herein.</span></em></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><em><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">If you do not agree with the terms and conditions of our Privacy Policy, including in relation to the manner of collection or use of your information, please do not use or access the Jain Thella app . </span></em></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">Our Privacy Policy is incorporated into the Terms and Conditions of Use of the <span style=\"mso-spacerun: yes;\">&nbsp;</span>Jain Thella app, and is subject to change from time to time without notice. It is strongly recommended that you periodically review our Privacy Policy as posted on the Jain Thella app.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">Should you have any clarifications regarding this Privacy Policy, please do not hesitate to contact us at </span><a href=\"mailto:jainthella@gmail.com\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">jainthella@gmail.com</span></a><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">. </span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 13.5pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">Collection, Storage and Use of Information Related to You</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">We may automatically track certain information about you based upon your behaviour on the Jain Thella app . We use this information to do internal research on our users&rsquo;demographics, interests, and behaviour to better understand, protect and serve our users. This information is compiled and analysed on an aggregated basis. This information may include the URL that you just came from , which URL you next go to , your computer browser information, your IP address, and other information associated with your interaction with the Jain Thella App.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">We also collect and store personal information provided by you from time to time on the Jain Thella app . We only collect and use such information from you that we consider necessary for achieving a seamless, efficient and safe experience, customized to your needs including:</span></p><ol start=\"1\" type=\"1\"><li class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-list: l0 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">To enable the provision of services opted for by you;</span></li><li class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-list: l0 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">To communicate necessary account and product/service related information from time to time;</span></li><li class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-list: l0 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">To allow you to receive quality customer care services;</span></li><li class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-list: l0 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">To undertake necessary fraud and money laundering prevention checks, and comply with the highest security standards;</span></li><li class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-list: l0 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">To comply with applicable laws, rules and regulations; and</span></li><li class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-list: l0 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">To provide you with information and offers on products and services, on updates, on promotions, on related, affiliated or associated service providers and partners, that we believe would be of interest to you.</span></li></ol><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">Where any service requested by you involves a third party, such information as is reasonably necessary by the Company to carry out your service request may be shared with such third party.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">We also do use your contact information to send you offers based on your interests and prior activity. The Company may also use contact information internally to direct its efforts for product improvement, to contact you as a survey respondent, to notify you if you win any contest; and to send you promotional materials from its contest sponsors or advertisers.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">The Company will not use your financial information for any purpose other than to complete a transaction with you.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">To the extent possible, we provide you the option of not divulging any specific information that you wish for us not to collect, store or use. You may also choose not to use a particular service or feature on the Jain Thella app , and opt out of any non-essential communications from the Company.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">We use data collection devices such as &ldquo;cookies&rdquo; on certain pages of the Jain Thella app to help analyse our web page flow, measure promotional effectiveness, and promote trust and safety. &ldquo;Cookies&rdquo; are small files placed on your hard drive that assist us in providing our services. We offer certain features that are only available through the use of a &ldquo;cookie&rdquo;.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">We also use cookies to allow you to enter your password less frequently during a session. Cookies can also help us provide information that is targeted to your interests. Most cookies are &ldquo;session cookies,&rdquo; meaning that they are automatically deleted from your hard drive at the end of a session. You are always free to decline our cookies if your browser permits, although in that case you may not be able to use certain features on the Jain Thella app and you may be required to re-enter your password more frequently during a session.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">Additionally, you may encounter &ldquo;cookies&rdquo; or other similar devices on certain pages of the Jain Thella app that are placed by third parties. We do not control the use of cookies by third parties.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">If you send us personal correspondence, such as emails or letters, or if other users or third parties send us correspondence about your activities on the Jain thella app , we may collect such information into a file specific to you.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">We do not retain any information collected for any longer than is reasonably considered necessary by us, or such period as may be required by applicable laws. The Company may be required to disclose any information that is lawfully sought from it by a judicial or other competent body pursuant to applicable laws.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">The may contain links to other websites. We are not responsible for the privacy practices of such websites which we do not manage and control. </span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 13.5pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">Choices Available Regarding Collection, Use and Distribution of Information</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">To protect against the loss, misuse and alteration of the information under its control, the Company has in place appropriate physical, electronic and managerial procedures. For example, the Company servers are accessible only to authorized personnel and your information is shared with employees and authorized personnel on a need to know basis to complete the transaction and to provide the services requested by you. Although the Company endeavors to safeguard the confidentiality of your personally identifiable information, transmissions made by means of the Internet cannot be made absolutely secure. By using the Jain Thella app, you agree that the Company will have no liability for disclosure of your information due to errors in transmission and/or unauthorized acts of third parties.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">Please note that we will not ask you to share any sensitive data or information via email or telephone. If you receive any such request by email or telephone, please do not respond/divulge any sensitive data or information and forward the information relating to the same to <u><span style=\"color: blue;\">jainthella@gmail.com</span></u> for necessary action. </span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 13.5pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">Communication with Company</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">If you wish to correct or update any information you have provided, you may do so online, on the Jain Thella app. Alternatively, you may contact the Company to correct or update such information by sending an e-mail to: <u><span style=\"color: blue;\">jainthella@gmail.com</span></u>.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">In the event of loss, you may contact the Company by sending an e-mail to: <u><span style=\"color: blue;\">jainthella@gmail.com</span></u>.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">In the event you wish to report a breach of the Privacy Policy, you may contact the designated Grievance Officer of the Company at:</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\';\">Person Name<br /> <strong>Company Name</strong><br /> Address<br /> Email address </span></p><p class=\"MsoNormal\">&nbsp;</p>',	'Active'),
(3,	'tcs',	'<p class=\"MsoNormal\" style=\"text-align: justify;\"><strong style=\"mso-bidi-font-weight: normal;\"><span style=\"font-size: 14.0pt; line-height: 115%; font-family: \'Century\',\'serif\'; color: #0d0d0d; mso-themecolor: text1; mso-themetint: 242;\">Terms &amp; conditions:</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #0d0d0d; mso-themecolor: text1; mso-themetint: 242;\">Personal Information</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">It is strongly recommended that you read and understand these Terms of Use carefully, as by accessing this, you agree to be bound by the same and agree that it constitutes an agreement between you and the Company. If you do not agree with this User Agreement, you should not use or access the Jain Thella app or its services for any purpose whatsoever.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">This document is published in accordance with the provisions of Rule 3 of the Information Technology (Intermediaries Guidelines) Rules, 2011. The User Agreement may be updated from time to time by the Company without notice. It is therefore strongly recommended that you review the User Agreement each time you access and/or use the Jain Thella app and its services.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">The terms &lsquo;visitor&rsquo;, &lsquo;user&rsquo;, &lsquo;you&rsquo; hereunder refer to the person visiting, accessing, browsing through and/or using the Jain Thella app at any point in time.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">Should you have any clarifications regarding the Terms of Use, please do not hesitate to contact us at <u>jainthella@gmail.com</u>.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #0d0d0d; mso-themecolor: text1; mso-themetint: 242;\">Services Overview</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">The Jain Thella is a platform for users to transact with third parties, who are granted access to the Jain Thella app to display and offer products for sale through the Jain Thella app. </span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">The Company therefore disclaims all warranties and liabilities associated with any products offered on the Jain Thella app.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">Services on the Jain Thella app are available to only selected geographies in India, and are subject to restrictions based on business hours of third party sellers.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">Transactions through the Jain Thella app may be subject to a delivery charge where the minimum order size is not met. You will be informed of such delivery charge at the stage of check-out for a transaction through the Jain Thella app.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #0d0d0d; mso-themecolor: text1; mso-themetint: 242;\">Eligibility</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">Persons who are &ldquo;incompetent to contract&rdquo; within the meaning of the Indian Contract Act, 1872 including minors, un-discharged insolvents etc. are not eligible to use the Jain Thella app.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">However, if you are a minor, i.e. under the age of 18 years, you may use the Jain Thella spp under the supervision of an adult parent or legal guardian who agrees to be bound by these Terms of Use. You are however prohibited from purchasing any material which is for adult consumption, the sale of which to minors is prohibited.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">The Company reserves the right to terminate&nbsp;or refuse your registration, or refuse to permit access to the Jain Thella app, if: (i) it is discovered or brought to notice that you do not conform to the aforesaid criteria, or (ii) the Company has reason to believe that the eligibility criteria is not met by a user, or the user may breach the terms of this User Agreement.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #0d0d0d; mso-themecolor: text1; mso-themetint: 242;\">License &amp; Access</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">The Company grants you a limited sub-license to access and make personal use of the Jain Thella app, but not to download (other than page caching) or modify it, or any portion of it, except with express written consent of the Company. Such limited sub- license does not include/permit any resale or commercial use of the Jain Thella app or its contents; any collection and use of any product listings, descriptions, or prices; any derivative use of the Jain Thella app or its contents; any downloading or copying of information for the benefit of another merchant; or any use of data mining, robots, or similar data gathering and extraction tools. The Jain Thella app or any portion of<span style=\"mso-spacerun: yes;\">&nbsp; </span>it may not be reproduced, duplicated, copied, sold, resold, visited, or otherwise exploited for any commercial purpose without express written consent of the Company. You may not frame or utilize framing techniques to enclose any trademark, logo, or other proprietary information (including images, text, page layout, or form) of the Jain Thela app or of the Company and/or its affiliates without the express written consent of the Company. You may not use any meta tags or any other &ldquo;hidden text&rdquo; utilizing the Company&rsquo;s name or trademarks without the express written consent of the Company. &nbsp;You shall not attempt to gain unauthorized access to any portion or feature of&nbsp;the Jain Thella app, or any other systems or networks connected to it or to any server, computer, network, or to any of the services offered on or through&nbsp;the<span style=\"mso-spacerun: yes;\">&nbsp; </span>Jain Thella app, by hacking, &lsquo;password mining&rsquo; or any other illegitimate means.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">You hereby agree and undertake not to host, display, upload, modify, publish, transmit, update or share&nbsp;any information</span></p><ol start=\"1\" type=\"1\"><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l1 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">belongs to another person and to which you do not have any right;</span></li><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l1 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">is grossly harmful, harassing, blasphemous, defamatory, obscene,&nbsp;pornographic, paedophilic, libellous, invasive of another&rsquo;s privacy, hateful, or&nbsp;racially, ethnically objectionable, disparaging, relating or encouraging money&nbsp;laundering or gambling, or otherwise unlawful in any manner whatever;</span></li><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l1 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">harms minors in any way;</span></li><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l1 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">infringes any patent, trademark, copyright or other proprietary/intellectual property rights;</span></li><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l1 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">violates any law for the time being in force;</span></li><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l1 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">deceives or misleads the addressee about the origin of such messages communicates any information which is grossly offensive or menacing in nature;</span></li><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l1 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">impersonates another person;</span></li><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l1 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">contains software viruses or any other computer code, files or programs&nbsp;designed to interrupt, destroy or limit the functionality of any computer resource;</span></li><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l1 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">threatens the unity, integrity, defence, security or sovereignty of India,&nbsp;friendly relations with foreign states, or public order or causes incitement to the commission of any cognizable offence or prevents investigation of any offence or&nbsp;is insulting any other nation;</span></li><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l1 level1 lfo1; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">is misleading or known to be false in any way.</span></li></ol><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">Any unauthorized use shall automatically terminate the permission or license granted by the Company.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #0d0d0d; mso-themecolor: text1; mso-themetint: 242;\">Account &amp; Registration Obligations</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">All users have to register and login for placing orders on the Jain Thella app. You must keep your account and registration details current and correct for communications related to your purchases from the Jain Thella app. By agreeing to the Terms of Use, the user agrees to receive promotional communication and newsletters from the Company and its partners. The user can opt out from such communication and/or newsletters either by unsubscribing on the Jain Thella itself, or by contacting the customer services team and placing a request for unsubscribing.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">As part of the registration process on the Jain Thella, the Company may collect the following personally identifiable information about you: Name &ndash; including first and last name, email address, mobile phone number and other contact details, demographic profile (like your age, gender, occupation, education, address etc.) and information about the pages on the Jain Thella app you visit/access, the links you click on the Jain Thella app, the number of times you access a particular page/feature and any such information. Information collected about you is subject to the Privacy Policy of the Company , which is incorporated in these Terms of Use by reference.</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #0d0d0d; mso-themecolor: text1; mso-themetint: 242;\">Pricing</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">We aim to ensure that prices of all products are correct and up-to-date. <span style=\"mso-bidi-font-weight: bold;\">However, from time to time, prices for certain products may not be current or may be inaccurate on account of technical issues, typographical errors or incorrect product information provided to the Company by a supplier. In each such case, notwithstanding anything to the contrary, the Company and the seller both reserve the right to cancel the order without any further liability<strong>.</strong></span> Subject to the foregoing, the price mentioned at the time of ordering a product shall be the price charged at the time of delivery, provided that no product listed on the Jain Thella app will be sold at a price higher than its MRP (Maximum Retail Price).<br><br>\r\nIn case of total billing amount of fruits and vegetables exceeds from rupees 1000 then person needs to pay advance amount before the product gets delivered to their door step.\r\n</span></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 3;\"><strong><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #0d0d0d; mso-themecolor: text1; mso-themetint: 242;\">Coupons and Promo Codes</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">From time to time, the Company may at its discretion offer a user promotional codes or coupons entitling you to encash the applicable value of such codes/coupons against purchases made on the Jain Thella app. Unless specifically stated on the code or coupon, a promotional code or coupon shall:</span></p><ol start=\"1\" type=\"1\"><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l0 level1 lfo2; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">expire at 12:00AM on a date being 15 days (inclusive of the issuance date) from the date of issuance endorsed thereon;</span></li><li class=\"MsoNormal\" style=\"color: #404040; mso-themecolor: text1; mso-themetint: 191; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-list: l0 level1 lfo2; tab-stops: list .5in;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\';\">have a maximum discount value of INR 100.00 only.&nbsp;</span></li></ol><p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Century\',\'serif\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">&nbsp;</span></p>\r\n\r\n\r\n\r\n<b>Cash Back Terms and Conditions:</b></br>\r\n<b>.</b> MyWallet is the instrument to park money in your jainthela  Account as a prepaid payment, and can be used only for bookings orders with jainthela.</br></br>\r\n<b>.</b> Balance in MyWallet doesn\'t bear any interest.</br></br>\r\n<b>.</b> \'My Cash\' amount credited in your MyWallet account post a cancellation or failed booking is refundable into the same card/account used for making the payment at the time of booking. This amount does not expire.</br></br>\r\n<b>.</b> \'Cashback\' amount be credited in your MyWallet account by jainthela in connection with jainthela \'s promotional and marketing campaigns is non-refundable and shall expire as per applicable offer terms.</br></br>\r\n<b>.</b> No other discount coupon or offer of jainthela can be clubbed and avail in a booking order where \'cashback\' amount is sought to be used.</br></br>\r\n<b>.</b> \'cashback\' amount present in your MyWallet account can be utilized in booking orders.</br></br>\r\n<b>.</b> ‘Cashback\' amount can be used only in bookings done through Android or IOS mobile apps.</br></br>\r\n<b>.</b> In case of cancellation of bookings order made through MyWallet, the refund if any after deducting cancellation charges will be processed into the MyWallet account only. However, if the balance in MyWallet isn\'t adequate for the cancellation charges of a transaction, then the deficit will be deducted from the respective bank account or credit card from which payment for that particular transaction was initially made.</br></br>\r\n<b>.</b> The customer agrees that he will not raise any charge back request with his/ her card issuing bank or entity for those amounts which are transferred to wallet after his/ her consent. Any such chargebacks from the card issuer or bank will be denied by jainthela, and jainthela reserves its rights to recover the money from the customer for any chargebacks request made in contravention of this clause.</br></br>\r\n<b>.</b> jainthela has the sole discretion for rewarding  MyWallet user with promotional offers or points, monitoring and temporarily suspending the MyWallet account in case of any chargebacks or similar issues, etc.</br></br>\r\n<b>.</b> These terms can be amended, modified or withdrawn by jainthela at any time without notice.\r\n  <br></br>\r\n\r\n\r\n\r\n\r\n<b>Other Terms & Conditions of cashback offer:</b><br>\r\n<b>.</b>	Transaction here refers the total order/ cart value which may include various sub orders of minimum 300 Rs. Net purchase value (after actual bill amt.) for products from eligible categories will be considered for assessing the eligibility of cashback.<br> \r\n<b>.</b>	In the event sub-orders are cancelled or returned, the corresponding value will be deducted from the paid amount while checking eligibility of Cash back<br> \r\n<b>.</b>	Cash back amount will be directly credited to the customer\'s account by jainthela.<br> \r\n<b>.</b>	Once the cashback against an item has been credited to customer\'s jainthela’s my wallet, return request of that item would not be accepted<br> \r\n<b>.</b>	By placing an order, the customer accepts all terms and conditions specified on jainthela app.<br> \r\n<b>.</b>	Customer can get cashback right after he will be eligible for it. <br>\r\n<b>.</b>	In case, you don\'t claim cashback, it will automatically be credited to your account after the return period is over. <br>\r\n<b>.</b>	Any disputes arising out of and in connection with this program shall be subject to the exclusive jurisdiction of the courts in udaipur only.<br> \r\n<b>.</b>	For any difficulties on cash back, please email customer care at  info@jainthela.com \r\n',	'Active'),
(4,	'aboutus',	'<p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 1;\"><strong><span style=\"font-size: 14.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-font-kerning: 18.0pt;\">About us</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 1;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">Jain Thella is an Udaipur based mobile e-commerce platform that is transforming the shopping experience for people of Lakecity</span><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-bidi-font-family: Arial; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">. </span><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">We offer a wide assortment of groceries, fruits and vegetables at your doorstep just on one click </span><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">.</span></p><p style=\"text-align: justify; line-height: 115%; background: white; mso-background-themecolor: background1;\"><span lang=\"EN-IN\" style=\"font-family: \'Century\',\'serif\'; mso-bidi-font-family: Arial; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">Who has the time and energy to drive all the way to the grocery store, find a parking spot, hunt for all the items on the shopping list, wait in the way-too-long queue for way-too-many minutes, carry all the heavy bags to the car, and reach home looking tired and worn out..</span></p><p style=\"text-align: justify; line-height: 115%; background: white; mso-background-themecolor: background1;\"><span lang=\"EN-IN\" style=\"font-family: \'Century\',\'serif\'; mso-bidi-font-family: Arial; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">When you have the perfect alternative of sitting at the comfort of your home or office, ordering everything through an on demand grocery delivery app, selecting the delivery time and location, making cashless payments, and receiving your grocery without any unnecessary trouble. With this thought we want to ease the daily deliver fresh farm produced vegetables and fruits.</span></p>',	'Active'),
(5,	'returnpolicy',	'<p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 1;\"><strong><span style=\"font-size: 14.0pt; font-family: \'Times New Roman\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-font-kerning: 18.0pt;\">Return policy</span></strong></p><p class=\"MsoNormal\" style=\"mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; text-align: justify; line-height: normal; mso-outline-level: 1;\"><span style=\"font-size: 12.0pt; font-family: \'Century\',\'serif\'; mso-fareast-font-family: \'Times New Roman\'; mso-bidi-font-family: \'Times New Roman\'; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">.</span></p><p style=\"text-align: justify; line-height: 115%; background: white; mso-background-themecolor: background1;\"><span lang=\"EN-IN\" style=\"font-family: \'Century\',\'serif\'; mso-bidi-font-family: Arial; color: #404040; mso-themecolor: text1; mso-themetint: 191;\">Most unopened items in new condition and returned within 3 days will receive a refund or exchange. Some items have a modified return policy noted on the receipt, packing slip, JainThela policy board (refund exceptions), JainThela.com or in the item department. Items that are opened or damaged or do not have a receipt may be denied a refund or exchange.</span></p><p style=\"text-align: justify; line-height: 115%; background: white; mso-background-themecolor: background1;\"></p>',	'Active');

DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `longname` varchar(100) NOT NULL,
  `shortname` varchar(50) NOT NULL,
  `unit_name` varchar(50) NOT NULL,
  `division_factor` int(11) NOT NULL,
  `print_unit` varchar(15) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `units` (`id`, `city_id`, `longname`, `shortname`, `unit_name`, `division_factor`, `print_unit`, `created_by`, `created_on`, `status`) VALUES
(1,	1,	'Kilogram',	'kg',	'KG',	1,	'Kg',	1,	'2018-03-08 06:45:08',	'Active'),
(2,	1,	'Gram',	'Gr',	'Gm',	1000,	'Kg',	1,	'2018-03-08 07:13:40',	'Active'),
(3,	1,	'Pcs',	'Pcs',	'Pcs',	1,	'Pcs',	1,	'2018-03-08 07:14:55',	'Active');

DROP TABLE IF EXISTS `unit_variations`;
CREATE TABLE `unit_variations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `unit_id` int(10) NOT NULL,
  `quantity_variation` int(10) NOT NULL COMMENT 'eg:100 ',
  `convert_unit_qty` decimal(10,2) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `unit_variations` (`id`, `unit_id`, `quantity_variation`, `convert_unit_qty`, `created_by`, `created_on`) VALUES
(1,	2,	500,	0.50,	1,	'2018-03-20 08:52:24'),
(2,	3,	1,	1.00,	1,	'2018-03-20 08:55:01'),
(3,	1,	2,	2.00,	1,	'2018-03-20 08:55:01'),
(4,	2,	250,	0.25,	1,	'2018-03-20 08:55:02'),
(5,	2,	100,	0.10,	1,	'2018-03-20 08:55:02'),
(6,	2,	800,	0.80,	1,	'2018-03-20 11:14:04'),
(7,	1,	900,	900.00,	1,	'2018-04-24 10:33:31'),
(8,	2,	900,	0.90,	1,	'2018-04-24 10:33:50');

DROP TABLE IF EXISTS `verify_otps`;
CREATE TABLE `verify_otps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(15) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `verify_otps` (`id`, `mobile`, `otp`, `status`) VALUES
(1,	'9887779189',	'',	0),
(2,	'9887779189',	'770',	0),
(3,	'9887779189',	'4308',	0),
(4,	'9887779189',	'5188',	0),
(5,	'9887779189',	'3862',	0),
(6,	'9694981008',	'1937',	0),
(7,	'9694981008',	'5140',	0),
(8,	'9588046310',	'2332',	0),
(9,	'8233068030',	'6657',	0),
(10,	'8233068030',	'6406',	0),
(11,	'8233068030',	'9634',	0),
(12,	'8233068030',	'6775',	0),
(13,	'9887779189',	'8548',	0),
(14,	'8233068030',	'2531',	0),
(15,	'9588046310',	'6094',	0),
(16,	'9588046310',	'7392',	0),
(17,	'9588046310',	'3302',	0),
(18,	'9588046310',	'4297',	0),
(19,	'8233068030',	'4127',	0),
(20,	'8233068030',	'5647',	0),
(21,	'8233068030',	'6769',	0),
(22,	'8233068030',	'9425',	0),
(23,	'uyfuf',	'5212',	0),
(24,	'uyfuf',	'7567',	0),
(25,	'uyfuf',	'4234',	0),
(26,	'uyfuf',	'9244',	0),
(27,	'uyfuf',	'7679',	0),
(28,	'uyfuf',	'4905',	0),
(29,	'uyfuf',	'6872',	0),
(30,	'5752752',	'3203',	0),
(31,	'5752752',	'5531',	0),
(32,	'8233068030',	'8830',	0),
(33,	'8233068030',	'7642',	0),
(34,	'8233068030',	'3321',	0),
(35,	'9352823161',	'3631',	0),
(36,	'9887779189',	'7049',	0),
(37,	'9887779189',	'7049',	0),
(38,	'9588046310',	'9493',	0),
(39,	'9588046310',	'4534',	0),
(40,	'9588046310',	'7688',	0),
(41,	'9588046310',	'1447',	0),
(42,	'9887779189',	'6765',	0),
(43,	'9887779189',	'1732',	0),
(44,	'iohlh',	'3872',	0),
(45,	'8233068030',	'5748',	0),
(46,	'8233068030',	'7297',	0),
(47,	'9887779189',	'7181',	0),
(48,	'8233068030',	'7974',	0),
(49,	'9694561206',	'2777',	0),
(50,	'9352823161',	'6892',	0),
(51,	'916882490',	'7770',	0),
(52,	'961882490',	'4643',	0),
(53,	'961882490',	'4851',	0),
(54,	'961882490',	'2060',	0),
(55,	'9461882490',	'3187',	0),
(56,	'94618824',	'4732',	0),
(57,	'9461',	'4372',	0),
(58,	'9461882490',	'5147',	0),
(59,	'123',	'5645',	0),
(60,	'5804748450',	'1660',	0),
(61,	'99',	'8925',	0),
(62,	'9929726424',	'1598',	0),
(63,	'9116727857',	'6804',	0),
(64,	'9887779189',	'7906',	0),
(65,	'8949435768',	'2465',	0),
(66,	'8949435768',	'3975',	0),
(67,	'8949435768',	'8405',	0),
(68,	'8949435768',	'4197',	0),
(69,	'8949435768',	'7571',	0),
(70,	'8949435768',	'6789',	0),
(71,	'8949435768',	'1123',	0),
(72,	'8949435768',	'4356',	0),
(73,	'8949435768',	'7523',	0),
(74,	'8649435768',	'3283',	0),
(75,	'8649435768',	'7234',	0),
(76,	'8949435768',	'8904',	0),
(77,	'8949435768',	'4305',	0),
(78,	'8946435768',	'4448',	0),
(79,	'8946435768',	'6146',	0),
(80,	'8949435768',	'7334',	0),
(81,	'9461882490',	'7832',	0),
(82,	'9461882490',	'1378',	0),
(83,	'9461882490',	'3630',	0),
(84,	'8949435768',	'1333',	0),
(85,	'9887779123',	'7166',	0);

DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `add_amount` decimal(10,2) NOT NULL,
  `used_amount` decimal(10,2) NOT NULL,
  `cancel_to_wallet_online` varchar(30) NOT NULL,
  `narration` text NOT NULL,
  `return_order_id` int(11) NOT NULL,
  `amount_type` varchar(30) NOT NULL,
  `transaction_type` varchar(30) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `wallets` (`id`, `city_id`, `customer_id`, `order_id`, `plan_id`, `promotion_id`, `add_amount`, `used_amount`, `cancel_to_wallet_online`, `narration`, `return_order_id`, `amount_type`, `transaction_type`, `created_on`) VALUES
(63,	1,	11,	0,	1,	0,	5000.00,	0.00,	'',	'text',	0,	'plan',	'Added',	'2018-03-23 10:25:27'),
(64,	1,	11,	0,	0,	0,	2000.00,	0.00,	'',	'text',	0,	'direct money',	'Added',	'2018-03-23 10:25:33'),
(65,	1,	11,	0,	0,	0,	0.00,	0.00,	'',	'text',	0,	'direct money',	'Added',	'2018-03-23 10:25:52'),
(66,	1,	11,	0,	0,	0,	999.00,	0.00,	'',	'text',	0,	'direct money',	'Added',	'2018-03-23 10:26:00'),
(67,	1,	11,	0,	0,	0,	99.00,	0.00,	'',	'text',	0,	'direct money',	'Added',	'2018-03-23 10:26:04'),
(68,	1,	11,	0,	0,	0,	0.00,	0.00,	'',	'text',	0,	'direct money',	'Added',	'2018-03-23 10:26:10'),
(69,	1,	11,	0,	1,	0,	1000.00,	0.00,	'',	'text',	0,	'plan',	'Added',	'2018-03-23 10:26:34'),
(70,	1,	11,	0,	1,	0,	1000.00,	0.00,	'',	'text',	0,	'plan',	'Deduct',	'2018-03-23 10:30:34'),
(71,	1,	25,	0,	1,	0,	1000.00,	0.00,	'',	'text',	0,	'plan',	'Added',	'2018-03-23 10:31:09'),
(75,	1,	11,	0,	0,	0,	1000.00,	0.00,	'',	'Amount Return form Order',	2,	'Cancel Order',	'Added',	'2018-03-25 12:18:41'),
(76,	1,	11,	0,	0,	0,	1000.00,	0.00,	'',	'Amount Return form Order',	2,	'Cancel Order',	'Added',	'2018-03-31 08:46:37'),
(77,	1,	11,	0,	0,	0,	1000.00,	0.00,	'',	'Amount Return form Order',	2,	'Cancel Order',	'Added',	'2018-03-31 08:54:55'),
(78,	1,	11,	0,	0,	0,	1000.00,	0.00,	'',	'Amount Return form Order',	2,	'Cancel Order',	'Added',	'2018-03-31 08:55:10'),
(79,	1,	11,	0,	0,	0,	1000.00,	0.00,	'',	'Amount Return form Order',	2,	'Cancel Order',	'Added',	'2018-03-31 09:10:22'),
(80,	1,	11,	0,	0,	0,	1000.00,	0.00,	'',	'Amount Return form Order',	2,	'Cancel Order',	'Added',	'2018-03-31 09:10:30'),
(81,	1,	11,	0,	0,	0,	1000.00,	0.00,	'',	'Amount Return form Order',	2,	'Cancel Order',	'Added',	'2018-03-31 09:25:28'),
(82,	1,	33,	0,	1,	0,	0.00,	0.00,	'',	'testing',	0,	'',	'Added',	'2018-04-18 06:31:28'),
(83,	1,	33,	0,	1,	0,	2000.00,	0.00,	'',	'testing',	0,	'',	'Added',	'2018-04-18 06:32:11'),
(84,	1,	33,	0,	1,	0,	1000.00,	0.00,	'',	'testing',	0,	'',	'Added',	'2018-04-18 06:32:27'),
(85,	1,	33,	0,	1,	0,	500.00,	0.00,	'',	'testing',	0,	'',	'Added',	'2018-04-18 06:32:53'),
(86,	1,	38,	0,	1,	0,	500.00,	0.00,	'',	'testing',	0,	'',	'Added',	'2018-04-18 06:47:16');

DROP TABLE IF EXISTS `wish_lists`;
CREATE TABLE `wish_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `wish_lists` (`id`, `customer_id`, `created_on`, `status`) VALUES
(12,	4,	'2018-03-23 07:05:27',	0),
(13,	25,	'2018-03-23 12:27:02',	0),
(18,	11,	'2018-04-05 12:20:27',	0),
(19,	33,	'2018-04-20 07:27:07',	0),
(20,	40,	'2018-04-24 06:04:57',	0),
(21,	45,	'2018-04-28 08:50:49',	0);

DROP TABLE IF EXISTS `wish_list_items`;
CREATE TABLE `wish_list_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wish_list_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `combo_offer_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `wish_list_items` (`id`, `wish_list_id`, `item_id`, `item_variation_id`, `combo_offer_id`, `status`, `created_on`) VALUES
(20,	11,	5,	2,	0,	0,	'2018-03-23 09:01:38'),
(21,	11,	3,	2,	0,	0,	'2018-03-23 09:01:50'),
(128,	20,	2,	9,	0,	0,	'2018-04-24 06:34:56');

-- 2018-04-30 09:59:23
