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

namespace Mage\Payment\Test\TestStep;

use Mage\Checkout\Test\Page\CheckoutOnepage;
use Mage\Payment\Test\Fixture\ValidationPassword;
use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Mtf\ObjectManager;

/**
 * Fill 3D secure credit card validation.
 */
class Fill3DSecureCreditCardValidationStep implements TestStepInterface
{
    /**
     * Onepage checkout page.
     *
     * @var CheckoutOnepage
     */
    protected $checkoutOnepage;

    /**
     * Cc fixture.
     *
     * @var ValidationPassword
     */
    protected $validationPassword;

    /**
     * @constructor
     * @param CheckoutOnepage $checkoutOnepage
     * @param ValidationPassword $validationPassword
     */
    public function __construct(CheckoutOnepage $checkoutOnepage, ValidationPassword $validationPassword)
    {
        $this->checkoutOnepage = $checkoutOnepage;
        $this->validationPassword = $validationPassword;
    }

    /**
     * Fill 3D secure credit card validation.
     *
     * @return void
     */
    public function run()
    {
        $centinelForm = $this->checkoutOnepage->getReviewBlock()->getCentinelForm();
        $centinelForm->fillPass($this->validationPassword);
        $centinelForm->submitCode();
    }
}
