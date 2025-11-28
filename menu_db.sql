-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 28 Kas 2025, 15:55:55
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `menu_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `order_no` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `name`, `order_no`) VALUES
(1, 'Kahvaltılık', 1),
(2, 'Ara Sıcaklar', 2),
(3, 'Spesyeller', 3),
(4, 'Ana Yemekler', 4),
(5, 'Alkollü İçecekler', 5),
(6, 'İçecekler', 6),
(7, 'Meyveler', 7),
(8, 'Mezeler', 8),
(9, 'Çerezler', 9),
(10, 'Söğüşler', 10),
(11, 'Tatlılar', 11);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `img`, `category_id`, `subcategory_id`) VALUES
(1, 'Serpme Kahvaltı', 400.00, 'Zengin peynir çeşitleri, zeytin, reçel, bal, kaymak, söğüş, sahanda yumurta ve daha fazlası.', 'serpmeKahvalti.jpeg', 1, 1),
(2, 'Kahvaltı Tabağı', 300.00, 'Seçme peynirler, zeytin, reçel, söğüş, haşlanmış yumurta ve sigara böreği.', 'kahvaltiTabagi.jpeg', 1, 1),
(3, 'Sade Omlet', 100.00, '', 'omlet.jpeg', 1, 1),
(4, 'Sucuklu Omlet', 150.00, '', 'sucukluOmlet.jpeg', 1, 1),
(5, 'Kavurmalı Omlet', 200.00, '', 'kavurmali-omlet.jpg', 1, 1),
(6, 'Sebzeli Omlet', 150.00, '', 'sebzeli-omlet.jpg', 1, 1),
(7, 'Menemen', 150.00, 'Taze domates, biber ve yumurtanın harika buluşması.', 'menemen.jpg', 1, 1),
(8, 'Sigara Böreği', 170.00, '', 'sigara-boregi.jpg', 1, 1),
(9, 'Paçanga Böreği', 250.00, '', 'pacanga-boregi.jpg', 1, 1),
(10, 'Kalamar', 450.00, '', 'kalamar.jpg', 2, 2),
(11, 'Sebzeli Karides', 450.00, '', 'sebzeli-karides.jpg', 2, 2),
(12, 'Tere Yağlı Karides', 450.00, '', 'tere-yagli-karides.jpg', 2, 2),
(13, 'Yaprak Ciğer', 250.00, '', 'yaprak-ciger.jpg', 2, 2),
(14, 'Gulik Yumurtalı', 220.00, '', 'gulik-yumurtali.jpg', 2, 2),
(15, 'Gulik Yoğurtlu', 220.00, '', 'gulik-yogurtlu.jpg', 2, 2),
(16, 'Dağ Mantarı', 1000.00, '', 'dag-mantari.jpg', 2, 2),
(17, 'Patates Cips Duble', 240.00, '', 'patates-cips-duble.jpg', 2, 2),
(18, 'Patates Cips Tek', 150.00, '', 'patates-cips-tek.jpg', 2, 2),
(19, 'Mantar Soslu Bonfile', 600.00, 'Yumuşacık bonfile dilimleri, kremalı mantar sos ve taze baharatlar.', 'mantar-soslu-bonfile.jpg', 3, 3),
(20, 'Lokum', 600.00, 'Ağızda dağılan, özel marine edilmiş bonfile parçaları.', 'lokum.jpg', 3, 3),
(21, 'Beğendi Yatağında İncik', 500.00, 'Ağır ateşte pişmiş kuzu incik, köz patlıcanlı beğendi yatağında.', 'begendi-yataginda-incik.jpg', 3, 3),
(22, 'Levrek', 550.00, 'Taze günlük levrek, ızgarada veya tavada.', 'levrek.jpg', 4, 6),
(23, 'Çupra', 550.00, 'Taze günlük çupra, ızgarada veya tavada.', 'cupra.jpg', 4, 6),
(24, 'Yerli Somun', 500.00, 'Izgara yerli somon balığı, yanında garnitür ile.', 'yerli-somun.jpg', 4, 6),
(25, 'Kaya Levreği', 500.00, 'Özel kaya levreği, ızgarada.', 'kaya-levregi.jpg', 4, 6),
(26, 'Soslu Kaya Levreği', 550.00, 'Özel sos ile hazırlanmış kaya levreği.', 'soslu-kaya-levregi.jpg', 4, 6),
(27, 'Norveç Somun', 550.00, 'İthal Norveç somonu, ızgara.', 'norvec-somun.jpg', 4, 6),
(28, 'Çiftlik Alabalığı', 350.00, 'Taze çiftlik alabalığı, tavada veya ızgarada.', 'ciftlik-alabaligi.jpg', 4, 6),
(29, 'Kara Kavurma', 500.00, 'Sac üzerinde kavrulmuş, baharatlı et parçaları.', 'kara-kavurma.jpg', 4, 5),
(30, 'Çoban Kavurma', 440.00, 'Kuşbaşı et, domates, biber ve soğan ile kavrulmuş.', 'coban-kavurma.jpg', 4, 5),
(31, 'Yoğurtlu Kavurma', 480.00, 'Kavurma, süzme yoğurt ve özel sos ile.', 'yogurtlu-kavurma.jpg', 4, 5),
(32, 'Et Sote', 450.00, 'Kuşbaşı et, domates, biber ve mantar sote.', 'et-sote.jpg', 4, 5),
(33, 'Piliç Sote', 350.00, 'Kuşbaşı tavuk, domates, biber ve mantar sote.', 'pilic-sote.jpg', 4, 5),
(34, 'Köri Soslu Tavuk', 300.00, 'Kremalı köri soslu tavuk parçaları, yanında pilav ile.', 'kori-soslu-tavuk.jpg', 4, 5),
(35, 'Soya Soslu Tavuk', 300.00, 'Soya soslu ve sebzeli tavuk parçaları.', 'soya-soslu-tavuk.jpg', 4, 5),
(36, 'Acı Tatlı Ekşi Tavuk', 300.00, 'Özel acı tatlı ekşi soslu panelenmiş tavuk.', 'aci-tatli-eksi-tavuk.jpg', 4, 5),
(37, 'Tavuklu Mantarlı Penne', 300.00, 'Kremalı sos, tavuk parçaları ve taze mantar ile.', 'tavuklu-mantarli-penne.jpg', 4, 7),
(38, 'Kremalı Peynirli Penne', 300.00, 'Zengin peynir çeşitleri ve krema soslu penne.', 'kremali-peynirli-penne.jpg', 4, 7),
(39, 'Köri Soslu Penne', 300.00, 'Köri sos, krema ve tavuk parçaları ile.', 'kori-soslu-penne.jpg', 4, 7),
(40, 'Kuşbaşı', 450.00, 'Izgara kuzu kuşbaşı, yanında pilav ve közlenmiş sebze.', 'kusbasi.jpg', 4, 4),
(41, 'Kuzu Pirzola', 550.00, 'Taze kuzu pirzola, ızgarada pişirilmiş.', 'kuzu-pirzola.jpg', 4, 4),
(42, 'Beyti Sarma', 480.00, 'Yoğurtlu ve domates soslu, lavaşa sarılı beyti kebap.', 'beyti-sarma.jpg', 4, 4),
(43, 'Çöp Şiş', 0.00, 'Marine edilmiş küçük et parçaları, çöp şişte ızgara.', 'cop-sis.jpg', 4, 4),
(44, 'Ali Nazik', 0.00, 'Köz patlıcanlı yoğurt yatağında kıymalı kebap.', 'ali-nazik.jpg', 4, 4),
(45, 'Adana Kebap', 0.00, 'Acılı zırh kıyması kebabı.', 'adana-kebap.jpg', 4, 4),
(46, 'Izgara Köfte', 0.00, 'Özel baharatlı ızgara köfte.', 'izgara-kofte.jpg', 4, 4),
(47, 'Kanat', 0.00, 'Özel soslu ızgara tavuk kanat.', 'kanat.jpg', 4, 4),
(48, 'Tavuk Şiş', 0.00, 'Marine edilmiş ızgara tavuk şiş.', 'tavuk-sis.jpg', 4, 4),
(49, 'Tavuk Pirzola', 0.00, 'Kemiksiz, ızgara tavuk pirzola.', 'tavuk-pirzola.jpg', 4, 4),
(50, 'Kaburga', 0.00, 'Izgara kuzu kaburga.', 'kaburga.jpg', 4, 4),
(51, 'Karışık Izgara (Beyaz Et)', 0.00, 'Tavuk şiş, kanat ve tavuk pirzoladan oluşan ızgara tabağı.', 'karisik-izgara-beyaz-et.jpg', 4, 4),
(52, 'Karışık Izgara (Kırmızı Et)', 0.00, 'Adana kebap, kuşbaşı, pirzola ve köfteden oluşan ızgara tabağı.', 'karisik-izgara-kirmizi-et.jpg', 4, 4),
(53, 'Karpuz Duble', 200.00, '', 'karpuz-duble.jpg', 7, 15),
(54, 'Karpuz Tek', 150.00, '', 'karpuz-tek.jpg', 7, 15),
(55, 'Kavun Duble', 200.00, '', 'kavun-duble.jpg', 7, 15),
(56, 'Kavun Tek', 0.00, '', 'kavun-tek.jpg', 7, 15),
(57, 'Karışık Duble', 0.00, '', 'karisik-duble.jpg', 7, 15),
(58, 'Karışık Tek', 0.00, '', 'karisik-tek.jpg', 7, 15),
(59, 'Serpme Meyve', 0.00, '', 'serpme-meyve.jpg', 7, 15),
(60, 'Yoğurtlu Semiz Otu', 150.00, '', 'yogurtlu-semiz-otu.jpg', 8, 16),
(61, 'Acılı Ezme', 150.00, '', 'acili-ezme.jpg', 8, 16),
(62, 'Brokoli', 150.00, '', 'brokoli.jpg', 8, 16),
(63, 'Patlıcan Ezme', 150.00, '', 'patlican-ezme.jpg', 8, 16),
(64, 'Z.Yağlı Taze Fasulye', 150.00, '', 'z-yagli-taze-fasulye.jpg', 8, 16),
(65, 'Rus Salatası', 150.00, '', 'rus-salatasi.jpg', 8, 16),
(66, 'Haydari', 150.00, '', 'haydari.jpg', 8, 16),
(67, 'Barbunya Pilaki', 190.00, '', 'barbunya-pilaki.jpg', 8, 16),
(68, 'Şakşuka', 150.00, '', 'saksuka.jpg', 8, 16),
(69, 'Süzme Yoğurt', 150.00, '', 'suzme-yogurt.jpg', 8, 16),
(70, 'Çoban Salata Duble', 150.00, '', 'coban-salata-duble.jpg', 8, 16),
(71, 'Çoban Salata Tek', 100.00, '', 'coban-salata-tek.jpg', 8, 16),
(72, 'Mevsim Salata Duble', 150.00, '', 'mevsim-salata-duble.jpg', 8, 16),
(73, 'Mevsim Salata Tek', 100.00, '', 'mevsim-salata-tek.jpg', 8, 16),
(74, 'Roka Salata Duble', 150.00, '', 'roka-salata-duble.jpg', 8, 16),
(75, 'Roka Salata Tek', 100.00, '', 'roka-salata-tek.jpg', 8, 16),
(76, 'Efes Klasik', 190.00, '', 'efes-klasik.jpg', 5, 8),
(77, 'Efes Malt', 190.00, '', 'efes-malt.jpg', 5, 8),
(78, 'Bomonti', 200.00, '', 'bomonti.jpg', 5, 8),
(79, 'Özel Sarı', 200.00, '', 'ozel-sari.jpg', 5, 8),
(80, 'Becks', 200.00, '', 'becks.jpg', 5, 8),
(81, 'Miller', 200.00, '', 'miller.jpg', 5, 8),
(82, 'Corona', 230.00, '', 'corona.jpg', 5, 8),
(83, 'Belfast', 200.00, '', 'belfast.jpg', 5, 8),
(84, 'Beylerbeyi Göbek 20 LİK', 0.00, '', 'beylerbeyi-gobek-20-lik.jpg', 5, 10),
(85, 'Beylerbeyi Göbek 35 LİK', 1600.00, '', 'beylerbeyi-gobek-35-lik.jpg', 5, 10),
(86, 'Beylerbeyi Göbek 50 LİK', 2100.00, '', 'beylerbeyi-gobek-50-lik.jpg', 5, 10),
(87, 'Beylerbeyi Göbek 70 LİK', 2900.00, '', 'beylerbeyi-gobek-70-lik.jpg', 5, 10),
(88, 'Beylerbeyi Göbek 100 LÜK', 3900.00, '', 'beylerbeyi-gobek-100-luk.jpg', 5, 10),
(89, 'Beylerbeyi Göbek Duble', 300.00, '', 'beylerbeyi-gobek-duble.jpg', 5, 10),
(90, 'Beylerbeyi Göbek Tek', 150.00, '', 'beylerbeyi-gobek-tek.jpg', 5, 10),
(91, 'Yeni Rakı 35 LİK', 1300.00, '', 'yeni-raki-35-lik.jpg', 5, 10),
(92, 'Yeni Rakı 50 LİK', 1750.00, '', 'yeni-raki-50-lik.jpg', 5, 10),
(93, 'Yeni Rakı 70 LİK', 2350.00, '', 'yeni-raki-70-lik.jpg', 5, 10),
(94, 'Yeni Rakı 100 LÜK', 3250.00, '', 'yeni-raki-100-luk.jpg', 5, 10),
(95, 'Yeni Rakı Duble', 260.00, '', 'yeni-raki-duble.jpg', 5, 10),
(96, 'Yeni Rakı Tek', 150.00, '', 'yeni-raki-tek.jpg', 5, 10),
(97, 'Tekirdağ Altın Seri 35 LİK', 1400.00, '', 'tekirdag-altin-seri-35-lik.jpg', 5, 10),
(98, 'Tekirdağ Altın Seri 50 LİK', 1900.00, '', 'tekirdag-altin-seri-50-lik.jpg', 5, 10),
(99, 'Tekirdağ Altın Seri 70 LİK', 2600.00, '', 'tekirdag-altin-seri-70-lik.jpg', 5, 10),
(100, 'Tekirdağ Altın Seri Duble', 270.00, '', 'tekirdag-altin-seri-duble.jpg', 5, 10),
(101, 'Tekirdağ Altın Seri Tek', 140.00, '', 'tekirdag-altin-seri-tek.jpg', 5, 10),
(102, 'Chivas 35 LİK', 2100.00, '', 'chivas-35-lik.jpg', 5, 11),
(103, 'Chivas 50 LİK', 3000.00, '', 'chivas-50-lik.jpg', 5, 11),
(104, 'Chivas 70 LİK', 4000.00, '', 'chivas-70-lik.jpg', 5, 11),
(105, 'Chivas 100 LÜK', 5200.00, '', 'chivas-100-luk.jpg', 5, 11),
(106, 'Chivas Duble', 450.00, '', 'chivas-duble.jpg', 5, 11),
(107, 'Chivas Tek', 230.00, '', 'chivas-tek.jpg', 5, 11),
(108, 'Jack Daniels 35 LİK', 2100.00, '', 'jack-daniels-35-lik.jpg', 5, 11),
(109, 'Jack Daniels 50 LİK', 2900.00, '', 'jack-daniels-50-lik.jpg', 5, 11),
(110, 'Jack Daniels 70 LİK', 3900.00, '', 'jack-daniels-70-lik.jpg', 5, 11),
(111, 'Jack Daniels 100 LÜK', 5600.00, '', 'jack-daniels-100-luk.jpg', 5, 11),
(112, 'Jack Daniels Duble', 450.00, '', 'jack-daniels-duble.jpg', 5, 11),
(113, 'Jack Daniels Tek', 230.00, '', 'jack-daniels-tek.jpg', 5, 11),
(114, 'Votka Duble', 240.00, '', 'votka-duble.jpg', 5, 12),
(115, 'Absolut Vodka 35 LİK', 1300.00, '', 'absolut-vodka-35-lik.jpg', 5, 12),
(116, 'Absolut Vodka 50 LİK', 1700.00, '', 'absolut-vodka-50-lik.jpg', 5, 12),
(117, 'Absolut Vodka 70 LİK', 2350.00, '', 'absolut-vodka-70-lik.jpg', 5, 12),
(118, 'İstanblue 35 LİK', 1100.00, '', 'istanblue-35-lik.jpg', 5, 12),
(119, 'İstanblue 50 LİK', 1600.00, '', 'istanblue-50-lik.jpg', 5, 12),
(120, 'İstanblue 70 LİK', 2100.00, '', 'istanblue-70-lik.jpg', 5, 12),
(121, 'Tekila Şhot', 150.00, '', 'tekila-shot.jpg', 5, 12),
(122, 'Tekila 35 LİK', 1200.00, '', 'tekila-35-lik.jpg', 5, 12),
(123, 'Tekila 50 LİK', 1700.00, '', 'tekila-50-lik.jpg', 5, 12),
(124, 'Kadeh Şarap', 300.00, '', 'kadeh-sarap.jpg', 5, 9),
(125, '70 LİK Şarap', 2000.00, '', '70-lik-sarap.jpg', 5, 9),
(126, 'Sufle', 150.00, '', 'sufle.jpg', 11, 19),
(127, 'Sıcak Çikolata', 150.00, '', 'sicak-cikolata.jpg', 11, 19),
(128, 'Fıstık Rüyası', 150.00, '', 'fistik-ruyasi.jpg', 11, 19),
(129, 'Limonlu Çizkek', 150.00, '', 'limonlu-cizkek.jpg', 11, 19),
(130, 'Çikolatalı Çizkek', 150.00, '', 'cikolatali-cizkek.jpg', 11, 19),
(131, 'Frambuazlı Çizkek', 160.00, '', 'frambuazli-cizkek.jpg', 11, 19),
(132, 'Domates Söğüş', 150.00, '', 'domates-sogus.jpg', 10, 18),
(133, 'Domates Peynir Söğüş', 150.00, '', 'domates-peynir-sogus.jpg', 10, 18),
(134, 'Kavun Peynir', 150.00, '', 'kavun-peynir.jpg', 10, 18),
(135, 'Kavun Karpuz Peynir Söğüş', 150.00, '', 'kavun-karpuz-peynir-sogus.jpg', 10, 18),
(136, 'Roka Söğüş', 150.00, '', 'roka-sogus.jpg', 10, 18),
(137, 'M. Suları', 100.00, '', 'm-sulari.jpg', 6, 14),
(138, 'Kola', 100.00, '', 'kola.jpg', 6, 14),
(139, 'Fanta', 100.00, '', 'fanta.jpg', 6, 14),
(140, 'Şalgam', 100.00, '', 'salgam.jpg', 6, 14),
(141, 'Ice Tea', 100.00, '', 'ice-tea.jpg', 6, 14),
(142, 'Sade Soda', 50.00, '', 'sade-soda.jpg', 6, 14),
(143, 'Meyveli Soda', 60.00, '', 'meyveli-soda.jpg', 6, 14),
(144, 'Redbull', 150.00, '', 'redbull.jpg', 6, 14),
(145, 'Ayran', 40.00, '', 'ayran.jpg', 6, 14),
(146, 'Su', 20.00, '', 'su.jpg', 6, 14),
(147, 'Nescafe', 100.00, '', 'nescafee.jpg', 6, 13),
(148, 'T. Kahvesi', 100.00, '', 't-kahvesi.jpg', 6, 13),
(149, 'Bitki Çayları', 100.00, '', 'bitki-caylari.jpg', 6, 13),
(150, 'Çay', 30.00, '', 'cay.jpg', 6, 13),
(151, 'Lüx Karışık Çerez', 200.00, '', 'lux-karisik-cerez.jpg', 9, 17),
(152, 'Karışık', 200.00, '', 'karisik.jpg', 9, 17),
(153, 'Antep Fıstığı', 350.00, '', 'antep-fistigi.jpg', 9, 17),
(154, 'Fındık', 250.00, '', 'findik.jpg', 9, 17),
(155, 'Kabak Çekirdeği', 200.00, '', 'kabak-cekirdegi.jpg', 9, 17),
(156, 'Leblebi', 150.00, '', 'leblebi.jpg', 9, 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`) VALUES
(1, 1, 'Kahvaltılık'),
(2, 2, 'Ara Sıcaklar'),
(3, 3, 'Spesyeller'),
(4, 4, 'Izgaralar'),
(5, 4, 'Tavalar'),
(6, 4, 'Balık'),
(7, 4, 'Makarna'),
(8, 5, 'Biralar'),
(9, 5, 'Şaraplar'),
(10, 5, 'Rakılar'),
(11, 5, 'Viskiler'),
(12, 5, 'Votkalar'),
(13, 6, 'Sıcak İçecekler'),
(14, 6, 'Soğuk İçecekler'),
(15, 7, 'Meyveler'),
(16, 8, 'Mezeler'),
(17, 9, 'Çerezler'),
(18, 10, 'Söğüşler'),
(19, 11, 'Tatlılar');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'MunzurBaba', 'MBaba62');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Tablo için indeksler `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- Tablo için AUTO_INCREMENT değeri `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
