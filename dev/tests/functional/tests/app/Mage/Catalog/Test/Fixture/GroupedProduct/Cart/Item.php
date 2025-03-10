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

namespace Mage\Catalog\Test\Fixture\GroupedProduct\Cart;

use Mage\Catalog\Test\Fixture\GroupedProduct;
use Magento\Mtf\Fixture\FixtureInterface;

/**
 * Data for verify cart item block on checkout page.
 *
 * Data keys:
 *  - product (fixture data for verify)
 */
class Item extends \Mage\Catalog\Test\Fixture\Cart\Item
{
    /**
     * @constructor
     * @param FixtureInterface $product
     */
    public function __construct(FixtureInterface $product)
    {
        /** @var GroupedProduct $product */
        $checkoutData = $product->getCheckoutData();
        $this->data = isset($checkoutData['cartItem']) ? $checkoutData['cartItem'] : [];
        $products = $product->getDataFieldConfig('associated')['source']->getProducts();
        $cartItem = [];
        $associatedProducts = [];

        foreach ($products as $key => $product) {
            $key = 'product_key_' . $key;
            $associatedProducts[$key] = $product;
        }

        // Replace key in checkout data
        foreach ($this->data as $fieldName => $fieldValues) {
            foreach ($fieldValues as $key => $value) {
                $cartItem[$fieldName][$associatedProducts[$key]->getSku()] = $value;
            }
        }

        // Add empty "options" field
        foreach ($associatedProducts as $product) {
            $cartItem['options'][] = [
                'title' => $product->getName(),
                'value' => $cartItem['qty'][$product->getSku()],
            ];
        }

        $this->data = $cartItem;
    }

    /**
     * Persist fixture.
     *
     * @return void
     */
    public function persist()
    {
        //
    }

    /**
     * Return prepared data set.
     *
     * @param string $key [optional]
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getData($key = null)
    {
        return $this->data;
    }

    /**
     * Return data set configuration settings.
     *
     * @return string
     */
    public function getDataConfig()
    {
        //
    }
}
