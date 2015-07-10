<?php

/**
 * Optimiseweb Banners Model Banners
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Model_Banners extends Mage_Core_Model_Abstract
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
