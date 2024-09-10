-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2024 at 02:36 PM
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
-- Database: `bookhaven`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_genre` varchar(255) NOT NULL,
  `book_isbn` varchar(13) NOT NULL,
  `book_year` int(11) NOT NULL,
  `book_author` varchar(255) NOT NULL,
  `book_price` float NOT NULL DEFAULT 0,
  `book_quantity` int(11) NOT NULL DEFAULT 0,
  `book_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `book_title`, `book_genre`, `book_isbn`, `book_year`, `book_author`, `book_price`, `book_quantity`, `book_img`) VALUES
(1, 'Atomic Habits', 'Self Help, Psychology', '847571894', 2016, 'James Clear', 89.76, 1, 'bookImg/ah.jpg'),
(2, 'Homo Sapiens', 'World History', '141754384', 2009, 'William Potter', 118.67, 4, 'bookImg/hs.jpg'),
(3, 'Letters To A Young Poet', 'Poetry', '714183421', 1976, 'Rainer Maria Rilke', 79.54, 4, 'bookImg/ltayp.jpg'),
(4, 'A Doctor In The House: Memoirs of Tun Dr Mahathir Mohamad', 'Biography', '415574814', 1986, 'Mahathir Mohamad', 105.45, 4, 'bookImg/m.jpg'),
(5, 'Psychology Of Money', 'Psychology, Finance', '541537482', 2018, 'Morgan Housel', 96.75, 4, 'bookImg/POM.jpg'),
(6, 'Sejarah Melayu: The Malay Annals', 'Malay History', '89754451', 2001, 'Tun Sri Lanang', 125.4, 4, 'bookImg/sm.jpg'),
(7, 'The Data Detective', 'Economics', '515481045', 2015, 'Tim Harford', 78.99, 4, 'bookImg/tdd.jpg'),
(8, 'The Undercover Economist', 'Economics', '515107718', 2017, 'Tim Harford', 87.65, 5, 'bookImg/tem.jpg'),
(9, 'World At War', 'World History', '6705184', 1967, 'Niall Ferguson', 154.8, 5, 'bookImg/war.jpg'),
(10, 'Why We Sleep', 'Neuroscience', '123904387', 2020, 'Matthew Walker', 93.6, 5, 'bookImg/wws.jpg'),
(11, 'IYCS', 'Parenting', '2145151564', 2024, 'Some Author', 900, 14, '../BookHaven/bookImgdemo book.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `amount_paid` float NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `payment_mode`, `amount_paid`, `user_id`, `order_date`) VALUES
(7, 'credit_card', 313.88, 2, '2024-06-13 07:28:17'),
(8, 'credit_card', 996.75, 2, '2024-06-13 07:41:43'),
(9, 'credit_card', 204.39, 2, '2024-06-13 07:42:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `book_id`, `quantity`, `subtotal`) VALUES
(7, 7, 2, 1, 118.67),
(8, 7, 1, 1, 89.76),
(9, 7, 4, 1, 105.45),
(10, 8, 11, 1, 900),
(11, 8, 5, 1, 96.75),
(12, 9, 6, 1, 125.4),
(13, 9, 7, 1, 78.99);

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `subtotal` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoppingcart`
--

INSERT INTO `shoppingcart` (`cart_id`, `user_id`, `book_id`, `order_quantity`, `subtotal`) VALUES
(18, 2, 3, 1, 79.54);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_phoneNo` varchar(100) NOT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `user_al` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_email`, `user_password`, `user_address`, `user_phoneNo`, `user_fullname`, `user_al`) VALUES
(1, 'AriffN', 'ariffnorhisham25@gmail.com', 'ariff25', 'No 28 Jalan Hilir 2 Taman Ampang Hilir', '0126254519', 'Muhammad Ariff bin Norhisham', 'Admin'),
(2, 'Hanafi Hanafi', 'hanafiemail@gmail.com', 'hanafi25', 'Tapah Road', '5145435441', 'Izdihar Hanafi', 'Customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_1` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_3` (`book_id`),
  ADD KEY `fk_4` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`);

--
-- Constraints for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD CONSTRAINT `fk_3` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`),
  ADD CONSTRAINT `fk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
