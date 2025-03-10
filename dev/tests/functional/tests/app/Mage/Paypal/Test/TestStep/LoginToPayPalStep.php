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
 * @copyright  Copyright (c) 2018-2020 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Mage\Paypal\Test\TestStep;

use Mage\Paypal\Test\Fixture\PaypalCustomer;
use Mage\Paypal\Test\Page\Paypal;
use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Mtf\Client\Browser;

/**
 * Login to Pay Pal step.
 */
class LoginToPayPalStep implements TestStepInterface
{
    /**
     * Pay Pal page.
     *
     * @var Paypal
     */
    protected $paypalPage;

    /**
     * Pay Pal customer fixture.
     *
     * @var PaypalCustomer
     */
    protected $customer;

    /**
     * Browser.
     *
     * @var Browser
     */
    protected $browser;

    /**
     * Loader selector.
     *
     * @var string
     */
    protected $loader = '#spinner .loader';

    /**
     * @constructor
     * @param Browser $browser
     * @param Paypal $paypalPage
     * @param PaypalCustomer $paypalCustomer
     */
    public function __construct(Browser $browser, Paypal $paypalPage, PaypalCustomer $paypalCustomer)
    {
        $this->browser = $browser;
        $this->paypalPage = $paypalPage;
        $this->customer = $paypalCustomer;
    }

    /**
     * Login to Pay Pal.
     *
     * @return void
     */
    public function run()
    {
        $reviewBlockIsPresent = false;
        $sleepingTime = 0;
        while (!$reviewBlockIsPresent and $sleepingTime <= 60)
        {
            sleep(1);
            $reviewBlockIsPresent = $this->paypalPage->getReviewBlock()->isVisible()
                || $this->paypalPage->getOldReviewBlock()->isVisible();
            $sleepingTime++;
        }
        /** Log out from previous session. */
        $reviewBlock = $this->paypalPage->getReviewBlock()->isVisible()
            ? $this->paypalPage->getReviewBlock()
            : $this->paypalPage->getOldReviewBlock();
        $reviewBlock->logOut();

        $reviewBlock->waitLoader();
        $payPalLoginBlock = $this->getActualBlock();
        $payPalLoginBlock->fill($this->customer);
        $payPalLoginBlock->submit();
        $payPalLoginBlock->switchOffPayPalFrame();
        $reviewBlock->waitLoader();
    }

    /**
     * Returns actual login block by selector
     *
     * @return \Mage\Paypal\Test\Block\NewLogin|\Mage\Paypal\Test\Block\Login|\Mage\Paypal\Test\Block\OldLogin
     */
    protected function getActualBlock()
    {
        if ($this->paypalPage->getNewLoginBlock()->isBlockActive()) {
            $returnBlock = $this->paypalPage->getNewLoginBlock();
        } elseif ($this->paypalPage->getLoginBlock()->isBlockActive()) {
            $returnBlock = $this->paypalPage->getLoginBlock();
        } else {
            $returnBlock = $this->paypalPage->getOldLoginBlock();
        }
        return $returnBlock;
    }
}
