-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 22 Eyl 2025, 19:58:22
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
-- Veritabanı: `dishane_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `secretary_id` int(11) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('beklemede','tamamlandı','iptal') NOT NULL DEFAULT 'beklemede',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `secretary_id`, `appointment_date`, `appointment_time`, `status`, `notes`, `created_at`) VALUES
(1, 4, 2, 3, '2025-05-17', '13:00:00', 'beklemede', 'Diş kliniğimizin ilk hastası hayırlı uğurlu olsun. :)', '2025-05-16 21:37:11'),
(2, 6, 2, 6, '2025-05-19', '12:00:00', 'iptal', NULL, '2025-05-21 19:37:54'),
(4, 9, 2, 9, '2025-06-02', '14:00:00', 'beklemede', NULL, '2025-05-21 20:21:21'),
(5, 6, 2, 6, '2025-06-09', '14:00:00', 'iptal', NULL, '2025-05-22 01:53:35'),
(6, 6, 2, 6, '2025-05-26', '10:00:00', 'iptal', NULL, '2025-05-22 01:54:16'),
(7, 6, 2, 6, '2025-05-05', '13:00:00', 'iptal', NULL, '2025-05-22 04:23:53'),
(8, 6, 2, 6, '2025-04-28', '13:00:00', 'beklemede', NULL, '2025-05-22 15:52:14'),
(9, 6, 2, 6, '2025-05-26', '13:00:00', 'iptal', NULL, '2025-05-22 17:17:30'),
(10, 6, 2, 6, '2025-06-02', '12:00:00', 'iptal', NULL, '2025-05-22 18:38:45'),
(11, 9, 10, 3, '2025-05-26', '15:00:00', 'beklemede', 'Muayene', '2025-05-22 20:48:28'),
(12, 6, 2, 6, '2025-06-02', '11:00:00', 'iptal', NULL, '2025-05-23 02:01:00'),
(13, 6, 2, 6, '2025-05-19', '09:00:00', 'iptal', NULL, '2025-05-23 02:38:52'),
(14, 5, 2, 3, '2025-05-24', '15:00:00', 'beklemede', '20lik diş kontrolü', '2025-05-24 03:44:14'),
(15, 6, 10, 6, '2025-05-27', '11:00:00', 'iptal', NULL, '2025-05-25 03:38:00'),
(16, 6, 2, 6, '2025-06-02', '11:00:00', 'iptal', NULL, '2025-05-25 04:42:30'),
(17, 9, 10, 9, '2025-06-03', '10:00:00', 'beklemede', NULL, '2025-05-26 03:44:08'),
(18, 6, 2, 6, '2025-06-02', '10:00:00', 'iptal', NULL, '2025-05-26 09:12:57'),
(19, 6, 2, 6, '2025-05-26', '10:00:00', 'iptal', NULL, '2025-05-26 10:26:03'),
(20, 6, 2, 6, '2025-06-02', '13:00:00', 'iptal', NULL, '2025-05-26 13:43:37'),
(21, 6, 2, 6, '2025-06-02', '12:00:00', 'beklemede', NULL, '2025-05-31 21:30:42'),
(22, 9, 20, 9, '2025-06-05', '13:00:00', 'iptal', NULL, '2025-05-31 21:54:11'),
(23, 22, 2, 22, '2025-06-09', '09:00:00', 'beklemede', NULL, '2025-06-06 22:40:54'),
(24, 6, 2, 6, '2025-06-09', '14:00:00', 'iptal', NULL, '2025-06-06 22:52:10'),
(25, 22, 2, 3, '2025-06-10', '17:00:00', 'beklemede', '', '2025-06-06 22:53:47'),
(26, 22, 2, 22, '2025-06-23', '16:00:00', 'beklemede', NULL, '2025-06-06 23:00:41');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `diagnoses`
--

CREATE TABLE `diagnoses` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `diagnosis` text NOT NULL,
  `diagnosis_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `diagnoses`
