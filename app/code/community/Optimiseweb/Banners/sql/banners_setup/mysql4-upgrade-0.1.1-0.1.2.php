<?php

/**
 * Optimiseweb Banners Installer
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('banners')} ADD COLUMN `store_ids` VARCHAR(255) NULL DEFAULT '0' AFTER `identifier`;

");

$installer->endSetup();
