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

namespace Mage\Customer\Test\Constraint;

use Mage\Customer\Test\Page\CustomerAccountCreate;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert that error message is displayed after creation existing customer.
 */
class AssertCustomerFailRegisterMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Fail message.
     */
    const FAIL_MESSAGE = "There is already an account with this email address.";

    /**
     * Assert that error message is displayed after creation existing customer.
     *
     * @param CustomerAccountCreate $registerPage
     * @return void
     */
    public function processAssert(CustomerAccountCreate $registerPage)
    {
        \PHPUnit_Framework_Assert::assertContains(
            self::FAIL_MESSAGE,
            $registerPage->getMessagesBlock()->getErrorMessages(),
            "Actual error message doesn't match expected error message."
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Error message is displayed after creation existing customer.';
    }
}