--

INSERT INTO `diagnoses` (`id`, `test_id`, `doctor_id`, `diagnosis`, `diagnosis_date`, `created_at`) VALUES
(3, 2, 2, 'b12 eksikliği için takviye verildi', '2025-05-25', '2025-05-25 05:28:54'),
(5, 2, 2, '20lik diş takibe alındı', '2025-05-25', '2025-05-25 06:01:51'),
(6, 1, 2, 'deneme tanısı', '2025-05-26', '2025-05-26 09:18:50'),
(7, 1, 2, 'tetkikler yapıldı sonuçlar temiz çıktı ', '2025-05-26', '2025-05-26 10:38:05');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doctor_hours`
--

CREATE TABLE `doctor_hours` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `weekday` enum('Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi','Pazar') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `doctor_hours`
--

INSERT INTO `doctor_hours` (`id`, `doctor_id`, `weekday`, `start_time`, `end_time`, `is_active`) VALUES
(1, 2, 'Pazartesi', '09:00:00', '17:00:00', 1),
(2, 10, 'Salı', '10:00:00', '15:00:00', 1),
(4, 10, 'Çarşamba', '09:00:00', '17:00:00', 1),
(5, 20, 'Perşembe', '10:00:00', '17:00:00', 1),
(6, 10, 'Cuma', '10:00:00', '17:00:00', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `inventory_items`
--

INSERT INTO `inventory_items` (`id`, `name`, `quantity`, `created_at`) VALUES
(1, 'Şırınga', 1, '2025-05-23 15:43:22'),
(2, 'Dolgu malzemesi', -3, '2025-05-23 16:41:23'),
(3, 'Diş Aynası', -2, '2025-05-24 01:46:36');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `inventory_logs`
--

CREATE TABLE `inventory_logs` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `change_quantity` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `related_appointment_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `inventory_logs`
--

