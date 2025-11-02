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

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `juguetes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT,
  `precio` DECIMAL(10,2) NOT NULL,
  `imagen` VARCHAR(255),
  `genero` ENUM('boy','girl','unisex') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunos juguetes de ejemplo
INSERT INTO `juguetes` (`nombre`, `descripcion`, `precio`, `genero`) VALUES
('Carro Control Remoto', 'Carro a control remoto de alta velocidad', 299.99, 'boy'),
('Muñeca Interactiva', 'Muñeca que habla y canta canciones', 399.99, 'girl'),
('Set de Construcción', 'Set de 100 piezas para construir', 199.99, 'unisex'),
('Cocina de Juguete', 'Cocina con sonidos y luces', 499.99, 'girl'),
('Robot Programable', 'Robot educativo programable', 599.99, 'boy'),
('Set de Arte', 'Set completo de arte con pinturas y pinceles', 149.99, 'unisex'),
('Pelota de Fútbol', 'Pelota de fútbol tamaño oficial', 99.99, 'unisex'),
('Casa de Muñecas', 'Casa de muñecas con muebles', 799.99, 'girl'),
('Dinosaurio RC', 'Dinosaurio a control remoto', 349.99, 'boy'),
('Juego de Mesa Educativo', 'Juego de mesa para aprender matemáticas', 179.99, 'unisex');
COMMIT;