-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2022 at 11:18 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vue_final_project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userid` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `role` int(2) NOT NULL,
  `counterlock` int(2) NOT NULL,
  `status` int(2) NOT NULL,
  `date_inserted` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userid`, `firstname`, `lastname`, `email`, `username`, `password`, `role`, `counterlock`, `status`, `date_inserted`) VALUES
(1, 'Sir', 'Almario', 'admin@user.com', 'admin01', '$2y$10$6.e1aLfxXYvxCIaECmDWCezewlMNhe4uSrx2xsK1PqzeLIl0bAGzu', 0, 3, 1, '2022-12-09'),
(2, 'Jack', 'Stone', 'jack@stone.com', 'jackstone', '$2y$10$fuQKcXdqVLEsGJwYN3M5ouLG7FxZLygyAdrtfob.SOUbgh6.s9zYy', 1, 3, 3, '2022-12-09'),
(3, 'Lino', 'Gao', 'lino@gao.com', 'linogao', '$2y$10$fuQKcXdqVLEsGJwYN3M5ouLG7FxZLygyAdrtfob.SOUbgh6.s9zYy', 1, 3, 1, '2022-12-10'),
(4, 'Dum', 'Gai', 'dum@gai.com', 'dumbguy', '$2y$10$fuQKcXdqVLEsGJwYN3M5ouLG7FxZLygyAdrtfob.SOUbgh6.s9zYy', 1, 0, 3, '2022-12-10'),
(5, 'John', 'Doe', 'jd@email.com', 'johndoe', '$2y$10$s/tXbacqsSjcbT7oVWiqQu6aCyD1IwBxqYvkN.3l5YI0CkB/OuV9e', 1, 0, 2, '2022-12-10'),
(6, 'Jean Claude', 'Andam', 'jclaude@andam.com', 'jclaudeandam', '$2y$10$FLbaoxNMF2q0xUE7DaJnZ.jmA6Nf4micxYUHOc3vS8qSar0scCiVK', 1, 3, 1, '2022-12-10'),
(7, 'Bulbulito', 'Bayagbag', 'bbayagbag@user.com', 'bbayagbag', '$2y$10$2emy.u56rkJyE5TfKey.COBE4xYOGSu/oNtTczcMpaLH9H/WwfwU.', 1, 3, 1, '2022-12-10'),
(8, 'John', 'Cena', 'jcena@ucantsee.me', 'johncena', '$2y$10$s0W2O89xNswHzwIw0/DVVOan9Jemokns7p4/PKofqHSJPNWHa/hS6', 1, 3, 1, '2022-12-10'),
(9, 'Maria', 'Aguanta', 'maria@aguanta.com', 'maria01', '$2y$10$qz5LhzEH64OGqm70O5WLaOH9mcv4zRuaSXbUP4jFZYC4UOk5t6rKO', 1, 3, 3, '2022-12-10'),
(10, 'almario', 'miano', 'almario@user.com', 'whatever01', '$2y$10$3OmijkyyTT.PBKKz/i9Zqe3rWqlJ1jpaeIQDwVp0I0hs4yXaYjSs.', 1, 3, 1, '2022-12-13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
