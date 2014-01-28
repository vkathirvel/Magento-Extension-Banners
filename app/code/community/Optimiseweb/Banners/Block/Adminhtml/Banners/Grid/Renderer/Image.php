<?php

/**
 * Optimiseweb Banners Block Adminhtml Banners Grid Renderer Image
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Block_Adminhtml_Banners_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    /**
     *
     * @param Varien_Object $row
     * @return type
     */
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }

    /**
     *
     * @param Varien_Object $row
     * @return string
     */
    protected function _getValue(Varien_Object $row)
    {
        $out = 'No Image';
        $val = $row->getData($this->getColumn()->getIndex());
        $val = str_replace("no_selection", "", $val);
        if (!empty($val)) {
            $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $val;
            $out = "<a href=" . $url . " target='_blank'><img src=" . $url . " width='75px'/></a>";
        }
        return $out;
    }

}
