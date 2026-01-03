-- Sanal Hukuk Asistani Database Setup (V10.0 - HYPER-RESILIENCE EDITION)
-- Comprehensive Turkish Constitution & Advanced Infrastructure

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- 1. Infrastructure Tables
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 2. Application Core Structure
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `right_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `detailed_guide` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `right_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `constitution_articles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `official_text` text NOT NULL,
  `simplified_explanation` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `constitution_articles_article_number_unique` (`article_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `supporting_laws` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `constitution_article_id` bigint(20) UNSIGNED NOT NULL,
  `law_name` varchar(255) NOT NULL,
  `law_number` varchar(255) DEFAULT NULL,
  `relevant_articles` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supporting_laws_constitution_article_id_foreign` (`constitution_article_id`),
  CONSTRAINT `supporting_laws_constitution_article_id_foreign` FOREIGN KEY (`constitution_article_id`) REFERENCES `constitution_articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `constitution_article_right_category` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `constitution_article_id` bigint(20) UNSIGNED NOT NULL,
  `right_category_id` bigint(20) UNSIGNED NOT NULL,
  `relevance_score` int(11) NOT NULL DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `const_art_right_cat_unique` (`constitution_article_id`, `right_category_id`),
  KEY `const_art_right_cat_right_cat_id_foreign` (`right_category_id`),
  CONSTRAINT `const_art_right_cat_art_id_foreign` FOREIGN KEY (`constitution_article_id`) REFERENCES `constitution_articles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `const_art_right_cat_right_cat_id_foreign` FOREIGN KEY (`right_category_id`) REFERENCES `right_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `event_records` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_description` text NOT NULL,
  `detected_keywords` text DEFAULT NULL,
  `detected_right_categories` text DEFAULT NULL,
  `matched_articles` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `analyzed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- 3. Data Population: Right Categories (V10 HYPER-EXPANDED)
-- --------------------------------------------------------

