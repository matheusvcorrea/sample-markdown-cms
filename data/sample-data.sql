-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 23-Jul-2016 às 18:07
-- Versão do servidor: 5.5.50-0ubuntu0.14.04.1
-- versão do PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `zend`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `Book`
--

CREATE TABLE IF NOT EXISTS `Book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6BD70C0FF47645AE` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `Book`
--

INSERT INTO `Book` (`id`, `title`, `url`) VALUES
(1, 'Firsts Books', 'first-book'),
(2, 'Second Book', 'second-book');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Navigation`
--

CREATE TABLE IF NOT EXISTS `Navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) DEFAULT NULL,
  `privilege_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_667C6EF89329D25` (`resource_id`),
  KEY `IDX_667C6EF32FB8AEA` (`privilege_id`),
  KEY `IDX_667C6EF727ACA70` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `Navigation`
--

INSERT INTO `Navigation` (`id`, `resource_id`, `privilege_id`, `parent_id`, `name`, `route`, `status`, `order`) VALUES
(1, 1, 1, NULL, 'Home', 'home', 0, 1),
(2, 2, 7, NULL, 'Login', 'authentication', 1, 4),
(3, 2, 8, NULL, 'Logout', 'logout', 0, 0),
(4, 4, 1, NULL, 'Cms', 'cms', 1, 2),
(5, 5, 1, NULL, 'Dashboard', 'dashboard', 1, 1),
(6, 3, 1, NULL, 'Books', 'book', 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `navigations_roles`
--

CREATE TABLE IF NOT EXISTS `navigations_roles` (
  `navigation_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`navigation_id`,`role_id`),
  KEY `IDX_DFAB9B1C39F79D6D` (`navigation_id`),
  KEY `IDX_DFAB9B1CD60322AC` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `navigations_roles`
--

INSERT INTO `navigations_roles` (`navigation_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(4, 2),
(5, 2),
(6, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Page`
--

CREATE TABLE IF NOT EXISTS `Page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B438191EF47645AE` (`url`),
  KEY `IDX_B438191E16A2B381` (`book_id`),
  KEY `IDX_B438191EF675F31B` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `Page`
--

INSERT INTO `Page` (`id`, `book_id`, `title`, `content`, `url`, `author_id`, `order`, `created`) VALUES
(3, 1, 'Title Page', '<h2>Edited Second Page<br></h2><h3>Sub H.<br></h3><p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#" data-mce-href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p><p><img src="/img/zf2-logo.png" alt="" data-mce-src="/img/zf2-logo.png"></p>', 'second-page', 1, 1, '0000-00-00 00:00:00'),
(4, 1, 'New Page', '<h2>This is a new page<br></h2><h3>This is a subtitle</h3><p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#" data-mce-href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>', 'new-page', 1, 0, '0000-00-00 00:00:00'),
(5, 2, 'Sample Title', '<h2>Subheader</h2>\r\n<h3>Titulo</h3>\r\n<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>\r\n<p><img src="/img/zf2-logo.png" alt="" /></p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</p>\r\n<ul>\r\n<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>\r\n<li>Aliquam tincidunt mauris eu risus.</li>\r\n<li>Vestibulum auctor dapibus neque.</li>\r\n</ul>\r\n<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>\r\n<h2>Header Level 2</h2>\r\n<ol>\r\n<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>\r\n<li>Aliquam tincidunt mauris eu risus.</li>\r\n</ol>\r\n<blockquote>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p>\r\n</blockquote>\r\n<h3>Header Level 3</h3>\r\n<ul>\r\n<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>\r\n<li>Aliquam tincidunt mauris eu risus.</li>\r\n</ul>\r\n<pre><code>\r\n#header h1 a { \r\n	display: block; \r\n	width: 300px; \r\n	height: 80px; \r\n}\r\n</code></pre>', 'sample', 1, 0, '2016-07-18 21:16:29'),
(7, 1, 'Test page', '<p>Hello world</p>', 'test-page', 1, 0, '2016-07-18 18:47:27'),
(8, 1, 'Second title', '<h1>Second title</h1>\r\n<h2>Hello wolrd</h2>\r\n<p>&nbsp;</p>', 'second-title', 1, 0, '2016-07-18 19:03:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Privilege`
--

CREATE TABLE IF NOT EXISTS `Privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `Privilege`
--

INSERT INTO `Privilege` (`id`, `name`) VALUES
(1, 'index'),
(2, 'view'),
(3, 'edit'),
(4, 'create'),
(5, 'update'),
(6, 'delete'),
(7, 'login'),
(8, 'logout'),
(9, 'list'),
(10, 'search');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Resource`
--

CREATE TABLE IF NOT EXISTS `Resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `Resource`
--

INSERT INTO `Resource` (`id`, `name`) VALUES
(1, 'Application\\Controller\\Index'),
(2, 'Authorize\\Controller\\Authorize'),
(3, 'Book\\Controller\\Book'),
(4, 'Cms\\Controller\\Cms'),
(5, 'Dashboard\\Controller\\Dashboard'),
(7, 'Search\\Controller\\Search');

-- --------------------------------------------------------

--
-- Estrutura da tabela `resources_roles`
--

CREATE TABLE IF NOT EXISTS `resources_roles` (
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`resource_id`),
  KEY `IDX_FCE77B49D60322AC` (`role_id`),
  KEY `IDX_FCE77B4989329D25` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `resources_roles`
--

INSERT INTO `resources_roles` (`role_id`, `resource_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 7),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `Role`
--

INSERT INTO `Role` (`id`, `name`) VALUES
(1, 'Guest'),
(2, 'Admin'),
(3, 'Member'),
(4, 'SomeUser');

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles_parents`
--

CREATE TABLE IF NOT EXISTS `roles_parents` (
  `role_id` int(11) NOT NULL,
  `parent_role_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`parent_role_id`),
  KEY `IDX_C70E6B91D60322AC` (`role_id`),
  KEY `IDX_C70E6B91A44B56EA` (`parent_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `roles_parents`
--

INSERT INTO `roles_parents` (`role_id`, `parent_role_id`) VALUES
(3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles_privileges`
--

CREATE TABLE IF NOT EXISTS `roles_privileges` (
  `roles_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL,
  PRIMARY KEY (`roles_id`,`privilege_id`),
  KEY `IDX_2472C79A32FB8AEA` (`privilege_id`),
  KEY `IDX_2472C79A38C751C4` (`roles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `roles_privileges`
--

INSERT INTO `roles_privileges` (`roles_id`, `privilege_id`) VALUES
(1, 1),
(3, 1),
(1, 2),
(3, 2),
(1, 7),
(3, 7),
(3, 8),
(3, 9),
(1, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `fullName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2DA17977D60322AC` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `User`
--

INSERT INTO `User` (`id`, `role_id`, `fullName`, `username`, `password`) VALUES
(1, 2, 'Admin', 'admin', '81dc9bdb52d04dc20036dbd8313ed055'),
(2, 3, 'Member', 'member', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `Navigation`
--
ALTER TABLE `Navigation`
  ADD CONSTRAINT `FK_667C6EF32FB8AEA` FOREIGN KEY (`privilege_id`) REFERENCES `Privilege` (`id`),
  ADD CONSTRAINT `FK_667C6EF727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `Navigation` (`id`),
  ADD CONSTRAINT `FK_667C6EF89329D25` FOREIGN KEY (`resource_id`) REFERENCES `Resource` (`id`);

--
-- Limitadores para a tabela `navigations_roles`
--
ALTER TABLE `navigations_roles`
  ADD CONSTRAINT `FK_DFAB9B1C39F79D6D` FOREIGN KEY (`navigation_id`) REFERENCES `Navigation` (`id`),
  ADD CONSTRAINT `FK_DFAB9B1CD60322AC` FOREIGN KEY (`role_id`) REFERENCES `Role` (`id`);

--
-- Limitadores para a tabela `Page`
--
ALTER TABLE `Page`
  ADD CONSTRAINT `FK_B438191E16A2B381` FOREIGN KEY (`book_id`) REFERENCES `Book` (`id`),
  ADD CONSTRAINT `FK_B438191EF675F31B` FOREIGN KEY (`author_id`) REFERENCES `User` (`id`);

--
-- Limitadores para a tabela `resources_roles`
--
ALTER TABLE `resources_roles`
  ADD CONSTRAINT `FK_FCE77B4989329D25` FOREIGN KEY (`resource_id`) REFERENCES `Resource` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_FCE77B49D60322AC` FOREIGN KEY (`role_id`) REFERENCES `Role` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `roles_parents`
--
ALTER TABLE `roles_parents`
  ADD CONSTRAINT `FK_C70E6B91A44B56EA` FOREIGN KEY (`parent_role_id`) REFERENCES `Role` (`id`),
  ADD CONSTRAINT `FK_C70E6B91D60322AC` FOREIGN KEY (`role_id`) REFERENCES `Role` (`id`);

--
-- Limitadores para a tabela `roles_privileges`
--
ALTER TABLE `roles_privileges`
  ADD CONSTRAINT `FK_2472C79A32FB8AEA` FOREIGN KEY (`privilege_id`) REFERENCES `Privilege` (`id`),
  ADD CONSTRAINT `FK_2472C79A38C751C4` FOREIGN KEY (`roles_id`) REFERENCES `Role` (`id`);

--
-- Limitadores para a tabela `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `FK_2DA17977D60322AC` FOREIGN KEY (`role_id`) REFERENCES `Role` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
