CREATE TABLE IF NOT EXISTS `sistemaproduccion`.`empleados` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `primer_nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `cedula` VARCHAR(50) NOT NULL,
  `genero` VARCHAR(50) NOT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `fecha_ingreso` DATE NOT NULL,
  `estado` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `sistemaproduccion`.`Puestos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `sistemaproduccion`.`TiposEmpleo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `sistemaproduccion`.`Departamentos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `sistemaproduccion`.`RelacionEmpleadoEmpresa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empleado_id` INT NOT NULL,
  `compania` VARCHAR(100) NOT NULL,
  `departamento_id` INT NOT NULL,
  `tipo_empleo_id` INT NOT NULL,
  `numero_empleado` VARCHAR(50) NOT NULL,
  `puesto_id` INT NOT NULL,
  `reporta_a` VARCHAR(100) NULL DEFAULT NULL,
  `sucursal` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`empleado_id`) REFERENCES `sistemaproduccion`.`DatosPersonales`(`id`),
  FOREIGN KEY (`departamento_id`) REFERENCES `sistemaproduccion`.`Departamentos`(`id`),
  FOREIGN KEY (`tipo_empleo_id`) REFERENCES `sistemaproduccion`.`TiposEmpleo`(`id`),
  FOREIGN KEY (`puesto_id`) REFERENCES `sistemaproduccion`.`Puestos`(`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `sistemaproduccion`.`IngresoEmpresa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empleado_id` INT NOT NULL,
  `solicitante_empleo` VARCHAR(100) NULL DEFAULT NULL,
  `fecha_oferta` DATE NULL DEFAULT NULL,
  `fecha_confirmacion` DATE NULL DEFAULT NULL,
  `fecha_fin_contrato` DATE NULL DEFAULT NULL,
  `aviso_dias` INT NULL DEFAULT NULL,
  `fecha_jubilacion` DATE NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`empleado_id`) REFERENCES `sistemaproduccion`.`DatosPersonales`(`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `sistemaproduccion`.`Direccion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empleado_id` INT NOT NULL,
  `direccion` VARCHAR(255) NULL DEFAULT NULL,
  `ciudad` VARCHAR(100) NULL DEFAULT NULL,
  `pais` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`empleado_id`) REFERENCES `sistemaproduccion`.`DatosPersonales`(`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `sistemaproduccion`.`Contacto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empleado_id` INT NOT NULL,
  `numero_celular` VARCHAR(20) NULL DEFAULT NULL,
  `correo_personal` VARCHAR(100) NULL DEFAULT NULL,
  `correo_compania` VARCHAR(100) NULL DEFAULT NULL,
  `correo_preferido` VARCHAR(100) NULL DEFAULT NULL,
  `no_suscrito` BOOLEAN NULL DEFAULT NULL,
  `contacto_emergencia` VARCHAR(100) NULL DEFAULT NULL,
  `telefono_emergencia` VARCHAR(20) NULL DEFAULT NULL,
  `relacion` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`empleado_id`) REFERENCES `sistemaproduccion`.`DatosPersonales`(`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `sistemaproduccion`.`Salarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empleado_id` INT NOT NULL,
  `tipo_salario` VARCHAR(50) NOT NULL, -- Fijo o Producción
  `monto` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`empleado_id`) REFERENCES `sistemaproduccion`.`DatosPersonales`(`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;
