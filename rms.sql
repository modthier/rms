SET @OLD_TIME_ZONE = @@TIME_ZONE;
SET TIME_ZONE = '+00:00';
/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `rms`
--
CREATE DATABASE IF NOT EXISTS `rms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rms`;
START TRANSACTION;

-- --------------------------------------------------------

--
-- Table structure for table `advances`
--

CREATE TABLE `advances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_shifts`
--

CREATE TABLE `cash_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `opened_at` timestamp NOT NULL,
  `opening_cash` decimal(14,2) NOT NULL DEFAULT 0.00,
  `closed_at` timestamp NULL DEFAULT NULL,
  `closing_cash` decimal(14,2) DEFAULT NULL,
  `expected_cash` decimal(14,2) DEFAULT NULL,
  `difference` decimal(14,2) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` varchar(16) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_shifts`
--

INSERT INTO `cash_shifts` (`id`, `user_id`, `opened_at`, `opening_cash`, `closed_at`, `closing_cash`, `expected_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, '2026-08-15 07:10:04', 0.00, '2026-08-15 07:11:50', 173.00, 137.00, 36.00, NULL, 'closed', '2026-08-15 07:10:04', '2026-08-15 07:11:50');

-- --------------------------------------------------------

--
-- Table structure for table `daily_consumptions`
--

CREATE TABLE `daily_consumptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_expenses`
--

