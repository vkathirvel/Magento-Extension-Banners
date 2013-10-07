<?php

/**
 * Optimiseweb Banners Installer
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimise Web Limited
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('banners')};

CREATE TABLE {$this->getTable('banners')} (
	`banner_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`identifier` VARCHAR(255) NOT NULL,
	`description` VARCHAR(255) NULL DEFAULT NULL,
	`image` VARCHAR(255) NULL DEFAULT NULL,
	`alt` VARCHAR(255) NULL DEFAULT NULL,
	`title` VARCHAR(255) NULL DEFAULT NULL,
	`url` VARCHAR(255) NULL DEFAULT NULL,
	`heading` VARCHAR(255) NULL DEFAULT NULL,
	`banner_content` TEXT NULL,
	`external` SMALLINT(6) NOT NULL DEFAULT '0',
	`banner_order` SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0',
	`status` SMALLINT(6) NOT NULL DEFAULT '1',
	`start_date` DATETIME NULL DEFAULT NULL,
	`end_date` DATETIME NULL DEFAULT NULL,
	`created_time` DATETIME NULL DEFAULT NULL,
	`update_time` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`banner_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
");

$installer->endSetup();