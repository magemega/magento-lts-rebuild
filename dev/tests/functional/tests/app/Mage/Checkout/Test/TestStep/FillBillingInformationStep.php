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

namespace Mage\Checkout\Test\TestStep;

use Mage\Checkout\Test\Page\CheckoutOnepage;
use Mage\Customer\Test\Fixture\Address;
use Mage\Customer\Test\Fixture\Customer;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Fill billing information.
 */
class FillBillingInformationStep implements TestStepInterface
{
    /**
     * Onepage checkout page.
     *
     * @var CheckoutOnepage
     */
    protected $checkoutOnepage;

    /**
     * Address fixture.
     *
     * @var Address
     */
    protected $billingAddress;

    /**
     * Customer fixture.
     *
     * @var Customer
     */
    protected $customer;

    /**
     * @constructor
     * @param CheckoutOnepage $checkoutOnepage
     * @param Address $billingAddress
     * @param Customer $customer [optional]
     */
    public function __construct(CheckoutOnepage $checkoutOnepage, Address $billingAddress = null, Customer $customer = null)
    {
        $this->checkoutOnepage = $checkoutOnepage;
        $this->billingAddress = $billingAddress;
        $this->customer = $customer;
    }

    /**
     * Fill billing address.
     *
     * @return void
     */
    public function run()
    {
        $this->checkoutOnepage->getBillingBlock()->fillBilling($this->billingAddress, $this->customer);
        $this->checkoutOnepage->getBillingBlock()->clickContinue();
    }
}