CREATE TABLE `daily_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_type_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `day_salary` decimal(10,2) NOT NULL,
  `hire_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_changes`
--

CREATE TABLE `expense_changes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_expense_id` bigint(20) UNSIGNED NOT NULL,
  `expense_type_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_types`
--

CREATE TABLE `expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ingredient` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `ingredient`, `created_at`, `updated_at`) VALUES
(1, 'كبدة', '2021-02-28 16:00:52', '2021-02-28 16:00:52'),
(2, 'هوت دوق', '2021-02-28 16:03:10', '2021-02-28 16:03:10'),
(3, 'دجاج', '2021-02-28 16:05:41', '2021-02-28 16:05:41'),
(4, 'اخري', '2021-02-28 16:07:33', '2021-02-28 16:21:01'),
(5, 'لحمة', '2021-12-05 05:54:42', '2021-12-05 05:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(8,2) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `item_type_id` bigint(20) UNSIGNED NOT NULL,
  `ingredient_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `icon`, `item_type_id`, `ingredient_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'فراخ كامله مشوي', 100.00, '63222ee000b5a.png', 3, 3, 1, '2022-09-14 15:43:28', '2022-09-14 15:43:28'),
(2, 'بيرقر جامبو', 100.00, '632b768aa8676.png', 1, 5, 1, '2022-09-21 16:39:38', '2022-09-21 16:39:38'),
(3, 'كوكا كولا', 100.00, '632b76aec6a2f.png', 2, 4, 1, '2022-09-21 16:40:14', '2022-09-21 16:40:14'),
(4, 'نص فراخ مشوي', 100.00, '632b76dce7f98.png', 3, 3, 1, '2022-09-21 16:41:00', '2024-05-22 12:55:55'),
(5, 'شاورما جامبو', 100.00, '632b76ffb48ab.png', 1, 5, 1, '2022-09-21 16:41:35', '2022-09-21 16:41:35'),
(6, 'فراولة', 100.00, '632b7717bcb23.png', 2, 4, 1, '2022-09-21 16:41:59', '2022-09-21 16:41:59'),
(7, 'بيرقر عادي', 50.00, '6548ff92096a3.png', 1, 5, 1, '2023-11-06 11:00:34', '2024-02-09 04:48:46'),
(8, 'شاي', 20.00, '6549000d80a5f.png', 4, 4, 1, '2023-11-06 11:02:37', '2023-11-06 11:02:37'),
(9, 'بيرقر علي الفحم', 137.00, '65ad0b81c737c.png', 1, 5, 1, '2023-12-28 10:12:33', '2024-05-22 12:55:55'),
(10, 'بيرقر مشوي', 503.00, '65ad0b56b3287.png', 1, 5, 1, '2023-12-28 10:13:27', '2024-05-22 12:55:55');

-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE `item_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_types`
--

INSERT INTO `item_types` (`id`, `type`, `label`, `created_at`, `updated_at`) VALUES
(1, 'ساندوتش', 'سندوتشات', '2021-02-28 16:43:02', '2021-02-28 16:43:02'),
(2, 'مشروب', 'مشروبات', '2021-02-28 16:45:21', '2021-02-28 16:56:54'),
(3, 'طلب', 'طلبات', '2022-09-14 15:36:32', '2022-09-14 15:36:32'),
(4, 'مشروبات ساخنة', 'مشروبات ساخنة', '2023-11-06 11:02:02', '2023-11-06 11:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_00_00_000000_create_websockets_statistics_entries_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_000001_create_roles_table', 1),
(4, '2014_10_12_000002_add_role_id_to_users_table', 1),
(5, '2014_10_12_000003_create_settings_table', 1),
(6, '2014_10_12_000004_create_employees_table', 1),
(7, '2014_10_12_000005_create_advances_table', 1),
(8, '2014_10_12_000006_create_attendances_table', 1),
(9, '2014_10_12_100000_create_password_resets_table', 1),
(10, '2014_10_12_100000_create_sessions_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(13, '2021_02_20_000000_create_units_table', 1),
(14, '2021_02_20_000001_create_ingredients_table', 1),
(15, '2021_02_21_000000_create_stocks_table', 1),
(16, '2021_02_21_000001_create_purchase_orders_table', 1),
(17, '2021_02_22_000000_create_daily_consumptions_table', 1),
(18, '2021_02_22_000000_create_expense_types_table', 1),
(19, '2021_02_23_171710_create_daily_expenses_table', 1),
(20, '2026_08_15_000000_create_cash_shifts_and_related_columns', 2),
(21, '2026_06_13_000000_add_receipt_mode_to_settings_table', 3),
(22, '2023_01_07_073020_create_purchase_items_table', 4),
(23, '2023_12_11_000000_create_payments_table', 4),
(24, '2023_12_11_000001_create_orders_table', 4),
(25, '2023_12_12_093933_add_status_to_orders_table', 4),
(26, '2023_12_13_134517_create_order_types_table', 4),
(27, '2023_12_13_141707_add_order_type_id_to_order_table', 4),
(28, '2023_12_14_050538_add_returned_to_orders_table', 4),
(29, '2023_12_15_000000_create_item_types_table', 4),
(30, '2023_12_15_000001_create_items_table', 4),
(31, '2023_12_15_000002_create_order_details_table', 4),
(32, '2023_12_24_052907_create_requirement_types_table', 4),
(33, '2023_12_24_054029_create_requirements_table', 4),
(34, '2023_12_24_121441_create_requirment_changes_table', 4),
(35, '2023_12_27_090532_create_expense_changes_table', 4),
(36, '2023_12_27_104924_create_expense_types_table', 4),
(37, '2024_02_08_093004_create_suppliers_table', 4),
(38, '2024_02_08_100328_add_fields_to_purchase_orders', 4),
(39, '2025_03_08_120000_add_performance_indexes_to_orders_and_expenses', 4),
(40, '2026_03_08_000000_add_deleted_at_to_requirements_table', 4),
(41, '2026_03_08_232431_add_label_to_items_types', 4),
(42, '2026_03_23_210000_convert_numeric_columns_to_decimal', 4),
(43, '2026_03_24_000000_add_runtime_performance_indexes', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(14,2) NOT NULL DEFAULT 0.00,
  `total_items` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `order_type_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `returned` tinyint(4) NOT NULL DEFAULT 0,
  `cash_shift_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `total_items`, `created_at`, `updated_at`, `payment_id`, `status`, `order_type_id`, `returned`, `cash_shift_id`) VALUES
(1, 1, 250.00, 3, '2026-03-23 21:40:38', '2026-03-23 21:40:38', 1, 0, 1, 0, NULL),
(2, 1, 503.00, 1, '2026-03-23 21:55:20', '2026-03-23 21:55:20', 1, 0, 1, 0, NULL),
(3, 1, 503.00, 1, '2026-03-23 22:02:26', '2026-03-23 22:02:26', 1, 0, 1, 0, NULL),
(4, 1, 503.00, 1, '2026-03-23 22:02:43', '2026-03-23 22:02:43', 1, 0, 1, 0, NULL),
(5, 1, 137.00, 1, '2026-03-23 22:03:16', '2026-03-23 22:03:16', 1, 0, 1, 0, NULL),
(6, 1, 200.00, 2, '2026-03-23 22:03:56', '2026-03-23 22:03:56', 1, 0, 1, 0, NULL),
(7, 4, 137.00, 1, '2026-08-15 07:10:15', '2026-08-15 07:10:15', 1, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(14,2) NOT NULL DEFAULT 0.00,
  `returned` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `item_id`, `order_id`, `quantity`, `price`, `returned`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 100.00, 0, '2026-03-23 21:40:38', '2026-03-23 21:40:38'),
(2, 5, 1, 1, 100.00, 0, '2026-03-23 21:40:38', '2026-03-23 21:40:38'),
(3, 7, 1, 1, 50.00, 0, '2026-03-23 21:40:38', '2026-03-23 21:40:38'),
(4, 10, 2, 1, 503.00, 0, '2026-03-23 21:55:20', '2026-03-23 21:55:20'),
(5, 10, 3, 1, 503.00, 0, '2026-03-23 22:02:26', '2026-03-23 22:02:26'),
(6, 10, 4, 1, 503.00, 0, '2026-03-23 22:02:43', '2026-03-23 22:02:43'),
(7, 9, 5, 1, 137.00, 0, '2026-03-23 22:03:16', '2026-03-23 22:03:16'),
(8, 6, 6, 2, 200.00, 0, '2026-03-23 22:03:56', '2026-03-23 22:03:56'),
(9, 9, 7, 1, 137.00, 0, '2026-08-15 07:10:15', '2026-08-15 07:10:15');

-- --------------------------------------------------------

--
-- Table structure for table `order_types`
--

CREATE TABLE `order_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_types`
--

INSERT INTO `order_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'محلي', NULL, NULL),
(2, 'سفري', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_cash` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `method`, `created_at`, `updated_at`, `is_cash`) VALUES
(1, 'كاش', '2021-03-10 15:26:07', '2021-03-10 15:27:49', 1),
(2, 'بنكك', '2021-03-10 15:29:10', '2021-03-10 15:29:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `ingredient_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `subtotal` decimal(14,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(14,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE `requirements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `total_price` decimal(14,2) NOT NULL DEFAULT 0.00,
  `requirement_type_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requirement_types`
--

CREATE TABLE `requirement_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requirment_changes`
--

CREATE TABLE `requirment_changes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `requirement_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `total_price` decimal(14,2) NOT NULL DEFAULT 0.00,
  `requirement_type_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'user', '2021-03-01 11:28:14', '2021-03-01 11:28:14'),
(2, 'admin', '2021-03-01 11:28:14', '2021-03-01 11:28:14'),
(3, 'stockeeper', '2021-03-01 11:28:14', '2021-03-01 11:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `receipt_mode` varchar(20) NOT NULL DEFAULT 'dual',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `receipt_mode`, `created_at`, `updated_at`) VALUES
(1, 'RMS', 'dual', '2026-08-15 07:17:19', '2026-08-15 07:17:19');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ingredient_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(14,3) NOT NULL DEFAULT 0.000,
  `total_price` decimal(14,2) NOT NULL DEFAULT 0.00,
  `unit_price` decimal(14,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(4) DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `active`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'mod47387', 'mod47387@yahoo.com', NULL, '$2y$10$epTecdXxOLsdivQg7ch4Neav/v0eNuHje7s.c5mT95KzySA1AnDee', 'gTLwieXbMdoy7MOljabf4g2w2wJPIyspzitGr3qnjNmjEXBkZMC8zEPJ9HBu', '2021-03-01 12:38:39', '2021-03-02 19:56:32'),
(2, 3, 1, 'مدثر سمير', 'mod47387@gmail.com', NULL, '$2y$10$zvKlhLNxPBmSPsvgJ2pGeu208KRoFkGTRBlP334a5jTMSbDdFTTfm', NULL, '2021-03-07 06:23:18', '2023-12-24 05:02:05'),
(3, 1, 1, 'الشيخ عباس', 'abbas@gmail.com', NULL, '$2y$10$ts0zyDHjru8wAxRMgYVLzev4ycmObggV68sdJ583gBmTNFmSqh4Hm', 'aYzIsXAgwTtERVZzNj4T6IoOvFvRlkFiamh8gLVIgYYgeCxKVZ12pFEZ9Jqb', '2021-03-07 12:48:53', '2023-12-14 00:05:00'),
(4, 2, 1, 'admin', 'admin@rms.com', NULL, '$2y$10$ZNEXWK1oOjr0C.kjbfSTB.qlaotYElzeJWh57hpJocDgxRlDBiJui', NULL, '2021-10-03 02:30:43', '2021-10-03 02:30:43'),
(5, 3, 1, 'Beck Parks', 'user@store.com', NULL, '$2y$10$GgM1qXmiXpcHzeMiMCJiHO8RPhMyyEHTO9KJIZDI5XY9XS4maHBk6', NULL, '2023-12-13 08:48:28', '2023-12-13 08:48:28');

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advances`
--
ALTER TABLE `advances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advances_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_employee_id_foreign` (`employee_id`),
  ADD KEY `attendances_created_at_idx` (`created_at`),
  ADD KEY `attendances_employee_created_idx` (`employee_id`,`created_at`);

--
-- Indexes for table `cash_shifts`
--
ALTER TABLE `cash_shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_shifts_user_id_status_index` (`user_id`,`status`),
  ADD KEY `cash_shifts_opened_at_index` (`opened_at`);

--
-- Indexes for table `daily_consumptions`
--
ALTER TABLE `daily_consumptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_consumptions_stock_id_foreign` (`stock_id`),
  ADD KEY `daily_consumptions_created_at_idx` (`created_at`),
  ADD KEY `daily_consumptions_stock_created_idx` (`stock_id`,`created_at`);

--
-- Indexes for table `daily_expenses`
--
ALTER TABLE `daily_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_expenses_expense_type_id_foreign` (`expense_type_id`),
  ADD KEY `daily_expenses_user_id_foreign` (`user_id`),
  ADD KEY `daily_expenses_created_at_index` (`created_at`),
  ADD KEY `daily_expenses_expense_type_id_index` (`expense_type_id`),
  ADD KEY `daily_expenses_created_at_idx` (`created_at`),
  ADD KEY `daily_expenses_user_created_idx` (`user_id`,`created_at`),
  ADD KEY `daily_expenses_expense_created_idx` (`expense_type_id`,`created_at`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_changes`
--
ALTER TABLE `expense_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_changes_daily_expense_id_foreign` (`daily_expense_id`),
  ADD KEY `expense_changes_expense_type_id_foreign` (`expense_type_id`),
  ADD KEY `expense_changes_user_id_foreign` (`user_id`);

--
-- Indexes for table `expense_types`
--
ALTER TABLE `expense_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for tables with omitted primary keys
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `item_types`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_cash_shift_id_foreign` (`cash_shift_id`),
  ADD KEY `orders_user_id_cash_shift_id_index` (`user_id`,`cash_shift_id`),
  ADD KEY `orders_created_at_index` (`created_at`),
  ADD KEY `orders_status_index` (`status`),
  ADD KEY `orders_returned_index` (`returned`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_created_at_returned_index` (`created_at`,`returned`),
  ADD KEY `orders_created_at_idx` (`created_at`),
  ADD KEY `orders_returned_created_idx` (`returned`,`created_at`),
  ADD KEY `orders_user_created_idx` (`user_id`,`created_at`),
  ADD KEY `orders_status_created_idx` (`status`,`created_at`),
  ADD KEY `orders_payment_created_idx` (`payment_id`,`created_at`);

ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_index` (`order_id`),
  ADD KEY `order_details_item_id_index` (`item_id`),
  ADD KEY `order_details_created_at_index` (`created_at`),
  ADD KEY `order_details_created_at_idx` (`created_at`),
  ADD KEY `order_details_order_created_idx` (`order_id`,`created_at`),
  ADD KEY `order_details_item_created_idx` (`item_id`,`created_at`);

ALTER TABLE `order_types`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_items_created_at_idx` (`created_at`),
  ADD KEY `purchase_items_purchase_created_idx` (`purchase_id`,`created_at`),
  ADD KEY `purchase_items_ingredient_created_idx` (`ingredient_id`,`created_at`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_orders_user_id_foreign` (`user_id`),
  ADD KEY `purchase_orders_created_at_idx` (`created_at`),
  ADD KEY `purchase_orders_supplier_created_idx` (`supplier_id`,`created_at`);

--
-- Indexes for table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requirements_unit_id_foreign` (`unit_id`),
  ADD KEY `requirements_created_at_idx` (`created_at`),
  ADD KEY `requirements_type_created_idx` (`requirement_type_id`,`created_at`);

--
-- Indexes for table `requirement_types`
--
ALTER TABLE `requirement_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requirment_changes`
--
ALTER TABLE `requirment_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requirment_changes_requirement_id_foreign` (`requirement_id`),
  ADD KEY `requirment_changes_requirement_type_id_foreign` (`requirement_type_id`),
  ADD KEY `requirment_changes_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_ingredient_id_foreign` (`ingredient_id`),
  ADD KEY `stocks_unit_id_foreign` (`unit_id`),
  ADD KEY `stocks_created_at_idx` (`created_at`),
  ADD KEY `stocks_ingredient_created_idx` (`ingredient_id`,`created_at`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advances`
--
ALTER TABLE `advances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_shifts`
--
ALTER TABLE `cash_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_consumptions`
--
ALTER TABLE `daily_consumptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_expenses`
--
ALTER TABLE `daily_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_changes`
--
ALTER TABLE `expense_changes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_types`
--
ALTER TABLE `expense_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_types`
--
ALTER TABLE `order_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requirements`
--
ALTER TABLE `requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requirement_types`
--
ALTER TABLE `requirement_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requirment_changes`
--
ALTER TABLE `requirment_changes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advances`
--
ALTER TABLE `advances`
  ADD CONSTRAINT `advances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_shifts`
--
ALTER TABLE `cash_shifts`
  ADD CONSTRAINT `cash_shifts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `daily_consumptions`
--
ALTER TABLE `daily_consumptions`
  ADD CONSTRAINT `daily_consumptions_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `daily_expenses`
--
ALTER TABLE `daily_expenses`
  ADD CONSTRAINT `daily_expenses_expense_type_id_foreign` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `daily_expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expense_changes`
--
ALTER TABLE `expense_changes`
  ADD CONSTRAINT `expense_changes_daily_expense_id_foreign` FOREIGN KEY (`daily_expense_id`) REFERENCES `daily_expenses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expense_changes_expense_type_id_foreign` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expense_changes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_cash_shift_id_foreign` FOREIGN KEY (`cash_shift_id`) REFERENCES `cash_shifts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `requirements`
--
ALTER TABLE `requirements`
  ADD CONSTRAINT `requirements_requirement_type_id_foreign` FOREIGN KEY (`requirement_type_id`) REFERENCES `requirement_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requirements_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `requirment_changes`
--
ALTER TABLE `requirment_changes`
  ADD CONSTRAINT `requirment_changes_requirement_id_foreign` FOREIGN KEY (`requirement_id`) REFERENCES `requirements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requirment_changes_requirement_type_id_foreign` FOREIGN KEY (`requirement_type_id`) REFERENCES `requirement_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requirment_changes_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ingredient_id_foreign` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stocks_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

SET TIME_ZONE = @OLD_TIME_ZONE;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