INSERT INTO `right_categories` (`id`, `name`, `slug`, `description`, `detailed_guide`, `keywords`, `order`) VALUES
(1, 'Devlet ve Egemenlik İlkeleri', 'devlet-ilkeleri', 'Devletin temel yapısı, laiklik, hukuk devleti ve egemenlik prensipleri.', 'Genel Bilgi: Anayasanın ilk üç maddesi değiştirilemez. Tüm hak arama süreçleriniz bu temel demokratik ve hukuk devleti ilkelerine dayanır.', '["cumhuriyet","egemenlik","yasama","yürütme","yargı","laik","hukuk devleti"]', 1),
(2, 'Kişilik Hakları ve Özel Hayat', 'ozel-hayat-gizliligi', 'İsim, ses, görüntü gizliliği, veri koruma ve mahremiyet hakları.', 'Rehber: İzinsiz ses kaydı veya gizli kamera kullanımı Türk Ceza Kanunu uyarınca suçtur. Sosyal medya linci veya sahte hesap durumlarında Bilişim Suçları Savcılığına başvurun.', '["isim","ses","kamera","takip","linç","sahte hesap","veri","fotoğraf","montaj","numara","gizlilik","mahremiyet"]', 2),
(3, 'Konut, Mülkiyet ve Yaşam', 'konut-mulkiyet', 'Evinize girilmesi, mülkünüze zarar verilmesi ve ev sahibi/kiracı uyuşmazlıkları.', 'Rehber: Ev sahibi habersiz eve giremez. Depozito iadesi veya gürültü sorunlarında Sulh Hukuk Mahkemesi yetkilidir. İzinsiz girişlerde derhal polise haber verin.', '["konut","ev","bahçe","cam","kırma","ev sahibi","depozito","gürültü","kesinti","elektrik","su","arsa","taşınmaz"]', 3),
(4, 'Tüketici Hakları ve Ticaret', 'tuketici-haklari', 'Ayıplı mallar, garanti sorunları, internet alışverişleri ve dolandırıcılık.', 'Rehber: Bozuk ürünlerde 6 ay içinde iade/değişim hakkınız vardır. Satıcı reddederse Tüketici Hakem Heyeti\'ne E-Devlet üzerinden ücretsiz başvurun.', '["bilgisayar","telefon","bozuk","değişim","iade","garanti","servis","internet alışveriş","kargo","sahte indirim","dolandırıcılık"]', 4),
(5, 'İş ve Çalışma Hakları', 'is-calisma', 'İşten çıkarma, maaş, SGK, mobbing ve tazminat uyuşmazlıkları.', 'Rehber: Tazminat ödenmemesi veya mobbing durumlarında önce Arabulucuya başvurmalısınız. SGK primlerinizin eksik yatırılması haklı fesih nedenidir.', '["iş","çalışma","maaş","sgk","prim","mobbing","tazminat","kovulma","iş kazası","ayrımcılık","patron"]', 5),
(6, 'Polis ve Kamu Denetimi', 'kolluk-kamu', 'Gözaltı, GBT, arama kararları ve kamu görevlilerinin uygulamaları.', 'Rehber: GBT sırasında kimlik sorma yetkisi vardır ancak kaba davranış veya arama kararı olmadan üst araması yapılamaz. Avukat isteme hakkınız kısıtlanamaz.', '["polis","jandarma","gbt","gözaltı","ifade","arama","kolluk","karakol","avukat","bekletilme","kamu"]', 6),
(7, 'Trafik, Sigorta ve Ulaşım', 'trafik-ulasim', 'Trafik cezaları, kaza kusur oranları ve sigorta ödemeleri.', 'Rehber: Yanlış yazılan trafik cezalarına 15 gün içinde Sulh Ceza Hakimliği\'nde itiraz edin. Araç değer kaybı için sigorta şirketine başvurun.', '["trafik","ceza","radar","plaka","kusur","çekici","sigorta","hasar","değer kaybı","kaza"]', 7),
(8, 'Sağlık ve Hastane Hakları', 'saglik-haklari', 'Malpraktis, yanlış teşhis, hasta hakları ve acil servis sorunları.', 'Rehber: Ameliyat hatalarında veya teşhis yanlışlarında İl Sağlık Müdürlüğü\'ne şikayette bulunun. Bilgilendirilmiş onam alınmadan işlem yapılamaz.', '["sağlık","doktor","hastane","ameliyat","teşhis","onam","rapor","acil","ücret"]', 8),
(9, 'Eğitim ve Öğrenci Hakları', 'egitim-haklari', 'Okul kayıtları, diplomalar, disiplin cezaları ve sınav iptalleri.', 'Rehber: Keyfi disiplin cezalarına karşı İdare Mahkemesi\'nde iptal davası açılabilir. Staj sömürüsüne karşı okul ve bakanlık denetimi isteyin.', '["okul","eğitim","kayıt","diploma","disiplin","sınav","staj","harç"]', 9),
(10, 'Dijital Haklar ve Teknoloji', 'dijital-teknoloji', 'Veri sızıntıları, online dolandırıcılık ve hesap kapatma uyuşmazlıkları.', 'Rehber: Online dolandırıcılıklarda bankanıza "harcama itirazı" yapın ve savcılığa siber suçlar için başvuru yapın.', '["dijital","teknoloji","verı sızıntısı","dolandırıcılık","kripto","hesap kapatma","abonelik","platform"]', 10),
(11, 'Mali Haklar ve Borç Yönetimi', 'mali-borc', 'Haciz işlemleri, banka masrafları, senet tehdidi ve kredi notu sorunları.', 'Rehber: Maaşa haciz gelirse ancak 1/4 oranında kesinti yapılabilir. Haksız hacizlerin kaldırılması için İcra Hukuk Mahkemesi\'ne başvurun.', '["haciz","maaş kesintisi","kefil","senet","banka","kredi","borç","icra"]', 11),
(12, 'Aile, Velayet ve Sosyal Hayat', 'aile-hukuku', 'Şiddet, nafaka, velayet ve çocuk teslimi uyuşmazlıkları.', 'Rehber: Aile içi şiddet varsa 6284 sayılı kanun uyarınca derhal uzaklaştırma kararı talep edin. Nafaka ödenmemesi icra suçudur.', '["aile","şiddet","nafaka","velayet","çocuk","boşanma","psikolojik baskı"]', 12),
(13, 'Yargı, İdare ve Adalet', 'yargi-idare', 'Mahkeme süreçleri, idari cezalar, belediye kararları ve imar sorunları.', 'Rehber: Uzayan yargılamalarda AYM\'ye bireysel başvuru hakkınız vardır. İdari para cezalarına karşı 15 gün içinde itiraz edin.', '["mahkeme","dava","yargılama","tebligat","imar","belediye","ruhsat","kamulaştırma","idari ceza"]', 13),
(14, 'Ayrımcılık ve İnsan Hakları', 'insan-haklari', 'Eşitlik ihlalleri, engelli hakları ve inanç özgürlüğü baskıları.', 'Rehber: Dil, din, ırk veya engellilik nedeniyle ayrımcılığa uğramak anayasal suçtur. TİHEK\'e başvuru yapabilirsiniz.', '["ayrımcılık","engelli","inanç","eşitlik","kıyafet","dil","insan hakları"]', 14);


