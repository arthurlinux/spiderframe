-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2009 at 07:31 AM
-- Server version: 5.0.50
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `newsletter`
--

CREATE Database: `newsletter`;
USE `newsletter`;
-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` smallint(3) unsigned NOT NULL auto_increment,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `email` varchar(35) character set utf8 NOT NULL,
  `category` smallint(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `emails`
--


-- --------------------------------------------------------

--
-- Table structure for table `sent_mails`
--

CREATE TABLE IF NOT EXISTS `sent_mails` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `time` bigint(11) unsigned NOT NULL,
  `subject` varchar(60) collate utf8_slovak_ci NOT NULL,
  `body` text collate utf8_slovak_ci NOT NULL,
  `attachment` varchar(120) collate utf8_slovak_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sent_mails`
--

