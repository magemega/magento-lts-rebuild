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

namespace Mage\GiftMessage\Test\TestCase;

use Magento\Mtf\TestCase\Scenario;

/**
 * Preconditions:
 * 1. Enable Gift Messages (Order/Items level).
 * 2. Create Product according dataset.
 *
 * Steps:
 * 1. Login as registered customer.
 * 2. Add product to Cart and start checkout.
 * 3. On Shipping Method section Click "Add gift option".
 * 4. Complete Checkout steps.
 * 5. Perform all asserts.
 *
 * @group Gift_Messages_(CS)
 * @ZephyrId MPERF-6942
 */
class CheckoutWithGiftMessagesTest extends Scenario
{
    /**
     * Runs one page checkout test with gift message.
     *
     * @return void
     */
    public function test()
    {
        $this->executeScenario();
    }

    /**
     * Disable enabled config after test.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->objectManager->create(
            'Mage\Core\Test\TestStep\SetupConfigurationStep',
            ['configData' => $this->currentVariation['arguments']['configData'], 'rollback' => true]
        )->run();
    }
}
