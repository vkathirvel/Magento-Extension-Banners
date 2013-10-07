<?php

/**
 * Optimiseweb Banners Block Adminhtml Banners
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimise Web Limited
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Block_Adminhtml_Banners extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_banners';
        $this->_blockGroup = 'banners';
        $this->_headerText = Mage::helper('banners')->__('Banner Manager');
        $this->_addButtonLabel = Mage::helper('banners')->__('Add Banner');
        parent::__construct();
    }

}