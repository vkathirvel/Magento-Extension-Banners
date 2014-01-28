<?php

/**
 * Optimiseweb Banners Model Mysql4 Banners Collection
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Model_Mysql4_Banners_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    /**
     * 
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('banners/banners');
    }

}
