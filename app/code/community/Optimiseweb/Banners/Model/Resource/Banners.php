<?php

/**
 * Optimiseweb Banners Model Resource Banners
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Model_Resource_Banners extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     *
     */
    public function _construct()
    {
        /* Note that the banner_id refers to the key field in your database table. */
        $this->_init('banners/banners', 'banner_id');
    }

    /**
     * Process data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Optimiseweb_Banners_Model_Resource_Banners
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$this->isValidIdentifier($object)) {
            Mage::throwException(Mage::helper('banners')->__('The Identifier contains capital letters or disallowed symbols.'));
        }
        if ($this->isNumericIdentifier($object)) {
            Mage::throwException(Mage::helper('banners')->__('The Identifier cannot consist only of numbers.'));
        }
        return parent::_beforeSave($object);
    }

    /**
     *  Check whether identifier is numeric
     *
     * @date Wed Mar 26 18:12:28 EET 2008
     *
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     */
    protected function isNumericIdentifier(Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('identifier'));
    }

    /**
     *  Check whether identifier is valid
     *
     *  @param    Mage_Core_Model_Abstract $object
     *  @return   bool
     */
    protected function isValidIdentifier(Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('identifier'));
    }

}
