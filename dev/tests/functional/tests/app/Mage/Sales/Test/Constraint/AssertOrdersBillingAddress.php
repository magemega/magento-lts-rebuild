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

namespace Mage\Sales\Test\Constraint;

use Mage\Sales\Test\Page\Adminhtml\SalesOrderView;
use Mage\Customer\Test\Fixture\Address;
use Mage\Sales\Test\Page\Adminhtml\SalesOrderIndex;

/**
 * Assert that orders were created with a right billing addresses.
 */
class AssertOrdersBillingAddress extends AbstractAssertOrdersAddress
{
    /* tags */
    const SEVERITY = 'high';
    /* end tags */

    /**
     * Assert that orders were created with a right billing addresses.
     *
     * @param SalesOrderIndex $salesOrder
     * @param SalesOrderView $salesOrderView
     * @param Address $billingAddress
     * @param array $ordersIds
     * @return void
     */
    public function processAssert(
        SalesOrderIndex $salesOrder,
        SalesOrderView $salesOrderView,
        Address $billingAddress,
        array $ordersIds
    ) {
        $addressData = $this->prepareAddressData($billingAddress);
        foreach ($ordersIds as $orderId) {
            $this->assert($salesOrder, $salesOrderView, $orderId, $addressData);
        }
    }

    /**
     * Get shipping address data from order form.
     *
     * @param SalesOrderView $salesOrderView
     * @return string
     */
    protected function getFormAddress(SalesOrderView $salesOrderView)
    {
        return $salesOrderView->getOrderForm()->getTabElement('information')->getBillingAddressBlock()->getAddress();
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Orders were created with a right billing addresses.';
    }
}
