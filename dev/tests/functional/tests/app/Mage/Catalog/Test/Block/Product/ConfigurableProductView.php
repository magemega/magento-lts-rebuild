<?php
/**
 * OpenMage
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available at https://opensource.org/license/osl-3-0-php
 *
 * @category   Tests
 * @package    Tests_Functional
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Mage\Catalog\Test\Block\Product;

use Mage\Catalog\Test\Block\Product\View\ConfigurableOptions;
use Mage\Catalog\Test\Fixture\ConfigurableProduct;
use Magento\Mtf\Fixture\InjectableFixture;

/**
 * Product view block on frontend page.
 */
class ConfigurableProductView extends View
{
    /**
     * Get configurable options block.
     *
     * @return ConfigurableOptions
     */
    public function getConfigurableOptionsBlock()
    {
        return $this->blockFactory->create(
            'Mage\Catalog\Test\Block\Product\View\ConfigurableOptions',
            ['element' => $this->_rootElement]
        );
    }

    /**
     * Fill in the option specified for the product.
     *
     * @param InjectableFixture $product
     * @return void
     */
    public function fillOptions(InjectableFixture $product)
    {
        /** @var ConfigurableProduct $product */
        $attributesData = $product->getConfigurableOptions()['attributes_data'];
        $checkoutData = $product->getCheckoutData();

        // Prepare attribute data
        foreach ($attributesData as $attributeKey => $attribute) {
            $attributesData[$attributeKey] = [
                'type' => $attribute['frontend_input'],
                'title' => $attribute['frontend_label'],
                'options' => [],
            ];

            foreach ($attribute['options'] as $optionKey => $option) {
                $attributesData[$attributeKey]['options'][$optionKey] = [
                    'title' => $option['label'],
                ];
            }
            $attributesData[$attributeKey]['options'] = array_values($attributesData[$attributeKey]['options']);
        }
        $attributesData = array_values($attributesData);

        $configurableCheckoutData = isset($checkoutData['options']['configurable_options'])
            ? $checkoutData['options']['configurable_options']
            : [];
        $checkoutOptionsData = $this->prepareCheckoutData($attributesData, $configurableCheckoutData);
        $this->getConfigurableOptionsBlock()->fillOptions($checkoutOptionsData);
    }

    /**
     * Return product options.
     *
     * @param InjectableFixture $product [optional]
     * @return array
     */
    public function getOptions(InjectableFixture $product = null)
    {
        $options = ['configurable_options' => $this->getConfigurableOptionsBlock()->getOptions($product)];
        $options += parent::getOptions($product);

        return $options;
    }

    /**
     * Get text of Stock Availability control.
     *
     * @return string
     */
    public function getConfigurableStockAvailability()
    {
        return strtolower($this->_rootElement->find($this->stockAvailability)->getText());
    }
}
