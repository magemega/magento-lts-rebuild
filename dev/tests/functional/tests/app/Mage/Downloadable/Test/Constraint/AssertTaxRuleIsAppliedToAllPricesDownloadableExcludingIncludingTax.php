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

namespace Mage\Downloadable\Test\Constraint;

use Mage\Tax\Test\Constraint\AssertTaxRuleIsAppliedToAllPricesExcludingIncludingTax;

/**
 * Checks that prices excl and incl tax on category, product and cart pages are equal to specified in dataset.
 */
class AssertTaxRuleIsAppliedToAllPricesDownloadableExcludingIncludingTax
    extends AssertTaxRuleIsAppliedToAllPricesExcludingIncludingTax
{
    /**
     * Verify fields for assert.
     *
     * @var array
     */
    protected $verifyFields = [
        'subtotal_excl_tax',
        'subtotal_incl_tax',
        'discount',
        'grand_total_excl_tax',
        'grand_total_incl_tax',
        'tax'
    ];
}
