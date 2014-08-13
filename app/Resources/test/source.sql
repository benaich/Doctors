use doctors;
show tables;

INSERT INTO `config` (`id`, `the_key`, `the_value`) VALUES
(2, 'app_logo', 'uploads/img/af28c5cce7fd0c1de575c139fedf7ccda7e8bad6.png'),
(3, 'app_name', 'ONOUSC'),
(4, 'app_description', 'description :)'),
(5, 'app_address', 'lot charaf salé'),
(6, 'app_cp', '11060'),
(7, 'app_city', 'RABAT'),
(8, 'app_tel', '0644435561'),
(9, 'app_gsm', '056515214'),
(10, 'app_email', 'onousc@gmail.com'),
(11, 'app_website', 'http://onousc.com'),
(12, 'app_map_lat', '33'),
(13, 'app_map_lng', '33'),
(14, 'app_lang', 'en_US'),
(15, 'rows_per_page', '10'),
(16, 'app_css', '/* css */'),
(17, 'allow_registration', 'on'),
(18, 'defaut_logement', '1');

select * from config;