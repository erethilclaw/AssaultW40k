-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 26, 2017 at 01:01 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 7.0.24-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assaultw40k`
--

-- --------------------------------------------------------

--
-- Table structure for table `army`
--

CREATE TABLE `army` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `army`
--

INSERT INTO `army` (`id`, `name`) VALUES
(1, 'Tyranids'),
(2, 'Eldar');

-- --------------------------------------------------------

--
-- Table structure for table `army_weapon`
--

CREATE TABLE `army_weapon` (
  `army_id` int(11) NOT NULL,
  `weapon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `tipus` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `tipus`) VALUES
(1, 'ROLE_ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `army_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Ha` int(11) NOT NULL,
  `Hp` int(11) NOT NULL,
  `F` int(11) NOT NULL,
  `R` int(11) NOT NULL,
  `H` int(11) NOT NULL,
  `I` int(11) NOT NULL,
  `A` int(11) NOT NULL,
  `L` int(11) NOT NULL,
  `S` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `army_id`, `name`, `Ha`, `Hp`, `F`, `R`, `H`, `I`, `A`, `L`, `S`) VALUES
(1, 1, 'Termagaunt', 3, 3, 3, 3, 1, 3, 1, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `unit_weapon`
--

CREATE TABLE `unit_weapon` (
  `unit_id` int(11) NOT NULL,
  `weapon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `rol_id`, `username`, `password`) VALUES
(1, 1, 'admin', '$2a$04$dL/xRARWXyU3KBdoXGhNMuFskT53VDzQYeKTgUrZ/xyVQq5IKkOXq');

-- --------------------------------------------------------

--
-- Table structure for table `weapon`
--

CREATE TABLE `weapon` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `distance` int(11) NOT NULL,
  `f` int(11) NOT NULL,
  `fp` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shoots` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `weapon`
--

INSERT INTO `weapon` (`id`, `name`, `distance`, `f`, `fp`, `type`, `shoots`) VALUES
(1, 'Perforacarne', 21, 3, 3, 'Asalto', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `army`
--
ALTER TABLE `army`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `army_weapon`
--
ALTER TABLE `army_weapon`
  ADD PRIMARY KEY (`army_id`,`weapon_id`),
  ADD KEY `IDX_1B3EDEE218D2742D` (`army_id`),
  ADD KEY `IDX_1B3EDEE295B82273` (`weapon_id`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DCBB0C5318D2742D` (`army_id`);

--
-- Indexes for table `unit_weapon`
--
ALTER TABLE `unit_weapon`
  ADD PRIMARY KEY (`unit_id`,`weapon_id`),
  ADD KEY `IDX_FE6A4C10F8BD700D` (`unit_id`),
  ADD KEY `IDX_FE6A4C1095B82273` (`weapon_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D6494BAB96C` (`rol_id`);

--
-- Indexes for table `weapon`
--
ALTER TABLE `weapon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `army`
--
ALTER TABLE `army`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `weapon`
--
ALTER TABLE `weapon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `army_weapon`
--
ALTER TABLE `army_weapon`
  ADD CONSTRAINT `FK_1B3EDEE218D2742D` FOREIGN KEY (`army_id`) REFERENCES `army` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1B3EDEE295B82273` FOREIGN KEY (`weapon_id`) REFERENCES `weapon` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `FK_DCBB0C5318D2742D` FOREIGN KEY (`army_id`) REFERENCES `army` (`id`);

--
-- Constraints for table `unit_weapon`
--
ALTER TABLE `unit_weapon`
  ADD CONSTRAINT `FK_FE6A4C1095B82273` FOREIGN KEY (`weapon_id`) REFERENCES `weapon` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_FE6A4C10F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6494BAB96C` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
