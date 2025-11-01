SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `juguetes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `juguetes`;

-- --------------------------------------------------------
-- Table structure for table `clientes`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `mail` VARCHAR(100) NOT NULL,
  `genero` ENUM('boy', 'girl') NOT NULL,
  PRIMARY KEY (`id`)
);

COMMIT;
SET AUTOCOMMIT = 1;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- datos de ejemplo
INSERT INTO `clientes` (`id`, `nombre`, `mail`, `genero`) VALUES
(1, 'Juan Perez', 'juan.perez@example.com', 'boy'),
(2, 'Maria Gomez', 'maria.gomez@example.com', 'girl'),
(3, 'Carlos Sanchez', 'carlos.sanchez@example.com', 'boy'),
(4, 'Ana Martinez', 'ana.martinez@example.com', 'girl'),
(5, 'Luis Rodriguez', 'luis.rodriguez@example.com', 'boy'); 
