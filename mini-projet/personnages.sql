-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Ven 12 Juillet 2013 à 21:47
-- Version du serveur: 5.0.41
-- Version de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de données: `mini_projet`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `personnages`
-- 

CREATE TABLE `personnages` (
  `id` smallint(5) NOT NULL auto_increment,
  `nom` varchar(50) collate latin1_general_ci NOT NULL,
  `degats` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `personnages`
-- 

