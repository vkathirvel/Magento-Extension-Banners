<?php

/**
 * Optimiseweb Banners Block Banners
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Block_Banners extends Mage_Core_Block_Template
{

    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('optimiseweb/banners/template.phtml');
    }

    /**
     *
     * @return type
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     *
     * @return type
     */
    public function getBanners()
    {
        if (!$this->hasData('banners')) {
            $this->setData('banners', Mage::registry('banners'));
        }
        return $this->getData('banners');
    }

    /**
     * Build a generic DIV HTML
     *
     * @param type $identifier
     * @param type $containerID
     * @param type $containerClass
     * @param type $itemClass
     * @param type $imageClass
     * @param type $linkClass
     * @param type $imageLinkContainerClass
     * @param type $headingClass
     * @param type $contentClass
     * @return type
     */
    public function getGenericDivHtml($identifier, $containerID = NULL, $containerClass = NULL, $itemClass = NULL, $imageClass = NULL, $linkClass = NULL, $imageLinkContainerClass = NULL, $headingClass = NULL, $contentClass = NULL)
    {
        return Mage::helper('banners')->getGenericDivHtml($identifier, $containerID, $containerClass, $itemClass, $imageClass, $linkClass, $imageLinkContainerClass, $headingClass, $contentClass);
    }

    /**
     *
     * @param type $identifier
     * @param type $containerId
     * @param type $containerClass
     * @return type
     */
    public function getSlideJsHtml($identifier, $containerId = NULL, $containerClass = NULL)
    {
        return Mage::helper('banners')->getSlideJsHtml($identifier, $containerId, $containerClass);
    }

    /**
     *
     * @param type $identifier
     * @param type $containerId
     * @param type $containerClass
     * @param type $liClass
     * @return type
     */
    public function getJcarouselHtml($identifier, $containerId = NULL, $containerClass = NULL, $liClass = NULL)
    {
        return Mage::helper('banners')->getJcarouselHtml($identifier, $containerId, $containerClass, $liClass);
    }

    /**
     *
     * @param type $identifier
     * @param type $containerClass
     * @return type
     */
    public function getFlexSliderHtml($identifier, $containerClass = NULL)
    {
        return Mage::helper('banners')->getFlexSliderHtml($identifier, $containerClass);
    }

    /**
     *
     * @param type $identifier
     * @param type $containerClass
     * @return type
     */
    public function getBxSliderHtml($identifier, $sliderClass = NULL, $containerClass = NULL)
    {
        return Mage::helper('banners')->getBxSliderHtml($identifier, $sliderClass, $containerClass);
    }

}
