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

namespace Mage\Tax\Test\Constraint;

use Magento\Mtf\Fixture\InjectableFixture;

/**
 * Checks that prices excl tax on category, product and cart pages are equal to specified in dataset.
 */
class AssertTaxRuleIsAppliedToAllPricesExcludingTax extends AbstractAssertTaxRuleIsAppliedToAllPrices
{
    /* tags */
    const SEVERITY = 'high';
    /* end tags */

    /**
     * Verify fields for category page.
     *
     * @var array
     */
    protected $categoryPrices = ['category_price'];

    /**
     * Verify fields for product page.
     *
     * @var array
     */
    protected $productPrices = ['product_view_price'];

    /**
     * Verify fields for assert.
     *
     * @var array
     */
    protected $verifyFields = [
        'subtotal',
        'discount',
        'shipping',
        'grand_total',
        'tax'
    ];

    /**
     * Verifiable fields for cart items.
     *
     * @var array
     */
    protected $cartItemVerifiableFields = [
        'cart_item_price',
        'cart_item_subtotal'
    ];

    /**
     * Get prices on category page.
     *
     * @param InjectableFixture $product
     * @return array
     */
    protected function getCategoryPrices(InjectableFixture $product)
    {
        return [
            'category_price' => $this->catalogCategoryView
                    ->getListProductBlock()
                    ->getProductPriceBlock($product->getName())
                    ->getResultPrice()
        ];
    }

    /**
     * Get product view prices.
     *
     * @return array
     */
    protected function getProductPagePrices()
    {
        return ['product_view_price' => $this->catalogProductView->getViewBlock()->getPriceBlock()->getResultPrice()];
    }

    /**
     * Returns string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Prices excl tax on category, product and cart pages are equal to specified in dataset.';
    }
}
