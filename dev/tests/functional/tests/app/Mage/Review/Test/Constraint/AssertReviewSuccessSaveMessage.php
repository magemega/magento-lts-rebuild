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

namespace Mage\Review\Test\Constraint;

use Mage\Review\Test\Page\Adminhtml\CatalogProductReview;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert that success save message is displayed after review save.
 */
class AssertReviewSuccessSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Text of success save message after review save.
     */
    const SUCCESS_MESSAGE = 'The review has been saved.';

    /**
     * Assert that success save message is displayed after review save.
     *
     * @param CatalogProductReview $reviewIndex
     * @return void
     */
    public function processAssert(CatalogProductReview $reviewIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_MESSAGE,
            $reviewIndex->getMessagesBlock()->getSuccessMessages()
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Review success save message is present.';
    }
}
