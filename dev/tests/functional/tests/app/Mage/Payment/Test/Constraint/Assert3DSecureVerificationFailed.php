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

namespace Mage\Payment\Test\Constraint;

use Magento\Mtf\Constraint\AbstractConstraint;
use Mage\Checkout\Test\Page\CheckoutOnepage;

/**
 * Assert that 3D secure verification failed.
 */
class Assert3DSecureVerificationFailed extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Verification fail message.
     */
    const VERIFICATION_FAIL_MESSAGE = 'Verification Failed';

    /**
     * Assert that 3D secure verification failed.
     *
     * @param CheckoutOnepage $checkoutOnepage
     * @return void
     */
    public function processAssert(CheckoutOnepage $checkoutOnepage)
    {
        \PHPUnit_Framework_Assert::assertContains(
            self::VERIFICATION_FAIL_MESSAGE,
            $checkoutOnepage->getReviewBlock()->getVerificationResponseText()
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return '3D secure verification failed.';
    }
}
