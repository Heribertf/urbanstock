INSERT INTO user_account (user_id, return_interest, account_balance)
SELECT i.user_id,
    COALESCE(
        SUM(i.paid_amount * s.percentage_interest / 100),
        0
    ) AS new_return_interest,
    COALESCE(
        SUM(i.paid_amount * s.percentage_interest / 100),
        0
    ) AS new_account_balance
FROM investments i
    JOIN stocks s ON i.stock_id = s.stock_id
WHERE i.investment_type = 'stock'
    AND i.close_date < NOW()
    AND i.payment_status = 'Completed'
    AND i.approval_status = 1
    AND i.investment_status = 1
GROUP BY i.user_id ON DUPLICATE KEY
UPDATE return_interest = return_interest +
VALUES(return_interest),
    account_balance = account_balance +
VALUES(account_balance);
UPDATE investments
SET investment_status = 0
WHERE investment_type = 'stock'
    AND close_date < NOW()
    AND payment_status = 'Completed'
    AND approval_status = 1
    AND investment_status = 1;
--CREATING A STORED PROCEDURE FOR UPDATING USER ACCOUNT INFORMATION 
DELIMITER // CREATE PROCEDURE UpdateUserAccountForAllUsers() BEGIN
DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN -- Log or handle the exception
    ROLLBACK;
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'An error occurred during the execution of UpdateUserAccountForAllUsers.';
END;
-- Start a transaction for atomicity
START TRANSACTION;
-- Update existing records in user_account
UPDATE user_account ua
SET ua.return_interest = ua.return_interest + (
        SELECT SUM(i.capital * s.percentage_interest)
        FROM investments i
            JOIN stocks s ON i.stock_id = s.stock_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'stock'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
            AND i.approval_status = 1
            AND i.investment_status = 1
    ),
    ua.account_balance = ua.account_balance + (
        SELECT SUM(i.capital * s.percentage_interest)
        FROM investments i
            JOIN stocks s ON i.stock_id = s.stock_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'stock'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
            AND i.approval_status = 1
            AND i.investment_status = 1
    )
WHERE EXISTS (
        SELECT 1
        FROM investments i
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'stock'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
            AND i.approval_status = 1
            AND i.investment_status = 1
    );
-- Insert new records
INSERT INTO user_account (
        user_id,
        return_interest,
        total_withdrawn,
        account_balance
    )
SELECT i.user_id,
    SUM(i.capital * s.percentage_interest) AS return_interest,
    0.00 AS total_withdrawn,
    SUM(i.capital * s.percentage_interest) AS account_balance
FROM investments i
    JOIN stocks s ON i.stock_id = s.stock_id
WHERE i.close_date <= NOW()
    AND i.investment_type = 'stock'
    AND i.payment_status = 'Completed'
    AND i.approval_status = 1
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
    AND approval_status = 1
    AND investment_status = 1;
-- Commit the transaction
COMMIT;
END // DELIMITER;
--CREATING AN EVENT TO EXECUTE THE STORED PROCEDURE:
SET GLOBAL event_scheduler = ON;
CREATE EVENT daily_update_event_for_all_users ON SCHEDULE EVERY 1 DAY DO BEGIN CALL UpdateUserAccountForAllUsers();
END;
DELIMITER // CREATE PROCEDURE UpdateUserAccountForAllUsersWithMachines() BEGIN
DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN -- Log or handle the exception
    ROLLBACK;
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'An error occurred during the execution of UpdateUserAccountForAllUsersWithMachines.';
END;
-- Start a transaction for atomicity
START TRANSACTION;
-- Update existing records in user_account
UPDATE user_account ua
SET ua.return_interest = ua.return_interest + (
        SELECT SUM(i.capital * m.percentage_interest)
        FROM investments i
            JOIN machines m ON i.machine_id = m.machine_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
            AND i.approval_status = 1
            AND i.investment_status = 1
    ),
    ua.account_balance = ua.account_balance + (
        SELECT SUM(i.capital * m.percentage_interest)
        FROM investments i
            JOIN machines m ON i.machine_id = m.machine_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
            AND i.approval_status = 1
            AND i.investment_status = 1
    )
