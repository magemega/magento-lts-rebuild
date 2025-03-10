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

namespace Mage\Cms\Test\Constraint;

use Mage\Cms\Test\Page\Adminhtml\CmsPageIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert that success delete message is displayed after remove Cms page.
 */
class AssertCmsPageDeleteMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Success CMS page delete message.
     */
    const SUCCESS_DELETE_MESSAGE = 'The page has been deleted.';

    /**
     * Assert that success delete message is displayed after remove Cms page.
     *
     * @param CmsPageIndex $cmsIndex
     * @return void
     */
    public function processAssert(CmsPageIndex $cmsIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_DELETE_MESSAGE,
            $cmsIndex->getMessagesBlock()->getSuccessMessages()
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Cms page success delete message is present.';
    }
}
