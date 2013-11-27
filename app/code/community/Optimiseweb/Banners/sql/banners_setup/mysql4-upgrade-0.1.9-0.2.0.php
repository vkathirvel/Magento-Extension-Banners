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

ALTER TABLE {$this->getTable('banners')} ADD COLUMN `image_retina` VARCHAR(255) NULL DEFAULT NULL AFTER `image`;

");

$installer->endSetup();