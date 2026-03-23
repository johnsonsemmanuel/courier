-- Courier Savings Bank - Fixed MySQL schema + demo/admin seed
-- How to use:
-- 1) In cPanel/phpMyAdmin, select your database
-- 2) Import this file
-- 3) Login with:
--    - demo@bankapp.com / password
--    - admin@bankapp.com / password
--
-- WARNING:
-- This file DROPS and recreates the tables required by the app, so it will remove existing data in those tables.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `bill_payments`;
DROP TABLE IF EXISTS `bill_payees`;
DROP TABLE IF EXISTS `cards`;
DROP TABLE IF EXISTS `recurring_transfers`;
DROP TABLE IF EXISTS `beneficiaries`;
DROP TABLE IF EXISTS `tax_alerts`;
DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `accounts`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `users`;

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_code` varchar(255) DEFAULT NULL,
  `two_factor_expires_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_user_id_unique` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: accounts
-- --------------------------------------------------------
CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_type` varchar(255) NOT NULL DEFAULT 'savings',
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `account_name` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `withheld_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounts_account_number_unique` (`account_number`),
  KEY `accounts_user_id_foreign` (`user_id`),
  CONSTRAINT `accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: transactions
-- --------------------------------------------------------
CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `recipient_account` varchar(255) DEFAULT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `reference_number` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_reference_number_unique` (`reference_number`),
  KEY `transactions_account_id_foreign` (`account_id`),
  CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: tax_alerts
-- --------------------------------------------------------
CREATE TABLE `tax_alerts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `has_tax_obligation` tinyint(1) NOT NULL DEFAULT 0,
  `tax_amount` decimal(15,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tax_alerts_user_id_foreign` (`user_id`),
  CONSTRAINT `tax_alerts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: kyc_verifications
-- --------------------------------------------------------
CREATE TABLE `kyc_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `id_document_path` varchar(255) DEFAULT NULL,
  `selfie_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kyc_verifications_user_id_foreign` (`user_id`),
  CONSTRAINT `kyc_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: beneficiaries
-- --------------------------------------------------------
-- Note: Your UI queries `is_favorite`, but your migrations don't include it.
-- This table includes it so the dashboard doesn't break.
CREATE TABLE `beneficiaries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL DEFAULT 'Courier Savings Bank',
  `nickname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_favorite` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `beneficiaries_user_id_foreign` (`user_id`),
  KEY `beneficiaries_account_number_index` (`account_number`),
  CONSTRAINT `beneficiaries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: recurring_transfers
-- --------------------------------------------------------
CREATE TABLE `recurring_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `recipient_account` varchar(255) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `frequency` enum('daily','weekly','biweekly','monthly','quarterly','yearly') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `next_execution_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','paused','completed','cancelled') NOT NULL DEFAULT 'active',
  `execution_count` int(11) NOT NULL DEFAULT 0,
  `max_executions` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `recurring_transfers_user_id_foreign` (`user_id`),
  KEY `recurring_transfers_status_index` (`status`),
  KEY `recurring_transfers_next_execution_date_index` (`next_execution_date`),
  CONSTRAINT `recurring_transfers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: cards
-- --------------------------------------------------------
CREATE TABLE `cards` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `card_holder_name` varchar(255) NOT NULL,
  `cvv` varchar(255) NOT NULL,
  `expiry_month` varchar(255) NOT NULL,
  `expiry_year` varchar(255) NOT NULL,
  `card_type` varchar(255) NOT NULL DEFAULT 'virtual',
  `card_brand` varchar(255) NOT NULL DEFAULT 'visa',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `daily_limit` decimal(15,2) NOT NULL DEFAULT 5000.00,
  `monthly_limit` decimal(15,2) NOT NULL DEFAULT 50000.00,
  `daily_spent` decimal(15,2) NOT NULL DEFAULT 0.00,
  `monthly_spent` decimal(15,2) NOT NULL DEFAULT 0.00,
  `last_reset_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cards_card_number_unique` (`card_number`),
  KEY `cards_user_id_foreign` (`user_id`),
  KEY `cards_account_id_foreign` (`account_id`),
  CONSTRAINT `cards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cards_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: bill_payees
-- --------------------------------------------------------
CREATE TABLE `bill_payees` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payee_name` varchar(255) NOT NULL,
  `payee_type` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `is_favorite` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bill_payees_user_id_foreign` (`user_id`),
  CONSTRAINT `bill_payees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: bill_payments
-- --------------------------------------------------------
CREATE TABLE `bill_payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bill_payee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `payee_name` varchar(255) NOT NULL,
  `payee_type` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bill_payments_reference_number_unique` (`reference_number`),
  KEY `bill_payments_user_id_foreign` (`user_id`),
  KEY `bill_payments_bill_payee_id_foreign` (`bill_payee_id`),
  KEY `bill_payments_account_id_foreign` (`account_id`),
  CONSTRAINT `bill_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bill_payments_bill_payee_id_foreign` FOREIGN KEY (`bill_payee_id`) REFERENCES `bill_payees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `bill_payments_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: password_reset_tokens
-- --------------------------------------------------------
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: sessions (database session driver)
-- --------------------------------------------------------
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: cache (database cache store)
-- --------------------------------------------------------
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: cache_locks (database cache locks)
-- --------------------------------------------------------
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Seed demo/admin users (password = "password")
-- --------------------------------------------------------
-- Generated with PHP password_hash('password', PASSWORD_BCRYPT, ['cost'=>12])
-- Hash: $2y$12$aDE2Q7c9K3ifT3/ueyeKZebP8tXKz3goMJJXtzsyF.m8tQkSjGwWO
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `user_id`, `two_factor_enabled`, `two_factor_code`, `two_factor_expires_at`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'demo@bankapp.com', NOW(), '$2y$12$aDE2Q7c9K3ifT3/ueyeKZebP8tXKz3goMJJXtzsyF.m8tQkSjGwWO', '+1 (555) 123-4567', '123 Main Street, New York, NY 10001', 'USR10001', 0, NULL, NULL, 0, NULL, NOW(), NOW()),
(2, 'Admin User', 'admin@bankapp.com', NOW(), '$2y$12$aDE2Q7c9K3ifT3/ueyeKZebP8tXKz3goMJJXtzsyF.m8tQkSjGwWO', '+1 (555) 000-0000', '100 Admin Street, Washington, DC 20001', 'USR00001', 0, NULL, NULL, 1, NULL, NOW(), NOW());

-- Seed accounts
INSERT INTO `accounts` (`id`, `user_id`, `account_number`, `account_name`, `account_type`, `balance`, `withheld_amount`, `status`, `currency`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, '1234567890', 'John Doe Savings', 'savings', 5000.00, 0.00, 'active', 'USD', 1, NOW(), NOW()),
(2, 2, '0000000001', 'Admin Account', 'savings', 100000.00, 0.00, 'active', 'USD', 1, NOW(), NOW());

-- Seed one completed deposit so the dashboard has income to display
INSERT INTO `transactions` (`id`, `account_id`, `transaction_type`, `amount`, `recipient_account`, `recipient_name`, `description`, `status`, `payment_method`, `reference_number`, `created_at`, `updated_at`) VALUES
(1, 1, 'deposit', 5000.00, NULL, NULL, 'Initial deposit', 'completed', NULL, 'TXNDEMO000000001', NOW(), NOW()),
(2, 2, 'deposit', 100000.00, NULL, NULL, 'Admin initial deposit', 'completed', NULL, 'TXNADMIN000000002', NOW(), NOW());

COMMIT;

