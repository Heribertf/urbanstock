-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 21, 2024 at 09:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `platform_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUserAccountForAllUsersMpesa` ()   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Log or handle the exception
        ROLLBACK;
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'An error occurred during the execution of UpdateUserAccountForAllUsers.';
    END;

    -- Start a transaction for atomicity
    START TRANSACTION;

    -- Update existing records in user_account
    UPDATE user_account ua
    SET ua.return_interest = ua.return_interest + (
        SELECT SUM(i.capital * s.percentage_interest / 100)
        FROM investments i
        JOIN stocks s ON i.stock_id = s.stock_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'stock'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
        	AND i.payment_mode = 'mpesa'
            AND i.investment_status = 1
    ),
    ua.account_balance = ua.account_balance + (
        SELECT SUM(i.capital * s.percentage_interest / 100)
        FROM investments i
        JOIN stocks s ON i.stock_id = s.stock_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'stock'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
        	AND i.payment_mode = 'mpesa'
            AND i.investment_status = 1
    )
    WHERE EXISTS (
        SELECT 1
        FROM investments i
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'stock'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
        	AND i.payment_mode = 'mpesa'
            AND i.investment_status = 1
    );

    -- Insert new records
    INSERT INTO user_account (user_id, return_interest, total_withdrawn, account_balance)
    SELECT i.user_id,
           SUM(i.capital * s.percentage_interest / 100) AS return_interest,
           0.00 AS total_withdrawn,
           SUM(i.capital * s.percentage_interest / 100) AS account_balance
    FROM investments i
    JOIN stocks s ON i.stock_id = s.stock_id
    WHERE i.close_date <= NOW()
        AND i.investment_type = 'stock'
        AND i.payment_status = 'Completed'
        AND i.payment_mode = 'mpesa'
        AND i.investment_status = 1
        AND NOT EXISTS (
            SELECT 1
            FROM user_account ua
            WHERE ua.user_id = i.user_id
        )
    GROUP BY i.user_id;

    -- Update investments table to close the market
    UPDATE investments
    SET investment_status = 0
    WHERE investment_type = 'stock'
        AND close_date <= NOW()
        AND payment_status = 'Completed'
        AND payment_mode = 'mpesa'
        AND investment_status = 1;

    -- Commit the transaction
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUserAccountForAllUsersPaypal` ()   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Log or handle the exception
        ROLLBACK;
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'An error occurred during the execution of UpdateUserAccountForAllUsers.';
    END;

    -- Start a transaction for atomicity
    START TRANSACTION;

    -- Update existing records in user_account
    UPDATE user_account ua
    SET ua.return_interest = ua.return_interest + (
        SELECT SUM((i.capital * 150) * s.percentage_interest / 100)
        FROM investments i
        JOIN stocks s ON i.stock_id = s.stock_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'stock'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
            AND i.payment_mode = 'paypal'
            AND i.investment_status = 1
    ),
    ua.account_balance = ua.account_balance + (
        SELECT SUM((i.capital * 150) * s.percentage_interest / 100)
        FROM investments i
        JOIN stocks s ON i.stock_id = s.stock_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'stock'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
        	AND i.payment_mode = 'paypal'
            AND i.investment_status = 1
    )
    WHERE EXISTS (
        SELECT 1
        FROM investments i
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'stock'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
        	AND i.payment_mode = 'paypal'
            AND i.investment_status = 1
    );

    -- Insert new records
    INSERT INTO user_account (user_id, return_interest, total_withdrawn, account_balance)
    SELECT i.user_id,
           SUM((i.capital * 150) * s.percentage_interest / 100) AS return_interest,
           0.00 AS total_withdrawn,
           SUM((i.capital * 150) * s.percentage_interest / 100) AS account_balance
    FROM investments i
    JOIN stocks s ON i.stock_id = s.stock_id
    WHERE i.close_date <= NOW()
        AND i.investment_type = 'stock'
        AND i.payment_status = 'Completed'
        AND i.payment_mode = 'paypal'
        AND i.investment_status = 1
        AND NOT EXISTS (
            SELECT 1
            FROM user_account ua
            WHERE ua.user_id = i.user_id
        )
    GROUP BY i.user_id;

    -- Update investments table to close the market
    UPDATE investments
    SET investment_status = 0
    WHERE investment_type = 'stock'
        AND close_date <= NOW()
        AND payment_status = 'Completed'
        AND payment_mode = 'paypal'
        AND investment_status = 1;

    -- Commit the transaction
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUserAccountForAllUsersWithMachinesMpesa` ()   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Log or handle the exception
        ROLLBACK;
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'An error occurred during the execution of UpdateUserAccountForAllUsersWithMachines.';
    END;

    -- Start a transaction for atomicity
    START TRANSACTION;

    -- Update existing records in user_account
    UPDATE user_account ua
    SET ua.return_interest = ua.return_interest + (
        SELECT SUM(i.capital * m.percentage_interest / 100)
        FROM investments i
        JOIN machines m ON i.machine_id = m.machine_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.next_cycle_time <= NOW()
        	AND i.close_date >= NOW()
            AND i.payment_status = 'Completed'
            AND i.payment_mode = 'mpesa'
            AND i.investment_status = 1
    ),
    ua.account_balance = ua.account_balance + (
        SELECT SUM(i.capital * m.percentage_interest / 100)
        FROM investments i
        JOIN machines m ON i.machine_id = m.machine_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.next_cycle_time <= NOW()
        	AND i.close_date >= NOW()
            AND i.payment_status = 'Completed'
            AND i.payment_mode = 'mpesa'
            AND i.investment_status = 1
    )
    WHERE EXISTS (
        SELECT 1
        FROM investments i
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.next_cycle_time <= NOW()
        	AND i.close_date >= NOW()
            AND i.payment_status = 'Completed'
            AND i.payment_mode = 'mpesa'
            AND i.investment_status = 1
    );

    -- Insert new records
    INSERT INTO user_account (user_id, return_interest, total_withdrawn, account_balance)
    SELECT i.user_id,
           SUM(i.capital * m.percentage_interest / 100) AS return_interest,
           0.00 AS total_withdrawn,
           SUM(i.capital * m.percentage_interest / 100) AS account_balance
    FROM investments i
    JOIN machines m ON i.machine_id = m.machine_id
    WHERE i.next_cycle_time <= NOW()
    	AND i.close_date >= NOW()
        AND i.investment_type = 'machine'
        AND i.payment_status = 'Completed'
        AND i.payment_mode = 'mpesa'
        AND i.investment_status = 1
        AND NOT EXISTS (
            SELECT 1
            FROM user_account ua
            WHERE ua.user_id = i.user_id
        )
    GROUP BY i.user_id;

    -- Update investments table to increment cycles and current_machine_value
    UPDATE investments
    SET machine_cycles = machine_cycles + 1,
        current_machine_value = current_machine_value + (
            SELECT SUM(i.capital * m.percentage_interest / 100)
            FROM investments i
            JOIN machines m ON i.machine_id = m.machine_id
            WHERE investments.investment_id = i.investment_id
        ),
        next_cycle_time = TIMESTAMPADD(HOUR, 1, next_cycle_time)
    WHERE investment_type = 'machine'
        AND next_cycle_time <= NOW()
        AND close_date >= NOW()
        AND payment_status = 'Completed'
        AND payment_mode = 'mpesa'
        AND investment_status = 1;
        
   -- Update investments table to close the market
        UPDATE investments
        SET investment_status = 0
        WHERE investment_type = 'machine'
            AND close_date <= NOW()
            AND payment_status = 'Completed'
            AND payment_mode = 'mpesa'
            AND investment_status = 1;

    -- Commit the transaction
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUserAccountForAllUsersWithMachinesPaypal` ()   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Log or handle the exception
        ROLLBACK;
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'An error occurred during the execution of UpdateUserAccountForAllUsersWithMachines.';
    END;

    -- Start a transaction for atomicity
    START TRANSACTION;

    -- Update existing records in user_account
    UPDATE user_account ua
    SET ua.return_interest = ua.return_interest + (
        SELECT SUM((i.capital * 150) * m.percentage_interest / 100)
        FROM investments i
        JOIN machines m ON i.machine_id = m.machine_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.next_cycle_time <= NOW()
        	AND i.close_date >= NOW()
            AND i.payment_status = 'Completed'
            AND i.payment_mode = 'paypal'
            AND i.investment_status = 1
    ),
    ua.account_balance = ua.account_balance + (
        SELECT SUM((i.capital * 150) * m.percentage_interest / 100)
        FROM investments i
        JOIN machines m ON i.machine_id = m.machine_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.next_cycle_time <= NOW()
        	AND i.close_date >= NOW()
            AND i.payment_status = 'Completed'
            AND i.payment_mode = 'paypal'
            AND i.investment_status = 1
    )
    WHERE EXISTS (
        SELECT 1
        FROM investments i
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.next_cycle_time <= NOW()
        	AND i.close_date >= NOW()
            AND i.payment_status = 'Completed'
            AND i.payment_mode = 'paypal'
            AND i.investment_status = 1
    );

    -- Insert new records
    INSERT INTO user_account (user_id, return_interest, total_withdrawn, account_balance)
    SELECT i.user_id,
           SUM((i.capital * 150) * m.percentage_interest / 100) AS return_interest,
           0.00 AS total_withdrawn,
           SUM((i.capital * 150) * m.percentage_interest / 100) AS account_balance
    FROM investments i
    JOIN machines m ON i.machine_id = m.machine_id
    WHERE i.next_cycle_time <= NOW()
    	AND i.close_date >= NOW()
        AND i.investment_type = 'machine'
        AND i.payment_status = 'Completed'
        AND i.payment_mode = 'paypal'
        AND i.investment_status = 1
        AND NOT EXISTS (
            SELECT 1
            FROM user_account ua
            WHERE ua.user_id = i.user_id
        )
    GROUP BY i.user_id;

    -- Update investments table to increment cycles and current_machine_value
    UPDATE investments
    SET machine_cycles = machine_cycles + 1,
        current_machine_value = current_machine_value + (
            SELECT SUM((i.capital * 150) * m.percentage_interest / 100)
            FROM investments i
            JOIN machines m ON i.machine_id = m.machine_id
            WHERE investments.investment_id = i.investment_id
        ),
        next_cycle_time = TIMESTAMPADD(HOUR, 1, next_cycle_time)
    WHERE investment_type = 'machine'
        AND next_cycle_time <= NOW()
        AND close_date >= NOW()
        AND payment_status = 'Completed'
        AND payment_mode = 'paypal'
        AND investment_status = 1;
        
   -- Update investments table to close the market
        UPDATE investments
        SET investment_status = 0
        WHERE investment_type = 'machine'
            AND close_date <= NOW()
            AND payment_status = 'Completed'
            AND payment_mode = 'paypal'
            AND investment_status = 1;

    -- Commit the transaction
    COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `investment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `investment_type` varchar(50) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `machine_id` int(11) DEFAULT NULL,
  `plan_id` int(11) NOT NULL,
  `capital` float(10,2) NOT NULL,
  `paid_amount` float(10,2) DEFAULT NULL,
  `investment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `close_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `txn` varchar(50) NOT NULL,
  `payment_mode` varchar(20) DEFAULT NULL,
  `currency_code` varchar(10) DEFAULT NULL,
  `payment_status` varchar(25) DEFAULT NULL,
  `payer_email` varchar(100) DEFAULT NULL,
  `payer_country` varchar(25) DEFAULT NULL,
  `approval_status` tinyint(1) NOT NULL DEFAULT 2,
  `investment_status` tinyint(1) NOT NULL DEFAULT 2,
  `machine_cycles` int(11) NOT NULL DEFAULT 0,
  `next_cycle_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `current_machine_value` float(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `investments`
--

INSERT INTO `investments` (`investment_id`, `user_id`, `investment_type`, `stock_id`, `machine_id`, `plan_id`, `capital`, `paid_amount`, `investment_date`, `close_date`, `txn`, `payment_mode`, `currency_code`, `payment_status`, `payer_email`, `payer_country`, `approval_status`, `investment_status`, `machine_cycles`, `next_cycle_time`, `current_machine_value`) VALUES
(1, 2, 'stock', 2, NULL, 2, 2.00, 2.00, '2024-01-11 03:41:29', '2024-01-12 14:41:41', '71G254186N301144E', 'paypal', 'USD', 'Completed', NULL, NULL, 1, 0, 0, '2024-01-18 13:37:38', 0.00),
(2, 1, 'stock', 1, NULL, 3, 25.00, 25.00, '2024-01-11 03:58:44', '2024-01-12 15:03:37', '0YH80092JD5803424', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 0, 0, '2024-01-18 13:37:38', 0.00),
(3, 1, 'stock', 1, NULL, 2, 45.00, 45.00, '2024-01-11 03:54:26', '2024-01-12 15:04:08', '2NR70517FC665973D', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 1, 0, 0, '2024-01-18 13:37:38', 0.00),
(4, 2, 'stock', 2, NULL, 1, 5600.00, NULL, '2024-01-12 09:02:42', '2024-01-13 09:02:42', 'SDFTYUHJKNHVJ', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '2024-01-18 13:37:38', 0.00),
(5, 1, 'stock', 4, NULL, 1, 4500.00, NULL, '2024-01-12 09:04:23', '2024-01-13 09:04:23', 'SDFTYUHJKNHV', 'mpesa', NULL, 'rejected', NULL, NULL, 0, 0, 0, '2024-01-18 13:37:38', 0.00),
(6, 1, 'stock', 1, NULL, 1, 10000.00, NULL, '2024-01-12 10:31:11', '2024-01-13 10:31:11', 'WRYIYEDFTYDTF', 'mpesa', NULL, 'Completed', NULL, NULL, 1, 0, 0, '2024-01-18 13:37:38', 0.00),
(7, 1, 'stock', 2, NULL, 3, 34000.00, NULL, '2024-01-12 10:34:44', '2024-01-13 10:34:44', 'WRYIYEDFTYIOU', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '2024-01-18 13:37:38', 0.00),
(8, 1, 'stock', 3, NULL, 2, 6700.00, NULL, '2024-01-15 20:54:09', '2024-01-16 20:54:09', 'WRYIYEDFTY', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '2024-01-18 13:37:38', 0.00),
(9, 2, 'stock', 2, NULL, 1, 5000.00, NULL, '2024-01-16 05:34:19', '2024-01-17 05:34:19', 'STGFKMGTOJ', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '2024-01-18 13:37:38', 0.00),
(10, 2, 'stock', 3, NULL, 3, 10000.00, NULL, '2024-01-16 05:35:11', '2024-01-17 05:35:11', 'EWGDYUJF', 'mpesa', NULL, 'Completed', NULL, NULL, 1, 0, 0, '2024-01-18 13:37:38', 0.00),
(11, 2, 'machine', NULL, 2, 1, 8000.00, NULL, '2024-01-17 12:25:29', '2024-01-18 12:25:29', 'IYEDFTYIOU', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '2024-01-18 13:37:38', 0.00),
(12, 2, 'machine', NULL, 3, 1, 16000.00, NULL, '2024-01-17 12:27:13', '2024-01-18 12:27:13', 'IYEDFTYI', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '2024-01-18 13:37:38', 0.00),
(13, 2, 'machine', NULL, 2, 2, 8000.00, NULL, '2024-01-17 12:29:42', '2024-01-24 12:29:42', 'wsderftgyuhjnhb', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '2024-01-18 13:37:38', 0.00),
(14, 2, 'machine', NULL, 1, 1, 12500.00, NULL, '2024-01-17 12:30:26', '2024-01-18 12:30:26', 'wsderftgyuh', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '2024-01-18 13:37:38', 0.00),
(15, 2, 'machine', NULL, 1, 3, 12500.00, NULL, '2024-01-17 12:33:33', '2024-02-16 12:33:33', 'hjk,lgflkjgmk', 'mpesa', NULL, 'Completed', NULL, NULL, 1, 1, 37, '2024-01-19 23:37:38', 231250.00),
(16, 2, 'machine', NULL, 2, 3, 8000.00, NULL, '2024-01-17 12:47:47', '2024-02-16 12:47:47', 'gjnhkcjihfbvb', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '2024-01-18 13:37:38', 0.00),
(17, 2, 'machine', NULL, 3, 2, 16000.00, NULL, '2024-01-17 12:48:41', '2024-01-24 12:48:41', 'gjnhkcjih', 'mpesa', NULL, 'Completed', NULL, NULL, 1, 1, 36, '2024-01-19 23:37:38', 5861600.00),
(18, 2, 'machine', NULL, 2, 1, 8000.00, NULL, '2024-01-19 13:27:43', '2024-01-20 13:27:43', 'SDFTYUHJo', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '0000-00-00 00:00:00', 0.00),
(19, 2, 'machine', NULL, 2, 1, 8000.00, NULL, '2024-01-19 13:29:30', '2024-01-20 13:29:30', 'SDFTYUHJA', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '0000-00-00 00:00:00', 0.00),
(20, 2, 'machine', NULL, 1, 3, 12500.00, NULL, '2024-01-19 13:38:19', '2024-02-18 13:38:19', 'WRYIYED', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '2024-01-19 14:38:19', 0.00),
(21, 2, 'stock', 5, NULL, 2, 9800.00, NULL, '2024-01-19 14:40:48', '2024-01-26 14:40:48', 'SDFTYUHJDFGHJ', 'mpesa', NULL, 'unconfirmed', NULL, NULL, 2, 2, 0, '0000-00-00 00:00:00', 0.00),
(22, 0, 'stock', 4, NULL, 2, 2.00, 2.00, '2024-01-19 22:29:27', '2024-01-21 09:29:39', '5Y758481R40731213', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 0, '0000-00-00 00:00:00', 0.00),
(23, 2, 'stock', 4, NULL, 1, 2.00, 2.00, '2024-01-19 22:50:32', '2024-01-21 09:50:48', '2Y8138973P070533U', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 0, '0000-00-00 00:00:00', 0.00),
(24, 2, 'stock', 5, NULL, 3, 46.00, 46.00, '2024-01-19 23:04:10', '2024-01-21 10:04:21', '0TP122170V542031W', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 0, '0000-00-00 00:00:00', 0.00),
(25, 2, 'stock', 1, NULL, 1, 44.00, 44.00, '2024-01-19 23:07:29', '2024-01-21 10:07:38', '9AC59888MY0582824', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 0, '2024-01-20 11:07:38', 0.00),
(26, 2, 'stock', 3, NULL, 2, 50.00, 50.00, '2024-01-19 23:22:54', '2024-01-21 10:23:04', '2TG52430M9088243B', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 0, '0000-00-00 00:00:00', 0.00),
(27, 2, 'stock', 5, NULL, 1, 51.87, 51.87, '2024-01-19 23:25:16', '2024-01-21 10:25:24', '7BH97146EP394452W', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 0, '0000-00-00 00:00:00', 0.00),
(28, 2, 'machine', NULL, 2, 3, 53.00, 53.00, '2024-01-20 00:14:46', '2024-01-21 11:14:55', '3UT49129WV8324502', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 16, '2024-01-21 04:14:55', 127200.00),
(29, 2, 'machine', NULL, 1, 2, 83.33, 83.33, '2024-01-20 00:26:40', '2024-01-21 11:26:52', '16A0087651916520H', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 16, '2024-01-21 04:26:52', 99996.00),
(30, 2, 'stock', 1, NULL, 2, 43.87, 43.87, '2024-01-20 00:35:52', '2024-01-21 11:36:01', '9FR33033WB134374E', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 0, '0000-00-00 00:00:00', 0.00),
(31, 3, 'stock', 4, NULL, 2, 60.00, 60.00, '2024-01-20 07:17:29', '2024-01-21 18:17:41', '3HM0145400048021V', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 0, '0000-00-00 00:00:00', 0.00),
(32, 3, 'machine', NULL, 2, 1, 53.33, 53.33, '2024-01-20 21:14:48', '2024-01-22 08:14:57', '86X186648T779091B', 'paypal', 'USD', 'Completed', 'sb-azzm029200761@personal.example.com', 'KE', 2, 1, 0, '2024-01-21 09:14:57', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `machine_id` int(11) NOT NULL,
  `machine_name` varchar(200) NOT NULL,
  `percentage_interest` float(5,2) NOT NULL,
  `machine_price` float(10,2) NOT NULL,
  `machine_status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`machine_id`, `machine_name`, `percentage_interest`, `machine_price`, `machine_status`, `delete_flag`) VALUES
