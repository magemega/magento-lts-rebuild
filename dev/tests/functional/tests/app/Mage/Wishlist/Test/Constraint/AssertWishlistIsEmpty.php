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

namespace Mage\Wishlist\Test\Constraint;

use Mage\Cms\Test\Page\CmsIndex;
use Mage\Wishlist\Test\Page\WishlistIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert wish list is empty on 'My Account' page.
 */
class AssertWishlistIsEmpty extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Assert wish list is empty.
     *
     * @param CmsIndex $cmsIndex
     * @param WishlistIndex $wishlistIndex
     * @return void
     */
    public function processAssert(CmsIndex $cmsIndex, WishlistIndex $wishlistIndex)
    {
        $cmsIndex->getTopLinksBlock()->openAccountLink("My Wishlist");
        \PHPUnit_Framework_Assert::assertTrue(
            $wishlistIndex->getWishlistBlock()->isEmptyBlockVisible(),
            'Wish list is not empty.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Wish list is empty.';
    }
}
