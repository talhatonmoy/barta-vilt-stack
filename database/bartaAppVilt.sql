-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2024 at 07:23 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bartaAppVilt`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment_body` text NOT NULL,
  `excerpt` text NOT NULL,
  `post_uuid` varchar(255) NOT NULL,
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
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\User', 2, '140cc53b-d592-4c2e-bce2-cac47a6088d6', 'userProfileImage', 'Linkeidn Profile image - high quality', 'Linkeidn-Profile-image---high-quality.png', 'image/png', 'public', 'public', 1303975, '[]', '[]', '[]', '[]', 3, '2024-11-09 21:50:11', '2024-11-09 21:50:11'),
(4, 'App\\Models\\Post', 11, 'adafe253-7cc3-4b37-9b84-2b64610dc54f', 'postImage', 'How to change date format in Vue Js.png', 'How-to-change-date-format-in-Vue-Js.png.png', 'image/png', 'public', 'public', 1622567, '[]', '[]', '[]', '[]', 1, '2024-11-10 23:39:54', '2024-11-10 23:39:54'),
(5, 'App\\Models\\Post', 12, 'ab21aee2-5b55-4114-b908-15252d2d2310', 'postImage', 'banner2', 'banner2.jpg', 'image/jpeg', 'public', 'public', 26588, '[]', '[]', '[]', '[]', 1, '2024-11-11 00:08:12', '2024-11-11 00:08:12'),
(6, 'App\\Models\\Post', 13, 'f64ccc86-16fa-4544-9da4-885d53f31a15', 'postImage', 'How to change date format in Vue Js.png(1)', 'How-to-change-date-format-in-Vue-Js.png(1).png', 'image/png', 'public', 'public', 832293, '[]', '[]', '[]', '[]', 1, '2024-11-11 05:23:59', '2024-11-11 05:23:59'),
(7, 'App\\Models\\Post', 28, '82587237-23c5-49e5-ba2a-7e06147bcfba', 'postImage', '700X100-2', '700X100-2.jpg', 'image/jpeg', 'public', 'public', 44603, '[]', '[]', '[]', '[]', 1, '2024-11-11 06:20:47', '2024-11-11 06:20:47'),
(8, 'App\\Models\\Post', 28, 'a1bb7c69-d53c-47a6-8e3d-4e28bba73dc8', 'postImage', '700x100-3', '700x100-3.jpg', 'image/jpeg', 'public', 'public', 29949, '[]', '[]', '[]', '[]', 2, '2024-11-11 06:20:47', '2024-11-11 06:20:47'),
(9, 'App\\Models\\Post', 28, '1b8419d4-1d80-4020-a34c-b80760b431b1', 'postImage', 'banner1', 'banner1.png', 'image/png', 'public', 'public', 112808, '[]', '[]', '[]', '[]', 3, '2024-11-11 06:20:47', '2024-11-11 06:20:47'),
(10, 'App\\Models\\Post', 28, '5a1de48f-44e3-4209-80c0-9d5b317d8eae', 'postImage', 'banner2', 'banner2.jpg', 'image/jpeg', 'public', 'public', 26588, '[]', '[]', '[]', '[]', 4, '2024-11-11 06:20:47', '2024-11-11 06:20:47'),
(11, 'App\\Models\\Post', 28, '8ee937fa-6cb1-4d7a-9243-9f6056b80f3c', 'postImage', 'banner3', 'banner3.jpg', 'image/jpeg', 'public', 'public', 44708, '[]', '[]', '[]', '[]', 5, '2024-11-11 06:20:47', '2024-11-11 06:20:47'),
(16, 'App\\Models\\Post', 32, '7d1ee753-b0ee-4e56-856a-670100d7ab34', 'postImage', '700x100-3', '700x100-3.jpg', 'image/jpeg', 'public', 'public', 29949, '[]', '[]', '[]', '[]', 1, '2024-11-11 08:23:47', '2024-11-11 08:23:47'),
(17, 'App\\Models\\Post', 32, '43fcee8a-8463-4bb2-9389-cfb31262207c', 'postImage', 'banner1', 'banner1.png', 'image/png', 'public', 'public', 112808, '[]', '[]', '[]', '[]', 2, '2024-11-11 08:23:47', '2024-11-11 08:23:47'),
(19, 'App\\Models\\Post', 32, '8c932e99-0fd3-4648-a5d2-09a6e7edf5ab', 'postImage', 'banner3', 'banner3.jpg', 'image/jpeg', 'public', 'public', 44708, '[]', '[]', '[]', '[]', 4, '2024-11-11 08:23:47', '2024-11-11 08:23:47'),
(20, 'App\\Models\\Post', 33, 'b3811b6b-a87b-401f-bef3-69a1a60a3f1a', 'postImage', 'How to change date format in Vue Js.png', 'How-to-change-date-format-in-Vue-Js.png.png', 'image/png', 'public', 'public', 1622567, '[]', '[]', '[]', '[]', 1, '2024-11-11 08:26:08', '2024-11-11 08:26:08'),
(21, 'App\\Models\\Post', 33, '91626fb5-e97c-478f-a440-4f5620811736', 'postImage', 'How to change date format in Vue Js.png(1)', 'How-to-change-date-format-in-Vue-Js.png(1).png', 'image/png', 'public', 'public', 832293, '[]', '[]', '[]', '[]', 2, '2024-11-11 08:26:08', '2024-11-11 08:26:08'),
(22, 'App\\Models\\Post', 34, '7ab14d3f-0a67-44ef-a101-9d5f3abd7f44', 'postImage', 'banner1', 'banner1.png', 'image/png', 'public', 'public', 112808, '[]', '[]', '[]', '[]', 1, '2024-11-11 08:35:47', '2024-11-11 08:35:47'),
(30, 'App\\Models\\Post', 37, '5d8038bf-ce47-45f5-af53-2c9129d02b35', 'postImage', '700x100-3', '700x100-3.jpg', 'image/jpeg', 'public', 'public', 29949, '[]', '[]', '[]', '[]', 3, '2024-11-11 09:24:55', '2024-11-11 09:24:55'),
(35, 'App\\Models\\Post', 38, '6f1807ab-2047-4649-a2ac-9f7211b004c6', 'postImage', '700X100 aspect ratio', '700X100-aspect-ratio.jpg', 'image/jpeg', 'public', 'public', 36862, '[]', '[]', '[]', '[]', 1, '2024-11-11 10:54:52', '2024-11-11 10:54:52'),
(36, 'App\\Models\\Post', 38, '96eb586e-b7ad-48ad-8541-2301fb872e5d', 'postImage', '700X100-2', '700X100-2.jpg', 'image/jpeg', 'public', 'public', 44603, '[]', '[]', '[]', '[]', 2, '2024-11-11 10:54:52', '2024-11-11 10:54:52'),
(37, 'App\\Models\\Post', 38, '59d1222c-a296-4f4e-a0fb-5a70d4e0bb58', 'postImage', '700x100-3', '700x100-3.jpg', 'image/jpeg', 'public', 'public', 29949, '[]', '[]', '[]', '[]', 3, '2024-11-11 10:54:52', '2024-11-11 10:54:52'),
(38, 'App\\Models\\Post', 38, '458815c4-45af-4757-a875-1f95c18b4366', 'postImage', 'banner1', 'banner1.png', 'image/png', 'public', 'public', 112808, '[]', '[]', '[]', '[]', 4, '2024-11-11 10:54:52', '2024-11-11 10:54:52'),
(39, 'App\\Models\\Post', 38, '37bb139f-fd4a-4f33-aaca-870b3d46a405', 'postImage', 'banner2', 'banner2.jpg', 'image/jpeg', 'public', 'public', 26588, '[]', '[]', '[]', '[]', 5, '2024-11-11 10:54:52', '2024-11-11 10:54:52'),
(40, 'App\\Models\\Post', 38, '35a9446c-204e-4a67-9c1b-84be9ab5a1df', 'postImage', 'banner3', 'banner3.jpg', 'image/jpeg', 'public', 'public', 44708, '[]', '[]', '[]', '[]', 6, '2024-11-11 10:54:52', '2024-11-11 10:54:52'),
(41, 'App\\Models\\Post', 38, '844135c2-0d6c-442a-95ea-15d6ba6858ab', 'postImage', 'Black and Beige Minimalist Aesthetic Modern Simple Typography Agency Logo', 'Black-and-Beige-Minimalist-Aesthetic-Modern-Simple-Typography-Agency-Logo.png', 'image/png', 'public', 'public', 17119, '[]', '[]', '[]', '[]', 7, '2024-11-11 10:54:52', '2024-11-11 10:54:52'),
(42, 'App\\Models\\Post', 39, '9b402ac7-fad0-4050-b269-c796ea95b309', 'postImage', 'banner1', 'banner1.png', 'image/png', 'public', 'public', 112808, '[]', '[]', '[]', '[]', 1, '2024-11-12 05:22:08', '2024-11-12 05:22:08'),
(50, 'App\\Models\\Post', 45, '2882992b-2a32-4f52-bc1c-133556689476', 'postImage', 'How to change date format in Vue Js.png', 'How-to-change-date-format-in-Vue-Js.png.png', 'image/png', 'public', 'public', 1622567, '[]', '[]', '[]', '[]', 1, '2024-11-13 03:40:26', '2024-11-13 03:40:26'),
(51, 'App\\Models\\Post', 45, 'b8c71987-3041-4dd8-91b7-6035b3abcbf3', 'postImage', 'How to change date format in Vue Js.png(1)', 'How-to-change-date-format-in-Vue-Js.png(1).png', 'image/png', 'public', 'public', 832293, '[]', '[]', '[]', '[]', 2, '2024-11-13 03:40:26', '2024-11-13 03:40:26'),
(52, 'App\\Models\\User', 5, 'a18637d9-ce73-412e-b978-ee8abff532a6', 'userProfileImage', 'WhatsApp Image 2024-10-22 at 21.42.58', 'WhatsApp-Image-2024-10-22-at-21.42.58.jpg', 'image/jpeg', 'public', 'public', 134020, '[]', '[]', '[]', '[]', 1, '2024-11-13 05:13:49', '2024-11-13 05:13:49'),
(53, 'App\\Models\\Post', 47, 'a6eba015-cb21-411f-82f5-04340f33c6d7', 'postImage', 'WhatsApp Image 2024-10-22 at 21.42.58', 'WhatsApp-Image-2024-10-22-at-21.42.58.jpeg', 'image/jpeg', 'public', 'public', 173556, '[]', '[]', '[]', '[]', 1, '2024-11-13 05:14:21', '2024-11-13 05:14:21'),
(54, 'App\\Models\\Post', 47, '0c979d2f-6ba4-4e70-a6b8-ff38760195a6', 'postImage', 'WhatsApp Image 2024-10-22 at 21.42.58', 'WhatsApp-Image-2024-10-22-at-21.42.58.jpg', 'image/jpeg', 'public', 'public', 134020, '[]', '[]', '[]', '[]', 2, '2024-11-13 05:14:21', '2024-11-13 05:14:21'),
(55, 'App\\Models\\Post', 48, 'fa7f5f8a-b9fe-4442-8a3e-114d429ef40e', 'postImage', '2-2408100214', '2-2408100214.jpg', 'image/jpeg', 'public', 'public', 273351, '[]', '[]', '[]', '[]', 1, '2024-11-13 05:16:55', '2024-11-13 05:16:55'),
(56, 'App\\Models\\Post', 49, '1a987db4-7646-4dd0-9d60-41fe02164256', 'postImage', '700X100 aspect ratio', '700X100-aspect-ratio.jpg', 'image/jpeg', 'public', 'public', 36862, '[]', '[]', '[]', '[]', 1, '2024-11-13 10:20:18', '2024-11-13 10:20:18'),
(57, 'App\\Models\\Post', 49, '512375d9-2866-4d08-a35c-dfea19aa2b80', 'postImage', '700X100-2', '700X100-2.jpg', 'image/jpeg', 'public', 'public', 44603, '[]', '[]', '[]', '[]', 2, '2024-11-13 10:20:18', '2024-11-13 10:20:18'),
(58, 'App\\Models\\Post', 49, '229589f8-6392-49fc-881a-2dd110ea46e3', 'postImage', '700x100-3', '700x100-3.jpg', 'image/jpeg', 'public', 'public', 29949, '[]', '[]', '[]', '[]', 3, '2024-11-13 10:20:18', '2024-11-13 10:20:18'),
(59, 'App\\Models\\Post', 49, 'fca54334-240c-42dd-acb8-8a4e2795e941', 'postImage', 'banner1', 'banner1.png', 'image/png', 'public', 'public', 112808, '[]', '[]', '[]', '[]', 4, '2024-11-13 10:20:18', '2024-11-13 10:20:18'),
(60, 'App\\Models\\Post', 49, 'd3e6b86b-c1db-432d-a516-fe589f4c4557', 'postImage', 'banner2', 'banner2.jpg', 'image/jpeg', 'public', 'public', 26588, '[]', '[]', '[]', '[]', 5, '2024-11-13 10:20:18', '2024-11-13 10:20:18'),
(61, 'App\\Models\\Post', 49, 'd3e5ea7c-a182-4b28-9471-5b189bb0ddf5', 'postImage', 'banner3', 'banner3.jpg', 'image/jpeg', 'public', 'public', 44708, '[]', '[]', '[]', '[]', 6, '2024-11-13 10:20:18', '2024-11-13 10:20:18'),
(62, 'App\\Models\\Post', 50, '9a85d9d2-92c1-4729-84fc-5cccddd83c47', 'postImage', '10 Essential Steps for Growing Organic Vegetables at Home', '10-Essential-Steps-for-Growing-Organic-Vegetables-at-Home.jpeg', 'image/jpeg', 'public', 'public', 191939, '[]', '[]', '[]', '[]', 1, '2024-11-13 23:25:33', '2024-11-13 23:25:33'),
(63, 'App\\Models\\Post', 50, '9799e1d3-62dd-46d8-ad6e-186c470b28d7', 'postImage', '2-2408100214', '2-2408100214.jpg', 'image/jpeg', 'public', 'public', 273351, '[]', '[]', '[]', '[]', 2, '2024-11-13 23:25:33', '2024-11-13 23:25:33'),
(64, 'App\\Models\\Post', 51, '6eab0260-c760-4be9-9e1b-d89d1f96b2a3', 'postImage', '10 Essential Steps for Growing Organic Vegetables at Home', '10-Essential-Steps-for-Growing-Organic-Vegetables-at-Home.jpeg', 'image/jpeg', 'public', 'public', 191939, '[]', '[]', '[]', '[]', 1, '2024-11-14 00:15:12', '2024-11-14 00:15:12'),
(65, 'App\\Models\\Post', 51, '08a962d8-f3ae-4e41-a7eb-3d3d2bab39bf', 'postImage', '2-2408100214', '2-2408100214.jpg', 'image/jpeg', 'public', 'public', 273351, '[]', '[]', '[]', '[]', 2, '2024-11-14 00:15:12', '2024-11-14 00:15:12'),
(66, 'App\\Models\\Post', 52, '9351f5a6-b935-42c1-acaf-a49b3389495c', 'postImage', '10 Essential Steps for Growing Organic Vegetables at Home', '10-Essential-Steps-for-Growing-Organic-Vegetables-at-Home.jpeg', 'image/jpeg', 'public', 'public', 191939, '[]', '[]', '[]', '[]', 1, '2024-11-14 00:15:53', '2024-11-14 00:15:53'),
(67, 'App\\Models\\Post', 52, 'b6f8e2a6-f44d-4b0f-afac-5d9fe16675b7', 'postImage', '2-2408100214', '2-2408100214.jpg', 'image/jpeg', 'public', 'public', 273351, '[]', '[]', '[]', '[]', 2, '2024-11-14 00:15:53', '2024-11-14 00:15:53');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_09_160603_create_media_table', 2),
(6, '2024_11_10_054909_create_posts_table', 3),
(7, '2024_11_10_085909_create_comments_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_body` text NOT NULL,
  `excerpt` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `uuid`, `user_id`, `post_body`, `excerpt`, `created_at`, `updated_at`) VALUES
