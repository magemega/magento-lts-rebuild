<?php
/**
 * OpenMage
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available at https://opensource.org/license/osl-3-0-php
 *
 * @category   Mage
 * @package    Mage_Usa
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @copyright  Copyright (c) 2019-2022 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Backend model for validate shipping carrier ups field
 *
 * @category   Mage
 * @package    Mage_Usa
 */

abstract class Mage_Usa_Model_Shipping_Carrier_Abstract_Backend_Abstract extends Mage_Core_Model_Config_Data
{
    /**
     * Source model to get allowed values
     *
     * @var string
     */
    protected $_sourceModel;

    /**
     * Field name to display in error block
     *
     * @var string
     */
    protected $_nameErrorField;

    /**
     * Set source model to get allowed values
     */
    abstract protected function _setSourceModelData();

    /**
     * Set field name to display in error block
     */
    abstract protected function _setNameErrorField();

    /**
     * Mage_Usa_Model_Shipping_Carrier_Ups_Backend_Abstract constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->_setSourceModelData();
        $this->_setNameErrorField();
    }

    /**
     * Check for presence in array with allow value.
     *
     * @throws Mage_Core_Exception
     * @return $this
     */
    protected function _beforeSave()
    {
        $sourceModel = Mage::getSingleton($this->_sourceModel);
        if (!method_exists($sourceModel, 'toOptionArray')) {
            Mage::throwException(Mage::helper('usa')->__('Method toOptionArray not found in source model.'));
        }
        $hasCorrectValue = false;
        $value = $this->getValue();
        foreach ($sourceModel->toOptionArray() as $allowedValue) {
            if (isset($allowedValue['value']) && $allowedValue['value'] == $value) {
                $hasCorrectValue = true;
                break;
            }
        }
        if (!$hasCorrectValue) {
            Mage::throwException(Mage::helper('usa')->__('Field "%s" has wrong value.', $this->_nameErrorField));
        }
        return $this;
    }
}
