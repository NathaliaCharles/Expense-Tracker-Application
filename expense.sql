SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `db`

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `log_id` int(11) NOT NULL COMMENT 'Auto incremented log id.',
  `username` varchar(20) NOT NULL COMMENT 'Username FK for relation',
  `type` int(11) NOT NULL COMMENT '1->Add, 2->Subtract',
  `account` int(11) NOT NULL COMMENT '1->Cash, 2->Debit, 3->Credit',
  `item` varchar(50) NOT NULL COMMENT 'Item added',
  `amount` int(11) NOT NULL COMMENT 'Amount in transaction',
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Timestamp of transaction input',
  `balance_before` bigint(20) NOT NULL COMMENT 'Total Balance before transaction',
  `balance_after` bigint(20) NOT NULL COMMENT 'Total Balance after transaction'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


--
-- Dumping data for table `expense`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `username` varchar(20)  NOT NULL COMMENT 'Primary identifier username',
  `hash_pwd` text NOT NULL COMMENT 'Hashed password',
  `credit_balance` int(11) NOT NULL DEFAULT 0 COMMENT 'Credit due balance',
  `cash_balance` int(11) NOT NULL DEFAULT 0 COMMENT 'In hand cash balance',
  `debit_balance` int(11) NOT NULL DEFAULT 0 COMMENT 'Debit account balance'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


--
-- Dumping data for table `tbluser`
--


-----------------------------------------------------


--
-- Table structure for table `registration`
--


CREATE TABLE 'registration' (
  `username` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `repassword` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


--
--Dumping data for table `registration`
--



------------------------------------------------------------------


--
--Table structure fro table `login`
--


CREATE TABLE `login` (
  `username` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=UTF8 ;



--
---Dumping for table `login`
--


--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for dumped tables
--


-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;