(1, 'V-series (V1)', 50.00, 12500.00, 1, 0),
(2, 'M-series (M1)', 100.00, 8000.00, 1, 0),
(3, 'K-series (K1)', 85.00, 16000.00, 1, 0),
(4, 'rtyuih', 76.00, 5678.00, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `hours` int(11) DEFAULT NULL,
  `plan_status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `plan_name`, `hours`, `plan_status`, `delete_flag`) VALUES
(1, '1 Day', 24, 1, 0),
(2, '1 Week', 168, 1, 0),
(3, '1 Month', 720, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int(11) NOT NULL,
  `stock_name` varchar(200) NOT NULL,
  `percentage_interest` float(5,2) NOT NULL,
  `stock_status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `stock_name`, `percentage_interest`, `stock_status`, `delete_flag`) VALUES
(1, 'Apple', 55.00, 1, 0),
(2, 'Microsoft', 70.00, 1, 0),
(3, 'Google', 77.00, 1, 0),
(4, 'Tesla', 60.00, 1, 0),
(5, 'Amazon', 91.00, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `profileImage` varchar(255) DEFAULT NULL,
  `registerDate` datetime DEFAULT current_timestamp(),
  `verified` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `code_expiry` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `firstName`, `lastName`, `email`, `phone`, `username`, `password`, `profileImage`, `registerDate`, `verified`, `delete_flag`, `token`, `token_expiry`, `code`, `code_expiry`, `type`) VALUES
