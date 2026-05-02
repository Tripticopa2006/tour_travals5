-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2026 at 10:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tour_travals`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `booking_date` datetime NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `package_id`, `booking_date`, `checkin_date`, `checkout_date`, `total_price`, `status`, `created_at`) VALUES
(1, 15, 27, '2026-03-20 10:32:13', '2026-03-21', '2026-03-23', 55000.00, 'confirmed', '2026-03-20 09:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `package_id`, `image_path`, `created_at`) VALUES
(1, 23, 'images/gallery/1773471021_dubai.jpg', '2026-03-14 06:50:21'),
(9, 28, 'images/gallery/1773482871_kolkata1.jpg', '2026-03-14 10:07:52'),
(10, 21, 'images/gallery/1773483030_mumbai2.jpg', '2026-03-14 10:10:30'),
(11, 21, 'images/gallery/1773483082_mumbai3.jpg', '2026-03-14 10:11:22'),
(13, 21, 'images/gallery/1773483295_mumbai.webp', '2026-03-14 10:14:55'),
(14, 21, 'images/gallery/1773483418_1600w-U2RB1oWcGXE.jpg', '2026-03-14 10:16:58'),
(15, 28, 'images/gallery/1773641722_kolkata2.jpg', '2026-03-16 06:15:22'),
(16, 28, 'images/gallery/1773641743_kolkata3.jpg', '2026-03-16 06:15:43'),
(17, 28, 'images/gallery/1773641761_kolkata4.jpg', '2026-03-16 06:16:01'),
(18, 19, 'images/gallery/1773641843_manali2.jpg', '2026-03-16 06:17:23'),
(19, 19, 'images/gallery/1773641861_manali4.jpg', '2026-03-16 06:17:41'),
(20, 19, 'images/gallery/1773641887_manali5.jpg', '2026-03-16 06:18:07'),
(21, 19, 'images/gallery/1773641904_manali6.jpg', '2026-03-16 06:18:24'),
(22, 23, 'images/gallery/1773647890_dubai 5.jpg', '2026-03-16 07:58:10'),
(23, 23, 'images/gallery/1773647912_dubai 4.jpg', '2026-03-16 07:58:32'),
(24, 23, 'images/gallery/1773647955_dubai 8.jpg', '2026-03-16 07:59:15'),
(25, 23, 'images/gallery/1773647990_dubai 3.jpg', '2026-03-16 07:59:50'),
(26, 23, 'images/gallery/1773648022_dubai 2.jpg', '2026-03-16 08:00:22'),
(27, 23, 'images/gallery/1773648044_dubai.jpg', '2026-03-16 08:00:44'),
(28, 20, 'images/gallery/1773648222_varanasi 4.jpg', '2026-03-16 08:03:42'),
(29, 20, 'images/gallery/1773648251_varanasi.jpg', '2026-03-16 08:04:11'),
(30, 20, 'images/gallery/1773648279_varanasi5.jpg', '2026-03-16 08:04:39'),
(31, 20, 'images/gallery/1773648297_varanasi2.jpg', '2026-03-16 08:04:57'),
(32, 27, 'images/gallery/1773648323_thailand2.jpg', '2026-03-16 08:05:23'),
(33, 27, 'images/gallery/1773648365_thailand3.jpg', '2026-03-16 08:06:05'),
(34, 27, 'images/gallery/1773648385_thailand4.jpg', '2026-03-16 08:06:25'),
(35, 27, 'images/gallery/1773648420_thailand5.jpg', '2026-03-16 08:07:00'),
(36, 27, 'images/gallery/1773648456_thailand6.jpg', '2026-03-16 08:07:36'),
(37, 27, 'images/gallery/1773648478_thailand7.jpg', '2026-03-16 08:07:58'),
(38, 27, 'images/gallery/1773648500_thailand8.jpg', '2026-03-16 08:08:21'),
(39, 22, 'images/gallery/1773648703_varanasi 6.jpg', '2026-03-16 08:11:43'),
(40, 22, 'images/gallery/1773648729_varanasi 11.jpg', '2026-03-16 08:12:09'),
(41, 22, 'images/gallery/1773648751_varanasi 10.jpg', '2026-03-16 08:12:31'),
(42, 22, 'images/gallery/1773648780_varanasi 9.jpg', '2026-03-16 08:13:00'),
(43, 22, 'images/gallery/1773648809_varanasi 7.jpg', '2026-03-16 08:13:29'),
(44, 22, 'images/gallery/1773648829_varanasi 8.jpg', '2026-03-16 08:13:49'),
(45, 25, 'images/gallery/1773649266_agra.jpg', '2026-03-16 08:21:08'),
(46, 25, 'images/gallery/1773649376_agra1.jpg', '2026-03-16 08:22:57'),
(47, 25, 'images/gallery/1773649426_agra3.jpg', '2026-03-16 08:23:46'),
(48, 25, 'images/gallery/1773649535_agra4.jpg', '2026-03-16 08:25:35'),
(49, 26, 'images/gallery/1773649597_japan.jpg', '2026-03-16 08:26:37'),
(50, 26, 'images/gallery/1773654728_napal2.jpg', '2026-03-16 09:52:08'),
(51, 26, 'images/gallery/1773654761_nepal.jpg', '2026-03-16 09:52:41'),
(52, 26, 'images/gallery/1773654815_nepal1.jpg', '2026-03-16 09:53:35'),
(53, 26, 'images/gallery/1773654839_nepal3.jpg', '2026-03-16 09:53:59'),
(54, 26, 'images/gallery/1773654864_nepal4.jpg', '2026-03-16 09:54:24');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `posted_at`) VALUES
(1, 'Tripti Dubey', 'dubeytripti436@gmail.com', NULL, 'Manali Package', 'hello', '2026-03-06 09:20:16'),
(2, 'sujita', 'sujita1232@gmail.com', NULL, 'mumbai', 'hello', '2026-03-06 09:36:14'),
(3, 'Tripti Dubey', 'nand86363@gmail.com', NULL, 'Manali Package', 'gddsfghfhfg', '2026-03-09 10:20:28'),
(4, 'ankita dubey', 'ankitadubeyseema2004@gmail.com', '7307984452', 'mumbai', 'hello shululululu', '2026-03-10 09:39:04'),
(5, 'ankita dubey', 'ankitadubeyseema2004@gmail.com', '7307984452', 'mumbai', 'gfjf', '2026-03-10 09:53:12'),
(6, 'ankita dubey', 'ankitadubeyseema2004@gmail.com', '7307984452', 'mumbai', 'yg eeetf', '2026-03-10 09:53:21'),
(7, 'ankita dubey', 'ankitadubeyseema2004@gmail.com', '7307984452', 'mumbai', 'uyuhyuhyhjhghh', '2026-03-10 09:54:26'),
(8, 'Tripti Dubey', 'nand86363@gmail.com', '7887013246', 'mumbai', 'hello ', '2026-03-10 09:56:35'),
(9, 'Tripti Dubey', 'nand86363@gmail.com', '7887013246', 'mumbai', 'hghfdkjg', '2026-03-10 10:07:34'),
(10, 'ankita dubey', 'ankitadubeyseema2004@gmail.com', '7307984452', 'Manali Package', 'ghfdgjkdfhgr', '2026-03-10 10:13:33'),
(11, 'Tripti Dubey', 'nand86363@gmail.com', '7887013246', 'Manali Package', 'gfdghk', '2026-03-10 10:14:11'),
(12, 'neha maurya', 'nm3456008@gmail.com', '8400645242', 'computer', 'erewrrwerwe', '2026-03-20 07:46:43');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `offer_name` varchar(255) DEFAULT NULL,
  `discount_percentage` int(3) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `package_id`, `offer_name`, `discount_percentage`, `start_date`, `end_date`, `image`, `status`) VALUES
(3, 23, 'dubai', 30, NULL, '2026-03-20', '1773736599_dubai 9.jpg', 1),
(4, 21, 'mumbai', 40, NULL, '2026-03-28', '1773736474_mumbai5.jpg', 1),
(5, 27, 'thailand', 20, NULL, '2026-03-25', '1773736343_thailand.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_location` varchar(100) NOT NULL,
  `p_price` decimal(10,2) NOT NULL,
  `p_transport` varchar(50) DEFAULT NULL,
  `p_transport_image` varchar(255) DEFAULT NULL,
  `p_hotel` varchar(255) DEFAULT NULL,
  `p_hotel_image` varchar(255) DEFAULT NULL,
  `p_description` text DEFAULT NULL,
  `p_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `p_name`, `p_location`, `p_price`, `p_transport`, `p_transport_image`, `p_hotel`, `p_hotel_image`, `p_description`, `p_image`, `created_at`) VALUES
(19, 'manali', 'shimala&manali', 15000.00, 'Car', '1773905032_3.jpg', 'Yes', '1773905032_10.jpg', 'Explore snow-capped mountains, Rohtang Pass, and riverside camping with professional guides.', 'manali.jpg', '2026-02-25 09:22:52'),
(20, 'Divine Varanasi & Ganga Aarti Tour', 'Varanasi, Uttar Pradesh', 9000.00, 'Bus', '1773904987_6.jpg', 'Yes', '1773904987_9.jpg', ' Varanasi ki pavitra galiyon ka anubhav karein. Is package mein shamil hai', 'varanasi.jpg', '2026-02-25 09:42:00'),
(21, 'Magical Mumbai City Skyline Tour', 'Mumbai, Maharashtra', 15000.00, 'Bus', '1773903662_3.jpg', 'No', '', 'Sapno ki nagri Mumbai ko kareeb se dekhein. Is package mein shamil hai', 'mumbai5.jpg', '2026-02-25 09:43:40'),
(22, 'Vibrant Goa: Beach & Sunset Special', 'North & South Goa', 23000.00, 'Bike', '1773904942_4.jpg', 'No', '1773904942_8.jpg', 'Goa ghumne ke liye sabse best hai', 'goa.jpg', '2026-02-25 09:51:40'),
(23, 'Luxurious Dubai City Tour', 'Dubai, United Arab Emirates', 35000.00, 'Bike', '1773903450_5.jpg', 'Yes', '1773903450_9.jpg', 'Is package mein aapko milega duniya ki sabse unchi building Burj Khalifa ka nazara', 'dubai 9.jpg', '2026-03-11 08:21:17'),
(25, 'Taj Mahal Wonders Tour', 'Agra, Uttar Pradesh', 55000.00, 'Bus', '1773903394_6.jpg', 'Yes', '1773903394_8.jpg', 'Taj Mahal ka nazaara ab aur bhi khaas Sunrise ke waqt Taj Mahal ki khubsurti dekhiye aur Agra Fort ki history jaaniye', '1600w-A451PcAELtc.jpg', '2026-03-11 08:32:13'),
(26, 'Himalayan Adventure - Kathmandu & Pokhara', 'Kathmandu, Nepal', 35000.00, 'Bike', '1773903352_4.jpg', 'Yes', '1773903352_10.jpg', 'Pahadon ki god mein ek sukoon bhari trip', 'nepal.jpg', '2026-03-11 08:34:21'),
(27, 'Exotic Thailand - Beaches & Nightlife', 'Thailand (Bangkok & Pattaya)', 55000.00, 'Car', '1773903298_2.jpg', 'Yes', '1773903298_9.jpg', 'Thailand ki khoobsurat beaches aur nightlife ka maza lijiye', 'thailand.jpg', '2026-03-11 09:57:23'),
(28, 'The City of Joy: Kolkata Heritage Tour', 'Kolkata, West Bengal', 7499.00, 'Bus', '1773903252_6.jpg', 'Yes', '1773903252_9.jpg', 'package mein aap dekhenge iconic Victoria Memorial, Howrah Bridge, aur Dakshineswar Kali Templ', 'kolkata.jpg', '2026-03-14 10:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `id` int(11) NOT NULL,
  `vehicle_name` varchar(255) NOT NULL,
  `vehicle_type` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `price_per_km` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`id`, `vehicle_name`, `vehicle_type`, `capacity`, `price_per_km`, `image`, `created_at`) VALUES
(1, 'bus', 'Bus', 574657, 544654, 'uploads/transport/1773816274_OIP 8.webp', '2026-03-18 06:44:34'),
(2, 'bus', 'Bus', 1234, 2000, 'uploads/transport/1773819182_OIP 8.webp', '2026-03-18 07:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `created_at`, `address`, `profile_pic`, `reset_token`, `city`, `state`) VALUES
(15, 'Antima devi ', 'antima25062004@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9313062443', '2026-02-25 10:01:24', 'nehiya varanasi ', '1772174148_a3e05e73-5c04-4185-9ae2-731a61c2ddfe.png', '23894ddf6ab615f5c2edf8feaf8aa00d218ff09482eee26a8b4a681de52ecb40', 'sdgfgh', 'gfhfghgh'),
(16, 'Sonam Sahani', 'ssonamsahani078@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', '2026-02-25 10:18:34', NULL, NULL, NULL, NULL, NULL),
(17, 'Abhishek Prajapati', 'abhishekprajapati887404@gmail.com', '202cb962ac59075b964b07152d234b70', '8115716867', '2026-02-26 07:57:23', 'hi i am abhidhek prajapati', NULL, NULL, NULL, NULL),
(18, 'Pritam Gond', 'advpritam07@gmail.com', '25d55ad283aa400af464c76d713c07ad', '9336085841', '2026-02-26 08:06:48', 'Varanasi Utter Pradesh ', NULL, NULL, NULL, NULL),
(19, 'ankita dubey', 'ankitadubeyseema2004@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '7887013246', '2026-02-27 09:50:37', NULL, NULL, 'd3c6cce5344f2f01c0e8b958dd2357abd196c1eb293d1f85b17e5842a40166e2', NULL, NULL),
(20, 'Nand kishor', 'nand86363@gmail.com', '202cb962ac59075b964b07152d234b70', '7235922730', '2026-03-19 07:52:35', NULL, NULL, NULL, NULL, NULL),
(21, 'Sonam Sahani', 'sahanisonam007@gmail.com', '202cb962ac59075b964b07152d234b70', '9651940506', '2026-03-20 06:30:08', 'JAUNPUR UTTAR PRADESH', '1773988262_ruby.jpg', NULL, 'JAUNPUR', 'UTTAR PRADESH'),
(22, 'neha maurya', 'nm3456008@gmail.com', '262f5bdd0af9098e7443ab1f8e435290', '8400645242', '2026-03-20 07:39:12', NULL, NULL, NULL, NULL, NULL),
(23, 'neha maurya', 'neha731784@gmail.com', '262f5bdd0af9098e7443ab1f8e435290', '8400645242', '2026-03-20 07:40:30', 'vikrampur kaithan', 'user_23_1773992571.jpg', NULL, 'varanasi', 'utter pradesh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
