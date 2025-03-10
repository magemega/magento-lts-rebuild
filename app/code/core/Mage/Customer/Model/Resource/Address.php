<?php
/**
 * OpenMage
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available at https://opensource.org/license/osl-3-0-php
 *
 * @category   Mage
 * @package    Mage_Customer
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @copyright  Copyright (c) 2019-2022 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Customer address entity resource model
 *
 * @category   Mage
 * @package    Mage_Customer
 */
class Mage_Customer_Model_Resource_Address extends Mage_Eav_Model_Entity_Abstract
{
    protected function _construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('customer_address')->setConnection(
            $resource->getConnection('customer_read'),
            $resource->getConnection('customer_write')
        );
    }

    /**
     * Set default shipping to address
     *
     * @param Varien_Object|Mage_Customer_Model_Address $address
     * @return $this
     */
    protected function _afterSave(Varien_Object $address)
    {
        if ($address->getIsCustomerSaveTransaction()) {
            return $this;
        }
        if ($address->getId() && ($address->getIsDefaultBilling() || $address->getIsDefaultShipping())) {
            $customer = Mage::getModel('customer/customer')
                ->load($address->getCustomerId());

            if ($address->getIsDefaultBilling()) {
                $customer->setDefaultBilling($address->getId());
            }
            if ($address->getIsDefaultShipping()) {
                $customer->setDefaultShipping($address->getId());
            }
            $customer->save();
        }
        return $this;
    }

    /**
     * Return customer id
     * @deprecated
     *
     * @param Mage_Customer_Model_Address $object
     * @return int
     */
    public function getCustomerId($object)
    {
        return $object->getData('customer_id') ? $object->getData('customer_id') : $object->getParentId();
    }

    /**
     * Set customer id
     * @deprecated
     *
     * @param Mage_Customer_Model_Address $object
     * @param int $id
     * @return $this
     */
    public function setCustomerId($object, $id)
    {
        return $this;
    }
}