-- --------------------------------------------------------
-- 4. Data Population: Constitution Articles
-- --------------------------------------------------------

INSERT INTO `constitution_articles` (`id`, `article_number`, `title`, `official_text`, `simplified_explanation`, `keywords`, `order`) VALUES
(1, 2, 'Cumhuriyetin Nitelikleri', 'Türkiye Cumhuriyeti... demokratik, laik ve sosyal bir hukuk Devletidir.', 'Hukuk devletinde her şey yasaya uygun olmalıdır.', '["hukuk devleti"]', 2),
(2, 10, 'Kanun Önünde Eşitlik', 'Herkes... kanun önünde eşittir. Kadınlar ve erkekler eşit haklara sahiptir.', 'Ayrımcılık yasaktır.', '["eşitlik","ayrımcılık"]', 10),
(3, 17, 'Kişi Dokunulmazlığı', 'Herkes, yaşama, maddi ve manevi varlığını koruma... hakkına sahiptir. Kimseye işkence ve eziyet yapılamaz.', 'Can ve vücut bütünlüğü korunur.', '["yaşam","iskence","eziyet","vücut"]', 17),
(4, 19, 'Kişi Hürriyeti ve Güvenliği', 'Herkes, kişi hürriyeti ve güvenliğine sahiptir. Hakim kararı olmadan kimse tutuklanamaz.', 'Özgürlüğünüz keyfi olarak kısıtlanamaz.', '["özgürlük","tutuklama","gözaltı"]', 19),
(5, 20, 'Özel Hayatın Gizliliği', 'Herkes, özel hayatına ve aile hayatına saygı gösterilmesini isteme hakkına sahiptir. Özel hayatın ve aile hayatının gizliliğine dokunulamaz.', 'Mahremiyetiniz kutsaldır.', '["gizlilik","mahremiyet","kişisel veri"]', 20),
(6, 21, 'Konut Dokunulmazlığı', 'Kimsenin konutuna dokunulamaz. Hakim kararı olmadıkça kimsenin konutuna girilemez.', 'Eviniz sizin kalenizdir.', '["konut","ev","arama"]', 21),
(7, 22, 'Haberleşme Hürriyeti', 'Herkes, haberleşme hürriyetine sahiptir. Haberleşmenin gizliliği esastır.', 'Haberleşmeniz izlenemez.', '["haberleşme","telefon","mesaj"]', 22),
(8, 23, 'Yerleşme ve Seyahat Hürriyeti', 'Herkes, yerleşme ve seyahat hürriyetine sahiptir.', 'İstediğiniz yere gidebilirsiniz.', '["seyahat","gezi"]', 23),
(9, 24, 'Din ve Vicdan Hürriyeti', 'Herkes, vicdan, dini inanç ve kanaat hürriyetine sahiptir.', 'İnancınızda özgürsünüz.', '["din","vicdan","inanç"]', 24),
(10, 25, 'Düşünce ve Kanaat Hürriyeti', 'Herkes, düşünce ve kanaat hürriyetine sahiptir.', 'Fikriniz size aittir.', '["düşünce","fikir"]', 25),
(11, 26, 'Düşünceyi Açıklama', 'Herkes, düşünce ve kanaatlerini söz, yazı, resim veya başka yollarla... açıklama ve yayma hakkına sahiptir.', 'Konuşma özgürlüğü.', '["ifade","yayın"]', 26),
(12, 34, 'Toplantı ve Gösteri', 'Herkes, önceden izin almadan... toplantı ve gösteri yürüyüşü düzenleme hakkına sahiptir.', 'Protesto hakkı.', '["protesto","eylem"]', 34),
(13, 35, 'Mülkiyet Hakkı', 'Herkes, mülkiyet ve miras haklarına sahiptir.', 'Eşyanız ve malınız dokunulmazdır.', '["mülkiyet","eşya"]', 35),
(14, 36, 'Hak Arama Hürriyeti', 'Herkes... adil yargılanma hakkına sahiptir.', 'Mahkemede adalet arama hakkı.', '["mahkeme","dava","savunma"]', 36),
(15, 38, 'Suç ve Cezalar', 'Kimse... işlendiği zaman yürürlükte bulunan kanunun suç saymadığı bir fiilden dolayı cezalandırılamaz.', 'Kanunsuz suç ve ceza olmaz.', '["suç","ceza"]', 38),
(16, 40, 'Hakların Korunması', 'Anayasa ile tanınmış hak ve hürriyetleri ihlal edilen herkes... başvurma imkanının sağlanmasını isteme hakkına sahiptir.', 'Hak ihlaline karşı devlet koruması.', '["başvuru","koruma"]', 40),
(17, 41, 'Ailenin Korunması', 'Aile, Türk toplumunun temelidir. Devlet... ananın ve çocukların korunması için gerekli tedbirleri alır.', 'Aile ve çocuk hakları.', '["aile","çocuk"]', 41),
(18, 42, 'Eğitim ve Öğrenim', 'Kimse, eğitim ve öğrenim hakkından yoksun bırakılamaz.', 'Okuma hakkı.', '["eğitim","okul"]', 42),
(19, 49, 'Çalışma Hakkı', 'Çalışma, herkesin hakkı ve ödevidir.', 'İş hakkı.', '["iş","çalışma"]', 49),
(20, 50, 'Çalışma Şartları', 'Kimse, yaşına, cinsiyetine ve gücüne uymayan işlerde çalıştırılamaz.', 'İş güvenliği ve şartları.', '["tatil","dinlenme"]', 50),
(21, 56, 'Sağlık ve Çevre', 'Herkes, sağlıklı ve dengeli bir çevrede yaşama hakkına sahiptir.', 'Sağlık hizmeti haktır.', '["sağlık","hastane","doğa"]', 56),
(22, 66, 'Türk Vatandaşlığı', 'Türk Devletine vatandaşlık bağı ile bağlı olan herkes Türktür.', 'Vatandaşlık hakkı.', '["vatandaş"]', 66),
(23, 125, 'Yargı Yolu', 'İdarenin her türlü eylem ve işlemlerine karşı yargı yolu açıktır.', 'Devlet işlemlerine dava açılabilir.', '["idare","iptal","belediye"]', 125);