INSERT INTO `inventory_logs` (`id`, `item_id`, `change_quantity`, `reason`, `related_appointment_id`, `user_id`, `created_at`) VALUES
(1, 1, -1, 'Kullanıldı', NULL, NULL, '2025-05-23 15:43:41'),
(2, 1, -3, 'Kullanıldı', NULL, NULL, '2025-05-23 16:26:51'),
(3, 2, -5, 'İade edildi', NULL, NULL, '2025-05-23 16:45:17'),
(4, 1, 1, 'İade edildi', NULL, NULL, '2025-05-23 16:46:13'),
(5, 1, 4, 'İade edildi', NULL, NULL, '2025-05-23 16:46:31'),
(6, 1, -3, 'Kullanıldı', NULL, NULL, '2025-05-23 16:46:44'),
(7, 1, -2, 'Dişi uyuşturmada kullanıldı', 14, 2, '2025-05-24 00:51:09'),
(8, 1, -2, 'Dişi uyuşturmada kullanıldı', 14, 2, '2025-05-24 00:57:48'),
(9, 1, -2, 'Dişi uyuşturmada kullanıldı', 14, 2, '2025-05-24 00:58:23'),
(10, 1, -2, 'Dişi uyuşturmada kullanıldı', 14, 2, '2025-05-24 01:08:43'),
(11, 2, -4, 'Kullanıldı', 14, 2, '2025-05-24 01:14:00'),
(12, 2, -1, 'Kullanıldı', 14, 2, '2025-05-24 01:19:10'),
(13, 2, -1, 'Kullanıldı', 14, 2, '2025-05-24 01:21:35'),
(14, 1, 15, 'Yeni alım', NULL, 3, '2025-05-24 01:44:21'),
(15, 2, 1, 'Yeni alım', NULL, 3, '2025-05-24 01:44:37'),
(16, 3, -2, 'Muayene sırasında kullanıldı', 13, 2, '2025-05-24 01:47:30'),
(17, 3, -1, 'Muayene sırasında kullanıldı', NULL, 2, '2025-05-24 22:13:08'),
(18, 1, -3, 'Anestezi verirken kullanıldı', NULL, 2, '2025-05-24 22:37:02'),
(19, 3, -1, 'Muayene sırasında kullanıldı', NULL, 2, '2025-05-24 22:38:06'),
(20, 1, -1, 'Anestezi verirken kullanıldı', NULL, 2, '2025-05-24 22:54:29'),
(21, 1, -1, 'Anestezi verirken kullanıldı', NULL, 2, '2025-05-24 23:01:13'),
(22, 3, -2, 'Kullanıldı', NULL, 2, '2025-05-24 23:17:09'),
(23, 1, -3, 'Dişi uyuşturmada kullanıldı', NULL, 2, '2025-05-24 23:34:57'),
(24, 3, -1, 'Kullanıldı', NULL, 2, '2025-05-24 23:47:13'),
(25, 2, -1, 'Kullanıldı', NULL, 2, '2025-05-24 23:54:10'),
(26, 1, -2, 'Kullanıldı', 1, 2, '2025-05-25 00:03:10'),
(27, 3, -2, 'Kullanıldı', 7, 2, '2025-05-25 00:06:07'),
(28, 2, -1, 'Kullanıldı', 9, 2, '2025-05-25 01:31:42'),
(29, 1, 1, 'Yeni alım', NULL, 3, '2025-05-26 08:23:33'),
(30, 2, 1, 'Yeni alım', NULL, 3, '2025-05-26 08:28:56'),
(31, 2, -2, 'Kullanıldı', 7, 2, '2025-05-26 08:56:59'),
(32, 3, -1, 'Kullanıldı', 1, 2, '2025-05-26 10:37:00'),
(33, 3, -1, 'Kullanıldı', 8, 2, '2025-05-31 18:55:11'),
(34, 3, -1, 'kullank', 23, 2, '2025-06-06 19:43:32');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `medical_records`
--

