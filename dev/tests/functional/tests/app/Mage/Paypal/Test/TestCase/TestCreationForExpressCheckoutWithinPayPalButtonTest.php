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

namespace Mage\Paypal\Test\TestCase;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Scenario;

/**
 * Preconditions:
 * 1. Create product.
 * 2. Apply configuration for test.
 *
 * Steps:
 * 1. Go to Frontend.
 * 2. Add products to the cart.
 * 3. Apply discount coupon or add gift card if necessary, click "Checkout with PayPal" button.
 * 4. Login to PayPal.
 * 5. Process checkout via PayPal.
 * 6. Perform asserts.
 *
 * @group One_Page_Checkout_(CS), PayPal_(CS)
 * @ZephyrId MPERF-6936
 */
class TestCreationForExpressCheckoutWithinPayPalButtonTest extends Scenario
{
    /* tags */
    const TEST_TYPE = '3rd_party_test';
    /* end tags */

    /**
     * Delete all tax rules before test run and prepare Pay Pal customer for test.
     *
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->objectManager->create('Mage\Tax\Test\TestStep\DeleteAllTaxRulesStep')->run();
        $paypalCustomer = $fixtureFactory->create('Mage\Paypal\Test\Fixture\PaypalCustomer', ['dataset' => 'default']);

        return ['paypalCustomer' => $paypalCustomer];
    }

    /**
     * Runs one page checkout test.
     *
     * @return void
     */
    public function test()
    {
        $this->executeScenario();
    }

    /**
     * Disable enabled config and delete all sales, tax and catalog rules after test.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->objectManager->create('\Mage\SalesRule\Test\TestStep\DeleteAllSalesRuleStep')->run();
        $this->objectManager->create('\Mage\CatalogRule\Test\TestStep\DeleteAllCatalogRulesStep')->run();
        $this->objectManager->create('\Mage\Tax\Test\TestStep\DeleteAllTaxRulesStep')->run();
        $this->objectManager->create(
            'Mage\Core\Test\TestStep\SetupConfigurationStep',
            ['configData' => $this->currentVariation['arguments']['configData'], 'rollback' => true]
        )->run();
    }
}
