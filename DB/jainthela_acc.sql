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
  `order_id` int(11) NOT NULL,
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

INSERT INTO `accounting_entries` (`id`, `ledger_id`, `debit`, `credit`, `transaction_date`, `location_id`, `city_id`, `purchase_voucher_id`, `purchase_voucher_row_id`, `is_opening_balance`, `sales_invoice_id`, `order_id`, `sale_return_id`, `purchase_invoice_id`, `purchase_return_id`, `receipt_id`, `receipt_row_id`, `payment_id`, `payment_row_id`, `credit_note_id`, `credit_note_row_id`, `debit_note_id`, `debit_note_row_id`, `sales_voucher_id`, `sales_voucher_row_id`, `journal_voucher_id`, `journal_voucher_row_id`, `contra_voucher_id`, `contra_voucher_row_id`, `reconciliation_date`, `entry_from`) VALUES
(1,	90,	12000.00,	0.00,	'2018-05-26',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Web'),
(2,	129,	0.00,	13440.00,	'2018-05-26',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Web'),
(3,	13,	720.00,	0.00,	'2018-05-26',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Web'),
(4,	14,	720.00,	0.00,	'2018-05-26',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Web'),
(5,	129,	63.00,	NULL,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	7,	9,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(6,	88,	NULL,	63.00,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	7,	10,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(7,	129,	63.00,	NULL,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	7,	9,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(8,	88,	NULL,	63.00,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	7,	10,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(9,	129,	85.00,	NULL,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	7,	9,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(10,	88,	NULL,	63.00,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	7,	10,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(11,	95,	NULL,	22.00,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	7,	11,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(28,	95,	7.00,	NULL,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	8,	12,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(29,	88,	NULL,	7.00,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	8,	13,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(30,	85,	NULL,	35.00,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(31,	88,	35.00,	NULL,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(34,	86,	NULL,	22.00,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	2,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(35,	88,	22.00,	NULL,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	2,	4,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(38,	95,	39.00,	NULL,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'web'),
(39,	88,	NULL,	39.00,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	2,	NULL,	'web'),
(40,	95,	40.00,	NULL,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	'web'),
(41,	88,	NULL,	40.00,	'2018-05-28',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	2,	NULL,	'web'),
(44,	131,	107.00,	NULL,	'2018-05-31',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	NULL,	'web'),
(45,	135,	NULL,	107.00,	'2018-05-31',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL,	NULL,	'web'),
(54,	132,	73.00,	NULL,	'2018-05-29',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(55,	133,	NULL,	73.00,	'2018-05-29',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(60,	132,	721.00,	NULL,	'2018-05-29',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web'),
(61,	86,	NULL,	721.00,	'2018-05-29',	0,	1,	NULL,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'web');

DROP TABLE IF EXISTS `accounting_groups`;
CREATE TABLE `accounting_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nature_of_group_id` int(10) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `customer` tinyint(1) DEFAULT NULL,
  `seller` int(11) DEFAULT NULL,
  `vendor` int(11) DEFAULT NULL,
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
  `input_output_gst` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seller` (`seller`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `accounting_groups` (`id`, `nature_of_group_id`, `city_id`, `name`, `parent_id`, `lft`, `rght`, `customer`, `seller`, `vendor`, `purchase_voucher_first_ledger`, `purchase_voucher_purchase_ledger`, `purchase_voucher_all_ledger`, `sale_invoice_party`, `sale_invoice_sales_account`, `credit_note_party`, `credit_note_sales_account`, `bank`, `cash`, `purchase_invoice_purchase_account`, `purchase_invoice_party`, `receipt_ledger`, `payment_ledger`, `credit_note_first_row`, `credit_note_all_row`, `debit_note_first_row`, `debit_note_all_row`, `sales_voucher_first_ledger`, `sales_voucher_sales_ledger`, `sales_voucher_all_ledger`, `journal_voucher_ledger`, `contra_voucher_ledger`, `input_output_gst`) VALUES
(1,	2,	1,	'Branch / Divisions',	NULL,	1,	4,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	1,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(2,	2,	1,	'Capital Account',	NULL,	5,	8,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(3,	1,	1,	'Current Assets',	NULL,	9,	24,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(4,	2,	1,	'Current Liabilities',	NULL,	25,	38,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(5,	4,	1,	'Direct Expenses',	NULL,	39,	40,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(6,	3,	1,	'Direct Incomes',	NULL,	41,	42,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(7,	1,	1,	'Fixed Assets',	NULL,	43,	44,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(8,	4,	1,	'Indirect Expenses',	NULL,	45,	46,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(9,	3,	1,	'Indirect Incomes',	NULL,	47,	48,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(10,	1,	1,	'Investments',	NULL,	49,	50,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(11,	2,	1,	'Loans (Liability)',	NULL,	51,	58,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(12,	1,	1,	'Misc. Expenses (ASSET)',	NULL,	59,	60,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(13,	4,	1,	'Purchase Accounts',	NULL,	61,	62,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(14,	3,	1,	'Sales Accounts',	NULL,	63,	64,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	NULL),
(15,	2,	1,	'Suspense A/c',	NULL,	65,	66,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(16,	NULL,	1,	'Reserves & Surplus',	2,	6,	7,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(17,	NULL,	1,	'Bank Accounts',	3,	10,	11,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	1,	NULL),
(18,	NULL,	1,	'Cash-in-hand',	3,	12,	13,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(19,	NULL,	1,	'Deposits (Asset)',	3,	14,	15,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(20,	NULL,	1,	'Loans & Advances (Asset)',	3,	16,	17,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(21,	NULL,	1,	'Stock-in-hand',	3,	18,	19,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(22,	NULL,	1,	'Sundry Debtors',	3,	20,	21,	1,	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	1,	NULL,	0,	NULL,	NULL,	NULL,	1,	NULL,	1,	1,	1,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(23,	NULL,	1,	'Duties & Taxes',	4,	26,	31,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(24,	NULL,	1,	'Provisions',	4,	32,	33,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(25,	NULL,	1,	'Sundry Creditors',	4,	34,	35,	NULL,	1,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	1,	NULL,	1,	1,	1,	1,	1,	1,	NULL,	NULL,	1,	1,	NULL),
(26,	NULL,	1,	'Bank OD A/c',	11,	52,	53,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(27,	NULL,	1,	'Secured Loans',	11,	54,	55,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(28,	NULL,	1,	'Unsecured Loans',	11,	56,	57,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(29,	NULL,	1,	'Input GST',	23,	27,	28,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'Input'),
(30,	NULL,	1,	'Output GST',	23,	29,	30,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'Output'),
(62,	NULL,	1,	'qwerty',	3,	22,	23,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(63,	NULL,	1,	'Staaf Advance',	1,	2,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(94,	NULL,	1,	'Commission',	4,	36,	37,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

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
  `status` varchar(10) NOT NULL COMMENT '1 for continoue and 0 for delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admins` (`id`, `location_id`, `role_id`, `name`, `username`, `password`, `email`, `mobile_no`, `created_on`, `created_by`, `passkey`, `timeout`, `status`) VALUES
(1,	1,	1,	'Ashish',	'ashish',	'$2y$10$xMXvmyPVbhwUy43ZS8EWDehvDcmNqiE7t6jPiCanbXc4JdLGggstq',	'ashishbohara1008@gmail.com',	'8058483636',	'2018-03-05 17:14:27',	1,	'',	0,	'Active'),
(2,	1,	1,	'Gopesh Singh Parihar1',	'gopsa1',	'$2y$10$J530qEu1xAUnt7ZSNeyJFe1YJHEmfWwyGs4Xz8qiPaOwcVhR.hjm6',	'gopesh1@gmail.com',	'82331997281',	'2018-05-08 12:04:00',	1,	'',	0,	'Active');

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
  `category_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `combo_offer_id` int(10) NOT NULL,
  `variation_id` int(10) NOT NULL,
  `banner_image_web` varchar(100) NOT NULL,
  `banner_image` varchar(100) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `banners` (`id`, `city_id`, `link_name`, `name`, `category_id`, `seller_id`, `item_id`, `combo_offer_id`, `variation_id`, `banner_image_web`, `banner_image`, `created_on`, `status`) VALUES
(1,	1,	'product_description',	'1',	6,	0,	1,	0,	6,	'banner/1/web/banner1527326280.jpeg',	'banner/1/app/banner1527326280.jpeg',	'2018-05-26 09:05:18',	'Active'),
(2,	1,	'product_description',	'2',	6,	0,	0,	0,	0,	'banner/2/web/banner1527326164.jpeg',	'banner/2/app/banner1527326164.jpeg',	'2018-05-26 09:10:27',	'Active'),
(3,	1,	'product_description',	'3',	0,	0,	6,	0,	0,	'banner/3/web/banner1527326058.jpeg',	'banner/3/app/banner1527326058.jpeg',	'2018-05-26 09:11:21',	'Active');

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
(1,	1,	'Amul',	'Active',	1,	'2018-05-26 09:26:55',	'brand/1/app/brand1527326763.jpeg',	'brand/1/web/brand1527326763.jpeg'),
(2,	1,	'Colgate',	'Active',	1,	'2018-05-26 10:06:39',	'brand/2/app/brand1527329141.png',	'brand/2/web/brand1527329141.png'),
(3,	1,	'Surf Excel',	'Active',	1,	'2018-05-26 10:08:57',	'brand/3/app/brand1527329284.png',	'brand/3/web/brand1527329284.png');

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
  `lead_from` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bulk_booking_leads` (`id`, `city_id`, `customer_id`, `lead_no`, `name`, `mobile`, `lead_description`, `delivery_date`, `delivery_time`, `created_on`, `status`, `reason`, `lead_from`) VALUES
(1,	1,	4,	1,	'Shailendra',	'9694981008',	'',	'2018-11-28',	'12:59',	'2018-05-28 10:59:13',	'Open',	'Testing SMS',	'web');

DROP TABLE IF EXISTS `bulk_booking_lead_rows`;
CREATE TABLE `bulk_booking_lead_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bulk_booking_lead_id` int(10) NOT NULL,
  `image_name` varchar(50) NOT NULL,
  `image_name_web` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bulk_booking_lead_id` (`bulk_booking_lead_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bulk_booking_lead_rows` (`id`, `bulk_booking_lead_id`, `image_name`, `image_name_web`) VALUES
(1,	1,	'Bulk_Booking15275051531794328303.jpeg',	'');

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
(1,	'Already Purchase',	'2018-05-09 10:28:37',	1,	'Active'),
(2,	'Others',	'2018-05-09 10:28:52',	1,	'Active');

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
(5,	1,	46,	13,	0,	2,	3.00,	60.00,	180.00,	3,	'2018-05-03 07:03:46'),
(32,	1,	46,	9,	0,	2,	1.00,	25.00,	25.00,	1,	'2018-05-04 07:20:40'),
(33,	1,	46,	11,	0,	2,	1.00,	25.00,	25.00,	1,	'2018-05-04 07:21:08'),
(35,	1,	46,	6,	0,	2,	2.00,	45.00,	90.00,	2,	'2018-05-04 07:22:02'),
(36,	1,	46,	16,	0,	2,	2.00,	30.00,	60.00,	2,	'2018-05-04 07:22:15'),
(37,	1,	46,	0,	2,	0,	2.00,	500.00,	1000.00,	2,	'2018-05-03 07:19:10'),
(40,	1,	48,	0,	1,	0,	1.00,	200.00,	200.00,	1,	'2018-05-04 12:02:56'),
(45,	1,	41,	0,	1,	0,	1.00,	200.00,	200.00,	1,	'2018-05-05 11:24:41'),
(59,	1,	11,	4,	0,	1,	3.00,	40.00,	120.00,	3,	'2018-05-07 07:05:45'),
(60,	1,	11,	6,	0,	2,	4.00,	45.00,	180.00,	4,	'2018-05-07 07:05:51'),
(61,	1,	11,	14,	0,	2,	1.00,	45.00,	45.00,	1,	'2018-05-07 07:05:56'),
(62,	1,	11,	16,	0,	2,	3.00,	30.00,	90.00,	3,	'2018-05-07 07:05:58'),
(82,	1,	11,	9,	0,	2,	1.00,	25.00,	25.00,	1,	'2018-05-07 12:37:14'),
(98,	1,	33,	8,	0,	2,	6.00,	50.00,	300.00,	6,	'2018-05-07 12:42:34'),
(99,	1,	33,	23,	0,	2,	6.00,	35.00,	210.00,	6,	'2018-05-07 12:42:42'),
(149,	1,	46,	7,	0,	2,	1.00,	75.00,	75.00,	1,	'2018-05-08 10:11:05'),
(150,	1,	41,	6,	0,	2,	2.00,	45.00,	90.00,	2,	'2018-05-08 10:15:59'),
(151,	1,	11,	23,	0,	2,	1.00,	35.00,	35.00,	1,	'2018-05-08 10:16:32'),
(153,	1,	41,	23,	0,	2,	20.00,	35.00,	700.00,	20,	'2018-05-08 10:29:13'),
(157,	1,	33,	6,	0,	2,	29.00,	45.00,	1305.00,	29,	'2018-05-08 12:03:12'),
(159,	1,	33,	4,	0,	1,	21.00,	40.00,	840.00,	21,	'2018-05-08 12:48:21'),
(160,	1,	33,	5,	0,	2,	2.00,	15.00,	30.00,	2,	'2018-05-08 12:48:42'),
(161,	1,	33,	7,	0,	2,	1.00,	75.00,	75.00,	1,	'2018-05-08 13:17:25'),
(162,	1,	33,	7,	0,	2,	18.00,	75.00,	1350.00,	18,	'2018-05-08 13:17:25'),
(205,	1,	38,	25,	0,	2,	2.00,	0.00,	0.00,	2,	'2018-05-09 12:47:56'),
(208,	1,	40,	23,	0,	2,	4.00,	35.00,	140.00,	4,	'2018-05-09 12:51:52'),
(211,	1,	45,	9,	0,	2,	2.00,	25.00,	50.00,	2,	'2018-05-10 07:07:36'),
(214,	1,	33,	27,	0,	2,	2.00,	66.00,	132.00,	2,	'2018-05-10 09:39:53'),
(219,	1,	40,	8,	0,	2,	1.00,	50.00,	50.00,	1,	'2018-05-10 10:44:28'),
(224,	1,	40,	9,	0,	2,	1.00,	25.00,	25.00,	1,	'2018-05-10 11:03:44'),
(228,	1,	49,	9,	0,	2,	2.00,	25.00,	50.00,	2,	'2018-05-11 05:36:36'),
(250,	1,	46,	19,	0,	2,	4.00,	150.00,	600.00,	4,	'2018-05-12 10:12:08'),
(252,	1,	33,	20,	0,	3,	4.00,	3.00,	12.00,	4,	'2018-05-14 04:25:49'),
(263,	1,	38,	0,	1,	0,	1.00,	200.00,	200.00,	1,	'2018-05-14 06:54:29'),
(268,	1,	38,	4,	0,	1,	4.00,	40.00,	160.00,	4,	'2018-05-14 08:09:56'),
(269,	1,	38,	6,	0,	2,	1.00,	45.00,	45.00,	1,	'2018-05-14 08:10:00'),
(270,	1,	35,	19,	0,	2,	2.00,	150.00,	300.00,	2,	'2018-05-14 08:47:07'),
(271,	1,	38,	5,	0,	2,	1.00,	15.00,	15.00,	1,	'2018-05-14 08:51:14'),
(273,	1,	33,	26,	0,	2,	5.00,	50.00,	250.00,	5,	'2018-05-14 11:18:19'),
(274,	1,	41,	4,	0,	1,	1.00,	40.00,	40.00,	1,	'2018-05-14 13:08:20'),
(277,	1,	4,	6,	0,	1,	1.00,	60.00,	60.00,	1,	'2018-05-30 08:55:16'),
(280,	1,	4,	12,	0,	1,	2.00,	12.00,	24.00,	2,	'2018-05-30 09:09:17'),
(281,	1,	4,	13,	0,	2,	2.00,	5.00,	10.00,	2,	'2018-05-30 09:09:26'),
(282,	1,	4,	3,	0,	2,	1.00,	0.00,	0.00,	1,	'2018-05-30 09:09:37');

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
(1,	1,	'Fruits',	NULL,	1,	6,	'Yes',	'category/1/web/category1527317128.jpeg',	'category/1/app/category1527317128.jpeg',	'2018-05-26 06:46:20',	1,	'2018-05-26 06:58:58',	0,	'Active'),
(2,	1,	'Vegetables',	NULL,	7,	12,	'Yes',	'category/2/web/category1527317189.jpeg',	'category/2/app/category1527317189.jpeg',	'2018-05-26 06:47:20',	1,	'2018-05-26 07:00:16',	0,	'Active'),
(3,	1,	'Grocery',	NULL,	13,	16,	'Yes',	'category/3/web/category1527317626.jpeg',	'category/3/app/category1527317626.jpeg',	'2018-05-26 06:54:38',	1,	'2018-05-26 07:02:17',	0,	'Active'),
(4,	1,	'Sweets',	NULL,	17,	20,	'Yes',	'category/4/web/category1527327495.jpeg',	'category/4/app/category1527327495.jpeg',	'2018-05-26 06:55:55',	1,	'2018-05-26 09:39:25',	1,	'Active'),
(5,	1,	'Dairy',	NULL,	21,	24,	'Yes',	'category/5/web/category1527317743.jpeg',	'category/5/app/category1527317743.jpeg',	'2018-05-26 06:56:34',	1,	'2018-05-26 07:03:23',	0,	'Active'),
(6,	1,	'Seasonal',	1,	2,	3,	'Yes',	'category/6/web/category1527317852.jpeg',	'category/6/app/category1527317852.jpeg',	'2018-05-26 06:58:25',	1,	'2018-05-26 06:58:29',	0,	'Active'),
(7,	1,	'Citrus',	1,	4,	5,	'Yes',	'category/7/web/category1527317886.jpeg',	'category/7/app/category1527317886.jpeg',	'2018-05-26 06:58:58',	1,	'2018-05-26 06:59:02',	0,	'Active'),
(8,	1,	'Exotic',	2,	8,	9,	'Yes',	'category/8/web/category1527317917.jpeg',	'category/8/app/category1527317917.jpeg',	'2018-05-26 06:59:28',	1,	'2018-05-26 06:59:32',	0,	'Active'),
(9,	1,	'Leafies',	2,	10,	11,	'Yes',	'category/9/web/category1527317964.jpeg',	'category/9/app/category1527317964.jpeg',	'2018-05-26 07:00:16',	1,	'2018-05-26 07:00:20',	0,	'Active'),
(10,	1,	'Laddu',	4,	18,	19,	'Yes',	'category/10/web/category1527326902.jpeg',	'category/10/app/category1527326902.jpeg',	'2018-05-26 07:00:58',	1,	'2018-05-26 09:29:28',	1,	'Active'),
(11,	1,	'Dry Fruits & Nuts',	3,	14,	15,	'Yes',	'category/11/web/category1527318085.jpeg',	'category/11/app/category1527318085.jpeg',	'2018-05-26 07:02:17',	1,	'2018-05-26 07:02:20',	0,	'Active'),
(12,	1,	'MIlk',	5,	22,	23,	'Yes',	'category/12/web/category1527318151.jpeg',	'category/12/app/category1527318151.jpeg',	'2018-05-26 07:03:23',	1,	'2018-05-26 07:03:27',	0,	'Active');

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `alise_name` varchar(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active and Deactive',
  `books_beginning_from` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cities` (`id`, `state_id`, `name`, `alise_name`, `created_on`, `created_by`, `status`, `books_beginning_from`) VALUES
(1,	1,	'udaipur',	'UDR',	'2018-05-15 06:01:52',	1,	'Active',	'2018-04-01');

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


DROP TABLE IF EXISTS `combo_offer_details`;
CREATE TABLE `combo_offer_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `combo_offer_id` int(11) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gstin` varchar(50) NOT NULL,
  `pan` varchar(50) NOT NULL,
  `gstin_holder_name` varchar(100) NOT NULL,
  `gstin_holder_address` text NOT NULL,
  `firm_name` varchar(100) NOT NULL,
  `firm_address` text NOT NULL,
  `firm_email` varchar(200) NOT NULL,
  `firm_contact` varchar(200) NOT NULL,
  `firm_pincode` varchar(200) NOT NULL,
  `registration_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `termination_reason` text NOT NULL,
  `breif_decription` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `companies` (`id`, `state_id`, `city_id`, `name`, `gstin`, `pan`, `gstin_holder_name`, `gstin_holder_address`, `firm_name`, `firm_address`, `firm_email`, `firm_contact`, `firm_pincode`, `registration_date`, `termination_date`, `termination_reason`, `breif_decription`, `created_on`, `created_by`, `status`) VALUES
(1,	1,	1,	'Shree Nakoda Agro',	'Aqfxt67uvwx',	'',	'',	'',	'Shree Nakoda Agro',	'Pratap nagar by pass ',	'',	'9874563210',	'313002',	'0000-00-00',	'0000-00-00',	'',	'',	'2018-05-15 10:39:29',	0,	'');

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
  `city_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `contra_vouchers` (`id`, `voucher_no`, `location_id`, `city_id`, `transaction_date`, `narration`, `created_by`, `created_on`, `status`) VALUES
(1,	1,	0,	1,	'2018-05-28',	'40 test',	1,	'2018-05-28 11:11:47',	'');

DROP TABLE IF EXISTS `contra_voucher_rows`;
CREATE TABLE `contra_voucher_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contra_voucher_id` int(11) NOT NULL,
  `cr_dr` varchar(5) NOT NULL,
  `ledger_id` int(11) NOT NULL,
  `debit` decimal(15,2) DEFAULT NULL,
  `credit` decimal(15,2) DEFAULT NULL,
  `mode_of_payment` varchar(20) NOT NULL,
  `cheque_no` varchar(20) NOT NULL,
  `cheque_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `contra_voucher_rows` (`id`, `contra_voucher_id`, `cr_dr`, `ledger_id`, `debit`, `credit`, `mode_of_payment`, `cheque_no`, `cheque_date`) VALUES
(1,	1,	'Dr',	95,	40.00,	NULL,	'',	'',	'0000-00-00'),
(2,	1,	'Cr',	88,	NULL,	40.00,	'Cheque',	'97979414',	'0000-00-00');

DROP TABLE IF EXISTS `credit_notes`;
CREATE TABLE `credit_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(10) NOT NULL,
  `voucher_no` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `total_credit_amount` decimal(15,2) NOT NULL,
  `total_debit_amount` decimal(15,2) NOT NULL,
  `narration` text NOT NULL,
  `created_by` int(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `credit_notes` (`id`, `status`, `voucher_no`, `location_id`, `city_id`, `transaction_date`, `total_credit_amount`, `total_debit_amount`, `narration`, `created_by`, `created_on`) VALUES
(1,	'',	1,	0,	1,	'2018-05-29',	73.00,	73.00,	'73 tstg crdt22',	1,	'2018-05-29 04:40:37');

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

INSERT INTO `credit_note_rows` (`id`, `credit_note_id`, `cr_dr`, `ledger_id`, `debit`, `credit`, `mode_of_payment`, `cheque_no`, `cheque_date`) VALUES
(1,	1,	'Dr',	132,	73.00,	NULL,	'',	'',	NULL),
(2,	1,	'Cr',	133,	NULL,	73.00,	'',	'',	NULL);

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
  `bill_to_bill_accounting` varchar(10) NOT NULL,
  `opening_balance_value` decimal(15,2) NOT NULL,
  `debit_credit` varchar(10) NOT NULL,
  `edited_on` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile_no` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `customers` (`id`, `city_id`, `name`, `email`, `username`, `password`, `otp`, `device_id`, `fcm_token`, `referral_code`, `discount_in_percentage`, `timeout`, `created_on`, `created_by`, `status`, `gstin`, `gstin_holder_name`, `gstin_holder_address`, `firm_name`, `firm_address`, `discount_created_on`, `discount_expiry`, `customer_image`, `token`, `edited_by`, `bill_to_bill_accounting`, `opening_balance_value`, `debit_credit`, `edited_on`) VALUES
(1,	1,	'gopesh Singh',	'VYOM@gmail.com',	'3689796533',	'',	'',	'',	'',	'',	35.00,	0,	'2018-05-16 08:59:36',	1,	'Active',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'vuyom Foundation',	'harsh Nagar',	'2018-06-08 18:30:00',	'2018-11-08 18:30:00',	'',	'',	0,	'',	0.00,	'Dr',	'2018-05-16 09:16:26'),
(2,	1,	'Yash',	'yash@gmail.coim',	'65852.1',	'',	'',	'',	'',	'',	50.00,	0,	'2018-05-16 09:05:00',	1,	'Active',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'raj',	'hr',	'2018-06-08 18:30:00',	'2018-06-08 18:30:00',	'',	'',	0,	'',	0.00,	'Dr',	'2018-05-16 09:16:26'),
(3,	1,	'jtendra',	'jk@gmail.com',	'098765432433',	'',	'',	'',	'',	'',	50.00,	0,	'2018-05-16 09:14:49',	1,	'Active',	'22ASDFR0967W6Z5',	'ytg',	'btg',	'jk ',	'jkb',	'2018-06-08 18:30:00',	'2018-06-08 18:30:00',	'',	'',	0,	'yes',	1000.00,	'Dr',	'2018-05-16 09:16:26'),
(4,	1,	'Rohit Joshi',	'rohit@phppoets.in',	'9887779123',	'$2y$10$QNEqW7Dyiddc9iZhEf7xIORAXigyCnhaNZRPKSM5u3KzXJHBUAeV.',	'',	'',	'',	'',	0.00,	0,	'2018-05-26 13:01:32',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQsImV4cCI6MTUyODI3NDI1NX0.PMJG27bhRcucMDWCrOpZOuIHDHWUiNwOHtIlBOoMSGg',	0,	'',	0.00,	'',	'2018-05-30 08:37:35'),
(5,	1,	'Shelu',	'shelu@abc.com',	'9694981008',	'$2y$10$sdVEru67uEecvm7eFj7Fd.4QLtf6oa3jFoe45JViSvaTeIwdJaidS',	'',	'',	'',	'',	0.00,	0,	'2018-05-28 12:49:07',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjUsImV4cCI6MTUyODM0OTYxN30.nfNJiUu_BZXfrBi1QThPZ01LuYVS-4Ttp8PulmtW8Ks',	0,	'',	0.00,	'',	'2018-05-31 05:33:37'),
(6,	0,	'abc',	'abc@gmail.com',	'8233068030',	'$2y$10$4IDzkw1WkUUTfgB3mHg1E.y/TULAbAGtXfET5PvgAIn51oKYrwWXy',	'',	'ebb29e47edfe0d15',	'eLSjNtdIlLU:APA91bGLaTzpbLa1m2C3ab_tydaxpL6brw_BVmhjgWDIuuSyonRVc9UbrCRwrGsNipjWkHyhB8VEMCKohG3YK9cyhsLDsNsxJTdytOm0zzKBLAkzuRQQGg1nQN3vPcobXg9cAVLbpgSe',	'',	0.00,	0,	'2018-05-28 12:53:41',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjYsImV4cCI6MTUyODExNjgyMX0.7ph4zgThVljmaR9TGqfRAnMbJKoaqSzYhjR1VBxNDRg',	0,	'',	0.00,	'',	'2018-05-28 12:53:41'),
(7,	0,	'Anil Pahadiya',	'anilkumarpahadiya@gmail.com',	'8890999221',	'$2y$10$wn4xzzT1FgMl.Me8ZIKjWOS5CU5eR1K4DGX9rk6Cymp5Jt9UNSqbO',	'',	'',	'',	'',	0.00,	0,	'2018-05-30 11:35:07',	0,	'Active',	'',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjcsImV4cCI6MTUyODM0NzMzNX0.5YDYRtbsjKjP3gQG6nYDEvfa4pxTWkKOwdpg_dh9Cr4',	0,	'',	0.00,	'',	'2018-05-31 04:55:35');

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
(1,	1,	'',	'',	'',	1,	1,	313001,	'67',	'hrsh ngr',	'rmpr',	'',	'',	1,	0),
(2,	2,	'',	'',	'',	1,	1,	5342,	'sdvz',	'sdv',	'sdvzx',	'',	'',	1,	0),
(3,	3,	'',	'',	'',	1,	1,	854674,	'76',	'yrb',	'htgfdbf',	'',	'',	1,	0),
(4,	5,	'abc',	'',	'8233068038',	1,	1,	0,	'140',	'near passport office',	'subhash nagar',	'41.798',	'23.576',	0,	1),
(5,	5,	'abc',	'',	'9352823161',	1,	1,	0,	'140',	'near passport office',	'subhash  nagar',	'41.798',	'23.576',	0,	0),
(6,	5,	'abc',	'',	'8233068030',	1,	1,	0,	'140',	'near passport office',	'Subhash  Nagar ',	'41.798',	'23.576',	0,	0),
(7,	5,	'anc',	'',	'9352823161',	1,	1,	0,	'140',	'near passport office',	'subhash  Nagar ',	'41.798',	'23.576',	0,	0),
(8,	5,	'anc',	'',	'9352823161',	1,	1,	0,	'140',	'near passport office',	'subhash  Nagar ',	'41.798',	'23.576',	0,	0),
(9,	5,	'xy',	'',	'5545664466',	1,	1,	0,	'140',	'near passport office',	'subhash Nagar ',	'41.798',	'23.576',	0,	0),
(10,	5,	'xyz',	'',	'4561267898',	1,	1,	0,	'140',	'near passport office',	'subhash Nagar ',	'41.798',	'23.576',	0,	0),
(11,	5,	'bnn',	'',	'2555585585',	1,	1,	0,	'140',	'near passport office',	'subhash Nagar ',	'41.798',	'23.576',	0,	0),
(12,	5,	'sjjs',	'',	'2222353434',	1,	1,	0,	'140',	'near passport office',	'Subhash Nagar',	'41.798',	'23.576',	0,	0),
(13,	5,	'jrjd',	'',	'2434385788',	1,	1,	0,	'140',	'near passport office',	'subhash Nagar ',	'41.798',	'23.576',	0,	0),
(14,	5,	'st g',	'',	'1222555599',	1,	1,	0,	'dg',	'nff',	'subhash Nagar ',	'41.798',	'23.576',	0,	0),
(15,	5,	'hddjj',	'',	'6544664444',	1,	1,	0,	'hdjd',	'xjdj',	'hsdj',	'41.798',	'23.576',	0,	0),
(16,	5,	'hddjj',	'',	'6544664444',	1,	1,	0,	'hdjd',	'xjdj',	'hsdj',	'41.798',	'23.576',	0,	0),
(17,	5,	'evwveg',	'',	'3361556652',	1,	1,	0,	'2tg32gegg3',	'eh2yh3',	'ef2g',	'41.798',	'23.576',	0,	0);

DROP TABLE IF EXISTS `debit_notes`;
CREATE TABLE `debit_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `total_credit_amount` decimal(15,2) NOT NULL,
  `total_debit_amount` decimal(15,2) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_by` int(5) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `debit_notes` (`id`, `voucher_no`, `location_id`, `city_id`, `total_credit_amount`, `total_debit_amount`, `transaction_date`, `narration`, `status`, `created_by`, `created_on`) VALUES
(1,	1,	0,	1,	721.00,	721.00,	'2018-05-29',	'721 testing',	'',	1,	'2018-05-29 05:47:24');

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

INSERT INTO `debit_note_rows` (`id`, `debit_note_id`, `cr_dr`, `ledger_id`, `debit`, `credit`, `mode_of_payment`, `cheque_no`, `cheque_date`) VALUES
(1,	1,	'Dr',	132,	721.00,	NULL,	'',	'',	NULL),
(2,	1,	'Cr',	86,	NULL,	721.00,	'',	'',	NULL);

DROP TABLE IF EXISTS `delivery_charges`;
CREATE TABLE `delivery_charges` (
  `id` int(10) NOT NULL,
  `city_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `charge` decimal(10,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `delivery_charges` (`id`, `city_id`, `amount`, `charge`, `status`, `created_on`, `created_by`) VALUES
(1,	1,	100.00,	50.00,	'Active',	'2017-06-23 04:40:12',	1);

DROP TABLE IF EXISTS `delivery_dates`;
CREATE TABLE `delivery_dates` (
  `id` int(11) NOT NULL,
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
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `time_from` varchar(15) NOT NULL,
  `time_to` varchar(15) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `delivery_times` (`id`, `city_id`, `time_from`, `time_to`, `status`) VALUES
(1,	1,	'10:00 am',	'01:00 pm',	'Active'),
(2,	1,	'01:00 pm',	'04:00 pm',	'Active'),
(3,	1,	'04:00 pm',	'07:00 pm',	'Active');

DROP TABLE IF EXISTS `drivers`;
CREATE TABLE `drivers` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `location_id` int(10) NOT NULL,
  `device_token` text NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active,Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `drivers` (`id`, `name`, `user_name`, `password`, `mobile_no`, `location_id`, `device_token`, `latitude`, `longitude`, `status`) VALUES
(1,	'Jainthela',	'jain',	'bf76b73579ee889af8815b497e5c6bbe',	'8233334988',	1,	'fZD12x0OGgc:APA91bF4Vy0OuWGYcKLF9PuH-i9vgc-Dv6vxFvkLvcHzRdH62v8JoGIAJiiCYy3c13-0fRuB4gjShofk7Hr1sRflhneuzWsGeuuFJAHqoCgMUSBKByieaQ_w4foZFDtpLZCKNAAniT9M',	'24.5832109',	'73.7220595',	'Active'),
(3,	'Mukesh',	'9116138309',	'3bce4bb5d9664d0cdbdebb659a2846be',	'9116138309',	1,	'e57u8GmleWk:APA91bGK-TvUQgm1iYk2yetnMLRcjF6Pf3OoXP2wG9pHIqri9CyYs9bkuryBEfHA4vZPES2j1k_raJ_od84pdqPlw8OqhibFoWC8iARYU8WZfWdKUrnbP4Db0-j_pvnhLKbAsyBziaS5',	'24.59944128849224',	'73.74629461262217',	'Active'),
(4,	'Omprakash',	'9116138306',	'71d47b98e54bb00d0d3cfd01655cdbe5',	'9116138306',	1,	'c55cc60KS7s:APA91bFe7gYhQEtOdmvBOJt4A4E6MFIC5A9nJ77QY4355hiq_Fsna8wqEjLmMyaYjPodICH_1gLYThvw1G10RWUHRG1eHOg0ZOYPRyO1RxlTSTnRCPCp5x-K4P9J3vySXoc0tArpoM1p',	'24.5893889',	'73.7319605',	'Active'),
(5,	'Rajkumar',	'9116138308',	'eda30fb0bc9402cd26e6b1c2b5e3414a',	'9116138308',	1,	'cHj1eqZU72c:APA91bF_rS1fQoBXTF9NklYIi_m1waTXQPTRoK7WIUXxMcwLERrJyY5_6-wzKIcEbt8B8lLEJ8W5d8oE38BQ209fe_VSbbmczVj_fA-Hvm2VMFyLPuFYuL5sHShhh_dR2WCsEs-dV3is',	'24.5841984',	'73.6865467',	'Active'),
(6,	'Manish Mishra',	'302',	'577bcc914f9e55d5e4e4f82f9f00e7d4',	'9116138302',	1,	'cSnEWhAKaz4:APA91bFQu0Rhf7zMoxtiVVxle6Yzqbp-lYYeebZe5KPppW7admAyJRC9rdjoacSq8254T6tfd0QnrLy2iWuEWqzLjaL5PyFIw2Svx-7VcmwXbh91HJ7cLOcJSaU2ymQ3zByfc81YIwSr',	'24.5991378',	'73.7461653',	'Active'),
(7,	'narendra singh',	'9116138307',	'ec895a564d707ee4a7c18f1e611f83ab',	'9116138307',	1,	'cm7OxQD00Hg:APA91bGf895ED3En1MSiVXKW1VaeJ0kQFb5kDZkvnCNlumqeY0MIEpxLezhf6O2KG5UCY7BB4Gw1aubf9vU4oPiWWm7rBt0ip0I-oH-sJ-2IuT-tXXgySMM2GEkSfmpV41kBupth1037',	'24.591910871440227',	'73.70019295718284',	'Active'),
(9,	'heera lal',	'9116138303',	'c8837b23ff8aaa8a2dde915473ce0991',	'9116138303',	1,	'AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU',	'24.5950658',	'73.7424533',	'Active'),
(10,	'Gopesh Singh Parihar1',	'gopsa2',	'$2y$10$tKP4bMj464Th4Kyap5NdvOBYQXeFZZxTHKCKJEmgGLcFQp./UST/G',	'8233199721',	1,	'',	'',	'',	'Active'),
(11,	'Gopesh Singh Parihar',	'gopsa1',	'$2y$10$/LrMSbTcQXsYm.m9wZy2dezvg6AJ1sE.lHTCQbEXPfB6dr06RULBG',	'8233199728',	2,	'',	'',	'',	'Active');

DROP TABLE IF EXISTS `driver_locations`;
CREATE TABLE `driver_locations` (
  `id` int(11) NOT NULL,
  `drive_id` int(11) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `express_deliveries`;
CREATE TABLE `express_deliveries` (
  `id` int(11) NOT NULL,
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
(3,	'Test',	'express_delivery/3/app/express1524724939.png',	'express_delivery/3/web/express1524724939.png',	'Testings',	'Active',	2);

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
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
(5,	1,	'What is the return process?',	'Please read our Return Policy.',	0),
(6,	1,	'Are You ?',	'YEs.\r\n',	1);

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
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
(34,	1,	1,	'vivek',	'vivek@gmail.com',	'123456789',	'start',	'2018-04-25 09:59:35'),
(35,	11,	1,	'Shailendra Nagori',	'shelunagori@abc.com',	'9694981008',	'hello',	'2018-05-02 13:03:48'),
(36,	1,	1,	'priyanka',	'priyankajinger0@gmail.com',	'1234567890',	'good',	'2018-05-04 05:33:48'),
(37,	1,	1,	'priyanka',	'priyankajinger0@gmail.com',	'1234567890',	'good',	'2018-05-04 05:35:50'),
(38,	1,	1,	'priyanka',	'priyankajinger0@gmail.com',	'1234567890',	'good',	'2018-05-04 05:42:46'),
(39,	1,	1,	'priyanka',	'priyankajinger0@gmail.com',	'9694561206',	'asdfgh',	'2018-05-04 06:52:52'),
(40,	1,	1,	'priyanka',	'priyankajinger0@gmail.com',	'1234567890',	'hfdgsfd',	'2018-05-04 06:54:54'),
(41,	33,	1,	'rohit',	'rohit@gmail.com',	'9887779123',	'hellonvjdnsdknckdsncknskcndkjcnkdnsjnkjckj',	'2018-05-04 12:54:23'),
(42,	33,	1,	'rohit',	'rohit@gmail.com',	'9887779123',	'hello',	'2018-05-04 12:54:37'),
(43,	33,	1,	'rohit',	'rohit@gmail.com',	'9887779123',	'hello',	'2018-05-04 13:01:54'),
(44,	33,	1,	'rohit',	'rohit@gmail.com',	'9887779123',	'hello',	'2018-05-04 13:04:17'),
(45,	33,	1,	'rohit',	'rohit@gmail.com',	'9887779123',	'hello',	'2018-05-04 13:24:00'),
(46,	33,	1,	'Cmdhakar',	'cm124@gmail.com',	'9649427857',	'On Wed Dec the bes5554335yt way to ',	'2018-05-04 13:32:44'),
(47,	41,	1,	'jonty',	'jonty@gmail.com',	'9352823161',	'Jonty ',	'2018-05-05 10:15:18'),
(48,	35,	1,	'Dhakar',	'Cm@gmail.com',	'8852902100',	'hbvibib',	'2018-05-14 09:16:32'),
(49,	33,	1,	'rohit',	'rohit@gmail.com',	'9887779123',	'hello',	'2018-05-14 13:05:43'),
(50,	33,	1,	'rohit',	'rohit@gmail.com',	'9887779123',	'hello',	'2018-05-14 13:09:16'),
(51,	33,	1,	'rohit',	'rohit@gmail.com',	'9887779123',	'hello',	'2018-05-14 13:18:55');

DROP TABLE IF EXISTS `filters`;
CREATE TABLE `filters` (
  `id` int(11) NOT NULL,
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
  `city_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `location_id` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `financial_years` (`id`, `fy_from`, `fy_to`, `status`, `city_id`) VALUES
(1,	'2018-04-01',	'2019-03-31',	'open',	1),
(2,	'2018-04-01',	'2019-03-31',	'open',	3);

DROP TABLE IF EXISTS `grns`;
CREATE TABLE `grns` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) DEFAULT NULL,
  `super_admin_id` int(11) DEFAULT NULL,
  `vendor_ledger_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `voucher_no` int(10) NOT NULL,
  `grn_no` varchar(100) NOT NULL,
  `location_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `total_gst` decimal(15,2) NOT NULL,
  `total_purchase_rate` decimal(15,2) NOT NULL,
  `total_sales_rate` decimal(15,2) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `created_for` varchar(20) NOT NULL,
  `stock_transfer_status` varchar(20) NOT NULL DEFAULT 'Pending',
  `purchase_invoice_status` varchar(20) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `grns` (`id`, `seller_id`, `super_admin_id`, `vendor_ledger_id`, `city_id`, `voucher_no`, `grn_no`, `location_id`, `order_id`, `transaction_date`, `reference_no`, `total_gst`, `total_purchase_rate`, `total_sales_rate`, `created_on`, `status`, `created_for`, `stock_transfer_status`, `purchase_invoice_status`) VALUES
(1,	1,	NULL,	95,	1,	1,	'RJ/UDR/1',	0,	1,	'2018-05-25',	NULL,	0.00,	27.00,	30.00,	'2018-05-25 06:00:34',	'Pending',	'Seller',	'Pending',	'Complete'),
(2,	NULL,	1,	129,	1,	2,	'1',	0,	0,	'2018-05-25',	'12345',	0.00,	12000.00,	14000.00,	'2018-05-26 07:42:56',	'Pending',	'Jainthela',	'Pending',	'Complete'),
(3,	NULL,	1,	129,	1,	3,	'1',	0,	0,	'2018-05-26',	'12345',	0.00,	59000.00,	0.00,	'0000-00-00 00:00:00',	'Pending',	'Jainthela',	'Pending',	'Pending');

DROP TABLE IF EXISTS `grn_rows`;
CREATE TABLE `grn_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `unit_variation_id` int(10) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `transfer_quantity` decimal(15,2) NOT NULL,
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

INSERT INTO `grn_rows` (`id`, `grn_id`, `item_id`, `unit_variation_id`, `item_variation_id`, `quantity`, `transfer_quantity`, `rate`, `taxable_value`, `net_amount`, `gst_percentage`, `gst_value`, `purchase_rate`, `sales_rate`, `gst_type`, `mrp`) VALUES
(1,	1,	1,	1,	3,	12.00,	0.00,	0.00,	0.00,	0.00,	0,	0.00,	27.00,	30.00,	'',	0.00),
(2,	2,	1,	1,	0,	100.00,	98.00,	0.00,	0.00,	12000.00,	0,	0.00,	120.00,	140.00,	'',	0.00),
(3,	3,	1,	1,	0,	500.00,	0.00,	0.00,	0.00,	25000.00,	0,	0.00,	50.00,	0.00,	'',	0.00),
(4,	3,	5,	1,	0,	400.00,	0.00,	0.00,	0.00,	24000.00,	0,	0.00,	60.00,	0.00,	'',	0.00),
(5,	3,	4,	2,	0,	500.00,	0.00,	0.00,	0.00,	10000.00,	0,	0.00,	20.00,	0.00,	'',	0.00);

DROP TABLE IF EXISTS `gst_figures`;
CREATE TABLE `gst_figures` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `city_id` int(10) NOT NULL,
  `tax_percentage` decimal(5,2) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL COMMENT 'active or deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `gst_figures` (`id`, `name`, `city_id`, `tax_percentage`, `created_by`, `created_on`, `status`) VALUES
(1,	'0%',	1,	0.00,	0,	'2018-05-15 09:00:23',	''),
(2,	'5%',	1,	5.00,	0,	'2018-05-15 09:00:23',	''),
(3,	'12%',	1,	12.00,	0,	'2018-05-15 09:00:23',	''),
(4,	'18%',	1,	18.00,	0,	'2018-05-15 09:00:23',	''),
(5,	'28%',	1,	28.00,	0,	'2018-05-15 09:00:23',	''),
(6,	'0%',	3,	0.00,	0,	'2018-05-25 06:44:18',	''),
(7,	'5%',	3,	5.00,	0,	'2018-05-25 06:44:21',	''),
(8,	'12%',	3,	12.00,	0,	'2018-05-25 06:44:24',	''),
(9,	'18%',	3,	18.00,	0,	'2018-05-25 06:44:30',	''),
(10,	'28%',	3,	28.00,	0,	'2018-05-25 06:44:34',	'');

DROP TABLE IF EXISTS `history_item_variations`;
CREATE TABLE `history_item_variations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `unit_variation_id` int(11) NOT NULL,
  `item_variation_master_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `current_stock` decimal(15,2) NOT NULL,
  `add_stock` decimal(15,2) NOT NULL,
  `purchase_rate` decimal(10,2) NOT NULL,
  `print_rate` decimal(10,2) NOT NULL,
  `discount_per` decimal(6,2) NOT NULL,
  `commission` decimal(5,2) NOT NULL,
  `sales_rate` decimal(10,2) NOT NULL,
  `mrp` decimal(15,2) NOT NULL,
  `maximum_quantity_purchase` int(10) NOT NULL,
  `out_of_stock` varchar(5) NOT NULL,
  `ready_to_sale` varchar(5) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_on` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `section_show` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `history_item_variations` (`id`, `item_id`, `city_id`, `unit_variation_id`, `item_variation_master_id`, `seller_id`, `current_stock`, `add_stock`, `purchase_rate`, `print_rate`, `discount_per`, `commission`, `sales_rate`, `mrp`, `maximum_quantity_purchase`, `out_of_stock`, `ready_to_sale`, `created_on`, `update_on`, `status`, `section_show`) VALUES
(1,	1,	1,	1,	6,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-25 05:00:13',	'0000-00-00',	'Deactive',	'No'),
(2,	1,	1,	2,	7,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-25 05:00:14',	'0000-00-00',	'Deactive',	'No'),
(3,	1,	1,	1,	6,	1,	60.00,	0.00,	27.00,	0.00,	0.00,	10.00,	30.00,	35.00,	50,	'Yes',	'Yes',	'2018-05-25 05:07:48',	'0000-00-00',	'Deactive',	'Yes'),
(4,	1,	1,	2,	7,	1,	80.00,	0.00,	39.00,	0.00,	0.00,	10.00,	43.00,	43.00,	80,	'Yes',	'Yes',	'2018-05-25 05:07:49',	'0000-00-00',	'Deactive',	'Yes'),
(5,	1,	1,	1,	6,	1,	60.00,	0.00,	27.00,	0.00,	0.00,	10.00,	30.00,	35.00,	50,	'Yes',	'Yes',	'2018-05-25 05:07:48',	'0000-00-00',	'Active',	'Yes'),
(6,	1,	1,	2,	7,	1,	80.00,	0.00,	39.00,	0.00,	0.00,	10.00,	43.00,	43.00,	80,	'Yes',	'Yes',	'2018-05-25 05:07:49',	'0000-00-00',	'Active',	'Yes'),
(7,	1,	1,	1,	6,	1,	48.00,	0.00,	27.00,	0.00,	0.00,	10.00,	30.00,	35.00,	50,	'No',	'Yes',	'2018-05-25 05:07:48',	'0000-00-00',	'Active',	'Yes'),
(8,	1,	1,	1,	1,	NULL,	0.00,	0.00,	64.00,	0.00,	0.00,	0.00,	65.00,	65.00,	10,	'Yes',	'Yes',	'2018-05-25 05:00:13',	'0000-00-00',	'Deactive',	'Yes'),
(9,	1,	1,	2,	2,	NULL,	0.00,	0.00,	40.00,	0.00,	0.00,	0.00,	40.00,	40.00,	5,	'Yes',	'Yes',	'2018-05-25 05:00:14',	'0000-00-00',	'Deactive',	'Yes'),
(10,	1,	1,	1,	1,	NULL,	73.00,	73.00,	120.00,	0.00,	0.00,	0.00,	150.00,	150.00,	10,	'No',	'Yes',	'2018-05-25 05:00:13',	'2018-05-25',	'Active',	'Yes'),
(11,	1,	1,	2,	2,	NULL,	100.00,	100.00,	30.00,	0.00,	0.00,	0.00,	50.00,	50.00,	5,	'No',	'Yes',	'2018-05-25 05:00:14',	'2018-05-25',	'Active',	'Yes'),
(12,	5,	1,	1,	9,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 07:18:07',	'0000-00-00',	'Deactive',	'No'),
(13,	4,	1,	1,	7,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 07:19:16',	'0000-00-00',	'Deactive',	'No'),
(14,	4,	1,	2,	8,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 07:19:17',	'0000-00-00',	'Deactive',	'No'),
(15,	1,	1,	1,	1,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 07:56:00',	'0000-00-00',	'Deactive',	'No'),
(16,	1,	1,	2,	2,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 07:56:01',	'0000-00-00',	'Deactive',	'No'),
(17,	1,	1,	1,	1,	1,	20.00,	0.00,	55.00,	0.00,	0.00,	9.00,	60.00,	60.00,	10,	'Yes',	'Yes',	'2018-05-26 08:08:07',	'0000-00-00',	'Deactive',	'Yes'),
(18,	1,	1,	2,	2,	1,	15.00,	0.00,	32.00,	0.00,	0.00,	9.00,	35.00,	35.00,	10,	'Yes',	'Yes',	'2018-05-26 08:08:08',	'0000-00-00',	'Deactive',	'Yes'),
(19,	2,	1,	1,	3,	1,	12.00,	0.00,	73.00,	0.00,	0.00,	9.00,	80.00,	80.00,	3,	'Yes',	'Yes',	'2018-05-26 08:08:43',	'0000-00-00',	'Deactive',	'Yes'),
(20,	2,	1,	2,	4,	1,	15.00,	0.00,	23.00,	0.00,	0.00,	9.00,	25.00,	25.00,	6,	'Yes',	'Yes',	'2018-05-26 08:08:43',	'0000-00-00',	'Deactive',	'Yes'),
(21,	3,	1,	1,	5,	1,	12.00,	0.00,	29.00,	0.00,	0.00,	3.00,	30.00,	30.00,	7,	'Yes',	'Yes',	'2018-05-26 08:09:12',	'0000-00-00',	'Deactive',	'Yes'),
(22,	3,	1,	2,	6,	1,	6.00,	0.00,	16.00,	0.00,	0.00,	3.00,	16.00,	16.00,	4,	'Yes',	'Yes',	'2018-05-26 08:09:12',	'0000-00-00',	'Deactive',	'Yes'),
(23,	4,	1,	1,	7,	1,	20.00,	0.00,	11.00,	0.00,	0.00,	6.00,	12.00,	12.00,	20,	'Yes',	'Yes',	'2018-05-26 08:09:47',	'0000-00-00',	'Deactive',	'Yes'),
(24,	4,	1,	2,	8,	1,	20.00,	0.00,	5.00,	0.00,	0.00,	6.00,	5.00,	5.00,	30,	'Yes',	'Yes',	'2018-05-26 08:09:47',	'0000-00-00',	'Deactive',	'Yes'),
(25,	5,	1,	1,	9,	1,	30.00,	0.00,	35.00,	0.00,	0.00,	2.00,	36.00,	36.00,	10,	'Yes',	'Yes',	'2018-05-26 08:10:07',	'0000-00-00',	'Deactive',	'Yes'),
(26,	7,	1,	1,	11,	1,	50.00,	0.00,	118.00,	0.00,	0.00,	2.00,	120.00,	120.00,	100,	'Yes',	'Yes',	'2018-05-26 08:10:31',	'0000-00-00',	'Deactive',	'Yes'),
(27,	1,	1,	1,	1,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 07:56:00',	'0000-00-00',	'Deactive',	'No'),
(28,	1,	1,	2,	2,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 07:56:01',	'0000-00-00',	'Deactive',	'No'),
(29,	6,	1,	1,	10,	1,	90.00,	0.00,	437.00,	0.00,	0.00,	3.00,	450.00,	450.00,	60,	'Yes',	'Yes',	'2018-05-26 08:10:57',	'0000-00-00',	'Deactive',	'Yes'),
(30,	8,	1,	1,	12,	1,	200.00,	0.00,	40.00,	0.00,	0.00,	1.00,	40.00,	40.00,	12,	'Yes',	'Yes',	'2018-05-26 08:11:41',	'0000-00-00',	'Deactive',	'Yes'),
(31,	8,	1,	2,	13,	1,	150.00,	0.00,	25.00,	0.00,	0.00,	1.00,	25.00,	25.00,	14,	'Yes',	'Yes',	'2018-05-26 08:11:42',	'0000-00-00',	'Deactive',	'Yes'),
(32,	1,	1,	1,	1,	1,	20.00,	0.00,	55.00,	0.00,	0.00,	9.00,	60.00,	60.00,	10,	'Yes',	'Yes',	'2018-05-26 08:08:07',	'0000-00-00',	'Active',	'Yes'),
(33,	2,	1,	1,	3,	1,	12.00,	0.00,	73.00,	0.00,	0.00,	9.00,	80.00,	80.00,	3,	'Yes',	'Yes',	'2018-05-26 08:08:43',	'0000-00-00',	'Active',	'Yes'),
(34,	3,	1,	1,	5,	1,	12.00,	0.00,	29.00,	0.00,	0.00,	3.00,	30.00,	30.00,	7,	'Yes',	'Yes',	'2018-05-26 08:09:12',	'0000-00-00',	'Active',	'Yes'),
(35,	4,	1,	1,	7,	1,	20.00,	0.00,	11.00,	0.00,	0.00,	6.00,	12.00,	12.00,	20,	'Yes',	'Yes',	'2018-05-26 08:09:47',	'0000-00-00',	'Active',	'Yes'),
(36,	5,	1,	1,	9,	1,	30.00,	0.00,	35.00,	0.00,	0.00,	2.00,	36.00,	36.00,	10,	'Yes',	'Yes',	'2018-05-26 08:10:07',	'0000-00-00',	'Active',	'Yes'),
(37,	7,	1,	1,	11,	1,	50.00,	0.00,	118.00,	0.00,	0.00,	2.00,	120.00,	120.00,	100,	'Yes',	'Yes',	'2018-05-26 08:10:31',	'0000-00-00',	'Active',	'Yes'),
(38,	6,	1,	1,	10,	1,	90.00,	0.00,	437.00,	0.00,	0.00,	3.00,	450.00,	450.00,	60,	'Yes',	'Yes',	'2018-05-26 08:10:57',	'0000-00-00',	'Active',	'Yes'),
(39,	8,	1,	1,	12,	1,	200.00,	0.00,	40.00,	0.00,	0.00,	1.00,	40.00,	40.00,	12,	'Yes',	'Yes',	'2018-05-26 08:11:41',	'0000-00-00',	'Active',	'Yes'),
(40,	1,	1,	2,	2,	1,	15.00,	0.00,	32.00,	0.00,	0.00,	9.00,	35.00,	35.00,	10,	'Yes',	'Yes',	'2018-05-26 08:08:08',	'0000-00-00',	'Active',	'Yes'),
(41,	2,	1,	2,	4,	1,	15.00,	0.00,	23.00,	0.00,	0.00,	9.00,	25.00,	25.00,	6,	'Yes',	'Yes',	'2018-05-26 08:08:43',	'0000-00-00',	'Active',	'Yes'),
(42,	3,	1,	2,	6,	1,	6.00,	0.00,	16.00,	0.00,	0.00,	3.00,	16.00,	16.00,	4,	'Yes',	'Yes',	'2018-05-26 08:09:12',	'0000-00-00',	'Active',	'Yes'),
(43,	4,	1,	2,	8,	1,	20.00,	0.00,	5.00,	0.00,	0.00,	6.00,	5.00,	5.00,	30,	'Yes',	'Yes',	'2018-05-26 08:09:47',	'0000-00-00',	'Active',	'Yes'),
(44,	8,	1,	2,	13,	1,	150.00,	0.00,	25.00,	0.00,	0.00,	1.00,	25.00,	25.00,	14,	'Yes',	'Yes',	'2018-05-26 08:11:42',	'0000-00-00',	'Deactive',	'Yes'),
(45,	5,	1,	1,	9,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:18:07',	'0000-00-00',	'Deactive',	'No'),
(46,	4,	1,	1,	7,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:19:16',	'0000-00-00',	'Deactive',	'No'),
(47,	4,	1,	2,	8,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:19:17',	'0000-00-00',	'Deactive',	'No'),
(48,	1,	1,	1,	1,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:56:00',	'0000-00-00',	'Deactive',	'No'),
(49,	1,	1,	2,	2,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:56:01',	'0000-00-00',	'Deactive',	'No'),
(50,	1,	1,	1,	1,	1,	20.00,	0.00,	55.00,	0.00,	0.00,	9.00,	60.00,	60.00,	10,	'No',	'Yes',	'2018-05-26 08:08:07',	'0000-00-00',	'Active',	'Yes'),
(51,	1,	1,	2,	2,	1,	15.00,	0.00,	32.00,	0.00,	0.00,	9.00,	35.00,	35.00,	10,	'No',	'Yes',	'2018-05-26 08:08:08',	'0000-00-00',	'Active',	'Yes'),
(52,	2,	1,	1,	3,	1,	12.00,	0.00,	73.00,	0.00,	0.00,	9.00,	80.00,	80.00,	3,	'No',	'Yes',	'2018-05-26 08:08:43',	'0000-00-00',	'Active',	'Yes'),
(53,	2,	1,	2,	4,	1,	15.00,	0.00,	23.00,	0.00,	0.00,	9.00,	25.00,	25.00,	6,	'No',	'Yes',	'2018-05-26 08:08:43',	'0000-00-00',	'Active',	'Yes'),
(54,	3,	1,	1,	5,	1,	12.00,	0.00,	29.00,	0.00,	0.00,	3.00,	30.00,	30.00,	7,	'No',	'Yes',	'2018-05-26 08:09:12',	'0000-00-00',	'Active',	'Yes'),
(55,	3,	1,	2,	6,	1,	6.00,	0.00,	16.00,	0.00,	0.00,	3.00,	16.00,	16.00,	4,	'No',	'Yes',	'2018-05-26 08:09:12',	'0000-00-00',	'Active',	'Yes'),
(56,	4,	1,	1,	7,	1,	20.00,	0.00,	11.00,	0.00,	0.00,	6.00,	12.00,	12.00,	20,	'No',	'Yes',	'2018-05-26 08:09:47',	'0000-00-00',	'Active',	'Yes'),
(57,	4,	1,	2,	8,	1,	20.00,	0.00,	5.00,	0.00,	0.00,	6.00,	5.00,	5.00,	30,	'No',	'Yes',	'2018-05-26 08:09:47',	'0000-00-00',	'Active',	'Yes'),
(58,	5,	1,	1,	9,	1,	30.00,	0.00,	35.00,	0.00,	0.00,	2.00,	36.00,	36.00,	10,	'No',	'Yes',	'2018-05-26 08:10:07',	'0000-00-00',	'Active',	'Yes'),
(59,	7,	1,	1,	11,	1,	50.00,	0.00,	118.00,	0.00,	0.00,	2.00,	120.00,	120.00,	100,	'No',	'Yes',	'2018-05-26 08:10:31',	'0000-00-00',	'Active',	'Yes'),
(60,	6,	1,	1,	10,	1,	90.00,	0.00,	437.00,	0.00,	0.00,	3.00,	450.00,	450.00,	60,	'No',	'Yes',	'2018-05-26 08:10:57',	'0000-00-00',	'Active',	'Yes'),
(61,	8,	1,	1,	12,	1,	200.00,	0.00,	40.00,	0.00,	0.00,	1.00,	40.00,	40.00,	12,	'No',	'Yes',	'2018-05-26 08:11:41',	'0000-00-00',	'Active',	'Yes'),
(62,	8,	1,	2,	13,	1,	150.00,	0.00,	25.00,	0.00,	0.00,	1.00,	25.00,	25.00,	14,	'No',	'Yes',	'2018-05-26 08:11:42',	'0000-00-00',	'Deactive',	'Yes'),
(63,	1,	1,	1,	1,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:56:00',	'0000-00-00',	'Deactive',	'No'),
(64,	1,	1,	2,	2,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:56:01',	'0000-00-00',	'Deactive',	'No'),
(65,	5,	1,	1,	9,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:18:07',	'0000-00-00',	'Deactive',	'No'),
(66,	4,	1,	1,	7,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:19:16',	'0000-00-00',	'Deactive',	'No'),
(67,	4,	1,	2,	8,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:19:17',	'0000-00-00',	'Deactive',	'No'),
(68,	1,	1,	1,	1,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:56:00',	'0000-00-00',	'Deactive',	'No'),
(69,	1,	1,	2,	2,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:56:01',	'0000-00-00',	'Deactive',	'No'),
(70,	4,	1,	1,	7,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:19:16',	'0000-00-00',	'Deactive',	'Yes'),
(71,	4,	1,	2,	8,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:19:17',	'0000-00-00',	'Deactive',	'Yes'),
(72,	4,	1,	1,	7,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:19:16',	'0000-00-00',	'Deactive',	'Yes'),
(73,	4,	1,	2,	8,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:19:17',	'0000-00-00',	'Deactive',	'Yes'),
(74,	1,	1,	1,	1,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:56:00',	'0000-00-00',	'Deactive',	'No'),
(75,	1,	1,	1,	1,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:56:00',	'0000-00-00',	'Deactive',	'No'),
(76,	1,	1,	1,	3,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 12:04:55',	'0000-00-00',	'Deactive',	'Yes'),
(77,	1,	1,	1,	3,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 12:04:55',	'0000-00-00',	'Deactive',	'Yes'),
(78,	1,	1,	1,	3,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 12:04:55',	'0000-00-00',	'Deactive',	'Yes');

DROP TABLE IF EXISTS `home_screens`;
CREATE TABLE `home_screens` (
  `id` int(11) NOT NULL,
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
(3,	'Dry Fruits',	'horizontal',	'Yes',	3,	8,	'Home',	'Category',	1,	'',	'category_wise',	5),
(4,	'Medicin',	'horizontal',	'Yes',	4,	2,	'Home',	'Category',	1,	'',	'',	8),
(5,	'Other Releted Items',	'horizontal',	'Yes',	1,	0,	'Product Detail',	'Items',	1,	'',	'',	9),
(6,	'Banner',	'banner',	'Yes',	1,	0,	'Home',	'Banners',	1,	'',	'',	1),
(7,	'Store Directory',	'store directory',	'Yes',	6,	0,	'Home',	'SubCategory',	1,	'',	'',	3),
(8,	'Shop By Category',	'horizental',	'Yes',	7,	0,	'Home',	'MainCategory',	1,	'',	'category_wise',	4),
(9,	'Tie Image',	'tie up',	'Yes',	8,	0,	'Home',	'Combooffer',	1,	'',	'',	10),
(10,	'Single Image & two Item',	'Single Image & two Item',	'Yes',	9,	1,	'Home',	'Categorytwoitem',	1,	'image',	'',	11),
(11,	'Combo offers',	'combo_offer',	'Yes',	8,	0,	'Home',	'Combooffer',	1,	'',	'item_wise_combo',	2),
(12,	'Test1',	'circle',	'No',	3,	2,	'Product Detail',	'Brands',	1,	'homeScreen/12/app/homeScreen1525240514.jpeg',	'combo_description',	3),
(13,	'Last Screen',	'horizontal',	'Yes',	10,	3,	'Home',	'Category',	1,	'',	'category_wise',	10);

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
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `approve` varchar(15) NOT NULL DEFAULT 'Approved' COMMENT 'Pending/Approved/Not Approved, By default Pending',
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  `section_show` varchar(10) NOT NULL COMMENT 'Show Item For App',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `items` (`id`, `category_id`, `admin_id`, `seller_id`, `city_id`, `brand_id`, `name`, `alias_name`, `description`, `minimum_stock`, `next_day_requirement`, `request_for_sample`, `default_grade`, `tax`, `gst_figure_id`, `item_maintain_by`, `created_on`, `edited_on`, `approve`, `status`, `section_show`) VALUES
(1,	6,	0,	0,	1,	0,	'Apple',	'Seb',	'Regular Kashmiri APple',	10.00,	0.00,	'No',	'',	0.00,	3,	'',	'2018-05-26 07:41:46',	'2018-05-26 07:41:46',	'Approved',	'Active',	'Yes'),
(2,	6,	0,	0,	1,	0,	'Mango',	'',	'',	20.00,	0.00,	'No',	'',	0.00,	1,	'',	'2018-05-26 07:05:32',	'0000-00-00 00:00:00',	'Approved',	'Active',	'Yes'),
(3,	7,	0,	0,	1,	0,	'Orange',	'santra',	'',	25.00,	0.00,	'No',	'',	0.00,	1,	'',	'2018-05-26 07:09:16',	'0000-00-00 00:00:00',	'Approved',	'Active',	'Yes'),
(4,	8,	0,	0,	1,	0,	'Methi',	'Methi',	'',	25.00,	0.00,	'No',	'',	0.00,	1,	'',	'2018-05-26 07:10:48',	'0000-00-00 00:00:00',	'Approved',	'Active',	'Yes'),
(5,	9,	0,	0,	1,	0,	'Palak',	'Palak',	'Palak',	23.00,	0.00,	'No',	'',	0.00,	1,	'',	'2018-05-26 07:12:17',	'0000-00-00 00:00:00',	'Approved',	'Active',	'Yes'),
(6,	11,	0,	0,	1,	0,	'Almonds',	'Badam',	'',	60.00,	0.00,	'No',	'',	0.00,	1,	'',	'2018-05-26 07:13:53',	'0000-00-00 00:00:00',	'Approved',	'Active',	'Yes'),
(7,	10,	0,	0,	1,	0,	'Bunddi Laddu',	'Laddu',	'Fresh BUtter',	100.00,	0.00,	'No',	'',	0.00,	1,	'',	'2018-05-26 07:15:35',	'0000-00-00 00:00:00',	'Approved',	'Active',	'Yes'),
(8,	12,	0,	0,	1,	0,	'milk',	'',	'',	90.00,	0.00,	'No',	'',	0.00,	1,	'',	'2018-05-26 07:31:27',	'0000-00-00 00:00:00',	'Approved',	'Active',	'Yes');

DROP TABLE IF EXISTS `item_ledgers`;
CREATE TABLE `item_ledgers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_id` int(10) NOT NULL,
  `unit_variation_id` int(10) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `rate` decimal(15,2) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_detail_id` int(11) NOT NULL,
  `grn_id` int(11) NOT NULL,
  `grn_row_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `is_opening_balance` varchar(10) DEFAULT NULL,
  `sale_rate` decimal(15,2) DEFAULT NULL,
  `purchase_rate` decimal(10,2) NOT NULL,
  `location_id` int(10) NOT NULL,
  `credit_note_id` int(11) NOT NULL,
  `credit_note_row_id` int(11) NOT NULL,
  `sale_return_id` int(11) DEFAULT NULL,
  `sale_return_row_id` int(11) DEFAULT NULL,
  `stock_transfer_voucher_id` int(11) NOT NULL,
  `stock_transfer_voucher_row_id` int(11) NOT NULL,
  `purchase_invoice_id` int(11) DEFAULT NULL,
  `purchase_invoice_row_id` int(11) DEFAULT NULL,
  `purchase_return_id` int(11) DEFAULT NULL,
  `purchase_return_row_id` int(11) DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `entry_from` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `item_ledgers` (`id`, `item_id`, `unit_variation_id`, `item_variation_id`, `seller_id`, `transaction_date`, `quantity`, `rate`, `amount`, `order_id`, `order_detail_id`, `grn_id`, `grn_row_id`, `status`, `is_opening_balance`, `sale_rate`, `purchase_rate`, `location_id`, `credit_note_id`, `credit_note_row_id`, `sale_return_id`, `sale_return_row_id`, `stock_transfer_voucher_id`, `stock_transfer_voucher_row_id`, `purchase_invoice_id`, `purchase_invoice_row_id`, `purchase_return_id`, `purchase_return_row_id`, `city_id`, `entry_from`) VALUES
(1,	1,	1,	0,	NULL,	'2018-05-26',	500.00,	50.00,	25000.00,	0,	0,	3,	3,	'In',	NULL,	NULL,	0.00,	0,	0,	0,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	1,	''),
(2,	5,	1,	0,	NULL,	'2018-05-26',	400.00,	60.00,	24000.00,	0,	0,	3,	4,	'In',	NULL,	NULL,	0.00,	0,	0,	0,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	1,	''),
(3,	4,	2,	0,	NULL,	'2018-05-26',	500.00,	20.00,	10000.00,	0,	0,	3,	5,	'In',	NULL,	NULL,	0.00,	0,	0,	0,	NULL,	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL,	1,	'');

DROP TABLE IF EXISTS `item_review_ratings`;
CREATE TABLE `item_review_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `item_variations`;
CREATE TABLE `item_variations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `seller_item_id` int(11) NOT NULL,
  `unit_variation_id` int(11) NOT NULL,
  `item_variation_master_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `current_stock` decimal(15,2) NOT NULL,
  `add_stock` decimal(15,2) NOT NULL,
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
  `section_show` varchar(10) NOT NULL DEFAULT 'Yes' COMMENT 'Iteam show for app screen ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `item_variations` (`id`, `item_id`, `city_id`, `seller_item_id`, `unit_variation_id`, `item_variation_master_id`, `seller_id`, `current_stock`, `add_stock`, `purchase_rate`, `print_rate`, `discount_per`, `commission`, `sales_rate`, `mrp`, `maximum_quantity_purchase`, `out_of_stock`, `ready_to_sale`, `created_on`, `update_on`, `status`, `section_show`) VALUES
(1,	5,	1,	3,	1,	9,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:18:07',	'0000-00-00',	'Deactive',	'No'),
(3,	4,	1,	4,	2,	8,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:19:17',	'0000-00-00',	'Deactive',	'Yes'),
(5,	1,	1,	2,	2,	2,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'No',	'No',	'2018-05-26 07:56:01',	'0000-00-00',	'Deactive',	'No'),
(6,	1,	1,	1,	1,	1,	1,	20.00,	0.00,	55.00,	0.00,	0.00,	9.00,	60.00,	60.00,	10,	'No',	'Yes',	'2018-05-26 08:08:07',	'0000-00-00',	'Active',	'Yes'),
(7,	1,	1,	1,	2,	2,	1,	15.00,	0.00,	32.00,	0.00,	0.00,	9.00,	35.00,	35.00,	10,	'No',	'Yes',	'2018-05-26 08:08:08',	'0000-00-00',	'Active',	'Yes'),
(8,	2,	1,	5,	1,	3,	1,	12.00,	0.00,	73.00,	0.00,	0.00,	9.00,	80.00,	80.00,	3,	'No',	'Yes',	'2018-05-26 08:08:43',	'0000-00-00',	'Active',	'Yes'),
(9,	2,	1,	5,	2,	4,	1,	15.00,	0.00,	23.00,	0.00,	0.00,	9.00,	25.00,	25.00,	6,	'No',	'Yes',	'2018-05-26 08:08:43',	'0000-00-00',	'Active',	'Yes'),
(10,	3,	1,	6,	1,	5,	1,	12.00,	0.00,	29.00,	0.00,	0.00,	3.00,	30.00,	30.00,	7,	'No',	'Yes',	'2018-05-26 08:09:12',	'0000-00-00',	'Active',	'Yes'),
(11,	3,	1,	6,	2,	6,	1,	6.00,	0.00,	16.00,	0.00,	0.00,	3.00,	16.00,	16.00,	4,	'No',	'Yes',	'2018-05-26 08:09:12',	'0000-00-00',	'Active',	'Yes'),
(12,	4,	1,	7,	1,	7,	1,	20.00,	0.00,	11.00,	0.00,	0.00,	6.00,	12.00,	12.00,	20,	'No',	'Yes',	'2018-05-26 08:09:47',	'0000-00-00',	'Active',	'Yes'),
(13,	4,	1,	7,	2,	8,	1,	20.00,	0.00,	5.00,	0.00,	0.00,	6.00,	5.00,	5.00,	30,	'No',	'Yes',	'2018-05-26 08:09:47',	'0000-00-00',	'Active',	'Yes'),
(14,	5,	1,	8,	1,	9,	1,	30.00,	0.00,	35.00,	0.00,	0.00,	2.00,	36.00,	36.00,	10,	'No',	'Yes',	'2018-05-26 08:10:07',	'0000-00-00',	'Active',	'Yes'),
(15,	7,	1,	10,	1,	11,	1,	50.00,	0.00,	118.00,	0.00,	0.00,	2.00,	120.00,	120.00,	100,	'No',	'Yes',	'2018-05-26 08:10:31',	'0000-00-00',	'Active',	'Yes'),
(16,	6,	1,	9,	1,	10,	1,	90.00,	0.00,	437.00,	0.00,	0.00,	3.00,	450.00,	450.00,	60,	'No',	'Yes',	'2018-05-26 08:10:57',	'0000-00-00',	'Active',	'Yes'),
(17,	8,	1,	11,	1,	12,	1,	200.00,	0.00,	40.00,	0.00,	0.00,	1.00,	40.00,	40.00,	12,	'No',	'Yes',	'2018-05-26 08:11:41',	'0000-00-00',	'Active',	'Yes'),
(18,	8,	1,	11,	2,	13,	1,	150.00,	0.00,	25.00,	0.00,	0.00,	1.00,	25.00,	25.00,	14,	'No',	'Yes',	'2018-05-26 08:11:42',	'0000-00-00',	'Deactive',	'Yes'),
(19,	1,	1,	14,	1,	3,	NULL,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0,	'Yes',	'No',	'2018-05-26 12:04:55',	'0000-00-00',	'Deactive',	'Yes');

DELIMITER ;;

CREATE TRIGGER `item_variation_history` AFTER INSERT ON `item_variations` FOR EACH ROW
INSERT INTO history_item_variations SET item_id = NEW.item_id,city_id = NEW.city_id,unit_variation_id = NEW.unit_variation_id,item_variation_master_id = NEW.item_variation_master_id,seller_id = NEW.seller_id,current_stock = NEW.current_stock,add_stock = NEW.add_stock,purchase_rate = NEW.purchase_rate,print_rate = NEW.print_rate,discount_per = NEW.discount_per,commission = NEW.commission,sales_rate = NEW.sales_rate,mrp = NEW.mrp, maximum_quantity_purchase = NEW.maximum_quantity_purchase,out_of_stock = NEW.out_of_stock,ready_to_sale = NEW.ready_to_sale,created_on = NEW.created_on,update_on = NEW.update_on,status = NEW.status,section_show = NEW.section_show;;

CREATE TRIGGER `item_variations_au` AFTER UPDATE ON `item_variations` FOR EACH ROW
INSERT INTO history_item_variations SET item_id = NEW.item_id,city_id = NEW.city_id,unit_variation_id = NEW.unit_variation_id,item_variation_master_id = NEW.item_variation_master_id,seller_id = NEW.seller_id,current_stock = NEW.current_stock,add_stock = NEW.add_stock,purchase_rate = NEW.purchase_rate,print_rate = NEW.print_rate,discount_per = NEW.discount_per,commission = NEW.commission,sales_rate = NEW.sales_rate,mrp = NEW.mrp, maximum_quantity_purchase = NEW.maximum_quantity_purchase,out_of_stock = NEW.out_of_stock,ready_to_sale = NEW.ready_to_sale,created_on = NEW.created_on,update_on = NEW.update_on,status = NEW.status,section_show = NEW.section_show;;

DELIMITER ;

DROP TABLE IF EXISTS `item_variation_masters`;
CREATE TABLE `item_variation_masters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `unit_variation_id` int(11) NOT NULL,
  `item_image` varchar(50) NOT NULL,
  `item_image_web` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  `status` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `item_variation_masters` (`id`, `item_id`, `unit_variation_id`, `item_image`, `item_image_web`, `created_on`, `edited_on`, `created_by`, `edited_by`, `status`) VALUES
(1,	1,	1,	'item/1/app/item1527318219.png',	'item/1/web/item1527318219.png',	'2018-05-26 07:04:32',	'2018-05-26 07:04:37',	1,	0,	'Active'),
(2,	1,	2,	'item/2/app/item1527318226.png',	'item/2/web/item1527318226.png',	'2018-05-26 07:04:37',	'2018-05-26 07:04:42',	1,	0,	'Active'),
(3,	2,	1,	'item/3/app/item1527318281.png',	'item/3/web/item1527318281.png',	'2018-05-26 07:05:33',	'2018-05-26 07:05:40',	1,	0,	'Active'),
(4,	2,	2,	'item/4/app/item1527318289.png',	'item/4/web/item1527318289.png',	'2018-05-26 07:05:40',	'2018-05-26 07:05:48',	1,	0,	'Active'),
(5,	3,	1,	'item/5/app/item1527318506.png',	'item/5/web/item1527318506.png',	'2018-05-26 07:09:18',	'2018-05-26 07:09:23',	1,	0,	'Active'),
(6,	3,	2,	'item/6/app/item1527318512.png',	'item/6/web/item1527318512.png',	'2018-05-26 07:09:24',	'2018-05-26 07:09:30',	1,	0,	'Active'),
(7,	4,	1,	'item/7/app/item1527318597.jpeg',	'item/7/web/item1527318597.jpeg',	'2018-05-26 07:10:49',	'2018-05-26 07:10:52',	1,	0,	'Active'),
(8,	4,	2,	'item/8/app/item1527318601.png',	'item/8/web/item1527318601.png',	'2018-05-26 07:10:52',	'2018-05-26 07:10:56',	1,	0,	'Active'),
(9,	5,	1,	'item/9/app/item1527318686.jpeg',	'item/9/web/item1527318686.jpeg',	'2018-05-26 07:12:18',	'2018-05-26 07:12:22',	1,	0,	'Active'),
(10,	6,	1,	'item/10/app/item1527318782.jpeg',	'item/10/web/item1527318782.jpeg',	'2018-05-26 07:13:54',	'2018-05-26 07:13:57',	1,	0,	'Active'),
(11,	7,	1,	'item/11/app/item1527318884.jpeg',	'item/11/web/item1527318884.jpeg',	'2018-05-26 07:15:36',	'2018-05-26 07:15:39',	1,	0,	'Active'),
(12,	8,	1,	'item/12/app/item1527319836.jpeg',	'item/12/web/item1527319836.jpeg',	'2018-05-26 07:31:28',	'2018-05-26 07:31:32',	1,	0,	'Active'),
(13,	8,	2,	'item/13/app/item1527319841.jpeg',	'item/13/web/item1527319841.jpeg',	'2018-05-26 07:31:32',	'2018-05-26 07:31:35',	1,	0,	'Active');

DROP TABLE IF EXISTS `journal_vouchers`;
CREATE TABLE `journal_vouchers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(10) NOT NULL,
  `reference_no` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  `total_credit_amount` decimal(15,2) NOT NULL,
  `total_debit_amount` decimal(15,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `journal_vouchers` (`id`, `voucher_no`, `reference_no`, `location_id`, `city_id`, `transaction_date`, `narration`, `total_credit_amount`, `total_debit_amount`, `status`, `created_by`, `created_on`) VALUES
(1,	1,	0,	0,	1,	'2018-05-31',	'107',	0.00,	0.00,	'',	1,	'2018-05-28 12:18:54');

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

INSERT INTO `journal_voucher_rows` (`id`, `journal_voucher_id`, `cr_dr`, `ledger_id`, `debit`, `credit`, `mode_of_payment`, `cheque_no`, `cheque_date`, `total`) VALUES
(1,	1,	'Dr',	131,	107.00,	NULL,	'',	'',	NULL,	107.00),
(2,	1,	'Cr',	135,	NULL,	107.00,	'',	'',	NULL,	0.00);

DROP TABLE IF EXISTS `ledgers`;
CREATE TABLE `ledgers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `accounting_group_id` int(10) NOT NULL,
  `freeze` tinyint(1) NOT NULL COMMENT '0==unfreezed 1==freezed',
  `supplier_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
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
  `ccavenue` varchar(10) NOT NULL DEFAULT 'No',
  `tds_account` varchar(10) NOT NULL DEFAULT 'no',
  `ccavenue_charges` varchar(10) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `ledgers` (`id`, `city_id`, `name`, `accounting_group_id`, `freeze`, `supplier_id`, `customer_id`, `seller_id`, `vendor_id`, `tax_percentage`, `gst_type`, `input_output`, `gst_figure_id`, `bill_to_bill_accounting`, `round_off`, `cash`, `flag`, `default_credit_days`, `commission`, `sales_account`, `ccavenue`, `tds_account`, `ccavenue_charges`) VALUES
(1,	1,	'0% CGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'CGST',	'input',	1,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(2,	1,	'0% SGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'SGST',	'input',	1,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(3,	1,	'0% IGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'IGST',	'input',	1,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(4,	1,	'0% CGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'CGST',	'output',	1,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(5,	1,	'0% SGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'SGST',	'output',	1,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(6,	1,	'0% IGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'IGST',	'output',	1,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(7,	1,	'2.5% CGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'CGST',	'input',	2,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(8,	1,	'2.5% SGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'SGST',	'input',	2,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(9,	1,	'5% IGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'IGST',	'input',	2,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(10,	1,	'2.5% CGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'CGST',	'output',	2,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(11,	1,	'2.5% SGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'SGST',	'output',	2,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(12,	1,	'5% IGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'IGST',	'output',	2,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(13,	1,	'6% CGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'CGST',	'input',	3,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(14,	1,	'6% SGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'SGST',	'input',	3,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(15,	1,	'12% IGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'IGST',	'input',	3,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(16,	1,	'6% CGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'CGST',	'output',	3,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(17,	1,	'6% SGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'SGST',	'output',	3,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(18,	1,	'12% IGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'IGST',	'output',	3,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(19,	1,	'9% CGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'CGST',	'input',	4,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(20,	1,	'9% SGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'SGST',	'input',	4,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(21,	1,	'18% IGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'IGST',	'input',	4,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(22,	1,	'9% CGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'CGST',	'output',	4,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(23,	1,	'9% SGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'SGST',	'output',	4,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(24,	1,	'18% IGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'IGST',	'output',	4,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(25,	1,	'14% CGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'CGST',	'input',	5,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(26,	1,	'14% SGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'SGST',	'input',	5,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(27,	1,	'28% IGST (input)',	29,	0,	0,	0,	0,	0,	0.00,	'IGST',	'input',	5,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(28,	1,	'14% CGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'CGST',	'output',	5,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(29,	1,	'14% SGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'SGST',	'output',	5,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(30,	1,	'28% IGST (output)',	30,	0,	0,	0,	0,	0,	0.00,	'IGST',	'output',	5,	'no',	0,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(31,	1,	'Round off',	8,	0,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	1,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(32,	1,	'Cash',	18,	0,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	1,	1,	0,	NULL,	NULL,	'no',	'no',	'no'),
(33,	1,	'ccavenue',	17,	0,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	1,	0,	NULL,	NULL,	'yes',	'no',	'no'),
(85,	1,	'gopesh Singh',	22,	0,	0,	1,	0,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(86,	1,	'Yash',	22,	0,	0,	2,	0,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(87,	1,	'jtendra',	22,	0,	0,	3,	0,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(88,	1,	'Canara Bank',	17,	0,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(89,	1,	'Sales Accounts',	14,	0,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(90,	1,	'Purchase Account',	13,	0,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(95,	1,	'vikas Verma',	25,	0,	0,	0,	1,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(129,	1,	'Mandi',	25,	0,	0,	0,	0,	2,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(130,	1,	'raj pvt. Ltd.',	25,	0,	0,	0,	0,	3,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(131,	1,	'raj pvt. Ltd.',	25,	0,	0,	0,	0,	4,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(132,	1,	'Vndr Pvt. Ltd.',	25,	0,	0,	0,	0,	5,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(133,	1,	'ewf',	25,	0,	0,	0,	0,	6,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(134,	1,	'n',	25,	0,	0,	0,	0,	7,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(135,	1,	'n',	25,	0,	0,	0,	0,	8,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(136,	1,	'nJS ',	25,	0,	0,	0,	0,	9,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(137,	1,	'Tds Account',	3,	0,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	0,	0,	0,	0,	NULL,	NULL,	'No',	'yes',	'no'),
(138,	0,	'Rohit Joshi',	22,	0,	0,	4,	0,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(139,	0,	'',	22,	0,	0,	5,	0,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(140,	0,	'abc',	22,	0,	0,	6,	0,	0,	0.00,	NULL,	NULL,	NULL,	'yes',	0,	0,	0,	0,	NULL,	NULL,	'No',	'no',	'no'),
(141,	1,	'CCavenue Charges',	8,	0,	0,	0,	0,	0,	0.00,	NULL,	NULL,	NULL,	'no',	1,	0,	1,	0,	NULL,	NULL,	'no',	'no',	'yes');

DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `alise` varchar(100) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active/Deactive',
  `financial_year_begins_from` date NOT NULL,
  `financial_year_valid_to` date NOT NULL,
  `books_beginning_from` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `locations` (`id`, `city_id`, `name`, `alise`, `latitude`, `longitude`, `created_on`, `created_by`, `status`, `financial_year_begins_from`, `financial_year_valid_to`, `books_beginning_from`) VALUES
(1,	1,	'Fathepura',	'FP',	'41.798',	'23.576',	'2018-05-16 07:32:09',	1,	'Active',	'0000-00-00',	'0000-00-00',	'0000-00-00'),
(2,	3,	'PinkCity',	'PC',	'41.798',	'23.576',	'2018-05-25 08:43:52',	1,	'Active',	'0000-00-00',	'0000-00-00',	'0000-00-00');

DROP TABLE IF EXISTS `location_items`;
CREATE TABLE `location_items` (
  `id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `item_variation_master_id` int(11) NOT NULL,
  `location_id` int(10) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active.Deactive',
  PRIMARY KEY (`id`),
  KEY `item_variation_master_id` (`item_variation_master_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
  `menu_for_user` varchar(20) NOT NULL COMMENT 'Seller/Admin/Super Admin',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 for continue and 0 for discontinue',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `menus` (`id`, `name`, `icon`, `controller`, `action`, `parent_id`, `lft`, `rght`, `preference`, `menu_for_user`, `status`) VALUES
(1,	'Dashboard',	'fa fa-dashboard',	'Admins',	'index',	NULL,	1,	2,	0,	'Admin',	1),
(2,	'Unit',	'',	'Units',	'index',	NULL,	3,	4,	0,	'Admin',	1),
(3,	'Menu',	'',	'Menus',	'add',	NULL,	5,	6,	0,	'Admin',	1),
(4,	'City',	'',	'Cities',	'index',	NULL,	7,	8,	0,	'Super Admin',	1),
(5,	'State',	'',	'States',	'index',	NULL,	9,	10,	0,	'Admin',	1),
(6,	'Category',	'',	'Categories',	'index',	NULL,	11,	12,	0,	'Admin',	1),
(7,	'Delivery Charge',	'',	'delivery-charges',	'index',	NULL,	13,	14,	0,	'Admin',	1),
(8,	'Item',	'',	'Items',	'add',	NULL,	15,	20,	0,	'Admin',	1),
(9,	'Add',	'',	'items',	'add',	8,	16,	17,	0,	'Admin',	1),
(10,	'List',	'',	'items',	'index',	8,	18,	19,	0,	'Admin',	1),
(11,	'Cusotmer',	'',	'',	'',	NULL,	21,	26,	0,	'Admin',	1),
(12,	'Add',	'',	'Customers',	'Add',	11,	22,	23,	0,	'Admin',	1),
(13,	'List',	'',	'Customers',	'index',	11,	24,	25,	0,	'Admin',	1),
(14,	'Seller',	'',	'',	'',	NULL,	27,	38,	0,	'Admin',	1),
(15,	'Add',	'',	'Sellers',	'Add',	14,	28,	29,	0,	'Admin',	1),
(16,	'List',	'',	'Sellers',	'index',	14,	30,	31,	0,	'Seller',	1),
(20,	'Banner',	'',	'Banners',	'index',	NULL,	39,	40,	0,	'Admin',	1),
(21,	'Seller Item',	'',	'SellerItems',	'add',	14,	32,	33,	0,	'Admin',	1),
(22,	'Receipt Voucher',	'',	'',	'',	NULL,	41,	44,	0,	'Admin',	1),
(23,	'Add',	'',	'receipts',	'add',	22,	42,	43,	0,	'Admin',	1),
(24,	'Payment Voucher',	'',	'',	'',	NULL,	45,	48,	0,	'Admin',	1),
(25,	'Add',	'',	'payments',	'add',	24,	46,	47,	0,	'Admin',	1),
(26,	'Delivery Time',	'',	'DeliveryTimes',	'index',	NULL,	49,	50,	0,	'Admin',	1),
(27,	' UNIT VARIATION',	'',	' UnitVariations',	'index',	NULL,	0,	0,	0,	'Admin',	1),
(28,	'Combo Add',	'fa fa-add',	'ComboOffers',	'add',	35,	62,	63,	0,	'Admin',	1),
(29,	'Combo List',	'fa fa-edit',	'combo-offers',	'index',	35,	64,	65,	0,	'Admin',	1),
(30,	'Cancel Reasons',	'fa fa-list',	'cancel-reasons',	'index',	NULL,	51,	52,	0,	'Admin',	1),
(31,	'FAQ',	'fa fa-list',	'faqs',	'index',	NULL,	53,	54,	0,	'Admin',	1),
(32,	'Express Deliveries',	'fa fa-list',	'expressDeliveries',	'index',	NULL,	55,	56,	0,	'Admin',	1),
(33,	'Feedback',	'fa fa-list',	'Feedbacks',	'index',	NULL,	57,	58,	0,	'Admin',	1),
(34,	'Terms Conditions',	'fa fa-list',	'termConditions',	'index',	NULL,	59,	60,	0,	'Admin',	1),
(35,	'Combo Offer',	'',	'',	'',	NULL,	61,	66,	0,	'Admin',	1),
(36,	'Brand',	'fa fa-list',	'Brands',	'index',	NULL,	67,	68,	0,	'Admin',	1),
(37,	'Promo Code',	'',	'',	'',	NULL,	69,	74,	0,	'Admin',	1),
(38,	'Add',	'',	'Promotions',	'add',	37,	70,	71,	0,	'Admin',	1),
(39,	'Item Variation',	'',	'SellerItems',	'itemVariation',	65,	124,	125,	0,	'Seller',	1),
(41,	'Index',	'',	'Promotions',	'index',	37,	72,	73,	0,	'Admin',	1),
(42,	'Plans',	'fa fa-list',	'Plans',	'index',	NULL,	75,	76,	0,	'Admin',	1),
(43,	'Delivery',	'',	'',	'',	NULL,	77,	84,	0,	'Admin',	1),
(44,	'Charges',	'fa fa-list',	'DeliveryCharges',	'index',	43,	80,	81,	0,	'Admin',	1),
(45,	'Dates',	'fa fa-list',	'DeliveryDates',	'index',	43,	78,	79,	0,	'Admin',	1),
(46,	'Times',	'fa fa-list',	'DeliveryTimes',	'index',	43,	82,	83,	0,	'Admin',	1),
(47,	'Bulk Booking',	'',	'',	'',	NULL,	85,	88,	0,	'Admin',	1),
(48,	'Add',	'fa fa-add',	'bulkBookingLeads',	'index',	47,	86,	87,	0,	'Admin',	1),
(49,	'Notify List',	'fa fa-list',	'Notifies',	'index',	NULL,	89,	90,	0,	'Admin',	1),
(50,	'Approve Seller Item',	'',	'SellerItems',	'sellerItemApproval',	14,	34,	35,	0,	'Admin',	1),
(51,	'Home Screen',	'fa fa-list',	'HomeScreens',	'index',	NULL,	91,	92,	0,	'Admin',	1),
(52,	'Drivers',	'fa fa-list',	'Drivers',	'index',	NULL,	93,	94,	0,	'Admin',	1),
(53,	'Report',	'',	'',	'',	NULL,	95,	104,	0,	'Admin',	1),
(54,	'Seller Item',	'fa fa-list',	'seller-items',	'index',	53,	96,	97,	0,	'Admin',	1),
(55,	'Vouchers',	'',	'',	'',	NULL,	105,	110,	0,	'Admin',	1),
(56,	'Receipt Voucher',	'',	'',	'',	55,	106,	109,	0,	'Admin',	1),
(57,	'Add',	'',	'receipts',	'add',	56,	107,	108,	0,	'Admin',	1),
(58,	'Vendor',	'',	'',	'',	NULL,	111,	116,	0,	'Admin',	1),
(59,	'Add',	'',	'Vendors',	'add',	58,	112,	113,	0,	'Admin',	1),
(60,	'List',	'fa fa-List',	'Vendors',	'index',	58,	114,	115,	0,	'Admin',	1),
(61,	'Location',	'',	'',	'',	NULL,	117,	122,	0,	'Admin',	1),
(62,	'Add',	'',	'Locations',	'add',	61,	118,	119,	0,	'Admin',	1),
(63,	'List',	'fa fa-list',	'Locations',	'index',	61,	120,	121,	0,	'Admin',	1),
(64,	'Seller Rating',	'fa fa-list',	'Customers',	'rating',	53,	98,	99,	0,	'Admin',	1),
(65,	'Seller',	'',	'',	'',	NULL,	123,	126,	0,	'Seller',	1),
(66,	'Seller List',	'fa fa-list',	'Sellers',	'index',	14,	36,	37,	0,	'Super Admin',	1),
(74,	'Dashboard',	'fa fa-dashboard',	'Admins',	'index',	NULL,	1,	2,	0,	'Super Admin',	1),
(75,	'Unit',	'',	'Units',	'index',	NULL,	3,	4,	0,	'Super Admin',	1),
(76,	'Menu',	'',	'Menus',	'add',	NULL,	5,	6,	0,	'Super Admin',	1),
(77,	'City',	'',	'Cities',	'index',	NULL,	7,	8,	0,	'Super Admin',	1),
(78,	'State',	'',	'States',	'index',	NULL,	9,	10,	0,	'Super Admin',	1),
(79,	'Category',	'',	'Categories',	'index',	NULL,	11,	12,	0,	'Super Admin',	1),
(80,	'Delivery Charge',	'',	'delivery-charges',	'index',	NULL,	13,	14,	0,	'Super Admin',	1),
(81,	'Item',	'',	'',	'',	NULL,	15,	20,	0,	'Super Admin',	1),
(82,	'Add',	'',	'items',	'add',	81,	16,	17,	0,	'Super Admin',	1),
(83,	'List',	'',	'items',	'index',	81,	18,	19,	0,	'Super Admin',	1),
(84,	'Cusotmer',	'',	'',	'',	NULL,	21,	26,	0,	'Super Admin',	1),
(85,	'Add',	'',	'Customers',	'Add',	11,	22,	23,	0,	'Super Admin',	1),
(86,	'List',	'',	'Customers',	'index',	11,	24,	25,	0,	'Super Admin',	1),
(87,	'Seller',	'',	'',	'',	NULL,	27,	38,	0,	'Super Admin',	1),
(88,	'Add',	'',	'Sellers',	'Add',	87,	28,	29,	0,	'Super Admin',	1),
(89,	'List',	'',	'Sellers',	'index',	87,	30,	31,	0,	'Super Admin',	1),
(90,	'Banner',	'',	'Banners',	'index',	NULL,	39,	40,	0,	'Super Admin',	1),
(91,	'Seller Item',	'',	'SellerItems',	'add',	87,	32,	33,	0,	'Super Admin',	1),
(92,	'Receipt Voucher',	'',	'',	'',	NULL,	41,	44,	0,	'Super Admin',	1),
(93,	'Add',	'',	'receipts',	'add',	22,	42,	43,	0,	'Super Admin',	1),
(94,	'Payment Voucher',	'',	'',	'',	NULL,	45,	48,	0,	'Super Admin',	1),
(95,	'Add',	'',	'payments',	'add',	24,	46,	47,	0,	'Super Admin',	1),
(96,	'Delivery Time',	'',	'DeliveryTimes',	'index',	NULL,	49,	50,	0,	'Super Admin',	1),
(97,	' UNIT VARIATION',	'',	' UnitVariations',	'index',	NULL,	0,	0,	0,	'Super Admin',	1),
(98,	'Combo Add',	'fa fa-add',	'ComboOffers',	'add',	35,	62,	63,	0,	'Super Admin',	1),
(99,	'Combo List',	'fa fa-edit',	'combo-offers',	'index',	35,	64,	65,	0,	'Super Admin',	1),
(100,	'Cancel Reasons',	'fa fa-list',	'cancel-reasons',	'index',	NULL,	51,	52,	0,	'Super Admin',	1),
(101,	'FAQ',	'fa fa-list',	'faqs',	'index',	NULL,	53,	54,	0,	'Super Admin',	1),
(102,	'Express Deliveries',	'fa fa-list',	'expressDeliveries',	'index',	NULL,	55,	56,	0,	'Super Admin',	1),
(103,	'Feedback',	'fa fa-list',	'Feedbacks',	'index',	NULL,	57,	58,	0,	'Super Admin',	1),
(104,	'Terms Conditions',	'fa fa-list',	'termConditions',	'index',	NULL,	59,	60,	0,	'Super Admin',	1),
(105,	'Combo Offer',	'',	'',	'',	NULL,	61,	66,	0,	'Super Admin',	1),
(106,	'Brand',	'fa fa-list',	'Brands',	'index',	NULL,	67,	68,	0,	'Super Admin',	1),
(107,	'Promo Code',	'',	'',	'',	NULL,	69,	74,	0,	'Super Admin',	1),
(108,	'Add',	'',	'Promotions',	'add',	37,	70,	71,	0,	'Super Admin',	1),
(109,	'Item Variation',	'',	'SellerItems',	'itemVariation',	65,	124,	125,	0,	'Super Admin',	1),
(110,	'Index',	'',	'Promotions',	'index',	37,	72,	73,	0,	'Super Admin',	1),
(111,	'Plans',	'fa fa-list',	'Plans',	'index',	NULL,	75,	76,	0,	'Super Admin',	1),
(112,	'Delivery',	'',	'',	'',	NULL,	77,	84,	0,	'Super Admin',	1),
(113,	'Charges',	'fa fa-list',	'DeliveryCharges',	'index',	43,	80,	81,	0,	'Super Admin',	1),
(114,	'Dates',	'fa fa-list',	'DeliveryDates',	'index',	43,	78,	79,	0,	'Super Admin',	1),
(115,	'Times',	'fa fa-list',	'DeliveryTimes',	'index',	43,	82,	83,	0,	'Super Admin',	1),
(116,	'Bulk Booking',	'',	'',	'',	NULL,	85,	88,	0,	'Super Admin',	1),
(117,	'Add',	'fa fa-add',	'bulkBookingLeads',	'index',	47,	86,	87,	0,	'Super Admin',	1),
(118,	'Notify List',	'fa fa-list',	'Notifies',	'index',	NULL,	89,	90,	0,	'Super Admin',	1),
(119,	'Approve Seller Item',	'',	'SellerItems',	'sellerItemApproval',	14,	34,	35,	0,	'Super Admin',	1),
(120,	'Home Screen',	'fa fa-list',	'HomeScreens',	'index',	NULL,	91,	92,	0,	'Super Admin',	1),
(121,	'Drivers',	'fa fa-list',	'Drivers',	'index',	NULL,	93,	94,	0,	'Super Admin',	1),
(122,	'Report',	'',	'',	'',	NULL,	95,	104,	0,	'Super Admin',	1),
(123,	'Seller Item',	'fa fa-list',	'seller-items',	'index',	53,	96,	97,	0,	'Super Admin',	1),
(124,	'Voucher',	'',	'',	'',	NULL,	127,	152,	0,	'Super Admin',	1),
(125,	'Contra Voucher',	'',	'',	'',	124,	153,	158,	0,	'Super Admin',	1),
(126,	'Add',	'',	'ContraVouchers',	'add',	125,	154,	155,	0,	'Super Admin',	1),
(127,	'List',	'',	'ContraVouchers',	'index',	125,	156,	157,	0,	'Super Admin',	1),
(128,	'Challan',	'',	'',	'',	NULL,	159,	164,	0,	'Super Admin',	1),
(129,	'Add',	'',	'Grns',	'add',	128,	160,	161,	0,	'Super Admin',	1),
(130,	'Index',	'',	'Grns',	'index',	128,	162,	163,	0,	'Super Admin',	1),
(131,	'Payment Voucher',	'',	'',	'',	124,	128,	133,	0,	'Super Admin',	1),
(132,	'Add',	'',	'payments',	'add',	131,	129,	130,	0,	'Super Admin',	1),
(133,	'List',	'',	'payments',	'index',	131,	131,	132,	0,	'Super Admin',	1),
(134,	' Receipt Voucher',	'',	'',	'',	124,	165,	170,	0,	'Super Admin',	1),
(135,	'Add',	'',	'Receipts',	'add',	134,	166,	167,	0,	'Super Admin',	1),
(136,	'List',	'',	'Receipts',	'index',	134,	168,	169,	0,	'Super Admin',	1),
(137,	'Reports',	'',	'',	'',	NULL,	171,	192,	0,	'Super Admin',	1),
(139,	'Journal Voucher',	'',	'',	'',	124,	134,	139,	0,	'Super Admin',	1),
(140,	'Add',	'',	'journal-vouchers',	'add',	139,	135,	136,	0,	'Super Admin',	1),
(141,	'List',	'',	'journal-vouchers',	'index',	139,	137,	138,	0,	'Super Admin',	1),
(142,	'Account Statement',	'',	'AccountingEntries',	'AccountStatement',	137,	172,	173,	0,	'Super Admin',	1),
(143,	'GST Report',	'',	'AccountingEntries',	'gstReport',	137,	174,	175,	0,	'Super Admin',	1),
(144,	'Credit Notes Voucher',	'',	'',	'',	124,	140,	145,	0,	'Super Admin',	1),
(145,	'Add',	'',	'CreditNotes',	'add',	144,	141,	142,	0,	'Super Admin',	1),
(146,	'List',	'',	'CreditNotes',	'index',	144,	143,	144,	0,	'Super Admin',	1),
(147,	' Debit Note Voucher',	'',	'',	'',	124,	146,	151,	0,	'Super Admin',	1),
(148,	'Add',	'',	'DebitNotes',	'add',	147,	147,	148,	0,	'Super Admin',	1),
(149,	'List',	'',	'DebitNotes',	'index',	147,	149,	150,	0,	'Super Admin',	1),
(150,	'Stock Report',	'',	'Items',	'stockReport',	137,	176,	177,	0,	'Super Admin',	1),
(151,	'Payable Report',	'',	'Ledgers',	'overDueReportPayable',	137,	178,	179,	0,	'Super Admin',	1),
(153,	'Receivable Report',	'',	'Ledgers',	'overDueReportReceivable',	137,	180,	181,	0,	'Super Admin',	1),
(154,	'Cash/Credit Report ',	'',	'Orders',	'cashCreditReport',	137,	182,	183,	0,	'Super Admin',	1),
(155,	'Sales Report',	'',	'Items',	'SalesReport',	137,	184,	185,	0,	'Super Admin',	1),
(156,	'Trial Balance',	'',	'ledgers',	'trialBalance',	137,	186,	187,	0,	'Super Admin',	1),
(157,	'Profit & Loss Statement',	'',	'AccountingEntries',	'ProfitLossStatement',	137,	188,	189,	0,	'Super Admin',	1),
(158,	'Balance Sheet',	'',	'AccountingEntries',	'BalanceSheet',	137,	190,	191,	0,	'Super Admin',	1);

DROP TABLE IF EXISTS `nature_of_groups`;
CREATE TABLE `nature_of_groups` (
  `id` int(10) NOT NULL,
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
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `notifies`;
CREATE TABLE `notifies` (
  `id` int(10) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `send_flag` varchar(10) NOT NULL DEFAULT 'Unsend' COMMENT 'Send,Unsend,Notsend',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `item_variation_id` (`item_variation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
  `transaction_date` date NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_status` varchar(30) NOT NULL,
  `order_from` varchar(30) NOT NULL COMMENT 'App,Web',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `orders` (`id`, `location_id`, `city_id`, `sales_ledger_id`, `party_ledger_id`, `customer_id`, `driver_id`, `customer_address_id`, `promotion_detail_id`, `order_no`, `voucher_no`, `ccavvenue_tracking_no`, `amount_from_wallet`, `total_amount`, `discount_percent`, `total_gst`, `grand_total`, `pay_amount`, `online_amount`, `delivery_charge_id`, `order_type`, `delivery_date`, `delivery_time_id`, `order_status`, `cancel_reason_id`, `cancel_reason_other`, `cancel_date`, `transaction_date`, `order_date`, `payment_status`, `order_from`) VALUES
(1,	1,	1,	0,	0,	4,	0,	1,	0,	'5ad5ecd8e0779',	1,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'0000-00-00',	'2018-05-29 18:30:00',	'Success',	'App'),
(2,	1,	1,	0,	0,	4,	0,	1,	0,	'5ad5ecd8e0779',	2,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'0000-00-00',	'2018-05-29 18:30:00',	'Success',	'App'),
(3,	1,	1,	0,	0,	4,	0,	1,	0,	'5ad5ecd8e0779',	3,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'0000-00-00',	'2018-05-29 18:30:00',	'Success',	'App'),
(4,	1,	1,	0,	0,	4,	0,	1,	0,	'5ad5ecd8e0779',	4,	'6sddsf78fasf87asfa',	11.00,	11.00,	1.00,	1.00,	12.00,	12.00,	12.00,	1,	'Online',	'2018-03-10 18:30:00',	1,	'placed',	0,	'',	'0000-00-00',	'0000-00-00',	'2018-05-29 18:30:00',	'Success',	'App');

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_variation_id` int(11) DEFAULT NULL,
  `combo_offer_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `gst_percentage` decimal(10,2) NOT NULL,
  `gst_figure_id` int(11) NOT NULL,
  `gst_value` decimal(10,2) NOT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `order_details` (`id`, `order_id`, `item_id`, `item_variation_id`, `combo_offer_id`, `quantity`, `rate`, `amount`, `gst_percentage`, `gst_figure_id`, `gst_value`, `net_amount`) VALUES
(1,	1,	0,	6,	0,	1.00,	60.00,	60.00,	0.00,	0,	0.00,	0.00),
(2,	1,	0,	12,	0,	2.00,	12.00,	24.00,	0.00,	0,	0.00,	0.00),
(3,	1,	0,	13,	0,	2.00,	5.00,	10.00,	0.00,	0,	0.00,	0.00),
(4,	1,	0,	3,	0,	1.00,	0.00,	0.00,	0.00,	0,	0.00,	0.00),
(5,	2,	0,	6,	0,	1.00,	60.00,	60.00,	0.00,	0,	0.00,	0.00),
(6,	2,	0,	12,	0,	2.00,	12.00,	24.00,	0.00,	0,	0.00,	0.00),
(7,	2,	0,	13,	0,	2.00,	5.00,	10.00,	0.00,	0,	0.00,	0.00),
(8,	2,	0,	3,	0,	1.00,	0.00,	0.00,	0.00,	0,	0.00,	0.00),
(9,	3,	0,	6,	0,	1.00,	60.00,	60.00,	0.00,	0,	0.00,	0.00),
(10,	3,	0,	12,	0,	2.00,	12.00,	24.00,	0.00,	0,	0.00,	0.00),
(11,	3,	0,	13,	0,	2.00,	5.00,	10.00,	0.00,	0,	0.00,	0.00),
(12,	3,	0,	3,	0,	1.00,	0.00,	0.00,	0.00,	0,	0.00,	0.00),
(13,	4,	0,	6,	0,	1.00,	60.00,	60.00,	0.00,	0,	0.00,	0.00),
(14,	4,	0,	12,	0,	2.00,	12.00,	24.00,	0.00,	0,	0.00,	0.00),
(15,	4,	0,	13,	0,	2.00,	5.00,	10.00,	0.00,	0,	0.00,	0.00),
(16,	4,	0,	3,	0,	1.00,	0.00,	0.00,	0.00,	0,	0.00,	0.00);

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `payments` (`id`, `voucher_no`, `location_id`, `city_id`, `transaction_date`, `narration`, `created_by`, `created_on`, `status`) VALUES
(2,	8,	0,	1,	'2018-05-24',	'',	1,	'2018-05-24 13:20:00',	''),
(3,	9,	0,	1,	'2018-05-25',	'yhb  20  ',	1,	'2018-05-25 09:01:30',	''),
(4,	10,	0,	1,	'2018-05-25',	'12 ',	1,	'2018-05-25 09:02:18',	''),
(5,	11,	0,	1,	'2018-05-26',	'63 Test :ayament',	1,	'2018-05-26 05:41:28',	''),
(6,	12,	0,	1,	'2018-05-26',	'63 Test :ayament',	1,	'2018-05-26 05:43:07',	''),
(7,	16,	0,	1,	'2018-05-28',	'63 Test :ayament   fbffb f    g g g gg gf',	1,	'2018-05-26 05:44:56',	''),
(8,	24,	0,	1,	'2018-05-28',	'7  Testing ',	1,	'2018-05-28 05:57:51',	'');

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
(1,	3,	'Dr',	95,	20.00,	NULL,	'',	'',	'1970-01-01'),
(2,	3,	'Cr',	88,	NULL,	20.00,	'Cheque',	'aSDF',	'2018-06-06'),
(3,	4,	'Dr',	95,	12.00,	NULL,	'',	'',	'1970-01-01'),
(4,	4,	'Cr',	88,	NULL,	12.00,	'Cheque',	'797867543321',	'2018-06-09'),
(5,	5,	'Dr',	129,	63.00,	NULL,	'',	'',	'1970-01-01'),
(6,	5,	'Cr',	88,	NULL,	63.00,	'Cheque',	'5767',	'2018-06-09'),
(7,	6,	'Dr',	129,	63.00,	NULL,	'',	'',	'1970-01-01'),
(8,	6,	'Cr',	88,	NULL,	63.00,	'Cheque',	'5767',	'2018-06-09'),
(9,	7,	'Dr',	129,	85.00,	NULL,	'',	'',	'1970-01-01'),
(10,	7,	'Cr',	88,	NULL,	63.00,	'Cheque',	'6754',	'2018-05-12'),
(11,	7,	'Cr',	95,	NULL,	22.00,	'',	'',	'1970-01-01'),
(12,	8,	'Dr',	95,	7.00,	NULL,	'',	'',	'1970-01-01'),
(13,	8,	'Cr',	88,	NULL,	7.00,	'Cheque',	'57577979797777',	'2018-08-07');

DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
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
(2,	1,	1,	'Silver Plan',	3000.00,	25.00,	3750.00,	'2018-04-27 04:41:19',	'Active'),
(3,	1,	1,	'Normal Plan',	2000.00,	10.00,	2200.00,	'2018-04-27 04:41:19',	'Active');

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
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
(1,	1,	1,	'Cash Back',	'Cash Back 10%',	'2018-03-19 18:30:00',	'2018-06-24 18:30:00',	'2018-03-21 13:14:08',	'0'),
(6,	1,	1,	'offer2',	'dcdscdc',	'2018-04-25 18:30:00',	'2018-05-02 18:30:00',	'2018-04-26 09:55:19',	'Active'),
(7,	1,	1,	'Welcome Offers',	'Install and get 100 rs Off on your first order.',	'2018-04-04 18:30:00',	'2018-05-14 18:30:00',	'2018-04-30 07:16:31',	'Active');

DROP TABLE IF EXISTS `promotion_details`;
CREATE TABLE `promotion_details` (
  `id` int(11) NOT NULL,
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
  `financial_year_id` int(10) DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  KEY `financial_year_id` (`financial_year_id`),
  CONSTRAINT `purchase_invoices_ibfk_1` FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `purchase_invoices` (`id`, `financial_year_id`, `voucher_no`, `invoice_no`, `location_id`, `transaction_date`, `seller_ledger_id`, `purchase_ledger_id`, `narration`, `total_taxable_value`, `total_gst`, `total_amount`, `entry_from`, `city_id`, `created_by`, `created_on`, `edited_by`, `edited_on`) VALUES
(2,	NULL,	2,	'RJ/UDR/PI/2',	0,	'2018-05-26',	129,	90,	'Narration',	12000.00,	1440.00,	13440.00,	'Web',	1,	1,	'2018-05-25 18:30:00',	0,	'0000-00-00 00:00:00');

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
  `sales_rate` decimal(15,2) DEFAULT NULL,
  `gst_type` varchar(100) NOT NULL,
  `mrp` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `purchase_invoice_rows` (`id`, `purchase_invoice_id`, `item_id`, `item_variation_id`, `quantity`, `rate`, `discount_percentage`, `discount_amount`, `taxable_value`, `net_amount`, `gst_percentage`, `gst_value`, `round_off`, `purchase_rate`, `sales_rate`, `gst_type`, `mrp`) VALUES
(2,	2,	1,	0,	100.00,	0.00,	NULL,	NULL,	12000.00,	13440.00,	3,	1440.00,	NULL,	120.00,	NULL,	'',	0.00);

DROP TABLE IF EXISTS `purchase_returns`;
CREATE TABLE `purchase_returns` (
  `id` int(10) NOT NULL,
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
  `id` int(10) NOT NULL,
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
  `id` int(10) NOT NULL,
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
  `id` int(10) NOT NULL,
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
  `city_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `narration` text NOT NULL,
  `sales_invoice_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `receipts` (`id`, `voucher_no`, `location_id`, `city_id`, `transaction_date`, `narration`, `sales_invoice_id`, `created_by`, `created_on`, `status`) VALUES
(1,	1,	0,	1,	'2018-05-28',	'35 testing ',	0,	1,	'2018-05-28 07:03:00',	''),
(2,	2,	0,	1,	'2018-05-28',	'22',	0,	1,	'2018-05-28 08:59:05',	'');

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

INSERT INTO `receipt_rows` (`id`, `receipt_id`, `cr_dr`, `ledger_id`, `debit`, `credit`, `mode_of_payment`, `cheque_no`, `cheque_date`) VALUES
(1,	1,	'Cr',	85,	NULL,	35.00,	'',	'',	'1970-01-01'),
(2,	1,	'Dr',	88,	35.00,	NULL,	'Cheque',	'35355353',	'2018-06-01'),
(3,	2,	'Cr',	86,	NULL,	22.00,	'',	'',	'1970-01-01'),
(4,	2,	'Dr',	88,	22.00,	NULL,	'Cheque',	'ghj',	'2018-06-06');

DROP TABLE IF EXISTS `reference_details`;
CREATE TABLE `reference_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
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
  `payment_id` int(10) NOT NULL,
  `contra_voucher_row_id` int(11) NOT NULL,
  `contra_voucher_id` int(10) NOT NULL,
  `credit_note_id` int(11) DEFAULT NULL,
  `credit_note_row_id` int(11) NOT NULL,
  `debit_note_id` int(11) DEFAULT NULL,
  `debit_note_row_id` int(11) DEFAULT NULL,
  `sales_voucher_row_id` int(11) DEFAULT NULL,
  `purchase_voucher_row_id` int(10) NOT NULL,
  `journal_voucher_row_id` int(10) NOT NULL,
  `journal_voucher_id` int(10) NOT NULL,
  `sale_return_id` int(10) DEFAULT NULL,
  `purchase_invoice_id` int(10) DEFAULT NULL,
  `purchase_return_id` int(10) DEFAULT NULL,
  `sales_invoice_id` int(10) DEFAULT NULL,
  `opening_balance` varchar(10) DEFAULT NULL,
  `due_days` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `reference_details` (`id`, `customer_id`, `vendor_id`, `seller_id`, `transaction_date`, `city_id`, `location_id`, `ledger_id`, `type`, `ref_name`, `debit`, `credit`, `receipt_id`, `receipt_row_id`, `payment_row_id`, `payment_id`, `contra_voucher_row_id`, `contra_voucher_id`, `credit_note_id`, `credit_note_row_id`, `debit_note_id`, `debit_note_row_id`, `sales_voucher_row_id`, `purchase_voucher_row_id`, `journal_voucher_row_id`, `journal_voucher_id`, `sale_return_id`, `purchase_invoice_id`, `purchase_return_id`, `sales_invoice_id`, `opening_balance`, `due_days`) VALUES
(1,	NULL,	NULL,	0,	'2018-05-26',	1,	0,	129,	'New Ref',	'RJ/UDR/PI/2',	0.00,	13440.00,	0,	0,	0,	0,	0,	0,	NULL,	0,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	2,	NULL,	NULL,	NULL,	0),
(15,	NULL,	NULL,	0,	'2018-05-28',	1,	0,	95,	'New Ref',	'Dimpals',	7.00,	0.00,	0,	0,	12,	8,	0,	0,	NULL,	0,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	0),
(16,	NULL,	NULL,	0,	'2018-05-28',	1,	0,	85,	'New Ref',	'gppsss',	0.00,	35.00,	1,	1,	0,	0,	0,	0,	NULL,	0,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	0),
(18,	NULL,	NULL,	0,	'2018-05-28',	1,	0,	86,	'New Ref',	'ui',	0.00,	22.00,	2,	3,	0,	0,	0,	0,	NULL,	0,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	0),
(21,	NULL,	NULL,	0,	'2018-05-28',	1,	0,	95,	'New Ref',	'thirty six 40',	40.00,	0.00,	0,	0,	0,	0,	1,	1,	NULL,	0,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	0),
(23,	NULL,	NULL,	0,	'2018-05-31',	1,	0,	131,	'New Ref',	'rajuhgb',	107.00,	0.00,	0,	0,	0,	0,	0,	0,	NULL,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	0),
(28,	NULL,	NULL,	0,	'2018-05-29',	1,	0,	132,	'New Ref',	'vndr tst',	73.00,	0.00,	0,	0,	0,	0,	0,	0,	1,	1,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	0),
(33,	NULL,	NULL,	0,	'2018-05-29',	1,	0,	132,	'New Ref',	'gd',	701.00,	0.00,	0,	0,	0,	0,	0,	0,	NULL,	0,	1,	1,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	0),
(34,	NULL,	NULL,	0,	'2018-05-29',	1,	0,	132,	'New Ref',	'fedf',	20.00,	0.00,	0,	0,	0,	0,	0,	0,	NULL,	0,	1,	1,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	0),
(35,	NULL,	NULL,	0,	'2018-05-29',	1,	0,	86,	'New Ref',	'ysh',	0.00,	701.00,	0,	0,	0,	0,	0,	0,	NULL,	0,	1,	2,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	0),
(36,	NULL,	NULL,	0,	'2018-05-29',	1,	0,	86,	'New Ref',	'rgfvc',	0.00,	20.00,	0,	0,	0,	0,	0,	0,	NULL,	0,	1,	2,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	0);

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
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
  `id` int(11) NOT NULL,
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
  `id` int(11) NOT NULL,
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
  `id` int(10) NOT NULL,
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
  `id` int(10) NOT NULL,
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
  `id` int(11) NOT NULL,
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
  `id` int(11) NOT NULL,
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
  `city_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `gstin` varchar(50) NOT NULL,
  `pan` varchar(50) NOT NULL,
  `gstin_holder_name` varchar(100) NOT NULL,
  `gstin_holder_address` text NOT NULL,
  `firm_name` varchar(100) NOT NULL,
  `firm_address` text NOT NULL,
  `firm_email` varchar(200) NOT NULL,
  `firm_contact` varchar(200) NOT NULL,
  `firm_pincode` varchar(200) NOT NULL,
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
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `sellers` (`id`, `city_id`, `location_id`, `name`, `username`, `password`, `latitude`, `longitude`, `gstin`, `pan`, `gstin_holder_name`, `gstin_holder_address`, `firm_name`, `firm_address`, `firm_email`, `firm_contact`, `firm_pincode`, `registration_date`, `termination_date`, `termination_reason`, `breif_decription`, `passkey`, `timeout`, `created_on`, `created_by`, `status`, `bill_to_bill_accounting`, `opening_balance_value`, `debit_credit`, `saller_image`) VALUES
(1,	1,	1,	'Seller1',	'dasumenaria@gmail.com',	'$2y$10$RXMfdf0/3IstpzPiykTj7eIq.bBTlCQ6ipZNIjk3pmWM4AsRaci76',	'',	'',	'22ASDFR0967W6Z5',	'sf ',	'ete',	'22ASDFR0967W6Z5',	'vikas Verma',	'vikas Pvt.LTD',	'vikas@gmail.com',	'9874646',	'313001',	'2018-05-16',	'0000-00-00',	'',	'',	'',	0,	'2018-05-25 04:27:08',	1,	'Active',	'yes',	100.00,	'Dr',	'');

DROP TABLE IF EXISTS `seller_details`;
CREATE TABLE `seller_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `seller_id` int(10) NOT NULL,
  `contact_person` varchar(200) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `contact_email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `seller_details` (`id`, `seller_id`, `contact_person`, `contact_no`, `contact_email`) VALUES
(1,	1,	'ra',	'586542',	'fs@gmail.com');

DROP TABLE IF EXISTS `seller_items`;
CREATE TABLE `seller_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `commission_percentage` decimal(6,2) NOT NULL,
  `commission_created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `expiry_on_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `seller_items` (`id`, `category_id`, `item_id`, `seller_id`, `city_id`, `brand_id`, `created_on`, `created_by`, `commission_percentage`, `commission_created_on`, `expiry_on_date`, `status`) VALUES
(1,	8,	1,	1,	1,	1,	'2018-05-28 05:57:02',	0,	9.00,	'2018-05-28 05:57:02',	'0000-00-00 00:00:00',	'Active'),
(3,	9,	5,	NULL,	1,	0,	'2018-05-26 07:17:59',	1,	0.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active'),
(4,	8,	4,	NULL,	1,	0,	'2018-05-26 07:19:16',	1,	0.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active'),
(5,	6,	2,	1,	1,	0,	'2018-05-26 07:50:01',	0,	9.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active'),
(6,	7,	3,	1,	1,	0,	'2018-05-26 08:05:23',	0,	3.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active'),
(7,	8,	4,	1,	1,	0,	'2018-05-26 08:05:23',	0,	6.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active'),
(8,	9,	5,	1,	1,	0,	'2018-05-26 08:05:23',	0,	2.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active'),
(9,	11,	6,	1,	1,	0,	'2018-05-26 08:05:23',	0,	3.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active'),
(10,	10,	7,	1,	1,	0,	'2018-05-26 08:05:23',	0,	2.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active'),
(11,	12,	8,	1,	1,	0,	'2018-05-26 08:05:23',	0,	1.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active'),
(13,	6,	2,	NULL,	1,	0,	'2018-05-26 10:22:21',	1,	0.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active'),
(14,	6,	1,	NULL,	1,	0,	'2018-05-26 12:04:54',	1,	0.00,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'Active');

DROP TABLE IF EXISTS `seller_item_variations`;
CREATE TABLE `seller_item_variations` (
  `id` int(11) NOT NULL,
  `seller_item_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit_variation_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `seller_ratings`;
CREATE TABLE `seller_ratings` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `item_variation_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` decimal(5,2) NOT NULL,
  `comment` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_variation_id` (`item_variation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `seller_requests`;
CREATE TABLE `seller_requests` (
  `id` int(10) NOT NULL,
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


DROP TABLE IF EXISTS `seller_request_rows`;
CREATE TABLE `seller_request_rows` (
  `id` int(11) NOT NULL,
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


DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `data` blob NOT NULL,
  `expires` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `sessions` (`id`, `data`, `expires`) VALUES
('33k0s2ntahkoo691948qh387f4',	'Config|a:1:{s:4:\"time\";i:1527657329;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}',	1527657329),
('974n3uoofff89mjm70rgbaata5',	'Config|a:1:{s:4:\"time\";i:1527319554;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Flash|a:1:{s:5:\"flash\";a:2:{i:0;a:4:{s:7:\"message\";s:41:\"The item variation master has been added.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"Flash/success\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:41:\"The item variation master has been added.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"Flash/success\";s:6:\"params\";a:0:{}}}}Auth|a:1:{s:4:\"User\";a:17:{s:2:\"id\";i:1;s:7:\"city_id\";i:1;s:7:\"role_id\";i:1;s:4:\"name\";s:8:\"Testing1\";s:8:\"username\";s:5:\"test1\";s:5:\"email\";s:15:\"test1@gmail.com\";s:9:\"mobile_no\";s:10:\"9897654641\";s:10:\"created_on\";O:20:\"Cake\\I18n\\FrozenTime\":3:{s:4:\"date\";s:26:\"2018-05-09 11:00:03.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Asia/Kolkata\";}s:10:\"created_by\";i:1;s:7:\"passkey\";s:0:\"\";s:7:\"timeout\";i:0;s:6:\"status\";s:6:\"Active\";s:8:\"state_id\";i:1;s:10:\"company_id\";i:1;s:9:\"user_type\";s:11:\"Super Admin\";s:17:\"financial_year_id\";i:1;s:8:\"pass_key\";s:32:\"wt1U5MAUgJFTXGenFoZoiLwQGrLgdbUg\";}}',	1527319554),
('d1qu7peemvk279pne7f5eqbdg1',	'Config|a:1:{s:4:\"time\";i:1527586332;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Auth|a:1:{s:4:\"User\";a:17:{s:2:\"id\";i:1;s:7:\"city_id\";i:1;s:7:\"role_id\";i:1;s:4:\"name\";s:8:\"Testing1\";s:8:\"username\";s:5:\"test1\";s:5:\"email\";s:15:\"test1@gmail.com\";s:9:\"mobile_no\";s:10:\"9897654641\";s:10:\"created_on\";O:20:\"Cake\\I18n\\FrozenTime\":3:{s:4:\"date\";s:26:\"2018-05-09 11:00:03.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Asia/Kolkata\";}s:10:\"created_by\";i:1;s:7:\"passkey\";s:0:\"\";s:7:\"timeout\";i:0;s:6:\"status\";s:6:\"Active\";s:8:\"state_id\";i:1;s:10:\"company_id\";i:1;s:9:\"user_type\";s:11:\"Super Admin\";s:17:\"financial_year_id\";i:1;s:8:\"pass_key\";s:32:\"wt1U5MAtbJFTXGenFoZoiLwQGrLgdbtb\";}}Flash|a:1:{s:5:\"flash\";a:1:{i:0;a:4:{s:7:\"message\";s:36:\"The accounting group has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"Flash/success\";s:6:\"params\";a:0:{}}}}',	1527586332),
('dmng3sln55r7pknndd7ugccbq6',	'Config|a:1:{s:4:\"time\";i:1527482259;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}',	1527482259),
('l5ka96b5cm5h5cdg3oqsp5kef3',	'Config|a:1:{s:4:\"time\";i:1527340287;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Auth|a:0:{}',	1527340287),
('ol2tng0sisbdloseqs3qt78m35',	'Config|a:1:{s:4:\"time\";i:1527746363;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}',	1527746363),
('pdttgubnfk3c733gc44hlcjpo6',	'Config|a:1:{s:4:\"time\";i:1527325031;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Flash|a:1:{s:5:\"flash\";a:1:{i:0;a:4:{s:7:\"message\";s:47:\"You are not authorized to access that location.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"Flash/error\";s:6:\"params\";a:1:{s:5:\"class\";s:5:\"error\";}}}}',	1527325031),
('t135bhbp7o4mgmib85c87j1ep7',	'Config|a:1:{s:4:\"time\";i:1527665952;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}Auth|a:1:{s:4:\"User\";a:17:{s:2:\"id\";i:1;s:7:\"city_id\";i:1;s:7:\"role_id\";i:1;s:4:\"name\";s:8:\"Testing1\";s:8:\"username\";s:5:\"test1\";s:5:\"email\";s:15:\"test1@gmail.com\";s:9:\"mobile_no\";s:10:\"9897654641\";s:10:\"created_on\";O:20:\"Cake\\I18n\\FrozenTime\":3:{s:4:\"date\";s:26:\"2018-05-09 11:00:03.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Asia/Kolkata\";}s:10:\"created_by\";i:1;s:7:\"passkey\";s:0:\"\";s:7:\"timeout\";i:0;s:6:\"status\";s:6:\"Active\";s:8:\"state_id\";i:1;s:10:\"company_id\";i:1;s:9:\"user_type\";s:11:\"Super Admin\";s:17:\"financial_year_id\";i:1;s:8:\"pass_key\";s:32:\"wt1U5MAWKJFTXGenFoZoiLwQGrLgdbWK\";}}',	1527665952),
('u16u8e9roj8t2olvp1lufkk690',	'Config|a:1:{s:4:\"time\";i:1527569376;}_Token|a:3:{s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}}',	1527569376);

DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `alias_name` varchar(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active and Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `states` (`id`, `name`, `alias_name`, `created_on`, `created_by`, `status`) VALUES
(1,	'Rajasthan',	'RJ',	'2018-03-05 17:10:49',	1,	'Active'),
(2,	'Gujarat',	'',	'2018-03-08 10:08:32',	1,	'Active'),
(3,	'Delhi',	'',	'2018-03-08 10:29:23',	1,	'Deactive'),
(4,	'Maharastra',	'',	'2018-05-04 10:59:40',	1,	'Active');

DROP TABLE IF EXISTS `stock_transfer_vouchers`;
CREATE TABLE `stock_transfer_vouchers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `grn_id` int(11) DEFAULT NULL,
  `city_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `location_id` int(10) NOT NULL,
  `voucher_no` int(10) NOT NULL,
  `narration` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `stock_transfer_vouchers` (`id`, `grn_id`, `city_id`, `transaction_date`, `location_id`, `voucher_no`, `narration`) VALUES
(1,	2,	1,	'2018-05-25',	1,	1,	'qwerfftgrge');

DROP TABLE IF EXISTS `stock_transfer_voucher_rows`;
CREATE TABLE `stock_transfer_voucher_rows` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `stock_transfer_voucher_id` int(10) NOT NULL,
  `grn_row_id` int(11) NOT NULL,
  `item_id` int(10) NOT NULL,
  `item_variation_id` decimal(10,2) NOT NULL,
  `purchase_rate` decimal(10,2) NOT NULL,
  `sales_rate` decimal(15,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `grn_row_id` (`grn_row_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `stock_transfer_voucher_rows` (`id`, `stock_transfer_voucher_id`, `grn_row_id`, `item_id`, `item_variation_id`, `purchase_rate`, `sales_rate`, `quantity`) VALUES
(1,	1,	2,	1,	1.00,	120.00,	150.00,	73.00),
(2,	1,	2,	1,	2.00,	30.00,	50.00,	100.00);

DROP TABLE IF EXISTS `super_admins`;
CREATE TABLE `super_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
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
  `status` varchar(10) NOT NULL COMMENT '1 for continoue and 0 for delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `super_admins` (`id`, `city_id`, `role_id`, `name`, `username`, `password`, `email`, `mobile_no`, `created_on`, `created_by`, `passkey`, `timeout`, `status`) VALUES
(1,	1,	1,	'Testing1',	'test1',	'$2y$10$Yi9QYR2EUi4hQCPbn4gLuOcj21JdKTScwwSBzGu.IhT0tE4mQcAbq',	'test1@gmail.com',	'9897654641',	'2018-05-09 05:30:03',	1,	'',	0,	'Active'),
(2,	3,	1,	'JaipurTest',	'hello',	'$2y$10$Yi9QYR2EUi4hQCPbn4gLuOcj21JdKTScwwSBzGu.IhT0tE4mQcAbq',	'test1@gmail.com',	'9897654641',	'2018-05-09 05:30:03',	1,	'',	0,	'Active');

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
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


DROP TABLE IF EXISTS `supplier_areas`;
CREATE TABLE `supplier_areas` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `term_conditions`;
CREATE TABLE `term_conditions` (
  `id` int(11) NOT NULL,
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
(1,	1,	'Kilogram',	'Kg',	'kg',	1,	'',	1,	'2018-05-16 05:36:23',	'Active'),
(2,	1,	'gm',	'gm',	'kg',	1000,	'',	1,	'2018-05-16 05:44:43',	'Active');

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
(1,	1,	1,	1.00,	1,	'2018-05-16 05:43:08'),
(2,	2,	250,	0.25,	1,	'2018-05-16 05:45:27');

DROP TABLE IF EXISTS `vendors`;
CREATE TABLE `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gstin` varchar(50) NOT NULL,
  `pan` varchar(50) NOT NULL,
  `gstin_holder_name` varchar(100) NOT NULL,
  `gstin_holder_address` text NOT NULL,
  `firm_name` varchar(100) NOT NULL,
  `firm_address` text NOT NULL,
  `firm_email` varchar(200) NOT NULL,
  `firm_contact` varchar(200) NOT NULL,
  `firm_pincode` varchar(200) NOT NULL,
  `registration_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `termination_reason` text NOT NULL,
  `breif_decription` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `bill_to_bill_accounting` varchar(10) NOT NULL,
  `opening_balance_value` decimal(15,2) NOT NULL,
  `debit_credit` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active or Deactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `vendors` (`id`, `city_id`, `name`, `gstin`, `pan`, `gstin_holder_name`, `gstin_holder_address`, `firm_name`, `firm_address`, `firm_email`, `firm_contact`, `firm_pincode`, `registration_date`, `termination_date`, `termination_reason`, `breif_decription`, `created_on`, `created_by`, `bill_to_bill_accounting`, `opening_balance_value`, `debit_credit`, `status`) VALUES
(1,	1,	'savina mandi',	'22ASDFR0967W6Z5',	'234567890',	'werty',	'erty',	'mandi',	'qwery',	'erty',	'123123123',	'234142',	'2018-05-01',	'0000-00-00',	'',	'',	'2018-05-16 06:43:05',	1,	'yes',	240.00,	'Dr',	'Active'),
(2,	1,	'Mandi',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'qwerty',	'asdfg',	'Mandi',	'Savina',	'Mandi@mail.com',	'213456786543',	'131231',	'2018-05-22',	'0000-00-00',	'',	'',	'2018-05-25 09:45:38',	1,	'yes',	0.00,	'Dr',	'Active'),
(3,	1,	'rajeshwar',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'raj pvt. Ltd.',	'ramp',	'raj@gmail.com',	'979797977861',	'313002',	'2018-06-09',	'0000-00-00',	'',	'',	'2018-05-25 09:48:41',	1,	'yes',	12.00,	'Dr',	'Active'),
(4,	1,	'rajeshwar1',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z51',	'22ASDFR0967W6Z51',	'22ASDFR0967W6Z51',	'raj pvt. Ltd.1',	'ramp1',	'raj@gmai1l.com',	'9797979771',	'31301',	'2018-06-16',	'0000-00-00',	'',	'',	'2018-05-25 09:49:02',	1,	'yes',	12.00,	'Dr',	'Active'),
(5,	1,	'Vendor Test',	'22ASDFF0967W6Z5',	'22ASDFF0967W6Z5',	'22ASDFF0967W6Z5',	'22ASDFF0967W6Z5',	'Vndr Pvt. Ltd.',	'Subhash Nagar',	'vendor@gmail.com',	'9874563210',	'313003',	'2018-05-26',	'0000-00-00',	'',	'',	'2018-05-25 10:06:50',	1,	'yes',	23.00,	'Dr',	'Active'),
(6,	1,	'esfew',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'ewf',	'ewf',	'ewrf',	'423432423423',	'324',	'2018-05-22',	'0000-00-00',	'',	'',	'2018-05-25 10:13:41',	1,	'no',	0.00,	'Dr',	'Active'),
(7,	1,	'vishnu',	'22ASDFR0967W6Z4',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'n',	'j',	'jn@gmail.com',	'6985656',	'636113',	'2018-06-09',	'0000-00-00',	'',	'',	'2018-05-25 10:20:17',	1,	'no',	0.00,	'Dr',	'Active'),
(8,	1,	'vishnu',	'22ASDFR0967W6Z4',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'n',	'j',	'jn@gmail.com',	'6985656',	'636113',	'2018-06-09',	'0000-00-00',	'',	'',	'2018-05-25 10:21:21',	1,	'no',	0.00,	'Dr',	'Active'),
(9,	1,	'Narayan ',	'22ASDFR0967W6Z9',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'22ASDFR0967W6Z5',	'nJS ',	'Pratapnagar',	'asd@gmail.com',	'90590490',	'1321313',	'2018-05-26',	'0000-00-00',	'',	'',	'2018-05-25 10:22:57',	1,	'no',	0.00,	'Dr',	'Active');

DROP TABLE IF EXISTS `vendor_details`;
CREATE TABLE `vendor_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(10) NOT NULL,
  `contact_person` varchar(200) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `contact_email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `vendor_details` (`id`, `vendor_id`, `contact_person`, `contact_no`, `contact_email`) VALUES
(1,	1,	'qwegt',	'2345678909',	'gops@mail.com'),
(2,	2,	'gops',	'987656789',	'gops@mail.com'),
(3,	3,	'vishwas',	'3698741239',	'vishawas@gmail.com'),
(6,	4,	'vishwas1',	'3698741231',	'vishawas@gmail1.com'),
(7,	5,	'vishnu',	'897664924',	'vishnu@gmail.com'),
(8,	6,	'22ASDFR0967W6Z5',	'22096765',	'ef@eferf.fhtghf'),
(9,	7,	'22ASDFR0967W6Z5',	'22096765',	'fs@gmail.com'),
(10,	8,	'22ASDFR0967W6Z5',	'22096765',	'fs@gmail.com'),
(12,	9,	'22ASDFR0967W6Z5',	'22096765',	'w@gmail.com');

DROP TABLE IF EXISTS `verify_otps`;
CREATE TABLE `verify_otps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(15) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `verify_otps` (`id`, `mobile`, `otp`, `status`) VALUES
(1,	'9352823161',	'6319',	0),
(4,	'8233068030',	'7045',	0),
(5,	'8890999221',	'9109',	0),
(6,	'8890999221',	'1564',	0),
(7,	'8890999221',	'6500',	0),
(8,	'8890999221',	'5604',	0);

DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
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
  `amount_type` varchar(30) NOT NULL COMMENT 'direct money/plan/promotion/order',
  `transaction_type` varchar(30) NOT NULL COMMENT 'Added /Deduct',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `wallets` (`id`, `city_id`, `customer_id`, `order_id`, `plan_id`, `promotion_id`, `add_amount`, `used_amount`, `cancel_to_wallet_online`, `narration`, `return_order_id`, `amount_type`, `transaction_type`, `created_on`) VALUES
(1,	1,	41,	1001,	0,	0,	1000.00,	0.00,	'',	'test',	0,	'direct money',	'Added',	'2018-05-05 13:12:16'),
(2,	1,	40,	1001,	0,	0,	1000.00,	0.00,	'',	'test',	0,	'direct money',	'Added',	'2018-05-05 13:12:16'),
(3,	1,	40,	1001,	1,	0,	1000.00,	0.00,	'',	'test',	0,	'plan',	'Added',	'2018-05-05 13:12:16');

DROP TABLE IF EXISTS `wish_lists`;
CREATE TABLE `wish_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `wish_lists` (`id`, `customer_id`, `created_on`, `status`) VALUES
(1,	4,	'2018-05-28 13:01:48',	0);

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
(1,	0,	4,	13,	0,	0,	'2018-05-30 09:43:43'),
(7,	1,	4,	12,	0,	0,	'2018-05-30 10:30:30');

-- 2018-05-31 08:11:04
