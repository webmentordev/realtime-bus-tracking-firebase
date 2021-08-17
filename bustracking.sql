-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2021 at 07:29 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bustracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `code`) VALUES
(1, 'b552f3b27a0bf29f04105fde7fe51d6d');

-- --------------------------------------------------------

--
-- Table structure for table `admin_codes`
--

CREATE TABLE `admin_codes` (
  `id` int(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `generated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_codes`
--

INSERT INTO `admin_codes` (`id`, `code`, `generated_at`) VALUES
(1, '19a0c1a03b13f953342bd84fcc61ccca', '28, Dec 2020 09:02:55'),
(5, '12d91cff1f19c6f712a57ab9860e99f5', '28, Dec 2020 15:07:51'),
(6, 'ca9f901ab6229c16a499ed8f78267880', '30, Dec 2020 14:19:41'),
(7, '80ad8cd390a85ed70868da62e0f7021c', '30, Dec 2020 14:24:12'),
(8, 'b10c1b7035d4498cd82339dfe0525e8e', '01, Jun 2021 17:10:20 PM');

-- --------------------------------------------------------

--
-- Table structure for table `admin_register`
--

CREATE TABLE `admin_register` (
  `id` int(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `assigned_code` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_register`
--

INSERT INTO `admin_register` (`id`, `fullname`, `email`, `password`, `assigned_code`, `created_at`, `updated_at`) VALUES
(2, 'Ahmer Tahir', 'admin@domain.com', '1f32aa4c9a1d2ea010adcf2348166a04', 'qw4hd', '28, Dec 2020 17:28:08', NULL),
(3, 'hamid', 'hamid@gmail.com', '1f32aa4c9a1d2ea010adcf2348166a04', 'fyou', '30, Dec 2020 14:24:26', '17, May 2021 08:41:58 AM'),
(4, 'Muhammad Ahmer Tahir', 'ahmer99@gmail.com', '1f32aa4c9a1d2ea010adcf2348166a04', 'bigadmin', '01, Jun 2021 08:11:05 PM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` text NOT NULL,
  `message` varchar(255) NOT NULL,
  `contacted_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `email`, `fullname`, `message`, `contacted_at`) VALUES
(3, 'ajj@kmail.com', 'Junaid', '124', '12, Feb 2021 02:26:09 PM'),
(4, 'helo@gmail.com', 'HoHO', 'giaasd', '12, Feb 2021 02:26:22 PM'),
(5, 'ahmertahir99@gmail.com', 'Muhammad Ahmer Tahir', 'Web development is the work involved in developing a Web site for the Internet (World Wide Web) or an intranet (a private network).[1] Web development can range from developing a simple single static page of plain text to complex web applications, electro', '01, May 2021 06:32:45 PM'),
(6, 'ahmertahir99@gmail.com', 'Ahmer', 'Hi', '09, Jul 2021 07:47:15 PM');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `updated_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `image`, `created_at`, `phone_number`, `updated_at`) VALUES
(3, 'Khan Ahmad', '339-nfc.png', '19, Mar 2021 09:20:25 PM', '3025645879', '01, Jun 2021 08:11:34 PM'),
(4, 'Junaid Khan', '168-crysis-3-nanosuit-wallpaper-preview.jpg', '01, Jun 2021 06:43:54 PM', '3036523499', NULL),
(5, 'Kammal hassan', '274-samurai-jack-movie-event.png', '01, Jun 2021 07:54:18 PM', '30034521687', NULL),
(6, 'Hashim', '726-thumb-1920-720203.jpg', '01, Jun 2021 07:54:51 PM', '3024568713', NULL),
(7, 'Zahid Ahmad', '443-crysis-3-nanosuit-wallpaper-preview.jpg', '04, Jun 2021 03:42:42 PM', '3036420189', '30, Jun 2021 10:33:26 PM'),
(8, 'Hassan Ahmad', '955-busmylogo.png', '09, Jul 2021 08:20:29 PM', '3036589744', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(255) NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `msg` longtext NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `to_email`, `subject`, `msg`, `date`) VALUES
(6, 'ahmertahir99@gmail.com', 'Complete Project', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '20, Mar 2021 14:44:32 PM');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `complain` text NOT NULL,
  `issued_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `email`, `fullname`, `complain`, `issued_at`) VALUES
(4, 'k@k.com', 'jo', 'hello There', '29, Dec 2020 06:16:48'),
(5, 'yoyo@gamil.com', 'Hamid', 'HiHi', '29, Dec 2020 10:22:29'),
(6, 'JoJo@j.com', 'kaKa', 'YoYo', '29, Dec 2020 10:27:14 PM'),
(7, 'ahmertahir99@gmail.com', 'Ahmer', 'Hi Report', '09, Jul 2021 07:47:39 PM');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(255) NOT NULL,
  `route_number` int(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `driver_name` varchar(255) NOT NULL DEFAULT 'unknown',
  `created_at` varchar(255) NOT NULL DEFAULT 'empty',
  `updated_at` varchar(255) DEFAULT NULL,
  `tracker` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `route_number`, `icon`, `driver_name`, `created_at`, `updated_at`, `tracker`) VALUES
(25, 1, '282-r_stop.png', 'Khan', '10, Jul 2021 07:54:01 PM', NULL, '0001'),
(27, 2, '327-g_stop.png', 'Junaid', '10, Jul 2021 10:27:19 PM', NULL, '0002');

-- --------------------------------------------------------

--
-- Table structure for table `stops`
--

CREATE TABLE `stops` (
  `id` int(255) NOT NULL,
  `stop_number` int(255) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `route_registered` int(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stops`
--

INSERT INTO `stops` (`id`, `stop_number`, `lat`, `lng`, `icon`, `route_registered`, `created_at`, `updated_at`) VALUES
(76, 1, 31.333330, 71.111115, '282-r_stop.png', 1, '10, Jul 2021 07:54:43 PM', '10, Jul 2021 10:26:50 PM'),
(77, 2, 31.222219, 71.222221, '282-r_stop.png', 1, '10, Jul 2021 07:55:03 PM', NULL),
(83, 1, 31.433331, 71.311111, '327-g_stop.png', 2, '10, Jul 2021 10:27:39 PM', '10, Jul 2021 10:28:13 PM'),
(84, 2, 31.533331, 71.311111, '327-g_stop.png', 2, '10, Jul 2021 10:27:57 PM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(255) NOT NULL,
  `rollnumber` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `lastLogin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `rollnumber`, `created_at`, `email`, `password`, `status`, `lastLogin`) VALUES
(4, '2k17bscs208', '30, Jun 2021 12:56:58 AM', '2k17bscs208@undergrad.nfciet.edu.pk', '1f32aa4c9a1d2ea010adcf2348166a04', 'verified', NULL),
(5, '2k16bscs206', '09, Jul 2021 07:52:08 PM', '2k16bscs206@undergrad.nfciet.edu.pk', '1f32aa4c9a1d2ea010adcf2348166a04', 'verified', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_codes`
--
ALTER TABLE `admin_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_register`
--
ALTER TABLE `admin_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stops`
--
ALTER TABLE `stops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_codes`
--
ALTER TABLE `admin_codes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admin_register`
--
ALTER TABLE `admin_register`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `stops`
--
ALTER TABLE `stops`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