(1, 'Michael', 'Doe', 'doemichael@gmail.com', '0712345678', 'doemichael', '@Test23', NULL, '2024-01-12 12:15:17', 1, 0, NULL, NULL, NULL, NULL, 2),
(2, 'Felix', 'Developer', 'heribertfel20@gmail.com', '0712345678', NULL, '$2y$10$8QFo6a2hPTAY05SsWRRn9OyOlo58f0XrsUydcySQSvxkU73IieXFK', NULL, '2024-01-15 14:10:18', 0, 0, NULL, NULL, NULL, NULL, 1),
(3, 'Test', 'User', 'test@gmail.com', '0712345678', NULL, '$2y$10$lPSeUjZWIfc7H8XnEIFUN.ljO/gVMrAOO5T3f3uGtOAiUY/4HJtdK', NULL, '2024-01-20 20:49:10', 1, 0, NULL, NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `return_interest` float(10,2) NOT NULL DEFAULT 0.00,
  `total_withdrawn` float(10,2) NOT NULL DEFAULT 0.00,
  `account_balance` float(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`account_id`, `user_id`, `return_interest`, `total_withdrawn`, `account_balance`) VALUES
(13, 2, 8305053.00, 500.00, 8304553.00);

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `withdraw_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `withdraw_amount` int(11) NOT NULL,
  `recipient_number` varchar(15) DEFAULT NULL,
  `recipient_email` varchar(100) DEFAULT NULL,
  `withdraw_request_date` datetime NOT NULL,
  `transaction_ref` varchar(100) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 2,
  `type` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`withdraw_id`, `user_id`, `withdraw_amount`, `recipient_number`, `recipient_email`, `withdraw_request_date`, `transaction_ref`, `comment`, `updated`, `status`, `type`) VALUES
(1, 2, 500, '0712345678', NULL, '2024-01-19 11:41:48', 'WERTYUIFGH', NULL, '2024-01-19 13:23:57', 1, 1),
(2, 2, 1000, '0712345678', NULL, '2024-01-19 12:58:03', NULL, NULL, '2024-01-19 14:44:37', 2, 1),
(7, 2, 500, NULL, 'paulkavilao1@gmail.com', '2024-01-19 14:26:57', NULL, NULL, '2024-01-19 14:44:44', 2, 2),
(11, 2, 768, NULL, 'paulkavilao1@gmail.com', '2024-01-19 14:43:20', NULL, NULL, '2024-01-19 14:54:21', 0, 2),
(12, 2, 500, '0712345678', NULL, '2024-01-19 14:44:11', NULL, NULL, NULL, 2, 1),
(13, 2, 100, '0712345678', NULL, '2024-01-20 20:36:35', NULL, NULL, NULL, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`investment_id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`machine_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`withdraw_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `investment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `machine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `withdraw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `account_update_event_for_all_users_mpesa` ON SCHEDULE EVERY 1 HOUR STARTS '2024-01-18 14:07:48' ON COMPLETION NOT PRESERVE ENABLE DO CALL UpdateUserAccountForAllUsersMpesa()$$

CREATE DEFINER=`root`@`localhost` EVENT `machine_cycle_event_mpesa` ON SCHEDULE EVERY 1 MINUTE STARTS '2024-01-18 16:11:11' ON COMPLETION NOT PRESERVE ENABLE DO CALL UpdateUserAccountForAllUsersWithMachinesMpesa()$$

CREATE DEFINER=`root`@`localhost` EVENT `account_update_event_for_all_users_paypal` ON SCHEDULE EVERY 1 HOUR STARTS '2024-01-21 10:41:52' ON COMPLETION NOT PRESERVE ENABLE DO CALL UpdateUserAccountForAllUsersPaypal()$$

CREATE DEFINER=`root`@`localhost` EVENT `machine_cycle_event_paypal` ON SCHEDULE EVERY 1 MINUTE STARTS '2024-01-21 10:43:56' ON COMPLETION NOT PRESERVE ENABLE DO CALL UpdateUserAccountForAllUsersWithMachinesPaypal()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