CREATE TABLE `medical_records` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `test_type` varchar(100) DEFAULT NULL,
  `result` text DEFAULT NULL,
  `record_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `medical_records`
--

INSERT INTO `medical_records` (`id`, `patient_id`, `doctor_id`, `test_type`, `result`, `record_date`, `created_at`) VALUES
(1, 1, 2, 'Kan Testi', 'Normal', '2024-05-27', '2025-05-25 06:10:34'),
(2, 6, 2, 'Kan tahlili', 'Tam kan sayımı yapıldı, b12 vitamini çok düşük.', '2025-05-25', '2025-05-25 07:22:55');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `tc_no` char(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','sekreter','doktor','hasta') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `full_name`, `tc_no`, `email`, `phone`, `password`, `role`, `created_at`) VALUES
(1, 'Dişhane Admin', '11111111111', 'admin@dishane.com', '05555555555', '$2y$10$EHJkYksRm9g4tqcnMSPDmOCkVRKsryVncOh.Bcser8/swZBPAZybm', 'admin', '2025-05-16 16:12:17'),
(2, 'Sena Nur Özdemir', '12345678901', 'senanur@hotmail.com', '05555555556', '$2y$10$7MrK1DfftVZ9aL0MwTGZkOf6yM.VE6uiqAz6DPgr8FM1HARuu0oaC', 'doktor', '2025-05-16 18:12:59'),
(3, 'Hayrunnisa Bilici', '22222222222', 'hayrunnisa@gmail.com', '05555555558', '$2y$10$8uY9c0VtWs2f6whTkAyvq.nECiRPsXrbMN1GCRo5EnXuCNpLgxo1i', 'sekreter', '2025-05-16 18:27:41'),
(4, 'Rüveyda', '12345678910', 'ruv@hotmail.com', '05555555560', '$2y$10$SgyTOvb8GfsEL4wBaDrzB.t19CuV60v6kol1ZlfgAWUPSTyOU3o3C', 'hasta', '2025-05-16 18:33:09'),
(6, 'Ayşe Selen Aydoğan', '44444444444', 'ayse@gmail.com', '05554444444', '$2y$10$64/zuLg5PbZN8GH9fxFmd.XVvVINESIg4V6b87GrbCZppkW5tL1/i', 'hasta', '2025-05-17 14:08:48'),
(9, 'Sena Yolaçan', '66666666666', 'senakemal@hotmail.com', '55555555560', '$2y$10$J3OYvee5so4py9xJYQ1e2.4BNRgJrR6/vHsWCHlQ43Y3s1fraTrDu', 'hasta', '2025-05-20 17:52:43'),
(10, 'İnci Kapçı', '77777777777', 'inci@gmail.com', '05555555562', '$2y$10$QM8LMyTjAcQOZIo2re9uauowMRygyPjaJV678ueZQ5aZperM6Ayb6', 'doktor', '2025-05-20 22:23:51'),
(12, 'Test Hasta Nisan', '13141516178', 'nisan@test.com', '5550000001', '$2y$10$0MBO63LoBqIb1.pdECNGDOyQrw4w4SIO8/0wEgyADvEVw2K3r30Gq', 'hasta', '2025-04-10 07:00:00'),
(13, 'Test Hasta Mart', '12131415161', 'mart@test.com', '5550000002', '$2y$10$e38b92Jw8/CPIFX4i9FFk.LtcV8uXX/CoVWUgsYBc3HhykH3QZayK', 'hasta', '2025-03-05 09:00:00'),
(14, 'Test Hasta Şubat', '11121314151', 'subat@test.com', '5550000003', '$2y$10$nTnK5B8p/SZ9JJ21b3Zy6u4jOZDPu.9/CjI5JOLVjhzjM1hMoeDJG', 'hasta', '2025-02-14 13:00:00'),
(15, 'Test Hasta Martt', '12345678912', 'mart@test.com', '5550000004', '$2y$10$nTnK5B8p/SZ9JJ21b3Zy6u4jOZDPu.9/CjI5JOLVjhzjM1hMOEDJG', 'hasta', '2025-03-07 11:00:00'),
(20, 'Şevval Özyurt', '88888888888', 'sevval@gmail.com', '05555555588', '$2y$10$Z76x0xQjgL.DzQTI1XLnw.Yw1gdI/FcSpKk7Q/6CrRJagjLfIqdeq', 'doktor', '2025-05-26 03:30:07'),
(21, 'Tuanna Akarsu', '99999999999', 'tuanna@gmail.com', '05555555599', '$2y$10$7zQEDI7jeLfn46FcEck73.IG03LhpePnAoihxrNFIs0bkpxQSFXCq', 'hasta', '2025-05-26 05:35:08'),
(22, 'mustafa özdemir', '72727272727', 'mmo@hotmail.com', '05447727572', '$2y$10$suiRyId4IVAA9U0Wys/ZXuIhI0JDFvnDHtyFe0is75Hjdd.dAar9e', 'hasta', '2025-06-06 19:39:27');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Tablo için indeksler `doctor_hours`
--
ALTER TABLE `doctor_hours`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Tablo için indeksler `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tc_no` (`tc_no`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Tablo için AUTO_INCREMENT değeri `diagnoses`
--
ALTER TABLE `diagnoses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `doctor_hours`
--
ALTER TABLE `doctor_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `inventory_logs`
--
ALTER TABLE `inventory_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Tablo için AUTO_INCREMENT değeri `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD CONSTRAINT `diagnoses_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `medical_records` (`id`),
  ADD CONSTRAINT `diagnoses_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);

--
-- Tablo kısıtlamaları `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD CONSTRAINT `inventory_logs_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`);

--
-- Tablo kısıtlamaları `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `medical_records_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
