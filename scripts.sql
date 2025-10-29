CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `apellido` varchar(60) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `token` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `cliente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `entrada` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `id_usu` int DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `entrada_det` (
  `id` int DEFAULT NULL,
  `id_prod` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL
);

CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `id_cli` int DEFAULT NULL,
  `tipo_pago` varchar(45) DEFAULT NULL,
  `credito` tinyint(1) DEFAULT NULL,
  `total` decimal(5,2) DEFAULT NULL,
  `id_usu` int DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `ventas_det` (
  `id` int DEFAULT NULL,
  `id_prod` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio` decimal(5,2) DEFAULT NULL
);