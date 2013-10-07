<?php

/**
 * Optimiseweb Banners Block Adminhtml Banners Edit Form
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimise Web Limited
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Block_Adminhtml_Banners_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     *
     * @return type
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
                )
        );

        $form->setUseContainer(true);

        $this->setForm($form);

        return parent::_prepareForm();
    }

}