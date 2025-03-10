<?php
/**
 * OpenMage
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available at https://opensource.org/license/osl-3-0-php
 *
 * @category   Mage
 * @package    Mage_Bundle
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @copyright  Copyright (c) 2020-2022 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog bundle product info block
 *
 * @category   Mage
 * @package    Mage_Bundle
 *
 * @method string getAddToCartUrl(Mage_Catalog_Model_Product $value)
 */
class Mage_Bundle_Block_Catalog_Product_View_Type_Bundle extends Mage_Catalog_Block_Product_View_Abstract
{
    /**
     * Renderers for bundle product options
     *
     * @var array
     */
    protected $_optionRenderers = [];

    /**
     * Bundle product options
     *
     * @var array
     */
    protected $_options         = null;

    /**
     * Default MAP renderer type
     *
     * @var string
     */
    protected $_mapRenderer = 'msrp_item';

    /**
     * Tier price template
     *
     * @var string
     */
    protected $_tierPriceDefaultTemplate  = 'bundle/catalog/product/view/option_tierprices.phtml';

    /**
     * Return an array of bundle product options
     *
     * @return array
     */
    public function getOptions()
    {
        if (!$this->_options) {
            $product = $this->getProduct();
            /** @var Mage_Bundle_Model_Product_Type $typeInstance */
            $typeInstance = $product->getTypeInstance(true);
            $typeInstance->setStoreFilter($product->getStoreId(), $product);

            $optionCollection = $typeInstance->getOptionsCollection($product);

            $selectionCollection = $typeInstance->getSelectionsCollection(
                $typeInstance->getOptionsIds($product),
                $product
            );

            $this->_options = $optionCollection->appendSelections(
                $selectionCollection,
                false,
                Mage::helper('catalog/product')->getSkipSaleableCheck()
            );
        }

        return $this->_options;
    }

    /**
     * Whether the bundle product has any option
     *
     * @return bool
     */
    public function hasOptions()
    {
        $this->getOptions();
        if (empty($this->_options) || !$this->getProduct()->isSalable()) {
            return false;
        }
        return true;
    }

