-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`ocupacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`ocupacion` (
  `id_ocupacion` INT NOT NULL AUTO_INCREMENT,
  `nombre_ocupación` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_ocupacion`),
  UNIQUE INDEX `nombre_ocupación_UNIQUE` (`nombre_ocupación` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`roles` (
  `id_roles` INT NOT NULL AUTO_INCREMENT,
  `nombre_rol` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_roles`),
  UNIQUE INDEX `nombre_rol_UNIQUE` (`nombre_rol` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `correo_usuario` VARCHAR(100) NOT NULL,
  `edad_usuario` INT NOT NULL,
  `contraseña_usuario` VARCHAR(16) NOT NULL,
  `ocupacion_usuario` INT NOT NULL,
  `rol_usuario` INT NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE INDEX `correo_usuario_UNIQUE` (`correo_usuario` ASC) VISIBLE,
  INDEX `fk_usuario_ocupacion1_idx` (`ocupacion_usuario` ASC) VISIBLE,
  INDEX `fk_usuario_roles1_idx` (`rol_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_usuario_ocupacion1`
    FOREIGN KEY (`ocupacion_usuario`)
    REFERENCES `mydb`.`ocupacion` (`id_ocupacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_roles1`
    FOREIGN KEY (`rol_usuario`)
    REFERENCES `mydb`.`roles` (`id_roles`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`autor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`autor` (
  `id_autores` INT NOT NULL AUTO_INCREMENT,
  `nombre_autor` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_autores`),
  UNIQUE INDEX `idautores_UNIQUE` (`id_autores` ASC) VISIBLE,
  UNIQUE INDEX `nombre_autor_UNIQUE` (`nombre_autor` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`genero`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`genero` (
  `id_genero` INT NOT NULL AUTO_INCREMENT,
  `nombre_genero` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_genero`),
  UNIQUE INDEX `nombre_genero_UNIQUE` (`nombre_genero` ASC) VISIBLE,
  UNIQUE INDEX `id_genero_UNIQUE` (`id_genero` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`libro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`libro` (
  `id_libro` INT NOT NULL AUTO_INCREMENT,
  `id_autor` INT NOT NULL,
  `id_genero` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  `portada_url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_libro`),
  INDEX `fk_libros_autores_idx` (`id_autor` ASC) VISIBLE,
  INDEX `fk_libros_generos1_idx` (`id_genero` ASC) VISIBLE,
  INDEX `fk_libros_usuario1_idx` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_libros_autores`
    FOREIGN KEY (`id_autor`)
    REFERENCES `mydb`.`autor` (`id_autores`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_libros_generos1`
    FOREIGN KEY (`id_genero`)
    REFERENCES `mydb`.`genero` (`id_genero`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_libros_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `mydb`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`reseña`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`reseña` (
  `id_reseña` INT NOT NULL AUTO_INCREMENT,
  `fecha_reseña` DATE NOT NULL,
  `contenido_reseña` TEXT NOT NULL,
  `id_libro` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id_reseña`),
  INDEX `fk_reseña_libros1_idx` (`id_libro` ASC, `id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_reseña_libros1`
    FOREIGN KEY (`id_libro` , `id_usuario`)
    REFERENCES `mydb`.`libro` (`id_libro` , `id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
