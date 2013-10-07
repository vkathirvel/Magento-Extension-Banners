<?php

/**
 * Optimiseweb Banners Block Adminhtml Banners Edit
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimise Web Limited
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Block_Adminhtml_Banners_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    /**
     *
     */
    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'banners';
        $this->_controller = 'adminhtml_banners';

        $this->_updateButton('save', 'label', Mage::helper('banners')->__('Save Banner'));
        $this->_updateButton('delete', 'label', Mage::helper('banners')->__('Delete Banner'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     *
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    /**
     *
     * @return type
     */
    public function getHeaderText() {
        if (Mage::registry('banners_data') && Mage::registry('banners_data')->getId()) {
            return Mage::helper('banners')->__('Edit Banner');
        } else {
            return Mage::helper('banners')->__('Add Banner');
        }
    }

}