    /**
     * Returns JSON encoded config to be used in JS scripts
     *
     * @return string
     */
    public function getJsonConfig()
    {
        Mage::app()->getLocale()->getJsPriceFormat();
        $optionsArray = $this->getOptions();
        $options      = [];
        $selected     = [];
        $currentProduct = $this->getProduct();
        /** @var Mage_Core_Helper_Data $coreHelper */
        $coreHelper   = Mage::helper('core');
        /** @var Mage_Bundle_Model_Product_Price $bundlePriceModel */
        $bundlePriceModel = Mage::getModel('bundle/product_price');

        $preConfiguredFlag = $currentProduct->hasPreconfiguredValues();
        if ($preConfiguredFlag) {
            $preConfiguredValues = $currentProduct->getPreconfiguredValues();
            $defaultValues       = [];
        }

        $position = 0;
        foreach ($optionsArray as $_option) {
            /** @var Mage_Bundle_Model_Option $_option */
            if (!$_option->getSelections()) {
                continue;
            }

            $optionId = $_option->getId();
            $option = [
                'selections' => [],
                'title'      => $_option->getTitle(),
                'isMulti'    => in_array($_option->getType(), ['multi', 'checkbox']),
                'position'   => $position++
            ];

            $selectionCount = count($_option->getSelections());
            /** @var Mage_Tax_Helper_Data $taxHelper */
            $taxHelper = Mage::helper('tax');
            foreach ($_option->getSelections() as $_selection) {
                $selectionId = $_selection->getSelectionId();
                $_qty = !($_selection->getSelectionQty() * 1) ? '1' : $_selection->getSelectionQty() * 1;
                // recalculate currency
                $tierPrices = $_selection->getTierPrice();
                foreach ($tierPrices as &$tierPriceInfo) {
                    $tierPriceInfo['price'] =
                        $bundlePriceModel->getLowestPrice($currentProduct, $tierPriceInfo['price']);
                    $tierPriceInfo['website_price'] =
                        $bundlePriceModel->getLowestPrice($currentProduct, $tierPriceInfo['website_price']);
                    $tierPriceInfo['price'] = $coreHelper::currency($tierPriceInfo['price'], false, false);
                    $tierPriceInfo['priceInclTax'] = $taxHelper->getPrice(
                        $_selection,
                        $tierPriceInfo['price'],
                        true,
                        null,
                        null,
                        null,
                        null,
                        null,
                        false
                    );
                    $tierPriceInfo['priceExclTax'] = $taxHelper->getPrice(
                        $_selection,
                        $tierPriceInfo['price'],
                        false,
                        null,
                        null,
                        null,
                        null,
                        null,
                        false
                    );
                }
                unset($tierPriceInfo); // break the reference with the last element

                $itemPrice = $bundlePriceModel->getSelectionFinalTotalPrice(
                    $currentProduct,
                    $_selection,
                    $currentProduct->getQty(),
                    $_selection->getQty(),
                    false,
                    false
                );

                $canApplyMAP = false;

                /** @var Mage_Tax_Helper_Data $taxHelper */
                $taxHelper = Mage::helper('tax');

                $_priceInclTax = $taxHelper->getPrice(
                    $_selection,
                    $itemPrice,
                    true,
                    null,
                    null,
                    null,
                    null,
                    null,
                    false
                );
                $_priceExclTax = $taxHelper->getPrice(
                    $_selection,
                    $itemPrice,
                    false,
                    null,
                    null,
                    null,
                    null,
                    null,
                    false
                );

                if ($currentProduct->getPriceType() == Mage_Bundle_Model_Product_Price::PRICE_TYPE_FIXED) {
                    $_priceInclTax = $taxHelper->getPrice(
                        $currentProduct,
                        $itemPrice,
                        true,
                        null,
                        null,
                        null,
                        null,
                        null,
                        false
                    );
                    $_priceExclTax = $taxHelper->getPrice(
                        $currentProduct,
                        $itemPrice,
                        false,
                        null,
                        null,
                        null,
                        null,
                        null,
                        false
                    );
                }

                $selection = [
                    'qty'              => $_qty,
                    'customQty'        => $_selection->getSelectionCanChangeQty(),
                    'price'            => $coreHelper::currency($_selection->getFinalPrice(), false, false),
                    'priceInclTax'     => $coreHelper::currency($_priceInclTax, false, false),
                    'priceExclTax'     => $coreHelper::currency($_priceExclTax, false, false),
                    'priceValue'       => $coreHelper::currency($_selection->getSelectionPriceValue(), false, false),
                    'priceType'        => $_selection->getSelectionPriceType(),
                    'tierPrice'        => $tierPrices,
                    'name'             => $_selection->getName(),
                    'plusDisposition'  => 0,
                    'minusDisposition' => 0,
                    'canApplyMAP'      => $canApplyMAP,
                    'tierPriceHtml'    => $this->getTierPriceHtml($_selection, $currentProduct),
                ];

                $responseObject = new Varien_Object();
                $args = ['response_object' => $responseObject, 'selection' => $_selection];
                Mage::dispatchEvent('bundle_product_view_config', $args);
                if (is_array($responseObject->getAdditionalOptions())) {
                    foreach ($responseObject->getAdditionalOptions() as $o => $v) {
                        $selection[$o] = $v;
                    }
                }
                $option['selections'][$selectionId] = $selection;

                if (($_selection->getIsDefault() || ($selectionCount == 1 && $_option->getRequired()))
                    && $_selection->isSalable()
                ) {
                    $selected[$optionId][] = $selectionId;
                }
            }
            $options[$optionId] = $option;

            // Add attribute default value (if set)
            if ($preConfiguredFlag) {
                $configValue = $preConfiguredValues->getData('bundle_option/' . $optionId);
                if ($configValue) {
                    $defaultValues[$optionId] = $configValue;
                }
            }
        }

        $config = [
            'options'       => $options,
            'selected'      => $selected,
            'bundleId'      => $currentProduct->getId(),
            'priceFormat'   => Mage::app()->getLocale()->getJsPriceFormat(),
            'basePrice'     => $coreHelper::currency($currentProduct->getPrice(), false, false),
            'priceType'     => $currentProduct->getPriceType(),
            'specialPrice'  => $currentProduct->getSpecialPrice(),
            'includeTax'    => Mage::helper('tax')->priceIncludesTax() ? 'true' : 'false',
            'isFixedPrice'  => $this->getProduct()->getPriceType() == Mage_Bundle_Model_Product_Price::PRICE_TYPE_FIXED,
            'isMAPAppliedDirectly' => Mage::helper('catalog')->canApplyMsrp($this->getProduct(), null, false)
        ];

        if ($preConfiguredFlag && !empty($defaultValues)) {
            $config['defaultValues'] = $defaultValues;
        }

        return $coreHelper->jsonEncode($config);
    }

    /**
     * Add renderer for an option type, e.g., select, radio button, etc.
     *
     * @param string $type
     * @param string $block
     */
    public function addRenderer($type, $block)
    {
        $this->_optionRenderers[$type] = $block;
    }

    /**
     * Get option html
     *
     * @param Mage_Catalog_Model_Product_Option $option
     * @return string
     */
    public function getOptionHtml($option)
    {
        if (!isset($this->_optionRenderers[$option->getType()])) {
            return $this->__('There is no defined renderer for "%s" option type.', $option->getType());
        }
        return $this->getLayout()->createBlock($this->_optionRenderers[$option->getType()])
            ->setOption($option)->toHtml();
    }
}
