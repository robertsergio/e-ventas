
--Esto es una prueba...
-- ----------------------------------
-- Alias: e-ventas at localhost
-- Database name: e-ventas
-- Host: localhost
-- Port number: 3306
-- User name: root
-- Server: 5.0.45-community-nt-log
-- Session ID: 2
-- Character set: utf8
-- Collation: utf8_general_ci
-- Client encoding: utf8


SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `e-ventas`
  CHARACTER SET `utf8`
  COLLATE `utf8_general_ci`;

USE `e-ventas`;

/* Tables */
CREATE TABLE `barrios` (
  `id`         int AUTO_INCREMENT NOT NULL,
  `nombre`     varchar(255) NOT NULL,
  `ciudad_id`  int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `categorias` (
  `id`            int NOT NULL,
  `nombre`        varchar(20),
  `descripcion`   text,
  `categoria_id`  int COMMENT 'Una categoria puede tener subcategorias y una subcategoria a la vez tener subcategorias.',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `ciudades` (
  `id`      int AUTO_INCREMENT NOT NULL,
  `nombre`  varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `ci_sessions` (
  `session_id`     varchar(40) NOT NULL DEFAULT '0',
  `ip_address`     varchar(16) NOT NULL DEFAULT '0',
  `user_agent`     varchar(50) NOT NULL,
  `last_activity`  int(10) NOT NULL DEFAULT '0',
  `user_data`      text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE = MyISAM;

CREATE TABLE `clientes` (
  `id`           int NOT NULL,
  `nombre`       varchar(255) NOT NULL,
  `apellido`     varchar(255) NOT NULL,
  `telefono`     varchar(20),
  `direccion`    varchar(225) NOT NULL,
  `email`        varchar(50),
  `ruc`          varchar(100) COMMENT 'ruc del cliente',
  `barrio_id`    int NOT NULL,
  `borrado`      tinyint(1) NOT NULL DEFAULT '0',
  `celular`      varchar(20),
  `vendedor_id`  int NOT NULL DEFAULT '0',
  `ci`           varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `comisiones` (
  `id`                  int AUTO_INCREMENT NOT NULL,
  `fecha_creacion`      timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vendedor_id`         int NOT NULL,
  `monto_ganado`        int NOT NULL DEFAULT '0' COMMENT 'Dinero ganado por venta.',
  `estado_id`           int NOT NULL,
  `pedido_id`           int NOT NULL,
  `fecha_modificacion`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  COMMENT = 'Un desembolso es lo que se le debe pagar a un vendedor por u';

CREATE TABLE `depositos` (
  `id`              int AUTO_INCREMENT NOT NULL,
  `banco`           int NOT NULL COMMENT 'nombre del banco depositado.',
  `fecha_deposito`  datetime NOT NULL COMMENT 'Fecha del deposito',
  `Monto`           int NOT NULL,
  `boleta`          int NOT NULL COMMENT 'numero de boleta',
  `fecha_creacion`  datetime NOT NULL,
  `pedido_id`       int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `estados` (
  `id`           int NOT NULL,
  `nombre`       varchar(20) NOT NULL,
  `descripcion`  text COMMENT 'se guarda una descripcion del estado.',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  COMMENT = 'define los estados que puede tener un pedido. Un estado no s';

CREATE TABLE `mensajes` (
  `id`            int NOT NULL,
  `remitente_id`  int NOT NULL COMMENT 'usuario q envia el mensaje.',
  `destino_id`    int NOT NULL COMMENT 'usuario q recibe el mensaje.',
  `contenido`     text COMMENT 'contenido del mensaje.',
  `fecha_envio`   timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de envio del mensaje.',
  `leido`         tinyint(1) NOT NULL DEFAULT '0',
  `borrado`       tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  COMMENT = 'Guarda mensajes entre usuarios';

CREATE TABLE `modulos` (
  `id`           int NOT NULL,
  `nombre`       varchar(50),
  `descripcion`  text,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `operaciones` (
  `id`           int NOT NULL,
  `nombre`       varchar(50),
  `descripcion`  text,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `pedidos` (
  `id`                  int AUTO_INCREMENT NOT NULL,
  `estado_id`           int NOT NULL,
  `fecha_creacion`      timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vendedor_id`         int NOT NULL,
  `cliente_id`          int NOT NULL,
  `observacion`         text,
  `fecha_modificacion`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  COMMENT = 'Guarda todos los pedidos de compras que se han hecho.';

CREATE TABLE `pedido_tiene_producto` (
  `producto_id`      int NOT NULL,
  `pedido_id`        int NOT NULL,
  `cantidad`         int NOT NULL DEFAULT '0',
  `precio_unitario`  double NOT NULL DEFAULT '0',
  `comision_actual`  float DEFAULT '0',
  PRIMARY KEY (`producto_id`, `pedido_id`)
) ENGINE = InnoDB
  COMMENT = 'un pedido tiene muchos productos, y un producto tiene muchos';

CREATE TABLE `permisos` (
  `id`            int NOT NULL,
  `modulo_id`     int NOT NULL,
  `operacion_id`  int NOT NULL,
  `rol_id`        int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `productos` (
  `id`            int AUTO_INCREMENT NOT NULL,
  `nombre`        varchar(20) NOT NULL,
  `categoria_id`  int,
  `precio`        double unsigned NOT NULL DEFAULT '0',
  `borrado`       tinyint(1) NOT NULL DEFAULT '0',
  `descripcion`   text,
  `imagen`        varchar(255),
  `comision`      float COMMENT 'La comision es un porcentaje del precio del producto que se le otorga al vendedor.',
  `cantidad`      int DEFAULT '0' COMMENT 'cantidad de productos',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `roles` (
  `id`      int AUTO_INCREMENT NOT NULL,
  `nombre`  varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  COMMENT = 'Los tres primeros roles no pueden ser tocados.';

CREATE TABLE `usuarios` (
  `id`             int AUTO_INCREMENT NOT NULL,
  `nombre`         varchar(255) NOT NULL,
  `username`       varchar(255) NOT NULL,
  `password`       varchar(255) NOT NULL,
  `rol_id`         int,
  `supervisor_id`  int,
  `borrado`        tinyint(1) NOT NULL DEFAULT '0',
  `fecha_nac`      datetime COMMENT 'fecha de nacimiento',
  `telefono`       varchar(20),
  `celular`        varchar(20),
  `direccion`      varchar(225) NOT NULL,
  `barrio_id`      int NOT NULL,
  `apellido`       varchar(255) NOT NULL,
  `email`          varchar(255),
  `ci`             varchar(50) COMMENT 'numero de cedula',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  COMMENT = 'Los vendedores son supervisados por un supervisor.';

CREATE TABLE `vendedor_tiene_productos` (
  `vendedor_id`  int NOT NULL,
  `producto_id`  int NOT NULL,
  PRIMARY KEY (`vendedor_id`, `producto_id`)
) ENGINE = InnoDB;

/* Indexes */
CREATE INDEX `barrio_pertenece_ciudad`
  ON `barrios`
  (`ciudad_id`);

CREATE INDEX `categoria_tiene_subcategoria`
  ON `categorias`
  (`categoria_id`);

CREATE UNIQUE INDEX `nombre`
  ON `categorias`
  (`nombre`);

CREATE INDEX `cliente_pertenece_barrio`
  ON `clientes`
  (`barrio_id`);

CREATE INDEX `cliente_pertenece_vendedor`
  ON `clientes`
  (`vendedor_id`);

CREATE UNIQUE INDEX `restriccion_ci_vendedor`
  ON `clientes`
  (`ci`, `vendedor_id`);

CREATE INDEX `desembolso_tiene_estado`
  ON `comisiones`
  (`estado_id`);

CREATE UNIQUE INDEX `id_pedido`
  ON `comisiones`
  (`pedido_id`);

CREATE INDEX `vendedor_tiene_desembolso`
  ON `comisiones`
  (`vendedor_id`);

CREATE INDEX `pedido_tiene_deposito`
  ON `depositos`
  (`pedido_id`);

CREATE UNIQUE INDEX `nombre`
  ON `estados`
  (`nombre`);

CREATE INDEX `destino`
  ON `mensajes`
  (`destino_id`);

CREATE INDEX `remitente`
  ON `mensajes`
  (`remitente_id`);

CREATE INDEX `cliente_tiene_pedidos`
  ON `pedidos`
  (`cliente_id`);

CREATE INDEX `pedido_tiene_estado`
  ON `pedidos`
  (`estado_id`);

CREATE INDEX `vendedor_realiza_pedidos`
  ON `pedidos`
  (`vendedor_id`);

CREATE INDEX `tiene_pedido`
  ON `pedido_tiene_producto`
  (`pedido_id`);

CREATE INDEX `modulo_pertene_permiso`
  ON `permisos`
  (`modulo_id`);

CREATE INDEX `operacion_pertene_permiso`
  ON `permisos`
  (`operacion_id`);

CREATE INDEX `rol_tiene_permiso`
  ON `permisos`
  (`rol_id`);

CREATE INDEX `producto_pertence_categoria`
  ON `productos`
  (`categoria_id`);

CREATE UNIQUE INDEX `nombre`
  ON `roles`
  (`nombre`);

CREATE INDEX `supervisor_supervisa_vendedores`
  ON `usuarios`
  (`supervisor_id`);

CREATE UNIQUE INDEX `username`
  ON `usuarios`
  (`username`);

CREATE INDEX `usuario_pertence_barrio`
  ON `usuarios`
  (`barrio_id`);

CREATE INDEX `usuario_tiene_rol`
  ON `usuarios`
  (`rol_id`);

CREATE INDEX `con_productos`
  ON `vendedor_tiene_productos`
  (`producto_id`);

/* Foreign Keys */
ALTER TABLE `barrios`
  ADD CONSTRAINT `barrio_pertenece_ciudad`
  FOREIGN KEY (`ciudad_id`)
    REFERENCES `ciudades`(`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `categorias`
  ADD CONSTRAINT `categoria_tiene_subcategoria`
  FOREIGN KEY (`categoria_id`)
    REFERENCES `categorias`(`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

ALTER TABLE `clientes`
  ADD CONSTRAINT `cliente_pertenece_barrio`
  FOREIGN KEY (`barrio_id`)
    REFERENCES `barrios`(`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `clientes`
  ADD CONSTRAINT `cliente_pertenece_vendedor`
  FOREIGN KEY (`vendedor_id`)
    REFERENCES `usuarios`(`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `comisiones`
  ADD CONSTRAINT `desemboldo_tiene_pedido`
  FOREIGN KEY (`pedido_id`)
    REFERENCES `pedidos`(`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `comisiones`
  ADD CONSTRAINT `desembolso_tiene_estado`
  FOREIGN KEY (`estado_id`)
    REFERENCES `estados`(`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

ALTER TABLE `comisiones`
  ADD CONSTRAINT `vendedor_tiene_desembolso`
  FOREIGN KEY (`vendedor_id`)
    REFERENCES `usuarios`(`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `depositos`
  ADD CONSTRAINT `pedido_tiene_deposito`
  FOREIGN KEY (`pedido_id`)
    REFERENCES `pedidos`(`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

ALTER TABLE `mensajes`
  ADD CONSTRAINT `destino`
  FOREIGN KEY (`destino_id`)
    REFERENCES `usuarios`(`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `mensajes`
  ADD CONSTRAINT `remitente`
  FOREIGN KEY (`remitente_id`)
    REFERENCES `usuarios`(`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `pedidos`
  ADD CONSTRAINT `cliente_tiene_pedidos`
  FOREIGN KEY (`cliente_id`)
    REFERENCES `clientes`(`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedido_tiene_estado`
  FOREIGN KEY (`estado_id`)
    REFERENCES `estados`(`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

ALTER TABLE `pedidos`
  ADD CONSTRAINT `vendedor_realiza_pedidos`
  FOREIGN KEY (`vendedor_id`)
    REFERENCES `usuarios`(`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `pedido_tiene_producto`
  ADD CONSTRAINT `tiene_pedido`
  FOREIGN KEY (`pedido_id`)
    REFERENCES `pedidos`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `pedido_tiene_producto`
  ADD CONSTRAINT `tiene_producto`
  FOREIGN KEY (`producto_id`)
    REFERENCES `productos`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `permisos`
  ADD CONSTRAINT `modulo_pertene_permiso`
  FOREIGN KEY (`modulo_id`)
    REFERENCES `modulos`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `permisos`
  ADD CONSTRAINT `operacion_pertene_permiso`
  FOREIGN KEY (`operacion_id`)
    REFERENCES `operaciones`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `permisos`
  ADD CONSTRAINT `rol_tiene_permiso`
  FOREIGN KEY (`rol_id`)
    REFERENCES `roles`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `productos`
  ADD CONSTRAINT `producto_pertence_categoria`
  FOREIGN KEY (`categoria_id`)
    REFERENCES `categorias`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `usuarios`
  ADD CONSTRAINT `supervisor_supervisa_vendedores`
  FOREIGN KEY (`supervisor_id`)
    REFERENCES `usuarios`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuario_pertence_barrio`
  FOREIGN KEY (`barrio_id`)
    REFERENCES `barrios`(`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuario_tiene_rol`
  FOREIGN KEY (`rol_id`)
    REFERENCES `roles`(`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE;

ALTER TABLE `vendedor_tiene_productos`
  ADD CONSTRAINT `con_productos`
  FOREIGN KEY (`producto_id`)
    REFERENCES `productos`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `vendedor_tiene_productos`
  ADD CONSTRAINT `con_vendedores`
  FOREIGN KEY (`vendedor_id`)
    REFERENCES `usuarios`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

/* Data for table "barrios" */
INSERT INTO `barrios` (`id`, `nombre`, `ciudad_id`) VALUES (1, 'San Pablo', 1);
INSERT INTO `barrios` (`id`, `nombre`, `ciudad_id`) VALUES (2, 'Hipodromo', 1);
INSERT INTO `barrios` (`id`, `nombre`, `ciudad_id`) VALUES (3, 'Tamarandy', 3);
COMMIT;


/* Data for table "categorias" */
INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `categoria_id`) VALUES (1, 'Ejercicios', '', NULL);
INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `categoria_id`) VALUES (2, 'Corredoras', 'Son las maquinas para correr.', 1);
INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `categoria_id`) VALUES (3, 'Pastillas', 'Pastillas para todos...', NULL);
INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `categoria_id`) VALUES (4, 'Adelgazantes', 'Pastillas para adelgazar.', 3);
COMMIT;


/* Data for table "ciudades" */
INSERT INTO `ciudades` (`id`, `nombre`) VALUES (1, 'Asuncion');
INSERT INTO `ciudades` (`id`, `nombre`) VALUES (2, 'Fernando de la Mora');
INSERT INTO `ciudades` (`id`, `nombre`) VALUES (3, 'Luque');
COMMIT;


/* Data for table "ci_sessions" */
INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES ('76e4b25805c44b3da216584dcfccd398', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv', 1242313676, 'a:4:{s:2:\"id\";s:1:\"5\";s:6:\"nombre\";s:17:\"Don Administrador\";s:6:\"rol_id\";s:1:\"1\";s:4:\"auth\";s:4:\"true\";}');
INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES ('7a5dbd5d7dada3c15650b6889aa88ce2', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv', 1242305259, '');
COMMIT;


/* Data for table "clientes" */
INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `telefono`, `direccion`, `email`, `ruc`, `barrio_id`, `borrado`, `celular`, `vendedor_id`, `ci`) VALUES (1, 'Un Cliente', 'de Prueba', '55555', 'Concepcion 3252 e/ Paraiso y Guarayos.', 'lindo@loco.com', '2288512', 1, 0, '666666', 13, '2288512');
INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `telefono`, `direccion`, `email`, `ruc`, `barrio_id`, `borrado`, `celular`, `vendedor_id`, `ci`) VALUES (2, 'Juan', 'Perez', '55556666', 'Concepcion 3252 c/ Paraiso.', 'juan@perez.com', '2288512-0', 1, 0, '45456745', 10, '2288512');
INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `telefono`, `direccion`, `email`, `ruc`, `barrio_id`, `borrado`, `celular`, `vendedor_id`, `ci`) VALUES (4, 'Brus', 'Wili', '555555', 'Concepcion 3252 c/ Paraiso.', 'brus@wilis.com', '32323', 1, 0, '666666', 16, '555555');
INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `telefono`, `direccion`, `email`, `ruc`, `barrio_id`, `borrado`, `celular`, `vendedor_id`, `ci`) VALUES (5, 'Juan', 'Talavera', '23423423', 'Concepcion 3252 c/ Paraiso.', 'jhon@tala.com', '2384298-0', 1, 0, '23423423', 16, '2342342');
INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `telefono`, `direccion`, `email`, `ruc`, `barrio_id`, `borrado`, `celular`, `vendedor_id`, `ci`) VALUES (7, '?a Eustaquia', 'Doe', '34234', 'Concepcion 3252 c/ Paraiso.', 'juan@perez.com', '23423423-0', 1, 0, '2342342', 16, '3232323');
INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `telefono`, `direccion`, `email`, `ruc`, `barrio_id`, `borrado`, `celular`, `vendedor_id`, `ci`) VALUES (8, 'Luis', 'Gonzales', '5555649', 'Concepcion 3252 c/ Paraiso', 'lucho@gmail.com', '2288512', 1, 0, '4443333', 10, '2288513');
COMMIT;


/* Data for table "comisiones" */
COMMIT;


/* Data for table "depositos" */
COMMIT;


/* Data for table "estados" */
COMMIT;


/* Data for table "mensajes" */
COMMIT;


/* Data for table "modulos" */
COMMIT;


/* Data for table "operaciones" */
INSERT INTO `operaciones` (`id`, `nombre`, `descripcion`) VALUES (1, 'agregar', 'Nos permite rellenar un formulario para agregar una entidad en la base de datos.');
INSERT INTO `operaciones` (`id`, `nombre`, `descripcion`) VALUES (2, 'borrar', 'Nos permite rellenar un formulario para borrar una entidad de la base de datos.');
INSERT INTO `operaciones` (`id`, `nombre`, `descripcion`) VALUES (3, 'listar', 'Lista entidades de la base de datos.');
INSERT INTO `operaciones` (`id`, `nombre`, `descripcion`) VALUES (4, 'ver', 'Para ver datos de una entidad.');
INSERT INTO `operaciones` (`id`, `nombre`, `descripcion`) VALUES (5, 'crear', 'Crea una entidad en la base de datos.');
INSERT INTO `operaciones` (`id`, `nombre`, `descripcion`) VALUES (6, 'actualizar', 'Actualizar una entidad de la base de datos.');
INSERT INTO `operaciones` (`id`, `nombre`, `descripcion`) VALUES (7, 'carrito', 'Permite poder utilizar el carrito de compras.');
INSERT INTO `operaciones` (`id`, `nombre`, `descripcion`) VALUES (8, 'agregarCarrito', 'Permite agregar productos al carrito.');
COMMIT;


/* Data for table "pedidos" */
COMMIT;


/* Data for table "pedido_tiene_producto" */
COMMIT;


/* Data for table "permisos" */
COMMIT;


/* Data for table "productos" */
INSERT INTO `productos` (`id`, `nombre`, `categoria_id`, `precio`, `borrado`, `descripcion`, `imagen`, `comision`, `cantidad`) VALUES (24, 'One Touch Can Opener', 2, 85000, 0, 'Es un abre-latas...', '/imagenes/one_touch_1.jpg', 0.5, 0);
INSERT INTO `productos` (`id`, `nombre`, `categoria_id`, `precio`, `borrado`, `descripcion`, `imagen`, `comision`, `cantidad`) VALUES (26, 'Uno mas', 4, 23423, 0, 'Holis...', 'imagenes/Sin_foto.png', 0.4, 0);
INSERT INTO `productos` (`id`, `nombre`, `categoria_id`, `precio`, `borrado`, `descripcion`, `imagen`, `comision`, `cantidad`) VALUES (27, 'Otro Producto', 3, 1000, 0, 'Es otro producto...', 'imagenes/Sin_foto.png', 0.2, 0);
INSERT INTO `productos` (`id`, `nombre`, `categoria_id`, `precio`, `borrado`, `descripcion`, `imagen`, `comision`, `cantidad`) VALUES (129, 'Reduce Fat Fast', 3, 193000, 0, 'Hay algo que SI puede ayudarlo a perder peso\n\n\nTodos queremos lucir y sentirnos bien? El Programa Reduce Fat-Fast? es un suplemento alimenticio diet?tico, 100% natural cl?nicamente comprobado.\n\nReduce Fat-Fast  son c?psulas que contienen vitaminas especialmente preparadas para ayudarlo a bajar de peso, controlando el apetito y el buen funcionamiento del organismo de manera natural.\n\n \n\nUn complemento alimenticio que elimina la grasa acumulada en su cuerpo, facilitando la p?rdida de peso.  \n\n\nCombinado con una dieta saludable y ejercicios moderados, Reduce Fat-Fast? ha funcionado en hombres y mujeres de distintos or?genes ?tnicos, diferentes razas, morfolog?as y h?bitos de alimentaci?n. Por ende,  tambi?n funcionar? para usted.', 'imagenes/reduce_21.jpg', 0.3, 50);
COMMIT;


/* Data for table "roles" */
INSERT INTO `roles` (`id`, `nombre`) VALUES (1, 'Administrador');
INSERT INTO `roles` (`id`, `nombre`) VALUES (2, 'Supervisor');
INSERT INTO `roles` (`id`, `nombre`) VALUES (3, 'Vendedor');
COMMIT;


/* Data for table "usuarios" */
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (3, 'Homero', 'homero', '', 3, 11, 0, NULL, '5555555', '09812345', 'Calle Siempre Viva', 2, 'Simpson', 'homer@fox.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (5, 'Don Administrador', 'adm', 'b09c600fddc573f117449b3723f23d64', 1, NULL, 0, NULL, '33333', '09812345', 'Cerquita', 1, 'del Mundo', '', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (8, 'Carlos Antonio', 'carlitos', '86c06093b9c9351bcea13ba73dcf9502', 1, NULL, 0, NULL, '444444', '333333', 'Cerquita', 3, 'Lopez', 'carlitos@gmail.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (9, 'Loco', 'loco', '4c193eb3ec2ce5f02b29eba38621bea1', 3, NULL, 1, NULL, '5555666', '99888', 'Lejos', 2, 'Lindo', 'lindo@loco.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (10, 'Don Vendedor', 'vendedor', '0407e8c8285ab85509ac2884025dcf42', 3, 11, 0, NULL, '555555', '666666', 'Concepcion 3252 e/ Paraiso y Guarayos.', 1, 'Loco', 'vendedor@loco.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (11, 'Don Supervisor', 'supervisor', '09348c20a019be0318387c08df7a783d', 2, NULL, 0, NULL, '66666', '888888', 'No se...', 3, 'Loco', 'supervisor@loco.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (12, 'Welcome', 'wel', 'd41d8cd98f00b204e9800998ecf8427e', 1, NULL, 0, NULL, '5556666', '9995555', 'welcome c/ reidmon', 1, 'Reidmon', 'wel@come.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (13, 'Tercer Vendedor', 'v3', '', 3, 11, 0, NULL, '2342342', '2342342', 'Lejos', 1, 'de Prueba', 'v3@e-ventas.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (14, 'Creado ', 'new', '22af645d1859cb5ca6da0c484f1f37ea', 3, 11, 0, NULL, '989898', '98989', 'Lejitos', 2, 'por un Supervisor', '5456546', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (15, 'Supervisor Segundo', 'supervisor2', '2a03aa2f503b2db79e38d483f2f612cc', 2, NULL, 0, NULL, '5466546', '3453', 'Concepcion 3252 e/ Paraiso y Guarayos.', 1, 'de Prueba', 'lindo@loco.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (16, 'Mi vendedor', 'vendedor2', 'b18c8bbdaafe044ab946a5293bee3c89', 3, 15, 0, NULL, '465465', '978798', 'Concepcion 3252 e/ Paraiso y Guarayos.', 1, 'de Prueba', 'lindo@loco.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (17, 'Supervisor Tercero', 'sup3', '147500ecf55c645be72ae4174cf23f44', 2, NULL, 0, NULL, '654654', '234234', 'Concepcion 3252 e/ Paraiso y Guarayos.', 2, 'de Prueba', '5464564', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (18, 'Supervisor Cuarto', 'sup4', '2adddb60df561908cb0c2953c735326e', 2, NULL, 0, NULL, '654654', '234234', 'Concepcion 3252 e/ Paraiso y Guarayos.', 2, 'de Prueba', '5464564', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (19, 'Supervisor QUinto', 'sup5', '6d541e1a33995e4edfeca487a47ddc57', 2, NULL, 0, NULL, '654654', '234234', 'Concepcion 3252 e/ Paraiso y Guarayos.', 2, 'de Prueba', 'supervisor@loco.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (20, 'Supervisor Sexto', 'sup6', '10e9ecc13f5412c432a0d85d5f52603c', 2, NULL, 0, NULL, '654654', '234234', 'Concepcion 3252 e/ Paraiso y Guarayos.', 2, 'de Prueba', 'lindo@loco.com', NULL);
INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password`, `rol_id`, `supervisor_id`, `borrado`, `fecha_nac`, `telefono`, `celular`, `direccion`, `barrio_id`, `apellido`, `email`, `ci`) VALUES (21, 'Vendedor Tercero', 'ven3', '9e72d1a7efc8120dd01dafb36cb7142e', 2, 18, 0, NULL, '345345', '56456', 'Capilla del Monte...', 1, 'de Prueba', 'vendedor@loco.com', NULL);
COMMIT;


/* Data for table "vendedor_tiene_productos" */
COMMIT;
