<?php

/**
 * Optimiseweb Banners Model Status
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Model_Status extends Varien_Object
{

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    static public function getOptionArray()
    {
        return array(
                self::STATUS_ENABLED => Mage::helper('banners')->__('Enabled'),
                self::STATUS_DISABLED => Mage::helper('banners')->__('Disabled')
        );
    }

}
