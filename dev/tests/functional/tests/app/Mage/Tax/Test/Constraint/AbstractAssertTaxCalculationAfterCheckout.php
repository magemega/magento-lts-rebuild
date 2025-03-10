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

namespace Mage\Tax\Test\Constraint;

use Mage\Checkout\Test\Page\CheckoutOnepage;
use Mage\Checkout\Test\Page\CheckoutOnepageSuccess;
use Mage\Customer\Test\Fixture\Customer;
use Mage\Sales\Test\Page\OrderView;
use Magento\Mtf\Fixture\InjectableFixture;
use Magento\Mtf\System\Event\EventManagerInterface;
use Magento\Mtf\ObjectManager;

/**
 * Checks that prices excluding tax on order review and customer order pages are equal to specified in dataset.
 */
abstract class AbstractAssertTaxCalculationAfterCheckout extends AbstractAssertTax
{
    /**
     * Checkout page.
     *
     * @var CheckoutOnepage
     */
    protected $checkoutOnepage;

    /**
     * Checkout page.
     *
     * @var CheckoutOnepageSuccess
     */
    protected $checkoutOnepageSuccess;

    /**
     * Order view page.
     *
     * @var OrderView
     */
    protected $orderView;

    /**
     * Product type for review items block.
     *
     * @var
     */
    protected $productType;

    /**
     * Checkout's steps.
     *
     * @var array
     */
    protected $steps = [
        'proceed_to_checkout' => ['class' => 'ProceedToCheckout'],
        'billing_information' => ['class' => 'FillBillingInformation'],
        'shipping_method' => ['class' => 'FillShippingMethod', 'arguments' => ['shipping']],
        'payment_method' => ['class' => 'SelectPaymentMethod', 'arguments' => ['payment']],
        'place_order' => ['class' => 'PlaceOrder']
    ];

    /**
     * @constructor
     * @param ObjectManager $objectManager
     * @param EventManagerInterface $eventManager
     * @param CheckoutOnepage $checkoutOnepage
     * @param CheckoutOnepageSuccess $checkoutOnepageSuccess
     * @param OrderView $orderView
     */
    public function __construct(
        ObjectManager $objectManager,
        EventManagerInterface $eventManager,
        CheckoutOnepage $checkoutOnepage,
        CheckoutOnepageSuccess $checkoutOnepageSuccess,
        OrderView $orderView
    ) {
        parent::__construct($objectManager, $eventManager);
        $this->checkoutOnepage = $checkoutOnepage;
        $this->checkoutOnepageSuccess = $checkoutOnepageSuccess;
        $this->orderView = $orderView;
    }

    /**
     * Assert that prices on order review and customer order pages are equal to specified in dataset.
     *
     * @param InjectableFixture $product
     * @param array $prices
     * @param array $arguments [optional]
     * @return void
     */
    public function processAssert(InjectableFixture $product, array $prices, array $arguments = null)
    {
        $this->priceTypes['review_prices'] = 'Review';
        $prices = $this->prepareVerifyFields($prices);

        $this->checkoutStep('proceed_to_checkout');
        $this->checkoutStep('billing_information');
        if (isset($arguments['shipping'])) {
            $this->checkoutStep('shipping_method', $arguments);
        }
        $this->checkoutStep('payment_method', $arguments);

        $this->assertReviewPrices($product, $prices);

        $this->checkoutStep('place_order');
        $this->checkoutOnepageSuccess->getSuccessBlock()->openOrder();

        $this->assertOrderPrices($product, $prices);
    }

    /**
     * Assert order prices.
     *
     * @param InjectableFixture $product
     * @param array $prices
     * @return void
     */
    protected function assertReviewPrices(InjectableFixture $product, array $prices)
    {
        $error = $this->verifyData($prices, $this->getActualPrices($product, 'review_prices'));
        \PHPUnit_Framework_Assert::assertTrue(empty($error), $error);
    }

    /**
     * Run checkout step.
     *
     * @param string $type
     * @param array $arguments [optional]
     * @return array
     */
    protected function checkoutStep($type, array $arguments = null)
    {
        $className = "Mage\\Checkout\\Test\\TestStep\\{$this->steps[$type]['class']}Step";
        $arguments = isset($this->steps[$type]['arguments'])
            ? $this->prepareArgumentsForStep($this->steps[$type]['arguments'], $arguments)
            : [];

        return $this->objectManager->create($className, $arguments)->run();
    }

    /**
     * Prepare arguments for step.
     *
     * @param array $arguments
     * @param array $argumentsData
     * @return array
     */
    protected function prepareArgumentsForStep(array $arguments, array $argumentsData)
    {
        $result = [];
        foreach ($arguments as $argument) {
            $result[$argument] = $argumentsData[$argument];
        }

        return $result;
    }

    /**
     * Get review product prices.
     *
     * @param InjectableFixture $product
     * @return array
     */
    public function getReviewPrices(InjectableFixture $product)
    {
        $reviewBlock = $this->checkoutOnepage->getReviewBlock()->getItemsBlock($this->productType)
            ->getItemProductBlock($product);
        return $this->getTypePrices($reviewBlock);
    }

    /**
     * Get review totals.
     *
     * @return array
     */
    public function getReviewTotals()
    {
        $totalBlock = $this->checkoutOnepage->getReviewBlock()->getTotalBlock();
        return $this->getTypeBlockData($totalBlock);
    }
}
