-- phpMyAdmin SQL Dump
-- version 3.4.7
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 17-01-2014 a las 06:07:31
-- Versión del servidor: 5.5.18
-- Versión de PHP: 5.4.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `web_intelegis`
--

CREATE DATABASE `web_fiscal`;
USE `web_fiscal`;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_address`
--

CREATE TABLE IF NOT EXISTS `cat_address` (
  `cat_address_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `cat_address`
--

INSERT INTO `cat_address` (`cat_address_id`, `type`, `active`) VALUES
(1, 'Personal', '1'),
(2, 'Card', '1'),
(3, 'Shipping', '1'),
(4, 'Provider', '1'),
(5, 'Other', '1'),
(6, 'Client', '1'),
(7, 'Company', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_card`
--

CREATE TABLE IF NOT EXISTS `cat_card` (
  `cat_card_id` int(11) NOT NULL AUTO_INCREMENT,
  `card` varchar(45) CHARACTER SET ucs2 COLLATE ucs2_bin NOT NULL,
  PRIMARY KEY (`cat_card_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `cat_card`
--

INSERT INTO `cat_card` (`cat_card_id`, `card`) VALUES
(1, 'Visa'),
(2, 'Master Card'),
(3, 'American Express');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_client`
--

CREATE TABLE IF NOT EXISTS `cat_client` (
  `cat_client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `status_client` enum('Baja','Alta','Desactivada') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Alta',
  `date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `date_low` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `user_login_id` int(11) NOT NULL,
  `active_client` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `cat_client`
--

INSERT INTO `cat_client` (`cat_client_id`, `client`, `description`, `phone`, `mail`, `status_client`, `date`, `date_low`, `user_login_id`, `active_client`) VALUES
(1, '', '', '', '', 'Alta', '15/01/2014', '15/01/2014', 1, '1'),
(2, '', '', '', '', 'Alta', '15/01/2014', '15/01/2014', 1, '1'),
(3, 'Arthurlinux', 'se encarga de servidores Linux', '22222', 'arosbar@gmail.com', 'Alta', '15/01/2014', '15/01/2014', 1, '1'),
(4, 'test', 'tetstst', '0''898908', 'aaa@kkk.om', 'Alta', '15/01/2014', '15/01/2014', 1, '1'),
(5, 'tes', 'hh', 'hhh', 'hhh', 'Alta', '15/01/2014', '1389825304', 1, '1'),
(6, 'ss', 'ss', 'sss', 'sss', 'Alta', '15/01/2014', '1389825593', 1, '1'),
(7, 'jj', 'jjj', 'jjj', 'jj', 'Alta', '15/01/2014', '1389826280', 1, '1'),
(8, 'test', 'test', '888987', 'lwksks', 'Alta', '15/01/2014', '1389826779', 1, '1'),
(9, 'uuu', 'iiii', 'iiii', 'iiii', 'Alta', '15/01/2014', '1389827143', 1, '1'),
(10, 'uuu', 'iiii', 'iiii', 'iiii', 'Alta', '15/01/2014', '1389827440', 1, '1'),
(11, 'kkk', 'kkkk', 'kkkk', 'kkk', 'Alta', '15/01/2014', '1389828053', 1, '1'),
(12, 'kj', 'kjj', 'kj', 'kjk', 'Alta', '15/01/2014', '1389828198', 1, '1'),
(13, 'ljll', 'll', 'lll', 'll', 'Alta', '15/01/2014', '1389828398', 1, '1'),
(14, 'lll', 'll', 'l', 'l', 'Alta', '15/01/2014', '1389828458', 1, '1'),
(15, 'test', 't', 't', 't', 'Alta', '15/01/2014', '1389831020', 1, '1'),
(16, 'jj', 'j', 'jh', 'jh', 'Alta', '15/01/2014', '1389831804', 1, '1'),
(17, 'ttt', 't', 't', 't', 'Alta', '15/01/2014', '1389832069', 1, '1'),
(18, 'oo', 'o', 'o', 'o', 'Alta', '15/01/2014', '1389832125', 1, '1'),
(19, 'eeeee2', 'k', 'k', 'k', 'Alta', '31/12/1969', '1389795136', 1, '1'),
(20, 'iy', 'y', 'iyiu', 'yui', 'Alta', '15/01/2014', '1389832221', 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_company`
--

CREATE TABLE IF NOT EXISTS `cat_company` (
  `cat_company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `administrator` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cat_client_id` int(11) NOT NULL,
  `rfc` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `type_company` enum('Interna','Externa') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Externa',
  `status_company` enum('Alta','Baja','Pendiente','Sin Pagar') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Alta',
  `user_login_id` int(11) NOT NULL,
  `date_low` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active_company` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_contact`
--

CREATE TABLE IF NOT EXISTS `cat_contact` (
  `cat_contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cat_contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2147483647 ;

--
-- Volcado de datos para la tabla `cat_contact`
--

INSERT INTO `cat_contact` (`cat_contact_id`, `contact`) VALUES
(1, 'mail'),
(2, 'phone'),
(3, 'cell'),
(4, 'fax'),
(5, 'phone work');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_date_format`
--

CREATE TABLE IF NOT EXISTS `cat_date_format` (
  `cat_date_format_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_format` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_date_format_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2147483647 ;

--
-- Volcado de datos para la tabla `cat_date_format`
--

INSERT INTO `cat_date_format` (`cat_date_format_id`, `date_format`, `active`) VALUES
(1, 'DDMMYYYY', '1'),
(2, 'MMDDYYYY', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_image`
--

CREATE TABLE IF NOT EXISTS `cat_image` (
  `cat_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `context` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `cat_image`
--

INSERT INTO `cat_image` (`cat_image_id`, `type`, `context`, `active`) VALUES
(1, 'user', 'Image for users', '1'),
(2, 'article', 'Image for articles', '1'),
(3, 'galery', 'General images for galery', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_login_type`
--

CREATE TABLE IF NOT EXISTS `cat_login_type` (
  `cat_login_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_login_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2147483647 ;

--
-- Volcado de datos para la tabla `cat_login_type`
--

INSERT INTO `cat_login_type` (`cat_login_type_id`, `login_type`, `active`) VALUES
(1, 'root', '1'),
(2, 'admin', '1'),
(3, 'super_user', '1'),
(4, 'adviser', '1'),
(5, 'user', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_mail_controller`
--

CREATE TABLE IF NOT EXISTS `cat_mail_controller` (
  `cat_mail_controller_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `user` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `server` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'smt.gmail.com',
  `domain` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'gmail.com',
  `password` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT '50',
  `port` int(11) NOT NULL DEFAULT '465',
  `ssl` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'true',
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_mail_controller_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `cat_mail_controller`
--

INSERT INTO `cat_mail_controller` (`cat_mail_controller_id`, `name`, `user`, `server`, `domain`, `password`, `capacity`, `port`, `ssl`, `active`) VALUES
(1, 'Support', 'test.estilosfrescos', 'smtp.gmail.com', 'gmail.com', 'spidermay_test', 50, 465, 'true', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_module`
--

CREATE TABLE IF NOT EXISTS `cat_module` (
  `cat_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `module_context` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  KEY `modulo_id` (`cat_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `cat_module`
--

INSERT INTO `cat_module` (`cat_module_id`, `module`, `module_context`, `description`, `active`) VALUES
(1, 'admin', 'Admin', 'Administración general del sistema', '1'),
(2, 'user', 'User', 'Control de usuarios', '1'),
(3, 'address', 'Address', 'Control address for users', '1'),
(4, 'message', 'Messages', '', '1'),
(5, 'permission', 'Permission', '', '1'),
(6, 'city', 'Cities', '', '1'),
(7, 'mail', 'Mailer', '', '1'),
(8, 'images', 'Admin images', '', '1'),
(9, 'state', 'States', '', '1'),
(10, 'dictionary', 'Dictionaries', 'All reference to add and edit dictionaries', '1'),
(11, 'reference', 'Reference', '', '1'),
(12, 'stock', 'Stock', 'Admin Stocks', '1'),
(13, 'provider', 'Provider', '', '1'),
(14, 'settings', 'Settings', 'Settings for user', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_module_permission`
--

CREATE TABLE IF NOT EXISTS `cat_module_permission` (
  `cat_module_permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_module_id` int(11) NOT NULL,
  `permission` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `permission_context` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_module_permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Volcado de datos para la tabla `cat_module_permission`
--

INSERT INTO `cat_module_permission` (`cat_module_permission_id`, `cat_module_id`, `permission`, `permission_context`, `description`, `active`) VALUES
(1, 2, 'add_user', 'Add user', 'Agregar nuevos usuarios', '0'),
(2, 2, 'edit_user', 'Edit user', 'Editar usuarios', '1'),
(3, 2, 'inactive_user', 'Inactive user', 'Desactivar usuarios', '1'),
(4, 2, 'delete_user', 'Delete user', 'Delete users', '1'),
(5, 2, 'view_user', 'View user', 'Ver usuarios', '1'),
(6, 2, 'list_user', 'List user', 'Listing users', '1'),
(7, 2, 'view_permission', 'View permission', 'View permissions by user', '1'),
(8, 5, 'inactive_module_permission', '', '0', '1'),
(9, 3, 'add_address', 'Add address', 'Agregar permisos', '1'),
(10, 3, 'edit_address', 'Edit address', '', '1'),
(11, 6, 'add_city', '', '0', '1'),
(12, 6, 'edit_city', '', '0', '1'),
(13, 8, 'add_image', 'Add image', 'Add imagen for users', '1'),
(14, 2, 'add_permission', 'Add permission', 'Add permissions by user', '1'),
(15, 3, 'dele_address', 'Dele Address', '', '1'),
(16, 3, 'delete_address', 'Delete Address', '', '1'),
(17, 5, 'add_module', 'Add module', 'Add module permissions', '1'),
(18, 10, 'add_dictionary', 'Add dictionary', 'Add new dictionary', '1'),
(19, 10, 'add_dictionary_word', 'Add dictionary word', 'Add new pharagraph', '1'),
(20, 10, 'edit_dictionary', 'Edit dictionary', 'Edit dictionary', '1'),
(21, 10, 'edit_dictionary_word', 'Edit dictionary word', 'Edit paragraph', '1'),
(22, 5, 'add_module_permission', 'Add module permission', 'Add new permissions', '1'),
(23, 5, 'edit_module_permission', 'Edit module permission', 'Edit permission', '1'),
(24, 5, 'edit_module', 'Edit module', 'Edit module', '1'),
(25, 5, 'inactive_module', 'Inactive module', '', '1'),
(26, 10, 'delete_dictionary', 'Delete dictionary', '', '1'),
(27, 12, 'view_stock', 'View stock', '', '1'),
(28, 12, 'edit_stock', 'Edit stock', '', '1'),
(29, 12, 'delete_stock', 'Delete stock', '', '1'),
(30, 12, 'add_item_in_stock', 'Add item in stock', '', '1'),
(31, 12, 'add_stock', 'Add stock', '', '1'),
(32, 12, 'add_stock_item', 'Add stock item', 'Add new items for stock', '1'),
(33, 12, 'inactive_stock', 'Inactive stock', '', '1'),
(34, 13, 'add_provider', 'Add provider', '', '1'),
(35, 2, 'edit_rol', 'Edit rol', 'Edit rol per user', '1'),
(36, 1, 'add_user_rol', 'Add user rol', 'Add roles for user', '1'),
(37, 1, 'add_admin_user', 'Add admin user', 'Add new user rol with admin account', '1'),
(38, 14, 'edit_user_setting', 'Edit user setting', 'Edit user settings', '1'),
(39, 10, 'delete_dictionary_word', 'Delete dictionary word', 'Delete lines in dictionary', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_number_format`
--

CREATE TABLE IF NOT EXISTS `cat_number_format` (
  `cat_number_format_id` int(11) NOT NULL AUTO_INCREMENT,
  `number_format` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_number_format_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2147483647 ;

--
-- Volcado de datos para la tabla `cat_number_format`
--

INSERT INTO `cat_number_format` (`cat_number_format_id`, `number_format`, `active`) VALUES
(1, '1,000.00', '1'),
(2, '1000.00', '1'),
(3, '1 000,00', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_percentage`
--

CREATE TABLE IF NOT EXISTS `cat_percentage` (
  `cat_percentage_id` int(11) NOT NULL AUTO_INCREMENT,
  `percentage` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `active_percentage` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cat_percentage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_return_form`
--

CREATE TABLE IF NOT EXISTS `cat_return_form` (
  `cat_return_form_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_form` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `active_return_form` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_return_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_service`
--

CREATE TABLE IF NOT EXISTS `cat_service` (
  `cat_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status_service` enum('Alta','Baja','Desactivado') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Alta',
  `active_service` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `date_service` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `date_low` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `user_login_id` int(11) NOT NULL,
  PRIMARY KEY (`cat_service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_temporality`
--

CREATE TABLE IF NOT EXISTS `cat_temporality` (
  `cat_temporality` int(11) NOT NULL AUTO_INCREMENT,
  `temporality` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `active_temporality` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_temporality`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_time_zone`
--

CREATE TABLE IF NOT EXISTS `cat_time_zone` (
  `cat_time_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_zone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '1',
  PRIMARY KEY (`cat_time_zone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2147483647 ;

--
-- Volcado de datos para la tabla `cat_time_zone`
--

INSERT INTO `cat_time_zone` (`cat_time_zone_id`, `time_zone`, `active`) VALUES
(1, 'America/Mexico_city', '1'),
(2, 'America/Tijuana', '1'),
(3, 'America/Mazatlan', '1'),
(4, 'America/Los Angeles', '1'),
(5, 'America/Monterrey', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_user_rol`
--

CREATE TABLE IF NOT EXISTS `cat_user_rol` (
  `cat_user_rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_user_rol_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `cat_user_rol`
--

INSERT INTO `cat_user_rol` (`cat_user_rol_id`, `rol`, `description`, `active`) VALUES
(1, 'Admin', 'User admin in the system. He have all privilegies', '1'),
(2, 'User', 'User in the system. his privileges depend to administrator', '1'),
(3, 'Member', 'User members in the company. Not have privilegies', '1'),
(4, 'Manager', '', '0'),
(5, 'Adviser', '', '0'),
(6, 'Doctor', '', '0'),
(7, 'Seller', '', '0'),
(8, 'Provider', '', '1'),
(9, 'Instructor', 'User with account instructor privileges. \r\n\r\nFor create teams and assign routines, etc.', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_user_x_rol`
--

CREATE TABLE IF NOT EXISTS `cat_user_x_rol` (
  `cat_user_x_rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_user_rol_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_user_x_rol_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `cat_user_x_rol`
--

INSERT INTO `cat_user_x_rol` (`cat_user_x_rol_id`, `cat_user_rol_id`, `user_id`, `active`) VALUES
(1, 1, 1, '1'),
(2, 2, 1, '1'),
(3, 2, 2, '1'),
(4, 3, 1, '0'),
(5, 4, 1, '1'),
(6, 5, 1, '1'),
(7, 6, 1, '0'),
(8, 7, 1, '1'),
(9, 8, 1, '0'),
(10, 9, 1, '0'),
(11, 2, 3, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_image_id` int(11) NOT NULL,
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `detail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `image`
--

INSERT INTO `image` (`image_id`, `cat_image_id`, `title`, `image`, `detail`, `date`, `active`) VALUES
(1, 3, 'Arka 1', '/apps/subcore/media/images/1.jpg', 'Detalles de la imagen 1', '573681997', '1'),
(2, 3, 'Arka 2', '/apps/subcore/media/images/2.jpg', 'Detalles para la imagen dos', '573681997', '1'),
(3, 3, 'Arka 3', '/apps/subcore/media/images/3.jpg', 'Detalles de la imagen 3', '573681997', '1'),
(4, 3, 'Arka 4', '/apps/subcore/media/images/4.jpg', 'Detalles para la imagen 4', '573681997', '1'),
(5, 3, 'Arka 5', '/apps/subcore/media/images/5.jpg', 'Detalles de la imagen 5', '573681997', '1'),
(6, 3, 'Arka 6', '/apps/subcore/media/images/6.jpg', 'Detalles para la imagen 6', '573681997', '1'),
(7, 3, 'Arka 7', '/apps/subcore/media/images/7.jpg', 'Detalles de la imagen 7', '573681997', '1'),
(8, 3, 'Arka 8', '/apps/subcore/media/images/8.jpg', 'Detalles de la imagen 8', '573681997', '1'),
(9, 3, 'Arka 9', '/apps/subcore/media/images/9.jpg', 'Detalles de la imagen 9', '573681997', '1'),
(10, 3, 'Arka 10', '/apps/subcore/media/images/10.jpg', 'Detalles de la imagen 10', '573681997', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `image_galery`
--

CREATE TABLE IF NOT EXISTS `image_galery` (
  `image_galery_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`image_galery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `report` text COLLATE utf8_unicode_ci NOT NULL,
  `user_login_id` int(11) NOT NULL,
  `report_date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `report`
--

INSERT INTO `report` (`report_id`, `title`, `report`, `user_login_id`, `report_date`, `ip`, `active`) VALUES
(1, 'test', 'lalalala', 0, '14/01/2014', '::1', '1'),
(2, 'test', 'lalalala', 1, '14/01/2014', '::1', '1'),
(3, 'test3', 'lldddd', 1, '14/01/2014', '::1', '1'),
(4, 'ueueueue777', '737373', 1, '14/01/2014', '::1', '1'),
(5, 'Testa', 'dasdvasd', 1, '14/01/2014', '::1', '1'),
(6, 'aeaeda', 'asdfasdacfs', 1, '23/01/2014', '::1', '1'),
(7, 'asas', 'asdfasd', 1, '14/01/2014', '::1', '1'),
(8, 'qwefqwe', 'qwerqwe', 1, '14/01/2014', '::1', '1'),
(9, 'Test 9', '9999999999', 1, '-1793839', '::1', '1'),
(10, 'qwerqwe', 'awe', 1, '14/01/2014', '::1', '1'),
(11, 'awefawe', 'awedqrawe', 1, '14/01/2014', '::1', '1'),
(12, 'adsasd', 'asdads', 1, '14/01/2014', '::1', '1'),
(13, 'asdfas', 'asdfasd', 1, '1389762533', '::1', '1'),
(14, 'asdfas', 'asdfasd', 1, '1389762533', '::1', '1'),
(15, 'asdfas', 'asdfasd', 1, '1389762535', '::1', '1'),
(16, 'asdfas', 'asdfasd', 1, '1389762536', '::1', '1'),
(17, 'asdfas', 'asdfasd', 1, '1389762562', '::1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sys_counter`
--

CREATE TABLE IF NOT EXISTS `sys_counter` (
  `sys_counter_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`sys_counter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sys_tracking`
--

CREATE TABLE IF NOT EXISTS `sys_tracking` (
  `sys_tracking_id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `who_id` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `detail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`sys_tracking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login_id` int(11) NOT NULL,
  `names` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `mother_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `rfc` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `curp` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `sex` enum('man','woman') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'man',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`user_id`, `user_login_id`, `names`, `lastname`, `mother_name`, `rfc`, `curp`, `birthday`, `sex`) VALUES
(1, 1, 'Admin', 'System', 'Support', 'SYSA 850418', '', '482702069', 'man'),
(2, 2, 'May', 'Cortés', 'Aceves', 'COAM 800101', '', '06/03/1988', 'man'),
(3, 3, 'Prueba de user', 'Prueb last name', 'las tima', 'PRLP 930106', '', '726342595', 'man');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_address`
--

CREATE TABLE IF NOT EXISTS `user_address` (
  `user_address_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `cat_address_id` int(11) NOT NULL DEFAULT '1',
  `street` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `colony` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `postal_zip` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `place` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `interior` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `address_detail` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `address_cross` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `delete` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `user_address`
--

INSERT INTO `user_address` (`user_address_id`, `user_id`, `city_id`, `sector_id`, `cat_address_id`, `street`, `number`, `colony`, `postal_zip`, `place`, `interior`, `address_detail`, `address_cross`, `active`, `delete`) VALUES
(1, 2, 1565, 0, 1, 'Jesus', '345', 'Nueva', '2344', 'I', '78', 'Detalles', 'Cruza', '1', '1'),
(2, 3, 565, 0, 1, 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', '1', '1'),
(6, 11, 565, 0, 1, '´ñl', 'ñ´l', 'ñ´l', 'ñ´', '´ñ', '', '', '', '1', '1'),
(7, 12, 565, 0, 1, 'kjk', 'jk', 'jk', 'jk', 'jk', 'jk', 'jkj', 'k', '1', '1'),
(8, 13, 569, 0, 1, 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l', '1', '1'),
(9, 14, 569, 0, 1, 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l', '1', '1'),
(11, 18, 1056, 0, 1, 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', '1', '1'),
(13, 20, 2379, 0, 6, 'yu', 'uyi', 'yiu', 'yiu', 'yiuy', 'iiuy', 'uiyiyui', 'iuy', '1', '1'),
(14, 19, 565, 0, 6, 'ss', 'kk', 'k', 'k', 'k', '', '', '', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_billing`
--

CREATE TABLE IF NOT EXISTS `user_billing` (
  `user_billing_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cat_card_id` int(11) NOT NULL,
  `card_number` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `holder_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `month` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_billing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_contact`
--

CREATE TABLE IF NOT EXISTS `user_contact` (
  `user_contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sys_contact_id` int(11) NOT NULL,
  `contact` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `custom` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `key` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `delete` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `user_login_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_login_date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `delete` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `user_login`
--

INSERT INTO `user_login` (`user_login_id`, `mail`, `password`, `secret`, `user_login_date`, `active`, `delete`) VALUES
(1, 'admin@system.com', '827ccb0eea8a706c4c34a16891f84e7b', '', '1388519669', '1', '1'),
(2, 'may@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 's-l-2krOdQwF7Lr', '1388499281', '0', '1'),
(3, 'test@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'QfVwZNMzArk74Wz', '1389808195', '0', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_permission`
--

CREATE TABLE IF NOT EXISTS `user_permission` (
  `user_permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login_id` int(11) NOT NULL,
  `cat_module_permission_id` int(11) NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Volcado de datos para la tabla `user_permission`
--

INSERT INTO `user_permission` (`user_permission_id`, `user_login_id`, `cat_module_permission_id`, `active`) VALUES
(1, 1, 6, '1'),
(2, 1, 14, '1'),
(3, 1, 7, '1'),
(4, 1, 5, '1'),
(5, 1, 4, '1'),
(6, 1, 3, '1'),
(7, 1, 2, '1'),
(8, 1, 1, '1'),
(9, 1, 25, '1'),
(10, 1, 8, '1'),
(11, 1, 17, '1'),
(12, 1, 22, '1'),
(13, 1, 23, '1'),
(14, 1, 24, '1'),
(15, 1, 9, '1'),
(16, 1, 10, '1'),
(17, 1, 15, '1'),
(18, 1, 16, '1'),
(19, 1, 27, '1'),
(20, 1, 28, '1'),
(21, 1, 29, '1'),
(22, 1, 30, '1'),
(23, 1, 31, '1'),
(24, 1, 32, '1'),
(25, 1, 33, '1'),
(26, 1, 11, '1'),
(27, 1, 12, '1'),
(28, 1, 13, '1'),
(29, 1, 18, '1'),
(30, 1, 19, '1'),
(31, 1, 20, '1'),
(32, 1, 21, '1'),
(33, 1, 26, '1'),
(34, 1, 34, '1'),
(35, 1, 35, '1'),
(36, 1, 39, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_setting`
--

CREATE TABLE IF NOT EXISTS `user_setting` (
  `user_setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login_id` int(11) NOT NULL,
  `cat_time_zone_id` int(11) NOT NULL,
  `cat_date_format_id` int(11) NOT NULL,
  `cat_number_format_id` int(11) NOT NULL,
  `language` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