(1, '2f4751c5-8d4b-4ef4-994f-49905b39c12c', 2, 'fgsdf', 'fgsdf', '2024-11-10 03:27:09', '2024-11-10 03:27:09'),
(2, 'b80daf14-15de-45bc-aa5f-26ab3999890d', 2, 'PHP এর $ নিয়ে এত টানাটানি না করে চাইলেই কিন্তু PHP কে fork করে PoorPHP নামে নতুন ল্যাঙ্গুয়েজ বানানো যায়।', 'PHP এর $ নিয়ে এত টানাটানি না করে চাইলেই কিন্তু PHP কে fork করে PoorPHP নামে নতুন ল্যাঙ্গুয়েজ বানানো যায়।', '2024-11-10 03:38:16', '2024-11-10 03:38:16'),
(3, 'aabf2364-2db2-4abb-ab95-da87d539b076', 2, 'PHP এর $ নিয়ে এত টানাটানি না করে চাইলেই কিন্তু PHP কে fork করে PoorPHP নামে নতুন ল্যাঙ্গুয়েজ বানানো যায়।\nসবই থাকবে, কেবল $ থাকবে না!\n\nআইডিয়াটা কেমন বন্ধুরা? 😁', 'PHP এর $ নিয়ে এত টানাটানি না করে চাইলেই কিন্তু PHP কে fork করে PoorPHP নামে নতুন ল্যাঙ্গুয়েজ বানানো যায়।\nসবই থাকবে, কেবল $ থাকবে না!\n\nআইডিয়াটা কেমন বন্ধুরা? 😁', '2024-11-10 03:38:45', '2024-11-10 03:38:45'),
(4, '510e7ba4-9dfa-46f3-9156-13a6766b4894', 2, 'sdfgsfd', 'sdfgsfd', '2024-11-10 04:46:29', '2024-11-10 04:46:29'),
(5, '9c438b28-63a1-4d0b-99e4-b10fbdbf9d10', 2, 'sdfsdfdsdffd', 'sdfsdfdsdffd', '2024-11-10 04:46:49', '2024-11-10 04:46:49'),
(6, 'bbca01d2-7912-45af-bf9d-6c622ab53b9a', 2, 'Exciting News!\n\nI’m thrilled to share that I\'m diving into the world of Laravel!  As I embark on this journey of learning one of the most powerful PHP frameworks, I can’t help but feel energized about the new opportunities that await.\n\nLaravel’s elegant syntax and robust features are not just a game-changer for web development but a key to unlocking my potential as a developer. From building RESTful APIs to crafting beautiful applications, I’m eager to explore everything it has to offer.\n\nI’d love to connect with others who are passionate about Laravel! If you have tips, resources, or experiences to share, please drop a comment or send me a message. Let’s learn and grow together! 💪🌱\n\n#LearningJourney #Laravel #WebDevelopment #ContinuousImprovement #TechCommunity', 'Exciting News!\n\nI’m thrilled to share that I\'m diving into the world of Laravel!  As I embark on this journey of learning one of the most powerful PHP frameworks, I can’t help but feel energized about the new opportunities that await.\n\nLaravel’s eleg....', '2024-11-10 06:49:57', '2024-11-10 22:30:46'),
(10, 'ccbf3af0-1dea-45ff-a587-ea74d2757833', 2, 'Exciting News!\r\n\r\nI’m thrilled to share that I\'m diving into the world of Laravel! 🎉 As I embark on this journey of learning one of the most powerful PHP frameworks, I can’t help but feel energized about the new opportunities that await.\r\n\r\nLaravel’s elegant syntax and robust features are not just a game-changer for web development but a key to unlocking my potential as a developer. From building RESTful APIs to crafting beautiful applications, I’m eager to explore everything it has to offer.\r\n\r\nI’d love to connect with others who are passionate about Laravel! If you have tips, resources, or experiences to share, please drop a comment or send me a message. Let’s learn and grow together! 💪🌱\r\n\r\n#LearningJourney #Laravel #WebDevelopment #ContinuousImprovement #TechCommunity', 'Exciting News!\r\n\r\nI’m thrilled to share that I\'m diving into the world of Laravel! 🎉 As I embark on this journey of learning one of the most powerful PHP frameworks, I can’t help but feel energized about the new opportunities that await.\r\n\r\nLaravel’....', '2024-11-10 23:09:49', '2024-11-10 23:09:49'),
(11, '699b2980-1143-44cd-beff-ba993058ea47', 2, 'I’m thrilled to share that I\'m diving into the world of Laravel!  As I embark on this journey of learning one of the most powerful PHP frameworks, I can’t help but feel energized about the new opportunities that await. Done', 'I’m thrilled to share that I\'m diving into the world of Laravel!  As I embark on this journey of learning one of the most powerful PHP frameworks, I can’t help but feel energized about the new opportunities that await. Done', '2024-11-10 23:39:53', '2024-11-11 02:53:21'),
(12, '67ec3137-532f-4171-9c7b-304ae309cede', 2, 'I’d love to connect with others who are passionate about Laravel! If you have tips, resources, or experiences to share, please drop a comment or send me a message. Let’s learn and grow together! 💪🌱\r\n\r\n#LearningJourney #Laravel #WebDevelopment #ContinuousImprovement #TechCommunity', 'I’d love to connect with others who are passionate about Laravel! If you have tips, resources, or experiences to share, please drop a comment or send me a message. Let’s learn and grow together! 💪🌱\r\n\r\n#LearningJourney #Laravel #WebDevelopment #Cont....', '2024-11-11 00:08:12', '2024-11-11 00:08:12'),
(13, '73688737-43df-4418-aa82-eb8c132ba1c3', 2, 'Posts With Mutiple Images', 'Posts With Mutiple Images', '2024-11-11 05:23:59', '2024-11-11 05:23:59'),
(14, 'c8888d2f-baac-4046-a7c1-00ec1d6f2689', 2, 'sd', 'sd', '2024-11-11 06:05:50', '2024-11-11 06:05:50'),
(15, 'cfda76d1-c786-4cc3-8b88-c8a1dc4eff12', 2, 'sd', 'sd', '2024-11-11 06:06:10', '2024-11-11 06:06:10'),
(16, 'ad3b92a4-c0c1-4a9a-a119-c34dd4348764', 2, 'sd', 'sd', '2024-11-11 06:06:37', '2024-11-11 06:06:37'),
(17, '8bcab012-e675-4bd4-8711-2c515fbc4dff', 2, 'sd', 'sd', '2024-11-11 06:07:18', '2024-11-11 06:07:18'),
(18, 'c86ef2d2-4c98-4761-958c-d7f774a96886', 2, 'sd', 'sd', '2024-11-11 06:07:40', '2024-11-11 06:07:40'),
(19, 'eb959c6b-6b94-4a2f-a209-d54afa0f1723', 2, 'dsds', 'dsds', '2024-11-11 06:07:45', '2024-11-11 06:07:45'),
(20, '89731700-e441-446e-9681-f1ffc56a8461', 2, 'sdd', 'sdd', '2024-11-11 06:08:59', '2024-11-11 06:08:59'),
(21, 'df2eb640-d040-421f-810b-93ee9801fa97', 2, 'sds', 'sds', '2024-11-11 06:09:06', '2024-11-11 06:09:06'),
(22, '8db5d251-c5e5-4f8a-aa07-d2e88b82d813', 2, 'sdsd', 'sdsd', '2024-11-11 06:10:03', '2024-11-11 06:10:03'),
(23, 'e6f7c1d4-7de2-4664-b811-4080e1cd442c', 2, 'sdsd', 'sdsd', '2024-11-11 06:11:40', '2024-11-11 06:11:40'),
(24, '14f344c7-13de-425f-b33c-bbbc801be618', 2, 'sdsd', 'sdsd', '2024-11-11 06:15:50', '2024-11-11 06:15:50'),
(25, 'f529f474-9d69-4f5d-a692-b8652929c1bf', 2, 'sdsd', 'sdsd', '2024-11-11 06:16:14', '2024-11-11 06:16:14'),
(26, 'e4c7859f-6537-4c90-b0d2-57b715cfdaf8', 2, 'sd', 'sd', '2024-11-11 06:16:42', '2024-11-11 06:16:42'),
(27, '1f2a5254-c9db-48ff-9209-66ffc13e96c7', 2, 'sd', 'sd', '2024-11-11 06:18:36', '2024-11-11 06:18:36'),
(28, '52a9b55a-a56c-4da1-bbfd-b68e91494069', 2, 'sd', 'sd', '2024-11-11 06:20:47', '2024-11-11 06:20:47'),
(29, '1c8b7e76-bb02-4f59-bad6-07fa85b4139e', 2, 'sdsd', 'sdsd', '2024-11-11 06:21:29', '2024-11-11 06:21:29'),
(30, 'c448fb0e-de95-4e4e-afc4-1fc375ffd176', 2, 'sdddd', 'sdddd', '2024-11-11 08:19:16', '2024-11-11 08:19:16'),
(31, 'd48fc608-5d7a-40eb-aae8-27f4541b42bc', 2, 'ds', 'ds', '2024-11-11 08:19:21', '2024-11-11 08:19:21'),
(32, '6f537cda-237f-45dc-aa35-a3b128597739', 2, 'New Post', 'New Post', '2024-11-11 08:23:47', '2024-11-11 08:23:47'),
(33, '69e6051e-1fd3-472e-98d5-7888fb2f8476', 2, 'New Post Again', 'New Post Again', '2024-11-11 08:26:08', '2024-11-11 08:26:08'),
(34, '72aa2fd9-529f-4141-b50f-330c7919c21a', 2, 'New Post', 'New Post', '2024-11-11 08:35:47', '2024-11-11 08:35:47'),
(35, '9c7ecd73-64c0-4eb8-831d-af5ccb6142ee', 2, 'sds1sd', 'sds1sd', '2024-11-11 08:49:13', '2024-11-12 04:37:01'),
(37, '5649a293-98ab-48e3-83e6-0a398a5ced49', 2, 'ooaass', 'ooaass', '2024-11-11 09:24:55', '2024-11-12 05:20:46'),
(38, '178a5fcf-ca21-4444-8a88-abcd87f7f3eb', 2, 'rrr', 'rrr', '2024-11-11 10:54:52', '2024-11-11 10:54:52'),
(39, 'e8069efa-a10f-473f-a331-f638fdebe825', 2, 'New Post', 'New Post', '2024-11-12 05:22:08', '2024-11-12 05:22:08'),
(41, '4f7ff9c1-7b14-42e8-b072-c2548011a005', 2, 'ki', 'ki', '2024-11-12 05:24:24', '2024-11-12 05:24:24'),
(42, '8f7a0d91-86cb-46d7-8915-ffeea3f5c560', 2, 's', 's', '2024-11-12 08:11:57', '2024-11-12 08:11:57'),
(44, 'b9157ba2-205a-4e2d-b275-0f3384c68aa7', 2, 'ddd', 'ddd', '2024-11-12 08:21:16', '2024-11-12 08:21:16'),
(45, 'f7a9938e-e138-44c5-bf80-1804351a7fc2', 2, 'New Post', 'New Post', '2024-11-13 03:40:26', '2024-11-13 03:40:26'),
(46, '3b1f9edc-9b13-42e3-af9a-5038527dd3c8', 5, 'New Post', 'New Post', '2024-11-13 05:13:57', '2024-11-13 05:13:57'),
(47, 'cf7ddae3-55ec-4ef2-89b0-886bc0450a4f', 5, 'New Post With Image', 'New Post With Image', '2024-11-13 05:14:21', '2024-11-13 05:14:21'),
(48, 'fcdc0714-1aae-44de-a614-85abe478361e', 5, 'Dr Yunush', 'Dr Yunush', '2024-11-13 05:16:55', '2024-11-13 05:16:55'),
(49, '5c27ecaf-7944-4bbb-bb7f-964b15c7f6f6', 2, 'ttt', 'ttt', '2024-11-13 10:20:18', '2024-11-13 23:38:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `bio` varchar(255) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_name`, `bio`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Leila', 'Oliver', 'gybyworiti', NULL, 'jacilozi@mailinator.com', NULL, '$2y$12$WKeVLMZyZMKKn4SxHZzy0OAH/6cdTtPweASLc45anGYeJQDqwo2KK', NULL, '2024-11-09 04:54:49', '2024-11-09 04:54:49'),
(2, 'Abu Talha', 'Tonmoy1', 'atton53', 'Full Stack VILT Web Application Developer', 'atton53@gmail.com', NULL, '$2y$12$iHtordac9E5HlILL9VsMneJ9nzWxd.MOW7Mal2txy6eqX0IQywIa.', NULL, '2024-11-09 05:05:47', '2024-11-11 11:30:27'),
(3, 'Kasper', 'Conley', 'mamuw', NULL, 'qefi@mailinator.com', NULL, '$2y$12$FM/9Hx9MJNjI3LwRwpqrSOz2DQeThKkgLhlPGM7.oXQ.IRj/nJwwm', NULL, '2024-11-09 22:31:14', '2024-11-09 22:31:14'),
(4, 'Abraham', 'Spears', 'piluqaxul', NULL, 'kizukuxiwo@mailinator.com', NULL, '$2y$12$lvOJ99dcALaQ73vsa8TPs.xy3tG3EvcmQUXOfzFgTOlsfqQj5Pj9K', NULL, '2024-11-10 00:39:15', '2024-11-10 00:39:15'),
(5, 'Nuyaiman', 'Bin Talha', 'nuyaiman2023', NULL, 'attonmoy53@gmail.com', NULL, '$2y$12$m8ZKsILkbL.pR2GL3exY5u5rkWhcgX3zGGgmJZn954nams87v7xJ2', NULL, '2024-11-13 05:11:00', '2024-11-13 05:11:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `comments_uuid_unique` (`uuid`),
  ADD KEY `comments_post_id_foreign` (`post_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_uuid_unique` (`uuid`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
