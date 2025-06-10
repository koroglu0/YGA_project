-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 03 Haz 2025, 18:36:25
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `shopping_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `price`, `created_at`, `image`, `stock`, `category_id`) VALUES
(17, 'Kuş Oyun Alanı', 'Kuşlar İçin', 987.00, '2025-06-03 15:39:51', 'uploads/img_683f1747482af.png', 15, NULL),
(18, 'Hamster Tasması', 'Tut ki kaçmasın', 50.00, '2025-06-03 15:40:31', 'uploads/img_683f176f2eb3c.png', 40, NULL),
(19, 'Hamster Tekerleği', 'dönsün dursun', 95.00, '2025-06-03 15:41:02', 'uploads/img_683f178eaa4b5.png', 100, NULL),
(20, 'Kuş Oyun Parkı', 'Kuşlar İçin Cennet', 1470.00, '2025-06-03 15:42:03', 'uploads/img_683f17cb47d69.png', 5, NULL),
(21, 'Balık Akvaryumu', '50X40 BALIK AKVARYUMU', 854.00, '2025-06-03 15:42:50', 'uploads/img_683f17fa1d66d.png', 86, NULL),
(22, 'Balık Su Motoru', 'Akvaryum için su motoru filtre', 666.00, '2025-06-03 15:43:40', 'uploads/img_683f182c99407.png', 66, NULL),
(23, 'Balık Süsü', 'Balıklar için mütiş yeminle', 14.00, '2025-06-03 15:44:25', 'uploads/img_683f18592d90f.png', 73, NULL),
(24, 'Kaplumbağa Evi', 'Evleri sırtında ama bu da güzel ev', 895.00, '2025-06-03 15:45:10', 'uploads/img_683f1886dbd53.png', 24, NULL),
(25, 'Köpek Taşıma Çantası', 'Patili dostlar için rahat ve güvenli', 1721.00, '2025-06-03 15:46:09', 'uploads/img_683f18c164817.png', 50, NULL),
(26, 'Kedi Taşıma Çantası', 'Kediler İçin harika', 230.00, '2025-06-03 15:46:53', 'uploads/img_683f18ed153eb.png', 20, NULL),
(27, 'Kedi Tüy toplama aleti', 'tüy kalmasın hiç', 90.00, '2025-06-03 15:47:44', 'uploads/img_683f1920ed4e7.png', 200, NULL),
(28, 'Kedi Yatağı', 'Yumuşacık', 954.00, '2025-06-03 15:48:10', 'uploads/img_683f193a0f92a.png', 107, NULL),
(29, 'Köpek Traş Seti', 'Kedi berberi olmak için tam set', 1562.00, '2025-06-03 15:48:54', 'uploads/img_683f19666f439.png', 20, NULL),
(30, 'Köpek Mama Kabı', 'Afiyet Olsun', 800.00, '2025-06-03 15:49:42', 'uploads/img_683f199691dd7.png', 70, NULL),
(31, 'Köpek Bakım Seti', 'Param Olsa Da BEN alsam', 6500.00, '2025-06-03 15:50:45', 'img_683f219172d893.28496554.jpg', 25, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'ahmet_cicek90', 'ahmetcicekofficial@gmail.com', '$2y$10$c70YIBMZhsL7h1F1YmXL5uPLcpb9grw9qcFNbjicDi6JqYK1YUMNu', '2025-06-03 10:37:29'),
(2, 'Samt91', 'test@gmail.com', '$2y$10$ztYSWl9lDfoE422ln4tfQ.VXU6z7Ah3VXayenylhK2F9JbEMNbB4m', '2025-06-03 13:03:07'),
(3, 'zeynep', 'zeynep@gmail.com', '$2y$10$o.A8bR8oH2xz/UWrCpw9UubY/sf6QXKbBF54VFC07qcbuyEVJH3E2', '2025-06-03 16:13:25'),
(4, 'ahmet', 'ahmet@gmail.com', '$2y$10$oXxlu4ytKAILLpQwJlYPOOPA.z3sq4IaUUHUiJrHcsYKO3Qmconku', '2025-06-03 16:20:56');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Tablo için indeksler `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_category` (`category_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
