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

namespace Mage\SalesRule\Test\Constraint;

use Mage\SalesRule\Test\Page\Adminhtml\PromoQuoteIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert that success message is displayed after sales rule delete.
 */
class AssertCartPriceRuleSuccessDeleteMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Success Sales Rule delete message.
     */
    const SUCCESS_DELETE_MESSAGE = 'The rule has been deleted.';

    /**
     * Assert that success message is displayed after sales rule delete.
     *
     * @param PromoQuoteIndex $promoQuoteIndex
     * @return void
     */
    public function processAssert(PromoQuoteIndex $promoQuoteIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_DELETE_MESSAGE,
            $promoQuoteIndex->getMessagesBlock()->getSuccessMessages()
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Sales rule success delete message is present.';
    }
}
