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

namespace Mage\Sales\Test\Constraint;

use Mage\Sales\Test\Page\SalesGuestPrint;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert that Grand Total price was printed correctly on sales guest print page.
 */
class AssertSalesPrintOrderGrandTotal extends AbstractConstraint
{
    /**
     * Assert that Grand Total price was printed correctly on sales guest print page.
     *
     * @param SalesGuestPrint $salesGuestPrint
     * @param string $grandTotal
     * @return void
     */
    public function processAssert(SalesGuestPrint $salesGuestPrint, $grandTotal)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $grandTotal,
            $salesGuestPrint->getViewBlock()->getGrandTotal(),
            "Grand total was printed incorrectly."
        );
    }

    /**
     * Returns a string representation of successful assertion.
     *
     * @return string
     */
    public function toString()
    {
        return "Grand total was printed correctly.";
    }
}
