<?php

/**
 * Optimiseweb Banners Helper Data
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Get config
     *
     * @param type $field
     * @return type
     */
    public function getConfig($field)
    {
        return Mage::getStoreConfig('optimisewebbanners/' . $field);
    }

    /**
     * Returns the Banners as an array
     *
     * @param type $identifier
     * @return boolean
     */
    public function getBanners($identifier)
    {
        $banners = Mage::getModel('banners/banners')->getCollection()
            ->addFieldToFilter('status', '1')
            ->addFieldToFilter('identifier', $identifier)
            ->addOrder('banner_order', 'asc');
        $bannerArray = array();
        $x = 0;
        foreach ($banners as $banner) {
            if ($this->_filterStore($banner->getData('store_ids')) AND $this->_checkDateRange($banner->getData('start_date'), $banner->getData('end_date'))) {
                $bannerArray[$x] = $banner->getData();
                if ($banner->getData('image'))
                    $bannerArray[$x]['image'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $banner->getData('image');
                if ($banner->getData('image_retina'))
                    $bannerArray[$x]['image_retina'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $banner->getData('image_retina');
                if ($banner->getData('url'))
                    $bannerArray[$x]['url'] = $this->_destinationUrlCheck($banner->getData('url'));
                if ($banner->getData('title'))
                    $bannerArray[$x]['title'] = htmlentities($banner->getData('title'));
                if ($banner->getData('alt'))
                    $bannerArray[$x]['alt'] = htmlentities($banner->getData('alt'));
            }
            $x++;
        }
        if (count($bannerArray) > 0) {
            return $bannerArray;
        } else {
            return FALSE;
        }
    }

    /**
     * Check if today is within the given date range
     *
     * @param type $startDate
     * @param type $endDate
     * @return boolean
     */
    public function _checkDateRange($startDate, $endDate)
    {
        if ($startDate) {
            
        } else {
            $startDate = '2000-01-01 00:00:00';
        }
        if ($endDate) {
            
        } else {
            /* $endDate = '2999-12-31 00:00:00'; */
            $endDate = date('Y-m-d H:i:s', PHP_INT_MAX);
        }

        $today = strtotime(date('Y-m-d'));
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        if (($today >= $startDate) AND ($today <= $endDate)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Check if the banner can be shown within the current store
     *
     * @param type $storeIds
     * @return boolean
     */
    protected function _filterStore($storeIds)
    {
        $storeIdData = explode(',', $storeIds);

        if (in_array('0', $storeIdData) OR in_array(Mage::app()->getStore()->getId(), $storeIdData)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Check for the protocol and add the store url if no protocol provided
     *
     * @param string $url
     * @return string
     */
    protected function _destinationUrlCheck($url)
    {
        $count = 0;
        $protocols = array('http://', 'https://', 'ftp://', 'mailto:');
        foreach ($protocols as $protocol) {
            if (substr($url, 0, strlen($protocol)) !== $protocol)
                $count++;
        }
        if (count($protocols) == $count) {
            if ($url == "baseurl") {
                $url = Mage::getUrl();
            } else {
                $url = Mage::getUrl() . $url;
            }
        }
        return $url;
    }

    /**
     * Get All Banner Group Names as Options Array
     *
     * @return type
     */
    public function getBannerGroupsAsOptionsArray()
    {
        $banners = Mage::getModel('banners/banners')->getCollection();
        $bannerGroups = array();
        foreach ($banners as $banner) {
            $bannerGroups[$banner->identifier] = $banner->identifier;
        }
        return $bannerGroups;
    }

    /**
     * Generates the divs required for a generic display of banners
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
     * @return string|boolean
     */
    public function getGenericDivHtml($identifier, $containerID = NULL, $containerClass = NULL, $itemClass = NULL, $imageClass = NULL, $linkClass = NULL, $imageLinkContainerClass = NULL, $headingClass = NULL, $contentClass = NULL)
    {
        $banners = $this->getBanners($identifier);
        if ($banners) {
            /* Start HTML */
            $html = '';
            /* DIV Container ID */
            if (!empty($containerID)) {
                $html .= '<div id="' . $containerID . '">';
            }
            /* DIV Container Class */
            $html .= '<div';
            if (!empty($containerClass)) {
                $html .= ' class="' . $containerClass . '"';
            }
            $html .= '>';
            /* Start Banners */
            foreach ($banners as $banner) {
                /* DIV Banner Item */
                $html .= '<div';
                if (!empty($itemClass)) {
                    $html .= ' class="' . $itemClass . '"';
                }
                $html .= '>';
                /* DIV Banner Heading */
                if ($banner['heading']) {
                    $html .= '<div';
                    if (!empty($headingClass)) {
                        $html .= ' class="' . $headingClass . '"';
                    }
                    $html .= '>';
                    $html .= $banner['heading'] . '</div>';
                }
                /* DIV Banner Content */
                if ($banner['banner_content']) {
                    $html .= '<div';
                    if (!empty($contentClass)) {
                        $html .= ' class="' . $contentClass . '"';
                    }
                    $html .= '>';
                    $html .= $banner['banner_content'] . '</div>';
                }
                /* DIV Image and Link Container */
                $html .= '<div';
                if (!empty($imageLinkContainerClass)) {
                    $html .= ' class="' . $imageLinkContainerClass . '"';
                }
                $html .= '>';
                /* A Link */
                if ($banner['url']) {
                    $html .= '<a href="' . $banner['url'] . '"';
                    if ($banner['title']) {
                        $html .= ' title="' . $banner['title'] . '" ';
                    }
                    if ($banner['external'] == 1) {
                        $html .= ' rel="external" ';
                    }
                    if (!empty($linkClass)) {
                        $html .= ' class="' . $linkClass . '"';
                    }
                    $html .= '>';
                }
                /* IMG Image */
                $html .= '<img src="' . $banner['image'] . '"';
                if ($banner['image_retina'] AND $this->getConfig('retina/enabled')) {
                    $dataAttribute = 'data-at2x';
                    if ($this->getConfig('retina/dataattribute')) {
                        $dataAttribute = $this->getConfig('retina/dataattribute');
                    }
                    $html .= ' ' . $dataAttribute . '="' . $banner['image_retina'] . '"';
                }
                if ($banner['alt']) {
                    $html .= ' alt="' . $banner['alt'] . '"';
                }
                if (!empty($imageClass)) {
                    $html .= ' class="' . $imageClass . '"';
                }
                $html .= ' />';
                /* Close A Link */
                if ($banner['url']) {
                    $html .= '</a>';
                }
                /* Close DIV Image and Link Container */
                $html .= '</div>';
                /* Close DIV Banner Item */
                $html .= '</div>';
            }
            /* Close DIV Container Class */
            $html .= '</div>';
            /* Close DIV Container ID */
            if (!empty($containerID)) {
                $html .= '</div>';
            }

            return $html;
        }
        return FALSE;
    }

    /**
     * Generates the divs required for Slide JS
     *
     * @param type $identifier
     * @param type $containerId
     * @param type $containerClass
     * @return string|boolean
     */
    public function getSlideJsHtml($identifier, $containerId = NULL, $containerClass = NULL)
    {
        $banners = $this->getBanners($identifier);
        if ($banners) {
            if (empty($containerId))
                $containerId = 'slides';
            if (empty($containerClass))
                $containerClass = 'slides_container';

            $html = '';
            $html .= '<div id="' . $containerId . '">';
            $html .= '<div class="' . $containerClass . '">';
            foreach ($banners as $banner) {
                $html .= '<div>';
                if ($banner['heading']) {
                    $html .= '<div class="slide-heading">' . $banner['heading'] . '</div>';
                }
                if ($banner['banner_content']) {
                    $html .= '<div class="slide-description">' . $banner['banner_content'] . '</div>';
                }
                $html .= '<div class="slide-image">';
                if ($banner['url']) {
                    $html .= '<a href="' . $banner['url'] . '"';
                    if ($banner['title']) {
                        $html .= ' title="' . $banner['title'] . '" ';
                    }
                    if ($banner['external'] == 1) {
                        $html .= ' rel="external" ';
                    }
                    $html .= '>';
                }
                $html .= '<img src="' . $banner['image'] . '"';
                if ($banner['image_retina'] AND $this->getConfig('retina/enabled')) {
                    $dataAttribute = 'data-at2x';
                    if ($this->getConfig('retina/dataattribute')) {
                        $dataAttribute = $this->getConfig('retina/dataattribute');
                    }
                    $html .= ' ' . $dataAttribute . '="' . $banner['image_retina'] . '"';
                }
                if ($banner['alt']) {
                    $html .= ' alt="' . $banner['alt'] . '"';
                }
                $html .= ' />';
                if ($banner['url']) {
                    $html .= '</a>';
                }
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }
        return FALSE;
    }

    /**
     * Generates the divs required for JCarousel Plugin
     *
     * @param type $identifier
     * @param type $containerId
     * @param type $containerClass
     * @param type $liClass
     * @return string|boolean
     */
    public function getJcarouselHtml($identifier, $containerId = NULL, $containerClass = NULL, $liClass = NULL)
    {
        $banners = $this->getBanners($identifier);
        if ($banners) {
            if (empty($containerId))
                $containerId = 'carousel-id';
            if (empty($containerClass))
                $containerClass = 'carousel-class';
            if (empty($liClass))
                $liClass = 'carousel-li-class';

            $html = '';
            $html .= '<ul id="' . $containerId . '" class="' . $containerClass . '">';
            foreach ($banners as $banner) {
                $html .= '<li class="' . $liClass . '">';
                if ($banner['heading']) {
                    $html .= '<div class="carousel-heading">' . $banner['heading'] . '</div>';
                }
                if ($banner['banner_content']) {
                    $html .= '<div class="carousel-description">' . $banner['banner_content'] . '</div>';
                }
                $html .= '<div class="carousel-image">';
                if ($banner['url']) {
                    $html .= '<a href="' . $banner['url'] . '"';
                    if ($banner['title']) {
                        $html .= ' title="' . $banner['title'] . '" ';
                    }
                    if ($banner['external'] == 1) {
                        $html .= ' rel="external" ';
                    }
                    $html .= '>';
                }
                $html .= '<img src="' . $banner['image'] . '"';
                if ($banner['image_retina'] AND $this->getConfig('retina/enabled')) {
                    $dataAttribute = 'data-at2x';
                    if ($this->getConfig('retina/dataattribute')) {
                        $dataAttribute = $this->getConfig('retina/dataattribute');
                    }
                    $html .= ' ' . $dataAttribute . '="' . $banner['image_retina'] . '"';
                }
                if ($banner['alt']) {
                    $html .= ' alt="' . $banner['alt'] . '"';
                }
                $html .= ' />';
                if ($banner['url']) {
                    $html .= '</a>';
                }
                $html .= '</div>';
                $html .= '</li>';
            }
            $html .= '</ul>';

            return $html;
        }
        return FALSE;
    }

    /**
     * Generates the divs required for Flexslider Plugin
     *
     * @param type $identifier
     * @param string $containerClass
     * @return string|boolean
     */
    public function getFlexSliderHtml($identifier, $containerClass = NULL)
    {
        $banners = $this->getBanners($identifier);
        if ($banners) {
            if (empty($containerClass))
                $containerClass = 'flexslider-container';

            $html = '';
            $html .= '<div class="' . $containerClass . ' flexslider">';
            $html .= '<ul class="flexslider-list slides">';
            foreach ($banners as $banner) {
                $html .= '<li class="flexslider-item">';
                if ($banner['heading']) {
                    $html .= '<div class="flexslider-heading">' . $banner['heading'] . '</div>';
                }
                if ($banner['banner_content']) {
                    $html .= '<div class="flexslider-description">' . $banner['banner_content'] . '</div>';
                }
                $html .= '<div class="flexslider-image">';
                if ($banner['url']) {
                    $html .= '<a href="' . $banner['url'] . '"';
                    if ($banner['title']) {
                        $html .= ' title="' . $banner['title'] . '" ';
                    }
                    if ($banner['external'] == 1) {
                        $html .= ' rel="external" ';
                    }
                    $html .= '>';
                }
                $html .= '<img src="' . $banner['image'] . '"';
                if ($banner['image_retina'] AND $this->getConfig('retina/enabled')) {
                    $dataAttribute = 'data-at2x';
                    if ($this->getConfig('retina/dataattribute')) {
                        $dataAttribute = $this->getConfig('retina/dataattribute');
                    }
                    $html .= ' ' . $dataAttribute . '="' . $banner['image_retina'] . '"';
                }
                if ($banner['alt']) {
                    $html .= ' alt="' . $banner['alt'] . '"';
                }
                $html .= ' />';
                if ($banner['url']) {
                    $html .= '</a>';
                }
                $html .= '</div>';
                $html .= '</li>';
            }
            $html .= '</ul>';
            $html .= '</div>';

            return $html;
        }
        return FALSE;
    }

    /**
     * Generates the divs required for BxSlider Plugin
     *
     * @param type $identifier
     * @param string $containerClass
     * @return string|boolean
     */
    public function getBxSliderHtml($identifier, $sliderClass = NULL, $containerClass = NULL)
    {
        $banners = $this->getBanners($identifier);
        if ($banners) {
            if ($containerClass == NULL)
                $containerClass = 'bxslider-container';
            if ($sliderClass == NULL)
                $sliderClass = 'bxslider';

            $html = '';
            $html .= '<div class="' . $containerClass . '">';
            $html .= '<ul class="' . $sliderClass . '">';
            foreach ($banners as $banner) {
                $html .= '<li class="bxslider-item">';
                if ($banner['heading']) {
                    $html .= '<div class="bxslider-heading">' . $banner['heading'] . '</div>';
                }
                if ($banner['banner_content']) {
                    $html .= '<div class="bxslider-description">' . $banner['banner_content'] . '</div>';
                }
                $html .= '<div class="bxslider-image">';
                if ($banner['url']) {
                    $html .= '<a href="' . $banner['url'] . '"';
                    if ($banner['title']) {
                        $html .= ' title="' . $banner['title'] . '" ';
                    }
                    if ($banner['external'] == 1) {
                        $html .= ' rel="external" ';
                    }
                    $html .= '>';
                }
                $html .= '<img src="' . $banner['image'] . '"';
                if ($banner['image_retina'] AND $this->getConfig('retina/enabled')) {
                    $dataAttribute = 'data-at2x';
                    if ($this->getConfig('retina/dataattribute')) {
                        $dataAttribute = $this->getConfig('retina/dataattribute');
                    }
                    $html .= ' ' . $dataAttribute . '="' . $banner['image_retina'] . '"';
                }
                if ($banner['alt']) {
                    $html .= ' alt="' . $banner['alt'] . '"';
                }
                $html .= ' />';
                if ($banner['url']) {
                    $html .= '</a>';
                }
                $html .= '</div>';
                $html .= '</li>';
            }
            $html .= '</ul>';
            $html .= '</div>';

            return $html;
        }
        return FALSE;
    }

}
