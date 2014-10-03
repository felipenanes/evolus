-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.12-log - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para cakephp
CREATE DATABASE IF NOT EXISTS `cakephp` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `cakephp`;


-- Copiando estrutura para tabela cakephp.actions
CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela cakephp.actions: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;


-- Copiando estrutura para tabela cakephp.actions_profiles
CREATE TABLE IF NOT EXISTS `actions_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) NOT NULL DEFAULT '0',
  `profile_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela cakephp.actions_profiles: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `actions_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `actions_profiles` ENABLE KEYS */;


-- Copiando estrutura para tabela cakephp.geral_areas
CREATE TABLE IF NOT EXISTS `geral_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela cakephp.geral_areas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `geral_areas` DISABLE KEYS */;
/*!40000 ALTER TABLE `geral_areas` ENABLE KEYS */;


-- Copiando estrutura para tabela cakephp.modules
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela cakephp.modules: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;


-- Copiando estrutura para tabela cakephp.profiles
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela cakephp.profiles: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;


-- Copiando estrutura para tabela cakephp.specific_areas
CREATE TABLE IF NOT EXISTS `specific_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela cakephp.specific_areas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `specific_areas` DISABLE KEYS */;
/*!40000 ALTER TABLE `specific_areas` ENABLE KEYS */;


-- Copiando estrutura para tabela cakephp.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `geral_area_id` int(11) NOT NULL,
  `specific_area_id` int(11) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela cakephp.users: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `email`, `geral_area_id`, `specific_area_id`, `password`) VALUES
	(2, 'felipe', 'felipenanes@gmail.com', 0, 0, '4a2cc50dbaa25acdce0677038b7142e8edbb052c');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
