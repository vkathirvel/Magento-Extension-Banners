<?php

/**
 * Optimiseweb Banners Block Adminhtml Banners Edit Tab Form
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Block_Adminhtml_Banners_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     *
     * @return type
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('banners_data');

        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('banners_form1', array('legend' => Mage::helper('banners')->__('General'), 'class' => 'fieldset-wide'));

        $fieldset->addField('status', 'select', array(
                'label' => Mage::helper('banners')->__('Status'),
                'title' => Mage::helper('banners')->__('Status'),
                'name' => 'status',
                'values' => array(
                        array(
                                'value' => 1,
                                'label' => Mage::helper('banners')->__('Enabled'),
                        ),
                        array(
                                'value' => 2,
                                'label' => Mage::helper('banners')->__('Disabled'),
                        ),
                ),
        ));

        $fieldset->addField('description', 'text', array(
                'label' => Mage::helper('banners')->__('Friendly Description'),
                'title' => Mage::helper('banners')->__('Friendly Description'),
                'required' => true,
                'class' => 'required-entry',
                'name' => 'description',
                'after_element_html' => '<p class="note" style="width:90%;">A friendly name to describe the Banner. The description helps you easily identify your banners in the admin area.</p>',
        ));

        $fieldset->addField('identifier', 'text', array(
                'label' => Mage::helper('banners')->__('Banner Group'),
                'title' => Mage::helper('banners')->__('Banner Group'),
                'required' => true,
                'class' => 'required-entry validate-identifier',
                'name' => 'identifier',
                'after_element_html' => '<p class="note" style="width:90%;">Banner groups might be predetermined. Check with your designer / developer.</p>',
        ));

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset = $form->addFieldset('banners_form6', array('legend' => Mage::helper('banners')->__('Stores'), 'class' => 'fieldset-wide'));

            $fieldset->addField('store_ids', 'multiselect', array(
                    'name' => 'store_ids[]',
                    'label' => Mage::helper('banners')->__('Store View'),
                    'title' => Mage::helper('banners')->__('Store View'),
                    'required' => true,
                    'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_ids', 'hidden', array(
                    'name' => 'store_ids[]',
                    'value' => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreIds(Mage::app()->getStore(true)->getId());
        }

        $fieldset = $form->addFieldset('banners_form2', array('legend' => Mage::helper('banners')->__('Image'), 'class' => 'fieldset-wide'));

        $fieldset->addField('image', 'image', array(
                'label' => Mage::helper('banners')->__('Banner Image'),
                'title' => Mage::helper('banners')->__('Banner Image'),
                'required' => false,
                'name' => 'image',
        ));

        $fieldset->addField('image_retina', 'image', array(
                'label' => Mage::helper('banners')->__('Image for Retina Display'),
                'title' => Mage::helper('banners')->__('Image for Retina Display'),
                'required' => false,
                'name' => 'image_retina',
        ));

        $fieldset->addField('alt', 'text', array(
                'label' => Mage::helper('banners')->__('Image Alt Tag'),
                'title' => Mage::helper('banners')->__('Image Alt Tag'),
                'required' => false,
                'name' => 'alt',
                'after_element_html' => '<p class="note">Alt tags are meant to describe the image.</p>',
        ));

        $fieldset = $form->addFieldset('banners_form3', array('legend' => Mage::helper('banners')->__('Link'), 'class' => 'fieldset-wide'));

        $fieldset->addField('url', 'text', array(
                'label' => Mage::helper('banners')->__('Link Destination URL'),
                'title' => Mage::helper('banners')->__('Link Destination URL'),
                'required' => false,
                'name' => 'url',
                'after_element_html' => '<p class="note" style="width:90%;">Provide the full URL including the protocol (http:// or https://) like http://www.yourwebsite.com/examplepage.html or leave it as examplepage.html (the store URL will be prepended to the URL provided). To link to the homepage, you can use "baseurl".</p>',
        ));

        $fieldset->addField('title', 'text', array(
                'label' => Mage::helper('banners')->__('Link Title Tag'),
                'title' => Mage::helper('banners')->__('Link Title Tag'),
                'required' => false,
                'name' => 'title',
                'after_element_html' => '<p class="note" style="width:90%;">Title tags on links are meant to describe the link\'s action or destination.</p>',
        ));

        $fieldset->addField('external', 'select', array(
                'label' => Mage::helper('banners')->__('Link Target - External?'),
                'title' => Mage::helper('banners')->__('Link Target - External?'),
                'name' => 'external',
                'after_element_html' => '<p class="note">Do you want the link to open in a new window?</p>',
                'values' => array(
                        array(
                                'value' => 0,
                                'label' => Mage::helper('banners')->__('No'),
                        ),
                        array(
                                'value' => 1,
                                'label' => Mage::helper('banners')->__('Yes'),
                        ),
                ),
        ));

        $fieldset = $form->addFieldset('banners_form4', array('legend' => Mage::helper('banners')->__('Text'), 'class' => 'fieldset-wide'));

        $fieldset->addField('heading', 'text', array(
                'label' => Mage::helper('banners')->__('Banner Heading'),
                'title' => Mage::helper('banners')->__('Banner Heading'),
                'required' => false,
                'name' => 'heading',
                'after_element_html' => '<p class="note">Depends on the Banner design and setup.</p>',
        ));

        $fieldset->addField('banner_content', 'editor', array(
                'name' => 'banner_content',
                'label' => Mage::helper('banners')->__('Banner Content'),
                'title' => Mage::helper('banners')->__('Banner Content'),
                'style' => 'width:500px; height:100px;',
                'wysiwyg' => false,
                'required' => false,
                'after_element_html' => '<p class="note">Depends on the Banner design and setup.</p>',
        ));

        $fieldset = $form->addFieldset('banners_form5', array('legend' => Mage::helper('banners')->__('Dates and Sort Order'), 'class' => 'fieldset-wide'));

        $fieldset->addField('banner_order', 'text', array(
                'label' => Mage::helper('banners')->__('Sort Position'),
                'title' => Mage::helper('banners')->__('Sort Position'),
                'required' => false,
                'class' => 'validate-number',
                'name' => 'banner_order',
                'after_element_html' => '<p class="note" style="width:90%;">Sort position 0 (appears first) and upwards (1 / 2 / 3...).</p>',
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        $fieldset->addField('start_date', 'date', array(
                'label' => Mage::helper('banners')->__('Start Date'),
                'title' => Mage::helper('banners')->__('Start Date'),
                'required' => false,
                'name' => 'start_date',
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'input_format' => $dateFormatIso,
                'format' => $dateFormatIso,
                'after_element_html' => '<p class="note">Depends on the Banner design and setup.</p>',
        ));

        $fieldset->addField('end_date', 'date', array(
                'label' => Mage::helper('banners')->__('End Date'),
                'title' => Mage::helper('banners')->__('End Date'),
                'required' => false,
                'name' => 'end_date',
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'input_format' => $dateFormatIso,
                'format' => $dateFormatIso,
                'after_element_html' => '<p class="note">Depends on the Banner design and setup.</p>',
        ));

        if (Mage::getSingleton('adminhtml/session')->getBannersData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBannersData());
            Mage::getSingleton('adminhtml/session')->setBannersData(null);
        } elseif ($model) {
            $form->setValues(Mage::registry('banners_data')->getData());
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }

}
