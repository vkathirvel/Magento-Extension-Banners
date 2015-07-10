<?php

/**
 * Optimiseweb Banners Block Adminhtml Banners Grid
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Block_Adminhtml_Banners_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('bannersGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('banners/banners')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('banner_id', array(
                'header' => Mage::helper('banners')->__('ID'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'banner_id',
        ));

        $this->addColumn('description', array(
                'header' => Mage::helper('banners')->__('Friendly Description'),
                'align' => 'left',
                'index' => 'description',
        ));

        $bannerGroupsAsOptionsArray = Mage::helper('banners')->getBannerGroupsAsOptionsArray();

        $this->addColumn('identifier', array(
                'header' => Mage::helper('banners')->__('Banner Group'),
                'align' => 'left',
                'index' => 'identifier',
                'type' => 'options',
                'options' => $bannerGroupsAsOptionsArray,
        ));

        $this->addColumn('image', array(
                'header' => Mage::helper('banners')->__('Image File'),
                'align' => 'left',
                'type' => 'image',
                'index' => 'image',
                'width' => '85px',
                'renderer' => 'Optimiseweb_Banners_Block_Adminhtml_Banners_Grid_Renderer_Image',
                'filter' => false,
                'sortable' => false,
        ));

        $this->addColumn('url', array(
                'header' => Mage::helper('banners')->__('Destination URL'),
                'align' => 'left',
                'index' => 'url',
        ));

        $this->addColumn('banner_order', array(
                'header' => Mage::helper('banners')->__('Sort Order'),
                'align' => 'left',
                'index' => 'banner_order',
                'width' => '25px',
        ));

        $this->addColumn('start_date', array(
                'header' => Mage::helper('banners')->__('Start Date'),
                'align' => 'center',
                'type' => 'datetime',
                'index' => 'start_date',
                'width' => '100px',
        ));

        $this->addColumn('end_date', array(
                'header' => Mage::helper('banners')->__('End Date'),
                'align' => 'center',
                'type' => 'datetime',
                'index' => 'end_date',
                'width' => '100px',
        ));

        $this->addColumn('status', array(
                'header' => Mage::helper('banners')->__('Status'),
                'align' => 'left',
                'width' => '80px',
                'index' => 'status',
                'type' => 'options',
                'options' => array(
                        1 => 'Enabled',
                        2 => 'Disabled',
                ),
        ));

        $this->addColumn('action', array(
                'header' => Mage::helper('banners')->__('Action'),
                'width' => '100',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                        array(
                                'caption' => Mage::helper('banners')->__('Edit'),
                                'url' => array('base' => '*/*/edit'),
                                'field' => 'id'
                        )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('banners')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('banners')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('banner_id');
        $this->getMassactionBlock()->setFormFieldName('banners');

        $this->getMassactionBlock()->addItem('delete', array(
                'label' => Mage::helper('banners')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('banners')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('banners/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
                'label' => Mage::helper('banners')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                        'visibility' => array(
                                'name' => 'status',
                                'type' => 'select',
                                'class' => 'required-entry',
                                'label' => Mage::helper('banners')->__('Status'),
                                'values' => $statuses
                        )
                )
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
