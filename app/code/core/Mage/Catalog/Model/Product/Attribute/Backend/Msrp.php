<?php
/**
 * OpenMage
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available at https://opensource.org/license/osl-3-0-php
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @copyright  Copyright (c) 2020 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Product attribute for `Apply MAP` enable/disable option
 *
 * @category   Mage
 * @package    Mage_Catalog
 */
class Mage_Catalog_Model_Product_Attribute_Backend_Msrp extends Mage_Catalog_Model_Product_Attribute_Backend_Boolean
{
    /**
     * Disable MAP if it's bundle with dynamic price type
     *
     * @param Mage_Catalog_Model_Product $product
     * @return Mage_Catalog_Model_Product_Attribute_Backend_Boolean|Mage_Catalog_Model_Product_Attribute_Backend_Msrp
     */
    public function beforeSave($product)
    {
        if (!($product instanceof Mage_Catalog_Model_Product)
            || $product->getTypeId() != Mage_Catalog_Model_Product_Type::TYPE_BUNDLE
            || $product->getPriceType() != Mage_Bundle_Model_Product_Price::PRICE_TYPE_DYNAMIC
        ) {
            return parent::beforeSave($product);
        }

        parent::beforeSave($product);
        $attributeCode = $this->getAttribute()->getName();
        $value = $product->getData($attributeCode);
        if (empty($value)) {
            $value = Mage::helper('catalog')->isMsrpApplyToAll();
        }
        if ($value) {
            $product->setData($attributeCode, 0);
        }
        return $this;
    }
}