WHERE EXISTS (
        SELECT 1
        FROM investments i
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.close_date <= NOW()
            AND i.payment_status = 'Completed'
            AND i.approval_status = 1
            AND i.investment_status = 1
    );
-- Insert new records
INSERT INTO user_account (
        user_id,
        return_interest,
        total_withdrawn,
        account_balance
    )
SELECT i.user_id,
    SUM(i.capital * m.percentage_interest) AS return_interest,
    0.00 AS total_withdrawn,
    SUM(i.capital * m.percentage_interest) AS account_balance
FROM investments i
    JOIN machines m ON i.machine_id = m.machine_id
WHERE i.close_date <= NOW()
    AND i.investment_type = 'machine'
    AND i.payment_status = 'Completed'
    AND i.approval_status = 1
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
        SELECT SUM(i.capital * m.percentage_interest)
        FROM investments i
            JOIN machines m ON i.machine_id = m.machine_id
        WHERE investments.investment_id = i.investment_id
    )
WHERE investment_type = 'machine'
    AND close_date <= NOW()
    AND payment_status = 'Completed'
    AND approval_status = 1
    AND investment_status = 1;
-- Commit the transaction
COMMIT;
END // DELIMITER;
DELIMITER // CREATE PROCEDURE UpdateUserAccountForAllUsersWithMachinesAndCycles() BEGIN
DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN -- Log or handle the exception
    ROLLBACK;
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'An error occurred during the execution of UpdateUserAccountForAllUsersWithMachinesAndCycles.';
END;
-- Start a transaction for atomicity
START TRANSACTION;
-- Update existing records in user_account
UPDATE user_account ua
SET ua.return_interest = ua.return_interest + (
        SELECT SUM(i.capital * m.percentage_interest)
        FROM investments i
            JOIN machines m ON i.machine_id = m.machine_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.next_cycle_time <= NOW()
            AND i.payment_status = 'Completed'
            AND i.approval_status = 1
            AND i.investment_status = 1
    ),
    ua.account_balance = ua.account_balance + (
        SELECT SUM(i.capital * m.percentage_interest)
        FROM investments i
            JOIN machines m ON i.machine_id = m.machine_id
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.next_cycle_time <= NOW()
            AND i.payment_status = 'Completed'
            AND i.approval_status = 1
            AND i.investment_status = 1
    )
WHERE EXISTS (
        SELECT 1
        FROM investments i
        WHERE i.user_id = ua.user_id
            AND i.investment_type = 'machine'
            AND i.next_cycle_time <= NOW()
            AND i.payment_status = 'Completed'
            AND i.approval_status = 1
            AND i.investment_status = 1
    );
-- Insert new records
INSERT INTO user_account (
        user_id,
        return_interest,
        total_withdrawn,
        account_balance
    )
SELECT i.user_id,
    SUM(i.capital * m.percentage_interest) AS return_interest,
    0.00 AS total_withdrawn,
    SUM(i.capital * m.percentage_interest) AS account_balance
FROM investments i
    JOIN machines m ON i.machine_id = m.machine_id
WHERE i.next_cycle_time <= NOW()
    AND i.investment_type = 'machine'
    AND i.payment_status = 'Completed'
    AND i.approval_status = 1
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
        SELECT SUM(i.capital * m.percentage_interest)
        FROM investments i
            JOIN machines m ON i.machine_id = m.machine_id
        WHERE investments.investment_id = i.investment_id
    ),
    next_cycle_time = TIMESTAMPADD(HOUR, 1, next_cycle_time)
WHERE investment_type = 'machine'
    AND next_cycle_time <= NOW()
    AND payment_status = 'Completed'
    AND approval_status = 1
    AND investment_status = 1;
UPDATE investments
SET investment_status = 0
WHERE investment_type = 'stock'
    AND close_date <= NOW()
    AND payment_status = 'Completed'
    AND approval_status = 1
    AND investment_status = 1;
-- Commit the transaction
COMMIT;
END // DELIMITER;