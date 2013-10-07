<?php

/**
 * Optimiseweb Banners Block Adminhtml Banners Edit Tabs
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimise Web Limited
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Block_Adminhtml_Banners_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    /**
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId('banners_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('banners')->__('Banner Information'));
    }

    /**
     *
     * @return type
     */
    protected function _beforeToHtml() {
        $this->addTab('main_section', array(
            'label' => Mage::helper('banners')->__('Banner Information'),
            'title' => Mage::helper('banners')->__('Banner Information'),
            'content' => $this->getLayout()->createBlock('banners/adminhtml_banners_edit_tab_main')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}