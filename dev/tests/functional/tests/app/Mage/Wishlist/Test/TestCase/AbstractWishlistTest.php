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

namespace Mage\Wishlist\Test\TestCase;

use Mage\Catalog\Test\Page\Product\CatalogProductView;
use Mage\Cms\Test\Page\CmsIndex;
use Mage\Customer\Test\Fixture\Customer;
use Mage\Wishlist\Test\Page\WishlistIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\ObjectManager;
use Magento\Mtf\TestCase\Injectable;
use Magento\Mtf\Fixture\InjectableFixture;

/**
 * Abstract class for wish list tests.
 */
abstract class AbstractWishlistTest extends Injectable
{
    /**
     * Object Manager.
     *
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Cms index page.
     *
     * @var CmsIndex
     */
    protected $cmsIndex;

    /**
     * Product view page.
     *
     * @var CatalogProductView
     */
    protected $catalogProductView;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Wishlist index page.
     *
     * @var WishlistIndex
     */
    protected $wishlistIndex;

    /**
     * Injection data.
     *
     * @param CmsIndex $cmsIndex
     * @param CatalogProductView $catalogProductView
     * @param FixtureFactory $fixtureFactory
     * @param WishlistIndex $wishlistIndex
     * @param ObjectManager $objectManager
     * @param Customer $customer
     * @return array
     */
    public function __inject(
        CmsIndex $cmsIndex,
        CatalogProductView $catalogProductView,
        FixtureFactory $fixtureFactory,
        WishlistIndex $wishlistIndex,
        ObjectManager $objectManager,
        Customer $customer
    ) {
        $this->cmsIndex = $cmsIndex;
        $this->catalogProductView = $catalogProductView;
        $this->fixtureFactory = $fixtureFactory;
        $this->wishlistIndex = $wishlistIndex;
        $this->objectManager = $objectManager;
        $customer->persist();

        return ['customer' => $customer];
    }

    /**
     * Login customer.
     *
     * @param Customer $customer
     * @return void
     */
    protected function loginCustomer(Customer $customer)
    {
        $this->objectManager->create(
            'Mage\Customer\Test\TestStep\LoginCustomerOnFrontendStep',
            ['customer' => $customer]
        )->run();
    }

    /**
     * Create products.
     *
     * @param string $products
     * @return array
     */
    protected function createProducts($products)
    {
        return $this->objectManager->create(
            'Mage\Catalog\Test\TestStep\CreateProductsStep',
            ['products' => $products]
        )->run()['products'];
    }

    /**
     * Add products to wish list.
     *
     * @param InjectableFixture|InjectableFixture[] $products
     * @param bool $configure [optional]
     * @return void
     */
    protected function addToWishlist($products, $configure = false)
    {
        $products = is_array($products) ? $products : [$products];
        $this->objectManager->create(
            'Mage\Wishlist\Test\TestStep\AddProductsToWishlistStep',
            ['products' => $products, 'configure' => $configure]
        )->run();
    }
}
