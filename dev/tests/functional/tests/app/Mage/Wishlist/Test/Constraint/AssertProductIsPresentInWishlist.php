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
use Magento\Mtf\Fixture\InjectableFixture;

/**
 * Assert that product is present in default wishlist.
 */
class AssertProductIsPresentInWishlist extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Assert that product is present in default wishlist.
     *
     * @param CmsIndex $cmsIndex
     * @param WishlistIndex $wishlistIndex
     * @param InjectableFixture $product
     * @return void
     */
    public function processAssert(CmsIndex $cmsIndex, WishlistIndex $wishlistIndex, InjectableFixture $product)
    {
        $cmsIndex->getTopLinksBlock()->openAccount();
        $cmsIndex->getLinksBlock()->openLink("My Wishlist");

        \PHPUnit_Framework_Assert::assertTrue(
            $wishlistIndex->getItemsBlock()->getItemProductBlock($product)->isVisible(),
            $product->getName() . ' is not visible on wishlist page.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product is present in default wishlist.';
    }
}
