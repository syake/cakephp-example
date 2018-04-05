-- MySQL Script generated by MySQL Workbench
-- Thu Apr  5 10:18:27 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema cakephp-test
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema cakephp-test
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cakephp-test` DEFAULT CHARACTER SET utf8 ;
USE `cakephp-test` ;

-- -----------------------------------------------------
-- Table `cakephp-test`.`projects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cakephp-test`.`projects` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug_UNIQUE` (`name` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cakephp-test`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cakephp-test`.`users` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nickname` VARCHAR(255) NULL DEFAULT NULL,
  `enable` TINYINT(1) NULL DEFAULT '0',
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username` (`username` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cakephp-test`.`articles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cakephp-test`.`articles` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` BIGINT(20) UNSIGNED NOT NULL,
  `author_id` BIGINT(20) UNSIGNED NOT NULL,
  `status` TINYINT(4) NULL DEFAULT 0,
  `title` VARCHAR(64) NULL,
  `description` VARCHAR(255) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_articles_projects_idx` (`project_id` ASC),
  INDEX `fk_articles_users1_idx` (`author_id` ASC),
  CONSTRAINT `fk_articles_projects`
    FOREIGN KEY (`project_id`)
    REFERENCES `cakephp-test`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_articles_users1`
    FOREIGN KEY (`author_id`)
    REFERENCES `cakephp-test`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 28
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cakephp-test`.`sections`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cakephp-test`.`sections` (
  `article_id` BIGINT(20) UNSIGNED NOT NULL,
  `id` BIGINT(20) UNSIGNED NOT NULL,
  `title` VARCHAR(64) NULL,
  `description` TEXT NULL,
  `style` VARCHAR(20) NULL,
  PRIMARY KEY (`article_id`, `id`),
  CONSTRAINT `fk_sections_articles1`
    FOREIGN KEY (`article_id`)
    REFERENCES `cakephp-test`.`articles` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cakephp-test`.`projects_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cakephp-test`.`projects_users` (
  `project_id` BIGINT(20) UNSIGNED NOT NULL,
  `user_id` BIGINT(20) UNSIGNED NOT NULL,
  `role` ENUM('admin', 'author') NULL DEFAULT 'author',
  PRIMARY KEY (`project_id`, `user_id`),
  INDEX `fk_projects_has_users1_users1_idx` (`user_id` ASC),
  INDEX `fk_projects_has_users1_projects1_idx` (`project_id` ASC),
  CONSTRAINT `fk_projects_has_users1_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `cakephp-test`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projects_has_users1_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `cakephp-test`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cakephp-test`.`images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cakephp-test`.`images` (
  `name` VARCHAR(255) NOT NULL,
  `data` MEDIUMBLOB NULL,
  `mime_type` VARCHAR(255) NULL,
  `project_id` BIGINT(20) UNSIGNED NULL,
  `created` DATETIME NULL,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  PRIMARY KEY (`name`),
  CONSTRAINT `fk_images_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `cakephp-test`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cakephp-test`.`cells`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cakephp-test`.`cells` (
  `article_id` BIGINT(20) UNSIGNED NOT NULL,
  `section_id` BIGINT(20) UNSIGNED NOT NULL,
  `id` BIGINT(20) UNSIGNED NOT NULL,
  `title` VARCHAR(64) NULL,
  `description` TEXT NULL,
  `image_name` VARCHAR(255) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`article_id`, `section_id`, `id`),
  INDEX `fk_cells_images1_idx` (`image_name` ASC),
  CONSTRAINT `fk_cells_sections1`
    FOREIGN KEY (`article_id` , `section_id`)
    REFERENCES `cakephp-test`.`sections` (`article_id` , `id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_cells_images1`
    FOREIGN KEY (`image_name`)
    REFERENCES `cakephp-test`.`images` (`name`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cakephp-test`.`mainvisuals`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cakephp-test`.`mainvisuals` (
  `article_id` BIGINT(20) UNSIGNED NOT NULL,
  `id` BIGINT(20) UNSIGNED NOT NULL,
  `image_name` VARCHAR(255) NULL,
  `title` VARCHAR(45) NULL,
  `description` VARCHAR(255) NULL,
  PRIMARY KEY (`article_id`, `id`),
  INDEX `fk_mainvisuals_images1_idx` (`image_name` ASC),
  CONSTRAINT `fk_mainvisuals_articles1`
    FOREIGN KEY (`article_id`)
    REFERENCES `cakephp-test`.`articles` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_mainvisuals_images1`
    FOREIGN KEY (`image_name`)
    REFERENCES `cakephp-test`.`images` (`name`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