-- --------------------------------------------------------
-- 5. Junction & Supporting
-- --------------------------------------------------------

INSERT INTO `constitution_article_right_category` (`constitution_article_id`, `right_category_id`, `relevance_score`) VALUES
(1, 1, 100), (2, 14, 100), (3, 2, 90), (3, 8, 100), (4, 6, 100), (5, 2, 100), (5, 12, 80),
(6, 3, 100), (7, 2, 90), (7, 10, 100), (10, 2, 90), (11, 2, 80), (13, 3, 90), (13, 4, 100),
(13, 11, 100), (14, 13, 100), (17, 12, 100), (18, 9, 100), (19, 5, 100), (20, 5, 100),
(21, 8, 100), (23, 13, 100);

INSERT INTO `supporting_laws` (`constitution_article_id`, `law_name`, `law_number`, `relevant_articles`, `description`) VALUES
(6, 'Türk Medeni Kanunu', '4721', 'M. 683', 'Mülkiyet ve el atmanın önlenmesi.'),
(14, 'Tüketicinin Korunması Hakkında Kanun', '6502', 'M. 8', 'Ayıplı mal ve haklar.'),
(19, 'İş Kanunu', '4857', 'M. 17-21', 'Kıdem ve ihbar tazminatı.'),
(3, 'Ceza Kanunu', '5237', 'M. 86', 'Kasten yaralama ve darp.');
